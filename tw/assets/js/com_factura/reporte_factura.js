//alert("version 1.0");

var idClientex = 0;

var idCotizacionx = 0;

var folFact = 0;

var tipox=0;

var table="";



//alert("verson 2.0");



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



function CierraPopup() {



  $('#cerrarx').click(); //Esto simula un click sobre el botón close de la modal, por lo que no se debe preocupar por qué clases agregar o qué clases sacar.

  $('.modal-backdrop').remove();//eliminamos el backdrop del modal



}



function calcularTotal(sub,desc,iva){



	tsub = sub.replace(/[^\d.]/g,"");

	tdesc = desc.replace(/[^\d.]/g,"");

	tiva = iva.replace(/[^\d.]/g,"");



	total = parseFloat(tsub)-parseFloat(tdesc)+parseFloat(tiva);



	return formatNumber( round(total) );



}



$(document).ready(function() {



  ///////////primera imagen  



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

        "search":         "Buscar por descripcion:",

        "paginate": {

            "first":      "Primero",

            "last":       "Ultimo",

            "next":       "Siguiente",

            "previous":   "Anterior"

        }

        },



        dom: '<"top" pli>rt',



        buttons: [ 'copy', 'excel' , 'csv'],

        "order": [  [ 5, "desc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            /* Append the grade to the default row class name */

            if ( true ) // your logic here

	        {



	          $(nRow).addClass( 'customFont' );



	          $('td:eq(0)', nRow).addClass( 'alignCenter' );

	          $('td:eq(1)', nRow).addClass( 'alignCenter' );



	          $('td:eq(2)', nRow).addClass( 'fontText2center' );



	          $('td:eq(3)', nRow).addClass( 'alignCenter' );

            $('td:eq(4)', nRow).addClass( 'alignCenter' );

	          $('td:eq(5)', nRow).addClass( 'alignCenter' );

	          $('td:eq(7)', nRow).addClass( 'fontText2' );



	          $('td:eq(8)', nRow).addClass( 'alignRight' );

	          $('td:eq(9)', nRow).addClass( 'fontText2red' );

	          $('td:eq(10)', nRow).addClass( 'alignRight' );

	          $('td:eq(11)', nRow).addClass( 'alignRight' );

	          

	          

	        }



        },



        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Rfacturas/loadPartidas" ,



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();



        //alert("idcliente:"+data[12]);

        showContacto(data[12]);



        $("#titulo").html("Enviar factura: "+data[6]);



        idClientex = data[12];

        idCotizacionx = data[11];

        folFact = data[13];

        tipox = data[14];



        $("#contacto3").val("");



        //alert(idCotizacionx);





        //showDatosfactura(idCotizacionx);



        $("#dfactura").html('<label style="color:red;">Factura</label><br><a href="'+base_urlx+'tw/php/facturas/'+folFact+'.pdf" target="_blank" style="color:red; font-weight:bold; font-size17px;" ><i style="color:red; font-weight:bold; font-size17px;" class="fa fa-file-pdf-o"></i> '+folFact+'</a>');



        $("#vercotizacion").html('<a href="'+base_urlx+'tw/php/facturas/fact'+data[12]+'.pdf" target="_blank" style="color:red; font-weight: bold; font-size: 15px;"> <i class="fa fa-eye" style="color:red; font-weight: bold; font-size: 15px;"></i> Ver factura</a>')



        $("#datos_cfdi").html('<i class="fa fa-file" style="color:darkblue;" ></i><a href="'+base_urlx+'/tw/php/facturas_ppd/'+folFact+'.pdf" target="_blank" style="color:darkblue;"> '+folFact+'</a> - '+data[6]);



    } );



    //showClientes();

    showCancelacion();





} );



/////////****************** SELECT SUB-CATEGORIAS



function showContacto(idcliente){



  $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rcotizacion/showContacto/",

            data:{idcli:idcliente},

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  var creaOption="";

                  var creaOption2="<option value='0' selected>No agregar copia</option>" 



                  $.each(result, function(i,item){

                      data0=item.id;//id

                      data1=item.nombre;//id

                      data2=item.puesto;//nombre

                      data3=item.correo//correo

                      creaOption=creaOption+'<option value="'+data0+'">'+data1+'/'+data2+'-'+data3+'</option>'; 

                  }); 



                  $("#contacto1").html(creaOption);

                  $("#contacto2").html(creaOption2+''+creaOption);

                  

              }else{



                $("#contacto1").html("<option value='0'>Sin contactos</option>");

                $("#contacto2").html("<option value='0'>Sin contactos</option>");



              }



 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



}



