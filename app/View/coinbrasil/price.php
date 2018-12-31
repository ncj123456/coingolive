<div class="row">
    <?php
    foreach ($data as $d) {
        $moeda_base = $d['moeda_base'];
        $price_media = $d['price_media'];

        $price24h = $data24h[$moeda_base];
        $porcChange24h = ($price_media - $price24h) * 100 / $price_media;

        $color24h = 'text-success';
        if ($porcChange24h < 0) {
            $color24h = 'text-danger';
        }
        
        
//        $price7d = $data7d[$moeda_base];
//        $porcChange7d = ($price_media - $price7d) * 100 / $price_media;
//        
//         $color7d = 'text-success';
//        if ($porcChange7d < 0) {
//            $color7d = 'text-danger';
//        }

//        $diffPrice = $d['max_price'] - $d['min_price'];
//        $lastDiffPrice = $d['max_price'] - $d['price_media'];
//
//        $dffPorc = number_format($diffPrice * 100 / $d['max_price'], 2);
//        $lastDffPorc = number_format($lastDiffPrice * 100 / $diffPrice, 2);
        ?>
        <div class="card col-md-6"  style="margin-top: 0px;margin-bottom:  0px;">
            <div class="card-body" >
                <h4 class="card-title" style="margin:0px"><?= $moeda_base ?></h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-text">
                            <h2 style="margin:0px;font-size: 2rem;"><?= decimal($price_media, 2) ?> 
                                <span class="<?= $color24h ?>" style="font-size: 70%;">
                                    <?= decimal($porcChange24h, 2) ?>%
                                </span>
                            </h2>
                            <span><small>Min: </small> <?= decimal($d['min_price'], 2) ?></span>
                            <span><small>Max: </small> <?= decimal($d['max_price'], 2) ?></span>
                        </div>  
                    </div>    
                    <!--                    <div class="col-md-6">
                                            <div class="text-center">
                                                Posição preço atual 24h:<br/>
                                                <div class="progress progress-line-primary "  style="margin:3px;background-color: rgba(51, 51, 51, 0.2);">
                                                    <div class="progress-bar" role="progressbar" style="background-color:#484848!important;width: <?= 100 - $lastDffPorc ?>%;">
                                                    </div>
                                                </div>
                                    <span style="position: absolute;left: 0px;"><small>  <?= decimal($d['min_price'], 2) ?></small></span>
                                    <span style="position: absolute;right: 0px;"><small>  <?= decimal($d['max_price'], 2) ?></small></span>
                                            </div>
                                        </div>-->
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>