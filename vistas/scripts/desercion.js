var tabla;
var valor_global;

function init() {
	listargeneral();
	$("#resultadoprofesional").hide();
	$("#inactivotaba").hide();
	$("#volver_tabla").hide();
	$("#inactivotabla2").hide();

	$("#formularioAgregarSeguimiento").on("submit", function (e1) {
		guardarSeguimiento(e1);
	});

	$("#formularioTarea").on("submit", function (e2) {
		guardarTarea(e2);
	});
}

//Función Listar
function volver() {
	listargeneral();
	// $("#inactivotabla2").hide();
	$("#datos_table_desertado").hide();
	window.location.reload();
}

function muestra() {
	$("#input_dato").show();
}

function consulta_desercion() {
	// volver();
	var dato = $("#dato").val();

	if (dato != "") {
		$.post(
			"../controlador/desercion.php?op=consulta_desercion",
			{ dato: dato },
			function (datos) {
				// console.log(datos);
				var r = JSON.parse(datos);
				if (r.status != "error") {
					$("#datos_estudiante_desertado").html(r.conte);
					$("#datos_table_desertado").html(r.conte2);

					$("#tabla_desertados").dataTable({
						dom: "Bfrtip",

						buttons: [
							{
								extend: "excelHtml5",
								text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
								titleAttr: "Excel",
							},
						],
					});
				} else {
					alertify.error("No se encontre ningun dato con esa referencia.");
				}
			}
		);
	} else {
		alertify.error("Por favor completa los campos.");
	}
}

//Función para mostrar los datos de contactanos
function listargeneral() {
	$("#precarga").show();
	$("#resultadoprofesional").hide();
	$("#inactivotaba").hide();
	$("#inactivotabla2").hide();
	$.post("../controlador/desercion.php?op=listargeneral", {}, function (data) {
		data = JSON.parse(data);
		$("#datos").html(data.total);
		$("#precarga").hide();
	});
}

//Función para mostrar los datos de contactanos
function profesional(valor) {
	
	valor_global = valor;
	$("#precarga").show();
	$("#datos_table_desertado").hide();
	$.post(
		"../controlador/desercion.php?op=profesional",
		{ valor: valor },
		function (data) {
			// console.log(data);
			data = JSON.parse(data);
			$("#resultadoprofesional").show();
			$("#inactivotaba").hide();
			$("#inactivotabla2").hide();
			$("#profesional").html(data.total);
			$("#precarga").hide();
		}
	);
}

//Función para mostrar los datos de contactanos
function seguimientoinactivo(valor) {
	$("#precarga").show();
	$.post(
		"../controlador/desercion.php?op=profesional",
		{ valor: valor },
		function (data) {
			data = JSON.parse(data);
			$("#resultadoprofesional").show();
			$("#profesional").html(data.total);
			$("#precarga").hide();
		}
	);
}

//Función para mostrar los datos de contactanos
function activarjornada(id_jornada, valor) {
	$("#precarga").show();
	$.post(
		"../controlador/desercion.php?op=activarjornada",
		{ id_jornada: id_jornada, valor: valor },
		function (data) {
			listargeneral();
		}
	);
}

// function activarjornada(id_jornada, valor) {
//     let valores = [];

// 	global_valores = valores;
//     valores.push(valor);
//     console.log("ID Jornada: " + id_jornada); // Agregar este console.log()
//     $("#precarga").show();
//     $.post(
//         "../controlador/desercion.php?op=activarjornada",
//         { id_jornada: id_jornada, valor: valor },
//         function (data) {
//             listargeneral();
//         }
//     );
// }

//Función ver estudiantes
function listarestudiantes(periodo, valor, id_credencial) {
	$("#precarga").show();
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
	var fecha_hoy =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();

	tabla = $("#tbllistado").dataTable({
		aProcessing: true, //Activamos el procesamiento del datatables
		aServerSide: true, //Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //Definimos los elementos del control de tabla
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel",
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Renovaciones",
				titleAttr: "Print",
			},
		],
		ajax: {
			url:
				"../controlador/desercion.php?op=listarestudiantes&periodo=" +
				periodo +
				"&valor=" +
				valor +
				"&id_credencial=" +
				id_credencial,
			type: "get",
			dataType: "json",
			error: function (e) {
				// console.log(e.responseText);
			},
		},

		bDestroy: true,
		iDisplayLength: 10, //Paginación
		order: [[1, "asc"]],
		initComplete: function (settings, json) {
			$("#exampleModal").modal("show");
			$("#precarga").hide();
		},
	});
}

