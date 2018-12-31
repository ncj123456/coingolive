<?php
$_title = ucfirst($exchange_current).' - '._e('Variação das criptomoedas em 24h');
$_meta_description = _e('Encontre a moeda com maior variação na [1], veja a diferença entre o preço mínimo e o preço máximo das criptomoedas nas últimas 24h em diferentes exchanges e analise a posição do preço atual',ucfirst($exchange_current));

    if (!DEBUG) {
        require __DIR__ . '/../inc/ads.inc.php';
    }
?>
<div class="row">
    <div class="col-md-12">
        <h1 style="padding: 3px;margin-top:20px;font-size:25px"><?= _e($_title) ?></h1>
    </div>
    <?php
    require __DIR__ . '/../inc/msg_help.inc.php'
    ?>
    <div class="col-md-10">
        <div class="card" style="  margin-top: 0px;">
            <div class="card-body" style="padding:0;margin-left: 10px;margin-right: 10px">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-12" style="margin-top: 15px;">
                        Exchange 
                        <div class="dropdown">
                            <button class="btn-sm btn btn-primary btn-block  dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= ucfirst($exchange_current) ?>  
                            </button>
                            <div class="dropdown-menu ">
                                <?php
                                foreach ($exchange_list as $e) {
                                    if ($e['exchange'] == $exchange_current) {
                                        continue;
                                    }
                                    ?>
                                    <a href="<?= siteUrl('/coin-change/' . $e['exchange'] . '/btc/') ?>" class="dropdown-item">
                                        <?= ucfirst($e['exchange']) ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12" style="margin-top: 15px;">
                        Market Exchange
                        <div class="dropdown">
                            <button class="btn-sm btn btn-primary  btn-block  dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= ucfirst($market_current) ?>  
                            </button>
                            <div class="dropdown-menu ">
                                <?php
                                foreach ($market_list as $e) {
                                    if ($e['market'] == $market_current) {
                                        continue;
                                    }
                                    ?>
                                    <a href="<?= siteUrl('/coin-change/' . $exchange_current . '/' . strtolower($e['market']) . '/') ?>" class="dropdown-item">
                                        <?= ucfirst($e['market']) ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 ml-auto">
                        <div class="form-group input-group has-default bmd-form-group">
                            <input type="text" name="input_busca" id="input_busca" class="form-control" placeholder="Search Symbol" value="">
                            <button type="button" class="btn btn-sm btn-primary btn-raised btn-fab btn-round">
                                <i class="material-icons">search</i>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="tableContent">
                    <div style="overflow-x: auto">
                        <table class="table table-striped table-nowrap" id="table_coin_change">
                            <thead>

                                <tr>
                                    <?php
                                    $table_head = [
                                        'symbol' => _e('Symbol'),
                                        'diff_porc' => _e('Diference Price Low High'),
                                        'last_diff_porc' => _e('Last Price Position'),
                                        'change24h' => _e(' Change 24h'),
                                        'volume' => _e('Volume').' '.strtoupper($market_current),
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
                                        <th scope="col" class="text-center ">
                                            <a class="column-order" href="?order=<?= $col_name ?>&type=<?= $new_order ?>">
                                                <?= $col_desc ?> <i class="fa fa-sort<?= $class_order ?>"></i>
                                            </a>
                                        </th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($data as $d) {
                                    $change24h = $d['change24h'];
                                    $class24h = 'success';

                                    if ($change24h < 0) {
                                        $class24h = 'danger';
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $d['symbol'] ?></td>
                                        <td class="text-center"><?= $d['diff_porc'] ?>%</td>
                                        <td class="text-center"data-toggle="tooltip" title='
                                            <?= $d['symbol'] ?><br/> 
                                            Low price: <?= $d['price_low']?> <br/>
                                            Last price: <?= $d['price_last']?> <br/>
                                            High price: <?= $d['price_high'] ?> <br/>
                                            ' data-html='true'>
                                            <div class="progress progress-line-primary ">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" style="width: <?= 100 - $d['last_diff_porc'] ?>%;">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center text-<?= $class24h; ?>"><?= $change24h ?>%</td>
                                        <td class="text-center"><?= $d['volume'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4  " style="padding:15px">
                        <?= _e('Ultima atualização') . ' ' . dateDesc($data[0]['updated']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <?php 
    if (!DEBUG) {
        require __DIR__ . '/../inc/ads_lado.inc.php';
    }
?>
</div>