//alert("version 3.0");

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





function calcularTotal(sub,desc,iva){



	tsub = sub.replace(/[^\d.]/g,"");

	tdesc = desc.replace(/[^\d.]/g,"");

	tiva = iva.replace(/[^\d.]/g,"");



	total = parseFloat(tsub)-parseFloat(tdesc)+parseFloat(tiva);



	return formatNumber( round(total) );



}



function CierraPopup() {



  $('#cerrarx').click(); //Esto simula un click sobre el botón close de la modal, por lo que no se debe preocupar por qué clases agregar o qué clases sacar.

  $('.modal-backdrop').remove();//eliminamos el backdrop del modal



}

// Funciones de eventos

$("#valueEntradaPago").on('input', function() {
  var valor = $(this).val();
  var maximo = parseInt($(this).attr('max'));

  if (valor < 0) {
      $(this).val(0);
  }
  if (valor > maximo) {
      $(this).val(maximo);
  }
}).on('paste', function(e) {
  e.preventDefault(); // Evita que se realice la acción de pegado
});


// Funciones cargadas al iniciar

showInfo();
showCuentas();



/////////****************** SELECT SUB-CATEGORIAS

function formatoMoneda(valor) {

  valor = parseFloat(valor).toFixed(2);
  valor = '$' + valor.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
  return valor;

}


function actCuenta(){
  verificar=0;

  if ( $("#cuenta").val() == 0 || $("#cuenta").val() == null ){

    alert("Alerta, favor de seleccionar una cuenta de empresa valida");
    verificar=1;

  }

  if ( $("#name_factpdf").val()== "" && verificar==0 ) {

    alert("Alerta, favor de subir un archivo valido");
    verificar=1;

  }


  if(verificar==0){
    $("#btncargar").attr('disabled', true);
      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/actualizacion_pagos_odc.php",//prueba
          //url: base_urlx+"tw/php/crear_xml_facturalo.php",
          data:{ 

            archivo:$("#name_factpdf").val(),
            cuenta_empresa:$("#cuenta").val(),
            idUser : iduserx

          },
          cache: false,
          success: function(result)
          {

            if ( result ) {

              alert(result+" filas afectadas");

              location.reload();

            }else{

              alert(result+" filas afectadas");
              location.reload();
              //alert("Alerta, El archivo no pudo cargar ningun movimiento, favor de revisarlo e intentarlo nuevamente");

            }


          }

      });

  }

}

$(function () {

  'use strict';

  //alert("subiendo");

  // Change this to the location of your server-side upload handler:

  var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_csv_facturasxodc/';

  $('#fileupload_pdf').fileupload({

      url: url,
      dataType: 'json',
      done: function (e, data) {

          //quitarArchivo(f);
          $.each(data.result.files, function (index, file) {

            $("#name_factpdf").val(file.name);

          });

      },

          progressall: function (e, data) {
              var progress = parseInt(data.loaded / data.total * 100, 10);
              $('#progress_bar_factpdf .progress-bar').css(
                  'width',
                  progress + '%'
              );

           $("#files_cfactpdf").html("<strong>El documento se ha subido correctamente</strong>");


          }

      }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

});


///****** FILTRAR 



function showInfo(){

  if ( table !="" ) {


    $('#my-table').DataTable().destroy();


  }


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

        "search":         "Buscar en la tabla por:",

        "paginate": {

            "first":      "Primero",

            "last":       "Ultimo",

            "next":       "Siguiente",

            "previous":   "Anterior"

        }

        },



        dom: '<"top" pl>rt',



        buttons: [ 'copy', 'excel' , 'csv'],

        "order": [  [ 4, "desc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            /* Append the grade to the default row class name */

            if ( true ) // your logic here

          {


            $(nRow).addClass( 'customFont' );


            $('td:eq(0)', nRow).addClass( 'alignCenter' );

            $('td:eq(1)', nRow).addClass( 'alignCenter' );

            if ($('td:eq(1)', nRow).text() === 'No pagado') {
        
              $('td:eq(1)', nRow).addClass( 'fontWithBackgroundRed' );

            }else if ($('td:eq(1)', nRow).text() === 'Pagado') {

              $('td:eq(1)', nRow).addClass( 'fontWithBackgroundGreen' );

            }else{

              $('td:eq(1)', nRow).addClass( 'fontWithBackgroundYellow' );

            }


            $('td:eq(2)', nRow).addClass( 'fontText2center' );


            $('td:eq(4)', nRow).addClass( 'fontText2blue' );

            $('td:eq(5)', nRow).addClass( 'fontText2green' );

            $('td:eq(6)', nRow).addClass( 'fontText2red' );
            

          }



        },columnDefs: [

           {
               targets: [6],
               data: null,
               render: function ( data, type, row, meta ) {                   
                  valor=formatoMoneda(data[6]);
                  return ``+valor+``         
               }
              
           },
           {
                targets: [5],
                data: null,
                render: function ( data, type, row, meta ) {                   
                  valor=formatoMoneda(data[5]);
                  return ``+valor+``         
                }
              
            },
            {
              targets: [4],
              data: null,
              render: function ( data, type, row, meta ) {                   
                valor=formatoMoneda(data[4]);
                return ``+valor+``         
              }
            
          },
           



        ],

        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Rpagoproveedor/loadPartidasFiltro?buscador="+$("#buscador").val()+"&estatus="+$("#bestatus").val(),



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();

        $("#modalPagoDescription").html(
          'ODC: <span id="modalPagoProveedor">'+data[2]+'</span><br>' +
          'Proveedor: <span id="modalPagoCuenta">'+data[3]+'</span><br>' +
          'Total: <span id="modalPagoRastreo">'+data[4]+'</span><br>' +
          'Pagado: <span id="modalPagoMetodo">'+data[5]+'</span><br>' +
          'Por pagar: <span id="modalPagoImporte">'+data[6]+'</span><br>'+
          '<span id="modalPagoIdODC" style="display: none;">'+data[7]+'</span>'
        );

        if(data[1] === "Pagado"){
          $("#finalizarODC").hide();
        }else{
          $("#finalizarODC").show();
        }
        
    } );

}

