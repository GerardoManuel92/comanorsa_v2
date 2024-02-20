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

var table="";

$(".select2").select2();

$(".select2-placeholer").select2({

      

    allowClear: true



});

showProveedor();

function showProveedor(){


    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Ajusteinventario/showProveedor/",

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  var creaOption="<option value='0' selected>Selecciona un proveedor...</option>"; 



                  $.each(result, function(i,item){

                      data1=item.id;//id

                      data2=item.rfc;//nombre

                      data3=item.nombre;//id

                      creaOption=creaOption+'<option value="'+data1+'">'+data2+'-'+data3+'</option>'; 

                  }); 



                  $("#proveedor").html(creaOption);

                  $("#proveedor").val(0);



              }else{



                 $("#proveedor").html("<option value='0'>Sin categorias</option>");



              }

              showInfo();

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



}

function showInfo(){

  

  ///////////primera imagen  

    $('#my-table').DataTable().destroy();

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

        "search":         "Buscar por descripcion:",

        "paginate": {

            "first":      "Primero",

            "last":       "Ultimo",

            "next":       "Siguiente",

            "previous":   "Anterior"

        }

        },



        dom: '<"top" pli>rt',



        buttons: [ 'copy', 'excel' , 'csv'],

        "order": [  [ 5, "desc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {



            if ( true ) // your logic here

          {



            $(nRow).addClass( 'customFont' );



            $('td:eq(0)', nRow).addClass( 'alignCenter' );

            $('td:eq(1)', nRow).addClass( 'alignCenter' );



            $('td:eq(2)', nRow).addClass( 'fontText2center' );



            $('td:eq(3)', nRow).addClass( 'alignCenter' );

          
            $('td:eq(6)', nRow).addClass( 'alignRight' );

           
            

            

          }



        },



        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Rentradaxajuste/loadPartidas?idpro="+$("#proveedor").val() + "&statusx=" + $("#bestatus").val(),



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();


        showPartidas(data[9]);
        //alert("idcliente:"+data[8]);


    } );


}

function showPartidas(identradax){

    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Rentradaxajuste/showPartidas/",

            data:{

              ident:identradax

            },

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  var creaOption=""; 



                  $.each(result, function(i,item){

                      cantidadx=item.cantidad;//id

                      costox=item.costo;//nombre

                      tot_totalx=item.tot_total;//id

                      npartex=item.nparte;//nombre

                      descripcionx=item.descripcion;

                      motivo = item.motivo;

                      documento = item.documento;

                      creaOption=creaOption+'<div class="row"><div class="col-md-12 col-lg-12"><h4>'+npartex+' - '+descripcionx+'</h4> <p>Cantidad: '+cantidadx+'pz | Costo: '+costox+' mxn | Subtotal: '+tot_totalx+' mxn</p></div> </div><hr>'; 

                  }); 



                  $("#partidas_ajuste").html(creaOption);


                  /*setTimeout(function (){

                    $("#cliente").val(sidcliente);
                    $('#cliente').trigger('change.select2'); // Notify only Select2 of changes

                  }, 500);*/


              }else{



                 $("#partidas_ajuste").html("<option value='0'>Sin partidas</option>");



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



}

function showExcel() {


  $.ajax({

    type: "POST",

    dataType: "json",

    url: base_urlx + "tw/php/crear_excel_entradas_x_ajuste.php",

    data: { proveedorx: $("#proveedor").val(), statusx: $("#bestatus").val() },

    cache: false,

    success: function (result) {

      if (result) {

        window.location.href = base_urlx + "tw/php/reporte/reporte_entradas_x_ajuste.xlsx";


      } else {
        alert('No se pudo generar excel');
      }
    }
  });
}


function cerrarSesion(){



  var x = confirm("¿Realmente deseas cerrar la sesión?");



  if( x==true ){



    window.location.href = base_urlx+"Login/CerrarSesion/";

    

  }



}

function cancelarAjuste(ID,ID2) {

    var respuesta = window.confirm("Realmente quires cancelar el ajuste ?"+ID);

    
    if (respuesta) {

      $.ajax({

        type: "POST",
  
        dataType: "json",
  
        url: base_urlx+"Rentradaxajuste/cancelarAjuste/",
        
        data:{
  
          id:ID
  
        },
  
        cache: false,
  
        success: function(result)
  
        {
  
  
  
          if ( result != null ) {
  
            alert("Ajuste cancelado");
            showInfo();
  
          }else{
  
  
          }
  
  
  
        }
  
  
  
    }).fail( function( jqXHR, textStatus, errorThrown ) {
  
  
  
  
  
    detectarErrorJquery(jqXHR, textStatus, errorThrown);
  
  
  
    });
       
    }

}