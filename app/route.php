<?php

$app = new Base\Route();

//static pages
$app->get('', 'CoinHome:data');
$app->get('/coin-home', 'CoinHome:last7days');
$app->get('/tools', 'Home:view');

$app->get('/contact', 'Home:contact');
$app->get('/feedback', 'Home:feedback');
$app->get('/partners', 'Home:partners');

$app->get('/global-data', 'CoinGlobal:json');

//Coin max price
$app->get('/coin/price', 'CoinMaxPrice:data');

$app->get('/market-cap-rank', 'CoinPerfil:rankMarketCap');

//perfil moeda
$app->get('/currencies/:name', 'CoinPerfil:redirect');
$app->get('/currencies/:name/:moeda', 'CoinPerfil:redirect');

$app->get('/coins/:name', 'CoinPerfil:view');
$app->get('/coins/:name/:moeda', 'CoinPerfil:view');

//change moeda
$app->get('/moeda/change', 'Moeda:change');

//seo
$app->ajax('/seo/sitemap', 'Seo:sitemap');

//json todas as moedas
$app->ajax('/coin/all/json', 'CoinMaxPrice:listAll');


//variacao
$app->get('/coin-change/:exchange/:market', 'Change:view');
$app->get('/coin-change/cron', 'CronChange:save');

//ath
$app->get('/coin/ath-price', 'CoinAth:data');
$app->get('/coin/ath', 'CoinAth:redirect');

//change history
$app->get('/coin/price-change-history', 'CoinHistoryChange:data');
$app->get('/coin/change-history', 'CoinHistoryChange:redirect');


$app->get('/videos-criptomoedas', 'Video:view');

//user
$app->ajax('/user/login/ajax', 'User:login');
$app->ajax('/user/auth', 'User:auth');
$app->ajax('/user/register/ajax', 'User:register_ajax');
$app->post('/user/register/save', 'User:save');
$app->get('/user/logout', 'User:logout');
$app->post('/user/civic', 'User:civic');
$app->ajax('/country/list', 'Country:listJson');

$app->get('/videos-criptomoedas', 'Video:view');

//favorite
$app->post('/user/favorite/coin', 'UserFavorite:favoriteCoin');

//widget
$app->ajax('/widget/view', 'Widget:view');
//monitor
$app->get('/monitor', 'Monitor:check');


$app->execute();
