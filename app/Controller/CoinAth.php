<?php

namespace Controller;

class CoinAth {

    function data() {
        $moeda = $_COOKIE['moeda'];
        $listMoeda = \Base\I18n::getListMoeda();
        if (!isset($listMoeda[$moeda])) {
            $moeda = 'USD';
            setcookie('moeda', 'USD', time() + 2592000, '/');
        } 
        $name = isset($_GET['name']) ? $_GET['name'] : 'rank';
        $order = isset($_GET['order']) ? $_GET['order'] : 'asc';
        $busca = isset($_GET['s']) ? $_GET['s'] : '';
        $page = (int) (isset($_GET['p']) && $_GET['p']>=0 ? $_GET['p'] : 0);
        $limit = 100;
        $min_rank = (int) ((isset($_GET['min_rank']) && !empty($_GET['min_rank'])) ? $_GET['min_rank'] : 1);
        $max_rank = (int) (isset($_GET['max_rank']) ? $_GET['max_rank'] : 0);
        $filter_vol24h =  isset($_GET['vol24h']) ? $_GET['vol24h'] : '1M';
        
       $optsVol24 = [
           '10M'=>10000000,
           '1M'=>1000000,
           '100K'=>100000,
           '10K'=>10000,
           '1K'=>1000,
           'ALL'=>0
       ];
       
       $vol24h = $optsVol24[$filter_vol24h];
       
       if($moeda != 'USD'){
           $vol24h=0;
       }
       
        $table_head = $this->getTableHead();
        
        //check order column in array 
        if(!isset($table_head[$name])){
            $name = 'rank';
        }

      $max_rank_all = (new \Model\Moeda())->findMaxRank();
        if (empty($max_rank)) {
            $max_rank = $max_rank_all;
        }
        
        $id_user = \Base\Auth::getIdUser();
        $favorite = (isset($_GET['favorite']) && $_GET['favorite'] === "true") ? true : false;

        $data = (new \Model\Moeda())->findAth($id_user, $favorite, $moeda, $limit, $page, $name, $order, $busca, $min_rank, $max_rank,$vol24h);
        
        return [
            'data' => $data,
            'limit' => $limit,
            'table_head'=>$table_head,
            'column' => $name,
            'order' => $order,
            'page' => $page,
            'max_rank' => $max_rank,
            'min_rank' => $min_rank,
            'max_rank_all'=>$max_rank_all
        ];
    }
    
    private function getTableHead(){
                $table_head = [
                    'name' => _e('Criptomoeda'),
                    'rank' => _e('Rank'),
                    'price_moeda' => _e('Preço Atual'),
                    'high_price' => _e('Alta Histórica'),
                    'growth_high' => _e('% Para Alta'),
                    'high_date' => _e('Data Alta Histórica'),
                    'porc_high' => _e('% Queda preço desde ATH'),
                    'volume_24h_moeda' => _e('Volume 24h'),
                ];
          return $table_head;
    }
    
    function redirect(){
       header( "HTTP/1.1 301 Moved Permanently" );
       header("Location: ". siteUrl('/coin/ath-price/'));
    }

}
