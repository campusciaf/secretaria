var tabla;
var numero_celular;
var envio_mensaje;
var id_credencial_global;
//Función que se ejecuta al inicio
$(".ocultar_select").hide();
function init(){
	listar_por_categoria();
	listargraduados(0);
	consultaegresados_C();


	
		//formulario para guardar seguimiento
		$("#formularioAgregarSeguimiento").on("submit", function (e1) {
			guardarSeguimiento(e1);
		});

		//formulario para guardar tareas
	$("#formularioTarea").on("submit", function (e2) {
		guardarTarea(e2);
	});

	$("#formularioenviarmensaje").on("submit", function (e3) {
		guardarMensaje(e3);
	});

	$("#formulario_editar").on("submit", function (e4) {
		editar(e4);
	});

	$("#formulariodata").on("submit", function (e5) {
		guardardata(e5);
	});

	$("#formulariodatos").on("submit", function (e6) {
		editar_guardar_caracter(e6);
	});


	$.post(
		"../controlador/consultagraduadosgeneral.php?op=selectEstadoEgresado",
		function (r) {
			$("#id_egresado_estado").html(r);
			$("#estado_egresado").selectpicker("refresh");
		}
	);

	$.post("../controlador/consultagraduadosgeneral.php?op=selectTipoSangre", function (
		r
	) {
		$("#tipo_sangre").html(r);
		$("#tipo_sangre").selectpicker("refresh");
	});

	$.post("../controlador/consultagraduadosgeneral.php?op=selectDepartamento", function (
		r
	) {
		$("#departamento_nacimiento").html(r);
		$("#departamento_nacimiento").selectpicker("refresh");
	});

	$.post("../controlador/consultagraduadosgeneral.php?op=selectMunicipio", function (r) {
		$("#lugar_nacimiento").html(r);
		$("#lugar_nacimiento").selectpicker("refresh");
	});

}
//Función Listar Metas
function listargraduados(ciclo_escuela){
	$("#precarga").show();
	
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistadograduados').dataTable({

		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		buttons: [
			{
				extend:    'copyHtml5',
				text:      '<i class="fa fa-copy fa-2x" style="color: blue"></i>',
				titleAttr: 'Copy'
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			
		],
		
		"ajax":{ 
			url: '../controlador/consultagraduadosgeneral.php?op=listargraduados&ciclo_escuela='+ciclo_escuela, 
			type : "get", 
			dataType : "json",						
			error: function(e){
				// console.log(e);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[11, "asc" ]],//Ordenar (columna,orden)
		'initComplete': function (settings, json) {
			$("#precarga").hide();
		},
		
	});
	
}


function guardarSeguimiento(e1) {
	//
	e1.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioAgregarSeguimiento")[0]);

	$.ajax({
		url: "../controlador/consultagraduadosgeneral.php?op=agregarSeguimiento",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Seguimiento Guardado.",
				showConfirmButton: false,
				timer: 1500
			});
			limpiarSeguimiento();
			$("#myModalAgregar").modal("hide");
		}
	});
}


function cuentatarea() {
	// muestra el numero de caracteres limite en un textarea
	var max_chars = 600;

	$("#max").html(max_chars);

	$("#mensaje_tarea").keyup(function () {
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		$("#contadortarea").html(diff);
	});
}

function cuenta() {
	// muestra el numero de caracteres limite en un textarea
	var max_chars = 600;

	$("#max").html(max_chars);

	$("#mensaje_seguimiento").keyup(function () {
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		$("#contador").html(diff);
	});
}

function cuentamensaje() {
	// muestra el numero de caracteres limite en un textarea
	var max_chars = 600;

	$("#max").html(max_chars);

	$("#envio_mensaje").keyup(function () {
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		$("#contadormensaje").html(diff);
	});
}


//funcion para guardar las tareas
function guardarTarea(e2) {
	e2.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioTarea")[0]);

	$.ajax({
		url: "../controlador/consultagraduadosgeneral.php?op=agregarTarea",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Tarea Guardada.",
				showConfirmButton: false,
				timer: 1500
			});
			limpiarTarea();
			$("#myModalAgregar").modal("hide");
		}
	});
}