//Función ver estudiantes
function listarestudiantesnivel(periodo, nivel, valor) {
	$("#precarga").show();
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
	var fecha_hoy =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();

	tabla = $("#tbllistado").dataTable({
		aProcessing: true, //Activamos el procesamiento del datatables
		aServerSide: true, //Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //Definimos los elementos del control de tabla
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel",
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Renovaciones",
				titleAttr: "Print",
			},
		],
		ajax: {
			url:
				"../controlador/desercion.php?op=listarestudiantesnivel&periodo=" +
				periodo +
				"&nivel=" +
				nivel +
				"&valor=" +
				valor,
			type: "get",
			dataType: "json",
			error: function (e) {
				// console.log(e.responseText);
			},
		},

		bDestroy: true,
		iDisplayLength: 10, //Paginación
		order: [[1, "asc"]],
		initComplete: function (settings, json) {
			$("#exampleModal").modal("show");
			$("#precarga").hide();
		},
	});
}

//Función ver estudiantes
function verestudiantesporrenovar(
	id_programa,
	jornada,
	semestre,
	periodo,
	porrenovar
) {
	$("#precarga").show();
	$("#resultadoprofesional").hide();
	$("#totalestudiantes").hide();
	$("#inactivotaba").show();
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
	var fecha_hoy =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();

	tabla = $("#tbllistado").dataTable({
		aProcessing: true, //Activamos el procesamiento del datatables
		aServerSide: true, //Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //Definimos los elementos del control de tabla
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel",
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Renovaciones",
				titleAttr: "Print",
			},
		],
		ajax: {
			url:
				"../controlador/desercion.php?op=verestudiantesporrenovar&id_programa=" +
				id_programa +
				"&jornada=" +
				jornada +
				"&semestre=" +
				semestre +
				"&periodo=" +
				periodo +
				"&porrenovar=" +
				porrenovar,
			type: "get",
			dataType: "json",
			error: function (e) {
				// console.log(e.responseText);
			},
		},

		bDestroy: true,
		iDisplayLength: 10, //Paginación
		order: [[1, "asc"]],
		initComplete: function (settings, json) {
			$("#exampleModal").modal("show");
			$("#precarga").hide();
		},
	});
}

//Función ver estudiantes inactivos
function verestudiantesporrenovartotal(id_programa, jornada) {
	$("#precarga").show();
	$("#resultadoprofesional").hide();
	$("#totalestudiantes").hide();
	$("#inactivotaba").show();
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
	var fecha_hoy =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();

	tabla = $("#tbllistado").dataTable({
		aProcessing: true, //Activamos el procesamiento del datatables
		aServerSide: true, //Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //Definimos los elementos del control de tabla
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel",
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Renovaciones",
				titleAttr: "Print",
			},
		],
		ajax: {
			url:
				"../controlador/desercion.php?op=verestudiantesporrenovartotal&id_programa=" +
				id_programa +
				"&jornada=" +
				jornada,
			type: "get",
			dataType: "json",
			error: function (e) {
				// console.log(e.responseText);
			},
		},

		bDestroy: true,
		iDisplayLength: 10, //Paginación
		order: [[1, "asc"]],
		initComplete: function (settings, json) {
			$("#exampleModal").modal("show");
			$("#precarga").hide();
		},
	});
}

