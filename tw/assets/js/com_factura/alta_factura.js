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

var indexTabla = 0;
var idxt = "";
var colx = "";
var valorcosto = 0;
var valorprecio = 0;

//////////////

///////
var idPro = 0;
var idDescrip = "";
var idIva = 0;
var idCiva = 0;
var idPact = 0;
////////////********* variables de recuperacion 

var editId = 0;
var editParte = 0;
var editDescrip = "";
var editCantidad = 0;
var editUnidad = "";
var editCosto = 0;
var editIva = 0;
var editDesc = 0;
var editSubtotal = 0;
var idFila = "";

var editCproveedor = 0;
var edittcambio = 0;
var editUtil = 0;

var total_neto = 0;
var limite_autorizado=0;
var limit_excedido = 0;
var saldo_disponible=0;

var Idpcot = 0;


//alert("version8.0");

//////************* EDITAR CELDAD

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

      if ( colx == 3 ||  colx == 0 || colx == 5 || colx == 11 || colx == 7 ) {

        row.invalidate()

      }else{

          $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Factpedido/updateCelda/",
            data:{

              texto:e.target.textContent,
              columna:colx,
              idpcot:editId,
              idcpro:editCproveedor,
              idpcotizacion:Idpcot

            },
            cache: false,
            success: function(result)
            {

              if ( result != null && result != 0) {

                temp = table.row(idFila).data();

                temp[6] = formatNumber( round(result.costo) );
                temp[2] = round(result.cantidad);
                temp[4] = result.descripcion;
                temp[8] = round(result.descuento);

                temp[9] = round(result.utilidad);
                temp[10] = round(result.tcambio);

                temp[11] = formatNumber( round( round(result.costo)*result.cantidad ) );

                temp[15] = round(result.subtotal);
                temp[16] = round(result.tiva);
                temp[17] = round(result.tdescuento);



                $('#my-table').dataTable().fnUpdate(temp,idFila,undefined,false);

                $("#tneto").html("Calculando...");

                setTimeout(function (){
                    
                    sumaTotal();              
                              
                }, 1000);

                //alert("Se ha actualizado cantidad: "+result.cantidad+" costo: "+result.costo);

              }else if ( result == null ){

                alert("Alerta, favor de intentar actualizarlo nuevamente");
                row.invalidate()

              }else if ( result == 0 ){

                alert("Alerta, la cantidad no puede ser 0 o mayor a la solicitada en el pedido");
                row.invalidate()

              }

            }

          });

      }
      
    }

  })
}

