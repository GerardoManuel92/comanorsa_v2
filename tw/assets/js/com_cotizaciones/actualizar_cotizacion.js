//alert("VERSION 2.0");

//salert("ACTUALIZACION / productos con tipo de cambio v3");

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
var editOrden=0;

var editCproveedor = 0;
var edittcambio = 0;
var editUtil = 0;

var total_neto = 0;
var limit_excedido = 0;

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
            url: base_urlx+"Actcotizacion/updateCelda/",
            data:{

              texto:e.target.textContent,
              columna:colx,
              idpcot:editId,
              idcpro:editCproveedor,//costo proveedor
              ordenx:editOrden,
              idcotizacion:idcotx

            },
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                if (colx == 1) {

                  $('#my-table').DataTable().ajax.reload();

                }else{

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

                }

              }else{

                alert("Alerta, favor de intentar actualizarlo nuevamente");

              }

            }

          });

      }
      
    }

  })
}

$(document).ready(function() {

	////////******** MOSTRAR CLIENTES

	showCliente();
	
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
        columnDefs: [{ 
          targets: [1,2,4,6,7,8,9,10],
          createdCell: createdCell
        }],

        "paging": false,
        "processing": true,
        "serverSide": true,
        "search" : false,
        "ajax": base_urlx+"Actcotizacion/loadPartidas?idcot="+idcotx,

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
        editOrden= data[1];

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

$('td').click(function(){ 

  var col = $(this).parent().children().index($(this)); 
  var row = $(this).parent().parent().children().index($(this).parent()); 
  //alert('Row: ' + row + ', Column: ' + col); 

});


////** MOSTRAR / OCULTAR


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
                  $("#cliente").val(idclientex).trigger('change');

                  if ( idclientex == 21 ) {

                    $("#namefactura").css("display", "");

                  }else{

                    $("#namefactura").css("display", "none");

                  }

              }else{

                 $("#cliente").html("<option value='0'>Sin categorias</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

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

                 //$("#cliente").html("<option value='0'>Sin categorias</option>");

              }
 
            }

  }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

  });

}

showCfdi();
showMpago();



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

//////////
function tmoneda(monedax){

  if ( monedax == 2 ) {

    $("#tc").prop("disabled",false);
    $("#tc").focus();


  }else{

    $("#tc").prop("disabled",true);
    $("#tc").val("1");

  }

}

function showObs(){

  $("#agobs").css("display", "");
  $("#cerrarobs").css("display", "");
  $("#abrirobs").css("display", "none");
  $("#obs").focus();

}

