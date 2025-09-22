var tabla;
//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	listarTabla();
	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
}
function listarDependencias() {
	//Cargamos los items de los selects
	$.post("../controlador/ayudadependencia.php?op=selectDependencia", function (r) {
		$("#id_remite_a").html(r);
		$('#id_remite_a').selectpicker('refresh');
	});
}
function activarformulario() {
	$("#respuesta_directa").on("submit", function (e1) {
		guardarrespuestadirecta(e1);
	});
	$("#redireccionar").on("submit", function (e2) {
		guardarrespuestaredireccionar(e2);
	});
}
//Función limpiar
function limpiar() {
	$("#id_ayuda").val("");
	$("#asunto").val("");
	$("#mensaje").val("");
}
//Función mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
	}
	else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}
//Función cancelarform
function cancelarform() {
	limpiar();
	mostrarform(false);
}
//Función Listar
function verAyuda(id_ayuda) {
	$.post("../controlador/ayudadependencia.php?op=verAyuda", { id_ayuda: id_ayuda }, function (data, status) {
		// console.log(data);
		data = JSON.parse(data);
		$("#myModal").modal("show");
		$("#historial").html("");
		$('#historial').append(data["0"]["0"]);
		listarDependencias();
		activarformulario();
	});
}
//Función Listar
function verAyudaTerminado(id_ayuda) {
	$.post("../controlador/ayudadependencia.php?op=verAyudaTerminado", { id_ayuda: id_ayuda }, function (data, status) {
		data = JSON.parse(data);
		$("#myModalTerminado").modal("show");
		$("#historialTerminado").html("");
		$('#historialTerminado').append(data["0"]["0"]);
	});
}
function listarTabla() {
	// Obtener los datos del usuario para la impresión del DataTable
	$.post("../controlador/ayudadependencia.php?op=datosDataTablePrint", function (res) {
		res = JSON.parse(res);
		var nombre_usuario = res.nombre;
		var dependencia = res.dependencia;
		// Obtener la fecha actual de la impresión
		var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
		var diasSemana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
		var f = new Date();
		var fecha_hoy = `${diasSemana[f.getDay()]}, ${f.getDate()} de ${meses[f.getMonth()]} de ${f.getFullYear()}`;
		// Configuración de la tabla
		var tabla = $('#tbllistado').dataTable({
			"aProcessing": true, // Activamos el procesamiento del datatables
			"aServerSide": true, // Paginación y filtrado realizados por el servidor
			"stateSave": true,
			"dom": 'Bfrtip', // Definimos los elementos del control de tabla
			"buttons": [
				{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel" style="color: green"></i>',
					titleAttr: 'Excel'
				},
				{
					extend: 'print',
					text: '<i class="fas fa-print" style="color: #ff9900"></i>',
					messageTop: `<div style="width:50%;float:left"><b>Usuario:</b> ${nombre_usuario} <br><b>Dependencia:</b> ${dependencia} <br><b>Fecha Reporte:</b> ${fecha_hoy} </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>`,
					title: 'Contáctanos',
					titleAttr: 'Contáctanos'
				}
			],
			"ajax": {
				url: '../controlador/ayudadependencia.php?op=listarTabla',
				type: "get",
				dataType: "json",
				error: function (e) {
					// console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 10, // Paginación
			"order": [[4, "desc"]], // Ordenar (columna, orden)
			"columnDefs": [
				{ "width": "140px", "targets": 0 }
			],
			'initComplete': function (settings, json) {
				$("#precarga").hide();
				scroll(0, 0);
				$(".tooltips").tooltip();
			}
		});
	});
}
function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../controlador/ayudadependencia.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			// console.log(datos);
			alertify.success(datos);
			mostrarform(false);
			listarTabla();
		}
	});
	limpiar();
}
function guardarrespuestadirecta(e1) {
	e1.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#respuesta_directa")[0]);
	$.ajax({
		url: "../controlador/ayudadependencia.php?op=guardarrespuesta",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			// console.log(datos);
			alertify.success(datos);
			mostrarform(false);
			$("#myModal").modal("hide");
			listarTabla();
		}
	});
	limpiar();
}
function guardarrespuestaredireccionar(e2) {
	e2.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardardirecto").prop("disabled", true);
	var formData = new FormData($("#redireccionar")[0]);
	$.ajax({
		url: "../controlador/ayudadependencia.php?op=guardarrespuestaredireccionar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			// console.log(datos);
			alertify.success(datos);
			mostrarform(false);
			$("#myModal").modal("hide");
			listarTabla();
		}
	});
	limpiar();
}
function contacto(id_credencial) {
	$.post("../controlador/ayudadependencia.php?op=contacto", { id_credencial: id_credencial }, function (data, status) {
		data = JSON.parse(data);
		$("#myModalContacto").modal("show");
		$("#resultado_contacto").html("");
		$('#resultado_contacto').append(data["0"]["0"]);
	});
}
init();