function agregar_mostrar_seguimiento(id_credencial) {
	$("#precarga").show();
	$("#btnGuardarSeguimiento").prop("disabled", false);
	$("#precarga").show();
	$("#id_estudiante_agregar").val(id_credencial);
	$("#id_estudiante_tarea").val(id_credencial);

	$.post(
		"../controlador/desercion.php?op=agregar_mostrar_seguimiento",
		{ id_credencial: id_credencial },
		function (data, status) {
			// console.log(data)
			data = JSON.parse(data); // convertir el mensaje a json
			$("#myModalAgregar").modal("show");
			$("#agregarContenido").html(""); // limpiar el div resultado
			$("#agregarContenido").append(data["0"]["0"]); // agregar el resultao al div resultado
			$("#precarga").hide();
		}
	);
}

function limpiarSeguimiento() {
	$("#mensaje_seguimiento").val("");
	$("#formularioAgregarSeguimiento").val("");
}
function guardarSeguimiento(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioAgregarSeguimiento")[0]);

	$.ajax({
		url: "../controlador/desercion.php?op=agregarSeguimiento",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			// console.log(datos);
			alertify.set("notifier", "position", "top-center");
			alertify.success(datos);
			limpiarSeguimiento();
			$("#myModalAgregar").modal("hide");
		},
	});
}

function cuentatarea() {
	// muestra el numero de caracteres limite en un textarea
	var max_chars = 150;

	$("#max").html(max_chars);

	$("#mensaje_tarea").keyup(function () {
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		$("#contadortarea").html(diff);
	});
}

function cuenta() {
	// muestra el numero de caracteres limite en un textarea
	var max_chars = 150;

	$("#max").html(max_chars);

	$("#mensaje_seguimiento").keyup(function () {
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		$("#contador").html(diff);
	});
}

function guardarTarea(e2) {
	e2.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioTarea")[0]);

	$.ajax({
		url: "../controlador/desercion.php?op=agregarTarea",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			alertify.set("notifier", "position", "top-center");
			alertify.success(datos);
			limpiarTarea();
			$("#myModalAgregar").modal("hide");
		},
	});
}

function limpiarTarea() {
	$("#mensaje_tarea").val("");
	$("#fecha_programada").val("");
	$("#hora_programada").val("");
}
//Mostramos el seguimiento de los estudiantes
function seguimientoverHistorial(id_credencial) {
	$("#precarga").show();
	$("#myModalHistorialTareas").modal("show");
	$.post(
		"../controlador/desercion.php?op=seguimientoverHistorial",
		{ id_credencial: id_credencial },
		function (data, status) {
			// console.log(data);
			data = JSON.parse(data); // convertir el mensaje a json
			$("#historial").html(""); // limpiar el div resultado
			$("#historial").append(data["0"]["0"]); // agregar el resultao al div resultado
			$("#precarga").hide();
			verHistorialTabla(id_credencial);
			verHistorialTablaTareas(id_credencial);
		}
	);
}

// funcion para listar los estudaintes por suma de programa y jornada
function verHistorialTabla(id_credencial) {
	// $("#resultadoprofesional").hide();
	// $("#inactivotaba").hide();
	var estado = "Inscrito";
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
	var fecha_hoy =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();

	$("#titulo").html("Estado: <b>" + estado + "</b>"); // limpiar el div resultado

	tabla = $("#tbllistadohistorial").dataTable({
		aProcessing: true, //Activamos el procesamiento del datatables
		aServerSide: true, //Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //Definimos los elementos del control de tabla
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel",
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left">Reporte: <b>' +
					estado +
					" </b><br>Fecha Reporte: <b> " +
					fecha_hoy +
					'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Ejes",
				titleAttr: "Seguimiento",
			},
		],
		ajax: {
			url:
				"../controlador/desercion.php?op=verHistorialTabla&id_credencial=" +
				id_credencial,
			type: "get",
			dataType: "json",
			error: function (e) {
				// console.log(e.responseText);
			},
		},
		bDestroy: true,
		iDisplayLength: 10, //Paginación
		initComplete: function (settings, json) {
			$("#precarga").hide();
		},
		// funcion para cambiar el responsive del data table

		select: "single",

		drawCallback: function (settings) {
			api = this.api();
			var $table = $(api.table().node());

			if ($table.hasClass("cards")) {
				// Create an array of labels containing all table headers
				var labels = [];
				$("thead th", $table).each(function () {
					labels.push($(this).text());
				});

				// Add data-label attribute to each cell
				$("tbody tr", $table).each(function () {
					$(this)
						.find("td")
						.each(function (column) {
							$(this).attr("data-label", labels[column]);
						});
				});

				var max = 0;
				$("tbody tr", $table)
					.each(function () {
						max = Math.max($(this).height(), max);
					})
					.height(max);
			} else {
				// Remove data-label attribute from each cell
				$("tbody td", $table).each(function () {
					$(this).removeAttr("data-label");
				});

				$("tbody tr", $table).each(function () {
					$(this).height("auto");
				});
			}
		},
	});

	var width = $(window).width();
	if (width <= 750) {
		$(api.table().node()).toggleClass("cards");
		api.draw("page");
	}
	window.onresize = function () {
		anchoVentana = window.innerWidth;
		if (anchoVentana > 1000) {
			$(api.table().node()).removeClass("cards");
			api.draw("page");
		} else if (anchoVentana > 750 && anchoVentana < 1000) {
			$(api.table().node()).removeClass("cards");
			api.draw("page");
		} else {
			$(api.table().node()).toggleClass("cards");
			api.draw("page");
		}
	};
	// ****************************** //
}

