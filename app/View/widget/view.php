<?php
//calculos
$price_moeda = $data['price_moeda'];
$available_supply = (float) $data['available_supply'];
$market_cap_compare = $compare['market_cap_moeda'];
$max_price_moeda = $market_cap_compare / $available_supply;

$percent_available_supply = round((($max_price_moeda / $data['price_moeda']) * 100 ) - 100);


if ($percent_available_supply < 0) {
    $color_percent = 'red';
} elseif ($percent_available_supply > 0) {
    $color_percent = 'green';
} else {
    $color_percent = '';
}
//check moeda fiat
if ($data['moeda_char'] == 'BTC') {
    $price_current = decimal($price_moeda, 8) . ' ' . $data['moeda_char'];
    $price_available_supply = decimal($max_price_moeda, 8) . ' ' . $data['moeda_char'];
} else {
    $price_current = $data['moeda_char'] . ' ' . decimal($price_moeda, 2, true);
    $price_available_supply = $data['moeda_char'] . ' ' . decimal($max_price_moeda, 2, true);
}
?>
<div style="border:2px solid #E4E6EB;border-radius: 10px;font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;min-width:285px;max-width:500px;">
    <div>
        <div style="float:right;width:67%;border: 0px solid #000;text-align:left;padding:5px 0px;line-height:25px;margin-left: 10px">
            <span style="font-size: 18px;">
                <a href="<?= BASE_URL . '/currencies/' . $data['codigo'] . '/' ?>" target="_blank" style="text-decoration: none; color: #9c27b0;">
                    <?= $data['name'] . ' (' . $data['symbol'] . ')' ?></a>
            </span>
            <br>
        </div>
        <div style="text-align:right;padding:5px 0px;width:33%;">
            <img src="<?= BASE_URL . '/assets/img/coin/' . $data['codigo'] . '.png' ?>">
        </div>
    </div>
    <div style="border-top: 1px solid #E4E6EB;clear:both;">
        <div style="text-align:center;float:left;width:66%;font-size:12px;padding:12px 0;border-right:1px solid #E4E6EB;line-height:1.25em;">
            <?= _e('MOEDA BASE ESTIMATIVA') ?> 
            <br>
            <div style="float:right;width:50%;border: 0px solid #000;text-align:left;padding:5px 10px;line-height:25px;">
                <span style="font-size: 14px;">
                        <?= $compare['name'] . ' (' . $compare['symbol'] . ')' ?>
                </span>
                <br>
            </div>
            <div style="text-align:right;padding:5px 0px;width:55%;">
                <img style="max-width:20px" src="<?= BASE_URL . '/assets/img/coin/' . $compare['codigo'] . '.png' ?>">
            </div>
        </div>
        <div style="text-align:center;float:left;width:33%;font-size:12px;padding:12px 0 16px 0;line-height:1.25em;"> 
            <?= _e('MARKET CAP ESTIMADO') ?> 
            <br>
            <br>
            <span style="font-size: 14px; "><?= $compare['moeda_char'] . ' ' . decimal($compare['market_cap_moeda']); ?>
            </span>
        </div>
    </div>
    <div style="border-top: 1px solid #E4E6EB;clear:both;">
        <div style="text-align:center;float:left;width:33%;font-size:12px;padding:12px 0;border-right:1px solid #E4E6EB;line-height:1.25em;">
           <?= _e('PREÇO ATUAL') ?> <?= ' (' . $data['symbol'] . ')' ?>
            <br>
            <br>
            <span style="font-size: 18px; "><?= $price_current ?> </span>
        </div>
        <div style="text-align:center;float:left;width:33%;font-size:12px;padding:12px 0 16px 0;border-right:1px solid #E4E6EB;line-height:1.25em;"> <?= _e('PREÇO MÁXIMO'). ' (' . $data['symbol'] . ')' ?>
            <br>
            <br>
            <span style="font-size: 18px; "><?= $price_available_supply; ?>
                <span style="font-size:9px"><?= $data['moeda'] ?></span>
            </span>
        </div>
        <div style="text-align:center;float:left;width:33%;font-size:12px;padding:12px 0 16px 0;line-height:1.25em;"> 
            <?= _e('CRESCIMENTO').' (' . $data['symbol'] . ')' ?>
            <br>
            <br>
            <span style="font-size: 18px; <?= ' color:' . $color_percent; ?>"><?= decimal($percent_available_supply, 0) ?>%
            </span>
        </div>
    </div>
    <div style="border-top: 1px solid #E4E6EB;clear:both;">
        <div style="text-align:center;float:left;width:33%;font-size:12px;padding:12px 0;border-right:1px solid #E4E6EB;line-height:1.25em;">
            <?= _e('DOMINÂNCIA ATUAL') ?>
            <br>
            <br>
            <span style="font-size: 14px; "><?= decimal($data['percent_dominance'], 2, true) ?>% </span>
        </div>
        <div style="text-align:center;float:left;width:33%;font-size:12px;padding:12px 0 16px 0;border-right:1px solid #E4E6EB;line-height:1.25em;"> <?= _e('MARKET CAP ATUAL') ?>
            <br>
            <br>
            <span style="font-size: 14px; "><?= $data['moeda_char'] . ' ' . decimal($data['market_cap_moeda']); ?>
                <span style="font-size:9px"><?= $data['moeda'] ?></span>
            </span>
        </div>
        <div style="text-align:center;float:left;width:33%;font-size:12px;padding:12px 0 16px 0;line-height:1.25em;"> VOLUME (24H)
            <br>
            <br>
            <span style="font-size: 14px; "><?= $data['moeda_char'] . ' ' . decimal($data['volume_24h_moeda']); ?>
                <span style="font-size:9px"><?= $data['moeda'] ?></span>
            </span>
        </div>
    </div>
    <div style="border-top: 1px solid #E4E6EB;text-align:center;clear:both;font-size:10px;font-style:italic;padding:5px 0;">
        <a href="<?= BASE_URL ?>/" target="_blank" style="text-decoration: none; color: #9c27b0;">Powered by CoinGoLive</a>
 <?= _e('Ultima atualização') . ' ' . dateDesc($data['data_alteracao']) ?>
    </div>
</div>