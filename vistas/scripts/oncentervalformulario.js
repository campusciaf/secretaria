var tabla;
var step = 1;
//Función que se ejecuta al inicio
function init() {
	listarDatos();
	listar();
	selectPrograma();
	selectJornada();
	selectTipoDocumento();
	selectNivelEscolaridad();
	$.post("../controlador/oncentervalformulario.php?op=selectEscuela", function (r) {
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
				title: 'Pre-inscripción',
				intro: "Bienvenido a nuestro módulo de pre-inscripción donde las personas están cada ves más cerca de sumarse a este parche creativo e innovador"
			},
			{
				title: 'Formularios validados ',
				element: document.querySelector('#t-fval'),
				intro: "Aquí encontrarás nuestras estadistícas de las personas a las que se la han validado sus formularios hasta la fecha"
			},
			{
				title: 'Validados',
				element: document.querySelector('#t-val'),
				intro: "Aquí encontrarás el número de personas validadas para continuar con el proceso de convertirse en un ser creativo"
			},
			{
				title: 'Inscritos',
				element: document.querySelector('#t-ins'),
				intro: "Aquí enocntrarás el número de personas totalmente inscritas y listas para terminar con su proceso de matrícula"
			},
			{
				title: 'matriculados',
				element: document.querySelector('#t-matri'),
				intro: "Aquí encontrarás el número de personas han terminado su proceso e inician con el proceso de convertirse en profesionales"
			},
			{
				title: 'Caso',
				element: document.querySelector('#t-ca'),
				intro: "Da un vistazo a el número de caso único de cada persona"
			},
			{
				title: 'Identificación ',
				element: document.querySelector('#t-id'),
				intro: "Aquí encontrarás el número de identificación de cada persona"
			},
			{
				title: 'Nombre',
				element: document.querySelector('#t-no'),
				intro: "Aquí encontrarás el nombre completo de la persona en este proceso"
			},
			{
				title: 'Programa',
				element: document.querySelector('#t-pro'),
				intro: "Da un vistazo a el programa por el cual nuestro futuro ser creativo decidió empezar con este proceso"
			},
			{
				title: 'Jornada',
				element: document.querySelector('#t-jor'),
				intro: "Da un vistazo a la jornada de su elección"
			},
			{
				title: 'Formulario',
				element: document.querySelector('#t-form'),
				intro: "Aquí encontrarás si su formulario ha sido validado o de lo contrario tendrá que ser validado"
			},
			{
				title: 'Recibo de inscripción  ',
				element: document.querySelector('#t-ri'),
				intro: "Aquí encontrarás si su recibo de inscripción ha sido validado de lo contrario estará como pendiente"
			},
		]
	},
		console.log()
	).start();
}
function listarDatos() {
	$.post("../controlador/oncentervalformulario.php?op=listarDatos", {}, function (data, status) {
		data = JSON.parse(data);
		$("#data1").html(data.data1);
	});
}
function selectPrograma() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervalformulario.php?op=selectPrograma", function (r) {
		$("#fo_programa").html(r);
		$('#fo_programa').selectpicker('refresh');
	});
}
function selectJornada() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervalformulario.php?op=selectJornada", function (r) {
		$("#jornada_e").html(r);
		$('#jornada_e').selectpicker('refresh');
	});
}
function selectTipoDocumento() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervalformulario.php?op=selectTipoDocumento", function (r) {
		$("#tipo_documento").html(r);
		$('#tipo_documento').selectpicker('refresh');
	});
}
function selectNivelEscolaridad() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervalformulario.php?op=selectNivelEscolaridad", function (r) {
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
					messageTop: '<div style="width:50%;float:left">Reporte Formulario<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
					title: 'Formulario Inscripción',
					titleAttr: 'Print'
				},
			],
			"ajax":
			{
				url: '../controlador/oncentervalformulario.php?op=listar',
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
	$.post("../controlador/oncentervalformulario.php?op=mostrar", { id_programa: id_programa }, function (data, status) {
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
	$.post("../controlador/oncentervalformulario.php?op=perfilEstudiante", { id_estudiante: id_estudiante }, function (data, status) {
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
		url: "../controlador/oncentervalformulario.php?op=editarPerfil",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			console.log(datos);
			if (datos == 1) {
				alertify.success("Perfil Actualizado");
				$('#tbllistado').DataTable().ajax.reload();
				$("#myModalPerfilEstudiante").modal("hide");
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
//Función para activar registros
function validarFormulario(id_estudiante) {
	alertify.confirm('validar Formulario', '¿Está Seguro de validar el formulario del estudiante?', function () {
		$.post("../controlador/oncentervalformulario.php?op=validarFormulario", { id_estudiante: id_estudiante }, function (e) {
			e = JSON.parse(e);// convertir el mensaje a json
			console.log(e);
			if (e.resultado == 1) {
				alertify.success("Validación Correcta");
				refrescartabla();
				listarDatos();
			}
			else {
				alertify.error("Error Validación");
			}
			if (e.estado == 1) {
				alertify.success("Cambio de estado Inscrito");
				refrescartabla();
				listarDatos();
			}
		});
	}
		, function () { alertify.error('Cancelado') });
}
function refrescartabla() {
	tabla = $('#tbllistado').DataTable();
	tabla.ajax.reload(function (json) {
		$('#tbllistado').val(json.lastInput);
	});
}
init();	
