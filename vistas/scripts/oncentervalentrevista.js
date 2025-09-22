var tabla;
//Función que se ejecuta al inicio
function init() {
	listarDatos();
	listar();
	selectPrograma();
	selectJornada();
	selectTipoDocumento();
	selectNivelEscolaridad();
	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
	$.post("../controlador/oncentervalentrevista.php?op=selectEscuela", function (r) {
		$("#escuela").html(r);
		$('#escuela').selectpicker('refresh');
	});
	$("#formularioeditarperfil").on("submit", function (e5) {
		editarPerfil(e5);
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
				title: 'Entrevistas',
				intro: "Bienvenido a nuestro panel de entrevistas para nuestro proceso de admisión con los próximos seres originales"
			},
			{
				title: 'Comparativo',
				element: document.querySelector('#t-data'),
				intro: "Esta columna nos indica el número de entrevistas validas a la fecha, en nuestro tercer renglón se encuentra la comparativa de los datos de la campaña "
			},
			{
				title: 'Caso',
				element: document.querySelector('#t-caso'),
				intro: "Aquí podrás encontrar el número de caso único correspondiente a la persona interesada en el proceso de admisión"
			},
			{
				title: 'Identificación',
				element: document.querySelector('#t-identificacion'),
				intro: "Visualiza el número de identificación de la persona interesada en nuestro proceso de admisión"
			},
			{
				title: 'Nombre',
				element: document.querySelector('#t-nombre'),
				intro: "Da un vistazo a el nombre de la persona que se convertirás en nuestro próximo ser original"
			},
			{
				title: 'Programa',
				element: document.querySelector('#t-programa'),
				intro: "Aquí podrás encontrar el programa de elección de la persona interesa en hacer parte de familia más creativa e innovadora"
			},
			{
				title: 'Jornada',
				element: document.querySelector('#t-jornada'),
				intro: "Aquí podrás encontrar la jornada previamente elegida por la persona interesada en nuestro proceso de admisión"
			},
			{
				title: 'Entrevista',
				element: document.querySelector('#t-entrevista'),
				intro: "Da un vistazo a la validación de la entrevista de nuestro próximo ser original en caso tal de que se visualice como pendiente significa que la persona no ha realizado su entrevista, de lo contrario aparecerá tendrá la opción de ver, quiere decir que la entrevista esta realizada y pendiente de validación "
			},
			{
				title: 'Validar',
				element: document.querySelector('#t-validar'),
				intro: "Da un vistazo a la validación de la entrevista de nuestro próximo ser original en caso tal de que se visualice como pendiente significa que la persona no ha realizado su entrevista, de lo contrario aparecerá tendrá la opción de validar, quiere decir que la entrevista esta realizada y pendiente de validación"
			}
		]
	},
		console.log()
	).start();
}
function listarDatos() {
	$.post("../controlador/oncentervalentrevista.php?op=listarDatos", {}, function (data, status) {
		data = JSON.parse(data);
		$("#data1").html(data.data1);
	});
}
function selectPrograma() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervalentrevista.php?op=selectPrograma", function (r) {
		$("#fo_programa").html(r);
		$('#fo_programa').selectpicker('refresh');
	});
}
function selectJornada() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervalentrevista.php?op=selectJornada", function (r) {
		$("#jornada_e").html(r);
		$('#jornada_e').selectpicker('refresh');
	});
}
function selectTipoDocumento() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervalentrevista.php?op=selectTipoDocumento", function (r) {
		$("#tipo_documento").html(r);
		$('#tipo_documento').selectpicker('refresh');
	});
}
function selectNivelEscolaridad() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervalentrevista.php?op=selectNivelEscolaridad", function (r) {
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
					messageTop: '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
					title: 'Programas Académicos',
					titleAttr: 'Print'
				},
			],
			"ajax":
			{
				url: '../controlador/oncentervalentrevista.php?op=listar',
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
			},
		});
}
function mostrar(id_programa) {
	$.post("../controlador/oncentervalentrevista.php?op=mostrar", { id_programa: id_programa }, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);
		$("#nombre").val(data.nombre);
		$("#estado").val(data.estado);
		$("#estado").selectpicker('estado');
		$("#id_programa").val(data.id_programa);
	});
}
// funcion pra mostrar los datos en el formulario del perfil del estudiante
function perfilEstudiante(id_estudiante, identificacion, fila) {
	//$("#precarga").show();
	$("#btnCambiar").prop("disabled", false);
	$("#myModalPerfilEstudiante").modal("show");
	$("#id_estudiante").val(id_estudiante);
	$("#fila").val(fila);
	$.post("../controlador/oncentervalentrevista.php?op=perfilEstudiante", { id_estudiante: id_estudiante }, function (data, status) {
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
		url: "../controlador/oncentervalentrevista.php?op=editarPerfil",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			if (datos == 1) {
				alertify.success("Perfil Actualizado");
				tabla.ajax.reload();
			}
			else if (datos == 2) {
				alertify.error("Perfil no se pudo Actualizar");
			}
			else {
				alertify.error("Perfil ya bloqueado por validación");
			}
		}
	});
}
function verEntrevista(id_estudiante) {
	$.post("../controlador/oncentervalentrevista.php?op=verEntrevista", { id_estudiante: id_estudiante }, function (data) {
		data = JSON.parse(data);
		$("#salud_fisica").val(data.salud_fisica);
		$("#salud_mental").val(data.salud_mental);
		$("#condicion_especial").val(data.condicion_especial);
		$("#nombre_condicion_especial").val(data.nombre_condicion_especial);
		$("#estres_reciente").val(data.estres_reciente);
		$("#desea_apoyo_mental").val(data.desea_apoyo_mental);
		$("#costea_estudios").val(data.costea_estudios);
		$("#labora_actualmente").val(data.labora_actualmente);
		$("#donde_labora").val(data.donde_labora);
		$("#tiempo_laborando").val(data.tiempo_laborando);
		$("#desea_beca").val(data.desea_beca);
		$("#responsabilidades_familiares").val(data.responsabilidades_familiares);
		$("#seguridad_carrera").val(data.seguridad_carrera);
		$("#penso_abandonar").val(data.penso_abandonar);
		$("#desea_referir").val(data.desea_referir);
		$("#rendimiento_prev").val(data.rendimiento_prev);
		$("#necesita_apoyo_academico").val(data.necesita_apoyo_academico);
		$("#nombre_materia").val(data.nombre_materia);
		$("#tiene_habilidades_organizativas").val(data.tiene_habilidades_organizativas);
		$("#comodidad_herramientas_digitales").val(data.comodidad_herramientas_digitales);
		$("#acceso_internet").val(data.acceso_internet);
		$("#acceso_computador").val(data.acceso_computador);
		$("#estrato").val(data.estrato);
		$("#municipio_residencia").val(data.municipio_residencia);
		$("#direccion_residencia").val(data.direccion_residencia);
		$("#nombre_referencia_familiar").val(data.nombre_referencia_familiar);
		$("#telefono_referencia_familiar").val(data.telefono_referencia_familiar);
		$("#parentesco_referencia_familiar").val(data.parentesco_referencia_familiar);

		$("#myModalEntrevista").modal("show");
	});
}
//Función para activar registros
function validarEntrevista(id_estudiante) {
	alertify.confirm('validar Entrevista', '¿Está Seguro de validar la entrevista del estudiante?', function () {
		$.post("../controlador/oncentervalentrevista.php?op=validarEntrevista", { id_estudiante: id_estudiante }, function (e) {
			e = JSON.parse(e);// convertir el mensaje a json
			console.log(e);
			if (e.resultado == 1) {
				alertify.success("Validación Correcta");
				refrescartabla();
			}
			else {
				alertify.error("Error Validación");
			}
		});
	}, function () { alertify.error('Cancelado') });
}
function refrescartabla() {
	tabla = $('#tbllistado').DataTable();
	tabla.ajax.reload(function (json) {
		$('#tbllistado').val(json.lastInput);
	});
}
init();