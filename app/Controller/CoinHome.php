<?php

namespace Controller;

class CoinHome  {

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

        $data = (new \Model\Moeda())->findCoinHome($id_user, $favorite, $moeda, $limit, $page, $name, $order, $busca, $min_rank, $max_rank,$vol24h);
        
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
                    'rank' => _e('#'),
                    'name' => _e('Criptomoeda'),
                    'price_moeda' => _e('Preço'),
                    'market_cap_moeda' => _e('MarketCap'),
                    'price_change_percentage_1h' => _e('1h'),
                    'price_change_percentage_24h' => _e('24h'),
                    'price_change_percentage_7d' => _e('7d'),
                    '#1' => _e('Gráfico preco 7d'),
                    '#2' => _e('24h Vol. in 7d'),
                    'volume_24h_moeda' => _e('Vol. 24h'),
                     'available_supply' => _e('Circ. Supply'),
                ];
          return $table_head;
    }
    
    function redirect(){
       header( "HTTP/1.1 301 Moved Permanently" );
       header("Location: ". siteUrl('/coin/ath-price/'));
    }
    
    function last7days(){
          $rs = (new \Model\CoinHistory())->findLast7Days($_GET['codigo']);
          $json = [];
          foreach($rs as $r){
              if($r['price'] > 1){
                  $r['price'] = round($r['price'] ,2);
              }else{
                   $r['price'] = round($r['price'] ,8);
              }
              $json['price'][]=(float) $r['price'];
              $json['vol24h'][]=(float) round($r['vol24h'],0);
          }
          echo json_encode($json);
    }

}
