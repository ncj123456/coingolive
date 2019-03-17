<?php
$_title = _e("Histórico Preço Criptomoedas, Valorização e Desvalorização");

$_meta_description = _e('Histórico de preço bitcoin e criptomoedas, acompanhe a variação do valor em diferentes períodos 1 hora, 7 dias, 1 mês e 1 ano, ordene e filtre a porcentagem de valorização e desvalorização das criptomoedas.');

$compare_coin = isset($_GET['compare']) ? $_GET['compare'] : 'bitcoin';
$current_moeda = isset($_COOKIE['moeda']) ? $_COOKIE['moeda'] : 'USD';
$listMoeda = \Base\I18n::getListMoeda();
        
if(!isset($listMoeda[$current_moeda])){
    $current_moeda='USD';
}
$inputOrderName = isset($_GET['name']) ? $_GET['name'] : 'rank';
$inputOrderType = isset($_GET['order']) ? $_GET['order'] : 'asc';
?>
<script>
var max_rank_all = <?= $max_rank_all ?>;
</script>
<input type="hidden" id="order_name" value="<?= $inputOrderName ?>"/>
<input type="hidden" id="order_type" value="<?= $inputOrderType ?>"/>

<div class="row" style="margin: 0px;">
    <div class="col-md-12">
        <h1 style="padding: 3px;margin-top:20px;font-size:25px"><?= _e($_title) ?></h1>
    </div>
    <div class="col-md-12">
        <div class="card" style="  margin-top: 0px;">
            <div class="card-body" style="padding:0;margin-left: 10px;margin-right: 10px">
                <div class="row">
                    <div class="col-5"  style="margin-top: 15px;max-width: 120px">
                        <?= _e('Conversão') ?> <i data-toggle="tooltip" title="<?= _e('Os valores serão convertidos na moeda selecionada') ?>" class="fa fa-question-circle-o help" style="color:#9124a3;"></i>
                        <div class="dropdown">
                            <button class="btn-sm btn btn-primary  dropdown-toggle moedaAtual" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $current_moeda ?>
                            </button>
                            <div class="dropdown-menu ">
                                <?php
                                foreach ($listMoeda as $n => $char) {
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
                    <div class="col-md-6 col-7">
                        <div class="row">
                            <div class="form-group col-6" style="padding-top: 0px!important;margin-top: 15px; max-width: 110px">
                                <?= _e('Rank início') ?>
                                <input id="min_rank" type="number" class="form-control text-center"  value="<?= $min_rank; ?>">
                            </div>
                            <div class="form-group col-6" style="padding-top: 0px!important;margin-top: 15px;max-width: 110px">
                                <?= _e('Rank fim') ?>                                
                                <input id="max_rank" type="number" class="form-control text-center"  value="<?= $max_rank; ?>">
                            </div>
                        </div>
                        <!--<div id="sliderLimit" class="slider" style=""></div>-->
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 ml-auto">
                        <form method="POST" id="formBusca">
                            <div  class="form-group input-group has-default bmd-form-group">
                                <input type="text" name="input_busca" id="input_busca"  class="form-control" placeholder="<?= _e('Pesquisar moeda'); ?>"  value="<?= isset($_GET['s']) ? $_GET['s'] : '' ?>">
                                <button type="submit" class="btn btn-sm btn-primary btn-raised btn-fab btn-round">
                                    <i class="material-icons">search</i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div>
                    <?php  require_once 'data_content.php'; ?>
                </div>

            </div>
        </div>
    </div> 
</div>
<div class="text-center">
     <?= _e('Fonte dos dados:') ?> <a href="https://coingecko.com" target="_blank">CoinGecko</a>
</div>