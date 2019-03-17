<?php
$_title2 = _e("Mercado de Bitcoin e Criptomoedas, Preços e Históricos");
$_meta_description = _e('Ferramentas para analisar o mercado de bitcoin e criptomoedas, confira preços, históricos e valor de mercado');
$lang = \Base\I18n::getCurrentLang();
?>
<div class="main main-raised"  style="margin: 0px!important;background-color: #f7f7f7!important">
    <div class="container">
        <div class="section" style="padding:10px 10px!important">
            <div class="row">
                <div class="col-md-12  text-center">
                     <h1 class="h3"><?= $_title2 ?></h1>
                     <h2 class="text h4"><?= $_meta_description?></h2>
                </div>
                <div class="col-md-4 ml-auto mr-auto">
                    <div class="card card-body" >
                        <h3 class="text-center" style=" font-size: 25px;"><?= _e('Calcular Preço Criptomoedas Alterando o Market Cap') ?></h3>
                        <a href="<?= siteUrl('/coin/price/'); ?>">
                            <img alt="<?= _e('Calcular Preço Criptomoedas Alterando o Market Cap') ?>" src="/assets/img/1.png" style="width: 100%;" />
                        </a>
                        <p class="text-center description h4"><?= _e('Calcule o preço das criptomoedas com a mesma capitalização de mercado do Bitcoin, altere o valor do Market Cap e veja o crescimento necessário para alcançá-lo') ?></p>
                        <div class="text-center">
                            <a href="<?= siteUrl('/coin/price/'); ?>" class="btn btn-primary btn-raised">
                                <?= _e('Calcular Preço') ?></a>
                        </div>
                    </div> 
                </div> 
                <div class="col-md-4">
                    <div class="card card-body" >
                        <h3 class="text-center" style=" font-size: 25px;"><?= _e('Alta histórica das Criptomoedas') ?></h3>
                        <a href="<?= siteUrl('/coin/ath-price/'); ?>" >
                            <img alt="<?= _e('Alta histórica das Criptomoedas').' ATH' ?>" src="/assets/img/2.png" style="width: 100%;" />
                        </a>
                        <p class="text-center description h4"><?= _e('Análise em qual data foi atingida a alta histórica, qual a posição do preço atual e quantos por cento será o crescimento do preço atual em relação à alta histórica') ?></p>
                        <div class="text-center">
                            <a href="<?= siteUrl('/coin/ath-price/'); ?>" class="btn btn-primary btn-raised">
                                <?= _e('Alta Histórica').' ATH' ?></a>
                        </div>
                    </div> 
                </div>
                <div class="col-md-4 ml-auto mr-auto">
                    <div class="card card-body" >
                        <h3 class="text-center" style=" font-size: 25px;"><?= _e('Histórico Preço Criptomoedas, Valorização e Desvalorização') ?></h3>
                        <a href="<?= siteUrl('/coin/price-change-history/'); ?>">
                            <img alt="<?= _e('Histórico Preço Criptomoedas, Valorização e Desvalorização') ?>" src="/assets/img/3.png" style="width: 100%;" />
                        </a>
                        <p class="text-center description h4"><?= _e('Histórico de preço bitcoin e criptomoedas, acompanhe a variação do valor em diferentes períodos 1 hora, 7 dias, 1 mês e 1 ano, ordene e filtre a porcentagem de valorização e desvalorização das criptomoedas.') ?></p>
                        <div class="text-center">
                            <a href="<?= siteUrl('/coin/price-change-history/'); ?>" class="btn btn-primary btn-raised">
                                <?= _e('Histórico Preço') ?></a>
                        </div>
                    </div> 
                </div>  
                <div class="col-md-4">
                    <div class="card card-body" >
                        <h3 class="text-center" style=" font-size: 25px;;"><?= _e('Variação das criptomoedas em 24h') ?></h3>
                        <a href="<?= siteUrl('/coin-change/binance/btc/'); ?>">
                            <img alt="<?= _e('Variação das criptomoedas em 24h') ?>" src="/assets/img/4.png" style="width: 100%;" />
                        </a>
                        <p class="text-center description h4"><?= _e('Encontre a moeda com maior variação, veja a diferença entre o preço mínimo e o preço máximo das criptomoedas nas últimas 24h em diferentes exchanges e analise a posição do preço atual') ?></p>
                        <div class="text-center">
                            <a href="<?= siteUrl('/coin-change/binance/btc/'); ?>" class="btn btn-primary btn-raised">
                                <?= _e('Variação das criptomoedas') ?></a>
                        </div>
                    </div> 
                </div>
                <?php if ($lang == 'pt-br') { ?>
                    <div class="col-md-4">
                        <div class="card card-body" >
                            <h3 class="text-center" style=" font-size: 25px;;">Vídeos recentes sobre Bitcoin e Criptomoedas</h3>
                            <a href="<?= siteUrl('/videos-criptomoedas/') ?>">
                                <img alt="Vídeos recentes sobre Bitcoin e Criptomoedas" src="/assets/img/5.jpg" style="width: 100%;" />
                            </a>
                            <p class="text-center description h4">Filtramos os melhores vídeos sobre Bitcoin e criptomoedas em apenas um lugar.Nosso robô busca constantemente novos conteúdos no Youtube, fique atualizado!</p>
                            <div class="text-center">
                                <a href="<?= siteUrl('/videos-criptomoedas/') ?>" class="btn btn-primary btn-raised">
                                    Vídeos sobre criptomoedas</a>
                            </div>
                        </div> 
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>