//Función que se ejecuta al inicio
function init(){
	$("#precarga").hide();

	
	$("#titulo").hide();
	
	$.post("../controlador/horarioprograma.php?op=selectPrograma", function(r){
	            $("#programa_ac").html(r);
	            $('#programa_ac').selectpicker('refresh');
	});

	$.post("../controlador/horarioprograma.php?op=selectJornada", function(r){
		$("#jornada").html(r);
		$('#jornada').selectpicker('refresh');
	});
	
	$.post("../controlador/horarioprograma.php?op=selectPeriodo", function(r){
		$("#periodo").html(r);
		$('#periodo').selectpicker('refresh');
	});

	$.post("../controlador/horarioprograma.php?op=selectDia", function(r){
		$("#dia").html(r);
		$('#dia').selectpicker('refresh');
	});

	//Cargamos los items de los selects hora inicial
	$.post("../controlador/horarioprograma.php?op=selectHora", function(r){
	    $("#hora").html(r);
	    $('#hora').selectpicker('refresh');
		$("#hasta").html(r);
		$('#hasta').selectpicker('refresh');
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
				intro: 'Bienvenido a nuestro modúlo donde podrás consultar todos nuestros programas activos'
			},
			{
				title: 'Programa académico',
				element: document.querySelector('#t-programa'),
				intro: "¡Consulta nuestros diferentes programas activos! "
			},
			{
				title: 'Jornada',
				element: document.querySelector('#t-jornada'),
				intro: "En este campo podrás encontrar todas nuestras jornadas disponibles para el programa que consultaste"
			},
			{
				title: 'Semestre',
				element: document.querySelector('#t-semestre'),
				intro: "¡Aquí podrás ver el semestre que tienes interés en consultar!"
			},
			{
				title: 'Grupo',
				element: document.querySelector('#t-grupo'),
				intro: "Contamos con diferentes grupos para que sea más facil tu busqueda,elige el grupo a consultar"
			},
			{
				title: 'Calendario',
				element: document.querySelector('#t-calendario'),
				intro: "Aquí podrás encontrar los diferentes horarios en donde comienza nuestra magica experiencia creativa "
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

//Función para guardar o editar

function buscarDatos(){
	$("#precarga").show();
	periodo		=	$('#periodo').val();
	jornada		=   $('#jornada').val();
	semestre	=   $('#semestre').val();
	grupo		=   $('#grupo').val();
	

 	if(periodo != "" && jornada != "" && semestre != "" && grupo != "" ){
		iniciarcalendario();
		$("#t-calendario").hide();
		

	}else{
		$("#precarga").hide();
	}
	
}


function calcularhoras(hasta){
	var horainicial=$("#hora").val();
	$.post("../controlador/horarioprograma.php?op=calcularHoras", {horainicial:horainicial , hasta:hasta}, function(r){
		$("#diferencia").val(r)

	});
}




function iniciarcalendario(){
	var id_programa=$("#programa_ac").val();
	var jornada=$("#jornada").val();
	var semestre=$("#semestre").val();
	var grupo=$("#grupo").val();
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

		events:"../controlador/horarioprograma.php?op=iniciarcalendario&id_programa="+id_programa+"&jornada="+jornada+"&semestre="+semestre+"&grupo="+grupo, 

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

