<?php
if($baseMoeda){
    $current_moeda = $baseMoeda;
}else{
    $current_moeda = isset($_COOKIE['moeda']) ? $_COOKIE['moeda'] : 'USD';
}
$market_cap_compare = $compare['market_cap_moeda'];
$

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

if($currentLang==='pt-br'){
    
    if($baseMoeda){
        $descBaseMoeda = ' em '.$baseMoeda;
    }

    $_title = $dados['name'] . ' (' . $dados['symbol'] . ') Preço atual'.$descBaseMoeda.', Histórico Cotação, Market Cap';
    $description = 'Cotação da criptomoeda '.$dados['name'] . ' (' . $dados['symbol'] . ') hoje '.$descBaseMoeda.', '
            . ' confira o maior valor na alta histórica ATH, veja a variação do preço em períodos e compare com o marketcap do Bitcoin e Ouro';
    
}else{
    
    if($baseMoeda){
        $descBaseMoeda = ' in '.$baseMoeda;
    } 

     $_title = $dados['name'] . ' (' . $dados['symbol'] . ') Price'.$descBaseMoeda.', Historical Price Change, Market Cap, ATH';
     $description ='Price '.$dados['name'] . ' (' . $dados['symbol'] . ') today'.$baseMoeda.', cryptocurrency all time high ATH,'
             . ' see the historical price change, compare with the Bitcoin and Gold market cap';
     
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

if($dados['moeda_char']=='BTC'){
    $dados['moeda_char'].=' ';
}
?>
<script>
    var price_coin =<?= $dados['price_moeda'] ?>;
    var moeda_char = '<?= $dados['moeda_char'] ?>';
</script>
<div class="row" style="margin: 0px;">
    <div class="main main-raised  col-md-12"  style="margin: 0px!important;background-color: #f9f9f9;">
        <div class="container">
            <!--            <div style="position:absolute; top: 1px;right: 8px">
            <?= _e('Ultima atualização') . ' ' . dateDesc($dados['data_alteracao']) ?>
                        </div>-->

            <div class="section section-perfil " style="padding-top: 0;padding-bottom: 2px">
                <div class="section" style="padding-top: 20px;">
                    <?php
                    $disableRank = true;
                    ?>
                    <div class="row">
                        <div class="col-md-3  text-center">
                            <img style="margin-right:10px;max-width:50px" src="/assets/img/coin/<?= $dados['codigo'] ?>.png">
                            <h1 class="title" style="line-height: 1.2em;margin-top: 3px;font-size: 22px;"><?= $dados['name'] ?><br/> <small> <?= $dados['symbol'] ?></small></h1>
                            <div class="text-center">
                                <?= btnBuy($dados['symbol'], true); ?>
                            </div>
                        </div>
                        <div class="col-md-9 card " style="max-width:650px">
                            <div style="padding:30px" class="d-flex flex-column flex-md-row align-items-center justify-content-center">
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <button style="width:92px"  class="btn btn-primary"><?= $dados['symbol'] ?></button>
                                    </div>
                                    <input type="number"  step="any" id="amount_from"   style="padding: 5px 0px 5px 10px;height: 47px;font-size: 20px"  value="" class="form-control amount-converter">
                                </div>
                                <i  class="fa fa-exchange text-xl text-lg-2xl m-3 currency-swap"></i>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="dropdown">
                                            <button style="width:92px"  class="btn btn-primary  dropdown-toggle moedaAtual" type="button" data-toggle="dropdown">
                                                <?= $current_moeda ?>
                                            </button>
                                            <div class="dropdown-menu ">
                                                <?php
                                                $listLangs = \Base\I18n::getListMoeda();
                                                foreach ($listLangs as $n => $char) {
                                                   $n2= strtolower($n);
                                                    ?>
                                                <a href="<?= siteUrl('/currencies/'.$dados['codigo'].'/'.$n2.'/');  ?>" class="dropdown-item">
                                                        <?= $n ?>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="number" id="amount_to" style="padding: 5px 0px 5px 10px;height: 47px;font-size: 20px" value="" class="form-control amount-converter" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 text-center" >
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
                                            if($dados['max_supply'] > 0){
                                                 echo decimal($dados['max_supply'], 0) . ' ';
                                                echo $dados['symbol'];
                                            }else{
                                                echo '<span class="table-danger " style="padding:4px 40px;border-radius:10px" data-toggle="tooltip" data-html="true" title="" data-original-title="'._e("Não existe um limite máximo de fornecimento").'"> <i class="fa fa-close" style="color:#c5615d"></i></span>';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-center" style="padding:5px;">
                            <div class="card card-body"  style="margin-top: 0px;height: 99%">
                                <h4 class="description"><?= _e('Alta Histórica') ?></h4>
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
                                <h4 class="description"><?= _e('Histórico de Preço') ?></h4>
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
                                <h3><img style="max-width:60px" src="/assets/img/btc_today.png" /> <?= _e('Market Cap Atual BTC' ) ?></h3>
                                <p><?= _e('Cálculo de preço com o valor de mercado atual do Bitcoin'); ?></p>
                                <table class="table " style="font-size:15px;border-radius: 20px;background-color: whitesmoke;">
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
                                                <th><?= _e('Posição <br/> Rank')?></th>
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
                                <h3><img style="max-width:60px" src="/assets/img/btc_ath.png" /> <?= _e('Market Cap BTC na ATH') ?></h3>
                                <p><?= _e('Cálculo de preço com o maior valor de mercado do Bitcoin') ?></p>
                                <table class="table " style="font-size:15px;border-radius: 20px;background-color: whitesmoke;">
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
                                <h3><img style="max-width:40px" src="/assets/img/gold.png" /> <?= _e('Market Cap Ouro') ?> </h3>
                                <p><?= _e('Cálculo de preço com o valor de mercado aproximado do Ouro') ?></p>
                                <table class="table " style="font-size:15px;border-radius: 20px;background-color: whitesmoke;">
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