var tabla, tabla_funcionarios;
//Función que se ejecuta al inicio
function init() {
	listar();
	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
	$("#formulario_editar_consecutivo").on("submit", function (e) {
		editar_formulario(e);
	});
}
//Función limpiar
function limpiar() {
	$("#id_permiso").val("");
	$("#permiso_nombre").val("");
	$("#orden").val("");
	$("#menu").val("");
	$("#permiso_nombre_original").val("");
}
//Función cancelarform
function cancelarform() {
	$("#mostrar_agregar_permiso").hide();
	$("#tllistado").show();
}
function listar() {
	$.post("../controlador/permiso.php?op=listar", {}, function (data, status) {
		$("#tbllistado").hide();
		$("#tllistado").show();
		data = JSON.parse(data);
		$("#tllistado").html("");
		$("#tllistado").append(data["0"]["0"]);
		$("#precarga").hide();
	});
}
function guardaryeditar(e) {
	$("#btnGuardar").prop("disabled", true);
	// e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../controlador/permiso.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			alertify.success(datos);
			$("#formularioregistros").hide();
			listar();
		}
	});
	limpiar();
}
//Funcion para traer el numero del permiso donde se va a crear
function agregar_permiso(orden) {
	$.post("../controlador/permiso.php?op=agregar_permiso", { orden: orden }, function (data) {
		data = JSON.parse(data);
		$("#tllistado").hide();
		$("#mostrar_agregar_permiso").show();
		$("#mostrar_agregar_permiso").html(data);
	});
}
//Función mostrar formulario
function mostrarform(flag) {
	if (flag) {
		$("#mostrar_agregar_permiso").show();
	}
	else {
		$("#mostrar_agregar_permiso").hide();
	}
}
//Funcion para traer el numero del permiso donde se va a crear
function editar_formulario_permiso(id_permiso) {
	$.post("../controlador/permiso.php?op=editar_formulario_permiso", { id_permiso: id_permiso }, function (data) {
		data = JSON.parse(data);
		$("#editar_permiso").show();
		$("#mostrar_agregar_permiso").show();
		$("#formulario_editado").show();
		$("#editar_formulario").show();
		$("#mostrar_agregar_permiso").html(data);
		$("#tllistado").hide();
	});
}
function editar_formulario(e) {
	// e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulario_editar_consecutivo")[0]);
	$.ajax({
		url: "../controlador/permiso.php?op=editar_formulario",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			alertify.success(datos);
		}
	});
	limpiar();
}
function mostrar_permiso_general(id_permiso) {
	$("#id_permiso_insertar").val(id_permiso);
	$("#myModalActivarDesactivarPermiso").modal("show");
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#mostrar_funcionarios_permisos').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Print'
			},
		],
		"ajax": {
			url: '../controlador/permiso.php?op=mostrar_permiso_general&id_permiso=' + id_permiso, type: "get", dataType: "json",
			error: function (e) {
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		// "order": [[0, "desc"]],//Ordenar (columna,orden)
		"order": [[2, "asc"]],//Ordenar (columna,orden) en orden alfabético ascendente por la tercera columna
		'initComplete': function (settings, json) {
			$("#precarga").hide();
			// scroll(0, 0);
		},
	});
}
// desactiva los funcionarios para los botones de submenu 
function desactivar_permiso(id_permiso, id_usuario) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar el permiso.?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/permiso.php?op=desactivar_permiso", { 'id_permiso': id_permiso, 'id_usuario': id_usuario }, function (e) {
				if (e == 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Permiso eliminado con éxito.",
						icon: "success"
					});
					$('#mostrar_funcionarios_permisos').DataTable().ajax.reload();
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Permiso no se puede eliminar.",
						icon: "error"
					});
				}
			});
		} else if (
			/* Read more about handling dismissals below */
			result.dismiss === Swal.DismissReason.cancel
		) {
			swalWithBootstrapButtons.fire({
				title: "Cancelado",
				text: "Tu proceso está a salvo :)",
				icon: "error"
			});
		}
	});
}
// activa los funcionarios para los botones de submenu 
function activar_permiso(id_permiso, id_usuario) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar el permiso?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/permiso.php?op=activar_permiso", { 'id_permiso': id_permiso, 'id_usuario': id_usuario }, function (e) {
				if (e == 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Permiso agregado con éxito.",
						icon: "success"
					});
					$('#mostrar_funcionarios_permisos').DataTable().ajax.reload();
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Permiso no se puede agregar.",
						icon: "error"
					});
				}
			});
		} else if (
			/* Read more about handling dismissals below */
			result.dismiss === Swal.DismissReason.cancel
		) {
			swalWithBootstrapButtons.fire({
				title: "Cancelado",
				text: "Tu proceso está a salvo :)",
				icon: "error"
			});
		}
	});
}
// muestra la tabla para los funcionarios del boton menu 0
function agregarmenufuncionario(orden) {
	$("#orden_insertar").val(orden);
	$("#myModalAgregarMenuFuncionario").modal("show");
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#mostrar_menu_funcionarios_permisos').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Print'
			},
		],
		"ajax": {
			url: '../controlador/permiso.php?op=agregarmenufuncionario&orden=' + orden, type: "get", dataType: "json",
			error: function (e) {
				console.log(e);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		// "order": [[0, "desc"]],//Ordenar (columna,orden)
		"order": [[2, "asc"]],//Ordenar (columna,orden) en orden alfabético ascendente por la tercera columna
		'initComplete': function (settings, json) {
			console.log(settings, json);
			$("#precarga").hide();
			// scroll(0, 0);
		},
	});
}
// desactiva los funcionarios para el boton menu
function desactivar_permiso_menu(orden, id_usuario) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar el permiso.?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/permiso.php?op=desactivar_permiso_menu", { 'orden': orden, 'id_usuario': id_usuario }, function (e) {
				if (e == 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Permiso eliminado con éxito.",
						icon: "success"
					});
					$('#mostrar_menu_funcionarios_permisos').DataTable().ajax.reload();
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Permiso no se puede eliminar.",
						icon: "error"
					});
				}
			});
		} else if (
			/* Read more about handling dismissals below */
			result.dismiss === Swal.DismissReason.cancel
		) {
			swalWithBootstrapButtons.fire({
				title: "Cancelado",
				text: "Tu proceso está a salvo :)",
				icon: "error"
			});
		}
	});
}
// activa los funcionarios para el boton menu
function activar_permiso_menu(orden, id_usuario) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar el permiso?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/permiso.php?op=activar_permiso_menu", { 'orden': orden, 'id_usuario': id_usuario }, function (e) {
				if (e == 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Permiso agregado con éxito.",
						icon: "success"
					});
					$('#mostrar_menu_funcionarios_permisos').DataTable().ajax.reload();
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Permiso no se puede agregar.",
						icon: "error"
					});
				}
			});
		} else if (
			/* Read more about handling dismissals below */
			result.dismiss === Swal.DismissReason.cancel
		) {
			swalWithBootstrapButtons.fire({
				title: "Cancelado",
				text: "Tu proceso está a salvo :)",
				icon: "error"
			});
		}
	});
}
init();