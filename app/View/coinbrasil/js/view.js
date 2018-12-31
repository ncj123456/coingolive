var chart_price = {};
var chart_volume = {};
var chart_media = {};
var chart_volume_sum = {};

function loadPage() {

    var name = $("#order_name").val();
    var order = $("#order_type").val();

    var url = '/bitcoin/brasil/data/?moeda=BRL&name=' + name +
            '&order=' + order + '&cache=true';
    $('#tableContentBRL').load(encodeURI(siteUrl(url)));

    var url = '/bitcoin/brasil/data/?moeda=USD&name=' + name +
            '&order=' + order + '&cache=true';
    $('#tableContentUSD').load(encodeURI(siteUrl(url)));
}


setInterval(function () {
    loadPrice();
    loadChartMedia();
    loadChartVolumeSum();
    generateChart('BRL');
    generateChart('USD');
    loadPage();

}, 60000);


function loadPrice() {
    $('#pricePainel').load(siteUrl('/bitcoin/brasil/price/?cache=true'));
}

line_option = {
//    backgroundColor: '#21202D',
    tooltip: {
        trigger: 'axis'
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
        axisLine: {lineStyle: {color: '#656565'}}
    },
    yAxis: {
        type: 'value',
        splitLine: {
            show: false
        },
        scale: true,
        axisLine: {lineStyle: {color: '#656565'}}
    },
    legend: {
        orient: 'horizontal',
    },
    grid: {
        bottom: 40,
        left: '2%',
        right: '8%',
        containLabel: true
    },
    dataZoom: [{
//            start: 0,
//            end: 100,
            textStyle: {
//                color: '#8392A5'
            },
            handleIcon: 'M10.7,11.9v-1.3H9.3v1.3c-4.9,0.3-8.8,4.4-8.8,9.4c0,5,3.9,9.1,8.8,9.4v1.3h1.3v-1.3c4.9-0.3,8.8-4.4,8.8-9.4C19.5,16.3,15.6,12.2,10.7,11.9z M13.3,24.4H6.7V23h6.6V24.4z M13.3,19.6H6.7v-1.4h6.6V19.6z',
            handleSize: '80%',
            dataBackground: {
                areaStyle: {
//                    color: '#8392A5'
                },
                lineStyle: {
                    opacity: 0.8,
//                    color: '#8392A5'
                }
            },
            handleStyle: {
//                color: '#fff',
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

function generateChart(moeda_base) {

    chart_price[moeda_base] = echarts.init(document.getElementById('chart_price_' + moeda_base.toLowerCase()));
    chart_price[moeda_base].setOption(line_option);

    chart_volume[moeda_base] = echarts.init(document.getElementById('chart_volume_' + moeda_base.toLowerCase()));
    chart_volume[moeda_base].setOption(line_option);


    $.getJSON(siteUrl('/bitcoin/brasil/series/?moeda=' + moeda_base + '&cache=true'), function (json) {
        chart_price[moeda_base].setOption({
            tooltip: {
                formatter: function (params) {
                    return formatTooltip(params, moeda_base);
                }
            },
            legend: {
                top: '4%',
//            inactiveColor: '#777',
                icon: 'circle',
                textStyle: {
//                color: '#8392A5'
                },
                data: json.price.legend,
//                selected: {
//                    // selected'series 1'
//                    'FlowBTC': false,
//                    // unselected'series 2'
//                    'OmniTrade': false,
//                    'BitcoinToYou': false,
//                }

            },
            series: json.price.series
        });

        //Volume
        chart_volume[moeda_base].setOption({
            tooltip: {
                formatter: function (params) {
                    return formatTooltip(params, 'BTC');
                }
            },
            legend: {
                top: '4%',
//            inactiveColor: '#777',
                icon: 'circle',
                textStyle: {
//                color: '#8392A5'
                },
                data: json.volume.legend

            },
            series: json.volume.series
        });
    });
}

function loadChartMedia() {
    chart_media = echarts.init(document.getElementById('chart_media'));
    chart_media.setOption(line_option);


    $.getJSON(siteUrl('/bitcoin/brasil/media/?cache=true'), function (json) {
        chart_media.setOption({
            tooltip: {
                formatter: function (params) {
                    return formatTooltip(params, 'USD');
                }
            },
            legend: {
                top: '4%',
//            inactiveColor: '#777',
                icon: 'circle',
                textStyle: {
//                color: '#8392A5'
                },
                data: json.legend,
//                selected: {
//                    // selected'series 1'
//                    'FlowBTC': false,
//                    // unselected'series 2'
//                    'OmniTrade': false,
//                    'BitcoinToYou': false,
//                }

            },
            series: json.series
        });
    });
}


function loadChartVolumeSum() {
    chart_volume_sum = echarts.init(document.getElementById('chart_volume_sum'));
    chart_volume_sum.setOption(line_option);



    $.getJSON(siteUrl('/bitcoin/brasil/volume/?cache=true'), function (json) {
        $("#text_volume_brl").text(json.last_volume + ' BTC');
        chart_volume_sum.setOption({
            tooltip: {
                formatter: function (params) {
                    return formatTooltip(params, 'BTC');
                }
            },
            legend: {
                top: '4%',
//            inactiveColor: '#777',
                icon: 'circle',
                textStyle: {
//                color: '#8392A5'
                },
                data: json.legend,
//                selected: {
//                    // selected'series 1'
//                    'FlowBTC': false,
//                    // unselected'series 2'
//                    'OmniTrade': false,
//                    'BitcoinToYou': false,
//                }

            },
            series: json.series
        });
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
    return currency + " " + n.toFixed(decimal).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
}

function formatTooltip(params, concat) {
    var html = '';

    var date_val = params[0]['data'][0];
    html += date_val + '<br/>';
    for (var i in params) {
        var p = params[i];
        html += p.marker + ' ' + p.seriesName + ': ' + formatCoin(p.data[1]) + ' ' + concat + ' <br/>';
    }
    return html;
}

$(".value_frame_brl").on('click', function () {
    var val = $(this).data('value');
    $("#frame_market_brl").attr('src', getUrlTradeView(val));
    $(".text_frame_brl").text($(this).text());
});

$(".value_frame_usd").on('click', function () {
    var val = $(this).data('value');
    $("#frame_market_usd").attr('src', getUrlTradeView(val));
    $(".text_frame_usd").text($(this).text());
});

function getUrlTradeView(name) {
    var url = 'https://br.tradingview.com/widgetembed/?symbol=' + name + '&interval=D&hidesidetoolbar=1&saveimage=1&toolbarbg=f1f3f6&studies=[]&theme=Light&style=1&timezone=Etc/UTC&studies_overrides={}&overrides={}&enabled_features=[]&disabled_features=[]&locale=br&utm_source=br.tradingview.com&utm_medium=widget_new&utm_campaign=chart&utm_term=' + name;
    return url;
}

$(window).on('resize', function () {
    chart_media.resize();
    chart_volume_sum.resize();

    for (var i in chart_price) {
        chart_price[i].resize();
    }
    for (var i in chart_volume) {
        chart_volume[i].resize();
    }
});


loadPrice();
loadChartVolumeSum();
loadChartMedia();
generateChart('BRL');
generateChart('USD');
loadPage();

$(window).on('topo.loaded', function () {
    $("#link_div_topo").css('position', 'fixed');
    $("#link_div_topo").attr('href', '#');
});
