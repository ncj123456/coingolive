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
                        m.symbol,
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
                  ".$join_favorite." JOIN user_favorite_coin f 
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
                        symbol,
                        moeda,
                        moeda_char,
                        price_moeda,                        
                        available_supply,
                        max_supply,
                        volume_24h_moeda,
                        market_cap_moeda,
                        percent_dominance,
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
                        codigo,
                        name,
                        symbol
                  FROM moeda ";
        $sql .= " WHERE moeda='USD'
                        ORDER BY rank ASC";
        return $this->query($sql);
    }

}
