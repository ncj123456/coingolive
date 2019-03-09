<?php

date_default_timezone_set('America/Belem');

//regra de cookie price

if(!isset($_COOKIE['moeda'])){
    setcookie( 'moeda', 'USD', time() +2592000,'/');    
}

//xss protection

foreach ($_GET as $name => $val) {
    $_GET[$name] = htmlspecialchars($val);
}
foreach ($_POST as $name => $val) {
    $_POST[$name] = htmlspecialchars($val);
}
foreach ($_REQUEST as $name => $val) {
    $_REQUEST[$name] = htmlspecialchars($val);
}

