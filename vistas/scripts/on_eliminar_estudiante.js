$(document).ready(inicio);
var estado = "Preinscrito";
var cedula_global;
function inicio() {

	$("#precarga").hide();
	$("#input_dato").show();
	$("#dato").prop("disabled", true);


	// $("#moverUsuario").on("submit", function (e4) {
	// 	guardarMoverUsuario(e4);
	// });




	// $("#cambioDocumento").on("submit", function (e3) {
	// 	guardarCambioDocumento(e3);
	// });


	// $("#form_soporte").on("submit", function (e2) {
	// 	e2.preventDefault();
	// 	guardarsoporte();
	// });

	// $("#form_soporte_digitales1").on("submit", function (e2) {
	// 	e2.preventDefault();
	// 	guardarsoporte_digitales1();
	// });
	// $("#form_soporte_digitales2").on("submit", function (e2) {
	// 	e2.preventDefault();
	// 	guardarsoporte_digitales2();
	// });
	// $("#form_soporte_digitales3").on("submit", function (e2) {
	// 	e2.preventDefault();
	// 	guardarsoporte_digitales3();
	// });
	// $("#form_soporte_digitales4").on("submit", function (e2) {
	// 	e2.preventDefault();
	// 	guardarsoporte_digitales4();
	// });
	// $("#form_soporte_digitales5").on("submit", function (e2) {
	// 	e2.preventDefault();
	// 	guardarsoporte_digitales5();
	// });

	// $("#form_soporte_compromiso").on("submit", function (e2) {
	// 	e2.preventDefault();
	// 	guardarsoporte_compromiso();
	// });

	// $("#form_soporte_proteccion_datos").on("submit", function (e2) {
	// 	e2.preventDefault();
	// 	guardarsoporte_proteccion_datos();
	// });

	// Webcam.set({
	// 	width: 320,
	// 	height: 240,
	// 	image_format: 'jpeg',
	// 	jpeg_quality: 90
	// });
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
				title: 'Panel de control',
				intro: 'Bienvenido a nuestro panel de control donde podrás encontrar toda la información desde el día uno de nuestro ser creativo'
			},
			{
				title: 'Buscar cliente',
				element: document.querySelector('#t-CL'),
				intro: "Aquí podrás realizar tu busqueda con diferentes opciones seleccionando la que realmente necesites"
			},
			{
				title: 'Nombre completo',
				element: document.querySelector('#t-NC'),
				intro: "Una vez la busqueda sea exitosa tendrás el nombre completo de nuestro ser creativo"
			},
			{
				title: 'Correo electrónico',
				element: document.querySelector('#t-Ce'),
				intro: "Aquí podrás visualizar el correo institucional de nuestro ser creativo "
			},
			{
				title: 'Número telefonico',
				element: document.querySelector('#t-NT'),
				intro: "Da un vistazo a el número teléfono de nuestro ser creativo"
			},
			{
				title: 'Información',
				element: document.querySelector('#t-TP'),
				intro: "Aquí podrás observar la información de nuestro ser creativo sobre la experiencia creativa de su elección"
			},
			{
				title: 'Caso',
				element: document.querySelector('#t-Cs'),
				intro: "Observa el número de caso correspondiente a nuestro ser creativo, con este número podrás realizar la busqueda inicial"
			},
			{
				title: 'Programa',
				element: document.querySelector('#t-P'),
				intro: "Aquí podrás visualizar el programa al que pertenece nuestro ser creativo "
			},
			{
				title: 'Jornada',
				element: document.querySelector('#t-Jr'),
				intro: "Da un vistazo de la jornada elegida por nustro ser original para vivir todas sus experiencias craetivas"
			},
			{
				title: 'Fecha ingresa',
				element: document.querySelector('#t-FI'),
				intro: "Conoce la fecha en la que se convertió en parte de esta famiia y se nombró como ser creativo"
			},
			{
				title: 'Medio',
				element: document.querySelector('#t-ME'),
				intro: "Conoce su forma de contactarnos y como empezó su proceso para unirse a est gran familia creativa e innovadora"
			},
			{
				title: 'Estado',
				element: document.querySelector('#t-ES'),
				intro: "visualiza el estado actual de nuestro ser creativo en nuestra institución"
			},
			{
				title: 'Periodo de campaña',
				element: document.querySelector('#t-PC'),
				intro: "Aquí podrás ver en cual periodo de campaña se realizó el proceso de nuestro ser creativo"
			},
			{
				title: 'Acciones',
				element: document.querySelector('#t-AC'),
				intro: 'En un click podrás visualizar de manera más detallada la información de nuestro ser creativo teniendo en cuenta que podrás editar algún dato correspondiente a la información <button class="btn btn-primary"><i class="fa fa-eye"></i></button>'
			},



		]

	},

	).start();

}

