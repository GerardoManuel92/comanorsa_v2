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

//alert("version 5.0");

var idPsat = 0;//////va a guardar la clave del producto no el ID
var clValidar = 0;
var arrayTag=[];

//////////////************* 

function financial(x) {
  return Number.parseFloat(x).toFixed(2);
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



   return '$' + splitLeft + splitRight;
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

//////******* INCIAMOS SELECT 2

$(document).ready(function() {

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

} );

showUnidades();
showMarcas();
showCategoria();

/////////////*************** BUSCADOR DE CLAVES SAT  

    var options = {

      //url: "<?php echo base_url();?>js/countries.json",
      //url: "assets/files/buscar_clvproveedor_factura.php?clv=",
      url: function(phrase) {

        return  base_urlx+"AltaProducto/buscarxdescrip?clv="+$('#bi_clave').val();
      
    },
      
      getValue: "descripcionx",
      
      theme:"light",

      list: {
        maxNumberOfElements: 20,
        match: {
          enabled: false
        },
       
        onClickEvent: function() {
          idPsat = $("#bi_clave").getSelectedItemData().clave;

        },
        onKeyEnterEvent: function(){
          idPsat = $("#bi_clave").getSelectedItemData().clave;
           
        }
      }
    };

    $("#bi_clave").easyAutocomplete(options);

/////////*********** ALTA ARCHIVOS

//////// SUBIR ARCHIVO PDF

$(function () {

    'use strict';

    //alert("subiendo");

    // Change this to the location of your server-side upload handler:

    var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_producto/';

    $('#fileupload_pdf').fileupload({

        url: url,

        dataType: 'json',

        done: function (e, data) {


            //quitarArchivo(f);

            $.each(data.result.files, function (index, file) {


              $("#name_factpdf").val(file.name);

              $("#imgpro").html('<center><img src="'+base_urlx+'tw/js/upload_producto/files/'+file.name+'"></center>');
                

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

/////////****************** SELECT UNIDADES

function showUnidades(){

  $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"AltaProducto/showUnidades/",
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption="<option value='0'>Selecciona una unidad...</option>"; 

                  $.each(result, function(i,item){
                      data1=item.clave;//id
                      data2=item.descripcion;//nombre
                      data3=item.id;
                      
                      creaOption=creaOption+'<option value="'+data3+'">'+data1+' - '+data2+'</option>'; 
                  }); 

                  $("#unidad").html(creaOption);
                  $("#unidad").val(0);

              }else{

                 $("#unidad").html("<option value='0'>Sin unidades</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });

}

/////////****************** SELECT MARCAS

function showMarcas(){

  $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"AltaProducto/showMarcas/",
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption="<option value='0'>Selecciona una marca...</option>"; 

                  $.each(result, function(i,item){
                      data1=item.id;//id
                      data2=item.marca;//nombre
                      creaOption=creaOption+'<option value="'+data1+'">'+data2+'</option>'; 
                  }); 

                  $("#marca").html(creaOption);
                  

              }else{

                 $("#marca").html("<option value='0'>Sin marcas</option>");

              }

              $('#marca').val(0).trigger('change');
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });

}

/////////****************** SELECT CATEGORIAS

function showCategoria(){

  

  $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"AltaProducto/showCategoria/",
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption="<option value='0'>Selecciona una categoria...</option>"; 

                  $.each(result, function(i,item){
                      data1=item.id;//id
                      data2=item.descripcion;//nombre
                      creaOption=creaOption+'<option value="'+data1+'">'+data2+'</option>'; 
                  }); 

                  $("#categoria").html(creaOption);
                  

              }else{

                 $("#categoria").html("<option value='0'>Sin categorias</option>");

              }

              $('#categoria').val(0).trigger('change');
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });

}


/////////****************** SELECT SUB-CATEGORIAS

function showSubcategoria(idcat){

  $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"AltaProducto/showSubcategoria/",
            data:{idcatx:idcat},
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption="<option value='0'>Selecciona una subcategoria...</option>"; 

                  $.each(result, function(i,item){
                      data1=item.id;//id
                      data2=item.descripcion;//nombre
                      creaOption=creaOption+'<option value="'+data1+'">'+data2+'</option>'; 
                  }); 

                  $("#subcategoria").html(creaOption);
                  

              }else{

                 $("#subcategoria").html("<option value='0'>Sin subcategorias</option>");

              }

              $('#subcategoria').val(0).trigger('change');
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });

}


