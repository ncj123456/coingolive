<?php
//copy file config
if(!file_exists(__DIR__.'/../define.php')){
    $rs1 =  copy(__DIR__.'/../define.local', __DIR__.'/../define.php');
    if(!$rs1){
        echo 'Erro ao copiar o arquivo de configuracao';
    }
}

//script create tables
$rs2 = exec('php /var/www/console/execute.php setup');


$rs3 = exec('php /var/www/console/execute.php moeda');
$rs4 = exec('php /var/www/console/execute.php coin-change');

if($rs2==='OK'){
    echo 'Tabelas criadas';
    unlink(__FILE__);
}else{
  echo $rs2;  
}

