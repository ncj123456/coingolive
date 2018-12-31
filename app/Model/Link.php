<?php

namespace Model;

class Link extends \Base\DAO {

    protected $_table = "link";
    protected $url;
    protected $ip;

    function setUrl($url) {
        $this->url = $url;
    }

    function findLink($id) {
        $sql = "SELECT  url  FROM link WHERE id=:id ";
        $par = [
            'id' => (int) $id
        ];

        $rs = $this->query($sql, $par);

        if (isset($rs[0])) {
            return $rs[0]['url'];
        }
        return false;
    }

}