function cargarFacturas(idODC) {
  
  $.ajax({
    type: "POST",
    dataType: "json",
    url: base_urlx+"Rpagoproveedor/cargarFacturas",
    data:{

      idODC:idODC

    },

    cache: false,
    success: function(result)

    {

      if ( result != null ) {

        $('#tableBodyFacturas').empty();
        $.each(result, function(i, item) {
          var newRow = "<tr>" +
              "<td><a href='' target='_blank'>" + item.folio + "</a></td>" +
              "<td>" + item.uuid + "</td>" +
              "<td>" + item.fecha + "</td>" +
              "<td>" + formatoMoneda(item.subtotal) + "</td>" +
              "<td>" + formatoMoneda(item.iva) + "</td>" +
              "<td>" + formatoMoneda(item.total) + "</td>" +
              "</tr>";
      
          $('#tableBodyFacturas').append(newRow);
      });


      }else{
        $('#tableBodyFacturas').empty();
        //alert("Error, favor de intentarlo nuevamente y de persistir el error comuniquese con el administrador");

      }

    }



  }).fail( function( jqXHR, textStatus, errorThrown ) {

    detectarErrorJquery(jqXHR, textStatus, errorThrown);

  });
  
}

function finalizarODC() {
  
  $.ajax({

    type: "POST",
    dataType: "json",
    url: base_urlx+"Rpagoproveedor/finalizarODC",
    data: {idODC: $("#modalPagoIdODC").text()},
    cache: false,
    success: function(result)
  
    { 
  
      alert("ODC Finalizada con exito");
      location.reload();

    }
  
  
  
    });      
  
}

function downLoadExcel(){
  $("#btnBajarExcel").attr('disabled', true);
  $.ajax({

  type: "POST",

  dataType: "json",

  url: base_urlx+"tw/php/crear_excel_facturasxodc.php",
  data:{
    buscador : $("#buscador").val(),
    estatus: $("#bestatus").val()
  },
  cache: false,

  success: function(result)

  { 

    window.location.href=base_urlx+"tw/php/reporte/cuentasodc"+result+".xlsx";
    $("#btnBajarExcel").attr('disabled', false);

  }



  });      



}



