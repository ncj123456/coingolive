<?php
$_title2 = _e("Ferramentas para investidores de criptomoedas");
$_meta_description = 'Ferramentas para investidores de criptomoedas, gráficos,  preços e históricos';
$lang = \Base\I18n::getCurrentLang();
?>
<div class="main main-raised"  style="margin: 0px!important">
    <div class="container">
        <div class="section" style="padding:70px 30px!important">
            <div class="row">
                <div class="col-md-4 ml-auto mr-auto">
                    <h2 class="text-center"><?= _e('Cotação máxima das criptomoedas') ?></h2>
                    <h4 class="text-center description"><?= _e('Estime o preço de cada moeda com a mesma capitalização de mercado do Bitcoin.') ?></h4>
                    <div class="text-center">
                        <a href="<?= siteUrl('/coin/price'); ?>" class="btn btn-primary btn-raised">
                            <?= _e('Cotação Máxima') ?></a>
                    </div>
                </div> 
                <div class="col-md-4">
                    <h2 class="text-center"><?= _e('Alta histórica das Criptomoedas') ?></h2>
                    <h4 class="text-center description"><?= _e('Análise em qual data foi atingida a alta histórica, qual a posição do preço atual e quantos por cento será o crescimento do preço atual em relação à alta histórica') ?></h4>
                    <div class="text-center">
                        <a href="<?= siteUrl('/coin/ath'); ?>" class="btn btn-primary btn-raised">
                            <?= _e('Alta Histórica') ?></a>
                    </div>
                </div>
                <div class="col-md-4 ml-auto mr-auto">
                    <h2 class="text-center"><?= _e('Histórico de crescimento criptomoedas') ?></h2>
                    <h4 class="text-center description"><?= _e('Análise o crescimento das criptomoedas no período de 24 horas, 1 mês, 3 meses, 6 meses e 1 ano') ?></h4>
                    <div class="text-center">
                        <a href="<?= siteUrl('/coin/change-history'); ?>" class="btn btn-primary btn-raised">
                            <?= _e('Histórico Crescimento') ?></a>
                    </div>
                </div>  
                <div class="col-md-4 ml-auto mr-auto">
                    <h2 class="text-center"><?= _e('Variação das criptomoedas em 24h') ?></h2>
                    <h4 class="text-center description"><?= _e('Encontre a moeda com maior variação, veja a diferença entre o preço mínimo e o preço máximo das criptomoedas nas últimas 24h em diferentes exchanges e analise a posição do preço atual') ?></h4>
                    <div class="text-center">
                        <a href="<?= siteUrl('/coin-change/binance/btc'); ?>" class="btn btn-primary btn-raised">
                            <?= _e('Variação das criptomoedas') ?></a>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>