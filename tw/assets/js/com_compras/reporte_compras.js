//alert("version 1.0");

var table= "";



$(document).ready(function() {



    loadFiltroAll();



} );



function loadFiltroAll(){



  if ( table !="" ) {



    $('#my-table').DataTable().destroy();

    $("#folio").val("");



  }



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

        "search":         "Buscar por descripcion:",

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



              $('td:eq(2)', nRow).addClass( 'fontText' );



              $('td:eq(3)', nRow).addClass( 'alignCenter' );

             

              $('td:eq(6)', nRow).addClass( 'alignRight' );



              $('td:eq(7)', nRow).addClass( 'alignRight' );

              $('td:eq(8)', nRow).addClass( 'alignRight' );

              $('td:eq(9)', nRow).addClass( 'alignRight' );

              

              

            }



        },



        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Rcompras/loadPartidas?buscar="+$("#buscador").val() ,



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });



    $("#bestatus").val(6);



}



function loadFiltroEst(){



  if ( table !="" ) {



    $('#my-table').DataTable().destroy();

    //$("#folio").val("");



  }



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

        "search":         "Buscar por descripcion:",

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



              $('td:eq(2)', nRow).addClass( 'fontText' );



              $('td:eq(3)', nRow).addClass( 'alignCenter' );

             

              $('td:eq(6)', nRow).addClass( 'alignRight' );



              $('td:eq(7)', nRow).addClass( 'alignRight' );

              $('td:eq(8)', nRow).addClass( 'alignRight' );

              $('td:eq(9)', nRow).addClass( 'alignRight' );

              

              

            }



        },



        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Rcompras/loadPartidasEst?est="+$("#bestatus").val() ,



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });



    $("#buscador").val("");



}

function loadFiltroEntrelazado(){

  if ( table !="" ) {



    $('#my-table').DataTable().destroy();

    $("#folio").val("");



  }



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

        "search":         "Buscar por descripcion:",

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



              $('td:eq(2)', nRow).addClass( 'fontText' );



              $('td:eq(3)', nRow).addClass( 'alignCenter' );

             

              $('td:eq(6)', nRow).addClass( 'alignRight' );



              $('td:eq(7)', nRow).addClass( 'alignRight' );

              $('td:eq(8)', nRow).addClass( 'alignRight' );

              $('td:eq(9)', nRow).addClass( 'alignRight' );

              

              

            }



        },



        "processing": true,

        "serverSide": true,

        "search" : false,

        ajax: {

          url: base_urlx + "Rcompras/loadFiltroEntrelazado",

          type: "GET",

          data: {

            buscadorx: $("#buscador").val(),

            estatusx: $("#bestatus").val(),

          },

        },



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });



    /* $("#bestatus").val(6); */
}



function finalizarEntrada(idOrden) {

  $.ajax({
    type: "POST",
    dataType: "json",
    url: base_urlx+"Rcompras/searchRows/",
    data:{idODC:idOrden},
    cache: false,
    success: function(result)
    {
      if (result > 0){
        x=confirm("¿Deseas finalizar la: ODC#"+idOrden+" como parcial?");
        if(x){
          $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Rcompras/finallyEntrada/",
            data:{
              idODC:idOrden,
              estatus: 4
            },
            cache: false,
            success: function(result)
            {
              if (result > 0){
                location.reload();
              }else{
                alert("Ha ocurrido un error");
              }
            }
          }).fail( function( jqXHR, textStatus, errorThrown ) {
              detectarErrorJquery(jqXHR, textStatus, errorThrown);
          });
        }
      }else{
        x=confirm("¿Deseas finalizar la: ODC#"+idOrden+" como completa sin entradas?");
        if(x){
          $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Rcompras/finallyEntrada/",
            data:{
              idODC:idOrden,
              estatus: 5
            },
            cache: false,
            success: function(result)
            {
              if (result > 0){
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
    }
  }).fail( function( jqXHR, textStatus, errorThrown ) {
      detectarErrorJquery(jqXHR, textStatus, errorThrown);
  });
  
}


function cancelarOrden(idodc){



  x=confirm("¿Realmente deseas cancelar la ODC#"+idodc+"?");



  if (x) {



    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rcompras/cancelarOrden/",

            data:{odcx:idodc},

            cache: false,

            success: function(result)

            {



              if (result==0){



                alert("Alerta, la orden de compra no puede ser cancelada por que ya cuenta con una entrada");



              }else if (result==1) {



                alert("La Orden de compra ha sido CANCELADA");

                location.reload();



              }else{



                alert("Error, de persistir el error favor de comunicarse con el administrador del portal");



              }

              

                  

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {



        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



  }



}

function convertirAMayusculas() {
  var input = document.getElementById('buscador');
  input.value = input.value.toUpperCase();
}


function showExcelFiltrado() {  

  $.ajax({

    type: "POST",

    dataType: "json",

    url: base_urlx + "tw/php/crear_excel_odc.php",

    data: { select_estatusx: $("#bestatus").val(), inputx: $("#buscador").val() },

    cache: false,

    success: function (result) {

      if (result) {

        window.location.href = base_urlx + "tw/php/reporte/reportes_ODC.xlsx";


      } else {
        alert('No se pudo generar excel');
      }
    }
  });
  //alert(select_estatusx);
}


function cerrarSesion(){



  var x = confirm("¿Realmente deseas cerrar la sesión?");



  if( x==true ){



    window.location.href = base_urlx+"Login/CerrarSesion/";

    

  }  



}