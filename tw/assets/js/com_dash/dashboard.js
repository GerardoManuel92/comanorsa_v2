
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

$(document).ready(function() {


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

        "order": [  [ 3, "desc" ] ],

        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            /* Append the grade to the default row class name */

            if ( true ) // your logic here

              {



                $(nRow).addClass( 'customFont' );



                

                /*$('td:eq(5)', nRow).addClass( 'alignCenter' ).addClass( 'color_compras' ).addClass( 'bgcolor_compras' );



                $('td:eq(2)', nRow).addClass( 'alignCenter' ).addClass( 'bgdocumento' ).addClass('color_documentos');



                $('td:eq(1)', nRow).addClass( 'fontText2' );



                $('td:eq(3)', nRow).addClass( 'alignCenter' );



                $('td:eq(4)', nRow).addClass( 'alignCenter' );



                $('td:eq(6)', nRow).addClass( 'alignCenter' ).addClass( 'bgcolor_entradas' ).addClass('color_entradas');



                $('td:eq(7)', nRow).addClass( 'alignCenter' ).addClass( 'bgcolor_darkgreen').addClass('color_darkgreen');*/



                $('td:eq(2)', nRow).addClass( 'alignCenter' ).addClass( 'color_darkred' );

                $('td:eq(3)', nRow).addClass( 'alignRight' ).addClass( 'color_darkred' ).addClass( 'bgcolor_darkred' );

                

              }

        },

        "paging": false,

        "processing": true,

        //"serverSide": true,

        "search" : true,

        "ajax": base_urlx+"Dashboard/showPagosVencidos",

        "columns": [

          
          { data: "ACCION" },
          { data: "CLIENTE" },
          { data: "DIAS" },
          { data: "VENCIDO" }

        ],

      //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 300,

        "scrollX": true

    });


});


/*showPagosVencidos();

unction showPagosVencidos(){

	$("#lista_vencidas").html("Cargando facturas...");

		$.ajax({

	            type: "POST",

	            dataType: "json",

	            url: base_urlx+"Dashboard/showPagosVencidos",   

	            cache: false,

	            success: function(result)

	            {


	            	if ( result != "" ) {
	   
	                	datos='';


	                	$.each(result, function(i,item){

							datos=datos+'<div class="row"><div class="col-md-12 col-lg-12"><h4><strong><i class="fa fa-user"></i>'+item.cliente+'</strong> &nbsp; <strong style="font-size: 20px; color:red;">'+formatNumber(round(item.total))+'mxn</strong></h4><p style="font-size: 15px;">Factura:<strong ><a href="'+base_urlx+'tw/php/facturas/'+item.folio+'.pdf" target="_blank" style="color:darkblue; font-size: 17px;"> '+item.folio+'</a></strong> - '+item.fecha+'  | Credito: <strong>'+item.credito+' dias</strong> </p><p style="font-size: 15px;">Fecha vencimiento: '+item.fcobro+'  | <strong style="font-size: 17px; color:red;">Dias transcurridos: '+item.dias_transcurridos+' Dias</strong></p></div><div class="col-md-6"><button class="btn btn-success" onclick="generarExcel('+item.id+')"><i class="fa fa-file-excel-o"></i> Estado de cuenta</button> &nbsp;&nbsp;<a class="btn btn-primary" href="#" role="button">Cobrar</a></div></div><hr>';		                 	 

		                }); 

	                	$("#lista_vencidas").html(datos);

	            	}else{


	            		alert("no hay resultados...");


	            	}


	            }



		  	}).fail( function( jqXHR, textStatus, errorThrown ) {





		        detectarErrorJquery(jqXHR, textStatus, errorThrown);



		});

}*/





function generarExcel(idclientex){

  buscarx=idclientex;


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

    //$("#cliente").focus();



  }

}


function cerrarSesion(){



    var x = confirm("¿Realmente deseas cerrar la sesión?");



    if( x==true ){



      window.location.href = base_urlx+"Login/CerrarSesion/";

      

    }  



}



