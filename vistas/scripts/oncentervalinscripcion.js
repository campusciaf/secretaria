var tabla;
//Función que se ejecuta al inicio
function init() {
	listar();
	listarDatos();
	selectPrograma();
	selectJornada();
	selectTipoDocumento();
	selectNivelEscolaridad();
	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
	$.post("../controlador/oncentervalinscripcion.php?op=selectEscuela", function (r) {
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
				title: 'Inscripción',
				intro: "Bienvenido a nuestro módulo de inscripción donde podrás visualizar a las personas que están en proceso de convertirse en nuestros seres creativos"
			},
			{
				title: 'Caso',
				element: document.querySelector('#t-c'),
				intro: "Aquí podrás encontrar el número de caso único de la persona interesada en formar parte de nuestro parche más creativo e innovador"
			},
			{
				title: 'Identificación',
				element: document.querySelector('#t-id'),
				intro: "Encontrarás el número de identificación de la persona en este proceso"
			},
			{
				title: 'Nombre',
				element: document.querySelector('#t-no'),
				intro: "Da un vistazo a el nombre de nuestro futuro ser creativo"
			},
			{
				title: 'Programa',
				element: document.querySelector('#t-pro'),
				intro: "podrás visualizar el programa de su elección para convertirse en todo un profesional"
			},
			{
				title: 'jornada',
				element: document.querySelector('#t-jo'),
				intro: "Visualiza la jornada de su elección"
			},
			{
				title: 'Recibo',
				element: document.querySelector('#t-re'),
				intro: "Aquí podrás encontrar el recibo de pago de nuestro futuro ser creativo"
			},
			{
				title: 'Validar',
				element: document.querySelector('#t-val'),
				intro: "Estamos a un paso de que la persona en este proceso se convierta parte de esta familia, creativa e innovadora,si todos sus documentos y su pago están en orden podrás vaidar su inscripción en un click "
			},
			{
				title: 'Formulario',
				element: document.querySelector('#t-form'),
				intro: "Aquí podrás visualizar el estado del formulario si aún aparece como pendiente o de lo contarario también ha sido validado"
			},
		]
	},
		console.log()
	).start();
}
function selectPrograma() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervalinscripcion.php?op=selectPrograma", function (r) {
		$("#fo_programa").html(r);
		$('#fo_programa').selectpicker('refresh');
	});
}
function selectJornada() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervalinscripcion.php?op=selectJornada", function (r) {
		$("#jornada_e").html(r);
		$('#jornada_e').selectpicker('refresh');
	});
}
function selectTipoDocumento() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervalinscripcion.php?op=selectTipoDocumento", function (r) {
		$("#tipo_documento").html(r);
		$('#tipo_documento').selectpicker('refresh');
	});
}
function selectNivelEscolaridad() {
	//Cargamos los items de los selects
	$.post("../controlador/oncentervalinscripcion.php?op=selectNivelEscolaridad", function (r) {
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
					messageTop: '<div style="width:50%;float:left">Reporte Inscripción<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
					title: 'Recibos de inscripción',
					titleAttr: 'Print'
				},
			],
			"ajax":
			{
				url: '../controlador/oncentervalinscripcion.php?op=listar',
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
	$.post("../controlador/oncentervalinscripcion.php?op=mostrar", { id_programa: id_programa }, function (data, status) {
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
	$.post("../controlador/oncentervalinscripcion.php?op=perfilEstudiante", { id_estudiante: id_estudiante }, function (data, status) {
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
		url: "../controlador/oncentervalinscripcion.php?op=editarPerfil",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			if (datos == 1) {
				alertify.success("Perfil Actualizado");
				refrescartabla();
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
function validarInscripcion(id_estudiante) {
	alertify.confirm('validar Inscripción', '¿Está Seguro de validar el recibo de inscripción del estudiante?', function () {
		$.post("../controlador/oncentervalinscripcion.php?op=validarInscripcion", { id_estudiante: id_estudiante }, function (e) {
			e = JSON.parse(e);// convertir el mensaje a json
			if (e.resultado == 1) {
				alertify.success("Validación Correcta");
				refrescartabla();
			}
			else {
				alertify.error("Error Validación");
			}
			if (e.estado == 1) {
				alertify.success("Cambio de estado Inscrito");
				refrescartabla();
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