function cerrarObs(){

  $("#agobs").css("display", "none");
  $("#abrirobs").css("display", "");
  $("#cerrarobs").css("display", "none");
  $("#bi_pro").focus();

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

///////////////********** ACTIVAR TASA

function showTasa(idtasa){

  if (idtasa == 3) {

  	$("#divtasa").css("display", "");
    $("#tasa").prop("disabled", false);
    $("#tasa").focus();

  }else{

  	$("#divtasa").css("display", "none");
    $("#tasa").prop("disabled", true);

  }

}

///////

function recargar(){

  $("#cliente").trigger("change");
  alert("actualizando");

}

//////////////******************* BUSCADOR DE PRODUCTOS 

    var options = {

      //url: "<?php echo base_url();?>js/countries.json",
      //url: "assets/files/buscar_clvproveedor_factura.php?clv=",
      url: function(phrase) {

        return  base_urlx+"AltaCotizacion/buscarxdescrip?clv="+$('#bi_pro').val();
      
    },
      
      getValue: "descripcionx",
      
      theme:"light",

      list: {
        maxNumberOfElements: 20,
        match: {
          enabled: false
        },
       
        onClickEvent: function() {
          idPro = $("#bi_pro").getSelectedItemData().id;
          $("#unidad").html( $("#bi_pro").getSelectedItemData().unidad );

          //alert( formatNumber( round($("#bi_pro").getSelectedItemData().costo) ) );


          $("#costo").val( formatNumber( round($("#bi_pro").getSelectedItemData().costo) ) );
          $("#utilidad").val( $("#bi_pro").getSelectedItemData().utilidad );
          $("#precio").val( formatNumber( round($("#bi_pro").getSelectedItemData().precio) ) );
          $("#descripcion").val( $("#bi_pro").getSelectedItemData().descrip );
          valorcosto = $("#bi_pro").getSelectedItemData().costo;
          valorprecio = $("#bi_pro").getSelectedItemData().precio;
          	ivax = $("#bi_pro").getSelectedItemData().iva;

          	if ( ivax == 3 ) {

          		$("#idtasa").html( $("#bi_pro").getSelectedItemData().tasa+"% - iva");
          		$("#tasa").val( $("#bi_pro").getSelectedItemData().tasa );

          	}else if ( ivax == 2 ) {

          		$("#tasa").val("0");

          	}else{

          		$("#tasa").val("16");

          	}

          idCiva = $("#bi_pro").getSelectedItemData().cimpuesto;

          $("#cantidad").focus();

          /////************* IMPUESTOS DE RETENCION
          porciento_rivax = $("#bi_pro").getSelectedItemData().porciento_riva;
          porciento_risrx = $("#bi_pro").getSelectedItemData().porciento_risr;


          if( porciento_risrx > 0 || porciento_rivax > 0 ) {

              $("#retenciones").css("display","");

              $("#valor_riva").val(porciento_rivax);
              $("#valor_risr").val(porciento_risrx);

              $("#tit_iva").html("Retencion IVA "+porciento_rivax+"%");
              $("#tit_isr").html("Retencion ISR "+porciento_risrx+"%");

          }else{

              $("#retenciones").css("display","none");

              $("#valor_riva").val("0");
              $("#valor_risr").val("0");

              $("#tit_iva").html("Retencion IVA 0%");
              $("#tit_isr").html("Retencion ISR 0%");

          }


        },
        onKeyEnterEvent: function(){
          idPro = $("#bi_pro").getSelectedItemData().id;
          $("#unidad").html( $("#bi_pro").getSelectedItemData().unidad );
          $("#costo").val( formatNumber( round($("#bi_pro").getSelectedItemData().costo) ) );
          $("#utilidad").val( $("#bi_pro").getSelectedItemData().utilidad );
          $("#precio").val( formatNumber( round($("#bi_pro").getSelectedItemData().precio) ) );
          $("#descripcion").val($("#bi_pro").getSelectedItemData().descrip);
          valorcosto = $("#bi_pro").getSelectedItemData().costo;
          valorprecio = $("#bi_pro").getSelectedItemData().precio;

          	ivax = $("#bi_pro").getSelectedItemData().iva;

          	if ( ivax == 3 ) {

          		$("#idtasa").html( $("#bi_pro").getSelectedItemData().tasa+"% - iva");
          		$("#tasa").val( $("#bi_pro").getSelectedItemData().tasa );

          	}else if ( ivax == 2 ) {

          		$("#tasa").val("0");

          	}else{

          		$("#tasa").val("16");

          	}

          idCiva = $("#bi_pro").getSelectedItemData().cimpuesto;

          $("#cantidad").focus();

          /////************* IMPUESTOS DE RETENCION
          porciento_rivax = $("#bi_pro").getSelectedItemData().porciento_riva;
          porciento_risrx = $("#bi_pro").getSelectedItemData().porciento_risr;


          if( porciento_risrx > 0 || porciento_rivax > 0 ) {

              $("#retenciones").css("display","");

              $("#valor_riva").val(porciento_rivax);
              $("#valor_risr").val(porciento_risrx);

              $("#tit_iva").html("Retencion IVA "+porciento_rivax+"%");
              $("#tit_isr").html("Retencion ISR "+porciento_risrx+"%");

          }else{

              $("#retenciones").css("display","none");

              $("#valor_riva").val("0");
              $("#valor_risr").val("0");

              $("#tit_iva").html("Retencion IVA 0%");
              $("#tit_isr").html("Retencion ISR 0%");

          }
           
        }
      }
    };

    $("#bi_pro").easyAutocomplete(options);


//////////************************** CALCULAR SUBTOTAL

function calcularSubtotal(){


  //alert($("#costo").val().replace(/[^\d.]/g,""));

  cantidadx = round($("#cantidad").val());
  costox = round( $("#costo").val().replace(/[^\d.]/g,"") );
  descx = $("#descuento").val();
  utilx = $("#utilidad").val();
  tcambiox = round($("#tc").val());
  subtotalx = 0;
  

  if ( cantidadx > 0 && costox > 0 ) {

    if ( utilx > 0 ) {

      if ( tcambiox > 0 ) {

        costox = tcambiox*costox;

      }

      precio_new = parseFloat(costox)+parseFloat( costox*(utilx/100) );

      $("#precio").val( formatNumber( round(precio_new) ) );

      subtotalx = cantidadx * precio_new;

      $("#total").val( formatNumber( round(subtotalx) ) );

    }else{

      precio_new = 0;

      $("#precio").val( formatNumber( round(precio_new) ) );

      subtotalx = cantidadx * precio_new;

      $("#total").val( formatNumber( round(subtotalx) ) );

    }

    //////************* CALCULAR IMPUESTOS DE RETENCIONES

    if ( subtotalx > 0 ){

      if ( $("#valor_riva").val() > 0 ) {

        importe_riva = subtotalx*( $("#valor_riva").val()/100 );
        $("#riva").val( formatNumber( round(importe_riva) ) );

      }

      if ( $("#valor_risr").val() > 0 ) {

        importe_risr = subtotalx*( $("#valor_risr").val()/100 );
        $("#risr").val( formatNumber( round(importe_risr) ) );

      }

    }

  }else{

    //alert("Alerta, favor de colocar una cantidad o costo con su utilidad valida para el producto");

  }

}

function calcularSubtotalPrecio(){

  preciox = round($("#precio").val().replace(/[^\d.]/g,"") );
  costox = round( $("#costo").val().replace(/[^\d.]/g,"") );
  tcambiox = round($("#tc").val());
  cantidadx = round($("#cantidad").val());

  if ( preciox > 0  ) {

    if ( tcambiox > 0 ) {

      preciox_stc= preciox/tcambiox;

    }else{

      preciox_stc= preciox;

    }

    utilx = ( ( parseFloat(preciox_stc)-parseFloat(costox) ) / costox )*100;

    $("#utilidad").val( utilx );

    subtotalx = cantidadx * preciox;

    $("#total").val( formatNumber( round(subtotalx) ) );

  }

}

//////////*************** INGRESAR PARTIDAS

function ingresarPartidas(){

	verificar = 0;

	calcularSubtotal();

  preciox = $("#precio").val().replace(/[^\d.]/g,"");
  costo_proveedorx = $("#costo").val().replace(/[^\d.]/g,"");

	if( idPro == 0 ){

		alert("Alerta, favor de seleccionar un producto valido");
		verificar = 1;
		$("#bi_pro").focus();

	}

	if( $("#cantidad").val() <= 0 && verificar == 0 ){

		alert("Alerta, favor de seleccionar una cantidad valida del producto");
		verificar = 1;
		$("#cantidad").focus();

	}
	if( preciox <= 0 && verificar == 0 ){

		alert("Alerta, favor de seleccionar un precio valido del producto");
		verificar = 1;
		$("#precio").focus();

	}
	if( $("#descuento").val() < 0 && verificar == 0 ){

		$("#descuento").val("0");

	}
	if( $("#total").val() <= 0 && verificar == 0 ){

		alert("Alerta, favor de colocar un valor valido para el subtotal del producto");
		verificar = 1;
		$("#total").focus();

	}

  if( $("#descripcion").val() == "" && verificar == 0 ){

    alert("Alerta, favor de colocar una descripcion valida");
    verificar = 1;
    $("#descripcion").focus();

  }

  if ( $("#tc").val() == "" || $("#tc").val() == null ) {

    tcval = 1;

  }else{

    tcval = $("#tc").val();

  }

	if ( verificar == 0 ) {

		$("#btn_ingresar").prop("disabled",true);
    $("#btn_ingresar").html('<i class="fa fa-spinner fa-spin"></i>');

		$.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Actcotizacion/ingresarPartidas/",
            data:{

            	idparte:idPro,
            	idcot:idcotx,
            	cantidad:$("#cantidad").val(),
            	costo:preciox,
              cproveedor:costo_proveedorx,
            	iva:$("#tasa").val(),
            	descuento:$("#descuento").val(),
              descripx:$("#descripcion").val(),
              rivax:$("#valor_riva").val(),
              risrx:$("#valor_risr").val(),
              tcambiox:tcval,
              utilidadx:$("#utilidad").val()

            },
            cache: false,
            success: function(result)
            {

            	if ( result > 0 ) {
   
                $('#my-table').DataTable().ajax.reload();
	            	$("#bi_pro").val("");
	            	idPro = 0;
	            	$("#cantidad").val("");
      					$("#costo").val("");
                $("#precio").val("");
                $("#utilidad").val("");
      					$("#unidad").val("");
      					$("#tasa").val("0");
      					$("#descuento").val("0");
      					$("#total").val("0");
      					$("#divtasa").css("display", "none");
	            	$("#bi_pro").focus();
                $("#descripcion").val("");
	            	

                $("#tneto").html("Calculando...");

                setTimeout(function (){
        
                    sumaTotal();              
                              
                }, 1000);

        			}else if ( result == null ){

                alert("Error, favor de intentarlo nuevamente de persistir el error favor de comunicarse con el administrador");

              }else{

                alert("Alerta, la partida ya se encuentra en su cotización");

                $("#bi_pro").val("");
                idPro = 0;
                $("#cantidad").val("");
                $("#costo").val("");
                $("#precio").val("");
                $("#utilidad").val("");
                $("#unidad").val("");
                $("#tasa").val("0");
                $("#descuento").val("0");
                $("#total").val("0");
                $("#divtasa").css("display", "none");
                $("#bi_pro").focus();
                $("#descripcion").val("");

              }

        			$("#btn_ingresar").prop("disabled",false);
    	    		$("#btn_ingresar").html('<i class="fa fa-arrow-right"></i>');
     
            }

	  }).fail( function( jqXHR, textStatus, errorThrown ) {


	        detectarErrorJquery(jqXHR, textStatus, errorThrown);

	  });

	}

}

