function changeMoeda(moeda, callback) {
    $.get(siteUrl('/moeda/change/?moeda=' + moeda), function () {
        if (typeof callback === 'function') {
            callback();
        }
        $('.moedaAtual').text(moeda);
    });

}


var allMoedas = false;

function loadAlllCoinJson(callback) {
    if (!allMoedas) {
        //$('.go_selectbox').on('click', function () {
        $.getJSON('/assets/moedas.json', function (json) {
            allMoedas = json;
            callback();
        });
    }
}

//});

$(".go_selectbox").each(function () {
    var obj = $(this);
    var input = obj.find('.go_selectbox_input');
    var btn = obj.find('.go_selectbox_btn');
    btn.on('click', function () {
        btn.parent().tooltip('dispose');
        setTimeout(function () {
            input.focus();
        }, 100);

        loadAlllCoinJson(function () {
            input.trigger('keyup');
        });


    });
    input.on('keyup', function () {
        var nomeFiltro = $(this).val().toLowerCase();
        var element = $(this).parents('.dropdown-menu').find('.opts');
        var limit = 8;
        var count = 0;
        var html = '';

        for (var i in allMoedas) {
            var desc = allMoedas[i];
            var corresponde = desc.toString().toLowerCase().indexOf(nomeFiltro) >= 0;
            if (corresponde) {
                if (count < limit) {
                    console.log(desc);
                    var icon = '<img style="width:25px;padding-right:5px" src="/assets/img/coin/' + i + '.png" /> ';
                    html += '<a href="javascript:compareCoin(\'' + i + '\')" class="dropdown-item">' + icon + desc + '</a>';
                    count++;
                } else {
                    break;
                }
            }
        }
        element.html(html);
    });
});


$("#valor_total_market_cap_compare").on('keyup', function () {
    var valorBase = toFloat($("#valor_total_market_cap_compare_base").val());
    var valorInput = toFloat($(this).val());

    var porc = valorInput * 100 / valorBase;

    $("#porc_total_market_cap_compare").val(toMoeda(porc, 0));

});

$("#porc_total_market_cap_compare").on('keyup', function () {
    var valorBase = toFloat($("#valor_total_market_cap_compare_base").val());
    var porcInput = toFloat($(this).val());

    var valor = valorBase * porcInput / 100;

    $("#valor_total_market_cap_compare").val(toMoeda(valor, 0));

});

function toFloat(val) {
    var val2 = 0;
    if (currentLang === 'en') {
        val2 = val.toString().replace(/\,/g, '');
    } else {
        val2 = val.toString().replace(/\./g, '');
    }
    return parseFloat(val2);
}

function toMoeda(val, dec) {
    if (currentLang === 'en') {
        return val.toFixed(dec).replace(/(.)(?=(\d{3})+$)/g, '$1,');
    }
    return val.toFixed(dec).replace(/(.)(?=(\d{3})+$)/g, '$1.');
}

if (currentLang === 'en') {
    $('#valor_total_market_cap_compare').mask('000,000,000,000,000,000,000', {reverse: true});
    $('#porc_total_market_cap_compare').mask('000,000,000,000,000', {reverse: true});
} else {
    $('#valor_total_market_cap_compare').mask('000.000.000.000.000.000.000', {reverse: true});
    $('#porc_total_market_cap_compare').mask('000.000.000.000.000', {reverse: true});
}

$("#valor_total_market_cap_compare,#porc_total_market_cap_compare ").on('change', function () {
    var val = toFloat($('#valor_total_market_cap_compare').val());
    loadPage(0, val);
});
$("#valor_total_market_cap_compare,#porc_total_market_cap_compare ").on('keyup', function (e) {
    if (e.keyCode == 13) {
        $('#valor_total_market_cap_compare').trigger('change');
    }
});



function addFavorite(id_coin) {
    $.ajax({
        type: "POST",
        url: siteUrl('/user/favorite/coin/'),
        data: {id_coin: id_coin},
        dataType: "json",
        success: function (res) {
            if (res.success) {
                var icon = $('#user_favorite_' + id_coin);

                if (res.success) {
                    icon.removeAttr("class");

                    if (res.msg === "insert") {
                        icon.attr("class", "fa fa-star");
                    } else if (res.msg === "delete") {
                        icon.attr("class", "fa fa-star-o");
                        loadPage();
                    }
                }

            } else {
                modalRegister();
            }
        },
        error: function () {
            alert('An error has occurred, please try again later');
        }
    });
}

function modalRegister() {
    $("#modalLogin").modal('show');
    $("#modalLoginBody").load(siteUrl('/user/register/ajax/'));
}

function modalLogin() {
    $("#modalLogin").modal('show');
    if ($('.navbar-toggler').hasClass('toggled')) {
        $('.navbar-toggler').click();
    }
    $("#modalLoginBody").load(siteUrl('/user/register/ajax/?login'));
}

function favoriteFilter() {
    var favorite = localStorage.getItem("favorite");
    if (favorite == "true") {
        favorite = "false";
    } else {
        favorite = "true";
    }
    localStorage.setItem("favorite", favorite);
    loadPage();
}

function formAjax(obj) {
    var form = $(obj);
    var func_success = form.data('func-success');
    $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize(),
        dataType: "json",
        success: function (res) {
            eval(func_success)(form, res);
        },
        error: function () {
            alert('An error has occurred, please try again later');
        }
    });
    return false;
}