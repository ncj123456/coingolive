<?php
$_title = _e("Bitcoin Brasil");

$_meta_description = _e('Gráficos, Preços, Exchanges de Bitcoin, compare o mercado brasileiro de Bitcoin com mercado USD, analise a variação do preço e volume em diferentes exchanges BRL e USD');

$compare_coin = isset($_GET['compare']) ? $_GET['compare'] : 'bitcoin';
$current_moeda = isset($_COOKIE['moeda']) ? $_COOKIE['moeda'] : 'USD';

if (!DEBUG) {
    require __DIR__ . '/../inc/ads.inc.php';
}
$listLangs = [
    'USD' => '$',
    'BTC' => 'BTC'
];
if (!isset($listLangs[$current_moeda])) {
    $current_moeda = 'USD';
}

function getUrlTradeView($name) {
    $url = 'https://br.tradingview.com/widgetembed/?symbol=' . $name . '&interval=D&hidesidetoolbar=1&saveimage=1&toolbarbg=f1f3f6&studies=[]&theme=Light&style=1&timezone=Etc/UTC&studies_overrides={}&overrides={}&enabled_features=[]&disabled_features=[]&locale=br&utm_source=br.tradingview.com&utm_medium=widget_new&utm_campaign=chart&utm_term=' . $name;
    return $url;
}
?>
<input type="hidden" id="order_name" value="volume"/>
<input type="hidden" id="order_type" value="desc"/>

<div class="row">
    <div class="col-md-3" style="max-width: 180px;">
        <h1 style="padding: 3px;margin-top:0px;font-size:25px"><?= _e($_title) ?></h1>
    </div>  
    <div class="col-md-4">
        <small>atualização automática a cada 1 minuto</small>
    </div>
    <div id="pricePainel" class="col-md-12" style="min-height: 141px;">        
        <span style="position: absolute;top:45%;left:45%"><i class="fa fa-refresh fa-spin"></i> Carregando..</span>
    </div>
    <div class="col-md-6 card" style="margin-bottom: 0px; margin-top: 18px" >
        <div class="card-title" style="margin-bottom: 0px;">Índice de preços BTC/USD e  BTC/BRL <small>O preço BRL é convertido em USD</small></div>
        <div id="chart_media" style="height: 300px"></div>
    </div>
    <div class="col-md-6 card" style="margin-bottom: 0px; margin-top: 18px ">
        <div class="card-title " style="margin-bottom: 0px;" ><span>Volume 24h Mercado BTC/BRL:  <span id="text_volume_brl" style="color: #9d58b0;"></span> </span></div>
        <div id="chart_volume_sum" style="height: 300px"></div>
    </div>
    <div class="col-md-6 card" style="margin-bottom: 0px;  margin-top: 18px;padding: 0;">
        <div style="margin-bottom: 0px;margin-left: 10px">
            <div class="row">
                <div class="col-5 text-right">
                    <div class="card-title">Mercado BTC/BRL </div>
                </div>
                <div class="col-7">
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle text_frame_brl"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            MercadoBitcoin
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" class="value_frame_brl" data-value="FOXBIT:BTCBRL">FoxBit</a></li>
                            <li><a href="javascript:void(0)" class="value_frame_brl" data-value="MERCADO:BTCBRL">MercadoBitcoin</a></li>
                            <li><a href="javascript:void(0)"  class="value_frame_brl" data-value="BTCYOU:BTCBRL">BitcoinToYou</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <iframe  id="frame_market_brl" src="<?= getUrlTradeView("MERCADO:BTCBRL") ?>" style="height: 400px;border: none;"></iframe>
    </div>
    <div class="col-md-6 card" style="margin-bottom: 0px;  margin-top: 18px;padding: 0;">
        <div style="margin-bottom: 0px;margin-left: 10px">
            <div class="row">
                <div class="col-5 text-right">
                    <div class="card-title">Mercado  BTC/USD </div>
                </div>
                <div class="col-7">
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle text_frame_usd"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Bitfinex
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" class="value_frame_usd" data-value="BITFINEX:BTCUSD">Bitfinex</a></li>
                            <li><a href="javascript:void(0)" class="value_frame_usd" data-value="BINANCE:BTCUSDT">Binance</a></li>
                            <li><a href="javascript:void(0)"  class="value_frame_usd" data-value="BITSTAMP:BTCUSD">Bitstamp</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <iframe  id="frame_market_usd" src="<?= getUrlTradeView("BITFINEX:BTCUSD") ?>" style="height: 400px;border: none;"></iframe>
    </div>
