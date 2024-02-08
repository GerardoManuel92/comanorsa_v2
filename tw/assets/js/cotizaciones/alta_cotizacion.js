
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
  
  var total_cot = 0;
  
  var total_desc = 0;
  
  var total_iva = 0;
  
  var indexTabla = 0;
  
  var idxt = "";
  
  var colx = "";
  
  var valorcosto = 0;
  
  var valorprecio = 0;
  
  
  
  //////////////
  
  
  
  ///////
  
  var idPro = 0;
  
  var idDescrip = "";
  
  var idIva = 0;
  
  var idCiva = 0;
  
  var idPact = 0;

  var iduserx = 1;
  
  ////////////********* variables de recuperacion 
  
  
  
  var editId = 0;
  
  var editParte = 0;
  
  var editDescrip = "";
  
  var editCantidad = 0;
  
  var editUnidad = "";
  
  var editCosto = 0;
  
  var editIva = 0;
  
  var editDesc = 0;
  
  var editSubtotal = 0;
  
  var idFila = "";
  
  var editCproveedor = 0;
  
  var edittcambio = 0;
  
  var editUtil = 0;
  
  var editOrden = 0;
  
  
  
  
  
  function sumaTotal(){
  
  
  
    total_cot =0;
  
    total_desc =0;
  
    total_iva =0;
  
  
  
    $('#my-table').DataTable().rows().data().each(function(el, index){
  
      //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria
  
      total_cot = parseFloat(total_cot)+parseFloat(el[15]);
  
      total_desc = parseFloat(total_desc)+parseFloat(el[17]);
  
      total_iva = parseFloat(total_iva)+parseFloat(el[16]);
  
  
  
    });
  
  
  
    total_neto = parseFloat(total_cot)-parseFloat(total_desc)+parseFloat(total_iva);
  
  
  
    $("#tsubtotal").html( "Subtotal: "+formatNumber(round(total_cot) ));
  
    $("#tneto").html("Total: "+formatNumber(round(total_neto) ));
  
    $("#tdescuento").html( "Descuento: "+formatNumber(round(total_desc) ));
  
    $("#tiva").html( "Iva "+formatNumber(round(total_iva) ));
  
  
  
  }
  
  
  /* $(function () {
  
  
  
      'use strict';
  
  
  
      //alert("subiendo");
  
  
  
      // Change this to the location of your server-side upload handler:
  
  
  
      var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_evidencias/';
  
  
  
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
  
  
  
  }); */
  
  
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
  
  
  
        if ( colx == 3 ||  colx == 0 || colx == 5 || colx == 11 || colx == 7 ) {
  
  
  
          row.invalidate()
  
  
  
        }else{
  
  
  
            $.ajax({
  
              type: "POST",
  
              dataType: "json",
  
              url: base_urlx+"Altacotizacion/updateCelda/",
  
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
  
  
  
                    temp[6] = formatNumber( round(result.costo) );
  
                    temp[2] = round(result.cantidad);
  
                    temp[4] = result.descripcion;
  
                    temp[8] = round(result.descuento);
  
  
  
                    temp[9] = round(result.utilidad);
  
                    temp[10] = round(result.tcambio);
  
  
  
                    temp[11] = formatNumber( round( round(result.costo)*result.cantidad ) );
  
  
  
                    temp[15] = round(result.subtotal);
  
                    temp[16] = round(result.tiva);
  
                    temp[17] = round(result.tdescuento);
  
  
  
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
  
  //alert("Prueba");
  
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
  
                  $('td:eq(2)', nRow).addClass( 'alignRight' ).addClass( 'fontText3' );
  
                  $('td:eq(3)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
  
                  $('td:eq(4)', nRow).addClass( 'fontText' );
  
                  $('td:eq(5)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
  
                  $('td:eq(6)', nRow).addClass( 'alignRight' ).addClass( 'fontText3' );
  
                  $('td:eq(7)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
  
                  $('td:eq(8)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
  
                  $('td:eq(9)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
  
                  $('td:eq(10)', nRow).addClass( 'alignCenter' ).addClass( 'fontText2' );
  
  
  
                  $('td:eq(11)', nRow).addClass( 'alignRight' ).addClass( 'fontText3' );
  
  
  
                  //$('td:eq(2)', nRow).addClass( 'fontText2' );
  
                  
  
                }
  
          },
  
          columnDefs: [{ 
  
            targets: [1,2,4,6,7,8,9,10],
  
            createdCell: createdCell
  
          }],
  
  
  
          "paging": false,
  
          "processing": true,
  
          "serverSide": true,
  
          "search" : false,
  
          "ajax": base_urlx+"Altacotizacion/loadPartidas?iduser="+iduserx,
  
  
  
        //"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
  
  
  
          "scrollY": 300,
  
          "scrollX": true
  
      });
  
  
  
      /////////////********* CLICK 
  
      $('#my-table tbody').on('focusin', 'tr', function () {
  
          var data = table.row( this ).data();
  
  
  
  
  
          editId = data[12];
  
  
  
          //idFila = table.row( this ).index();
  
          editCantidad = data[2];
  
          editCosto = data[13];
  
          editCproveedor = data[18];
  
          edittcambio =data[10];
  
          editUtil = data[9];
  
          editOrden= data[1];
  
  
  
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
  
  
  
      $("#bi_pro").focus();
  
  
  
  });
  
  
  
        $('td').click(function(){ 
  
  
  
          var col = $(this).parent().children().index($(this)); 
  
          var row = $(this).parent().parent().children().index($(this).parent()); 
  
          //alert('Row: ' + row + ', Column: ' + col); 
  
  
  
        });
  
  
  
  
  
  
  
  var tiempoTranscurrido = Date.now();
  
  var hoy = new Date(tiempoTranscurrido);
  
  
  
  $("#fecha").val( hoy.toLocaleDateString() );
  
  
  
  
  
  
  
  showCliente();
  
  
  
  /////////****************** SELECT CATEGORIAS
  
  
  
  function showCliente(){
  
  
  
        $.ajax({
  
              type: "POST",
  
              dataType: "json",
  
              url: base_urlx+"Altacotizacion/showCliente/",
  
              cache: false,
  
              success: function(result)
  
              {
  
  
  
                if ( result != null ) {
  
  
  
                    var creaOption="<option value='0' selected>Selecciona un cliente...</option>"; 
  
  
  
                    $.each(result, function(i,item){
  
                        data1=item.id;//id
  
                        data2=item.rfc;//nombre
  
                        data3=item.nombre;//id
  
                        data4=item.comercial;//nombre
  
                        creaOption=creaOption+'<option value="'+data1+'">'+data2+'-'+data3+' <strong style="color:darkblue;">'+data4+'</strong></option>'; 
  
                    }); 
  
  
  
                    $("#cliente").html(creaOption);
  
                    $("#cliente").val(0);
  
  
  
                }else{
  
  
  
                   $("#cliente").html("<option value='0'>Sin categorias</option>");
  
  
  
                }
  
   
  
              }
  
  
  
      }).fail( function( jqXHR, textStatus, errorThrown ) {
  
  
  
  
  
          detectarErrorJquery(jqXHR, textStatus, errorThrown);
  
  
  
      });
  
  
  
  }
  
  
  
  //////////////******************* BUSCADOR DE PRODUCTOS 
  
  
  
      var options = {
  
  
  
        //url: "<?php echo base_url();?>js/countries.json",
  
        //url: "assets/files/buscar_clvproveedor_factura.php?clv=",
  
        url: function(phrase) {
  
  
  
          return  base_urlx+"Altacotizacion/buscarxdescrip?clv="+$('#bi_pro').val();
  
        
  
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
  
  
  
            $("#costo").val( formatNumber(costo_final) );
  
            $("#utilidad").val( $("#bi_pro").getSelectedItemData().utilidad );
  
            $("#precio").val( formatNumber( round($("#bi_pro").getSelectedItemData().precio) ) );
  
            $("#descripcion").val( $("#bi_pro").getSelectedItemData().descrip );
  
            valorcosto = $("#bi_pro").getSelectedItemData().costo;
  
            valorprecio = $("#bi_pro").getSelectedItemData().precio;
  
                ivax = $("#bi_pro").getSelectedItemData().iva;
  
  
  
                if ( ivax == 3 ) {
  
  
  
                    $("#idtasa").html( $("#bi_pro").getSelectedItemData().tasa+"% - iva");
  
                    $("#tasa").val( $("#bi_pro").getSelectedItemData().tasa );
  
  
  
                }else if ( ivax == 2 ) {
  
  
  
                    $("#tasa").val("0");
  
  
  
                }else{
  
  
  
                    $("#tasa").val( $("#bi_pro").getSelectedItemData().tasa );
  
  
  
                }
  
  
  
            idCiva = $("#bi_pro").getSelectedItemData().cimpuesto;
  
  
  
            $("#cantidad").focus();
  
  
  
            /////************* IMPUESTOS DE RETENCION
  
            porciento_rivax = $("#bi_pro").getSelectedItemData().porciento_riva;
  
            porciento_risrx = $("#bi_pro").getSelectedItemData().porciento_risr;
  
  
  
  
  
            if( porciento_risrx > 0 || porciento_rivax > 0 ) {
  
  
  
                $("#retenciones").css("display","");
  
  
  
                $("#valor_riva").val(porciento_rivax);
  
                $("#valor_risr").val(porciento_risrx);
  
  
  
                $("#tit_iva").html("Retencion IVA "+porciento_rivax+"%");
  
                $("#tit_isr").html("Retencion ISR "+porciento_risrx+"%");
  
  
  
            }else{
  
  
  
                $("#retenciones").css("display","none");
  
  
  
                $("#valor_riva").val("0");
  
                $("#valor_risr").val("0");
  
  
  
                $("#tit_iva").html("Retencion IVA 0%");
  
                $("#tit_isr").html("Retencion ISR 0%");
  
  
  
            }
  
  
  
          },
  
          onKeyEnterEvent: function(){
  
            idPro = $("#bi_pro").getSelectedItemData().id;
  
            $("#unidad").html( $("#bi_pro").getSelectedItemData().unidad );
  
  
  
            costo = round($("#bi_pro").getSelectedItemData().costo);
  
            costo_new = round($("#bi_pro").getSelectedItemData().costo_new);
  
  
  
            if ( costo_new > 0  ) {
  
  
  
              costo_final = costo_new;
  
  
  
            }else{
  
  
  
              costo_final = costo;
  
  
  
            }
  
  
  
            $("#costo").val( formatNumber(costo_final) );
  
            $("#utilidad").val( $("#bi_pro").getSelectedItemData().utilidad );
  
            $("#precio").val( formatNumber( round($("#bi_pro").getSelectedItemData().precio) ) );
  
            $("#descripcion").val($("#bi_pro").getSelectedItemData().descrip);
  
            valorcosto = $("#bi_pro").getSelectedItemData().costo;
  
            valorprecio = $("#bi_pro").getSelectedItemData().precio;
  
  
  
                ivax = $("#bi_pro").getSelectedItemData().iva;
  
  
  
                if ( ivax == 3 ) {
  
  
  
                    $("#idtasa").html( $("#bi_pro").getSelectedItemData().tasa+"% - iva");
  
                    $("#tasa").val( $("#bi_pro").getSelectedItemData().tasa );
  
  
  
                }else if ( ivax == 2 ) {
  
  
  
                    $("#tasa").val("0");
  
  
  
                }else{
  
  
  
                    $("#tasa").val("16");
  
  
  
                }
  
  
  
            idCiva = $("#bi_pro").getSelectedItemData().cimpuesto;
  
  
  
            $("#cantidad").focus();
  
  
  
            /////************* IMPUESTOS DE RETENCION
  
            porciento_rivax = $("#bi_pro").getSelectedItemData().porciento_riva;
  
            porciento_risrx = $("#bi_pro").getSelectedItemData().porciento_risr;
  
  
  
  
  
            if( porciento_risrx > 0 || porciento_rivax > 0 ) {
  
  
  
                $("#retenciones").css("display","");
  
  
  
                $("#valor_riva").val(porciento_rivax);
  
                $("#valor_risr").val(porciento_risrx);
  
  
  
                $("#tit_iva").html("Retencion IVA "+porciento_rivax+"%");
  
                $("#tit_isr").html("Retencion ISR "+porciento_risrx+"%");
  
  
  
            }else{
  
  
  
                $("#retenciones").css("display","none");
  
  
  
                $("#valor_riva").val("0");
  
                $("#valor_risr").val("0");
  
  
  
                $("#tit_iva").html("Retencion IVA 0%");
  
                $("#tit_isr").html("Retencion ISR 0%");
  
  
  
            }
  
             
  
          }
  
        }
  
      };
  
  
  
      $("#bi_pro").easyAutocomplete(options);
  
  
  
  //////////************************** CALCULAR SUBTOTAL
  
  
  
  function esconderTxt(e){
  
  
  
    if (e==1) {
  
  
  
      $("#txt_cantidad").css("display", "none");
  
  
  
    }
  
  
  
    if (e==2) {
  
  
  
      $("#txt_costo").css("display", "none");
  
  
  
    }
  
  
  
  }
  
  
  
  function calcularSubtotal(){
  
  
  
    cantidadx = round($("#cantidad").val());
  
    costox = round( $("#costo").val().replace(/[^\d.]/g,"") );
  
    descx = $("#descuento").val();
  
    utilx = $("#utilidad").val();
  
    tcambiox = round($("#tc").val());
  
    subtotalx = 0;
  
  
  
    ///**********OBLIGAR AL REDONDEO A 2 UNIDADES 
  
  
  
    $("#cantidad").val(cantidadx);
  
    $("#costo").val(formatNumber(costox));
  
    //$("#descuento").val(descx);
  
    //$("#utilidad").val(utilx);
  
    $("#tc").val(tcambiox);
  
  
  
  
  
    //alert($("#costo").val().replace(/[^\d.]/g,""));
  
  
  
      /*cantidadx = round($("#cantidad").val());
  
      costox = round( $("#costo").val().replace(/[^\d.]/g,"") );
  
      descx = round($("#descuento").val());
  
    utilx = round($("#utilidad").val());
  
    tcambiox = round($("#tc").val());*/
  
    
  
    
  
  
  
      if ( cantidadx > 0 && costox > 0 ) {
  
  
  
      if ( utilx > 0 ) {
  
  
  
        if ( tcambiox > 0 ) {
  
  
  
          costox = tcambiox*costox;
  
  
  
        }
  
  
  
        precio_new = parseFloat(costox)+parseFloat( round( costox*(utilx/100) ) );
  
  
  
        $("#precio").val( formatNumber( round(precio_new) ) );
  
  
  
            subtotalx = cantidadx * precio_new;
  
  
  
            $("#total").val( formatNumber( round(subtotalx) ) );
  
  
  
      }else{
  
  
  
        precio_new = 0;
  
  
  
        $("#precio").val( formatNumber( round(precio_new) ) );
  
  
  
        subtotalx = cantidadx * precio_new;
  
  
  
        $("#total").val( formatNumber( round(subtotalx) ) );
  
  
  
      }
  
  
  
      //////************* CALCULAR IMPUESTOS DE RETENCIONES
  
  
  
      if ( subtotalx > 0 ){
  
  
  
  
  
        if ( $("#valor_riva").val() > 0 ) {
  
  
  
          importe_riva = subtotalx*( $("#valor_riva").val()/100 );
  
          $("#riva").val( formatNumber( round(importe_riva) ) );
  
  
  
        }
  
  
  
        if ( $("#valor_risr").val() > 0 ) {
  
  
  
          importe_risr = subtotalx*( $("#valor_risr").val()/100 );
  
          $("#risr").val( formatNumber( round(importe_risr) ) );
  
  
  
        }
  
  
  
      }
  
  
  
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
  
  
  
      //alert("Alerta, favor de colocar una cantidad o costo con su utilidad valida para el producto");
  
  
  
    }
  
  
  
  }
  
  
  
  function calcularSubtotalPrecio(){
  
  
  
    preciox = round($("#precio").val().replace(/[^\d.]/g,"") );
  
    costox = round( $("#costo").val().replace(/[^\d.]/g,"") );
  
    tcambiox = round($("#tc").val());
  
    cantidadx = round($("#cantidad").val());
  
  
  
  
  
    //alert(preciox);
  
  
  
    if ( preciox > 0  ) {
  
  
  
      if ( tcambiox > 0 ) {
  
  
  
        preciox_stc= preciox/tcambiox;
  
  
  
      }else{
  
  
  
        preciox_stc= preciox;
  
  
  
      }
  
  
  
      utilx = ( ( parseFloat(preciox_stc)-parseFloat(costox) ) / costox )*100;
  
  
  
      $("#utilidad").val( round(utilx) );
  
  
  
      subtotalx = cantidadx * preciox;
  
  
  
      $("#total").val( formatNumber( round(subtotalx) ) );
  
  
  
    }
  
  
  
  }
  
  
  
  ///////////////********** ACTIVAR TASA
  
  
  
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
  
  
  
  ///////////********
  
  function focusDesc(){
  
  
  
      //alert("focus");
  
      $('#descuento').focus();
  
  
  
  }
  
  
  
  //////////////**************** INGRESAR PARTIDAS AL TEMPORAL
  
  
  
  function ingresarPartidas(){
  
  
  
      verificar = 0;
  
  
  
      calcularSubtotalPrecio();
  
  
  
    precio2x = $("#precio").val();
  
    preciox = precio2x.replace(/[^\d.]/g,"");
  
    costo_proveedorx = $("#costo").val().replace(/[^\d.]/g,"");
  
  
  
    //alert("precio: "+$("#precio").val());
  
  
  
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
  
    //////////////////////********************DESACTIVADO POR UTILIDAD GENERAL
  
      /*if( preciox <= 0 && verificar == 0 ){
  
  
  
          alert("Alerta, favor de seleccionar un precio valido del producto");
  
          verificar = 1;
  
          $("#precio").focus();
  
  
  
      }*/
  
      if( $("#descuento").val() < 0 && verificar == 0 ){
  
  
  
          $("#descuento").val("0");
  
  
  
      }
  
      if( $("#total").val() <= 0 && verificar == 0 ){
  
  
  
          alert("Alerta, favor de colocar un valor valido para el subtotal del producto");
  
          verificar = 1;
  
          $("#total").focus();
  
  
  
      }
  
  
  
    if( $("#descripcion").val() == "" && verificar == 0 ){
  
  
  
      alert("Alerta, favor de colocar una descripcion valida");
  
      verificar = 1;
  
      $("#descripcion").focus();
  
  
  
    }
  
  
  
    if ( $("#tc").val() == "" || $("#tc").val() == null ) {
  
  
  
      tcval = 1;
  
  
  
    }else{
  
  
  
      tcval = $("#tc").val();
  
  
  
    }
  
  
  
      if ( verificar == 0 ) {
  
  
  
          $("#btn_ingresar").prop("disabled",true);
  
      $("#btn_ingresar").html('<i class="fa fa-spinner fa-spin"></i>');
  
  
  
          $.ajax({
  
              type: "POST",
  
              dataType: "json",
  
              url: base_urlx+"Altacotizacion/ingresarPartidas/",
  
              data:{
  
  
  
                  idparte:idPro,
  
                  iduser:iduserx,
  
                  cantidad:$("#cantidad").val(),
  
                  costo:preciox,
  
                cproveedor:costo_proveedorx,
  
                  iva:$("#tasa").val(),
  
                  descuento:$("#descuento").val(),
  
                descripx:$("#descripcion").val(),
  
                rivax:$("#valor_riva").val(),
  
                risrx:$("#valor_risr").val(),
  
                tcambiox:tcval,
  
                utilidadx:$("#utilidad").val()
  
  
  
              },
  
              cache: false,
  
              success: function(result)
  
              {
  
  
  
                  if ( result > 0 ) {
  
     
  
                  $('#my-table').DataTable().ajax.reload();
  
                  table.buttons().container().appendTo( '#controlPanel' );
  
                      $("#bi_pro").val("");
  
                      idPro = 0;
  
                      $("#cantidad").val("");
  
                            $("#costo").val("");
  
                  $("#precio").val("");
  
                  $("#utilidad").val("");
  
                            $("#unidad").val("");
  
                            $("#tasa").val("0");
  
                            $("#descuento").val("0");
  
                            $("#total").val("0");
  
                            $("#divtasa").css("display", "none");
  
                      $("#bi_pro").focus();
  
                  $("#descripcion").val("");
  
  
  
                  $("#valor_riva").val("0");
  
                  $("#riva").val("0");
  
                  $("#valor_risr").val("0");
  
                  $("#risr").val("0");
  
                  $("#retenciones").css("display", "none");
  
                      
  
  
  
                  $("#tneto").html("Calculando...");
  
  
  
                  setTimeout(function (){
  
          
  
                      sumaTotal();              
  
                                
  
                  }, 1000);
  
  
  
                      }else if ( result == null ){
  
  
  
                  alert("Error, favor de intentarlo nuevamente de persistir el error favor de comunicarse con el administrador");
  
  
  
                }else{
  
  
  
                  alert("Alerta, la partida ya se encuentra en su cotización");
  
  
  
                  $("#bi_pro").val("");
  
                  idPro = 0;
  
                  $("#cantidad").val("");
  
                  $("#costo").val("");
  
                  $("#precio").val("");
  
                  $("#utilidad").val("");
  
                  $("#unidad").val("");
  
                  $("#tasa").val("0");
  
                  $("#descuento").val("0");
  
                  $("#total").val("0");
  
                  $("#divtasa").css("display", "none");
  
                  $("#bi_pro").focus();
  
                  $("#descripcion").val("");
  
  
  
                  $("#valor_riva").val("0");
  
                  $("#riva").val("0");
  
                  $("#valor_risr").val("0");
  
                  $("#risr").val("0");
  
                  $("#retenciones").css("display", "none");
  
  
  
                }
  
  
  
                      $("#btn_ingresar").prop("disabled",false);
  
                      $("#btn_ingresar").html('<i class="fa fa-arrow-right"></i>');
  
       
  
              }
  
  
  
        }).fail( function( jqXHR, textStatus, errorThrown ) {
  
  
  
  
  
              detectarErrorJquery(jqXHR, textStatus, errorThrown);
  
  
  
        });
  
  
  
      }
  
  
  
  }
  
  
  
  function tmoneda(monedax){
  
  
  
    if ( monedax == 2 ) {
  
  
  
      $("#tc").prop("disabled",false);
  
      $("#tc").focus();
  
  
  
  
  
    }else{
  
  
  
      $("#tc").prop("disabled",true);
  
      $("#tc").val("1");
  
  
  
    }
  
  
  
  }
  
  
  
  function retirarParte(idpartex,torden){
  
  
  
    x = confirm("¿Realmente deseas retirar esta partida?");
  
  
  
    if ( x ) {
  
  
  
      $.ajax({
  
              type: "POST",
  
              dataType: "json",
  
              url: base_urlx+"Altacotizacion/retirarParte/",
  
              data:{
  
  
  
                idpcot:idpartex,
  
                ordenx:torden,
  
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
  
  
  
  function editarPartida(){
  
  
  
    /*editId
  
    editParte
  
    editDescrip
  
    editCantidad
  
    editUnidad
  
    editCosto
  
    editIva
  
    editDesc*/
  
  
  
    $("#bi_pro").val(editDescrip);
  
    idPro = editParte;
  
    idPact = editId;
  
    $("#cantidad").val(editCantidad);
  
    $("#unidad").val(editUnidad);
  
    $("#costo").val(editCosto);
  
  
  
    if ( editIva == 0 ) {
  
  
  
      $("#iva").val(2);
  
  
  
    }else if ( editIva == 16 ) {
  
  
  
      $("#iva").val(1);
  
  
  
    }else{
  
  
  
      $("#iva").val(3);
  
      $("#divtasa").css("display", "");
  
      $("#tasa").prop("disabled", false);
  
  
  
  
  
    }
  
  
  
    $("#tasa").val(editIva);
  
    $("#descuento").val(editDesc);
  
    $("#total").val(editSubtotal);
  
  
  
    $("#btn_alta").css("display", "none");
  
    $("#btn_act").css("display", "");
  
  
  
    $("#cantidad").focus();
  
  
  
  }
  
  
  
  function cancelarIngreso(){
  
  
  
    $("#bi_pro").val("");
  
    idPro = 0 ;
  
    $("#cantidad").val("");
  
    $("#unidad").val("");
  
    $("#costo").val("");
  
    $("#iva").val(1);
  
    $("#divtasa").css("display", "none");
  
    $("#tasa").prop("disabled", true);
  
  
  
    $("#tasa").val("0");
  
    $("#descuento").val("");
  
    $("#total").val("");
  
  
  
    $("#btn_alta").css("display", "");
  
    $("#btn_act").css("display", "none");
  
  
  
    $("#bi_pro").focus();
  
  
  
  }
  
  
  /* $(function () {
  
  
  
      'use strict';
  
  
  
      //alert("subiendo");
  
  
  
      // Change this to the location of your server-side upload handler:
  
  
  
      var url = window.location.hostname === 'blueimp.github.io' ?  '//jquery-file-upload.appspot.com/' : base_urlx+'tw/js/upload_evidencias/';
  
  
  
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
  
  
  
  }); */
  
  
  function actualizarPartidas(){
  
  
  
    verificar = 0;
  
  
  
    calcularSubtotal();
  
  
  
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
  
    if( $("#precio").val() <= 0 && verificar == 0 ){
  
  
  
      alert("Alerta, favor de seleccionar un precio valido del producto");
  
      verificar = 1;
  
      $("#precio").focus();
  
  
  
    }
  
    if( $("#descuento").val() < 0 && verificar == 0 ){
  
  
  
      $("#descuento").val("0");
  
  
  
    }
  
    if( $("#total").val() <= 0 && verificar == 0 ){
  
  
  
      alert("Alerta, favor de colocar un valor valido para el subtotal del producto");
  
      verificar = 1;
  
      $("#total").focus();
  
  
  
    }
  
    if( $("#tasa").val() < 0 && verificar == 0 ){
  
      
  
      $("#tasa").val("0");
  
  
  
    }
  
  
  
  
  
    if ( verificar == 0 ) {
  
  
  
      $("#btn_ingresar2").prop("disabled",true);
  
      $("#btn_ingresar2").html('<i class="fa fa-spinner fa-spin"></i>');
  
  
  
      $.ajax({
  
              type: "POST",
  
              dataType: "json",
  
              url: base_urlx+"Altacotizacion/actualizarPartidas/",
  
              data:{
  
  
  
                idparte:idPro,
  
                iduser:iduserx,
  
                cantidad:$("#cantidad").val(),
  
                costo:$("#precio").val(),
  
                iva:$("#tasa").val(),
  
                descuento:$("#descuento").val(),
  
                idpcot:idPact
  
  
  
              },
  
              cache: false,
  
              success: function(result)
  
              {
  
  
  
                if ( result > 0 ) {
  
     
  
                  $('#my-table').DataTable().ajax.reload();
  
                  $("#bi_pro").val("");
  
                  idPro = 0;
  
                  $("#cantidad").val("");
  
                  $("#costo").val("");
  
                  $("#precio").val("");
  
                  $("#utilidad").val("");
  
                  $("#unidad").val("");
  
                  $("#tasa").val("0");
  
                  $("#descuento").val("0");
  
                  $("#total").val("0");
  
                  $("#divtasa").css("display", "none");
  
                  $("#btn_alta").css("display", "");
  
                  $("#btn_act").css("display", "none");
  
                  $("#bi_pro").focus();
  
  
  
                  $("#tneto").html("Calculando...");
  
  
  
                  setTimeout(function (){
  
          
  
                      sumaTotal();              
  
                                
  
                  }, 1000);
  
                    
  
  
  
                }else if ( result == null ){
  
  
  
                  alert("Error, favor de intentarlo nuevamente de persistir el error favor de comunicarse con el administrador");
  
  
  
                }
  
  
  
                $("#btn_ingresar2").prop("disabled",false);
  
                $("#btn_ingresar2").html('<i class="fa fa-arrow-right"></i>');
  
       
  
              }
  
  
  
      }).fail( function( jqXHR, textStatus, errorThrown ) {
  
  
  
  
  
            detectarErrorJquery(jqXHR, textStatus, errorThrown);
  
  
  
      });
  
  
  
    }
  
  
  
  }
  
  
  
  function showPDF(idcotx,pedidox){
  
  
  
        $.ajax({
  
  
  
            type: "POST",
  
            dataType: "json",
  
            url: base_urlx+"tw/php/pdf_cotizacion.php",
  
            data:{ 
  
  
  
                idcot:idcotx
  
  
  
              },
  
            cache: false,
  
            success: function(result)
  
            {
  
  
  
              //window.open(base_urlx+"tw/php/cotizaciones/cot"+idcotx+".pdf", "_blank");
  
              if(pedidox==1){
  
  
                  $.ajax({
  
                        type: "POST",
  
                        dataType: "json",
  
                        url: base_urlx+"tw/php/verificar_url.php",
  
                        data: { archivo:$("#name_factpdf").val(), cotizacion:idcotx },
  
                        cache: false,
  
                        success: function(result)
  
                        { 
  
  
  
                          if(result){
  
  
  
                            //alert("Alerta, el PEDIDO ha sido creado con exito");
  
                            enviarCorreo(idcotx,true);
  
                          }else{
  
  
  
                            // alert("Error, la URL no ha podido ser validada");
  
                            enviarCorreo(idcotx,false);
  
  
  
                          }
  
  
  
                        }
  
  
  
                  });
  
  
              }else{
  
                enviarCorreo(idcotx);
  
              }
  
              
  
              //alert("Alerta, la cotización se almaceno correctamente, enviando...")
  
              
  
            }
  
  
  
        }); 
  
  
  
  
  
  }
  
  
  
  function enviarCorreo(idcotx,resultadox){
  
  
  
        $.ajax({
  
  
  
            type: "POST",
  
            dataType: "json",
  
            url: base_urlx+"Altacotizacion/enviarCorreo",
  
            data:{ 
  
  
  
                idcot:idcotx
  
  
  
              },
  
            cache: false,
  
            success: function(result)
  
            {
  
  
  
              if (result ) {
  
  
  
                window.open(base_urlx+"tw/php/cotizaciones/cot"+idcotx+".pdf", "_blank");
  
                if(resultadox){
  
                  alert("Alerta, la cotización se ha convertido a PEDIDO correctamente y ha sido enviada")
  
                }else{
  
                  alert("Alerta, la cotización se almaceno correctamente y ha sido enviada");
  
                }
  
                location.reload();
  
              }else{
  
  
  
                window.open(base_urlx+"tw/php/cotizaciones/cot"+idcotx+".pdf", "_blank");
  
                if(resultadox){
  
                  alert("Alerta, la cotización se ha convertido a PEDIDO correctamente y ha sido enviada")
  
                }else{
  
                  alert("Alerta, la cotización se almaceno correctamente, pero no ha podido ser enviada");
  
                }
  
                location.reload();
  
  
  
              }
  
  
  
              
  
            }
  
  
  
        }); 
  
  
  
  
  
  }
  
  
  
  
  
  function finalizarCotizacion(pedidox){
  
  
  
    x = confirm("¿Realmente deseas finalizar la cotización actual?");
  
  
  
    if ( x ) {
  
  
  
      subx = 0;
  
  
  
        $('#my-table').DataTable().rows().data().each(function(el, index){
  
        //Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria
  
        subx = parseFloat(subx)+parseFloat(el[15]);
  
  
  
      });
  
  
  
      verificar = 0;
  
  
  
      if ( subx <= 0 ) {
  
  
  
        alert("Alerta, no se han encontrado partidas en tu cotizacion o esta tiene un costo igual a 0");
  
        verificar = 1;
  
  
  
      }
  
      if(pedidox==1){
  
        if ( $("#name_factpdf").val() == ""  || $("#name_factpdf").val() == null ) {
  
          alert("Alerta, favor de añadir un archivo valido para la evidencia");
  
          verificar=1;
  
        }
  
      }
  
  
  
      if ( $("#cliente").val() <= 0 && verificar == 0 || $("#cliente").val() == null && verificar == 0  ) {
  
  
  
        alert("Alerta, favor de seleccionar un cliente valido");
  
        verificar = 1;
  
        $("#cliente").focus();
  
  
  
      }
  
  
  
      /*if ( $("#fecha").val() == "" ) {
  
  
  
        alert("Alerta, favor de agregar una fecha valida para la cotización");
  
        verificar = 1;
  
        $("#fecha").focus();
  
  
  
      }*/
  
  
  
  
  
      if ( verificar == 0 ) {
  
  
  
        $("#btn_finalizar").prop("disabled",true);
  
        $("#btn_finalizar").html('Generando...');
  
  
  
        $.ajax({
  
              type: "POST",
  
              dataType: "json",
  
              url: base_urlx+"Altacotizacion/finalizarCotizacion/",
  
              data:{
  
  
  
                idcliente:$("#cliente").val(),
  
                fecha:$("#fecha").val(),
  
                iduser:iduserx,
  
                obsx:$("#obs").val(),
  
                monedax:$("#moneda").val(),
  
                tcx:$("#tc").val()
  
  
  
              },
  
              cache: false,
  
              success: function(result)
  
              {
  
  
  
                if ( result > 0 ) {
  
  
  
                  //alert("Alerta, la cotización se almaceno correctamente");
  
  
  
                  showPDF(result,pedidox);
  
  
  
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
  
  
  
  function porcientoAll(){
  
  
  
    x = confirm("¿Realmente deseas actualizar todos los porcentajes?");  
  
  
  
        $.ajax({
  
              type: "POST",
  
              dataType: "json",
  
              url: base_urlx+"Altacotizacion/porcientoAll/",
  
              data:{
  
  
  
                gutilidad:$("#gutilidad").val(),
  
                gdescuento:$("#gdescuento").val(),
  
                idusuario:iduserx
  
  
  
              },
  
              cache: false,
  
              success: function(result)
  
              {
  
  
  
                //alert(result);
  
  
  
                if ( result ) {
  
  
  
                  $('#my-table').DataTable().ajax.reload();
  
  
  
                  setTimeout(function (){
  
          
  
                      sumaTotal();              
  
                                
  
                  }, 1000);
  
                  alert("Los porcentajes han sido actualizados correctamente");
  
  
  
                }else{
  
  
  
                  alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");
  
  
  
                }
  
  
  
                //$("#btn_finalizar").prop("disabled",false);
  
                //$("#btn_finalizar").html('<i class="icon-check" ></i style="color:black;"> Finalizar');
  
  
  
              }
  
  
  
        }).fail( function( jqXHR, textStatus, errorThrown ) {
  
  
  
  
  
            detectarErrorJquery(jqXHR, textStatus, errorThrown);
  
  
  
        });
  
    
  
  
  
  }
  
  
  
  function porcientoFal(){
  
  
  
    x = confirm("¿Realmente deseas actualizar los porcentajes faltantes o no asignados?");  
  
  
  
        $.ajax({
  
              type: "POST",
  
              dataType: "json",
  
              url: base_urlx+"Altacotizacion/porcientoFal/",
  
              data:{
  
  
  
                gutilidad:$("#gutilidad").val(),
  
                gdescuento:$("#gdescuento").val(),
  
                idusuario:iduserx
  
  
  
  
  
              },
  
              cache: false,
  
              success: function(result)
  
              {
  
  
  
                //alert(result);
  
  
  
                if ( result ) {
  
  
  
                  $('#my-table').DataTable().ajax.reload();
  
                  
  
                  setTimeout(function (){
  
          
  
                      sumaTotal();              
  
                                
  
                  }, 1000);
  
                  alert("Los porcentajes han sido actualizados correctamente");
  
  
  
                }else{
  
  
  
                  alert("Error, favor de intentarlo nuevamente de persistir el error comuniquese con el administrador");
  
  
  
                }
  
  
  
                //$("#btn_finalizar").prop("disabled",false);
  
                //$("#btn_finalizar").html('<i class="icon-check" ></i style="color:black;"> Finalizar');
  
  
  
              }
  
  
  
        }).fail( function( jqXHR, textStatus, errorThrown ) {
  
  
  
  
  
            detectarErrorJquery(jqXHR, textStatus, errorThrown);
  
  
  
        });
  
  
  
  }
  
  
  
  function cancelarCotizacion(){
  
  
  
    x = confirm("¿Realmente deseas CANCELAR la cotizacion actual?");
  
  
  
    if (x) {
  
  
  
      $("#btn_cancelar").prop("disabled",true);
  
      $("#btn_cancelar").html('Cancelando...');
  
  
  
      $.ajax({
  
              type: "POST",
  
              dataType: "json",
  
              url: base_urlx+"Altacotizacion/cancelarCotizacion/",
  
              data:{
  
  
  
                  iduser:iduserx
  
  
  
              },
  
              cache: false,
  
              success: function(result)
  
              {
  
  
  
                if ( result ) {
  
     
  
                  location.reload();
  
  
  
                }
  
  
  
                $("#btn_cancelar").prop("disabled",false);
  
                $("#btn_cancelar").html('<i class="icon-cancel"></i> cancelar');
  
       
  
              }
  
  
  
      }).fail( function( jqXHR, textStatus, errorThrown ) {
  
  
  
  
  
            detectarErrorJquery(jqXHR, textStatus, errorThrown);
  
  
  
      });
  
  
  
    }
  
  
  
  }
  
  
  
  function showObs(){
  
  
  
    $("#agobs").css("display", "");
  
    $("#cerrarobs").css("display", "");
  
    $("#abrirobs").css("display", "none");
  
    $("#obs").focus();
  
  
  
  }
  
  
  
  function cerrarObs(){
  
  
  
    $("#agobs").css("display", "none");
  
    $("#abrirobs").css("display", "");
  
    $("#cerrarobs").css("display", "none");
  
    $("#bi_pro").focus();
  
  
  
  }
  
  
  
  function cerrarSesion(){
  
  
  
      var x = confirm("¿Realmente deseas cerrar la sesión?");
  
  
  
      if( x==true ){
  
  
  
        window.location.href = base_urlx+"Login/CerrarSesion/";
  
        
  
      }  
  
  
  
  }
  
  
  
  ///////
  
  
  
  function recargar(){
  
  
  
    $("#cliente").select2("destroy");
  
    showCliente();
  
  
  
    $(".select2").select2();
  
      $(".select2-placeholer").select2({
  
        allowClear: true
  
  
  
      });
  
  
  
    //////////////******************* BUSCADOR DE PRODUCTOS 
  
  
  
      var options = {
  
  
  
        //url: "<?php echo base_url();?>js/countries.json",
  
        //url: "assets/files/buscar_clvproveedor_factura.php?clv=",
  
        url: function(phrase) {
  
  
  
          return  base_urlx+"Altacotizacion/buscarxdescrip?clv="+$('#bi_pro').val();
  
        
  
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
  
  
  
  
  
            $("#costo").val( formatNumber( round($("#bi_pro").getSelectedItemData().costo) ) );
  
            $("#utilidad").val( $("#bi_pro").getSelectedItemData().utilidad );
  
            $("#precio").val( formatNumber( round($("#bi_pro").getSelectedItemData().precio) ) );
  
            $("#descripcion").val( $("#bi_pro").getSelectedItemData().descrip );
  
            valorcosto = $("#bi_pro").getSelectedItemData().costo;
  
            valorprecio = $("#bi_pro").getSelectedItemData().precio;
  
              ivax = $("#bi_pro").getSelectedItemData().iva;
  
  
  
              if ( ivax == 3 ) {
  
  
  
                $("#idtasa").html( $("#bi_pro").getSelectedItemData().tasa+"% - iva");
  
                $("#tasa").val( $("#bi_pro").getSelectedItemData().tasa );
  
  
  
              }else if ( ivax == 2 ) {
  
  
  
                $("#tasa").val("0");
  
  
  
              }else{
  
  
  
                $("#tasa").val("16");
  
  
  
              }
  
  
  
            idCiva = $("#bi_pro").getSelectedItemData().cimpuesto;
  
  
  
            $("#cantidad").focus();
  
  
  
          },
  
          onKeyEnterEvent: function(){
  
            idPro = $("#bi_pro").getSelectedItemData().id;
  
            $("#unidad").html( $("#bi_pro").getSelectedItemData().unidad );
  
            $("#costo").val( formatNumber( round($("#bi_pro").getSelectedItemData().costo) ) );
  
            $("#utilidad").val( $("#bi_pro").getSelectedItemData().utilidad );
  
            $("#precio").val( formatNumber( round($("#bi_pro").getSelectedItemData().precio) ) );
  
            $("#descripcion").val($("#bi_pro").getSelectedItemData().descrip);
  
            valorcosto = $("#bi_pro").getSelectedItemData().costo;
  
            valorprecio = $("#bi_pro").getSelectedItemData().precio;
  
  
  
              ivax = $("#bi_pro").getSelectedItemData().iva;
  
  
  
              if ( ivax == 3 ) {
  
  
  
                $("#idtasa").html( $("#bi_pro").getSelectedItemData().tasa+"% - iva");
  
                $("#tasa").val( $("#bi_pro").getSelectedItemData().tasa );
  
  
  
              }else if ( ivax == 2 ) {
  
  
  
                $("#tasa").val("0");
  
  
  
              }else{
  
  
  
                $("#tasa").val("16");
  
  
  
              }
  
  
  
            idCiva = $("#bi_pro").getSelectedItemData().cimpuesto;
  
  
  
            $("#cantidad").focus();
  
             
  
          }
  
        }
  
      };
  
  
  
      $("#bi_pro").easyAutocomplete(options);
  
  
  
  }