<?php

namespace Model;

class CoinHistory extends \Base\DAO {

    protected $_table = "coin_history";
    protected $id;
    protected $id_externo;
    protected $price_btc;
    protected $price_usd;
    protected $volume_usd;
    protected $marketcap_usd;
    protected $date;
    protected $date_min;

    function setId($id) {
        $this->id = $id;
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

    function setDateMin($date_min) {
        $this->date_min = $date_min;
    }

    function findHistory($coins, $date = false) {
        $date = $this->antiInjection($date);
        $sql_part = [];
        //obtem a menor data  de criacao da moeda
        foreach ($coins as $k => $c) {
            $c = $this->antiInjection($c);
            $coins[$k] = $c;
            $sql_part[] = "(SELECT MIN(date) as min_date FROM coin_history WHERE id_externo='" . $c . "')";
        }
        $sql_date = "SELECT MAX(min_date) FROM (
                " . implode(' UNION ALL ', $sql_part) . "
            ) v";

        if ($date) {
            $sql_date = "'" . $date . "'";
        }

        $sql = "	SELECT 
                  p.*,
                  DATE_FORMAT(date,'%Y-%m-%d') as date_c
                  FROM coin_history p
                  WHERE id_externo in ('" . implode("','", $coins) . "')
                  AND date >= ($sql_date)
                    GROUP BY date_c,p.id_externo                
                  ORDER By date ASC";

        return $this->query($sql);
    }

    function findPriceChange($moeda) {
        $arrayMoedas = [
            'usd',
            'btc'
        ];
        //valida se a moeda existe
        if (!in_array($moeda, $arrayMoedas)) {
            return false;
        }
        $sql = "select 
                             v.id_externo,
                            (
                                select a.price_" . $moeda . " 
                                from coin_history a
                                where DATE_FORMAT(date,'%Y-%m-%d')=DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 YEAR),'%Y-%m-%d')
                                AND a.id_externo=v.id_externo
                                limit 1
                            ) as '1y',
                            (
                                select b.price_" . $moeda . "  
                                from coin_history b
                                where DATE_FORMAT(date,'%Y-%m-%d')=DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -6 month),'%Y-%m-%d')
                                AND b.id_externo=v.id_externo
                                limit 1
                            ) as '6m',
                            (
                                select c.price_" . $moeda . "  
                                from coin_history c
                                where DATE_FORMAT(date,'%Y-%m-%d')=DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -3 month),'%Y-%m-%d')
                                AND c.id_externo=v.id_externo
                                limit 1
                            ) as '3m',
                            (
                                select c.price_" . $moeda . "  
                                from coin_history c
                                where DATE_FORMAT(date,'%Y-%m-%d')=DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 month),'%Y-%m-%d')
                                AND c.id_externo=v.id_externo
                                limit 1
                            ) as '1m',
                            (
                                select d.price_" . $moeda . "  
                                from coin_history d
                                where DATE_FORMAT(date,'%Y-%m-%d')=DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -7 day),'%Y-%m-%d')
                                AND d.id_externo=v.id_externo
                                limit 1
                            ) as '7d',
                            (
                                select d.price_" . $moeda . "  
                                from coin_history d
                                where DATE_FORMAT(date,'%Y-%m-%d')=DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 day),'%Y-%m-%d')
                                AND d.id_externo=v.id_externo
                                limit 1
                            ) as '1d'
                            from (
                                SELECT s.id_externo 
                                FROM coin_history s
                                group by s.id_externo

                            ) v  ";
        return $this->query($sql);
    }

    function findAth($moeda) {

        $arrayMoedas = [
            'usd',
            'btc'
        ];
        //valida se a moeda existe
        if (!in_array($moeda, $arrayMoedas)) {
            return false;
        }
        $sql = "SELECT
                                z.id_externo,
                                MAX(z.price_" . $moeda . ") as high_price
                    FROM coin_history z
                    GROUP BY z.id_externo";
        $rs = $this->query($sql);
        $asssoc = [];

        foreach ($rs as $r) {
            $asssoc[$r['id_externo']] = $r;
        }
        return $asssoc;
    }

    function findAthDate($moeda, $id_externo, $high_price) {
        $arrayMoedas = [
            'usd',
            'btc'
        ];
        //valida se a moeda existe
        if (!in_array($moeda, $arrayMoedas)) {
            return false;
        }

        $sql = "
               SELECT max(x.date) as high_date
                FROM coin_history x
                 WHERE x.id_externo=:id_externo
                 AND x.price_" . $moeda . " =:high_price
            ";
        $par = [
            'id_externo' => $id_externo,
            'high_price' => $high_price
        ];
        return $this->query($sql, $par)[0]['high_date'];
    }
    
    function findHistory2($coin){
         $sql = "
               SELECT 
                    date,
                    open,
                    high,
                    low,
                    close
               FROM coin_history_2
               where id_externo=:id_externo
            ";
          $par = [
            'id_externo' => $coin
        ];
        return $this->query($sql, $par);
    }
    
        function findSuport($coin){
         $sql = "
               select 
                            max(close) as max_close,
                            min(close) as min_close,
                            num,
                            avg(close) as avg_close,
                            sum(qtde) as ss
                        from (
                                select 

                                concat(CHAR_LENGTH(uu),'-',(truncate((uu/50)/RPAD('1',CHAR_LENGTH(uu)-2,'0'),0))) as num,
                                close,
                                qtde,
                                uu
                                from (
                                        select 
                                        truncate(((close)*100000000),0) as uu,
                                        (truncate(((close-close*0.9)/10),0)) as num,
                                         h.close,
                                         h.date,
                                            (
                                            select 
                                                count(*)
                                            from coin_history_2 b 
                                            where h.close <= b.close+(close*0.01)
                                            AND h.close >=b.close-(close*0.01)
                                            and b.id_externo=h.id_externo
                                            ) as qtde,
                                            (
                                            select 
                                                max(b.high)
                                            from coin_history_2 b 
                                            where h.close <= b.close+(close*0.01)
                                            AND h.close >=b.close-(close*0.01)
                                            and b.id_externo=h.id_externo
                                            ) as mm
                                        from coin_history_2 h
                                        where h.id_externo=:id_externo
                                ) u 
                                ) g
                        group by g.num
                        order by ss desc
            ";
          $par = [
            'id_externo' => $coin
        ];
        return $this->query($sql, $par);
    }

}
