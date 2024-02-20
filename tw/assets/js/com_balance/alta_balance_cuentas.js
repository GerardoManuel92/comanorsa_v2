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

$(".select2").select2();
$(".select2-placeholer").select2({
  allowClear: true

});

var table="";
var idFila=0;
var idEdit=0;
var abonox=0;
var arrayFacturas=[];
var arrayPagos=[];
var arrayFolios=[];
var arrayFpago=[];
var arrayTipoFact=[];
var arrayTotfactura=[];
var idclix=0;
/*var mcuenta="";
var mfecha="";
var mhora="";
var mmovimiento="";
var mrastreo="";
var mimporte=0;*/


showCliente();
showCuentas();

showFpago();


function showCliente(){

    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Balancecuentas/showCliente/",

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  var creaOption="<option value='0' selected>Seleccionar un cliente...</option>"; 



                  $.each(result, function(i,item){

                      data1=item.id;//id

                      data2=item.nombre;//nombre

                      data3=item.comercial;

                      creaOption=creaOption+'<option value="'+data1+'">'+data2+' - '+data3+'</option>'; 

                  }); 



                  $("#cliente").html(creaOption);

                  //$("#regimen").val(0);



              }else{



                 $("#cliente").html("<option value='0'>Sin clientes almacenados</option>");



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });

}


/*function movXcliente(){


    if ( table !="" ) {



      $('#my-table').DataTable().destroy();

      //$("#folio").val("");


     

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



            dom: '<"top" fpl>rt',



            buttons: [ 'copy', 'excel' , 'csv'],

            "order": [  [ 1, "desc" ] ],



            "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

                

                if ( true ) // your logic here

              {



                $(nRow).addClass( 'customFont' );



                $('td:eq(0)', nRow).addClass( 'alignCenter' );

                $('td:eq(1)', nRow).addClass( 'alignCenter' );



                $('td:eq(2)', nRow).addClass( 'alignCenter' );



                $('td:eq(3)', nRow).addClass( 'alignCenter' );

                $('td:eq(4)', nRow).addClass( 'alignCenter' );

                $('td:eq(5)', nRow).addClass( 'alignCenter' );



                $('td:eq(6)', nRow).addClass( 'alignRight' ).addClass('color_red');

                $('td:eq(7)', nRow).addClass( 'alignRight' ).addClass('color_darkgreen');



                

              }



            },

            "processing": true,

            "serverSide": true,

            "search" : true,

            "keys": true,

            "ajax": base_urlx+"Balancecuentas/movXcliente?idcli="+$("#cliente").val(),



          "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



            "scrollY": 450,

            "scrollX": true

      });

 


      

      $('#my-table tbody').on('click', 'tr', function () {

          var data = table.row( this ).data();

          idFila = table.row( this ).index();

          //alert(idFila);

          $("#bfecha").val(data[2]);
          $("#bhora").val(data[13]);
          $("#movimiento").val(data[12]);
          $("#rastreo").val(data[3]);
          $("#cuenta_banco").val(data[11]);
          $("#tipo").val(data[9]);
          $("#importe").val(data[10]);

          idEdit=data[8];
          


      } );


    }


}*/


