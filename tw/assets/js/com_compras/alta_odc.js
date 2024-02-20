//alert("version 2.0");

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

var table;
var idxt = "";
var colx = "";
var editId = 0;
var idFila = "";
var idFilaclick = "";
var editCantidad = 0;
var editCosto = 0;
var total_sub = 0;
var total_desc = 0;
var total_iva = 0;
var cantidadx = 0;
var piva = 0;
var pedidox=0;
var almacenx = 0;

////*** SUMA DE TOTALES
function sumaTotal(){
  //6 :ccantidad

  total_sub =0;
  total_desc =0;
  total_iva =0;

  $("#tsubtotal").html("Calculando...");
  $("#tneto").html("Calculando...");

  $('#my-table').DataTable().rows().data().each(function(el, index){
    //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria

    spedido = el[4];
    salmacen = el[5];
    scosto= el[8];
    sdesc = el[9];
    siva = el[10];


    //////// CALCULAR LO SOLICITADO PARA ODC

    if ( spedido > salmacen ) {

      scant = parseFloat(spedido)-parseFloat(salmacen);

    }else{

      scant = 0;

    }

    subtotal = round(scant)*round(scosto.replace(/[^\d.]/g,""));
    desc = round(subtotal)*(sdesc/100);
    sub_descuento = parseFloat(subtotal)-parseFloat(desc);
    iva = round(sub_descuento)*round(siva/100);

    total_sub = parseFloat(total_sub)+parseFloat(subtotal);
    total_desc = parseFloat(total_desc)+parseFloat(desc);
    total_iva = parseFloat(total_iva)+parseFloat(iva);

    //alert(el[6]);

  });

  total_neto = parseFloat(total_sub)-parseFloat(total_desc)+parseFloat(total_iva);

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

      if ( colx == 0 || colx == 1 ) {

        ///////// estas columnas ya las bloquee en la crecion de la tabla, pero deje este codigo vivo para futuras referncias
        row.invalidate()

      }else{


        if ( almacenx >= pedidox ) {

          solicitarx = 0

        }else{

          solicitarx = parseFloat(pedidox)-parseFloat(almacenx);

        }

        validar = 0;

        if ( colx == 7 ) {

          if ( parseFloat(e.target.textContent) > parseFloat(solicitarx)  ) {

            alert("Alerta, no se puede ingresar una cantidad mayor a la requerida");
            row.invalidate();
            validar=1;

          }else{

            validar=0

          }

        }

        

        if ( validar == 0 ){

          $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Asignaroc/updateCelda/",
            data:{

              texto:e.target.textContent,
              columna:colx,
              idpcot:editId,
              iva:piva,
              pedido:pedidox,
              almacen:almacenx

            },
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                //alert("columna"+colx);
                temp = table.row(idFila).data();
                  ////////calcular subtotal

                  //alert("columna: "+colx+" fila:"+idFila);

                  if ( colx == 8 ) {

                    pcosto = e.target.textContent.replace(/[^\d.]/g,"");
                    subtotalx = pcosto*cantidadx;

                    //alert("subtotal="+subtotalx);

                    temp[8] = formatNumber( round(pcosto) );
                    temp[11] = formatNumber( round(subtotalx) );
                    $('#my-table').dataTable().fnUpdate(temp,idFila,undefined,false);
                    

                  }else if ( colx == 9 ) {

                    temp[9] = round(e.target.textContent);
                    $('#my-table').dataTable().fnUpdate(temp,idFila,undefined,false);

                  }else if ( colx == 7 ) {

                    temp[14] = round(e.target.textContent);

                    alert(e.target.textContent);
                    $('#my-table').dataTable().fnUpdate(temp,idFila,undefined,false);

                  }

                  //table.ajax.reload();

                  sumaTotal();
            
              }else{

                row.invalidate();
                alert("Alerta, favor de intentar actualizarlo nuevamente");

              }

            }

          });

        }

      }
      
    }

  })
}

//////////************************** CALCULAR SUBTOTAL

function calcularSubtotal(cantx,costox,descx,ivax){

  costo = costox.replace(/[^\d.]/g,"");

  subx = round(costo*cantx);

  return  formatNumber(subx);

  /*cdesc = parseFloat(subx)-parseFloat( subx*(descx/100) );

  subxdesc = parseFloat(subx)-parseFloat(round(cdesc));*/

}

