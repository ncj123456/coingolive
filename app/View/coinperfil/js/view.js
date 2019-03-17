function loadPage(page, marketcap) {
       location.reload();
}

$('#topMoedaAtual').hide();

$(".market-cap-rank").each(function () {
    var loading = '<i class="fa fa-refresh fa-spin"></i>';
    var obj = $(this);
    obj.html(loading);
    var merket_cap = obj.data('market-cap');
    var url = siteUrl('/market-cap-rank/?market_cap=' + merket_cap);
    $.get(url, function (data) {
        data = JSON.parse(data);
        obj.text(data.rank);
    });
});

$("#amount_from").on('keyup click change', function () {
    var from = parseFloat($("#amount_from").val());
    
    var result = price_coin*from;
    
      if(result > 1){
        result = result.toFixed(2);
    }else{
         result =result.toFixed(8);
    }
    
    $("#amount_to").val(result);
      setTotal(from);
});
$("#amount_to").on('keyup click change', function () {
    var to = parseFloat($("#amount_to").val());
    
    var result = to/price_coin;
    
    if(result > 1){
        result =result.toFixed(2);
    }else{
        result =result.toFixed(8);
    }
    
    $("#amount_from").val(result);
    
     setTotal(result);
});
$("#amount_to,#amount_from").on('focus',function(){
    $(this).select();
});

$("#amount_from").val('1');
$("#amount_from").trigger('keyup');


function setTotal(amount){
    $(".price-total").each(function(){
        let price = parseFloat($(this).data('price'));
        let total = amount*price;
        
            if(total > 1){
                total =formatTotal(total,2);
            }else{
                total =formatTotal(total,8); 
            }
            
            $(this).text(amount+'x = '+total);
    });
}

function formatTotal(val, dec) {
    if (currentLang === 'en') {
        if(val<1){
             return moeda_char+val.toFixed(dec);
        }
        return moeda_char+val.toFixed(dec).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
     if(val<1){
             return moeda_char+val.toFixed(dec);
        }
    return moeda_char+val.toFixed(dec).replace('.',',').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}