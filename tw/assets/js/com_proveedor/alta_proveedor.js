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



/////******* INCIAMOS SELECT 2



$(document).ready(function() {



    $(".select2").select2();

    $(".select2-placeholer").select2({

      allowClear: true



    });



} );



showFpago();

showCfdi();



var rfcValidar = 0;

var arrayTag=[];



/////////****************** SELECT FORMA DE PAGO



function showFpago(){



  $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"AltaProveedor/showFpago/",

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  var creaOption="<option value='0'>Selecciona una forma de pago...</option>"; 



                  $.each(result, function(i,item){

                      data1=item.clave;//id

                      data2=item.descripcion;//nombre

                      data3=item.id;

                      

                      creaOption=creaOption+'<option value="'+data3+'">'+data1+' - '+data2+'</option>'; 

                  }); 



                  $("#fpago").html(creaOption);

                  $("#fpago").val(0);



              }else{



                 $("#fpago").html("<option value='0'>Sin formas de pago</option>");



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



      });



}





/////////****************** SELECT USO DE CFDI



function showCfdi(){



  $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"AltaProveedor/showCfdi/",

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  var creaOption="<option value='0'>Selecciona un uso de CFDI...</option>"; 



                  $.each(result, function(i,item){

                      data1=item.clave;//id

                      data2=item.descripcion;//nombre

                      data3=item.id;

                      

                      creaOption=creaOption+'<option value="'+data3+'">'+data1+' - '+data2+'</option>'; 

                  }); 



                  $("#cfdi").html(creaOption);

                  $("#cfdi").val(0);



              }else{



                 $("#cfdi").html("<option value='0'>Sin usos de CFDI</option>");



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



      });



}





/////////****************** VERIFICAR RFC PROVEEDOR



function vRfc(vrfc){



  if ( vrfc != "" ) {



    $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"AltaProveedor/vRfc/",

            data:{rfc:vrfc},

            cache: false,

            success: function(result)

            {



              if ( result > 0 ) {



                alert("Alerta, el RFC ya existe favor de verificarlo ");



                $("#rfc").val("");



                $("#txtrfc").html("*RFC");



                rfcValidar = 0;



              }else{



                $("#txtrfc").html("*RFC <strong style='color:green'>(validado)</strong>");



                rfcValidar = 1;



              }

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



  }else{



    $("#txtrfc").html("*RFC <strong style='color:red'>(sin validar)</strong>");



  }



}



//////////******** NUEVO CONTACTO PROVEEDOR



function sumarContacto(){



  verificar = 0;



  if ( $("#contacto").val() == "" && verificar == 0 ){



    alert("Alerta, favor de ingresar un contacto valido");

    $("#contacto").focus();

    verificar = 1;



  }

  if ( $("#depa").val() == "" && verificar == 0 ){



    alert("Alerta, favor de ingresar un departamento valido");

    $("#depa").focus();

    verificar = 1;



  }

  if ( $("#telefono").val() == "" && verificar == 0 ){



    alert("Alerta, favor de ingresar un telefono valido");

    $("#telefono").focus();

    verificar = 1;



  }



  if ( verificar == 0 ) {



    datox = $("#contacto").val()+"||"+$("#depa").val()+"||"+$("#telefono").val()+"||"+$("#correo").val();

    arrayTag.push(datox);



    view = '';



    for (var i = 0; i < arrayTag.length; i++) {



      separarx=arrayTag[i].split("||");

      

      view = view+'<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12"><div class="card"><div class="card-header"><div class="card-photo"><img class="img-circle avatar" src="'+base_urlx+'comanorsa/usuario.png"></div><div class="card-short-description"><h5><span class="user-name"><a href="#/">'+separarx[0]+'</a></span><span class="badge badge-primary">'+separarx[1]+'</span><span class="badge badge-danger"><a href="javascript:retirarContacto('+i+')"><i class="fa fa-trash" style="color: white;"></i></a></span></h5><p>Correo: '+separarx[3]+'</p><p>Tel: '+separarx[2]+'</p></div></div></div></div>';



    }



    $("#lista_contacto").html(view);



    $("#contacto").val("");

    $("#depa").val("");

    $("#telefono").val("");

    $("#correo").val("");



    $("#contacto").focus();



  }





}



function retirarContacto(idx){



  arrayTag.splice(idx, 1);



  $("#viewtags").html("");



  view = '';



    for (var i = 0; i < arrayTag.length; i++) {



      separarx=arrayTag[i].split("||");

      

      view = view+'<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12"><div class="card"><div class="card-header"><div class="card-photo"><img class="img-circle avatar" src="'+base_urlx+'comanorsa/usuario.png"></div><div class="card-short-description"><h5><span class="user-name"><a href="#/">'+separarx[0]+'</a></span><span class="badge badge-primary">'+separarx[1]+'</span><span class="badge badge-danger"><a href="javascript:retirarContacto('+i+')"><i class="fa fa-trash" style="color: white;"></i></a></span></h5><p>Correo: '+separarx[3]+'</p><p>Tel: '+separarx[2]+'</p></div></div></div></div>';



    }



  $("#lista_contacto").html(view);



  $("#contacto").focus();



}





//////////*************** ALTA DE PROVEEDOR 



function altaPro(){



  verificar = 0;



  

  if ( $("#nfiscal").val() <= 0 && verificar == 0 ){



    alert( "Alerta, favor de agregar un nombre de proveedor valido" );

    $("#nfiscal").focus();

    verificar = 1;



  }



  if ( rfcValidar == 0 && verificar == 0 ){



    alert( "Alerta, favor de agregar un RFC valido" );

    $("#rfc").focus();

    verificar = 1;



  }


  if( $("#dias").val()>0 && verificar==0 || $("#limite").val()>0 && verificar==0 ){

      if( $("#limite").val()<=0 && verificar==0 || $("#limite").val() == "" && verificar==0 ){

        verificar=1;
        alert("Alerta, favor de ingresar un limite de credito valido");

      }else if( $("#dias").val()<=0 && verificar==0 || $("#dias").val() == "" && verificar==0 ){

        verificar=1;
        alert("Alerta, favor de ingresar dias de credito mayor a 0");

      }

  }

  if ( verificar == 0 ) {



    $("#btn_finalizar").prop("disabled",true);

    $("#btn_finalizar").html("Ingresando proveedor...");



     $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"AltaProveedor/altaPro/",

            data:{



              nombre:$("#nfiscal").val(),

              comercial:$("#ncomercial").val(),

              rfc:$("#rfc").val(),

              contacto:$("#contacto").val(),

              telefono:$("#telefono").val(),

              celular:$("#telefono2").val(),

              correo:$("#correo").val(),

              calle:$("#calle").val(),

              exterior:$("#ext").val(),

              interior:$("#int").val(),

              colonia:$("#colonia").val(),

              municipio:$("#municipio").val(),

              estado:$("#estado").val(),

              cp:$("#cp").val(),

              referencia:$("#ref").val(),

              idfpago:$("#fpago").val(),

              idcfdi:$("#cfdi").val(),

              contactox:arrayTag.toString(),

              diasx:$("#dias").val(),

              limitex:$("#limite").val()



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

              $("#btn_finalizar").html("<i class='icon-right'></i> Ingresar proveedor");

 

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









