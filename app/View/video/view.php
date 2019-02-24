
    <div class="row" style="margin: 15px">
<?php
foreach ($rs as $r) {
    ?>
        <div class="col-md-3" style="padding-left: 10px; padding-right: 10px; padding-bottom: 0px;padding-top: 0px">
            <div class=" card text-center" style="margin-bottom: 5px;">
                  <a href="<?= $r['link'] ?>" target="_blank" >  
                        <img style="width: 100%;" src="<?= $r['thumbnail'] ?>" />
                  </a>
                <div class="card-body"  style="padding: 10px;">
                    
                    <p style="font-size: 16px;font-weight: 800;"><a href="<?= $r['link'] ?>" style="color: #000" target="_blank" ><?= $r['title'] ?></a></p>
                        <p><i class="fa fa-eye"></i> <?= $r['views'] ?> <span style="margin-left: 10px"><i class="fa fa-thumbs-up"></i> <?= $r['likes'] ?></span></p>
                        
                        <small style="font-size: 14px"><?= dateDesc($r['published']) ?> </small>
                        
                        <p><?= $r['channel'] ?></p>
            </div>
            </div>
        </div>
    <?php
}
?>

    </div>