function enviarCorreo(){



  verificar = 0;

  copiax = 0;



  if ( $("#contacto1").val() == 0 ) {



    verificar = 1;

    alert("Alerta, antes debes seleccionar un correo valido");



  }



  if ( idClientex == 0 && verificar == 0 ) {



    verificar = 1;

    alert("Alerta, antes debes seleccionar un cliente valido");



  }



  if ( verificar == 0 ) {



      txtcorreo = $('select[name="contacto1"] option:selected').text();

      separar = txtcorreo.split("-");

      correox = separar[1];



      /////// revisar la copia de correo 



      if ( $("#contacto2").val() > 0 ) {



        txtcorreo2 = $('select[name="contacto2"] option:selected').text();

        separar2 = txtcorreo2.split("-");

        correox2 = separar2[1];

        copiax = 1;



      }else{



        correox2 = "";

        copiax = 0;



      }



      x = confirm("Favor de confirmar el envio de correo");

      

      if ( x ) {  



        $.ajax({

                type: "POST",

                dataType: "json",

                url: base_urlx+"Rfacturas/enviarCorreo/",

                data:{ idcli:idClientex, folio:folFact, destinatario:correox, copia:copiax, otro_correo:correox2, cont3:$("#contacto3").val()  },

                cache: false,

                success: function(result)

                {



                  if ( result ) {

       

                    alert("Correo enviado");



                  }



         

                }



        }).fail( function( jqXHR, textStatus, errorThrown ) {





              detectarErrorJquery(jqXHR, textStatus, errorThrown);



        });



      }



  }



}





function generarZip(){



  if ( folFact != "" ) {



    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"tw/php/zip.php",

            data:{folio:folFact},

            cache: false,

            success: function(result)

            {



              if ( result ) {



                window.open(base_urlx+"tw/php/zip_facturas/"+folFact+".zip" , "_blank");



              }else{



                alert("Alerta, el archivo no pudo ser generado favor de intentarlo nuevamente");



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



  }else{



    alert("Alerta, favor de seleccinar un folio de factura valido y de persistir el error reportarlo al administrador del portal");



  }



}



function showClientes(idcliente){



  $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rcotizacion/showClientes/",

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  var creaOption="<option value='0'>Ver todos</option> "; 



                  $.each(result, function(i,item){

                      data0=item.id;//id

                      data1=item.nombre;//id

                      data2=item.comercial;//nombre

                      creaOption=creaOption+'<option value="'+data0+'">'+data1+' | '+data2+'</option>'; 

                  }); 



                  $("#cliente").html(creaOption);

                  //$("#cliente").val(0).trigger('change');

                  

              }else{



                $("#cliente").html("");



              }



 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



}



function showCancelacion(idcliente){



  $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rfacturas/showCancelacion/",

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  var creaOption=""; 



                  $.each(result, function(i,item){

                      data0=item.id;//id

                      data1=item.clave;//id

                      data2=item.motivo;//nombre

                      creaOption=creaOption+'<option value="'+data0+'">'+data1+' - '+data2+'</option>'; 

                  }); 



                  $("#ocancelacion").html(creaOption);

                  //$("#cliente").val(0).trigger('change');

                  

              }else{



                $("#ocancelacion").html("");



              }



 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



}


