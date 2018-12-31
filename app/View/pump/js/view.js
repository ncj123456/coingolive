
socket.emit('get_last_line');
socket.on('last_line', function (obj) {
    createTable(obj.data);
    console.log(obj);
});

socket.on('change_data', function (obj) {
    console.log(obj);
    createTable(obj.data);

});

function createTable(data) {
    var html = '';

    var table = $("#content_table");

    table.css({background: "#9e58b21f"});

    for (var i in data) {
        var row = data[i];

        if (row.id_exchange !== 1) {
            continue;
        }

        html += ' <tr>' +
                '<td class="text-center">' + row.id_exchange + '</td>' +
                '<td class="text-center">' + row.symbol + '</td>' +
                '<td class="text-center">' + parseFloat(row.open_price).toFixed(8) + '</td>' +
                '<td class="text-center">' + parseFloat(row.last_price).toFixed(8) + ' </td>' +
                '<td class="text-center">' + parseFloat(row.porc).toFixed(2) + ' </td>' +
                '<td class="text-center">' + parseFloat(row.volume).toFixed(3) + ' </td>' +
                '</tr>';
    }

    table.html(html);
    setTimeout(function(){
        
    table.css({background: ""});
    },500);
    
}