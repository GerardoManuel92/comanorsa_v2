function detectarErrorJquery(jqXHR, textStatus, errorThrown) {
	if (jqXHR.status === 0) {
		alert("Not connect: Verify Network.");
	} else if (jqXHR.status == 404) {
		alert("Requested page not found [404]");
	} else if (jqXHR.status == 500) {
		alert("Internal Server Error [500].");
	} else if (textStatus === "parsererror") {
		alert("Requested JSON parse failed.");
	} else if (textStatus === "timeout") {
		alert("Time out error.");
	} else if (textStatus === "abort") {
		alert("Ajax request aborted.");
	} else {
		alert("Uncaught Error: " + jqXHR.responseText);
	}
}

mostrarDepartamentos();

mostrarMenus();

mostrarSubmenus();

showUsuarios();

showDepa();

$("#btnedit").css("display", "none");
$("#btncancelar").css("display", "none");
$("#btncrear").css("display", "");

//Se deshabilita boton para editar departamento para evitar que cuando se seleccione el value 0 se abra el modal
$("#editDepa").prop("disabled", true);

var idx = 0;

var idEditar = 0;

var iddept = 0;

/*** FUNCION PARA MOSTRAR DEPARTAMENTOS EN EL SELECT  */
function mostrarDepartamentos() {
	$.ajax({
		type: "POST",
		dataType: "json",
		url: base_urlx + "AltaUsuarios/showDepartamentos/",
		cache: false,
		success: function (result) {
			if (result != null) {
				creaOption =
					'<option value="0" isabled selected hidden>Seleccionar...</option>';

				$.each(result, function (i, item) {
					data1 = item.id; //id
					data2 = item.nombre; //nombre

					creaOption =
						creaOption + '<option value="' + data1 + '">' + data2 + "</option>";
				});

				$("#departamento").html(creaOption);
				$("#buscar_departamento").html(creaOption);
			} else {
				$("#departamento").html("<option value='0'>Sin departamentos</option>");
				$("#buscar_departamento").html(
					"<option value='0'>Sin departamentos</option>"
				);
			}
		},
	}).fail(function (jqXHR, textStatus, errorThrown) {
		detectarErrorJquery(jqXHR, textStatus, errorThrown);
	});
}

/*** FUNCION PARA MOSTRAR NOMBRE DEL DEPARTAMENTOS DEL VALOR DEL SELECT AL ABRIR EL MODAL  */
function showDepa() {
	$("#departamento").on("change", function () {
		// Obtener el valor seleccionado del select
		var valorSeleccionado = $(this).val();

		iddept = valorSeleccionado;

		//Ya que se elije un departamento entonces se habilita el boton de edición
		$("#editDepa").prop("disabled", false);

		// Asignar el valor al input
		$("#iddept").html(iddept);

		showDepartamento(iddept);

		showSubmenusxDepa(iddept);
	});
}

/*** FUNCION PARA MOSTRAR MENUS EN EL SELECT  */
function mostrarMenus() {
	$.ajax({
		type: "POST",
		dataType: "json",
		url: base_urlx + "AltaUsuarios/showMenus/",
		cache: false,
		success: function (result) {
			if (result != null) {
				creaOption = '<option value="0" >Seleccionar...</option>';

				$.each(result, function (i, item) {
					data1 = item.id; //id
					data2 = item.nombre; //nombre

					creaOption =
						creaOption + '<option value="' + data1 + '">' + data2 + "</option>";
				});

				$("#menu_modal").html(creaOption);
				$("#menu_modal2").html(creaOption);
			} else {
				$("#menu_modal").html("<option value='0'>Sin menus</option>");
				$("#menu_modal2").html("<option value='0'>Sin menus</option>");
			}
		},
	}).fail(function (jqXHR, textStatus, errorThrown) {
		detectarErrorJquery(jqXHR, textStatus, errorThrown);
	});
}