//funcion para abrir el modal que permite ver los seguimientos y tareas del estudiante
function verHistorial(id_credencial_tabla) {
	$("#precarga").show();
	$("#myModalHistorial").modal("show");
	$("#precarga").hide();
	verHistorialTabla(id_credencial_tabla);
	verHistorialTablaTareas(id_credencial_tabla);
}


//funcion para traer el id credencial del estudiante
function agregar_seguimiento_egresado(id_credencial) {
	$("#myModalAgregar").modal("show");
	$("#id_credencial_tarea").val(id_credencial);
	$("#id_credencial_tabla").val(id_credencial);
}


// funcion para listar el seguimiento de los estudiantes
function verHistorialTabla(id_credencial_tabla) {
	var estado = "Selecionado";
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

	tabla = $("#tbllistadohistorialegresado")
		.dataTable({
			aProcessing: true, //Activamos el procesamiento del datatables
			aServerSide: true, //Paginación y filtrado realizados por el servidor
			dom: "Bfrtip", //Definimos los elementos del control de tabla
			buttons: [
				{
					extend: "excelHtml5",
					text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					titleAttr: "Excel"
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
					titleAttr: "Seguimiento"
				}
			],
			ajax: {
				url:
					"../controlador/consultagraduadosgeneral.php?op=verHistorialTabla&id_credencial_tabla=" +id_credencial_tabla,
				type: "get",
				dataType: "json",
				error: function (e) { }
			},
			bDestroy: true,
			iDisplayLength: 10, //Paginación
			order: [[0, "desc"]] //Ordenar (columna,orden)
		})
		.DataTable();
}

// funcion para ver las tareas
function verHistorialTablaTareas(id_credencial_tarea) {
	var estado = "Selecionado";
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

	tabla = $("#tblseguimientohistorialegresado")
		.dataTable({
			aProcessing: true, //Activamos el procesamiento del datatables
			aServerSide: true, //Paginación y filtrado realizados por el servidor
			dom: "Bfrtip", //Definimos los elementos del control de tabla
			buttons: [
				{
					extend: "excelHtml5",
					text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					titleAttr: "Excel"
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
					titleAttr: "Seguimiento"
				}
			],
			ajax: {
				url:
					"../controlador/consultagraduadosgeneral.php?op=verTareasHistorialTabla&id_credencial_tarea=" +
					id_credencial_tarea,
				type: "get",
				dataType: "json",
				error: function (e) { }
			},
			bDestroy: true,
			iDisplayLength: 10, //Paginación
			order: [[0, "desc"]] //Ordenar (columna,orden)
		})
		.DataTable();
}

//funcion para guardar el seguimiento de los estudiantes
function guardarMensaje(e3) {
	e3.preventDefault(); //No se activará la acción predeterminada del evento
	// $("#btnGuardarSeguimiento").prop("disabled",true);
	var formData = new FormData($("#formularioenviarmensaje")[0]);

	$.ajax({
		url: "../controlador/consultagraduadosgeneral.php?op=agregarMensaje",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Mensaje Guardado.",
				showConfirmButton: false,
				timer: 1500
			});
		}
	});
}

// trae el numero de celular y mensaje
function enviarnumero(numero_celular, envio_mensaje) {
	$("#myModalMensaje").modal("show");
	$("#numero_celular").val(numero_celular);
	$("#envio_mensaje").val(envio_mensaje);
}


// funcion Enviar plantilla con la API
function mensaje_plantilla(numero_celular) {
	var numero_celular = $("#numero_celular").val();
	$.post(
		"../controlador/consultagraduadosgeneral.php?op=mensaje_plantilla",
		{ numero_celular: numero_celular },
		function (data) {
			data = JSON.parse(data);
			if (Object.keys(data).length > 0) {
				$("#numero_celular").val(data.numero_celular);
			}
		}
	);
}

