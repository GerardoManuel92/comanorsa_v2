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

function retirarPesos(pesos){

  if ( pesos != "" ) {

    return pesos.replace(/[^\d.]/g,"");

  }else{

    return "0";

  }

}

function validarFormatoFecha(campo) {

      separar = campo.split("-");
      fechanew = separar[2]+"/"+separar[1]+"/"+separar[0];

      var RegExPattern = /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
      if ((campo.match(RegExPattern)) && (fechanew!='')) {
            return true;
      } else {
            return false;
      }
}

function fechaEspanol(fechax){

  var fecha = new Date(fechax);
  fecha.setDate(fecha.getDate() + 1);
  var options = { year: 'numeric', month: 'long', day: 'numeric' };

  return fecha.toLocaleDateString("es-ES", options);

  /*console.log(
    fecha.toLocaleDateString("es-ES", options)
  );*/

}

alert("version 1.0");


showCliente();
var idFactura = 0;
var totFactura = 0;

function zero(n) {
 return (n>9 ? '' : '0') + n;
}
var date = new Date();

var fechahoy = date.getFullYear() +"-"+zero(date.getMonth()+1) +"-"+zero(date.getDate());

$("#fecha").val(fechahoy);

////
$(".select2").select2();
$(".select2-placeholer").select2({
  allowClear: true

});

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
                      creaOption=creaOption+'<option value="'+data1+'">'+data2+'-'+data3+' | '+data4+' <strong style="color:darkblue;">'+data4+'</strong></option>'; 
                  }); 

                  $("#cliente").html(creaOption);

              }else{

                 $("#cliente").html("<option value='0'>Sin categorias</option>");

              }

              showFpago();
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

function showFpago(){

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Ppd/showFpago/",
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
                  $("#fpago").val(21);

              }else{

                 $("#fpago").html("<option value='0'>Sin categorias</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

function calcularSubtotal(totalx,pagadox){

  facttotal = totalx.replace(/[^\d.]/g,"");
  factpagado = pagadox.replace(/[^\d.]/g,"");

  xpagar = parseFloat(facttotal)-parseFloat(factpagado);

  return formatNumber( round(xpagar) );

}

function showInfo(idfactx){

  if ( idfactx > 0 ) {

    ///// MOSTRAR OS IMPORTES DE LOS COMPLEMENTOS DE PAGOS YA TIMBRADOS Y LOS IMGRESADOS EN EL TEMPORAL  

    $("#cpagos").html("<h4>No hay partidas que mostrar</h4>");   

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Ppd/showInfo/",
            data:{idfact:idfactx},
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  sumanpago = 0;
                  sumatpago = 0;

                  $.each(result, function(i,item){
                      
                    sumanpago = parseFloat(sumanpago)+parseFloat(item.npagos);
                    sumatpago = parseFloat(sumatpago)+parseFloat(item.total);

                  }); 

                  //alert("npagos:"+sumanpago+" tpagos:"+sumatpago);

                  total_factura = retirarPesos(totFactura);
                  //alert(total_factura);
                  saldo = parseFloat(total_factura)-parseFloat(sumatpago);

                  $("#npago").val( parseInt(sumanpago)+parseInt(1) );
                  $("#saldo").val( formatNumber(round(saldo)) ) ;

                  showPartidas(idfactx);


              }else{

                  $("#npago").val("1");
                  $("#saldo").val(retirarPesos(totFactura));

              }

              
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

  }else{

    alert("Error, el ID e la factura no fue localizado correctamente, favor de volver a recargar la pagina e intentarlo nuevamente");

  }

}

$(document).ready(function() {


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
          "order": [  [ 0, "asc" ] ],

          "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
              /* Append the grade to the default row class name */
              if ( true ) // your logic here
                {

                  $(nRow).addClass( 'customFont' );

                  //$('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' ).addClass( 'bgcolor1' );
                  /*

                  $('td:eq(2)', nRow).addClass( 'alignRight' );
                  $('td:eq(3)', nRow).addClass( 'alignRight' ).addClass('bgdocumento').addClass( 'bold' );*/
                  $('td:eq(4)', nRow).addClass( 'alignRight' );
                  $('td:eq(5)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );
                  $('td:eq(6)', nRow).addClass( 'alignRight' ).addClass('bgcolor_darkgreen').addClass( 'color_darkgreen' );;
                  $('td:eq(7)', nRow).addClass( 'alignRight' ).addClass( 'bold' ).addClass('color_red');
                  //$('td:eq(2)', nRow).addClass( 'fontText2' );

                  
                }
          },
          columnDefs: [

              {
                 targets: [7],
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

                    valor2=calcularSubtotal( data[4],data[6] );

                    return ``+valor2+``         

                 }

                 
              }

          ],

          "processing": true,
          "serverSide": true,
          "search" : false,
          "ajax": base_urlx+"Ppd/loadPartidas?idcliente="+$("#idcliente").val(),

        "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]],

          "scrollY": 300,
          "scrollX": true
      });

      /////////////********* CLICK 
    $('#my-table tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();


          idFactura = data[8];
          totFactura = data[4];

          //ssalert(totFactura);

          showInfo(idFactura);
        

    } );
     

      table
      .buttons()
      .container()
      .appendTo( '#controlPanel' );


});

function tCambio(idmoneda){

  if ( idmoneda == 2 ) {

    $("#tcambio").prop("disabled", false);

  }else{

    $("#tcambio").prop("disabled", true);
    $("#tcambio").val("0");

  }

}

