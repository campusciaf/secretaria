

function inicio() {
    $("#precarga").hide();
    autenticacion();

    $("#calendarForm").on("submit", function(e) {
        guardaryeditar(e);
    });

    $("#formconclusion").on("submit", function(e2) {
        guardaryeditar2(e2);
    });
   
}


function autenticacion() {
    // Obtener el parámetro 'code' de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const code = urlParams.get('code');  // Obtiene el valor de 'code'

    // Verifica si 'code' está presente
    if (code) {
        // Ahora puedes enviar este código en la solicitud POST
        $.post("../controlador/calendar.php?op=autenticacion", { code: code }, function (data, status) {
            var r = JSON.parse(data);
            iniciarCalendario(); 
        });
    } else {

         // Envía 'null' si 'code' no está presente
         $.post("../controlador/calendar.php?op=autenticacion", { code: false }, function (data, status) {
            var r = JSON.parse(data);
                $("#ingreso").html(r.authUrl);
                iniciarCalendario(); 
        });
    }
}

var eventId = null; // Variable para almacenar el ID del evento seleccionado
var tareacodigo = null;
function iniciarCalendario() {


    $(function () {
        /* Inicializar los eventos externos */
        function init_events(ele) {
            ele.each(function () {
                var eventObject = {
                    title: $.trim($(this).text()) // Usar el texto del elemento como título del evento
                };
                $(this).data('eventObject', eventObject);
            });
            $(".precarga").hide();
        }
        init_events($('#external-events div.external-event'));

        /* Inicializar el calendario */
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

            defaultView: 'agendaDay', // Vista diaria con horas
            allDaySlot: false,        // Ocultar franja para eventos de todo el día
            slotDuration: '00:30:00', // Intervalos de 30 minutos
            axisFormat: 'h:mm A', // Formato de hora con AM/PM
            timeFormat: 'h:mm A', // Formato de hora con AM/PM
            minTime: '06:00:00',      // Mostrar horas desde las 6 AM
            maxTime: '23:00:00',      // Mostrar horas hasta las 10 PM
            nowIndicator: true,       // Línea para la hora actual
            editable: false,
            slotLabelFormat: 'h:mm A', // Formato de hora en las ranuras (AM/PM)

            events: '../controlador/calendar.php?op=autenticacion',
               


            eventDataTransform: function(event) {
                let now = new Date(); // Obtiene la fecha y hora actual
                let eventEnd = new Date(event.end); // Convierte la fecha de finalización del evento a un objeto Date

                // Aplicar el color de fondo y borde del evento
                if (eventEnd  < now) {
                    event.backgroundColor = '#d7dbef';  // Color de fondo para eventos vencidos
                    event.borderColor = '#d7dbef';      // Color de borde para eventos vencidos
                } else if (event.color) {
                    event.backgroundColor = event.color;  // Establecer color de fondo
                    event.borderColor = event.color;      // Establecer color de borde
                    //event.color = '#ffffff';              // Establecer color del texto (puedes personalizarlo)
                }
                return event;
            },


            // este fragmento de codigo sirve para agregar valores al titulo del evento
            // eventDataTransform: function(event) {
            //     if (event.organizerEmail) {
            //         event.title = event.title + " (@" + event.organizerEmail + ")";
            //     }
            //     return event;
            // },
            
            timezone: 'local',  // Esto asegura que FullCalendar usa la zona horaria local
            /* Función para capturar el clic en un día */
            dayClick: function (date) {

                LimpiarFormulario();

   
                $('#botonEliminar').hide();
                $("#eventDate").val(date.format('YYYY-MM-DD'));
                $('#fechaseleccionada').html(date.format('dddd, D [de] MMMM'));

                   // Obtener la hora de inicio seleccionada en FullCalendar
                    var selectedHour = date.hour();  // Hora seleccionada (en formato de 24 horas)
                    var selectedMinute = date.minute();  // Minutos seleccionados

                    // Establecer la hora de inicio en el campo "startTime"
                    var formattedStartTime = ("0" + selectedHour).slice(-2) + ":" + ("0" + selectedMinute).slice(-2);
                    $("#startTime").val(formattedStartTime);  // Establece la hora de inicio

                    // Establecer la hora de finalización sumando una hora a la hora de inicio
                    var endHour = selectedHour + 1;  // Sumar una hora para la hora final
                    if (endHour === 24) {  // Si la hora final es 24, cambiar a 00 (nueva jornada)
                        endHour = 0;
                    }
                    var formattedEndTime = ("0" + endHour).slice(-2) + ":" + ("0" + selectedMinute).slice(-2);
                    $("#endTime").val(formattedEndTime);  // Establecer la hora de finalización

                     // Colocar la descripción del evento
                $('#eventDescription').val(' ');
                if (CKEDITOR.instances['eventDescription']) {
					CKEDITOR.instances['eventDescription'].destroy();
				}
				CKEDITOR.replace('eventDescription', {
					width: '100%',
					height: 300
				});
                CKEDITOR.instances['eventDescription'].setData(' ');

                $('#conclusion').val(' ');
                if (CKEDITOR.instances['conclusion']) {
					CKEDITOR.instances['conclusion'].destroy();
				}
				CKEDITOR.replace('conclusion', {
					width: '100%',
					height: 300
				});
                CKEDITOR.instances['conclusion'].setData(' ');
                

       
                $("#custom-tabs-one-profile-tab").hide();
                $("#custom-tabs-one-profile-tarea").hide();
                $("#casoseleccionado").html("");
                

                $("#modalCalendario").modal({ backdrop: 'static', keyboard: false });
            },

            /* Función para manejar clics en un evento */

            eventRender: function(event, element) {
                
                let content = '<span class="badge badge-secondary btn-xs">Organizador: </span> <span class="text-white">'+ event.organizerEmail +'</span>';
                let estadotarea="";
                if(event.estadoTarea==1){
                    estadotarea= '<span class="badge badge-danger btn-xs">Pendiente</span>';
                }else if(event.estadoTarea==0){
                    estadotarea= '<span class="badge badge-success btn-xs">Terminada</span>';
                }else{
                    estadotarea="";
                }

                if(event.categoria=="admisiones"){
                    content += ' <span class="badge badge-info btn-xs">Admisiones</span>';
                    content += ' <span class="badge badge-info btn-xs">#caso: '+ event.idEstudiante +'</span>';
                    content += estadotarea;
                }else{
            
                    // Verifica si event.conclusion está vacío o no definido
                    if (!event.conclusion || event.conclusion.trim() === '') {
                        content += ' <span class="badge badge-warning btn-xs">Sin conclusiones</span>';
                    } else {
                        content += ' <span class="badge badge-success btn-xs">Con Conclusiones</span>';
                    }
                }
            
                element.append(content);
            },
            

            eventClick: function (calEvent) {
                eventId = calEvent.id;

                // Mostrar el botón de eliminar
                $('#botonEliminar').show();

                // Colocar el título del evento en el modal
                $('#modalCalendarioLabel').html(calEvent.title);

                // Rellenar los campos con la información del evento
                $('#id').val(calEvent.id);
                $('#eventTitle').val(calEvent.title);
                $('#meet').html("<a href='"+calEvent.meetLink+"' target='_blank' class='fs-14'>Unirse con Google Meet</a><br><span class='fs-12'>"+calEvent.meetLink+"<span>");

                 // Obtener la fecha del evento (formateada para el input de tipo 'date')
                var eventDate = moment(calEvent.start).format('YYYY-MM-DD'); // Formato adecuado para <input type="date">
                $('#eventDate').val(eventDate);
                
                // Obtener y poner la hora de inicio en el campo 'startTime'
                var startTime = moment(calEvent.start).format('HH:mm'); // Usamos Moment.js para formatear la hora
                $('#startTime').val(startTime);

                // Obtener y poner la hora de fin en el campo 'endTime'
                var endTime = moment(calEvent.end).format('HH:mm'); // Usamos Moment.js para formatear la hora
                $('#endTime').val(endTime);

                // Colocar la descripción del evento
                $('#eventDescription').val(calEvent.eventDescription);
                if (CKEDITOR.instances['eventDescription']) {
					CKEDITOR.instances['eventDescription'].destroy();
				}
				CKEDITOR.replace('eventDescription', {
					width: '100%',
					height: 300
				});
				// Espera a que CKEditor esté listo y luego establece el contenido
				CKEDITOR.instances['eventDescription'].setData(calEvent.eventDescription);
                

                // formulario conclusiones
                $('#id2').val(calEvent.id);
                $("#titulo2").val(calEvent.title);  // Establecer la hora de finalización
                $('#id_calendarconclusion').val(calEvent.id_calendarconclusion);
                $('#conclusion').val(calEvent.conclusion);
                if (CKEDITOR.instances['conclusion']) {
					CKEDITOR.instances['conclusion'].destroy();
				}
				CKEDITOR.replace('conclusion', {
					width: '100%',
					height: 300
				});
				// Espera a que CKEditor esté listo y luego establece el contenido
				CKEDITOR.instances['conclusion'].setData(calEvent.conclusion);
                
                if(calEvent.categoria == "admisiones"){
                    $("#custom-tabs-one-profile-tab").hide();
                    $("#custom-tabs-one-profile-tarea").show();
                    $("#casoseleccionado").html("Numero de caso: " + calEvent.idEstudiante);
                    $("#botonEliminar").hide();
                }else{
                    $("#custom-tabs-one-profile-tab").show();
                    $("#custom-tabs-one-profile-tarea").hide();
                    $("#botonEliminar").show();
                    $("#casoseleccionado").html("");
                    
                }
                
                tareacodigo=calEvent.idTarea;
                // Mostrar el modal
                $("#modalCalendario").modal({ backdrop: 'static', keyboard: false });
            },


        });

    });

    // este codigo me traer por consola los datos de los eventos
    fetch('../controlador/calendar.php?op=autenticacion')
    .then(response => response.json())
    .then(data => console.log(data));

} 


