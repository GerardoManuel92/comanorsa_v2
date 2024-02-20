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



var monto_oc = 0;

var idtipox= 0;

var diasx = 0;

var nfiltro= 0;

var table="";

var facturax="";

var editId=0;/// ID DE LA FACTURA 

//var dias_creditox=0;



/////////****************** SELECT CATEGORIAS

function verSaldo(info){

  separar=info.split("/");

  //alert(separar[1]);

  $("#monto_pago").val(separar[1]);

}

function sumaTotal(idclientex,idestatus){


          $.ajax({

                type: "POST",

                dataType: "json",

                url: base_urlx+"Cxcxc/sumaTotal/",

                data:{



                  idcliente:idclientex,

                  estatusx:idestatus



                },

                cache: false,

                success: function(result)

                {


                limitex=0;
                disponiblex=0
                
                xcobrar=parseFloat(result.total)-parseFloat(result.pagado)-parseFloat(result.ncredito);


                limitex=result.limite;
                disponiblex=parseFloat(limitex)-parseFloat(xcobrar);

                //alert(disponiblex);

                if ( result.ncredito > 0 ) {


                  if(limitex>0){

                    $("#pagosx").html('<p style="color: purple; display: ; font-size: 18px; font-weight: bold;">Total facturado: '+formatNumber(round(result.total))+'</p><p style="color: #F34C7C; font-weight: bold; font-size: 17px; " >Total saldado: '+formatNumber(round(result.pagado))+'</p><p style="color: orange; font-weight: bold; font-size: 17px; " >Nota de credito: '+formatNumber(round(result.ncredito))+'</p>  <p style="color:darkblue; font-weight:bold; font-size:18px;" >Linea de credito: '+formatNumber(round(limitex))+'</p>  <p style="color: #D88E03; font-weight: bold; font-size: 17px; " > Saldo total deudor: '+formatNumber(round(xcobrar))+'</p> <p style="color: darkgreen; font-weight: bold; font-size: 17px;"> Saldo disponible: '+formatNumber(round(disponiblex))+'</p>');                     

                  }else{

                    $("#pagosx").html('<p style="color: purple; display: ; font-size: 18px; font-weight: bold;">Total facturado: '+formatNumber(round(result.total))+'</p><p style="color: #F34C7C; font-weight: bold; font-size: 17px; " >Total saldado: '+formatNumber(round(result.pagado))+'</p><p style="color: orange; font-weight: bold; font-size: 17px; " >Nota de credito: '+formatNumber(round(result.ncredito))+'</p><p style="color:#D88E03; font-weight: bold; font-size: 17px; " >Saldo total deudor: '+formatNumber(round(xcobrar))+'</p>');

                  }

                  



                }else{


                  if(limitex>0){

                    $("#pagosx").html('<p style="color: purple; display: ; font-size: 18px; font-weight: bold;">Total facturado: '+formatNumber(round(result.total))+'0</p><p style="color: #F34C7C; font-weight: bold; font-size: 17px; " >Total saldado: '+formatNumber(round(result.pagado))+'</p>   <p style="color:darkblue; font-weight:bold; font-size:18px;" >Linea de credito: '+formatNumber(round(limitex))+'</p>   <p style="color: #D88E03; font-weight: bold; font-size: 17px; " >Saldo total deudor: '+formatNumber(round(xcobrar))+'</p> <p style="color: darkgreen; font-weight: bold; font-size: 17px;">Saldo disponible: '+formatNumber(round(disponiblex))+'</p>');  

                    //$("#pagosx").html('<p style="color: darkgreen; font-weight: bold; font-size: 17px;" >');  

                  }else{

                    $("#pagosx").html('<p style="color: purple; display: ; font-size: 18px; font-weight: bold;">Total facturado: '+formatNumber(round(result.total))+'0</p><p style="color: #F34C7C; font-weight: bold; font-size: 17px; " >Total saldado: '+formatNumber(round(result.pagado))+'</p><p style="color: #D88E03; font-weight: bold; font-size: 17px; " >Saldo total deudor: '+formatNumber(round(xcobrar))+'</p>');                    

                  }



                }





                



                  /*if ( result > 0) {



                    alert("El cobro se ha realizado correctamente");

                    location.reload();



                  }else{



                    alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");



                  }



                  $("#btnguardar").prop("disabled",false);

                  $("#btnguardar").html('GUARDAR PAGO');



                  */



                }



          }).fail( function( jqXHR, textStatus, errorThrown ) {



              detectarErrorJquery(jqXHR, textStatus, errorThrown);



          });



  //$("#pagosx").html('<p style="color: darkblue; display: ; font-size: 18px; font-weight: bold;">Total: '+total+'</p> <p style="color: green; font-weight: bold; font-size: 17px; " >Pagado: $ '+totalpagado+'</p><p style="color: red; font-weight: bold; font-size: 17px; " >Por cobrar: $ 0.00</p>');



}


