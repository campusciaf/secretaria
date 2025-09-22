var id_ = "";
var ciclo_ = "";
var materia_ = "";
var jornada_ = "";
var id_programa = "";
var grupo = "";
var ciclo_h = "";
var huella_homologacion = "";
var api; // variable global para inicializar el responsive
var anchoVentana = window.innerWidth; // ancho de la ventana
//Función que se ejecuta al inicio
function init() {
	listarMotivos();
	listargrupos();
	$("#reporteinfluencer").on("submit", function (e) {
		enviarReporte(e);
	});
}
function iniciarTour() {
	introJs().setOptions({
		"nextLabel": 'Siguiente',
		"prevLabel": 'Anterior',
		"doneLabel": 'Terminar',
		"showBullets": false,
		"showProgress": true,
		"showStepNumbers": true,
		"steps": [{
			"title": 'Lista de grupos',
			"intro": 'Bienvenido donde sucede la magia de lista de grupos,donde podrás construir las experiencias junto a tus seres originales a tu cargo'
		},
		{
			"title": 'programa',
			"element": document.querySelector('#t-paso1'),
			"intro": "Aquí podrás encontrar el nombre de el programa que te han asignado"
		},
		{
			"title": 'Asignatura',
			"element": document.querySelector('#t-paso2'),
			"intro": "Enterate de la asignatura a tu cargo, ideando experiencias nuevas para nuestros seres originales"
		},
		{
			"title": 'Jornada',
			"element": document.querySelector('#t-paso3'),
			"intro": "Hecha un vistazo a la jornada donde comienza tu lazo de experiencias con nuestros seres originales"
		}, {
			"title": 'Semestre',
			"element": document.querySelector('#t-paso4'),
			"intro": "Conoce el semestre de los seres originales, los cuales vas a guiar por el mundo del conocimiento"
		}, {
			"title": 'Horario',
			"element": document.querySelector('#t-paso5'),
			"intro": "Administra bien tu tiempo teniendo en cuenta el horario donde comienza la experiencia creativa"
		}, {
			"title": 'Salón',
			"element": document.querySelector('#t-paso6'),
			"intro": "Enterate de tu salón asignado donde te reunirás con tu respectivo grupo comenzando con la magia de la experiencia creativa"
		}, {
			"title": 'Acciones',
			"element": document.querySelector('#t-paso7'),
			"intro": "Aquí podrás encontrar difentres aliados para conocer no solo a nuestros seres originales,también a tus respectivas asignaturas comenzando asi una experiencia conjunta "
		},
		{
			"title": 'Listar grupos',
			"element": document.querySelector('#b-paso8'),
			"intro": "Conoce más a las personas bajo tu enseñanza creativa, en tu lista de grupo con alguna información de nuestros seres originales"
		}, {
			"title": 'Gestión PEA',
			"element": document.querySelector('#b-paso9'),
			"intro": "Apoyate revisando nuestro material PEA digirido para ti y tus respectivas asignaturas donde conocerás un poco más de ellas y continuando así con una experencia de aprendizaje no solo para nuestros seres originales si no también para nuestros docentes"
		}]
	},
	).start();
	console.log("holaaa");
}
function iniciarSegundoTour() {
	introJs().setOptions({
		"nextLabel": 'Siguiente',
		"prevLabel": 'Anterior',
		"doneLabel": 'Terminar',
		"showBullets": false,
		"showProgress": true,
		"showStepNumbers": true,
		"steps": [{
			"title": 'Listado de grupo',
			"intro": 'Aquí es donde podrás encontrar la información de nuestros seres originales, donde le asignaras sus respectivas notas a cada uno entre otras funciones interesantes que tenemos para ti '
		},
		{
			"title": 'Opciones',
			"element": document.querySelector('#t2-paso1'),
			"intro": "Encontraras diferentes opciones con las que puedes apoyarte y así poder cumplir con la promesa de venta del estudiante que es el grado"
		},
		{
			"title": 'Esta activo',
			"element": document.querySelector('#t2-paso2'),
			"intro": "Verifica el estado de nuestros seres originales, esta columna indica que nuestro ser original tiene o no acceso a la plataforma virtual"
		},
		{
			"title": 'caracterizado',
			"element": document.querySelector('#t2-paso3'),
			"intro": "Opción que te permite visualizar si el estudiante realizó la caracterización estudiantil, recuerda que es de vital importancia conocer a nuestros seres originales para desarrollar todas nuestras estrategias de bienestar, mercadeo y extensión"
		},
		{
			"title": 'Calendario',
			"element": document.querySelector('#t2-paso4'),
			"intro": "Encuentra información más detallada e individual sobre nuestros originales sobre las asignaturas, docente a cargo y su respectivo horario donde comienza la experiencia creativa más grande del eje cafero"
		},
		{
			"title": 'Reporte influencer',
			"element": document.querySelector('#t2-paso5'),
			"intro": "Diligencia una novedad si es necesario sobre algún ser original, de manera indivual envia el reporte y haz que crezca mucho más como persona y en conocimiento ayudándolo así a ser más creativo(a) e innovador(a)"
		},
		{
			"title": 'Identificación',
			"element": document.querySelector('#t2-paso6'),
			"intro": "Información única de los seres originales a tu cargo"
		},
		{
			"title": 'Foto',
			"element": document.querySelector('#t2-paso7'),
			"intro": "Conoce y reconoce a tus seres originales por su foto de perfil y si no cuentan con una tendrás que esperar a que comiencen las clases para conocerlos"
		},
		{
			"title": 'Apellidos',
			"element": document.querySelector('#t2-paso8'),
			"intro": "Información de nuestros seres orginales que te servira de gran ayuda"
		},
		{
			"title": 'Nombres	',
			"element": document.querySelector('#t2-paso9'),
			"intro": "El nombre dice mucho de nosotros, aprende a identificar a cada uno de nuestros seres originales dando un vistazo a esta información y recordando quien es cada original"
		},
		{
			"title": 'Faltas',
			"element": document.querySelector('#t2-paso10'),
			"intro": "Aquí podrás reportar las faltas de tus seres originales aclarando el motivo de su ausencia y con un solo click registrar su falta "
		},
		{
			"title": 'Cortes',
			"element": document.querySelector('#t2-paso11'),
			"intro": "Como podrás ver tenemos tres cortes donde tendrás que asignar las diferentes notas que hayan salido de todas las experiencias creativas que compartiste con nuestros seres originales"
		},
		{
			"title": 'Final',
			"element": document.querySelector('#t2-paso12'),
			"intro": "Aquí podrás apreciar la nota final de cada uno de nuestros seres originales teniendo en cuenta los cortes anteriores"
		},
		{
			"title": 'Enviar Mensajes',
			"element": document.querySelector('#t2-paso13'),
			"intro": " Encontrarás la sección donde te pones en contacto con nuestros seres originales y le podrás notificar todo al respecto de la experiencia creativa que esta por vivir hombro a hombro contigo, este mensaje será notificado a tu cuenta de correo CIAF"
		}, {
			"title": 'Datos de contacto',
			"element": document.querySelector('#t2-paso14'),
			"intro": "Hallarás más información de nuestros seres originales como su correo institucional,personal y número de contacto"
		}, {
			"title": 'Reporte Final',
			"element": document.querySelector('#t2-paso15'),
			"intro": "Una información más general de lo que se ha vivido académicamente a través de esta mágica experiencia creativa, este reporte solo lo descargaras el dia en que termino la experiencia creativa en clase, para ser firmado y enviado a registro y control. "
		},
		{
			"title": 'volver',
			"element": document.querySelector('#t2-paso16'),
			"intro": "Retrocede en el tiempo del campus y vuelve a tu información general de lista de grupos originales"
		}]
	}).start();
}
//Función Listar
function listargrupos() {
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
	tabla = $("#tbllistadogrupos").dataTable({
		"aProcessing": true, //Activamos el procesamiento del datatables
		"aServerSide": true, //Paginación y filtrado realizados por el servidor
		"dom": "Bfrtip", //Definimos los elementos del control de tabla
		"buttons": [{
			"extend": "excelHtml5",
			"text": '<i class="fa fa-file-excel" style="color: green"></i>',
			"titleAttr": "Excel",
		}, {
			"extend": "print",
			"text": '<i class="fas fa-print" style="color: #ff9900"></i>',
			"messageTop": '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
			"title": "Ejes",
			"titleAttr": "Print",
		}],
		"ajax": {
			"url": "../controlador/docentegruposanterior.php?op=listargrupos",
			"type": "get",
			"dataType": "json",
			error: function (e) {
			},
		},
		"bDestroy": true,
		"initComplete": function (settings, json) {
			$("#precarga").hide();
		}
	});
}
//funciona para regresar
function volver() {
	$(".primer_tour").removeClass("d-none");
	$(".segundo_tour").addClass("d-none");
	$("#listadoregistrosgrupos").show();
	$("#tbllistado").hide();
	$("#nombre_materia").html("");
}
//lista los estudiatnes de ese grupo y grupos especiales
function listar(id_docente_grupo) {
	$(".primer_tour").addClass("d-none");
	$(".segundo_tour").removeClass("d-none");
	$("#table-responsive").hide();
	$("#listadoregistrosgrupos").hide();
	$("#precarga").show();
	$.get(
		"../controlador/docentegruposanterior.php?op=listar",
		{ "id_docente_grupo": id_docente_grupo },
		function (data, status) {
			data = JSON.parse(data);
			$("#tllistado").hide(); // ocultamos los pea
			$(document).ready(function () {
				$("#example").DataTable({
					"paging": false,
					"searching": false,
					"scrollX": false,
					"order": [[3, "asc"]],
					"autoWidth": false,
					"dom":
						"<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'<'float-md-right ml-2'B>f>>" +
						"<'row'<'col-sm-12'tr>>" +
						"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
					"buttons": [],
				});
			});
			$("#tbllistado").html("");
			$("#tbllistado").append(data["0"].datos1);
			$("#nombre_materia").html(data["0"].datos2);
			$("#tbllistado").show();
			$("#precarga").hide();
			$(".tooltips").tooltip();
		}
	);
}
function modalFalta(id_credencial, id_docente_grupo, ciclo, id_estudiante, id_programa, id_materia) {
	$("#id_credencial").val(id_credencial);
	$("#id_docente_grupo").val(id_docente_grupo);
	$("#ciclo").val(ciclo);
	$("#id_estudiante").val(id_estudiante);
	$("#id_programa").val(id_programa);
	$("#id_materia").val(id_materia);
	listarFaltas(id_estudiante, id_materia, ciclo)
	$("#modalFaltas").modal("show");
}
function listarFaltas(id_estudiante, id_materia, ciclo) {
	$("#tbfaltas").dataTable({
		"aProcessing": true, //Activamos el procesamiento del datatables
		"aServerSide": true, //Paginación y filtrado realizados por el servidor
		"dom": "", //Definimos los elementos del control de tabla
		"ajax": {
			"url": "../controlador/docentegruposanterior.php?op=listarFaltas",
			"data": { "id_estudiante": id_estudiante, "id_materia": id_materia, "ciclo": ciclo },
			"type": "post",
			"dataType": "json",
			error: function (e) {
				console.log(e);
			},
		},
		"bDestroy": true,
		"initComplete": function (settings, json) {
			$("#precarga").hide();
		},
	});
}
//Función para activar registros
function eliminarFalta(falta_id, id_estudiante, id_materia, ciclo) {
	alertify.confirm("Eliminar inasistencia", "¿Desea eliminar esta inasistencia?", function () {
		$.post("../controlador/docentegruposanterior.php?op=eliminarFalta", { "falta_id": falta_id, "ciclo": ciclo, "id_materia": id_materia }, function (datos) {
			datos = JSON.parse(datos);
			if (datos.status == 1) {
				alertify.success("Inasistencia eliminada");
				listarFaltas(id_estudiante, id_materia, ciclo);
				listar($("#id_docente_grupo").val());
			} else {
				alertify.error("Error");
			}
		});
	}, function () { alertify.error('Cancelado') });
}
function registraFalta() {
	motivo_falta = $("#motivo_falta").val();
	if (motivo_falta == "") {
		$("#motivo_falta").css("border-color", "#dc3545");
		alertify.error("Seleccionar motivo de falta");
	} else {
		id_credencial = $("#id_credencial").val();
		id_docente_grupo = $("#id_docente_grupo").val();
		ciclo = $("#ciclo").val();
		id_estudiante = $("#id_estudiante").val();
		id_programa = $("#id_programa").val();
		id_materia = $("#id_materia").val();
		var dateObj = new Date();
		var month = dateObj.getUTCMonth() + 1;
		var day = dateObj.getUTCDate();
		var year = dateObj.getUTCFullYear();
		fecha_actual = year + "-" + month + "-" + (day < 10 ? 0 : "") + day;
		$.ajax({
			"url": "../controlador/docentegruposanterior.php?op=aggfalta",
			"type": "POST",
			"data": { "id_credencial": id_credencial, "id_docente_grupo": id_docente_grupo, "ciclo": ciclo, "id_estudiante": id_estudiante, "id_programa": id_programa, "id_materia": id_materia, "programa": $("#materia").val(), "fecha": fecha_actual, "motivo_falta": motivo_falta },
			"dataType": "json",
			success: function (r) {
				var id_docente_grupo = r.id_docente_grupo;
				if (r.tienefalta == 1) {
					alertify.error("El estudiante ya cuenta con esa falta");
				} else {
					alertify.success("Falta registrada");
					listar(id_docente_grupo);
					listarFaltas(id_estudiante, id_materia, ciclo);
				}
			},
			error: function (e) {
				console.log(e);
			},
		});
	}
}
//Función ver contacto estudiantes
function consultaContacto(ciclo, jornada, id_programa, grupo, materia) {
	$("#precarga").show();
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#listadocontacto').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		"dom": 'Bfrtip',//Definimos los elementos del control de tabla
		"buttons": [{
			"extend": 'excelHtml5',
			"text": '<i class="fa fa-file-excel" style="color: green"></i>',
			"titleAttr": 'Excel'
		}, {
			"extend": 'print',
			"text": '<i class="fas fa-print" style="color: #ff9900"></i>',
			"messageTop": '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
			"title": 'Renovaciones',
			"titleAttr": 'Print'
		}],
		"ajax": {
			"url": '../controlador/docentegruposanterior.php?op=consultaContacto&ciclo=' + ciclo + '&jornada=' + jornada + '&id_programa=' + id_programa + '&grupo=' + grupo + '&materia=' + materia,
			"type": "get",
			"dataType": "json",
			error: function (e) {
				console.log(e);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [[1, "asc"]],
		'initComplete': function (settings, json) {
			$("#modalReportes").modal("show");
			$("#precarga").hide();
		}
	});
}
function consulta(ciclo, jornada, id_programa, grupo, medio) {
	var data = {
		"ciclo": ciclo,
		"materia": $("#materia").val(),
		"jornada": jornada,
		"id_programa": id_programa,
		"grupo": grupo,
		"medio": medio,
	};
	$("#modalReportes").modal("show");
	if ($.fn.DataTable.isDataTable("#tbl_listar")) {
		$("#tbl_listar").DataTable().destroy();
	}
	$.ajax({
		"url": "../controlador/docentegruposanterior.php?op=consultaEstudiante",
		"type": "POST",
		"data": data,
		"dataType": "json",
		success: function (datos) {
			var r = JSON.parse(datos);
			$(".prueba").html(r.table);
			//$(document).ready(function (){
			$("#tbl_listar").dataTable({
				"paging": true,
				"searching": false,
				"autoWidth": false,
				"dom": "Bfrtip",
				"buttons": [{
					"extend": "print",
					"text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i> ',
					"messageTop":
						'<div style="width:50%;float:left" > <b>Docente:</b> ' +
						r.docente +
						" <br/><b>Programa:</b>" +
						r.programa +
						"  <br/><b>Jornada: </b>" +
						r.jornada +
						" <br/><b>Asignatura: </b>" +
						r.materia +
						" <br/><b>Fecha reporte: </b>" +
						r.fecha +
						' <br/>  <br/> </div> <div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="280px"></div>',
					"title": " Horarios asignados fin de semana",
					"titleAttr": "Imprimir",
				}],
				"order": [[1, "asc"]],
			});
		},
	});
}
function consultaAsistecia(ciclo, jornada, id_programa, grupo, medio) {
	var data = {
		ciclo: ciclo,
		materia: $("#materia").val(),
		jornada: jornada,
		id_programa: id_programa,
		grupo: grupo,
		medio: medio,
	};
	$("#modalReportes").modal("show");
	if ($.fn.DataTable.isDataTable("#tbl_listar")) {
		$("#tbl_listar").DataTable().destroy();
	}
	$.ajax({
		url: "../controlador/docentegruposanterior.php?op=consultaEstudiante",
		type: "POST",
		data: data,
		cdataType: "json",
		success: function (datos) {
			var r = JSON.parse(datos);
			$(".prueba").html(r.table);
			$(document).ready(function () {
				$("#tbl_listar").dataTable({
					paging: true,
					searching: false,
					autoWidth: false,
					dom: "Bfrtip",
					buttons: [
						{
							extend: "print",
							text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
							messageTop:
								'<div style="width:50%;float:left" > <b>Docente:</b> ' +
								r.docente +
								" <br/><b>Programa:</b>" +
								r.programa +
								"  <br/><b>Jornada: </b>" +
								r.jornada +
								" <br/><b>Asignatura: </b>" +
								r.materia +
								" <br/><b>Fecha reporte: </b>" +
								r.fecha +
								' <br/>  <br/> </div> <div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="280px"></div>',
							title: " Horarios asignados fin de semana",
							titleAttr: "Imprimir",
						},
					],
				});
			});
		},
	});
}
function consultaReporteFinal(id_docente, ciclo, materia, jornada, id_programa, grupo, semestre) {
	var data = { id_docente: id_docente, ciclo: ciclo, materia: materia, jornada: jornada, id_programa: id_programa, grupo: grupo };
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
	$("#modalReporteFinal").modal("show");
	if ($.fn.DataTable.isDataTable("#tbl_listar")) {
		$("#tbl_listar").DataTable().destroy();
	}
	$.ajax({
		"url": "../controlador/docentegruposanterior.php?op=consultaReporteFinal",
		"type": "POST",
		"data": data,
		"cdataType": "json",
		success: function (datos) {
			var r = JSON.parse(datos);
			$("#prueba").html(r.table);
			$(document).ready(function () {
				$("#tbl_listar").dataTable({
					"paging": true,
					"searching": false,
					"autoWidth": false,
					"dom": "Bfrtip",
					"buttons": [
						{
							"extend": "print",
							"text": '<div class="row"><div class="col-12"><div class="row align-items-center"><div class="col-3"><span class="rounded bg-light-orange p-3 text-orange"><i class="fa-solid fa-print"></i></i></span> </div><div class="col-9 line-height-18 text-left pl-4"><span class="text-left titulo-2 fs-12 line-height-16">Imprimir aquí</span> <br><span class="titulo-2 text-semibold fs-18 line-height-18">Reporte Final</span></div></div></div></div>',
							"messageTop":
								'<div style="width:50%;float:left" > <b>Docente:</b> ' +
								r.docente +
								" <br/><b>Programa:</b>" +
								r.programa +
								"  <br/> <b>Semestre: </b>" +
								semestre +
								" <br/><b>Jornada: </b>" +
								jornada +
								" <br/><b>Asignatura: </b>" +
								materia +
								" <br/><b>Fecha reporte: </b>" +
								fecha +
								' <br/>  <br/> </div> <div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="280px"></div>',
							messageBottom:
								"<br><br><br><br>___________________________________<br>Firma Docente ",
							title: "Reporte final Notas",
							titleAttr: "Imprimir",
						},
					],
					order: [[1, "asc"]], //Ordenar (columna,orden)
				});
			});
		},
	});
}
function enviarCorreos(ciclo, jornada, id_programa, grupo) {
	$("#enviarEmail").off("click").on("click", function () {
		$("#enviarEmail").html("Cargando ...");
		$("#enviarEmail").attr("disabled", true);
		var data = { ciclo: ciclo, materia: $("#materia").val(), jornada: jornada, id_programa: id_programa, grupo: grupo, contenido: $("#conteMail").val() };
		$.ajax({
			"url": "../controlador/docentegruposanterior.php?op=enviarCorreos",
			"type": "POST",
			"data": data,
			"dataType": "json",
			success: function (datos) {
				$("#enviarEmail").html("Enviar");
				$("#enviarEmail").attr("disabled", false);
				if (datos.result == "ok") {
					$("#modalEmail").modal("hide");
					$("#conteMail").val("");
				}
			},
			error: function (e) {
			}
		});
	});
}
function nota(id, nota, tl, c, id_programa, id_docente_grupo) {
	if (nota.length <= 4) {
		if (nota <= 5.0 && nota >= 0) {
			$.post("../controlador/docentegruposanterior.php?op=nota", { "id": id, "nota": nota, "tl": tl, "c": c, "pro": id_programa, "id_docente_grupo": id_docente_grupo },
				function (data) {
					console.log(data);
					var r = JSON.parse(data);
					if (r.status == "ok") {
						alertify.success("Nota agregada con exito");
						listar(id_docente_grupo);
					} else {
						alertify.error("Error al agregar la nota");
					}
				}
			);
		} else {
			alertify.error("Coloca una nota valida");
		}
	} else {
		alertify.error("Coloca una nota valida");
	}
}
//dividir un estring
function dividirCadena(cadenaADividir, separador) {
	arrayDeCadenas = cadenaADividir.split(separador);
	return arrayDeCadenas[1];
}
//fecha actual
function hoyFecha() {
	hoy = new Date();
	dd = hoy.getDate();
	mm = hoy.getMonth() + 1;
	yyyy = hoy.getFullYear();
	dd = addZero(dd);
	mm = addZero(mm);
	fecha = dd + "/" + mm + "/" + yyyy;
	$("#fecha").val(fecha);
}
//Listar categorias de casos
function listarMotivos() {
	$.post("../controlador/docentegruposanterior.php?op=listarMotivos", function (datos) {
		datos = JSON.parse(datos);
		if (datos.status == '0') {
			alertify.error(datos.info);
		} else {
			html = '<option value="" > -- Selecciona una opción -- </option>';
			for (i = 0; i < datos.info.length; i++) {
				html += '<option value="' + datos.info[i] + '">' + datos.info[i] + '</option>';
			}
			$("#motivo_falta").html(html);
		}
	});
}
function horarioEstudiante(id, ciclo, id_programa, grupo) {
	$("#precarga").show();
	$.post("../controlador/docentegruposanterior.php?op=horarioestudiante", { id: id, ciclo: ciclo, id_programa: id_programa, grupo: grupo }, function (data, status) {
		data = JSON.parse(data);
		$("#modalHorarioEstudiante").modal("show");
		$("#horarioestudiante").show();
		$("#horarioestudiante").html("");
		$("#horarioestudiante").append(data["0"]["0"]);
		$("#precarga").hide();
		$("#calendar").hide();
	});
}
function iniciarcalendario(id_estudiante, ciclo, id_programa, grupo) {
	$("#titulo").show();
	$("#horarioestudiante").hide();
	$("#calendar").show();
	var calendarEl = document.getElementById('calendar');
	var calendar = new FullCalendar.Calendar(calendarEl, {
		initialView: 'timeGridWeek',
		locales: 'es',
		slotMinTime: "06:00:00",
		slotMaxTime: "24:00:00",
		headerToolbar: {
			left: '',
			center: '',
			right: ''
		},
		slotLabelFormat: {
			hour: '2-digit',
			minute: '2-digit',
			hour12: true,
			meridiem: 'short',
		},
		eventTimeFormat: {
			hour: '2-digit',
			minute: '2-digit',
			hour12: true
		},
		events: "../controlador/docentegruposanterior.php?op=iniciarcalendario&id_estudiante=" + id_estudiante + "&ciclo=" + ciclo + "&id_programa=" + id_programa + "&grupo=" + grupo,
		eventClick: function (info) {
			$('#modalTitle').html(info.event.title);
			$('#modalDia').html(info.event.daysOfWeek);
		},
	});
	calendar.render();
}
function activarPea(id_docente_grupo, id_pea) {
	alertify.confirm("Activar PEA", "¿Click en OK para activar el Proyecto educativo de aula?", function () {
		$.post("../controlador/docentegruposanterior.php?op=activarPea", { id_docente_grupo: id_docente_grupo, id_pea: id_pea }, function (data) {
			datos = JSON.parse(data);
			if (datos == "1") {
				alertify.success('PEA activado');
				init();
			} else {
				alertify.error('error');
			}
		});
	}, function () { alertify.error('Cancelado') });
}
function reporteInfluencer(id_estudiante, id_docente, id_programa, id_materia) {
	$("#modalReporteInfluencer").modal("show");
	$("#id_estudiante_in").val(id_estudiante);
	$("#id_docente_in").val(id_docente);
	$("#id_programa_in").val(id_programa);
	$("#id_materia_in").val(id_materia);
	$("#precarga").hide();
}
//Función Listar
function enviarReporte(e) {
    e.preventDefault();
    var formData = new FormData($("#reporteinfluencer")[0]);
    $.ajax({
        "url": "../controlador/docentegruposanterior.php?op=reporteinfluencer",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            datos = JSON.parse(datos);
            if (datos["0"] == "ok") {
                alertify.success("Reporte enviado");
                $("#modalReporteInfluencer").modal("hide");

                $("#reporteinfluencer")[0].reset();

            } else {
                alertify.error('No se pudo crear el reporte');
            }
        },
    });
}
function marcarAsistio(id_credencial, id_docente_grupo, ciclo, id_estudiante, id_programa, id_materia) {
	$.post("../controlador/docentegrupos.php?op=marcarAsistio", { id_credencial: id_credencial, id_docente_grupo: id_docente_grupo, ciclo: ciclo, id_estudiante: id_estudiante, id_programa: id_programa, id_materia: id_materia }, function (data) {
		datos = JSON.parse(data);
		if (datos.exito == 1) {
			alertify.success("Asistencia registrada");
			//borrar tooltip del boton dentro del div seleccion-falta_
			$(".tooltip-inner").hide();
			$(".seleccion-falta_" + id_credencial).parent().html('<span class="badge badge-success"> <i class="fas fa-check"></i> </span>');
		} else {
			alertify.error('error');
		}
	});
}
init();