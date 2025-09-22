//Función que se ejecuta al inicio
function init() {
	$("#precarga").hide();
	$("#titulo").hide();
	$("#btn_print").hide();
	//Cargamos los items de los selects contrato
	$.post("../controlador/horariodocente.php?op=selectDocente", function (r) {
		// console.log(r);
		$("#id_docente").html(r);
		$('#id_docente').selectpicker('refresh');
	});
	//Cargamos los items de los selects contrato
	$.post("../controlador/horariodocente.php?op=selectPeriodo", function (r) {
		$("#periodo").html(r);
		$('#periodo').selectpicker('refresh');
	});
	$("#buscar").on("submit", function (e) {
		buscar(e);
	});
	$("#formularioAgregarGrupo").on("submit", function (e) {
		guardaryeditar(e);
	});
	
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
				title: 'Horarios',
				intro: 'Da un vistazo de nuestros horarios por docente en nuestro periodo actual'
			},
			{
				title: 'Docente',
				element: document.querySelector('#t-programa'),
				intro: "¡Aquí podrás consultar a todos nuestros docentes activos!"
			},
			{
				title: 'Periodo académico',
				element: document.querySelector('#t-periodo'),
				intro: "En este campo podrás encontrar todos nuestros peridos académicos activos"
			},

			{
				title: 'Calendario',
				element: document.querySelector('#t-calendario'),
				intro: "En este calendario toda nuestra comunidad académica podrá visualizar los horarios publicados"
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
function printCalendar() {
	var mode = 'iframe';
	var close=mode=="popup";
	var options = {mode:mode, popClose:close};
	$("#calendar").printArea(options);	 
}
//Función para guardar o editar
function buscarDatos() {
	periodo = $('#periodo').val();
	id_docente = $('#id_docente').val();
	if (periodo != "" && id_docente != "") {
		iniciarcalendario();
		$("#t-calendario").hide();
	}
}

function calcularhoras(hasta) {
	var horainicial = $("#hora").val();
	$.post("../controlador/horariodocente.php?op=calcularHoras", { horainicial: horainicial, hasta: hasta }, function (r) {
		$("#diferencia").val(r)
	});
}

function iniciarcalendario() {
	var id_docente = $("#id_docente").val();
	var periodo = $("#periodo").val();
	$("#titulo").show();
	$("#btn_print").show();
	$("#precarga").show();
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
		contentHeight: "auto",
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
		events: "../controlador/horariodocente.php?op=iniciarcalendario&id_docente=" + id_docente + "&periodo=" + periodo,

		eventSourceSuccess :function(info){
			$("#precarga").hide();
		},
		eventClick: function (info) {
			$('#modalTitle').html(info.event.title);
			$('#modalDia').html(info.event.daysOfWeek);
			$('#myModalEvento').modal();
		},
	});
	calendar.render();
}

init();