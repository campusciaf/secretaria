	$(function () {
		$("#precarga").hide();
		/* initialize the external events
		-----------------------------------------------------------------*/
		function init_events(ele) {
			ele.each(function () {
				// console.log(ele);
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

		// Muestra los eventos individual que estan en el calendario
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
			// eventSources: [{
			// 	events: function (start, end, timezone, callback) {
			// 		$.ajax({
			// 			url: '../controlador/calendario_poa_individual.php?op=mostrar_individual',
			// 			type: 'GET',
			// 			dataType: "JSON",
			// 			success: function (response) {
			// 				console.log(response);
			// 				var events = [];
			// 				$(response['data']).each(function () {
			// 					events.push({
			// 						id: $(this).attr('id'),
			// 						title: $(this).attr('title'),
			// 						start: $(this).attr('start'),
			// 						end: $(this).attr('end'),
			// 						className: $(this).attr('className'),
			// 						allDay : $(this).attr('allDay'),
			// 					});
			// 				});
			// 				callback(events);
			// 			},error: function (params) {
			// 				console.log(params.responseText);
			// 			}
			// 		});
			// 	}
			// }], 
			
			events:'../controlador/calendario_poa_individual.php?op=mostrar_individual',
			/*Función para abrir el modal*/
			eventClick: function(calEvent,jsEvent,view){
				/*Título del evento*/
				$('#meta_nombre').html(calEvent.title);
				// console.log(calEvent);
				var fecha_meta = getDatennow(calEvent.start["_i"]);
				$('#nombre_accion').html(calEvent.nombre_accion);
				$('#meta_fecha').html(calEvent.anio_eje);
				// $('#meta_nombre').html(meta_nombre);
				$('#meta_responsable').html(calEvent.meta_responsable);
				// var id_proyecto = calEvent.id_proyecto;
				// var nombreAccion = cargarAccion(id_proyecto);
				$("#modalcalendariopoa").modal({backdrop: 'static', keyboard: false});
				/*Línea para abrir el modal*/
			},
			editable:false,
		})

		/*Fin $(function)*/
		// $.ajax({
		// 	type:'POST',
		// 	url:'../controlador/calendario_poa_individual?op=mostrar_individual',
		// 	success:function(msg){
		// 		console.log(msg);
		// 	},
		// 	error:function(){
		// 		alert("Hay un error...");
		// 	}
		// });
	});

	/*Funcion para cargar datos de accion*/
	function cargarAccion(id_proyecto){
		$.ajax({
			type:'POST',
			url:'../controlador/calendario_poa_individual.php?op=cargarAccion',
			data: {id_proyecto:id_proyecto},
			success:function(msg){
				// alert('efewfew');
				console.log(msg);
				datos = JSON.parse(msg);
				// $('#meta_nombre').html(datos[0]['meta_nombre']);
			},
			error:function(){
				alert("Hay un error...");
			}
		});
	}

	/*Formato de la fecha*/
	function getDatennow(flag){
		// console.log(flag);
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