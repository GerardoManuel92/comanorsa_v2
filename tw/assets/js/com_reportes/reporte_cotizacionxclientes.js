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

$("#btnExcel").css("visibility","hidden");

function formatNumber(num) {

  var numStr = num.toString();
  var parts = numStr.split('.');

  var integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
 
  var decimalPart = parts[1] ? '.' + parts[1].substring(0, 2) : '.00';

  return '$' + integerPart + decimalPart;
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

	$("#btnExcel").css("visibility","visible");

	  if ( table !="" ) {

	    $('#my-table').DataTable().destroy();

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

	        "search":         "Buscar en la tabla por:",

	        "paginate": {

	            "first":      "Primero",

	            "last":       "Ultimo",

	            "next":       "Siguiente",

	            "previous":   "Anterior"

	        }

	        },



	        dom: '<"top" fpli>rt',



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

	        //"serverSide": true,

	        "search" : false,

	        "ajax": base_urlx+"Rcotizacionesxcliente/loadProductos?idcliente="+$("#cliente").val(),

          "columns": [

          
          { data: "ACCION" },
          { data: "CANTIDAD" },
          { data: "CLAVE" },
          { data: "DESCRIPCION" },
          { data: "MARCA" }

        ],


	      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],


	        "scrollY": 450,

	        "scrollX": true

	  	});

	  	$('#my-table tbody').on('click', 'tr', function () {

        	var data = table.row( this ).data();

        	clavex= data["CLAVE"];
        	descripx= data["DESCRIPCION"];
	        idpartex= data["IDPARTE"];

	       
	        $("#descrip_producto").html("<strong>"+clavex+"</strong> | "+descripx);


	    } );

	  	

}

function showexcel() {
	var inputSearch = $("#my-table_filter input[type='search']");

	// Obtiene el valor actual del input de búsqueda
	var valorSearch = inputSearch.val();
  /* alert( $("#cliente").val()); */

	// Hacer algo con el valor obtenido
	/* console.log("Valor del input de búsqueda:", valorSearch); */

	$.ajax({
		type: "POST",

		dataType: "json",

		url: base_urlx + "tw/php/crear_excel_cotizacion_x_cliente.php",

		data: {
			clientex: $("#cliente").val(),			
			inputx: valorSearch,
		},

		cache: false,

		success: function (result) {
			if (result) {
				window.location.href = base_urlx + "tw/php/reporte/reporte_cotizacion_clientes.xlsx";
        alert("Creando excel");
			} else {
				alert("No se pudo generar excel");
			}
		},
	});
}


function verEstatus(idpartex){


	$("#lista_ventas").html("");


	$('#btn_estatus').click();


        $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"Rcotizacionesxcliente/lista_ventaxproducto",

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

                    var folioX;
                    var inicio = 10000;
                    var nuevo = parseInt(inicio)+parseInt(item.folio);
                                         
                    switch (nuevo.toString().length) {
                        case 5:
                            folioX = "ODV00" + nuevo;
                            break;

                        case 6:
                            folioX = "ODV0" + nuevo;
                            break;

                        case 7:
                            folioX = "ODV" + nuevo;
                            break;

                        default:
                            folioX = "s/asignar";
                            break;
                    }



                		creaOption+='<p> <a href="'+base_urlx+'tw/php/cotizaciones/cot'+item.fol_factura+'.pdf" target="_blank" style="color:black; font-size: 17px;">'+folioX+'</a> - '+item.cantidad+' '+item.unidad+'  |  <strong style="font-size:16px;">'+formatNumber(item.costo)+' mxn</strong></p>';


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