/* Función para limpiar el formulario */
function LimpiarFormulario() {
    $('#id').val('');
    $('#eventTitle').val('');
    $('#eventDescription').val('');

    $('#id2').val('');
    $('#id_calendarconclusion').val('');
    $('#conclusion').val('');
    $("#btnGuardar2").prop("disabled", false);
}

/* Función para limpiar el formulario */
function crearevento() {
    $.post("../controlador/calendar.php?op=crearevento", {}, function (data, status) {
        try {
            var r = JSON.parse(data);
            console.log("Respuesta del servidor:", r);
            if (r.success) {
                alert("Evento guardado con éxito");
            } else {
                alert("Error al guardar el evento: " + r.error);
            }
        } catch (e) {
            console.error("Error al procesar la respuesta:", data);
        }
    });
}

function guardaryeditar(e) {
    e.preventDefault();  // Previene la recarga

    // Obtener los valores de fecha y hora
    const date = document.getElementById('eventDate').value;
    const startTime = document.getElementById('startTime').value;
    const endTime = document.getElementById('endTime').value;

    var eventDescription = CKEDITOR.instances.eventDescription.getData();


    // Asegurarse de que la fecha y las horas no estén vacías
    if (!date || !startTime || !endTime) {
        console.log('Por favor, completa todos los campos de fecha y hora.');
        return;
    }

    // Combinar la fecha con la hora
    const startDateTime = `${date}T${startTime}:00`;
    const endDateTime = `${date}T${endTime}:00`;

    // Crear un nuevo FormData y añadir los campos manualmente
    var formData = new FormData($("#calendarForm")[0]);
    formData.set('startTime', startDateTime);  // Agregar la fecha completa para la hora de inicio
    formData.set('endTime', endDateTime);      // Agregar la fecha completa para la hora de finalización
    formData.set('eventDescription', eventDescription);      // Agregar la fecha completa para la hora de finalización

    

    $("#btnGuardar").prop("disabled", true);


    // Enviar los datos usando AJAX
    $.ajax({
        url: "../controlador/calendar.php?op=crearevento",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {   
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Evento Guardado",
                showConfirmButton: false,
                timer: 1500
            });
            $('#calendar').fullCalendar('refetchEvents');  // Actualiza los eventos del calendario
            $('#modalCalendario').modal('hide'); // Cierra el modal
            $("#btnGuardar").prop("disabled", false);
        },
        error: function() {
            alert('Hubo un error al enviar los datos.');
        }
    });
}