// // funcion para listar los estudaintes por suma de programa y jornada
function verHistorialTablaTareas(id_credencial) {
	// $("#resultadoprofesional").hide();
	// $("#inactivotaba").hide();
	var estado = "Inscrito";
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
	var fecha_hoy =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();

	$("#titulo").html("Estado: <b>" + estado + "</b>"); // limpiar el div resultado

	tabla = $("#tbllistadoHistorialTareas").dataTable({
		aProcessing: true, //Activamos el procesamiento del datatables
		aServerSide: true, //Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //Definimos los elementos del control de tabla
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel",
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left">Reporte: <b>' +
					estado +
					" </b><br>Fecha Reporte: <b> " +
					fecha_hoy +
					'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Ejes",
				titleAttr: "Tareas Programadas",
			},
		],
		ajax: {
			url:
				"../controlador/desercion.php?op=verHistorialTablaTareas&id_credencial=" +
				id_credencial,
			type: "get",
			dataType: "json",
			error: function (e) {
				//console.log(e.responseText);
			},
		},
		bDestroy: true,
		iDisplayLength: 10, //Paginación
		initComplete: function (settings, json) {
			$("#precarga").hide();
		},

		// funcion para cambiar el responsive del data table

		select: "single",

		drawCallback: function (settings) {
			api = this.api();
			var $table = $(api.table().node());

			if ($table.hasClass("cards")) {
				// Create an array of labels containing all table headers
				var labels = [];
				$("thead th", $table).each(function () {
					labels.push($(this).text());
				});

				// Add data-label attribute to each cell
				$("tbody tr", $table).each(function () {
					$(this)
						.find("td")
						.each(function (column) {
							$(this).attr("data-label", labels[column]);
						});
				});

				var max = 0;
				$("tbody tr", $table)
					.each(function () {
						max = Math.max($(this).height(), max);
					})
					.height(max);
			} else {
				// Remove data-label attribute from each cell
				$("tbody td", $table).each(function () {
					$(this).removeAttr("data-label");
				});

				$("tbody tr", $table).each(function () {
					$(this).height("auto");
				});
			}
		},
	});

	var width = $(window).width();
	if (width <= 750) {
		$(api.table().node()).toggleClass("cards");
		api.draw("page");
	}
	window.onresize = function () {
		anchoVentana = window.innerWidth;
		if (anchoVentana > 1000) {
			$(api.table().node()).removeClass("cards");
			api.draw("page");
		} else if (anchoVentana > 750 && anchoVentana < 1000) {
			$(api.table().node()).removeClass("cards");
			api.draw("page");
		} else {
			$(api.table().node()).toggleClass("cards");
			api.draw("page");
		}
	};
	// ****************************** //
}
//Función ver estudiantes inactivos
function verestudiantesinactivos(
	id_programa,
	jornada,
	semestre,
	temporadainactivos,
	id_credencial
) {
	$("#precarga").show();
	$("#resultadoprofesional").hide();
	$("#totalestudiantes").hide();
	$("#inactivotaba").show();
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
	var fecha_hoy =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();

	tabla = $("#tbllistado").dataTable({
		aProcessing: true, //Activamos el procesamiento del datatables
		aServerSide: true, //Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //Definimos los elementos del control de tabla
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel",
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Renovaciones",
				titleAttr: "Print",
			},
		],
		ajax: {
			url:
				"../controlador/desercion.php?op=verestudiantesinactivos&id_programa=" +
				id_programa +
				"&jornada=" +
				jornada +
				"&semestre=" +
				semestre +
				"&temporadainactivos=" +
				temporadainactivos +
				"&id_credencial=" +
				id_credencial,
			type: "get",
			dataType: "json",
			error: function (e) {
				// console.log(e.responseText);
			},
		},

		bDestroy: true,
		iDisplayLength: 10, //Paginación
		order: [[1, "asc"]],
		initComplete: function (settings, json) {
			$("#exampleModal").modal("show");
			$("#precarga").hide();
		},
	});
}