/*** FUNCION PARA MOSTRAR SUBMENUS EN EL SELECT  */
function mostrarSubmenus() {
	$.ajax({
		type: "GET",
		dataType: "json",
		url: base_urlx + "AltaUsuarios/showSubmenus/",
		cache: false,
		data: { menux: $("#menu_modal").val(), menu2x: $("#menu_modal2").val() },
		success: function (result) {
			if (result != null) {
				creaOption = '<option value="0" >Seleccionar...</option>';

				$.each(result, function (i, item) {
					data1 = item.id; //id
					data2 = item.nombre; //nombre

					creaOption =
						creaOption + '<option value="' + data1 + '">' + data2 + "</option>";
				});

				$("#submenu_modal").html(creaOption);
				$("#submenu_modal2").html(creaOption);
			} else {
				$("#submenu_modal").html("<option value='0'>Sin menus</option>");
				$("#submenu_modal2").html("<option value='0'>Sin menus</option>");
			}
		},
	}).fail(function (jqXHR, textStatus, errorThrown) {
		detectarErrorJquery(jqXHR, textStatus, errorThrown);
	});
}

/*** FUNCION PARA REGISTRAR NUEVOS USUARIOS  */
function altaUsuario() {
	verificar = 0;

	if ($("#nombre").val() == "" || $("#nombre").val() == null) {
		//alert("Alerta, debes colocar nombre completo");

		Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Error!",
			text: "Debes colocar nombre completo",
			showConfirmButton: false,
			timer: 1500,
		});

		$("#nombre").focus();
	} else if ($("#usuario").val() == "" || $("#usuario").val() == null) {
		//alert("Alerta, favor de proporcionar un nombre de usuario");

		Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Error!",
			text: "Favor de proporcionar un nombre de usuario",
			showConfirmButton: false,
			timer: 1500,
		});

		$("#usuario").focus();
	} else if ($("#password").val() == "" || $("#password").val() == null) {
		//alert("Alerta, favor de proporcionar un password");
		Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Error!",
			text: "Favor de proporcionar un password",
			showConfirmButton: false,
			timer: 1500,
		});

		$("#password").focus();
	} else if (
		$("#departamento").val() == 0 ||
		$("#departamento").val() == null
	) {
		//alert("Alerta, debes seleccionar un departamento");

		Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Error!",
			text: "Debes seleccionar un departamento",
			showConfirmButton: false,
			timer: 1500,
		});
	} else {
		$.ajax({
			type: "POST",

			dataType: "json",

			url: base_urlx + "AltaUsuarios/altaUsuario/",

			data: {
				nombrex: $("#nombre").val(),
				correox: $("#correo").val(),
				telefonox: $("#telefono").val(),
				usuariox: $("#usuario").val(),
				passwordx: $("#password").val(),
				departamentox: $("#departamento").val(),
			},

			cache: false,

			success: function (result) {
				if (result > 0) {
					//alert("Usuario creado correctamente");
					Swal.fire({
						position: "top-end",
						icon: "success",
						title: "Usuario creado correctamente",
						showConfirmButton: false,
						timer: 2000,
					}).then(() => {
						location.reload(); // Recargar la página
					});
					location.reload();
				} else if (result == 0) {
					Swal.fire({
						position: "top-end",
						icon: "error",
						title: "error",
						text: "Debes seleccionar un departamento",
						showConfirmButton: false,
						timer: 1500,
					}).then(() => {
						location.reload();
					});
				} else {
					/* alert(
						"Error, favor de intentarlo nuevamente y de persistir el error comuniquese con el administrador"
					); */
					Swal.fire({
						position: "top-end",
						icon: "error",
						title:
							"Favor de intentarlo nuevamente y de persistir el error comuniquese con el administrador",
						showConfirmButton: false,
						timer: 1500,
					}).then(() => {
						location.reload();
					});
				}
			},
		}).fail(function (jqXHR, textStatus, errorThrown) {
			detectarErrorJquery(jqXHR, textStatus, errorThrown);
		});
	}
}