function loadFiltroEntrelazado(){

  if ( table !="" ) {



    $('#my-table').DataTable().destroy();

    $("#folio").val("");



  }



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

        "search":         "Buscar por descripcion:",

        "paginate": {

            "first":      "Primero",

            "last":       "Ultimo",

            "next":       "Siguiente",

            "previous":   "Anterior"

        }

        },



        dom: '<"top" pli>rt',



        buttons: [ 'copy', 'excel' , 'csv'],

        "order": [  [ 5, "desc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            /* Append the grade to the default row class name */

            if ( true ) // your logic here

          {



            $(nRow).addClass( 'customFont' );



            $('td:eq(0)', nRow).addClass( 'alignCenter' );

            $('td:eq(1)', nRow).addClass( 'alignCenter' );



            $('td:eq(2)', nRow).addClass( 'fontText2center' );



            $('td:eq(3)', nRow).addClass( 'alignCenter' );

            $('td:eq(4)', nRow).addClass( 'alignCenter' );

            $('td:eq(5)', nRow).addClass( 'alignCenter' );

            $('td:eq(7)', nRow).addClass( 'fontText2' );



            $('td:eq(8)', nRow).addClass( 'alignRight' );

            $('td:eq(9)', nRow).addClass( 'fontText2red' );

            $('td:eq(10)', nRow).addClass( 'alignRight' );

            $('td:eq(11)', nRow).addClass( 'alignRight' );

            

            

          }



        },



        "processing": true,

        "serverSide": true,

        "search" : false,

        ajax: {

          url: base_urlx + "Rfacturas/loadFiltroEntrelazado",

          type: "GET",

          data: {

            buscadorx: $("#buscador").val(),

            estatusx: $("#bestatus").val(),

          },
          
        },



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();



        //alert("idcliente:"+data[12]);

        showContacto(data[12]);



        $("#titulo").html("Enviar factura: "+data[6]);



       idClientex = data[12];

        idCotizacionx = data[11];

        folFact = data[13];



        $("#contacto3").val("");



        //showDatosfactura(idCotizacionx);





        $("#dfactura").html('<label style="color:red;">Factura</label><br><a href="'+base_urlx+'tw/php/facturas/'+folFact+'.pdf" target="_blank" style="color:red; font-weight:bold; font-size17px;" ><i style="color:red; font-weight:bold; font-size17px;" class="fa fa-file-pdf-o"></i> '+folFact+'</a>');

        $("#vercotizacion").html('<a href="'+base_urlx+'tw/php/facturas/fact'+data[12]+'.pdf" target="_blank" style="color:red; font-weight: bold; font-size: 15px;"> <i class="fa fa-eye" style="color:red; font-weight: bold; font-size: 15px;"></i> Ver factura</a>')

        $("#datos_cfdi").html('<i class="fa fa-file" style="color:darkblue;" ></i><a href="'+base_urlx+'/tw/php/facturas_ppd/'+folFact+'.pdf" target="_blank" style="color:darkblue;"> '+folFact+'</a> - '+data[6]);



    } );
}



function loadFiltroAll(){



  if ( table !="" ) {



    $('#my-table').DataTable().destroy();

    $("#folio").val("");



  }



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

        "search":         "Buscar por descripcion:",

        "paginate": {

            "first":      "Primero",

            "last":       "Ultimo",

            "next":       "Siguiente",

            "previous":   "Anterior"

        }

        },



        dom: '<"top" pli>rt',



        buttons: [ 'copy', 'excel' , 'csv'],

        "order": [  [ 5, "desc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            /* Append the grade to the default row class name */

            if ( true ) // your logic here

          {



            $(nRow).addClass( 'customFont' );



            $('td:eq(0)', nRow).addClass( 'alignCenter' );

            $('td:eq(1)', nRow).addClass( 'alignCenter' );



            $('td:eq(2)', nRow).addClass( 'fontText2center' );



            $('td:eq(3)', nRow).addClass( 'alignCenter' );

            $('td:eq(4)', nRow).addClass( 'alignCenter' );

            $('td:eq(5)', nRow).addClass( 'alignCenter' );

            $('td:eq(7)', nRow).addClass( 'fontText2' );



            $('td:eq(8)', nRow).addClass( 'alignRight' );

            $('td:eq(9)', nRow).addClass( 'fontText2red' );

            $('td:eq(10)', nRow).addClass( 'alignRight' );

            $('td:eq(11)', nRow).addClass( 'alignRight' );

            

            

          }



        },



        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Rfacturas/loadFiltroAll?buscar="+$("#buscador").val() ,



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();



        //alert("idcliente:"+data[12]);

        showContacto(data[12]);



        $("#titulo").html("Enviar factura: "+data[6]);



       idClientex = data[12];

        idCotizacionx = data[11];

        folFact = data[13];

        tipox = data[14];



        $("#contacto3").val("");



        //showDatosfactura(idCotizacionx);





        $("#dfactura").html('<label style="color:red;">Factura</label><br><a href="'+base_urlx+'tw/php/facturas/'+folFact+'.pdf" target="_blank" style="color:red; font-weight:bold; font-size17px;" ><i style="color:red; font-weight:bold; font-size17px;" class="fa fa-file-pdf-o"></i> '+folFact+'</a>');

        $("#vercotizacion").html('<a href="'+base_urlx+'tw/php/facturas/fact'+data[12]+'.pdf" target="_blank" style="color:red; font-weight: bold; font-size: 15px;"> <i class="fa fa-eye" style="color:red; font-weight: bold; font-size: 15px;"></i> Ver factura</a>')

        $("#datos_cfdi").html('<i class="fa fa-file" style="color:darkblue;" ></i><a href="'+base_urlx+'/tw/php/facturas_ppd/'+folFact+'.pdf" target="_blank" style="color:darkblue;"> '+folFact+'</a> - '+data[6]);



    } );



}



////////////********** BUSCAR POR ESTATUS 



