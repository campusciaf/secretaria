function inicio() {
    $("#precarga").show();
	listar();
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
				title: 'Mis Tareas',
				intro: "Bienvenido a nuestro módulo de tareas donde podrás visualizar todas tus tareas pendientes a lo largo de tu jornada laboral "
			},
			{
				title: 'Total General',
				element: document.querySelector('#t-tg'),
				intro: "Aquí podrás encontrar todas tus tareas con un número total"
			},
			{
				title: 'Total Cumplidas',
				element: document.querySelector('#t-tc'),
				intro: "Da un vistazo a el número de tus tareas cumplidas"
			},
			{
				title: 'Total Pendientes',
				element: document.querySelector('#t-tp'),
				intro: "Aquí encontrarás el número total de tareas pendientes que tienes por completar"
			},
			{
				title: 'Total No cumplidas',
				element: document.querySelector('#t-tn'),
				intro: "Da un vistazo a el número total de las tareas no cumplidas que has tenido hasta el momento"
			},
			{
				title: 'Total Del día',
				element: document.querySelector('#t-td'),
				intro: "Aquí encontrarás el número de tareas asignadas del día "
			},
			{
				title: 'Tareas',
				element: document.querySelector('#t-tr'),
				intro: "En nuestro panel de tareas encontrarás las diferentes asignaciones"
			},
			{
				title: 'Citas',
				element: document.querySelector('#t-tci'),
				intro: "Aquí encontrarás el avance de las tareas de citas con las personas que están interesadas en sumarce a este parche creativo"
			},
			{
				title: 'Seguimientos',
				element: document.querySelector('#t-tse'),
				intro: "Da un vistazo a todos los seguimientos que se le han realizado a cada uno de los procesos"
			},
			{
				title: 'Llamadas',
				element: document.querySelector('#t-tlla'),
				intro: "Aquí encontrarás todo el registro de llamadas realizadas a cada una de las personas interesadas en formar parte de la institución más creativa e innovadora "
			},
			{
				title: 'Totales',
				element: document.querySelector('#t-tt'),
				intro: "Encontrarás un resumen de cada una de tus tareas asignadas, cada tarea en hay un color designado que indica si se ha completado la tarea, si no se ha completo o de lo contrario esta en proceso "
			},
			

		]
			
	},
	console.log()
	
	).start();

}

function listar() {
	
    $.post("../controlador/oncenterreporte.php?op=listar",function(datos){
        var r = JSON.parse(datos);
		$("#resultado").html(r.general);
        $("#precarga").hide();
	});
}


inicio();