function sumaTotal(){

  total_cot =0;
  total_desc =0;
  total_iva =0;

  $('#my-table').DataTable().rows().data().each(function(el, index){
    //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria

    total_cot = parseFloat(total_cot)+parseFloat(el["SUBTOTAL"].replace(/[^0-9.]/g, ''));
    total_desc = parseFloat(total_desc)+parseFloat(el["TDESCUENTO"]);
    total_iva = parseFloat(total_iva)+parseFloat(el["TIVA"]);

  });

  total_neto = parseFloat(total_cot)-parseFloat(total_desc)+parseFloat(total_iva);

  

  $("#tsubtotal").html( "Subtotal: "+formatNumber(round(total_cot) ));
  $("#tneto").html("Total: "+formatNumber(round(total_neto) ));
  $("#tdescuento").html( "Descuento: "+formatNumber(round(total_desc) ));
  $("#tiva").html( "Iva "+formatNumber(round(total_iva) ));

  ////////******* total impuesto iva
  $("#iva_base").val( formatNumber( round(total_cot) ) );
  $("#iva_importe").val( formatNumber(round(total_iva) ) )

  showLimiteCredito();

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

function retirarParte(idpartex){

  x = confirm("¿Realmente deseas retirar esta partida?");

  if ( x ) {

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Factpedido/retirarParte/",
            data:{

              idpcot:idpartex

            },
            cache: false,
            success: function(result)
            {

              if ( result ) {
                
                $('#my-table').DataTable().ajax.reload();
                $("#bi_pro").focus();  

                setTimeout(function (){
        
                    sumaTotal();              
                              
                }, 1000);

              }else {

                alert("Error, favor de intentarlo nuevamente de persistir el error favor de comunicarse con el administrador");

              }

     
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


          detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

  }

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
        },

        dom: '<"top"B pl>rt',
        buttons: [ 'copy', 'excel' , 'csv'],
        "order": [  [ 1, "asc" ] ],

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
                
              }
        },
        
        columnDefs: [{ 
          targets: [2],
          createdCell: createdCell
        }],

        "paging": false,
        "processing": true,
        /* "serverSide": true, */
        "search" : false,
        "ajax": base_urlx+"Factpedido/loadPartidas?idcot="+idcotx,
        "columns": [
                   
          { data: "ACCION" },
          { data: "ORDEN" },
          { data: "CANTIDAD" },
          { data: "CLAVE" },
          { data: "DESCRIP" },
          { data: "UNIDAD" },
          { data: "COSTO" },
          { data: "IVA" },
          { data: "DESCUENTO" },
          { data: "UTILIDAD" },
          { data: "TCAMBIO" },
          { data: "SUBTOTAL" },


        ],
        "scrollY": 300,
        "scrollX": true
    });

    /////////////********* CLICK 
    $('#my-table tbody').on('focusin', 'tr', function () {

        var data = table.row( this ).data();
        editId = data["ID"];

        editCantidad = data["CANTIDAD"];
        editCosto = data["COSTO"];
        editCproveedor = data["COSTOPROVEEDOR"];
        edittcambio =data["TCAMBIO"];
        editUtil = data["UTILIDAD"];

        Idpcot = data["IDPCOT"];

    } );


    $('#my-table').on( 'focusout', 'tbody td', function () {

      idFila = table.cell( this ).index().row;
      colx = table.cell( this ).index().column;

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

$('td').click(function(){ 

  var col = $(this).parent().children().index($(this)); 
  var row = $(this).parent().parent().children().index($(this).parent()); 

  //alert('Row: ' + row + ', Column: ' + col); 

});

function showNewCliente(idcliente_fact){

  if( idcliente_fact == 21 ) {

    $("#namefactura").css("display", "");

  }else{

    $("#namefactura").css("display", "none");

  }

  $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Actcotizacion/showDatosCliente/",
            data:{ idcliente:idcliente_fact },
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  $("#nreceptor").html("R<strong>azon social: </strong>"+result.nombre);
                  $("#nrfc").html("<strong>RFC: </strong>"+result.rfc);
                  $("#ncp").html("<strong>C.P. Receptor: </strong>"+result.cp);
                  $("#nregimen").html("<strong>Regimen fiscal: </strong>"+result.regimen_fiscal);

              }else{

                 $("#cliente").html("<option value='0'>Sin categorias</option>");

              }
 
            }

  }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

  });

}


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

                    $("#mpago").val(1);
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

    showLimiteCredito();

  }else{

    $("#fpago").val(idfpagox);
    $("#fpago").prop("disabled",false);

    $("#btnfactura").prop("disabled",false);
    $("#alertax").html('');

  }

}


////************ LINEA DE CREDITO

function habilitarFact(){

  x=confirm("¿Realmente deseas habilitar la facturacion con limite de credito excedido?");

  if(x){

    $.ajax({

                type: "POST",
                dataType: "json",
                url: base_urlx+"Factpedido/habilitarFact/",
                data:{

                  adminpass:$("#passadmin").val()

                },

                cache: false,
                success: function(result)

                {

                  if(result!=null){

                    $("#btnfactura").prop("disabled",false);
                    $("#passadmin").val("");
                    alert("Alerta, la facturacion ha sido habilitada");

                  }else{

                    alert("Alerta, la contraseña no es correcta favor de intentarlo nuevamente");
                    $("#passadmin").val("");
                    $("#passadmin").focus();

                  }

                }



    }).fail( function( jqXHR, textStatus, errorThrown ) {



    detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });

    //

  }

}

