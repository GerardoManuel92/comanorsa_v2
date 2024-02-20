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
        return signo *  ath.round(num);
    // round(x * 10 ^ decimales)
    num = num.toString().split('e');
    num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
    // x * 10 ^ (-decimales)
    num = num.toString().split('e');
    return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
}

var table;
var colx = "";
var idFila = "";
var editId = 0;
var idparte = 0;
////////// EDITOR DE CELDAS


function loadStock(idProducto,focusx){

  //Carga de almacen/maximos y minimos

  $("#tneto").html("Cargando Almacen...");

  if(idProducto > 0){
    $.ajax({
      type: "POST",
      dataType: "json",
      url: base_urlx+"NuevoRequerimiento/loadStock/",
      data:{
        idparte:idProducto,        
      },
      cache: false,
      success: function(result)
      {
        if ( result!=null ) {

          almacenx=parseFloat(result.totentrada - result.totentrega);

          $("#tsubtotal").html( "Asignados: "+parseFloat((result.totasignado)));
          $("#tneto").html("Almacen: "+almacenx);


          if(focusx==0){

            $("#maximo").val(result.maximo);
            $("#minimo").val(result.minimo);

            $("#cantidad").val("");

            if(result.maximo>0){

              solicitar=0;

              if(almacenx<=result.minimo){

                  ///solamente en esta condicion se activa el maximo y minimos

                  if(almacenx<0){

                    parazero=Math.abs(almacenx);

                    solicitar=result.maximo+parazero;

                  }else{

                    ///////calcular si no es 0 diferencia maximo minimo

                    solicitar=result.maximo-almacenx;

                  }

              }


              $("#cantidad").val(solicitar);


               

            }


            $("#cantidad").focus();

          }


          //$("#tiva").html( "Asignados: "+parseInt((result.totasignado) ));          

        }else{

          $("#tsubtotal").html("");
          $("#tneto").html("Sin Almacen");

          if(focusx==0){

            $("#maximo").val(0);
            $("#minimo").val(0);

            $("#cantidad").val("");

            $("#cantidad").focus();

          }
        }
        

      }

    }).fail( function( jqXHR, textStatus, errorThrown ) {
        detectarErrorJquery(jqXHR, textStatus, errorThrown);
    });
  }else{
    $("#tneto").html("Cargando Almacen...");
  }

}

function verDetalles(){
  $("#tdescuento").css("display","");
  //$("#tiva").css("display","");
  $("#cerrar").css("display","");
}

function cerrarDetalles(){
  $("#tdescuento").css("display","none");
  //$("#tiva").css("display","none");
  $("#cerrar").css("display","none");
}

$(document).ready(function() {

  $('#fecha').datepicker({
    startView: 2,
    keyboardNavigation: false,
    forceParse: false,
    format: "dd/mm/yyyy"
  });
    $(".select2").select2();
    $(".select2-placeholer").select2({
      allowClear: true
    });
    
  $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
    $(this).closest(".select2-container").siblings('select:enabled').select2('open');
  });
  
  $('select.select2').on('select2:closing', function (e) {
    $(e.target).data("select2").$selection.one('focus focusin', function (e) {
      e.stopPropagation();
    });
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
        dom: '<"top" >rt',
        buttons: [ 'copy', 'excel' , 'csv'],
        "order": [  [ 2, "asc" ] ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            /* Append the grade to the default row class name */
            if ( true ) // your logic here
              {
                $(nRow).addClass( 'customFont' );
                $('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
                $('td:eq(1)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );
                $('td:eq(2)', nRow).addClass( 'alignCenter' ).addClass( 'fontText3' );
                $('td:eq(3)', nRow).addClass( 'alignCenter' ).addClass( 'fontText3' );
                $('td:eq(4)', nRow).addClass( 'fontText2' ).addClass( 'fontText4' );           
              }
        },
        columnDefs: [
          {
            targets: [4],
            createdCell: createdCell
          },
        ],
        "paging": false,
        "processing": true,
        //"serverSide": true,
        "search" : false,
        "ajax": base_urlx+"NuevoRequerimiento/loadPartidas?iduser="+iduserx,
        "columns": [
          { data: "ACCION" },
          { data: "CLAVE" },
          { data: "DESCRIPCION" },
          { data: "UM" },
          { data: "CANTIDAD" },
        ],
      //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "scrollY": 300,
        "scrollX": true
    });

    /////////////********* CLICK 

    $('#my-table tbody').on('focusin', 'tr', function () {

        var data = table.row( this ).data();
        editId = data["ID"];
        editCantidad = data["CANTIDAD"];
        
    } );

    $('#my-table tbody').on( 'click', 'td', function () {

      var data = table.row($(this).closest('tr')).data();
      var idparte = data["IDPARTE"]; 
      loadStock(idparte,1);

    } ); 

    $('#my-table').on( 'focusout', 'tbody td', function () {

      idFila = table.cell( this ).index().row;
      colx = table.cell( this ).index().column;      

    } );

    table
    .buttons()
    .container()
    .appendTo( '#controlPanel' );

    $("#bi_pro").focus(1);

});

