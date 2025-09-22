	$(function () {

		/* initialize the external events
		-----------------------------------------------------------------*/
		function init_events(ele) {
		ele.each(function () {

			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
			title: $.trim($(this).text()) // use the element's text as the event title
			}

			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject)

		})
		}
		init_events($('#external-events div.external-event'));

		/* initialize the calendar
		-----------------------------------------------------------------*/
		//Date for the calendar events (dummy data)
		var date = new Date()
		var d    = date.getDate(),
			m    = date.getMonth(),
			y    = date.getFullYear()
		$('#calendar').fullCalendar({
		header    : {
			left  : 'prev,next today',
			center: 'title',
			right : 'month,agendaWeek,agendaDay'
		},
		buttonText: {
			today: 'Hoy',
			month: 'Mes',
			week : 'Semana',
			day  : 'Día'
		},

		/*Enlace para cargar los eventos de la base de datos*/
			eventSources: [{
				events: function (start, end, timezone, callback) {
					$.ajax({
						url: '../controlador/calendario_poa_academico.php?op=mostrarAcademica',
						type: 'GET',
						dataType: "JSON",
						success: function (response) {
							console.log(response);
							var events = [];
							$(response['data']).each(function () {
								events.push({
									id: $(this).attr('id'),
									title: $(this).attr('title'),
									start: $(this).attr('start'),
									end: $(this).attr('end'),
									className: $(this).attr('className'),
									allDay : $(this).attr('allDay'),
								});
							});
							callback(events);
						},error: function (params) {
							console.log(params.responseText);
						}
					});
				}
			}], 

		/*Enlace para cargar los eventos de la base de datos*/
		events:'../controlador/calendario_poa_academico.php?op=mostrarAcademica',
			/*Función para abrir el modal*/
		eventClick:function(calEvent,jsEvent,view){
			/*Título del evento*/
			$('#calendariopoatitle').html(calEvent.title);
			var fecha_meta = getDatennow(calEvent.start["_i"]);
			$('#fecha_meta').html(fecha_meta);
			$('#quien_verifica').html(calEvent.meta_valida);
			var id_compromiso = calEvent.id_compromiso;
			var nombreCompromiso = cargarAccion(id_compromiso);
			/*Línea para abrir el modal*/
			$("#modalcalendariopoa").modal({backdrop: 'static', keyboard: false});
		},
		editable:false,
		})
		/*Fin $(function)*/
	});

	/*Funcion para cargar datos de compromiso*/
	// function cargarCompromiso(id_compromiso){
	// 	$.ajax({
	// 		type:'POST',
	// 		url:'../controlador/calendario_poa_academico.php?op=cargarCompromiso',
	// 		data:{id_compromiso:id_compromiso},
	// 		success:function(msg){
	// 			datos = JSON.parse(msg);
	// 			$('#nombre_compromiso').html(datos[0]['compromiso_nombre']);
	// 			cargarUsuario(datos[0]['id_usuario']);
	// 		},
	// 				error:function(){
	// 			alert("Hay un error...");
	// 		}
	// 	});
	// }

	/*Funcion para cargar datos de compromiso*/
	function cargarAccion(id_proyecto){
		$.ajax({
			type:'POST',
			url:'../controlador/calendario_poa_general.php?op=cargarAccion',
			data:{id_proyecto:id_proyecto},
			success:function(msg){
				datos = JSON.parse(msg);
				
			},
					error:function(){
				alert("Hay un error...");
			}
		});
	}

	/*Función */
	function cargarUsuario(id_usuario){
		$.ajax({
			type:'POST',
			url:'../controlador/calendario_poa_academico.php?op=cargarUsuario',
			data:{id_usuario:id_usuario},
			success:function(msg){
				datos = JSON.parse(msg);
				$('#imagen_dependencia').html('<img class="align-self-center mr-3" src="../files/usuarios/'+datos[0]["usuario_imagen"]+'" alt="'+datos[0]["usuario_nombre"]+" "+datos[0]["usuario_apellido"]+'" class="media-object" style="width: 100px;height: 120px;border-radius: 4px;box-shadow: 0 1px 3px rgba(0,0,0,.15);">');
				$('#dependencia').html(datos[0]["usuario_cargo"]);
				$('#fijo').html(datos[0]["usuario_telefono"]);
				$('#celular').html(datos[0]["usuario_celular"]);
				$('#nombre_encargado').html(datos[0]["usuario_nombre"]+" "+datos[0]["usuario_nombre_2"]+" "+datos[0]["usuario_apellido"]+" "+datos[0]["usuario_apellido_2"]);
			},
			error:function(){
				alert("Hay un error...");
			}
		});
	}
	/*Formato de la fecha*/
	function getDatennow(flag){
	var today = new Date(flag);
	var dd = today.getDate();
	var mm = today.getMonth() + 1; //January is 0!
	var yyyy = today.getFullYear();
	var hh = today.getHours();
	var mi = today.getMinutes();
	var ss = today.getSeconds();
	if (dd < 10) {
		dd = '0' + dd;
	} 
	if (mm < 10) {
		mm = '0' + mm;
	}
	if (mi < 10) {
		mi = '0' + mi;
	} 
	if (hh < 10) {
		hh = '0' + hh;
	} 
	if (ss < 10) {
		ss = '0' + ss;
	}

	if(flag){

		var days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
		const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
		"Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
		var date = days[today.getDay()]+' '+ dd +' de ' + monthNames[today.getMonth()]+' del '+ yyyy ;
		//today = dd + '/' + mm + '/' + yyyy+ " Hora:  " + hh + ":" + mi + ":" + ss;
		return date;

	}else{
		date = yyyy + '-' + mm + '-'+dd ;
		return date;
	}	
	}