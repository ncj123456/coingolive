<?php

namespace Model;

class CoinHistoryRank extends \Base\DAO {

    protected $_table = "coin_history_rank";
    protected $id_externo;
    protected $high_rank;
    protected $high_date;
    protected $rank7d;
    protected $rank1m;
    protected $rank3m;
    protected $rank6m;
    protected $rank1y;
    protected $updated;

    function setIdExterno($id_externo) {
        $this->id_externo = $id_externo;
    }

    function setHighRank($high_rank) {
        $this->high_rank = $high_rank;
    }

    function setHighDate($high_date) {
        $this->high_date = $high_date;
    }

    function setRank7d($rank7d) {
        $this->rank7d = $rank7d;
    }

    function setRank1m($rank1m) {
        $this->rank1m = $rank1m;
    }

    function setRank3m($rank3m) {
        $this->rank3m = $rank3m;
    }

    function setRank6m($rank6m) {
        $this->rank6m = $rank6m;
    }

    function setRank1y($rank1y) {
        $this->rank1y = $rank1y;
    }

    function setUpdated($updated) {
        $this->updated = $updated;
    }
    
      function findPorcChange($id_user, $favorite, $limit = 100, $page = 0, $column = 'rank', $order = 'ASC', $busca = '', $min_rank = false, $max_rank = false) {
        $column = $this->antiInjection($column);
        $order = $this->antiInjection($order);
        $par = [
            'limit' => $limit,
            'page' => $page * $limit,
            'id_user' => $id_user
        ];

        $join_favorite = "LEFT";

        if ($favorite) {
            $join_favorite = "INNER";
        }

         $sql = "SELECT * FROM (
                            SELECT 
                            m.rank,
                            m.name,
                            m.symbol,
                            m.price_moeda,
                            m.moeda_char,
                            m.market_cap_moeda,
                            m.percent_change_24h as porc24h,
                            m.data_alteracao,
                            h.id_externo,                            
                            h.high_rank,
                            h.rank7d,
                            h.rank1m,
                            h.rank3m,
                            h.rank6m,
                            h.rank1y,
                            (h.high_rank - m.rank) as change_high_rank,
                            (h.rank7d - m.rank) as change_rank7d,
                            (h.rank1m - m.rank) as change_rank1m,
                            (h.rank3m - m.rank) as change_rank3m,
                            (h.rank6m - m.rank) as change_rank6m,
                            (h.rank1y - m.rank) as change_rank1y,
                            f.id_coin as favorite
                            FROM moeda m
                            INNER JOIN coin_history_rank h 
                            ON h.id_externo=m.codigo 
                              " . $join_favorite . " JOIN user_favorite_coin f 
                                              ON f.id_coin= m.codigo 
                                               AND f.id_user=:id_user                            
                            WHERE m.moeda ='USD'               
                        ) c ";

        $where = [];

        if (!empty($busca)) {
            $where[] = " (name LIKE(:busca) OR  symbol LIKE(:busca)) ";
            $par['busca'] = '%' . $busca . '%';
        }

        if ($min_rank) {
            $where[] = " rank >= :min_rank ";
            $par['min_rank'] = $min_rank;
        }

        if ($max_rank) {
            $where[] = " rank <= :max_rank ";
            $par['max_rank'] = $max_rank;
        }
        if (count($where) > 0) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        
        if(strtolower($order) ==='desc'){
            $numOrder = -99999999;
        }elseif(strtolower($order) ==='asc'){
            $numOrder = 99999999;
        }else{
            return false;
        }

        $sql .= " ORDER BY COALESCE( " . $column . ",".$numOrder." ) " . $order . " LIMIT :limit OFFSET :page";
        
//        echo $sql;
//        print_r($par);die;

        return $this->query($sql, $par);
    }

    function findRankChange() {
        $sql = "select 
                             v.id_externo,
		(
                                select min(a.rank) 
                                from coin_history_2 a
                                where a.id_externo=v.id_externo
                            ) as 'high_rank',
                            (
                                select a.rank 
                                from coin_history_2 a
                                where date=DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 YEAR),'%Y-%m-%d')
                                AND a.id_externo=v.id_externo
                            ) as '1y',
                            (
                                select b.rank
                                from coin_history_2 b
                                where date=DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -6 month),'%Y-%m-%d')
                                AND b.id_externo=v.id_externo
                            ) as '6m',
                            (
                                select c.rank  
                                from coin_history_2 c
                                where date=DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -3 month),'%Y-%m-%d')
                                AND c.id_externo=v.id_externo
                            ) as '3m',
                            (
                                select c.rank  
                                from coin_history_2 c
                                where date=DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 month),'%Y-%m-%d')
                                AND c.id_externo=v.id_externo
                            ) as '1m',
                            (
                                select d.rank 
                                from coin_history_2 d
                                where date=DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -7 day),'%Y-%m-%d')
                                AND d.id_externo=v.id_externo
                            ) as '7d',
                            (
                                select d.rank  
                                from coin_history_2 d
                                where date=DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 day),'%Y-%m-%d')
                                AND d.id_externo=v.id_externo
                            ) as '1d'
                            from (
                                SELECT DISTINCT id_externo
                                FROM coin_history_2

                            ) v  ";
        return $this->query($sql);
    }

}
