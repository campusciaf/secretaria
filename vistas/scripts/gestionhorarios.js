//Función que se ejecuta al inicio
function init() {
	$("#precarga").hide();
	$.post("../controlador/gestionhorarios.php?op=selectPrograma", function (r) {
		$("#programa_ac").html(r);
		$('#programa_ac').selectpicker('refresh');
	});
	$.post("../controlador/gestionhorarios.php?op=selectJornada", function (r) {
		$("#jornada").html(r);
		$('#jornada').selectpicker('refresh');
	});
	$.post("../controlador/gestionhorarios.php?op=selectPeriodo", function (r) {
		$("#periodo").html(r);
		$('#periodo').selectpicker('refresh');
	});
	$.post("../controlador/gestionhorarios.php?op=selectDia", function (r) {
		$("#dia").html(r);
		$('#dia').selectpicker('refresh');
	});
	//Cargamos los items de los selects hora inicial
	$.post("../controlador/gestionhorarios.php?op=selectHora", function (r) {
		$("#hora").html(r);
		$('#hora').selectpicker('refresh');
		$("#hasta").html(r);
		$('#hasta').selectpicker('refresh');
	});
	$("#buscar").on("submit", function (e) {
		buscar(e);
	});
	$("#formularioAgregarGrupo").on("submit", function (e) {
		guardaryeditar(e);
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
			// {
			// 	title: 'Comparativo',
			// 	element: document.querySelector('#t-data'),
			// 	intro: "Columna que indica el número de entrevistas validadas a la fecha, en el tercer renglón se encuentran los datos de la campaña comparada"
			// },
			{
				title: 'Programa académico',
				element: document.querySelector('#t-programa'),
				intro: "¡Aquí es donde podrás consultar todos nuestros programas activos!"
			},
			{
				title: 'Jornada',
				element: document.querySelector('#t-jornada'),
				intro: "Ente campo podrás encontrar todas nuestras jornadas que tenemos disponibles para las diferentes experiencias creativas"
			},
			{
				title: 'Semestre',
				element: document.querySelector('#t-semestre'),
				intro: "¡Selecciona el semestre de tu interés!"
			},
			{
				title: 'Grupo',
				element: document.querySelector('#t-grupo'),
				intro: "Contamos con diferentes grupos para que sea más facil tu busqueda,elige el grupo a consultar"
			},
			{
				title: 'Panel de control',
				element: document.querySelector('#t-gestion'),
				intro: "En esta columna podrás crear y visualizar horarios para toda nuestra comunidad académica"
			},
			{
				title: 'Calendario',
				element: document.querySelector('#t-calendario'),
				intro: "En este calendario toda nuestra comunidad académica podrá visualizar los horarios publicados"
			},
			{
				title: 'Modelo 1',
				element: document.querySelector('#t-card1'),
				intro: "En este modelo estarán realizados todos los pasos ya que contarás con un horario asignado y solo deberás darle click a el botón publicar"
			},
			{
				title: 'Modelo 2',
				element: document.querySelector('#t-card2'),
				intro: "Aquí podrás crear el horario para la experiencia creativa de nuestros seres originales"
			},
			{
				title: 'Modelo 3',
				element: document.querySelector('#t-card3'),
				intro: "En este modelo ya tendrás un docente, un horario y un salón asigando, aclarando que esta serás con una modalidad PAT(Asistida por tecnología)"
			},
			{
				title: 'Modelo 4',
				element: document.querySelector('#t-card4'),
				intro: "Encontrarás el estado de la asignatura con dos experiencias creativas en diferentes días una estará publicada y la otra la podrás crear simplemente con un click en <a class='badge badge-info pointer text-white'><i class='fa fa-plus fa-1x'></i>Nuevo día</a>"
			},
			{
				title: 'Modelo 5',
				element: document.querySelector('#t-card5'),
				intro: "En este modelo podrás encontrar dos experiencias creativas, una con su respectivo salon y docente, en cuanto a la otra estos dos pasos fundamentales tendrán que ser agregados"
			},
			{
				title: 'Tarjeta normal',
				element: document.querySelector('#t-cal-1'),
				intro: "Esta tarjeta nos indica que la asignatura estará presente desde nuestro inicio y final de la etapa creativa"
			},
			{
				title: 'Tarjeta corte2',
				element: document.querySelector('#t-cal-2'),
				intro: "Esta tarjeta nos indica la proxima asignatura que estara en nuestro segundo corte cada ves más creativo e innovador"
			}
		]
	},
		console.log()
	).start();
}
/* funcion que trae las materias */
function buscar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#buscar")[0]);
	$.ajax({
		"url": "../controlador/gestionhorarios.php?op=buscar",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (data) {
			data = JSON.parse(data);
			$("#mallas").html("");
			$("#mallas").append(data["0"]["0"]);
			inicarcalendario();
			$("#titulo").show();
		}
	});
}
/* funcion que trae el horario de clases */
function calendario(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#buscar")[0]);
	$.ajax({
		"url": "../controlador/gestionhorarios.php?op=calendario",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (data) {
			data = JSON.parse(data);
			$("#calendario").html("");
			$("#calendario").append(data["0"]["0"]);
		}
	});
}
function agregarAlHorario(id_horario_fijo) {
	$.post("../controlador/gestionhorarios.php?op=agregarAlHorario", { id_horario_fijo: id_horario_fijo }, function (datos) {
		data = JSON.parse(datos);
		console.log(data[0]);
		if (data[0] == 1) {
			alertify.success("Agregado corerctamente");
			actualizar(1);
		}
		if (data[0] == 0) {
			alertify.error("horario no se pudo  Agregar");
		}
		if (data[0] == 2) {
			alertify.error("Cruce de horario");
		}
		if (data[0] == 3) {
			alertify.error("Cruce de salón");
		}
	});
}
// funcion para asignar horario
function crear(id_materia, jornada, semestre, grupo) {
	$("#myModalCrear").modal("show");
	$("#id_horario_fijo").val("");
	$("#id_materia").val(id_materia);
	$("#jornadamateria").val(jornada);
	$("#semestremateria").val(semestre);
	$("#grupomateria").val(grupo);
	$.post("../controlador/gestionhorarios.php?op=selectDia", function (r) {
		$("#dia").html(r);
		$('#dia').selectpicker('refresh');
	});
	//Cargamos los items de los selects hora inicial
	$.post("../controlador/gestionhorarios.php?op=selectHora", function (r) {
		$("#hora").html(r);
		$('#hora').selectpicker('refresh');
		$("#hasta").html(r);
		$('#hasta').selectpicker('refresh');
	});
	$("#diferencia").val("");
}
// funcion para asignar horario
function editar(id_horario_fijo) {
	$.post("../controlador/gestionhorarios.php?op=mostrareditar", { id_horario_fijo: id_horario_fijo }, function (datos) {
		data = JSON.parse(datos);
		$("#myModalCrear").modal("show");
		$("#id_horario_fijo").val(data.id_horario_fijo);
		$("#id_materia").val(data.id_materia);
		$("#dia").val(data.dia);
		$("#dia").selectpicker('refresh');
		$("#hora").val(data.hora);
		$("#hora").selectpicker('refresh');
		$("#hasta").val(data.hasta);
		$("#hasta").selectpicker('refresh');
		$("#diferencia").val(data.diferencia);
		$("#corte").val(data.corte);
	});
}
function ajustarhasta(hora) {
	$.post("../controlador/gestionhorarios.php?op=selectHasta", { hora: hora }, function (r) {
		$("#hasta").html(r);
		$('#hasta').selectpicker('refresh');
	});
}
function calcularhoras(hasta) {
	var horainicial = $("#hora").val();
	$.post("../controlador/gestionhorarios.php?op=calcularHoras", { horainicial: horainicial, hasta: hasta }, function (r) {
		$("#diferencia").val(r)
	});
}
//Función para guardar o editar
function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioAgregarGrupo")[0]);
	$.ajax({
		"url": "../controlador/gestionhorarios.php?op=guardaryeditar",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			datos = JSON.parse(datos);
			console.log(datos);
			if (datos[0] == "0") {
				alertify.error("error");
			} else if (datos[0] == "1") {
				alertify.success("Registro correcto");
				$("#myModalCrear").modal("hide");
				buscar(e);
			} else {
				alertify.error("Cruce de horario");
			}
		}
	});
	//limpiar();
}
function inicarcalendario() {
	var id_programa = $("#programa_ac").val();
	var jornada = $("#jornada").val();
	var semestre = $("#semestre").val();
	var grupo = $("#grupo").val();
	$("#demo-tour").hide();

	let fechaInicio = null;
	let fechaFin = null;
	

	var calendarEl = document.getElementById('calendar');
	var calendar = new FullCalendar.Calendar(calendarEl, {
		initialView: 'timeGridWeek',
		locale: 'es',
		minTime: "07:00",
		maxTime: "24:00",
		headerToolbar: {
			left: 'prev,next today',
			center: 'title',
			right: 'timeGridWeek'
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
		events: "../controlador/gestionhorarios.php?op=iniciarcalendario&id_programa=" 
				+ id_programa + "&jornada=" + jornada 
				+ "&semestre=" + semestre + "&grupo=" + grupo,
		
		datesSet: function(info) {
			fechaInicio = info.startStr.split("T")[0];
			fechaFin = info.endStr.split("T")[0];
			calendar.refetchEvents();
		},

		eventClick: function(info) {
			if (info.event.extendedProps.clickable) {
				alertify.confirm("Eliminar reserva", "¿Desea Eliminar esta reserva?", function () {
					
					const id_reserva = info.event.extendedProps.data_id;

					$.post("../controlador/gestionhorarios.php?op=eliminarReserva", { id_reserva: id_reserva }, function (datos) {
						var datos = JSON.parse(datos);
						if (datos[0] == 1) {
							alertify.success("Eliminado corerctamente");
							calendar.refetchEvents();
						}
						else {
							alertify.error("horario no se pudo  Eliminada");
						}
					});
				}, function () { alertify.error('Cancelado') });
			}
		},

		eventDidMount: function(info) {
			// Bootstrap Tooltip
			$(info.el).tooltip({
				title: info.event.title + " - " + (info.event.extendedProps.detalle || ""),
				placement: "top",
				trigger: "hover",
				container: "body"
			});
		}

	});
	calendar.render();

}
//Función para activar registros
function eliminarhorario(id_docente_grupo) {
	var e;
	alertify.confirm("Eliminar clase", "¿Desea Eliminar esta clase del horario?", function () {
		$.post("../controlador/gestionhorarios.php?op=eliminarhorario", { id_docente_grupo: id_docente_grupo }, function (datos) {
			var datos = JSON.parse(datos);
			if (datos[0] == 1) {
				alertify.success("Eliminado corerctamente");
				actualizar(1);
			}
			else {
				alertify.error("horario no se pudo  Eliminada");
			}
		});
	}
		, function () { alertify.error('Cancelado') });
}
/* Funcion que actualiza las mallas cuando se elimina algo */
function actualizar(valor) {
	var id_programa = $("#programa_ac").val();
	var jornada = $("#jornada").val();
	var semestre = $("#semestre").val();
	var grupo = $("#grupo").val();
	$.post("../controlador/gestionhorarios.php?op=buscar", { id_programa: id_programa, jornada: jornada, semestre: semestre, grupo: grupo, valor: valor }, function (data) {
		data = JSON.parse(data);
		$("#mallas").html("");
		$("#mallas").append(data["0"]["0"]);
		inicarcalendario();
		$("#titulo").show();
	});
}
/* funcion para listar los salones */
function listarSalones(id_docente_grupo, dia, hora, hasta, id_programa, grupo) {
	$.post("../controlador/gestionhorarios.php?op=listarSalones", { "id_docente_grupo": id_docente_grupo, "dia": dia, "hora": hora, "hasta": hasta, "id_programa": id_programa, "grupo": grupo }, function (data) {
		data = JSON.parse(data);
		$("#myModalAsignarSalon").modal("show");
		$("#lista_salones").html(data["0"]["0"]);
	});
}
/* funcion para asignar salon */
function asignarSalon(id_docente_grupo, salon) {
	$.post("../controlador/gestionhorarios.php?op=asignarSalon", { "id_docente_grupo": id_docente_grupo, "salon": salon }, function (data) {
		data = JSON.parse(data);
		if (data == true) {
			alertify.success("Salón Asignado Correctamente");
			$("#myModalAsignarSalon").modal("hide");
			actualizar(1);
		}
	});
}
/* funcion para asignar salon con fusion */
function asignarSalonFusion(id_docente_grupo, salon) {
	$.post("../controlador/gestionhorarios.php?op=asignarSalonFusion", { "id_docente_grupo": id_docente_grupo, "salon": salon }, function (data) {
		data = JSON.parse(data);
		if (data == true) {
			alertify.success("Salón Asignado Correctamente");
			$("#myModalAsignarSalon").modal("hide");
			actualizar(1);
		}
	});
}
/* funcion para listar los docentes */
function listarDocentes(id_docente_grupo, dia, hora, hasta, id_programa, grupo) {
	$.post("../controlador/gestionhorarios.php?op=listarDocentes", { "id_docente_grupo": id_docente_grupo, "dia": dia, "hora": hora, "hasta": hasta, "id_programa": id_programa, "grupo": grupo }, function (data) {
		data = JSON.parse(data);
		$("#myModalAsignarSalon").modal("show");
		$("#lista_salones").html(data["0"]["0"]);
	});
}
/* funcion para asignar docente */
function asignarDocente(id_docente_grupo, id_usuario_doc) {
	$.post("../controlador/gestionhorarios.php?op=asignarDocente", { "id_docente_grupo": id_docente_grupo, "id_usuario_doc": id_usuario_doc }, function (data) {
		data = JSON.parse(data);
		if (data == true) {
			alertify.success("Docente Asignado Correctamente");
			$("#myModalAsignarSalon").modal("hide");
			actualizar(1);
		}
	});
}
/* funcion para asignar docente con fusion */
function asignarDocenteFusion(id_docente_grupo, id_usuario_doc) {
	$.post("../controlador/gestionhorarios.php?op=asignarDocenteFusion", { "id_docente_grupo": id_docente_grupo, "id_usuario_doc": id_usuario_doc }, function (data) {
		data = JSON.parse(data);
		if (data == true) {
			alertify.success("Docente Asignado Correctamente");
			$("#myModalAsignarSalon").modal("hide");
			actualizar(1);
		}
	});
}
/* funcion para quitar un docente a un grupo*/
function quitarDocente(id_docente_grupo) {
	alertify.confirm("Quitar Docente", "¿Desea Eliminar este docente de la clase?", function () {
		$.post("../controlador/gestionhorarios.php?op=quitarDocente", { "id_docente_grupo": id_docente_grupo }, function (data) {
			data = JSON.parse(data);
			if (data == true) {
				alertify.success("Docente Asignado Correctamente");
				$("#myModalAsignarSalon").modal("hide");
				actualizar(1);
			}
		});
	}
		, function () { alertify.error('Cancelado') });
}
/* funcion para quitar un salón a un grupo*/
function quitarSalon(id_docente_grupo) {
	alertify.confirm("Quitar Docente", "¿Desea Eliminar este salónde la clase?", function () {
		$.post("../controlador/gestionhorarios.php?op=quitarSalon", { "id_docente_grupo": id_docente_grupo }, function (data) {
			data = JSON.parse(data);
			if (data == true) {
				alertify.success("Docente Asignado Correctamente");
				$("#myModalAsignarSalon").modal("hide");
				actualizar(1);
			}
		});
	}
		, function () { alertify.error('Cancelado') });
}
init();
