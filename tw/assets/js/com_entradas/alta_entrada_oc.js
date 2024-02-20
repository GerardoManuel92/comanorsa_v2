//alert("version2.0");



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



var table;

var killRow = [];

var total_cot = 0;

var total_desc = 0;

var total_iva = 0;

var indexTabla = 0;

var idxt = "";

var colx = "";

var valorcosto = 0;

var valorprecio = 0;

var id_info=0;

var cantidad_info=0;

var array_info=[];



////////////********* variables de recuperacion 



var editId = 0;

var editParte = 0;

var editDescrip = "";

var cant_odc = 0;

var editUnidad = "";

var costo_odc = 0;

var editIva = 0;

var editDesc = 0;

var editSubtotal = 0;

var idFila = "";

//////************* EDITAR CELDAD



const createdCell = function(cell) {

  let original



  cell.setAttribute('contenteditable', true)

  cell.setAttribute('spellcheck', false)



  cell.addEventListener('focus', function(e) {

    original = e.target.textContent

     //alert("/ row_focus: "+indexTabla );



  })



  cell.addEventListener('blur', function(e) {

    if (original !== e.target.textContent) {

      const row = table.row(e.target.parentElement);

      //row.invalidate()******* este codigo nos ayuda si no queremos ve el cambio actual reflejado en la celda al salir de ella



      if ( colx == 0 ) {



        row.invalidate()



      }else{



      	verificar = 0;

      	cant_entrada = e.target.textContent;





      	if ( cant_entrada >= 0 && cant_odc > 0 ) {



      		restax = parseFloat(cant_entrada)-parseFloat(cant_odc);



      		//alert(restax);



      		if ( restax > 0 ) {



      			verificar = 1;

      			alert("Alerta, la cantidad de entrada no puede ser mayor a la compra");

      			row.invalidate();



      		}



      	}else{



      		verificar = 1;

      		alert("Alerta, la cantidad de entrada no es valida favor de cambiarla");

      		row.invalidate();



      	}



      	if ( verificar == 0 ) {



	                temp = table.row(idFila).data();



	                costo_odc_decimal = costo_odc.replace(/[^\d.]/g,"");



	                newsubtotal = cant_entrada*costo_odc_decimal;



	                //alert(newsubtotal);



	                temp[5] = cant_entrada;

	                temp[9] = formatNumber( round( newsubtotal) );





	                //alert("idfila: "+idFila+" / cant_entrada:"+cant_entrada+" / cant_odc: "+cant_odc);

	               



	                $('#my-table').dataTable().fnUpdate(temp,idFila,undefined,false);



	                $("#tneto").html("Calculando...");



	                setTimeout(function (){

	                    

	                    sumaTotal();              

	                              

	                }, 1000);





        }



      }

      

    }



  })

}



//////////************************** CALCULAR SUBTOTAL



function calcularSubtotal(cantx,costox,ivax){



  costo = costox.replace(/[^\d.]/g,"");



  subx = round(costo*cantx);



  return  formatNumber(subx);



  /*cdesc = parseFloat(subx)-parseFloat( subx*(descx/100) );



  subxdesc = parseFloat(subx)-parseFloat(round(cdesc));*/



}



////*** SUMA DE TOTALES

function sumaTotal(){

  //6 :ccantidad



  total_sub =0;

  total_desc =0;

  total_iva =0;



  $("#tsubtotal").html("Calculando...");

  $("#tneto").html("Calculando...");



  $('#my-table').DataTable().rows().data().each(function(el, index){

    //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria



    scant = el[5];

    scosto= el[6];

    sdesc = 0;

    siva = el[7];





    //////// CALCULAR LO SOLICITADO PARA ODC



    subtotal = round(scant)*round(scosto.replace(/[^\d.]/g,""));

    desc = round(subtotal)*(sdesc/100);

    sub_descuento = parseFloat(subtotal)-parseFloat(desc);

    iva = round(sub_descuento)*round(siva/100);



    total_sub = parseFloat(total_sub)+parseFloat(subtotal);

    total_desc = parseFloat(total_desc)+parseFloat(desc);

    total_iva = parseFloat(total_iva)+parseFloat(iva);



    //alert(el[6]);



  });



  total_neto = parseFloat(total_sub)-parseFloat(total_desc)+total_iva;



  $("#tsubtotal").html( "Subtotal: "+formatNumber(round(total_sub) ));

  $("#tneto").html('<strong style="font-weight: bold; margin-bottom: 10px;"><a href="javascript:verDetalles()" style="font-size: 11px;">(ver detalles)</a><a href="javascript:cerrarDetalles()" id="cerrar" style="display: none;"><i class="fa fa-close" style="color:red; font-weight: bold;"></i></a></strong>'+" Total: "+formatNumber(round(total_neto) ));

  $("#tneto2").html(" Total: "+formatNumber(round(total_neto)) );

  $("#tdescuento").html( "Descuento: "+formatNumber(round(total_desc) ));

  $("#tiva").html( "Iva "+formatNumber(round(total_iva) ));



}



