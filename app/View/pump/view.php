<?php
$_title = "Pump";
?>
<?php
$_title = _e('Pump');
$_meta_description = _e('Encontre a moeda com maior variação, veja a diferença entre o preço mínimo e o preço máximo das criptomoedas nas últimas 24h em diferentes exchanges e analise a posição do preço atual');
?>
<div class="row">
    <div class="col-md-4">
        <h1 style="padding: 3px;margin-top:20px;font-size:35px"><?= _e($_title) ?></h1>
    </div>
    <?php
    if (!DEBUG) {
        echo '<div class="col-md-8 ">';
        require __DIR__ . '/../inc/ads.inc.php';
        echo '</div>';
    }
    ?>
    <div class="col-md-12">
        <div class="card" style="  margin-top: 0px;">
            <div class="card-body" style="padding:0;margin-left: 10px;margin-right: 10px">
                <div >
                    <div style="overflow-x: auto">
                        <table class="table table-striped table-nowrap">
                            <thead>

                                <tr>
                                    <?php
                                    $table_head = [
                                        'ex' => _e('Ex'),
                                        'symbol' => _e('Symbol'),
                                        'diff_porc' => _e('Open Price'),
                                        'last_diff_porc' => _e('Last Price'),
                                        'change24h' => _e(' porc'),
                                        'volume' => _e('Volume'),
                                        'volume' => _e('Porc Volume'),
                                    ];
                                    foreach ($table_head as $col_name => $col_desc) {
                                        $class_order = '';
                                        $new_order = 'desc';

//                                        if ($col_name == $column) {
//                                            if ($order == 'desc') {
//                                                $class_order = '-down';
//                                                $new_order = 'asc';
//                                            } elseif ($order == 'asc') {
//                                                $class_order = '-up';
//                                                $new_order = 'desc';
//                                            }
//                                        }
                                        ?>
                                        <th scope="col" class="text-center ">
                                            <a class="column-order" href="?order=<?= $col_name ?>&type=<?= $new_order ?>">
                                                <?= $col_desc ?> <i class="fa fa-sort<?= $class_order ?>"></i>
                                            </a>
                                        </th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody id="content_table">

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4  " style="padding:15px">
                        <?= _e('Ultima atualização') . ' ' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script>
    var socket = io('<?= HOST_NODEJS ?>');
</script>