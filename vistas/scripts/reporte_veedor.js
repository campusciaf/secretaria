var variableglobal_id_docente;
$(document).ready(init);


var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
var f = new Date();
var fecha = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
function init() {

	listar();
	$("#reporteinfluencer").on("submit", function (e) {
		enviarReporte(e);
	});
}

function listar() {
	$.post("../controlador/reporte_veedor.php?op=listar", { }, function (data, status) {
		// console.log(data);
		data = JSON.parse(data);
		$("#tllistado").hide();	// ocultamos los pea
		
		$("#tbllistado").html("");
		$("#tbllistado").append(data["0"]["0"]);
		$('#tabla_reporte_veedor').DataTable({
			"paging": false,
			"scrollX": false,
			"order": [[0, 'asc']],
			'dom':'Bfrtip',
			"buttons": [{
				"extend": 'excelHtml5',
				"text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				"titleAttr": 'Excel'
			}, {
				"extend": 'print',
				"text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				"messageTop": '<div style="width:50%;float:left">Reporte perfil reporte_veedor<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
				"title": 'Materias Matriculadas',
				"titleAttr": 'Print'
			},
			
			],

		});
		$("#precarga").hide();

	});
}



function listar_estudiantes(ciclo, nombre_materia,jornada, id_programa,grupo,id_docente) {
	variableglobal_id_docente=id_docente;
	$.post("../controlador/reporte_veedor.php?op=listar_estudiantes", { "ciclo": ciclo, "nombre_materia": nombre_materia, "jornada": jornada, "id_programa": id_programa, "grupo": grupo, "id_docente": id_docente }, function (data, status) {
		// console.log(data);
		data = JSON.parse(data);
		$("#tbllistado").hide();
		$("#listar_estudiantes").show();
		$("#listar_estudiantes").html("");
		$("#listar_estudiantes").append(data["0"]["0"]);
		$('#tabla_listar_estudiantes').DataTable({
			"paging": false,
			"scrollX": false,
			"order": [[0, 'asc']],
			'dom':'Bfrtip',
			"buttons": [{
				"extend": 'excelHtml5',
				"text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				"titleAttr": 'Excel'
			}, {
				"extend": 'print',
				"text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				"messageTop": '<div style="width:50%;float:left">Reporte perfil reporte_veedor<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
				"title": 'Materias Matriculadas',
				"titleAttr": 'Print'
			},
			
			],

		});
		$("#precarga").hide();

	});
}

function volver() {
	$("#tbllistado").show();
	$("#listar_estudiantes").hide();
	
}
	function reporteInfluencer(id_estudiante, id_programa, id_materia,id_credencial) {
		$("#modalReporteInfluencer").modal("show");
		$("#id_estudiante_in").val(id_estudiante);
		$("#id_docente_in").val(variableglobal_id_docente);
		$("#id_programa_in").val(id_programa);
		$("#id_materia_in").val(id_materia);
		$("#id_credencial_in").val(id_credencial);
		$("#precarga").hide();
	}
	//Función Listar
	// //function enviarReporte(e) {
	// 	e.preventDefault();
	// 	//$("#btnVerificar").prop("disabled",true);
	// 	var formData = new FormData($("#reporteinfluencer")[0]);
	// 	$.ajax({
	// 		"url": "../controlador/reporte_veedor.php?op=reporteveedor",
	// 		"type": "POST",
	// 		"data": formData,
	// 		"contentType": false,
	// 		"processData": false,
	// 		success: function (datos) {
	// 			console.log(datos);
	// 			datos = JSON.parse(datos);
	// 			if (datos["0"] == "ok") {
	// 				alertify.success("Reporte enviado");
	// 				$("#modalReporteInfluencer").modal("hide");
	// 			} else {
	// 				alertify.error('No se pudo crear el reporte');
	// 			}
	// 		},
	// 	});
//}

function enviarReporte(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#reporteinfluencer")[0]);
	$.ajax({
		"url": "../controlador/reporte_veedor.php?op=reporteveedor",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			console.log(datos);
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Reporte realizado",
				showConfirmButton: false,
				timer: 1500
			});
			
			$("#modalReporteInfluencer").modal("hide");
			
			// refrescartabla();

		}
	});

	
}