function showPartidas(idfactx){

  if ( idfactx > 0 ) {

    $("#cpagos").html("<h4>No hay partidas que mostrar</h4>");

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Ppd/showPartidas/",
            data:{idfact:idfactx},
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption=""; 

                  $.each(result, function(i,item){

                    monedax = item.moneda;
                    moneda = "";

                    if ( monedax == 2 ) {

                      tcambiox = item.tcambio;
                      moneda = "DOLARES";

                    }else{

                      tcambiox = item.tcambio;
                      moneda = "PESOS";
                    }

                    creaOption=creaOption+'<div class="col-md-8"><h4><a href="javascript:retirarComprobante('+item.id+')" style="color:red;"><i class="fa fa-trash" style="color: red:"></i></a>&nbsp; Pago No.'+item.npago+' </h4>Fecha de pago: '+fechaEspanol(item.fecha)+'</p><p>Moneda: '+moneda+' | T.Cambio: '+tcambiox+' | Forma de pago: '+item.clave+'-'+item.descripcion+' </p><p>Saldo anterior: '+formatNumber(round(item.saldo))+' | <strong style="color:red;">Saldo posterior: '+formatNumber(round(item.insoluto))+'</strong></p></div><div class="col-md-3"><p style="text-align: right; color:darkgreen; font-weight:bold; font-size:22px;" > Pagado <br>'+formatNumber(round(item.pago))+'</p></div>';

                  }); 

                  $("#cpagos").html(creaOption);

                  

              }else{

                $("#cpagos").html("<h4>No hay partidas que mostrar</h4>");

              }

              /////// regresar cursor

              $("#pagado").val("");
              $("#fpago").val(21);
              $("#tcambio").prop("disabled",true);
              $("#tcambio").val("");
              $("#moneda").val(1);

              $("#pagado").focus();

 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

  }

}

function retirarComprobante(idcompx){

  if ( idcompx > 0 ) {

    x = confirm("¿Realmente deseas retirar este complemento de pago?")

    if( x ){

      $.ajax({
              type: "POST",
              dataType: "json",
              url: base_urlx+"Ppd/retirarComprobante/",
              data:{ idcomp:idcompx,idfact:idFactura,total:retirarPesos(totFactura) },
              cache: false,
              success: function(result)
              {

                if ( result ) {

                  alert("El comprobante fue retirado con exito");
                  showInfo(idFactura);
                  //showPartidas(idFactura);

                }else{

                  alert("Error, los datos del pago no se mostraron correctamente favor de cerrar la ventana y volver a seleccionar la factura");

                }
   
              }

      }).fail( function( jqXHR, textStatus, errorThrown ) {


          detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });

    }

  }

}

function ingresarPago(){

  if( $("#pagado").val() > 0 ){

    ////// reviar que el importe no supere la cantidad restante de pago 

    restante = retirarPesos( $("#saldo").val() );
    diferencia = parseFloat(restante)-parseFloat( round($("#pagado").val()) );

    verificar = 0;

    if ( diferencia < 0 ) {

      alert("Alerta, el importe a comprobar no puede superar el limite del saldo anterior");
      verificar = 1;

    }

    /*if ( validarFormatoFecha( $("#fecha").val() ) == false ) {

      alert("Alerta, favor de ingresar una fecha del pago valida");
      verificar = 1;

    }*/

    if ( verificar == 0 ) {

      $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Ppd/ingresarPago/",
            data:{

              fecha: $("#fecha").val(),
              moneda: $("#moneda").val(),
              tcambio: $("#tcambio").val(),
              npago: $("#npago").val(),
              saldo: retirarPesos( $("#saldo").val() ),
              pago: $("#pagado").val(),
              fpago: $("#fpago").val(),
              idfact: idFactura,
              insoluto:diferencia


            },
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                showInfo(idFactura);
                alert("La insercion del comprobante fue realizada correctamente");

              }else{

                alert("Error, favor de intentarlo nuevamente");

              }
 
            }

      }).fail( function( jqXHR, textStatus, errorThrown ) {


          detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });

    }

  }else{

    alert("Alerta, favor de ingresar un importe a comprobar valido");

  }

}

//////////********** TIMBRAR PAGO*********///////////////

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

              if ( result > 0) {

                alert("Alerta, favor de agregar un complemento de pago valido");

              }else{

                alert(result);

              }
 
            }

      }).fail( function( jqXHR, textStatus, errorThrown ) {


          detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });

  }else{

    alert("Error, el ID del complemento no fue generado correctamente");

  }

}

function obtenerQr(idfacturax){

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

}


function timbrarPago(){

  x = confirm("¿Deseas timbrar este complemento de pago?");

  if ( x ) {

    if ( $("#idcliente").val() != "" ) {

        $.ajax({
              type: "POST",
              dataType: "json",
              url: base_urlx+"tw/php/alta_timbrado_complemento_prueba.php",
              data:{

                idcli: $("#idcliente").val(),
                iduser: iduserx

              },
              cache: false,
              success: function(result)
              {

                if ( result > 0 ) {

                  alert("Facturado con exito");
                  //retirarTimbrado(result)

                }else{

                  alert(result);

                }

   
              }

        }).fail( function( jqXHR, textStatus, errorThrown ) {


            detectarErrorJquery(jqXHR, textStatus, errorThrown);

        });

    }else{

      alert("Alerta, favor de recargar la pagina actual ya que el ID del cliente no fue asignado correctamente");

    }
  }

}