// funcion Enviar mensajes con la API
function mensaje(numero_celular, envio_mensaje) {
	var numero_celular = $("#numero_celular").val();
	var envio_mensaje = $("#envio_mensaje").val();
	$("#ModalCrearCategoria").modal("show");
	$.post(
		"../controlador/consultagraduadosgeneral.php?op=mensaje",
		{ numero_celular: numero_celular, envio_mensaje: envio_mensaje },
		function (data) {
			data = JSON.parse(data);
			if (Object.keys(data).length > 0) {
				$("#numero_celular").val(data.numero_celular);
				$("#envio_mensaje").val(data.envio_mensaje);
			}
		}
	);
}


function mostrar_egresado( id_credencial) {
	$("#formularioegresados").modal("show");
	id_credencial_global = id_credencial;

	$.post(
		"../controlador/consultagraduadosgeneral.php?op=mostrar_egresado",
		{ id_credencial: id_credencial },
		function (data, status) {
			// console.log(data);
			data = JSON.parse(data);

			$("#credencial_nombre").val(data.credencial_nombre);
			$("#credencial_nombre_2").val(data.credencial_nombre_2);
			$("#credencial_apellido").val(data.credencial_apellido);
			$("#credencial_apellido_2").val(data.credencial_apellido_2);
			$("#credencial_identificacion").val(data.credencial_identificacion);
			$("#fecha_nacimiento").val(data.fecha_nacimiento);
			$("#tipo_sangre").val(data.tipo_sangre);
			$("#tipo_sangre").selectpicker("refresh");
			$("#genero").val(data.genero);
			$("#grupo_etnico").val(data.grupo_etnico);
			$("#nombre_etnico").val(data.nombre_etnico);
			$("#departamento_nacimiento").val(data.departamento_nacimiento);
			$("#departamento_nacimiento").selectpicker("refresh");
			$("#lugar_nacimiento").val(data.lugar_nacimiento);
			$("#lugar_nacimiento").selectpicker("refresh");
			mostrarmunicipio(data.departamento_nacimiento, data.lugar_nacimiento);

			$("#direccion").val(data.direccion);
			$("#barrio").val(data.barrio);
			$("#telefono").val(data.telefono);
			$("#celular").val(data.celular);
			$("#email").val(data.email);
			$("#instagram").val(data.instagram);
		}
	);
}





function editar(e4) {
	e4.preventDefault(); 
    var formData = new FormData($("#formulario_editar")[0]);
	formData.append("id_credencial_global", id_credencial_global);
	$.ajax({
		type: "POST",
		url: "../controlador/consultagraduadosgeneral.php?op=editar_estudiante",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			// console.log(datos);
			var r = JSON.parse(datos);
			
			if (r.status == "ok") {
				$("#formularioegresados").modal("hide");
				$("#tbllistadograduados").DataTable().ajax.reload();
				Swal.fire({
						position: "top-end",
						icon: "success",
						title: "Estudiante Actualizado",
						showConfirmButton: false,
						timer: 1500,
						
				});
			} else {
				alertify.error(r.status);
			}
		}
	});
}


function limpiar() {
	$("#credencial_nombre").val("");
	$("#credencial_nombre_2").val("");
	$("#credencial_apellido").val("");
	$("#credencial_apellido_2").val("");
	$("#credencial_identificacion").val("");
	$("#fecha_nacimiento").val("");
	$("#tipo_sangre").val("");
	$("#tipo_sangre").selectpicker("refresh");
	$("#genero").val("");
	$("#grupo_etnico").val("");
	$("#nombre_etnico").val("");
	$("#departamento_nacimiento").val("");
	$("#departamento_nacimiento").selectpicker("refresh");

	$("#lugar_nacimiento").val("");
	$("#lugar_nacimiento").selectpicker("refresh");

	$("#direccion").val("");
	$("#barrio").val("");
	$("#telefono").val("");
	$("#celular").val("");
	$("#email").val("");
	$("#instagram").val("");
}

function mostrarmunicipio(departamento, municipio) {
	$.post(
		"../controlador/consultagraduadosgeneral.php?op=selectMunicipio",
		{ departamento: departamento },
		function (datos) {
			$("#lugar_nacimiento").html(datos);
			$("#lugar_nacimiento").selectpicker("refresh");
			$("#lugar_nacimiento").val(municipio);
			$("#lugar_nacimiento").selectpicker("refresh");
		}
	);
}



