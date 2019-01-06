<?php

namespace Controller;

class CronCoin
{

    function getGlobalMarket($moeda)
    {
        $url = "https://api.coingecko.com/api/v3/global";
        $json = file_get_contents($url);
        $data = json_decode($json, 1);

        return $data['data']['total_market_cap'][$moeda];
    }

    function insert()
    {


        $db = \Base\DB::connect();
        $db->beginTransaction();

        try {
            $this->deleteAll($db);

            $listMoedas = \Base\I18n::getListMoeda();


            foreach ($listMoedas as $moeda => $char) {

                $moedaLower = strtolower($moeda);

                $marketGlobal_dinamico = $this->getGlobalMarket($moedaLower);

                $url = "https://api.coingecko.com/api/v3/coins/markets?vs_currency=" . $moedaLower . "&per_page=10000";
                $json = file_get_contents($url);
                $data = json_decode($json, 1);

                foreach ($data as $d) {

                    //calcula o percentual de dominancia
                    $moeda_market_cap_dinamico = (float)$d['market_cap'];
                    $dominance = $moeda_market_cap_dinamico * 100 / $marketGlobal_dinamico;

                    $model = new \Model\Moeda($db);
                    $model->setCodigo($d['id']);
                    $model->setMoeda($moeda);
                    $model->setMoedaChar($char);
                    $model->setRank($d['market_cap_rank']);
                    $model->setName($d['name']);
                    $model->setSymbol($d['symbol']);
                    $model->setPriceMoeda((float)$d['current_price']);
                    $model->setVolume24hMoeda($d['market_cap_change_24h']);
                    $model->setAvailableSupply($d['circulating_supply']);
                    $model->setTotalSupply($d['circulating_supply']);
                    $model->setMaxSupply($d['total_supply']);
                    $model->setMarketCapMoeda($d['market_cap']);
                    $model->setPercentDominance($dominance);
                    $model->setPercentChange24h($d['price_change_percentage_24h']);
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

    function deleteAll($db)
    {
        $model = new \Model\Moeda($db);
        $model->deleteAll();
    }

    function saveImage()
    {
        $idCoin = $this->getIdCoin();

        $data = (new \Model\Moeda())->findList('USD');
        foreach ($data as $d) {
            $fileName = ROOT . '/public/assets/img/coin/' . $d['codigo'] . '.png';

            if (!file_exists($fileName) || filesize($fileName) < 10) {
                echo $d['codigo'] . "\n";
                $image = file_get_contents('https://s2.coinmarketcap.com/static/img/coins/32x32/' . $idCoin[$d['codigo']] . '.png');
                file_put_contents(ROOT . '/public/assets/img/coin/' . $d['codigo'] . '.png', $image);
            }
        }
    }

    function getIdCoin()
    {
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

    function listAll()
    {
        $data = (new \Model\Moeda())->findAllName();

        $retorno = [];

        foreach ($data as $d) {
            $retorno[$d['codigo']] = $d['name'] . '  (' . $d['symbol'] . ')';
        }

        return json_encode($retorno);
    }

}
