
$("#formBusca").on('submit', function () {
    loadPage();
    return false;
});

function loadPage(page, marketcap) {
    if (!page) {
        page = 0;
    }
    if (parseInt(page) < 0) {
        return false;
    }

    if (!marketcap) {
            if(input_marketcap_url > 0){
                marketcap=input_marketcap_url;
            }else{
                marketcap = '';
            }
    }
    

    var name = $("#order_name").val();
    var order = $("#order_type").val();
    var busca = $('#input_busca').val().toString().trim();
    var compare = $('#compare_coin').val();
    var min_rank = $("#min_rank").val();
    var max_rank = $("#max_rank").val();

    var url = '/coin/price/';
//            if(page>0){
                 url+='?p=' + page;
//            }
            if(busca !== ''){
               url+='&s=' + busca;
            }
             if(compare !== 'bitcoin'){
                url+='&compare=' + compare;
            }
            
             if(name === 'rank' && order==='asc'){
                 
             }else{
                url+='&name=' + name;
                url+='&order=' + order;
            }
            
            if(marketcap){
                 url+='&marketcap=' + marketcap;
             }
              
             if(min_rank!=1){
                    url+= '&min_rank=' + min_rank 
             }
                
            if(max_rank_all!=max_rank){
                url+='&max_rank=' + max_rank
            }
            
            if(user_favorite){
                    url+= '&favorite=' + user_favorite;
             }
    
//    alert(max_rank);
    window.location.href =encodeURI(siteUrl(url));
//    $('#tableContent').load(encodeURI(siteUrl(url)));
}

$("#btn_help_max_price").on('click', function () {
    
    $('html,body').animate({
        scrollTop: $("#help_max_price").offset().top
    }, 'falst');
});

function compareCoin(codigo) {
    $('#compare_coin').val(codigo);
    input_marketcap_url=0;
     loadPage();
}

$("#min_rank,#max_rank").on('blur', function () {
    loadPage();
});
$("#min_rank,#max_rank").keypress('blur', function (e) {
    if (e.keyCode == 13) {
        loadPage();
    }
});

$('.column-order').on('click', function () {
            var name = $(this).data('name');
            var order = $(this).data('order');

            $("#order_name").val(name);
            $("#order_type").val(order);

            loadPage();
});