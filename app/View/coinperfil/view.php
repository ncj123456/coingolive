<?php
$compare_coin = isset($_GET['compare']) ? $_GET['compare'] : 'bitcoin';
$current_moeda = isset($_COOKIE['moeda']) ? $_COOKIE['moeda'] : 'USD';
$input_marketcap = isset($_GET['marketcap']) ? $_GET['marketcap'] : 0;

$market_cap_compare = $compare['market_cap_moeda'];
$porc_market_cap_compare = 100;

if ($input_marketcap > 0) {

    $porc_market_cap_compare = $input_marketcap * 100 / $compare['market_cap_moeda'];
    $market_cap_compare = $input_marketcap;
}

//calculos
$price_moeda = $dados['price_moeda'];
$available_supply = (float) $dados['available_supply'];

$max_price_moeda = $market_cap_compare / $available_supply;

$percent_available_supply = round((($max_price_moeda / $dados['price_moeda']) * 100 ) - 100);


if ($percent_available_supply < 0) {
    $color_percent = 'red';
} elseif ($percent_available_supply > 0) {
    $color_percent = '#ff9f3c';
} else {
    $color_percent = '';
}
//check moeda fiat
if ($dados['moeda_char'] == 'BTC') {
    $price_current = decimal($price_moeda, 8) . ' ' . $dados['moeda_char'];
    $price_available_supply = decimal($max_price_moeda, 8) . ' ' . $dados['moeda_char'];
} else {
    $price_current = $dados['moeda_char'] . ' ' . decimal($price_moeda, 2, true);
    $price_available_supply = $dados['moeda_char'] . ' ' . decimal($max_price_moeda, 2, true);
}

$style_title = ' margin-top: 0px;';


//seo
$_title = $dados['name'] . ' (' . $dados['symbol'] . ')';
$_meta_description = _e('Estimativa do preço máximo da criptomoeda [1] utilizando a captalização de mercado da [2]', $dados['name'], ucfirst($compare_coin));

$color_vol24 = volumeColor($dados['volume_24h_moeda']);         
?>
<input type="hidden" id="porc_marketcap_perfil" value="<?= decimal($porc_market_cap_compare, 0) ?>"/>
<input type="hidden" id="valor_marketcap_perfil" value="<?= decimal($market_cap_compare, 0) ?>"/>
<input type="hidden" id="base_marketcap_perfil" value="<?= decimal($compare['market_cap_moeda'], 0) ?>"/>
<input type="hidden" id="input_compare_coin" value="<?= $compare_coin ?>"/>

