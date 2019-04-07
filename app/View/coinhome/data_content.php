
<div  style="overflow-x: auto" >
    
    <table class="table table-nowrap table-hover" >
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
        <tbody class=" table-coin">
            <?php
            foreach ($data as $d) {

                $format_porc = function($porc, $price, $moeda_char, $desc = '') {
                    if ($porc < 0) {
                        $class_percent = 'danger';
                    } elseif ($porc > 0) {
                        $class_percent = 'success';
                    } else {
                        $class_percent = 'default';
                    }
                    $tooltip = '';
                    if ($price) {
                        $tooltip = 'data-toggle="tooltip" data-html="true" title="' . $desc . '<br>' . $moeda_char . decimal($price, 2, true) . ' "';
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

                $coinName = $d['name'] . ' (' . $d['symbol'] . ')';
                ?>
                <tr>
                    <td class="text-center" ><a href="javascript:addFavorite('<?= $d['id_externo'] ?>')">
                            <i class="fa fa-star<?= $favorite ?>" id="user_favorite_<?= $d['id_externo'] ?>"></i>
                        </a>
                    </td>
                    <td class="text-center padding-table-3px"><?= $d['rank']; ?></td>
                    <td class="text-left td-name" style="min-width:100px!important"> 
                        <div class="d-flex flex-row align-items-center" style="height:100%">
                            <div>
                                <div class="d-flex align-items-center">
                                    <a href="<?= siteUrl('/coins/' . $d['id_externo'].'/') ?>"><img alt="<?= $coinName ?>" src="/assets/img/coin/<?= $d['id_externo'] ?>-small.png" /></a>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <a class="coin-link" href="<?= siteUrl('/coins/' . $d['id_externo'].'/') ?>"><?= $d['symbol'] ?></a>
                                </div><div class="desc" style="margin-left:-10px"><?= btnAds($d['symbol']) ?></div></div>
                        </div>
                    </td>
                    <td class="text-right" style="padding-left:3px"><?= $moeda_char ?><?= decimal($d['price_moeda'], 2, true); ?></td>
                     <td class="text-right" <?= tooltip(_e("Dominancia") . ': ' . decimalAuto($d['percent_dominance'], 2, 2) . ' %') ?> > 
                        <?= ($moeda_char . numFormat($d['market_cap_moeda'], 2)) ?>
                    </td>
                    <td class="text-center <?= classPorc($d['price_change_percentage_1h'])?>" ><?= decimal($d['price_change_percentage_1h']); ?>%</td>
                    <td class="text-center <?= classPorc($d['price_change_percentage_24h'])?>" ><?= decimal($d['price_change_percentage_24h']) ?>%</td>
                    <td class="text-center <?= classPorc($d['price_change_percentage_7d'])?>" ><?= decimal($d['price_change_percentage_7d']) ?>%</td>
                    <td class="text-center" style="padding:0!important;min-width: 166px">
                       <div class='sparkline' data-codigo="<?= $d['id_externo'] ?>" data-json7d='<?= $d['data_7d'] ?>'></div>
                    </td>
                    <td class="text-center" style="padding:0!important;min-width: 166px">
                        <div id='chart_vol24h_<?= $d['id_externo'] ?>'></div>
                    </td>
                    
                    <td class="text-right" style="background-color:  <?= $color_vol24 ?>"> <?= $moeda_char . numFormat($d['volume_24h_moeda'], 2) ?> </td>
                     
                       <td class="text-right" <?= tooltip($supplyTooltip) ?>> <?= numFormat($d['available_supply'], 2) ?> </td>
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
            
            if($inputOrderFilterVol24h!='1M'){
                   $urlPage .= '&vol24h='.$inputOrderFilterVol24h;
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

            $urlPagePrev = siteUrl('/') . '?p=' . ($page - 1) . $urlPage;
            $urlPageNext = siteUrl('/') . '?p=' . ($page + 1) . $urlPage;


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
