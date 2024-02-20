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

var monto_oc = 0;
var idtipox= 0;
var diasx = 0;
//alert("version4.0");

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

/////////////*********** INICIAL

$(document).ready(function() {
    
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
        "search":         "Buscar por cliente,documento:",
        /*"paginate": {
            "first":      "Primero",
            "last":       "Ultimo",
            "next":       "Siguiente",
            "previous":   "Anterior"
        }*/
        },

        dom: '<"top" pl>rt',

        buttons: [ 'copy', 'excel' , 'csv'],
        "order": [  [ 6, "asc" ] ],

        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            /* Append the grade to the default row class name */
            if ( true ) // your logic here
              {

                $(nRow).addClass( 'customFont' );

                $('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
                $('td:eq(2)', nRow).addClass( 'alignCenter' );
                $('td:eq(1)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );
                $('td:eq(4)', nRow).addClass( 'alignCenter' );

                $('td:eq(3)', nRow).addClass( 'fontText2' ).addClass( 'alignCenter' );
                $('td:eq(5)', nRow).addClass( 'alignCenter' );
           

                $('td:eq(6)', nRow).addClass( 'alignRight' ).addClass('color_darkred');
                $('td:eq(7)', nRow).addClass( 'alignRight' );
                $('td:eq(8)', nRow).addClass( 'alignRight' );
                $('td:eq(9)', nRow).addClass( 'alignRight' );
                $('td:eq(10)', nRow).addClass( 'alignRight' );
                $('td:eq(11)', nRow).addClass( 'alignRight' );
                $('td:eq(12)', nRow).addClass( 'alignRight' );
              
                
              }
        },

        "processing": true,
        "serverSide": true,
        "search" : false,
        "ajax": base_urlx+"Ccxc/loadPartidas?est="+$("#estatus").val(),

      "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]],

        "scrollY": 300,
        "scrollX": true
  });

    ////////////// FOCUS IN 

    $('#my-table tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();

        editId = data[13];
        clientex = data[4];
        totalx = data[10];

        diasx = data[14];
        idtipox=data[15];

        //alert(idtipox);

        monto_oc =  totalx.replace(/[^\d.]/g,"");

        $("#info_oc").html("<p>"+clientex+"</p><p>"+totalx+"</p>");
        $("#pago").val( monto_oc );

        if( parseFloat(diasx) > 0 ) {

          $("#complementox").css("display", "");

        }else{

          $("#complementox").css("display", "none");

        }




    } );


    /*table
    .buttons()
    .container()
    .appendTo( '#controlPanel' );*/

});

///////******************** CAMBIAR ESTATUS

function showInfo(){

  if ( table !="" ) {

    $('#my-table').DataTable().destroy();
    
  }

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
        "search":         "Buscar por cliente,documento:",
        /*"paginate": {
            "first":      "Primero",
            "last":       "Ultimo",
            "next":       "Siguiente",
            "previous":   "Anterior"
        }*/
        },

        dom: '<"top"B pl>rt',

        buttons: [ 'copy', 'excel' , 'csv'],
        "order": [  [ 6, "asc" ] ],

        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            /* Append the grade to the default row class name */
            if ( true ) // your logic here
              {

                $(nRow).addClass( 'customFont' );

                $('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
                $('td:eq(2)', nRow).addClass( 'alignCenter' );
                $('td:eq(1)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );
                $('td:eq(4)', nRow).addClass( 'alignCenter' );

                $('td:eq(3)', nRow).addClass( 'fontText2' ).addClass( 'alignCenter' );
                $('td:eq(5)', nRow).addClass( 'alignCenter' );
           

                $('td:eq(6)', nRow).addClass( 'alignRight' ).addClass('color_darkred');
                 $('td:eq(7)', nRow).addClass( 'alignRight' );
                $('td:eq(8)', nRow).addClass( 'alignRight' );
                $('td:eq(9)', nRow).addClass( 'alignRight' );
                $('td:eq(10)', nRow).addClass( 'alignRight' );
                $('td:eq(11)', nRow).addClass( 'alignRight' );
                $('td:eq(12)', nRow).addClass( 'alignRight' );
              
                
              }
        },

        "processing": true,
        "serverSide": true,
        "search" : false,
        "ajax": base_urlx+"Ccxc/loadPartidas?est="+$("#estatus").val(),

      "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]],

        "scrollY": 300,
        "scrollX": true
  });

    ////////////// FOCUS IN 

  $('#my-table tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();

        editId = data[13];
        clientex = data[4];
        totalx = data[10];

        idtipox=data[15];
        diasx = data[14];

        //alert(idtipox);

        monto_oc =  totalx.replace(/[^\d.]/g,"");

        $("#info_oc").html("<p>"+clientex+"</p><p>"+totalx+"</p>");
        $("#pago").val( monto_oc );

        if( parseFloat(diasx) > 0 ) {

          $("#complementox").css("display", "");

        }else{

          $("#complementox").css("display", "none");

        }

  });


    table
    .buttons()
    .container()
    .appendTo( '#controlPanel' );

}


//////// SUBIR ARCHIVO PDF

$(function () {

    'use strict';

 

    var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_cxc_comprobante/';

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

             $("#files_cfactpdf").html("<strong>El comprobante se ha subido correctamente</strong>");


            }

        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

});

///////// SUBIR COMPLEMENTO

