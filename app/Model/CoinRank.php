<?php

namespace Model;

class CoinRank extends \Base\DAO {

    protected $_table = "coin_rank";
    protected $rank;
    protected $id_externo;
    protected $price_btc;
    protected $price_usd;
    protected $volume_usd;
    protected $marketcap_usd;
    protected $date;

    function setRank($rank) {
        $this->rank = $rank;
    }

    function setIdExterno($id_externo) {
        $this->id_externo = $id_externo;
    }

    function setPriceBtc($price_btc) {
        $this->price_btc = $price_btc;
    }

    function setPriceUsd($price_usd) {
        $this->price_usd = $price_usd;
    }

    function setVolumeUsd($volume_usd) {
        $this->volume_usd = $volume_usd;
    }

    function setMarketcapUsd($marketcap_usd) {
        $this->marketcap_usd = $marketcap_usd;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function findDates() {
        $sql = "select 
                            count(*),
                            date as dt
                            from
                        coin_history_2 v
                        where v.rank is null AND v.marketcap > 0
                        group by dt
                        order by dt asc";
        return $this->query($sql);
    }

    function findRank($coins) {

        $par = [];
        $whereIn=[];
        foreach ($coins as $k => $val) {
            $par[$k . '_id_externo'] = $val;
            $whereIn[':'.$k . '_id_externo']=$val;
        }
        
        $whereIn = implode(',',array_keys($whereIn));

        $sql = "select
                        id_externo,
                           rank,
                           date
                       from coin_history_2
                       where id_externo in (".$whereIn.") 
                        and rank is not null";
        return $this->query($sql, $par);
    }

    function findHistory2ByDate($date) {
        $sql = "select 
                        @rownum:= @rownum + 1 rank
                        ,a.id_externo
                        from (
                                select
                                    v.id_externo
                                from coin_history_2 v
                                where date =:date
                                and marketcap>0
                                and (rank is null OR rank <> '')
                                group by v.id_externo
                                order by marketcap desc
                            ) a,(select @rownum:= 0) s";
        $par = [
            'date' => $date
        ];
        return $this->query($sql, $par);
    }

}
