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



var idcliente = 0;

var idnombre = "";

var iddireccion = "";

var idlimite=0;

var iddias=0;



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

        "search":         "Buscar por proveedor, comercial o rfc:",

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



            $('td:eq(7)', nRow).addClass( 'alignCenter' );

            

            $('td:eq(8)', nRow).addClass( 'alignCenter' );

            $('td:eq(9)', nRow).addClass( 'alignCenter' );       

            

          }



        },

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Rproveedores/loadPartidas" ,



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

        idlimite= data[9];

        iddias= data[8];

        $("#titulo_modal").html('<strong style="color:white;">Cuentas - '+data[2]+'</strong>');

        showContactos(idcliente);

        bancosxProveedor();

        



    } );





} );

showBancos();

function showBancos(){

  $.ajax({

          type: "POST",

          dataType: "json",

          url: base_urlx+"Rproveedores/showBancos/",

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


            }else{

               $("#lista_banco").html("<option value='0'>Sin bancos almacenados</option>");

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

              url: base_urlx+"Rproveedores/altaCuentas/",

              data:{

                idbancox:$("#lista_banco").val(),
                cuentax:$("#cuenta").val(),
                idProveedor:idcliente

              },

              cache: false,

              success: function(result)

              {

                if ( result>0 ) {

                  bancosxProveedor();

                }else{

                  alert("Error, la cuenta bancaria no pudo ser agregada favor de intentarlo nuevamente");

                }

   

              }


      }).fail( function( jqXHR, textStatus, errorThrown ) {





          detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });

  }

}

function bancosxProveedor(){

  
  $("#view_banco").html("");

  $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Rproveedores/bancosxProveedor/",
            data:{
              idProveedor:idcliente
            },
            cache: false,

            success: function(result)
            {

              if ( result != null ) {
                  var creaOption=""; 

                  $.each(result, function(i,item){
                      data1=item.id;//id
                      data2=item.cuenta;
                      data3=item.rfc;
                      data4=item.comercial;
                      creaOption=creaOption+'<div class="col-md-6 col-lg-6"><div class="card"><div class="card-header"><div class="card-photo"><img class="img-circle avatar" src="'+base_urlx+'comanorsa/banco2.png" alt="" title=""></div><div class="card-short-description"><h5><span class="user-name"><a href="#/">RFC: '+data3+' - '+data4+' </a></span><a href="javascript:eliminarBanco('+data1+')"><span class="badge badge-danger"><i class="fa fa-trash"></i></span></a></h5><p>CUENTA: '+data2+'</p></div></div></div></div>'; 

                  }); 

                  $("#view_banco").html(creaOption);

              }else{



                 $("#view_banco").html("<div class='col-md-12'><h4>Sin cuentas bancarias...</h4></div>");

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

            url: base_urlx+"Rproveedores/eliminarBanco/",

            data:{idcuentax:idcuenta},

            cache: false,

            success: function(result)

            {

              if ( result ) {

                bancosxProveedor();

              }else{

                alert("Error, favor de intentarlo nuevamente");

              }

            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {

        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

  }

}

function showContactos(idcliex){



  if ( idcliex > 0 ) {



    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rproveedores/showContactos/",

            data:{ idcli:idcliex },

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  $("#ccliente").html(idnombre);

                  $("#cdireccion").html(iddireccion);

                  $("#climite").html("Limite de credito: "+formatNumber(round(idlimite)) );

                  $("#cdias").html("Dias de credito: "+iddias);



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



                    creaOption=creaOption+'<li><div class="user-avatar"><img title="" alt="" class="img-circle avatar" src="'+base_urlx+'comanorsa/usuario.png"></div><div class="user-detail"><h5>'+contacto+'</h5><p>'+puesto+'</p><p><a href="tel:'+telefono+'"><i class="fa fa-phone"></i>'+telefono+'</a></p><p><a href="mailto:'+correo+'"><i class="fa fa-envelope"></i>'+correo+'</a></p></div></li>'; 



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

function showExcel(){

  var inputSearch = $("#my-table_filter input[type='search']");

	// Obtiene el valor actual del input de búsqueda
	var valorSearch = inputSearch.val();

  $.ajax({

		type: "POST",

		dataType: "json",

		url: base_urlx + "tw/php/crear_excel_proveedor.php",

		data: { inputx : valorSearch},

		cache: false,

		success: function (result) {

			if (result) {

				window.location.href = base_urlx + "tw/php/reporte/reporte_proveedores.xlsx";
				

			} else {
				alert('No se pudo generar excel');
			}
		}
	});
}

function retirarPro(idprov){



  x = confirm("¿Realmente deseas retirar este proveedor");



  if (x) {



      if ( idprov > 0 ) {



        $.ajax({

                type: "POST",

                dataType: "json",

                url: base_urlx+"Rproveedores/retirarPro/",

                data:{ prov:idprov },

                cache: false,

                success: function(result)

                {



                  if ( result ) {



                    location.reload();

                      

                  }else{



                    alert("Error, favor de intentarlo nuevamente");



                  }

     

                }



        }).fail( function( jqXHR, textStatus, errorThrown ) {



            detectarErrorJquery(jqXHR, textStatus, errorThrown);



        });



      }



  }else{



    alert("Error. error con el identificador del proveedor");



  }



}


function exportarInfo(idcliex){


  $.ajax({

		type: "POST",

		dataType: "json",

		url: base_urlx + "tw/php/crear_excel_detalle_proveedor.php",

		data: { idprovx : idcliex},

		cache: false,

		success: function (result) {

			if (result) {

				window.location.href = base_urlx + "tw/php/reporte/PROVEEDORES/reporte'"+idprovx+"'.xlsx";
				

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