function showCuentas(){

    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Balancecuentas/showCuentas/",

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


$(function () {

    'use strict';

    //alert("subiendo");

    // Change this to the location of your server-side upload handler:

    var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_balance/';

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

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/actualizacion_estado_cuenta.php",//prueba
          //url: base_urlx+"tw/php/crear_xml_facturalo.php",
          data:{ 

            archivo:$("#name_factpdf").val(),
            cuenta_empresa:$("#cuenta").val()

          },
          cache: false,
          success: function(result)
          {

            if ( result ) {

              alert("El archivo se ha cargado exitosamente");

              //location.reload();

            }else{

              alert("Alerta, El archivo no pudo cargar ningun movimiento, favor de revisarlo e intentarlo nuevamente");

            }


          }

      });

  }

}

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



        dom: '<"top" fpli>rt',



        buttons: [ 'copy', 'excel' , 'csv'],

        "order": [  [ 1, "desc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            /* Append the grade to the default row class name */

            if ( true ) // your logic here

          {



            $(nRow).addClass( 'customFont' );



            $('td:eq(0)', nRow).addClass( 'alignCenter' );

            $('td:eq(1)', nRow).addClass( 'alignCenter' );



            $('td:eq(2)', nRow).addClass( 'alignCenter' );



            $('td:eq(3)', nRow).addClass( 'alignCenter' );

            $('td:eq(4)', nRow).addClass( 'alignCenter' );

            $('td:eq(5)', nRow).addClass( 'alignCenter' );



            $('td:eq(6)', nRow).addClass( 'alignRight' ).addClass('color_red');

            $('td:eq(7)', nRow).addClass( 'alignRight' ).addClass('color_darkgreen');


            $('td:eq(8)', nRow).addClass( 'alignCenter' );
            

          }



        },

        "processing": true,

        "serverSide": true,

        "search" : true,

        "keys": true,

        "ajax": base_urlx+"Balancecuentas/loadPartidas?estx="+$("#estatus").val()+"&idclientex="+$("#cliente").val(),



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

  });

  //table.cell(':eq(50)').focus();


    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();

        idFila = table.row( this ).index();

        //alert(idFila);

        $("#bfecha").val(data[2]);
        $("#bhora").val(data[14]);
        $("#movimiento").val(data[13]);
        $("#rastreo").val(data[3]);
        $("#cuenta_banco").val(data[12]);
        $("#tipo").val(data[10]);
        $("#importe").val(data[11]);
        $("#descrip").val(data[17]);
        $("#fpago").val(data[18]);


        clientex=data[5];
        fechax=data[2];
        horax=data[14];

        idEdit=data[9];

        abonox=data[15];

        idclix=data[16];

        $("#rastreo").prop("disabled", false);
        $("#cuenta_banco").prop("disabled", false);


        if(abonox>0){

          $("#error_factura").css("display","none");
          $("#facturas").css("display","");
          $("#infopago").html('<h4 style="font-weight: bold:">Facturas a aplicar</h4><p>'+clientex+' | Fecha: '+fechax+' , Hora: '+horax+'hrs</p><p> #movimiento:'+data[13]+' | Banco: '+data[4]+' ............. <strong style="font-size: 17px;">'+data[7]+'</strong></p>')

          $("#notificacion_saldos").html("");

          $("#inforestante").html('<p style="font-size: 17px; text-align:right;">Saldo restante: <br><strong style="color:darkgreen; font-size:19px;">'+formatNumber(round(abonox))+'</strong></p>');

          showFacturas(data[16]);

        }else{

          $("#error_factura").css("display","");
          $("#facturas").css("display","none");

        }
        

    } );



}

/*******GENERAR EXCEL ***************/
function showExcel() {

  var inputSearch = $("#my-table_filter input[type='search']");

	// Obtiene el valor actual del input de búsqueda
	var valorSearch = inputSearch.val();

  $.ajax({

    type: "POST",

    dataType: "json",

    url: base_urlx + "tw/php/crear_excel_balance_cuentas.php",

    data: { statusx: $("#estatus").val(), clientex : $("#cliente").val(), inputx : valorSearch },

    cache: false,

    success: function (result) {

      if (result) {

        window.location.href = base_urlx + "tw/php/reporte/reporte_balance_cuentas.xlsx";


      } else {
        alert('No se pudo generar excel');
      }
    }
  });
}


