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
   var splitRight = splitStr.length > 1 ? '.' + splitStr[1] : '';
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

//alert("version 9.0");

function zero(n) {
 return (n>9 ? '' : '0') + n;
}

var date = new Date();
var fechahoy = date.getFullYear() +"-"+zero(date.getMonth()+1) +"-"+zero(date.getDate());
var table;
var colx = "";
var idFila = "";
var idtotal = 0;
var idpagadox = 0;
var editId = 0;
var idncpp = null;
var tipox=0;


$("#fecha").val(fechahoy);
////
$(".select2").select2();
$(".select2-placeholer").select2({
  allowClear: true

});


function sumaTotal(){

  total_comprobante =0;

  $('#my-table').DataTable().rows().data().each(function(el, index){
    //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria
    total_comprobante = parseFloat(total_comprobante)+parseFloat(el[6].replace(/[^\d.]/g,""));
    
  });

  $("#tneto").html("Total: "+formatNumber(round(total_comprobante) ));
 
}

function calcularSubtotal(totalx,pagadox){

  facttotal = totalx.replace(/[^\d.]/g,"");
  factpagado = pagadox.replace(/[^\d.]/g,"");

  xpagar = parseFloat(facttotal)-parseFloat(factpagado);

  return formatNumber( round(xpagar) );

}

////////// EDITOR DE CELDAS

const createdCell = function(cell) {
  let original

  cell.setAttribute('contenteditable', true)
  cell.setAttribute('spellcheck', false)

  cell.addEventListener('focus', function(e) {
    original = e.target.textContent
     //alert("/ row_focus: "+indexTabla );

  })

    cell.addEventListener('blur', function(e) {
    if (original !== e.target.textContent) {
      const row = table.row(e.target.parentElement);
      //row.invalidate()******* este codigo nos ayuda si no queremos ve el cambio actual reflejado en la celda al salir de ella
      //alert(e.target.textContent+"/ row.data() );
      //alert("row: "+idxt+" column: "+colx+" Idpcot: "+editId);

      if ( colx == 0 || colx == 1 ) {

        ///////// estas columnas ya las bloquee en la crecion de la tabla, pero deje este codigo vivo para futuras referncias
        row.invalidate()

      }else{


          $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Cppnew/updateCelda/",
            data:{

              texto:e.target.textContent.replace(/[^\d.]/g,""),
              columna:colx,
              idfactura:editId,
              total:idtotal.replace(/[^\d.]/g,""),
              pagado:idpagadox.replace(/[^\d.]/g,""),
              idcliente:$("#cliente").val(),
              ncpp:idncpp,
              tipo:tipox,
              iduser:iduserx

            },
            cache: false,
            success: function(result)
            {

              if ( result == null ) {

                row.invalidate()
                alert("Error, favor de ingresar un valor mayor a 0 y menor o igual al monto que falta por saldar");
            
              }else if( result == 0 ){

                row.invalidate()
                alert("Alerta, favor de intentar ingresar nuevamente el monto a cobrar");

              }else{

                  //alert("columna"+colx);
                  temp = table.row(idFila).data();
                  ////////calcular subtotal

                    //cobrox = e.target.textContent.replace(/[^\d.]/g,"");
                    //totalx = idtotal.replace(/[^\d.]/g,"");
                    //pagadox = idpagadox.replace(/[^\d.]/g,"");

                    //xpagar=parseFloat(totalx)-parseFloat(result.cobrado);
                    //restantex=parseFloat(xpagar)-parseFloat(cobrox);

                    //alert("subtotal="+subtotalx);

                    temp[6] = formatNumber( round(result.cobrado) );
                    temp[7] = formatNumber( round(result.posterior) );
                    $('#my-table').dataTable().fnUpdate(temp,idFila,undefined,false);

                    setTimeout(function (){
                    
                        sumaTotal();              
                                  
                    }, 500);

                  
              }

              //alert(result);

            }

          });

      }
      
    }

  })
}


