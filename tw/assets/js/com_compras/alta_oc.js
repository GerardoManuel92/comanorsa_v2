//alert("version 1.0");

$(document).ready(function(){
  $('#btn_odc').hide();
  $("#selectProveedor").change(function() {
    var valueSelect = $(this).val();
    if (valueSelect > 2) {
      $('#btn_odc').show();
      $("#titulo strong").text("Generar ODC a: " + $("#selectProveedor option:selected").text());
    } else {
      $('#btn_odc').hide();
    }
  });
});

var table= "";
var idxt = "";
var colx = "";
var editId = 0;
var idFila = "";
var idFilaclick = "";
var editCantidad = 0;
var editCosto = 0;
var total_sub = 0;
var total_desc = 0;
var total_iva = 0;
var cantidadx = 0;
var piva = 0;
var pedidox = 0;
var idasignacion=0;

var credito_dias=0;
//var idpcot = 1;

var almacenx = 0;
//loadPartidas();
showProveedor();


function showProveedor() {
  $.ajax({
    type: "POST",
    dataType: "json",
    url: base_urlx + "AltaOc/showProveedor/",
    cache: false,
    success: function (result) {
      if (result != null) {
        var creaOption = "<option value='0' selected>Selecciona a un proveedor...";
        $.each(result, function (i, item) {
          data1 = item.id;//id
          data2 = item.rfc;//nombre
          data3 = item.nombre;//id
          data4 = item.comercial;//nombre
          creaOption = creaOption + '<option data-credito="'+item.dias+'" id="prov'+data1+'" value="' + data1 + '">' + data2 + '-' + data3 + ' <strong style="color:darkblue;">' + data4 + '</strong></option>';
        });

        $("#selectProveedor").html(creaOption);
      } else {
        $("#selectProveedor").html("<option value='0'>Sin proveedores</option>");
      }
    }
  }).fail(function (jqXHR, textStatus, errorThrown) {
    detectarErrorJquery(jqXHR, textStatus, errorThrown);
  });
}


function loadPartidas(){

  /* if($('#selectProveedor').val() == 0 || $('#selectProveedor').val() == 1 || $('#selectProveedor').val()==null || $('#selectProveedor').val() == 2){
    $('#my-table').DataTable().destroy();
  }else{ */

    const post = document.querySelector('#prov'+$("#selectProveedor").val());
    const credito_dias = post.getAttribute("data-credito");

    $("#dias").val(credito_dias);

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
          "search":         "Buscar por descripcion:",
          "paginate": {
            "first":      "Primero",
            "last":       "Ultimo",  
            "next":       "Siguiente",  
            "previous":   "Anterior"  
          }
        },
  
        dom: '<"top" pl>rt',    
        buttons: [ 'copy', 'excel' , 'csv'],  
        "order": [  [ 3, "desc" ] ],  
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
              /* Append the grade to the default row class name */
          if ( true ) // your logic here
          {    
            $(nRow).addClass( 'customFont' );    
            $('td:eq(0)', nRow).addClass( 'alignCenter' );
               
            $('td:eq(2)', nRow).addClass( 'alignCenter' );      
            $('td:eq(3)', nRow).addClass( 'alignRight' );                     
            $('td:eq(4)', nRow).addClass( 'alignCenter' );  
            $('td:eq(5)', nRow).addClass( 'alignCenter' );  
            $('td:eq(6)', nRow).addClass( 'alignRight' );                                          
          }
        },  
        columnDefs: [
          /* {
            targets: [6],
            data: null,
            render: function (data, type, row, meta) {
              var values = data[6].split('/');
              total = calcularSubtotal(values[0], values[1], 0, values[2], 0);      
              //calcularSubtotal(cantx, costox, descx, ivax, totx)        
              return `` + total + ``
            }
          } */
        ],
          "processing": true,
          "serverSide": true,
          "search" : false,
          "ajax": base_urlx+"AltaOc/loadPartidas?proveedor="+$("#selectProveedor").val() ,  
          "drawCallback": function (settings) {            
            sumaTotal();
          },
          "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],  
          "scrollY": 450,
          "scrollX": true
      });

      $('#my-table tbody').on('click', 'tr', function () {
        // Obtener la fila actual

        var data = table.row( this ).data();

        idasignacion=data[8];

        idFila=$(this).index();

        
    });

  //}  
}