function facturarXml(){



	x = confirm("¿Deseas facturar?");	



	if ( x ) {



		$("#info").html("extrayendo datos...");



		$.ajax({

	            type: "POST",

	            dataType: "json",

	            url: base_urlx+"tw/php/crear_xml_facturalo_t3.php",   

	            cache: false,

	            success: function(result)

	            {



	            	if ( result != "" ) {

	   

	                	//$("#info").html( "Proceso:"+result.mensaje+"<br> UUID:"+result.cfdi['UUID'] );

	                	//+"<br> NoCertificadoSAT:"+result.cfdi.NoCertificadoSAT+"<br> CadenaOriginalSAT:"+result.cfdi.CadenaOriginalSAT+"<br> Sello:"+result.cfdi.Sello+"<br> SelloSAT:"+result.cfdi.SelloSAT+"<br> CodigoQR:"+result.cfdi.CodigoQR);



	                	datos = "";



	                	$.each(result, function(i,item){

		                      data1=item.UUID;//id

		                      

		                    datos=datos+"UUID:"+data1;   

		                }); 



	                	$("#info").html(datos);



	        			

	            	}else{



	            		alert("no hay resultados...");



	            		//$("#info").html( "Proceso:"+result.mensaje+"<br> UUID:"+result.cfdi['UUID'] );

	            			//+"<br> NoCertificadoSAT:"+result.cfdi.NoCertificadoSAT+"<br> CadenaOriginalSAT:"+result.cfdi.CadenaOriginalSAT+"<br> Sello:"+result.cfdi.Sello+"<br> SelloSAT:"+result.cfdi.SelloSAT+"<br> CodigoQR:"+result.cfdi.CodigoQR);



	            	}





	            	//alert("INFORMACION DE FACTURA");



	     

	            }



		  }).fail( function( jqXHR, textStatus, errorThrown ) {





		        detectarErrorJquery(jqXHR, textStatus, errorThrown);



		});



	}



}





function leerJson(){



	$("#info").html("extrayendo datos...");



		$.ajax({

	            type: "POST",

	            dataType: "json",

	            url: base_urlx+"tw/php/prueba_json.php",   

	            cache: false,

	            success: function(result)

	            {



	            	if ( result != "" ) {

	   

	                	//$("#info").html( "Proceso:"+result.mensaje+"<br> UUID:"+result.cfdi['UUID'] );

	                	//+"<br> NoCertificadoSAT:"+result.cfdi.NoCertificadoSAT+"<br> CadenaOriginalSAT:"+result.cfdi.CadenaOriginalSAT+"<br> Sello:"+result.cfdi.Sello+"<br> SelloSAT:"+result.cfdi.SelloSAT+"<br> CodigoQR:"+result.cfdi.CodigoQR);



	                	$.each(result, function(i,item){

		                      data1=item.mensaje;//id

		                      //data2=item.cfdi;//nombre

		                      /*data3=item.nombre;//id

		                      data4=item.comercial;//nombre

		                      creaOption=creaOption+'<option value="'+data1+'">'+data2+'-'+data3+' <strong style="color:darkblue;">'+data4+'</strong></option>';*/



		                    $("#info").html( "MENSAJE:"+data1 );



		                });





	        			

	            	}else{



	            		alert("no hay resultados...");



	            		//$("#info").html( "Proceso:"+result.mensaje+"<br> UUID:"+result.cfdi['UUID'] );

	            			//+"<br> NoCertificadoSAT:"+result.cfdi.NoCertificadoSAT+"<br> CadenaOriginalSAT:"+result.cfdi.CadenaOriginalSAT+"<br> Sello:"+result.cfdi.Sello+"<br> SelloSAT:"+result.cfdi.SelloSAT+"<br> CodigoQR:"+result.cfdi.CodigoQR);



	            	}





	            	alert("INFORMACION DE FACTURA");



	     

	            }



		  }).fail( function( jqXHR, textStatus, errorThrown ) {





		        detectarErrorJquery(jqXHR, textStatus, errorThrown);



		});



}