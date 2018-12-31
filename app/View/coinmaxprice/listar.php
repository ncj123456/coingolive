<?php
$_title = _e('Cotação Máxima');
$_meta_description = _e('Estime o preço de cada moeda com a mesma capitalização de mercado do Bitcoin.');

$compare_coin = isset($_GET['compare']) ? $_GET['compare'] : 'bitcoin';
$current_moeda = isset($_COOKIE['moeda']) ? $_COOKIE['moeda'] : 'USD';
?>
<input type="hidden" id="order_name" value="rank"/>
<input type="hidden" id="order_type" value="asc"/>
<input type="hidden" id="compare_coin" value="<?= $compare_coin ?>"/>
<?php
if (!DEBUG) {
    require __DIR__ . '/../inc/ads.inc.php';
}
?>
<div class="row">
    <div class="col-md-12">
        <h1 style="padding: 3px;margin-top:20px;font-size:25px"><?= _e($_title) ?>
            <i data-toggle="tooltip" title="" class="fa fa-question-circle-o help" id="btn_help_max_price" style="color:#9124a3;font-size: 30px" data-original-title="<?= _e('Ajuda') ?>"></i>
        </h1>
    </div>
    <div class="col-md-10">
        <?php require __DIR__ . '/../inc/msg_help.inc.php' ?>
    </div>
    <div class="col-md-10">
       <?php require_once __DIR__."/msg_alert.inc.php" ?>
        <div class="card" style="  margin-top: 0px;">
            <div class="card-body" style="padding:0;margin-left: 10px;margin-right: 10px">
                <?php
                $disableRank = false;
                require __DIR__ . '/../inc/calculo.inc.php';
                ?>
                <div id="tableContent" >

                </div>

            </div>
        </div>
    </div> 

    <div class="text-center " style="margin-top: 20px;width: 100%; max-width: 160px">
        <?php
        if (!DEBUG) {
            require __DIR__ . '/../inc/ads_lado.inc.php';
        }
        ?>
    </div>
</div>
</div>
<div class="text-center">
    <?= _e('Fonte dos dados:') ?> <a href="https://coinmarketcap.com" target="_blank">CoinMarketCap</a>
</div>