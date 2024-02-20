//alert("version 1.0");

var clave;
var descripcion;
var unidad;
var cantidad;
var dantidad_rq;
var table= "";

function detectarErrorJquery(jqXHR, textStatus, errorThrown) {

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



$(document).ready(function() {
  loadFiltroEst();
} );



function loadFiltroEst(){

  if ( table !="" ) {
    $('#my-table').DataTable().destroy();
  }

    table = $('#my-table').DataTable({

      "language": {
        "lengthMenu": "Mostrando _MENU_ articulos por pagina",
        "zeroRecords": "No hay partidas que mostrar",
        "info": "Total _TOTAL_ partidas<br>",
        "infoEmpty": "No hay partidas que mostrar",
        "emptyTable": "No hay partidas que mostrar",
        "infoFiltered": "(filtrado de _MAX_ articulos totales)",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar por Ususario/Fecha/Documento:",
      },
      dom: '<"top"B fpil>rt',
      buttons: ['copy', 'excel', 'csv'],
      "order": [[2, "desc"]],

        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            /* Append the grade to the default row class name */
            if ( true ) // your logic here
            {

              $(nRow).addClass( 'customFont' );
              $('td:eq(0)', nRow).addClass( 'alignCenter' );
              $('td:eq(1)', nRow).addClass( 'alignCenter' );
              $('td:eq(2)', nRow).addClass( 'fontText' );
              $('td:eq(3)', nRow).addClass( 'alignCenter' );                                   

            }
        },

        "processing": true,
        "serverSide": true,
        "search" : false,
        "ajax": base_urlx+"Requerimientos/loadPartidasEst?est="+$("#bestatus").val() ,
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "scrollY": 450,
        "scrollX": true        

    });

    $('#my-table tbody').on('click', 'tr', function () {

      var data = table.row( this ).data();
      showRQ(data[5]);  
      
      $("#documento").html("RQ: "+data[4]);
      $("#solicito").html("Solicito: "+data[3]);
      $("#fecha").html("Fecha: "+data[2]);

  } );

}

function showRQ(idRQ){

  if ( idRQ > 0 ) {
    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Requerimientos/showRQ/",
            data:{ idRq:idRQ },
            cache: false,
            success: function(result)
            {

              if ( result != null ) {                  

                  var creaOption=""; 

                  $.each(result, function(i,item){

                    clave= item.clave;
                    descripcion= item.descripcion;
                    unidad= item.unidad;
                    cantidad= item.cantidad;
                    cantidad_rq = item.cantidad_rq;

                    creaOption=creaOption+'<li><div class="user-detail"><h5>'+clave+'</h5<p>'+descripcion+'</p><p>Pedido: '+cantidad+unidad+'</p><p>Requerido: '+cantidad_rq+unidad+'</p></div></li>'; 
                    
                  }); 

                  $("#lista_contacto").html(creaOption);                

              }else{
                 $("#lista_contacto").html("");
              }
            }
    }).fail( function( jqXHR, textStatus, errorThrown ) {
        detectarErrorJquery(jqXHR, textStatus, errorThrown);
    });
  }
}


function cancelarRQ(idRQ) {
  x=confirm("¿Deseas cancelar el Requerimiento?");
        if(x){
          $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Requerimientos/cancelarRQ/",
            data:{
              idRq:idRQ,
            },
            cache: false,
            success: function(result)
            {
              if (result){
                location.reload();
              }else{
                alert("Ha ocurrido un error");
              }
            }
          }).fail( function( jqXHR, textStatus, errorThrown ) {
              detectarErrorJquery(jqXHR, textStatus, errorThrown);
          });
        }
}


function cerrarSesion(){



  var x = confirm("¿Realmente deseas cerrar la sesión?");



  if( x==true ){



    window.location.href = base_urlx+"Login/CerrarSesion/";

    

  }  



}

