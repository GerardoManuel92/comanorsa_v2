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

        return signo *  ath.round(num);

    // round(x * 10 ^ decimales)

    num = num.toString().split('e');

    num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));

    // x * 10 ^ (-decimales)

    num = num.toString().split('e');

    return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));

}

var table;
var colx = "";
var idFila = "";

////////// EDITOR DE CELDAS



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



      if ( colx == 3 ||  colx == 0 || colx == 5 || colx == 11 || colx == 7 ) {



        row.invalidate()



      }else{



          $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"AltaCotizacion/updateCelda/",

            data:{



              texto:e.target.textContent,

              columna:colx,

              idpcot:editId,

              idcpro:editCproveedor,

              ordenx:editOrden



            },

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                if (colx == 1) {



                  $('#my-table').DataTable().ajax.reload();



                }else{



                  temp = table.row(idFila).data();



                  temp["PRECIO"] = formatNumber( round(result.costo) );

                  temp["CANTIDAD"] = round(result.cantidad);

                  temp["DESCRIPCION"] = result.descripcion;

                  //temp["MOTIVO"] = result.motivo;

                  temp["DESC"] = round(result.descuento);



                  temp["UTILIDAD"] = round(result.utilidad);

                  temp["TC"] = round(result.tcambio);



                  temp["SUBTOTAL"] = formatNumber( round( round(result.costo)*result.cantidad ) );



                  temp["SUBX"] = round(result.subtotal);

                  temp["IVAX"] = round(result.tiva);

                  temp["DESCX"] = round(result.tdescuento);



                  $('#my-table').dataTable().fnUpdate(temp,idFila,undefined,false);



                }



                $("#tneto").html("Calculando...");



                setTimeout(function (){

                    

                    sumaTotal();              

                              

                }, 1000);



                //alert("Se ha actualizado cantidad: "+result.cantidad+" costo: "+result.costo);



              }else{



                alert("Alerta, favor de intentar actualizarlo nuevamente");



              }



            }



          });



      }

      

    }



  })

}


function sumaTotal(){



  total_cot =0;

  total_desc =0;

  total_iva =0;



  $('#my-table').DataTable().rows().data().each(function(el, index){

    //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria

    /*total_cot = parseFloat(total_cot)+parseFloat(el[15]);

    total_desc = parseFloat(total_desc)+parseFloat(el[17]);

    total_iva = parseFloat(total_iva)+parseFloat(el[16]);*/


    total_cot = parseFloat(total_cot)+parseFloat(el["SUBX"]);

    //total_desc = parseFloat(total_desc)+parseFloat(el["DESCX"]);

    total_iva = parseFloat(total_iva)+parseFloat(el["IVAX"]);



  });



  total_sub = parseFloat(total_cot)-parseFloat(total_iva);



  $("#tsubtotal").html( "Subtotal: "+formatNumber(round(total_sub) ));

  $("#tneto").html("Total: "+formatNumber(round(total_cot) ));

  $("#tiva").html( "Iva "+formatNumber(round(total_iva) ));



}



$(document).ready(function() {



  $('#fecha').datepicker({

    startView: 2,

    keyboardNavigation: false,

    forceParse: false,

    format: "dd/mm/yyyy"

  });

    

    $(".select2").select2();

    $(".select2-placeholer").select2({

      allowClear: true



    });





    

  $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {



    $(this).closest(".select2-container").siblings('select:enabled').select2('open');

    



  });



  

  $('select.select2').on('select2:closing', function (e) {

    $(e.target).data("select2").$selection.one('focus focusin', function (e) {

      e.stopPropagation();

    });

  });



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

        "order": [  [ 1, "desc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            /* Append the grade to the default row class name */

            if ( true ) // your logic here

              {



                $(nRow).addClass( 'customFont' );



                $('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );

                $('td:eq(1)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );

                $('td:eq(2)', nRow).addClass( 'alignCenter' ).addClass( 'fontText3' );

                $('td:eq(3)', nRow).addClass( 'fontText2' );

                $('td:eq(4)', nRow).addClass( 'fontText2' );

                $('td:eq(5)', nRow).addClass( 'alignCenter' ).addClass( 'fontText' );

                $('td:eq(6)', nRow).addClass( 'alignRight' ).addClass( 'fontText2' );

                $('td:eq(7)', nRow).addClass( 'alignCenter' ).addClass( 'fontText3' );

                $('td:eq(8)', nRow).addClass( 'alignRight' ).addClass( 'fontText2' );

                

              }

        },

        "paging": false,

        "processing": true,

        //"serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Ajusteinventario/loadPartidas?iduser="+iduserx,

        "columns": [

          
          { data: "ACCION" },
          { data: "CANTIDAD" },
          { data: "CLAVE" },
          { data: "DESCRIPCION" },
          { data: "UM" },
          { data: "PRECIO" },
          { data: "IVA" },
          { data: "SUBTOTAL" }

        ],

      //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 300,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('focusin', 'tr', function () {

        var data = table.row( this ).data();





        editId = data["IDX"];



        //idFila = table.row( this ).index();

        editCantidad = data["CANTIDAD"];

        editCosto = data["COSTOX"];

        //editCproveedor = data["PROVX"];

        //alert(editCproveedor);

        //edittcambio =data["TC"];

        //editUtil = data["UTILIDAD"];

        //editOrden= data["ITEM"];



        //alert(editUtil);



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





    /*$('#my-table tbody').on( 'click', 'td', function () {



      alert( table.cell( this ).index() );



    } );*/



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



    $("#tneto").html("Calculando...");



    setTimeout(function (){
        
      sumaTotal();              

    }, 2000);



    $("#bi_pro").focus(1);



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

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);


    });



}

