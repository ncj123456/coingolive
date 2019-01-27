<?php

namespace Model;

class CoinHistoryChange extends \Base\DAO {

    protected $_table = "coin_history_change";
    protected $id_externo;
    protected $moeda_base;
    protected $high_price;
    protected $high_date;
    protected $price7d;
    protected $price1m;
    protected $price3m;
    protected $price6m;
    protected $price1y;

    function setIdExterno($id_externo) {
        $this->id_externo = $id_externo;
    }

    function setPrice7d($price7d) {
        $this->price7d = $price7d;
    }

    function setPrice1m($price1m) {
        $this->price1m = $price1m;
    }

    function setPrice3m($price3m) {
        $this->price3m = $price3m;
    }

    function setPrice6m($price6m) {
        $this->price6m = $price6m;
    }

    function setPrice1y($price1y) {
        $this->price1y = $price1y;
    }

    function setHighPrice($high_price) {
        $this->high_price = $high_price;
    }

    function setHighDate($high_date) {
        $this->high_date = $high_date;
    }

    function setMoedaBase($moeda_base) {
        $this->moeda_base = $moeda_base;
    }

    function findAth($id_user, $favorite, $moeda, $limit = 100, $page = 0, $column = 'rank', $order = 'ASC', $busca = '', $min_rank = false, $max_rank = false) {

        $column = $this->antiInjection($column);
        $order = $this->antiInjection($order);
        $par = [
            'limit' => $limit,
            'page' => $page * $limit,
            'id_user' => $id_user,
            'moeda_base' => strtoupper($moeda)
        ];

        $join_favorite = "LEFT";

        if ($favorite) {
            $join_favorite = "INNER";
        }


        $sql = "SELECT * FROM (
                            SELECT 
                            h.id_externo,
                            h.high_price,
                            m.rank,
                            m.name,
                            m.symbol,
                            m.price_moeda,
                             m.moeda_char,
                            m.volume_24h_moeda,
                            m.data_alteracao,
                            DATE_FORMAT(h.high_date,'%Y-%m-%d') as high_date,
                            ((h.high_price-m.price_moeda)*100/m.price_moeda) as growth_high,
                             ((m.price_moeda - h.high_price)*100/h.high_price) as porc_high,
                              f.id_coin as favorite

                            FROM moeda m
                            INNER JOIN coin_history_change h 
                            ON h.id_externo=m.codigo AND h.moeda_base=:moeda_base
                              " . $join_favorite . " JOIN user_favorite_coin f 
                                              ON f.id_coin= m.codigo 
                                               AND f.id_user=:id_user
                           WHERE m.moeda=:moeda_base
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

        if (strtolower($order) === 'desc') {
            $numOrder = -99999999;
        } elseif (strtolower($order) === 'asc') {
            $numOrder = 99999999;
        } else {
            return false;
        }

        $sql .= " ORDER BY COALESCE( " . $column . ",".$numOrder." )  " . $order . " LIMIT :limit OFFSET :page";

        return $this->query($sql, $par);
    }

    function findPorcChange($id_user, $favorite, $moeda, $limit = 100, $page = 0, $column = 'rank', $order = 'ASC', $busca = '', $min_rank = false, $max_rank = false) {
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
                            h.id_externo,
                            h.high_price,
                            DATE_FORMAT(h.high_date,'%Y-%m-%d') as high_date,
                            m.rank,
                            m.name,
                            m.symbol,
                            m.price_moeda,
                            m.moeda_char,
                            m.market_cap_moeda,
                            m.percent_change_24h as porc24h,
                            m.data_alteracao,
                            h.price7d,
                            h.price1m,
                            h.price3m,
                            h.price6m,
                            h.price1y,
                            ((m.price_moeda - h.high_price)*100/h.high_price) as porc_high,
                            ((m.price_moeda - h.price7d)*100/h.price7d) as porc7d,
                            ((m.price_moeda - h.price1m)*100/h.price1m) as porc1m,
                            ((m.price_moeda - h.price3m)*100/h.price3m) as porc3m,
                            ((m.price_moeda - h.price6m)*100/h.price6m) as porc6m,
                            ((m.price_moeda - h.price1y)*100/h.price1y) as porc1y,
                              f.id_coin as favorite

                            FROM moeda m
                            INNER JOIN coin_history_change h 
                            ON h.id_externo=m.codigo AND h.moeda_base=:moeda
                              " . $join_favorite . " JOIN user_favorite_coin f 
                                              ON f.id_coin= m.codigo 
                                               AND f.id_user=:id_user                            
                            WHERE m.moeda =:moeda                   
                        ) c ";

        $where = [];

        $par['moeda'] = $moeda;

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
        
        if (strtolower($order) === 'desc') {
            $numOrder = -99999999;
        } elseif (strtolower($order) === 'asc') {
            $numOrder = 99999999;
        } else {
            return false;
        }

        $sql .= " ORDER BY COALESCE( " . $column . ",".$numOrder." )  " . $order . " LIMIT :limit OFFSET :page";

        return $this->query($sql, $par);
    }

    function findMaxRank() {
        $sql = "SELECT max(rank) as max_rank FROM moeda";
        return $this->query($sql)[0]['max_rank'];
    }

    function findChangePorcByCoin($coins) {

        foreach ($coins as $k => $c) {
            $coins[$k] = $this->antiInjection($c);
        }

        $sql = "SELECT * FROM (
                            SELECT 
                            h.id_externo,
                            h.high_price,
                            DATE_FORMAT(h.high_date,'%Y-%m-%d') as high_date,
                            m.rank,
                            m.name,
                            m.symbol,
                            m.price_moeda,
                            m.market_cap_moeda,
                            m.percent_change_24h as porc24h,
                            h.price7d,
                            h.price1m,
                            h.price3m,
                            h.price6m,
                            h.price1y,
                            ((m.price_moeda - h.high_price)*100/h.high_price) as porc_high,
                            ((m.price_moeda - h.price7d)*100/h.price7d) as porc7d,
                            ((m.price_moeda - h.price1m)*100/h.price1m) as porc1m,
                            ((m.price_moeda - h.price3m)*100/h.price3m) as porc3m,
                            ((m.price_moeda - h.price6m)*100/h.price6m) as porc6m,
                            ((m.price_moeda - h.price1y)*100/h.price1y) as porc1y

                            FROM moeda m
                            INNER JOIN coin_history_change h 
                            ON h.id_externo=m.codigo AND m.moeda='USD' AND h.moeda_base='USD'
                        ) c   WHERE id_externo in ('" . implode("','", $coins) . "') ";

        return $this->query($sql);
    }


}
