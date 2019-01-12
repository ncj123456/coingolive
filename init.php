<?php

date_default_timezone_set('America/Belem');

//regra de cookie price

if(!isset($_COOKIE['moeda'])){
    setcookie( 'moeda', 'USD', time() +2592000,'/');    
}

