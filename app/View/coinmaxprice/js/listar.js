loadPage(0);

$("#formBusca").on('submit', function () {

    var marketcap = toFloat($('#valor_total_market_cap_compare').val());
    loadPage(0, marketcap);
    return false;
});

function loadPage(page, marketcap) {
    if (typeof page == 'undefined') {
        page = 0;
    }
    if (parseInt(page) < 0) {
        return false;
    }

    if (!marketcap) {
        marketcap = '';
    }

    var name = $("#order_name").val();
    var order = $("#order_type").val();
    var busca = $('#input_busca').val().toString().trim();
    var compare = $('#compare_coin').val();
    var min_rank = $("#min_rank").val();
    var max_rank = $("#max_rank").val();
    var user_favorite = localStorage.getItem("favorite");

    var url = '/coin/price/data/?page=' + page
            + '&busca=' + busca +
            '&compare=' + compare +
            '&name=' + name +
            '&order=' + order +
            '&marketcap=' + marketcap +
            '&min_rank=' + min_rank +
            '&max_rank=' + max_rank +
            '&favorite=' + user_favorite;
    $('#tableContent').load(encodeURI(siteUrl(url)));
}

$("#btn_help_max_price").on('click', function () {
    $("#help_max_price").slideToggle();
});

function compareCoin(codigo) {
    var busca = $('#input_busca').val();
    window.location = "?compare=" + codigo + "&busca=" + busca;
}

$("#min_rank,#max_rank").on('blur', function () {
    loadPage(0);
});
$("#min_rank,#max_rank").keypress('blur', function (e) {
    if (e.keyCode == 13) {
        loadPage(0);
    }
});