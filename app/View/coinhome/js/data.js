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
           
              if(user_favorite){
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
//    
//    allData7d2 = [];
//    for(var i in allData7d){
//        allData7d2.push(parseFloat(allData7d[i].toFixed(2)));
//    }
    
    $(".sparkline").each(function(){
        var obj =  $(this);
        var codigo =obj.data('codigo');
       var url = siteUrl('/coin-home/?codigo='+codigo);
        $.getJSON(url,function(data){
                        var opt = {
                            lineColor: '#ff0000',
                            fillColor: '#ffaaaa',
                            spotColor: '#005fbf'
                        };
                        var dataPrice = data.price;
                        if(dataPrice[0]<dataPrice[dataPrice.length-1]){
                            opt = {
                                lineColor: '#007f00',
                                fillColor: '#a6db72',
                                spotColor: '#005fbf'
                            };
                        }
                        obj.sparkline(data.price, {
                            type: 'line',
                            width: '166px',
                            height: '50px',
                            highlightLineColor: '#7f00ff',
                           minSpotColor: '#7f00ff',
                            maxSpotColor: '#7f00ff',
                            lineColor: opt.lineColor,
                            fillColor: opt.fillColor,
                            spotColor: opt.spotColor});
                    
                    $("#chart_vol24h_"+codigo).sparkline(data.vol24h, {
                        width: '166px',
                         height: '50px',
                         type: 'line',
                         fillColor: '#74d9f1',
                         lineColor: '#04748e'
                     });
                        });
    });