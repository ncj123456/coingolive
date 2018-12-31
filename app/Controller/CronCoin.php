<?php

namespace Controller;

class CronCoin {

    function getBtc($moeda) {
        $url = "https://api.coinmarketcap.com/v1/ticker/bitcoin/?convert=" . $moeda;
        $json = file_get_contents($url);
        $data = json_decode($json, 1);
        return $data[0];
    }

    function getGlobalMarket() {
        $url = "https://api.coinmarketcap.com/v1/global/";
        $json = file_get_contents($url);
        $data = json_decode($json, 1);
        return $data['total_market_cap_usd'];
    }

    function insert() {

        $marketGlobal = $this->getGlobalMarket();

        $db = \Base\DB::connect();
        $db->beginTransaction();

        try {
            $this->deleteAll($db);

            $listMoedas = \Base\I18n::getListMoeda();

            foreach ($listMoedas as $moeda => $char) {

                $moedaLower = strtolower($moeda);

                $url = "https://api.coinmarketcap.com/v1/ticker/?convert=" . $moeda . "&limit=10000";
                $json = file_get_contents($url);
                $data = json_decode($json, 1);

                $btc = $this->getBtc($moeda);

                $market_cap = (float) $btc['market_cap_' . $moedaLower];


                foreach ($data as $d) {

                    $price_moeda = (float) $d['price_' . $moedaLower];

                    //calcula o preco maximo
                    $max_supply = (float) $d['max_supply'];

                    if (!empty($max_supply)) {
                        $price_max_supply = $market_cap / $max_supply;

                        //calcula a porcentagem de  crescimento
                        $percent_max_supply = (($price_max_supply / $price_moeda) * 100) - 100;
                    } else {
                        $price_max_supply = 0;
                        $percent_max_supply = 0;
                    }


                    //calcula o preco maximo do total distribuido            
                    $total_supply = (float) $d['total_supply'];

                    if (!empty($total_supply)) {
                        $price_total_supply = $market_cap / $total_supply;

                        //calcula a porcentagem de  crescimento
                        if ($price_moeda > 0) {
                            $percent_total_supply = (($price_total_supply / $price_moeda) * 100) - 100;
                        } else {
                            $price_moeda = 0;
                        }
                    } else {
                        $price_total_supply = 0;
                        $percent_total_supply = 0;
                    }

                    //calcula o preco maximo do total disponivel para usar na ordenacao

                    $available_supply = (float) $d['available_supply'];

                    if (!empty($available_supply)) {
                        $price_available_supply = $market_cap / $available_supply;

                        //calcula a porcentagem de  crescimento
                        $percent_available_supply = (($price_available_supply / $price_moeda) * 100 ) - 100;
                    } else {
                        $price_available_supply = 0;
                        $percent_available_supply = 0;
                    }

                    //calcula o percentual de dominancia

                    $moeda_market_cap_usd = (float) $d['market_cap_usd'];
                    $dominance = $moeda_market_cap_usd * 100 / $marketGlobal;

                    $model = new \Model\Moeda($db);
//            $model->hydrate($d);
                    $model->setCodigo($d['id']);
                    $model->setMoeda($moeda);
                    $model->setMoedaChar($char);
                    $model->setRank($d['rank']);
                    $model->setName($d['name']);
                    $model->setSymbol($d['symbol']);
                    $model->setPriceMoeda($price_moeda);
                    $model->setVolume24hMoeda($d['24h_volume_' . $moedaLower]);
                    $model->setAvailableSupply($d['available_supply']);
                    $model->setTotalSupply($d['total_supply']);
                    $model->setMaxSupply($d['max_supply']);
                    $model->setMarketCapMoeda($d['market_cap_' . $moedaLower]);
                    $model->setPercentDominance($dominance);
                    $model->setPriceAvailableSupply($price_available_supply);
                    $model->setPercentAvailableSupply($percent_available_supply);
                    $model->setPercentChange24h($d['percent_change_24h']);
                    $model->insert();

                    echo "inserted: " . $d['symbol'] . '-' . $moeda . "\n";
                }

                sleep(1);
            }
            $db->commit();


            $file_moedas = ROOT . '/public/assets/moedas.json';
            $allMoeda = $this->listAll();
            file_put_contents($file_moedas, $allMoeda);
        } catch (\PDOException $ex) {
            $db->rollBack();
            print_r($ex);
        }
    }

    function deleteAll($db) {
        $model = new \Model\Moeda($db);
        $model->deleteAll();
    }

    function saveImage() {
        $idCoin = $this->getIdCoin();
        
        $data = (new \Model\Moeda())->findList('USD');
        foreach ($data as $d) {
            $fileName = ROOT . '/public/assets/img/coin/' . $d['codigo'] . '.png';
            
            if (!file_exists($fileName) || filesize($fileName)<10) { 
                echo $d['codigo']."\n";
                $image = file_get_contents('https://s2.coinmarketcap.com/static/img/coins/32x32/' . $idCoin[$d['codigo']] . '.png');
                file_put_contents(ROOT . '/public/assets/img/coin/' . $d['codigo'] . '.png', $image);
            }
        }
    }

    function getIdCoin() {
        $max = 100000;
        $coin = [];

        for ($i = 0; $i <= $max; $i += 100) {
            $json = file_get_contents('https://api.coinmarketcap.com/v2/ticker/?limit=100&start=' . $i);
            $data = json_decode($json, 1)['data'];

            if (count($data) == 0) {
                break;
            }

            echo $i . "\n";

            foreach ($data as $d) {
                $coin[$d['website_slug']] = $d['id'];
            }
//            sleep(0.1);
        }
        return $coin;
    }

    function listAll() {
        $data = (new \Model\Moeda())->findAllName();

        $retorno = [];

        foreach ($data as $d) {
            $retorno[$d['codigo']] = $d['name'] . '  (' . $d['symbol'] . ')';
        }

        return json_encode($retorno);
    }

}
