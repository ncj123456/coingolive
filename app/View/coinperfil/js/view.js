function loadPage(page, marketcap) {
       location.reload();
}

$('#topMoedaAtual').hide();

$('#topMoedaAtual').click();

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

function resizeScreen(){
    var width = $(window).width();
    
    if(width < 992){
        $("#rowItems").removeClass("flex-md-row");
        $("#rowItems").addClass("flex-md-column");
    }else{
        $("#rowItems").removeClass("flex-md-column");
        $("#rowItems").addClass("flex-md-row");
    }
}

$(document).ready(function(){

    var to = $("#amount_from").val()
    to = 1;

    var pricemoeda = $("#amount_from").attr("pricemoeda"); 

    convertValues(to,pricemoeda);
    
    resizeScreen();
});

$(window).resize(function(){
    resizeScreen();
});
/*$(".amount-converter").on('keyup click change', function () {

    var from = parseFloat($("#amount_from").val());

    var result = price_coin*from;

    console.log(result);
    if(result > 1){
        result = result.toFixed(2);
    }else{
        result = result.toFixed(8);

    }
    //$("#amount_from").val(from);
    $(".amount-converter").each(function(){
        if ($(this).data("symbol") == "BTC"){
            $(this).val(result);
        }else if($(this).data("symbol") == "USD"){
            
        }
    });
    

    setTotal(result);
});*/

arr = all_prices_decoded;

function changeValue(){
   
    all_prices_decoded.forEach = function(f,s){
        console.log('adad');
    }
    
}
$(window).on(function(){

});

//Função Para Converter
function convertValues(to,result){
    //var classe = $(".amount-converter").hasClass("amount-this");
    
    $(".amount-converter").each(function(){
        if ($(this).hasClass("amount-this")){

           $(this).removeClass("amount-this");

        }else{

            var thisprice = $(this).attr("pricemoeda");             
            var res = thisprice/result*to;   
            res >= 1 ? res = res.toFixed(2) : res = res.toFixed(8);
            $(this).val(res); 
            var valueCoin = $("#amount_from").val();
            setTotal(valueCoin);

        }
    });
}

///Alteração Do Input 
$(".amount-converter").on("input",function () {

    var symbol = $(this).data("symbol");
    var to = parseFloat($(this).val()); 
    var pricemoeda = $(this).attr("pricemoeda"); 
    $(this).addClass("amount-this");
    convertValues(to,pricemoeda,symbol);

});

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