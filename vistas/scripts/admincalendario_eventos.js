function init() {
	listarEventos();
	calendario();
	listarActividad(0);
	actividades();
	$("#contenido2").hide();
	$("#seleccionar_periodo").hide();
	// tomamos el año actual.
	const anioActual = new Date().getFullYear();
    $.post("../controlador/admin_calendario_eventos.php?accion=listar_anios", function (r) {
        $("#anio_filtro").html(r);
        $("#anio_filtro").selectpicker("refresh");
        // Seleccionar automáticamente el año actual y dependiendo si cambian el año 
        $("#anio_filtro").val(anioActual).selectpicker("refresh");
        $("#dato_periodo").html(anioActual);
    });
	// en esta parte se refresca la tabla con el año filtrado
	$("#anio_filtro").on("change", function () {
    todosEventosPorPeriodo();
});
}

// guarda el tipo de asistente 
function formagregarasistente() {
	$("#agregarasistente").on("submit", function (e) {
		guardarasistente(e);
	});
}
// *************************
function agregarTotal(id_calendario_asistente, id_evento, campo) {
	var total = $("#total" + campo).val();
	$.post("../controlador/admin_calendario_eventos.php?accion=guardarparticipantes", { id_calendario_asistente: id_calendario_asistente, id_evento: id_evento, total: total }, function (datos) {
		datos = JSON.parse(datos);
		if (datos.contenido == 1) {
			alertify.success("Número particiantes correcto");
			gestionEvento(datos.contenidoid);
		} else {
			alertify.error("Error");
		}
	});
}
function listarActividad(id_actividad) {
	$.post("../controlador/admin_calendario_eventos.php?accion=selectActividad", { id_actividad: id_actividad }, function (r) {
		$("#txtActividadTipo").html(r);
		$('#txtActividadTipo').selectpicker('refresh');
	});
}
//Función para listar todos los eventos
function todosEventos() {
	$.post("../controlador/admin_calendario_eventos.php?accion=todos-eventos", {}, function (datos) {
		datos = JSON.parse(datos);
		$("#todos_eventos").html(datos.contenido);
		ejecutaeventos();
		$("#contenido1").hide();
		$("#contenido2").show();
		$("#resultado_eventos").hide();
	});
}
//Función para listar todos los eventos
function volver() {
	$("#precarga").show();
	listarEventos();
	calendario();
	listarActividad(0);
	actividades();
	$("#contenido2").hide();
	$("#contenido1").show();
	$("#resultado_eventos").show();

}
//Función para listar los eventos
function listarEventos() {
	$.post("../controlador/admin_calendario_eventos.php?accion=listar-eventos", {}, function (datos) {
		datos = JSON.parse(datos);
		$("#resultado_eventos").html(datos.contenido);
		tarjetaeventos();
		$("#precarga").hide();
	});
}

//Función para listar los eventos
function actividades() {
	$.post("../controlador/admin_calendario_eventos.php?accion=actividades", {}, function (datos) {
		datos = JSON.parse(datos);
		$("#actividades").html(datos.contenido);
	});
}

