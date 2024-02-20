//alert("version 1.0");
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

$(document).ready(function() {

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

        dom: '<"top"B fpl>rt',

        buttons: [ 'copy', 'excel' , 'csv'],
        "order": [  [ 0, "desc" ] ],

        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            /* Append the grade to the default row class name */
            if ( true ) // your logic here
        {

          $(nRow).addClass( 'customFont' );

          $('td:eq(0)', nRow).addClass( 'alignCenter' );
          $('td:eq(1)', nRow).addClass( 'alignCenter' );
          
        }
        },
        "processing": true,
        "serverSide": true,
        "search" : false,
        "ajax": base_urlx+"AltaSubcategoria/loadPartidas" ,

      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

        "scrollY": 450,
        "scrollX": true
    });

    table
    .buttons()
    .container()
    .appendTo( '#controlPanel' );

    $(".select2").select2();
    $(".select2-placeholer").select2({
      allowClear: true

    });

} );

showCategoria();

/////////****************** SELECT CATEGORIAS

function showCategoria(){

  $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"AltaProducto/showCategoria/",
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption="<option value='0'>Selecciona una categoria...</option>"; 

                  $.each(result, function(i,item){
                      data1=item.id;//id
                      data2=item.descripcion;//nombre
                      creaOption=creaOption+'<option value="'+data1+'">'+data2+'</option>'; 
                  }); 

                  $("#categoria").html(creaOption);
                  $("#categoria").val(0);

                  $("#categoria").focus();

              }else{

                 $("#categoria").html("<option value='0'>Sin categorias</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });

}


//////////*************** ALTA DE PROVEEDOR 
function altaNewSubcategoria(){

  verificar = 0;

  
  if ( $("#categoria").val() <= 0 && verificar == 0 ){

    alert( "Alerta, favor de agregar una categoria valida" );
    $("#categoria").focus();
    verificar = 1;

  }

  if ( $("#subcategoria").val() <= 0 && verificar == 0 ){

    alert( "Alerta, favor de agregar una subcategoria valida" );
    $("#subcategoria").focus();
    verificar = 1;

  }

	if ( verificar == 0 ) {

	    $("#btn_finalizar").prop("disabled",true);
	    $("#btn_finalizar").html("Ingresando subcategoria...");

	    $.ajax({
	            type: "POST",
	            dataType: "json",
	            url: base_urlx+"AltaSubcategoria/altaNewSubcategoria/",
	            data:{

	              categoria:$("#categoria").val(),
                subcategoria:$("#subcategoria").val()
	              
	            },
	            cache: false,
	            success: function(result)
	            {

	              if ( result > 0 ) {

	                alert("La insercion fue realizada correctamente");
	                //location.reload();
	                $('#my-table').DataTable().ajax.reload();

	                //$("#categoria").val(0);
                  $("#subcategoria").val("")
	                $("#categoria").focus();


	              }else{

	                alert("Error, favor de intentarlo nuevamente y de persistir el error comuniquese con el administrador");

	              }

	              $("#btn_finalizar").prop("disabled",false);
	              $("#btn_finalizar").html("<i class='icon-right'></i> Ingresar subcategoria");
	 
	            }

	    }).fail( function( jqXHR, textStatus, errorThrown ) {


	        detectarErrorJquery(jqXHR, textStatus, errorThrown);

	    });

  	}

}