function calcularSubtotal(cantx, costox, descx, ivax, totx) {

  let cantidad;

  if (totx <= 0) {
    cantidad = cantx;
  } else {
    cantidad = totx;
  }

  let subx = (cantidad * costox.replace(/[^\d.]/g, ""));
  let subtotalConDescuento = subx - (subx * (descx / 100));
  let subtotalConIVA = subtotalConDescuento + (subtotalConDescuento * (ivax / 100));

  return formatNumber(round(subtotalConIVA));

}

function generarOC(){
  /*
  alert($("#tsubtotal").text().replace(/[^\d.]/g, ""));
  alert($("#tdescuento").text().replace(/[^\d.]/g, ""));
  alert($("#tiva").text().replace(/[^\d.]/g, ""));
  alert(obtenerNumeroDesdeTexto($("#tneto").text()));
  */

  x = confirm("¿Realmente deseas generar la ORDEN DE COMPRA?");

  if ( x ) {

    $("#btngenerar").prop("disabled",true);
    $("#btngenerar").html('Generando...');

    verificar = 0;

      $('#my-table').DataTable().rows().data().each(function(el, index){
        //verificar si un costo esta en 0
        if ( el[6].replace(/[^\d.]/g,"") <= 0 && verificar == 0) {
          verificar = 1;
          alert("Alerta, uno o mas productos no tiene un costo valido favor de revisarlos");
        }

      });

    if ( $("#selectProveedor").val() == 0 && verificar == 0  || $("#selectProveedor").val() == 1 && verificar == 0  ) {

      alert("Alerta, favor de seleccionar un proveedor valido");
      verificar = 1;
      $("#selectProveedor").focus();

    }

    if ( verificar == 0 ) {

      $("#btngenerar").prop("disabled",true);
      $("#btngenerar").html('Generando...');

      /*var allData = table.rows().data().toArray();
      var valuesID = [];

      for (var i = 0; i < allData.length; i++) {
        valuesID.push(allData[i][10]);
      }*/

      /* alert($("#tsubtotal").text().replace(/[^\d.]/g, ""));
      alert($("#tdescuento").text().replace(/[^\d.]/g, ""));
      alert($("#tiva").text().replace(/[^\d.]/g, ""));
      alert(obtenerNumeroDesdeTexto($("#tneto").text())); */
      
      $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"AltaOc/finalizarOc/",
            data:{

              idpro:$("#selectProveedor").val(),
              iduser:iduserx,
              entrega:$("#entrega").val(),
              dias:$("#dias").val(),
              obs:$("#obs").val(),
              subtotal:$("#tsubtotal").text().replace(/[^\d.]/g, ""),
              descuento:$("#tdescuento").text().replace(/[^\d.]/g, ""),
              iva:$("#tiva").text().replace(/[^\d.]/g, ""),
              total: obtenerNumeroDesdeTexto($("#tneto").text())
              //moneda:$("#moneda").val()

            },
            cache: false,
            success: function(result)

            {

              if ( result > 0 ) {

                alert("Alerta, la ORDEN DE COMPRA se almaceno correctamente");
                //location.reload();
                showPDF(result);

              }else{

                alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");

              }

              $("#btngenerar").prop("disabled",false);
              $("#btngenerar").html('Generar ODC');

            }

      }).fail( function( jqXHR, textStatus, errorThrown ) {

          detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });

    }else{

      $("#btngenerar").prop("disabled",false);
      $("#btngenerar").html('Generar ODC');

    }

  }

}