<!--    <div class="col-md-12 text-center" style="margin-top: 10px;margin-bottom: -10px;overflow-x: auto">
         Bitcoadz.io - Ad Display Code 
        <div id="data_19115"></div><script data-cfasync="false" async type="text/javascript" src="//www.bitcoadz.io/display/items.php?19115&35261&468&60&1&0&0&0"></script>
         Bitcoadz.io - Ad Display Code 
    </div>-->
    <div class="col-md-6 card" style="margin-bottom: 0px;  margin-top: 18px">
        <div class="card-title" style="margin-bottom: 0px;">Preço BTC/BRL por Exchange</div>
        <div id="chart_price_brl" style="height: 300px"></div>
    </div>
    <div class="col-md-6 card" style="margin-bottom: 0px; margin-top: 18px ">       
        <div class="card-title" style="margin-bottom: 0px;"> Preço BTC/USD por Exchange</div>
        <div id="chart_price_usd" style="height: 300px"></div>
    </div>
    <div class="col-md-6 card" style="margin-bottom: 0px;  margin-top: 18px">       
        <div class="card-title" style="margin-bottom: 0px;">Volume 24h BTC/BRL por Exchange</div>
        <div id="chart_volume_brl" style="height: 300px"></div>
    </div>
    <div class="col-md-6 card" style="margin-bottom: 0px; margin-top: 18px ">       
        <div class="card-title" style="margin-bottom: 0px;">Volume 24h BTC/USD por Exchange</div>
        <div id="chart_volume_usd" style="height: 300px"></div>
    </div>
    <div class="col-md-10" style="margin-top: 20px">
<!--        <div class="row">
            <div class="col-md-12 text-center" style="margin-top: 0px;margin-bottom: 0px;overflow-x: auto">
                 Bitcoadz.io - Ad Display Code 
                <div id="data_19116"></div><script data-cfasync="false" async type="text/javascript" src="//www.bitcoadz.io/display/items.php?19116&35261&468&60&1&0&0&0"></script>
                 Bitcoadz.io - Ad Display Code 
            </div>
        </div>-->
        <div class="card" style="margin: 0px;">
            <div class="card-body" style="padding:0;margin-left: 10px;margin-right: 10px">
                <div id="tableContentBRL">

                </div>
            </div>
        </div>        
        <div class="card">
            <div class="card-body" style="padding:0;margin-left: 10px;margin-right: 10px">
                <div id="tableContentUSD">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 card" style="margin-bottom: 0px;  margin-top: 18px">       
                <div class="card-title" style="margin-bottom: 0px;">Volume 24h BTC/BRL por Exchange</div>
                <div style="height: 400px;width: 100%;" id="pie_exchanges_brl"></div>
            </div>
            <div class="col-md-6 card" style="margin-bottom: 0px;  margin-top: 18px">       
                <div class="card-title" style="margin-bottom: 0px;">Volume 24h BTC/USD por Exchange</div>
                <div style="height: 400px;width: 100%;" id="pie_exchanges_usd"></div>
            </div>
        </div>
    </div>    
    <?php
    if (!DEBUG) {
        require __DIR__ . '/../inc/ads_lado.inc.php';
    }
    ?>
</div>
<script src="/assets/js/plugins/echarts/echarts-en.min.js"></script>