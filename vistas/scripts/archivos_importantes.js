function init() {
	listar_registros();
	$("#formulariosubirarchivoimportante").on("submit", function (e) {
		formulariosubirarchivoimportante(e);
	});
	$("#formulariosubirdocumentoimportante").on("submit", function (e) {
		formulariosubirdocumentoimportante(e);
	});
}
function listar_registros() {
	$("#documentos").hide();
	$("#btnsubirdocumentoimportante").hide();
	$("#btncreararchivoimportante").show();
	$("#archivos_importantes").show();
	$("#btn_volver").hide();
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tblistadocumentos').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		dom: 'Bfrtip',
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
			url: '../controlador/archivos_importantes.php?op=listar_registros',
			type: "get",
			dataType: "json",
			data: {},
			error: function (e) {
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [[0, "asc"]],
		'initComplete': function (settings, json) {
			//tomamos el nombre de la dependencia del usuario para saber en que area esta en caso de que no tenga area o este vacia se mostrara un mensaje Sin Área.
			let dependencia_area = json.dependencia_usuarios;
			document.getElementById('area_usuario').textContent = (dependencia_area) ? dependencia_area : "Sin Área";
			//asignamos el id de la dependencia del usuario para agregarlo por medio de la dependencia.
			$("#id_dependencia_subir_documento").val(json.id_dependencias);
			$("#precarga").hide();
			scroll(0, 0);
		},
	});
}
function volver() {
	$("#documentos").hide();
	$("#archivos_importantes").show();
	$("#btnsubirdocumentoimportante").hide();
	$("#btn_volver").hide();
	$("#btncreararchivoimportante").show();
}
function mostrardocumentosimportantes(id_archivos_importante) {
	$("#id_dependencia_subir_archivo_importante").val(id_archivos_importante);
	$("#btnsubirdocumentoimportante").show();
	$("#btncreararchivoimportante").hide();
	$("#documentos").show();
	$("#archivos_importantes").hide();
	$("#btn_volver").show();
	$("#precarga").show();
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#mostrararchivosimportantes').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		dom: 'Bfrtip',
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
			url: '../controlador/archivos_importantes.php?op=mostrardocumentosimportantes',
			type: "post",
			data: {
				id_archivos_importante: id_archivos_importante
			},
			dataType: "json",
			error: function (e) {
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [[0, "asc"]],
		'initComplete': function (settings, json) {
			$("#precarga").hide();
			scroll(0, 0);
		},
	});
}
function creararchivoimportante() {
	$("#documento_texto").html("Crear Archivo Importante");
	$("#creararchivoimportante").modal("show");
	$("#id_dependencia_editar_subir_documento").val("");
	$("#entidad").val("");
	$("#id_dependencia_archivo_importante").val("");
	$("#fabricante").val("");
	$("#telefono").val("");
	$("#detalles").val("");
	$("#fecha_vencimiento").val("");
}
function subirdocumentoimportante() {
	$("#documento_texto").html("Subir Documento Importante");
	$("#mostrardocumentosimportantes").modal("show");
	$("#id_archivos_importantes_documentos").val("");
	$("#archivo_importante_nombre").val("");
	$("#agregar_documento_archivo").val("");
	$("#archivo_texto").html("Crear Archivo");
}
function formulariosubirarchivoimportante(e) {
	e.preventDefault();
	let formData = new FormData($("#formulariosubirarchivoimportante")[0]);
	$.ajax({
		url: "../controlador/archivos_importantes.php?op=formulariosubirarchivoimportante",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			$('#tblistadocumentos').DataTable().ajax.reload();
			$("#creararchivoimportante").modal("hide");
			let data = JSON.parse(datos);
			if (data[0][0] == 1) {
				alertify.success("Documento agregado");
			} else if (data[0][0] == 2) {
				alertify.error("No se pudo agregar");
			} else if (data[0][0] == 3) {
				alertify.success("Documento actualizado");
			} else if (data[0][0] == 4) {
				alertify.error("Documento no actualizado");
			} else {
				alertify.error("Error de formato");
			}
		},
	});
}
function formulariosubirdocumentoimportante(e) {
	e.preventDefault();
	let formData = new FormData($("#formulariosubirdocumentoimportante")[0]);
	$.ajax({
		url: "../controlador/archivos_importantes.php?op=subirdocumentosimportantes",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			$('#mostrararchivosimportantes').DataTable().ajax.reload();
			$("#mostrardocumentosimportantes").modal("hide");
			let data = JSON.parse(datos);
			if (data[0][0] == 1) {
				alertify.success("Documento agregado");
			} else if (data[0][0] == 2) {
				alertify.error("No se pudo agregar");
			} else if (data[0][0] == 3) {
				alertify.success("Documento actualizado");
			} else if (data[0][0] == 4) {
				alertify.error("Documento no actualizado");
			} else {
				alertify.error("Error de formato");
			}
		},
	});
}
// trae la informacion del documento seleccionado para posteriormente editarlo
function mostrar_documento_importante(id_archivos_importante) {
	$.post("../controlador/archivos_importantes.php?op=mostrar_documento_importante", { "id_archivos_importante": id_archivos_importante }, function (data) {
		data = JSON.parse(data);
		if (Object.keys(data).length > 0) {
			$("#mostrardocumentosimportantes").modal("show");
			$("#archivo_importante_nombre").val(data.archivo_importante_nombre);
			$("#id_archivos_importantes_documentos").val(data.id_archivos_importantes_documentos);
			$("#archivo_texto").html("Editar Archivo");
		}
	});
}
function mostrar_archivo_importante(id_archivos_importante) {
	$.post("../controlador/archivos_importantes.php?op=mostrar_documento", { "id_archivos_importante": id_archivos_importante }, function (data) {
		data = JSON.parse(data);
		if (Object.keys(data).length > 0) {
			$("#documento_texto").html("Editar Archivo Importante");
			$("#id_dependencia_archivo_importante").val(id_archivos_importante);
			$("#entidad").val(data.entidad);
			$("#fabricante").val(data.fabricante);
			$("#telefono").val(data.telefono);
			$("#fecha_vencimiento").val(data.fecha_vencimiento);
			$("#detalles").val(data.detalles);
			$("#creararchivoimportante").modal("show");
		}
	});
}
// elimina el documento seleccionado
function eliminar_documento(id_archivos_importante) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar el documento?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/archivos_importantes.php?op=eliminar_documento", { 'id_archivos_importante': id_archivos_importante }, function (e) {
				if (e !== 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Documento eliminada con éxito.",
						icon: "success"
					});
					$('#tblistadocumentos').DataTable().ajax.reload();
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Documento no se puede eliminar.",
						icon: "error"
					});
				}
			});
		} else if (
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
// elimina el documento seleccionado
function eliminar_documento_importante(id_archivos_importantes_documentos) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar el archivo?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/archivos_importantes.php?op=eliminar_documento_importantes", { 'id_archivos_importantes_documentos': id_archivos_importantes_documentos }, function (e) {
				if (e !== 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Archivo eliminada con éxito.",
						icon: "success"
					});
					$('#mostrararchivosimportantes').DataTable().ajax.reload();
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Archivo no se puede eliminar.",
						icon: "error"
					});
				}
			});
		} else if (
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