function aceptoData(id_credencial) {
	$.post(
		"../controlador/consultagraduadosgeneral.php?op=aceptoData",
		{ id_credencial: id_credencial },
		function (data) {
			data = JSON.parse(data);
			if (data == 2) {
				//no tiene tratamiento de datos
				$("#myModalData").modal("show");
				$("#myModalCaraterizacion").modal("hide");
				$("#id_credencial_e").val(id_credencial);
			} else {
				listarPreguntas(id_credencial);
			}
		}
	);
}

function guardardata(e5) {
	e5.preventDefault();
	var formData = new FormData($("#formulariodata")[0]);

	$.ajax({
		url: "../controlador/consultagraduadosgeneral.php?op=guardardata",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			datos = JSON.parse(datos);
			if (datos.estado == "si") {
				Swal.fire({
					icon: "success",
					title: "Datos protegidos",
					showConfirmButton: false,
					timer: 1500
				});
				aceptoData(datos.credencial);
			} else {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: "Ocurrió un error al guardar los datos hoy.",
					showConfirmButton: false,
					timer: 1500
				});
			}
		}
	});
}

function listarPreguntas(id_credencial) {
	$("#myModalData").modal("hide");
	$("#myModalCaraterizacion").modal("show");
	$.post(
		"../controlador/consultagraduadosgeneral.php?op=listarPreguntas",
		{ id_credencial: id_credencial },
		function (data) {
			data = JSON.parse(data);
			$("#preguntas").html(data);

			$("#precarga").hide();
		}
	);
}


function editar_guardar_caracter(e6) {
	$("#precarga").show();
	e6.preventDefault();
	var formData = new FormData($("#formulariodatos")[0]);

	$.ajax({
		type: "POST",
		url: "../controlador/consultagraduadosgeneral.php?op=guardar_editar_caracter",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			datos = JSON.parse(datos);
			if (datos.estado == "si") {
				Swal.fire({
					icon: "success",
					title: "Datos actualizados",
					showConfirmButton: false,
					timer: 1500
				});

				listarPreguntas(datos.credencial);
				$("#precarga").hide();
				$("#tbllistadograduados").DataTable().ajax.reload();
				$("#tblconsultaegresadoModal").DataTable().ajax.reload();
			} else {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: "Proceso rechazado!",
					showConfirmButton: false,
					timer: 1500
				});
			}
		}
	});
}


function mostrarLabora(opcion) {
	if (opcion == "si") {
		$(".si_labora").removeClass("d-none");
	} else if (opcion == "no") {
		$(".si_labora").addClass("d-none");
	}
}

function mostrarNumHijos(opcion) {
	if (opcion == "si") {
		$(".si_hijos").removeClass("d-none");
	} else if (opcion == "no") {
		$(".si_hijos").addClass("d-none");
	}
}



function consultaegresados_C() {
	$("#precarga").show();
	$("#tblconsultaegresadoModal").show();

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
	tabla = $("#tblconsultaegresadoModal").dataTable({
		aProcessing: true, //Activamos el procesamiento del datatables
		aServerSide: true, //Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //Definimos los elementos del control de tabla
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel"
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left"><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Consulta Egresados",
				titleAttr: "Print"
			}
		],

		ajax: {
			url: "../controlador/consultagraduadosgeneral.php?op=mostrar_caracter",
			type: "get",
			dataType: "json",
			error: function (e) { }
		},
		bDestroy: true,
		iDisplayLength: 10, //Paginación
		order: [[0, "asc"]], //Ordenar (columna,orden)
		initComplete: function (settings, json) {
			$("#precarga").hide();
		}
	});
}

function listar_por_categoria() {
    $.post("../controlador/consultagraduadosgeneral.php?op=mostrar_total_por_programa", {}, function(data) {
        // console.log(data);
        data = JSON.parse(data);

        $("#tecnico_laboral").text(data["Tecnico Laboral"]);
        $("#tecnico_profesional").text(data["Tecnico Profesional"]);
        $("#tecnologo").text(data["Tecnologo"]);
        $("#profesional").text(data["Profesional"]);
        $("#total_general").text(data["Total General"]);
    });
}




init();