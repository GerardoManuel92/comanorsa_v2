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



//alert("Version 10.0");



////**** VARIABLES DE EDICION

var colx = "";

var idFila = "";

var editId = 0;

var editDecrip = "";

var editCantidad = 0;

var cantidadFactura = 0;

var cantidadNota = 0;



showFpago();



////***** FORMA DE PAGO CLIENTE

function showFpago(){



    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Actcotizacion/showFpago/",

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  var creaOption=""; 



                  $.each(result, function(i,item){

                      data1=item.id;//id

                      data2=item.clave;//nombre

                      data3=item.descripcion;//id

                      creaOption=creaOption+'<option value="'+data1+'">'+data2+'-'+data3+'</option>'; 

                  }); 



                  $("#fpago").html(creaOption);

                  //$("#fpago").val(idfpagox);



              }else{



                 $("#fpago").html("<option value='0'>Sin formas de pago</option>");



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



}



//////////////******* CALCULAR SUBTOTAL GLOBAL



function sumaTotal(){



  total_nota =0;

  total_desc =0;

  total_iva =0;



  $('#my-table').DataTable().rows().data().each(function(el, index){

    //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria



    ncosto = el[11];

    ncantidad =el[0];

    ndescuento = el[8]/100;

    niva = el[7]/100;9



    //costoc_descuento = parseFloat(ncosto)-parseFloat( round(ncosto*ndescuento) );

    nsubdescuento = round(ncantidad*parseFloat( round(ncosto*ndescuento) ) );

    nsubtotal = round(ncantidad*ncosto);

    niva = round(nsubtotal*niva);



    total_nota = parseFloat(total_nota)+parseFloat(nsubtotal);

    total_desc = parseFloat(total_desc)+parseFloat(nsubdescuento);

    total_iva = parseFloat(total_iva)+parseFloat(niva);



  });



  total_neto = parseFloat(total_nota)-parseFloat(total_desc)+parseFloat(total_iva);



  $("#tsubtotal").html( "Subtotal: "+formatNumber(round(total_nota) ));

  $("#tneto").html("Total nota: "+formatNumber(round(total_neto) ));

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



//////************* EDITAR CELDA

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

      //alert(e.target.textContent+"/ row.data() );

      //alert("row: "+idxt+" column: "+colx+" Idpcot: "+editId);



      if ( colx == 1 ||  colx == 3 || colx == 4 || colx == 5 || colx == 6 || colx == 7 || colx == 8 ) {



        row.invalidate();



      }else{



        ////validacion de datos



        verificar = 0;



        if ( colx == 0  ) {



            /////***el restante despues de restar las cantidadaes de anterior nota de credito

            restax = parseFloat(cantidadFactura)-parseFloat(cantidadNota);



            if ( parseFloat(e.target.textContent) > parseFloat(restax) ) {



                alert("Alerta, la cantidad de la nota de credito no puede ser mayor a la cantidad restante de la factura");

                //alert("cantidad_factura:"+cantidadFactura+" cantidad_nota"+e.target.textContent);

                verificar =1;

                row.invalidate();



            }



        }else if ( colx == 2 ) {



            if ( e.target.textContent == "" ) {



                alert("Alerta, favor de añadir una descripcion para el articulo a devolver");

                verificar = 1;

                row.invalidate();



            }



        }



        if ( verificar == 0 ) {



            $.ajax({

                type: "POST",

                dataType: "json",

                url: base_urlx+"Altancredito/updateCelda/",

                data:{



                  texto:e.target.textContent,

                  columna:colx,

                  idpfact:editId,

                  idfacturax:$("#idfactura").val(),

                  anterior_cant: editCantidad,

                  anterior_descrip: editDescrip



                },

                cache: false,

                success: function(result)

                {



                  if ( result != null ) {



                    



                    temp = table.row(idFila).data();



                    //temp[6] = formatNumber( round(result.costo) );

                    temp[0] = round(result.cantidad);

                    temp[2] = result.descripcion;

                    

                    $('#my-table').dataTable().fnUpdate(temp,idFila,undefined,false);



                    $("#tneto").html("Calculando...");



                    //alert("Se ha actualizado cantidad: "+result.cantidad+" descripcion: "+result.descripcion);



                    setTimeout(function (){

                        

                        sumaTotal();              

                                  

                    }, 1000);



                  }else{



                    alert("Alerta, favor de intentar actualizarlo nuevamente");



                  }



                }



          });



        }



      }

      

    }



  })

}



