<?php

namespace Base;

abstract class Controller {

    function getPost() {
        $data = [];
        foreach ($_POST as $k => $p) {
            $data[$k] = $this->inputFilter($p);
        }
        return $data;
    }

    function inputFilter($input) {
        $input = strip_tags($input);
        $input = addslashes($input);
        return $input;
    }

    function getIp() {
        return isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR'];
    }

    function jsonSuccess($msg) {
        $arr = [
            'success' => true,
            'msg' => $msg
        ];
        return json_encode($arr);
    }

    function jsonError($msg) {
        $arr = [
            'success' => false,
            'msg' => $msg
        ];
        return json_encode($arr);
    }

}
