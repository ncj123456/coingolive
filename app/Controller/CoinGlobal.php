<?php

namespace Controller;

class CoinGlobal {

    function json() {
         $base = isset($_COOKIE['moeda'])?$_COOKIE['moeda']:'USD';
         $baseSymbol = \Base\I18n::getListMoeda()[$base];
        
         $base = strtolower($base);
        $data = (new \Model\CoinGlobal())->findData();     
        
        $rs = [];
        $rs['base'] = $base;
        $rs['base_symbol'] = $baseSymbol;
        $rs['coins'] = $data['active_cryptocurrencies'];
        $rs['total_market_cap'] = $data['total_market_cap'][$base];
         $rs['total_volume'] = $data['total_volume'][$base];
        $rs['market_cap_change_24h'] = $data['market_cap_change_percentage_24h_usd'];
        $rs['dominance'] = $data['market_cap_percentage'];
        
        echo json_encode($rs);
        
    }

}