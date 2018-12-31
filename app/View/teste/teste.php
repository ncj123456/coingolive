<?php
$_title = "Teste";
?>
<script src="/assets/js/plugins/echarts/echarts-en.min.js"></script>
<div class="col-md-8">
    <div id="chart_volume" style="width: 100%;min-height:400px;"></div>
</div>
<script>

    option = {
        animation: false,
        backgroundColor: '#21202D',
        tooltip: {
            trigger: 'axis',
//            formatter: function (params) {
//                params = params[0];
//                var date = new Date(params.name);
//                return date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' : ' + params.value[1];
//            },
            axisPointer: {
                animation: false
            }
        },
        toolbox: {
            feature: {
                saveAsImage: {}
            }
        },
        xAxis: {
            type: 'category',
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
            axisLine: {lineStyle: {color: '#8392A5'}}
        },
        grid: {
            bottom: 80,     
            left:'2%',
            right:'8%',
            containLabel: true
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
        series: []
    };
//    setInterval(function () {
//
//        for (var i = 0; i < 5; i++) {
//            data.shift();
//            data.push(randomData());
//        }
//
//        myChart.setOption({
//            series: [{
//                    data: data
//                }]
//        });
//    }, 1000);

    // use configuration item and data specified to show chart

    var chart_volume = echarts.init(document.getElementById('chart_volume'));
    chart_volume.setOption(option);

    window.onload = function () {
        $.getJSON(siteUrl('/compare/volume/'), function (json) {
            console.log(json);
            chart_volume.setOption({
                legend: {
                    top: '4%',
                    inactiveColor: '#777',
                    icon: 'circle',
                    textStyle: {
                        color: '#8392A5'
                    },
                    data: json.legend

                },
                series: json.series
            });
        });


        $(window).on('resize', function () {
            if (chart_volume != null && chart_volume != undefined) {
                chart_volume.resize();
            }
        });
    }

</script>