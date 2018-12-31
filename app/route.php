<?php

$app = new Base\Route();

//compare

$app->get('', 'Home:view');
$app->get('/compare/exchange/price/bitcoin', 'Compare:redirect');
$app->get('/exchange/price/bitcoin', 'Compare:redirect');
$app->get('/compare/coin', 'Compare:view');
$app->get('/compare/data', 'Compare:data');
$app->ajax('/compare/change', 'Compare:change');

//Coin

$app->get('/coin/price', 'CoinMaxPrice:listar');
$app->ajax('/coin/price/data', 'CoinMaxPrice:data');
$app->get('/coin/cron', 'CronCoin:insert');
$app->get('/coin/cron/image', 'CronCoin:saveImage');

//perfil moeda
$app->get('/currencies/:name', 'CoinPerfil:view');

//contato

$app->get('/contact', 'Contato:contact');
$app->get('/feedback', 'Contato:feedback');
$app->get('/partners', 'Home:partners');


//change moeda
$app->get('/moeda/change', 'Moeda:change');

//seo

//change moeda
$app->ajax('/seo/sitemap', 'Seo:sitemap');

//json todas as moedas
$app->ajax('/coin/all/json', 'CoinMaxPrice:listAll');

//click
$app->get('/click', 'Click:save');
$app->get('/click/listar', 'Click:listar');

//widget
$app->ajax('/widget/view', 'Widget:view');


//trade
$app->get('/trade', 'Trade:view');
$app->get('/trade/data', 'Trade:data');

//variacao
$app->get('/coin-change/:exchange/:market', 'Change:view');
//variacao
$app->get('/coin-change/cron', 'CronChange:save');

//variacao
$app->get('/coin/pump', 'Pump:view');

$app->get('/coin/change-history', 'CoinHistoryChange:view');
$app->ajax('/coin/change-history/data', 'CoinHistoryChange:data');

//ath
$app->get('/coin/ath', 'CoinAth:view');
$app->ajax('/coin/ath/data', 'CoinAth:data');

//user
//$app->get('/user/register', 'User:register');
//$app->get('/user/login', 'User:login');
$app->ajax('/user/login/ajax', 'User:login');
$app->ajax('/user/auth', 'User:auth');
$app->ajax('/user/register/ajax', 'User:register_ajax');
$app->post('/user/register/save', 'User:save');
$app->get('/user/logout', 'User:logout');
$app->post('/user/civic', 'User:civic');
$app->ajax('/country/list', 'Country:listJson');

//favorite
$app->post('/user/favorite/coin', 'UserFavorite:favoriteCoin');
//teste
$app->get('/teste', 'Teste:teste');
//brasil
$app->get('/bitcoin/brasil', 'CoinBrasil:view');
$app->ajax('/bitcoin/brasil/data', 'CoinBrasil:data');
$app->ajax('/bitcoin/brasil/series', 'CoinBrasil:series');
$app->ajax('/bitcoin/brasil/price', 'CoinBrasil:price');
$app->ajax('/bitcoin/brasil/media', 'CoinBrasil:media');
$app->ajax('/bitcoin/brasil/volume', 'CoinBrasil:volumeSum');
$app->ajax('/bitcoin/brasil/resume', 'CoinBrasil:resume');

//coin index
$app->get('/coin-rank', 'CoinRank:view'); 
$app->ajax('/coin-rank/data', 'CoinRank:data');
$app->ajax('/coin-rank/cron', 'CronCoinRank:save');
$app->get('/coin-rank-history', 'CoinHistoryRank:view');
$app->ajax('/coin-rank-history/data', 'CoinHistoryRank:data');
$app->get('/coin-rank/generate', 'CoinHistoryRank:generate');

//teste
$app->get('/donate', 'Home:donate');

//monitor
$app->get('/monitor', 'Monitor:check');

$app->execute();
