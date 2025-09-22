var api, tabla; // variable global para inicializar el responsive
var anchoVentana = window.innerWidth; // ancho de la ventana
$(document).ready(init);
//Función que se ejecuta al inicio
function init() {
	listarCursosDocente();
}
//Función Listar
function listarCursosDocente() {
	$(".div_listado_estudiantes").hide();
	tabla = $("#tablaListadoCursos").dataTable({
		"aProcessing": true, //Activamos el procesamiento del datatables
		"aServerSide": true, //Paginación y filtrado realizados por el servidor
		"dom": "Bfrtip", //Definimos los elementos del control de tabla
		"buttons": [{
			"extend": "excelHtml5",
			"text": '<i class="fa fa-file-excel text-success"></i>',
			"titleAttr": "Excel",
		},{
			"extend": "print",
			"text": "<i class='fas fa-print text-orange'></i>",
			"titleAttr": "Print",
		}],
		"ajax": {
			"url": "../controlador/docente_cursos_ec.php?op=listarCursosDocente",
			"type": "get",
			"dataType": "json",
			error: function (e) {
				console.log(e.responseText);
			},
		},
		"bDestroy": true,
		"initComplete": function (settings, json) {
			$("#precarga").hide();
		},
		//funcion para cambiar el responsive del data table
		"select": "single",
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
					$(this).find("td").each(function (column) {
						$(this).attr("data-label", labels[column]);
					});
				});
				var max = 0;
				$("tbody tr", $table).each(function () {
					max = Math.max($(this).height(), max);
				}).height(max);
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
}

function iniciarTour(){
	introJs().setOptions({
		nextLabel: 'Siguiente',
		prevLabel: 'Anterior',
		doneLabel: 'Terminar',
		showBullets:false,
		showProgress:true,
		showStepNumbers:true,
		steps: [ 
			{
				title: 'Panel estudiante',
				intro: 'Módulo para consultar los horarios por salones creados en el periodo actual.'
			},
			{
				title: 'programas',
				element: document.querySelector('#m-paso1'),
				intro: ""
			},
			

		]
			
	},
	
	
	).start();


}



