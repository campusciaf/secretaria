var tabla;
//Función que se ejecuta al inicio
function init() {
	listar();
	selectPrograma();
	selectJornada();
	selectTipoDocumento();
	selectNivelEscolaridad();
	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
	$.post("../controlador/oncentervaldatacredito.php?op=selectEscuela", function (r) {
		$("#escuela").html(r);
		$('#escuela').selectpicker('refresh');
	});
	$("#formularioeditarperfil").on("submit", function (e5) {
		editarPerfil(e5);
	});
	$("#formularioDatacredito").on("submit", function (e5) {
		GenerarScore(e5);
	});
}
function iniciarTour() {
	introJs().setOptions({
		nextLabel: 'Siguiente',
		prevLabel: 'Anterior',
		doneLabel: 'Terminar',
		showBullets: false,
		showProgress: true,
		showStepNumbers: true,
		steps: [
			{
				title: 'Documentos',
				intro: "Bienvenido a nuestro panel de documentos donde podrás validar los documentos de nuestros seres originales"
			},
			{
				title: 'Caso',
				element: document.querySelector('#t-caso'),
				intro: "Aquí podrás encontrar el número de caso único que corresponde a la persona que esta realizando el proceso de admisión"
			},
			{
				title: 'Identificación',
				element: document.querySelector('#t-identificacion'),
				intro: "Visualiza el número de identificación de la persona interesada en el proceso de admisiones"
			},
			{
				title: 'Nombre',
				element: document.querySelector('#t-nombre'),
				intro: "En este campo podrás encontrar el nombre de la persona que esta interesada en nuestro proceso de admisiones"
			},
			{
				title: 'Programa',
				element: document.querySelector('#t-programa'),
				intro: "En este campo contiene el nombre de el programa que esta asociado con la persona que esta interesada en nustro proceso de admisión "
			},
			{
				title: 'Jornada',
				element: document.querySelector('#t-jornada'),
				intro: "Este campo contiene a jornada de la experiencia creativa que la persona desea realizar"
			},
			{
				title: 'Soportes',
				element: document.querySelector('#t-soportes'),
				intro: "Aquí podrás visualizar los documentos requeridos para ser un verdadero ser creativo al dar clic en el botón <span class='badge badge-primary text-white'>Ver soporte</span>, el sistema te mostrará una ventana para la gestión de los respectivos documentos"
			},
			{
				title: 'Validar',
				element: document.querySelector('#t-validar'),
				intro: "En este campo podrás visualizar si la documentación esta completamente validada tendrá un OK de lo contrario aparecerá como pendiente"
			},
			{
				title: 'Matrícula',
				element: document.querySelector('#t-matricula'),
				intro: "En este campo podrás visualizar si el soporte de pago de matricula fue realizado, este es un proceso que no se realiza en este módulo "
			}
		]
	},
		console.log()
	).start();
}
function selectPrograma() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervaldatacredito.php?op=selectPrograma", function (r) {
		$("#fo_programa").html(r);
		$('#fo_programa').selectpicker('refresh');
	});
}
function selectJornada() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervaldatacredito.php?op=selectJornada", function (r) {
		$("#jornada_e").html(r);
		$('#jornada_e').selectpicker('refresh');
	});
}
function selectTipoDocumento() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervaldatacredito.php?op=selectTipoDocumento", function (r) {
		$("#tipo_documento").html(r);
		$('#tipo_documento').selectpicker('refresh');
	});
}
function selectNivelEscolaridad() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervaldatacredito.php?op=selectNivelEscolaridad", function (r) {
		$("#nivel_escolaridad").html(r);
		$('#nivel_escolaridad').selectpicker('refresh');
	});
}
//Función Listar
function listar() {
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistado').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
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
					messageTop: '<div style="width:50%;float:left">Reporte Validación de documentos<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
					title: 'Documentos',
					titleAttr: 'Print'
				},
			],
			"ajax":
			{
				url: '../controlador/oncentervaldatacredito.php?op=listar',
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			"order": [[1, "desc"]],//Ordenar (columna,orden)
			'initComplete': function (settings, json) {
				$("#precarga").hide();
				$(".tooltips").tooltip();
			},
		});
}
function mostrar(id_programa) {
	$.post("../controlador/oncentervaldatacredito.php?op=mostrar", { id_programa: id_programa }, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);
		$("#nombre").val(data.nombre);
		$("#estado").val(data.estado);
		$("#estado").selectpicker('estado');
		$("#id_programa").val(data.id_programa);
	});
}
//Funcion pra mostrar los datos en el formulario del perfil del estudiante
function perfilEstudiante(id_estudiante, identificacion, fila) {
	//$("#precarga").show();
	$("#btnCambiar").prop("disabled", false);
	$("#myModalPerfilEstudiante").modal("show");
	$("#id_estudiante").val(id_estudiante);
	$("#fila").val(fila);
	$.post("../controlador/oncentervaldatacredito.php?op=perfilEstudiante", { id_estudiante: id_estudiante }, function (data, status) {
		data = JSON.parse(data);
		$("#fo_programa").val(data.fo_programa);
		$("#fo_programa").selectpicker('refresh');
		$("#jornada_e").val(data.jornada_e);
		$("#jornada_e").selectpicker('refresh');
		$("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#nombre").val(data.nombre);
		$("#nombre_2").val(data.nombre_2);
		$("#apellidos").val(data.apellidos);
		$("#apellidos_2").val(data.apellidos_2);
		$("#celular").val(data.celular);
		$("#email").val(data.email);
		$("#nivel_escolaridad").val(data.nivel_escolaridad);
		$("#nivel_escolaridad").selectpicker('refresh');
		$("#fecha_graduacion").val(data.fecha_graduacion);
		$("#nombre_colegio").val(data.nombre_colegio);
	});
}
function editarPerfil(e5) {
	e5.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioeditarperfil")[0]);
	$.ajax({
		url: "../controlador/oncentervaldatacredito.php?op=editarPerfil",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			if (datos == 1) {
				Swal.fire({ position: 'top-end', icon: 'success', title: "Perfil Actualizado" });
				refrescartabla();
			}
			else if (datos == 2) {
				Swal.fire({ position: 'top-end', icon: 'error', title: "Perfil no se pudo Actualizar" });
			}
			else {
				Swal.fire({ position: 'top-end', icon: 'error', title: "Perfil ya bloqueado por validación" });
			}
		}
	});
}
//Función para activar registros
function validarDocumentos(id_estudiante) {
	alertify.confirm('validar Documentos', '¿Está Seguro de validar los documentos?', function () {
		$.post("../controlador/oncentervaldatacredito.php?op=validarDocumentos", { id_estudiante: id_estudiante }, function (e) {
			e = JSON.parse(e);// convertir el mensaje a json
			if (e.resultado == 1) {
				alertify.success("Validación Correcta");
				refrescartabla();
			}
			else {
				alertify.error("Error Validación");
			}
			if (e.estado == 1) {
				alertify.success("Cambio de estado Admitido");
				refrescartabla(); // linea 106 del error de la consola
			}
		});
	}
		, function () { alertify.error('Cancelado') });
}
function verSoportes(id_estudiante) {
	$.post("../controlador/oncentervaldatacredito.php?op=verSoportes", { id_estudiante: id_estudiante }, function (e) {
		$("#myModaVerSoportesDigitales").modal("show");
		e = JSON.parse(e);// convertir el mensaje a json
		$("#soporte_cedula").html("");
		$("#soporte_cedula").append(e.cedula);// agrega contenido al div de cédula	
		$("#soporte_diploma").html("");
		$("#soporte_diploma").append(e.diploma);// agrega contenido al div de diploma
		$("#soporte_acta").html("");
		$("#soporte_acta").append(e.acta);// agrega contenido al div de acta
		$("#soporte_salud").html("");
		$("#soporte_salud").append(e.salud);// agrega contenido al div de salud
		$("#soporte_prueba").html("");
		$("#soporte_prueba").append(e.prueba);// agrega contenido al div de salud
		$("#soporte_compromiso").html("");
		$("#soporte_compromiso").append(e.compromiso);// agrega contenido al div de salud
		$("#soporte_proteccion_datos").html("");
		$("#soporte_proteccion_datos").append(e.proteccion_datos);// agrega contenido al div de salud
	});
}
function validar(id_estudiante, soporte) {
	$.post("../controlador/oncentervaldatacredito.php?op=validar", { id_estudiante: id_estudiante, soporte: soporte }, function (e) {
		e = JSON.parse(e);// convertir el mensaje a json
		if (e == 1) {
			Swal.fire({ position: 'top-end', icon: 'success', title: "Soporte validado" });
			verSoportes(id_estudiante);
			refrescartabla();
		} else {
			Swal.fire({ position: 'top-end', icon: 'error', title: "Soporte no se pudo validar" });
		}
	});
}
function refrescartabla() {
	tabla = $('#tbllistado').DataTable();
	tabla.ajax.reload(function (json) {
		$('#tbllistado').val(json.lastInput);
	});
}
function mostrarDatosModal(id_interesado, datacredito_documento, primer_apellido_datacredito) {
	$("#id_interesado").val(id_interesado);
	$("#datacredito_documento").val(datacredito_documento);
	$("#primer_apellido_datacredito").val(primer_apellido_datacredito);
	$("#modal_datacredito").modal("show");
}

function GenerarScore(e5) {
	$("#btnDatacredito").attr("disabled", true);
	$(".precarga").show();
	e5.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioDatacredito")[0]);
	$.ajax({
		"url": "../controlador/oncentervaldatacredito.php?op=formularioDatacredito",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			console.log(datos);
			$("#btnDatacredito").attr("disabled", false);
			$(".precarga").hide();
			try {
				datos = JSON.parse(datos);
				if (datos.exito == 1) {
					Swal.fire({ position: 'top-end', icon: 'success', title: datos.info });
					$(".score_id_" + datos.id_interesado).html(datos.scoreValue);
					$("#modal_datacredito").modal("hide");
				}else {
					Swal.fire({ position: 'top-end', icon: 'error', title: datos.info });
				}
			} catch (error) {
				Swal.fire({ position: 'top-end', icon: 'error', title: "Error al analizar los datos." });
			}
		}
	});
}
init();