function loadFiltroEstatus(){



  if ( table !="" ) {



    $('#my-table').DataTable().destroy();

    $("#folio").val("");



  }



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

        "search":         "Buscar por descripcion:",

        "paginate": {

            "first":      "Primero",

            "last":       "Ultimo",

            "next":       "Siguiente",

            "previous":   "Anterior"

        }

        },



        dom: '<"top" pli>rt',



        buttons: [ 'copy', 'excel' , 'csv'],

        "order": [  [ 5, "desc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            /* Append the grade to the default row class name */

            if ( true ) // your logic here

          {



            $(nRow).addClass( 'customFont' );



            $('td:eq(0)', nRow).addClass( 'alignCenter' );

            $('td:eq(1)', nRow).addClass( 'alignCenter' );



            $('td:eq(2)', nRow).addClass( 'fontText2center' );



            $('td:eq(3)', nRow).addClass( 'alignCenter' );

            $('td:eq(4)', nRow).addClass( 'alignCenter' );

            $('td:eq(5)', nRow).addClass( 'alignCenter' );

            $('td:eq(7)', nRow).addClass( 'fontText2' );



            $('td:eq(8)', nRow).addClass( 'alignRight' );

            $('td:eq(9)', nRow).addClass( 'fontText2red' );

            $('td:eq(10)', nRow).addClass( 'alignRight' );

            $('td:eq(11)', nRow).addClass( 'alignRight' );

            

            

          }



        },



        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Rfacturas/loadFiltroEstatus?estatus="+$("#bestatus").val() ,



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();



        //alert("idcliente:"+data[12]);

        showContacto(data[12]);



        $("#titulo").html("Enviar factura: "+data[6]);



       idClientex = data[12];

        idCotizacionx = data[11];

        folFact = data[13];



        $("#contacto3").val("");



        //showDatosfactura(idCotizacionx);





        $("#dfactura").html('<label style="color:red;">Factura</label><br><a href="'+base_urlx+'tw/php/facturas/'+folFact+'.pdf" target="_blank" style="color:red; font-weight:bold; font-size17px;" ><i style="color:red; font-weight:bold; font-size17px;" class="fa fa-file-pdf-o"></i> '+folFact+'</a>');

        $("#vercotizacion").html('<a href="'+base_urlx+'tw/php/facturas/fact'+data[12]+'.pdf" target="_blank" style="color:red; font-weight: bold; font-size: 15px;"> <i class="fa fa-eye" style="color:red; font-weight: bold; font-size: 15px;"></i> Ver factura</a>')

        $("#datos_cfdi").html('<i class="fa fa-file" style="color:darkblue;" ></i><a href="'+base_urlx+'/tw/php/facturas_ppd/'+folFact+'.pdf" target="_blank" style="color:darkblue;"> '+folFact+'</a> - '+data[6]);



    } );



}



////////************************ CANCELAR FACTURA



function showPDFfactura(idfacturax,tipo_doc){



      if( tipo_doc == 1 ) {



          $.ajax({



            type: "POST",

            dataType: "json",

            url: base_urlx+"tw/php/pdf_acuse_cancelacion.php",

            data:{ 



                idfactura:idfacturax



              },

            cache: false,

            success: function(result)

            {



              window.open(base_urlx+"tw/php/facturas_canceladas/cancelacion_"+result+".pdf", "_blank");

              //alert("La factura se cancelo con exito");

              table.ajax.reload();

              CierraPopup();



            }



          }); 



      }else if( tipo_doc == 4 ) {



        $.ajax({



            type: "POST",

            dataType: "json",

            url: base_urlx+"tw/php/pdf_acuse_cancelacion_sustitucion.php",

            data:{ 



                idfactura:idfacturax



              },

            cache: false,

            success: function(result)

            {



              window.open(base_urlx+"tw/php/facturas_canceladas/cancelacion_"+result+".pdf", "_blank");

              //alert("La factura se cancelo con exito");

              table.ajax.reload();

              CierraPopup();



            }



          }); 



      }



      





}



