//alert("verion 6.0");

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

var editId = 0;
var table;
var colx = "";
var idFila = "";

showProveedor();

////////// EDITOR DE CELDAS

const createdCell = function(cell) {
  let original

  cell.setAttribute('contenteditable', true)
  cell.setAttribute('spellcheck', false)

  cell.addEventListener('focus', function(e) {
  original = e.target.textContent

  })

  cell.addEventListener('blur', function(e) {
    if (original !== e.target.textContent) {
      const row = table.row(e.target.parentElement);
      //row.invalidate()******* este codigo nos ayuda si no queremos ve el cambio actual reflejado en la celda al salir de ella
      //alert(e.target.textContent+"/ row.data() );
      //alert("row: "+idxt+" column: "+colx+" Idpcot: "+editId);

      if ( colx == 1 ||  colx == 2 || colx == 3 || colx == 4 || colx == 5 || colx == 6 || colx == 7 ) {

        row.invalidate()

      }else{

        if ( e.target.textContent != "" ) {

          $.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"Entradas/updateCelda/",
            data:{

              texto:e.target.textContent,
              columna:colx,
              idpxml:editId

            },
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                temp = table.row(idFila).data();

                temp[0] = result.no_identificacion;
                temp[1] = result.nparte;
                temp[2] = result.tags;
                temp[3] = result.descrip;
                temp[4] = result.cantidad;
                temp[5] = result.unidad;
                temp[6] = formatNumber( round( result.unitario ) );
                temp[7] = formatNumber( round( result.subtotal ) );


                $('#my-table').dataTable().fnUpdate(temp,idFila,undefined,false);

                /*$("#tneto").html("Calculando...");

                setTimeout(function (){
                    
                    sumaTotal();              
                              
                }, 1000);*/

                alert("Se ha actualizado correctamente");

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

    
  $(".select2").select2();
  $(".select2-placeholer").select2({
      allowClear: true

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
        "search":         "Buscar por clave/descripcion:",
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

                $('td:eq(0)', nRow).addClass( 'alignCenter' );
                
                $('td:eq(2)', nRow).addClass( 'alignRight' );
                $('td:eq(3)', nRow).addClass( 'alignCenter' );
                $('td:eq(4)', nRow).addClass( 'alignRight' );
                $('td:eq(5)', nRow).addClass( 'alignRight' );
                $

                //$('td:eq(2)', nRow).addClass( 'fontText2' );
                
              }
        },
        columnDefs: [{ 
          targets: '_all',
          createdCell: createdCell
        }],

        "processing": true,
        "serverSide": true,
        "search" : false,
        "ajax": base_urlx+"Entradas/loadPartidas?iduser="+iduserx,

      //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

        "scrollY": 300,
        "scrollX": true
    });

    /////////////********* CLICK 
    $('#my-table tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();

        editId = data[8];
        idFila = table.row( this ).index();
       
    } );


    $('#my-table').on( 'focusin', 'tbody td', function () {

      idxt = table.cell( this ).index().row;
      colx = table.cell( this ).index().column;

    } );



    table
    .buttons()
    .container()
    .appendTo( '#controlPanel' );

    $("#tneto").html("Calculando...");

    /*setTimeout(function (){
        

        sumaTotal();              
                  
    }, 2000);
    */

});

$('td').click(function(){ 

  var col = $(this).parent().children().index($(this)); 
  var row = $(this).parent().parent().children().index($(this).parent()); 
  //alert('Row: ' + row + ', Column: ' + col); 

});

/////////****************** SELECT CATEGORIAS

function showProveedor(){

  	$.ajax({
            type: "POST",
            dataType: "json",
            url: base_urlx+"OrdenCompra/showProveedor/",
            cache: false,
            success: function(result)
            {

              if ( result != null ) {

                  var creaOption="<option value='0' selected>Selecciona un proveedor...</option>"; 

                  $.each(result, function(i,item){
                      data1=item.id;//id
                      data2=item.rfc;//nombre
                      data3=item.nombre;//id
                      data4=item.comercial;//nombre
                      creaOption=creaOption+'<option value="'+data1+'">'+data2+'-'+data3+' <strong style="color:darkblue;">'+data4+'</strong></option>'; 
                  }); 

                  $("#proveedor").html(creaOption);
                  $("#proveedor").val(0);

              }else{

                 $("#proveedor").html("<option value='0'>Sin proveedores</option>");

              }
 
            }

    }).fail( function( jqXHR, textStatus, errorThrown ) {

        detectarErrorJquery(jqXHR, textStatus, errorThrown);

    });

}

////////************** SUBIR ARCHIVO COMPROBANTE

$(function () {

    'use strict';

    //alert("subiendo");

    // Change this to the location of your server-side upload handler:

    var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_xml/';

    $('#fileupload_comprobante').fileupload({

        url: url,

        dataType: 'json',

        done: function (e, data) {


            //quitarArchivo(f);

            $.each(data.result.files, function (index, file) {


              $("#name_comprobante").val(file.name);
    
              $.ajax({

                  type: "POST",
                  dataType: "json",
                  url: base_urlx+"tw/php/entradas/obtener_partidas_xml_factura.php",
                  data:{ 

                    archivo:file.name,
                    idusuario:iduserx

                  },
                  cache: false,
                  success: function(result)
                  {

                    var infox = result.split("||");

                    //alert(infox[0]);

                    mostrarDatos(infox[0]);

                  }

                
              });

            });

        },

            progressall: function (e, data) {

                var progress = parseInt(data.loaded / data.total * 100, 10);

                $('#progress_comprobante .progress-bar').css(

                    'width',

                    progress + '%'

                );

             //$("#file_planos").html("<strong>Los planos se han subido correctamente</strong>");


            }

        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

});

///////********************* MOSTRAR DATOS 

function mostrarDatos(idprox){

  if ( idprox != "" || idprox != null ) {

    //alert("idpro: "+idprox);

	            $.ajax({

                  type: "POST",
                  dataType: "json",
                  url: base_urlx+"Entradas/selectProveedor",
                  data:{ 

                    idpro:idprox
                  },
                  cache: false,
                  success: function(result)
                  {

                    if (result != null ) {

                      $("#proveedor").val(result.id);
                      $('#my-table').DataTable().ajax.reload();

                    }else{

                        alert("El RFC del proveedor no se encuentra en la lista de tus proveedores, ¿Deseas añadirlo? ");

                    }

                  }

                
              });

  }else{

    alert("Error, el RFC de la factura no ha podido ser verificado favor de subir un documento válido");

  }
	
}