function guardaryeditar2(e2) {
    e2.preventDefault();  // Previene la recarga

    var miconclusion = CKEDITOR.instances.conclusion.getData();


    var formData = new FormData($("#formconclusion")[0]);
    formData.set('conclusion', miconclusion);      // Agregar la fecha completa para la hora de finalización
    $("#btnGuardar2").prop("disabled", true);

    // Enviar los datos usando AJAX
    $.ajax({
        url: "../controlador/calendar.php?op=conclusion",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {   
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Conclusiones Guardadas",
                showConfirmButton: false,
                timer: 1500
            });
            $('#calendar').fullCalendar('refetchEvents');  // Actualiza los eventos del calendario
            $('#modalCalendario').modal('hide'); // Cierra el modal
            $("#btnGuardar2").prop("disabled", false);
        },
        error: function() {
            alert('Hubo un error al enviar los datos.');
        }
    });
}

function validarTarea() {
	$.post("../controlador/calendar.php?op=validarTarea",{tareacodigo:tareacodigo},function(data){
			
		console.log(data);
		var r = JSON.parse(data);
		if (r.status == "ok") {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Tarea terminada",
                showConfirmButton: false,
                timer: 1500
            });
            $('#modalCalendario').modal('hide'); // Cierra el modal
			$('#calendar').fullCalendar('refetchEvents');  // Actualiza los eventos del calendario
		} else {
			alertify.success("Error");
		}		

	});
}

$('#botonEliminar').on('click', function() {
    if (eventId) {

        // Enviar una solicitud AJAX al backend para eliminar el evento
        $.ajax({
            url: "../controlador/calendar.php?op=deleteEvent",
            type: "POST",
            data: { eventId: eventId },
            success: function(response) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Evento Eliminado",
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#modalCalendario').modal('hide'); // Cierra el modal
                $('#calendar').fullCalendar('refetchEvents');  // Actualiza los eventos del calendario
            },
            error: function() {
                alert('Error al eliminar el evento');
            }
        });
    }
});

inicio()
