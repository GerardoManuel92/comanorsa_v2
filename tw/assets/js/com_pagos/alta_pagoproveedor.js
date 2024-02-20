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

function toMoney(numero) {
  const formatoMoneda = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD'
  });

  return formatoMoneda.format(numero);
}

function ofMoney(cadenaMoneda) {
  const numero = parseFloat(cadenaMoneda.replace(/[^\d.-]/g, ''));
  return isNaN(numero) ? "Formato no válido" : numero;
}

function obtenerODC(valor) {
  let folioX = 0;
  const inicio = 10000;
  const folio = parseInt(valor);

  const nuevo = inicio + folio;

  switch (nuevo.toString().length) {
    case 5:
      folioX = "ODC00" + nuevo;
      break;
    case 6:
      folioX = "ODC0" + nuevo;
      break;
    case 7:
      folioX = "ODC" + nuevo;
      break;
    default:
      folioX = "s/asignar";
      break;
  }
  return folioX;

}

function obtenerID(valorODC) {
  const inicio = 10000;
  const folio = parseInt(valorODC.substring(3));
  const nuevo = inicio + folio;

  switch (nuevo.toString().length) {
    case 5:
      return nuevo % 10000; 
    case 6:
      return nuevo % 10000;
    case 7:
      return nuevo % 10000;
    default:
      return "s/asignar";
  }
  
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
var importe = 0;
var importeUtilizado = 0;
var dataClick = [];
/*var mcuenta="";
var mfecha="";
var mhora="";
var mmovimiento="";
var mrastreo="";
var mimporte=0;*/


showProveedor();
showCuentas();
showODC();

function obtenerValorNumerico(texto) {
 
  const matches = texto.match(/[\d,]+(?:\.\d+)?/);

  if (matches) {
    const valorNumerico = parseFloat(matches[0].replace(/,/g, ''));
    return valorNumerico;
  }

  return NaN;
}


function showProveedor(){

    $.ajax({

            type: "POST",
            dataType: "json",
            url: base_urlx+"Pagoproveedor/showProveedor/",
            cache: false,

            success: function(result)

            {

              if ( result != null ) {

                  var creaOption="<option value='0' selected>Seleccionar un proveedor...</option>"; 

                  $.each(result, function(i,item){

                      data1=item.id;//id
                      data2=item.nombre;//nombre
                      data3=item.comercial;
                      creaOption=creaOption+'<option value="'+data1+'">'+data2+' - '+data3+'</option>'; 

                  }); 

                  $("#cliente").html(creaOption);
                  $("#modalAccountsProveedor").html(creaOption);

              }else{

                 $("#cliente").html("<option value='0'>Sin proveedores almacenados</option>");
                 $("#modalAccountsProveedor").html("<option value='0'>Sin proveedores almacenados</option>");

              }

            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {

        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

function showODC(){

  $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"Pagoproveedor/showODC/",
          cache: false,

          success: function(result)

          {

            if ( result != null ) {

                var creaOption="<option value='0' selected>Selecciona una ODC ...</option>"; 

                $.each(result, function(i,item){

                    data1=item.id;//id
                    data2=item.nom;//nombre
                    creaOption=creaOption+'<option value="'+data1+'">'+data2+'</option>'; 

                }); 

                $("#modalPagoSelctODC").html(creaOption);

            }else{

               $("#modalPagoSelctODC").html("<option value='0'>Sin clientes almacenados</option>");

            }

          }

  }).fail( function( jqXHR, textStatus, errorThrown ) {

      detectarErrorJquery(jqXHR, textStatus, errorThrown);

  });

}


function showCuentas(){

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Pagoproveedor/showCuentas/",
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

    var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_balance_cargos/';

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

$(function () {

  'use strict';

  var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_evidencia_saldos/';

  $('#fileODC').fileupload({

      url: url,
      dataType: 'json',
      done: function (e, data) {

          //quitarArchivo(f);

          $.each(data.result.files, function (index, file) {

            $("#nameODC").val(file.name); 

          });

      },

          progressall: function (e, data) {

              var progress = parseInt(data.loaded / data.total * 100, 10);
              $('#barODC .progress-bar').css(
                  'width',
                  progress + '%'
              );

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
          url: base_urlx+"tw/php/actualizacion_estado_cargos.php",//prueba
          data:{ 

            archivo:$("#name_factpdf").val(),
            cuenta_empresa:$("#cuenta").val()

          },
          
          cache: false,
          success: function(result)
          {
            if ( result ) {
              alert("El archivo se ha cargado exitosamente");
              location.reload();
            }else{
              alert("Alerta, El archivo no pudo cargar ningun movimiento, favor de revisarlo e intentarlo nuevamente");
            }
          }

      });

  }

}

showInfo();

$("#modalPagoNumberImporte").on('input', function() {
  var valor = $(this).val();
  var maximo = parseFloat($(this).attr('max'));

  if (valor < 0) {
      $(this).val(0);
  }
  if (valor > maximo) {
      $(this).val(maximo);
  }
}).on('paste', function(e) {
  e.preventDefault(); // Evita que se realice la acción de pegado
});

function showInfo(){

  if ( table !="" ) {

    $('#my-table').DataTable().destroy();

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

        dom: '<"top" fpl>rt',

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
            $('td:eq(7)', nRow).addClass( 'alignCenter' );
            
          }

        },

        "processing": true,
        "serverSide": true,
        "search" : true,
        "keys": true,
        "ajax": base_urlx+"Pagoproveedor/loadPartidas?estx="+$("#estatus").val()+"&idclientex="+$("#cliente").val(),

      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

        "scrollY": 450,

        "scrollX": true

  });

  //table.cell(':eq(50)').focus();


    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {
        dataClick = [];
        var data = table.row( this ).data();
        dataClick = table.row( this ).data();
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
        

        $("#modalPagoDescription").html(
          'Proveedor: <span id="modalPagoProveedor">'+data[5]+'</span><br>' +
          'No. Cuenta/Banco: <span id="modalPagoCuenta">'+data[4]+'</span><br>' +
          'No. Rastreo: <span id="modalPagoRastreo">'+data[3]+'</span><br>' +
          'Forma de pago: <span id="modalPagoMetodo">'+data[7]+'</span><br>' +
          'Importe de pago: <span id="modalPagoImporte">'+data[6]+'</span><br>'+
          '<span id="modalPagoOculto" style="display: none;">'+data[9]+'</span>'
        );

        $("#modalAccountDescription").html(
          'No. Cuenta/Banco: <span id="modalAccountBanco">'+data[4]+'</span><br>' +
          'No. Rastreo: <span id="modalAccountRastreo">'+data[3]+'</span><br>' +          
          'Importe de pago: <span id="modalAccountImporte">'+data[6]+'</span><br>'+
          '<br>'+
          '<span id="modalAccountDescription">'+data[17]+'</span><br>'+
          '<span id="modalAccountOculto" style="display: none;">'+data[9]+'</span>'
        );

        $("#modalAccounsCuenta").val(obtenerCuenta(data[4]));

        importe = obtenerValorNumerico(data[6]);

        clientex=data[5];
        fechax=data[2];
        horax=data[14];

        idEdit=data[9];

        abonox=data[15];

        idclix=data[16];
        

        
        

        //obtenerOcrearXML(data[9]);

        $("#rastreo").prop("disabled", false);
        $("#cuenta_banco").prop("disabled", false);

    } );

}


        
  $('#modal_pagos').on('shown.bs.modal', function () {
    cargarPagosTemporal(dataClick[9]);
    $("#modalPagoNumberImporte").attr('max', obtenerValorNumerico(dataClick[6]));
  });

  $('#modalAccounts').on('shown.bs.modal', function () {
    
  });

  $('#modalODC').on('shown.bs.modal', function () {
    showODCxSaldo();
  });

  function obtenerCuenta(cuenta) {

    var regex = /\b\d+\b/;
    var numeroEncontrado = cuenta.match(regex);

    if (numeroEncontrado !== null) {
        var numeroExtraido = numeroEncontrado[0];
        return numeroExtraido;
    } else {
        return null;
    }
  }

  function actualizarCuenta() {
    
    if($("#modalAccounsCuenta").val() == "" || $("#modalAccountsProveedor").val() == 0 ){

      alert("Favor de llenar todos los campos");

    }else{

      $.ajax({
        type: "POST",
        dataType: "json",
        url: base_urlx+"Pagoproveedor/actualizarCuenta/",
        data:{ 
  
          idbancox:$("#modalAccountsBanco").val(),
          cuentax:$("#modalAccounsCuenta").val(),
          idProveedor:$("#modalAccountsProveedor").val(),
          idSaldo:$("#modalPagoOculto").text()
  
        },
        cache: false, 
          success: function (response) {
              location.reload();
          },
          error: function (error) {
              console.log('Error en la solicitud AJAX:', error);
          }
      });

    }

  }

  function cargarPagosTemporal(idSaldo) {
  
    importeUtilizado = 0;
    $('#modalPagosTable').empty();

    $.ajax({
      type: "POST",
      dataType: "json",
      url: base_urlx+"Pagoproveedor/cargarPagosTemporal/",//prueba
      //url: base_urlx+"tw/php/crear_xml_facturalo.php",
      data:{ 

        idSaldo:idSaldo

      },
      cache: false,
        success: function (data) {
  
            if(data!=null){

              $.each(data, function (index, item) {
                  var newRow = '<tr>' +
                      '<td>' + obtenerODC(item.idodc) + '</td>' +
                      '<td>' + toMoney(item.total) + '</td>' +
                      '<td><button class="btn btn-danger" type="button" onclick="eliminarFila(this)"><i class="fa fa-trash"></i></button></td>' +
                      '</tr>';
                  importeUtilizado = parseFloat(importeUtilizado) + parseFloat(item.total);
                  $('#modalPagosTable').append(newRow);
              });
            }

            $('#containerLoading').hide();
            $('#containerTablePagos').show();

        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
  }

  function cargaraTemporal() {

    $('#containerLoading').show();
    $('#containerTablePagos').hide();

    importe = 0;
    importeUtilizado = 0;

    var datosTabla = [];

    $('#modalPagosTable tr').each(function () {
        var odc = $(this).find('td:eq(0)').text();
        var importe = $(this).find('td:eq(1)').text();

        var fila = { ODC: obtenerID(odc), IMPORTE: ofMoney(importe) };
        datosTabla.push(fila);
    });
    
    $.ajax({
      type: "POST",
      dataType: "json",
      url: base_urlx+"Pagoproveedor/cargaraTemporal/",
      data:{ 

        datos:datosTabla,
        idSaldo: $("#modalPagoOculto").text()

      },
      cache: false, 
        success: function (response) {
            console.log(response);
        }
    });
  }

  function agregarFila() {
    
      var selectValue = document.getElementById("modalPagoSelctODC").value;
      var numberValue = document.getElementById("modalPagoNumberImporte").value;
      

      if (selectValue!=0 && numberValue!=0) {
        if(parseFloat(importeUtilizado)+parseFloat(numberValue) <= importe){

          var tablaBody = document.getElementById("modalPagosTable");

          var newRow = tablaBody.insertRow();
          var cell1 = newRow.insertCell(0);
          var cell2 = newRow.insertCell(1);
          var cell3 = newRow.insertCell(2);

          cell1.innerHTML = obtenerODC(selectValue);
          cell2.innerHTML = toMoney(numberValue);
          cell3.innerHTML = '<button class="btn btn-danger" type="button" onclick="eliminarFila(this)"><i class="fa fa-trash"></i></button>';
          importeUtilizado = parseFloat(importeUtilizado) + parseFloat(numberValue);

        }else{
          alert("Estas revasando el importe del saldo");
        }
          
      } else {
          alert("Selecciona la ODC y el importe correspondiente");
      }
  }

  function eliminarFila(button) {
      var row = button.parentNode.parentNode;
      var selectValue = row.cells[0].innerHTML;

      var restarImporte = row.cells[1].innerHTML;
      importeUtilizado = parseFloat(importeUtilizado) - parseFloat(restarImporte); 

      row.parentNode.removeChild(row);
  }

  showBancos();

  function showBancos(){

    $.ajax({
  
            type: "POST",
  
            dataType: "json",
  
            url: base_urlx+"Pagoproveedor/showBancos/",
  
            cache: false,
  
            success: function(result)
  
            {
  
              if ( result != null ) {
  
  
                  var creaOption=""; 
  
                  $.each(result, function(i,item){
  
                      data1=item.id;//id
                      data2=item.rfc;//nombre
                      data3=item.comercial;
  
                      creaOption=creaOption+'<option value="'+data1+'">'+data2+' - '+data3+'</option>'; 
  
                  }); 
  
  
  
                  $("#modalAccountsBanco").html(creaOption);
  
  
              }else{
  
                 $("#modalAccountsBanco").html("<option value='0'>Sin bancos almacenados</option>");
  
              }
  
  
  
            }
  
  
  
    }).fail( function( jqXHR, textStatus, errorThrown ) {
  
        detectarErrorJquery(jqXHR, textStatus, errorThrown);
  
    });
  
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


function aplicarPago() {
    $("#btnaplicar").prop("disabled", true);
    var datosTabla = [];

    $('#modalPagosTable tr').each(function () {
        var odc = $(this).find('td:eq(0)').text();
        var importe = $(this).find('td:eq(1)').text();

        var fila = { ODC: obtenerID(odc), IMPORTE: ofMoney(importe) };
        datosTabla.push(fila);
    });

    if(datosTabla.length == 0){

      alert("No de encontro ningun pago cargado");
      $("#btnaplicar").prop("disabled", false);

    }else{
      if(importe == importeUtilizado){
        if($("#nameODC").val() == ""){
          alert("No de encontro ninguna evidencia");
          $("#btnaplicar").prop("disabled", false);
        }else{
          $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Pagoproveedor/aplicarPago/",
            data:{ 
      
              datos:datosTabla,
              idSaldo: $("#modalPagoOculto").text(),
              idProveedor: idclix,
              evidencia: $("#nameODC").val()
      
            },
            cache: false, 
              success: function (response) {
                  location.reload();
              },
              error: function (xhr, status, error) {
                console.log('Error en la solicitud AJAX:');
                console.log('Estado:', status);
                console.log('Error:', error);
                console.log('Respuesta del servidor:', xhr.responseText);
            }
          });
        } 
      }else{
        alert("No has cubierto el importe total");
        $("#btnaplicar").prop("disabled", false);
      }
      

    }
  
}

function showODCxSaldo(){

  $("#viewODC").html("");

  $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Pagoproveedor/showODCxSaldo",
            data:{
              idSaldo:$("#modalPagoOculto").text()
            },
            cache: false,

            success: function(result)
            {

              if ( result != null ) {
                  var creaOption=""; 
                  //var enlaceEvidencia = $("#enlaceEvidencia");
                  var evident = "";
                  $.each(result, function(i,item){
                      data1=item.fecha;//id
                      data2=item.idodc;
                      data3=item.total;
                      data4=item.nombre;
                      data5=item.evidencia;
                      evident = data5;
                      creaOption=creaOption+'<div class="col-md-6 col-lg-6"><div class="card"><div class="card-header"><div class="card-photo"><img class="img-circle avatar" src="'+base_urlx+'comanorsa/banco2.png" alt="" title=""></div><div class="card-short-description"><h5><span class="user-name"><a href="'+base_urlx+'tw/php/ordencompra/odc'+data2+'.pdf" target="_blank">ODC: '+data2+' </a></span></h5><p>Fecha: '+data1+'</p><p>Proveedor: '+data4+'</p><p>Fecha: '+data1+'</p><p>Total: '+formatNumber(data3)+'</p></div></div></div></div>'; 
                      //enlaceEvidencia.attr("href", base_urlx+"tw/js/upload_evidencia_saldos/files/"+data5).attr("target", "_blank");
                  }); 

                  $("#viewODC").html(creaOption);

                  $("#modalODCDescription").html(
                    'Proveedor: <span id="modalPagoProveedor">'+dataClick[5]+'</span><br>' +
                    'No. Cuenta/Banco: <span id="modalPagoCuenta">'+dataClick[4]+'</span><br>' +
                    'No. Rastreo: <span id="modalPagoRastreo">'+dataClick[3]+'</span><br>' +
                    'Forma de pago: <span id="modalPagoMetodo">'+dataClick[7]+'</span><br>' +
                    'Importe de pago: <span id="modalPagoImporte">'+dataClick[6]+'</span><br>'+
                    'Evidencia: <a id="enlaceEvidencia2" target="_blank" href="'+base_urlx+'tw/js/upload_evidencia_saldos/files/'+evident+'">'+evident+'</a><br>'+
                    '<span id="modalODCOculto" style="display: none;">'+dataClick[9]+'</span>'
                  );

              }else{



                 $("#viewODC").html("<div class='col-md-12'><h4>Sin cuentas bancarias...</h4></div>");

              }

            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {

        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

function aplicarPagoPpd(){

      ////////// NO ESTA EN USO ///////////////

            $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"Pagoproveedor/aplicarPago/",

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

            url: base_urlx+"Pagoproveedor/actualizarMov/",
            data:{

                idx:idEdit,
                bfechax:$("#bfecha").val(),
                bhorax:$("#bhora").val(),
                movimientox:$("#movimiento").val(),
                rastreox:$("#rastreo").val(),
                cuentax:$("#cuenta_banco").val(),
                importex:$("#importe").val(),
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