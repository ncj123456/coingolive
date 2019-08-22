<?php
if ($baseMoeda) {
    $current_moeda = $baseMoeda;
} else {
    $current_moeda = isset($_COOKIE['moeda']) ? $_COOKIE['moeda'] : 'USD';
}
$market_cap_compare = $compare['market_cap_moeda'];

//calculos
$price_moeda = $dados['price_moeda'];
$available_supply = (float) $dados['available_supply'];

$style_title = ' margin-top: 0px;';
$marketcap1 = ($market_cap_compare * 1 / 100);
$marketcap10 = ($market_cap_compare * 10 / 100);
$marketcap30 = ($market_cap_compare * 30 / 100);
$marketcap50 = ($market_cap_compare * 50 / 100);
$marketcap100 = $market_cap_compare;

$price_marketcap1 = $marketcap1 / $available_supply;
$price_marketcap10 = $marketcap10 / $available_supply;
$price_marketcap30 = $marketcap30 / $available_supply;
$price_marketcap50 = $marketcap50 / $available_supply;
$price_marketcap100 = $marketcap100 / $available_supply;


$porc_price_marketcap_current = $dados['market_cap_moeda'] * 100 / $market_cap_compare;

$porc_price_marketcap1 = round((($price_marketcap1 / $dados['price_moeda']) * 100 ) - 100);
$porc_price_marketcap10 = round((($price_marketcap10 / $dados['price_moeda']) * 100 ) - 100);
$porc_price_marketcap30 = round((($price_marketcap30 / $dados['price_moeda']) * 100 ) - 100);
$porc_price_marketcap50 = round((($price_marketcap50 / $dados['price_moeda']) * 100 ) - 100);
$porc_price_marketcap100 = round((($price_marketcap100 / $dados['price_moeda']) * 100 ) - 100);

//=========MARKETCAP ATH

$listAthMarketCap = [
    'usd' => 325311461891,
    'brl' => 1071905821292,
    'eur' => 272767172714
];

$market_cap_ath_compare = $listAthMarketCap[strtolower($current_moeda)];
$porc_price_marketcap_ath_current = $dados['market_cap_moeda'] * 100 / $market_cap_ath_compare;
$price_marketcap_ath1 = ($market_cap_ath_compare * 1 / 100) / $available_supply;
$price_marketcap_ath10 = ($market_cap_ath_compare * 10 / 100) / $available_supply;
$price_marketcap_ath30 = ($market_cap_ath_compare * 30 / 100) / $available_supply;
$price_marketcap_ath50 = ($market_cap_ath_compare * 50 / 100) / $available_supply;
$price_marketcap_ath100 = $market_cap_ath_compare / $available_supply;

$porc_price_marketcap_ath1 = round((($price_marketcap_ath1 / $dados['price_moeda']) * 100 ) - 100);
$porc_price_marketcap_ath10 = round((($price_marketcap_ath10 / $dados['price_moeda']) * 100 ) - 100);
$porc_price_marketcap_ath30 = round((($price_marketcap_ath30 / $dados['price_moeda']) * 100 ) - 100);
$porc_price_marketcap_ath50 = round((($price_marketcap_ath50 / $dados['price_moeda']) * 100 ) - 100);
$porc_price_marketcap_ath100 = round((($price_marketcap_ath100 / $dados['price_moeda']) * 100 ) - 100);

//=========MARKETCAP GOLD

$listGoldMarketCap = [
    'usd' => 7700000000000,
    'brl' => 28490000000000,
    'eur' => 6160000000000
];
$market_cap_gold = $listGoldMarketCap[strtolower($current_moeda)];

$porc_price_marketcap_gold_current = $dados['market_cap_moeda'] * 100 / $market_cap_gold;

$price_marketcap_gold1 = ($market_cap_gold * 1 / 100) / $available_supply;
$price_marketcap_gold10 = ($market_cap_gold * 10 / 100) / $available_supply;
$price_marketcap_gold30 = ($market_cap_gold * 30 / 100) / $available_supply;
$price_marketcap_gold50 = ($market_cap_gold * 50 / 100) / $available_supply;
$price_marketcap_gold100 = $market_cap_gold / $available_supply;

