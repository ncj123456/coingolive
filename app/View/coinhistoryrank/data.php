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
                $table_head = [
                    'name' => _e('Moeda'),
                    'rank' => _e('Rank'),
                    'change_high_rank' => _e('Máximo'),
                    'change_rank7d' => '7 ' . _e('dias'),
                    'change_rank1m' => '1 ' . _e('mês'),
                    'change_rank3m' => '3 ' . _e('meses'),
                    'change_rank6m' => '6 ' . _e('meses'),
                    'change_rank1y' => '1 ' . _e('ano')
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

                $favorite = '-o';
                if ($d['favorite'] === $d['id_externo']) {
                    $favorite = '';
                }

                $format_diff = function($rank, $desc = '') {
                    if ($rank === null) {
                        return '--';
                    }

                    $numClass = round(abs($rank) / 20);
                    if ($numClass > 5) {
                        $numClass = 6;
                    }
                    $arrow = '';
                    if ($rank < 0) {
                        $class_percent = 'red' . $numClass;
                        $arrow = 'down';
                    } elseif ($rank > 0) {
                        $arrow = 'up';
                        $class_percent = 'green' . $numClass;
                    } else {
                        $class_percent = 'badge-default';
                    }
                    $tooltip = 'data-toggle="tooltip" data-html="true" title="Rank: ' . $desc . '"';

                    return '<span style="font-size:13px;width:100%;border-radius: 3px;" ' . $tooltip . '  class="badge ' . $class_percent . '">                                       <i class="fa fa-chevron-' . $arrow . '"></i> ' . abs($rank) . '</span>';
                };
                ?>
                <tr >
                    <td class="text-left padding-table-3px" colspan="2"> 
                        <a href="javascript:addFavorite('<?= $d['id_externo'] ?>')" style="margin-right:10px;">
                            <i class="fa fa-star<?= $favorite ?>" id="user_favorite_<?= $d['id_externo'] ?>"></i>
                        </a>
                        <a href="<?= siteUrl('/coin-rank/?coins=' . $d['id_externo']) ?>">
                            <img style="margin-right:10px;    max-height: 20px;" src="/assets/img/coin/<?= $d['id_externo'] ?>.png">
                            <?= $d['symbol'] ?>
                            <!--<small><?= $d['symbol'] ?></small>-->
                        </a>
                    </td>
                    <td class="text-center padding-table-3px"><?= $d['rank']; ?></td>
                    <td class="text-center padding-table-3px"><?= $format_diff($d['change_high_rank'], $d['high_rank']); ?></td>
                    <td class="text-center padding-table-3px"><?= $format_diff($d['change_rank7d'], $d['rank7d']); ?></td>
                    <td class="text-center padding-table-3px"> <?= $format_diff($d['change_rank1m'], $d['rank1m']); ?></td>
                    <td class="text-center padding-table-3px" data-toggle="tooltip">
                        <?= $format_diff($d['change_rank3m'], $d['rank3m']); ?>
                    </td>
                    <td class="text-center padding-table-3px">
                        <?= $format_diff($d['change_rank6m'], $d['rank6m']); ?>
                    </td>
                    <td class="text-center padding-table-3px"><?= $format_diff($d['change_rank1y'], $d['rank1y']); ?></td>
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

    var header = $("#fixedTableHead");
    var position = header.offset().top;

    tableHeadFixed();

    window.onscroll = function () {
        tableHeadFixed();
    };

    function tableHeadFixed() {
        var top = window.pageYOffset;
        var header = $("#fixedTableHead");
        if (top > position) {
            header.attr("style", "transform: translate(0px," + (top - position) + "px);");
        } else {
            header.removeAttr("style");
        }
    }

</script>
<style>
    #fixedTableHead {
        z-index: 1000;
    }

</style>
