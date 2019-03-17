<?php

namespace Controller;

class CoinPerfil {

    function view($codigo, $baseMoeda) {
        $moedaFiat = isset($_COOKIE['moeda']) ? $_COOKIE['moeda'] : 'USD';
//        $compare = isset($_GET['compare']) ? $_GET['compare'] : 'bitcoin';
        $compare = 'bitcoin';


        if ($baseMoeda !== null && $baseMoeda !== false) {
            $baseMoeda = strtoupper($baseMoeda);

            $listMoedas = \Base\I18n::getListMoeda();
            if (!isset($listMoedas[$baseMoeda])) {
                echo '404';
                die;
            }

            setcookie('moeda', $baseMoeda, time() + 2592000, '/');
            $moedaFiat = $baseMoeda;
        }

        $moeda = new \Model\Moeda();
        $dados = $moeda->findOne($codigo, $moedaFiat);

        if (!$dados) {
            header('location: /');
            return;
        }

        $moedaCompare = (new \Model\Moeda())->findOne($compare, $moedaFiat);

        return [
            'dados' => $dados,
            'baseMoeda' => $baseMoeda,
            'compare' => $moedaCompare
        ];
    }

    function rankMarketCap() {
        $marketCap = $_GET['market_cap'];
        $baseCoin = isset($_COOKIE['moeda']) ? $_COOKIE['moeda'] : 'USD';
        $rank = (new \Model\Moeda())->findRankByMarketCap($marketCap, $baseCoin);

        echo json_encode(['rank' => $rank]);
    }
    
    function redirect($codigo, $baseMoeda) {
        $lang = \Base\I18n::getCurrentLang();
        $newUrl =  '/'.$lang.'/coins/'.$codigo.'/';
        
        if(!empty($baseMoeda)){
            $newUrl = '/'.$lang.'/coins/'.$codigo.'/'.$baseMoeda.'/';
        }
     
        header( "HTTP/1.1 301 Moved Permanently" );
        header("Location: ".$newUrl);
        
    }

}
