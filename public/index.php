<?php

if(file_exists(__DIR__.'/setup.php')){
    header('Location: /setup.php');
    die;
}

header('Access-Control-Allow-Origin: *');
//verifica o cache
//if (isset($_GET['cache']) && $_GET['cache'] == 'true') {
//    //salva o cache
//    require __DIR__ . '/../cache.php';
//}
session_start();

//isalva os erros gerados
require __DIR__ . '/../log_erro.php';

//inclui as definicoes globais
require __DIR__ . '/../define.php';

//inclui as configuracoes de inicio
require __DIR__ . '/../init.php';

//verifica se exibira os erros
if (DEBUG) {
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
}

require __DIR__ . '/../func.php';
require ROOT . '/autoload.php';


require ROOT . '/app/route.php';
