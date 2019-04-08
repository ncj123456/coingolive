<?php

namespace Controller;

class CronCoin {

    private function getGlobalData() {
        $url = "https://api.coingecko.com/api/v3/global";
        $json = file_get_contents($url);
        $data = json_decode($json, 1);

        return $data['data'];
    }

    function insert() {

        $pid = file_get_contents(__DIR__ . '/pid.txt');
        if (!empty($pid) && file_exists('/proc/' . $pid)) {
            echo 'already this process running pid ' . $pid . PHP_EOL;
            return false;
        }

        $myPid = getmypid();
        file_put_contents(__DIR__ . '/pid.txt', $myPid);


        $db = \Base\DB::connect();
        $db->query("SET session wait_timeout=28800");
        $db->query("SET session interactive_timeout=28800");

        try {

            $listMoedas = \Base\I18n::getListMoeda();
            $data7d = [];

            $globalData = $this->getGlobalData();
            $this->saveGlobalData($db, $globalData);

            $marketGlobalDinamicAll = $globalData['total_market_cap'];

            foreach ($listMoedas as $moeda => $char) {

                $moedaLower = strtolower($moeda);

                $marketGlobalDinamic = $marketGlobalDinamicAll[$moedaLower];

                $page = 1;
                $countResults = 1;

                while ($countResults > 0) {
                    $url = "https://api.coingecko.com/api/v3/coins/markets?order=gecko_desc&vs_currency=" . $moedaLower . "&price_change_percentage=1h,24h,7d,14d,30d,200d,1y&per_page=250&page=" . $page;
                    $json = file_get_contents($url);
                    $data = json_decode($json, 1);


                    $idsCoin = [];
                    foreach ($data as $c) {
                        $idsCoin[] = $c['id'];
                    }

                    //insere o historico
                    foreach ($data as $d) {
                        if ($moeda === 'USD') {
                            $coinHistory = new \Model\CoinHistory($db);
                            $coinHistory->setCodigo($d['id']);
                            $coinHistory->setPrice((float) $d['current_price']);
                            $coinHistory->setVol24h($d['total_volume']);
                            $coinHistory->setAvailableSupply($d['circulating_supply']);
                            $coinHistory->insert();
                        }
                    }

                    //executa apenas no usd
                    if ($moeda === 'USD') {
                        $data7d2 = $this->getLast7days($db, $idsCoin);
                        $data7d = array_merge($data7d, $data7d2);
                    }

                    foreach ($data as $d) {

                        $data7dJson = json_encode($data7d[$d['id']]);

                        //calcula o percentual de dominancia
                        $moeda_market_cap_dinamico = (float) $d['market_cap'];
                        $dominance = $moeda_market_cap_dinamico * 100 / $marketGlobalDinamic;

                        $athDate = explode('T', $d['ath_date'])[0];

                        //rewrite name xrp
                        if ($d['symbol'] == 'xrp') {
                            $d['name'] = 'Ripple';
                        }

                        $model = new \Model\Moeda($db);
                        $model->setCodigo($d['id']);
                        $model->setMoeda($moeda);
                        $model->setMoedaChar($char);
                        $model->setRank($d['market_cap_rank']);
                        $model->setName($d['name']);
                        $model->setSymbol($d['symbol']);
                        $model->setPriceMoeda((float) $d['current_price']);
                        $model->setVolume24hMoeda($d['total_volume']);
                        $model->setAvailableSupply($d['circulating_supply']);
                        $model->setTotalSupply($d['circulating_supply']);
                        $model->setMaxSupply($d['total_supply']);
                        $model->setMarketCapMoeda($d['market_cap']);
                        $model->setPercentDominance($dominance);
                        $model->setPercentChange24h($d['price_change_percentage_24h']);
                        $model->setAth($d['ath']);
                        $model->setAthDate($athDate);
                        $model->setAthChangePercentage($d['ath_change_percentage']);
                        $model->setPriceChangePercentage1h($d['price_change_percentage_1h_in_currency']);
                        $model->setPriceChangePercentage24h($d['price_change_percentage_24h_in_currency']);
                        $model->setPriceChangePercentage7d($d['price_change_percentage_7d_in_currency']);
                        $model->setPriceChangePercentage14d($d['price_change_percentage_14d_in_currency']);
                        $model->setPriceChangePercentage30d($d['price_change_percentage_30d_in_currency']);
                        $model->setPriceChangePercentage200d($d['price_change_percentage_200d_in_currency']);
                        $model->setPriceChangePercentage1y($d['price_change_percentage_1y_in_currency']);
                        $model->setData7d($data7dJson);
                        $model->insertOrUpdate();

                        $this->saveImage($d['image'], $d['id']);

                        echo "page " . $page . " inserted: " . $d['symbol'] . '-' . $moeda . "\n";
                    }

                    $countResults = count($data);
                    $page++;
                }
            }

            (new \Model\CoinHistory($db))->delete8Days();

            $countCoins = (new \Model\Moeda())->countCoins();
            if (empty($countCoins)) {
                echo "Error, no record was saved" . PHP_EOL;
                return false;
            }

            $file_moedas = ROOT . '/public/assets/moedas.json';
            $allMoeda = $this->listAll();
            file_put_contents($file_moedas, $allMoeda);
        } catch (\PDOException $ex) {
            print_r($ex);
        }
    }

    private function saveImage($url, $code) {

        //largue img
        $fileName = ROOT . '/public/assets/img/coin/' . $code . '.png';

        if (!file_exists($fileName) || filesize($fileName) < 10) {

            echo "image saved: " . $code . PHP_EOL;
            $image = file_get_contents($url);
            file_put_contents($fileName, $image);
        }

        //small img
        $fileName2 = ROOT . '/public/assets/img/coin/' . $code . '-small.png';

        if (!file_exists($fileName2) || filesize($fileName2) < 10) {

            $url2 = str_replace('large', 'small', $url);

            echo "image small saved: " . $code . PHP_EOL;
            $image2 = file_get_contents($url2);
            file_put_contents($fileName2, $image2);

            //if error save image large
            if (!file_exists($fileName2) || filesize($fileName2) < 10) {
                echo "======" . $code . "==== error small- replace large image" . PHP_EOL;
                file_put_contents($fileName2, $image);
            }
        }
    }

    function listAll() {
        $data = (new \Model\Moeda())->findAllName();

        $retorno = [];

        foreach ($data as $d) {
            $retorno[$d['rank'] . '|' . $d['codigo']] = $d['name'] . '  (' . $d['symbol'] . ')';
        }

        return json_encode($retorno);
    }

    private function saveGlobalData($db, $data) {
        $json = json_encode($data);

        $model = new \Model\CoinGlobal($db);
        $model->setId(1);
        $model->setDataJson($json);
        $model->insertOrUpdate();
    }

    private function getLast7days($db, $codigos) {
        $rs = (new \Model\CoinHistory($db))->findLast7Days($codigos);
        $json = [];
        foreach ($rs as $r) {
            if ($r['price'] > 1) {
                $r['price'] = round($r['price'], 2);
            } else {
                $r['price'] = round($r['price'], 8);
            }
            $json[$r['codigo']]['price'][] = (float) $r['price'];
            $json[$r['codigo']]['vol24h'][] = (float) round($r['vol24h'], 0);
        }
        return $json;
    }

}