function showInfoEstatus(){



  if ( table !="" ) {



    $('#my-table').DataTable().destroy();

    //$("#folio").val("");



  }



  /*filtrar entre cliente y vendedor*/



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

        "search":         "Buscar en la tabla por:",

        "paginate": {

            "first":      "Primero",

            "last":       "Ultimo",

            "next":       "Siguiente",

            "previous":   "Anterior"

        }

        },



        dom: '<"top" pl>rt',



        buttons: [ 'copy', 'excel' , 'csv'],

        "order": [  [ 4, "desc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            /* Append the grade to the default row class name */

            if ( true ) // your logic here

          {



            $(nRow).addClass( 'customFont' );


            $('td:eq(0)', nRow).addClass( 'alignCenter' );

            $('td:eq(1)', nRow).addClass( 'alignCenter' );

            if ($('td:eq(1)', nRow).text() === 'No pagado') {
        
              $('td:eq(1)', nRow).addClass( 'fontWithBackgroundRed' );

            }else if ($('td:eq(1)', nRow).text() === 'Pagado') {

              $('td:eq(1)', nRow).addClass( 'fontWithBackgroundGreen' );

            }else{

              $('td:eq(1)', nRow).addClass( 'fontWithBackgroundYellow' );

            }


            $('td:eq(2)', nRow).addClass( 'fontText2center' );


            $('td:eq(4)', nRow).addClass( 'fontText2blue' );

            $('td:eq(5)', nRow).addClass( 'fontText2green' );

            $('td:eq(6)', nRow).addClass( 'fontText2red' );

            

            

          }



        },columnDefs: [


          {
            targets: [6],
            data: null,
            render: function ( data, type, row, meta ) {                   
               valor=formatoMoneda(data[6]);
               return ``+valor+``         
            }
           
        },
        {
             targets: [5],
             data: null,
             render: function ( data, type, row, meta ) {                   
               valor=formatoMoneda(data[5]);
               return ``+valor+``         
             }
           
         },
         {
           targets: [4],
           data: null,
           render: function ( data, type, row, meta ) {                   
             valor=formatoMoneda(data[4]);
             return ``+valor+``         
           }
         
       },



        ],

        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Rpagoproveedor/loadPartidasEstatus?estatus="+$("#bestatus").val()+"&buscador="+$("#buscador").val(),



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {

      var data = table.row( this ).data();

      $("#modalPagoDescription").html(
        'ODC: <span id="modalPagoProveedor">'+data[2]+'</span><br>' +
        'Proveedor: <span id="modalPagoCuenta">'+data[3]+'</span><br>' +
        'Total: <span id="modalPagoRastreo">'+data[4]+'</span><br>' +
        'Pagado: <span id="modalPagoMetodo">'+data[5]+'</span><br>' +
        'Por pagar: <span id="modalPagoImporte">'+data[6]+'</span><br>'+
        '<span id="modalPagoIdODC" style="display: none;">'+data[7]+'</span>'
      );

      if(data[1] === "Pagado"){
        $("#finalizarODC").hide();
      }else{
        $("#finalizarODC").show();
      }


    } );



}



