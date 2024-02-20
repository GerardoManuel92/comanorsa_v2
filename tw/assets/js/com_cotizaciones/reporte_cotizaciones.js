//alert("version 3.0");

var idClientex = 0;

var idCotizacionx = 0;

var table = "";





function detectarErrorJquery(jqXHR, textStatus, errorThrown) {



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







  return "$ " + splitLeft + splitRight;

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





function calcularTotal(sub, desc, iva) {



  tsub = sub.replace(/[^\d.]/g, "");

  tdesc = desc.replace(/[^\d.]/g, "");

  tiva = iva.replace(/[^\d.]/g, "");



  total = parseFloat(tsub) - parseFloat(tdesc) + parseFloat(tiva);



  return formatNumber(round(total));



}



function CierraPopup() {



  $('#cerrarx').click(); //Esto simula un click sobre el botón close de la modal, por lo que no se debe preocupar por qué clases agregar o qué clases sacar.

  $('.modal-backdrop').remove();//eliminamos el backdrop del modal



}



/*$(document).ready(function() {



  ///////////primera imagen  



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



        dom: '<"top" fpl>rt',



        buttons: [ 'copy', 'excel' , 'csv'],

        "order": [  [ 4, "desc" ] ],



        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            

            if ( true ) // your logic here

          {



            $(nRow).addClass( 'customFont' );



            $('td:eq(0)', nRow).addClass( 'alignCenter' );

            $('td:eq(1)', nRow).addClass( 'alignCenter' );



            $('td:eq(2)', nRow).addClass( 'fontText2center' );



            $('td:eq(3)', nRow).addClass( 'alignCenter' );

            $('td:eq(4)', nRow).addClass( 'alignCenter' );

            $('td:eq(6)', nRow).addClass( 'fontText2' );



            $('td:eq(7)', nRow).addClass( 'alignRight' );

            $('td:eq(8)', nRow).addClass( 'fontText2red' );

            $('td:eq(9)', nRow).addClass( 'alignRight' );

            $('td:eq(10)', nRow).addClass( 'alignRight' );

            

            

          }



        },columnDefs: [



           {

               targets: [10],

               data: null,

               render: function ( data, type, row, meta ) {                   





                  valor=calcularTotal( data[7],data[8],data[9] );



                  return ``+valor+``         



               }



               

           }



        ],

        "processing": true,

        "serverSide": true,

        "search" : false,

        "ajax": base_urlx+"Rcotizacion/loadPartidas",



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



        "scrollY": 450,

        "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {

        var data = table.row( this ).data();



        //alert("idcliente:"+data[12]);

        //showContacto(data[12]);



        $("#titulo").html("Enviar cotización: "+data[5]);



        idClientex = data[12];

        idCotizacionx = data[11];



        $("#vercotizacion").html('<a href="'+base_urlx+'tw/php/cotizaciones/cot'+data[11]+'.pdf" target="_blank" style="color:red; font-weight: bold; font-size: 15px;"> <i class="fa fa-eye" style="color:red; font-weight: bold; font-size: 15px;"></i> Ver cotización</a>')



    } );



    showClientes();

    showVendedor();





} );





*/



showInfo();



/////////****************** SELECT SUB-CATEGORIAS



function showContacto(idcliente) {



  $.ajax({

    type: "POST",

    dataType: "json",

    url: base_urlx + "Rcotizacion/showContacto/",

    data: { idcli: idcliente },

    cache: false,

    success: function (result) {



      if (result != null) {



        var creaOption = "";

        var creaOption2 = "<option value='0' selected>No agregar copia</option>"



        $.each(result, function (i, item) {

          data0 = item.id;//id

          data1 = item.nombre;//id

          data2 = item.puesto;//nombre

          data3 = item.correo//correo

          creaOption = creaOption + '<option value="' + data0 + '">' + data1 + '/' + data2 + '-' + data3 + '</option>';

        });



        $("#contacto1").html(creaOption);

        $("#contacto2").html(creaOption2 + '' + creaOption);



      } else {



        $("#contacto1").html("<option value='0'>Sin contactos</option>");

        $("#contacto2").html("<option value='0'>Sin contactos</option>");



      }





    }



  }).fail(function (jqXHR, textStatus, errorThrown) {





    detectarErrorJquery(jqXHR, textStatus, errorThrown);



  });



}



function showClientes(idcliente) {



  $.ajax({

    type: "POST",

    dataType: "json",

    url: base_urlx + "Rcotizacion/showClientes/",

    cache: false,

    success: function (result) {



      if (result != null) {



        var creaOption = "<option value='0'>Ver todos</option> ";



        $.each(result, function (i, item) {

          data0 = item.id;//id

          data1 = item.nombre;//id

          data2 = item.comercial;//nombre

          creaOption = creaOption + '<option value="' + data0 + '">' + data1 + ' | ' + data2 + '</option>';

        });



        $("#cliente").html(creaOption);

        $("#cliente").val(0).trigger('change');



      } else {



        $("#cliente").html("");



      }





    }



  }).fail(function (jqXHR, textStatus, errorThrown) {





    detectarErrorJquery(jqXHR, textStatus, errorThrown);



  });



}



function showVendedor(idcliente) {



  $.ajax({

    type: "POST",

    dataType: "json",

    url: base_urlx + "Rcotizacion/showVendedor/",

    cache: false,

    success: function (result) {



      if (result != null) {



        var creaOption = "<option value='0' selected>Ver todos</option> ";



        $.each(result, function (i, item) {

          data0 = item.id;//id

          data1 = item.nombre;//id

          creaOption = creaOption + '<option value="' + data0 + '">' + data1 + '</option>';

        });



        $("#vendedor").html(creaOption);



        if (iddepax > 1) {



          $("#vendedor").val(iduserx);

          $("#vendedor").prop("disabled", true);



        }



      } else {



        $("#vendedor").html("");



      }



      showClientes();





    }



  }).fail(function (jqXHR, textStatus, errorThrown) {





    detectarErrorJquery(jqXHR, textStatus, errorThrown);



  });



}



///****** FILTRAR 



function showInfo() {



  if (table != "") {



    $('#my-table').DataTable().destroy();

    //$("#folio").val("");



  }



  /*filtrar entre cliente y vendedor*/



  table = $('#my-table').DataTable({



    "language": {



      "lengthMenu": "Mostrando _MENU_ articulos por pagina",

      "zeroRecords": "No hay partidas que mostrar",

      "info": "Total _TOTAL_ partidas<br>",

      "infoEmpty": "No hay partidas que mostrar",

      "emptyTable": "No hay partidas que mostrar",

      "infoFiltered": "(filtrado de _MAX_ articulos totales)",

      "loadingRecords": "Cargando...",

      "processing": "Procesando...",

      "search": "Buscar en la tabla por:",

      "paginate": {

        "first": "Primero",

        "last": "Ultimo",

        "next": "Siguiente",

        "previous": "Anterior"

      }

    },



    dom: '<"top" pli>rt',



    buttons: ['copy', 'excel', 'csv'],

    "order": [[4, "desc"]],



    "fnRowCallback": function (nRow, aData, iDisplayIndex) {

      /* Append the grade to the default row class name */

      if (true) // your logic here

      {



        $(nRow).addClass('customFont');



        $('td:eq(0)', nRow).addClass('alignCenter');

        $('td:eq(1)', nRow).addClass('alignCenter');



        $('td:eq(2)', nRow).addClass('fontText2center');



        $('td:eq(3)', nRow).addClass('alignCenter');

        $('td:eq(4)', nRow).addClass('alignCenter');

        $('td:eq(6)', nRow).addClass('fontText2');



        $('td:eq(7)', nRow).addClass('alignRight');

        $('td:eq(8)', nRow).addClass('fontText2red');

        $('td:eq(9)', nRow).addClass('alignRight');

        $('td:eq(10)', nRow).addClass('alignRight');





      }



    }, columnDefs: [



      {

        targets: [10],

        data: null,

        render: function (data, type, row, meta) {

          /*return `<button class="btn btn-danger hidden-xs" type="button" title="Borrar" onclick="borrarArticulo(${row[4]})"> <i class="icon-trash"></i> </button><button class="btn btn-orange hidden-xs" type="button" title="Editar" onclick="editarArticulo(${row[4]})"> <i class="icon-pencil"></i> </button><div class="dropdown open hidden-sm hidden-md hidden-lg hidden-xl">

              <a class="more-link" data-toggle="dropdown" href="#/" aria-expanded="true"><i class="icon-dot-3 ellipsis-icon"></i></a>

              <ul class="dropdown-menu dropdown-menu-right">

                <li><a href="" style="color:orange; font-weight:bold; ">Editar</a></li>

                <li><a href="" style="color:red; font-weight:bold; ">Eliminar</a></li>

                <li><a href="#modal_info" data-toggle="modal" style="color:blue; font-weight:bold; ">Ver info.</a> </li>

              </ul>

            </div>`

 

            */



          valor = calcularTotal(data[7], data[8], data[9]);



          return `` + valor + ``



        }





      }



    ],

    "processing": true,

    "serverSide": true,

    "search": false,

    "ajax": base_urlx + "Rcotizacion/loadPartidasFiltro?buscador=" + $("#buscador").val() + "&estatus=" + $("#bestatus").val(),



    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



    "scrollY": 450,

    "scrollX": true

  });



  /////////////********* CLICK 

  $('#my-table tbody').on('click', 'tr', function () {

    var data = table.row(this).data();



    //alert("idcliente:"+data[12]);

    showContacto(data[12]);



    $("#titulo").html("Enviar cotización: " + data[5]);



    idClientex = data[12];

    idCotizacionx = data[11];



    $("#contacto3").val("");



    $("#vercotizacion").html('<a href="' + base_urlx + 'tw/php/cotizaciones/cot' + data[11] + '.pdf" target="_blank" style="color:red; font-weight: bold; font-size: 15px;"> <i class="fa fa-eye" style="color:red; font-weight: bold; font-size: 15px;"></i> Ver cotización</a>')



  });



}



function showInfoEstatus() {



  if (table != "") {



    $('#my-table').DataTable().destroy();

    //$("#folio").val("");



  }



  /*filtrar entre cliente y vendedor*/



  table = $('#my-table').DataTable({



    "language": {



      "lengthMenu": "Mostrando _MENU_ articulos por pagina",

      "zeroRecords": "No hay partidas que mostrar",

      "info": "Total _TOTAL_ partidas<br>",

      "infoEmpty": "No hay partidas que mostrar",

      "emptyTable": "No hay partidas que mostrar",

      "infoFiltered": "(filtrado de _MAX_ articulos totales)",

      "loadingRecords": "Cargando...",

      "processing": "Procesando...",

      "search": "Buscar en la tabla por:",

      "paginate": {

        "first": "Primero",

        "last": "Ultimo",

        "next": "Siguiente",

        "previous": "Anterior"

      }

    },



    dom: '<"top" pli>rt',



    buttons: ['copy', 'excel', 'csv'],

    "order": [[4, "desc"]],



    "fnRowCallback": function (nRow, aData, iDisplayIndex) {

      /* Append the grade to the default row class name */

      if (true) // your logic here

      {



        $(nRow).addClass('customFont');



        $('td:eq(0)', nRow).addClass('alignCenter');

        $('td:eq(1)', nRow).addClass('alignCenter');



        $('td:eq(2)', nRow).addClass('fontText2center');



        $('td:eq(3)', nRow).addClass('alignCenter');

        $('td:eq(4)', nRow).addClass('alignCenter');

        $('td:eq(6)', nRow).addClass('fontText2');



        $('td:eq(7)', nRow).addClass('alignRight');

        $('td:eq(8)', nRow).addClass('fontText2red');

        $('td:eq(9)', nRow).addClass('alignRight');

        $('td:eq(10)', nRow).addClass('alignRight');





      }



    }, columnDefs: [



      {

        targets: [10],

        data: null,

        render: function (data, type, row, meta) {

          /*return `<button class="btn btn-danger hidden-xs" type="button" title="Borrar" onclick="borrarArticulo(${row[4]})"> <i class="icon-trash"></i> </button><button class="btn btn-orange hidden-xs" type="button" title="Editar" onclick="editarArticulo(${row[4]})"> <i class="icon-pencil"></i> </button><div class="dropdown open hidden-sm hidden-md hidden-lg hidden-xl">

              <a class="more-link" data-toggle="dropdown" href="#/" aria-expanded="true"><i class="icon-dot-3 ellipsis-icon"></i></a>

              <ul class="dropdown-menu dropdown-menu-right">

                <li><a href="" style="color:orange; font-weight:bold; ">Editar</a></li>

                <li><a href="" style="color:red; font-weight:bold; ">Eliminar</a></li>

                <li><a href="#modal_info" data-toggle="modal" style="color:blue; font-weight:bold; ">Ver info.</a> </li>

              </ul>

            </div>`

 

            */



          valor = calcularTotal(data[7], data[8], data[9]);



          return `` + valor + ``



        }





      }



    ],

    "processing": true,

    "serverSide": true,

    "search": false,

    "ajax": base_urlx + "Rcotizacion/loadPartidasEstatus?estatus=" + $("#bestatus").val() + "&buscador=" + $("#buscador").val(),



    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



    "scrollY": 450,

    "scrollX": true

  });



  /////////////********* CLICK 

  $('#my-table tbody').on('click', 'tr', function () {

    var data = table.row(this).data();



    //alert("idcliente:"+data[12]);

    showContacto(data[12]);



    $("#titulo").html("Enviar cotización: " + data[5]);



    idClientex = data[12];

    idCotizacionx = data[11];



    $("#contacto3").val("");



    $("#vercotizacion").html('<a href="' + base_urlx + 'tw/php/cotizaciones/cot' + data[11] + '.pdf" target="_blank" style="color:red; font-weight: bold; font-size: 15px;"> <i class="fa fa-eye" style="color:red; font-weight: bold; font-size: 15px;"></i> Ver cotización</a>')



  });



}



function showFolio() {



  if ($("#folio").val() > 10000) {



    if (table != "") {



      ////**



      $("#vendedor").val(0);

      $('#my-table').DataTable().destroy();



    }



    /*filtrar entre cliente y vendedor*/



    table = $('#my-table').DataTable({



      "language": {



        "lengthMenu": "Mostrando _MENU_ articulos por pagina",

        "zeroRecords": "No hay partidas que mostrar",

        "info": "Mostrando pagina _PAGE_ de _PAGES_",

        "infoEmpty": "No hay partidas que mostrar",

        "emptyTable": "No hay partidas que mostrar",

        "infoFiltered": "(filtrado de _MAX_ articulos totales)",

        "loadingRecords": "Cargando...",

        "processing": "Procesando...",

        "search": "Buscar en la tabla por:",

        "paginate": {

          "first": "Primero",

          "last": "Ultimo",

          "next": "Siguiente",

          "previous": "Anterior"

        }

      },



      dom: '<"top" fpl>rt',



      buttons: ['copy', 'excel', 'csv'],

      "order": [[4, "desc"]],



      "fnRowCallback": function (nRow, aData, iDisplayIndex) {

        /* Append the grade to the default row class name */

        if (true) // your logic here

        {



          $(nRow).addClass('customFont');



          $('td:eq(0)', nRow).addClass('alignCenter');

          $('td:eq(1)', nRow).addClass('alignCenter');



          $('td:eq(2)', nRow).addClass('fontText2center');



          $('td:eq(3)', nRow).addClass('alignCenter');

          $('td:eq(4)', nRow).addClass('alignCenter');

          $('td:eq(6)', nRow).addClass('fontText2');



          $('td:eq(7)', nRow).addClass('alignRight');

          $('td:eq(8)', nRow).addClass('fontText2red');

          $('td:eq(9)', nRow).addClass('alignRight');

          $('td:eq(10)', nRow).addClass('alignRight');





        }



      }, columnDefs: [



        {

          targets: [10],

          data: null,

          render: function (data, type, row, meta) {

            /*return `<button class="btn btn-danger hidden-xs" type="button" title="Borrar" onclick="borrarArticulo(${row[4]})"> <i class="icon-trash"></i> </button><button class="btn btn-orange hidden-xs" type="button" title="Editar" onclick="editarArticulo(${row[4]})"> <i class="icon-pencil"></i> </button><div class="dropdown open hidden-sm hidden-md hidden-lg hidden-xl">

                <a class="more-link" data-toggle="dropdown" href="#/" aria-expanded="true"><i class="icon-dot-3 ellipsis-icon"></i></a>

                <ul class="dropdown-menu dropdown-menu-right">

                  <li><a href="" style="color:orange; font-weight:bold; ">Editar</a></li>

                  <li><a href="" style="color:red; font-weight:bold; ">Eliminar</a></li>

                  <li><a href="#modal_info" data-toggle="modal" style="color:blue; font-weight:bold; ">Ver info.</a> </li>

                </ul>

              </div>`

 

              */



            valor = calcularTotal(data[7], data[8], data[9]);



            return `` + valor + ``



          }





        }



      ],

      "processing": true,

      "serverSide": true,

      "search": false,

      "ajax": base_urlx + "Rcotizacion/loadPartidasFolio?folio=" + $("#folio").val(),



      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],



      "scrollY": 450,

      "scrollX": true

    });



    /////////////********* CLICK 

    $('#my-table tbody').on('click', 'tr', function () {

      var data = table.row(this).data();



      //alert("idcliente:"+data[12]);

      showContacto(data[12]);



      $("#titulo").html("Enviar cotización: " + data[5]);



      idClientex = data[12];

      idCotizacionx = data[11];



      $("#contacto3").val("");



      $("#vercotizacion").html('<a href="' + base_urlx + 'tw/php/cotizaciones/cot' + data[11] + '.pdf" target="_blank" style="color:red; font-weight: bold; font-size: 15px;"> <i class="fa fa-eye" style="color:red; font-weight: bold; font-size: 15px;"></i> Ver cotización</a>')



    });



  } else {



    alert("Alerta, favor de seleccionar un folio valido")



  }



}