function calcularSolicitar(pedidox,almacenx,cantidadocx){

  if ( cantidadocx > 0 ) {

    return cantidadocx;

  }else{

    if ( almacenx >= pedidox ) {

    return 0;

    }else{

      return parseFloat(pedidox)-parseFloat(almacenx);  

    }

  }


}

function calcularRequerido(pedidox,almacenx){

  if ( almacenx >= pedidox ) {

    return 0;

  }else{

    return parseFloat(pedidox)-parseFloat(almacenx);  

  }

  
  //return 20;

}

/*function calcularPedido(pedidox,almacenx){


  if ( parseFloat(almacenx) > parseFloat(pedidox) || parseFloat(almacenx) == parseFloat(pedidox)) {

    solicitar = 0;

  }else{

    solicitar = parseFloat(pedidox)-parseFloat(almacenx);

  }

  return solicitar;

}

/////////////*********** INICIAL

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
       
        },

        dom: '<"top"B fpl>rt',

        buttons: [ 'copy', 'excel' , 'csv'],
        "order": [  [ 1, "desc" ] ],

        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            
            if ( true ) // your logic here
              {

                $(nRow).addClass( 'customFont' );

                $('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' ).addClass( 'bgcolor1' );
                $('td:eq(1)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );
                $('td:eq(4)', nRow).addClass( 'alignCenter' );

                $('td:eq(3)', nRow).addClass( 'fontText2' );
                $('td:eq(5)', nRow).addClass( 'alignCenter' );
                $('td:eq(6)', nRow).addClass( 'alignCenter' );

                $('td:eq(7)', nRow).addClass( 'alignRight' );
                $('td:eq(8)', nRow).addClass( 'alignRight' );
                $('td:eq(9)', nRow).addClass( 'alignRight' );
                $('td:eq(10)', nRow).addClass( 'alignRight' ).addClass( 'fontText3' );

                //$('td:eq(2)', nRow).addClass( 'fontText2' );
                
              }
        },
        columnDefs: [

            { 
              targets: [7,8,6],
              createdCell: createdCell
            },

            {
               targets: [6],
               data: null,
               render: function ( data, type, row, meta ) {                   
                

                  valor=calcularSolicitar( data[4],data[5] );

                  return ``+valor+``         

               }

               
            },

           
            {
               targets: [10],
               data: null,
               render: function ( data, type, row, meta ) {                   
              

                  valor2=calcularSubtotal( data[4],data[7],data[8],data[9] );

                  return ``+valor2+``         

               }

            }

        ],

        "processing": true,
        "serverSide": true,
        "search" : false,
        "ajax": base_urlx+"Asignaroc/loadPartidas?cot=0",

      "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]],

        "scrollY": 300,
        "scrollX": true
    });

    ////////////// FOCUS IN 

    $('#my-table tbody').on('focusin', 'tr', function () {
        var data = table.row( this ).data();


        editId = data[11];
        almacenx = data[5];
        pedidox = data[4];
        piva = data[9];

        if ( pedidox > almacenx ) {

          cantidadx = parseFloat(pedidox)-parseFloat(almacenx);

        }else{

          cantidadx = 0;

        }
        
        //idFila = table.row( this ).index();
        //idColumn = table.cell( this ).index().column;

        
        

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

});*/

function showDias(idprox){

  $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Asignaroc/showDias/",
            data:{

              idprov:idprox

            },
            cache: false,
            success: function(result)
            {

              //alert(result.dias);
              $("#dias").val(result.dias);

            }


  });

}

