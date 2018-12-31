<?php
$_title = _e("Comparar Crescimento das Criptomoedas");
$_meta_description = _e("Compare o histórico das criptomoedas, porcentagem de crescimento do preço e market cap");
$_css[] = "/assets/css/dark.css";

    if (!DEBUG) {
        require __DIR__ . '/../inc/ads.inc.php';
    }
    ?>
<div class="row">
    <div class="col-lg-2 col-md-2 col-sm-12"  style="margin-top: 15px;min-width: 150px;">

        <div class="form-group">
            <label class="label-control">Start Date</label>
            <input type="text" class="form-control datetimepicker"  id="date_start" value=""/>
        </div>        
        <div class="dropdown go_selectbox">
            <button class="btn btn-primary btn-block dropdown-toggle go_selectbox_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= _e('Add Coin'); ?>
            </button>
            <div class="dropdown-menu ">
                <div style="padding: 10px">
                    <input type="text"   class="form-control go_selectbox_input"  placeholder="buscar"/>
                </div>
                <div class="opts">
                </div>
            </div>
        </div>
        <div>
            Selected Coins
            <?php
            foreach ($input_coins as $coin) {
                echo '
                 <div class="btn-group" style="margin: 2px;width: 100%;">
                <button class="btn btn-white  btn-sm"  style="width: 100%;">
              <img style="width:25px;padding-right:5px" src="/assets/img/coin/' . $coin . '.png" />  ' . $coin . '
            </button>
             <button class="btn btn-white btn-sm" onclick="removeCoin(\'' . $coin . '\')" type="button" >X</button></div>';
            }
            ?>
        </div>
    </div>
    <div class="col-md-8">
        <?= _e('Comparação porcentagem crescimento preços USD'); ?>
        <div id="chart_price"  style="width: 100%;min-height:400px;"></div>       
        <hr/>
        <div id="history_change"></div>
            <hr/>
        <?= _e('Marketcap USD'); ?>
        <div id="chart_marketcap" style="width: 100%;min-height:400px;"></div>
    </div>    
   <?php 
    if (!DEBUG) {
        require __DIR__ . '/../inc/ads_lado.inc.php';
    }
?>
</div>

<div class="text-center" style="margin-top: 30px">
    <?= _e('Fonte dos dados:') ?> <a href="https://coinmarketcap.com" target="_blank">CoinMarketCap</a>
</div>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="/assets/js/plugins/moment.min.js"></script>
<script src="/assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
<script src="/assets/js/plugins/echarts/echarts-en.min.js"></script>
<script>
    $('.datetimepicker').datetimepicker({
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        },
        format: 'YYYY-MM-DD'
    });
    window.onload = function () {
        $("#history_change").load(siteUrl('/compare/change/?coins=<?= isset($_GET['coins']) ? $_GET['coins'] : '' ?>'));
        loadChart();
    };
    var price_all = {};

    function getOption(functionFormat) {
        //volume
        option = {
            backgroundColor: '#21202D',
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    animation: false
                },
                formatter: functionFormat
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'time',
                splitLine: {
                    show: false
                },
                axisLine: {lineStyle: {color: '#8392A5'}}
            },
            yAxis: {
                type: 'value',
                splitLine: {
                    show: false
                },
                scale: true,
                axisLine: {lineStyle: {color: '#8392A5'}}
            },
            grid: {
                bottom: 80,
                left: '2%',
                right: '8%',
                containLabel: true
            },
            dataZoom: [{
                    start: 0,
                    end: 100,
                    textStyle: {
                        color: '#8392A5'
                    },
                    handleIcon: 'M10.7,11.9v-1.3H9.3v1.3c-4.9,0.3-8.8,4.4-8.8,9.4c0,5,3.9,9.1,8.8,9.4v1.3h1.3v-1.3c4.9-0.3,8.8-4.4,8.8-9.4C19.5,16.3,15.6,12.2,10.7,11.9z M13.3,24.4H6.7V23h6.6V24.4z M13.3,19.6H6.7v-1.4h6.6V19.6z',
                    handleSize: '80%',
                    dataBackground: {
                        areaStyle: {
                            color: '#8392A5'
                        },
                        lineStyle: {
                            opacity: 0.8,
                            color: '#8392A5'
                        }
                    },
                    handleStyle: {
                        color: '#fff',
                        shadowBlur: 3,
                        shadowColor: 'rgba(0, 0, 0, 0.6)',
                        shadowOffsetX: 2,
                        shadowOffsetY: 2
                    }
                }, {
                    type: 'inside'
                }],
            series: []
        };
        return option;
    }

    var chart_price = echarts.init(document.getElementById('chart_price'));
    function formatTooltipPrice(params) {
        console.log(params);
        var html = '';

        var date_val = params[0]['data'][0];
        html += date_val + '<br/>';
        for (var i in params) {
            var p = params[i];
            html += p.marker + ' ' + p.seriesName + ': ' + formatCoin(p.data[1]) + ' % | ' + price_all[date_val][p.seriesName] + ' USD <br/>';
        }
        return html;
    }
    var opt_price = getOption(formatTooltipPrice);
    chart_price.setOption(opt_price);
