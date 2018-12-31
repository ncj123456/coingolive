<?php

namespace Model;

class MoedaPrice extends \Base\DAO {

    protected $_table = "moeda_price";
    protected $symbol;
    protected $price_open;
    protected $price_high;
    protected $price_low;
    protected $price_close;
    protected $volume;
    protected $time_open;
    protected $time_close;
    
    
    function setSymbol($symbol) {
        $this->symbol = $symbol;
    }

    function setPriceOpen($price_open) {
        $this->price_open = $price_open;
    }

    function setPriceHigh($price_high) {
        $this->price_high = $price_high;
    }

    function setPriceLow($price_low) {
        $this->price_low = $price_low;
    }

    function setPriceClose($price_close) {
        $this->price_close = $price_close;
    }

    function setVolume($volume) {
        $this->volume = $volume;
    }

    function setTimeOpen($time_open) {
        $this->time_open = $time_open;
    }

    function setTimeClose($time_close) {
        $this->time_close = $time_close;
    }

    

    function findList() {
        $sql = "SELECT * FROM moeda_price";
        return $this->query($sql);
    }

}
