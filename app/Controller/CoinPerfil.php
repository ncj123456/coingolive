<?php

namespace Controller;

class CoinPerfil {

    function view($codigo) {
        $moedaFiat = isset($_COOKIE['moeda'])?$_COOKIE['moeda']:'USD';
        $compare = isset($_GET['compare']) ? $_GET['compare'] : 'bitcoin';
        $moeda = new \Model\Moeda();
        $dados = $moeda->findOne($codigo, $moedaFiat);
        
        if(!$dados){
            header('location: /');
            return;
        }

        $moedaCompare = (new \Model\Moeda())->findOne($compare, $moedaFiat);

        return [
        'dados' => $dados,
        'compare' => $moedaCompare
        ];
    }

}