/*** FUNCION PARA MOSTRAR DATOS DEL USUARIO EN EL FORMULARIO PARA SER EDITADOS  */
function editarUser(iduseredit) {
	//***** traer los datos del usuario

	$.ajax({
		type: "POST",
		dataType: "json",
		url: base_urlx + "AltaUsuarios/editarUser/",
		data: { idedit: iduseredit },
		cache: false,
		success: function (result) {
			idEditar = iduseredit;
			$("#nombre").val(result.nombre);
			$("#departamento").val(result.iddepartamento);
			$("#telefono").val(result.telefono);
			$("#correo").val(result.correo);
			$("#usuario").val(result.usuario);
			$("#password").val(result.pass);

			$("#btnedit").css("display", "");
			$("#btncrear").css("display", "none");
			$("#btncancelar").css("display", "");

			//$("#btnusuarios").html('<button class="btn btn-warning" id="btnedit" tabindex="9" style="color:black;" ><i id="cargando3" class="fa fa-edit"></i> Editar Usuario</button><button type="button" class="btn btn-danger" id="btncerrar" tabindex="10"><i class="mdi mdi-close-box"> </i></button>');

			$("#nombre").focus();
		},
	}).fail(function (jqXHR, textStatus, errorThrown) {
		detectarErrorJquery(jqXHR, textStatus, errorThrown);
	});
}

/*** FUNCION PARA MODIFICAR DATOS NUEVOS DEL USUARIO  */
function modificarUsuario() {
	verificar = 0;

	if ($("#nombre").val() == "" || $("#nombre").val() == null) {
		//alert("Alerta, debes colocar nombre completo");
		Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Debes colocar nombre completo",
			showConfirmButton: false,
			timer: 1500,
		});

		$("#nombre").focus();
	} else if ($("#usuario").val() == "" || $("#usuario").val() == null) {
		//alert("Alerta, favor de proporcionar un nombre de usuario");
		Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Favor de proporcionar un nombre de usuario",
			showConfirmButton: false,
			timer: 1500,
		});

		$("#usuario").focus();
	} else if ($("#password").val() == "" || $("#password").val() == null) {
		//alert("Alerta, favor de proporcionar un password");
		Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Favor de proporcionar un password",
			showConfirmButton: false,
			timer: 1500,
		});

		$("#password").focus();
	} else if (
		$("#departamento").val() == 0 ||
		$("#departamento").val() == null
	) {
		//alert("Alerta, debes seleccionar un departamento");
		Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Debes seleccionar un departamento",
			showConfirmButton: false,
			timer: 1500,
		});
	} else {
		$.ajax({
			type: "POST",

			dataType: "json",

			url: base_urlx + "AltaUsuarios/actUsuario/",

			data: {
				nombrex: $("#nombre").val(),
				correox: $("#correo").val(),
				telefonox: $("#telefono").val(),
				usuariox: $("#usuario").val(),
				passwordx: $("#password").val(),
				departamentox: $("#departamento").val(),
				iduserx: idEditar,
			},

			cache: false,

			success: function (result) {
				if (result) {
					Swal.fire({
						title: "Alerta",
						text: "¿Estás seguro que deseas modificar los datos?",
						icon: "warning",
						showCancelButton: true,
						confirmButtonColor: "#3085d6",
						cancelButtonColor: "#d33",
						confirmButtonText: "Sí, cerrar sesión",
						cancelButtonText: "Cancelar",
					}).then((result) => {
						if (result.isConfirmed) {
							Swal.fire({
								position: "top-end",
								icon: "success",
								title: "Se han modificado los datos del usuario",
								showConfirmButton: false,
								timer: 2000,
							}).then(() => {
								location.reload(); // Recargar la página
							});
						}
					});
				} else {
					/* alert(
						"Error, favor de intentarlo nuevamente y de persistir el error comuniquese con el administrador"
					); */
					Swal.fire({
						position: "top-end",
						icon: "error",
						title: "Error",
						text: "Favor de intentarlo nuevamente y de persistir el error comuniquese con el administrador",
						showConfirmButton: false,
						timer: 1500,
					});
				}
			},
		}).fail(function (jqXHR, textStatus, errorThrown) {
			detectarErrorJquery(jqXHR, textStatus, errorThrown);
		});
	}
}

