//function loadWidgetCGLBitcoinBrasil() {
//
//    var host_base = 'https://coingolive.com';
//    var obj_cgl = document.getElementById("coingolive-bar-bitcoinbrasil");
//
//    var base_url_cgl = host_base + '/pt-br/bitcoin/brasil/resume/?cache=true&external=true';
//
//    var xhttp = new XMLHttpRequest();
//    xhttp.onreadystatechange = function () {
//        if (this.readyState == 4 && this.status == 200) {
//            obj_cgl.innerHTML = this.responseText;
//        }
//    };
//    xhttp.open("GET", encodeURI(base_url_cgl), true);
//    xhttp.send();
//};
//
//document.addEventListener("DOMContentLoaded", function(event) {
//    
//    loadWidgetCGLBitcoinBrasil();
//
//    setInterval(function () {
//        loadWidgetCGLBitcoinBrasil();
//    }, 60000);
//
//});