function ShowTnota(tipo){

  if(tipo==0){

    $("#select_nota").css("display","");
    $("#subir_nota").css("display","none");


  }else if(tipo==1){


    $("#subir_nota").css("display","");
    $("#select_nota").css("display","none");

  }

}



function showCliente(){



    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Cxcxc/showCliente/",

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


                  setTimeout(function (){

                    $("#cliente").val(sidcliente);
                    $('#cliente').trigger('change.select2'); // Notify only Select2 of changes

                  }, 500);

                  



              }else{



                 $("#cliente").html("<option value='0'>Sin categorias</option>");



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



}

function showMovimientos(idclientexx){

  $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Cxcxc/showMovimientos/",
            data:{

              idcli:idclientexx

            },
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption="<option value='0'>Seleccione un movimiento</option>"; 

                  $.each(result, function(i,item){
                      data1=item.rastreo;//id
                      data2=item.cuenta;//nombre
                      data3=item.comercial;//id
                      data4=item.importe;
                      data5=item.dato;//// id/importe

                      creaOption=creaOption+'<option value="'+data5+'"> '+item.fecha_banco+'|'+item.hora_banco+' #RASTREO:'+data1+' - CUENTA:'+data2+' , '+data3+' | '+formatNumber(round(data4))+'</option>'; 

                  }); 

                  $("#lista_movimientos").html(creaOption);
                  
                 

              }else{

                 $("#lista_movimientos").html("<option value='0'>Sin cuentas asignadas...</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}



function calcularxCobrar(totalx,pagadox,ncreditox){



  total=totalx.replace(/[^\d.]/g,"");

  pagado=pagadox.replace(/[^\d.]/g,"");

  totnc=ncreditox.replace(/[^\d.]/g,"");



  xpagar=parseFloat(total)-parseFloat(pagado)-parseFloat(totnc);



  if ( xpagar > 0 ) {



    return "<p style='color:red; font-weight:bold; font-size:13px;' >"+formatNumber(round(xpagar)+"</p>");



  }else{



    return formatNumber(round(xpagar));



  }



}



function xCobrarSpesos(totalx,pagadox){



  total=totalx.replace(/[^\d.]/g,"");

  pagado=pagadox.replace(/[^\d.]/g,"");



  xpagar=parseFloat(total)-parseFloat(pagado);



  return round(xpagar);



}





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



  showCliente();



});