/*** FUNCION PARA CAMBIAR ESTATUS DEL USUARIO ELIMINADO  */
function eliminarUser(iduserbajax, estatus_actual) {
	// Preguntar al usuario si realmente desea eliminar

	Swal.fire({
		title: "¿Deseas eliminar este usuario?",
		text: "Esta acción no se podrá revertir",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Sí, eliminar",
		cancelButtonText: "Cancelar",
	}).then((result) => {
		if (result.isConfirmed) {
			if (iduserbajax > 0) {
				$.ajax({
					type: "POST",
					dataType: "json",
					url: base_urlx + "AltaUsuarios/eliminaUser/",
					data: { iduser: iduserbajax, estatus: estatus_actual },
					cache: false,
					success: function (result2) {
						if (result2) {
							//alert("Usuario eliminado");
							Swal.fire({
								position: "top-end",
								icon: "success",
								title: "Usuario eliminado correctamente",
								showConfirmButton: false,
								timer: 2000,
							}).then(() => {
								location.reload(); // Recargar la página
							});
						} else {
							//alert("Error, favor de intentarlo nuevamente");
							Swal.fire({
								position: "top-end",
								icon: "error",
								title: "No se pudo eliminar el usuario",
								showConfirmButton: false,
								timer: 1500,
							});
						}
					},
				}).fail(function (jqXHR, textStatus, errorThrown) {
					detectarErrorJquery(jqXHR, textStatus, errorThrown);
				});
			} else {
				//alert("Error, favor de intentarlo nuevamente");
				Swal.fire({
					position: "top-end",
					icon: "error",
					title: "Error",
					text: "Favor de intentarlo nuevamente y de persistir el error comuniquese con el administrador",
					showConfirmButton: false,
					timer: 1500,
				});
			}
		}
	});
}

/*** FUNCION PARA MOSTRAR NOMBRES DE MENUS Y SUBMENUS SELECCIONADOS QUE SE AGREGAN A LA TABLA  */
$(document).ready(function () {
	var registros = []; // Array para almacenar los registros
	var submenu;
	var submenux;

	// Evento de clic en el botón "Guardar"
	$("#modalDepartamentos").on("click", ".btn-info", function () {
		//var departamento = $("#txtdepartamento").val();
		var menu = $("#menu_modal").val();
		submenu = $("#submenu_modal").val();

		var texto_menu = "";
		var texto_submenu = "";

		verificar = 0;

		if (menu == 0 || menu == null) {
			verificar = 1;
			//alert("Antes debe seleccionar un menu valido");
			Swal.fire({
				position: "top-end",
				icon: "error",
				title: "Error",
				text: "Antes debe seleccionar un menu valido",
				showConfirmButton: false,
				timer: 1500,
			});
		}

		if (
			(submenu == 0 && verificar == 0) ||
			(submenu == null && verificar == 0)
		) {
			verificar = 1;
			//alert("Antes debe seleccionar un submenu valido");
			Swal.fire({
				position: "top-end",
				icon: "error",
				title: "Error",
				text: "Antes debe seleccionar un submenu valido",
				showConfirmButton: false,
				timer: 1500,
			});
		}

		texto_menu = $("#menu_modal option:selected").text();

		texto_submenu = $("#submenu_modal option:selected").text();

		//console.log($('#iduser').text())

		if (verificar == 0) {
			$.ajax({
				type: "POST",

				dataType: "json",

				url: base_urlx + "AltaUsuarios/anadirMenus/",

				data: {
					//menux: $("#nombre").val(),
					submenux: submenu,
					idusuariox: $("#iduser").text(),
				},

				cache: false,

				success: function (result) {
					if (result > 0) {
						//alert("Submenu registrado correctamente");
						Swal.fire({
							position: "top-end",
							icon: "success",
							title: "Submenu registrado correctamente",
							showConfirmButton: false,
							timer: 2000,
						}).then(() => {
							showtempSubmenus();
						});

						// Mover la declaración y asignación de nuevoRegistro aquí
					} else {
						//alert("Alerta, este submenu ya se ha agregado");
						Swal.fire({
							position: "top-end",
							icon: "error",
							title: "Error",
							text: "No se puede agregar este submenu mas de una vez",
							showConfirmButton: false,
							timer: 1500,
						});
					}
				},
			}).fail(function (jqXHR, textStatus, errorThrown) {
				detectarErrorJquery(jqXHR, textStatus, errorThrown);
			});
		}
	});

	/* // Evento de clic en el botón "Eliminar" de la tabla
	$("#my-table").on("click", ".btn-danger", function () {
		var fila = $(this).closest("tr");
		
		fila.remove();
	}); */

	$("#modalDepartamentos").on("click", ".btn-success", function () {
		altaDepartamento(submenu);
	});
});

