<?php

date_default_timezone_set('America/Sao_Paulo');

//regra de cookie price

if(!isset($_COOKIE['moeda'])){
    setcookie( 'moeda', 'USD', time() +2592000,'/');    
}