function verDetalles(){



  $("#tdescuento").css("display","");

  $("#tiva").css("display","");

  $("#cerrar").css("display","");



}



function cerrarDetalles(){



  $("#tdescuento").css("display","none");

  $("#tiva").css("display","none");

  $("#cerrar").css("display","none");

}



$(document).ready(function() {



	////////******** MOSTRAR CLIENTES

	

	$(".select2").select2();

    $(".select2-placeholer").select2({

      allowClear: true



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

        "search":         "Buscar por descripcion:",

        /*"paginate": {

            "first":      "Primero",

            "last":       "Ultimo",

            "next":       "Siguiente",

            "previous":   "Anterior"

        }*/

        },



        dom: '<"top" >rt',



        buttons: [ 'copy', 'excel' , 'csv'],

        "order": [  [ 0, "desc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            /* Append the grade to the default row class name */

            if ( true ) // your logic here

              {



                $(nRow).addClass( 'customFont' );



                

                $('td:eq(2)', nRow).addClass( 'alignCenter' )

                $('td:eq(3)', nRow).addClass( 'alignCenter' )

                $('td:eq(4)', nRow).addClass( 'alignCenter' )

                $('td:eq(5)', nRow).addClass( 'alignCenter' ).addClass( 'color_compras' ).addClass( 'bgcolor_compras' );



                $('td:eq(6)', nRow).addClass( 'alignCenter' ).addClass( 'color_darkgreen' ).addClass( 'bgcolor_darkgreen' );

                $('td:eq(7)', nRow).addClass( 'alignRight' ).addClass( 'fontText16' );

                $('td:eq(8)', nRow).addClass( 'alignRight' ).addClass( 'fontText16' );

                $('td:eq(9)', nRow).addClass( 'alignRight' ).addClass( 'fontText16' );

                $('td:eq(10)', nRow).addClass( 'alignRight' ).addClass( 'fontText16' );

                

              }

        },

        columnDefs: [



	        { 

	          targets: [5],

	          createdCell: createdCell



	        },



            {

               targets: [8],

               data: null,

               render: function ( data, type, row, meta ) {                   

                /*return `<button class="btn btn-danger hidden-xs" type="button" title="Borrar" onclick="borrarArticulo(${row[4]})"> <i class="icon-trash"></i> </button><button class="btn btn-orange hidden-xs" type="button" title="Editar" onclick="editarArticulo(${row[4]})"> <i class="icon-pencil"></i> </button><div class="dropdown open hidden-sm hidden-md hidden-lg hidden-xl">

                    <a class="more-link" data-toggle="dropdown" href="#/" aria-expanded="true"><i class="icon-dot-3 ellipsis-icon"></i></a>

                    <ul class="dropdown-menu dropdown-menu-right">

                      <li><a href="" style="color:orange; font-weight:bold; ">Editar</a></li>

                      <li><a href="" style="color:red; font-weight:bold; ">Eliminar</a></li>

                      <li><a href="#modal_info" data-toggle="modal" style="color:blue; font-weight:bold; ">Ver info.</a> </li>

                    </ul>

                  </div>`

  

                  */



                  valor2=calcularSubtotal( data[5],data[6],data[7] );



                  return ``+valor2+``         



               }



               

            }





        ],



        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Entradaoc/loadPartidas?idoc="+$("#idoc").val(),



      //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 300,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('focusout', 'tr', function () {

        var data = table.row( this ).data();





        editId = data[9];

        cant_odc = data[5];

        costo_odc = data[6];



       



    } );





    $('#my-table').on( 'focusout', 'tbody td', function () {



      idFila = table.cell( this ).index().row;

      colx = table.cell( this ).index().column;



      //var data = table.cells( idxt, '' ).render( 'display' );

   

      //alert( "row:"+table.cell( this ).data()+" columna:"+colx );

    } );



    $('#my-table tbody').on('click', 'tr', function () {

        var datax = table.row( this ).data();

        $("#titulo_info").html(datax[1]);

        id_info=datax[9];

        cantidad_info=datax[5];

        totalx=parseFloat(cantidad_info)+parseFloat(1);

        datos_info="";

        $("#lista_info").html("");

        for (var i=1; i<cantidad_info+1; i++) {
         
          datos_info+='<div class="col-md-6 col-lg-6 col-xs-12" ><label>Añadir info</label><div class="form-group"><div class="input-group"><span class="input-group-addon">'+i+'.-</span><input type="text" id="info'+i+'" name="info'+i+'" class="form-control"></div></div></div>';

        }

        $("#lista_info").html(datos_info);

        var rowData = $('#my-table').DataTable().row(this).data();
  
        if (rowData) {
            var codc = rowData[3];
            var centrada = rowData[5];
            var idAsignarOC = rowData[10];
            var cvalor = codc + "/" + centrada + "/" + idAsignarOC;
  
            killRow = [];
            killRow.push(cvalor);
          }


    });



    table

    .buttons()

    .container()

    .appendTo( '#controlPanel' );



    $("#tneto").html("Calculando...");



    setTimeout(function (){



        sumaTotal();              

                  

    }, 1700);



});