function calendario() {
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
		var d = date.getDate(),
			m = date.getMonth(),
			y = date.getFullYear()
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			buttonText: {
				today: 'Hoy',
				month: 'Mes',
				week: 'Semana',
				day: 'Día'
			},
			/*Función para capturar la información del día seleccionado*/
			dayClick: function (date, jsEvent, view) {
				LimpiarFormulario();
				/*Visualizacion de eventos del CRUD*/
				$('#botonAgregar').show();
				$('#botonModificar').hide();
				$('#botonEliminar').hide();
				$("#txtFechaInicio").val(date.format());
				var dateObj = new Date(date.format());
				dateObj.setDate(dateObj.getDate() + 1);
				var month = dateObj.getUTCMonth() + 1; //months from 1-12
				var day = dateObj.getUTCDate();

				if (month < 10) {
					month = "0" + month;
				}
				if (day < 10) {
					day = "0" + day;
				}

				var year = dateObj.getUTCFullYear();
				newdate = year + "-" + month + "-" + day;
				$("#txtFechaFin").attr({ "min": newdate });
				$("#modalCalendario").modal({ backdrop: 'static', keyboard: false });
				// $("#modalCalendarioalerta").modal({backdrop: 'static', keyboard: false});

			},

			/*Enlace para cargar los eventos de la base de datos*/
			events: '../controlador/admin_calendario_eventos.php',
			/*Función para abrir el modal*/
			eventClick: function (calEvent, jsEvent, view) {
				/*Visualizacion de eventos del CRUD*/
				$('#botonAgregar').hide();
				$('#botonModificar').show();
				$('#botonEliminar').show();
				/*Título del evento*/
				$('#modalCalendarioLabel').html(calEvent.title);
				$('#modalCalendarioalertaLabel').html(calEvent.title);
				/*Mostrar la información del evento*/
				$('#idActividad').val(calEvent.id);
				$('#txtTitulo').val(calEvent.title);
				FechaInicio = calEvent.start._i.split(" ");
				$('#txtFechaInicio').val(FechaInicio[0]);
				/*Si se quiere habilitar la hora
				se debe establecer la linea
				FechaInicio[1]*/
				FechaFin = calEvent.end._i.split(" ");
				$('#txtFechaFin').val(FechaFin[0]);
				/*Si se quiere habilitar la hora
				se debe establecer la linea
				FechaFin[1]*/
				$("#txtDescripcion").val(calEvent.descripcion);
				$("#txtTime").val(calEvent.hora);
				$('#txtActividadTipo').val(calEvent.id_actividad);
				$('#txtActividadTipo').selectpicker('refresh');
				/*Línea para abrir el modal*/
				$("#modalCalendario").modal({ backdrop: 'static', keyboard: false });
				$("#modalCalendarioalerta").modal({ backdrop: 'static', keyboard: false });
				listarActividad(calEvent.id_actividad);
				actividades();

			},
			editable: false,
			eventDrop: function (calEvent) {
				/*Capturar la información del evento que se va a arrastrar*/
				$('#idActividad').val(calEvent.id);
				$('#txtTitulo').val(calEvent.title);
				var fechaInicio = calEvent.start.format().split("T");
				$('#txtFechaInicio').val(fechaInicio[0]);
				/*Si se quiere habilitar la hora
				se debe establecer la linea
				fechaInicio[1]*/
				var fechaFin = calEvent.end.format().split("T");
				$('#txtFechaFin').val(fechaFin[0]);
				/*Si se quiere habilitar la hora
				se debe establecer la linea
				fechaFin[1]*/
				$("#txtDescripcion").val(calEvent.descripcion);
				$("#txtTime").val(calEvent.hora);
				$('#txtActividadTipo').val(calEvent.id_actividad);
				$('#txtActividadTipo').selectpicker('refresh');
				/* Enviar información para modificar el evento*/
				RecolectarDatosGUI();
				EnviarInformacion('modificar', NuevoEvento, true);
				listarActividad(calEvent.id_actividad);


			},
		})

		/*Función para agregar eventos al calendario*/
		var NuevoEvento;
		$('#botonAgregar').click(function () {
			var boolean_data = RecolectarDatosGUI();
			verificar(boolean_data, "agregar");
		});
		/*Función para eliminar eventos del calendario*/
		$('#botonEliminar').click(function () {
			var boolean_data = RecolectarDatosGUI();
			verificar(boolean_data, "eliminar");
		});
		/*Función para modificar eventos del calendario*/
		$('#botonModificar').click(function () {
			var boolean_data = RecolectarDatosGUI();
			verificar(boolean_data, "modificar");

		});

		/*Función para recolectar los datos de la interfaz de usuario*/
		function RecolectarDatosGUI() {
			/*Validar que los campos no estén vacíos*/
			if ($('#txtTitulo').val().trim() == '') {
				return false;
			} else if ($('#txtFechaInicio').val().trim() == '') {
				return false;
			} else if ($('#txtFechaFin').val().trim() == '') {
				return false;
			} else if ($('#txtTime').val().trim() == '') {
				return false;
			} else if ($('#txtActividadTipo').val() == '') {
				return false;
			}
			/* Validar que la fecha final sea mayor a la fecha
			inicio para que deje crear el evento sin problemas */
			if ($('#txtFechaFin').val() <= $('#txtFechaInicio').val()) {

				return 1;
			}

			NuevoEvento = {
				id: $('#idActividad').val(),
				title: $('#txtTitulo').val(),
				start: $('#txtFechaInicio').val(),
				end: $('#txtFechaFin').val(),
				time: $('#txtTime').val(),
				descripcion: $("#txtDescripcion").val(),
				id_actividad: $('#txtActividadTipo').val(),
			};
		}

		/*Función para recolectar los datos de la interfaz de usuario*/
		function verificar(boolean_data, accion) {
			if (boolean_data == false) {
				alert("No es posible agregar el evento si no están todos los campos diligenciados.");
			} else if (boolean_data == 1) {
				alert("No se puede generar el evento con una fecha menor o igual a la Fecha de Inicio");
			} else {
				EnviarInformacion(accion, NuevoEvento);
			}
		}
		/*función para enviar los datos al controlador 

		para ser procesados*/
		function EnviarInformacion(accion, objEvento, modal) {
			$.ajax({
				type: 'POST',
				url: '../controlador/admin_calendario_eventos.php?accion=' + accion,
				data: objEvento,
				success: function (msg) {

					if (msg) {
						$('#calendar').fullCalendar('refetchEvents');
						if (!modal) {
							$("#modalCalendario").modal('toggle');
							// $("#modalCalendarioalerta").modal('toggle');
						}
						listarEventos();
						actividades();
					}
				},
				error: function () {
					alert("Hay un error...");
				}
			});
		}

		/*Fin $(function)*/
	});
}
/* Función para limpiar el formulario al momento de cancelar la acción*/
function LimpiarFormulario() {
	$('#modalCalendarioLabel').html('Agregar Evento');
	// $('#modalCalendarioalertaLabel').html('Agregar Evento');
	$('#idActividad').val('');
	$('#txtTitulo').val('');
	$("#txtDescripcion").val('');
	$('#txtFechaInicio').val('');
	$('#txtFechaFin').val('');
	$("#txtTime").val('');
	$('#txtActividadTipo').val('');
}