/////*********** ADJUNTAR COMPROBANTE DE INGRESO

$(function () {
    'use strict';
    //alert("subiendo");
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_ajuste_entrada/';

    $('#fileupload_pdf').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
              $("#name_archivo").val(file.name);            
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

///////************ BUSCAR PARTIDAS BUSCADOR INTELIGENTE

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
          loadStock(idPro,0);
          //$("#unidad").html( $("#bi_pro").getSelectedItemData().unidad );
          //alert( formatNumber( round($("#bi_pro").getSelectedItemData().costo) ) );
          /////////************** REVISION DE COSTOS
          $("#descripcion").val( $("#bi_pro").getSelectedItemData().descrip );
          valorcosto = $("#bi_pro").getSelectedItemData().costo;
          $("#cantidad").focus();
        },
        onKeyEnterEvent: function(){
          idPro = $("#bi_pro").getSelectedItemData().id;
          loadStock(idPro,0);
          $("#unidad").html( $("#bi_pro").getSelectedItemData().unidad );
          /////////************** REVISION DE COSTOS
          $("#descripcion").val( $("#bi_pro").getSelectedItemData().descrip );
          valorcosto = $("#bi_pro").getSelectedItemData().costo;
          $("#cantidad").focus();
        }
      }
    };
$("#bi_pro").easyAutocomplete(options);
///////////************* CALCULOS PARA OBTENER SUBTOTAL
function esconderTxt(e){
  if (e==1) {
    $("#txt_cantidad").css("display", "none");
  }
  if (e==2) {
    $("#txt_costo").css("display", "none");
  }
}


function ingresarPartidas(){

  verificar = 0;

  if( $("#cantidad").val() <= 0 && verificar == 0 ){

    alert("Alerta, favor de seleccionar una cantidad valida del producto");
    verificar = 1;
    $("#cantidad").focus();

  }

  if ( verificar == 0 ) {

    $("#btn_ingresar").prop("disabled",true);
    $("#btn_ingresar").html('<i class="fa fa-spinner fa-spin"></i>');
    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"NuevoRequerimiento/ingresarPartidas/",
            data:{
              idparte:idPro,
              iduser:iduserx,
              cantidad:$("#cantidad").val(),
            },
            cache: false,
            success: function(result)
            {
              if ( result > 0 ) {

                $('#my-table').DataTable().ajax.reload();
                table.buttons().container().appendTo( '#controlPanel' );
                //alert("LA partida se almaceno correctamente");
                $("#bi_pro").val("");
                idPro = 0;
                $("#cantidad").val("");
                $("#bi_pro").focus();            
                $("#descripcion").val("");

                //$("#motivo").val("");

                setTimeout(function (){
                    //sumaTotal();                                            
                }, 1000);

              }else if( result == null ){
                alert("Error, favor de intentarlo nuevamente de persistir el error favor de comunicarse con el administrador");
              }else{
                alert("Alerta, la partida ya se encuentra en su cotización");
                $("#bi_pro").val("");
                idPro = 0;
                $("#cantidad").val("");
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
            url: base_urlx+"NuevoRequerimiento/retirarParte/",
            data:{
              idpcot:idpartex,
              idusuario:iduserx
            },
            cache: false,
            success: function(result)
            {
              if ( result ) {
                $('#my-table').DataTable().ajax.reload();
                $("#bi_pro").focus();
                
              }else {
                alert("Error, favor de intentarlo nuevamente de persistir el error favor de comunicarse con el administrador");
              }
            }
    }).fail( function( jqXHR, textStatus, errorThrown ) {
          detectarErrorJquery(jqXHR, textStatus, errorThrown);
    });
  }



}

