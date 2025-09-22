var tabla;
var usuario_identificacion = "";

//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	$("#listadoregistros").hide();

	$("#formularioverificar").on("submit", function (e1) {
		verificardocumento(e1);
	});
}

//Función mostrar formulario
function mostrarform(flag) {
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
		$("#seleccionprograma").hide();
	} else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#seleccionprograma").show();
	}
}

//Función Listar los docentes
function verificardocumento(e1) {
	$("#listadomaterias").hide();
	$("#mostrar_formulario_crear_docente").hide();
	e1.preventDefault();
	var formData = new FormData($("#formularioverificar")[0]);
	$.ajax({
		url: "../controlador/consulta_pea_docente.php?op=verificardocumento",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			// console.log(datos);
			data = JSON.parse(datos);
			if (JSON.stringify(data["0"]["1"]) == "false") {
				// si llega vacio toca matricular
				alertify.error("No existe el docente");
				$("#listadoregistros").hide();
				$("#mostrardatos").hide();
			} else {
				usuario_identificacion = data["0"]["0"];

				$("#mostrardatos").show();
				listar(usuario_identificacion);
				mostrar_tabla2(usuario_identificacion);
				mostrar_tabla3(usuario_identificacion);
			}
		},
	});
}

function mostrar_tabla2() {
	$.post("../controlador/consulta_pea_docente.php?op=mostrar_tabla2", { usuario_identificacion: usuario_identificacion }, function (data) {
		// console.log(data);
		data = JSON.parse(data);
		$("#mostrar_tablas_consulta").show();
		$("#mostrar_tablas_consulta").html(data);

		$("#mostrar_consulta_enlaces").dataTable({
			dom: "Bfrtip",

			buttons: [
				{
					extend: "excelHtml5",
					text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
					titleAttr: "Excel",
				},
			],
		});
		// refrescartablaeditarmeta();
	});
}



function mostrar_tabla3() {

	$.post("../controlador/consulta_pea_docente.php?op=mostrar_tabla3", { usuario_identificacion: usuario_identificacion }, function (data) {
		// console.log(data);
		data = JSON.parse(data);
		$("#mostrar_tablas_ejercicios_consulta").show();
		$("#mostrar_tablas_ejercicios_consulta").html(data);
		$("#mostrar_consulta_ejercicio").dataTable({
			dom: "Bfrtip",
			buttons: [
				{
					extend: "excelHtml5",
					text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
					titleAttr: "Excel",
				},
			],
		});
		// refrescartablaeditarmeta();
	});
}

//Función Listar
function listar() {

	usuario_identificacion_global = usuario_identificacion;
	$("#listadoregistros").show();
	var meses = new Array(
		"Enero",
		"Febrero",
		"Marzo",
		"Abril",
		"Mayo",
		"Junio",
		"Julio",
		"Agosto",
		"Septiembre",
		"Octubre",
		"Noviembre",
		"Diciembre"
	);
	var diasSemana = new Array(
		"Domingo",
		"Lunes",
		"Martes",
		"Miércoles",
		"Jueves",
		"Viernes",
		"Sábado"
	);
	var f = new Date();
	var fecha =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();

	tabla = $("#tbllistado")
		.dataTable({
			aProcessing: true, //Activamos el procesamiento del datatables
			aServerSide: true, //Paginación y filtrado realizados por el servidor

			dom: "Bfrtip",
			buttons: [
				{
					extend: "excelHtml5",
					text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					titleAttr: "Excel",
				},

			],
			ajax: {
				url:
					"../controlador/consulta_pea_docente.php?op=listar&usuario_identificacion=" +
					usuario_identificacion,
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e);
				},
			},
			bDestroy: true,
			scrollX: false,
			iDisplayLength: 10, //Paginación
			order: [[2, "asc"]], //Ordenar (columna,orden)
		})
		.DataTable();
}

init();