function showFacturas(idcli){

    if(idcli>0){

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"Balancecuentas/showFacturas/",//prueba
          //url: base_urlx+"tw/php/crear_xml_facturalo.php",
          data:{ 

            idclientex:idcli

          },
          cache: false,
          success: function(result)
          {

            if ( result!=null ) {

                creaOption="";
                total=0;
                arrayFacturas=[];
                arrayFolios=[];
                arrayFpago=[];
                arrayTipoFact=[];
                arrayTotfactura=[];

                  $.each(result, function(i,item){

                      //total=parseFloat(total)+parseFloat(1);

                      if(item.credito==0){

                        arrayFacturas.push(item.id);
                        arrayFolios.push(item.folio);
                        arrayFpago.push(item.credito);
                        arrayTipoFact.push(item.tipo);
                        arrayTotfactura.push(item.saldo.replace(/[^\d.]/g,""));

                        creaOption=creaOption+'<div class=" col-md-12" style="margin-top: 15px;"><div class="col-md-6 col-lg-6"><label>Información:</label><p><a href="'+base_urlx+'tw/php/facturas/'+item.folio+'.pdf" target="_blank">'+item.folio+'</a> | Credito: '+item.credito+' Dias | Transcurridos: '+item.transcurridos+' Dias</p></div><div class="col-md-3 col-lg-3" style="text-align: right;"><label>Total x saldar</label><input type="text" id="totfact'+item.id+'" name="totfact'+item.id+'"  style="text-align: right;" disabled value="'+item.saldo+'"></div><div class="col-md-3 col-lg-3" style="text-align: right;"><label>Saldo aplicado</label><input type="number" id="saldofact'+item.id+'" name="saldofact'+item.id+'" value="0" style="text-align: right;" onblur="validarSaldos('+item.id+')" ></div></div>';

                      }

                  });


                  //alert(total);


                $("#info_facturas").html(creaOption);



            }else{

              $("#info_facturas").html("<div class='col-md-12' style='margin-left:10px;'><h4>Sin facturas por saldar</h4></div>");

            }


          }

      });

    }

}

function validarSaldos(idx){

  ///////validar que el saldo aplicado a la factura sea correcto 

  resta=parseFloat($("#totfact"+idx).val().replace(/[^\d.]/g,""))-parseFloat($("#saldofact"+idx).val());
  suma_pago=0;
  verificar=0;

  if (resta==0 || resta>0){

    for (var i = 0; i<arrayFacturas.length; i++) {
      

      resta=parseFloat($("#totfact"+arrayFacturas[i]).val().replace(/[^\d.]/g,""))-parseFloat($("#saldofact"+arrayFacturas[i]).val());

      if(resta>0 || resta==0){



      }else{

        verificar=1;
        pfolio=arrayFolios[i];

      }

      suma_pago=parseFloat(suma_pago)+parseFloat( $("#saldofact"+arrayFacturas[i]).val() );

    }

    if(verificar==0){

      //alert("Saldos aplicados correctamente");

      restante=parseFloat(abonox)-parseFloat(suma_pago);

      if(restante<0 || restante==null){

        alert("Alerta, El saldo aplicado no puede superar al importe abonado");

        $("#saldofact"+idx).val("0");
        $("#saldofact"+idx).focus();


      }else if(restante>0 || restante==0){

        //$("#inforestante").html('<p style="font-weight: bold; font-size: 17px;">Saldo restante: <br>'+restante+'</p>');

        $("#inforestante").html('<p style="font-size: 17px; text-align:right;">Saldo restante: <br><strong style="color:darkgreen; font-size:19px;">'+formatNumber(round(restante))+'</strong></p>');


      }

    }else{

      alert("Error, favor de revisar el saldo de la factura "+pfolio+" no fue aplicado correctamente");

    }

  }else{

    alert("Alerta, favor de aplicar un saldo valido");
    $("#saldofact"+idx).val("0");
    $("#saldofact"+idx).focus();

  } 

}

function devolucionPago(idsaldo){

  x=confirm("¿Realmente deseas cambiar el estatus del pago a devolucion?");

    if(x){

            $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"Balancecuentas/devolucionPago/",

              data:{

                idsaldox:idsaldo

              },

              cache: false,

              success: function(result)

              {

                if(result){

                  temp = table.row(idFila).data();


                  temp[0] = "";
                  temp[1] = "Devolucion";

                  $('#my-table').dataTable().fnUpdate(temp,idFila,undefined,false);

                }else{

                  alert("Error, el identificador del pago no fue agregado correctamente, favor de recargar la pagina e intentelo nuevamente");

                }
                
                 

              }

            }).fail( function( jqXHR, textStatus, errorThrown ) {





                detectarErrorJquery(jqXHR, textStatus, errorThrown);



            });

    }

}

