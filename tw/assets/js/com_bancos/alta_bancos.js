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

var idbanco="";
var nrazon="";
var ncomercial="";
var nrfc="";
var nclave="";

var idbanco_act=0;

function altaBanco(){



  verificar = 0;


  if ( $("#razon").val() == "" || $("#razon").val() == null ){


    alert( "Alerta, favor de agregar una razon social valida" );

    $("#razon").focus();


  }else if( $("#rfc").val() == "" || $("#rfc").val() == null ){

    alert( "Alerta, favor de agregar un RFC valido" );

    $("#rfc").focus();

  }else if( $("#banco").val() == "" || $("#banco").val() == null ){

    alert( "Alerta, favor de agregar un nombre comercial valido" );

    $("#banco").focus();

  }else if( $("#clave").val() == "" || $("#clave").val() == null ){

    alert( "Alerta, favor de agregar una clave institucional valida" );

    $("#clave").focus();

  }else{

      $("#btn_finalizar").prop("disabled",true);

      $("#btn_finalizar").html("Ingresando...");



      $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"Altabanco/altaBanco/",

              data:{

                razonx:$("#razon").val(),
                rfcx:$("#rfc").val(),
                bancox:$("#banco").val(),
                clavex:$("#clave").val()

              },

              cache: false,

              success: function(result)

              {

                if ( result > 0 ) {

                  alert("La insercion fue realizada correctamente");

                  //location.reload();

                  $('#my-table').DataTable().ajax.reload();



                  $("#razon").val("");
                  $("#rfc").val("");
                  $("#banco").val("");
                  $("#clave").val("");
                  $("#razon").focus();


                }else if(result == 0) {

                  alert("Alerta, el banco ya se encuentra en la lista actual");

                }else{



                  alert("Error, favor de intentarlo nuevamente y de persistir el error comuniquese con el administrador");



                }



                $("#btn_finalizar").prop("disabled",false);

                $("#btn_finalizar").html("<i class='icon-right'></i> Ingresar");

   

              }



      }).fail( function( jqXHR, textStatus, errorThrown ) {





          detectarErrorJquery(jqXHR, textStatus, errorThrown);



      });



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

        "ajax": base_urlx+"Altabanco/loadPartidas" ,



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();


        idbanco=data[5];

        nrazon=data[2];

        ncomercial=data[4];

        nrfc=data[1];

        nclave=data[3];


    } );



    table

    .buttons()

    .container()

    .appendTo( '#controlPanel' );



} );


function editarBanco(idbancox){

  $("#razon").val(nrazon);
  $("#rfc").val(nrfc);
  $("#banco").val(ncomercial);
  $("#clave").val(nclave);

    $("#btnguardar").css("display", "none");

    $("#btnactualizar").css("display", "");
    $("#razon").focus();

    idbanco_act=idbancox;


}

function cerrarAct(){



    location.reload();

}

function deleteBanco(idbancox){


  if ( idbancox > 0 ) {



    x = confirm("¿Realmente deseas eliminar este Banco?");


    if ( x ) {


      $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"Altabanco/deleteBanco/",

              data:{

                idbanco:idbancox

              },

              cache: false,

              success: function(result)

              {

                if ( result ) {


                  alert("El banco fue eliminado correctamente");

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

function actBanco(){

  verificar = 0;


  if ( $("#razon").val() == "" || $("#razon").val() == null ){


    alert( "Alerta, favor de agregar una razon social valida" );

    $("#razon").focus();


  }else if( $("#rfc").val() == "" || $("#rfc").val() == null ){

    alert( "Alerta, favor de agregar un RFC valido" );

    $("#rfc").focus();

  }else if( $("#banco").val() == "" || $("#banco").val() == null ){

    alert( "Alerta, favor de agregar un nombre comercial valido" );

    $("#banco").focus();

  }else if( $("#clave").val() == "" || $("#clave").val() == null ){

    alert( "Alerta, favor de agregar una clave institucional valida" );

    $("#clave").focus();

  }else{

      $("#btn_actualizar").prop("disabled",true);

      $("#btn_actualizar").html("Actualizando...");



      $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"Altabanco/actBanco/",

              data:{

                razonx:$("#razon").val(),
                rfcx:$("#rfc").val(),
                bancox:$("#banco").val(),
                clavex:$("#clave").val(),
                idbanco:idbanco_act

              },

              cache: false,

              success: function(result)

              {

                if ( result > 0 ) {

                  alert("La insercion fue realizada correctamente");
                  location.reload();


                }else if(result == 0) {

                  alert("Alerta, el banco ya se encuentra en la lista actual");

                }else{



                  alert("Error, favor de intentarlo nuevamente y de persistir el error comuniquese con el administrador");



                }



                $("#btn_actualizar").prop("disabled",false);

                $("#btn_actualizar").html("<i class='icon-right'></i> Actualizar");

   

              }



      }).fail( function( jqXHR, textStatus, errorThrown ) {





          detectarErrorJquery(jqXHR, textStatus, errorThrown);



      });



  }

}

function cerrarSesion(){



    var x = confirm("¿Realmente deseas cerrar la sesión?");



    if( x==true ){



      window.location.href = base_urlx+"Login/CerrarSesion/";

      

    }  



}