function finalizarEntrada(){

  x = confirm("¿Realmente deseas finalizar el requierimiento?");

  if ( x ) {

    cantidad = 0;
      $('#my-table').DataTable().rows().data().each(function(el, index){
        //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria
        cantidad = parseFloat(cantidad)+parseFloat(el["CANTIDAD"]);
      });

    verificar = 0;

    if ( cantidad <= 0 ) {
      alert("Alerta, no se han encontrado partidas o las cantidades corresponden a 0");
      verificar = 1;
    }

    if ( verificar == 0 ) {

      $("#btn_finalizar").prop("disabled",true);
      $("#btn_finalizar").html('Generando...');
      
      $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"NuevoRequerimiento/finalizarAjuste/",
            data:{
              iduser:iduserx,
              docx:$("#name_archivo").val(),
            },
            cache: false,
            success: function(result)
            {
              if ( result > 0 ) {
                //alert("Alerta, fue ingresada CORRECTAMENTE");
                showPDFRQ(result);
                //location.reload();
              }else{
                alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");
              }
              $("#btn_finalizar").prop("disabled",false);
              $("#btn_finalizar").html('<i class="icon-check" ></i style="color:black;"> Finalizar');
            }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
          detectarErrorJquery(jqXHR, textStatus, errorThrown);
      });
    }
  }
}

function showPDFRQ(idrq) {

  $.ajax({

    type: "POST",
    dataType: "json",
    url: base_urlx + "tw/php/pdf_rq_comanorsa.php",
    data: {
      idRq: idrq
    },
    cache: false,
    success: function (result) {
      alert("Se realizo el requerimieno satisfactoriamente");
      window.open(base_urlx+"tw/php/requerimientos/"+result+".pdf", "_blank");
      location.reload();
    }
  });
}

function loadMaxMin(){

  $("#btn_loadMaxMin").prop("disabled",true);
  $.ajax({

    type: "POST",
    dataType: "json",
    url: base_urlx + "NuevoRequerimiento/loadMaxMin/",
    data: {
      idUser: iduserx
    },
    cache: false,
    success: function (result) {
      if(result>0){
        $('#my-table').DataTable().ajax.reload();
        table.buttons().container().appendTo( '#controlPanel' );
        //alert("LA partida se almaceno correctamente");
        $("#bi_pro").val("");
        idPro = 0;
        $("#cantidad").val("");
        $("#bi_pro").focus();            
        $("#descripcion").val("");

        $("#btn_loadMaxMin").prop("disabled",false);
      }
    }
  });
  
}

function cancelarRQ() {

  $("#btn_cancelar").prop("disabled",true);
  x = confirm("¿Realmente cancelar el requerimiento?");
  if(x){
    $.ajax({
      type: "POST",
      dataType: "json",
      url: base_urlx + "NuevoRequerimiento/cancelarRQ/",
      data: {
        idUser: iduserx
      },
      cache: false,
      success: function (result) {
        if(result){
          $('#my-table').DataTable().ajax.reload();
          table.buttons().container().appendTo( '#controlPanel' );
          //alert("LA partida se almaceno correctamente");
          $("#bi_pro").val("");
          idPro = 0;
          $("#cantidad").val("");
          $("#bi_pro").focus();            
          $("#descripcion").val("");
          $("#btn_cancelar").prop("disabled",false);
          alert("Ajuste cancelado");
        }
      }
    });
  }else{
    $("#btn_cancelar").prop("disabled",false);
  }
  
}

const createdCell = function (cell) {

  let original
  cell.setAttribute('contenteditable', true)
  cell.setAttribute('spellcheck', false)
  cell.addEventListener('focus', function (e) {
    original = e.target.textContent
  })
  cell.addEventListener('blur', function (e) {
    if (original !== e.target.textContent) {
      const row = table.row(e.target.parentElement);
      if (colx == 0 || colx == 1) {
        row.invalidate()
      }       
      else {
        if(colx == 4){
          if((parseFloat(e.target.textContent)<=0)){
            row.invalidate();
            return;
          }
        }
        $.ajax({
          type: "POST",
          dataType: "json",
          url: base_urlx + "NuevoRequerimiento/updateCelda/",
          data: {
            texto: parseInt(e.target.textContent),
            columna: colx,
            idTemporal: editId,//idparte 
          },
          cache: false,
          success: function (result) {
            if (result != null) {
              temp = table.row(idFila).data();
              if (colx == 4) {
                temp["CANTIDAD"] = (round((result)));
                $('#my-table').dataTable().fnUpdate(temp, idFila, undefined, false);
              } 
            } else {
              row.invalidate();
              alert("Alerta, favor de intentar actualizarlo nuevamente");
            }
          }
        });
      }
    }
  })
}
