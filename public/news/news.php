<?php
ini_set('display_errors',1);
$sitemap = file_get_contents("https://livecoins.com.br/feed/");

$noticias  = simplexml_load_string($sitemap);

$itens = $noticias->channel->item;
$array = [];

foreach($itens as $i){
    $array[]=[
        'title'=> (string) $i->title,
        'url'=> (string) $i->link
    ];
}

file_put_contents(__DIR__.'/news.json', json_encode($array));