$porc_price_marketcap_gold1 = round((($price_marketcap_gold1 / $dados['price_moeda']) * 100 ) - 100);
$porc_price_marketcap_gold10 = round((($price_marketcap_gold10 / $dados['price_moeda']) * 100 ) - 100);
$porc_price_marketcap_gold30 = round((($price_marketcap_gold30 / $dados['price_moeda']) * 100 ) - 100);
$porc_price_marketcap_gold50 = round((($price_marketcap_gold50 / $dados['price_moeda']) * 100 ) - 100);
$porc_price_marketcap_gold100 = round((($price_marketcap_gold100 / $dados['price_moeda']) * 100 ) - 100);


//seo
$descBaseMoeda = '';

$currentLang = \Base\I18n::getCurrentLang();

$nameCoin = $dados['name'] . ' (' . $dados['symbol'] . ')';

if ($currentLang === 'pt-br') {

    $descFiat = [
        'BRL' => 'Real',
        'USD' => 'Dólar',
        'EUR' => 'Euro',
    ];

    if ($baseMoeda) {
        $descBaseMoeda = ' em ' . $descFiat[$baseMoeda] . ' (' . $baseMoeda . ')';
    }

    $_title = $nameCoin . ' Preço' . $descBaseMoeda . ', Histórico Cotação, Market Cap, ATH';
    $description = 'Preço ' . $nameCoin . ' hoje' . $descBaseMoeda
            . ', confira a maior cotação na alta histórica ATH, veja a variação do valor em períodos com porcentagem de valorização e desvalorização, compare com o market cap do Bitcoin e Ouro';

    $titleH1 = $nameCoin . '<br/><span class="coin-h1"> Preço' . $descBaseMoeda . ' hoje, Histórico Cotação, Market Cap, Alta histórica ATH </span>';
} else {

    $descFiat = [
        'BRL' => 'Real',
        'USD' => 'Dollar',
        'EUR' => 'Euro',
    ];

    if ($baseMoeda) {
        $descBaseMoeda = ' to ' . $descFiat[$baseMoeda] . ' (' . $baseMoeda . ')';
    }

    $_title = $nameCoin . ' Price' . $descBaseMoeda . ', Price Change History, Market Cap, ATH';
    $description = 'Price ' . $nameCoin . ' today' . $descBaseMoeda . ', cryptocurrency all time high ATH,'
            . ' see the price change history with percentage gain and loss, compare with the Bitcoin and Gold market cap';

    $titleH1 = $nameCoin . '<br/><span class="coin-h1"> Price' . $descBaseMoeda . ' today, Price Change History, Market Cap, All Time High ATH';
}
$_meta_description = $description;
$_css[] = "/assets/css/coin-perfil.css";

$color_vol24 = volumeColor($dados['volume_24h_moeda']);

$crescimentoPorc = function($val) {
    if ($val < 0) {
        return "porc-change-negative";
    }
    return "porc-change";
};
$porcInverse = function($price, $porc) {
    return $price * 100 / (100 + $porc);
};

if ($dados['moeda_char'] == 'BTC') {
    $dados['moeda_char'] .= ' ';
}

$dadosDecoded = json_decode($dados['all_prices'],false);

//alterar posição array

function changePos(&$array, $a, $b) {
    $out = array_splice($array, $a, 1);    
	array_splice($array, $b, 0, $out);
}
//posição original BRL BTC EUR USD

//mudando ultimo para o primeiro 
changePos($dadosDecoded,3,0);

//mudando terceiro para o ultimo
changePos($dadosDecoded,3,2);

if ($dados['symbol'] == 'xrb')
    ?>
    <script>
        var price_coin =<?= $dados['price_moeda'] ?>;
        var moeda_char = '<?= $dados['moeda_char'] ?>';
        var all_prices = <?= $dados['all_prices'] ?>;
        var all_prices_decoded = <?= json_decode($dados['all_prices']) ?>;
        