function showxCliente(){



  buscarx=$("#cliente").val();



  if ( buscarx > 0 ) {



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

          "search":         "Buscar por documento/Importe:",

          /*"paginate": {

              "first":      "Primero",

              "last":       "Ultimo",

              "next":       "Siguiente",

              "previous":   "Anterior"

          }*/

          },



          dom: '<"top" fpl>rt',



          buttons: [ 'copy', 'excel' , 'csv'],

          "order": [  [ 6, "asc" ] ],



          "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

              /* Append the grade to the default row class name */

              if ( true ) // your logic here

                {



                  $(nRow).addClass( 'customFont' );



                  $('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );

                  //$('td:eq(2)', nRow).addClass( 'alignCenter' );

                  $('td:eq(1)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );

                  //$('td:eq(4)', nRow).addClass( 'alignCenter' );



                  $('td:eq(2)', nRow).addClass( 'fontText2' ).addClass( 'alignCenter' );

                  $('td:eq(3)', nRow).addClass( 'alignCenter' );



                  $('td:eq(4)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );

             



                  $('td:eq(5)', nRow).addClass( 'alignRight' ).addClass('color_darkred');

                  $('td:eq(6)', nRow).addClass( 'alignRight' );

                  $('td:eq(7)', nRow).addClass( 'alignRight' );

                  $('td:eq(8)', nRow).addClass( 'alignRight' );

                  $('td:eq(9)', nRow).addClass( 'alignRight' );

                  $('td:eq(10)', nRow).addClass( 'alignRight' );

                  $('td:eq(11)', nRow).addClass( 'alignRight' );

                

                  

                }

          },

          columnDefs: [



            {

                targets: [12],

                data: null,

                render: function ( data, type, row, meta ) {                   

                



                  valor=calcularxCobrar( data[9],data[11],data[10] );



                  return ``+valor+``         



               }



               

            }



          ],



          "processing": true,

          "serverSide": true,

          "search" : false,

          "ajax": base_urlx+"Cxcxc/loadBuscar?buscar="+buscarx+"&estatusx="+$("#estatus").val(),



        "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]],



          "scrollY": 300,

          "scrollX": true

    });



    ////////////// FOCUS IN 



    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();



        totalx = data[9];

        facturax=data[2];

        //alert(facturax);

        ncreditox = data[10];

        cobradox = data[11];

        editId = data[13];

        diasx = data[14];

        idtipox=data[16];/// tipo factura 0:normal,1:sustitucion

        $("#monto_pago").val(0);

        //dias_creditox=data[4];

        xpagarx=parseFloat( totalx.replace(/[^\d.]/g,"") )-parseFloat( cobradox.replace(/[^\d.]/g,"") )-parseFloat( ncreditox.replace(/[^\d.]/g,"")) ;


        monto_oc=round(xpagarx);



        //$("#info_oc").html("<p>"+clientex+"</p><p>"+formatNumber(monto_oc)+"</p>");

        $("#pago").val( monto_oc );

        $("#xpagar").val( formatNumber(round(monto_oc)) );

        $("#factura_pagar").html( "FACTURA: "+facturax );



        $("#totpago").val(monto_oc);



        if( parseFloat(diasx) > 0 ) {



          $("#complementox").css("display", "");

          $("#pago").prop("disabled",false);

          $("#mpfpago").html('Forma de pago: &nbsp;&nbsp;Pago en parcialidades');

          



        }else{



          $("#complementox").css("display", "none");

          $("#pago").prop("disabled",true);

          $("#mpfpago").html('Forma de pago: &nbsp;&nbsp;Pago en una sola exhibicion');

        }

        $("#mpinfo").html('Factura:&nbsp;'+facturax+'| '+totalx+' mxn');


        //showPagos();


        showPagosFactura(editId,idtipox);


    } );



    $("#incial").val("");

    $("#final").val("");



    $("#pagosx").html("<h4>Calculando...</h4>");



    sumaTotal(buscarx,0);

    showMovimientos(buscarx);

    showNotasxcliente();

    

    nfiltro= 1;



    /*table

    .buttons()

    .container()

    .appendTo( '#controlPanel' );*/



  }



}


function showNc(){

  //alert();

  separar=$('#lista_notas').val().split("NC");

  window.open(base_urlx+"tw/php/facturas_nc/NC"+separar[1]+".pdf", "_blank");

}

function showNotasxcliente(){


  if( $("#cliente").val() > 0 ){

    $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"Cxcxc/showNotasxcliente/",

              data:{idcliente:$("#cliente").val()},

              cache: false,

              success: function(result)

              {



                if ( result != null ) {



                    creaOption="<option value='0' selected>Selecciona una nota de credito...</option>"; 



                    $.each(result, function(i,item){

                        data1=item.id+""+item.foliox;//id

                        data2=item.foliox;//nombre

                        data3=item.ciente;//id

                        data4=item.total;//nombre

                        creaOption=creaOption+'<option value="'+data1+'">'+data2+'-'+data3+' <strong style="color:darkblue;">'+formatNumber(round(data4))+'</strong></option>'; 

                    }); 



                    $("#lista_notas").html(creaOption);

                    $("#lista_notas").val(0);



                }else{



                   $("#lista_notas").html("<option value='0'>Sin notas de credito</option>");



                }

   

              }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





      detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });

  }

}