function retirarParte(idpartex,torden){

  x = confirm("¿Realmente deseas retirar esta partida?");

  if ( x ) {

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Actcotizacion/retirarParte/",
            data:{

              idpcot:idpartex,
              ordenx:torden,
              idcotizacion:idcotx

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

//////////////******* CALCULAR SUBTOTAL GLOBAL

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

  if ( $("#limite").val() > 0 ) {

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

  }

}


///////////************************************************************ CALCULO DE IMPUESTOS

//////////////////////// TRASLADADO

///////////****** IVA

function selectIva(){

  if( $('#iva_tasa').prop('checked') ) {

    $("#iva_valor").val("16");

    calcularIva();

  }else{

    $("#iva_valor").val("0");
    $("#iva_importe").val("0");

  }

  $("#iva_excento").prop("checked", false);

}

function selectivaExc(){

  if( $('#iva_excento').prop('checked') ) {

    $("#iva_valor").val("0");
    $("#iva_importe").val("0");

  }else{

    $("#iva_valor").val("16");

    calcularIva();

  }

  $("#iva_tasa").prop("checked", false);

}

function calcularIva(){

  iva_basex = $("#iva_base").val().replace(/[^\d.]/g,"");
  iva_valorx = $("#iva_valor").val().replace(/[^\d.]/g,"");
  //iva_importex = $("#iva_importe").val().replace(/[^\d.]/g,"");

  if ( iva_basex > 0 && iva_valorx > 0 ) {

    iva_importex = parseFloat(iva_basex)+parseFloat( iva_basex*(iva_valorx/100) );

    iva_montox = parseFloat(iva_importex)-parseFloat( iva_basex );

    $("#iva_importe").val( formatNumber( round(iva_montox) ) );
    //alert(iva_montox);

  }

}

///////////////////  RETENCION

/////******** IVA

function selectivaRet(){

  if( $('#riva_tasa').prop('checked') ) {

    $("#riva_base").val( $("#iva_base").val() );
    $("#riva_valor").val("16");

    calcularRiva();

  }else{

    $("#riva_valor").val("0");
    $("#riva_importe").val("0");

  }

}

function calcularRiva(){

  iva_basex = $("#riva_base").val().replace(/[^\d.]/g,"");
  iva_valorx = $("#riva_valor").val().replace(/[^\d.]/g,"");
  //iva_importex = $("#iva_importe").val().replace(/[^\d.]/g,"");

  if ( iva_basex > 0 && iva_valorx > 0 ) {

    iva_importex = parseFloat(iva_basex)+parseFloat( iva_basex*(iva_valorx/100) );

    iva_montox = parseFloat(iva_importex)-parseFloat( iva_basex );

    $("#riva_importe").val( formatNumber( round(iva_montox) ) );

  }

}

//////////*** ISR

function selectisrRet(){

  if( $('#risr_tasa').prop('checked') ) {

    $("#risr_base").val( $("#iva_base").val() );
    $("#risr_valor").val("35");

    iva_basex = $("#risr_base").val().replace(/[^\d.]/g,"");
    iva_valorx = $("#risr_valor").val().replace(/[^\d.]/g,"");

    if ( iva_basex > 0 && iva_valorx > 0 ) {

      iva_importex = parseFloat(iva_basex)+parseFloat( iva_basex*(iva_valorx/100) );
      iva_montox = parseFloat(iva_importex)-parseFloat( iva_basex );

      $("#risr_importe").val( formatNumber( round(iva_montox) ) );

    }

  }else{

    $("#risr_valor").val("0");
    $("#risr_importe").val("0");

  }

}

/////////////****************************************** PORCENTAJES GENERALES

function porcientoAll(){

  x = confirm("¿Realmente deseas actualizar todos los porcentajes?");  

      $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Actcotizacion/porcientoAll/",
            data:{

              gutilidad:$("#gutilidad").val(),
              gdescuento:$("#gdescuento").val()

            },
            cache: false,
            success: function(result)
            {

              //alert(result);

              if ( result ) {

                $('#my-table').DataTable().ajax.reload();

                setTimeout(function (){
        
                    sumaTotal();              
                              
                }, 1000);
                alert("Los porcentajes han sido actualizados correctamente");

              }else{

                alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");

              }

              //$("#btn_finalizar").prop("disabled",false);
              //$("#btn_finalizar").html('<i class="icon-check" ></i style="color:black;"> Finalizar');

            }

      }).fail( function( jqXHR, textStatus, errorThrown ) {


          detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });
  

}