function cancelarFact(){



    if ( idCotizacionx > 0 ) {



      x = confirm("¿Realmente deseas cancelar la factura "+folFact+"?");



      verificar = 0;



      if ( $("#ocancelacion").val() == 1 ) {



        if ( $("#lista_factura").val() > 0 ){



          verificar = 0;



        }else{



          alert("Alerta, antes debes seleccionar una factura valida para sustituir");

          verificar = 1;



        }



      }



      if ( verificar == 0 ) {





        $("#btn_cancelar").prop("disabled", true);

        $("#btn_cancelar").html("Cancelando...");



        if (x){



          $.ajax({

                type: "POST",

                dataType: "json",

                url: base_urlx+"tw/php/cancelar_factura.php",

                //url: base_urlx+"tw/php/prueba_cancelar_factura.php",

                data:{ 



                  idfact:idCotizacionx,

                  documento:tipox,

                  motivox:$("#ocancelacion").val(),

                  idfacturax:$("#lista_factura").val(),

                  obsx:$("#obs").val(),

                  foliox:folFact,

                  textofactura:$('select[name="lista_factura"] option:selected').text()



                },

                cache: false,

                success: function(result)

                {



                  if ( result == 0) {



                    showPDFfactura(idCotizacionx,tipox);



                    //alert(result);



                  }else{



                    //alert("Error, favor de intentarlo nuevamente de no poder cancelarlo comuniquese con el administrador del portal");



                    alert(result);



                  }



                  $("#btn_cancelar").prop("disabled", false);

                  $("#btn_cancelar").html("Cancelar factura");

     

                }



          }).fail( function( jqXHR, textStatus, errorThrown ) {





                detectarErrorJquery(jqXHR, textStatus, errorThrown);



          });



        }



      }



    }else{







    }



} 



////////////***************** REFACTURAR LAS NO TIMBRADAS



function showDatosfactura(idfacturax){



  /*if( idcliente_fact == 21 ) {



    $("#namefactura").css("display", "");



  }else{



    $("#namefactura").css("display", "none");



  }*/



  $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rfacturas/showDatosfactura/",

            data:{ idfact:idfacturax },

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





/////////////****************************   CANCELACION 01 BUSCAR CFDI



function loadFiltroCancelar(){



  $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rfacturas/loadFiltroCancelar/",

            data:{ buscarx:$("#buscador_cancelar").val() },

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  var creaOption=""; 



                  $.each(result, function(i,item){

                      data0=item.id;//idfolio de factura no iID de factura 

                      data1=item.uuid;//id

                      data2=item.foliox;//nombre

                      data3=item.total;



                      creaOption=creaOption+'<option value="'+data0+'">'+data2+' | '+formatNumber(data3)+' | '+data1+' </option>'; 

                  }); 



                  $("#lista_factura").html(creaOption);

                  //$("#cliente").val(0).trigger('change');

                  

              }else{



                $("#lista_factura").html("<option> Sin facturas asignadas </option>");



              }



 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



}





function vetFactura(){



  separar=$('#lista_factura option:selected').html().split('|');



  window.open(base_urlx+"tw/php/facturas/"+separar[0].trim()+".pdf", "_blank");



}



function mostrarFactura(idmotivox){



  if ( idmotivox == 1 ) {



    $("#select_factura").css("display", "");



  }else{



    $("#select_factura").css("display", "none");



  }



}





function verEstatus(idfacturax,doc){



  $('#btn_estatus').click();



  $("#est_cfdi").html("Obteniendo información...");



        $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"tw/php/estatus_cfdi.php",

              data:{ 



                idcfdi:idfacturax,

                tdocumento:doc



              },

              cache: false,

              success: function(result)

              {



                if ( result ) {



                  //alert(result.Estado);



                  $("#est_cfdi").html("Estatus actual: "+result.Estado);

                  //$("#tcancelacion").html("Tipo de cancelacion:"+result[2]);

                  

                  //Esto simula un click sobre el botón close de la modal, por lo que no se debe preocupar por qué clases agregar o qué clases sacar.

                  //$('.modal-backdrop').remove();//eliminamos el backdrop del modal



                }else{



                  alert("Error, favor de intentarlo nuevamente");                



                }

   

              }



        }).fail( function( jqXHR, textStatus, errorThrown ) {





              detectarErrorJquery(jqXHR, textStatus, errorThrown);



        });



}


function showExcelFiltrado() {  

  $.ajax({

    type: "POST",

    dataType: "json",

    url: base_urlx + "tw/php/crear_excel_facturas.php",

    data: { select_estatusx: $("#bestatus").val(), inputx: $("#buscador").val() },

    cache: false,

    success: function (result) {

      if (result) {

        window.location.href = base_urlx + "tw/php/reporte/reporte_facturas.xlsx";


      } else {
        alert('No se pudo generar excel');
      }
    }
  });
  //alert(select_estatusx);
}

function convertirAMayusculas() {
  var input = document.getElementById('buscador');
  input.value = input.value.toUpperCase();
}




function cerrarSesion(){



  var x = confirm("¿Realmente deseas cerrar la sesión?");



  if( x==true ){



    window.location.href = base_urlx+"Login/CerrarSesion/";

    

  }



}