/////////****************** SELECT SUB-CATEGORIAS



function showContacto(idcliente) {



  $.ajax({

    type: "POST",

    dataType: "json",

    url: base_urlx + "Rcotizacion/showContacto/",

    data: { idcli: idcliente },

    cache: false,

    success: function (result) {



      if (result != null) {



        var creaOption = "";

        var creaOption2 = "<option value='0' selected>No agregar copia</option>"



        $.each(result, function (i, item) {

          data0 = item.id;//id

          data1 = item.nombre;//id

          data2 = item.puesto;//nombre

          data3 = item.correo;//correo

          creaOption = creaOption + '<option value="' + data0 + '">' + data1 + '/' + data2 + '-' + data3 + '</option>';

        });



        $("#contacto1").html(creaOption);

        $("#contacto2").html(creaOption2 + '' + creaOption);



      } else {



        $("#contacto1").html("<option value='0'>Sin contactos</option>");

        $("#contacto2").html("<option value='0'>Sin contactos</option>");



      }





    }



  }).fail(function (jqXHR, textStatus, errorThrown) {





    detectarErrorJquery(jqXHR, textStatus, errorThrown);



  });



}



function enviarCorreo() {



  verificar = 0;

  copiax = 0;



  if ($("#contacto1").val() == 0) {



    verificar = 1;

    alert("Alerta, antes debes seleccionar un correo valido");



  }



  if (idClientex == 0 && verificar == 0) {



    verificar = 1;

    alert("Alerta, antes debes seleccionar un cliente valido");



  }



  if (verificar == 0) {



    txtcorreo = $('select[name="contacto1"] option:selected').text();

    separar = txtcorreo.split("-");

    correox = separar[1];



    /////// revisar la copia de correo 



    if ($("#contacto2").val() > 0) {



      txtcorreo2 = $('select[name="contacto2"] option:selected').text();

      separar2 = txtcorreo2.split("-");

      correox2 = separar2[1];

      copiax = 1;



    } else {



      correox2 = "";

      copiax = 0;



    }



    x = confirm("Favor de confirmar el envio de correo");



    if (x) {



      $.ajax({

        type: "POST",

        dataType: "json",

        url: base_urlx + "Rcotizacion/enviarCorreo/",

        data: { idcli: idClientex, idcot: idCotizacionx, destinatario: correox, copia: copiax, otro_correo: correox2, cont3: $("#contacto3").val() },

        cache: false,

        success: function (result) {



          if (result) {



            alert("Correo enviado");



          }





        }



      }).fail(function (jqXHR, textStatus, errorThrown) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



      });



    }



  }



}



