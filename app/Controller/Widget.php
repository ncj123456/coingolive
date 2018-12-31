<?php

namespace Controller;

class Widget {

    function view() {
        header('Access-Control-Allow-Origin: *');

        $name = isset($_GET['name']) ? $_GET['name'] : false;
        $base = isset($_GET['base']) ? $_GET['base'] : 'bitcoin';
        $moeda = isset($_GET['moeda']) ? $_GET['moeda'] : 'USD';
        $this->saveRefer();

        if ($name) {
            $data = (new \Model\Moeda())->findOne($name, $moeda);
            if ($data) {
                $moedaCompare = (new \Model\Moeda())->findOne($base, $moeda);
                return [
                    'data' => $data,
                    'compare' => $moedaCompare
                ];
            }
        }

        echo 'currency not found, visit <a href="' . BASE_URL . '">CoinGoLive</a>';
        return;
    }

    function saveRefer() {

        $url_refer = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : null;
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $ip = $_SERVER['REMOTE_ADDR'];


        $obj = new \Model\UrlReferrer();
        $obj->setTag('widget');
        $obj->setUrlRefer($url_refer);
        $obj->setUrlDestino($actual_link);
        $obj->setIp($ip);
        $obj->insert();
    }

}