/*** FUNCION PARA GUARDAR SUBMENUS  A LA TABLA MENUS_DEPARTAMENTO QUE SE ENCUENTRAN DENTRO DE LA TABLA */
function altaDepartamento(idsubmenu) {
	verificar = 0;

	if (
		$("#txtdepartamento").val() == "" ||
		$("#txtdepartamento").val() == null
	) {
		//alert("Alerta, debes colocar un nombre de departamento");
		Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Error",
			text: "Antes debe colocar un nombre de departamento",
			showConfirmButton: false,
			timer: 1500,
		});

		$("#txtdepartamento").focus();
	} else {
		$.ajax({
			type: "POST",

			dataType: "json",

			url: base_urlx + "AltaUsuarios/altaDepartamento/",

			data: {
				departamentox: $("#txtdepartamento").val(),
				idUser : $("#iduser").text(),
			},

			cache: false,

			success: function (result) {
				if (result > 0) {
					Swal.fire({
						position: "top-end",
						icon: "success",
						title: "Se ha creado el nuevo departamento",
						showConfirmButton: false,
						timer: 1500,
					}).then(() => {
						location.reload();
					});
				} else if (result == 0) {
					//alert("Alerta, el departamento ya se encuentra registrado");
					Swal.fire({
						position: "top-end",
						icon: "error",
						title: "Error",
						text: "El departamento ya se encuentra registrado",
						showConfirmButton: false,
						timer: 1500,
					});
				} else {
					alert(
						"Error, favor de intentarlo nuevamente y de persistir el error comuniquese con el administrador"
					);
				}
			},
		}).fail(function (jqXHR, textStatus, errorThrown) {
			detectarErrorJquery(jqXHR, textStatus, errorThrown);
		});
	}
}

/*** FUNCION PARA CONVERTIR A MUSYUSCULA LO QUE SE INGRESE EN EL INPUT DEPARTAMENTO  */
function convertirAMayusculas() {
	var input = document.getElementById("txtdepartamento");
	input.value = input.value.toUpperCase();
}

/*** FUNCION PARA MOSTRAR USUARIOS REGISTRADOS MEDIANTE CARD TARGET*/
function showUsuarios() {
	$.ajax({
		type: "POST",
		dataType: "json",
		url: base_urlx + "AltaUsuarios/showUsuarios/",
		cache: false,
		data: {
			buscarx: $("#busqueda").val(),
			dept: $("#buscar_departamento").val(),
		},
		success: function (result) {
			if (result != null) {
				var contarDivs = 0;
				var div = "";

				bordercolor = "primary border";
				txtcolor = "text-primary";

				$.each(result, function (i, item) {
					data1 = item.id; //id
					data2 = item.nombre; //nombre
					data3 = item.departamento; //departamento
					data4 = item.correo; //correo
					data5 = item.telefono; //telefono
					data6 = item.estatus; //estatus

					// Crea un conjunto de divs para cada elemento en el bucle
					div +=
						'<div class="col-md-12 col-lg-12"><div class="card border-' +
						bordercolor +
						'"><div class="card-header border-primary"><h5 class="card-title ' +
						txtcolor +
						'"><img class="avatar-xs rounded-circle" src="' +
						base_urlx +
						'comanorsa/usuario.png" alt="" title="">' +
						item.nombre +
						' - <strong style="color:#2D2D2D;">' +
						item.departamento +
						'</strong></h5></div><div class="card-body" ><div class="row data-repeater-item" style="color: black;line-height:8px;" ><div class="col-md-8 col-lg-8"><p>Telefono: ' +
						item.telefono +
						"</p><p>Correo: " +
						item.correo +
						'</p></div><div class="col-md-4 col-lg-4 float-right"><button type="button" class="btn btn-primary btn-rounded waves-effect waves-light" onclick="verMenus(' +
						item.id +
						')" data-toggle="modal" data-target="#modalMenus"><i class="fa fa-eye" aria-hidden="true"></i> Ver menus</button><button type="button" class="btn btn-warning btn-rounded waves-effect waves-light" onclick="editarUser(' +
						item.id +
						')" style="color:black;"><i class="fa fa-pencil"></i> Editar</button><button type="button" class="btn btn-danger btn-rounded waves-effect waves-light" onclick="eliminarUser(' +
						item.id +
						" ," +
						item.estatus +
						')" style="color:white;"><i class="fa fa-trash"></i> Eliminar</button></div></div></div></div></div>';

					contarDivs++;
				});

				$("#totalDivs").html(contarDivs);

				$("#divUsuarios").html(div);
			} else {
				$("#divUsuarios").html("<p>No se encontraron registros</p>");
				$("#totalDivs").html("0");
			}
		},
	}).fail(function (jqXHR, textStatus, errorThrown) {
		detectarErrorJquery(jqXHR, textStatus, errorThrown);
	});
}

