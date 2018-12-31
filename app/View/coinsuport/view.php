<?php
$titleCoins = [];
foreach ($input_coins as $k=>$c){
    $a = str_replace(['-'], ' ', $c);
    $titleCoins[]=ucwords($a);
}
$titleCoins = implode(', ', $titleCoins);
$_title = $titleCoins.' - '._e("Histórico Rank");
$_meta_description =$titleCoins.", ". _e("Criptomoedas compare o histórico do rank baseado no Market Cap");

if (!DEBUG) {
    require __DIR__ . '/../inc/ads.inc.php';
}
?>
<div class="row">
    <?php
    if (!$input_coins) {
        $input_coins = [];
        ?>
        <div class="col-md-12 ">
            <div class="alert alert-info">
                <div class="container">
                    <div class="alert-icon">
                        <i class="material-icons">info_outline</i>
                    </div> <?= _e('Selecione uma ou mais criptomoedas'); ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="col-md-10">
        <div class="card" style="padding: 10px;margin-bottom: 0px; margin-top: 18px;" >
            <div class="card-title" style="margin-bottom: 0px;"><?= $_title ?>
                <div id="chart_suport" style="height: 500px"></div>
            </div>
            <script src="/assets/js/plugins/echarts/echarts-en.min.js"></script>
        </div>   
    </div>
    <div class="col-md-2">
        <?php
        if (!DEBUG) {
            require __DIR__ . '/../inc/ads_lado.inc.php';
        }
        ?>
    </div>
    <div class="text-center" style="width: 100%;margin-top: 30px">
        <?= _e('Fonte dos dados:') ?> <a href="https://coinmarketcap.com" target="_blank">CoinMarketCap</a>
    </div>
</div>
<script>
    var input_coin = "<?= $coin ?>";
    function compareCoin(name) {
        input_coins.push(name);
        window.location = getUrl();
        return false;
    }

    function removeCoin(name) {

        var index = input_coins.indexOf(name);
        if (index > -1) {
            input_coins.splice(index, 1);
        }

        window.location = getUrl();
        return false;
    }

    function getUrl() {
        var url = '?coins=' + input_coins.join(',');
        return url;
    }
</script>