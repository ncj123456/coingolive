chart();
function chart() {

    $.getJSON(siteUrl('/coin-suport/data/' + input_coin), function (json) {

        var rawData = json.data;
        var dates = rawData.map(function (item) {
            return item[0];
        });
        var data = rawData.map(function (item) {
            return [+item[1], +item[2], +item[3], +item[4]];
        });
        var option = {
            backgroundColor: '#21202D',
            legend: {
                data: ['日K', 'MA5', 'MA10', 'MA20', 'MA30'],
                inactiveColor: '#777',
                textStyle: {
                    color: '#fff'
                }
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    animation: false,
                    type: 'cross',
                    lineStyle: {
                        color: '#376df4',
                        width: 2,
                        opacity: 1
                    }
                }
            },
            xAxis: {
                type: 'category',
                data: dates,
                axisLine: {lineStyle: {color: '#8392A5'}}
            },
            yAxis: {
                scale: true,
                axisLine: {lineStyle: {color: '#8392A5'}},
                splitLine: {show: false}
            },
            grid: {
                bottom: 80
            },
            dataZoom: [{
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
            animation: false,
            series: [
                {
                    type: 'candlestick',
                    name: 'Open',
                    data: data,
                    markLine: {
                        silent: true,
                        symbol: 'circle',
                        data: json.suport
                    },
                    itemStyle: {
                        normal: {
                            color0: '#FD1050',
                            color: '#0CF49B',
                            borderColor0: '#FD1050',
                            borderColor: '#0CF49B'
                        }
                    }
                }
            ]
        };
        chart_suport = echarts.init(document.getElementById('chart_suport'));
        chart_suport.setOption(option);

    });
}
//
//
//line_option = {
////    backgroundColor: '#21202D',
//    tooltip: {
//        trigger: 'axis'
//    },
//    toolbox: {
//        feature: {
//            saveAsImage: {}
//        }
//    },
//    xAxis: {
//        type: 'time',
//        splitLine: {
//            show: false
//        },
//        axisLine: {lineStyle: {color: '#656565'}}
//    },
//    yAxis: {
//        type: 'value',
//        inverse: true,
//        min: 1,
//        splitLine: {
//            show: false
//        },
////        scale: true,
//        axisLine: {lineStyle: {color: '#656565'}}
//    },
//    legend: {
//        orient: 'horizontal',
//    },
//    grid: {
//        bottom: 40,
//        left: '2%',
//        right: '8%',
//        containLabel: true
//    },
//    dataZoom: [{
////            start: 0,
////            end: 100,
//            textStyle: {
////                color: '#8392A5'
//            },
//            handleIcon: 'M10.7,11.9v-1.3H9.3v1.3c-4.9,0.3-8.8,4.4-8.8,9.4c0,5,3.9,9.1,8.8,9.4v1.3h1.3v-1.3c4.9-0.3,8.8-4.4,8.8-9.4C19.5,16.3,15.6,12.2,10.7,11.9z M13.3,24.4H6.7V23h6.6V24.4z M13.3,19.6H6.7v-1.4h6.6V19.6z',
//            handleSize: '80%',
//            dataBackground: {
//                areaStyle: {
////                    color: '#8392A5'
//                },
//                lineStyle: {
//                    opacity: 0.8,
////                    color: '#8392A5'
//                }
//            },
//            handleStyle: {
////                color: '#fff',
//                shadowBlur: 3,
//                shadowColor: 'rgba(0, 0, 0, 0.6)',
//                shadowOffsetX: 2,
//                shadowOffsetY: 2
//            }
//        }, {
//            type: 'inside'
//        }],
//    series: []
//};
//
//function loadChartRank() {
//    chart_rank = echarts.init(document.getElementById('chart_rank'));
//    chart_rank.setOption(line_option);
//
//    $.getJSON(siteUrl('/coin-suport/data/' + input_coin), function (json) {
//        chart_rank.setOption({
////            tooltip: {
////                formatter: function (params) {
////                    return formatTooltip(params, 'USD');
////                }
////            },
//            legend: {
//                top: '4%',
////            inactiveColor: '#777',
//                icon: 'circle',
//                textStyle: {
////                color: '#8392A5'
//                },
//                data: json.legend,
////                selected: {
////                    // selected'series 1'
////                    'FlowBTC': false,
////                    // unselected'series 2'
////                    'OmniTrade': false,
////                    'BitcoinToYou': false,
////                }
//
//            },
//            series: json.series
//        });
//    });
//
//}
//$(window).on('resize', function () {
//    if (chart_rank != null && chart_rank != undefined) {
//        chart_rank.resize();
//    }
//});
//loadChartRank();