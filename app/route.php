<?php

$app = new Base\Route();

//static pages
$app->get('', 'Home:view');
$app->get('/contact', 'Home:contact');
$app->get('/feedback', 'Home:feedback');
$app->get('/partners', 'Home:partners');

//Coin max price
$app->get('/coin/price', 'CoinMaxPrice:listar');
$app->ajax('/coin/price/data', 'CoinMaxPrice:data');

//perfil moeda
$app->get('/currencies/:name', 'CoinPerfil:view');

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
$app->get('/coin/ath', 'CoinAth:view');
$app->ajax('/coin/ath/data', 'CoinAth:data');

//change history
$app->get('/coin/change-history', 'CoinHistoryChange:view');
$app->ajax('/coin/change-history/data', 'CoinHistoryChange:data');

//user
$app->ajax('/user/login/ajax', 'User:login');
$app->ajax('/user/auth', 'User:auth');
$app->ajax('/user/register/ajax', 'User:register_ajax');
$app->post('/user/register/save', 'User:save');
$app->get('/user/logout', 'User:logout');
$app->post('/user/civic', 'User:civic');
$app->ajax('/country/list', 'Country:listJson');

//favorite
$app->post('/user/favorite/coin', 'UserFavorite:favoriteCoin');

//widget
$app->ajax('/widget/view', 'Widget:view');
//monitor
$app->get('/monitor', 'Monitor:check');

$app->execute();
