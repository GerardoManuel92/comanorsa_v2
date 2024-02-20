

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

  $("#mcargando").modal("hide");

}



alert("version2.0");

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
        "search":         "Buscar por cotizador o proyecto:",
        "paginate": {
            "first":      "Primero",
            "last":       "Ultimo",
            "next":       "Siguiente",
            "previous":   "Anterior"
        }
        },

        dom: '<"top" pl>rt',

        buttons: [ 'copy', 'excel' , 'csv'],
        "order": [  [ 0, "desc" ] ],

        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            /* Append the grade to the default row class name */
            if ( true ) // your logic here
        {

          $(nRow).addClass( 'customFont' );

          $('td:eq(0)', nRow).addClass( 'alignCenter' );
          $('td:eq(1)', nRow).addClass( 'alignCenter' );
          $('td:eq(2)', nRow).addClass( 'alignCenter' );
          $('td:eq(3)', nRow).addClass( 'alignCenter' );
          $('td:eq(4)', nRow).addClass( 'alignCenter' );
          
          
        }
        },
        "processing": true,
        "serverSide": true,
        "search" : false,
        "ajax": base_urlx+"Bitacora/loadPartidas" ,

      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

        "scrollY": 450,
        "scrollX": true
    });

    /////////////********* CLICK 
    /*$('#my-table tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();

       
    } );*/


} );

loadUsuarios();
//////////************** IP

function loadUsuarios(){



	$.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Bitacora/loadUsuarios/",
            cache: false,
            success: function(result)
            {

                var creaOption="<option value='0'>Seleccione un usuario...</option>"; 

                $.each(result, function(i,item){
                    data1=item.id;//id
                    data2=item.nombre;//nombre
                    
                    creaOption=creaOption+'<option value="'+data1+'">'+data2+'</option>'; 
                }); 

                $("#idusuario").html(creaOption);
                $("#idusuario").val(0);

 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });  

}
////////******* LLAMAR TABLA

function crearTabla(){

	verificar = 0;

	if ( $("#inicio").val() == "" ) {

		verificar = 1;
		$("#inicio").focus();

	}

	if ( $("#final").val() == "" && verificar == 0 ) {

		verificar = 1;
		$("#final").focus();
	}

	if ( verificar == 0 ) {

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
	        "search":         "Buscar por cotizador o proyecto:",
	        "paginate": {
	            "first":      "Primero",
	            "last":       "Ultimo",
	            "next":       "Siguiente",
	            "previous":   "Anterior"
	        }
	        },

	        dom: '<"top" pl>rt',

	        buttons: [ 'copy', 'excel' , 'csv'],
	        "order": [  [ 0, "desc" ] ],

	        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
	            /* Append the grade to the default row class name */
	            if ( true ) // your logic here
	        {

	          $(nRow).addClass( 'customFont' );

	          $('td:eq(0)', nRow).addClass( 'alignCenter' );
	          $('td:eq(1)', nRow).addClass( 'alignCenter' );
	          $('td:eq(2)', nRow).addClass( 'alignCenter' );
	          $('td:eq(3)', nRow).addClass( 'alignCenter' );
	          $('td:eq(4)', nRow).addClass( 'alignCenter' );
	          
	          
	        }
	        },
	        "processing": true,
	        "serverSide": true,
	        "search" : false,
	        "ajax": base_urlx+"Bitacora/loadPartidas?finicio="+$("#inicio").val()+"&ffinal="+$("#final").val()+"&departamento="+$('#departamento option:selected').html()+"&iduser="+$('#idusuario').val(),

	      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

	        "scrollY": 450,
	        "scrollX": true
	    });

	}


}


function cerrarSesion(){

  var x = confirm("¿Realmente deseas cerrar la sesión?");

  if( x==true ){

    window.location.href = base_urlx+"Login/CerrarSesion/";
    
  }  

}