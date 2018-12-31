<div style="overflow-x: auto" >
    <table class="table table-striped table-nowrap">
        <thead>

            <tr>
                <?php
                $table_head = [
                    'rank' => _e('Rank'),
                    'name' => _e('Moeda'),
                    'market_cap_moeda' => _e('Cap. de Mercado'),
                    'price_moeda' => _e('Preço'),
                    'porc_high' => _e('Máximo'),
                    'porc24h' => '24 ' . _e('horas'),
                    'porc7d' => '7 ' . _e('dias'),
                    'porc1m' => '1 ' . _e('mês'),
                    'porc3m' => '3 ' . _e('meses'),
                    'porc6m' => '6 ' . _e('meses'),
                    'porc1y' => '1 ' . _e('ano')
                ];
                foreach ($table_head as $col_name => $col_desc) {
                        ?>
                    <th scope="col" class="text-left column-order">
                        <?= $col_desc ?>
                    </th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data as $d) {

                $format_porc = function($porc, $price, $desc = '') {
                    if ($porc < 0) {
                        $class_percent = 'danger';
                    } elseif ($porc > 0) {
                        $class_percent = 'success';
                    } else {
                        $class_percent = 'default';
                    }
                    $tooltip = '';
                    if ($price) {
                        $tooltip = 'data-toggle="tooltip" data-html="true" title="' . $desc . '<br>$' . decimal($price, 2, true) . ' "';
                    }
                    return '<span style="font-size:13px;width:100%;border-radius: 3px;" ' . $tooltip . '  class="badge badge-' . $class_percent . '">' . decimal($porc, 2) . '%</span>';
                }
                ?>
                <tr >
                    <td class="text-center padding-table-3px"><?= $d['rank']; ?></td>
                    <td class="text-left padding-table-3px"> 
                        <a href="<?= siteUrl('/compare/coin/?coins=' . $d['id_externo']) ?>">
                            <img style="margin-right:10px;    max-height: 20px;" src="/assets/img/coin/<?= $d['id_externo'] ?>.png">
                            <?= $d['symbol'] ?>
                            <!--<small><?= $d['symbol'] ?></small>-->
                        </a>
                    </td>
                    <td class="text-center"><span<?= tooltip('$' . decimal($d['market_cap_moeda'], 0)) ?>>$<?= numFormat($d['market_cap_moeda'], 2); ?></span></td>
                    <td class="text-right" style="padding-left:3px">$<?= decimal($d['price_moeda'], 2, true); ?></td>
                    <td class="text-center padding-table-3px"><?= $format_porc($d['porc_high'], $d['high_price'], $d['high_date']); ?></td>
                    <td class="text-center padding-table-3px"><?= $format_porc($d['porc24h'], false); ?></td>
                    <td class="text-center padding-table-3px"><?= $format_porc($d['porc7d'], $d['price7d']); ?></td>
                    <td class="text-center padding-table-3px"><?= $format_porc($d['porc1m'], $d['price1m']); ?></td>
                    <td class="text-center padding-table-3px" data-toggle="tooltip">
                        <?= $format_porc($d['porc3m'], $d['price3m']); ?>
                    </td>
                    <td class="text-center padding-table-3px">
                        <?= $format_porc($d['porc6m'], $d['price6m']); ?>
                    </td>
                    <td class="text-center padding-table-3px"><?= $format_porc($d['porc1y'], $d['price1y']); ?></td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>
    $('[data-toggle="tooltip"]').tooltip();
</script>