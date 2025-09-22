$(document).ready(inicio);

function inicio() {
	consultahoy();
	consulta();

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

function iniciarSegundoTour() {
	introJs().setOptions({
		"nextLabel": 'Siguiente',
		"prevLabel": 'Anterior',
		"doneLabel": 'Terminar',
		"showBullets": false,
		"showProgress": true,
		"showStepNumbers": true,
		"steps": [{
			"title": 'Listado de tareas',
			"intro": 'Bienvenido a nuestro módulo de listado de tareas donde encontrarás con más detalle cada uno de los registros correspondientes'
		},
		{
			"title": 'Referencias',
			"element": document.querySelector('#t2-paso1'),
			"intro": "Aquí encontrarás el número de referencia único de cada registro"
		},

		{
			"title": 'Nombre',
			"element": document.querySelector('#t2-paso2'),
			"intro": "Encontrarás el nombre de la persona a la cual has acompañado en cada proceso"
		},

		{
			"title": 'Motivo',
			"element": document.querySelector('#t2-paso3'),
			"intro": "Aquí encontrarás la circunstancia por el cual la persona interesada requiere de tu ayuda"
		},
		{
			"title": 'Recordatorio',
			"element": document.querySelector('#t2-paso4'),
			"intro": "Aquí encontrarás el recordatorio para cada proceso realizado o a realizar"
		},
		{
			"title": 'Fecha',
			"element": document.querySelector('#t2-paso5'),
			"intro": "Encontrarás la fecha de cada uno de los listados"
		},
		{
			"title": 'Hora',
			"element": document.querySelector('#t2-paso6'),
			"intro": "Aquí encontrarás la hora en la que se realizó este listado de tareas con cada uno de los procesos"
		},
		{
			"title": 'Asesor',
			"element": document.querySelector('#t2-paso7'),
			"intro": "Da un vistazo a el nombre del asesor que lleva cada uno de los procesos"
		},
		{
			"title": 'Seguimiento',
			"element": document.querySelector('#t2-paso8'),
			"intro": "Aquí encontrarás la información de seguimiento que se le ha realizado a cada uno de los procesos"
		},
		{
			"title": 'Volver',
			"element": document.querySelector('#t2-paso9'),
			"intro": "Regresa el tiempo en el campus y vuelve nuevamente a tu panel de tareas"
		},


		]
	}).start();
}

function consultahoy() {
	$("#precarga").show();
    $.post("../controlador/sofimistareas.php?op=consultahoy",function(datos){
        var r = JSON.parse(datos);
		$(".datoshoy").html(r.conte);
		$("#precarga").hide();
	});
}

function consulta() {
	$("#precarga").show();
    $.post("../controlador/sofimistareas.php?op=consulta",function(datos){
        var r = JSON.parse(datos);
		$(".datos").html(r.conte);
		$("#precarga").hide();
		$("#datogeneral").html(r.general);
		$("#cumplidas").html(r.cumplidas);
		$("#pendientes").html(r.pendientes);
		$("#nocumplidas").html(r.nocumplidas);
		$("#deldia").html(r.deldia);
	});
}

function buscar(tipo,id,consulta) {
	$("#precarga").show();
	$(".primer_tour").addClass("d-none");
	$(".segundo_tour").removeClass("d-none");
    $.post("../controlador/sofimistareas.php?op=buscar",{tipo:tipo,id:id,consulta:consulta},function(datos){
        var r = JSON.parse(datos);
        $(".datos").attr("hidden",true);
		$(".datoshoy").attr("hidden",true);
        $(".datos_usuario").attr("hidden",false);
		$(".datos_usuario").html(r.conte);
		$("#tbl_buscar").DataTable({
			"dom": 'Bfrtip',
            buttons: [{
                extend:    'copyHtml5',
                text:      '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel" style="color: green"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-alt"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf" style="color: red"></i>',
                titleAttr: 'PDF',
     
            }]
		});		
		$("#precarga").hide();
	});
}

function cambiarasesor(id_tarea,id_asesor,tipo,id_asesor_buscar,consulta) {
	$.post("../controlador/sofimistareas.php?op=cambiarasesor",{id_tarea:id_tarea,id_asesor:id_asesor},function(data){
		
		console.log(data);
		var r  = JSON.parse(data);
		if (r.status == "ok") {
			alertify.success("Se cambio el asesor con exito");
			buscar(tipo,id_asesor_buscar,consulta)
		} else {
			alertify.success("Error al cambiar el asesor");
		}

	});
}

function cambiarfecha(id_tarea,fecha,tipo,id_asesor_buscar,consulta) {
	$.post("../controlador/sofimistareas.php?op=cambiarfecha",{id_tarea:id_tarea,fecha:fecha},function(data){
		
		console.log(data);
		var r  = JSON.parse(data);
		if (r.status == "ok") {
			alertify.success("Se cambio la fecha con exito");
			buscar(tipo,id_asesor_buscar,consulta)
		} else {
			alertify.success("Error al cambiar la fecha");
		}

	});
}


function volver() {
	consulta();
	$(".primer_tour").removeClass("d-none");
	$(".segundo_tour").addClass("d-none");
	$(".datos").attr("hidden",false);
	$(".datoshoy").attr("hidden",false);
	$(".datos_usuario").attr("hidden",true);
}

function validarTarea(id_estudiante,tipo,consulta,id_tarea) {
	$.post("../controlador/sofimistareas.php?op=validarTarea",{id_tarea:id_tarea},function(data){
			
		console.log(data);
		var r = JSON.parse(data);
		if (r.status == "ok") {
			alertify.success("OK");
			buscar(tipo,id_estudiante,consulta);
            consultahoy();
	        consulta();
		} else {
			alertify.success("Error");
		}		

	});
}

function cuentatarea(){// muestra el numero de caracteres limite en un textarea
	var max_chars = 150;
	
	$('#max').html(max_chars);

	$('#mensaje_tarea').keyup(function() {
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		$('#contadortarea').html(diff);   
	});
}