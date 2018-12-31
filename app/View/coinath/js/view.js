loadPage();
function loadPage(page) {
    if (typeof page == 'undefined') {
        page = 0;
    }
    if (parseInt(page) < 0) {
        return false;
    }

    var name = $("#order_name").val();
    var order = $("#order_type").val();
    var busca = $('#input_busca').val().toString().trim();
    var min_rank = $("#min_rank").val();
    var max_rank = $("#max_rank").val();
    var user_favorite = localStorage.getItem("favorite");
    
    var url = '/coin/ath/data/?page=' + page +
            '&busca=' + busca +
            '&name=' + name +
            '&order=' + order +
            '&min_rank=' + min_rank +
            '&max_rank=' + max_rank+
            '&favorite=' + user_favorite;
    $('#tableContent').load(encodeURI(siteUrl(url)));
}



$("#min_rank,#max_rank").on('blur', function () {
    loadPage(0);
});
$("#min_rank,#max_rank").keypress('blur', function (e) {
    if (e.keyCode == 13) {
        loadPage(0);
    }
});

$("#formBusca").on('submit', function () {

    loadPage(0);
    return false;
});