//funciona para regresar
function volver() {
	$("#listadoRegistrosCursos").show();
	$(".div_listado_estudiantes").hide();
}
//lista los estudiatnes de ese grupo
function listarEstudiantes(id_curso) {
	$("#listadoRegistrosCursos").hide();
	$("#precarga").show();
	listadoEstudiantes = $("#tbllistado").dataTable({
		"aProcessing": true, //Activamos el procesamiento del datatables
		"aServerSide": true, //Paginación y filtrado realizados por el servidor
		"dom": "Bfrtip", //Definimos los elementos del control de tabla
		"buttons": [{
			"text": '<i class="fas fa-arrow-circle-left "></i> <b class="">Volver</b>',
			"className": "btn-danger",
			"action": function () {
				volver();
			}
		}],
		"ajax": {
			"url": "../controlador/docente_cursos_ec.php?op=listarEstudiantes&id_curso="+id_curso,
			"type": "POST",
			"dataType": "json",
			error: function (e) {
				console.log(e.responseText);
			},
		},
		"bDestroy": true,
		"initComplete": function (settings, json) {
			$("#precarga").hide();
			$(".div_listado_estudiantes").show();
			$(".b_tooltip").tooltip();
		},
		//funcion para cambiar el responsive del data table
		"select": "single",
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
					$(this).find("td").each(function (column) {
						$(this).attr("data-label", labels[column]);
					});
				});
				var max = 0;
				$("tbody tr", $table).each(function () {
					max = Math.max($(this).height(), max);
				}).height(max);
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
}
function calificarEstudiante(estado_inscrito, id_inscrito) {
	estado = (estado_inscrito == "finalizado")?"aprobar":"reprobar";
	badge = (estado_inscrito == "finalizado")?"success":"danger";
	swal({ "title": "¿Esta seguro de "+estado+" al estudiante ?", "icon": "warning", "buttons": ["Cancelar", "Confirmar"], "dangerMode": false }).then((willUpdate) => {
		if (willUpdate) {
			$.post("../controlador/docente_cursos_ec.php?op=calificarEstudiante", { "id_inscrito": id_inscrito, "estado_inscrito": estado_inscrito }, function (e) {
				console.log(e);	
				e = JSON.parse(e);
				if (e.exito == 1) {
					swal(e.info, '', 'success');
					$(".estado_inscrito_"+id_inscrito).html('<div class="badge badge-'+badge+'">'+estado_inscrito+'</div>');
				} else {
					swal(e.info, '', 'error');
				}
			});
		} else { }
	});
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
			"url": "../controlador/docentegrupos.php?op=listarFaltas",
			"data": { id_estudiante: id_estudiante, id_materia: id_materia, ciclo: ciclo },
			"type": "post",
			"dataType": "json",
			error: function (e) {
				// console.log(e.responseText);
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
		$.post("../controlador/docentegrupos.php?op=eliminarFalta", { falta_id: falta_id, ciclo: ciclo, id_materia: id_materia }, function (datos) {
		
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
	id_credencial = $("#id_credencial").val();
	id_docente_grupo = $("#id_docente_grupo").val();
	ciclo = $("#ciclo").val();
	id_estudiante = $("#id_estudiante").val();
	id_programa = $("#id_programa").val();
	id_materia = $("#id_materia").val();
	motivo_falta = $("#motivo_falta").val();

	var dateObj = new Date();
	var month = dateObj.getUTCMonth() + 1;
	var day = dateObj.getUTCDate();
	var year = dateObj.getUTCFullYear();
	fecha_actual = year + "-" + month + "-" + (day < 10 ? 0 : "") + day;
	$.ajax({
		"url": "../controlador/docentegrupos.php?op=aggfalta",
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
				listarFaltas(id_estudiante, id_materia, ciclo)
			}
		},
		error: function (params) {
			// console.log(params.responseText);
		},
	});
}


//Función ver contacto estudiantes
function consultaContacto(ciclo,jornada,id_programa,grupo,materia){
	$("#precarga").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		
		tabla=$('#listadocontacto').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
				   buttons: [
				{
					extend:    'excelHtml5',
					text:      '<i class="fa fa-file-excel" style="color: green"></i>',
					titleAttr: 'Excel'
				},
				{
					extend: 'print',
					 text: '<i class="fas fa-print" style="color: #ff9900"></i>',
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					 titleAttr: 'Print'
				},
	
			],
			"ajax":
					{
						url: '../controlador/docentegrupos.php?op=consultaContacto&ciclo='+ciclo+'&jornada='+jornada+'&id_programa='+id_programa+'&grupo='+grupo+'&materia='+materia,
						type : "get",
						dataType : "json",						
						error: function(e){
							// console.log(e.responseText);	
						}
					},
			
				"bDestroy": true,
				"iDisplayLength": 10,//Paginación
				"order": [[ 1, "asc" ]],
				'initComplete': function (settings, json) {
					$("#modalReportes").modal("show");
					$("#precarga").hide();
				},
	
		  });

			
}