function habilitarOdc(idcotz) {



  x = confirm("¿Deseas habilitar la ODC de la cotización #" + idcotz + "?");



  if (x) {



    if (idcotz > 0) {



      $.ajax({

        type: "POST",

        dataType: "json",

        url: base_urlx + "Rcotizacion/habilitarOdc/",

        data: { idcot: idcotz },

        cache: false,

        success: function (result) {



          if (result > 0) {



            alert("Alerta, la ODC ya puede ser generada");



          } else {



            alert("Error, no se han podido asignar partidas a la ODC ");



          }





        }



      }).fail(function (jqXHR, textStatus, errorThrown) {





        detectarErrorJquery(jqXHR, textStatus, errorThrown);



      });



    } else {



      alert("Alerta, favor de seleccionar una cotizacion con ID valido");



    }



  }



}



function showexcel(idcotx) {



  /*folio ="";

  inicio = 10000;

  var nuevo = parseFloat(inicio)+parseFloat(idcotx);



  switch ( nuevo.length  ) {



    case 5:

        

        folio = "ODV00"+nuevo;



    break;



    case 6:

        

        folio = "ODV0"+nuevo;



    break;



    case 7:

        

        folio = "ODV"+nuevo;



    break;



    default:



        folio = "s/asignar";



    break;



}





alert(nuevo.toString().length );*/



  $.ajax({

    type: "POST",

    dataType: "json",

    url: base_urlx + "tw/php/crear_excel_cotizacion.php",

    data: { alta1: idcotx },

    cache: false,

    success: function (result) {





      folio = "";

      inicio = 10000;

      nuevo = parseFloat(inicio) + parseFloat(idcotx);



      switch (nuevo.toString().length) {



        case 5:



          folio = "ODV00" + nuevo;



          break;



        case 6:



          folio = "ODV0" + nuevo;



          break;



        case 7:



          folio = "ODV" + nuevo;



          break;



        default:



          folio = "s/asignar";



          break;



      }



      window.location.href = base_urlx + "tw/php/reporte/cotizacion_" + folio + ".xlsx";



    }



  });



}