$(document).ready(function() {



	////////////////************ TABLA 



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

        /*"paginate": {

            "first":      "Primero",

            "last":       "Ultimo",

            "next":       "Siguiente",

            "previous":   "Anterior"

        }*/

        },



        dom: '<"top"B pli>rt',



        buttons: [ 'copy', 'excel' , 'csv'],

        "order": [  [ 1, "desc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            /* Append the grade to the default row class name */

            if ( true ) // your logic here

              {



                $(nRow).addClass( 'customFont' );



                $('td:eq(0)', nRow).addClass( 'alignRight' ).addClass( 'fontText2' );

                $('td:eq(1)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );

                $('td:eq(2)', nRow).addClass( 'fontText3' );

                $('td:eq(3)', nRow).addClass( 'alignRight' ).addClass( 'fontText2' );

                $('td:eq(4)', nRow).addClass( 'alignRight' ).addClass( 'fontText2' );

                $('td:eq(5)', nRow).addClass( 'alignCenter' );

                $('td:eq(6)', nRow).addClass( 'alignRight' ).addClass( 'fontText3' );

                $('td:eq(7)', nRow).addClass( 'alignRight' ).addClass( 'fontText3' );

                $('td:eq(8)', nRow).addClass( 'alignRight' ).addClass( 'fontText3' );

                $('td:eq(9)', nRow).addClass( 'alignRight' ).addClass( 'fontText3' );



                //$('td:eq(2)', nRow).addClass( 'fontText2' );

                

              }

        },

        columnDefs: [{ 

          targets: [0,2],

          createdCell: createdCell

        }],



        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Altancredito/loadPartidas?idfactura="+$("#idfactura").val(),



      //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 300,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('focusin', 'tr', function () {

        var data = table.row( this ).data();





        editId = data[10];

        editDescrip = data[2];

        editCantidad = data[0];

        cantidadFactura = data[3];

        cantidadNota = data[4];

        costoFactura = data[11];



        //idFila = table.row( this ).index();

        //editCantidad = data[2];

        //editCosto = data[11];



        /*editParte = data[11];

        editDescrip = data[3];

        editUnidad = data[4];

        editIva = data[6];

        editDesc = data[7];

        editSubtotal = data[8];



        indexTabla = table.row(this).index();*/



        //alert( editId );



        //alert( indexTabla );



    } );





    $('#my-table').on( 'focusout', 'tbody td', function () {



      idFila = table.cell( this ).index().row;

      colx = table.cell( this ).index().column;



      //var data = table.cells( idxt, '' ).render( 'display' );

   

      //alert( "row:"+table.cell( this ).data()+" columna:"+colx );

    } );



    table

    .buttons()

    .container()

    .appendTo( '#controlPanel' );



    //$("#tneto").html("Calculando...");



    /*setTimeout(function (){



        sumaTotal();              

                  

    }, 2000);*/



});





///////////**************** ALTA DE NOTA DE CREDITO



function showPDFfactura(idnotax){



      $.ajax({



          type: "POST",

          dataType: "json",

          url: base_urlx+"tw/php/pdf_factura_nc.php",

          data:{ 



              idfactura:idnotax



            },

          cache: false,

          success: function(result)

          {





            window.open(base_urlx+"tw/php/facturas_nc/"+result+".pdf", "_blank");

            alert("La Nota de credito fue generada exitosamente");

            window.location.href=base_urlx+"Rcn";

          }



      }); 





}





function generarNota(){



    x = confirm("¿Realmente deseas generar la nota de credito para esta factura?");



    if ( x ) {



        $("#btnfactura").prop("disabled",true);

        $("#btnfactura").html('<i class="fa fa-spinner fa-spin"></i>');



        verificar = 0;



        cantidadx = 0;



        $('#my-table').DataTable().rows().data().each(function(el, index){



            cantidadx = parseFloat(cantidadx)+parseFloat(ncantidad =el[0]);



        });





        if ( cantidadx == 0 ) {



            alert("Favor de agregar una cantidad de devolucion a un articulo de la factura");

            verificar = 1;



        }



        if ( verificar == 0 ) {



            $.ajax({

                type: "POST",

                dataType: "json",

                url: base_urlx+"tw/php/crear_xml_ncredito_faturalo.php",

                data:{



                    idfactura:$("#idfactura").val(),

                    idcotizacion:$("#idcotizacion").val(),

                    fpago:$("#fpago").val(),

                    observaciones:$("#obs").val(),

                    iduser:iduserx



                },

                cache: false,

                success: function(result)

                {





                  //alert(result);

                    //alert(result);



                    if ( result > 0 ) {



                        showPDFfactura(result);



                        //alert("La nota ha sido creada correctamente");



                    }else{



                        alert(result);



                    }

         

                }



            }).fail( function( jqXHR, textStatus, errorThrown ) {





                detectarErrorJquery(jqXHR, textStatus, errorThrown);



            });



            $("#btnfactura").prop("disabled",false);

            $("#btnfactura").html('<i class="fa fa-check"> Timbrar nota</i>');



        }else{



            $("#btnfactura").prop("disabled",false);

            $("#btnfactura").html('<i class="fa fa-check"> Timbrar nota</i>');



        }



    }



}





function cancelarNota(){



    x = confirm("¿Realmente deseas CANCELAR esta Nota de credito");



    if (x) {



    window.open('','_parent',''); 

    window.close();



    }



}



/////////**************************/////////////



function cerrarSesion(){



    var x = confirm("¿Realmente deseas cerrar la sesión?");



    if( x==true ){



      window.location.href = base_urlx+"Login/CerrarSesion/";

      

    }  



}