<?php

namespace Controller;

class CoinHistoryChange {

    function view() {
        return [
            1
        ];
    }

    function data() {
        $moeda = $_COOKIE['moeda'];
        $listMoeda = ['USD', 'BTC'];
        if (!in_array($moeda,$listMoeda)) {
            $moeda = 'USD';
            setcookie('moeda', 'USD', time() + 2592000, '/');
        } 
        $name = isset($_GET['name']) ? $_GET['name'] : '';
        $order = isset($_GET['order']) ? $_GET['order'] : '';
        $busca = isset($_GET['busca']) ? $_GET['busca'] : '';
        $page = (int) (isset($_GET['page']) ? $_GET['page'] : 0);
        $limit = 100;
        $min_rank = (int) ((isset($_GET['min_rank']) && !empty($_GET['min_rank'])) ? $_GET['min_rank'] : 1);
        $max_rank = (int) (isset($_GET['max_rank']) ? $_GET['max_rank'] : 0);


        if (empty($max_rank)) {
            $max_rank = (new \Model\CoinHistoryChange())->findMaxRank();
        }

        $id_user = \Base\Auth::getIdUser();
        $favorite = (isset($_GET['favorite']) && $_GET['favorite'] === "true") ? true : false;

        $data = (new \Model\CoinHistoryChange())->findPorcChange($id_user, $favorite, $moeda, $limit, $page, $name, $order, $busca, $min_rank, $max_rank);
        return [
            'data' => $data,
            'limit' => $limit,
            'column' => $name,
            'order' => $order,
            'page' => $page,
            'max_rank' => $max_rank,
            'min_rank' => $min_rank
        ];
    }

}
