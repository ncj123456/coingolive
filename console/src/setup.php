<?php

$db = \Base\DB::connect();
$sql = file_get_contents(ROOT.'/setup.sql');

$exec= $db->query($sql);
$exec->closeCursor();

if($exec){
    echo "OK".PHP_EOL;
}else{
    echo " erro ao criar tabelas".PHP_EOL;
}

//insert country
$sql = file_get_contents(ROOT.'/setup_country.sql');

$exec= $db->query($sql);