function buscarxFecha(){



  if ( $("#incial").val() != "" && $("#final").val() != "" ) {



    if( $("#cliente").val() == 0 || $("#cliente").val() == null || $("#cliente").val() == "" ){



       alert("Favor de seleccionar un cliente valido");



    }else{





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

            "search":         "Buscar por documento/Importe:",

            /*"paginate": {

                "first":      "Primero",

                "last":       "Ultimo",

                "next":       "Siguiente",

                "previous":   "Anterior"

            }*/

            },



            dom: '<"top" fpl>rt',



            buttons: [ 'copy', 'excel' , 'csv'],

            "order": [  [ 6, "asc" ] ],



            "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

                /* Append the grade to the default row class name */

                if ( true ) // your logic here

                  {



                    $(nRow).addClass( 'customFont' );



                    $('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );

                    //$('td:eq(2)', nRow).addClass( 'alignCenter' );

                    $('td:eq(1)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );

                    //$('td:eq(4)', nRow).addClass( 'alignCenter' );



                    $('td:eq(2)', nRow).addClass( 'fontText2' ).addClass( 'alignCenter' );

                    $('td:eq(3)', nRow).addClass( 'alignCenter' );



                    $('td:eq(4)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );

               



                    $('td:eq(5)', nRow).addClass( 'alignRight' ).addClass('color_darkred');

                    $('td:eq(6)', nRow).addClass( 'alignRight' );

                    $('td:eq(7)', nRow).addClass( 'alignRight' );

                    $('td:eq(8)', nRow).addClass( 'alignRight' );

                    $('td:eq(9)', nRow).addClass( 'alignRight' );

                    $('td:eq(10)', nRow).addClass( 'alignRight' );

                    $('td:eq(11)', nRow).addClass( 'alignRight' );

                  

                    

                  }

            },



            columnDefs: [



              {

                  targets: [12],

                  data: null,

                  render: function ( data, type, row, meta ) {                   

                  



                    valor=calcularxCobrar( data[9],data[11],data[10] );



                    return ``+valor+``         



                 }

 

              }



            ],



            "processing": true,

            "serverSide": true,

            "search" : false,

            "ajax": base_urlx+"Cxcxc/buscarxFecha?buscar="+buscarx+"&estatusx="+$("#estatus").val()+"&inicio="+$("#incial").val()+"&fin="+$("#final").val(),



          "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]],



            "scrollY": 300,

            "scrollX": true

      });



      ////////////// FOCUS IN 



      $('#my-table tbody').on('click', 'tr', function () {

          var data = table.row( this ).data();



        totalx = data[9];

        facturax=data[2];

        ncreditox = data[10];

        cobradox = data[11];

        editId = data[13];

        diasx = data[14];

        idtipox=data[16];

        $("#monto_pago").val(0);


        xpagarx=parseFloat( totalx.replace(/[^\d.]/g,"") )-parseFloat( cobradox.replace(/[^\d.]/g,"") )-parseFloat( ncreditox.replace(/[^\d.]/g,"")) ;







        monto_oc=round(xpagarx);


        $("#factura_pagar").html("Factura:"+" "+facturax);
        

        $("#pago").val( monto_oc );

        $("#xpagar").val( parseFloat(round(monto_oc)) );



        $("#totpago").val(monto_oc);


        if( parseFloat(diasx) > 0 ) {



          $("#complementox").css("display", "");

          $("#pago").prop("disabled",false);

          $("#mpfpago").html('Forma de pago: &nbsp;&nbsp;Pago en parcialidades');

        }else{


          $("#complementox").css("display", "none");

          $("#pago").prop("disabled",true);

          $("#mpfpago").html('Forma de pago: &nbsp;&nbsp;Pago en una sola exhibicion');



        }

        $("#mpinfo").html('Factura:&nbsp;'+facturax+'| '+totalx+' mxn');

        showPagosFactura(editId,idtipox);



      } );



      nfiltro= 2;



    }



  }else{



    alert("Favor de seleccionar un rango de fechas valido");



  }



  



}


