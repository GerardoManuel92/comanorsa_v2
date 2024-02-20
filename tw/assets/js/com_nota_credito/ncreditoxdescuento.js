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

//alert("Version 1.0");

////**** VARIABLES DE EDICION
var colx = "";
var idFila = "";
var editId = 0;
var editDecrip = "";
var editCantidad = 0;
var cantidadFactura = 0;
var cantidadNota = 0;

//////

var ivax=0;
var subx=0;
var netox=0;


function calcularTotalx(){

  descx=$("#desc").val();

  if ( descx > 0 ) {

    subx=descx/1.16;
    ivax=parseFloat(descx)-parseFloat(subx);

    ivax=round(ivax)
    subx=round(subx);
    netox=round(descx);

    $("#tsubtotal").html( "Subtotal: "+formatNumber(subx));
    $("#tneto").html("Total nota: "+formatNumber(netox));
    $("#tiva").html( "Iva "+formatNumber(ivax));

  }

}

function verDetalles(){


  $("#tiva").css("display","");
  $("#cerrar").css("display","");

}

function cerrarDetalles(){

  $("#tiva").css("display","none");
  $("#cerrar").css("display","none");
}



///////////**************** ALTA DE NOTA DE CREDITO

function showPDFfactura(idnotax){

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/pdf_nota_descuento.php",
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

        $("#btn_finalizar").prop("disabled",true);
        $("#btn_finalizar").html('<i class="fa fa-spinner fa-spin"></i>');

        verificar = 0;
       
        if ( netox == 0 ) {

            alert("Favor de agregar un monto valido para aplicar el descuento");
            verificar = 1;
            $("#desc").focus();

        }

        if ( netox > $("#idtotal").val() ) {

            alert("Favor de agregar un monto menor al total de la factura");
            verificar = 1;
            $("#desc").focus();

        }

        if ( ivax == 0 ) {

            alert("Error el iva no fue calculado correctamente, favor de volverlo a intentar");
            verificar = 1;
            $("#desc").focus();

        }

        if ( subx == 0 ) {

            alert("Error el subtotal no fue calculado correctamente, favor de volverlo a intentar");
            verificar = 1;
            $("#desc").focus();

        }

        if ( verificar == 0 ) {

            $.ajax({
                type: "POST",
                dataType: "json",
                url: base_urlx+"tw/php/crear_xml_ndescuento_facturalo.php",
                data:{

                    idfactura:$("#idfactura").val(),
                    neto:netox,
                    iva:ivax,
                    sub:subx,
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

            $("#btn_finalizar").prop("disabled",false);
            $("#btn_finalizar").html('<i class="fa fa-check"> Generar nota</i>');

        }else{

            $("#btn_finalizar").prop("disabled",false);
            $("#btn_finalizar").html('<i class="fa fa-check"> Generar nota</i>');

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