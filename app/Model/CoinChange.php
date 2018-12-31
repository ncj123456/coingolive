<?php

namespace Model;

class CoinChange extends \Base\DAO {

    protected $_table = "coin_change";
    protected $exchange;
    protected $market;
    protected $symbol;
    protected $price_last;
    protected $price_high;
    protected $price_low;
    protected $diff_porc;
    protected $diff_price;
    protected $last_diff_porc;
    protected $volume;
    protected $change24h;
    protected $updated;

    function setExchange($exchange) {
        $this->exchange = $exchange;
    }

    function setMarket($market) {
        $this->market = $market;
    }

    function setSymbol($symbol) {
        $this->symbol = $symbol;
    }

    function setPriceLast($price_last) {
        $this->price_last = $price_last;
    }

    function setPriceHigh($price_high) {
        $this->price_high = $price_high;
    }

    function setPriceLow($price_low) {
        $this->price_low = $price_low;
    }

    function setDiffPorc($diff_porc) {
        $this->diff_porc = $diff_porc;
    }

    function setDiffPrice($diff_price) {
        $this->diff_price = $diff_price;
    }

    function setLastDiffPorc($last_diff_porc) {
        $this->last_diff_porc = $last_diff_porc;
    }

    function setVolume($volume) {
        $this->volume = $volume;
    }

    function setChange24h($change24h) {
        $this->change24h = $change24h;
    }

    function setUpdated($updated) {
        $this->updated = $updated;
    }

    function findAllExchange() {
        $sql = "SELECT exchange FROM coin_change GROUP BY exchange";
        return $this->query($sql);
    }

    function findAllMarket($exchange) {
        $sql = "SELECT market FROM coin_change WHERE exchange=:exchange GROUP BY market";
        $par=[  
               'exchange'=>$exchange
        ];
        return $this->query($sql,$par);
    }

}
