

function detectarErrorJquery(jqXHR, textStatus, errorThrown){


  if (jqXHR.status === 0) {

    alert('Not connect: Verify Network.');

  } else if (jqXHR.status == 404) {

    alert('Requested page not found [404]');

  } else if (jqXHR.status == 500) {

    alert('Internal Server Error [500].');

  } else if (textStatus === 'parsererror') {

    alert('Requested JSON parse failed.');

  } else if (textStatus === 'timeout') {

    alert('Time out error.');

  } else if (textStatus === 'abort') {

    alert('Ajax request aborted.');

  } else {

    alert('Uncaught Error: ' + jqXHR.responseText);

  }

}

function formatNumber(num) {
   num += '';
   var splitStr = num.split(',');
   var splitLeft = splitStr[0];
   var splitRight = splitStr.length > 1 ? ',' + splitStr[1] : '';
   var regx = /(\d+)(\d{3})/;
   while (regx.test(splitLeft)) {
      splitLeft = splitLeft.replace(regx, '$1' + ',' + '$2');
   }



   return "$ "+splitLeft + splitRight;
}

function round(num, decimales = 2) {
    var signo = (num >= 0 ? 1 : -1);
    num = num * signo;
    if (decimales === 0) //con 0 decimales
        return signo * Math.round(num);
    // round(x * 10 ^ decimales)
    num = num.toString().split('e');
    num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
    // x * 10 ^ (-decimales)
    num = num.toString().split('e');
    return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
}


function calcularTotal(sub,desc,iva){

	tsub = sub.replace(/[^\d.]/g,"");
	tdesc = desc.replace(/[^\d.]/g,"");
	tiva = iva.replace(/[^\d.]/g,"");

	total = parseFloat(tsub)-parseFloat(tdesc)+parseFloat(tiva);

	return formatNumber( round(total) );

}

$(document).ready(function() {

  ///////////primera imagen  

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
        "search":         "Buscar por descripcion o clave:",
        "paginate": {
            "first":      "Primero",
            "last":       "Ultimo",
            "next":       "Siguiente",
            "previous":   "Anterior"
        }
        },

        dom: '<"top"B fpl>rt',

        buttons: [ 'copy', 'excel' , 'csv'],
        "order": [  [ 4, "desc" ] ],

        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            /* Append the grade to the default row class name */
            if ( true ) // your logic here
	        {

	          $(nRow).addClass( 'customFont' );

	          $('td:eq(0)', nRow).addClass( 'alignCenter' );
	          $('td:eq(1)', nRow).addClass( 'alignCenter' );

	          $('td:eq(2)', nRow).addClass( 'fontText2center' );

	          $('td:eq(3)', nRow).addClass( 'alignCenter' );
	          $('td:eq(4)', nRow).addClass( 'alignCenter' );
	          $('td:eq(6)', nRow).addClass( 'alignCenter' );

	          $('td:eq(7)', nRow).addClass( 'alignRight' );
	          $('td:eq(8)', nRow).addClass( 'fontText2red' );
	          $('td:eq(9)', nRow).addClass( 'alignRight' );
	          $('td:eq(10)', nRow).addClass( 'alignRight' );
	          
	          
	        }

        },
        "processing": true,
        "serverSide": true,
        "search" : false,
        "ajax": base_urlx+"Pmvendidos/loadPartidas" ,

      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

        "scrollY": 450,
        "scrollX": true
    });

    /////////////********* CLICK 
    $('#my-table tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();



        

    } );


} );


function cerrarSesion(){

  var x = confirm("¿Realmente deseas cerrar la sesión?");

  if( x==true ){

    window.location.href = base_urlx+"Login/CerrarSesion/";
    
  }

}
