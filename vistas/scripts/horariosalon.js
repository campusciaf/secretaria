//Función que se ejecuta al inicio
function init(){
	$("#precarga").hide();
	
	$("#titulo").hide();
	
	//Cargamos los items de los selects contrato
	$.post("../controlador/horariosalon.php?op=selectSalon", function(r){
		$("#salon").html(r);
		$('#salon').selectpicker('refresh');
});
	//Cargamos los items de los selects contrato
	$.post("../controlador/horariosalon.php?op=selectPeriodo", function(r){
	            $("#periodo").html(r);
	            $('#periodo').selectpicker('refresh');
	});

	$("#buscar").on("submit",function(e){
		buscar(e);	
		
	});

	$("#formularioAgregarGrupo").on("submit",function(e){
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
				intro: 'Da un vistazo a nuestro modulo donde podrás observar todos nuestros horarios por salones activos'
			},
			{
				title: 'Salón',
				element: document.querySelector('#t-programa'),
				intro: "Aquí podrás encontrar todos nuestros nuestros salones disponibles para que puedas consultar "
			},
			{
				title: 'Periodo académico',
				element: document.querySelector('#t-periodo'),
				intro: "Aquí podrás encontrar todos nuestros periodos académicos activos para consultar"
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

function buscarDatos(){
	periodo		=	$('#periodo').val();
	salon		=   $('#salon').val();


 	if(periodo != "" && salon != ""){
		iniciarcalendario();
		$("#t-calendario").hide();
	}else{
		$("#precarga").hide();
	}
	
}


function calcularhoras(hasta){
	var horainicial=$("#hora").val();
	$.post("../controlador/horariosalon.php?op=calcularHoras", {horainicial:horainicial , hasta:hasta}, function(r){
		$("#diferencia").val(r)

	});
}



function iniciarcalendario(){
	var salon=$("#salon").val();
	var periodo=$("#periodo").val();
	$("#precarga").show();
	$("#titulo").show();

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
		

		events:"../controlador/horariosalon.php?op=iniciarcalendario&salon="+salon+"&periodo="+periodo,

		eventSourceSuccess :function(info){
			$("#precarga").hide();
		},

		eventClick:function(info){
			$('#modalTitle').html(info.event.title);
			$('#modalDia').html(info.event.daysOfWeek);
			$('#myModalEvento').modal();

		},
		

	});
	calendar.render();



	// $('#btnPrint').click(function(){
	// 	window.print();
	// });

}



init();

