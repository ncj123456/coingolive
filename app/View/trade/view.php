<?php
$_title = 'Trade';
$_css[] = "/assets/css/dark.css";
?>
<div id="chart_price"  style="width: 100%;height:80%; position: absolute; top:130px;left:0"></div>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="https://momentjs.com/downloads/moment-timezone-with-data.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script src="/assets/js/plugins/echarts/echarts-en.min.js"></script>

<script>


    $.getJSON(siteUrl('/trade/data/'), function (json) {
        renderChart(json);
    });
    function renderChart(rawData) {
        var green = "#85c549";
        var red = "#cc5878";
        var last_line = rawData[rawData.length - 1];
        var last_close = last_line[2];
        var last_open = last_line[1];
        var last_value_color = green;
        if (last_close < last_open) {
            last_value_color = red;
        }
        var dates = rawData.map(function (item) {
            return item[0];
        });
        var data = rawData.map(function (item) {
            return [+item[1], +item[2], +item[3], +item[4]];
        });
        var option = {
            backgroundColor: '#21202D',
            legend: {
                data: ['K'],
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
                left: 80,
                right: 80,
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
                    name: '日K',
                    data: data,
                    barWidth: '60%',
                    itemStyle: {
                        normal: {
                            color0: '#cc5878',
                            color: '#85c549',
                            borderColor0: '#cc5878',
                            borderColor: '#85c549'
                        }
                    },
                    markLine: {
//                        silent: true,
                        symbol: 'none',
                        lineStyle: {
                            color: last_value_color
                        },
                        data: [
                            {
                                yAxis: last_close
                            }
                        ]
                    },
                    markPoint: {
                        symbol:'pin',
                        symbolSize:1,
                        data: [
                            {
                                name: 'highest value',
                                type: 'max',
                                valueDim: 'highest',
                                 label:{
                                    position: ['-20', '-15']
                                },
                                itemStyle:{
                                    color:"#e6e6e6"
                                }
                            },
                            {
                                name: 'lowest value',
                                type: 'min',
                                valueDim: 'lowest',
                                label:{
                                     position: ['-20', '7']
                                },
                                itemStyle:{
                                   color:"#e6e6e6"
                                }
                            }
                        ]
                    }

                }
            ]
        };
        var chart_price = echarts.init(document.getElementById('chart_price'));
        chart_price.setOption(option);
    }
</script>