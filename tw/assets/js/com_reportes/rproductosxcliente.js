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

$(".select2").select2();
$(".select2-placeholer").select2({

      allowClear: true
});

var table="";
var idpartex=0;
var clavex="";
var descripx="";
showCliente();


function showCliente(){



  	$.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"AltaCotizacion/showCliente/",

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

                  $("#cliente").val(0);



              }else{



                 $("#cliente").html("<option value='0'>Sin categorias</option>");



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



}


function buscarxCliente(){

	

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

	        "search":         "Buscar en la tabla por:",

	        "paginate": {

	            "first":      "Primero",

	            "last":       "Ultimo",

	            "next":       "Siguiente",

	            "previous":   "Anterior"

	        }

	        },



	        dom: '<"top" fpl>rt',



	        buttons: [ 'copy', 'excel' , 'csv'],

	        "order": [  [ 1, "desc" ] ],



	        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

	            /* Append the grade to the default row class name */

	            if ( true ) // your logic here

	          {



	            $(nRow).addClass( 'customFont' );



	            $('td:eq(0)', nRow).addClass( 'alignCenter' );

	            $('td:eq(1)', nRow).addClass( 'alignRight' );
	            $('td:eq(2)', nRow).addClass( 'alignCenter' );
	            $('td:eq(4)', nRow).addClass( 'alignCenter' );

	            
	            

	          }



	        },

	        "processing": true,

	        "serverSide": true,

	        "search" : false,

	        "ajax": base_urlx+"Rproductosxcliente/loadPartidas?idcliente="+$("#cliente").val(),


	      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],


	        "scrollY": 450,

	        "scrollX": true

	  	});

	  	$('#my-table tbody').on('click', 'tr', function () {

        	var data = table.row( this ).data();

        	clavex= data[2];
        	descripx= data[3];
	        idpartex= data[5];

	       
	        $("#descrip_producto").html("<strong>"+clavex+"</strong> | "+descripx);


	    } );

	  	

}


function verEstatus(idpartex){


	$("#lista_ventas").html("");


	$('#btn_estatus').click();


        $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"Rproductosxcliente/lista_ventaxproducto",

              data:{ 

                idproducto:idpartex,
                idcli:$("#cliente").val()

              },

              cache: false,

              success: function(result)

              {



                if ( result != null ) {

                	creaOption='';

                	$.each(result, function(i,item){


                		creaOption+='<p> <a href="'+base_urlx+'tw/php/facturas/'+item.fol_factura+'.pdf" target="_blank" style="color:black; font-size: 17px;">'+item.fol_factura+'</a> - '+item.cantidad+' '+item.unidad+'  |  <strong style="font-size:16px;">'+formatNumber(item.costo)+' mxn</strong></p>';


                	});


                	$("#lista_ventas").html(creaOption);

                }else{



                  alert("Error, favor de intentarlo nuevamente");                



                }

   

              }



        }).fail( function( jqXHR, textStatus, errorThrown ) {





              detectarErrorJquery(jqXHR, textStatus, errorThrown);



        });



}
