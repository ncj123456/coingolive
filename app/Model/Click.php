<?php

namespace Model;

class Click extends \Base\DAO {

    protected $_table = "click";
    protected $id_link;
    protected $ip;

    function setIdLink($id_link) {
        $this->id_link = $id_link;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    function findList() {
        $sql = "select l.url,count(DISTINCT ip) as qtde from click c 
                        inner join link l on l.id=c.id_link
                        GROUP BY l.url";
        return $this->query($sql);
    }

}
