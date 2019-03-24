<?php

namespace Model;

class Monitor extends \Base\DAO {

    function maxprice() {
        $sql = "select 
                        DATE_SUB(now(), INTERVAL 7 minute) >  min(updated) as erro
                        from moeda";
        return $this->query($sql)[0]['erro'];
    }

    function coinchange() {
        $sql = "select 
                        DATE_SUB(now(), INTERVAL 7 minute) >  min(updated) as erro
                        from coin_change;";
        return $this->query($sql)[0]['erro'];
    }

    function changehistory() {
        $sql = "select 
                    DATE_SUB(now(), INTERVAL 1 day) >  min(updated) as erro
                    from coin_history_change";
        return $this->query($sql)[0]['erro'];
    }

}
