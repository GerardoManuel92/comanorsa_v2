//alert("version5.0");

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

var table;
var total_cot = 0;
var total_desc = 0;
var total_iva = 0;
var total_neto = 0;

function sumaTotal(){

  total_cot =0;
  total_desc =0;
  total_iva =0;

  $('#my-table').DataTable().rows().data().each(function(el, index){
    //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria
    total_cot = parseFloat(total_cot)+parseFloat(el[15]);
    total_desc = parseFloat(total_desc)+parseFloat(el[17]);
    total_iva = parseFloat(total_iva)+parseFloat(el[16]);

  });

  total_neto = parseFloat(total_cot)-parseFloat(total_desc)+parseFloat(total_iva);

  $("#tsubtotal").html( "Subtotal: "+formatNumber(round(total_cot) ));
  $("#tneto").html("Total: "+formatNumber(round(total_neto) ));
  $("#tdescuento").html( "Descuento: "+formatNumber(round(total_desc) ));
  $("#tiva").html( "Iva "+formatNumber(round(total_iva) ));

  ////////******* total impuesto iva
  $("#iva_base").val( formatNumber( round(total_cot) ) );
  $("#iva_importe").val( formatNumber(round(total_iva) ) )

  ////////////////******* VERIFICAR LIMITE DE VENTA

  /*if ( $("#limite").val() > 0 ) {

    if ( total_neto > $("#limite").val() ) {

      $("#btnfactura").prop("disabled",true);

      $("#alertax").html("**Nota: El cliente excede el límite de crédito otorgado, por tanto, no se puede realizar esta venta");

      limit_excedido = 1;

    }else{

      $("#btnfactura").prop("disabled",false);

      $("#alertax").html("");

      limit_excedido = 0;

    }

  }else{

    $("#btnfactura").prop("disabled",false);
    $("#alertax").html("");
    limit_excedido = 0;

  }*/

}

function verDetalles(){

  
  $("#tdescuento").css("display","");
  $("#tiva").css("display","");
  $("#cerrar").css("display","");

}

function cerrarDetalles(){

  $("#tdescuento").css("display","none");
  $("#tiva").css("display","none");
  $("#cerrar").css("display","none");
}

