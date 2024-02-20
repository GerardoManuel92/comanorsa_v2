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



/////*******



//alert("version 7.0");

$(document).ready(function() {



    $(".select2").select2();

    $(".select2-placeholer").select2({

      allowClear: true



    });



} );





showFpago();

showCfdi();

showRegimen();



var rfcValidar = 0;

var arrayTag=[];

var arrayDir=[];

var arrayBanco=[];



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



/////////****************** SELECT REGIMEN FISCAL



function showRegimen(){



  $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"AltaCliente/showRegimen/",

            cache: false,

            success: function(result)

            {



              if ( result != null ) {



                  var creaOption="<option value='0'>Selecciona un regimen fiscal...</option>"; 



                  $.each(result, function(i,item){

                      data1=item.id;//id

                      data2=item.clave;//nombre

                      data3=item.regimen;

                      

                      creaOption=creaOption+'<option value="'+data1+'">'+data2+' - '+data3+'</option>'; 

                  }); 



                  $("#regimen").html(creaOption);

                  $("#regimen").val(0);



              }else{



                 $("#regimen").html("<option value='0'>Sin regimen fiscal</option>");



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

            url: base_urlx+"AltaCliente/vRfc/",

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



////////*******actualizar cliente info



function updateDir(posicionx){



  //calle+"||"+exterior+"||"+interior+"||"+colonia+"||"+municipio+"||"+estado+"||"+cp+"||"+referencia+"||"+descuento+"||"+credito+"||"+limite+"||"+idx

  //alert(arrayDir[posicionx]);



  //acomodar en los input

  infox=arrayDir[posicionx].split("||");



  $("#calle").val(infox[0]);

  $("#ext").val(infox[1]);

  $("#int").val(infox[2]);

  $("#colonia").val(infox[3]);

  $("#municipio").val(infox[4]);

  $("#estado").val(infox[5]);

  $("#cp").val(infox[6]);

  $("#ref").val(infox[7]);

  //$("#descuento").val(infox[8]);

  //$("#dias").val(infox[9]);

  //$("#limite").val(infox[10]);



  

  setTimeout(function (){

                    

    retirarDir(posicionx);             

                              

  }, 1000);





}



//////////******** NUEVA DIRECCION CLIENTE



function sumarDir(){



  verificar = 0;



  if ( $("#calle").val() == "" && verificar == 0 ){



    alert("Alerta, favor de ingresar una calle valida");

    $("#calle").focus();

    verificar = 1;



  }

  if ( $("#colonia").val() == "" && verificar == 0 ){



    alert("Alerta, favor de ingresar una colonia valido");

    $("#colonia").focus();

    verificar = 1;



  }

  if ( $("#municipio").val() == "" && verificar == 0 ){



    alert("Alerta, favor de ingresar un municipio valido");

    $("#municipio").focus();

    verificar = 1;



  }



  if ( $("#estado").val() == "" && verificar == 0 ){



    alert("Alerta, favor de ingresar un estado valido");

    $("#estado").focus();

    verificar = 1;



  }



  if ( $("#cp").val() == "" && verificar == 0 ){



    alert("Alerta, favor de ingresar un cp valido");

    $("#cp").focus();

    verificar = 1;



  }







  if ( verificar == 0 ) {



    datox = $("#calle").val()+"||"+$("#ext").val()+"||"+$("#int").val()+"||"+$("#colonia").val()+"||"+$("#municipio").val()+"||"+$("#estado").val()+"||"+$("#cp").val()+"||"+$("#ref").val()+"||";

    arrayDir.push(datox);



    //alert("longitud:"+arrayDir.length+" datos:"+arrayDir[0]);



    view2 = '';

    direccionx ='';

    foliox = '';



    for (var i = 0; i < arrayDir.length; i++) {



      separarx=arrayDir[i].split("||");





      



      direccionx="Calle "+separarx[0];



      if ( separarx[1] != "" ) {



        direccionx+=" Ext."+separarx[1]



      } 



      if ( separarx[2] != "" ) {



        direccionx+=" Int."+separarx[2];



      }



      direccionx+=", Col."+separarx[3]+", Mcpio."+separarx[4]+", "+separarx[5]+" Cp."+separarx[6]+" - "+separarx[7];



      foliox = parseFloat(i)+1;



      //view2+=direccionx;

      

      view2+='<div class="card"><div class="card-header"><div class="card-photo"> <img class="img-circle avatar" src="'+base_urlx+'comanorsa/casa.png"></div><div class="card-short-description"> <h5><span class="user-name"><a href="#/">Direccion #'+foliox+' </a></span><a href="javascript:retirarDir('+i+')"><span class="badge badge-danger"><i class="fa fa-trash"></i></span></a><a href="javascript:updateDir('+i+')"><span class="badge badge-warning"><i class="fa fa-edit" style="color:black; font-size:17px;"></i></span></a></h5><p>'+direccionx+'</p></div> </div><div class="card-content"><ul class="list-inline list-action" style="color: darkblue; font-weight: bold; font-size: 14px;"></ul></div></div>';



    }



    $("#lista_direccion").html(view2);



    

    $("#calle").val("");

    $("#ext").val("");

    $("#int").val("");

    $("#colonia").val("");

    $("#municipio").val("");

    $("#estado").val("");

    $("#cp").val("");

    $("#ref").val("");

    $("#descuento").val("");

    $("#dias").val("");

    $("#limite").val("");



     $("#calle").focus();





  }





}



function retirarDir(idx){



  arrayDir.splice(idx, 1);



  $("#lista_direccion").html("");



   view2 = '';

    direccionx ='';

    foliox = '';



    for (var i = 0; i < arrayDir.length; i++) {



      separarx=arrayDir[i].split("||");





      



      direccionx=separarx[0];



      if ( separarx[1] != "" ) {



        direccionx+=" #"+separarx[1]



      } 



      if ( separarx[2] != "" ) {



        direccionx+=" Int."+separarx[2];



      }



      direccionx+=", "+separarx[3]+", "+separarx[4]+", "+separarx[5]+" Cp."+separarx[6]+" - "+separarx[7];



      foliox = parseFloat(i)+1;



      //view2+=direccionx;

      

      view2+='<div class="card"><div class="card-header"><div class="card-photo"> <img class="img-circle avatar" src="'+base_urlx+'comanorsa/casa.png"></div><div class="card-short-description"> <h5><span class="user-name"><a href="#/">Direccion #'+foliox+' </a></span><a href="javascript:retirarDir('+i+')"><span class="badge badge-danger"><i class="fa fa-trash"></i></span></a><a href="javascript:updateDir('+i+')"><span class="badge badge-warning"><i class="fa fa-edit" style="color:black; font-size:17px;"></i></span></a></h5><p>'+direccionx+'</p></div> </div><div class="card-content"><ul class="list-inline list-action" style="color: darkblue; font-weight: bold; font-size: 14px;"></ul></div></div>';



    }



    $("#lista_direccion").html(view2);



    

    /*$("#calle").val("");

    $("#ext").val("");

    $("#int").val("");

    $("#colonia").val("");

    $("#municipio").val("");

    $("#estado").val("");

    $("#cp").val("");

    $("#ref").val("");

    $("#descuento").val("");

    $("#dias").val("");

    $("#limite").val("");*/



     $("#calle").focus();



}





//////////*************** ALTA DE CLIENTES 



function altaCli(){



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



  if ( $("#fpago").val() == 0 || $("#fpago").val() == null ) {



    alert("Alerta, favor de agregar una forma de pago valida");

    $("#fpago").focus();

    verificar = 1;



  }

  if ( $("#cfdi").val() == 0 || $("#cfdi").val() == null ) {



    alert("Alerta, favor de agregar un uso de cfdi valido");

    $("#cfdi").focus();

    verificar = 1;



  }

  if ( $("#regimen").val() == 0 || $("#regimen").val() == null ) {



    alert("Alerta, favor de agregar un regimen fiscal valido");

    $("#regimen").focus();

    verificar = 1;



  }



  if ( verificar == 0 ) {



    $("#btn_finalizar").prop("disabled",true);

    $("#btn_finalizar").html("Ingresando cliente...");



     $.ajax({

            type: "POST",

            dataType: "json",

            url: base_urlx+"AltaCliente/altaCli/",

            data:{


              nombre:$("#nfiscal").val(),

              comercial:$("#ncomercial").val(),

              rfc:$("#rfc").val(),

             

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

              descuento:$("#descuento").val(),

              credito:$("#dias").val(),

              limite:$("#limite").val(),

              contactox:arrayTag.toString(),

              regimenx:$("#regimen").val(),

              //direccionesx:arrayDir.toString(),

              //bancox:arrayBanco.toString()





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

              $("#btn_finalizar").html("<i class='icon-right'></i> Ingresar cliente");

 

            }



    }).fail( function( jqXHR, textStatus, errorThrown ) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



    });



  }



}



///////****************** AÑADIR CUENTAS BANCARIAS

function sumarBanco(){

  verificar = 0;

  if ( $("#cuenta").val() == "" && verificar == 0 ){



    alert("Alerta, favor de ingresar una cuenta valida");

    $("#cuenta").focus();

    verificar = 1;



  }


  if ( verificar == 0 ) {

    $("#lista_cuentas").html("");

    separarx=$('select[name="lista_banco"] option:selected').text().split("//");

    bdatox = $("#lista_banco").val()+"||"+separarx[0]+"||"+separarx[1]+"||"+$("#cuenta").val();

    arrayBanco.push(bdatox);

    //alert("longitud:"+arrayDir.length+" datos:"+arrayDir[0]);

    view2 = '';

    for (var i = 0; i < arrayBanco.length; i++) {

      separarx2=arrayBanco[i].split("||");


      view2+='<div class="col-md-6 col-lg-6"><div class="card"><div class="card-header"><div class="card-photo"><img class="img-circle avatar" src="'+base_urlx+'comanorsa/banco2.png" alt="" title=""></div><div class="card-short-description"><h5><span class="user-name"><a href="#/">RFC: '+separarx2[1]+' - '+separarx2[2]+' </a></span><a href="javascript:eliminarBanco('+i+')"><span class="badge badge-danger"><i class="fa fa-trash"></i></span></a></h5><p>CUENTA: '+separarx2[3]+'</p></div></div></div></div>';



    }

    $("#lista_cuentas").html(view2);
    $("#cuenta").val("");

    $("#cuenta").focus();


  }





}



function eliminarBanco(idx){

  arrayBanco.splice(idx, 1);

  $("#lista_cuentas").html("");

  view2 = '';

  for (var i = 0; i < arrayBanco.length; i++) {

      separarx2=arrayBanco[i].split("||");


      view2+='<div class="col-md-6 col-lg-6"><div class="card"><div class="card-header"><div class="card-photo"><img class="img-circle avatar" src="'+base_urlx+'comanorsa/banco2.png" alt="" title=""></div><div class="card-short-description"><h5><span class="user-name"><a href="#/">RFC: '+separarx2[1]+' - '+separarx2[2]+' </a></span><a href="javascript:eliminarBanco('+i+')"><span class="badge badge-danger"><i class="fa fa-trash"></i></span></a></h5><p>CUENTA: '+separarx2[3]+'</p></div></div></div></div>';



    }

  $("#lista_cuentas").html(view2);    

    

}


function cerrarSesion(){



    var x = confirm("¿Realmente deseas cerrar la sesión?");



    if( x==true ){



      window.location.href = base_urlx+"Login/CerrarSesion/";

      

    }  



}



