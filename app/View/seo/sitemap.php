<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
    <?php
    $urlBase = "http://coingolive.com";
    $langs = \Base\I18n::getListLangs();
    foreach ($langs as $name => $desc) {
        ?>
        <url>
            <loc><?= $urlBase . '/' . $name . '/' ?></loc>
            <priority>1</priority>
        </url>
        <url>
            <loc><?= $urlBase . '/' . $name . '/coin/price/' ?></loc>
            <priority>1</priority>
        </url>
        <url>
            <loc><?= $urlBase . '/' . $name . '/coin-change/binance/btc/' ?></loc>
            <priority>1</priority>
        </url>
        <url>
            <loc><?= $urlBase . '/' . $name . '/coin-change/cryptopia/btc/' ?></loc>
            <priority>1</priority>
        </url>
        <url>
            <loc><?= $urlBase . '/' . $name . '/coin-change/bittrex/btc/' ?></loc>
            <priority>1</priority>
        </url>
        <url>
            <loc><?= $urlBase . '/' . $name . '/coin-change/poloniex/btc/' ?></loc>
            <priority>1</priority>
        </url>
        <url>
            <loc><?= $urlBase . '/' . $name . '/coin/change-history/' ?></loc>
            <priority>1</priority>
        </url>
        <url>
            <loc><?= $urlBase . '/' . $name . '/coin/ath/' ?></loc>
            <priority>1</priority>
        </url>
        <url>
            <loc><?= $urlBase . '/' . $name . '/feedback/' ?></loc>
            <priority>1</priority>
        </url>
        <url>
            <loc><?= $urlBase . '/' . $name . '/contact/' ?></loc>
            <priority>1</priority>
        </url>
        <?php
    }
    ?>
    <url>
        <loc><?= $urlBase . '/pt-br/bitcoin/brasil/' ?></loc>
        <priority>1</priority>
    </url>

    <?php
    foreach ($data as $d) {
        foreach ($langs as $name => $desc) {
            ?>
            <url>
                <loc><?= $urlBase . '/' . $name . '/currencies/' . $d['codigo'] . '/'; ?></loc>
                <priority>0.80</priority>
            </url>
            <?php
        }
    }
    ?>
</urlset>

