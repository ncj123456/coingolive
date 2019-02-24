<?php
$_title = "Vídeos recentes sobre Bitcoin e Criptomoedas";
$_meta_description = "Filtramos os melhores vídeos sobre Bitcoin e criptomoedas em apenas um lugar.Nosso robô busca constantemente novos conteúdos no Youtube, fique atualizado!";
?>
<div class="card">
    <div class="text-center">
        <h1 style="padding: 3px;margin-top:20px;font-size:25px;">Filtramos os melhores vídeos sobre Bitcoin e criptomoedas <br/> em apenas um lugar. </h1>
        <p style="margin-top: 0;margin-bottom: 15px">Nosso robô busca constantemente novos conteúdos no Youtube, fique atualizado!</p>
    </div>
</div>
<hr/>
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