/*** FUNCION PARA MOSTRAR LOS MENUS QUE TIENE DISPONIBLES EL USUARIO ACORDE A SU DEPARTAMENTO EN UNA VENTANA MODAL  */
function verMenus(idcliex) {
	$("#idUser").html(idcliex);

	$.ajax({
		type: "GET",
		dataType: "json",
		url: base_urlx + "AltaUsuarios/showMenusxUsuario/",
		data: { clientex: idcliex },
		cache: false,
		success: function (result) {
			if (result != null) {
				inicioLista = "<ol>";
				cuerpoLista = "";
				finLista = "</ol>";

				$.each(result, function (i, item) {
					data1 = item.menu; //id
					data2 = item.submenu; //nombre
					data3 = item.usuario; //usuario

					cuerpoLista += "<li>" + data1 + " - " + data2 + "</li>";
				});

				$("#nombreUser").html(" - " + data3);

				$("#divLista").html(inicioLista + cuerpoLista + finLista);
			} else {
				$("#divLista").html("<strong> No hay datos que mostrar </strong>");
			}
		},
	}).fail(function (jqXHR, textStatus, errorThrown) {
		detectarErrorJquery(jqXHR, textStatus, errorThrown);
	});
}

/*** FUNCION PARA MOSTRAR NOMBRE DE DEPARTAMENTO CUYO ID ESTA OCULTO EN UNA VENTANA MODAL  */
function showDepartamento(idepx) {
	$.ajax({
		type: "GET",
		dataType: "json",
		url: base_urlx + "AltaUsuarios/showDepa/",
		cache: false,
		data: { depax: idepx },
		success: function (result) {
			if (result != null) {
				//creaOption = '<option value="0" >Seleccionar...</option>';

				$.each(result, function (i, item) {
					data1 = item.nombre; //id

					//creaOption = creaOption + '<option value="' + data1 + '">' + data2 + '</option>';
				});

				$("#nombre_depax").val(data1);

				/* $("#submenu_modal").html(creaOption);
				$("#submenu_modal2").html(creaOption);
 */
			} else {
				/* $("#submenu_modal").html("<option value='0'>Sin menus</option>");
				$("#submenu_modal2").html("<option value='0'>Sin menus</option>"); */
			}
		},
	}).fail(function (jqXHR, textStatus, errorThrown) {
		detectarErrorJquery(jqXHR, textStatus, errorThrown);
	});
}

