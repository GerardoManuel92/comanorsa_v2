showCategoria();
showMarca();
showPartidas();

var total_filas = 0; // Variable para almacenar el número total de filas

$(document).ready(function() {
	// Código para inicializar Select2 en tu elemento
	$('#bmarca').select2();
});

function showPartidas() {
	// Destruir la tabla si ya está inicializada
	if ($.fn.DataTable.isDataTable("#my-table")) {
		$("#my-table").DataTable().destroy();
	}

	table = $("#my-table").DataTable({
		language: {
			lengthMenu: "Mostrando _MENU_ articulos por pagina",

			zeroRecords: "No hay partidas que mostrar",

			info: "Total _TOTAL_ partidas<br>",

			infoEmpty: "No hay partidas que mostrar",

			emptyTable: "No hay partidas que mostrar",

			infoFiltered: "(filtrado de _MAX_ articulos totales)",

			loadingRecords: "Cargando...",

			processing: "Procesando...",

			search: "Buscar por descripcion, sku o #parte:",

			paginate: {
				first: "Primero",

				last: "Ultimo",

				next: "Siguiente",

				previous: "Anterior",
			},
		},

		dom: '<"top" fpli>rt',

		buttons: ["copy", "excel", "csv"],

		order: [[3, "asc"]],

		fnRowCallback: function (nRow, aData, iDisplayIndex) {
			/* Append the grade to the default row class name */

			/* Append the grade to the default row class name */
			//var miDataTable = $("#my-table").DataTable();

			// Obtén la información sobre la tabla
			//var info = table.page.info();

			if (true) {
				// your logic here

				total_filas ++;

				$(nRow).addClass("customFont");

				$("td:eq(0)", nRow).addClass("alignCenter");

				$("td:eq(1)", nRow).addClass("alignCenter");

				$("td:eq(3)", nRow).addClass("alignCenter");

				$("td:eq(4)", nRow).addClass("alignCenter");

				$("td:eq(5)", nRow).addClass("alignCenter");

				$("td:eq(6)", nRow).addClass("alignCenter");

				$("td:eq(7)", nRow).addClass("alignRight");

				$("td:eq(8)", nRow).addClass("alignCenter");
				
			}
			/* $(".dataTables_length").empty().append(
				" Registros encontrados: " + info.recordsTotal
			);
			 */
		},

		processing: true,

		serverSide: true,

		search: false,

		ajax: base_urlx + "Rproducto/loadPartidas",

		lengthMenu: [
			[10, 25, 50, -1],
			[10, 25, 50, "All"],
		],

		scrollY: 450,

		scrollX: true,
	});

	/////////////********* CLICK


	$("#my-table_filter").find("input").focus();
	/* console.log(total_filas); */
	
}

function contarFilas() {
	
	var total_filas = 0; // Variable para almacenar el número total de filas
  
	$('#my-table').DataTable().rows().data().each(function (el, index) {
	  // Asumiendo que es la columna 5 de cada fila la que quieres agregar a la sumatoria
	  /* total_cot = parseFloat(total_cot) + parseFloat(el[15]);
	  total_desc = parseFloat(total_desc) + parseFloat(el[17]);
	  total_iva = parseFloat(total_iva) + parseFloat(el[16]);
   */
	  total_filas++; // Incrementa el contador de filas
	});
  
	/* total_neto = parseFloat(total_cot) - parseFloat(total_desc) + parseFloat(total_iva);
  
	$("#tsubtotal").html("Subtotal: " + formatNumber(round(total_cot)));
	$("#tneto").html("Total: " + formatNumber(round(total_neto)));
	$("#tdescuento").html("Descuento: " + formatNumber(round(total_desc)));
	$("#tiva").html("Iva " + formatNumber(round(total_iva))); */
  
	// Muestra el número total de filas
	/* console.log(total_filas); */
	//$("#tnumfilas").html("Número total de filas: " + total_filas);
  }
  

///////*********** MUESTRA LAS CATEGORIAS EN EL SELECT */

function showCategoria() {
	$.ajax({
		type: "POST",

		dataType: "json",

		url: base_urlx + "Rproducto/showCategoria/",

		cache: false,

		success: function (result) {
			if (result != null) {
				var creaOption = "<option value='0' selected>Todas...</option>";

				$.each(result, function (i, item) {
					data1 = item.id; //id

					data2 = item.descripcion; //descripcion

					creaOption =
						creaOption + '<option value="' + data1 + '">' + data2 + "</option>";
				});

				$("#bcategoria").html(creaOption);
			} else {
				$("#bcategoria").html("<option value='0'>Sin proveedores</option>");
			}
		},
	}).fail(function (jqXHR, textStatus, errorThrown) {
		detectarErrorJquery(jqXHR, textStatus, errorThrown);
	});
}



