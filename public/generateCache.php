<?php

$base = "http://coingolive.com";
$urls = [
    "/pt-br/bitcoin/brasil/price/?cache=true&generate=true",
    "/pt-br/bitcoin/brasil/resume/?cache=true&generate=true",
    "/pt-br/bitcoin/brasil/resume/?cache=true&external=true&generate=true",
    "/pt-br/bitcoin/brasil/volume/?cache=true&generate=true",
    "/pt-br/bitcoin/brasil/media/?cache=true&generate=true",
    "/pt-br/bitcoin/brasil/series/?moeda=BRL&cache=true&generate=true",
    "/pt-br/bitcoin/brasil/series/?moeda=USD&cache=true&generate=true",
    "/pt-br/bitcoin/brasil/data/?moeda=BRL&name=volume&order=desc&cache=true&generate=true",
    "/pt-br/bitcoin/brasil/data/?moeda=USD&name=volume&order=desc&cache=true&generate=true",
    "/pt-br/bitcoin/brasil/media/?cache=true&generate=true",
    
];

foreach($urls as $u){
file_get_contents($base.$u);
}