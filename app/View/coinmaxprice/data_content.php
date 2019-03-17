<div style="overflow-x: auto" >
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
                    'rank' => _e('Rank'),
                    'name' => _e('Criptomoeda'),
                    'price_moeda' => _e('Preço Atual'),
                    'price_available_supply' => _e('Preço Máximo'),
                    'percent_available_supply' => _e('Crescimento'),
                    'volume_24h_moeda' => _e('Volume 24h'),
                    'percent_dominance' => _e('Market Cap'),
                    'available_supply' => _e('Available Supply'),
                    'max_supply' => _e('Limite'),
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
                $class = " table-success";
                $maximo = numFormat($d['max_supply'], 0);
                $txtMax = $maximo;
                $maxSymbol = $maximo . ' ' . $d['symbol'];
                $maxTooltip = tooltip(decimal($d['max_supply'], 0) . ' ' . $d['symbol']);
                $supplyTooltip = decimal($d['available_supply'], 0) . ' ' . $d['symbol'];

                if ($d['max_supply'] == 0) {
                    $maxTooltip = tooltip(_e('Não existe um limite máximo de fornecimento'));
                    $txtMax = '<i class="fa fa-close" style="color:#c5615d"></i>';
                    $class = "table-danger";
                }
//calculos
                $price_moeda = $d['price_moeda'];
                $available_supply = (float) $d['available_supply'];
                $market_cap_compare . "=" . $available_supply;

                if ($available_supply == 0) {
                    $max_price_moeda = 0;
                } else {
                    $max_price_moeda = $market_cap_compare / $available_supply;
                }


                if ($d['available_supply'] == 0) {
                    $percent_available_supply = 0;
                } else {
                    $percent_available_supply = round((($max_price_moeda / $d['price_moeda']) * 100 ) - 100);
                }



                if ($percent_available_supply < 0) {
                    $class_percent = 'danger';
                } elseif ($percent_available_supply > 0) {
                    $class_percent = 'warning';
                } else {
                    $class_percent = 'default';
                }

                $favorite = '-o';
                if ($d['favorite'] === $d['codigo']) {
                    $favorite = '';
                }

                $moeda_char = $d['moeda_char'];
                if ($d['moeda_char'] == 'BTC') {
                    $moeda_char = "<span class='icon-moeda-char'><i class='fa fa-btc'></i></span> ";
                }

                $color_vol24 = volumeColor($d['volume_24h_moeda']);

                $nameCoin = $d['name'] . ' (' . $d['symbol'] . ')';
                ?>
                <tr>
                    <td class="text-center" ><a href="javascript:addFavorite('<?= $d['codigo'] ?>')">
                            <i class="fa fa-star<?= $favorite ?>" id="user_favorite_<?= $d['codigo'] ?>"></i>
                        </a>
                    </td>
                    <td class="text-center"><?= $d['rank'] ?></td>
                    <td class="text-left"  style="min-width: 250px;"> 
                        <a href="<?= siteUrl('/coins/' . $d['codigo']) ?>/">
                            <img style="margin-right:10px;max-height: 20px;" alt="<?= $nameCoin ?>" title="<?= $nameCoin ?>" src="/assets/img/coin/<?= $d['codigo'] ?>.png">
                            <?= $d['name'] ?>
                            <small><?= $d['symbol'] ?></small>
                        </a>
                        <?= btnBuy($d['symbol']) ?>
                    </td>
                    <td class="text-right"><?= $moeda_char . decimal($price_moeda, 2, true) ?></td>
                    <td class="text-right"> <?= $moeda_char . decimal($max_price_moeda, 2, true) ?> </td>

                    <td class="text-right">
                        <span style="font-size:13px" class="badge badge-<?= $class_percent ?>"><?= decimal($percent_available_supply, 0) ?>%</span>
                    </td>

                    <td class="text-right"  style="background-color:  <?= $color_vol24 ?>;"> <?= $moeda_char . numFormat($d['volume_24h_moeda'], 2) ?> </td>
                    <td class="text-right" <?= tooltip(_e("Dominancia") . ': ' . decimalAuto($d['percent_dominance'], 2, 2) . ' %') ?> > 
                        <?= ($moeda_char . numFormat($d['market_cap_moeda'], 2)) ?>
                    </td>

                    <td class="text-right" <?= tooltip($supplyTooltip) ?>> <?= numFormat($d['available_supply'], 2) ?> </td>

                    <td class="<?= $class ?> text-center" <?= $maxTooltip ?>> <?= $txtMax ?></td>

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
    $page = $p;
    
    if (count($data) >= $limit || $p > 0) {
        ?>
        <div class="col-md-4 ml-auto  text-right " style="margin-bottom:15px">
            <?php
            //url pagination
            if (!empty($inputBusca)) {
                $urlPage .= '&s=' . $inputBusca;
            }

            if ($compare_coin !== 'bitcoin') {
                $urlPage .= '&compare=' . $compare_coin;
            }

            if (!empty($inputMarketCap)) {
                $urlPage .= '&marketcap=' . $inputMarketCap;
            }

            if ($inputOrderName == 'rank' && $inputOrderType == 'asc') {
                
            } else {
                $urlPage .= '&name=' . $inputOrderName;
                $urlPage .= '&order=' . $inputOrderType;
            }

            if ($min_rank > 1) {
                $urlPage .= '&min_rank=' . $min_rank;
            }

            if ($max_rank != $max_rank_all) {
                $urlPage .= '&max_rank=' . $max_rank;
            }

            if ($inputFavorite == 'true') {
                $urlPage .= '&favorite=' . $inputFavorite;
            }

            $urlPagePrev = siteUrl('/coin/price/') . '?p=' . ($page - 1) . $urlPage;
            $urlPageNext = siteUrl('/coin/price/') . '?p=' . ($page + 1) . $urlPage;


            //if disabled
            $disabledPrev = '';
            $disabledNext = '';
            if ($page == 0) {
                $disabledPrev = 'disabled';
                $urlPagePrev = 'javascript:void(0)';
            }
            if (count($data) < $limit) {
                $disabledNext = 'disabled';
                $urlPageNext = 'javascript:void(0)';
            }
            ?>
            <a href="<?= $urlPagePrev ?>"  class="btn btn-primary btn-round <?= $disabledPrev ?>">< <?= _e('Anterior') ?></a>
            <a href="<?= $urlPageNext ?>" class="btn btn-primary btn-round <?= $disabledNext ?>" ><?= _e('Próximo') ?> > </a>

        </div>
    <?php } ?>
</div>
<script>
//    $(document).ready(function () {
//
//        $('.column-order').on('click', function () {
//            var name = $(this).data('name');
//            var order = $(this).data('order');
//
//            $("#order_name").val(name);
//            $("#order_type").val(order);
//
//            loadPage();
//        });
//
//        $('[data-toggle="tooltip"]').tooltip();
//
//        $("#valor_total_market_cap_compare").val("<?= decimal($market_cap_compare, 0) ?>");
//        $("#valor_total_market_cap_compare_base").val("<?= decimal($compare['market_cap_moeda'], 0) ?>");
//        $("#porc_total_market_cap_compare").val("<?= decimal($porc_market_cap_compare, 0) ?>");
//        $(".moeda-char").html("<?= $moeda_char ?>");
//
//        $("#min_rank").val('<?= $min_rank; ?>');
//        $("#max_rank").val('<?= $max_rank; ?>');
//
//    });
</script>