function porcientoFal(){

  x = confirm("¿Realmente deseas actualizar los porcentajes faltantes o no asignados?");  

      $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Actcotizacion/porcientoFal/",
            data:{

              gutilidad:$("#gutilidad").val(),
              gdescuento:$("#gdescuento").val()

            },
            cache: false,
            success: function(result)
            {

              //alert(result);

              if ( result ) {

                $('#my-table').DataTable().ajax.reload();
                
                setTimeout(function (){
        
                    sumaTotal();              
                              
                }, 1000);
                alert("Los porcentajes han sido actualizados correctamente");

              }else{

                alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");

              }

              //$("#btn_finalizar").prop("disabled",false);
              //$("#btn_finalizar").html('<i class="icon-check" ></i style="color:black;"> Finalizar');

            }

      }).fail( function( jqXHR, textStatus, errorThrown ) {


          detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });

}

//////////////////////************************* ACTUALIZAR A COTIZACION

function showPDF(idcotxz){

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/pdf_cotizacion.php",
          data:{ 

              idcot:idcotxz

            },
          cache: false,
          success: function(result)
          {

            window.open(base_urlx+"tw/php/cotizaciones/cot"+idcotxz+".pdf", "_blank");
            window.location.href=base_urlx+"Rcotizacion";
            //window.location.href=base_urlx+"Rcotizacion";
          }

      }); 


}

