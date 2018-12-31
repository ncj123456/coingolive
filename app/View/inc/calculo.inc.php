<div class="row">
    <div class="col-lg-2 col-md-2 col-sm-12"  style="margin-top: 15px;max-width: 120px">
        <?= _e('Conversão') ?> <i data-toggle="tooltip" title="<?= _e('Os valores serão convertidos na moeda selecionada') ?>" class="fa fa-question-circle-o help" style="color:#9124a3;"></i>
        <div class="dropdown">
            <button class="btn-sm btn btn-primary  dropdown-toggle moedaAtual" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= $current_moeda ?>
            </button>
            <div class="dropdown-menu ">
                <?php
                $listLangs = \Base\I18n::getListMoeda();
                foreach ($listLangs as $n => $char) {
                    ?>
                    <a href="javascript:changeMoeda('<?= $n ?>',loadPage)" class="dropdown-item">
                        <?= $n ?>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12"  style="margin-top: 15px;min-width: 200px;">
        <?= _e('Moeda Base Market Cap'); ?> <i data-toggle="tooltip" title="" class="fa fa-question-circle-o help" style="color:#9124a3;" data-original-title="<?= _e('Moeda Base para estimativa do \'Preço Máximo\' e \'Crescimento\' de todas as moedas apresentadas na lista. Os cálculos são baseados em sua capitalização de mercado atual'); ?>"></i>
        <div class="dropdown go_selectbox">
            <button class="btn btn-primary btn-block btn-sm dropdown-toggle go_selectbox_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= $compare_coin ?>
            </button>
            <div class="dropdown-menu ">
                <div style="padding: 10px">
                    <input type="text"   class="form-control go_selectbox_input"  placeholder="buscar"/>
                </div>
                <div class="opts">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12" style=" max-width: 120px;">
        <div class="form-group" style="padding-top: 0px!important;margin-top: 15px;">
            <?= _e('Market Cap') ?> <i data-toggle="tooltip"  class="fa fa-question-circle-o help" style="color:#9124a3;" title="<?= _e('Porcentagem do Market Cap da \'Moeda Base\'  para facilitar a variação do do campo \'Market Cap Estimado\'. Sua alteração implica diretamente nos campos \'Preço Máximo\' e \'Crescimento\' de todas as moedas apresentadas na lista.'); ?>"></i>
            <div class="input-group">
                <input   id="porc_total_market_cap_compare" type="text" class="form-control text-right" placeholder="">
                <div class="input-group-prepend">
                    <span class="input-group-text">%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-12" style=" max-width: 193px;">
        <div class="form-group" style="padding-top: 0px!important;margin-top: 15px;">
            <?= _e('Market Cap Estimado'); ?> <i data-toggle="tooltip"  class="fa fa-question-circle-o help" style="color:#9124a3;display: " title="<?= _e('Estimativa do valor total acumulado em investimentos na moeda. Sua alteração implica diretamente nos campos \'Preço Máximo\' e \'Crescimento\' de todas as moedas apresentadas na lista.'); ?>"></i>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text moeda-char"><?= $current_moeda ?></span>
                </div>
                <input type="hidden" id="valor_total_market_cap_compare_base"/>
                <input  id="valor_total_market_cap_compare"  type="text" class="form-control" placeholder="Insira um valor ">
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 ml-auto" style="padding: 0px 0px 0px 30px ">
        <div class="row">
            <?php 
            $colBusca = 9;
            if(!$disableRank){
                $colBusca=5;
                ?>
            <div class="form-group col-3" style="padding: 2px!important;margin-top: 15px; max-width: 110px">
                <?= _e('Rank início') ?>
                <input id="min_rank" type="number" class="form-control text-center"  min="1">
            </div>
            <div class="form-group col-3" style="padding: 2px!important;margin-top: 15px;max-width: 110px">
                <?= _e('Rank fim') ?>                                
                <input id="max_rank" type="number" class="form-control text-center" min="1" >
            </div>
            <?php } ?>
            <div class="col-<?= $colBusca ?>" style="padding: 0px 0px 0px 10px ">
                <form method="POST" id="formBusca" >
                    <div  class="form-group input-group has-default bmd-form-group" style="padding-top:40px">
                        <input type="text" name="input_busca" id="input_busca"  class="form-control" placeholder="<?= _e('Pesquisar'); ?>"  value="<?= isset($_GET['busca']) ? $_GET['busca'] : '' ?>">
                        <button type="submit" class="btn btn-sm btn-primary btn-raised btn-fab btn-round">
                            <i class="material-icons">search</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>