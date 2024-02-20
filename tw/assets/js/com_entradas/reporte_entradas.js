//alert("version 1.0");
var idClientex = 0;
var idCotizacionx = 0;
var table ="";


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

///****** FILTRAR 

showInfo();

function showInfo(){

  if ( table !="" ) {

    $('#my-table').DataTable().destroy();
    //$("#folio").val("");

  }

  /*filtrar entre cliente y vendedor*/

  table = $('#my-table').DataTable({

      "language": {

            "lengthMenu": "Mostrando _MENU_ articulos por pagina",
            "zeroRecords": "No hay partidas que mostrar",
            "info": "Total _TOTAL_ partidas<br>",
            "infoEmpty": "No hay partidas que mostrar",
            "emptyTable":"No hay partidas que mostrar",
            "infoFiltered": "(filtrado de _MAX_ articulos totales)",
            "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search":         "Buscar en la tabla por:",
        "paginate": {
            "first":      "Primero",
            "last":       "Ultimo",
            "next":       "Siguiente",
            "previous":   "Anterior"
        }
        },

        dom: '<"top" pli>rt',

        buttons: [ 'copy', 'excel' , 'csv'],
        "order": [  [ 3, "desc" ] ],

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
        "ajax": base_urlx+"Rentradas/loadPartidasFiltro?buscador="+$("#buscador").val() + "&estatusx=" + $("#bestatus").val(),

      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

        "scrollY": 450,
        "scrollX": true
    });

    /////////////********* CLICK 
    $('#my-table tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();

        //alert("idcliente:"+data[12]);
        //showContacto(data[12]);

        //$("#titulo").html("Enviar cotización: "+data[5]);

        //idClientex = data[12];
        //idCotizacionx = data[11];

        //$("#vercotizacion").html('<a href="'+base_urlx+'tw/php/cotizaciones/cot'+data[11]+'.pdf" target="_blank" style="color:red; font-weight: bold; font-size: 15px;"> <i class="fa fa-eye" style="color:red; font-weight: bold; font-size: 15px;"></i> Ver cotización</a>')

    } );

}

function cambiarEstatus(identx){

  x=confirm("¿Realmente deseas cancelar la Entrada#"+identx+"?");

  if (x) {

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Rentradas/cambiarEstatus/",
            data:{identradax:identx},
            cache: false,
            success: function(result)
            {

              if (result==false){

                alert("Alerta, la entrada no puede ser cancelada por que el producto ya fue entregado");

              }else if (result==true) {

                alert("La Entrada ha sido CANCELADA");
                location.reload();

              }else{

                alert("Error, de persistir el error favor de comunicarse con el administrador del portal");

              }

              //alert(result);
              
                  
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {

        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

  } 

}

function showExcel() {


  $.ajax({

    type: "POST",

    dataType: "json",

    url: base_urlx + "tw/php/crear_excel_entradas.php",

    data: { inputx: $("#buscador").val(), statusx : $("#bestatus").val() },

    cache: false,

    success: function (result) {

      if (result) {

        window.location.href = base_urlx + "tw/php/reporte/reporte_entradas.xlsx";


      } else {
        alert('No se pudo generar excel');
      }
    }
  });
}

/*function crearPdf(){

  $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Rentradas/showEntradas/",
            cache: false,
            success: function(result)
            {

                $.each(result, function(i,item){
                      ident=item.id;//id

                      $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: base_urlx+"tw/php/pdf_entrada.php",
                        data:{identrada:ident},
                        cache: false,
                        success: function(result)
                        {
                           
                          console.log(ident);

                        }

                      });
                      
                });


                alert("El proceso a finalizado");

            }

  });

}*/