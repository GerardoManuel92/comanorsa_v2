//alert("Version 9.0");



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



function fechaenLetra(fecha){



  fechax = new Date(fecha);



  options = { year: 'numeric', month: 'long', day: 'numeric' };



  return fechax.toLocaleDateString("es-ES", options)





}

function getFolio(cadena) {

  const coincidencias = cadena.match(/\d+/g);
  const datoNumerico = coincidencias ? coincidencias.join('') : '';
  const resultado = parseInt(datoNumerico, 10);

  return resultado;
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



function round(num, decimales = 3) {

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

var total_cot = 0;

var total_desc = 0;

var total_iva = 0;

var indexTabla = 0;

var idxt = "";

var colx = "";

var valorcosto = 0;

var valorprecio = 0;



////////////********* variables de recuperacion 



var editId = 0;

var editParte = 0;

var editDescrip = "";

var cant_doc = 0;

var cant_almacen = 0;

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





        if ( cant_entrada == 0 || cant_almacen > 0 ) {



          restax = parseFloat(cant_entrada)-parseFloat(cant_almacen);



          //BLOQUEDO POR QUE SI PUEDE HABER ENTREGAS NEGATIVAS



          /*if ( restax > 0 ) {



            verificar = 1;

            alert("Alerta, la cantidad de entrega no puede ser mayor a la existencia en almacen");

            row.invalidate();



          }*/



        }else{



          verificar = 1;

          alert("Alerta, la cantidad de entrega no es valida favor de cambiarla");

          row.invalidate();



        }



        if ( parseFloat(cant_entrada) > parseFloat(cant_doc) ) {



          verificar = 1;

          alert("Alerta, la cantidada de entrega no puede superar la cantidad de entregas ni la cantidad de su factura");

          row.invalidate();



        }



        if ( verificar == 0 ) {



                  temp = table.row(idFila).data();



                  costo_odc_decimal = costo_odc.replace(/[^\d.]/g,"");



                  newsubtotal = cant_entrada*costo_odc_decimal;



                  //alert(newsubtotal);



                  temp[5] = cant_entrada; //Cambio de numeración

                  //temp[9] = formatNumber( round( newsubtotal) );





                  //alert("idfila: "+idFila+" / cant_entrada:"+cant_entrada+" / cant_doc: "+cant_doc);

                 



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



function calcularSubtotal(cantx,costox){



  costo = costox.replace(/[^\d.]/g,"");



  subx = round(costo*cantx);



  return  formatNumber(subx);



}



////////************** DATOS DEL DOCUMENTO



function showInfo(){



  $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Centregav2/showInfo/",

            data:{



              documento:$("#tipo").val(),

              folio:$("#folio").val()



            },

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  if ( result.entrega == 1 ) {



                    alert("Alerta, la FACTURA ha sido entregada por completo");



                    $('#btn_entrega').prop('disabled',true);



                  }else if ( result.estatus == 2 ) {



                    alert("Alerta, la FACTURA esta CANCELADA");



                    $('#btn_entrega').prop('disabled',true);



                  }else if ( result.estatus == 0 ) {



                    alert("Alerta, la FACTURA no ha sido TIMBRADA");



                    $('#btn_entrega').prop('disabled',true);



                  }else{



                    $("#documento").html(result.folio);

                    $("#vendedor").html("Vendedor: "+result.vendedor);

                    $("#formato").html('<i class="fa fa-file-text" style="color: #8D27B0;"> Documento</i>');

                    $("#clientex").html('&nbsp;&nbsp;&nbsp;Cliente: '+result.cliente)

                    $('#formato').attr('href', base_urlx+"tw/php/facturas/"+result.folio+".pdf");



                    $("#fecha").html( 'Realizada: '+fechaenLetra(result.ftimbrado) );


                    //alert(result.tipox);

                    $("#tipo_factura").val(result.tipox);



                    $('#btn_entrega').prop('disabled',false);

                    

                    showDocumento();

                  }





              }else{



                 alert("Error, no se encontro ninguna facura. Favor de intentarlo nuevamente");



              }

 

            }



  }).fail( function( jqXHR, textStatus, errorThrown ) {



        detectarErrorJquery(jqXHR, textStatus, errorThrown);



  });

  



}



////*** SUMA DE TOTALES