function showMarca() {
	$.ajax({
		type: "POST",

		dataType: "json",

		url: base_urlx + "Rproducto/showMarca/",

		cache: false,

		success: function (result) {
			if (result != null) {
				var creaOption = "<option value='0' selected>Todas...</option>";

				$.each(result, function (i, item) {
					data1 = item.id; //id

					data2 = item.marca; //marca

					creaOption =
						creaOption + '<option value="' + data1 + '">' + data2 + "</option>";
				});

				$("#bmarca").html(creaOption);
			} else {
				$("#bmarca").html("<option value='0'>Sin marcas</option>");
			}
		},
	}).fail(function (jqXHR, textStatus, errorThrown) {
		detectarErrorJquery(jqXHR, textStatus, errorThrown);
	});
}

function showMarcaxCategoria() {
	$.ajax({
		type: "GET",

		dataType: "json",

		url: base_urlx + "Rproducto/showMarca/",

		data: { categoriaId: $("#bcategoria").val() },

		cache: false,

		success: function (result) {
			if (result != null) {
				var creaOption = "<option value='0' selected>Marca...</option>";

				$.each(result, function (i, item) {
					data1 = item.id; //id

					data2 = item.marca; //marca

					creaOption =
						creaOption + '<option value="' + data1 + '">' + data2 + "</option>";
				});

				$("#bmarca").html(creaOption);
			} else {
				$("#bmarca").html("<option value='0'>Sin proveedores</option>");
			}
		},
	}).fail(function (jqXHR, textStatus, errorThrown) {
		detectarErrorJquery(jqXHR, textStatus, errorThrown);
	});
}

function showCategoriaxMarca() {
	$.ajax({
		type: "GET",

		dataType: "json",

		url: base_urlx + "Rproducto/showCategoriaxMarcas/",

		data: { marcaId: $("#bmarca").val(), categoriaId: $("#bcategoria").val() },

		cache: false,

		success: function (result) {
			if (result != null) {
				var creaOption = "<option value='0' selected>Categoria...</option>";

				$.each(result, function (i, item) {
					data1 = item.id; //id

					data2 = item.descripcion; //marca

					creaOption =
						creaOption + '<option value="' + data1 + '">' + data2 + "</option>";
				});

				$("#bcategoria").html(creaOption);
			} else {
				$("#bcategoria").html("<option value='0'>Sin categorias</option>");
			}
		},
	}).fail(function (jqXHR, textStatus, errorThrown) {
		detectarErrorJquery(jqXHR, textStatus, errorThrown);
	});
}

function validaCombo() {
	var cat = $("#bcategoria").val();
	var mar = $("#bmarca").val();

	if (cat == 0 && mar > 0) {
		showCategoriaxMarca();
	} else if (cat > 0 && mar == 0) {
		showMarcaxCategoria();
	}
}



////////******* ACTUALIZAR TABLA CON FILTROS

function crearTabla() {
	verificar = 0;

	if ($("#inicio").val() == "") {
		verificar = 1;

		$("#inicio").focus();
	}

	if ($("#final").val() == "" && verificar == 0) {
		verificar = 1;

		$("#final").focus();
	}

	if (verificar == 0) {
		$("#my-table").DataTable().destroy();

		table = $("#my-table").DataTable({
			language: {
				lengthMenu: "Mostrando _MENU_ articulos por pagina",

				zeroRecords: "No hay partidas que mostrar",

				info: "Mostrando pagina _PAGE_ de _PAGES_",

				infoEmpty: "No hay partidas que mostrar",

				emptyTable: "No hay partidas que mostrar",

				infoFiltered: "(filtrado de _MAX_ articulos totales)",

				loadingRecords: "Cargando...",

				processing: "Procesando...",

				search: "Buscar por cotizador o proyecto:",

				paginate: {
					first: "Primero",

					last: "Ultimo",

					next: "Siguiente",

					previous: "Anterior",
				},
			},

			dom: '<"top" pl>rt',

			buttons: ["copy", "excel", "csv"],

			order: [[0, "desc"]],

			fnRowCallback: function (nRow, aData, iDisplayIndex) {
				/* Append the grade to the default row class name */

				if (true) {
					// your logic here

					$(nRow).addClass("customFont");

					$("td:eq(0)", nRow).addClass("alignCenter");

					$("td:eq(1)", nRow).addClass("alignCenter");

					$("td:eq(2)", nRow).addClass("alignCenter");

					$("td:eq(3)", nRow).addClass("alignCenter");

					$("td:eq(4)", nRow).addClass("alignCenter");
				}
			},

			processing: true,

			serverSide: true,

			search: false,

			ajax:
				base_urlx +
				"Rproducto/loadPartidas?finicio=" +
				$("#inicio").val() +
				"&ffinal=" +
				$("#final").val() +
				"&departamento=" +
				$("#departamento option:selected").html() +
				"&iduser=" +
				$("#idusuario").val(),

			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, "All"],
			],

			scrollY: 450,

			scrollX: true,
		});
	}
}

