<?php

namespace Controller;

class Moeda {

    function change() {
        $moeda = $_GET['moeda'];
        setcookie( 'moeda', $moeda, time() +2592000,'/');  
        echo 'OK';
    }

}