function showExcelGeneral() {  

  $.ajax({

    type: "POST",

    dataType: "json",

    url: base_urlx + "tw/php/crear_excel_cotizaciones.php",

    data: { select_estatusx: $("#bestatus").val(), inputx: $("#buscador").val() },

    cache: false,

    success: function (result) {

      if (result) {

        window.location.href = base_urlx + "tw/php/reporte/reporte_cotizaciones.xlsx";


      } else {
        alert('No se pudo generar excel');
      }
    }
  });
  //alert(select_estatusx);
}


function convertirAMayusculas() {

  var input = document.getElementById('buscador');

  input.value = input.value.toUpperCase();
  
}




function crearPedido() {



  //urlx = $("#evidencia").val();



  if ($("#name_factpdf").val() != "") {



    $.ajax({

      type: "POST",

      dataType: "json",

      url: base_urlx + "tw/php/verificar_url.php",

      data: { archivo: $("#name_factpdf").val(), cotizacion: idCotizacionx },

      cache: false,

      success: function (result) {



        if (result) {



          alert("Alerta, el PEDIDO ha sido creado con exito");

          CierraPopup();

          table.ajax.reload();



        } else {



          alert("Error, la URL no ha podido ser validada");



        }



      }



    });



  } else {



    alert("Alerta, favor de añadir un archivo valido");



  }



}