function showLimiteCredito(){

  if( $("#mpago").val()==1 ){

    //// si la factura es PUE no se toma en cuenta la linea de credito

    $("#alertax").html('');
    $("#btnfactura").prop("disabled",false);

  }else{

          $.ajax({

                type: "POST",

                dataType: "json",

                url: base_urlx+"Cxcxc/sumaTotal/",

                data:{

                  idcliente:$("#idcliente").val(),

                  estatusx:0


                },

                cache: false,

                success: function(result)

                {


                  limitex=0;
                  disponiblex=0
                  
                  xcobrar=parseFloat(result.total)-parseFloat(result.pagado)-parseFloat(result.ncredito);


                  limitex=result.limite;

                  limite_autorizado=result.limite;

                  disponiblex=parseFloat(limitex)-parseFloat(xcobrar);

                  saldo_disponible=disponiblex;

                  //alert(disponiblex);

                  if ( result.ncredito > 0 ) {


                    if(limitex>0){

                      $("#pagosx").html('<p style="color:darkblue; font-weight:bold; font-size:18px;" >Linea de credito: '+formatNumber(round(limitex))+'</p>  <p style="color: #D88E03; font-weight: bold; font-size: 17px; " > Saldo total deudor: '+formatNumber(round(xcobrar))+'</p> <p style="color: darkgreen; font-weight: bold; font-size: 20px;"> Saldo disponible: '+formatNumber(round(disponiblex))+'</p>');                     

                    }else{

                      $("#pagosx").html('<p style="color:#D88E03; font-weight: bold; font-size: 17px; " >Saldo total deudor: '+formatNumber(round(xcobrar))+'</p>');

                    }

                    



                  }else{


                    if(limitex>0){

                      $("#pagosx").html('<p style="color:darkblue; font-weight:bold; font-size:18px;" >Linea de credito: '+formatNumber(round(limitex))+'</p>   <p style="color: #D88E03; font-weight: bold; font-size: 17px; " >Saldo total deudor: '+formatNumber(round(xcobrar))+'</p> <p style="color: darkgreen; font-weight: bold; font-size: 20px;">Saldo disponible: '+formatNumber(round(disponiblex))+'</p>');  

                      //$("#pagosx").html('<p style="color: darkgreen; font-weight: bold; font-size: 17px;" >');  

                    }else{

                      $("#pagosx").html('<p style="color: #D88E03; font-weight: bold; font-size: 17px; " >Saldo total deudor: '+formatNumber(round(xcobrar))+'</p>');                    

                    }



                  }


                  ////////************** AUTORIZACION DE VENTA

                  if(limite_autorizado>0){

                    $("#datos_factura").html('<p style="color: purple; font-size: 17px; font-weight: bold;">Importe factura: '+formatNumber(round(total_neto) )+'</p>');

                    disponible_real=parseFloat(saldo_disponible)+(.20*limite_autorizado);

                    if(disponible_real>total_neto){

                      /////AUTORIZADO

                      $("#alertax").html('');
                      $("#btnfactura").prop("disabled",false);

                    }else{

                      ////////// NO AUTORIZADO

                      $("#alertax").html('<div class="col-md-12 col-lg-12"><h4 style="color:red; font-size:17px; font-weight:bold;">Factura no autorizada, limite de credito excedido</h4><div class="col-md-6 col-lg-6 col-xs-12"><label>*Ingresar contraseña admin</label><div class="input-group"> <input type="password" class="form-control" id="passadmin" name="passadmin"><span class="input-group-btn"><button class="btn btn-primary" type="button" onclick="habilitarFact()">Habilitar facturacion</button></span></div></div></div>');
                      $("#btnfactura").prop("disabled",true);

                    }

                  }else{

                    $("#alertax").html('');
                    $("#btnfactura").prop("disabled",false);

                  }


                }



          }).fail( function( jqXHR, textStatus, errorThrown ) {



              detectarErrorJquery(jqXHR, textStatus, errorThrown);



          });

  }

}


///////////////////*************************** FINALIZAR A FACTURACION

