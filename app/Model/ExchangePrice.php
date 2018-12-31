<?php

namespace Model;

class ExchangePrice extends \Base\DAO {

    protected $_table = "exchange_price";
    protected $id;
    protected $id_exchange;
    protected $id_exchange_coin;
    protected $price;
    protected $volume;
    protected $created;

    function setId($id) {
        $this->id = $id;
    }

    function setIdExchange($id_exchange) {
        $this->id_exchange = $id_exchange;
    }

    function setIdExchangeCoin($id_exchange_coin) {
        $this->id_exchange_coin = $id_exchange_coin;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setVolume($volume) {
        $this->volume = $volume;
    }

    function setCreated($created) {
        $this->created = $created;
    }

    function findLastPrice($moeda, $column, $order) {
        $cols = [
            'exchange',
            'last_price',
            'high_price',
            'low_price',
            'bid_price',
            'ask_price',
            'volume',
        ];
        $type = [
            'desc',
            'asc'
        ];
        $sql_order = '';
        if (in_array($column, $cols) && in_array($order, $type)) {
            $sql_order = " ORDER BY " . $column . " " . $order;
        }
        $sql = "SELECT 
                                    e.name as exchange,
                                    e.color,
                                    e.logo,
                                    g.moeda_base,
                                    p.last_price,
                                    p.high_price,
                                    p.low_price,
                                    p.bid_price,
                                    p.ask_price,                                    
                                    p.volume,
                                    p.created
                        FROM exchange_price p
                        INNER JOIN exchange e ON e.id=p.id_exchange
                        INNER JOIN exchange_coin c ON c.id=p.id_exchange_coin
                        INNER JOIN exchange_api g
                                ON g.id_exchange=p.id_exchange 
                                AND g.id_exchange_coin=p.id_exchange_coin
                        WHERE p.id IN (
                            SELECT MAX(s.id)
                            FROM exchange_price s
                            GROUP BY s.id_exchange,s.id_exchange_coin
                        ) 
                        AND e.status=1
                        AND  g.moeda_base=:moeda
                        " . $sql_order;
        $par = ['moeda' => $moeda];
        return $this->query($sql, $par);
    }

    function findHistoryPrice($moeda) {
        $sql = "SELECT 
                                    e.name as exchange,
                                    e.color,
                                    e.logo,
                                    p.last_price,
                                    p.volume,
                                    DATE_FORMAT(p.created,'%Y-%m-%d %H:%i') as created
                        FROM exchange_price p
                        INNER JOIN exchange e ON e.id=p.id_exchange
                        INNER JOIN exchange_coin c ON c.id=p.id_exchange_coin
                        INNER JOIN exchange_api g
                                ON g.id_exchange=p.id_exchange 
                                AND g.id_exchange_coin=p.id_exchange_coin
		INNER JOIN (
                            SELECT max(s.id) as id FROM  exchange_price s
                             WHERE s.created >= DATE_SUB(NOW(),INTERVAL 7 DAY)
                           GROUP BY s.id_exchange,s.id_exchange_coin, DATE_FORMAT(s.created,'%Y-%m-%d %H')
                        ) a   ON a.id=p.id
                        WHERE e.status=1 
                        AND g.moeda_base=:moeda
                        ORDER BY p.id desc";
        $par['moeda'] = $moeda;
        return $this->query($sql, $par);
    }

    function findPriceCalc() {
        $sql = "SELECT 
                            v.moeda_base,
                            (sum(v.calc_price)/sum(v.volume))as price_media,
                            max(v.high_price) as max_price,
                            min(v.low_price) as min_price
                    FROM (
                        SELECT 
                            (p.last_price*p.volume) as calc_price,
                             p.volume,
                             g.moeda_base,
                             p.high_price,
                             p.low_price
                        FROM exchange_price p
                        INNER JOIN exchange e ON e.id=p.id_exchange
                        INNER JOIN exchange_api g
                            ON g.id_exchange=p.id_exchange 
                            AND g.id_exchange_coin=p.id_exchange_coin
                        WHERE p.id IN (
                                            SELECT MAX(s.id)
                                            FROM exchange_price s
                                            GROUP BY s.id_exchange,s.id_exchange_coin
                                        )
                        AND g.status=1
                         AND e.status=1
                        AND  p.high_price > 0
                        AND  p.low_price > 0
                        AND  p.last_price > 0
                        GROUP BY p.id
                    ) as v
                    GROUP BY v.moeda_base";
        return $this->query($sql);
    }

    function findPriceCalcTime($time) {
        $period=[
            '24h'=>'24 HOUR',
            '7d'=>'5 DAY',
        ];
        if(!isset($time, $period)){
            return false;
        }
        $sql = "SELECT 
                            v.moeda_base,
                            (sum(v.calc_price)/sum(v.volume))as price_media
                    FROM (
                        SELECT 
                            (p.last_price*p.volume) as calc_price,
                             p.volume,
                             g.moeda_base
                        FROM exchange_price p
                        INNER JOIN exchange e ON e.id=p.id_exchange
                        INNER JOIN exchange_api g
                            ON g.id_exchange=p.id_exchange 
                            AND g.id_exchange_coin=p.id_exchange_coin
                        WHERE p.id IN (
                                            SELECT MAX(s.id)
                                            FROM exchange_price s
                                            WHERE s.created <= DATE_SUB(NOW(),INTERVAL ".$period[$time].")
                                            GROUP BY s.id_exchange,s.id_exchange_coin
                                        )
                        AND g.status=1
                         AND e.status=1
                        AND  p.high_price > 0
                        AND  p.low_price > 0
                        AND  p.last_price > 0
                        GROUP BY p.id
                    ) as v
                    GROUP BY v.moeda_base";
        $rs = $this->query($sql);
        $prices = [];
        foreach ($rs as $r) {
            $prices[$r['moeda_base']] = $r['price_media'];
        }
        return $prices;
    }

    function findExchange() {
        $sql = "SELECT 
                                        name,
                                        logo,
                                        color
                                FROM exchange
                                WHERE status=1";
        return $this->query($sql);
    }

    function findCalcPriceHistory() {

        $sql = "SELECT 
                       v.moeda_base,
                    (sum(v.calc_price)/sum(v.volume))as price_media,
                    DATE_FORMAT(v.created,'%Y-%m-%d %H:%i') as minuto
                    FROM (
                        SELECT 
                                    e.name as exchange,
                                    (p.last_price*p.volume) as calc_price,
                                    e.color,
                                    e.logo,
                                    p.last_price,
                                    p.volume,
                                    g.moeda_base,
                                    p.created
                        FROM exchange_price p
                        INNER JOIN exchange e ON e.id=p.id_exchange
                        INNER JOIN exchange_coin c ON c.id=p.id_exchange_coin
                        INNER JOIN exchange_api g
                                ON g.id_exchange=p.id_exchange 
                                AND g.id_exchange_coin=p.id_exchange_coin
                        INNER JOIN (
                                        SELECT max(s.id) as id 
                                        FROM  exchange_price s
                                        WHERE s.created >= DATE_SUB(NOW(),INTERVAL 7 DAY)
                                        GROUP BY s.id_exchange,s.id_exchange_coin, DATE_FORMAT(s.created,'%Y-%m-%d %H:%i')
                        ) a   ON a.id=p.id
                        WHERE e.status=1
                        ORDER BY p.id desc
                    ) as v
                    group by v.moeda_base,minuto";
        return $this->query($sql);
    }

    function findVolumeSum($moeda) {
        $sql = "SELECT
                            count(*) as qtde,
                            sum(p.volume) as volume_sum,
                            DATE_FORMAT(p.created,'%Y-%m-%d %H:%i') as minuto
                        FROM
                        exchange_price p
                        INNER JOIN exchange_api g
                                ON g.id_exchange=p.id_exchange 
                                AND g.id_exchange_coin=p.id_exchange_coin
                                AND g.moeda_base='BRL'
                        WHERE p.created >= DATE_SUB(NOW(),INTERVAL 7 DAY)
                        GROUP BY minuto
                        having qtde=(
                                        select count(*) 
                                        FROM exchange_api h
                                        WHERE h.moeda_base='BRL' 
                                        AND h.status=1
                                    )
                        order by p.id asc";
        $par['moeda'] = $moeda;
        return $this->query($sql, $par);
    }

}
