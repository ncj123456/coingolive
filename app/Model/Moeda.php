<?php

namespace Model;

class Moeda extends \Base\DAO {

    protected $_table = "moeda";
    protected $codigo;
    protected $moeda;
    protected $name;
    protected $symbol;
    protected $rank;
    protected $available_supply;
    protected $total_supply;
    protected $max_supply;
    protected $price_moeda;
    protected $percent_change_24h;
    protected $volume_24h_moeda;
    protected $market_cap_moeda;
    protected $moeda_char;
    protected $percent_dominance;
    protected $price_available_supply;
    protected $percent_available_supply;
    protected $ath;
    protected $ath_date;
    protected $ath_change_percentage;
    protected $price_change_percentage_1h;
    protected $price_change_percentage_24h;
    protected $price_change_percentage_7d;
    protected $price_change_percentage_14d;
    protected $price_change_percentage_30d;
    protected $price_change_percentage_200d;
    protected $price_change_percentage_1y;

    function descTable() {
        $attr = [
            'symbol' => [
                'pk' => true,
                'type' => 'string',
                'size' => 255,
                'required' => true
            ],
            'codigo' => [
                'type' => 'string',
                'size' => 255,
                'required' => true
            ],
            'moeda' => [
                'type' => 'string',
                'size' => 3,
                'required' => true
            ],
            'moeda_char' => [
                'type' => 'string',
                'size' => 3,
                'required' => true
            ],
            'name' => [
                'type' => 'string',
                'size' => 255,
                'required' => true
            ],
            'rank' => [
                'type' => 'int',
                'size' => 11
            ],
            'available_supply' => [
                'type' => 'decimal',
                'size' => [20, 2],
            ],
            'total_supply' => [
                'type' => 'decimal',
                'size' => [20, 2],
            ],
            'max_supply' => [
                'type' => 'decimal',
                'size' => [20, 2],
            ],
            'price_moeda' => [
                'type' => 'decimal',
                'size' => [35, 10]
            ],
            'volume_24h_moeda' => [
                'type' => 'decimal',
                'size' => [20, 2]
            ],
            'market_cap_moeda' => [
                'type' => 'decimal',
                'size' => [20, 2]
            ],
            'percent_dominance' => [
                'type' => 'decimal',
                'size' => [20, 6]
            ], 'price_available_supply' => [
                'type' => 'decimal',
                'size' => [35, 10]
            ], 'percent_available_supply' => [
                'type' => 'decimal',
                'size' => [20, 2]
            ],
            'percent_change_24h' => [
                'type' => 'decimal',
                'size' => [20, 2]
            ]
        ];
        return $attr;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setMoeda($moeda) {
        $this->moeda = $moeda;
    }

    function setMoedaChar($moeda_char) {
        $this->moeda_char = $moeda_char;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setSymbol($symbol) {
        $this->symbol = $symbol;
    }

    function setRank($rank) {
        $this->rank = $rank;
    }

    function setAvailableSupply($available_supply) {
        $this->available_supply = $available_supply;
    }

    function setTotalSupply($total_supply) {
        $this->total_supply = $total_supply;
    }

    function setMaxSupply($max_supply) {
        $this->max_supply = $max_supply;
    }

    function setPriceMoeda($price_moeda) {
        $this->price_moeda = $price_moeda;
    }

    function setVolume24hMoeda($volume_24h_moeda) {
        $this->volume_24h_moeda = $volume_24h_moeda;
    }

    function setMarketCapMoeda($market_cap_moeda) {
        $this->market_cap_moeda = $market_cap_moeda;
    }

    function setPercentDominance($percent_dominance) {
        $this->percent_dominance = $percent_dominance;
    }

    function setPriceAvailableSupply($price_available_supply) {
        $this->price_available_supply = $price_available_supply;
    }

    function setPercentAvailableSupply($percent_available_supply) {
        $this->percent_available_supply = $percent_available_supply;
    }

    function setPercentChange24h($percent_change_24h) {
        $this->percent_change_24h = $percent_change_24h;
    }

    function setAth($ath) {
        $this->ath = $ath;
    }

    function setAthDate($ath_date) {
        $this->ath_date = $ath_date;
    }

    function setAthChangePercentage($ath_change_percentage) {
        $this->ath_change_percentage = $ath_change_percentage;
    }

    function setPriceChangePercentage1h($price_change_percentage_1h) {
        $this->price_change_percentage_1h = $price_change_percentage_1h;
    }

    function setPriceChangePercentage24h($price_change_percentage_24h) {
        $this->price_change_percentage_24h = $price_change_percentage_24h;
    }

    function setPriceChangePercentage7d($price_change_percentage_7d) {
        $this->price_change_percentage_7d = $price_change_percentage_7d;
    }

    function setPriceChangePercentage14d($price_change_percentage_14d) {
        $this->price_change_percentage_14d = $price_change_percentage_14d;
    }

    function setPriceChangePercentage30d($price_change_percentage_30d) {
        $this->price_change_percentage_30d = $price_change_percentage_30d;
    }

    function setPriceChangePercentage200d($price_change_percentage_200d) {
        $this->price_change_percentage_200d = $price_change_percentage_200d;
    }

    function setPriceChangePercentage1y($price_change_percentage_1y) {
        $this->price_change_percentage_1y = $price_change_percentage_1y;
    }

    function findList($id_user, $favorite = false, $moeda, $search = null, $column = 'rank', $order = 'asc', $limit = null, $offset = 0, $min_rank = false, $max_rank = false) {

        $par = [];
        $join_favorite = "LEFT";

        if ($favorite) {
            $join_favorite = "INNER";
        }

        $sql = "SELECT 
                        m.codigo,
                        m.rank,
                        m.name,
                        UPPER(m.symbol) symbol,
                        m.moeda,
                        m.moeda_char,
                        m.price_moeda,                        
                        m.available_supply,
                        m.max_supply,
                        m.volume_24h_moeda,
                        m.market_cap_moeda,
                        m.percent_dominance,
                        m.data_alteracao,
                        f.id_coin as favorite
                  FROM moeda m
                  " . $join_favorite . " JOIN user_favorite_coin f 
                                              ON f.id_coin= m.codigo 
                                               AND f.id_user=:id_user";
        $sql .= ' WHERE m.moeda=:moeda ';
        $par['moeda'] = $moeda;
        $par['id_user'] = $id_user;
        //busca
        if (!empty($search)) {
            $par['search'] = '%' . $search . '%';
            $par['symbol'] = $search;
            $sql .= ' AND (m.symbol = :symbol OR m.name LIKE (:search)) ';
        }
        if ($min_rank) {
            $sql .= " AND m.rank >= :min_rank ";
            $par['min_rank'] = $min_rank;
        }

        if ($max_rank) {
            $sql .= " AND m.rank <= :max_rank ";
            $par['max_rank'] = $max_rank;
        }
        //ordenacao

        $attr = get_object_vars($this);

        //verifica se existe a coluna para ordenar
        if (array_key_exists($column, $attr)) {
            if ($order == 'desc' || $order == 'asc') {
                $sql .= ' ORDER BY ' . $column . '  ' . $order;
            }
        } else {
            $sql .= ' ORDER BY m.rank ASC';
        }
//              $par['order'] =  'rank';
        //paginacao
        if (!empty($limit)) {
            $par['limit'] = $limit;
            $par['offset'] = $offset;
            $sql .= ' LIMIT :limit OFFSET :offset';
        }

        return $this->query($sql, $par);
    }

    function findListAll($moeda = 'USD') {
        $sql = "SELECT 
                        codigo
                  FROM moeda 
                 WHERE moeda=:moeda";

        $par = [];
        $par['moeda'] = $moeda;
        return $this->query($sql, $par);
    }

    function findOne($codigo, $moeda) {
        $sql = "SELECT 
                        codigo,
                        rank,
                        name,
                        UPPER(symbol) as symbol,
                        moeda,
                        moeda_char,
                        price_moeda,                        
                        available_supply,
                        max_supply,
                        volume_24h_moeda,
                        market_cap_moeda,
                        percent_dominance,
                         ath_change_percentage,
                         price_change_percentage_1h,
                         price_change_percentage_24h,
                         price_change_percentage_7d,
                         price_change_percentage_14d,
                          price_change_percentage_30d,
                         price_change_percentage_200d,
                          price_change_percentage_1y,
                             
                            ath as high_price,
                            DATE_FORMAT(ath_date,'%Y-%m-%d') as high_date,
                            truncate(((ath - price_moeda)*100/price_moeda),2)as growth_high,
                             truncate(((price_moeda - ath)*100/ath),2)as porc_high,
                        data_alteracao
                  FROM moeda ";
        $sql .= ' WHERE moeda=:moeda
                        AND codigo=:codigo ';
        $par = [];
        $par['moeda'] = $moeda;
        $par['codigo'] = $codigo;
        $rs = $this->query($sql, $par);
        if (isset($rs[0])) {
            return $rs[0];
        } else {
            return false;
        }
    }

    function findAllName() {
        $sql = "SELECT 
                        CASE 
                            WHEN rank > 0 THEN rank
                            ELSE 9999999
                         END as rank,
                        codigo,
                        name,
                        UPPER(symbol) as symbol
                  FROM moeda ";
        $sql .= " WHERE moeda='USD'
                        ORDER BY COALESCE(rank,99999999) ASC";
        return $this->query($sql);
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
                            m.codigo as id_externo,
                            m.ath as high_price,
                            m.rank,
                            m.name,
                            UPPER(m.symbol) as symbol,
                            m.price_moeda,
                             m.moeda_char,
                            m.volume_24h_moeda,
                            m.data_alteracao,
                            DATE_FORMAT(m.ath_date,'%Y-%m-%d') as high_date,
                            ((m.ath-m.price_moeda)*100/m.price_moeda) as growth_high,
                             ((m.price_moeda - m.ath)*100/m.ath) as porc_high,
                              f.id_coin as favorite

                            FROM moeda m
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
            $order='asc';
             $numOrder = -99999999;
        }

        $sql .= " ORDER BY COALESCE( " . $column . "," . $numOrder . " )  " . $order . " LIMIT :limit OFFSET :page";

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
                             m.codigo as id_externo,
                            m.ath as high_price,
                            DATE_FORMAT(m.ath_date,'%Y-%m-%d') as high_date,
                            m.rank,
                            m.name,
                              UPPER(m.symbol) as symbol,
                            m.price_moeda,
                            m.moeda_char,
                            m.market_cap_moeda,
                            m.volume_24h_moeda,
                            m.percent_change_24h as porc24h,
                            m.data_alteracao,
                            m.ath_change_percentage,
                            m.price_change_percentage_1h,
                            m.price_change_percentage_24h,
                            m.price_change_percentage_7d,
                            m.price_change_percentage_14d,
                            m.price_change_percentage_30d,
                            m.price_change_percentage_200d,
                             m.price_change_percentage_1y,
                             f.id_coin as favorite

                            FROM moeda m
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

        $sql .= " ORDER BY COALESCE( " . $column . "," . $numOrder . " )  " . $order . " LIMIT :limit OFFSET :page";

        return $this->query($sql, $par);
    }

    function findMaxRank() {
        $sql = "SELECT max(rank) as max_rank FROM moeda";
        return $this->query($sql)[0]['max_rank'];
    }
    
       function findMaxVolume24h($moeda) {
        $sql =  "SELECT max(volume_24h_moeda) as volume_24h_moeda "
                . "FROM moeda "
                . "WHERE moeda =:moeda ";
          $par = ['moeda'=>$moeda];
        return $this->query($sql,$par)[0]['volume_24h_moeda'];
    }
    
    function findRankByMarketCap($marketCap,$baseCoin){
              $sql = "SELECT rank  FROM moeda 
                            WHERE market_cap_moeda <= :market_cap 
                            AND moeda=:baseCoin
                           ORDER BY market_cap_moeda DESC LIMIT 1";
              $par = [
                  'market_cap'=>$marketCap,
                  'baseCoin'=>$baseCoin
                    ];
              
        return $this->query($sql,$par)[0]['rank'];
    }

}
