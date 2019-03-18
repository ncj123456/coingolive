function loadPage(page) {
    if (typeof page == 'undefined') {
        page = 0;
    }
    if (parseInt(page) < 0) {
        return false;
    }

    var name = $("#order_name").val();
    var order = $("#order_type").val();
    var order_filter_vol24h= $("#order_filter_vol24h").val();
    var busca = $('#input_busca').val().toString().trim();
    var min_rank = $("#min_rank").val();
    var max_rank = $("#max_rank").val();
    var user_favorite = localStorage.getItem("favorite");
    
    var url = '/coin/ath-price/?p=' + page;
    
            if(order_filter_vol24h!='1M'){
                url+='&vol24h=' + order_filter_vol24h;
            }
    
            if(busca){
                url+='&s=' + busca;
            }
            
             if(name === 'rank' && order==='asc'){
                 
             }else{
                url+='&name=' + name;
                url+='&order=' + order;
            }
           
            if(min_rank > 1 ){
                  url+='&min_rank=' + min_rank;
            }
             if(max_rank_all!=max_rank){
                  url+='&max_rank=' + max_rank;
            }
              if(user_favorite =='true' ){
                  url+='&favorite=' + user_favorite;
            }
        window.location.href =encodeURI(siteUrl(url));
//    $('#tableContent').load(encodeURI(siteUrl(url)));
}



$("#min_rank,#max_rank").on('blur', function () {
    loadPage();
});
$("#min_rank,#max_rank").keypress('blur', function (e) {
    if (e.keyCode == 13) {
        loadPage();
    }
});

$("#formBusca").on('submit', function () {
    loadPage();
    return false;
});

    $('.column-order').on('click', function () {
        var name = $(this).data('name');
        var order = $(this).data('order');

        $("#order_name").val(name);
        $("#order_type").val(order);

        loadPage();
    });
    
    function filterVol24h(type){
        $("#order_filter_vol24h").val(type);
        loadPage();
    }