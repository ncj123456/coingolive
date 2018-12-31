<?php
$external = (isset($_GET['external'])&&$_GET['external']==true)?true:false;
$link='';
$target='';
$css_color='#d8d8d8';
$css_background_color="#79308c";
$css_font_size = "16px";
if($external){
    $link = 'https://coingolive.com';
    $target='target="_blank"';
    $css_color = '#1e73be';
    $css_background_color = '#ffff';
    $css_font_size = "18px";
}
?>
<div style="height: 45px;">
    <a id="link_div_topo" <?= $target?> href="<?= $link.siteUrl('/bitcoin/brasil/') ?>"
       style="display: block;padding: 10px;  height: 45px; font-size:<?= $css_font_size ?>; text-align: center; text-decoration:none;width: 100%;z-index: 5000;color:<?= $css_color?> ;position: absolute;background-color: <?= $css_background_color?>;font-weight:500;">
           <?php
           foreach ($data as $d) {
               $moeda_base = $d['moeda_base'];
               $price_media = $d['price_media'];

               $price24h = $data24h[$moeda_base];
               $porcChange24h = ($price_media - $price24h) * 100 / $price_media;

               $color24h = '#4dd618';
               if ($porcChange24h < 0) {
                   $color24h = '#ff968e';
               }
               ?>
        <span style="margin-right: 5px;white-space: nowrap;">
                <span  style="font-size: 70%;">BTC/<?= $moeda_base ?></span> 
                    <?= decimal($price_media, 2) ?>
                <span  style="font-size: 70%;font-weight: 900;color: <?= $color24h ?>">
                    <?= decimal($porcChange24h, 2) ?>%
                </span>
            </span>
            <?php
        }
        ?>
    </a>
</div>