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

//alert("version 3.0");

var arrayTag=[];
var rfcValidar = 1;
var arrayDir=[];

//showDirecciones();

showFpago();
showCfdi();
showRegimen();

function showContactos(){

	if ( $("#idcliente").val() > 0 ) {

		$.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"ActCliente/showContactos/",
            data:{ idcliente:$("#idcliente").val() },
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  //var creaOption=""; 

                    $.each(result, function(i,item){
                      data1=item.id;//id
                      data2=item.nombre;//nombre
                      data3=item.puesto;
                      data4=item.telefono;
                      data5=item.correo;

                      //creaOption+='<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12"><div class="card"><div class="card-header"><div class="card-photo"><img class="img-circle avatar" src="'+base_urlx+'comanorsa/usuario.png"></div><div class="card-short-description"><h5><span class="user-name"><a href="#/">'+data2+'</a></span><span class="badge badge-primary">'+data3+'</span><span class="badge badge-danger"><a href="javascript:retirarContacto('+data1+')"><i class="fa fa-trash" style="color: white;"></i></a></span></h5><p>Correo: '+data5+'</p><p>Tel: '+data4+'</p></div></div></div></div>'; 

                    	datox = data2+"||"+data3+"||"+data4+"||"+data5;
    					arrayTag.push(datox);

                    }); 

                	view = '';

				    for (var i = 0; i < arrayTag.length; i++) {

				      separarx=arrayTag[i].split("||");
				      
				      view = view+'<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12"><div class="card"><div class="card-header"><div class="card-photo"><img class="img-circle avatar" src="'+base_urlx+'comanorsa/usuario.png"></div><div class="card-short-description"><h5><span class="user-name"><a href="#/">'+separarx[0]+'</a></span><span class="badge badge-primary">'+separarx[1]+'</span><span class="badge badge-danger"><a href="javascript:retirarContacto('+i+')"><i class="fa fa-trash" style="color: white;"></i></a></span></h5><p>Correo: '+separarx[3]+'</p><p>Tel: '+separarx[2]+'</p></div></div></div></div>';

				    }

    				$("#lista_contacto").html(view);

              }else{

                $("#lista_contacto").html("<p>Sin contactos asignados</p>");

              }
 
            }

	    }).fail( function( jqXHR, textStatus, errorThrown ) {


	        detectarErrorJquery(jqXHR, textStatus, errorThrown);

	    });

	}else{

		alert("Alerta, el id del cliente no se cargo correctamente, favor de cargar la pagina nuevamente");

	}

}

////***** MOSTRAR DIRECCIONES

function showDirecciones(){

  if ( $("#idcliente").val() > 0 ) {

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"ActCliente/showDirecciones/",
            data:{ idcliente:$("#idcliente").val() },
            cache: false,
            success: function(result)
            {

              contador = 0;

              if ( result != null ) {

                  //var creaOption=""; 

                    $.each(result, function(i,item){
                      calle=item.calle;//id
                      exterior=item.exterior;//id
                      interior=item.interior;//id
                      colonia=item.colonia;//id
                      municipio=item.municipio;//id
                      estado=item.estado;//id
                      cp=item.cp;//id
                      referencia=item.referencia;//nombre
                      //credito=item.credito;
                      //descuento=item.descuento;
                      //limite=item.limite;
                      idx=item.id;

                      //creaOption+='<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12"><div class="card"><div class="card-header"><div class="card-photo"><img class="img-circle avatar" src="'+base_urlx+'comanorsa/usuario.png"></div><div class="card-short-description"><h5><span class="user-name"><a href="#/">'+data2+'</a></span><span class="badge badge-primary">'+data3+'</span><span class="badge badge-danger"><a href="javascript:retirarContacto('+data1+')"><i class="fa fa-trash" style="color: white;"></i></a></span></h5><p>Correo: '+data5+'</p><p>Tel: '+data4+'</p></div></div></div></div>'; 

                      datox = calle+"||"+exterior+"||"+interior+"||"+colonia+"||"+municipio+"||"+estado+"||"+cp+"||"+referencia+"||"+idx;
                      arrayDir.push(datox);

                    }); 

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
                    
                    view2+='<div class="card"><div class="card-header"><div class="card-photo"> <img class="img-circle avatar" src="'+base_urlx+'comanorsa/casa.png"></div><div class="card-short-description"> <h5><span class="user-name"><a href="#/">Direccion #'+foliox+' </a></span><a href="javascript:retirarDir('+i+')"><span class="badge badge-danger"><i class="fa fa-trash"></i></span></a><a href="javascript:updateDir('+i+')"><span class="badge badge-warning"><i class="fa fa-edit" style="color:black; font-size:17px;"></i></span></a></h5><p>'+direccionx+'</p></div> </div><div class="card-content"></div></div>';

                  }

                  $("#lista_direccion").html(view2);

                  showContactos();

              }else{

                $("#lista_contacto").html("<p>Sin contactos asignados</p>");

              }
 
            }

      }).fail( function( jqXHR, textStatus, errorThrown ) {


          detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });

  }else{

    alert("Alerta, el id del cliente no se cargo correctamente, favor de cargar la pagina nuevamente");

  }

}