function aplicarPago(){


  //VERIFICAR QUE LA SUMA DE LO APLICADO NO SUPERE EL MONTO DEL MOVIMIENTO

  suma_pago=0;
  verificar=0;
  pfolio="";
  verificar_pue=0;
  verificar_ppd=0;

  arrayPagos=[];

  for (var i = 0; i<arrayFacturas.length; i++) {
    

    resta=parseFloat($("#totfact"+arrayFacturas[i]).val().replace(/[^\d.]/g,""))-parseFloat($("#saldofact"+arrayFacturas[i]).val());

    arrayPagos.push($("#saldofact"+arrayFacturas[i]).val());

    if(resta<0){

      verificar=1;
      pfolio=arrayFolios[i];

    }

    if( $("#saldofact"+arrayFacturas[i]).val() > 0){

      creditox=arrayFpago[i];

      if(creditox>0){

        ///SUMA A PPD

        verificar_ppd=1;

      }else if(creditox==0){

        ///// SUMA A PUE
        verificar_pue=1;

      }

    }

    suma_pago=parseFloat(suma_pago)+parseFloat( $("#saldofact"+arrayFacturas[i]).val() );

  }

  if(verificar==0){

    if(suma_pago>0){

      restante=parseFloat(abonox)-parseFloat(suma_pago);

      if(restante<0 || restante==null){

        alert("Alerta, El saldo aplicado no puede superar al importe abonado");

        //$("#saldofact"+idx).val("0");
        //$("#saldofact"+idx).focus();


      }else if(restante>0 || restante==0){

        //$("#inforestante").html('<p style="font-weight: bold; font-size: 17px;">Saldo restante: <br>'+restante+'</p>');

        $("#inforestante").html('<p style="font-size: 17px; text-align:right;">Saldo restante: <br><strong style="color:darkgreen; font-size:19px;">'+formatNumber(round(restante))+'</strong></p>');

          //REVISAR Y APLICAR SALDO A LAS FACTURAS PUE

          $("#btnaplicar").prop("disabled",true);
          $("#btnaplicar").html("Aplicando...");

          if(verificar_pue==1){


            $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"Balancecuentas/aplicarPago/",

              data:{

                idmovimiento:idEdit,
                abono_movimiento:abonox,
                ids:arrayFacturas,
                saldos:arrayPagos,
                tipos:arrayTipoFact,
                creditos:arrayFpago,
                tot_facturas:arrayTotfactura

              },

              cache: false,

              success: function(result)

              {

                //alert(result.length);
                
                  if(result){

                    $("#notificacion_saldos").html("<div class='col-md-12' ><h4 style='color:darkgreen; font-weight:bold;'>Las facturas PUE fueron saldadas correctamente</h4></div>");

                    temp = table.row(idFila).data();
                    temp[1]="Aplicado";

                    $('#my-table').dataTable().fnUpdate(temp,idFila,undefined,false);
                    CierraPopup3();

                  }else{

                    $("#notificacion_saldos").html("<h4>Error, al saldar las facturas PUE, favor de recargar la pagina e intentarlo nuevamente</h4>");

                    CierraPopup3();

                  }

                  $("#btnaplicar").prop("disabled",false);
                  $("#btnaplicar").html("Aplicar");

              }



            }).fail( function( jqXHR, textStatus, errorThrown ) {





                detectarErrorJquery(jqXHR, textStatus, errorThrown);



            });

          }

      }

    }else{

      alert("Alerta, antes debes aplicar algun saldo");

    }



  }else{

    alert("Error, favor de revisar el saldo de la factura "+pfolio+" no fue aplicado correctamente");

  }


}


function aplicarPagoPpd(){

      ////////// NO ESTA EN USO ///////////////

            $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"Balancecuentas/aplicarPago/",

              data:{

                idmovimiento:idEdit,
                abono_movimiento:abonox,
                ids:arrayFacturas,
                saldos:arrayPagos,
                tipos:arrayTipoFact,
                creditos:arrayFpago,
                tot_facturas:arrayTotfactura,
                iduser:iduserx,
                idcliente:idclix

              },

              cache: false,
              success: function(result)

              {

                $("#btnaplicar").prop("disabled",false);
                $("#btnaplicar").html("Aplicar");

              }



            }).fail( function( jqXHR, textStatus, errorThrown ) {





                detectarErrorJquery(jqXHR, textStatus, errorThrown);



            });

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

function showinfoPago(idxpago){

  if(idxpago==3){

    $("#rastreo").prop("disabled", false);
    $("#cuenta_banco").prop("disabled", false);

  }else{

    $("#rastreo").prop("disabled", true);
    $("#cuenta_banco").prop("disabled", true);

  }

}