function showxproveedor(){

  $("#documento").val(0);

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

          dom: '<"top" fpl>rt',

          buttons: [ 'copy', 'excel' , 'csv'],
          "order": [  [ 1, "desc" ] ],

          "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
              /* Append the grade to the default row class name */
              if ( true ) // your logic here
                {

                  $(nRow).addClass( 'customFont' );

                  $('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' ).addClass( 'bgcolor1' );
                  $('td:eq(1)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );
                  $('td:eq(4)', nRow).addClass( 'alignCenter' );

                  $('td:eq(3)', nRow).addClass( 'fontText2' );
                  $('td:eq(5)', nRow).addClass( 'alignCenter' ).addClass( 'color_red' ).addClass( 'bold' );
                  $('td:eq(6)', nRow).addClass( 'alignCenter' ).addClass( 'color_green' ).addClass( 'bold' );

                  $('td:eq(7)', nRow).addClass( 'alignCenter' ).addClass( 'bold' );
                  $('td:eq(8)', nRow).addClass( 'alignRight' );
                  $('td:eq(9)', nRow).addClass( 'alignRight' );
                  $('td:eq(10)', nRow).addClass( 'alignRight' ).addClass( 'fontText3' );
                  $('td:eq(11)', nRow).addClass( 'alignRight' ).addClass( 'fontText3' );

                  //$('td:eq(2)', nRow).addClass( 'fontText2' );
                  
                }
          },
          columnDefs: [

              { 
                targets: [7,8],
                createdCell: createdCell
              },

              {
                 targets: [6],
                 data: null,
                 render: function ( data, type, row, meta ) {                   
                  

                    valor=calcularRequerido( data[4],data[5] );

                    return ``+valor+``         

                 }

                 
              },

              {
                 targets: [7],
                 data: null,
                 render: function ( data, type, row, meta ) {                   
                  

                    valor=calcularSolicitar( data[4],data[5],data[14] );

                    return ``+valor+``         

                 }

                 
              },

              {
                 targets: [11],
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

                    valor2=calcularSubtotal( data[4],data[8],data[9],data[10] );

                    return ``+valor2+``         

                 }

                 
              }

          ],

          "processing": true,
          "serverSide": true,
          "search" : false,
          "ajax": base_urlx+"Asignaroc/loadPartidaspro?idpro="+$("#proveedor").val(),

        "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]],

          "scrollY": 300,
          "scrollX": true
    });

    ////////// NOMBRE PROVEEDOR PARA ODC

    if ( $("#proveedor").val() > 1 ) {

      $("#btn_odc").css("display", "");
      $("#titulo").html( '<strong style="color:white;">Generar ODC a: '+$('select[name="proveedor"] option:selected').text()+'<strong>' );

    }else{

      $("#btn_odc").css("display", "none");

    }

    ////////////// FOCUS IN 

    $('#my-table tbody').on('focusin', 'tr', function () {
        var data = table.row( this ).data();


        editId = data[12];
        almacenx = data[5];
        pedidox = data[4];

        if ( pedidox > almacenx ) {

          cantidadx = parseFloat(pedidox)-parseFloat(almacenx);

        }else{

          cantidadx = 0;

        }

        console.log(editId);
        
        //idFila = table.row( this ).index();
        //idColumn = table.cell( this ).index().column;

        
        

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

    $("#tneto").html("Calculando...");

    setTimeout(function (){

        sumaTotal();              
                  
    }, 2000);


    /////******** traer los dias de credito 

    showDias($("#proveedor").val());

}

	/*$('td').click(function(){ 

        var col = $(this).parent().children().index($(this)); 
        var row = $(this).parent().parent().children().index($(this).parent()); 
        //alert('Row: ' + row + ', Column: ' + col); 

        alert(row);

    });*/
showProveedor();
showDocumentos();

/////////****************** SELECT CATEGORIAS

function showProveedor(){

  	$.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Asignaroc/showProveedor/",
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption="<option value='0' selected>Selecciona a un proveedor...</option><option value='1' selected>Sin asignar...</option>"; 

                  $.each(result, function(i,item){
                      data1=item.id;//id
                      data2=item.rfc;//nombre
                      data3=item.nombre;//id
                      data4=item.comercial;//nombre
                      creaOption=creaOption+'<option value="'+data1+'">'+data2+'-'+data3+' <strong style="color:darkblue;">'+data4+'</strong></option>'; 
                  }); 

                  $("#proveedor_asig").html(creaOption);
                  //$("#proveedor_asig").val(0).trigger('change');

              }else{

                 $("#proveedor").html("<option value='0'>Sin proveedores</option>");

              }

              showProAsignado();
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {

        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

function showProAsignado(){

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Asignaroc/showProAsignado/",
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption="<option value='1' selected>Proveedores asignados...</option>"; 

                  $.each(result, function(i,item){
                      data1=item.idprox;//id
                      data3=item.nombre;//id
                      data4=item.comercial;//nombre

                      if (data1 == 1) {

                        creaOption=creaOption+'<option value="'+data1+'" selected>'+data3+' <strong style="color:darkblue;">'+data4+'</strong></option>'; 

                      }else{

                        creaOption=creaOption+'<option value="'+data1+'">'+data3+' <strong style="color:darkblue;">'+data4+'</strong></option>'; 

                      }

                      
                  }); 

                  $("#proveedor").html(creaOption);
                  //$("#proveedor").val(1).trigger('change');

              }else{

                 $("#proveedor").html("<option value='0'>Sin proveedores asignados</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {

        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

function showDocumentos(){

    $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Asignaroc/showDocumentos/",
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption="<option value='0' selected>Ver todos...</option>"; 

                  $.each(result, function(i,item){
                      data1=item.idcotx;//id
                      data2=item.documento;//nombre
                      data3=item.clientex;//id
                    
                      creaOption=creaOption+'<option value="'+data1+'">'+data2+'-'+data3+'</option>'; 
                  }); 

                  $("#documento").html(creaOption);
                  $("#documento").val(0).trigger('change');

              }else{

                 $("#proveedor").html("<option value='0'>Sin documentos</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {

        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

//////////////**************** INGRESAR PARTIDAS AL TEMPORAL

function asignarPartidas(){

	verificar = 0;

  menu = new Array(); //MENUS SELECCIONADOS

        for(var i=0;i<$("input[name='menux']:checked").length;i++){

            menu.push($("input[name='menux']:checked")[i].value);
        }

  if ( $("input[name='menux']:checked").length == 0 ) {

      verificar = 1;
      alert("Favor de seleccionar por lo menos un producto para su asignación");

  }

  if ( $("#proveedor_asig").val() == 0 && verificar == 0 ) {

    verificar = 1;
    alert("Favor de seleccionar un proveedor para su asignacion");
    $("#proveedor_asig").focus();

  }


	if ( verificar == 0 ) {

		$("#btn_asignar").prop("disabled",true);
	  $("#btn_asignar").html('<i class="fa fa-spinner fa-spin"></i>');

		$.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Asignaroc/asignarPartidas/",
            data:{

            	idpoc:menu,
            	idpro:$("#proveedor_asig").val()

            },
            cache: false,
            success: function(result)
            {

            	if ( result ) {
   
                alert("Las partidas se asignaron correctamente");
                location.reload();

        		  }else{

                alert("Error, favor de intentarlo nuevamente si persiste el problema favor de comunicarse con el administrador del portal");

              }

        			$("#btn_asignar").prop("disabled",false);
    	    		$("#btn_asignar").html('Asignar');
     
            }

		}).fail( function( jqXHR, textStatus, errorThrown ) {


		    detectarErrorJquery(jqXHR, textStatus, errorThrown);

		});

	}

}

function showPDF(idcotx){

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"tw/php/pdf_odc_comanorsa.php",
          data:{ 

              idoc:idcotx

            },
          cache: false,
          success: function(result)
          {

            enviarCorreo(idcotx);
            /*window.open(base_urlx+"tw/php/ordencompra/odc"+idcotx+".pdf", "_blank");
            alert("Alerta, la orden de compra se almaceno correctamente")
            location.reload();*/
          }

      }); 


}

function enviarCorreo(idcotx){

      $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"Asignaroc/enviarCorreo",
          data:{ 

              idodc:idcotx

            },
          cache: false,
          success: function(result)
          {

            window.open(base_urlx+"tw/php/ordencompra/odc"+idcotx+".pdf", "_blank");

            if (result ) {
              
              alert("Alerta, la orden de compra se almaceno correctamente y ha sido enviada")
              
            }else{

              alert("Alerta, la orden de compra se almaceno correctamente");              

            }

            location.reload();

          }

      }); 


}



