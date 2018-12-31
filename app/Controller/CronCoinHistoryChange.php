<?php

namespace Controller;

class CronCoinHistoryChange {

    function insert() {

        $db = \Base\DB::connect();
        $db->beginTransaction();
        //deleta todos
        $history = new \Model\CoinHistoryChange($db);
        $history->deleteAll();

        $moedas = ['usd', 'btc'];

        foreach ($moedas as $moeda_base) {
            $change = (new \Model\CoinHistory($db))->findPriceChange($moeda_base);
            $ath = (new \Model\CoinHistory($db))->findAth($moeda_base);
            
            foreach ($change as $d) {
                
                $lineAth = $ath[$d['id_externo']];
                $high_price= $lineAth['high_price'];
                $athDate = (new \Model\CoinHistory($db))->findAthDate($moeda_base,$d['id_externo'],$high_price);

                $history = new \Model\CoinHistoryChange($db);
                $history->setIdExterno($d['id_externo']);
                $history->setHighPrice($high_price);
                $history->setHighDate($athDate);
                $history->setPrice7d($d['7d']);
                $history->setPrice1m($d['1m']);
                $history->setPrice3m($d['3m']);
                $history->setPrice6m($d['6m']);
                $history->setPrice1y($d['1y']);
                $history->setMoedaBase(strtoupper($moeda_base));

                $history->insert();

                echo $d['id_externo'] . "\n";
            }
        }

        $db->commit();
    }

}

