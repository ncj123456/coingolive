<?php

namespace Controller;

class CronChange {

    function save() {

        $exchanges = [
            'binance',
            'poloniex',
            'bittrex',
            'cryptopia'
        ];

        $db = \Base\DB::connect();
        $db->beginTransaction();

        $moeda = new \Model\CoinChange($db);
        $moeda->deleteAll();

        foreach ($exchanges as $ex_name) {
            $name = ucfirst($ex_name);
            $methodPrice = "getAllPrice{$name}";
            $all = $this->$methodPrice();

            foreach ($all as $k => $a) {
                $methodSave = "save{$name}";
                if (!$this->$methodSave($db, $ex_name, $a, $k)) {
                    continue;
                }
            }
        }

        $db->commit();

        echo 'OK';
    }

    function getAllPriceBinance() {
        $json = file_get_contents('https://www.binance.com/api/v1/ticker/24hr');
        return json_decode($json, 1);
    }

    function getAllPricePoloniex() {
        $json = file_get_contents('https://poloniex.com/public?command=returnTicker');
        return json_decode($json, 1);
    }

    function getAllPriceBittrex() {
        $json = file_get_contents('https://bittrex.com/api/v1.1/public/getmarketsummaries');
        return json_decode($json, 1)['result'];
    }

    function getAllPriceCryptopia() {
        $json = file_get_contents('https://www.cryptopia.co.nz/api/GetMarkets');
        return json_decode($json, 1)['Data'];
    }

    function saveBinance($db, $exchange, $a) {

        $highPrice = $a['highPrice'];
        $lowPrice = $a['lowPrice'];
        $lastPrice = $a['lastPrice'];
        $market = substr($a['symbol'], -3);
        $symbol = substr($a['symbol'], 0, -3);

        if ($market == 'SDT') {
            $market = substr($a['symbol'], -4);
            $symbol = substr($a['symbol'], 0, -4);
        }

//        $symbol =;

        if ($lowPrice == 0) {
            return false;
        }

        $diffPrice = $highPrice - $lowPrice;
        $lastDiffPrice = $highPrice - $lastPrice;

        $dffPorc = number_format($diffPrice * 100 / $highPrice, 2);
        $lastDffPorc = number_format($lastDiffPrice * 100 / $diffPrice, 2);

        $moeda = new \Model\CoinChange($db);
        $moeda->setExchange($exchange);
        $moeda->setMarket($market);
        $moeda->setSymbol($symbol);
        $moeda->setPriceLast($lastPrice);
        $moeda->setPriceHigh($highPrice);
        $moeda->setPriceLow($lowPrice);
        $moeda->setDiffPorc($dffPorc);
        $moeda->setDiffPrice($diffPrice);
        $moeda->setLastDiffPorc($lastDffPorc);
        $moeda->setVolume($a['quoteVolume']);
        $moeda->setChange24h($a['priceChangePercent']);
        $moeda->insert();
        return true;
    }

    function savePoloniex($db, $exchange, $a, $symbol) {
        $highPrice = $a['high24hr'];
        $lowPrice = $a['low24hr'];

        $parSymbol = explode('_', $symbol);
        $lastPrice = $a['last'];
        $market = $parSymbol[0];
        $symbol = $parSymbol[1];

        if ($lowPrice == 0) {
            return false;
        }

        $diffPrice = $highPrice - $lowPrice;
        $lastDiffPrice = $highPrice - $lastPrice;

        $dffPorc = number_format($diffPrice * 100 / $highPrice, 2);
        $lastDffPorc = number_format($lastDiffPrice * 100 / $diffPrice, 2);

        $moeda = new \Model\CoinChange($db);
        $moeda->setExchange($exchange);
        $moeda->setMarket($market);
        $moeda->setSymbol($symbol);
        $moeda->setPriceLast($lastPrice);
        $moeda->setPriceHigh($highPrice);
        $moeda->setPriceLow($lowPrice);
        $moeda->setDiffPorc($dffPorc);
        $moeda->setDiffPrice($diffPrice);
        $moeda->setLastDiffPorc($lastDffPorc);
        $moeda->setVolume($a['baseVolume']);
        $moeda->setChange24h($a['percentChange'] * 100);
        $moeda->insert();
        return true;
    }

    function saveBittrex($db, $exchange, $a) {
        $highPrice = $a['High'];
        $lowPrice = $a['Low'];

        $parSymbol = explode('-', $a['MarketName']);
        $lastPrice = $a['Last'];
        $market = $parSymbol[0];
        $symbol = $parSymbol[1];

        if ($lowPrice == 0) {
            return false;
        }
        $percChange = ($lastPrice - $a['PrevDay']) * 100 / $a['PrevDay'];

        $diffPrice = $highPrice - $lowPrice;
        $lastDiffPrice = $highPrice - $lastPrice;

        $dffPorc = number_format($diffPrice * 100 / $highPrice, 2);

        if ($diffPrice) {
            $lastDffPorc = number_format(($lastDiffPrice * 100 / $diffPrice), 2);
        } else {
            $lastDffPorc = 0;
        }

        $moeda = new \Model\CoinChange($db);
        $moeda->setExchange($exchange);
        $moeda->setMarket($market);
        $moeda->setSymbol($symbol);
        $moeda->setPriceLast($lastPrice);
        $moeda->setPriceHigh($highPrice);
        $moeda->setPriceLow($lowPrice);
        $moeda->setDiffPorc($dffPorc);
        $moeda->setDiffPrice($diffPrice);
        $moeda->setLastDiffPorc($lastDffPorc);
        $moeda->setVolume($a['BaseVolume']);
        $moeda->setChange24h($percChange);
        $moeda->insert();
        return true;
    }

    function saveCryptopia($db, $exchange, $a) {
        $highPrice = $a['High'];
        $lowPrice = $a['Low'];

        $parSymbol = explode('/', $a['Label']);
        $lastPrice = $a['LastPrice'];
        $market = $parSymbol[1];
        $symbol = $parSymbol[0];
        $volume = $a['BaseVolume'];

        if ($lowPrice == 0) {
            return false;
        }

        $diffPrice = $highPrice - $lowPrice;
        $lastDiffPrice = $highPrice - $lastPrice;

        $dffPorc = number_format($diffPrice * 100 / $highPrice, 2);
        if ($diffPrice != 0) {
            $lastDffPorc = number_format($lastDiffPrice * 100 / $diffPrice, 2);
        } else {
            $lastDffPorc = $diffPrice;
        }

        $moeda = new \Model\CoinChange($db);
        $moeda->setExchange($exchange);
        $moeda->setMarket($market);
        $moeda->setSymbol($symbol);
        $moeda->setPriceLast($lastPrice);
        $moeda->setPriceHigh($highPrice);
        $moeda->setPriceLow($lowPrice);
        $moeda->setDiffPorc($dffPorc);
        $moeda->setDiffPrice($diffPrice);
        $moeda->setLastDiffPorc($lastDffPorc);
        $moeda->setVolume($volume);
        $moeda->setChange24h($a['Change']);
        $moeda->insert();
        return true;
    }

}