/*** FUNCION PARA MOSTRAR MEDIANTE TABLA LOS MENUS Y SUBMENUS QUE CORRESPONDEN A X DEPARTAMENTO  */
function showSubmenusxDepa(idepx) {
	$.ajax({
		type: "GET",
		dataType: "json",
		url: base_urlx + "AltaUsuarios/showSubmenusxDepa/",
		cache: false,
		data: { depax: idepx },
		success: function (result) {
			if (result != null) {
				var tabla = $("#submenusTable tbody");

				tabla.empty(); // Limpiar la tabla antes de agregar nuevos datos

				$.each(result, function (i, item) {
					data1 = item.id; //id submenu
					data2 = item.departamento; //nombre
					data3 = item.menu; //menu
					data4 = item.submenu; //submenu
					data5 = item.iddept; //id departamento

					var fila =
						"<tr>" +
						'<td style="text-align:center; font-weight:bold;"><p hidden>' +
						data1 +
						"</p>" +
						'<button type="button" class="btn btn-danger btn-rounded waves-effect waves-light" onclick="eliminarSubmenu(' +
						data1 +
						"," +
						data5 +
						')" style="color:white;"><i class="fa fa-trash"></i> Eliminar</button></td>' +
						'<td style="text-align:center; font-weight:bold;">' +
						data2 +
						"</td>" +
						'<td style="text-align:center; font-weight:bold;">' +
						data3 +
						"</td>" +
						'<td style="text-align:center; font-weight:bold;">' +
						data4 +
						"</td>" +
						"</tr>";
					tabla.append(fila);
				});
			} else {
			}
		},
	}).fail(function (jqXHR, textStatus, errorThrown) {
		detectarErrorJquery(jqXHR, textStatus, errorThrown);
	});
}

/*** FUNCION PARA CAMBIAR ESTATUS A 1 SI SE ELIMINA UN SUBMENU  */
function eliminarSubmenu(idsubm, deptx) {
	// Preguntar al usuario si realmente desea eliminar
	var confirmacion = window.confirm(
		"¿Seguro que deseas eliminar este submenu?"
	);

	if (confirmacion) {
		// Continuar con la eliminación
		if (idsubm > 0) {
			$.ajax({
				type: "POST",
				dataType: "json",
				url: base_urlx + "AltaUsuarios/eliminaSubmenu/",
				data: { subx: idsubm, ideptx: deptx },
				cache: false,
				success: function (result) {
					if (result) {
						alert("Submenu eliminado");

						// Recargar solo la parte de la modal que contiene la tabla de submenús
						$("#modalSubmenus").on("hidden.bs.modal", function () {
							$("#modalSubmenus .modal-body").find("#submenusTable").html("");
						});
						showSubmenusxDepa(deptx);
					} else {
						alert("Error, favor de intentarlo nuevamente");
					}
				},
			}).fail(function (jqXHR, textStatus, errorThrown) {
				detectarErrorJquery(jqXHR, textStatus, errorThrown);
			});
		} else {
			alert("Error, favor de intentarlo nuevamente");
		}
	} else {
		// Usuario canceló la eliminación
		alert("Eliminación cancelada");
	}
}

/*** FUNCION PARA QUITAR SUBMENUS DE LA TABLA DE ALTA DE DEPARTAMENTOS */
function retirarId(idx) {
	if (idx > 0) {
		$.ajax({
			type: "POST",
			dataType: "json",
			url: base_urlx + "AltaUsuarios/retiraSubmenu/",
			data: { idsubx: idx },
			cache: false,
			success: function (result) {
				if (result > 0) {
					alert("Submenu eliminado");

					// Recargar solo la parte de la modal que contiene la tabla de submenús
					$("#my-table").on("hidden.bs.modal", function () {
						$("#my-table .modal-body").find("#my-table").html("");
					});
					// Recargar la tabla después de eliminar el registro
					showtempSubmenus();
				} else {
					alert("Error, favor de intentarlo nuevamente");
				}
			},
		}).fail(function (jqXHR, textStatus, errorThrown) {
			detectarErrorJquery(jqXHR, textStatus, errorThrown);
		});
	}
}

