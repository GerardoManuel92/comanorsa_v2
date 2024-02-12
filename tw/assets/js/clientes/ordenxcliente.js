showCliente();

function showCliente(){



  	$.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Ordenxcliente/showCliente/",

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

				  $("#clienteASG").html(creaOption);



              }else{



                 $("#cliente").html("<option value='0'>Sin categorias</option>");



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



}

$(function() {
	$("#datepicker").datepicker({
		format: 'yyyy-mm-dd', 
		todayHighlight: true
	}).on('changeDate', function(e) {
		
  
		$(this).datepicker('hide');
	});
  });


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

        "search":         "Buscar por Factura, OC, Folio o Evidencia:",


        "paginate": {

            "first":      "Primero",

            "last":       "Ultimo",

            "next":       "Siguiente",

            "previous":   "Anterior"

        }

        },




        dom: '<"top"lfB>rt<"bottom"ip><"clear">',

        buttons: [ 'copy', 'excel' , 'csv'],

        "order": [  [ 3, "asc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            /* Append the grade to the default row class name */

            if ( true ) // your logic here

        {

          $(nRow).addClass( 'customFont' );
          $('td:eq(0)', nRow).addClass( 'alignCenter' );
          $('td:eq(1)', nRow).addClass( 'alignCenter' );
          $('td:eq(3)', nRow).addClass( 'alignCenter' );
          $('td:eq(4)', nRow).addClass( 'alignCenter' );
          $('td:eq(5)', nRow).addClass( 'alignCenter' );
          $('td:eq(6)', nRow).addClass( 'alignCenter' );          

        }

        },

        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Ordenxcliente/loadPartidas" ,



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });

    table

    .buttons()

    .container()

    .appendTo( '#controlPanel' );

    /////////////********* CLICK 

    /*$('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();



       

    } );*/



    $("#my-table_filter").find("input").focus();





} );


function asignarOC() {

  if($("#clienteASG").val() != 0 && $("#dateValue").val() != "" && $("#name_factpdf").val() != ""){

    x = confirm("¿Realmente deseas asignar la OC al cliente?");
	
    if(x){
      $("#btn_all").prop("disabled",true);
      $.ajax({
        type: "POST",
        dataType: "json",
        url: base_urlx+"Ordenxcliente/asignarOC/",
        data:{

          iduser:iduserx,
          folioOC:$("#folio").val(),
          idCliente:$("#clienteASG").val(),
          fecha:$("#dateValue").val(),
          evidencia:$("#name_factpdf").val(),
          observaciones:$("#observaciones").val()

        },
        cache: false,
        success: function(result)
        {

          if ( result > 0 ) {

          alert("Se asigno la OC correctamente");
          location.reload();

          }else{

          alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");

          }

          $("#btn_all").prop("disabled",false);

        }

      }).fail( function( jqXHR, textStatus, errorThrown ) {

        detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });
    }
    
  }else{
    alert("Asegurate de seleccionar un Cliente, una Fecha y adjuntar una Evidencia valida"); 
  }

}

////////******* ACTUALIZAR TABLA CON FILTROS


function loadPartidas(){

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
            $('td:eq(3)', nRow).addClass( 'alignCenter' );
            $('td:eq(4)', nRow).addClass( 'alignCenter' );
            $('td:eq(5)', nRow).addClass( 'alignCenter' );
            $('td:eq(6)', nRow).addClass( 'alignCenter' );          

	        }

	        },

	        "processing": true,
	        "serverSide": true,
	        "search" : false,
	        "ajax": base_urlx+"Ordenxcliente/loadPartidas?idClient="+$("#cliente").val()+"&estatus="+$("#estatus").val(),



	      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



	        "scrollY": 450,

	        "scrollX": true

	    });


}


function cerrarSesion(){



  var x = confirm("¿Realmente deseas cerrar la sesión?");



  if( x==true ){



    window.location.href = base_urlx+"Login/CerrarSesion/";

    

  }  



}

function cancelarOC(idOC) {

    x = confirm("¿Realmente deseas cancelar la OC?");
	
    if(x){
  
      $.ajax({
        type: "POST",
        dataType: "json",
        url: base_urlx+"Ordenxcliente/cancelarOC/",
        data:{

          idOC:idOC,

        },
        cache: false,
        success: function(result)
        {

          if ( result > 0 ) {

          alert("La OC se fue cancelada");
          location.reload();

          }else{

          alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");

          }

        }

      })
    }

  
}


// Subir PDF
$(function () {

    'use strict';

    //alert("subiendo");

    // Change this to the location of your server-side upload handler:

    var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_ordenxcliente/';

    $('#fileupload_pdf').fileupload({

        url: url,

        dataType: 'json',

        done: function (e, data) {

            //quitarArchivo(f);

            $.each(data.result.files, function (index, file) {

              $("#name_factpdf").val(file.name);
              //console.log(file.name);

            });

        },

            progressall: function (e, data) {

                var progress = parseInt(data.loaded / data.total * 100, 10);

                $('#progress_bar_factpdf .progress-bar').css(

                    'width',
                    progress + '%'

                );

             $("#files_cfactpdf").html("<strong>El pdf se ha subido correctamente</strong>");

            }

        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

});