$(document).ready(function() {

  ////////******** MOSTRAR CLIENTES
  
  $(".select2").select2();
    $(".select2-placeholer").select2({
      allowClear: true

    });

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
        /*"paginate": {
            "first":      "Primero",
            "last":       "Ultimo",
            "next":       "Siguiente",
            "previous":   "Anterior"
        }*/
        },

        dom: '<"top"B pl>rt',

        buttons: [ 'copy', 'excel' , 'csv'],
        "order": [  [ 1, "desc" ] ],

        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            /* Append the grade to the default row class name */
            if ( true ) // your logic here
              {

                $(nRow).addClass( 'customFont' );

                $('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
                $('td:eq(1)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );
                $('td:eq(2)', nRow).addClass( 'alignRight' ).addClass( 'fontText3' );
                $('td:eq(3)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
                $('td:eq(4)', nRow).addClass( 'fontText' );
                $('td:eq(5)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
                $('td:eq(6)', nRow).addClass( 'alignRight' ).addClass( 'fontText3' );
                $('td:eq(7)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
                $('td:eq(8)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
                $('td:eq(9)', nRow).addClass( 'alignRight' ).addClass( 'fontText3' );

                //$('td:eq(2)', nRow).addClass( 'fontText2' );
                
              }
        },
        /*columnDefs: [{ 
          targets: [2],
          createdCell: createdCell
        }],*/

        "paging": false,
        "processing": true,
        "serverSide": true,
        "search" : false,
        "ajax": base_urlx+"CrearFactura/loadPartidas",

      //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

        "scrollY": 300,
        "scrollX": true
    });

    /////////////********* CLICK 
    $('#my-table tbody').on('focusin', 'tr', function () {
        var data = table.row( this ).data();


        editId = data[12];

        //idFila = table.row( this ).index();
        editCantidad = data[2];
        editCosto = data[13];
        editCproveedor = data[18];
        edittcambio =data[10];
        editUtil = data[9];

        Idpcot = data[19];

        /*editParte = data[11];
        editDescrip = data[3];
        editUnidad = data[4];
        editIva = data[6];
        editDesc = data[7];
        editSubtotal = data[8];

        indexTabla = table.row(this).index();*/

        //alert( editId );

        //alert( indexTabla );

    } );


    $('#my-table').on( 'focusout', 'tbody td', function () {

      idFila = table.cell( this ).index().row;
      colx = table.cell( this ).index().column;

      //var data = table.cells( idxt, '' ).render( 'display' );
   
      //alert( "row:"+table.cell( this ).data()+" columna:"+colx );
    } );



    table
    .buttons()
    .container()
    .appendTo( '#controlPanel' );

    $("#tneto").html("Calculando...");

    setTimeout(function (){

        sumaTotal();              
                  
    }, 2000);

});


showCfdi();
showMpago();

showNewCliente(idclientex);

////***** CFDI CLIENTE
function showCfdi(){

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Actcotizacion/showCfdi/",
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption=""; 

                  $.each(result, function(i,item){

                      data1=item.id;//id
                      data2=item.clave;//nombre
                      data3=item.descripcion;//id
                      creaOption=creaOption+'<option value="'+data1+'">'+data2+'-'+data3+'</option>'; 
                  }); 

                  $("#cfdi").html(creaOption);
                  $("#cfdi").val(idcfdix);

              }else{

                 $("#cfdi").html("<option value='0'>Sin datos de uso cfdi</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

////***** FORMA DE PAGO CLIENTE
function showFpago(fpagox,seleccionable){

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Actcotizacion/showFpago/",
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption=""; 

                  $.each(result, function(i,item){
                      data1=item.id;//id
                      data2=item.clave;//nombre
                      data3=item.descripcion;//id
                      creaOption=creaOption+'<option value="'+data1+'">'+data2+'-'+data3+'</option>'; 
                  }); 

                  $("#fpago").html(creaOption);
                  $("#fpago").val(fpagox);

                  if ( seleccionable ) {

                    $("#fpago").prop("disabled",true);

                  }else{

                    $("#fpago").prop("disabled",false);

                  }

              }else{

                 $("#fpago").html("<option value='0'>Sin formas de pago</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

//////****** METODO DE PAGO 
function showMpago(){

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Actcotizacion/showMpago/",
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption=""; 

                  $.each(result, function(i,item){
                      data1=item.id;//id
                      data2=item.clave;//nombre
                      data3=item.descripcion;//id
                      creaOption=creaOption+'<option value="'+data1+'">'+data2+'-'+data3+'</option>'; 
                  }); 

                  $("#mpago").html(creaOption);
                  

                  if ( $("#credito").val() > 0 ) {

                    ///// pagos parciales
                    $("#mpago").val(2);

                    /// fomar de pago 99
                    showFpago(21,true);

                  }else{

                    $("#mpago").val(3);
                    /// fomar de pago 99
                    showFpago(idfpagox,false);

                  }

              }else{

                 $("#mpago").html("<option value='0'>Sin metodos de pago</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

//////******** estatus depdniendo el metodo

function estatusFpago(valorx){

  if ( valorx == 2 ) {

    $("#fpago").val(21);
    $("#fpago").prop("disabled",true);

  }else{

    $("#fpago").val(idfpagox);
    $("#fpago").prop("disabled",false);

  }

}

//////// ***************************************SUBIR ARCHIVO PDF

$(function () {

    'use strict';

    //alert("subiendo");

    // Change this to the location of your server-side upload handler:

    var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_odc/';

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

//////////////////****** FACTURAR

function showPDFfactura(idfactxx){

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/pdf_factura_relacion_cancelacion.php",
          data:{ 

              idfactura:idfactxx

            },
          cache: false,
          success: function(result)
          {

            window.open(base_urlx+"tw/php/facturas/"+result+".pdf", "_blank");
            alert("La factura fue generada exitosamente");
            window.location.href=base_urlx+"Rfacturas";
          }

      }); 


}

function obtenerQr(idfacturax){

  if ( idfacturax > 0 ) {

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/obtener_qr.php",//prueba
          //url: base_urlx+"tw/php/crear_xml_facturalo.php",
          data:{ 

              idfactura:idfacturax

            },
          cache: false,
          success: function(result)
          {


            if ( result ) {

              showPDFfactura(idfacturax);

            }else{

              alert("Error, "+result);

            }


          }

      });

  }

}

function retirarTimbrado(idfacturax){

  if ( idfacturax > 0 ) {

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/retirar_timbrado.php",//prueba
          //url: base_urlx+"tw/php/crear_xml_facturalo.php",
          data:{ 

              idfactura:idfacturax

            },
          cache: false,
          success: function(result)
          {

            if ( result > 0) {

              obtenerQr(result);

            }else{

              alert("Error, "+result);

            }


          }

      });

  }

}

function facturarXml(idcotxx,idfactx){

  if ( idfactx > 0 ) {

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/crear_xml_facturalo_relacion_cancelacion.php",//prueba
          //url: base_urlx+"tw/php/crear_xml_facturalo.php",
          data:{ 

              idcot:idcotxx,
              idfact:idfactx,
              idcli:idclientex,
              name_factura:$("#name_factura").val(),
              tipo:0

            },
          cache: false,
          success: function(result)
          {

            if ( result == 0) {
              
              retirarTimbrado(idfactx);

              //alert(result);

            }else {

              alert("Error, "+result);

            }


          }

      });

  }

}

function factCotizacion(){

  x = confirm("¿Realmente deseas crear esta factura de relacion por cancelacion?");

  if(x){

    subx = 0;

    $('#my-table').DataTable().rows().data().each(function(el, index){
      //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria
      subx = parseFloat(subx)+parseFloat(el[12]);

      });

      verificar = 0;

      if ( subx <= 0 ) {

        alert("Alerta, no se han encontrado partidas en tu cotizacion o esta tiene un costo igual a 0");
        verificar = 1;

      }

      if ( parseFloat(total_cot) <= 0 ){

        alert("Alerta, el subtotal no puede ser menor o igual a 0");
        verificar = 1;

      }

      /*if ( parseFloat(total_iva) <= 0 ){

        alert("Alerta, el IVA no puede ser menor o igual a 0");
        verificar = 1;

      }*/

      if ( verificar == 0 ) {

        $("#btnfactura").prop("disabled",true);
        $("#btnfactura").html('TIMBRANDO XML...');

        $.ajax({
                type: "POST",
                dataType: "json",
                url: base_urlx+"CrearFactura/factCotizacion/",
                data:{

                  idcliente:idclientex,
                  iduser:iduserx,
                  idfactura:idfacturax,
                  dias:$("#credito").val(),
                  fpagox:$("#fpago").val(),
                  mpagox:$("#mpago").val(),
                  cfdix:$("#cfdi").val(),
                  odc:$("#name_factpdf").val(),
                  totalx:round(total_neto),
                  ivax:round(total_iva),
                  descuentox:round(total_desc),
                  subtotalx:round(total_cot)

                },
                cache: false,
                success: function(result)
                {

                  if ( result > 0 ) {

                    facturarXml(idfacturax,result);

                    //alert(result);

                  }else{

                    alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");

                  }

                  

                }

        }).fail( function( jqXHR, textStatus, errorThrown ) {


              detectarErrorJquery(jqXHR, textStatus, errorThrown);

        });

      }else if( verificar == 2 ) {

        $.ajax({

                type: "POST",
                dataType: "json",
                url: base_urlx+"Rcotizacion/habilitarOdc/",
                data:{idcot:idcotx},
                cache: false,
                success: function(result)
                {

                  if ( result > 0 ) {

                    alert("Alerta, las partidas han sido enviadas para su requisicion Y generacion de ODC, favor de volver a FACTURAR");
                    idodcx = 1;

                  }else{

                    alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");

                  }


                }

          }).fail( function( jqXHR, textStatus, errorThrown ) {


                detectarErrorJquery(jqXHR, textStatus, errorThrown);

          });

      }

  }

}


