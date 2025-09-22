$(document).ready(init);

function init() {
    listar3();

	
}

function listar(id, ciclo, id_programa, grupo) {
	$.post("../controlador/mihorario.php?op=listar", { id: id, ciclo: ciclo, id_programa: id_programa, grupo: grupo }, function (data, status) {
		data = JSON.parse(data);
		$("#tllistado").hide();	// ocultamos los pea
		$("#tbllistado").html("");
		$("#tbllistado").append(data["0"]["0"]);
		$('#example').DataTable({
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
				"messageTop": '<div style="width:50%;float:left">Reporte perfil mihorario<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
				"title": 'Materias Matriculadas',
				"titleAttr": 'Print'
			},
			],
			"language": {
				"url": "../public/datatables/idioma/Spanish.json"
			},
			"columnDefs": [
				{ "className": 'text-center', "targets": [2, 3, 4, 5, 6] },
			],
			

		});
		$("#precarga").hide();

	});
}

function iniciarcalendario() {
	$("#listado").hide();
	$("#calendario").show();

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
		eventSources: [
			{
				url: "../controlador/mihorario.php?op=iniciarcalendario", // URL del backend
				method: "POST",  // Se cambia a POST
				failure: function() {
					console.log('Hubo un error al cargar los eventos.');
				},
				success: function() {
					$("#precarga").hide();
				}
			}
		],
		eventClick: function(info) {
			$('#modalTitle').html(info.event.title);
			$('#modalDia').html(info.event.start.toLocaleDateString());
		},
	});

	calendar.render();

	// $.post("../controlador/mihorario.php?op=iniciarcalendario", {  }, function (data) {
	// 	data = JSON.parse(data);
	// 	console.log(data)
	// });

}


//Función Listar
function listar3()
{


var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	           buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                titleAttr: 'Excel'
            },
			{
                extend: 'print',
			 	text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                messageTop: '<div style="width:50%;float:left"><b>Mi horario:</b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Faltas',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/mihorario.php?op=listar3',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		
			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			"order": [[ 0, "asc" ]],
			'initComplete': function (settings, json) {
				$("#calendario").hide();
                $("#precarga").hide();
			},

      });
	
    //   $.post("../controlador/mihorario.php?op=iniciarcalendario3", {  }, function (data) {
	// 	data = JSON.parse(data);
	// 	console.log(data)
	// });

	
		
}

function volverhorario() {
	$("#listado").show();
	$("#calendario").hide();
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
				title: 'Programa y horario',
				intro: '¡Bienvenido a la información donde comienza tu experiencia creativa!'
			},
			{
				title: 'PEA',
				element: document.querySelector('#t-paso1'),
				intro: "Aquí podrás encontrar todos aquellos proyectos educativos de aula que nuestro docente tiene para todos nuestros seres originales creando asi un ambiente creativo e innovador"
			},

			{
				title: 'Asignatura',
				element: document.querySelector('#t-paso2'),
				intro: "Conoce las diferentes asinaturas de tu semestre teniendo encuenta donde comienza y donde termina la mágica experiencia creativa"
			},

			{
				title: 'Docente',
				element: document.querySelector('#t-paso3'),
				intro: "Conoce a los guias de esta aventura educativa, que te llevarán por el mundo de el conocimiento "
			},

			{
				title: 'Cortes',
				element: document.querySelector('#t-paso4'),
				intro: "Enterate de las diferentes notas que te han asignado en las experiencias creativas de tu semestre"
			},
			
			{
				title: 'Final',
				element: document.querySelector('#t-paso5'),
				intro: "Da un vistazo a tu nota final donde se hace un reencuento de todas las experiencias creativas que has vivido este semestre"
			},

			{
				title: 'Horario de clase',
				element: document.querySelector('#t-paso6'),
				intro: "Aquí te puedes enterar de la hora tan esperada para comenzar tu experiencia creativa "
			},

			{
				title: 'Faltas',
				element: document.querySelector('#t-paso7'),
				intro: "Da un vistazo a tus faltas reportadas por tus docentes, recuerda que es muy imporante reportar tu ausencia y el motivo de ella, luego te podrás poner al tanto de la experiencia creativa a la que has faltado"
			},

			{
				title: 'Calendario',
				element: document.querySelector('#t-paso8'),
				intro: "Observa de manera más detallada cuando comienza tu encuentro con el conocimiento en nuestro calendario donde podrás observar tus proximas experiencias creativas"
			},

		




            


        







		]
			
	},
	
	
	).start();


}