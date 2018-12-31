<?php

namespace Controller;

class Trade {
    
    function view(){
//        $rs = (new \Model\MoedaPrice())->findList();
//        
//        print_r($rs);
        
        return [1];
    }
    
    
    function data(){
                $rs = (new \Model\MoedaPrice())->findList();
                
                $data =[];
                
                foreach($rs as $k=>$v){
                    $data[$k][0]=$v['time_open'];
                    $data[$k][1]=$v['price_open'];
                    $data[$k][2]=$v['price_close'];
                    $data[$k][3]=$v['price_low'];
                    $data[$k][4]=$v['price_high'];
                }
                echo json_encode($data);
    }

    function insert() {
        $symbol = 'NANOBTC';
                
        $data = $this->getKline($symbol, '1h');

        foreach ($data as $d) {
            $open_time = $this->toDate($d[0]);
            $price_open = $d[1];
            $price_high = $d[2];
            $price_low = $d[3];
            $price_close = $d[4];
            $volume = $d[5];
            $close_time = $this->toDate($d[6]);
            
            
            $moeda = new \Model\MoedaPrice();
            $moeda->setTimeOpen($open_time);
            $moeda->setTimeClose($close_time);
            $moeda->setSymbol($symbol);
            $moeda->setPriceOpen($price_open);
            $moeda->setPriceHigh($price_high);
            $moeda->setPriceLow($price_low);
            $moeda->setPriceClose($price_close);
            $moeda->setVolume($volume);
            $moeda->insert();
            
        }
    }

    function getKline($symbol, $interval) {
        $url = 'https://api.binance.com/';
        $rs = json_decode(file_get_contents($url . 'api/v1/klines?symbol=' . $symbol . '&interval=' . $interval), 1);
        return $rs;
    }
    
    function toDate($time){
        return date("Y-m-d H:i:s", substr($time, 0, 10));
    }

}