function sumaTotal(){



  total_sub =0;

  total_desc =0;

  total_iva =0;



  $("#tsubtotal").html("Calculando...");

  $("#tneto").html("Calculando...");



  $('#my-table').DataTable().rows().data().each(function(el, index){

    //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria


    // Reasignación
    scant = el[5];

    scosto= el[6];

    sdesc = el[7];

    siva = el[8];





    //////// CALCULAR LO SOLICITADO PARA ODC



    subtotal = round(scant)*round(scosto.replace(/[^\d.]/g,""));

    desc = round(subtotal)*(sdesc/100);

    sub_descuento = parseFloat(subtotal)-parseFloat(desc);

    iva = round(sub_descuento)*(siva/100);



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



function showDocumento(){



  if ( getFolio($("#folio").val()) > 0 ) {





    $('#my-table').DataTable().destroy();



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

          "search":         "Buscar por producto:",

          /*"paginate": {

              "first":      "Primero",

              "last":       "Ultimo",

              "next":       "Siguiente",

              "previous":   "Anterior"

          }*/

          },



          dom: '<"top" pl>rt',



          buttons: [ 'copy', 'excel' , 'csv'],

          "order": [  [ 0, "asc" ] ],



          "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

              /* Append the grade to the default row class name */

              if ( true ) // your logic here

                {



                  $(nRow).addClass( 'customFont' );



                  //$('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' ).addClass( 'bgcolor1' );

                  $('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );



                  $('td:eq(2)', nRow).addClass( 'alignRight' );

                  $('td:eq(3)', nRow).addClass( 'alignRight' ).addClass('bgdocumento').addClass( 'bold' );

                  $('td:eq(5)', nRow).addClass( 'alignRight' ).addClass('bgcolor_darkgreen').addClass( 'color_darkgreen' );

                  $('td:eq(6)', nRow).addClass( 'alignRight' );

                  $('td:eq(7)', nRow).addClass( 'alignRight' );

                  $('td:eq(8)', nRow).addClass( 'alignRight' );

                  $('td:eq(9)', nRow).addClass( 'alignRight' ).addClass( 'bold' );

                  //$('td:eq(2)', nRow).addClass( 'fontText2' );

                  

                }

          },

          columnDefs: [



              { 

                targets: [5],

                createdCell: createdCell

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


                    // Reasignado
                    valor2=calcularSubtotal( data[5],data[6] );



                    return ``+valor2+``         



                 }



                 

              }



          ],



          "processing": true,

          "serverSide": true,

          "search" : false,

          "paging": false,

          "ajax": base_urlx+"Centregav2/loadPartidas?iddoc="+$("#folio").val(),


          "scrollY": 300,

          "scrollX": true

      });





      ////////////// FOCUS IN 



      $('#my-table tbody').on('focusout', 'tr', function () {

          var data = table.row( this ).data();


          // Reasignado
          editId = data[10];

          cant_doc = data[2]-data[4];

          costo_odc = data[5];

          cant_almacen = data[3];



      } );



      $('#my-table').on( 'focusout', 'tbody td', function () {

        var datax = table.row( this ).data();



        colx = table.cell( this ).index().column;



        idFila = table.cell( this ).index().row;



        //alert(datax[11]);



      } );



      table

      .buttons()

      .container()

      .appendTo( '#controlPanel' );



      //showInfo();



      $("#tneto").html("Calculando...");



      setTimeout(function (){



          sumaTotal();              

                    

      }, 2000);



  }else{



    alert("Alerta, favor de colocar un folio valido");

    $("#folio").focus();



  }



}



//////// SUBIR ARCHIVO PDF