function payment(button, realizarPago) {
  
  if(realizarPago == false){

    var id = $(button).data('id');
  
    $("#verODC").html(
      'Proveedor: <span id="modalProveedor"></span><br>' +
      'ODC: <span id="modalODC"></span><br>' +
      'Total: <span id="modalTotal"></span><br>' +
      'Pagado: <span id="modalPagado"></span><br>' +
      'Por pagar: <span id="modalDebe"></span><br>'+
      '<span id="modalOculto" style="display: none;">'+button+'</span>'
    );
    

  }else{
    
    
    $.ajax({
      type: "POST",
      dataType: "json",
      url: base_urlx+"Rpagoproveedor/cargarPago",
      data:{

        idODC:$("#modalOculto").text(),
        idProveedor:$("#modalProveedor").text(),
        total:$("#valueEntradaPago").val(),

      },

      cache: false,
      success: function(result)

      {

        if ( result > 0 ) {

          alert("El pago fue completado");

          location.reload();

        }else{

          alert("Error, favor de intentarlo nuevamente y de persistir el error comuniquese con el administrador");

        }

      }



    }).fail( function( jqXHR, textStatus, errorThrown ) {

      detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

  }
  

}

/////////****************** SELECT SUB-CATEGORIAS





function showexcel(idcotx){



            /*folio ="";

            inicio = 10000;

            var nuevo = parseFloat(inicio)+parseFloat(idcotx);



            switch ( nuevo.length  ) {



              case 5:

                  

                  folio = "ODV00"+nuevo;



              break;



              case 6:

                  

                  folio = "ODV0"+nuevo;



              break;



              case 7:

                  

                  folio = "ODV"+nuevo;



              break;



              default:



                  folio = "s/asignar";



              break;



          }





          alert(nuevo.toString().length );*/



    $.ajax({

          type: "POST",

          dataType: "json",

          url: base_urlx+"tw/php/crear_excel_cotizacion.php",

          data: { alta1:idcotx },

          cache: false,

          success: function(result)

          { 





            folio ="";

            inicio = 10000;

            nuevo = parseFloat(inicio)+parseFloat(idcotx);



            switch ( nuevo.toString().length ) {



              case 5:

                  

                  folio = "ODV00"+nuevo;



              break;



              case 6:

                  

                  folio = "ODV0"+nuevo;



              break;



              case 7:

                  

                  folio = "ODV"+nuevo;



              break;



              default:



                  folio = "s/asignar";



              break;



          }



            window.location.href=base_urlx+"tw/php/reporte/cotizacion_"+folio+".xlsx";



          }



    });      



}





function crearPedido(){



  //urlx = $("#evidencia").val();



  if ( $("#name_factpdf").val() != "" ) {



    $.ajax({

          type: "POST",

          dataType: "json",

          url: base_urlx+"tw/php/verificar_url.php",

          data: { archivo:$("#name_factpdf").val(), cotizacion:idCotizacionx },

          cache: false,

          success: function(result)

          { 



            if(result){



              alert("Alerta, el PEDIDO ha sido creado con exito");

              CierraPopup();

              table.ajax.reload();



            }else{



              alert("Error, la URL no ha podido ser validada");



            }



          }



    });



  }else{



    alert("Alerta, favor de añadir un archivo valido");



  } 



}



//////////////////////////////******************* subir archivo de evidencia



function subirEvidencia(){

  if ( $("#name_factpdf").val() != "" ) {



    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rpagoproveedor/subirEvidencia/",

            data: { idcotizacion:idCotizacionx, evidencia:$("#name_factpdf").val() },

            cache: false,

            success: function(result)

            { 



              if ( result ) {



                alert("Alerta, el PEDIDO ha sido creado con exito");

                CierraPopup();

                table.ajax.reload();



              }else{



                alert("Error, favor de intentarlo nuevamente");



              }



            }





    });



  }else{



    alert("Alerta, favor de agregar una evidencia valida");



  } 

    



}



//////// ***************************************SUBIR ARCHIVO PDF



function cancelarCotizacion(idcotx){



  x=confirm("¿Realmente deseas cancelar la cotizacion seleccionada?");



  if (x) {



     $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rpagoproveedor/cancelarCotizacion/",

            data: { idcotizacion:idcotx },

            cache: false,

            success: function(result)

            { 



              if ( result ) {



                alert("Alerta, la cotizacion ha sido cancelada con exito");

                table.ajax.reload();



              }else{



                alert("Error, favor de intentarlo nuevamente");



              }



            }





    });



  }



}



function cancelarPedido(idcotx){



  x=confirm("¿Realmente deseas revertir el pedido, esto lo regresara al proceso de cotización?");



  if (x) {



     $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rpagoproveedor/cancelarPedido/",

            data: { idcotizacion:idcotx },

            cache: false,

            success: function(result)

            { 



              if ( result==1 ) {



                alert("Alerta, el pedido ha cambiado su estatus a cotizacion");

                table.ajax.reload();



              }else if( result==0 ){



                alert("Alerta, el pedido no puede ser revertido debido a que ya tiene ordenes de compra asignadas algun proveedor");



              }



            }





      });



  }



}


function showCuentas(){

  $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"Rpagoproveedor/showCuentas/",
          cache: false,
          success: function(result)
          {

            if ( result != null ) {

                var creaOption="<option value='0' >Seleciona una cuenta...</option>"; 
                $.each(result, function(i,item){

                    data1=item.id;

                    data2=item.cuenta;//id

                    data3=item.comercial;//nombre

                    creaOption=creaOption+'<option value="'+data1+'">'+data2+' - '+data3+'</option>'; 

                }); 

                $("#cuenta").html(creaOption);

                //$("#regimen").val(0);

            }else{

               $("#cuenta").html("<option value='0'>Sin bancos almacenados</option>");

            }

          }

  }).fail( function( jqXHR, textStatus, errorThrown ) {

      detectarErrorJquery(jqXHR, textStatus, errorThrown);

  });

}





function cerrarSesion(){



  var x = confirm("¿Realmente deseas cerrar la sesión?");



  if( x==true ){



    window.location.href = base_urlx+"Login/CerrarSesion/";

    

  }



}