function CierraPopup() {



  $('#cerrarx2').click(); //Esto simula un click sobre el botón close de la modal, por lo que no se debe preocupar por qué clases agregar o qué clases sacar.

  $('.modal-backdrop').remove();//eliminamos el backdrop del modal



}

function CierraPopup2() {



  $('#cerrarx3').click(); //Esto simula un click sobre el botón close de la modal, por lo que no se debe preocupar por qué clases agregar o qué clases sacar.

  $('.modal-backdrop').remove();//eliminamos el backdrop del modal


}

function CierraPopup3(){

  $('#cerrarx4').click(); //Esto simula un click sobre el botón close de la modal, por lo que no se debe preocupar por qué clases agregar o qué clases sacar.

  $('.modal-backdrop').remove();//eliminamos el backdrop del modal

}


function actualizarMov(){

  verificar = 0;

  if( $("#bfecha").val() == "" && verificar==0 || $("#bfecha").val == null && verificar== 0 ){

    alert("Alerta, favor de ingresar una fecha valida");
    $("#bfecha").focus();
    verificar=1;

  }
  if( $("#bhora").val() == "" && verificar==0 || $("#bhora").val == null && verificar== 0 ){

    alert("Alerta, favor de ingresar una hora valida");
    $("#bhora").focus();
    verificar=1;  

  }
  if( $("#movimiento").val() == "" && verificar==0 || $("#movimiento").val == null && verificar== 0 ){

    alert("Alerta, favor de ingresar un movimiento valido");
    $("#movimiento").focus();
    verificar=1;

  }
  if( $("#rastreo").val() == "" && verificar==0 || $("#rastreo").val == null && verificar== 0 ){

    alert("Alerta, favor de ingresar un numero de rastreo valido");
    $("#rastreo").focus();
    verificar=1;

  }
  if( $("#cuenta_banco").val() == "" && verificar==0 || $("#cuenta_banco").val == null && verificar== 0 ){

    alert("Alerta, favor de ingresar una cuenta valida");
    $("#cuenta_banco").focus();
    verificar=1;

  }
  if( $("#importe").val() == "" && verificar==0 || $("#importe").val == null && verificar== 0 ){

    alert("Alerta, favor de ingresar un importe valido");
    $("#importe").focus();
    verificar=1;

  }

  if (verificar==0){

    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Balancecuentas/actualizarMov/",
            data:{

                idx:idEdit,
                bfechax:$("#bfecha").val(),
                bhorax:$("#bhora").val(),
                movimientox:$("#movimiento").val(),
                rastreox:$("#rastreo").val(),
                cuentax:$("#cuenta_banco").val(),
                importex:$("#importe").val(),
                tipox:$("#tipo").val(),
                xfpago:$("#fpago").val()

            },

            cache: false,

            success: function(result)

            {

              if (result!=null) {

                temp = table.row(idFila).data();

                  if(result.estatus==0){

                    temp[1] = "Sin aplicar";

                  }else if (result.estatus==1){

                    temp[1] = "Aplicado";

                  }

                  temp[2] = result.fecha_banco;

                  temp[3] = result.rastreo;

                  temp[4] = result.cuentax;

                  temp[5] = result.nombrex;

                  if(result.tipo == 1){

                    temp[6] = formatNumber( round(result.importe) );

                    temp[7] = 0;

                  }else if(result.tipo==2){

                    temp[6] = 0;

                    temp[7] = formatNumber( round(result.importe) );

                  }

                  temp[8] = $('select[name="fpago"] option:selected').text();

                  temp[9]=result.id;

                  temp[10] =result.tipo;

                  temp[11] =result.importe;

                  temp[12] =result.cuenta;

                  temp[13] =result.movimiento;

                  temp[14] =result.hora_banco;



                  $('#my-table').dataTable().fnUpdate(temp,idFila,undefined,false);

                  CierraPopup2();

                  

              }else{


                alert("Alerta, el movimiento no puedo ser actualizado correctamente");

              }

                $('#progress_bar_factpdf .progress-bar').css('width','0%');

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });

  } 

  

}