function consulta(ciclo, jornada, id_programa, grupo, medio) {
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
		"url": "../controlador/docentegrupos.php?op=consultaEstudiante",
		"type": "POST",
		"data": data,
		"dataType": "json",
		success: function (datos) {
		
			var r = JSON.parse(datos);
			$(".prueba").html(r.table);
			//$(document).ready(function (){
			$("#tbl_listar").dataTable({
				paging: true,
				searching: false,
				autoWidth: false,
				dom: "Bfrtip",
				buttons: [
					{
						extend: "print",
						text: '<i class="fas fa-print" style="color: #ff9900"></i>',
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
				order: [[1, "asc"]],
			});
			//});
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
	//console.table(data);
	$("#modalReportes").modal("show");
	if ($.fn.DataTable.isDataTable("#tbl_listar")) {
		$("#tbl_listar").DataTable().destroy();
	}
	$.ajax({
		url: "../controlador/docentegrupos.php?op=consultaEstudiante",
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
							text: '<i class="fas fa-print" style="color: #ff9900"></i>',
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


function consultaReporteFinal( id_docente, ciclo, materia, jornada, id_programa, grupo, semestre){
	var data = {id_docente: id_docente, ciclo: ciclo, materia: materia, jornada: jornada, id_programa: id_programa, grupo: grupo};
	//console.table(data);
	var meses = new Array( "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array( "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
	$("#modalReporteFinal").modal("show");
	if ($.fn.DataTable.isDataTable("#tbl_listar")) {
		$("#tbl_listar").DataTable().destroy();
	}
	$.ajax({
		"url": "../controlador/docentegrupos.php?op=consultaReporteFinal",
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
							"text": '<i class="fas fa-print" style="color: #ff9900"></i>',
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

function enviarCorreos(ciclo, jornada, id_programa, grupo){
	$("#enviarEmail").off("click").on("click", function () {
		$("#enviarEmail").html("Cargando ...");
		$("#enviarEmail").attr("disabled", true);
		//console.log(ciclo, jornada, id_programa, grupo);
		var data= {ciclo: ciclo, materia: $("#materia").val(), jornada: jornada, id_programa: id_programa, grupo: grupo, contenido: $("#conteMail").val()};
		//console.table(data);
		$.ajax({
			"url": "../controlador/docentegrupos.php?op=enviarCorreos",
			"type": "POST",
			"data": data,
			"dataType": "json",
			success: function (datos) {
				// console.log(datos);
				$("#enviarEmail").html("Enviar");
				$("#enviarEmail").attr("disabled", false);
				if (datos.result == "ok") {
					$("#modalEmail").modal("hide");
					$("#conteMail").val("");
				}
			},
			error: function (e) {
				// console.log(e.responseText);
			}
		});
	});
}

function nota(id, nota, tl, c, id_programa, id_docente_grupo) {
	if (nota.length <= 4) {
		if (nota <= 5.0 && nota >= 0) {
			$.post("../controlador/docentegrupos.php?op=nota",{ "id": id, "nota": nota, "tl": tl, "c": c, "pro": id_programa, "id_docente_grupo": id_docente_grupo },
				function (data) {
					// console.log(data);
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
	$.post("../controlador/docentegrupos.php?op=listarMotivos", function (datos) {
	
		datos = JSON.parse(datos);
		if (datos.status == '0'){
			alertify.error(datos.info);
		} else {
			html = '<option disabled selected value="">-- Selecciona una opción --</option>';
			for (i = 0; i < datos.info.length; i++) {
				html += '<option value="' + datos.info[i] + '">' + datos.info[i] + '</option>';
			}
			$("#motivo_falta").html(html);
		}
	});
}

function horarioEstudiante(id,ciclo,id_programa,grupo)
{
	
	$("#precarga").show();
	$.post("../controlador/docentegrupos.php?op=horarioestudiante",{id:id , ciclo:ciclo, id_programa:id_programa, grupo:grupo  },function(data, status){

		data = JSON.parse(data);
			
		$("#modalHorarioEstudiante").modal("show");
		$("#horarioestudiante").show();
		$("#horarioestudiante").html("");
		$("#horarioestudiante").append(data["0"]["0"]);
		$("#precarga").hide();
		$("#calendar").hide();
		// console.log(data);
		} );

}

function iniciarcalendario(id_estudiante,ciclo,id_programa,grupo){
	

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
		slotLabelFormat:{
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

		events:"../controlador/docentegrupos.php?op=iniciarcalendario&id_estudiante="+id_estudiante+"&ciclo="+ciclo+"&id_programa="+id_programa+"&grupo="+grupo,
		eventClick:function(info){
			$('#modalTitle').html(info.event.title);
			$('#modalDia').html(info.event.daysOfWeek);
		},
	});
	calendar.render();
}
//Función para activar el pea
function activarPea(id_docente_grupo,id_pea){
	alertify.confirm("Activar PEA", "¿Click en OK para activar el Proyecto educativo de aula?", function () {
	
		$.post("../controlador/docentegrupos.php?op=activarPea",{id_docente_grupo:id_docente_grupo, id_pea:id_pea},function(data){
		
			datos = JSON.parse(data);
			// console.log(data);
			if(datos=="1"){
				alertify.success('PEA activado');
				init();

			}else{
				alertify.error('error');
			}
		
		});

	}, function () { alertify.error('Cancelado') });
}