function actCotizacion(){

	x = confirm("¿Realmente deseas ACTUALIZAR esta cotizacón?");

	if (x) {

		subx = 0;

	    $('#my-table').DataTable().rows().data().each(function(el, index){
	    //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria
	    subx = parseFloat(subx)+parseFloat(el[15]);

	    });

	    verificar = 0;

	    if ( subx <= 0 ) {

	      alert("Alerta, no se han encontrado partidas en tu cotizacion o esta tiene un costo igual a 0");
	      verificar = 1;

	    }

	    if ( $("#cliente").val() <= 0 && verificar == 0 || $("#cliente").val() == null && verificar == 0  ) {

	      alert("Alerta, favor de seleccionar un cliente valido");
	      verificar = 1;
	      $("#cliente").focus();

	    }

	    if ( verificar == 0 ) {

		    $("#btn_finalizaract").prop("disabled",true);
		    $("#btn_finalizaract").html('Generando...');

		    $.ajax({
		            type: "POST",
		            dataType: "json",
		            url: base_urlx+"Actcotizacion/actCotizacion/",
		            data:{

		              idcliente:$("#cliente").val(),
		              //fecha:$("#fecha").val(),
		              idcot:idcotx,
		              obsx:$("#obs").val(),
		              monedax:$("#moneda").val(),
		              tcx:$("#tc").val()

		            },
		            cache: false,
		            success: function(result)
		            {

		              if ( result > 0 ) {

		                alert("Alerta, la cotización se actualizo correctamente");

		                showPDF(result);

                    //window.location.href=base_urlx+"Rcotizacion";
                    

		              }else{

		                alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");

		              }

		              $("#btn_finalizaract").prop("disabled",false);
		              $("#btn_finalizaract").html('<i class="icon-arrows-ccw" ></i style="color:black;"> Actualizar');

		            }

		    }).fail( function( jqXHR, textStatus, errorThrown ) {


		          detectarErrorJquery(jqXHR, textStatus, errorThrown);

		    });

	    }

	}

}

