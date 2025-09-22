//Función que se ejecuta al inicio
function init(){
	$("#precarga").hide();
	iniciarcalendario();
	
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


function iniciarcalendario(){




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
		

		events:"../controlador/horariodocentepersonal.php?op=iniciarcalendario",

		eventClick:function(info){
			$('#modalTitle').html(info.event.title);
			$('#modalDia').html(info.event.daysOfWeek);
			$('#myModalEvento').modal();

		},
		

	});
	calendar.render();



	$('#btnPrint').click(function(){
		window.print();
	});

}



init();

