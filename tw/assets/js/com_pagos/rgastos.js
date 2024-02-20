//alert("version 3.0");

var idClientex = 0;

var idCotizacionx = 0;

var table ="";

var dataClick = [];

var textoOriginal = "";

var idFila = "";



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

function calcularTotal(sub,desc,iva){



	tsub = sub.replace(/[^\d.]/g,"");

	tdesc = desc.replace(/[^\d.]/g,"");

	tiva = iva.replace(/[^\d.]/g,"");



	total = parseFloat(tsub)-parseFloat(tdesc)+parseFloat(tiva);



	return formatNumber( round(total) );



}

function CierraPopup() {



  $('#cerrarx').click(); //Esto simula un click sobre el botón close de la modal, por lo que no se debe preocupar por qué clases agregar o qué clases sacar.

  $('.modal-backdrop').remove();//eliminamos el backdrop del modal



}

// Funciones cargadas al iniciar

showInfo();
showCuentas();



/////////****************** SELECT SUB-CATEGORIAS

function formatoMoneda(valor) {

  valor = parseFloat(valor).toFixed(2);
  valor = '$' + valor.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
  return valor;

}


function showInfo(){

  if ( table !="" ) {

    $('#my-table').DataTable().destroy();

  }

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
        "search":         "Buscar en la tabla por:",
        "paginate": {

            "first":      "Primero",
            "last":       "Ultimo",
            "next":       "Siguiente",
            "previous":   "Anterior"

        }

        },

        dom: '<"top" pl>rt',
        buttons: [ 'copy', 'excel' , 'csv'],
        "order": [[4,"desc"]], 

        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            /* Append the grade to the default row class name */

        if ( true ) // your logic here
        {


            $(nRow).addClass( 'customFont' );
            $('td:eq(0)', nRow).addClass( 'alignCenter' );
            $('td:eq(1)', nRow).addClass( 'alignCenter' );
            if ($('td:eq(1)', nRow).text() === 'Activo') {

              //$('td:eq(1)', nRow).addClass( 'fontWithBackgroundRed' );
              $('td:eq(1)', nRow).contents().wrap('<div class="fontWithBackgroundRed"></div>');

            }else if ($('td:eq(1)', nRow).text() === 'Aplicado') {

              //$('td:eq(1)', nRow).addClass( 'fontWithBackgroundGreen' );
              $('td:eq(1)', nRow).contents().wrap('<div class="fontWithBackgroundGreen"></div>');

            }

            $('td:eq(4)', nRow).addClass( 'fontText2red' );
            
          }

        },columnDefs: [

           {
               targets: [4],
               data: null,
               render: function ( data, type, row, meta ) {                   
                  valor=formatoMoneda(data[4]);
                  return ``+valor+``         
               }
              
           },
           {
            targets: [3], 
            data: null,
            render: function (data, type, row, meta) {
              return `<div class="editable-container" data-status="${row[1]}">
                    <div contenteditable="${row[1] === 'Activo'}">${data[3]}</div>
                    <button class="btn-apply" style="display:none;">Aplicar</button>
                    <button class="btn-cancel" style="display:none;">Cancelar</button>
                  </div>`;
            },
          },
          
        ],
        "createdRow": function (row, data, dataIndex) {
          if (data[1] === 'Activo') {
            $(row).addClass('editable');
          }
        },

        "processing": true,
        "serverSide": true,
        "search" : false,
        "ajax": base_urlx+"Rgastos/loadPartidasEstatus?buscador="+$("#buscador").val()+"&estatus="+$("#bestatus").val(),

      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
      "scrollY": 450,
      "scrollX": true

    });

    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row(this).data();
        dataClick = data;
        idFila = table.row( this ).index();
        //alert(idFila);

        $("#verDescripcion").html(
          'Descripción original: '+
          '<br><span id="modalDescripcionOriginal">'+data[5]+'</span><br>' +
          '<span id="modalOculto" style="display: none;">'+data[6]+'</span>'
        );

    } );

    $('#my-table tbody').on('click', '.btn-cancel', function () {
      var row = $(this).closest('tr');
      var data = table.row(row).data();
      var cell = table.cell(row, 3); 
      cell.data(data[3]);
      //table.draw();
    });

    $('#my-table tbody').on('click', '.btn-apply', function () {
      var row = $(this).closest('tr');
      var id = dataClick[6];
      var description = row.find('.editable-container div[contenteditable="true"]').text(); 
      
      if(description !== textoOriginal){
        $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"Rgastos/reconocerPago/",
          cache: false,
          data:{ 
  
            id: id,
            descripcion: description
  
          },
          success: function(result)
          {
            
  
            if ( result.eject == true ) {
  
              //alert("Pago reconocido");
              //location.reload();
              //showInfo();
              //table.ajax.reload();
              //alert(result.fieldDescript);
             
              var table = $('#my-table').DataTable();
              temp = table.row(idFila).data();

              var mensajeEmergente = document.getElementById('lblPagoReconocido');
              mensajeEmergente.style.display = 'block';
              
             temp[0] = '<div class="btn-group">'+
                          '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                      '<span class="caret"></span>'+
                          '</button>'+
                          '<ul class="dropdown-menu">'+
                          '<li><a href="" style="color:darkgreen; font-weight:bold;" data-toggle="modal" data-target="#modalDescripcion"> <i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Ver descripción</a></li>'+
                          '<li><a href="#" onclick="cancelarAplicacion('+result.fieldId+');" style="color:darkred; font-weight:bold;"> <i class="fa fa-remove" style="color:darkred; font-weight:bold;"></i> Cancelar</a></li>'+
                          '</ul>'+
                      '</div>';
              temp[1] = "<div class='fontWithBackgroundGreen'>Aplicado</div>";
              temp[3] = result.fieldDescript;

              $('#my-table').dataTable().fnUpdate(temp, idFila, undefined, false, false);
              setTimeout(function() {
                  mensajeEmergente.style.display = 'none';
              }, 3000);
            }
            
  
          }
  
        }).fail( function( jqXHR, textStatus, errorThrown ) {
  
          detectarErrorJquery(jqXHR, textStatus, errorThrown);
  
        });
      }else{
        alert("No se reconocio ningún cambio en la descripción")
      }

      });
  
    $('#my-table tbody').on('click', '.editable-container div[contenteditable="true"]', function () {
      var container = $(this).closest('.editable-container');
      var btnApply = container.find('.btn-apply');
      var btnCancel = container.find('.btn-cancel');
      textoOriginal = $(this).text();
      btnApply.show();
      btnCancel.show();
    });
    /*
    $('#my-table').on( 'focusout', 'tbody td', function () {

      var row = $(this).closest('tr');
      var data = table.row(row).data();
      var cell = table.cell(row, 3); 
      cell.data(data[3]);

    } );*/

}