function ejecutaeventos() {
	// -------------------------------------------------------------
	//   Centered Navigation
	// -------------------------------------------------------------
	(function () {
		var $frame = $('#forcecentered');
		var $wrap = $frame.parent();

		// Call Sly on frame
		$frame.sly({
			horizontal: 1,
			itemNav: 'centered',
			smart: 1,
			activateOn: 'click',
			mouseDragging: 1,
			touchDragging: 1,
			releaseSwing: 1,
			startAt: 3,
			scrollBar: $wrap.find('.scrollbar'),
			scrollBy: 1,
			speed: 300,
			elasticBounds: 1,
			easing: 'easeOutExpo',
			dragHandle: 1,
			dynamicHandle: 1,
			clickBar: 1,

			// Buttons
			prev: $wrap.find('.prev'),
			next: $wrap.find('.nextbtn'),
			// Cycling
			cycleBy: 'items',
			cycleInterval: 3000,
			pauseOnHover: 1,
		});
	}());
}

function gestionEvento(id_evento) {

	$.post("../controlador/admin_calendario_eventos.php?accion=gestionEvento", { id_evento: id_evento }, function (datos) {
		datos = JSON.parse(datos);
		$("#resultado_gestion").html(datos.contenido);
		ejecutaeventos();
		$("#gestioneventos").modal("show");

		formagregarasistente();// trae el formulario para agregar el tipo de asistente



	});

}

//Función para guardar o editar

