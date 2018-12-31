<?php

ob_start();
$cacheFile = getCacheFileName();


if(isset($_GET['generate'])){
  register_shutdown_function(function() {
        $cacheFile = getCacheFileName();
        $data = ob_get_contents();
        $fileBytes = file_put_contents($cacheFile, $data);
    });
    
}else if (file_exists($cacheFile)) {
    //obtem o cache e finalliza o script
    $data = file_get_contents($cacheFile);
    echo $data;
    die;

//verifica se alguém já ficou no cache
//} elseif (file_exists($initCacheFile)) {

    //aguarda até o cache ser criado
    //do {
//        if (file_exists($completeFileCache)) {
//            //obtem o cache e finalliza o script
//            $data = file_get_contents($completeFileCache);
//            echo $data;
//            die;
//        }
  //      sleep(0.4);
//    } while (true);
//} else {
//    file_put_contents($initCacheFile, 'true');
    //salva o cache no fim do script
//    register_shutdown_function(function() {
//        $cacheFile = getCacheFileName();
 //       $data = ob_get_contents();
 //       $fileBytes = file_put_contents($cacheFile, $data);
        
//        if ($fileBytes) {
 //           rename($cacheFile, $cacheFile.".complete");
 //       }
  //  });
}

function getCacheFileName() {
    $url = $_SERVER['REQUEST_URI'];
    $url = str_replace(["&generate=true","generate=true"],"",$url);
    $cacheName = md5($url);
    $cacheFile = __DIR__ . '/cache/' . $cacheName;
    return $cacheFile;
}