function showPDF(idcotx){



      $.ajax({



          type: "POST",

          dataType: "json",

          url: base_urlx+"tw/php/pdf_entrada.php",

          data:{ 



              identrada:idcotx



            },

          cache: false,

          success: function(result)

          {



            window.open(base_urlx+"tw/php/entradas/entrada"+idcotx+".pdf", "_blank");

            alert("Alerta, la entrada se almaceno correctamente")

            window.location.href=base_urlx+"Rcompras";

          }



      }); 





}



function entradaParcial(){
  
  //

	x = confirm("¿Realmente deseas generar la entrada?");

	if ( x ) {
		info_parcial = new Array(); //entradas parciales

		///// crear el ARRAY de las entradas

		$('#my-table').DataTable().rows().data().each(function(el, index){
			codc = el[3]; // Entrada original
			centrada = el[5]; //Entrada ajustada
			idAsignarOC = el[10]; // Id parte asignada
			cvalor = codc+"/"+centrada+"/"+idAsignarOC;
			info_parcial.push(cvalor);
		});

    $("#btn_parcial").prop("disabled",true);
    $("#btn_parcial").html('Almacenando...');

	      $.ajax({
          type: "POST",
          dataType: "json",
          url: base_urlx+"Entradaoc/entradaParcial/",
          data:{
            info:info_parcial,
            iduser:iduserx,
            obs:$("#obs").val(),
            idoc:$("#idoc").val()
          },
          cache: false,
          success: function(result)
          {
            if ( result == true ) {
              alert("La entrada se ha realizado correctamente");
              location.reload();
              //showPDF(result);
            }else{

              alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");

            }
            $("#btn_parcial").prop("disabled",false);
            $("#btn_parcial").html('<i class="fa fa-file-code-o" style="color:black;"></i> Entrada parcial');
          }

	      }).fail( function( jqXHR, textStatus, errorThrown ) {

	        detectarErrorJquery(jqXHR, textStatus, errorThrown);

	      });
	}
}



function entradaAll(){

	x = confirm("¿Realmente deseas dar entrada COMPLETA a esta ODC?");
	if ( x ) {
    $("#btn_all").prop("disabled",true);
    $("#btn_all").html('Almacenando...');

    info_parcial = new Array(); 

		$('#my-table').DataTable().rows().data().each(function(el, index){
			codc = el[3]; // Entrada original
			centrada = el[5]; //Entrada ajustada
			idAsignarOC = el[10]; // Id parte asignada
			cvalor = codc+"/"+centrada+"/"+idAsignarOC;
			info_parcial.push(cvalor);
		});

    $.ajax({
          type: "POST",
          dataType: "json",
          url: base_urlx+"Entradaoc/entradaAll/",
          data:{
            info:info_parcial,
            iduser:iduserx,
            obs:$("#obs").val(),
            idoc:$("#idoc").val()
          },
          cache: false,
          success: function(result)
          {
            if ( result > 0 ) {
              alert("La entrada se ha realizado correctamente");
              //location.reload();
              //showPDF(result);
            }else{
              alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");
            }

            $("#btn_all").prop("disabled",false);
            $("#btn_all").html('<i class="fa fa-file-code-o" style="color:black;"></i> Entrada parcial');

          }

    }).fail( function( jqXHR, textStatus, errorThrown ) {

        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });
	}
}

function finalizarEntrada(id) {
  
  x = confirm("¿Realmente deseas eliminar esta entrada?");
	if ( x ) {
    $("#btn_all").prop("disabled",true);
    $("#btn_all").html('Almacenando...');

    $.ajax({
          type: "POST",
          dataType: "json",
          url: base_urlx+"Entradaoc/finalizarEntrada/",
          data:{
            info:killRow,
            iduser:iduserx,
            obs:$("#obs").val(),
            idoc:$("#idoc").val()
          },
          cache: false,
          success: function(result)
          {
            if ( result > 0 ) {
              alert("La entrada se ha eliminado correctamente");
              location.reload();
              //showPDF(result);
            }else{
              alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");
            }

            $("#btn_all").prop("disabled",false);
            $("#btn_all").html('<i class="fa fa-file-code-o" style="color:black;"></i> Entrada parcial');

          }

    }).fail( function( jqXHR, textStatus, errorThrown ) {

        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });
	}
}


function agregarInfo(){

    array_info=[];
    infox="";

  for (var i=1; i<cantidad_info+1; i++) {

    infox=$("info"+i).val();

    if(infox!="" || infox!=null){

      array_info.push(infox);

    }

  }

}


function cerrarSesion(){



    var x = confirm("¿Realmente deseas cerrar la sesión?");



    if( x==true ){



      window.location.href = base_urlx+"Login/CerrarSesion/";

      

    }  



}