function showMovimientos(idclientexx){

  $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Cppnew/showMovimientos/",
            data:{

              idcli:idclientexx

            },
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption="<option value='0'>Seleccione una cuenta</option>"; 

                  $.each(result, function(i,item){
                      data1=item.rastreo;//id
                      data2=item.cuenta;//nombre
                      data3=item.comercial;//id
                      data4=item.importe;
                      data5=item.id;

                      creaOption=creaOption+'<option value="'+data5+'">'+item.fecha_banco+'|'+item.hora_banco+' #RASTREO:'+data1+' - CUENTA:'+data2+' , '+data3+' | '+formatNumber(round(data4))+'</option>'; 

                  }); 

                  $("#lista_movimiento").html(creaOption);
                  
                 

              }else{

                 $("#lista_movimiento").html("<option value='0'>Sin cuentas asignadas...</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}


///*********** MOSTRAR DATOS 

function showPpd(idclientex){


    $('#my-table').DataTable().destroy();

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
          "search":         "Buscar por producto:",
          /*"paginate": {
              "first":      "Primero",
              "last":       "Ultimo",
              "next":       "Siguiente",
              "previous":   "Anterior"
          }*/
          },

          dom: '<"top" pl>rt',

          buttons: [ 'copy', 'excel' , 'csv'],
          "order": [  [ 0, "desc" ] ],

          "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
              /* Append the grade to the default row class name */
              if ( true ) // your logic here
                {

                  $(nRow).addClass( 'customFont' );

                  //$('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' ).addClass( 'bgcolor1' );
                  /*

                  $('td:eq(2)', nRow).addClass( 'alignRight' );
                  $('td:eq(3)', nRow).addClass( 'alignRight' ).addClass('bgdocumento').addClass( 'bold' );*/
                  //$('td:eq(0)', nRow).addClass( 'alignCenter' );
                  $('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
                  $('td:eq(1)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
                  $('td:eq(2)', nRow).addClass( 'alignRight' );
                  $('td:eq(3)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );
                  $('td:eq(4)', nRow).addClass( 'alignRight' ).addClass('bgcolor_darkgreen').addClass( 'color_darkgreen' );;
                  $('td:eq(5)', nRow).addClass( 'alignRight' ).addClass( 'bold' ).addClass('color_red');
                  $('td:eq(6)', nRow).addClass( 'alignRight' );
                  $('td:eq(7)', nRow).addClass( 'alignRight' );
                  //$('td:eq(2)', nRow).addClass( 'fontText2' );

                  
                }
          },
          columnDefs: [

              { 
                targets: [6],
                createdCell: createdCell
              },

              {
                 targets: [5],
                 data: null,
                 render: function ( data, type, row, meta ) {                   
                  /*return `<button class="btn btn-danger hidden-xs" type="button" title="Borrar" onclick="borrarArticulo(${row[4]})"> <i class="icon-trash"></i> </button><button class="btn btn-orange hidden-xs" type="button" title="Editar" onclick="editarArticulo(${row[4]})"> <i class="icon-pencil"></i> </button><div class="dropdown open hidden-sm hidden-md hidden-lg hidden-xl">
                      <a class="more-link" data-toggle="dropdown" href="#/" aria-expanded="true"><i class="icon-dot-3 ellipsis-icon"></i></a>
                      <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="" style="color:orange; font-weight:bold; ">Editar</a></li>
                        <li><a href="" style="color:red; font-weight:bold; ">Eliminar</a></li>
                        <li><a href="#modal_info" data-toggle="modal" style="color:blue; font-weight:bold; ">Ver info.</a> </li>
                      </ul>
                    </div>`
    
                    */

                    valor2=calcularSubtotal( data[2],data[4] );

                    return ``+valor2+``         

                 }

                 
              }

          ],

          "processing": true,
          "serverSide": true,
          "search" : false,
          "ajax": base_urlx+"Cppnew/loadPartidas?idcliente="+idclientex+"&iduser="+iduserx,

        "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]],

          "scrollY": 300,
          "scrollX": true
      });

      /////////////********* CLICK 
    $('#my-table tbody').on('focusin', 'tr', function () {
        var data = table.row( this ).data();


          idtotal = data[2];
          idpagadox = data[4];
          idncpp = data[3];
          editId = data[8];
          tipox=data[9];

        console.log(idtotal+" "+idpagadox+" | "+tipox);

    } );

    
    $('#my-table').on( 'focusout', 'tbody td', function () {

      idFila = table.cell( this ).index().row;
      colx = table.cell( this ).index().column;

      //var data = table.cells( idxt, '' ).render( 'display' );
   
      //alert( "row:"+table.cell( this ).data()+" columna:"+colx );
    } );



    showMovimientos(idclientex);

    $("#rfc").val("");
    $("#banco").val("");
    $("#cuenta ").val("");
    $("#noperacion").val("");
    $("#brfc").val("");
    $("#bcuenta").val("");
    $("#importe").val("");
    $("#fpago").val(1);
     

      table
      .buttons()
      .container()
      .appendTo( '#controlPanel' );

      setTimeout(function (){
                    
                        sumaTotal();              
                                  
                    }, 500);


}

////***** FORMA DE PAGO CLIENTE
function showFpago(){

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
                  $("#fpago").val(1);
                 

              }else{

                 $("#fpago").html("<option value='0'>Sin formas de pago</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

////***** MOSTRAR CUENTAS
function showCuentas(idclientexx){

  //alert("OK");

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Cppnew/showCuentas/",
            data:{idcli:idclientexx},
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption="<option value='0'>Seleccione una cuenta</option>"; 

                  $.each(result, function(i,item){
                      data1=item.id;//id
                      data2=item.cuenta;//nombre
                      data3=item.comercial;//id

                      creaOption=creaOption+'<option value="'+data1+'">Cuenta: '+data2+' - '+data3+'</option>'; 

                  }); 

                  $("#lista_cuentas").html(creaOption);
                  
                 

              }else{

                 $("#lista_cuentas").html("<option value='0'>Sin cuentas asignadas...</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}



////******* MOSTRAR INFORMACION DEL PAGO DEL COMPLEMENTO
function datosMovimiento(idmovimiento){

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Cppnew/datosMovimiento/",
            data:{idmov:idmovimiento},
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                $("#rfc").val(result.rfc);
                $("#fecha").val(result.fecha_banco);
                $("#banco").val(result.razon);
                $("#cuenta ").val(result.cuenta);
                $("#noperacion").val(result.rastreo);
                $("#brfc").val(result.rfc_banco_empresa);
                $("#bcuenta").val(result.cuenta_empresa);
                $("#importe").val(result.importe);
                $("#fpago").val(result.fpago);

              }else{

                $("#rfc").val("");
                $("#banco").val("");
                $("#cuenta ").val("");
                $("#noperacion").val("");
                $("#brfc").val("");
                $("#bcuenta").val("");
                $("#importe").val("");
                $("#fpago").val(1);

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

function datosCuentas(idcuenta){

   $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Cppnew/datosCuentas/",
            data:{idcuentax:idcuenta},
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                $("#rfc").val(result.rfc);
                $("#banco").val(result.razon);
                $("#cuenta ").val(result.cuenta);

                $("#noperacion").focus();

              }else{

                alert("Error, favor de intentarlo nuevamente");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

/////////****************** MOSTRAR CLIENTES
showCliente()

function showCliente(){

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"AltaCotizacion/showCliente/",
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption="<option value='0' selected>Selecciona un cliente...</option>"; 

                  $.each(result, function(i,item){
                      data1=item.id;//id
                      data2=item.rfc;//nombre
                      data3=item.nombre;//id
                      data4=item.comercial;//nombre
                      creaOption=creaOption+'<option value="'+data1+'">'+data2+'-'+data3+' <strong style="color:darkblue;">'+data4+'</strong></option>'; 
                  }); 

                  $("#cliente").html(creaOption);
                  $("#cliente").val(0);

                  showFpago();

              }else{

                 $("#cliente").html("<option value='0'>Sin categorias</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

function pdfComplemento(idcomp){

  if ( idcomp > 0 ) {

      $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"tw/php/pdf_complemento_pago.php",
            data:{

              idcompx: idcomp

            },
            cache: false,
            success: function(result)
            {

              /*if ( result > 0) {

                alert("Alerta, favor de agregar un complemento de pago valido");

              }else{

                alert(result);

              }*/

              window.open(base_urlx+"tw/php/facturas_ppd/"+result+".pdf", "_blank");

              enviarCorreo(idcomp);
              
 
            }

      }).fail( function( jqXHR, textStatus, errorThrown ) {


          detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });

  }else{

    alert("Error, el ID del complemento no fue generado correctamente");

  }

}

/*function obtenerQr(idfacturax){

  if ( idfacturax > 0 ) {

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/obtener_qr_ppd.php",//prueba
          //url: base_urlx+"tw/php/crear_xml_facturalo.php",
          data:{ 

              idfactura:idfacturax

            },
          cache: false,
          success: function(result)
          {


            if ( result ) {

              pdfComplemento(idfacturax);

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
          url: base_urlx+"tw/php/retirar_timbrado_ppd.php",//prueba
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

}*/


function enviarCorreo(idppd){

  if (idppd>0){

    $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"Cppnew/enviarCorreo",//prueba
          //url: base_urlx+"tw/php/crear_xml_facturalo.php",
          data:{ 

              idppdx:idppd

            },
          cache: false,
          success: function(result)
          {

            if ( result ) {

             
            ///enviarCorreo(idppd);
              
            //pdfComplemento(idppd);

              location.reload();

            }else{

              alert("Error, "+result);

              //pdfComplemento(idppd);
              location.reload();

            }


          }

    });

  }

}

function timbrarPpd(idppd){

  if ( idppd > 0 ) {


      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/timbrar_ppd_temporal.php",//prueba
          //url: base_urlx+"tw/php/crear_xml_facturalo.php",
          data:{ 

              idppdx:idppd,
              idmov:$("#lista_movimiento").val(),
              importe_movimiento:$("#importe").val()

            },
          cache: false,
          success: function(result)
          {

            if ( result ) {

             
              //enviarCorreo(idppd);
              
              pdfComplemento(idppd);

            }else{

              alert("Error, "+result);

            }


          }

      });

  }

}

function sellarXml(idppd){

  if ( idppd > 0 ) {

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/generar_xml_sellado_ppd.php",//prueba
          //url: base_urlx+"tw/php/crear_xml_facturalo.php",
          data:{ 

              idppdx:idppd

            },
          cache: false,
          success: function(result)
          {

            if ( result > 0) {

              //obtenerQr(result);

              timbrarPpd(idppd);

            }else{

              alert("Error, "+result);

            }


          }

      });

  }


}


function timbrarPago(){

  x = confirm("¿Deseas timbrar este complemento de pago?");

  if ( x ) {

    verificar = 0;
    total_comprobante =0;

    if ( $("#idcliente").val() == 0 ) {

      alert("Alerta, favor de seleccionar un cliente valido");
      verificar = 1;

    }

    if ( $("#fecha").val() == "" ) {

      alert("Alerta, favor de seleccionar una fecha valida");
      verificar = 1;

    }

    $('#my-table').DataTable().rows().data().each(function(el, index){
      //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria
      total_comprobante = parseFloat(total_comprobante)+parseFloat(el[6].replace(/[^\d.]/g,""));
      
    });

    if ( total_comprobante == 0 || total_comprobante == null ) {

      alert("Alerta, favor de agregarle como minimo un monto cobrado a una factura");
      verificar = 1;

    }

    if ( verificar == 0 ) {


        $("#btn_finalizar").prop("disabled",true);
        $("#btn_finalizar").html("Generando complemento");

        $.ajax({
              type: "POST",
              dataType: "json",
              url: base_urlx+"tw/php/alta_timbrado_complemento_prueba.php",
              data:{

                idcli: $("#cliente").val(),
                iduser: iduserx,
                fpagox: $("#fpago").val(),
                noperacionx: $("#noperacion").val(),
                fechax: $("#fecha").val(),
                rfcx: $("#rfc").val(),
                bancox: $("#banco").val(),
                cuentax: $("#cuenta").val(),
                monedax: $("#moneda").val(),
                bcuentax: $("#bcuenta").val(),
                brfcx: $("#brfc").val(),
                totalx: round(total_comprobante),
                documentox:$("#name_factpdf").val(),
                idmov:$("#lista_movimiento").val()


              },
              cache: false,
              success: function(result)
              {

                if ( result > 0 ) {

                  
                  sellarXml(result)

                  //alert("ultimo_id:"+result);

                }else{

                  alert(result);

                  $("#btn_finalizar").prop("disabled",true);
                  $("#btn_finalizar").html("Generar complemento");

                }

                //alert(result);

   
              }

        }).fail( function( jqXHR, textStatus, errorThrown ) {


            detectarErrorJquery(jqXHR, textStatus, errorThrown);

        });

    }
  }

}


//////// ***************************************SUBIR ARCHIVO PDF

$(function () {

    'use strict';

    //alert("subiendo");

    // Change this to the location of your server-side upload handler:

    var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_cpago/';

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