//Función ver estudiantes inactivos
function verestudiantesinactivostotal(
	id_programa,
	jornada,
	temporadainactivos
) {
	$("#precarga").show();
	$("#resultadoprofesional").hide();
	$("#totalestudiantes").hide();
	$("#inactivotaba").show();
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
	var fecha_hoy =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();

	tabla = $("#tbllistado").dataTable({
		aProcessing: true, //Activamos el procesamiento del datatables
		aServerSide: true, //Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //Definimos los elementos del control de tabla
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel",
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Renovaciones",
				titleAttr: "Print",
			},
		],
		ajax: {
			url:
				"../controlador/desercion.php?op=verestudiantesinactivostotal&id_programa=" +
				id_programa +
				"&jornada=" +
				jornada +
				"&temporadainactivos=" +
				temporadainactivos,
			type: "get",
			dataType: "json",
			error: function (e) {
				// console.log(e.responseText);
			},
		},

		bDestroy: true,
		iDisplayLength: 10, //Paginación
		order: [[1, "asc"]],
		initComplete: function (settings, json) {
			$("#exampleModal").modal("show");
			$("#precarga").hide();
		},
	});
}

//Función ver estudiantes
function verestudiantestotal(id_programa, jornada, periodo, porrenovar) {
	$("#precarga").show();
	$("#resultadoprofesional").hide();
	$("#totalestudiantes").show();
	$("#inactivotaba").hide();
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
	var fecha_hoy =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();

	tabla = $("#tbllistado").dataTable({
		aProcessing: true, //Activamos el procesamiento del datatables
		aServerSide: true, //Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //Definimos los elementos del control de tabla
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel",
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Renovaciones",
				titleAttr: "Print",
			},
		],
		ajax: {
			url:
				"../controlador/desercion.php?op=verestudiantestotal&id_programa=" +
				id_programa +
				"&jornada=" +
				jornada +
				"&periodo=" +
				periodo +
				"&porrenovar=" +
				porrenovar,
			type: "get",
			dataType: "json",
			error: function (e) {
				// console.log(e.responseText);
			},
		},

		bDestroy: true,
		iDisplayLength: 10, //Paginación
		order: [[1, "asc"]],
		initComplete: function (settings, json) {
			$("#exampleModal").modal("show");
			$("#precarga").hide();
		},
	});
}

//Función ver estudiantes
function listarestudiantesmeta(periodo, valor) {
	$("#precarga").show();
	$("#resultadoprofesional").hide();
	$("#totalestudiantes").hide();
	$("#inactivotaba").hide();
	$("#inactivotabla2").hide();
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
	var fecha_hoy =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();

	tabla = $("#tbllistado").dataTable({
		aProcessing: true, //Activamos el procesamiento del datatables
		aServerSide: true, //Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //Definimos los elementos del control de tabla
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel",
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Renovaciones",
				titleAttr: "Print",
			},
		],
		ajax: {
			url:
				"../controlador/desercion.php?op=listarestudiantesmeta&periodo=" +
				periodo +
				"&valor=" +
				valor,
			type: "get",
			dataType: "json",
			error: function (e) {
				// console.log(e.responseText);
			},
		},

		bDestroy: true,
		iDisplayLength: 10, //Paginación
		order: [[1, "asc"]],
		initComplete: function (settings, json) {
			$("#exampleModal").modal("show");
			$("#precarga").hide();
		},
	});
}

