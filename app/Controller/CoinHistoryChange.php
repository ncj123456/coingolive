<?php

namespace Controller;

class CoinHistoryChange {

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

       $table_head = $this->getTableHead();
        
        //check order column in array 
        if(!isset($table_head[$name])){
            $name = 'rank';
        }


      $max_rank_all = (new \Model\Moeda())->findMaxRank();
        if (empty($max_rank)) {
            $max_rank = $max_rank_all;
        }
        
//         $max_vol24= (new \Model\Moeda())->findMaxVolume24h($moeda);

        $id_user = \Base\Auth::getIdUser();
        $favorite = (isset($_GET['favorite']) && $_GET['favorite'] === "true") ? true : false;

        $data = (new \Model\Moeda())->findPorcChange($id_user, $favorite, $moeda, $limit, $page, $name, $order, $busca, $min_rank, $max_rank);
        return [
            'data' => $data,
            'limit' => $limit,
            'table_head'=>$table_head,
            'column' => $name,
            'order' => $order,
            'page' => $page,
            'max_rank' => $max_rank,
            'min_rank' => $min_rank,
            'max_rank_all'=>$max_rank_all,
//            'max_vol24'=>$max_vol24
        ];
    }
    
    private function getTableHead(){
        
                $table_head = [
                    'name' => _e('Criptomoeda'),
                    'rank' => _e('Rank'),
                    'price_moeda' => _e('Preço'),
                    'volume_24h_moeda' => _e('Volume 24h'),
                    'price_change_percentage_1h' => '1 ' . _e('hora'),
                    'price_change_percentage_24h' => '24 ' . _e('horas'),
                    'price_change_percentage_7d' => '7 ' . _e('dias'),
                    'price_change_percentage_14d' => '14 ' . _e('dias'),
                    'price_change_percentage_30d' => '30 ' . _e('dias'),
                    'price_change_percentage_200d' => '200 ' . _e('dias'),
                    'price_change_percentage_1y' => '1 ' . _e('ano'),
//                    'market_cap_moeda' => _e('Cap. de Mercado'),
                    'ath_change_percentage' => _e('% Desde ATH'),
                ];
                return $table_head;
    }
    
        
    function redirect(){
       header( "HTTP/1.1 301 Moved Permanently" );
       header("Location: ". siteUrl('/coin/price-change-history/'));
    }

}
