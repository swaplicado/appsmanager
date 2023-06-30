function drawTable(table_name, lData){
    table[table_name].clear().draw();
    table[table_name].rows.add(lData).draw();
}

function renderInTable(table_name, column, elements){
    table[table_name].rows().every(function(rowIdx) {
        var row = this;
        var checkBoxTd = $(row.node()).find('td:eq('+column+')'); // accede a la celda, el index de la celda es apartir de la primer celda que se muestra en la vista, las olcultas no cuentan

        checkBoxTd.html(elements[rowIdx]);
      });
}