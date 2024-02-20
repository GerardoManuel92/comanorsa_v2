

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



function showEstatus(ventax,entregax){





  return parseFloat(ventax)-parseFloat(entregax);



}



function xEntregar(ventax,entregax){



  resta = parseFloat(ventax)-parseFloat(entregax);



  if( resta > 0 ) {



     return "<p style='color:red; font-weight:bold; font-size:12px;'> POR ENTREGAR </p>";



  }else{



    return "<p style='color:darkgreen; font-weight:bold; font-size:12px;'> COMPLETO </p>";



  }



}



showFactura();



////***** FORMA DE PAGO CLIENTE

/* function showOdc(){



    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Seguimiento/showOdc/",

            data:{ idcot:idcotx },

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  creaOptionx=""; 



                  $.each(result, function(i,item){

                      data1=item.oc;//id

                      data2=item.nombre;//nombre

                      

                      creaOptionx=creaOptionx+'<option value="'+data1+'">ODC'+data1+'-'+data2+'</option>'; 

                  });



                  $("#lista_odc").html(creaOptionx);



              }else{



                 $("#fpago").html("<option value='0'>Sin ODC</option>");



              }



              showFactura();

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



} */



function showFactura(){



    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Seguimiento/showFactura/",

            data:{ idcot:idcotx },

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  creaOptions=""; 





                  $.each(result, function(i,item){

                      data1=item.id;//id

                      data2=item.total;//nombre

                      data3=item.foliox;//nombre

                      

                      creaOptions=creaOptions+'<option value="'+data1+'">'+data3+' Total:'+formatNumber( round(data2) )+'</option>'; 

                  }); 



                  $("#lista_factura").html(creaOptions);
                  showEntregas();



              }else{



                 $("#lista_factura").html("<option value='0'>Sin facturas</option>");



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



}

function showEntregas(){
  $.ajax({
          type: "POST",
          dataType: "json",
          url: base_urlx+"Seguimiento/showEntregas/",
          data:{ idFactura:$('#lista_factura').val()},
          cache: false,
          success: function(result)
          {
            if ( result != null ) {
              $('#lista_entrega').empty();
                creaOptions=""; 
                $.each(result, function(i,item){
                    data1=item.id;//id
                    data2=item.fecha;//nombre
                    data3=item.recibio;//nombre  
                    data4=item.archivo;//archivo                
                    creaOptions=creaOptions+'<option value="'+data1+'" data-archive="'+data4+'">'+data2+' - Recibio: '+data3+'</option>'; 
                }); 
                $("#lista_entrega").html(creaOptions);
            }else{
                $('#lista_entrega').empty();
               $("#lista_entrega").html("<option value='0'>Sin entregas</option>");
            }
          }
  }).fail( function( jqXHR, textStatus, errorThrown ) {
      detectarErrorJquery(jqXHR, textStatus, errorThrown);
  });
}



function verOc(){



  window.open(base_urlx+"tw/php/ordencompra/odc"+$("#lista_odc").val()+".pdf", "_blank");



}



function vetFactura(){

  separar=$('#lista_factura option:selected').html().split(' ');
  window.open(base_urlx+"tw/php/facturas/"+separar[0]+".pdf", "_blank");

}

function verEntrega(){

  var dataArchive = $('#lista_entrega option:selected').data('archive');
  window.open(base_urlx+"tw/js/upload_entrega/files/"+dataArchive+"", "_blank");

}



function verOdcCliente(){



  separar=$('#lista_factura option:selected').html().split(' ');

  separar2=separar[0].toString().split('BDL');

  //alert(separar2[1]);



  $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Seguimiento/verOdcCliente/",

            data:{ idfolio:separar2[1] },

            cache: false,

            success: function(result)

            {



              if ( result.odc != "" || result.odc==null ) {



                window.open(base_urlx+"tw/js/upload_odc/files/"+result.odc, "_blank");



              }else{



                alert("Sin ODC asignado");



              }



              

 

            }



  }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



  });



}



$(document).ready(function() {



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

        "order": [  [ 0, "asc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            /* Append the grade to the default row class name */

            if ( true ) // your logic here

              {



                $(nRow).addClass( 'customFont' );



                

                $('td:eq(5)', nRow).addClass( 'alignCenter' ).addClass( 'color_compras' ).addClass( 'bgcolor_compras' );



                $('td:eq(2)', nRow).addClass( 'alignCenter' ).addClass( 'bgdocumento' ).addClass('color_documentos');



                $('td:eq(1)', nRow).addClass( 'fontText2' );



                $('td:eq(3)', nRow).addClass( 'alignCenter' );



                $('td:eq(4)', nRow).addClass( 'alignCenter' );



                $('td:eq(6)', nRow).addClass( 'alignCenter' ).addClass( 'bgcolor_entradas' ).addClass('color_entradas');



                $('td:eq(7)', nRow).addClass( 'alignCenter' ).addClass( 'bgcolor_darkgreen').addClass('color_darkgreen');



                $('td:eq(8)', nRow).addClass( 'alignCenter' ).addClass( 'color_darkred' ).addClass( 'bgcolor_darkred' );

                

              }

        },

        columnDefs: [



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



                  valor2=showEstatus( data[2],data[7] );



                  return ``+valor2+``         



               }



               

            },



            {

               targets: [9],

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



                  valor2=xEntregar( data[2],data[7] );



                  return ``+valor2+``         



               }



               

            }





        ],



        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Seguimiento/loadPartidas?idcot="+idcotx,



      //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 400,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();





        editId = data[8];

        cant_odc = data[1];

        costo_odc = data[3];



       



    } );





    table

    .buttons()

    .container()

    .appendTo( '#controlPanel' );



    



    //$("#tneto").html("Calculando...");









});