function actualizarFilaEnDataTable(filaId, nuevosDatos) {
  var table = $('#my-table').DataTable();
  var row = table.row('#' + filaId);

  if (row) {
      row.data(nuevosDatos).draw(false);
  } else {
      console.error('La fila con ID ' + filaId + ' no se encontró en la DataTable.');
  }
}

function cancelarAplicacion(id) {

  if(confirm("¿Estás seguro de cancelar el pago?")){
    event.preventDefault();
    $.ajax({

      type: "POST",
      dataType: "json",
      url: base_urlx+"Rgastos/cancelarAplicacion/",
      cache: false,
      data:{ 
  
        id: id,
        descripcion: $("#modalDescripcionOriginal").text()
  
      },
      success: function(result)
      {
        
  
        if ( result.eject == true ) {
  
          //alert("Pago cancelado");
          var table = $('#my-table').DataTable();
          temp = table.row(idFila).data();

          var mensajeEmergente = document.getElementById('lblPagoCancelado');
          mensajeEmergente.style.display = 'block';

          temp[0] = '<div class="btn-group">'+
                      '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                  '<span class="caret"></span>'+
                      '</button>'+
                      '<ul class="dropdown-menu">'+
                      '<li><a href="#" style="color:darkgreen; font-weight:bold;" data-toggle="modal" data-target="#modalDescripcion"> <i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Ver descripción</a></li>'+
                      '</ul>'+
                  '</div>';
          temp[1] = "<div class='fontWithBackgroundRed'>Activo</div>";
          temp[3] =  result.fieldDescript;
          $('#my-table').dataTable().fnUpdate(temp, idFila, undefined, false, false);

          setTimeout(function() {
            mensajeEmergente.style.display = 'none';
        }, 3000);
  
        }
        
  
      }
  
    }).fail( function( jqXHR, textStatus, errorThrown ) {
  
      detectarErrorJquery(jqXHR, textStatus, errorThrown);
  
    });
  }
}

function showCuentas(){

  $.ajax({

          type: "POST",
          dataType: "json",
          url: base_urlx+"Rgastos/showCuentas/",
          cache: false,
          success: function(result)
          {

            if ( result != null ) {

                var creaOption="<option value='0' >Seleciona una cuenta...</option>"; 
                $.each(result, function(i,item){

                    data1=item.id;

                    data2=item.cuenta;//id

                    data3=item.comercial;//nombre

                    creaOption=creaOption+'<option value="'+data1+'">'+data2+' - '+data3+'</option>'; 

                }); 

                $("#cuenta").html(creaOption);

                //$("#regimen").val(0);

            }else{

               $("#cuenta").html("<option value='0'>Sin bancos almacenados</option>");

            }

          }

  }).fail( function( jqXHR, textStatus, errorThrown ) {

      detectarErrorJquery(jqXHR, textStatus, errorThrown);

  });

}


function cerrarSesion(){



  var x = confirm("¿Realmente deseas cerrar la sesión?");



  if( x==true ){



    window.location.href = base_urlx+"Login/CerrarSesion/";

    

  }



}