//////////////////////************************* NUEVA COTIZACION EN BASE A LA ACTUAL

function newCotizacion(){

  x = confirm("¿Realmente deseas crear un nuevo folio en base a esta cotizacón?");

  if (x) {

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

      if ( $("#cliente").val() <= 0 && verificar == 0 || $("#cliente").val() == null && verificar == 0  ) {

        alert("Alerta, favor de seleccionar un cliente valido");
        verificar = 1;
        $("#cliente").focus();

      }

      if ( verificar == 0 ) {

        $("#btn_nfolio").prop("disabled",true);
        $("#btn_nfolio").html('Generando...');

        $.ajax({
                type: "POST",
                dataType: "json",
                url: base_urlx+"Actcotizacion/newCotizacion/",
                data:{

                  idcliente:$("#cliente").val(),
                  iduser:iduserx,
                  idcot:idcotx,
                  obsx:$("#obs").val(),
                  monedax:$("#moneda").val(),
                  tcx:$("#tc").val()

                },
                cache: false,
                success: function(result)
                {

                  if ( result > 0) {

                    alert("Alerta, la cotización se genero correctamente");

                    showPDF(result);/// VA AL MISMO PDF DE CREACION INICIAL

                  }else{

                    alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");

                  }

                  $("#btn_nfolio").prop("disabled",false);
                  $("#btn_nfolio").html('<i class="icon-star" ></i style="color:black;"> Nuevo folio');

                }

        }).fail( function( jqXHR, textStatus, errorThrown ) {


              detectarErrorJquery(jqXHR, textStatus, errorThrown);

        });

      }

  }

}

///////////////////**************************** FINALIZAR A REMISION 

function showPDFRem(idcotxz){

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/pdf_remision.php",
          data:{ 

              idrem:idcotxz

            },
          cache: false,
          success: function(result)
          {

            window.open(base_urlx+"tw/php/remisiones/rem"+idcotxz+".pdf", "_blank");

            alert("Alerta, la REMISION se genero correctamente");
            window.location.href=base_urlx+"Rcotizacion";
          }

      }); 


}

function showPDFcotRem(idcotxz,idremx){

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/pdf_cotizacion.php",
          data:{ 

              idcot:idcotxz

            },
          cache: false,
          success: function(result)
          {

            showPDFRem(idremx);

            //window.open(base_urlx+"tw/php/cotizaciones/cot"+idcotxz+".pdf", "_blank");
            //window.location.href=base_urlx+"Rcotizacion";
          }

      }); 


}

////