function vertotalestudiantes(id_programa, temporadainactivos, profesional) {
	$("#precarga").show();
	$("#resultadoprofesional").hide();
	$("#totalestudiantes").show();
	$("#inactivotabla2").show();
	$("#inactivotaba").hide();

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
	var fecha_hoy =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();

	tabla = $("#totalestudiantes").dataTable({
		aProcessing: true, //Activamos el procesamiento del datatables
		aServerSide: true, //Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //Definimos los elementos del control de tabla
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel",
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Renovaciones",
				titleAttr: "Print",
			},

			
		],
		ajax: {
			url:
				"../controlador/desercion.php?op=vertotalestudiantes&id_programa=" +
				id_programa +
				"&temporadainactivos=" +
				temporadainactivos +
				"&profesional=" +
				profesional,
			type: "get",
			dataType: "json",
			error: function (e) {
				// console.log(e.responseText);
			},
		},

		bDestroy: true,
		iDisplayLength: 10, //Paginación
		order: [[1, "asc"]],
		initComplete: function (settings, json) {
			$("#exampleModal").modal("show");
			$("#precarga").hide();
		},
	});
}

function vertotalestudiantesinactivos(
	id_programa,
	temporadainactivos,
	profesional
) {
	$("#precarga").show();
	$("#resultadoprofesional").hide();
	$("#totalestudiantes").show();
	$("#inactivotabla2").show();
	$("#inactivotaba").hide();

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
	var fecha_hoy =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();

	tabla = $("#totalestudiantes").dataTable({
		aProcessing: true, //Activamos el procesamiento del datatables
		aServerSide: true, //Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //Definimos los elementos del control de tabla
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel",
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Renovaciones",
				titleAttr: "Print",
			},
			
			
		],
		ajax: {
			url:
				"../controlador/desercion.php?op=vertotalestudiantesinactivos&id_programa=" +
				id_programa +
				"&temporadainactivos=" +
				temporadainactivos +
				"&profesional=" +
				profesional,
			type: "get",
			dataType: "json",
			error: function (e) {
				// console.log(e.responseText);
			},
		},

		bDestroy: true,
		iDisplayLength: 10, //Paginación
		order: [[1, "asc"]],
		initComplete: function (settings, json) {
			$("#exampleModal").modal("show");
			$("#precarga").hide();
		},
	});
}

function vertotalestudiantesporrenovar(
	id_programa,
	temporadainactivos,
	profesional
) {
	$("#precarga").show();
	$("#resultadoprofesional").hide();
	$("#totalestudiantes").show();
	$("#inactivotabla2").show();
	$("#inactivotaba").hide();

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
	var fecha_hoy =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();

	tabla = $("#totalestudiantes").dataTable({
		aProcessing: true, //Activamos el procesamiento del datatables
		aServerSide: true, //Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //Definimos los elementos del control de tabla
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel",
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Renovaciones",
				titleAttr: "Print",
			}
		],
		ajax: {
			url:
				"../controlador/desercion.php?op=vertotalestudiantesporrenovar&id_programa=" +
				id_programa +
				"&temporadainactivos=" +
				temporadainactivos +
				"&profesional=" +
				profesional,
			type: "get",
			dataType: "json",
			error: function (e) {
				// console.log(e.responseText);
			},
		},

		bDestroy: true,
		iDisplayLength: 10, //Paginación
		order: [[1, "asc"]],
		initComplete: function (settings, json) {
			$("#exampleModal").modal("show");
			$("#precarga").hide();
		},
	});
}

function volverTabla() {
	// window.location.reload();
	profesional(valor_global);
  }

init();
