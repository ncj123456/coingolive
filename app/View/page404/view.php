<?php
$_title2 = _e("Página não encontrada!").' 404';
?>
<div class="main main-raised"  style="margin: 0px!important;background-color: #f7f7f7!important">
    <div class="container">
        <div class="section" style="padding:10px 10px!important">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-body" >
                        <h1 class="text-center">404</h1>
                        <h2 class="text-center" style=" font-size: 25px;;"><?= _e("Página não encontrada!") ?></h2>
                        <div class="text-center">
                            <a href="<?= siteUrl('/'); ?>" class="btn btn-primary btn-raised">
                                <?= _e('Voltar para página principal') ?></a>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>