</script>
<div class="row" style="margin: 0px;">

    <div class="main main-raised  col-md-12"  style="margin: 0px!important;background-color: #f9f9f9;">
        <div class="container">
            <!--            <div style="position:absolute; top: 1px;right: 8px">
            <?= _e('Ultima atualização') . ' ' . dateDesc($dados['updated']) ?>
                        </div>-->

            <div class="section section-perfil " style="padding-top: 0;padding-bottom: 2px">
            <div class="section" style="padding-top: 15px;">
                    <?php
                    $disableRank = true;
                    ?>
                    <div class="row">
                        <div style="margin-left: auto;margin-right: auto;" class="col-md-4 text-center  ">
                            <img alt="<?= $nameCoin ?>" style="margin-right:10px;max-width:50px" src="/assets/img/coin/<?= $dados['codigo'] ?>.png">
                            <h1 class="title" style="line-height: 1.1em;margin-top: 3px;font-size: 22px;"><?= $titleH1 ?></h1>
                            <div class="text-center"><?= btnAds($dados['symbol'], true); ?></div>
                        </div>                        
                        <div class="col-md-12 text-center" style="max-width:1850px;">
                                    <div class="card d-flex justify-content-center" style="padding:10px;top:0px;max-width:410px;margin-bottom:0px;margin-left:auto;margin-right:auto">
                                             
                                    <div class="input-group">

                                        <div class="input-group-prepend">
                                            <button style="width:92px"  class="btn btn-primary"><?= $dados['symbol'] ?></button>
                                        </div>
                                        <input type="number" data-symbol="<?=$dados['symbol'];?>" pricemoeda="<?=1?>" step="any" id="amount_from"   style="padding: 10px 0px 5px 10px;height: 47px;font-size: 20px"  value="" class="form-control amount-converter ">
                                        
                                     
                                    </div>
                                    </div>
                                    <div id="rowItems" class="card d-flex flex-md-row " style="max-width:2500px;padding:10px;margin-bottom:20px">
                                    <?php foreach($dadosDecoded as $value){?>                               
                                        <div class="input-group ">
                                            <div class="input-group-prepend ">
                                                <button style="width:92px"  class="btn btn-primary moedaAtual" type="button" data-toggle="dropdown">
                                                    <?= $value->moeda?>
                                                </button>           
                                            </div>
                                            
                                            
                                            <input data-symbol="<?= $value->moeda;?>" type="number" 
                                            pricecurrentmoeda="<?= $value->price_moeda ?>" pricemoeda="<?= $value->price ?>" step="any" style="margin:20;padding: 5px 1px 5px 10px;height: 47px;font-size: 20px" value="" class="form-control amount-converter " >
                                        </div>

                                    <?php } ?>
                                    
                                </div>
                            </div>
                                    
                        
                        
                        <div class="col-md-12 text-center"style="margin-left: auto;margin-right: auto;" class="col-md-4 text-center  " >
                            <div class="card card-body"  style="margin-top: 0px;margin-bottom: 8px;">
                                <div class="row">
                                    <div class="col-md-2 col-6" style="margin-bottom:5px;margin-top: 5px;">
                                        <span class="description"><?= _e('Rank') ?></span><br/>
                                        <span><?= $dados['rank'] ?></span>
                                    </div>
                                    <div class="col-md-2  col-6" style="margin-bottom:5px;margin-top: 5px">
                                        <span class="description"><?= _e('Market Cap Atual') ?></span><br/>
                                        <span><?= $dados['moeda_char'] . decimal($dados['market_cap_moeda'], 0) ?></span>
                                    </div>
                                    <div class="col-md-2  col-6" style="margin-bottom:5px;margin-top: 5px">
                                        <span class="description">  <?= _e('Dominância Atual') ?></span><br/>
                                        <span><?= decimal($dados['percent_dominance'], 4) ?> %</span>
                                    </div>
                                    <div class="col-md-2  col-6" style="margin-bottom:5px;margin-top: 5px">
                                        <span class="description"><?= _e('Volume 24h') ?></span>:<br/>
                                        <span><?= $dados['moeda_char'] . decimal($dados['volume_24h_moeda'], 0) ?> </span>
                                    </div>
                                    <div class="col-md-2 col-6" style="margin-bottom:5px;margin-top: 5px">
                                        <span class="description"><?= _e('Fornecimento Circulante') ?></span><br/>
                                        <span  ><?= decimal($available_supply, 0) . ' ' . $dados['symbol']; ?></span>
                                    </div>
                                    <div class="col-md-2  col-6" style="margin-bottom:5px;margin-top: 5px">
                                        <span class="description"><?= _e('Fornecimento Máximo') ?></span><br/>
                                        <span> 
                                            <?php
                                            if ($dados['max_supply'] > 0) {
                                                echo decimal($dados['max_supply'], 0) . ' ';
                                                echo $dados['symbol'];
                                            } else {
                                                echo '<span class="table-danger " style="padding:4px 40px;border-radius:10px" data-toggle="tooltip" data-html="true" title="" data-original-title="' . _e("Não existe um limite máximo de fornecimento") . '"> <i class="fa fa-close" style="color:#c5615d"></i></span>';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6 text-center" style="padding:5px;">
                            <div class="card card-body"  style="margin-top: 0px;height: 99%">
                                <h2   style=" margin-top: 2px;"><?= _e('Alta Histórica') ?></h2>
                                <div class="table-responsive">
                                    <table class="table ">
                                        <tr>
                                            <td><?= _e('Cálculo Preço ATH') ?></td>
                                            <td class="price-total" data-price="<?= $dados['high_price'] ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><?= _e('Preço') ?> ATH</td>
                                            <td><?= $dados['moeda_char'] ?><?= decimal($dados['high_price'], 2, true); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= _e('Data') ?> ATH</td>
                                            <td><?= $dados['high_date'] ?> <small>( <?= dateDesc($dados['high_date']) ?> )</small></td>
                                        </tr>
                                        <tr>
                                            <td>% <?= _e('para') ?> ATH</td>
                                            <td style="padding:0px!important; "><?= formatPorc($dados['growth_high'], false, '', '', '5px') ?></td>
                                        </tr>
                                        <tr>
                                            <td>% <?= _e('desde') ?> ATH</td>
                                            <td style="padding:0px!important; "><?= formatPorc($dados['porc_high'], false, '', '', '5px') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= _e('Posição Preço Atual') ?></td>
                                            <td>
                                                <div class="progress progress-line-primary " style="height: 20px;">
                                                    <div class="progress-bar progress-bar-primary" role="progressbar" style="width: <?= round(100 + $dados['porc_high'], 2) ?>%;heigth:10px">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 text-center" style="padding:5px">

                            <div class="card card-body"  style="margin-top: 0px;margin-bottom: 5px;">
                                <h2 style=" margin-top: 2px;"><?= _e('Histórico de Preço') ?></h2>
                                <div class="table-responsive">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th><?= _e('Período') ?></th>
                                                <th><?= _e('Variação') ?></th>
                                                <th><?= _e('Preço') ?></th>
                                                <th><?= _e('Total calculado') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1 <?= _e('hora') ?></td>
                                                <td style="padding:0px!important"><?= formatPorc($dados['price_change_percentage_1h'], false, '', '', '5px') ?></td>
                                                <td>
                                                    <?php
                                                    $price1h = $porcInverse($dados['price_moeda'], $dados['price_change_percentage_1h']);
                                                    echo $dados['moeda_char'] . decimal($price1h, 2, true);
                                                    ?>
                                                </td>
                                                <td class="price-total" data-price="<?= $price1h ?>"></td>

                                            </tr>
                                            <tr>
                                                <td>24 <?= _e('horas') ?></td>
                                                <td style="padding:0px!important"><?= formatPorc($dados['price_change_percentage_24h'], false, '', '', '5px') ?></td>
                                                <td>
                                                    <?php
                                                    $price24h = $porcInverse($dados['price_moeda'], $dados['price_change_percentage_24h']);
                                                    echo $dados['moeda_char'] . decimal($price24h, 2, true);
                                                    ?>
                                                </td>
                                                <td class="price-total" data-price="<?= $price24h ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>7 <?= _e('dias') ?></td>
                                                <td style="padding:0px!important"><?= formatPorc($dados['price_change_percentage_7d'], false, '', '', '5px') ?></td>
                                                <td>
                                                    <?php
                                                    $price7d = $porcInverse($dados['price_moeda'], $dados['price_change_percentage_7d']);
                                                    echo $dados['moeda_char'] . decimal($price7d, 2, true);
                                                    ?>
                                                </td>
                                                <td class="price-total" data-price="<?= $price7d ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>14 <?= _e('dias') ?></td>
                                                <td style="padding:0px!important"><?= formatPorc($dados['price_change_percentage_14d'], false, '', '', '5px') ?></td>
                                                <td>
                                                    <?php
                                                    $price14d = $porcInverse($dados['price_moeda'], $dados['price_change_percentage_14d']);
                                                    echo $dados['moeda_char'] . decimal($price14d, 2, true);
                                                    ?>
                                                </td>
                                                <td class="price-total" data-price="<?= $price14d ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>30 <?= _e('dias') ?></td>
                                                <td style="padding:0px!important"><?= formatPorc($dados['price_change_percentage_30d'], false, '', '', '5px') ?></td>              
                                                <td>
                                                    <?php
                                                    $price30d = $porcInverse($dados['price_moeda'], $dados['price_change_percentage_30d']);
                                                    echo $dados['moeda_char'] . decimal($price30d, 2, true);
                                                    ?>
                                                </td>
                                                <td class="price-total" data-price="<?= $price30d ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>200 <?= _e('dias') ?></td>
                                                <td style="padding:0px!important"><?= formatPorc($dados['price_change_percentage_200d'], false, '', '', '5px') ?></td>
                                                <td>
                                                    <?php
                                                    $price200d = $porcInverse($dados['price_moeda'], $dados['price_change_percentage_200d']);
                                                    echo $dados['moeda_char'] . decimal($price200d, 2, true);
                                                    ?>
                                                </td>
                                                <td class="price-total" data-price="<?= $price200d ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>1 <?= _e('ano') ?></td>
                                                <td style="padding:0px!important"><?= formatPorc($dados['price_change_percentage_1y'], false, '', '', '5px') ?></td>    
                                                <td>
                                                    <?php
                                                    $price1y = $porcInverse($dados['price_moeda'], $dados['price_change_percentage_1y']);
                                                    echo $dados['moeda_char'] . decimal($price1y, 2, true);
                                                    ?>
                                                </td>
                                                <td class="price-total" data-price="<?= $price1y ?>"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                                          
                        <div class="col-md-6 text-center" style="padding:5px">
                            <div class="card card-body"  style="margin-top: 0px;margin-bottom: 5px;">
                                <h2><img style="max-width:60px" src="/assets/img/btc_today.png" alt="<?= _e('BTC hoje') ?>" /> <?= _e('Market Cap Atual BTC') ?></h2>
                                <p><?= _e('Cálculo de preço com o valor de mercado atual do Bitcoin'); ?></p>
                                <table class="table" style="border-style: hidden;font-size:15px;border-radius: 20px;background-color: whitesmoke;">
                                    <tbody>
                                        <tr>
                                            <td><?= _e('Atual Market Cap BTC'); ?></td>
                                            <td><?= $dados['moeda_char'] . decimal($market_cap_compare, 0); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= _e('Data'); ?></td>
                                            <td><?= _e('Hoje'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="table-responsive"> 
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><?= _e('% do Atual <br/> Market Cap BTC') ?></th>
                                                <th><?= _e('Preço'); ?> <?= $dados['symbol'] ?><br/> <?= _e('calculado') ?></th>
                                                <th><?= _e('Total <br/> calculado') ?></th>
                                                <th><?= _e('Posição <br/> Rank') ?></th>
                                                <th><?= _e('Crescimento <br/> necessário') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= decimal($porc_price_marketcap_current, 2, true) ?>%</td>
                                                <td><?= $dados['moeda_char'] . decimal($dados['price_moeda'], 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $dados['price_moeda'] ?>"></td>
                                                <td  data-market-cap="<?= $dados['market_cap_moeda'] ?>"  class="market-cap-rank"></td>
                                                <td>--</td>
                                            </tr>
                                            <tr>
                                                <td>1%</td>
                                                <td><?= $dados['moeda_char'] . decimal($price_marketcap1, 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $price_marketcap1 ?>"></td>
                                                <td data-market-cap="<?= $marketcap1 ?>"   class="market-cap-rank"></td>
                                                <td  class="<?= $crescimentoPorc($porc_price_marketcap1) ?>"><?= decimal($porc_price_marketcap1, 0) ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>10%</td>
                                                <td><?= $dados['moeda_char'] . decimal($price_marketcap10, 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $price_marketcap10 ?>"></td>
                                                <td data-market-cap="<?= $marketcap10 ?>"   class="market-cap-rank"></td>
                                                <td  class="<?= $crescimentoPorc($porc_price_marketcap10) ?>"><?= decimal($porc_price_marketcap10, 0) ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>30%</td>
                                                <td><?= $dados['moeda_char'] . decimal($price_marketcap30, 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $price_marketcap30 ?>"></td>
                                                <td data-market-cap="<?= $marketcap30 ?>"  class="market-cap-rank"></td>
                                                <td  class="<?= $crescimentoPorc($porc_price_marketcap30) ?>"><?= decimal($porc_price_marketcap30, 0) ?>%</td>
                                            </tr>
                                            <tr>
                                                <td >50%</td>
                                                <td><?= $dados['moeda_char'] . decimal($price_marketcap50, 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $price_marketcap50 ?>"></td>
                                                <td data-market-cap="<?= $marketcap50 ?>" class="market-cap-rank"></td>
                                                <td  class="<?= $crescimentoPorc($porc_price_marketcap50) ?>"><?= decimal($porc_price_marketcap50, 0) ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>100%</td>
                                                <td><?= $dados['moeda_char'] . decimal($price_marketcap100, 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $price_marketcap100 ?>"></td>
                                                <td data-market-cap="<?= $marketcap100 ?>" class="market-cap-rank"></td>
                                                <td  class="<?= $crescimentoPorc($porc_price_marketcap100) ?>"><?= decimal($porc_price_marketcap100, 0) ?>%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-center" style="padding:5px">
                            <div class="card card-body"  style="margin-top: 0px;margin-bottom: 5px;">
                                <h2><img style="max-width:60px" src="/assets/img/btc_ath.png"  alt="BTC ATH"/> <?= _e('Market Cap BTC na ATH') ?></h2>
                                <p><?= _e('Cálculo de preço com o maior valor de mercado do Bitcoin') ?></p>
                                <table class="table " style="font-size:15px;
                                border-style: hidden;border-radius: 20px;background-color: whitesmoke;">
                                    <tbody>
                                        <tr>
                                            <td><?= _e('Maior MarketCap BTC') ?></td>
                                            <td><?= $dados['moeda_char'] . decimal($market_cap_ath_compare, 0); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= _e('Data') ?></td>
                                            <td>2017-12-16</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="table-responsive"> 
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><?= _e('% do Maior <br/> MarketCap BTC') ?></th>
                                                <th><?= _e('Preço'); ?> <?= $dados['symbol'] ?><br/> <?= _e('calculado') ?></th>
                                                <th><?= _e('Total <br/> calculado') ?></th>
                                                <th><?= _e('Crescimento <br/> necessário') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= decimal($porc_price_marketcap_ath_current, 2, true) ?>%</td>
                                                <td><?= $dados['moeda_char'] . decimal($dados['price_moeda'], 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $dados['price_moeda'] ?>"></td>
                                                <td>--</td>
                                            </tr>
                                            <tr>
                                                <td>1%</td>
                                                <td><?= $dados['moeda_char'] . decimal($price_marketcap_ath1, 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $price_marketcap_ath1 ?>"></td>
                                                <td  class="<?= $crescimentoPorc($porc_price_marketcap_ath1) ?>"><?= decimal($porc_price_marketcap_ath1, 0) ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>10%</td>
                                                <td><?= $dados['moeda_char'] . decimal($price_marketcap_ath10, 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $price_marketcap_ath10 ?>"></td>
                                                <td  class="<?= $crescimentoPorc($porc_price_marketcap_ath10) ?>"><?= decimal($porc_price_marketcap_ath10, 0) ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>30%</td>
                                                <td><?= $dados['moeda_char'] . decimal($price_marketcap_ath30, 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $price_marketcap_ath30 ?>"></td>
                                                <td  class="<?= $crescimentoPorc($porc_price_marketcap_ath30) ?>"><?= decimal($porc_price_marketcap_ath30, 0) ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>50%</td>
                                                <td><?= $dados['moeda_char'] . decimal($price_marketcap_ath50, 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $price_marketcap_ath50 ?>"></td>
                                                <td  class="<?= $crescimentoPorc($porc_price_marketcap_ath50) ?>"><?= decimal($porc_price_marketcap_ath50, 0) ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>100%</td>
                                                <td><?= $dados['moeda_char'] . decimal($price_marketcap_ath100, 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $price_marketcap_ath100 ?>"></td>
                                                <td  class="<?= $crescimentoPorc($porc_price_marketcap_ath100) ?>"><?= decimal($porc_price_marketcap_ath100, 0) ?>%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                          
                        <div class="col-md-6 text-center" style="padding:5px">
                            <div class="card card-body"  style="margin-top: 0px;margin-bottom: 5px;">
                                <h2><img style="max-width:40px" src="/assets/img/gold.png" alt="Ouro" /> <?= _e('Market Cap Ouro') ?> </h2>
                                <p><?= _e('Cálculo de preço com o valor de mercado aproximado do Ouro') ?></p>
                                <table class="table " style="font-size:15px;border-style: hidden;border-radius: 20px;background-color: whitesmoke;">
                                    <tbody>
                                        <tr>
                                            <td><?= _e('Market Cap Ouro') ?></td>
                                            <td><?= $dados['moeda_char'] . decimal($market_cap_gold, 0); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= _e('Data') ?></td>
                                            <td>2017</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="table-responsive"> 
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>% <?= _e('Market Cap Ouro') ?></th>
                                                <th><?= _e('Preço'); ?> <?= $dados['symbol'] ?><br/> <?= _e('calculado') ?></th>
                                                <th><?= _e('Total <br/> calculado') ?></th>
                                                <th><?= _e('Crescimento <br/> necessário') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= decimal($porc_price_marketcap_gold_current, 2, true) ?>%</td>
                                                <td><?= $dados['moeda_char'] . decimal($dados['price_moeda'], 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $dados['price_moeda'] ?>"></td>
                                                <td>--</td>
                                            </tr>
                                            <tr>
                                                <td>1%</td>
                                                <td><?= $dados['moeda_char'] . decimal($price_marketcap_gold1, 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $price_marketcap_gold1 ?>"></td>
                                                <td  class="<?= $crescimentoPorc($porc_price_marketcap_gold1) ?>"><?= decimal($porc_price_marketcap_gold1, 0) ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>10%</td>
                                                <td><?= $dados['moeda_char'] . decimal($price_marketcap_gold10, 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $price_marketcap_gold10 ?>"></td>
                                                <td  class="<?= $crescimentoPorc($porc_price_marketcap_gold10) ?>"><?= decimal($porc_price_marketcap_gold10, 0) ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>30%</td>
                                                <td><?= $dados['moeda_char'] . decimal($price_marketcap_gold30, 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $price_marketcap_gold30 ?>"></td>
                                                <td  class="<?= $crescimentoPorc($porc_price_marketcap_gold30) ?>"><?= decimal($porc_price_marketcap_gold30, 0) ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>50%</td>
                                                <td><?= $dados['moeda_char'] . decimal($price_marketcap_gold50, 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $price_marketcap_gold50 ?>"></td>
                                                <td  class="<?= $crescimentoPorc($porc_price_marketcap_gold50) ?>"><?= decimal($porc_price_marketcap_gold50, 0) ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>100%</td>
                                                <td><?= $dados['moeda_char'] . decimal($price_marketcap_gold100, 2, true); ?></td>
                                                <td class="price-total" data-price="<?= $price_marketcap_gold100 ?>"></td>
                                                <td  class="<?= $crescimentoPorc($porc_price_marketcap_gold100) ?>"><?= decimal($porc_price_marketcap_gold100, 0) ?>%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding:5px">
                            <div class="card card-body"  style="margin-top: 0px;margin-bottom: 5px;">
                                <!-- Coinzilla Banner 300x250 -->
                                <script async src="https://coinzillatag.com/lib/display.js"></script>
                                <div class="text-center">
                                    <div id="ads" class="coinzilla" data-zone="C-387385a8c26c8224bc"></div>
                                </div>
                                <script>
                                window.coinzilla_display = window.coinzilla_display || [];
                                var c_display_preferences = {};
                                c_display_preferences.zone = "387385a8c26c8224bc";
                                c_display_preferences.width = "300";
                                c_display_preferences.height = "250";
                                coinzilla_display.push(c_display_preferences);
                                </script>
                            </div>
                        </div>
                        </div> 
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="col-md-12" style="margin-top:30px" >
        <?php require_once __DIR__ . "/../coinmaxprice/msg_alert.inc.php" ?>
    </div>
</div>
<div class="text-center" style="margin-top: 40px">
    <?= _e('Fonte dos dados:') ?> <a href="https://coingecko.com" target="_blank">CoinGecko</a>
</div>