/////*********** ADJUNTAR COMPROBANTE DE INGRESO

$(function () {



    'use strict';



    //alert("subiendo");



    // Change this to the location of your server-side upload handler:



    var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_ajuste_entrada/';



    $('#fileupload_pdf').fileupload({



        url: url,



        dataType: 'json',



        done: function (e, data) {



            $.each(data.result.files, function (index, file) {





              $("#name_archivo").val(file.name);

                



            });



        },



            progressall: function (e, data) {



                var progress = parseInt(data.loaded / data.total * 100, 10);



                $('#progress_bar_factpdf .progress-bar').css(



                    'width',



                    progress + '%'



                );



             $("#files_cfactpdf").html("<strong>El documento se ha subido correctamente</strong>");





            }



        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');



});


///////************ BUSCAR PARTIDAS BUSCADOR INTELIGENTE

var options = {



      //url: "<?php echo base_url();?>js/countries.json",

      //url: "assets/files/buscar_clvproveedor_factura.php?clv=",

      url: function(phrase) {



        return  base_urlx+"AltaCotizacion/buscarxdescrip?clv="+$('#bi_pro').val();

      

    },

      

      getValue: "descripcionx",

      

      theme:"light",



      list: {

        maxNumberOfElements: 20,

        match: {

          enabled: false

        },

       

        onClickEvent: function() {

          idPro = $("#bi_pro").getSelectedItemData().id;

          $("#unidad").html( $("#bi_pro").getSelectedItemData().unidad );



          //alert( formatNumber( round($("#bi_pro").getSelectedItemData().costo) ) );



          /////////************** REVISION DE COSTOS

          costo = round($("#bi_pro").getSelectedItemData().costo);

          costo_new = round($("#bi_pro").getSelectedItemData().costo_new);



          if ( costo_new > 0  ) {



            costo_final = costo_new;



          }else{



            costo_final = costo;



          }

          ivax = $("#bi_pro").getSelectedItemData().iva;



            if ( ivax == 3 ) {



              //$("#idtasa").html( $("#bi_pro").getSelectedItemData().tasa+"% - iva");

              $("#tasa").val( $("#bi_pro").getSelectedItemData().tasa );



            }else if ( ivax == 2 ) {



              $("#tasa").val("0");



            }else{



              $("#tasa").val( $("#bi_pro").getSelectedItemData().tasa );



            }



          $("#costo").val( formatNumber(costo_final) );


          $("#descripcion").val( $("#bi_pro").getSelectedItemData().descrip );

          valorcosto = $("#bi_pro").getSelectedItemData().costo;


          $("#cantidad").focus();




        },

        onKeyEnterEvent: function(){

          idPro = $("#bi_pro").getSelectedItemData().id;

          $("#unidad").html( $("#bi_pro").getSelectedItemData().unidad );


          /////////************** REVISION DE COSTOS



          costo = round($("#bi_pro").getSelectedItemData().costo);

          costo_new = round($("#bi_pro").getSelectedItemData().costo_new);



          if ( costo_new > 0  ) {



            costo_final = costo_new;



          }else{



            costo_final = costo;



          }


            ivax = $("#bi_pro").getSelectedItemData().iva;



            if ( ivax == 3 ) {



              $("#idtasa").html( $("#bi_pro").getSelectedItemData().tasa+"% - iva");

              $("#tasa").val( $("#bi_pro").getSelectedItemData().tasa );



            }else if ( ivax == 2 ) {



              $("#tasa").val("0");



            }else{



              $("#tasa").val("16");



            }


          $("#costo").val( formatNumber(costo_final) );


          $("#descripcion").val( $("#bi_pro").getSelectedItemData().descrip );

          valorcosto = $("#bi_pro").getSelectedItemData().costo;

          $("#cantidad").focus();


        }

      }

    };



$("#bi_pro").easyAutocomplete(options);


///////////************* CALCULOS PARA OBTENER SUBTOTAL

function esconderTxt(e){



  if (e==1) {



    $("#txt_cantidad").css("display", "none");



  }



  if (e==2) {



    $("#txt_costo").css("display", "none");



  }



}

////**** ACTIVAR TASA

function showTasa(idtasa){



  if (idtasa == 3) {



    $("#divtasa").css("display", "");

    $("#tasa").prop("disabled", false);

    $("#tasa").focus();



  }else{



    $("#divtasa").css("display", "none");

    $("#tasa").prop("disabled", true);



  }



}

function calcularSubtotal(){



  cantidadx = round($("#cantidad").val());

  costox = round( $("#costo").val().replace(/[^\d.]/g,"") );

  subtotalx = 0;



  ///**********OBLIGAR AL REDONDEO A 2 UNIDADES 

  $("#cantidad").val(cantidadx);

  $("#costo").val(formatNumber(costox));


  if ( cantidadx > 0 && costox > 0 ) {


      subtotalx = cantidadx * costox;


      $("#total").val( formatNumber( round(subtotalx) ) );


  }else{



    if ( cantidadx <= 0 || cantidadx == "" || cantidadx == null) {



      $("#txt_cantidad").css("display", "");



      setTimeout(function (){


          esconderTxt(1);              

                    

      }, 2000);



      //setTimeout( esconderTxt() , 800);



    }else if (costox <= 0 || costox == "" || costox == null) {



      $("#txt_costo").css("display", "");



      setTimeout(function (){



          esconderTxt(2);              

                    

      }, 2000);



    }



  }



}

//////////////**************** INGRESAR PARTIDAS AL TEMPORAL

function calcularSubtotalPrecio(){



  //preciox = round($("#precio").val().replace(/[^\d.]/g,"") );

  costox = round( $("#costo").val().replace(/[^\d.]/g,"") );

  //tcambiox = round($("#tc").val());

  cantidadx = round($("#cantidad").val());

  subtotalx=cantidadx*costox;

  $("#total").val( formatNumber( round(subtotalx) ) );

}



function ingresarPartidas(){



  verificar = 0;



  calcularSubtotalPrecio();


  costo_proveedorx = $("#costo").val().replace(/[^\d.]/g,"");



  //alert("precio: "+$("#precio").val());


  if(costo_proveedorx== 0 || costo_proveedorx == ""){

    alert("Alerta, favor de colcar un costo valido");

    verificar = 1;

    $("#costo").focus();

  }



  if( idPro == 0 ){



    alert("Alerta, favor de seleccionar un producto valido");

    verificar = 1;

    $("#bi_pro").focus();



  }



  if( $("#cantidad").val() <= 0 && verificar == 0 ){



    alert("Alerta, favor de seleccionar una cantidad valida del producto");

    verificar = 1;

    $("#cantidad").focus();



  }


  if( $("#total").val() <= 0 && verificar == 0 ){



    alert("Alerta, favor de colocar un valor valido para el subtotal del producto");

    verificar = 1;

    $("#total").focus();



  }

  if( $("#motivo").val() <= 0 && verificar == 0 ){



    alert("Alerta, favor de colocar el motivo del ajuste");

    verificar = 1;

    $("#motivo").focus();



  }


  if ( verificar == 0 ) {



    $("#btn_ingresar").prop("disabled",true);

    $("#btn_ingresar").html('<i class="fa fa-spinner fa-spin"></i>');

    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Ajusteinventario/ingresarPartidas/",

            data:{

              idparte:idPro,

              iduser:iduserx,

              cantidad:$("#cantidad").val(),

              cproveedor:costo_proveedorx,

              iva:$("#tasa").val(),

              

            },

            cache: false,

            success: function(result)

            {


              if ( result > 0 ) {


                $('#my-table').DataTable().ajax.reload();

                table.buttons().container().appendTo( '#controlPanel' );

                //alert("LA partida se almaceno correctamente");

                $("#bi_pro").val("");

                idPro = 0;

                $("#cantidad").val("");

                $("#costo").val("");

                

                $("#tasa").val("0");

                

                $("#total").val("0");

                $("#divtasa").css("display", "none");

                $("#bi_pro").focus();


                $("#tneto").html("Calculando...");

                $("#descripcion").val("");

                //$("#motivo").val("");



                setTimeout(function (){

                    sumaTotal();              

                              
                }, 1000);



              }else if( result == null ){



                alert("Error, favor de intentarlo nuevamente de persistir el error favor de comunicarse con el administrador");



              }else{



                alert("Alerta, la partida ya se encuentra en su cotización");



                $("#bi_pro").val("");

                idPro = 0;

                $("#cantidad").val("");

                $("#costo").val("");

                

                $("#tasa").val("0");

                

                $("#total").val("0");

                $("#divtasa").css("display", "none");

                $("#bi_pro").focus();


                $("#tneto").html("Calculando...");

                $("#descripcion").val("");

                $("#motivo").val("");


              }



              $("#btn_ingresar").prop("disabled",false);

              $("#btn_ingresar").html('<i class="fa fa-arrow-right"></i>');

     

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {


          detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



  }



}


function retirarParte(idpartex,torden){



  x = confirm("¿Realmente deseas retirar esta partida?");



  if ( x ) {



    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Ajusteinventario/retirarParte/",

            data:{



              idpcot:idpartex,

              idusuario:iduserx



            },

            cache: false,

            success: function(result)

            {



              if ( result ) {


                $('#my-table').DataTable().ajax.reload();

                $("#bi_pro").focus();

                setTimeout(function (){

                    sumaTotal();                                            

                }, 1000);



              }else {



                alert("Error, favor de intentarlo nuevamente de persistir el error favor de comunicarse con el administrador");



              }



     

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





          detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



  }



}

function finalizarEntrada(){



  x = confirm("¿Realmente deseas finalizar el ajuste de entrada?");



  if ( x ) {



    subx = 0;



      $('#my-table').DataTable().rows().data().each(function(el, index){

        //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria

        subx = parseFloat(subx)+parseFloat(el["SUBX"]);



      });



    verificar = 0;



    if ( subx <= 0 ) {



      alert("Alerta, no se han encontrado partidas en tu cotizacion o esta tiene un costo igual a 0");

      verificar = 1;



    }



    if ( $("#proveedor").val() <= 0 && verificar == 0 || $("#proveedor").val() == null && verificar == 0  ) {



      alert("Alerta, favor de seleccionar un proveedor valido");

      verificar = 1;

      $("#proveedor").focus();



    }

    
    if ( verificar == 0 ) {



      $("#btn_finalizar").prop("disabled",true);

      $("#btn_finalizar").html('Generando...');



      $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"Ajusteinventario/finalizarAjuste/",

            data:{



              idpro:$("#proveedor").val(),

              //fecha:$("#fecha").val(),

              iduser:iduserx,

              obsx:$("#motivo").val(),

              docx:$("#name_archivo").val(),

              motivo:$("#motivo").val()

              //tcx:$("#tc").val()



            },

            cache: false,

            success: function(result)

            {



              if ( result > 0 ) {

                alert("Alerta, la entrada fue ingresada CORRECTAMENTE");

                showPDF(result);

                location.reload();


              }else{

                alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");

              }



              $("#btn_finalizar").prop("disabled",false);

              $("#btn_finalizar").html('<i class="icon-check" ></i style="color:black;"> Finalizar');



            }



      }).fail( function( jqXHR, textStatus, errorThrown ) {





          detectarErrorJquery(jqXHR, textStatus, errorThrown);



      });



    }



  }



}


function showPDF(ajuste){

  $.ajax({



      type: "POST",

      dataType: "json",

      url: base_urlx+"tw/php/pdf_ajuste_entrada.php",

      data:{ 


          folio:ajuste


        },

      cache: false,

      success: function(result)

      {

/*
            $.ajax({

                  type: "POST",

                  dataType: "json",

                  url: base_urlx+"tw/php/verificar_url_ajuste.php",

                  data: { archivo:ajuste, folio:ajuste },

                  cache: false,

                  success: function(result)

                  { 



                    if(result){



                      alert("Alerta, el PEDIDO ha sido creado con exito");

                      //enviarCorreo(idcotx,true);

                    }else{



                      alert("Error, la URL no ha podido ser validada");

                      //enviarCorreo(idcotx,false);



                    }



                  }



            });*/
        

      }



  }); 





}



