<?php

echo $_SERVER['REMOTE_ADDR'];
echo "<br/>";
$ipCountry = isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : false;

if($ipCountry){
    echo "IP do : ".$ipCountry;
}else{
    echo "não encontrado o GEOIP";
}