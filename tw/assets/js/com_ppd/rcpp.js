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

//alert("version 7.0");

function zero(n) {
 return (n>9 ? '' : '0') + n;
}

var table = '';
var fol_cpp = 0;
var idnc = 0;
var folFact = 0;

function CierraPopup() {

  $('#cerrarx').click(); //Esto simula un click sobre el botón close de la modal, por lo que no se debe preocupar por qué clases agregar o qué clases sacar.
  $('.modal-backdrop').remove();//eliminamos el backdrop del modal

}


/*$(document).ready(function() {

  ///////////primera imagen  

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
        "order": [  [ 5, "desc" ] ],

        
            if ( true ) // your logic here
	        {

	          $(nRow).addClass( 'customFont' );

	          $('td:eq(0)', nRow).addClass( 'alignCenter' );
	          $('td:eq(1)', nRow).addClass( 'alignCenter' );

	          $('td:eq(2)', nRow).addClass( 'fontText2center' );

	          $('td:eq(3)', nRow).addClass( 'alignCenter' );
            $('td:eq(4)', nRow).addClass( 'alignCenter' );
	          $('td:eq(5)', nRow).addClass( 'alignCenter' );
	          //$('td:eq(7)', nRow).addClass( 'fontText2' );

	          $('td:eq(7)', nRow).addClass( 'alignRight' );
	          $('td:eq(8)', nRow).addClass( 'alignCenter' );
	          
	          
	        }

        },

        "processing": true,
        "serverSide": true,
        "search" : false,
        "ajax": base_urlx+"Rcpp/loadPartidas?buscar="+$("#buscador").val(),

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

        idClientex = data[10];
        //idCotizacionx = data[11];
        //folFact = data[13];

        //$("#dfactura").html('<label style="color:red;">Factura</label><br><a href="'+base_urlx+'tw/php/facturas/'+folFact+'.pdf" target="_blank" style="color:red; font-weight:bold; font-size17px;" ><i style="color:red; font-weight:bold; font-size17px;" class="fa fa-file-pdf-o"></i> '+folFact+'</a>');

        //$("#vercotizacion").html('<a href="'+base_urlx+'tw/php/facturas/fact'+data[12]+'.pdf" target="_blank" style="color:red; font-weight: bold; font-size: 15px;"> <i class="fa fa-eye" style="color:red; font-weight: bold; font-size: 15px;"></i> Ver factura</a>')

    } );

    //showClientes();
    //showCancelacion();


} );*/

loadFiltroAll();

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
	          //$('td:eq(7)', nRow).addClass( 'fontText2' );

	          $('td:eq(7)', nRow).addClass( 'alignRight' );
	          $('td:eq(8)', nRow).addClass( 'alignCenter' );
	          
	          
	        }

        },

        "processing": true,
        "serverSide": true,
        "search" : false,
        "ajax": base_urlx+"Rcn/loadPartidas?buscar="+$("#buscador").val() + "&estatusx=" + $("#bestatus").val(),

      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

        "scrollY": 450,
        "scrollX": true
    });

    /////////////********* CLICK 
    $('#my-table tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();

        //alert("idcliente:"+data[12]);
        showContacto(data[10]);

        $("#titulo").html("Enviar factura: "+data[6]);

        idClientex = data[10];
        idnc = data[9];
        fol_cpp = data[11];

        //alert(fol_cpp);

        //$("#dfactura").html('<label style="color:red;">Factura</label><br><a href="'+base_urlx+'tw/php/facturas/'+folFact+'.pdf" target="_blank" style="color:red; font-weight:bold; font-size17px;" ><i style="color:red; font-weight:bold; font-size17px;" class="fa fa-file-pdf-o"></i> '+folFact+'</a>');

        //$("#vercotizacion").html('<a href="'+base_urlx+'tw/php/facturas/fact'+data[12]+'.pdf" target="_blank" style="color:red; font-weight: bold; font-size: 15px;"> <i class="fa fa-eye" style="color:red; font-weight: bold; font-size: 15px;"></i> Ver factura</a>')

    } );

    //showClientes();
    showCancelacion();

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

////////************************ CANCELAR FACTURA

function showPDFfactura(idfacturax){

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/pdf_acuse_cancelacion_nc.php",
          data:{ 

              idfactura:idfacturax

            },
          cache: false,
          success: function(result)
          {

            window.open(base_urlx+"tw/php/facturas_canceladas_nc/cancelacion_"+result+".pdf", "_blank");
            //alert("La factura se cancelo con exito");
            table.ajax.reload();
            CierraPopup();

          }

      }); 


}

function cancelarFact(){

    if ( idnc > 0 ) {

      x = confirm("¿Realmente deseas cancelar la NOTA DE CREDITO "+fol_cpp+"?");

      

      if (x){

      	$("#btn_cancelar").prop("disabled", true);
      	$("#btn_cancelar").html("Cancelando...");

        $.ajax({
              type: "POST",
              dataType: "json",
              url: base_urlx+"tw/php/cancelar_nc.php",
              data:{ 

                idfact:idnc,
                motivox:$("#ocancelacion").val(),
                obsx:$("#obs").val(),
                foliox:fol_cpp

              },
              cache: false,
              success: function(result)
              {

                if ( result ) {

                  showPDFfactura(idnc);

                  //alert("La factura "+fol_cpp+" se cancelo con exito");
                  //table.ajax.reload();
                  //CierraPopup();


                }else{

                  alert(result);                

                }

                $("#btn_cancelar").prop("disabled", false);
                $("#btn_cancelar").html("Cancelar factura");
   
              }

        }).fail( function( jqXHR, textStatus, errorThrown ) {


              detectarErrorJquery(jqXHR, textStatus, errorThrown);

        });

      }

    }else{



    }

}



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
                url: base_urlx+"Rremisiones/enviarCorreo/",
                data:{ idcli:idClientex, idcot:idCotizacionx, destinatario:correox, copia:copiax, otro_correo:correox2 },
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

  if ( fol_cpp != "" ) {

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"tw/php/zip_nc.php",
            data:{folio:fol_cpp},
            cache: false,
            success: function(result)
            {

              if ( result ) {

                window.open(base_urlx+"tw/php/zip_facturas_nc/"+fol_cpp+".zip" , "_blank");

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

/*******GENERAR EXCEL ***************/
function showExcel() {


  $.ajax({

    type: "POST",

    dataType: "json",

    url: base_urlx + "tw/php/crear_excel_nota_credito.php",

    data: { inputx: $("#buscador").val(),  statusx : $("#bestatus").val()},

    cache: false,

    success: function (result) {

      if (result) {

        window.location.href = base_urlx + "tw/php/reporte/reporte_nota_credito.xlsx";


      } else {
        alert('No se pudo generar excel');
      }
    }
  });
}

////////////***** COVERTIR A MAYUSCULA LO QUE SE INGRESE EN EL INPUT */

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


