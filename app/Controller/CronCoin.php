<?php

namespace Controller;

class CronCoin {

    private function getGlobalData($moeda) {
        $url = "https://api.coingecko.com/api/v3/global";
        $json = file_get_contents($url);
        $data = json_decode($json, 1);

        return $data['data'];
    }

    function insert() {
        
        $pid = file_get_contents(__DIR__.'/pid.txt');
        if(!empty($pid) && file_exists('/proc/'.$pid)){
            echo 'already this process running pid '.$pid.PHP_EOL;
            return false;
        }
        
        $myPid = getmypid();
        file_put_contents(__DIR__.'/pid.txt',$myPid);


        $db = \Base\DB::connect();
        $db->beginTransaction();

        try {
            $this->deleteAll($db);

            $listMoedas = \Base\I18n::getListMoeda();
            
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

                    foreach ($data as $d) {

                        //calcula o percentual de dominancia
                        $moeda_market_cap_dinamico = (float) $d['market_cap'];
                        $dominance = $moeda_market_cap_dinamico * 100 / $marketGlobalDinamic;

                        $athDate = explode('T', $d['ath_date'])[0];
                        
                        //rewrite name xrp
                        if($d['symbol']=='xrp'){
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
                        $model->insert();

                        $this->saveImage($d['image'], $d['id']);

                        echo "page " . $page . " inserted: " . $d['symbol'] . '-' . $moeda . "\n";
                    }

                    $countResults = count($data);
                    $page++;
                }
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

    private function saveImage($url, $code) {

        $fileName = ROOT . '/public/assets/img/coin/' . $code . '.png';

        if (!file_exists($fileName) || filesize($fileName) < 10) {

            echo "image saved: " . $code . PHP_EOL;
            $image = file_get_contents($url);
            file_put_contents(ROOT . '/public/assets/img/coin/' . $code . '.png', $image);
        }
    }

    function listAll() {
        $data = (new \Model\Moeda())->findAllName();

        $retorno = [];

        foreach ($data as $d) {
            $retorno[$d['rank'].'|'.$d['codigo']] = $d['name'] . '  (' . $d['symbol'] . ')';
        }

        return json_encode($retorno);
    }
    
    private function saveGlobalData($db,$data){
        
        (new \Model\CoinGlobal($db))->deleteAll();
        
        $json = json_encode($data);
        
        $model = new \Model\CoinGlobal($db);
        $model->setDataJson($json);
        $model->insert();
    }

}