/*function tCambiox(){

  $("#tcambio").css("disabled", false);
  $("#tcambio").focus();

}*/


////////////////******************* FINALIZAR OC

function generarOC(){

  x = confirm("¿Realmente deseas generar la ORDEN DE COMPRA?");

  if ( x ) {

    $("#btngenerar").prop("disabled",true);
    $("#btngenerar").html('Generando...');

    verificar = 0;

      $('#my-table').DataTable().rows().data().each(function(el, index){

        //verificar si un costo esta en 0
        if ( el[8].replace(/[^\d.]/g,"") <= 0 && verificar == 0) {

          verificar = 1;

          alert("Alerta, uno o mas productos no tiene un costo valido favor de revisarlos");

        }
       

      });

    if ( $("#proveedor").val() == 0 && verificar == 1  || $("#proveedor").val() == 1 && verificar == 1  ) {

      alert("Alerta, favor de seleccionar un proveedor valido");
      verificar = 1;
      $("#proveedor").focus();

    }

    if ( verificar == 0 ) {

      $("#btngenerar").prop("disabled",true);
      $("#btngenerar").html('Generando...');

      $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Asignaroc/finalizarOc/",
            data:{

              idpro:$("#proveedor").val(),
              iduser:iduserx,
              entrega:$("#entrega").val(),
              dias:$("#dias").val(),
              obs:$("#obs").val(),
              moneda:$("#moneda").val()

            },
            cache: false,
            success: function(result)
            {

              if ( result > 0 ) {

                //alert("Alerta, la ORDEN DE COMPRA se almaceno correctamente");

                showPDF(result);

              }else{

                alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");

              }

              $("#btngenerar").prop("disabled",false);
              $("#btngenerar").html('Generar ODC');

            }

      }).fail( function( jqXHR, textStatus, errorThrown ) {


          detectarErrorJquery(jqXHR, textStatus, errorThrown);

      });

      
    }else{

      $("#btngenerar").prop("disabled",false);
      $("#btngenerar").html('Generar ODC');

    }

  }

}