///***** ACTUALIZAR DIRECCIONES

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
  
  
  setTimeout(function (){
                    
    retirarDir(posicionx);             
                              
  }, 1000);


}

///****** SUMAR DIRECCIONES

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

    datox = $("#calle").val()+"||"+$("#ext").val()+"||"+$("#int").val()+"||"+$("#colonia").val()+"||"+$("#municipio").val()+"||"+$("#estado").val()+"||"+$("#cp").val()+"||"+$("#ref").val();
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

      direccionx+=", Col."+separarx[3]+", Mcpo."+separarx[4]+", "+separarx[5]+" Cp."+separarx[6]+" - "+separarx[7];

      foliox = parseFloat(i)+1;

      //view2+=direccionx;
      
      view2+='<div class="card"><div class="card-header"><div class="card-photo"> <img class="img-circle avatar" src="'+base_urlx+'comanorsa/casa.png"></div><div class="card-short-description"> <h5><span class="user-name"><a href="#/">Direccion #'+foliox+' </a></span><a href="javascript:retirarDir('+i+')"><span class="badge badge-danger"><i class="fa fa-trash"></i></span></a><a href="javascript:updateDir('+i+')"><span class="badge badge-warning"><i class="fa fa-edit" style="color:black; font-size:17px;"></i></span></a></h5><p>'+direccionx+'</p></div> </div><div class="card-content"></div></div>';

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
    //$("#descuento").val("");
    //$("#dias").val("");
    //$("#limite").val("");

     $("#calle").focus();


  }


}

////****** RETIRAR DIRECCIONES

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
      
      view2+='<div class="card"><div class="card-header"><div class="card-photo"> <img class="img-circle avatar" src="'+base_urlx+'comanorsa/casa.png"></div><div class="card-short-description"> <h5><span class="user-name"><a href="#/">Direccion #'+foliox+' </a></span><a href="javascript:retirarDir('+i+')"><span class="badge badge-danger"><i class="fa fa-trash"></i></span></a><a href="javascript:updateDir('+i+')"><span class="badge badge-warning"><i class="fa fa-edit" style="color:black; font-size:17px;"></i></span></a></h5><p>'+direccionx+'</p></div> </div><div class="card-content"></div></div>';

    }

    $("#lista_direccion").html(view2);

    $("#calle").focus();

    
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
    $("#limite").val("");

    */

}

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
                  $("#fpago").val(idfpagox).trigger('change');

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
                  $("#cfdi").val(idcfdix).trigger('change');

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
                  $("#regimen").val(idregimenx).trigger('change');

              }else{

                 $("#regimen").html("<option value='0'>Sin regimen fiscal</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {


        detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });

}


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

/////////****************** VERIFICAR RFC PROVEEDOR

function vRfc(vrfc){

  if ( vrfc != "" ) {

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"ActCliente/vRfc/",
            data:{ rfc:vrfc, idcliente:$("#idcliente").val() },
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

/*function retirarContacto(idcontactox){

	if ( idcontactox > 0) {

		x = confirm("¿Realmente deseas retirar este contacto?");

		if ( x ) {

			$.ajax({
	            type: "POST",
	            dataType: "json",
	            url: base_urlx+"ActCliente/retirarContacto/",
	            data:{ idcontacto:idcontactox },
	            cache: false,
	            success: function(result)
	            {

	              if ( result ) {

	                alert("Alerta, el contacto ha sido retirado");
	                showContactos();
	                  
	              }else{

	                alert("Error, favor de intentarlo nuevamente");

	              }
	 
	            }

		    }).fail( function( jqXHR, textStatus, errorThrown ) {


		        detectarErrorJquery(jqXHR, textStatus, errorThrown);

		    });

		}

	}else{

		alert("Error, favor de recargar la pagina e intentarlo nuevamente");

	}

}*/

//////////*************** ALTA DE CLIENTES 

function actCli(){

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

  if ( verificar == 0 ) {

    $("#btn_finalizar").prop("disabled",true);
    $("#btn_finalizar").html("Actualizando cliente...");

     $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"ActCliente/actCli/",
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
              //direccionex:arrayDir.toString(),
              regimenx:$("#regimen").val(),

              idcliente:$("#idcliente").val()


            },
            cache: false,
            success: function(result)
            {

              if ( result > 0 ) {

                alert("La actualizacion fue realizada correctamente");
                window.location.href=base_urlx+'Rclientes';

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

function cancelarActcliente(){

	window.location.href=base_urlx+'Rclientes';

}

function cerrarSesion(){

    var x = confirm("¿Realmente deseas cerrar la sesión?");

    if( x==true ){

      window.location.href = base_urlx+"Login/CerrarSesion/";
      
    }  

}