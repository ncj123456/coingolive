<?php
if ($_SESSION['ads'] === 2) {
    $_SESSION['ads'] = 1;
    ?>
    <div class="text-center">
        <!-- Bitcoadz.io - Ad Display Code -->
        <div id="data_18910"></div><script data-cfasync="false" async type="text/javascript" src="//www.bitcoadz.io/display/items.php?18910&35261&728&90&1&0&0&0"></script>
    </div>
    <?php
} else {
    $_SESSION['ads'] = 2;
    ?>
    <div class="text-center">
        <!-- Bitcoadz.io - Ad Display Code -->
        <div id="data_18910"></div><script data-cfasync="false" async type="text/javascript" src="//www.bitcoadz.io/display/items.php?18910&35261&728&90&1&0&0&0"></script>
    </div>
    <!-- Bitcoadz.io - Ad Display Code -->
    <?php
}
?>