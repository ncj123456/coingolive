<div  style="overflow-x: auto" >
    <table class="table table-striped table-nowrap">
        <thead>

            <tr>  
                <th>
                    <?php
                    $favorite_check = "";
                    if (isset($_GET['favorite']) && $_GET['favorite'] == "true") {
                        $favorite_check = "check-";
                    }
                    ?>
                    <i  title="Filtrar Favoritos" onclick="favoriteFilter()"  class="fa fa-<?= $favorite_check; ?>square-o" style="cursor:pointer"></i> 
                </th>
                <?php
                $table_head = [
                    'name' => _e('Moeda'),
                    'rank' => _e('Rank'),
                    'price_moeda' => _e('Preço Atual'),
                    'high_price' => _e('Alta Histórica'),
                    'growth_high' => _e('% Para Alta'),
                    'high_date' => _e('Data Alta Histórica'),
                    'porc_high' => _e('Posição Preço Atual'),
                    'volume_24h_moeda' => _e('Volume 24h'),
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
            
            foreach ($data as $d) {

                $format_porc = function($porc, $price, $moeda_char,$desc = '') {
                    if ($porc < 0) {
                        $class_percent = 'danger';
                    } elseif ($porc > 0) {
                        $class_percent = 'success';
                    } else {
                        $class_percent = 'default';
                    }
                    $tooltip = '';
                    if ($price) {
                        $tooltip = 'data-toggle="tooltip" data-html="true" title="' . $desc . '<br>'.$moeda_char . decimal($price, 2, true) . ' "';
                    }
                    return '<span style="font-size:13px;width:100%;border-radius: 3px;" ' . $tooltip . '  class="badge badge-' . $class_percent . '">' . decimal($porc, 2) . '%</span>';
                };

                $favorite = '-o';
                if ($d['favorite'] === $d['id_externo']) {
                    $favorite = '';
                }

                $porc_position = ($d['high_price'] - $d['price_moeda'] ) * 100 / $d['high_price'];

                $moeda_char = $d['moeda_char'];
                if ($d['moeda_char'] == 'BTC') {
                    $moeda_char = "<span class='icon-moeda-char'><i class='fa fa-btc'></i> </span>";
                }
               $color_vol24 = volumeColor($d['volume_24h_moeda']);         
                ?>
                <tr >
                    <td class="text-left padding-table-3px" colspan="2"> 
                        <a href="javascript:addFavorite('<?= $d['id_externo'] ?>')" style="margin-right:10px;">
                            <i class="fa fa-star<?= $favorite ?>" id="user_favorite_<?= $d['id_externo'] ?>"></i>
                        </a>
                        <!--<a href="<?= siteUrl('/compare/coin/?coins=' . $d['id_externo']) ?>">-->
                            <img style="margin-right:10px;    max-height: 20px;" src="/assets/img/coin/<?= $d['id_externo'] ?>.png">
                            <?= $d['symbol'] ?>
                            <!--<small><?= $d['symbol'] ?></small>-->
                        <!--</a>-->
                    </td>
                    <td class="text-center padding-table-3px"><?= $d['rank']; ?></td>
                    <td class="text-right" style="padding-left:3px"><?= $moeda_char ?> <?= decimal($d['price_moeda'], 2, true); ?></td>
                    <td class="text-right" style="padding-left:3px"><?= $moeda_char ?><?= decimal($d['high_price'], 2, true); ?></td>
                    <td class="text-center padding-table-3px">
                    <?= $format_porc($d['growth_high'], $d['high_price'],$moeda_char, $d['high_date']); ?>
                    </td>
                    <td class="text-center padding-table-3px"><?= $d['high_date'] ?> 
                        <small><?= dateDesc($d['high_date']) ?></small>
                    </td>
                    <td class="text-center"data-toggle="tooltip" title='
                        <?= $d['symbol'] ?><br/> 
                        <?= decimal($d['porc_high'], 2); ?>%<br/>
                        ' data-html='true'>
                        <div class="progress progress-line-primary ">
                            <div class="progress-bar progress-bar-primary" role="progressbar" style="width: <?= round(100 + $d['porc_high'], 2) ?>%;">
                            </div>
                        </div>
                    </td>
                    <td class="text-center"  style="background-color:  <?= $color_vol24 ?>;"><span<?= tooltip($moeda_char . decimal($d['volume_24h_moeda'], 0)) ?>>
                                <?= $moeda_char ?><?= numFormat($d['volume_24h_moeda'], 2); ?></span></td>
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
    if (count($data) >= $limit || $page > 0) {
        ?>
        <div class="col-md-4 ml-auto  text-right " style="margin-bottom:15px">
            <?php
            $disabledPrev = '';
            $disabledNext = '';
            if ($page == 0) {
                $disabledPrev = 'disabled';
            }
            if (count($data) < $limit) {
                $disabledNext = 'disabled';
            }
            ?>
            <button type="button" onclick="loadPage(<?= $page - 1 ?>)" class="btn btn-primary btn-round" <?= $disabledPrev ?>>< <?= _e('Anterior') ?></button>

            <button type="button" onclick="loadPage(<?= $page + 1 ?>)" class="btn btn-primary btn-round" <?= $disabledNext ?>><?= _e('Próximo') ?> > </button>

        </div>
    <?php } ?>
</div>
<script>
    $('.column-order').on('click', function () {
        var name = $(this).data('name');
        var order = $(this).data('order');

        $("#order_name").val(name);
        $("#order_type").val(order);

        loadPage();
    });

    $("#min_rank").val('<?= $min_rank; ?>');
    $("#max_rank").val('<?= $max_rank; ?>');

    $('[data-toggle="tooltip"]').tooltip();

</script>