function retirarProducto(idx) {
	if (idx > 0) {
		x = confirm("¿Realmente deseas retirar este producto?");

		if (x) {
			$.ajax({
				type: "POST",

				dataType: "json",

				url: base_urlx + "Rproducto/retirarProducto/",

				data: { idpro: idx },

				cache: false,

				success: function (result) {
					if (result) {
						alert("Alerta, el producto ha sido retirado correctamente");

						location.reload();
					} else {
						alert("Error, favor de intentarlo nuevamente");
					}
				},
			}).fail(function (jqXHR, textStatus, errorThrown) {
				detectarErrorJquery(jqXHR, textStatus, errorThrown);
			});
		}
	} else {
		alert(
			"Alerta, el id del producto no pudo ser localizado, favor de recargar la pagina"
		);
	}
}

function showInfoCategoria() {
	
	if ($("#bmarca").val() > 0 ) {
		// Destruir la tabla si ya está inicializada
		if ($.fn.DataTable.isDataTable("#my-table")) {
			$("#my-table").DataTable().destroy();
		}

		table = $("#my-table").DataTable({
			language: {
				lengthMenu: "Mostrando _MENU_ articulos por pagina",

				zeroRecords: "No hay partidas que mostrar",

				info: "Total _TOTAL_ partidas<br>",

				infoEmpty: "No hay partidas que mostrar",

				emptyTable: "No hay partidas que mostrar",

				infoFiltered: "(filtrado de _MAX_ articulos totales)",

				loadingRecords: "Cargando...",

				processing: "Procesando...",

				search: "Buscar por descripcion, sku o #parte:",

				paginate: {
					first: "Primero",

					last: "Ultimo",

					next: "Siguiente",

					previous: "Anterior",
				},
			},

			dom: '<"top" fpli>rt',

			buttons: ["copy", "excel", "csv"],

			order: [[3, "asc"]],

			fnRowCallback: function (nRow, aData, iDisplayIndex) {
				/* Append the grade to the default row class name */

				/* Append the grade to the default row class name */
				//var miDataTable = $("#my-table").DataTable();

				// Obtén la información sobre la tabla
				//var info = table.page.info();

				if (true) {
					// your logic here

					$(nRow).addClass("customFont");

					$("td:eq(0)", nRow).addClass("alignCenter");

					$("td:eq(1)", nRow).addClass("alignCenter");

					$("td:eq(3)", nRow).addClass("alignCenter");

					$("td:eq(4)", nRow).addClass("alignCenter");

					$("td:eq(5)", nRow).addClass("alignCenter");

					$("td:eq(6)", nRow).addClass("alignCenter");

					$("td:eq(7)", nRow).addClass("alignRight");

					$("td:eq(8)", nRow).addClass("alignCenter");
				}
				/* $(".dataTables_length").empty().append(
					"<label> Registros encontrados: " + info.recordsTotal + '</label>'
				); */
				
			},

			processing: true,

			serverSide: true,

			search: false,

			ajax: {
				url: base_urlx + "Rproducto/loadPartidasCategoria",
				type: "GET",
				data: {
					categoriaId: $("#bcategoria").val(),
					marcaId: $("#bmarca").val(),
				},
			},

			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, "All"],
			],

			scrollY: 450,

			scrollX: true,
		});

		$("#my-table_filter").find("input").focus();
		
	}
}

function showexcel() {
	var inputSearch = $("#my-table_filter input[type='search']");

	// Obtiene el valor actual del input de búsqueda
	var valorSearch = inputSearch.val();

	// Hacer algo con el valor obtenido
	/* console.log("Valor del input de búsqueda:", valorSearch); */

	$.ajax({
		type: "POST",

		dataType: "json",

		url: base_urlx + "tw/php/crear_excel_productos.php",

		data: {
			categoriax: $("#bcategoria").val(),
			marcax: $("#bmarca").val(),
			inputx: valorSearch,
		},

		cache: false,

		success: function (result) {
			if (result) {
				window.location.href = base_urlx + "tw/php/reporte/hoja_productos.xlsx";
			} else {
				alert("No se pudo generar excel");
			}
		},
	});
}

function cerrarSesion() {
	var x = confirm("¿Realmente deseas cerrar la sesión?");

	if (x == true) {
		window.location.href = base_urlx + "Login/CerrarSesion/";
	}
}

function reestablecer() {
	var inputSearch = $("#my-table_filter input[type='search']");
	var valorSearch = inputSearch.val("");
	var select2Element = $('#bmarca');
	var select2Categoria = $('#bcategoria');
	
	select2Element.val(null).trigger('change');
	select2Categoria.val(null).trigger('change');
	showMarca();
	showCategoria();
	showPartidas();
}