function remCotizacion(){

	x = confirm("Se creara la REMISIÓN de la cotizacion que fue habilitada para ODC");

	if (x) {

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

	    if ( $("#cliente").val() <= 0 && verificar == 0 || $("#cliente").val() == null && verificar == 0  ) {

	      alert("Alerta, favor de seleccionar un cliente valido");
	      verificar = 1;
	      $("#cliente").focus();

	    }

      if ( limit_excedido == 1 ) {

        alert("**Nota: El cliente excede el límite de crédito otorgado, por tanto, no se puede realizar esta venta");
        verificar=1

      }

      if ( idodcx == 0 ) {

        y = confirm("Alerta, la ODC no ha sido habilitada, pulse 'ACEPTAR' si desea habilitarla o 'CANCELAR' si desea continuar asi")

        if ( y ) {

          //habilitar odc
          verificar = 2;

        }else{

          ///
          verificar = 0;

        }

      }

	    if ( verificar == 0 ) {

		    $("#btn_finalizarrem").prop("disabled",true);
		    $("#btn_finalizarrem").html('Generando...');

		    $.ajax({
		            type: "POST",
		            dataType: "json",
		            url: base_urlx+"Actcotizacion/remCotizacion/",
		            data:{

		              idcliente:$("#cliente").val(),
		              //fecha:$("#fecha").val(),
		              idcot:idcotx,
		              obsx:$("#obs").val(),
		              monedax:$("#moneda").val(),
		              tcx:$("#tc").val()

		            },
		            cache: false,
		            success: function(result)
		            {

		              if ( result > 0 ) {

		                

		                showPDFcotRem(idcotx,result);

		              }else{

		                alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");

		              }

		              $("#btn_finalizarrem").prop("disabled",false);
		              $("#btn_finalizarrem").html('<i class="icon-doc-text" ></i style="color:black;"> REMISIONAR');

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

                    alert("Alerta, las partidas han sido enviadas para su requisicion Y generacion de ODC, favor de volver a REMISIONAR");
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

            window.open(base_urlx+"tw/php/facturas/"+result+".pdf", "_blank");
            alert("La factura fue generada exitosamente");
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
          //url: base_urlx+"tw/php/crear_xml_facturalo_prueba.php",//prueba
          url: base_urlx+"tw/php/crear_xml_facturalo.php",
          data:{ 

              idcot:idcotxx,
              idfact:idfactx,
              idcli:$("#cliente").val(),
              name_factura:$("#name_factura").val()

            },
          cache: false,
          success: function(result)
          {

            //alert(result);

            //alert("resultado xml: "+result);

            if ( result == 0) {

              //showPDFfactura(idfactx);
              retirarTimbrado(idfactx);

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

  x = confirm("Realmente deseas facturar la cotizacion que fue habilitada para odc");

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

      if ( $("#cliente").val() <= 0 && verificar == 0 || $("#cliente").val() == null && verificar == 0  ) {

        alert("Alerta, favor de seleccionar un cliente valido");
        verificar = 1;
        $("#cliente").focus();

      }

      if ( idodcx == 0 ) {

        y = confirm("Alerta, la ODC no ha sido habilitada, pulse 'ACEPTAR' si desea habilitarla o 'CANCELAR' si desea continuar asi")

        if ( y ) {

          //habilitar odc
          verificar = 2;

        }else{

          ///
          verificar = 0;

        }

      }

      

      if ( verificar == 0 ) {

        $("#btn_finalizarfact").prop("disabled",true);
        $("#btn_finalizarfact").html('Generando...');

        $.ajax({
                type: "POST",
                dataType: "json",
                url: base_urlx+"Actcotizacion/factCotizacion/",
                data:{

                  idcliente:$("#cliente").val(),
                  iduser:iduserx,
                  idcot:idcotx,
                  obsx:$("#obs").val(),
                  monedax:$("#moneda").val(),
                  tcx:$("#tc").val(),
                  dias:$("#credito").val(),
                  fpagox:$("#fpago").val(),
                  mpagox:$("#mpago").val(),
                  cfdix:$("#cfdi").val(),
                  odc:$("#name_factpdf").val()

                },
                cache: false,
                success: function(result)
                {

                  if ( result > 0 ) {

                    ///*** actualizamos el pdf de la cotizacion
                    //showPDFcotfact(idcotx,idcotx);/// se retiro por que no es necesaria la actualizacion de la cotizacion
                    facturarXml(idcotx,result);

                  }else{

                    alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");

                  }

                  $("#btn_finalizarfact").prop("disabled",false);
                  $("#btn_finalizarfact").html('<i class="icon-bell" ></i style="color:black;"> Facturar');

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

//////*****************

function cancelarOC(){

	x = confirm("¿Realmente deseas CANCELAR esta cotizacón");

	if (x) {

    window.open('','_parent',''); 
    window.close();

	}

}

/////////**************************/////////////

function cerrarSesion(){

    var x = confirm("¿Realmente deseas cerrar la sesión?");

    if( x==true ){

      window.location.href = base_urlx+"Login/CerrarSesion/";
      
    }  

}