//////****************** IMPLEMENTACION DE JAVA SCRIPT

$("#documento").change(function() {
    //const resultado = document.querySelector('.resultado');
    //resultado.textContent = `Te gusta el sabor ${event.target.value}`;

    $("#proveedor").val(0);

    $('#my-table').DataTable().destroy();

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

        dom: '<"top"B fpl>rt',

        buttons: [ 'copy', 'excel' , 'csv'],
        "order": [  [ 1, "desc" ] ],

        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            /* Append the grade to the default row class name */
            if ( true ) // your logic here
              {

                $(nRow).addClass( 'customFont' );

                $('td:eq(0)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' ).addClass( 'bgcolor1' );
                $('td:eq(1)', nRow).addClass( 'alignCenter' ).addClass( 'fontText4' );
                $('td:eq(4)', nRow).addClass( 'alignCenter' );

                $('td:eq(3)', nRow).addClass( 'fontText2' );
                $('td:eq(5)', nRow).addClass( 'alignCenter' ).addClass( 'color_red' ).addClass( 'bold' );
                $('td:eq(6)', nRow).addClass( 'alignCenter' ).addClass( 'color_green' ).addClass( 'bold' );

                $('td:eq(7)', nRow).addClass( 'alignCenter' ).addClass( 'bold' );
                $('td:eq(8)', nRow).addClass( 'alignRight' );
                $('td:eq(9)', nRow).addClass( 'alignRight' );
                $('td:eq(10)', nRow).addClass( 'alignRight' ).addClass( 'fontText3' );
                $('td:eq(11)', nRow).addClass( 'alignRight' ).addClass( 'fontText3' );

                //$('td:eq(2)', nRow).addClass( 'fontText2' );
                
              }
        },
        columnDefs: [

            { 
              targets: [7,8],
              createdCell: createdCell
            },

            {
               targets: [6],
               data: null,
               render: function ( data, type, row, meta ) {                   
                

                  valor=calcularRequerido( data[4],data[5],data[13] );

                  return ``+valor+``         

               }

               
            },

            {
               targets: [7],
               data: null,
               render: function ( data, type, row, meta ) {                   
                

                  valor=calcularSolicitar( data[4],data[5],data[14] );

                  return ``+valor+``         

               }

               
            },

            {
               targets: [11],
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

                  valor2=calcularSubtotal( data[4],data[8],data[9],data[10] );

                  return ``+valor2+``         

               }

               
            }

        ],

        "processing": true,
        "serverSide": true,
        "search" : false,
        "ajax": base_urlx+"Asignaroc/loadPartidas?cot="+`${event.target.value}`,

      "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]],

        "scrollY": 300,
        "scrollX": true
    });

    ////////////// FOCUS IN 

    $('#my-table tbody').on('focusin', 'tr', function () {
        var data = table.row( this ).data();


        editId = data[12];
        almacenx = data[5];
        pedidox = data[4];
        piva = data[10];

        if ( pedidox > almacenx ) {

          cantidadx = parseFloat(pedidox)-parseFloat(almacenx);

        }else{

          cantidadx = 0;

        }

        console.log(editId);
        
        //idFila = table.row( this ).index();
        //idColumn = table.cell( this ).index().column;

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

});

function cerrarSesion(){

    var x = confirm("¿Realmente deseas cerrar la sesión?");

    if( x==true ){

      window.location.href = base_urlx+"Login/CerrarSesion/";
      
    }  

}