/////////****************** VERIFICAR CLAVE REPETIDA

function vClave(vclave){

  if ( vclave != "" ) {

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"AltaProducto/vClave/",
            data:{clave:vclave},
            cache: false,
            success: function(result)
            {

              if ( result > 0 ) {

                alert("Alerta, el numero de parte ya existe favor de verificarla ");

                $("#clave").val("");

                $("#txtclave").html("*Clave");

                clValidar = 0;

              }else{

                $("#txtclave").html("*Clave <strong style='color:green'>(validado)</strong>");

                clValidar = 1;

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

  }else{

    $("#txtclave").html("*Clave <strong style='color:red'>(sin validar)</strong>");

  }

}

///////////************************ CALCULAR COSTO

function calcularCosto(){

  //alert("entre a costo");

  costox = $("#costo").val();

  if ( costox > 0) {

    //alert("entre a costo");

    costo_round = round(costox);
    $("#costo").val(costo_round);

    if ( $("#iva").val() == 1 ) {
      /// general

      costo_iva = costo_round+(costo_round*.16); 

      $("#cimpuesto").val( round(costo_iva) );

      $("#tasa").prop("disabled",true);


    }else if ( $("#iva").val() == 2 ) {
      /// excento

      $("#cimpuesto").val( round(costo_round) );

      $("#tasa").prop("disabled",true);

    }else if ( $("#iva").val() == 3 ) {
      /// por producto

      $("#tasa").prop("disabled",false);

      if ( $("#tasa").val() > 0 ) {

        valor_tasa = ( $("#tasa").val()/100 );
        tasa_round = round(valor_tasa);

        costo_iva = costo_round+(costo_round*tasa_round); 

        $("#cimpuesto").val( round(costo_iva) );

      }else{

          //alert("Alerta, favor de agregar un valor de tasa valido");

        costo_iva = costo_round; 

        $("#cimpuesto").val( round(costo_iva) );

      }

    }


    if ( $("#utilidad").val() > 0  ) {

      //alert("utilidad");

      utilidadx = round( $("#utilidad").val() );
      $("#utilidad").val(utilidadx);

      preciox = costo_round+( costo_round*(utilidadx/100) );
      $("#precio").val( round(preciox) );

    }else{


      //alert("entre sin utilidad");
      $("#precio").val( round(costox) );

    }

  }else{


    $("#costo").val("0");

  }

}

/////////************* INGRESAR TAGS

function sumarTag(){

  if ( $("#tag").val() != "" ) {

    $("#viewtags").val("");

    arrayTag.push( $("#tag").val() );

    //alert(arrayTag.length);

    view ="<h3>Tags</h3>";

    for (var i = 0; i < arrayTag.length; i++) {
      
      view = view+'<button onclick="retirarTag('+i+')" class="btn-red" style="border-radius: 10px; opacity: .8; margin-left:10px;"><i class="fa fa-close"></i> '+arrayTag[i]+'</button>';

    }

    
    $("#viewtags").html(view); 

    $("#tag").val("");
    $("#tag").focus();      
                

  }else{

    alert("Favor de ingresar un tag valido");
    $("#tag").focus();

  }

}


function retirarTag(idx){

  arrayTag.splice(idx, 1);

  $("#viewtags").html("");

  view = "<h3>Tags</h3>";

  for (var i = 0; i < arrayTag.length; i++) {
      
      view = view+'<button onclick="retirarTag('+i+')" class="btn-red" style="border-radius: 10px; opacity: .8; margin-left:10px;"><i class="fa fa-close"></i> '+arrayTag[i]+'</button>';

    }

    
    $("#viewtags").html(view);

}


//////////*************** ALTA DE PRODUCTO 

function altaPartida(){

  verificar = 0;

  if ( clValidar == 0 && verificar == 0 ){

    alert( "Alerta, favor de agregar una clave valida" );
    $("#clave").focus();
    verificar = 1;

  }
  if ( $("#unidad").val() <= 0 && verificar == 0 ){

    alert( "Alerta, favor de agregar una unidad valida" );
    $("#unidad").focus();
    verificar = 1;

  }
  if ( $("#marca").val() <= 0 && verificar == 0 ){

    alert( "Alerta, favor de agregar una marca valida" );
    $("#marca").focus();
    verificar = 1;

  }
  if ( $("#categoria").val() <= 0 && verificar == 0 ){

    alert( "Alerta, favor de agregar una unidad categoria" );
    $("#categoria").focus();
    verificar = 1;

  }
  if ( $("#subcategoria").val() <= 0 && verificar == 0 ){

    alert( "Alerta, favor de agregar una subcategoria valida" );
    $("#subcategoria").focus();
    verificar = 1;

  }
  if ( $("#descrip").val() == "" && verificar == 0 ){

    alert( "Alerta, favor de agregar una descripcion valida" );
    $("#descrip").focus();
    verificar = 1;

  }
  if ( idPsat == 0 && verificar == 0 ){

    alert( "Alerta, favor de agregar una clave SAT valida" );
    $("#bi_clave").focus();
    verificar = 1;

  }

  if ( $("#precio").val() <= 0 ) {

    alert("Alerta, favor de ingresar un precio para el producto valido");
    $("#costo").focus();
    verificar = 1;

  }

  if ( verificar == 0 ) {

    $("#btn_finalizar").prop("disabled",true);
    $("#btn_finalizar").html("Ingresando producto...");

     $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"AltaProducto/altaPartida/",
            data:{

              cbx:$("#cbarras").val(),
              clavex:$("#clave").val(),
              satx:idPsat,
              unidadx:$("#unidad").val(),
              marcax:$("#marca").val(),
              categoriax:$("#categoria").val(),
              subcategoriax:$("#subcategoria").val(),
              descripx:$("#descrip").val(),
              maximox:$("#maximo").val(),
              minimox:$("#minimo").val(),
              ivax:$("#iva").val(),
              tagx:arrayTag.toString(),
              cimpuestox:$("#cimpuesto").val(),
              tasax:$("#tasa").val(),
              costox:$("#costo").val(),
              utilidadx:$("#utilidad").val(),
              preciox:$("#precio").val(),
              monedax:$("#moneda").val(),
              imgpro:$("#name_factpdf").val(),
              riva_valor:$("#riva_valor").val(),
              risr_valor:$("#risr_valor").val()


            },
            cache: false,
            success: function(result)
            {

              if ( result > 0 ) {

                alert("La insercion fue realizada correctamente");
                location.reload();

              }else{

                alert("Error, favor de intentarlo nuevamente y de persistir el error comuniquese con el administrador");

              }

              $("#btn_finalizar").prop("disabled",false);
              $("#btn_finalizar").html("Ingresar producto");
 
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


///////////////********** ACTIVAR TASA

function showTasa(idtasa){

  if (idtasa == 3) {

    $("#tasa").prop("disabled", false);

  }else{

    $("#tasa").prop("disabled", true);

  }

}


///////////////////********** RECARGAR SELECTS

function recargar(){

  $("#marca").select2("destroy");
  $("#categoria").select2("destroy");
  $("#unidad").select2("destroy");

  showMarcas();
  showCategoria();
  showUnidades();
  //$("#subcategoria").html("");

  $(".select2").select2();
  $(".select2-placeholer").select2({
  
    allowClear: true

  });

}

////////************************ IMPUESTOS

function selectIva(){

  if( $('#iva_tasa').prop('checked') ) {

    $("#riva_valor").prop("disabled",false);
    $("#riva_valor").focus();

  }else{

    $("#riva_valor").prop("disabled",true);
    $("#riva_valor").val("0");

  }

}

function selectisrRet(){

  if( $('#risr_tasa').prop('checked') ) {

    $("#risr_valor").prop("disabled",false);
    $("#risr_valor").focus();

  }else{

    $("#risr_valor").prop("disabled",true);
    $("#risr_valor").val("0");

  }

}