//////////////////////////////******************* subir archivo de evidencia



function subirEvidencia() {





  if ($("#name_factpdf").val() != "") {



    $.ajax({

      type: "POST",

      dataType: "json",

      url: base_urlx + "Rcotizacion/subirEvidencia/",

      data: { idcotizacion: idCotizacionx, evidencia: $("#name_factpdf").val() },

      cache: false,

      success: function (result) {



        if (result) {



          alert("Alerta, el PEDIDO ha sido creado con exito");

          CierraPopup();

          table.ajax.reload();



        } else {



          alert("Error, favor de intentarlo nuevamente");



        }



      }





    });



  } else {



    alert("Alerta, favor de agregar una evidencia valida");



  }





}



//////// ***************************************SUBIR ARCHIVO PDF



$(function () {



  'use strict';



  //alert("subiendo");



  // Change this to the location of your server-side upload handler:



  var url = window.location.hostname === 'blueimp.github.io' ? '//jquery-file-upload.appspot.com/' : base_urlx + 'tw/js/upload_evidencias/';



  $('#fileupload_pdf').fileupload({



    url: url,



    dataType: 'json',



    done: function (e, data) {





      //quitarArchivo(f);



      $.each(data.result.files, function (index, file) {





        $("#name_factpdf").val(file.name);





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





function cancelarCotizacion(idcotx) {



  x = confirm("¿Realmente deseas cancelar la cotizacion seleccionada?");



  if (x) {



    $.ajax({

      type: "POST",

      dataType: "json",

      url: base_urlx + "Rcotizacion/cancelarCotizacion/",

      data: { idcotizacion: idcotx },

      cache: false,

      success: function (result) {



        if (result) {



          alert("Alerta, la cotizacion ha sido cancelada con exito");

          table.ajax.reload();



        } else {



          alert("Error, favor de intentarlo nuevamente");



        }



      }





    });



  }



}



function cancelarPedido(idcotx) {



  x = confirm("¿Realmente deseas revertir el pedido, esto lo regresara al proceso de cotización?");



  if (x) {



    $.ajax({

      type: "POST",

      dataType: "json",

      url: base_urlx + "Rcotizacion/cancelarPedido/",

      data: { idcotizacion: idcotx },

      cache: false,

      success: function (result) {



        if (result == 1) {



          alert("Alerta, el pedido ha cambiado su estatus a cotizacion");

          table.ajax.reload();



        } else if (result == 0) {



          alert("Alerta, el pedido no puede ser revertido debido a que ya tiene ordenes de compra asignadas algun proveedor");



        }



      }





    });



  }



}







function cerrarSesion() {



  var x = confirm("¿Realmente deseas cerrar la sesión?");



  if (x == true) {



    window.location.href = base_urlx + "Login/CerrarSesion/";



  }



}