function showPDFfactura(idfactxx){

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/pdf_facturav3.php",
          data:{ 

              idfactura:idfactxx

            },
          cache: false,
          success: function(result)
          {

            enviarCorreo(idfactxx,result);
            /*window.open(base_urlx+"tw/php/facturas/"+result+".pdf", "_blank");
            alert("La factura fue generada exitosamente");
            window.location.href=base_urlx+"Rcotizacion";*/
          }

      }); 


}

function enviarCorreo(idfactx,foliox){

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"Factpedido/enviarCorreo",
          data:{ 

              idcot:idfactx,
              folio:foliox,
              idcliente:idclientex

            },
          cache: false,
          success: function(result)
          {

            window.open(base_urlx+"tw/php/facturas/"+foliox+".pdf", "_blank");

            if (result ) {
              
              alert("La factura fue generada exitosamente y ha sido enviada");              

            }else{

              alert("La factura fue generada exitosamente, pero NO ha podido ser enviada");

            }

            window.location.href=base_urlx+"Rcotizacion";
            
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
          url: base_urlx+"tw/php/crear_xml_facturalo_prueba.php",//prueba
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

/*function showPDFcotfact(idcotxz,idfact){

      ////////*********** ACTUALIZACION DEL PDF 

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/pdf_cotizacion_factura.php",
          data:{ 

              idcot:idcotxz

            },
          cache: false,
          success: function(result)
          {

            facturarXml(idcotxz,idfact);

            //alert("La cotizacion ha sido actualizada");

            //window.open(base_urlx+"tw/php/cotizaciones/cot"+idcotxz+".pdf", "_blank");
            //window.location.href=base_urlx+"Rcotizacion";
          }

      }); 


}*/

function factCotizacion(){

  x = confirm("¿Realmente deseas facturar este pedido?");

  if(x){

    subx = 0;

    $('#my-table').DataTable().rows().data().each(function(el, index){
      //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria
      subx = parseFloat(subx)+parseFloat(el["ID"]);

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
                url: base_urlx+"Factpedido/factCotizacion/",
                data:{

                  idcliente:idclientex,
                  iduser:iduserx,
                  idcot:idcotx,
                  obsx:$("#obs").val(),
                  //monedax:$("#moneda").val(),
                  //tcx:$("#tc").val(),
                  dias:$("#credito").val(),
                  fpagox:$("#fpago").val(),
                  mpagox:$("#mpago").val(),
                  cfdix:$("#cfdi").val(),
                  odc:$("#name_factpdf").val(),
                  totalx:round(total_neto),
                  ivax:round(total_iva),
                  descuentox:round(total_desc),
                  subtotalx:round(total_cot),
                  obs_factura:$("#obs").val(),
                  no_odc:$("#odc").val()


                },
                cache: false,
                success: function(result)
                {

                  if ( result > 0 ) {

                    facturarXml(idcotx,result);

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


function simularFactura(){

   x = confirm("¿Realmente deseas facturar este pedido?");

  if(x){

    subx = 0;

    $('#my-table').DataTable().rows().data().each(function(el, index){
      //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria
      subx = parseFloat(subx)+parseFloat(el["ID"]);

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
                url: base_urlx+"Factpedido/simularFactura/",
                data:{

                  idcliente:idclientex,
                  iduser:iduserx,
                  idcot:idcotx,
                  obsx:$("#obs").val(),
                  //monedax:$("#moneda").val(),
                  //tcx:$("#tc").val(),
                  dias:$("#credito").val(),
                  fpagox:$("#fpago").val(),
                  mpagox:$("#mpago").val(),
                  cfdix:$("#cfdi").val(),
                  odc:$("#name_factpdf").val(),
                  totalx:round(total_neto),
                  ivax:round(total_iva),
                  descuentox:round(total_desc),
                  subtotalx:round(total_cot),
                  obs_factura:$("#obs").val(),
                  no_odc:$("#odc").val()


                },
                cache: false,
                success: function(result)
                {

                  if ( result > 0 ) {

                    alert("La factura se genero exitosamente");

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
                data:{idcot:idcotx,iduser:iduserx},
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