function showtempSubmenus() {
	$.ajax({
		type: "GET",
		dataType: "json",
		url: base_urlx + "AltaUsuarios/mostrartemporalMenus/",
		cache: false,
		data: { userx: $("#iduser").text() },
		success: function (result) {
			if (result != null) {
				var tabla = $("#my-table tbody");

				tabla.empty(); // Limpiar la tabla antes de agregar nuevos datos

				$.each(result, function (i, item) {
					data1 = item.id; //id submenu
					data2 = item.menu; //nombre
					data3 = item.submenu; //menu

					var fila =
						"<tr>" +
						'<td style="text-align:center; font-weight:bold;"><p hidden>' +
						data1 +
						"</p>" +
						'<button type="button" class="btn btn-danger btn-rounded waves-effect waves-light" onclick="retirarId(' +
						data1 +
						')" style="color:white;"><i class="fa fa-trash"></i></button></td>' +
						'<td style="text-align:center; font-weight:bold;">' +
						data2 +
						"</td>" +
						'<td style="text-align:center; font-weight:bold;">' +
						data3 +
						"</td>" +
						"</tr>";
					tabla.append(fila);
				});
			} else {
			}
		},
	}).fail(function (jqXHR, textStatus, errorThrown) {
		detectarErrorJquery(jqXHR, textStatus, errorThrown);
	});
}

/*** FUNCION PARA AGREGAR UN NUEVO SUBMENU A UN DEPARTAMENTO  */
function AgregaNvoSubmenu() {
	// Validar si hay campos vacíos
	verificar = 0;

	var iddepartamentox = 0;

	if ($("#nombre_depax").val() == "" || $("#nombre_depax").val() == null) {
		console.error("Alerta, no hay un nombre de departamento válido");
		alert("Alerta, no hay un nombre de departamento válido");
		$("#nombre_depax").focus();
	} else if ($("#menu_modal2").val() == 0 || $("#menu_modal2").val() == null) {
		console.error("Alerta, debes seleccionar un menú válido");
		alert("Alerta, debes seleccionar un menú válido");
	} else if (
		$("#submenu_modal2").val() == 0 ||
		$("#submenu_modal2").val() == null
	) {
		console.error("Alerta, debes seleccionar un submenú válido");
		alert("Alerta, debes seleccionar un submenú válido");
	} else {
		$.ajax({
			type: "POST",
			dataType: "json",
			url: base_urlx + "AltaUsuarios/AgregaNvoSubmenu/",
			data: {
				iddepartamentox: $("#iddept").text(),
				idsubmenux: $("#submenu_modal2").val(),
			},
			cache: false,
			success: function (result) {
				if (result > 0) {
					alert("Submenú agregado correctamente");

					$("#menu_modal2").val(0);
					$("#submenu_modal2").val(0);

					// Recargar solo la parte de la modal que contiene la tabla de submenús
					$("#modalSubmenus").on("hidden.bs.modal", function () {
						$("#modalSubmenus .modal-body").find("#submenusTable").html("");
					});
					showSubmenusxDepa($("#iddept").text());
				} else if (result == 0) {
					alert(
						"Alerta, el submenú ya se encuentra registrado en este departamento"
					);

					// Recargar solo la parte de la modal que contiene la tabla de submenús
					$("#modalSubmenus").on("hidden.bs.modal", function () {
						$("#modalSubmenus .modal-body").find("#submenusTable").html("");
					});
					showSubmenusxDepa($("#iddept").text());
				} else {
					console.error("Error al agregar submenú. Resultado:", result);
					alert(
						"Error, favor de intentarlo nuevamente y de persistir el error comuníquese con el administrador"
					);
				}
			},
		}).fail(function (jqXHR, textStatus, errorThrown) {
			console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
			detectarErrorJquery(jqXHR, textStatus, errorThrown);
		});
	}
}

/*** FUNCION PARA LIMPIAR CAMPOS  */
function limpiar() {
	$("#btnedit").css("display", "none");
	$("#btncancelar").css("display", "none");
	$("#btncrear").css("display", "");

	$("#nombre").val("");
	$("#correo").val("");
	$("#telefono").val("");
	$("#usuario").val("");
	$("#password").val("");
	$("#departamento").val(0);
}

/*** FUNCION PARA LIMPIAR CAMPOS DE FILTRO DE BUSQUEDA DE USUARIOS */
function limpiarFiltros() {
	$("#busqueda").val("");
	$("#buscar_departamento").val(0);
	showUsuarios();
}

/*** FUNCION PARA CERRAR SESION DE USUARIO  */
function cerrarSesion() {
	var x = confirm("¿Realmente deseas cerrar la sesión?");

	if (x == true) {
		window.location.href = base_urlx + "Login/CerrarSesion/";
	}
}
