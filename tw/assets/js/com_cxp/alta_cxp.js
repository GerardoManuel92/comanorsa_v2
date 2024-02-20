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

        "search":         "Buscar por producto:",

        /*"paginate": {

            "first":      "Primero",

            "last":       "Ultimo",

            "next":       "Siguiente",

            "previous":   "Anterior"

        }*/

        },



        dom: '<"top"B fpl>rt',



        buttons: [ 'copy', 'excel' , 'csv'],

        "order": [  [ 5, "asc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            /* Append the grade to the default row class name */

            if ( true ) // your logic here

              {



                $(nRow).addClass( 'customFont' );



                $('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );

                $('td:eq(2)', nRow).addClass( 'alignCenter' );

                $('td:eq(1)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );

                $('td:eq(4)', nRow).addClass( 'alignCenter' );



                $('td:eq(3)', nRow).addClass( 'fontText2' );

                $('td:eq(5)', nRow).addClass( 'alignCenter' ).addClass('color_darkred');

           



                $('td:eq(6)', nRow).addClass( 'alignRight' );

                $('td:eq(7)', nRow).addClass( 'alignRight' );

                $('td:eq(8)', nRow).addClass( 'alignRight' );

              

                

              }

        },



        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Ccxp/loadPartidas",



      "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]],



        "scrollY": 300,

        "scrollX": true

    });



    ////////////// FOCUS IN 



    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();



        editId = data[10];

        proveedorx = data[3];

        totalx = data[9];



        monto_oc =  totalx.replace(/[^\d.]/g,"");



        $("#info_oc").html("<p>"+proveedorx+"</p><p>"+totalx+"</p>");

        $("#pago").val( monto_oc );





    } );





    table

    .buttons()

    .container()

    .appendTo( '#controlPanel' );



});





//////// SUBIR ARCHIVO PDF



$(function () {



    'use strict';



 



    var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_oc_comprobante/';



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



             $("#files_cfactpdf").html("<strong>El pdf se ha subido correctamente</strong>");





            }



        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');



});





/////////************* GUARDAR PAGO 



function guardarPago(){



  x = confirm("¿Realmente deseas realizar el pago a este proveedor?");



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

     



    if ( verificar == 0 ) {





        $("#btnguardar").prop("disabled",true);

        $("#btnguardar").html('Almacenando...');



          $.ajax({

                type: "POST",

                dataType: "json",

                url: base_urlx+"Ccxp/guardarPago/",

                data:{



                  iduser:iduserx,

                  idocx:editId



                },

                cache: false,

                success: function(result)

                {



                  if ( result ) {



                    alert("El pago se ha realizado correctamente");

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



