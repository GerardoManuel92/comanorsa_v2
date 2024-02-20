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

showBancos();

$(".select2").select2();

var table="";

var actidcuenta="";
var actrfc="";
var actcuenta="";
var actsaldo="";

var idcuenta_act=0; 

////////////***************** SHOW CUENTAS BANCARIAS

function showBancos(){

    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rclientes/showBancos/",

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

                  //$("#regimen").val(0);



              }else{



                 $("#lista_banco").html("<option value='0'>Sin bancos almacenados</option>");



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });

}

function altaCuenta(){


  verificar=0;

  if($("#lista_banco").val()=="" && verificar == 0 || $("#lista_banco").val()==null && verificar==0){

    alert("Alerta, favor de seleccionar un banco valido");
    $("#lista_banco").focus();
    verificar=1;

  }

  if($("#rfc").val()=="" && verificar == 0 || $("#rfc").val()==null && verificar==0){

    alert("Alerta, favor de colocar un RFC valido");
    $("#rfc").focus();
    verificar=1;

  }

  if($("#cuenta").val()=="" && verificar == 0 || $("#cuenta").val()==null && verificar==0){

    alert("Alerta, favor de colocar una cuenta valida");
    $("#cuenta").focus();
    verificar=1;

  }

  if($("#inicial").val()==0 && verificar == 0 || $("#inicial").val()==null && verificar==0){

    alert("Alerta, favor de colocar una valida");
    $("#lista_banco").focus();
    verificar=1;

  }


  if (verificar==0){

    $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"CuentasCom/altaCuenta/",

              data:{

                bancox:$("#lista_banco").val(),
                rfcx:$("#rfc").val(),
                cuentax:$("#cuenta").val(),
                inicialx:$("#inicial").val(),
                idusuario:iduserx

              },

              cache: false,

              success: function(result)

              {


                if ( result>0 ) {

                  alert("La cuenta se ha agregado exitosamente");

                  location.reload();

                }else{


                  alert("Error, favor de recargar la pagina e intentarlo nuevamente");

                }

   

              }



      }).fail( function( jqXHR, textStatus, errorThrown ) {





          detectarErrorJquery(jqXHR, textStatus, errorThrown);



      });

  }

}


function deleteCuenta(idcuenta,est){


  if ( idcuenta > 0 ) {



    x = confirm("¿Realmente deseas CAMBIAR EL ESTATUS de esta Cuenta?");


    if ( x ) {


      $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"CuentasCom/deleteCuenta/",

              data:{

                idcuentax:idcuenta,
                estx:est

              },

              cache: false,

              success: function(result)

              {

                if ( result ) {


                  alert("La CUENTA fue ACTUALIZADA correctamente");

                  location.reload();


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

function editarCuenta(idcuentax){

  $("#lista_banco").val(actidcuenta);
  $("#rfc").val(actrfc);
  $("#cuenta").val(actcuenta);
  $("#inicial").val(actsaldo);
  $("#moneda").val("PESOS");


    $("#btnguardar").css("display", "none");

    $("#btnactualizar").css("display", "");
    $("#rfc").focus();

    idcuenta_act=idcuentax;


}

function actCuenta(){

  verificar=0;

  if($("#lista_banco").val()=="" && verificar == 0 || $("#lista_banco").val()==null && verificar==0){

    alert("Alerta, favor de seleccionar un banco valido");
    $("#lista_banco").focus();
    verificar=1;

  }

  if($("#rfc").val()=="" && verificar == 0 || $("#rfc").val()==null && verificar==0){

    alert("Alerta, favor de colocar un RFC valido");
    $("#rfc").focus();
    verificar=1;

  }

  if($("#cuenta").val()=="" && verificar == 0 || $("#cuenta").val()==null && verificar==0){

    alert("Alerta, favor de colocar una cuenta valida");
    $("#cuenta").focus();
    verificar=1;

  }

  if($("#inicial").val()==0 && verificar == 0 || $("#inicial").val()==null && verificar==0){

    alert("Alerta, favor de colocar una valida");
    $("#lista_banco").focus();
    verificar=1;

  }


  if (verificar==0){

      $.ajax({

              type: "POST",

              dataType: "json",

              url: base_urlx+"CuentasCom/actCuenta/",

              data:{

                bancox:$("#lista_banco").val(),
                rfcx:$("#rfc").val(),
                cuentax:$("#cuenta").val(),
                inicialx:$("#inicial").val(),
                idusuario:iduserx,
                idcuentax:idcuenta_act

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

        "order": [  [ 3, "asc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            /* Append the grade to the default row class name */

            if ( true ) // your logic here

        {



          $(nRow).addClass( 'customFont' );



          $('td:eq(0)', nRow).addClass( 'alignCenter' );

          $('td:eq(1)', nRow).addClass( 'alignCenter' );

          $('td:eq(4)', nRow).addClass( 'alignRight' );

          

        }

        },

        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"CuentasCom/loadPartidas" ,



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();

        actidcuenta=data[8];
        actrfc=data[2];
        actcuenta=data[3];
        actsaldo=data[9];


    } );



    table

    .buttons()

    .container()

    .appendTo( '#controlPanel' );



} );

function cerrarSesion(){



    var x = confirm("¿Realmente deseas cerrar la sesión?");



    if( x==true ){



      window.location.href = base_urlx+"Login/CerrarSesion/";

      

    }  



}