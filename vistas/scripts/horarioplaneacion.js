//Función que se ejecuta al inicio
function init(){
	$("#precarga").hide();
	
	$("#titulo").hide();
	
	$.post("../controlador/horarioplaneacion.php?op=selectPrograma", function(r){
	            $("#programa_ac").html(r);
	            $('#programa_ac').selectpicker('refresh');
	});

	$.post("../controlador/horarioplaneacion.php?op=selectJornada", function(r){
		$("#jornada").html(r);
		$('#jornada').selectpicker('refresh');
	});
	
	$.post("../controlador/horarioplaneacion.php?op=selectPeriodo", function(r){
		$("#periodo").html(r);
		$('#periodo').selectpicker('refresh');
	});

	$.post("../controlador/horarioplaneacion.php?op=selectDia", function(r){
		$("#dia").html(r);
		$('#dia').selectpicker('refresh');
	});

	//Cargamos los items de los selects hora inicial
	$.post("../controlador/horarioplaneacion.php?op=selectHora", function(r){
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
				title: 'Planeación Horarios' ,
				intro: 'Te damos la bienvenida a la planeación de nuestros horarios donde podrás tener un control sobre todas nuestras experiencias creativas'
			},
			{
				title: 'Programa académico',
				element: document.querySelector('#t-programa'),
				intro: "Aquí podrás encontrar todos los programas que tenemos disponibles para que visualices toda la información al rescpecto de cada uno"
			},
			{
				title: 'Jornada',
				element: document.querySelector('#t-jornada'),
				intro: "Consulta nuestras diferentes jornadas y da un vistazo en donde comienza la fuente de la creatividad"
			},
			{
				title: 'Semestre',
				element: document.querySelector('#t-semestre'),
				intro: "Consulta el semestre de tu elección y enterate de como  sucede nuestra magia creativa"
			},
			{
				title: 'Grupo',
				element: document.querySelector('#t-grupo'),
				intro: "Este campo te ayudará a conocer de manera más detalla y espeficíca ya que contamos con diferentes en nuestros semestres creativos "
			},
			{
				title: 'Panel de control',
				element: document.querySelector('#t-gestion'),
				intro: "Toma el control de los horarios,agrega,edita de la manera mas efectiva para que todos continuen la experiencia más creativa e innovadora"
			},
			{
				title: 'Calendario',
				element: document.querySelector('#t-calendario'),
				intro: "Visualiza nuestro calendario académico con sus respectivos horarios, acompañanos en la experiencia de nuestro calendario con toda nuestra comunidad"
			},
			{
				title: 'Modelo 1',
				element: document.querySelector('#t-card1'),
				intro: "Revisa muy bien los horarios y asigan correctamente cada una de nuestras experiencias,este campo se caracteriza por tener el botón <button class='btn btn-success btn-xs'><i class='fa fa-plus fa-1x'></i> Crear</button>"
			},
			{
				title: 'Modelo 2',
				element: document.querySelector('#t-card2'),
				intro: "Una ves hayas asignado el respectivo horario, te faltarían dos pasos a realizar asignar su respectivo salón y su respectivo docente y ya habrás terminado de crear una nueva experiencia creativa"
			},
			{
				title: 'Modelo 3',
				element: document.querySelector('#t-card3'),
				intro: "Aún no olvides nuestra otra modalidad PAT(Asistida por tecnologia) este campo ya se visualiza con todo asignado "
			},
			{
				title: 'Modelo 4',
				element: document.querySelector('#t-card4'),
				intro: "Aquí podrás ver dos de nuestras experiencias creativas del día en donde en una de ellas podrás ver todo asignado y la segunda les hace falta asignar su respectivo docente y su salón"
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
function buscar(e){
	
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#buscar")[0]);
	$.ajax({
		"url": "../controlador/horarioplaneacion.php?op=buscar",
	    "type": "POST",
	    "data": formData,
	    "contentType": false,
	    "processData": false,
	    success: function(data){  
			data = JSON.parse(data); 
			$("#mallas").html("");
			$("#mallas").append(data["0"]["0"]);
			inicarcalendario();
			$("#titulo").show();
	    }
	});

}


/* funcion que trae el horario de clases */
function calendario(e){
	
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#buscar")[0]);
	$.ajax({
		"url": "../controlador/horarioplaneacion.php?op=calendario",
	    "type": "POST",
	    "data": formData,
	    "contentType": false,
	    "processData": false,
	    success: function(data){  
			data = JSON.parse(data); 
			$("#calendario").html("");
			$("#calendario").append(data["0"]["0"]);
	    }
	});

}

// funcion para asignar horario
function crear(id_materia,jornada,semestre,grupo){
	
	$("#myModalCrear").modal("show");
	$("#id_horario_fijo").val("");
	$("#id_materia").val(id_materia);
	$("#jornadamateria").val(jornada);
	$("#semestremateria").val(semestre);
	$("#grupomateria").val(grupo);


	$.post("../controlador/horarioplaneacion.php?op=selectDia", function(r){
		$("#dia").html(r);
		$('#dia').selectpicker('refresh');
	});
	
	//Cargamos los items de los selects hora inicial
	$.post("../controlador/horarioplaneacion.php?op=selectHora", function(r){
	    $("#hora").html(r);
	    $('#hora').selectpicker('refresh');
		$("#hasta").html(r);
		$('#hasta').selectpicker('refresh');
	});
	$("#diferencia").val("");
	

}

// funcion para asignar horario
function editar(id_horario_fijo){
	$.post("../controlador/horarioplaneacion.php?op=mostrareditar", {id_horario_fijo:id_horario_fijo}, function(datos){
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

function ajustarhasta(hora){
	$.post("../controlador/horarioplaneacion.php?op=selectHasta", {hora:hora}, function(r){
		$("#hasta").html(r);
		$('#hasta').selectpicker('refresh');
	});
}

function calcularhoras(hasta){
	var horainicial=$("#hora").val();
	$.post("../controlador/horarioplaneacion.php?op=calcularHoras", {horainicial:horainicial , hasta:hasta}, function(r){
		$("#diferencia").val(r)

	});
}

//Función para guardar o editar
function guardaryeditar(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioAgregarGrupo")[0]);
	$.ajax({
		"url": "../controlador/horarioplaneacion.php?op=guardaryeditar",
	    "type": "POST",
	    "data": formData,
	    "contentType": false,
	    "processData": false,
	    success: function(datos){   
			
			datos = JSON.parse(datos);
			console.log(datos);
			if(datos[0]=="0"){
				alertify.error("error");
			}else if(datos[0]=="1"){
				alertify.success("Registro correcto");
				$("#myModalCrear").modal("hide");
				buscar(e);
				
			}else{
				alertify.error("Cruce de horario");
			}

			
	    }
	});
	//limpiar();
}


function inicarcalendario(){
	var id_programa=$("#programa_ac").val();
	var jornada=$("#jornada").val();
	var semestre=$("#semestre").val();
	var grupo=$("#grupo").val();
	$("#demo-tour").hide();

	var calendarEl = document.getElementById('calendar');
	var calendar = new FullCalendar.Calendar(calendarEl, {
		initialView: 'timeGridWeek',
		locales: 'es',
		minTime: "07:00",
    	maxTime: "24:00",
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

		events:"../controlador/horarioplaneacion.php?op=iniciarcalendario&id_programa="+id_programa+"&jornada="+jornada+"&semestre="+semestre+"&grupo="+grupo,
	});
	calendar.render();

		

}

//Función para activar registros
function eliminarhorario(id_horario_fijo)
{
	var e;
	alertify.confirm("Eliminar clase", "¿Desea Eliminar esta clase del horario?", function(){ 
	
		$.post("../controlador/horarioplaneacion.php?op=eliminarhorario", {id_horario_fijo:id_horario_fijo}, function(datos){
			var datos = JSON.parse(datos);
			
        		if(datos[0] == 1){
				   alertify.success("Eliminado corerctamente");
				   
				   actualizar(1);

				   }
				else{
					alertify.error("horario no se pudo  Eliminada");
				}
        	});
	
	}
                , function(){ alertify.error('Cancelado')});


}


/* Funcion que actualiza las mallas cuando se elimina algo */
function actualizar(valor){
	var id_programa=$("#programa_ac").val();
	var jornada=$("#jornada").val();
	var semestre=$("#semestre").val();
	var grupo=$("#grupo").val();

	$.post("../controlador/horarioplaneacion.php?op=buscar",{id_programa:id_programa, jornada:jornada, semestre:semestre, grupo:grupo, valor:valor}, function(data){
		data = JSON.parse(data); 
	    $("#mallas").html("");
		$("#mallas").append(data["0"]["0"]);
		inicarcalendario();
		$("#titulo").show();

	});
}

/* funcion para listar los salones */
function listarSalones(id_horario_fijo,dia,hora,hasta,id_programa,grupo){
	$.post("../controlador/horarioplaneacion.php?op=listarSalones", {"id_horario_fijo":id_horario_fijo,"dia": dia, "hora": hora, "hasta": hasta , "id_programa": id_programa,"grupo": grupo}, function(data){
		data = JSON.parse(data);
		$("#myModalAsignarSalon").modal("show");
		$("#lista_salones").html(data["0"]["0"]);
	});
}
/* funcion para asignar salon */
function asignarSalon(id_horario_fijo,salon){
	$.post("../controlador/horarioplaneacion.php?op=asignarSalon", {"id_horario_fijo" : id_horario_fijo, "salon": salon }, function(data){
		data = JSON.parse(data);
		if(data == true){
			alertify.success("Salón Asignado Correctamente");
			$("#myModalAsignarSalon").modal("hide");
			actualizar(1);
		}
	});
}


init();