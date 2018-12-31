function loadWidgetCoinGoLive() {

    var host_base = 'https://coingolive.com/';
    var elements_cgl = document.getElementsByClassName("coingolive-currency-widget");

    for (var i = 0; i < elements_cgl.length; ++i) {

        var obj_cgl = elements_cgl[i];

        var currency_name_cgl = obj_cgl.dataset.currencyname;
        var currency_base_cgl = obj_cgl.dataset.currencybase;
        var moeda_cgl = obj_cgl.dataset.moeda;
        var lang_cgl = obj_cgl.dataset.lang;


        var base_url_cgl = host_base + lang_cgl + '/widget/view/';

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                obj_cgl.innerHTML = this.responseText;
            }
        };
        var par_cgl = '?name=' + currency_name_cgl + '&base=' + currency_base_cgl + '&moeda=' + moeda_cgl;
        xhttp.open("GET", encodeURI(base_url_cgl + par_cgl), true);
        xhttp.send();
    }
}
if (typeof cgl_trigger_manuel == 'undefined' || !cgl_trigger_manuel) {
    window.onload = loadWidgetCoinGoLive;
}