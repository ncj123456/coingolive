<?php

namespace Controller;

class CoinMaxPrice {

    function data() {
        $moeda = $_COOKIE['moeda'];
        $listMoeda = \Base\I18n::getListMoeda();
        if (!isset($listMoeda[$moeda])) {
            $moeda = 'USD';
            setcookie('moeda', 'USD', time() + 2592000, '/');
        } 
        $compare = isset($_GET['compare']) ? $_GET['compare'] : 'bitcoin';
        $busca = isset($_GET['s']) ? $_GET['s'] : null;
        $p = (int) (isset($_GET['p']) && $_GET['p']>=0) ? $_GET['p'] : 0;
        $column = isset($_GET['name']) ? $_GET['name'] : 'rank';
        $order = isset($_GET['order']) ? $_GET['order'] : 'asc';
        $min_rank = (int) ((isset($_GET['min_rank']) && !empty($_GET['min_rank'])) ? $_GET['min_rank'] : 1);
        $max_rank = (int) (isset($_GET['max_rank']) ? $_GET['max_rank'] : 0);
        $limit = 100;
        $offset = $limit * $p;

        $id_user = \Base\Auth::getIdUser();
        $favorite = (isset($_GET['favorite']) && $_GET['favorite'] === "true") ? true : false;
        $data = (new \Model\Moeda())->findList($id_user, $favorite, $moeda, $busca, $column, $order, $limit, $offset, $min_rank, $max_rank);

        $moedaCompare = (new \Model\Moeda())->findOne($compare, $moeda);

         $max_rank_all = (new \Model\Moeda())->findMaxRank();
        if (empty($max_rank)) {
            $max_rank = $max_rank_all;
        }

        return [
            'data' => $data,
            'limit' => $limit,
            'p' => $p,
            'column' => $column,
            'order' => $order,
            'compare' => $moedaCompare,
            'moeda_char' => $moeda,
            'max_rank' => $max_rank,
            'min_rank' => $min_rank,
            'max_rank_all'=>$max_rank_all
        ];
    }

//    function listAll(){
//         $data = (new \Model\Moeda())->findAllName();
//         
//        $retorno = [];
//        
//        foreach ($data as $d){
//            $retorno[$d['codigo']]=$d['name'].'  ('.$d['symbol'].')';
//        }
//
//        echo json_encode($retorno);
//    }
}
