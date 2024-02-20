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



var idmarca = 0;

var idmarca_act = 0;

var marcax = "";



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

        "order": [  [ 1, "asc" ] ],



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

        "ajax": base_urlx+"AltaMarca/loadPartidas" ,



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();



        idmarca = data[2];

        marcax = data[1];

       

    } );



    table

    .buttons()

    .container()

    .appendTo( '#controlPanel' );



} );



//////////*************** ALTA DE PROVEEDOR 



function altaMarca(){



  verificar = 0;



  

  if ( $("#marca").val() <= 0 && verificar == 0 ){



    alert( "Alerta, favor de agregar una marca valida" );

    $("#marca").focus();

    verificar = 1;



  }



	if ( verificar == 0 ) {



	    $("#btn_finalizar").prop("disabled",true);

	    $("#btn_finalizar").html("Ingresando marca...");



	    $.ajax({

	            type: "POST",

	            dataType: "json",

	            url: base_urlx+"AltaMarca/altaNewmarca/",

	            data:{



	              marca:$("#marca").val()

	              

	            },

	            cache: false,

	            success: function(result)

	            {



	              if ( result > 0 ) {



	                alert("La insercion fue realizada correctamente");

	                //location.reload();

	                $('#my-table').DataTable().ajax.reload();



	                $("#marca").val("");

	                $("#marca").focus();





                }else if(result == 0) {



                  alert("Alerta, marca repetida esta ya se encuentra en la lista actual de marcas");



	              }else{



	                alert("Error, favor de intentarlo nuevamente y de persistir el error comuniquese con el administrador");



	              }



	              $("#btn_finalizar").prop("disabled",false);

	              $("#btn_finalizar").html("<i class='icon-right'></i> Ingresar marca");

	 

	            }



	    }).fail( function( jqXHR, textStatus, errorThrown ) {





	        detectarErrorJquery(jqXHR, textStatus, errorThrown);



	    });



  }



}



function editarMarca(){



  verificar = 0;



  if ( idmarca == 0 ) {



    alert("Error, el sistema no pudo encontrar el id de la marca a editar, favor de recargar la pagina y volverlo a intentar");

    verificar = 1;



  }



  if ( marcax == "" ) {



    alert("Error, el sistema no pudo encontrar el nombre de la marca a editar, favor de recargar la pagina y volverlo a intentarlo");

    verificar = 1;



  }



  if ( verificar == 0 ) {



    idmarca_act = idmarca;



    $("#marca").val(marcax);

    $("#btnguardar").css("display", "none");

    $("#btnactualizar").css("display", "");



    $("#marca").focus();



  }





}



function cerrarAct(){



    location.reload();

}



function Actmarca(){



  verificar = 0;



  

  if ( $("#marca").val() <= 0 && verificar == 0 ){



    alert( "Alerta, favor de agregar una marca valida" );

    $("#marca").focus();

    verificar = 1;



  }



  if ( idmarca_act == 0 ) {



    alert("Error, favor de actualizar la pagina nuevamente");

    verificar = 1;



  }



  if ( verificar == 0 ) {



      $("#btn_actualizar").prop("disabled",true);

      $("#btn_actualizar").html("Actualizando marca...");



      $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"AltaMarca/Actmarca/",

              data:{



                marca:$("#marca").val(),

                idmarca:idmarca_act

                

              },

              cache: false,

              success: function(result)

              {



                if ( result ) {



                  alert("La actualizacion fue realizada correctamente");

                  location.reload();

                  /*$('#my-table').DataTable().ajax.reload();



                  $("#marca").val("");

                  $("#marca").focus();*/



                }else if(result == 0) {



                  alert("Alerta, marca repetida esta ya se encuentra en la lista actual de marcas");



                }else{



                  alert("Error, favor de intentarlo nuevamente y de persistir el error comuniquese con el administrador");



                }



                $("#btn_actualizar").prop("disabled",false);

                $("#btn_actualizar").html('<i class="icon-right"></i> Actualizar marca');

   

              }



      }).fail( function( jqXHR, textStatus, errorThrown ) {





          detectarErrorJquery(jqXHR, textStatus, errorThrown);



      });



  }



}



function deleteMarca(didmarca){



  if ( didmarca > 0 ) {



    x = confirm("¿Realmente deseas eliminar esta marca?");



    if ( x ) {



      $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"AltaMarca/deleteMarca/",

              data:{



                idmarca:didmarca

                

              },

              cache: false,

              success: function(result)

              {



                if ( result ) {



                  alert("La marca fue eliminada correctamente");

                  location.reload();

                  /*$('#my-table').DataTable().ajax.reload();



                  $("#marca").val("");

                  $("#marca").focus();*/



                }else{



                  alert("Error, favor de intentarlo nuevamente y de persistir el error comuniquese con el administrador");



                }

   

              }



      }).fail( function( jqXHR, textStatus, errorThrown ) {





          detectarErrorJquery(jqXHR, textStatus, errorThrown);



      });



    }



  }



}



function cerrarSesion(){



    var x = confirm("¿Realmente deseas cerrar la sesión?");



    if( x==true ){



      window.location.href = base_urlx+"Login/CerrarSesion/";

      

    }  



}

