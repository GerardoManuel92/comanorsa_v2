

$(document).ready(function() {

	////////////////************ TABLA 

	table = $('#my-table').DataTable({
      	"language": {
            "lengthMenu": "Mostrando _MENU_ articulos por pagina",
            "zeroRecords": "No hay partidas que mostrar",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay partidas que mostrar",
            "emptyTable":"No hay partidas que mostrar",
            "infoFiltered": "(filtrado de _MAX_ articulos totales)",
            "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search":         "Buscar por descripcion:",      
        },
        dom: '<"top"B pl>rt',
        buttons: [ 'copy', 'excel' , 'csv', 'pdf'],
        "order": [  [ 0, "desc" ] ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {          
            if ( true ) // your logic here
              {
                $(nRow).addClass( 'customFont' );                
                $('td:eq(0)', nRow).addClass( 'alignCenter' );
                $('td:eq(1)', nRow).addClass( 'alignCenter' );
                $('td:eq(2)', nRow).addClass( 'alignCenter' );
                $('td:eq(3)', nRow).addClass( 'alignCenter' ).addClass('fontText16');
                $('td:eq(4)', nRow).addClass( 'alignCenter' ).addClass('fontText16');
                $('td:eq(5)', nRow).addClass( 'alignCenter' ).addClass('fontText16');                                
              }
        },
        "processing": true,
        "serverSide": true,
        "search" : false,
        "ajax": base_urlx+"Kardex/loadPartidas?idparte="+idpartex,
      //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "scrollY": 400,
        "scrollX": true
    });
    table
    .buttons()
    .container()
    .appendTo( '#controlPanel' );
    //$("#tneto").html("Calculando...");
});