$(function () {

    'use strict';

 

    var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_cxc_complemento/';

    $('#fileupload_comp').fileupload({

        url: url,

        dataType: 'json',

        done: function (e, data) {


            //quitarArchivo(f);

            $.each(data.result.files, function (index, file) {


              $("#name_comp").val(file.name);
                

            });

        },

            progressall: function (e, data) {

                var progress = parseInt(data.loaded / data.total * 100, 10);

                $('#progress_bar_comp .progress-bar').css(

                    'width',

                    progress + '%'

                );

             $("#files_comp").html("<strong>El complemento se ha subido correctamente</strong>");


            }

        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

});

///////// SUBIR XML

$(function () {

    'use strict';

    var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_cxc_complemento/';

    $('#fileupload_xml').fileupload({

        url: url,

        dataType: 'json',

        done: function (e, data) {


            //quitarArchivo(f);

            $.each(data.result.files, function (index, file) {


              $("#name_xml").val(file.name);
                

            });

        },

            progressall: function (e, data) {

                var progress = parseInt(data.loaded / data.total * 100, 10);

                $('#progress_bar_xml .progress-bar').css(

                    'width',

                    progress + '%'

                );

             $("#files_xml").html("<strong>El XML se ha subido correctamente</strong>");


            }

        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

});


/////////************* GUARDAR PAGO 

function guardarPago(){

  x = confirm("¿Realmente deseas agregar el cobro a este documento?");

  if ( x ) {


      verificar = 0;

      

      if ( $("#pago").val() > 0 ) {

          if ( $("#pago").val() > monto_oc ) {

            alert("Alerta, el monto a pagar es mayor al total de la ODC");
            verificar = 1;
            $("#pago").focus();

          }

      }else{

        alert("Alerta, favor de colocar un monto a pagar valido");
        verificar = 1;
        $("#pago").focus();

      }

      if ( $("#name_factpdf").val() == "" && verificar == 0 ) {

        alert("Alerta, favor de subir un comprobante de pago valido");
        verificar = 1;

      }

      if (diasx > 0){

        if ( $("#name_comp").val() == "" && verificar == 0 ) {

          alert("Alerta, favor de subir del pdf del complemento de pago ");
          verificar = 1;

        } 

      }


     

    if ( verificar == 0 ) {


        $("#btnguardar").prop("disabled",true);
        $("#btnguardar").html('Almacenando...');

          $.ajax({
                type: "POST",
                dataType: "json",
                url: base_urlx+"Ccxc/guardarPago/",
                data:{

                  iduser:iduserx,
                  editid:editId,
                  pagox:$("#pago").val(),
                  comprobantex:$("#name_factpdf").val(),
                  pdf_ppd:$("#name_comp").val(),
                  xml:$("#name_xml").val(),
                  tipo:idtipox

                },
                cache: false,
                success: function(result)
                {

                  if ( result > 0) {

                    alert("El cobro se ha realizado correctamente");
                    location.reload();

                  }else{

                    alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");

                  }

                  $("#btnguardar").prop("disabled",false);
                  $("#btnguardar").html('GUARDAR PAGO');

                }

          }).fail( function( jqXHR, textStatus, errorThrown ) {

              detectarErrorJquery(jqXHR, textStatus, errorThrown);

          });

    }

  }

}

//////////////////**** FILTRAR CXC

function showBuscar(){

  buscarx=$("#buscador").val();

  if ( buscarx!="" ) {

    ////////////////************ TABLA 

    $('#my-table').DataTable().destroy();

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
          "search":         "Buscar por cliente,documento:",
          /*"paginate": {
              "first":      "Primero",
              "last":       "Ultimo",
              "next":       "Siguiente",
              "previous":   "Anterior"
          }*/
          },

          dom: '<"top"pl>rt',

          buttons: [ 'copy', 'excel' , 'csv'],
          "order": [  [ 6, "asc" ] ],

          "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
              /* Append the grade to the default row class name */
              if ( true ) // your logic here
                {

                  $(nRow).addClass( 'customFont' );

                  $('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
                  $('td:eq(2)', nRow).addClass( 'alignCenter' );
                  $('td:eq(1)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );
                  $('td:eq(4)', nRow).addClass( 'alignCenter' );

                  $('td:eq(3)', nRow).addClass( 'fontText2' ).addClass( 'alignCenter' );
                  $('td:eq(5)', nRow).addClass( 'alignCenter' );
             

                  $('td:eq(6)', nRow).addClass( 'alignRight' ).addClass('color_darkred');
                  $('td:eq(7)', nRow).addClass( 'alignRight' );
                  $('td:eq(8)', nRow).addClass( 'alignRight' );
                  $('td:eq(9)', nRow).addClass( 'alignRight' );
                  $('td:eq(10)', nRow).addClass( 'alignRight' );
                  $('td:eq(11)', nRow).addClass( 'alignRight' );
                  $('td:eq(12)', nRow).addClass( 'alignRight' );
                
                  
                }
          },

          "processing": true,
          "serverSide": true,
          "search" : false,
          "ajax": base_urlx+"Ccxc/loadBuscar?buscar="+buscarx,

        "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]],

          "scrollY": 300,
          "scrollX": true
    });

    ////////////// FOCUS IN 

    $('#my-table tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();

        editId = data[13];
        clientex = data[4];
        totalx = data[10];

        idtipox=data[15];
        diasx = data[14];

        //alert(idtipox);

        monto_oc =  totalx.replace(/[^\d.]/g,"");

        $("#info_oc").html("<p>"+clientex+"</p><p>"+totalx+"</p>");
        $("#pago").val( monto_oc );

        if( parseFloat(diasx) > 0 ) {

          $("#complementox").css("display", "");

        }else{

          $("#complementox").css("display", "none");

        }


    } );


    /*table
    .buttons()
    .container()
    .appendTo( '#controlPanel' );*/

  }else{

    alert("Alerta, antes debes colocar una busqueda valida");
    $("#buscador").val();

  }

}
