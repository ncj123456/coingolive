<?php
    if(!isset( $_SESSION['ads'] )){
        $_SESSION['ads'] =rand(1,2);//aleatorio
    }
    if ($_SESSION['ads'] === 1) {
        ?>
        <div style="width:100%; overflow-x: auto; ">
            <div class="text-center">
                <div class="coinzilla" data-zone="415245a8c26c8245e2" data-w="728" data-h="90"  style="max-width: 728px; width:100%; display: inline-block;min-height: 90px"></div>
            </div>
        </div>
        <?php
    } else {        
        ?>
      <div style="width:100%; overflow-x: auto; ">
            <div class="text-center">
                <div class="coinzilla" data-zone="415245a8c26c8245e2" data-w="728" data-h="90"  style="max-width: 728px; width:100%; display: inline-block;min-height: 90px"></div>
            </div>
        </div>
        <!-- Bitcoadz.io - Ad Display Code -->
        <?php
    }
?>