function showPagosFactura(idfact,tipo){

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Cxcxc/showPagosFactura/",
            data:{

              idfacturax:idfact,
              tipox:tipo

            },
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  creaOption=''; 

                  $.each(result, function(i,item){
                      npagox=item.npago;//id
                      pagox=item.pago;//nombre
                      foliox=item.folio;//id
                      fechax=item.fecha;
                      tpagox=item.tpago;//// id/importe
                      comprobantex=item.comprobante;//// id/importe

                      if(tpagox==0){

                        ///////complemento de pago

                        creaOption+='<p>Fecha: '+fechax+' &nbsp;&nbsp;&nbsp; No.Pago: '+npagox+' | Folio: <a href="'+base_urlx+'tw/php/facturas_ppd/'+foliox+'.pdf" target="_blank" >'+foliox+'</a> | &nbsp;&nbsp;&nbsp; Importe: '+formatNumber(round(pagox))+'</p>';

                      }else if(tpagox==1){

                        ////////// pago PUE o PPD fuera del sistema

                        creaOption+='<p>Fecha: '+fechax+' &nbsp;&nbsp;&nbsp; | <a href="'+base_urlx+'tw/js/upload_cxc_comprobante/files/'+comprobantex+'" target="_blank" > <i class="fa fa-eye"></i> Comprobante</a></p> | &nbsp;&nbsp;&nbsp; Importe: '+formatNumber(round(pagox))+'</p>';

                      }else if(tpagox==2){

                        ///////////// PAGOS POR MOVIMEINTOS BANCARIOS

                        creaOption+='<p>Fecha: '+fechax+' | #Movimiento: '+foliox+' | Importe: '+formatNumber(round(pagox))+'</p>';

                      }

                     

                  }); 

                  //alert(creaOption);
                  $("#pagos_factura").html(creaOption)

              }else{

                 alert("Sin cobros aplicados");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}


function CierraPopup() {



  $('#cerrarx2').click(); //Esto simula un click sobre el botón close de la modal, por lo que no se debe preocupar por qué clases agregar o qué clases sacar.

  $('.modal-backdrop').remove();//eliminamos el backdrop del modal



}





/////////////**************************** SUBIR COBRO 



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



///////// SUBIR NOTA DE CREDITO