//    chart_price.setOption({
//        dataZoom: [{
//                start: 20,
//                end: 100
//            }]
//    });

//marketcap
    var chart_marketcap = echarts.init(document.getElementById('chart_marketcap'));

    function formatTooltipMarketcap(params) {
        console.log(params);
        var html = '';

        var date_val = params[0]['data'][0];
        html += date_val + '<br/>';
        for (var i in params) {
            var p = params[i];
            html += p.marker + ' ' + p.seriesName + ': ' + formatCoin(p.data[1]) + '  USD <br/>';
        }
        return html;
    }
    var opt_marketcap = getOption(formatTooltipMarketcap);
    chart_marketcap.setOption(opt_marketcap);
//    chart_marketcap.setOption({
//        dataZoom: [{
//                start: 20,
//                end: 100
//            }]
//    });

    function loadChart() {

        console.log('entrou');

        $.getJSON(siteUrl('/compare/data/?coins=<?= isset($_GET['coins']) ? $_GET['coins'] : '' ?>&date=<?= isset($_GET['date']) ? $_GET['date'] : '' ?>'), function (json) {

            chart_marketcap.setOption({
                legend: {
                    top: '4%',
                    inactiveColor: '#777',
                    icon: 'circle',
                    textStyle: {
                        color: '#8392A5'
                    },
                    data: json.marketcap.legend

                },
                series: json.marketcap.series
            });

            $("#date_start").val(json.price.series[0]['data'][0][0]);

            chart_price.setOption({
                legend: {
                    top: '4%',
                    inactiveColor: '#777',
                    icon: 'circle',
                    textStyle: {
                        color: '#8392A5'
                    },
                    data: json.price.legend

                },
                series: json.price.series
            });
            price_all = json.price_date;
        });

        $(window).on('resize', function () {
            if (chart_price != null && chart_price != undefined) {
                chart_price.resize();
            }
        });

        $(window).on('resize', function () {
            if (chart_marketcap != null && chart_marketcap != undefined) {
                chart_marketcap.resize();
            }
        });
    }
    function formatCoin(val, decimal, currency) {
        if (!decimal) {
            decimal = 2;
        }
        if (!currency) {
            currency = '';
        }
        var n = parseFloat(val);
        return currency + " " + n.toFixed(decimal).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }



    var input_coins = <?= json_encode($input_coins) ?>;
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


    $("#date_start").on('blur', function () {
        window.location = getUrl();
    });

    function getUrl() {
        var date = $("#date_start").val();
        var url = '?coins=' + input_coins.join(',') + "&date=" + date;
        return url;
    }
</script>
</body>
</html>