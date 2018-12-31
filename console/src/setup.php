<?php

$db = \Base\DB::connect();
$sql = file_get_contents(ROOT.'/setup.sql');

$exec= $db->query($sql);

if($exec){
    echo "OK".PHP_EOL;
}else{
    echo " erro ao criar tabelas".PHP_EOL;
}