$(function () {



    'use strict';



    var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_cxc_nota/';



    $('#fileupload_nc').fileupload({



        url: url,



        dataType: 'json',



        done: function (e, data) {





            //quitarArchivo(f);



            $.each(data.result.files, function (index, file) {





              $("#name_nc").val(file.name);



              $("#titulo_nota").val("");

                              $("#cliente_nota").val("");

                              $("#folio_nota").val("");

                              $("#factura_nota").val("");

                              $("#total_nota").val("");

                              $("#fpago_nota").val("");

                              $("#idfactura_nota").val("");

                              $("#tipo_factura").val("");



                $.ajax({

                        type: "POST",

                        dataType: "json",

                        url: base_urlx+"tw/php/obtener_datos_nota_credito.php",

                        cache: false,

                        data:{nc:file.name},

                        success: function(result)

                        {



                          if ( result != null ) {





                              /*$.each(result, function(i,item){



                                  //idfacturax=item.idfactura;//id

                                  tipo=item.tipo;//nombre

                                  cliente=item.cliente;//id

                                  fol_factura=item.fol_factura;//nombre

                                  totalx=item.totalx;

                                  formaPago=item.formaPago;

                                  nc=item.nc;

                                 

                              });*/



                              //alert(result.cliente);



                              $("#datos_nota").css("display","");



                              $("#titulo_nota").html("Datos de la nota de credito");

                              $("#cliente_nota").html("cliente: "+result.cliente);

                              $("#folio_nota").html("Folio nota: "+result.nc);

                              $("#factura_nota").html("Folio factura:"+result.fol_factura);

                              $("#total_nota").html("Total de nota: "+formatNumber( result.totalx[0]) );

                              $("#fpago_nota").html("Forma de pago: "+result.formaPago);

                              $("#idfactura_nota").val(result.idfactura);

                              $("#tipo_factura").val(result.tipo);



                          }else{



                            $("#datos_nota").css("display","none");



                              



                          }

             

                        }



                }).fail( function( jqXHR, textStatus, errorThrown ) {





                    detectarErrorJquery(jqXHR, textStatus, errorThrown);



                });

                



            });



        },



            progressall: function (e, data) {



                var progress = parseInt(data.loaded / data.total * 100, 10);



                $('#progress_bar_nc .progress-bar').css(



                    'width',



                    progress + '%'



                );



             $("#files_nc").html("<strong>El XML de la nota se ha subido correctamente</strong>");





            }



        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');



});





///////////////////********************* SUBIR NOTA DE CREDITO



function guardarNota(){




  if( $("#forma").val() ==1 ){


    verificar = 0;



    if( $("#name_nc").val() == "" ){



      alert("Antes debes subir una nota de credito valida");

      verificar=1;



    }



    if( $("#idfactura_nota").val() == 0 || $("#idfactura_nota").val() == "" ){



      alert("Error, la factura a la cual se liga esta nota de credito no ha sido localizada, favor de intentarlo nuevamente.");

      verificar=1;



    }



    if(verificar == 0) {



      $.ajax({



                    type: "POST",

                    dataType: "json",

                    url: base_urlx+"tw/php/alta_nota_credito_fuera_sistema.php",

                    data:{



                      nc:$("#name_nc").val(),

                      idfact:$("#idfactura_nota").val(),

                      tipo:$("#tipo_factura").val(),

                      idfactura_aplicar:editId,

                      idtipo:idtipox,

                      xpagarx:monto_oc,

                      idusuario:iduserx

                    },

                    cache: false,

                    success: function(result)

                    {



                      if ( result ) {



                        CierraPopup();



                        alert("La nota se agrego correctamente");



                        table.ajax.reload();



                         $("#titulo_nota").html("");

                                $("#cliente_nota").html("");

                                $("#folio_nota").html("");

                                $("#factura_nota").html("");

                                $("#total_nota").html("");

                                $("#fpago_nota").html("");

                                $("#idfactura_nota").val("");

                                $("#tipo_factura").val("");



                        $("#datos_nota").css("display","none");

                        $('#progress_bar_nc .progress-bar').css('width','0%');

                        $("#name_nc").val("");



                      }else{



                        alert("Error, la nota de credito no se añadio correctamente, favor de intentarlo nuevamente");



                      }



                    }



      }).fail( function( jqXHR, textStatus, errorThrown ) {



        detectarErrorJquery(jqXHR, textStatus, errorThrown);



      });





    }


  }else if( $("#forma").val()==0 ){

    /////////// SELECCIONAR NOTA DE CREDITO Y AÑADIR A FACTURA PARA PAGO

    separarx=$("#lista_notas").val().split("NC");    


    if( $("#lista_notas").val()==0 ){

      alert("Alerta, favor de sleccionar una nota de credito valida");
      $("#lista_notas").focus();


    }else if( separarx[0]>0 ){


      //alert( "idnota="+$("#lista_notas").val() );

      $.ajax({

                    type: "POST",

                    dataType: "json",

                    url: base_urlx+"Cxcxc/AplicarNota",

                    data:{

                      idnc:separarx[0],

                      idfactura_aplicar:editId,

                      idtipo:idtipox,

                      xpagarx:monto_oc,

                      idusuario:iduserx

                    },

                    cache: false,

                    success: function(result)

                    {



                      if ( result ) {



                        CierraPopup();



                        alert("La nota se agrego correctamente");



                        table.ajax.reload();



                         $("#titulo_nota").html("");

                                $("#cliente_nota").html("");

                                $("#folio_nota").html("");

                                $("#factura_nota").html("");

                                $("#total_nota").html("");

                                $("#fpago_nota").html("");

                                $("#idfactura_nota").val("");

                                $("#tipo_factura").val("");

                                $("#forma").val(0);

                        showNotasxcliente();



                        $("#datos_nota").css("display","none");

                        $('#progress_bar_nc .progress-bar').css('width','0%');

                        $("#name_nc").val("");





                      }else{



                        alert("Error, la nota de credito no se añadio correctamente, favor de intentarlo nuevamente");



                      }



                    }



      }).fail( function( jqXHR, textStatus, errorThrown ) {



        detectarErrorJquery(jqXHR, textStatus, errorThrown);



      });

    }


  }


}



/////////************* GUARDAR PAGO 



function guardarPago(){



  x = confirm("¿Realmente deseas agregar el cobro a este documento?");



  if ( x ) {



      verificar = 0;


      if ( $("#pago").val() > 0 ) {



          if ( $("#pago").val() > monto_oc ) {



            alert("Alerta, el monto a pagar es mayor al total de la FACTURA");

            verificar = 1;

            $("#pago").focus();



          }



      }else{



        alert("Alerta, favor de colocar un monto a pagar valido");

        verificar = 1;

        $("#pago").focus();



      }



      /*if ( $("#name_factpdf").val() == "" && verificar == 0 ) {



        alert("Alerta, favor de subir un comprobante de pago valido");

        verificar = 1;



      }*/



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

                url: base_urlx+"Cxcxc/guardarPago/",

                data:{



                  iduser:iduserx,

                  editid:editId,

                  pagox:$("#pago").val(),

                  comprobantex:$("#name_factpdf").val(),

                  lista_movx:$("#lista_movimientos").val(),

                  pdf_ppd:$("#name_comp").val(),

                  xml:$("#name_xml").val(),

                  tipo:idtipox,

                  xcobrar:$("#totpago").val(),

                  importe_movimiento:$("#monto_pago").val()



                },

                cache: false,

                success: function(result)

                {



                  if ( result > 0) {



                    alert("El cobro se ha realizado correctamente");

                    

                    if ( nfiltro == 1 ) {



                      showxCliente();



                    }else if( nfiltro == 2 ){



                      buscarxFecha();



                    }



                    //////////******* LIMPIAMOS EL FORMULARIO



                    $("#name_factpdf").val("");

                    $("#name_comp").val("");

                    $("#name_xml").val("");

                    $("#pago").val("");

                    $("#totpago").val("");



                    progress = 0;



                    $('#progress_bar_factpdf .progress-bar').css(



                        'width',



                        progress + '%'



                    );



                    $('#progress_bar_comp .progress-bar').css(



                      'width',



                      progress + '%'



                    );



                    $('#progress_bar_xml .progress-bar').css(



                        'width',



                        progress + '%'



                    );



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



///////////**********************GENERAR REPORTE 



function generarPdf(){

  buscarx=$("#cliente").val();



  if ( buscarx > 0 ) {



    $.ajax({



                  type: "POST",

                  dataType: "json",

                  url: base_urlx+"tw/php/pdf_estado_cuenta.php",

                  data:{



                    buscar:buscarx,

                    estatusx:$("#estatus").val(),

                    nfiltrox:nfiltro,

                    inicio:$("#incial").val(),

                    fin:$("#final").val()



                  },

                  cache: false,

                  success: function(result)

                  {



                    



                    window.open(base_urlx+"tw/php/estado_cuenta/edc"+result+".pdf");

                       

                   



                  }



    }).fail( function( jqXHR, textStatus, errorThrown ) {



                detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



  }else{



    alert("Alerta, antes debes colocar una cliente valido");

    $("#cliente").focus();



  }



}

function generarExcel(){

  buscarx=$("#cliente").val();


  if ( buscarx > 0 ) {


    $.ajax({


                  type: "POST",

                  dataType: "json",

                  url: base_urlx+"tw/php/crear_excel_cxc.php",

                  data:{

                    idcliente:buscarx

                  },

                  cache: false,

                  success: function(result)

                  {

                    window.location.href=base_urlx+"tw/php/reporte/"+result;


                  }



    }).fail( function( jqXHR, textStatus, errorThrown ) {



      detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });


  }else{

    alert("Alerta, antes debes colocar una cliente valido");

    $("#cliente").focus();



  }

}



function cerrarSesion(){



    var x = confirm("¿Realmente deseas cerrar la sesión?");



    if( x==true ){



      window.location.href = base_urlx+"Login/CerrarSesion/";

      

    }  



}