function showPDF(idcotx) {
  $.ajax({
    type: "POST",
    dataType: "json",
    url: base_urlx + "tw/php/pdf_odc_comanorsa.php",
    data: {
      idoc: idcotx
    },
    cache: false,
    success: function (result) {
      //enviarCorreo(idcotx);
      //alert("Alerta, la orden de compra se almaceno correctamente");
      window.open(base_urlx+"tw/php/ordencompra/odc"+idcotx+".pdf", "_blank");
      location.reload();
    }
  });
}

function sumaTotal(){
  
  total_sub =0;
  total_desc =0;
  total_iva =0;

  $("#tsubtotal").html("Calculando...");
  $("#tneto").html("Calculando...");

  $('#my-table').DataTable().rows().data().each(function(el, index){

    sdesc = el[4];
    subtotal_oc=el[6].replace(/[^\d.]/g,"");
    siva = el[5];

    //replace(/[^\d.]/g,"")
    desc = round(subtotal_oc)*(sdesc/100);
    
    sub_descuento = parseFloat(subtotal_oc)-parseFloat(desc);
    iva = round(sub_descuento)*round(siva/100);


    total_sub = parseFloat(total_sub)+parseFloat(subtotal_oc);
    total_desc = parseFloat(total_desc)+parseFloat(desc);
    total_iva = parseFloat(total_iva)+parseFloat(iva);


  });

  total_neto = parseFloat(total_sub)-parseFloat(total_desc)+parseFloat(total_iva);
  $("#tsubtotal").html( "Subtotal: "+formatNumber(round(total_sub) ));
  $("#tneto").html('<strong style="font-weight: bold; margin-bottom: 10px;"><a href="javascript:verDetalles()" style="font-size: 11px;">(ver detalles)</a><a href="javascript:cerrarDetalles()" id="cerrar" style="display: none;"><i class="fa fa-close" style="color:red; font-weight: bold;"></i></a></strong>'+" Total: "+formatNumber(round(total_neto) ));
  $("#tneto2").html(" Total: "+formatNumber(round(total_neto)) );
  $("#tdescuento").html( "Descuento: "+formatNumber(round(total_desc) ));
  $("#tiva").html( "Iva "+formatNumber(round(total_iva) ));

}

function retirarParte(idparte_asignar){

  if(idparte_asignar>0){

    xr=confirm("¿Realmente deseas retirar esta partida?");

    if(xr){

      $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"AltaOc/retirarParte/",
            data:{

              idparte_asignarx:idparte_asignar,
              idparte_asignacion_prov:idasignacion
             
            },
            cache: false,
            success: function(result)

            {

              if (result) {

                //table.row(idFila).remove();

                table.row(':eq('+idFila+')').remove().draw();

                sumaTotal();

                //fila.remove();

                alert("La partida se ha retirado");

              }

            }

      }).fail( function( jqXHR, textStatus, errorThrown ) {

          detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });

    }

  }

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


function formatNumber(num) {

  num += '';
  var splitStr = num.split(',');
  var splitLeft = splitStr[0];
  var splitRight = splitStr.length > 1 ? ',' + splitStr[1] : '';
  var regx = /(\d+)(\d{3})/;

  while (regx.test(splitLeft)) {
    splitLeft = splitLeft.replace(regx, '$1' + ',' + '$2');

  }

  return "$ " + splitLeft + splitRight;

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


function cerrarSesion(){
  var x = confirm("¿Realmente deseas cerrar la sesión?");
  if( x==true ){
    window.location.href = base_urlx+"Login/CerrarSesion/";
  }  
}

function obtenerNumeroDesdeTexto(texto) {
  var match = texto.match(/\$\s*([\d,]+(\.\d+)?)/);
  return match ? parseFloat(match[1].replace(/,/g, '')) : null;
}

