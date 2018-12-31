$("#btn_help_max_price").on('click', function () {
    $("#help_max_price").slideToggle();
});

function loadPage(page, marketcap) {
    var compare = $("#input_compare_coin").val();
    if (typeof marketcap === 'undefined') {
        marketcap = '';
    }
    window.location = "?compare=" + compare + "&marketcap=" + marketcap;
}


function compareCoin(codigo) {
    window.location = "?compare=" + codigo;
}

$("#formBusca").on('submit', function () {

    var busca = $("#input_busca").val();
    window.location = siteUrl('/coin/price/?busca=' + busca);
    return false;
});

$("#porc_total_market_cap_compare").val($("#porc_marketcap_perfil").val());
$("#valor_total_market_cap_compare").val($("#valor_marketcap_perfil").val());
$("#valor_total_market_cap_compare_base").val($("#base_marketcap_perfil").val());


var show_widget = false;
$("#btn_widget").on('click', function () {
    if (!show_widget) {
        loadWidgetCoinGoLive();
        show_widget = true;
    }
    $("#codigo_widget").slideToggle();
});