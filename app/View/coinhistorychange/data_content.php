<div  style="overflow-x: auto" >
    <table class="table table-striped table-nowrap">
        <thead id="fixedTableHead" class="table-header">

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

                $favorite = '-o';
                if ($d['favorite'] === $d['id_externo']) {
                    $favorite = '';
                }

                $moeda_char = $d['moeda_char'];
                if ($d['moeda_char'] == 'BTC') {
                    $moeda_char = "<span class='icon-moeda-char'><i class='fa fa-btc'></i> </span>";
                }

                //highlight volume

//                $porcVol = ($d['volume_24h_moeda'] * 100 / $max_vol24);

                $color_vol24 = volumeColor($d['volume_24h_moeda']);   
               $coinName = $d['name'].' ('.$d['symbol'].')';
                ?>
                <tr >
                     <td class="text-center" ><a href="javascript:addFavorite('<?= $d['id_externo'] ?>')">
                            <i class="fa fa-star<?= $favorite ?>" id="user_favorite_<?= $d['id_externo'] ?>"></i>
                        </a>
                    </td>
                    <td class="text-center padding-table-3px"><?= $d['rank']; ?></td>
                       <td class="text-left td-name"> 
                        <div class="d-flex flex-row align-items-center" style="height:100%">
                            <div>
                                <div class="d-flex align-items-center">
                                    <a href="<?= siteUrl('/coins/' . $d['id_externo'].'/') ?>"><img alt="<?= $coinName ?>" src="/assets/img/coin/<?= $d['id_externo'] ?>-small.png" /></a>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <a class="coin-link" href="<?= siteUrl('/coins/' . $d['id_externo'].'/') ?>"><?= $d['symbol'] ?></a>
                                    <?= btnAds($d['symbol']) ?></div><div class="desc"><?= $d['name'] ?></div></div>
                        </div>
                    </td>
                    <td class="text-right" style="padding-left:3px"><?= $moeda_char ?><?= decimal($d['price_moeda'], 2, true); ?></td>
                    <td class="text-right" style="background-color:  <?= $color_vol24 ?>"> <?= $moeda_char . numFormat($d['volume_24h_moeda'], 2) ?> </td>
                    <td class="text-center <?= classPorc($d['price_change_percentage_1h'])?>" ><?= decimal($d['price_change_percentage_1h']); ?>%</td>
                    <td class="text-center <?= classPorc($d['price_change_percentage_24h'])?>" ><?= decimal($d['price_change_percentage_24h']) ?>%</td>
                    <td class="text-center <?= classPorc($d['price_change_percentage_7d'])?>" ><?= decimal($d['price_change_percentage_7d']) ?>%</td>
                    <td class="text-center <?= classPorc($d['price_change_percentage_14d'])?>" ><?= decimal($d['price_change_percentage_14d']) ?>%</td>
                    <td class="text-center <?= classPorc($d['price_change_percentage_30d'])?>" ><?= decimal($d['price_change_percentage_30d']) ?>%</td>
                    <td class="text-center <?= classPorc($d['price_change_percentage_200d'])?>" ><?= decimal($d['price_change_percentage_200d']) ?>%</td>
                    <td class="text-center <?= classPorc($d['price_change_percentage_1y'])?>" ><?= decimal($d['price_change_percentage_1y']) ?>%</td>
                    <td class="text-center"data-toggle="tooltip" title="
                        <?= $d['symbol'] ?><br/> 
                        <?= decimal($d['ath_change_percentage'], 2); ?>%<br/>
                        <?= $moeda_char . decimalAuto($d['high_price']); ?> <br/>
                        <?= $d['high_date'] ?>
                        " data-html='true'>
                            <div class="progress" style="height: 25px;margin-bottom: 0px;">
                                <div class="progress-bar bg-danger"  role="progressbar" style="width: <?= round(abs($d['ath_change_percentage']), 2) ?>%;display:block">
                               <?= decimal($d['ath_change_percentage'], 2); ?>%
                                </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="row" style="padding:20px">
    <?php
    if (isset($data[0]['updated'])) {
        ?>
        <div class="col-md-4  ">
            <?= _e('Ultima atualização') . ' ' . dateDesc($data[0]['updated']) ?>
        </div>
        <?php
    }
    if (count($data) >= $limit || $page > 0) {
        ?>
        <div class="col-md-4 ml-auto  text-right " style="margin-bottom:15px">
            <?php
              //url pagination
            if (!empty($inputBusca)) {
                $urlPage .= '&s=' . $inputBusca;
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
            
            $urlPagePrev = siteUrl('/coin/price-change-history/').'?p=' . ($page - 1) .$urlPage;
            $urlPageNext = siteUrl('/coin/price-change-history/').'?p=' . ($page + 1) .$urlPage;
            
            
            //if disabled
            $disabledPrev = '';
            $disabledNext = '';
            if ($page == 0) {
                $disabledPrev = 'disabled';
                $urlPagePrev='javascript:void(0)';
            }
            if (count($data) < $limit) {
                $disabledNext = 'disabled';
                $urlPageNext='javascript:void(0)';
            }
            ?>
            <a href="<?= $urlPagePrev ?>"  class="btn btn-primary btn-round <?= $disabledPrev ?>">< <?= _e('Anterior') ?></a>
            <a href="<?= $urlPageNext ?>" class="btn btn-primary btn-round <?= $disabledNext ?>" ><?= _e('Próximo') ?> > </a>

        </div>
    <?php } ?>
</div>
<script>

//    $("#min_rank").val('<?= $min_rank; ?>');
//    $("#max_rank").val('<?= $max_rank; ?>');
//
//    $('[data-toggle="tooltip"]').tooltip();

//    $('.JStableOuter table').scroll(function (e) {
//
//        $('.JStableOuter thead').css("left", -$(".JStableOuter tbody").scrollLeft());
//        $('.JStableOuter thead th:nth-child(2)').attr("style","z-index:1000");
//        $('.JStableOuter thead th:nth-child(2)').css("left", $(".JStableOuter table").scrollLeft() - 0);
//        $('.JStableOuter thead th:nth-child(1)').css("left", $(".JStableOuter table").scrollLeft() - 0);
//        $('.JStableOuter tbody td:nth-child(1)').css("left", $(".JStableOuter table").scrollLeft());
//
//        $('.JStableOuter thead').css("top", -$(".JStableOuter tbody").scrollTop());
//        $('.JStableOuter thead tr th').css("top", $(".JStableOuter table").scrollTop());
//
//    });


</script>
<style>
    #fixedTableHead {
        z-index: 1000;
    }

</style>
