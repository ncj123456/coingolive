<?php

namespace Model;

class UrlReferrer extends \Base\DAO {

    protected $_table = "url_referrer";
    protected $url_refer;
    protected $url_destino;
    protected $tag;
    protected $ip;

    function setUrlRefer($url_refer) {
        $this->url_refer = $url_refer;
    }

    function setUrlDestino($url_destino) {
        $this->url_destino = $url_destino;
    }

    function setTag($tag) {
        $this->tag = $tag;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

}
