var tabla;

//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	Listar();
	$("#formulario_crearyeditarofertaslaborales").on("submit", function (e) {
		guardaryeditareditarempresa(e);
	});

	
}

function mostrarform(flag) {
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
	} else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}
function cancelarform() {
	limpiar();
	mostrarform(false);
}


function Listar() {
	var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
	var diasSemana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
	var f = new Date();
	var fecha_hoy = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();

	tabla = $("#tblistaofertalaboral").dataTable({
		aProcessing: true,
		aServerSide: true,
		dom: "Bfrtip",
		language: {
			url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
			emptyTable: "No hay estudiantes que hayan cumplido las 40 horas."
		},
		buttons: [
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Exportar a Excel"
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left"><b>Asesor:</b> primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Reporte Estudiantes con 40+ horas",
				titleAttr: "Imprimir"
			}
		],
		ajax: {
			url: "../controlador/certificado_est.php?op=Listar",
			type: "get",
			dataType: "json",
			error: function (e) {
				console.error("Error al cargar los datos:", e.responseText);
			}
		},
		bDestroy: true,
		iDisplayLength: 10,
		order: [[4, "desc"]],
		initComplete: function (settings, json) {
			$("#precarga").hide();
		}
	});
}









function iniciarTour() {
	introJs()
		.setOptions(
			{
				nextLabel: "Siguiente",
				prevLabel: "Anterior",
				doneLabel: "Terminar",
				showBullets: false,
				showProgress: true,
				showStepNumbers: true,
				steps: [
					{
						title: "Usuarios",
						intro:
							"Bienvenido a nuestra gestión de usuarios que hacen parte de nuestra comunidad CIAF"
					}
				]
			},
		)
		.start();


		
}



init();
