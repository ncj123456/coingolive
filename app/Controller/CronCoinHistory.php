<?php

namespace Controller;

class CronCoinHistory {

    protected $qtde = 2;

    function insert() {
        $coins = $this->coinList();
        $db = \Base\DB::connect();

        foreach ($coins as $d) {
            $dados = $this->getHistory($d['id']);

            echo $d['id'] . "\n";

            $dados = array_reverse($dados, true);

            $count = 0;
            $dateAnterior = '';

            foreach ($dados as $time => $val) {


                //verifica se chegou no limit
                if ($count == $this->qtde) {
                    break;
                }

                $dateLine = date("Y-m-d", $time / 1000);

                if ($dateLine == $dateAnterior) {
                    continue;
                }

                $date = date("Y-m-d h:i:s", $time / 1000);

//                echo $date . "\n";
//                       echo $d['id']. "\n";

                $date = date("Y-m-d h:i:s", $time / 1000);

                $history = new \Model\CoinHistory($db);
                $history->setIdExterno($d['id']);
                $history->setDate($date);
                $history->setPriceBtc($val['price_btc']);
                $history->setPriceUsd($val['price_usd']);
                $history->setMarketcapUsd($val['marketcap']);
                $history->setVolumeUsd($val['volume_usd']);
                $history->insert();

                $dateAnterior = $dateLine;

                sleep(0.5);
                $count++;
            }
        }
    }

    function coinList() {
        $json = file_get_contents("https://api.coinmarketcap.com/v1/ticker/?limit=0");
        $data = json_decode($json, 1);

        return $data;
    }

    function getHistory($id) {
        $json = file_get_contents("https://graphs2.coinmarketcap.com/currencies/" . $id);
        $data = json_decode($json, 1);

        $marketcap = $data['market_cap_by_available_supply'];
        $price_btc = $data['price_btc'];
        $price_usd = $data['price_usd'];
        $volume_usd = $data['volume_usd'];

        $retorno = [];

        foreach ($volume_usd as $v) {
            $retorno[$v[0]]['volume_usd'] = $v[1];
        }
        foreach ($price_btc as $b) {
            $retorno[$b[0]]['price_btc'] = $b[1];
        }
        foreach ($price_usd as $u) {
            $retorno[$u[0]]['price_usd'] = $u[1];
        }
        foreach ($marketcap as $m) {
            $retorno[$m[0]]['marketcap'] = $m[1];
        }
        return $retorno;
    }

}
