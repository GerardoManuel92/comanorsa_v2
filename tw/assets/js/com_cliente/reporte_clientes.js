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



var idcliente = 0;

var idnombre = "";

var iddireccion = "";



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


showBancos();

////////////***************** SHOW CUENTAS BANCARIAS

function showBancos(){

    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rclientes/showBancos/",

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  var creaOption=""; 



                  $.each(result, function(i,item){

                      data1=item.id;//id

                      data2=item.rfc;//nombre

                      data3=item.comercial;

                      

                      creaOption=creaOption+'<option value="'+data1+'">'+data2+' - '+data3+'</option>'; 

                  }); 



                  $("#lista_banco").html(creaOption);

                  //$("#regimen").val(0);



              }else{



                 $("#lista_banco").html("<option value='0'>Sin bancos almacenados</option>");



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });

}

function eliminarBanco(idcuenta){

  x=confirm("¿Realmente deseas eliminar esta cuenta bancaria?");

  if(x){

    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rclientes/eliminarBanco/",

            data:{idcuentax:idcuenta},

            cache: false,

            success: function(result)

            {

              if ( result ) {

                bancosxClientes();

              }else{

                alert("Error, favor de intentarlo nuevamente");

              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });

  }

}



function bancosxClientes(){

  $("#view_banco").html("");

  $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rclientes/bancosxClientes/",

            data:{idclientex:idcliente},

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  var creaOption=""; 



                  $.each(result, function(i,item){

                      data1=item.id;//id

                      data2=item.cuenta;//nombre

                      data3=item.rfc;
                      
                      data4=item.comercial;

                      creaOption=creaOption+'<div class="col-md-6 col-lg-6"><div class="card"><div class="card-header"><div class="card-photo"><img class="img-circle avatar" src="'+base_urlx+'comanorsa/banco2.png" alt="" title=""></div><div class="card-short-description"><h5><span class="user-name"><a href="#/">RFC: '+data3+' - '+data4+' </a></span><a href="javascript:eliminarBanco('+data1+')"><span class="badge badge-danger"><i class="fa fa-trash"></i></span></a></h5><p>CUENTA: '+data2+'</p></div></div></div></div>'; 

                  }); 



                  $("#view_banco").html(creaOption);

                  //$("#regimen").val(0);



              }else{



                 $("#view_banco").html("<div class='col-md-12'><h4>Sin cuentas bancarias...</h4></div>");



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });

  


}




function altaCuentas(){

  if( $("#cuenta").val()=="" || $("#cuenta").val()==null ){

    alert("Alerta,favor de agregar una cuenta valida");
    $("#cuenta").focus();

  }else{

    $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"Rclientes/altaCuentas/",

              data:{

                idbancox:$("#lista_banco").val(),
                cuentax:$("#cuenta").val(),
                idclientex:idcliente

              },

              cache: false,

              success: function(result)

              {

                if ( result>0 ) {

                  bancosxClientes();

                }else{

                  alert("Error, la cuenta bancaria no pudo ser agregada favor de intentarlo nuevamente");

                }

   

              }


      }).fail( function( jqXHR, textStatus, errorThrown ) {





          detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });

  }

}

//////


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

        "search":         "Buscar por cliente, comercial o rfc:",

        "paginate": {

            "first":      "Primero",

            "last":       "Ultimo",

            "next":       "Siguiente",

            "previous":   "Anterior"

        }

        },



        dom: '<"top"B fpli>rt',



        buttons: [ /* 'copy', 'excel' , 'csv' */],

        "order": [  [ 2, "desc" ] ],



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

	          $('td:eq(6)', nRow).addClass( 'fontText2' );



	          $('td:eq(7)', nRow).addClass( 'alignRight' );

	          

	          $('td:eq(9)', nRow).addClass( 'alignRight' );

	          $('td:eq(10)', nRow).addClass( 'alignRight' );

	          

	          

	        }



        },

        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Rclientes/loadPartidas" ,



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();





        idcliente = data[10];

        idnombre = data[11];

        iddireccion = data[7];

        $("#titulo_modal").html('<strong style="color:white;">Cuentas - '+data[3]+'</strong>');

        //alert(idnombre);



        showDireccion(idcliente);

        bancosxClientes();

        /* exportarInfo(idcliente); */



    } );





} );