<div class="row">
    <div class="col-md-12" >
        <?php require_once __DIR__ . "/../coinmaxprice/msg_alert.inc.php" ?>
    </div>
    <div class="main main-raised  col-md-12"  style="margin: 0px!important;background-color: #f9f9f9;">
        <div class="container">
            <div style="position:absolute; top: 1px;right: 8px">
                <?= _e('Ultima atualização') . ' ' . dateDesc($dados['data_alteracao']) ?>
            </div>

            <div class="section section-perfil " style="padding-top: 0;padding-bottom: 2px">
                <div class="section" style="padding-top: 6px;">
                    <?php
                    $disableRank = true;
                    require __DIR__ . '/../inc/calculo.inc.php';
                    ?>
                    <hr/>
                    <div class="row">
                        <?php require __DIR__ . '/../inc/msg_help.inc.php' ?>
                        <div class="col-md-3  text-center">
                            <img style="margin-right:10px;max-width:80px" src="/assets/img/coin/<?= $dados['codigo'] ?>.png">
                            <h2 class="title" style="line-height: 1.2em;margin-top: 3px"><?= $dados['name'] ?><br/> <small> <?= $dados['symbol'] ?></small></h2>
                            <div class="text-center">
                                <?= btnBuy($dados['symbol'], true); ?>
                            </div>
                        </div>
                        <div class="col-md-5 text-center" style="padding:5px">
                            <div class="card card-body"  style="margin-top: 0px;margin-bottom: 5px;">
                                <h4 class="description"><?= _e('Cotação Máxima') ?></h4>
                                <table class="table ">
                                    <tr>
                                        <td><?= _e('Preço Atual') ?></td>
                                        <td><?= $price_current ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= _e('Preço Máximo') ?>  <i data-toggle="tooltip" title="" class="fa fa-question-circle-o help" id="btn_help_max_price" style="color:#9124a3;font-size: 20px" data-original-title="<?= _e('Ajuda') ?>"></i></td>
                                        <td><?= $price_available_supply ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= _e('Crescimento') ?></td>
                                        <td style="background-color:#ff9800;color:#fff;  border-radius: 5px;"><?= decimal($percent_available_supply, 0) ?>%</td>
                                    </tr>
                                    <tr>
                                        <td><?= _e('Market Cap Atual') ?></td>
                                        <td><?= $dados['moeda_char'] . ' ' . decimal($dados['market_cap_moeda'], 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= _e('Market Cap Estimado').' ('.$compare['symbol'].')' ?></td>
                                        <td><?= $dados['moeda_char'] . ' ' . decimal($market_cap_compare, 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= _e('Dominância Atual') ?></td>
                                        <td><?= decimal($dados['percent_dominance'], 3) ?> %</td>
                                    </tr>
                                    <tr>
                                        <td><?= _e('Fornecimento Circulante') ?></td>
                                        <td><?= decimal($available_supply, 0) . ' ' . $dados['symbol']; ?> </td>
                                    </tr>
                                    <tr>
                                        <td><?= _e('Fornecimento Máximo') ?></td>
                                        <td>
                                            <?php
                                            echo decimal($dados['max_supply'], 0) . ' ';
                                            echo ($dados['max_supply'] > 0) ? $dados['symbol'] : null;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= _e('Volume 24h') ?></td>
                                        <td   style="background-color:  <?= $color_vol24 ?>;  border-radius: 5px;" >
                                     <?= $dados['moeda_char'] . ' ' . decimal($dados['volume_24h_moeda'],0) ?> 
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="col-md-4 text-center" style="padding:5px">
                         
                            <div class="card card-body"  style="margin-top: 0px;margin-bottom: 5px;">
                                <h4 class="description"><?= _e('Histórico de Preço') ?></h4>
                                <table class="table ">
                                    <tr>
                                        <td>1 <?= _e('hora') ?></td>
                                        <td style="padding:0px!important"><?= formatPorc($dados['price_change_percentage_1h'],false,'','','5px') ?></td>
                                    </tr>
                                    <tr>
                                        <td>24 <?= _e('horas') ?></td>
                                        <td style="padding:0px!important"><?= formatPorc($dados['price_change_percentage_24h'],false,'','','5px') ?></td>
                                    </tr>
                                    <tr>
                                        <td>7 <?= _e('dias') ?></td>
                                        <td style="padding:0px!important"><?= formatPorc($dados['price_change_percentage_7d'],false,'','','5px') ?></td>
                                    </tr>
                                    <tr>
                                        <td>14 <?= _e('dias') ?></td>
                                        <td style="padding:0px!important"><?= formatPorc($dados['price_change_percentage_14d'],false,'','','5px') ?></td>
                                    </tr>
                                    <tr>
                                        <td>30 <?= _e('dias') ?></td>
                                        <td style="padding:0px!important"><?= formatPorc($dados['price_change_percentage_30d'],false,'','','5px') ?></td>
                                    </tr>
                                    <tr>
                                        <td>200 <?= _e('dias') ?></td>
                                        <td style="padding:0px!important"><?= formatPorc($dados['price_change_percentage_200d'],false,'','','5px') ?></td>
                                    </tr>
                                    <tr>
                                        <td>1 <?= _e('ano') ?></td>
                                        <td style="padding:0px!important"><?= formatPorc($dados['price_change_percentage_1y'],false,'','','5px') ?></td>
                                    </tr>
                                </table>
                            </div>
                               <div class="card card-body"  style="margin-top: 0px;">
                                <h4 class="description"><?= _e('Alta Histórica') ?></h4>
                                <table class="table ">
                                    <tr>
                                        <td><?= _e('Preço') ?> ATH</td>
                                        <td><?= $dados['moeda_char'] ?> <?= decimal($dados['high_price'], 2, true); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= _e('Data') ?> ATH</td>
                                        <td><?= $dados['high_date'] ?> <small>( <?= dateDesc($dados['high_date']) ?> )</small></td>
                                    </tr>
                                    <tr>
                                        <td>% <?= _e('para') ?> ATH</td>
                                        <td style="padding:0px!important; "><?= formatPorc($dados['growth_high'],false,'','','5px') ?></td>
                                    </tr>
                                    <tr>
                                        <td>% <?= _e('desde') ?> ATH</td>
                                        <td style="padding:0px!important; "><?= formatPorc($dados['porc_high'],false,'','','5px') ?></td>
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
                </div>
                <?php
                $currentLang = \Base\I18n::getCurrentLang();
                $html_widget = '<script type="text/javascript" src="' . BASE_URL . '/assets/js/widget.js"></script>'
                        . ' <div class="coingolive-currency-widget" data-currencyname="' . $dados['codigo'] . '" data-currencybase="' . $compare_coin . '" data-lang="' . $currentLang . '" data-moeda="' . $current_moeda . '"></div>';
                ?>
                <script>
                    var cgl_trigger_manuel = true;
                </script>
                <div class="text-right">
                    <button  class="btn btn-outline-primary btn-sm" id="btn_widget">Widget</button>
                </div>
                <div id="codigo_widget" style="display:none">
                    <hr>
                    <div class="row" >
                        <div class="col-md-6">
                            <label>Widget</label>
                            <textarea id="codigo_html_widget" class="form-control" rows="5">
                                <?= $html_widget ?>
                            </textarea>
                        </div>
                        <div class="col-md-6" >
                            <?= $html_widget ?>
                        </div>
                    </div>

                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center" style="margin-top: 40px">
    <?= _e('Fonte dos dados:') ?> <a href="https://coingecko.com" target="_blank">CoinGecko</a>
</div>