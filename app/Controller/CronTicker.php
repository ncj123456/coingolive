<?php

namespace Controller;

class CronTicker {

    protected $qtde = 2;

    function insert() {
        $coins = $this->coinList();
        $db = \Base\DB::connect();

        foreach ($coins as $d) {

            echo $d['id'] . "\n";
            
            $date = date("Y-m-d h:i:s", $d['last_updated'] );

            $history = new \Model\CoinHistory($db);
            $history->setIdExterno($d['id']);
            $history->setDate($date);
            $history->setPriceBtc($d['price_btc']);
            $history->setPriceUsd($d['price_usd']);
            $history->setMarketcapUsd($d['market_cap_usd']);
            $history->setVolumeUsd($d['24h_volume_usd']);
            $history->insert();
        }
    }

    function coinList() {
        $json = file_get_contents("https://api.coinmarketcap.com/v1/ticker/?limit=0");
        $data = json_decode($json, 1);

        return $data;
    }

}