$(function () {



    'use strict';



    //alert("subiendo");



    // Change this to the location of your server-side upload handler:



    var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_entrega/';



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



/*function entradaParcial(){



  x = confirm("¿Realmente deseas generar la ENTREGA de forma PARCIAL?");



  if ( x ) {



    verificar = 0;



      info_parcial = new Array(); //entradas parciales



      total_prom = 0;

      total_entregas = 0;



      ///// crear el ARRAY de las entradas

      $('#my-table').DataTable().rows().data().each(function(el, index){


        // Reasignado
        codc = el[2];

        Centregav2 = el[5];

        cidentrega = el[10];



        ///////



        total_prom = parseFloat(total_prom)+parseFloat(1);

        total_entregas = parseFloat(total_entregas)+parseFloat(Centregav2);



        ////////////



        cvalor = codc+"/"+Centregav2+"/"+cidentrega;



        info_parcial.push(cvalor);



      });



      /////// el promedio nos ayuda a validar que las partidas no vengan todo con entrega igual a 0



      prom = total_entregas/total_prom;



    if ( $("#folio").val() <= 0 || $("#folio").val() == "" || $("#folio").val() == null ) {



      verificar =1;

      alert("Alerta, favor de ingresar un folio valido");

      $("#folio").focus();





    }



    if ( prom <= 0 && verificar == 1) {



      verificar =1;

      alert("Alerta, favor de ingresar como minimo un producto con cantidad de entrega mayor a 0");

      



    }






      if ( verificar == 0 ) {





        $("#btn_parcial").prop("disabled",true);

        $("#btn_parcial").html('Almacenando...');



          $.ajax({

                type: "POST",

                dataType: "json",

                url: base_urlx+"Centregav2/entradaParcial/",

                data:{



                  info:info_parcial,

                  iduser:iduserx,

                  obs:$("#observaciones").val(),

                  tipox:$("#tipo").val(),

                  foliox:$("#folio").val(),

                  recibio:$("#recibio").val(),

                  name_factpdf:$("#name_factpdf").val()



                },

                cache: false,

                success: function(result)

                {



                  if ( result > 0 ) {



                    alert("La evidencia de ENTREGA se ha realizado correctamente");

                    location.reload();



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



}*/



function entradaAll(){

  x = confirm("¿Realmente deseas generar la ENTREGA?");



  if ( x ) {





      verificar = 0;



      info_parcial = new Array(); //entradas parciales



      total_prom = 0;

      total_entregas = 0;



      ///// crear el ARRAY de las entradas

      $('#my-table').DataTable().rows().data().each(function(el, index){


        
        codc = el[2];

        Centregav2 = el[3];

        cidentrega = el[10];



        ///////



        total_prom = parseFloat(total_prom)+parseFloat(1);

        total_entregas = parseFloat(total_entregas)+parseFloat(Centregav2);



        ////////////



        cvalor = codc+"/"+Centregav2+"/"+cidentrega;



        info_parcial.push(cvalor);



      });



      /////// el promedio nos ayuda a validar que las partidas no vengan todo con entrega igual a 0



      prom = total_entregas/total_prom;



    if ( $("#folio").val() <= 0 || $("#folio").val() == "" || $("#folio").val() == null ) {



      verificar =1;

      alert("Alerta, favor de ingresar un folio valido");

      $("#folio").focus();





    }



    if ( prom <= 0 && verificar == 1) {



      verificar =1;

      alert("Alerta, favor de ingresar como minimo un producto con cantidad de entrega mayor a 0");

      



    }


    
    if ( $("#name_factpdf").val() == "") {



      verificar =1;

      alert("Alerta, favor de ingresar una evidencia de entrega valida");

      

    }

    /*var almacenY = false;

    $('#my-table').DataTable().rows().data().each(function(el, index){
  
      if(el[3] == 0){
        almacenY = true;
        verificar = 1;
      }
      
    });

    if(almacenY){
      alert("Error, tienes almacen de 0")
    }*/


    if ( verificar == 0 ) {

      info_parcial = new Array(); // Información de Entradas

      ///// crear el ARRAY de las entradas

      $('#my-table').DataTable().rows().data().each(function(el, index){
        codc = el[2]; // Entrada original
        centrada = el[5]; //Entrada ajustada
        idAsignarOC = el[10]; // Id parte asignada
        cvalor = codc+"/"+centrada+"/"+idAsignarOC;
        info_parcial.push(cvalor);
      });


        $("#btn_all").prop("disabled",true);

        $("#btn_all").html('Almacenando...');



          $.ajax({

                type: "POST",

                dataType: "json",

                url: base_urlx+"Centregav2/entradaAll/",

                data:{



                  iduser:iduserx,

                  obs:$("#obs").val(),

                  tipox:$("#tipo").val(),

                  foliox:$("#folio").val(),

                  recibio:$("#recibio").val(),

                  name_factpdf:$("#name_factpdf").val(),

                  entregas:info_parcial



                },

                cache: false,

                success: function(result)

                {



                  if ( result > 0 ) {



                alert("La entrega se ha realizado correctamente");

                location.reload();



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



}


function cerrarSesion(){



    var x = confirm("¿Realmente deseas cerrar la sesión?");



    if( x==true ){



      window.location.href = base_urlx+"Login/CerrarSesion/";

      

    }  



}