function iniciarSegundoTour() {
	introJs().setOptions({
		nextLabel: 'Siguiente',
		prevLabel: 'Anterior',
		doneLabel: 'Terminar',
		showBullets: false,
		showProgress: true,
		showStepNumbers: true,
		steps: [
			{
				title: 'Configuración cliente',
				intro: 'Aquí es donde ocurre la magia y podrás editar algunos datos de nuestro ser creativo'
			},
			{
				title: 'Caso',
				element: document.querySelector('#t2-Cas'),
				intro: "visualiza mejor el número de caso de nuestro ser creativo"
			},
			{
				title: 'Campaña',
				element: document.querySelector('#t2-Cam'),
				intro: "Visualiza el periodo de campaña de nuestro ser creativo"
			},
			{
				title: 'Estado',
				element: document.querySelector('#t2-EST'),
				intro: "visualiza el estado actual de nuestro ser creativo"
			},
			{
				title: 'Proceso de admisiones',
				element: document.querySelector('#t2-CP'),
				intro: "Aquí podrás editar los datos personales de nuestro ser creativo"
			},
			{
				title: 'Tomar foto',
				element: document.querySelector('#t2-tf'),
				intro: "Tendrás la opción de agregar una foto de nuestro ser creativo a su registro con nosostros"
			},
			{
				title: 'Seguimiento',
				element: document.querySelector('#t2-seg'),
				intro: "Aquí podrás agregar un nuevo seguimiento y visualizar los anteriores"
			},
			{
				title: 'ver historial',
				element: document.querySelector('#t2-vh'),
				intro: "Da un vistazo a el historial general de nuestro ser creativo"
			},
			{
				title: 'Cambiar de estado',
				element: document.querySelector('#t2-cd'),
				intro: "Aquí podrás cambiar de estado a nuestro ser creativo en este caso lo podemos visualizar como matriculado"
			},
			{
				title: 'Ver ficha completa',
				element: document.querySelector('#t2-vfc'),
				intro: "Da un vistazo a toda la información general de nuestro ser creativo"
			},
			{
				title: 'Eliminar',
				element: document.querySelector('#t2-el'),
				intro: "podrás eliminar todos los registros de nuestro ser creatvo de ser necesario"
			},
			{
				title: 'Proceso',
				element: document.querySelector('#t2-pro'),
				intro: "Da un vistazo a todas las categorias disponibles en todo el proceso de nuestro ser creativo"
			},
			{
				title: 'Estado',
				element: document.querySelector('#t2-st'),
				intro: "Aquí encontrarás las diferentes funciones para cada categoria de el procesop de nuestro ser creativo"
			},
		]
	},
	).start();
}


function muestra(valor) {
	$("#dato").prop("disabled", false);
	$("#btnconsulta").prop("disabled", false);
	$("#input_dato").show();
	var tipo = $("#tipo").val(valor);
	if (valor == 1) {
		$("#valortitulo").html("Ingresar número de identificacíon")
	}
	if (valor == 2) {
		$("#valortitulo").html("Ingresar número de caso")
	}
	if (valor == 3) {
		$("#valortitulo").html("Ingresar número de tel/cel")
	}
}
function consultacliente() {
	var dato = $("#dato").val();
	cedula_global = dato;
	var tipo = $("#tipo").val();
	if (dato != "" && tipo != "") {
		$.post("../controlador/on_eliminar_estudiante.php?op=consultacliente", { dato: dato, tipo: tipo }, function (datos) {
			var r = JSON.parse(datos);
			if (r.status != "error") {
				$("#datos_estudiante").html(r.conte2);
				$("#datos_estudiante").show();
				$(".datos_table").html(r.conte);
				var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
				var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
				var f = new Date();
				var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
				$("#tbl_datos").DataTable({
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
					"bDestroy": true,
					"iDisplayLength": 20,//Paginación
					'initComplete': function (settings, json) {
						$("#precarga").hide();
						// volver();
					},
				});
			} else {
				alertify.error("No se encontre ningun dato con esa referencia.");
			}
		});
	} else {
		alertify.error("Por favor completa los campos.");
	}
}

function on_eliminar_estudiante(id_estudiante) {

	alertify.confirm('Eliminar Estudiante', '¿Está Seguro de eliminar el Estudiante?', function () {
		$.post("../controlador/on_eliminar_estudiante.php?op=on_eliminar_estudiante", { id_estudiante: id_estudiante}, function (e) {
			var r = JSON.parse(e);
			if (r.status == 'ok') {
				consultacliente();
				alertify.success("Estudiante eliminado con exito.");
			}
			else {
				alertify.error("Error al eliminar el Estudiante.");
			}
		});
	}
		, function () { alertify.error('Cancelado') });
}