function showContactos(idcliex2){



  if ( idcliex2 > 0 ) {



    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rclientes/showContactos/",

            data:{ idcli:idcliex2 },

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  $("#ccliente").html(idnombre);

                  //$("#cdireccion").html(iddireccion);



                  var creaOption=""; 



                  $.each(result, function(i,item){

                    contacto= item.contacto;

                    puesto= item.puesto;

                    telefono= item.telefono;

                    correo= item.correo;

                    /*nombre= item.nombre;

                    calle= item.calle;

                    exterior= item.exterior;

                    interior= item.interior;

                    colonia= item.colonia;

                    municipio= item.municipio;

                    estado= item.estado;

                    cp= item.cp;

                    referencia= item.referencia;*/



                    creaOption=creaOption+'<li><div class="user-avatar"><img title="" alt="" class="img-circle avatar" src="'+base_urlx+'comanorsa/usuario.png"></div><div class="user-detail"><h5>'+contacto+'</h5><p>'+puesto+'</p><p><a href="tel:'+telefono+'"><i class="fa fa-phone"></i> '+telefono+'</a></p><p><a href="mailto:'+correo+'"><i class="fa fa-envelope"></i> '+correo+'</a></p></div></li>'; 



                  }); 



                  $("#lista_contacto").html(creaOption);

                  

              }else{



                 $("#lista_contacto").html("");



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



  }else{







  }



}



function showDireccion(idcliex){



  $("#cdireccion").html("");

  $("#lista_contacto").html("");

  $("#ccliente").html("<p><strong style='color:red;'>Sin datos</strong></p>");

  $("#credito").html("");
  $("#limite").html("");
  $("#fpago").html("");
  $("#ucfdi").html("");



  if ( idcliex > 0 ) {

    

    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rclientes/showDireccion/",

            data:{ idcli:idcliex },

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  var creaOption="";

                  contador = 0;

                  creditox="";
                  limitex="";
                  fpagox="";
                  cfdix=""; 

                  $.each(result, function(i,item){



                    contador +=1;

                    

                    //creaOption=creaOption+'<li><div class="user-avatar"><img title="" alt="" class="img-circle avatar" src="'+base_urlx+'comanorsa/usuario.png"></div><div class="user-detail"><h5>'+contacto+'</h5><p>'+puesto+'</p><p><a href="tel:'+telefono+'"><i class="fa fa-phone"></i>'+telefono+'</a></p><p><a href="mailto:'+correo+'"><i class="fa fa-envelope"></i>'+correo+'</a></p></div></li>'; 

                    creaOption += "<strong>Direccion"+contador+":</strong><br>"+item.direccion+"<br>"; 

                    creditox=item.credito;
                    limitex=item.limite;
                    fpagox=item.fpagox;
                    cfdix=item.cfdix;



                  }); 


                  $("#cdireccion").html(creaOption);

                  $("#credito").html(creditox+" Dias");
                  $("#limite").html( formatNumber(limitex)+" mxn");
                  $("#fpago").html(fpagox);
                  $("#ucfdi").html(cfdix);

                  showContactos(idcliex);

                  

              }else{



                 $("#cdireccion").html("");



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



  }else{







  }



}


function showExcel(){

  var inputSearch = $("#my-table_filter input[type='search']");

	// Obtiene el valor actual del input de búsqueda
	var valorSearch = inputSearch.val();

  $.ajax({

		type: "POST",

		dataType: "json",

		url: base_urlx + "tw/php/crear_excel_clientes.php",

		data: { inputx : valorSearch},

		cache: false,

		success: function (result) {

			if (result) {

				window.location.href = base_urlx + "tw/php/reporte/reporte_clientes.xlsx";
				

			} else {
				alert('No se pudo generar excel');
			}
		}
	});
}

function exportarInfo(idcliex){

  var inputSearch = $("#my-table_filter input[type='search']");

	// Obtiene el valor actual del input de búsqueda
	var valorSearch = inputSearch.val();

  $.ajax({

		type: "POST",

		dataType: "json",

		url: base_urlx + "tw/php/crear_excel_detalle_cliente.php",

		data: { idclientex : idcliex},

		cache: false,

		success: function (result) {

			if (result) {

				window.location.href = base_urlx + "tw/php/reporte/CLIENTES/reporte_cliente '"+idclientex+"'.xlsx";
				

			} else {
				alert('No se pudo generar excel');
			}
		}
	});
}



function cerrarSesion(){



  var x = confirm("¿Realmente deseas cerrar la sesión?");



  if( x==true ){



    window.location.href = base_urlx+"Login/CerrarSesion/";

    

  }



}

