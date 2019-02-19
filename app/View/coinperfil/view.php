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
?>
<input type="hidden" id="porc_marketcap_perfil" value="<?= decimal($porc_market_cap_compare, 0) ?>"/>
<input type="hidden" id="valor_marketcap_perfil" value="<?= decimal($market_cap_compare, 0) ?>"/>
<input type="hidden" id="base_marketcap_perfil" value="<?= decimal($compare['market_cap_moeda'], 0) ?>"/>
<input type="hidden" id="input_compare_coin" value="<?= $compare_coin ?>"/>

<div class="row">
    <div class="col-md-12" >
        <?php require_once __DIR__ . "/../coinmaxprice/msg_alert.inc.php" ?>
    </div>
    <div class="main main-raised  col-md-12"  style="margin: 0px!important">
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
                                <?= btnBuy($dados['symbol'],true); ?>
                            </div>
                        </div>
                        <div class="col-md-3 text-center" style="padding:5px">
                            <h3 class="description"><?= _e('Preço Atual') ?></h3>
                            <h2  style="<?= $style_title ?>"><?= $price_current ?></h2>
                        </div>
                        <div class="col-md-3 text-center" style="padding:5px">
                            <h3 class="description" ><?= _e('Preço Máximo') ?> <i data-toggle="tooltip" title="" class="fa fa-question-circle-o help" id="btn_help_max_price" style="color:#9124a3;font-size: 30px" data-original-title="<?= _e('Ajuda') ?>"></i></h3>
                            <h2 style="<?= $style_title ?>" ><?= $price_available_supply ?></h2>
                        </div>
                        <div class="col-md-3 text-center" style="padding:5px">
                            <h3 class="description" ><?= _e('Crescimento') ?></h3>
                            <h2   style="<?= $style_title . ' color:' . $color_percent; ?>" ><?= decimal($percent_available_supply, 0) ?>%</h2>
                        </div>
                        <div class="col-md-3 text-center" style="padding:5px">
                        </div>
                        <div class="col-md-3 text-center" style="padding:5px">
                            <h4 class="description"><?= _e('Dominancia') ?></h4>
                            <h3  style="<?= $style_title ?>"> <?= decimal($dados['percent_dominance'], 2, true) ?>% </h3>
                        </div>
                        <div class="col-md-3 text-center" style="padding:5px">
                            <h4 class="description"><?= _e('Volume 24h') ?></h4>
                            <h3 style="<?= $style_title ?>"> <?= $dados['moeda_char'] . ' ' . decimal($dados['volume_24h_moeda']) ?> </h3>
                        </div>
                        <div class="col-md-3 text-center" style="padding:5px">
                            <h4 class="description"><?= _e('Fornecimento Máximo') ?></h4>
                            <h3 style="<?= $style_title ?>"> 
                                <?php
                                echo decimal($dados['max_supply'], 2) . '<br/>';
                                echo ($dados['max_supply'] > 0) ? $dados['symbol'] : null;
                                ?> </h3>
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