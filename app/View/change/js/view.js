$("#input_busca").on('keyup',function(){
    var filter = $(this).val().toLowerCase();
    
        $('#table_coin_change ').find('tbody').find('tr').each(function () {
            var conteudoCelula = $(this).find('td:first').text();
            var corresponde = conteudoCelula.toLowerCase().indexOf(filter) >= 0;
            $(this).css('display', corresponde ? '' : 'none');
        });
});