<?php
$_title = _e('Calcular Preço Criptomoedas Alterando o Market Cap');
$_meta_description = _e('Calcule o preço das criptomoedas com a mesma capitalização de mercado do Bitcoin, altere o valor do Market Cap e veja o crescimento necessário para alcançá-lo');

$compare_coin = isset($_GET['compare']) ? $_GET['compare'] : 'bitcoin';
$current_moeda = isset($_COOKIE['moeda']) ? $_COOKIE['moeda'] : 'USD';

$market_cap_compare = $compare['market_cap_moeda'];
$porc_market_cap_compare = 100;

if (isset($_GET['marketcap']) && $_GET['marketcap'] > 0) {

    $porc_market_cap_compare = $_GET['marketcap'] * 100 / $compare['market_cap_moeda'];
    $market_cap_compare = $_GET['marketcap'];
}

//filters
$inputBusca = isset($_GET['s']) ? $_GET['s'] : '';
$inputOrderName = isset($_GET['name']) ? $_GET['name'] : 'rank';
$inputOrderType = isset($_GET['order']) ? $_GET['order'] : 'asc';
$inputMarketCap = isset($_GET['marketcap']) ? $_GET['marketcap'] : 0;
$inputFavorite = isset($_GET['favorite']) ? $_GET['favorite'] : '';
?>
<script>
    var max_rank_all = <?= $max_rank_all ?>;
     var input_marketcap_url = <?= $inputMarketCap ?>;
       var user_favorite = <?= ($inputFavorite)?'true':'false' ?>;
</script>
<input type="hidden" id="order_name" value="<?= $inputOrderName ?>"/>
<input type="hidden" id="order_type" value="<?= $inputOrderType ?>"/>
<input type="hidden" id="compare_coin" value="<?= $compare_coin ?>"/>
<div class="row" style="margin: 0px;">
    <div class="col-md-12">
        <h1 style="padding: 3px;margin-top:20px;font-size:25px"><?= _e($_title) ?>
            <i data-toggle="tooltip" title="" class="fa fa-question-circle-o help" id="btn_help_max_price" style="color:#9124a3;font-size: 30px" data-original-title="<?= _e('Ajuda') ?>"></i>
        </h1>
    </div>
    <div class="col-md-12">
        <div class="card" style="  margin-top: 0px;">
            <div class="card-body" style="padding:0;margin-left: 10px;margin-right: 10px">
                <?php
                $disableRank = false;
                require __DIR__ . '/../inc/calculo.inc.php';
                ?>
                <!--<div id="tableContent" >-->
                <div>
                    <?php
                    require_once __DIR__ . '/data_content.php';
                    ?>
                </div>

            </div>
        </div>
        
        <?php require __DIR__ . '/../inc/msg_help.inc.php' ?>
        <?php require_once __DIR__ . "/msg_alert.inc.php" ?>
    </div> 
</div>
<div class="text-center">
    <?= _e('Fonte dos dados:') ?> <a href="https://coingecko.com" target="_blank">CoinGecko</a>
</div>