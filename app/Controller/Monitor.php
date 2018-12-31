<?php

namespace Controller;

class Monitor {

    function check() {
        $types = [
            'maxprice',
            'coinchange',
            'changehistory'
        ];

        if (isset($_GET['type'])) {
            $method = $_GET['type'];

            if (in_array($method, $types)) {
                $rs = (new \Model\Monitor())->{$method}();
                echo json_encode(["erro" => $rs]);
            }else{
                echo 'type nao encontrado';
            }
        }
    }

}