function guardarasistente(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#agregarasistente")[0]);

	$.ajax({
		url: "../controlador/admin_calendario_eventos.php?accion=guardarasistente",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			datos = JSON.parse(datos);

			if (datos.contenido == 1) {
				alertify.success("Asistente Correcto");
				gestionEvento(datos.contenidoid);
			} else {
				alertify.error("Error");
			}


		}

	});
}

function todosEventosPorPeriodo() {
    ejecutaeventos();
	todosEventos();
    $("#contenido1").hide();
    // $("#contenido2").show();
    $("#seleccionar_periodo").show();
    $("#resultado_eventos").hide();
    $("#precarga").show();
    var periodoSeleccionado = $("#anio_filtro").val(); 
    // $("#dato_periodo").html(periodoSeleccionado);
    var f = new Date();
    var meses = [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ];
    var diasSemana = [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ];
    var fecha = `${diasSemana[f.getDay()]}, ${f.getDate()} de ${meses[f.getMonth()]} de ${f.getFullYear()}`;
    tabla = $('#tbllistaeventos').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
            {
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Exportar Excel',
				customize: function(xlsx) {
					const sheet = xlsx.xl.worksheets['sheet1.xml'];

					$('row', sheet).each(function(index) {
						// Saltamos la primera fila (encabezado)
						if (index === 0) return;
						// Celdas de la fila
						const actividadCell = $('c', this)[1]; // Segunda columna = Actividad
						const actividadTexto = $('v', actividadCell).text();
						// Cambiar el estilo basado en el texto
						let estilo = '0'; // Estilo por defecto
						switch (actividadTexto) {
							case 'Desarrollo Humano': estilo = '25'; break; // fucsia
							case 'Cultural': estilo = '26'; break; // amarillo
							case 'Deportivo y Recreativo': estilo = '27'; break; // verde
							case 'Egresados': estilo = '28'; break;
							case 'Salud': estilo = '29'; break;
							case 'Semana Original': estilo = '30'; break;
						}
						// Asignamos el estilo a la celda
						$(actividadCell).attr('s', estilo);
					});
				}
			},
            {
                extend: 'print',
                text: '<i class="fa fa-file-pdf fa-2x" style="color: red"></i>',
                messageTop: `<div style="width:50%;float:left">Reporte Influencer<br><b>Fecha de Impresión</b>: ${fecha}</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>`,
                title: 'Reporte Influencer',
                titleAttr: 'Print'
            },
        ],
        "ajax": {
            url: '../controlador/admin_calendario_eventos.php?accion=todos-eventos-por-periodo',
            type: 'POST',
            data: { periodoSeleccionado: periodoSeleccionado }, 
            dataType: "json",
            error: function (e) {
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]],
        'initComplete': function () {
            $("#precarga").hide();
            scroll(0, 0);
        },
    });
}

//Función para activar registros
function eliminarasistente(id_calendario_asistente, id_evento) {
	alertify.confirm("Eliminar asistente", "¿Desea Eliminar esta asistente?", function (){
		$.post("../controlador/admin_calendario_eventos.php?accion=eliminarasistente", { id_calendario_asistente: id_calendario_asistente, id_evento: id_evento }, function (datos) {
			datos = JSON.parse(datos);
			if (datos.contenido == 1) {
				alertify.success("Asistente eliminado");
				gestionEvento(datos.contenidoid);
			}else {
				alertify.error("Error");
			}
		});
	}
	,function () { alertify.error('Cancelado') });
}


function tarjetaeventos() {
    $(".eventos").slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        arrows: false,
        responsive: [
            {
				breakpoint: 1024,
				settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                infinite: true,
                dots: true
			}
            },
            {
				breakpoint: 600,
				settings: {
				slidesToShow: 2,
				slidesToScroll: 1
                }
			},
			{
				breakpoint: 480,
				settings: {
				slidesToShow: 1,
				slidesToScroll: 1
                }
			}
        ]
    });
}




init();