<h2 class="h3">Exchanges <?= $moeda ?></h2>
<div  style="overflow-x: auto" >
    <table class="table table-striped table-nowrap">
        <thead>
            <tr>  
                <?php
                $table_head = [
                    'exchange' => _e('Exchange'),
                    'last_price' => _e('Preço Atual'),
                    'bid_price' => _e('Compra'),
                    'ask_price' => _e('Venda'),
                    'high_price' => _e('Máximo'),
                    'low_price' => _e('Mínimo'),
                    'volume' => _e('Volume 24h'),
                ];
                foreach ($table_head as $col_name => $col_desc) {
                    $class_order = '';
                    $new_order = 'desc';

                    if ($col_name == $column) {

                        if ($order == 'desc') {
                            $class_order = '-down';
                            $new_order = 'asc';
                        } elseif ($order == 'asc') {
                            $class_order = '-up';
                            $new_order = 'desc';
                        }
                    }
                    ?>
                    <th scope="col" data-order='<?= $new_order ?>' data-name='<?= $col_name; ?>' class="text-left column-order">
                        <?= $col_desc ?><i class="fa fa-sort<?= $class_order ?>"></i>
                    </th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $last_price = [];
            $bid_price = [];
            $ask_price = [];
            $high_price = [];
            $low_price = [];
            $volume = [];

            foreach ($data as $d) {
                $last_price[] = $d['last_price'];
                $bid_price[] = $d['bid_price'];
                $ask_price[] = $d['ask_price'];
                $high_price[] = $d['high_price'];
                $low_price[] = $d['low_price'];
                $volume[] = $d['volume'];
            }

            $chart_volume = [];
            foreach ($data as $d) {
                $chart_volume[$d['exchange']] = [
                    'name' => $d['exchange'],
                    'value' => round($d['volume'],2),
                    'itemStyle' => [
                        'color' => $d['color']
                    ]
                ];
                //min max
                //last price
                $class_last_price = '';
                if ($d['last_price'] === max($last_price)) {
                    $class_last_price = 'text-success';
                } elseif ($d['last_price'] === min($last_price)) {
                    $class_last_price = 'text-danger';
                }

                //bid price                
                $class_bid_price = '';
                if ($d['bid_price'] === max($bid_price)) {
                    $class_bid_price = 'text-success';
                } elseif ($d['bid_price'] === min($bid_price)) {
                    $class_bid_price = 'text-danger';
                }

                // ask  price
                $class_ask_price = '';
                if ($d['ask_price'] === max($ask_price)) {
                    $class_ask_price = 'text-success';
                } elseif ($d['ask_price'] === min($ask_price)) {
                    $class_ask_price = 'text-danger';
                }

                // high  price
                $class_high_price = '';
                if ($d['high_price'] === max($high_price)) {
                    $class_high_price = 'text-success';
                } elseif ($d['high_price'] === min($high_price)) {
                    $class_high_price = 'text-danger';
                }
                $class_low_price = '';
                $class_volume = '';

                // low  price
                $class_low_price = '';
                if ($d['low_price'] === max($low_price)) {
                    $class_low_price = 'text-success';
                } elseif ($d['low_price'] === min($low_price)) {
                    $class_low_price = 'text-danger';
                }

                // volume
                $class_volume = '';
                if ($d['volume'] === max($volume)) {
                    $class_volume = 'text-success';
                } elseif ($d['volume'] === min($volume)) {
                    $class_volume = 'text-danger';
                }
                ?>
                <tr >
                    <td class="text-left padding-table-3px"><i class="fa fa-circle icon-fa" style="color:<?= $d['color'] ?>"></i> <?= $d['exchange']; ?></td>
                    <td class="text-right <?= $class_last_price ?>" style="padding-left:3px">
                        <?= decimal($d['last_price'], 2); ?> <small><?= $d['moeda_base']; ?></small> 
                    </td>
                    <td class="text-right  <?= $class_bid_price ?>" style="padding-left:3px">
                        <?= decimal($d['bid_price'], 2); ?> <small><?= $d['moeda_base']; ?></small>
                    </td>
                    <td class="text-right  <?= $class_ask_price ?>" style="padding-left:3px">
                        <?= decimal($d['ask_price'], 2); ?> <small><?= $d['moeda_base']; ?></small> 
                    </td>
                    <td class="text-right  <?= $class_high_price ?>" style="padding-left:3px"> 
                        <?= decimal($d['high_price'], 2); ?> <small><?= $d['moeda_base']; ?></small>
                    </td>
                    <td class="text-right  <?= $class_low_price ?>" style="padding-left:3px">
                        <?= decimal($d['low_price'], 2); ?> <small><?= $d['moeda_base']; ?></small> 
                    </td>
                    <td class="text-right  <?= $class_volume ?>" style="padding-left:3px">
                        <span class="icon-moeda-char"><i class="fa fa-btc"></i></span> <?= decimal($d['volume'], 2); ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="row" style="padding:20px">
    <?php
    if (isset($data[0]['data_alteracao'])) {
        ?>
        <div class="col-md-4  ">
            <?= _e('Ultima atualização') . ' ' . dateDesc($data[0]['data_alteracao']) ?>
        </div>
        <?php
    }
    ?>

</div>
<script>

    $('.column-order').on('click', function () {
        var name = $(this).data('name');
        var order = $(this).data('order');

        $("#order_name").val(name);
        $("#order_type").val(order);

        loadPage();
    });

    $('[data-toggle="tooltip"]').tooltip();

    var pie_exchanges_<?= strtolower($moeda) ?> = echarts.init(document.getElementById('pie_exchanges_<?= strtolower($moeda) ?>'));

    option_<?= strtolower($moeda) ?> = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            x: 'center',
            y: 'top',
            top: 20,
            data: <?= json_encode(array_keys($chart_volume)); ?>
        },
        series: [
            {
                name: 'Volume BTC',
                type: 'pie',
                radius: '55%',
                center: ['50%', '60%'],
                data: <?= json_encode(array_values($chart_volume)) ?>,
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };
    pie_exchanges_<?= strtolower($moeda) ?>.setOption(option_<?= strtolower($moeda) ?>);

    $(window).on('resize', function () {
        pie_exchanges_<?= strtolower($moeda) ?>.resize();
    });

</script>
