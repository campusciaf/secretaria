$(document).ready(incio);
//funcion inicial para realizar consultas basicas

function incio() {
    $("#precarga").hide();
    $('[data-toggle="tooltip"]').tooltip();

    $("#formReservas").on("submit", function (e) {
        e.preventDefault();
        aggReserva();
    });

    listarHoras();
    actulizarEstado();
}
//actualiza los salones que ya el docente a finalizado
function actulizarEstado() {
    $.ajax({
        url: "../controlador/disponibilidad_salones_admin.php?op=actualizarEstado",
        type: "POST",
        success: function (e) { }
    });
}
//lista todas las horas iniciales y finales
function listarHoras() {
    $.post(
        "../controlador/disponibilidad_salones_admin.php?op=selectHora",
        function (r) {
            $("#hora, #hasta").html(r);
            $("#hora, #hasta").selectpicker("refresh");
        }
    );
}
//Listar Horas restantes    
function ajustarhasta(hora) {
    $.post(
        "../controlador/disponibilidad_salones_admin.php?op=selectHasta",
        { hora: hora },
        function (r) {
            $("#hasta").html(r);
            $("#hasta").selectpicker("refresh");
        }
    );
}

function consultarSalones(sede) {
    $.post(
        "../controlador/disponibilidad_salones_admin.php?op=consultarSalones",
        { sede: sede },
        function (datos) {
            var r = JSON.parse(datos);
            $("#salon_nivel").html(r);
        }
    );
}

function iniciarCalendario(codigo_salon, estado_formulario) {
    $("#salonconsultado").html("Salón: " + codigo_salon);
    $("#calendar").fullCalendar("destroy");
    $("#calendar").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title"
        },
        buttonText: {
            today: "Hoy",
            month: "Mes",
            week: "Semana",
            day: "Día"
        },
        defaultView: "agendaWeek", // Cambiado a vista semanal
        allDaySlot: false, // Ocultar franja para eventos de todo el día
        slotDuration: "00:30:00", // Intervalos de 30 minutos
        axisFormat: "h:mm A", // Formato de hora con AM/PM
        timeFormat: "h:mm A", // Formato de hora con AM/PM
        minTime: "06:00:00", // Mostrar horas desde las 6 AM
        maxTime: "23:00:00", // Mostrar horas hasta las 10 PM
        nowIndicator: true, // Línea para la hora actual
        editable: false,
        slotLabelFormat: "h:mm A", // Formato de hora en las ranuras (AM/PM)
        events: function (start, end, timezone, callback) {
            $.ajax({
                url: "../controlador/disponibilidad_salones_admin.php?op=iniciarcalendario",
                type: "POST",
                data: {
                    codigo_salon: codigo_salon,
                    startDate: start.format("YYYY-MM-DD"),
                    endDate: end.format("YYYY-MM-DD")
                },
                success: function (response) {
                    var eventos = JSON.parse(response);
                    var eventosFormateados = eventos.map(function (evento) {
                        return {
                            title: evento.title,
                            dow: evento.daysOfWeek,
                            start: evento.startTime,
                            end: evento.endTime,
                            color: evento.color || "#fff"
                        };
                    });
                    // Verifica que los eventos estén correctamente formateados
                    // console.log("Eventos formateados", eventosFormateados);
                    callback(eventosFormateados);
                },
                error: function (xhr, status, error) {
                    console.error("Error cargando eventos:", xhr.responseText);
                }
            });
        },
        timezone: "local", // Esto asegura que FullCalendar usa la zona horaria local
        /* Función para capturar el clic en un día */
        dayClick: function (date) {
            $("#nombresalon").html(codigo_salon);
            $("#eventDate").val(date.format("YYYY-MM-DD"));
            $("#fecha_reserva").val(date.format("YYYY-MM-DD"));
            $("#fechaseleccionada").html(date.format("dddd, D [de] MMMM"));
            $("#codigo_salon").val(codigo_salon);
            $("#estado_formulario").val(estado_formulario);

            var selectedHour = date.hour(); // Hora seleccionada (en formato de 24 horas)
            var selectedMinute = date.minute(); // Minutos seleccionados
            // Redondear el minuto de inicio al múltiplo de 5 más cercano
            selectedMinute = Math.floor(selectedMinute / 5) * 5;
            if (selectedMinute === 60) {
                // Si los minutos redondean a 60, ajustarlos
                selectedMinute = 0;
                selectedHour += 1; // Sumamos 1 a la hora
            }
            // Establecer la hora de inicio en el campo "startTime"
            var formattedStartTime =
                ("0" + selectedHour).slice(-2) +
                ":" +
                ("0" + selectedMinute).slice(-2);

            let f1 = date.format("YYYY-MM-DD")+" "+formattedStartTime;
            // Convertir a objeto Date
            let fecha1 = new Date(f1);
            let fecha2 = new Date();

            // Diferencia en milisegundos
            let diffMs = Math.abs(fecha2 - fecha1);

            // Convertir a horas
            let diffHoras = diffMs / (1000 * 60 * 60);
            if (estado_formulario == 1 && diffHoras <= 72) {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Faltan " + Number((72 - diffHoras).toFixed(2)) + " Horas para agendar este salón",
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                //iniciamos la funcion para que cuando abran el formulario unicamente se oculten o se muestren los inputs requeridos.
                aplicarEstadoFormulario(codigo_salon);
                // ajustamos el tama;o del modal dependiendo del id que colocamos en la funcion
                ajustarTamanoModal(estado_formulario);
                // Obtener la hora de inicio seleccionada en FullCalendar
                var selectedHour = date.hour(); // Hora seleccionada (en formato de 24 horas)
                var selectedMinute = date.minute(); // Minutos seleccionados
                // Redondear el minuto de inicio al múltiplo de 5 más cercano
                selectedMinute = Math.floor(selectedMinute / 5) * 5;
                if (selectedMinute === 60) {
                    // Si los minutos redondean a 60, ajustarlos
                    selectedMinute = 0;
                    selectedHour += 1; // Sumamos 1 a la hora
                }
                // Establecer la hora de inicio en el campo "startTime"
                var formattedStartTime =
                    ("0" + selectedHour).slice(-2) +
                    ":" +
                    ("0" + selectedMinute).slice(-2);
                $("#startTime").val(formattedStartTime); // Establece la hora de inicio
                // Para la hora de finalización, sumamos 5 minutos a la hora de inicio
                selectedMinute += 45; // Incrementamos los minutos en 5
                if (selectedMinute >= 60) {
                    selectedHour += Math.floor(selectedMinute / 60); // Incrementamos las horas necesarias
                    selectedMinute = selectedMinute % 60; // Tomamos los minutos restantes
                }
                // Redondeamos la hora de finalización también
                var formattedEndTime =
                    ("0" + selectedHour).slice(-2) +
                    ":" +
                    ("0" + selectedMinute).slice(-2);
                // Asignar el valor redondeado al campo endTime (hora de finalización)
                $("#endTime").val(formattedEndTime); // Establecer la hora de finalización
                // Validación en el campo de tiempo para que no se pueda seleccionar algo diferente a múltiplos de 5 minutos
                $("#endTime").on("input", function () {
                    var timeValue = $(this).val(); // Obtener el valor del campo de tiempo
                    var parts = timeValue.split(":"); // Separar hora y minutos
                    var minutes = parseInt(parts[1]);
                    // Si los minutos no son múltiplos de 5, corregirlo
                    if (minutes % 5 !== 0) {
                        var correctedMinutes = Math.floor(minutes / 5) * 5;
                        if (correctedMinutes === 60) correctedMinutes = 0;
                        var correctedTime =
                            parts[0] + ":" + ("0" + correctedMinutes).slice(-2);
                        $(this).val(correctedTime); // Establecer el valor corregido
                    }
                });
                $("#modalReserva").modal({ backdrop: "static", keyboard: false });

            }
        },
        /* Función para manejar clics en un evento */

        // eventClick: function (calEvent) {
        //     eventId = calEvent.id;
        //     // Mostrar el botón de eliminar
        //     $('#botonEliminar').show();
        //     // Colocar el título del evento en el modal
        //     $('#modalReserva').html(calEvent.title);
        //     // Rellenar los campos con la información del evento
        //     $('#id').val(calEvent.id);
        //     $('#eventTitle').val(calEvent.title);
        //     // Obtener la fecha del evento (formateada para el input de tipo 'date')
        //     var eventDate = moment(calEvent.start).format('YYYY-MM-DD'); // Formato adecuado para <input type="date">
        //     $('#eventDate').val(eventDate);
        //     // Obtener y poner la hora de inicio en el campo 'startTime'
        //     var startTime = moment(calEvent.start).format('HH:mm'); // Usamos Moment.js para formatear la hora
        //     $('#startTime').val(startTime);
        //     // Obtener y poner la hora de fin en el campo 'endTime'
        //     var endTime = moment(calEvent.end).format('HH:mm'); // Usamos Moment.js para formatear la hora
        //     $('#endTime').val(endTime);
        //     // Colocar la descripción del evento
        //     $('#eventDescription').val(calEvent.eventDescription);
        //     // Mostrar el modal
        //     $("#modalReserva").modal({ backdrop: 'static', keyboard: false });
        // },
        viewRender: function (view, element) {
            setTimeout(function () {
                $("#calendar").fullCalendar("refetchEvents");
            }, 100);
        }
    });
}

//agrega el codigo del salon al form
function datosReserva(codigo_salon) {
    $("#formReservas")[0].reset();
    $("#codigo_salon").val(codigo_salon);
}
//Guarda la reserva
function aggReserva() {
    var estado = $("#estado_formulario").val();
    var formData = new FormData($("#formReservas")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/disponibilidad_salones_admin.php?op=aggReserva",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            var r = JSON.parse(datos);
            // console.log(r);
            if (r.conte == "1") {
                alertify.success("Reserva exitosa");
                iniciarCalendario(r.conte2, estado);
                $("#estado_formulario").val(estado);
                $("#formReservas")[0].reset();
                $("#modalReserva").modal("hide");
            } else {
                alertify.error(r.conte2);
            }
        }
    });
}
//ver reservas activas
function misReservas() {
    $("#modal-misreservas").modal("show");
    if ($.fn.DataTable.isDataTable("#table-misreservas")) {
        $("#table-misreservas").DataTable().destroy();
    }
    $("#table-misreservas")
        .dataTable({
            aProcessing: true, //Activamos el procesamiento del datatables
            aServerSide: true, //Paginación y filtrado realizados por el servidor
            stateSave: true,
            dom: "tp",
            ajax: {
                url: "../controlador/disponibilidad_salones_admin.php?op=listarmisreservas&guia=r",
                type: "get",
                dataType: "json",
                error: function (e) {
                    // console.log(e.responseText);
                }
            },
            bDestroy: true,
            iDisplayLength: 20
            //"order": [[ 0, "desc" ]]//Ordenar (columna,orden)
        })
        .DataTable();
}
//cancelar reservas
function cancelarReservas(id, salon) {
    var formData = { id: id };
    //console.table(formData);
    $.ajax({
        url: "../controlador/disponibilidad_salones_admin.php?op=cancelarReserva",
        type: "POST",
        data: formData,
        cdataType: "json",
        success: function (datos) {
            //console.log(datos);
            var datos = JSON.parse(datos);
            if (datos.exito == "1") {
                alertify.success("Eliminado Correctamente");
                misReservas();
                iniciarCalendario(salon);
            } else {
                alertify.error(datos.info);
            }
        }
    });
}
function historialReservas() {
    $("#modal-historialreservas").modal("show");
    if ($.fn.DataTable.isDataTable("#table_histo_reservas")) {
        $("#table_histo_reservas").DataTable().destroy();
    }
    $("#table_histo_reservas")
        .dataTable({
            aProcessing: true, //Activamos el procesamiento del datatables
            aServerSide: true, //Paginación y filtrado realizados por el servidor
            stateSave: true,
            dom: "tp",
            ajax: {
                url: "../controlador/disponibilidad_salones_admin.php?op=historialReservas",
                type: "get",
                dataType: "json",
                error: function (e) {
                    // console.log(e.responseText);
                }
            },
            bDestroy: true,
            iDisplayLength: 20
        })
        .DataTable();
}

function listarHoraSalones(salon) {
    $.post(
        "../controlador/disponibilidad_salones_admin.php?op=listarHoraSalones&salon=" +
        salon,
        function (datos) {
            var r = JSON.parse(datos);
            //console.log(r);
            $("#impri_horas").html(html);
            var html = "";
            html += '<th scope="col">#</th>';
            for (i = 0; i < r.length; i++) {
                html += '<th class="disabl" scope="col">' + r[i].codigo + "</th>";
            }
            $("#impri_horas").html(html);
            $("#cant_salones").val(r.length);
        }
    );
}

function listarSalones(jornada, fe) {
    var cantidad = $("#select_nivel").val();
    var fechaEnv = "";

    if (fe !== "") {
        fechaEnv = fe;
    }

    $.post(
        "../controlador/disponibilidad_salones_admin.php?op=listarSalones&jornada=" +
        jornada +
        "&cantidad=" +
        cantidad +
        "&fecha=" +
        fechaEnv,
        function (data) {
            //console.log(data);
            var r = JSON.parse(data);
            $(".imprime_table").html(r.table);

            $("#table_listar_salones").DataTable({
                iDisplayLength: 30,
                ordering: false
            });
            /* $('#table_listar_salones').dataTable(
              {
                  "aProcessing": true,//Activamos el procesamiento del datatables
                  "aServerSide": true,//Paginación y filtrado realizados por el servidor
                  responsive: true,
                  "dom": "tp",
                  "bDestroy": true,
                  "iDisplayLength": 30,
                  //"order": [[ 0, "desc" ]]//Ordenar (columna,orden)
              }).DataTable(); */
        }
    );
}

function reservaSalon(id_hora, id) {
    $("#modal_reserva").modal("show");
    $("td").click(function () {
        var $this = $(this);
        var col = $this.index();
        var row = $this.closest("tr").index();
        var piso = $("#select_nivel").val();
        $.post(
            "../controlador/disponibilidad_salones_admin.php?op=consultaSalon",
            { piso: piso },
            function (data) {
                //console.log(data);
                var r = JSON.parse(data);
                $("#salon").val(r[col - 1].codigo);
                $("#hora").val(id_hora);
                $("#id_docente").val(id);
                $("#fecha").val($("#fecha_busqueda").val());
            }
        );
    });
    $("#h_inicio").html(consultaHoraI(id_hora));
    var jornada = $("#select_jornada").val();
    consultaHoraF(id_hora, jornada);
}

function consultaHoraI(hora) {
    var data = {
        id: hora
    };

    $.ajax({
        url: "../controlador/disponibilidad_salones_admin.php?op=consultaHoraI",
        type: "POST",
        data: data,
        cdataType: "json",
        success: function (r) {
            var datos = JSON.parse(r);
            $("#h_inicio").html(
                '<option value="' + datos.id_horas + '">' + datos.formato + "</option>"
            );
        }
    });
}

function consultaHoraF(hora, jornada) {
    var data = {
        id: hora,
        jornada: jornada
    };

    $.ajax({
        url: "../controlador/disponibilidad_salones_admin.php?op=consultaHoraF",
        type: "POST",
        data: data,
        cdataType: "json",
        success: function (r) {
            //console.log(r);
            var datos = JSON.parse(r);
            var opti = "";
            //console.log(datos);
            opti +=
                '<option value="" selected disabled > -Seleccione la hora final-</option>';
            for (index = 0; index < datos.length; index++) {
                opti +=
                    '<option value="' +
                    datos[index].id_horas +
                    '">' +
                    datos[index].formato +
                    "</option>";
            }

            $("#h_fin").html(opti);
        }
    });
}

function cerrarModal() {
    $("#salon").val("");
    $("#hora").val("");
    $("#id_docente").val("");
    $("#descripcion").val("");
    $("#h_fin").html("");
}

function mostrar_datos_personales_usuarios() {
    $.post(
        "../controlador/disponibilidad_salones_admin.php?op=mostrar_datos_personales_usuarios",
        {},
        function (data) {
            // console.log(data);
            data = JSON.parse(data);
            if (Object.keys(data).length > 0) {
                $("#nombre_docente").val(
                    data.usuario_nombre +
                    " " +
                    data.usuario_nombre_2 +
                    " " +
                    data.usuario_apellido +
                    " " +
                    data.usuario_apellido_2
                );
                $("#correo_docente").val(data.usuario_email);
                $("#telefono_docente").val(data.usuario_celular);
            }
        }
    );
}

function ocultarPrograma() {
    if ($("#programa").val() === "otro") {
        $("#programa_otro_wrap").removeClass("d-none");
        $("#programa_otro").prop("required", true);
    } else {
        $("#programa_otro_wrap").addClass("d-none");
        $("#programa_otro").prop("required", false).val("");
    }
}

function ocultarAsistentes() {
    if ($("#asistentes").val() === "otro") {
        $("#asistentes_otro_wrap").removeClass("d-none");
        $("#asistentes_otro").prop("required", true);
    } else {
        $("#asistentes_otro_wrap").addClass("d-none");
        $("#asistentes_otro").prop("required", false).val("");
    }
}

function aplicarEstadoFormulario() {
    mostrar_datos_personales_usuarios();
    var estado = $("#estado_formulario").val();
    if (estado == "1") {
        // $("#lugar").on("change", ocultarLugar);
        $("#programa").on("change", ocultarPrograma);
        $("#asistentes").on("change", ocultarAsistentes);
        // campos requeridos para el formulario cuando es igual a 1
        $("#ocultar_campos_formulario").show();
        $("#ocultar_campos_formulario_normal").hide();
        // $("#startTime").prop("disabled", false).prop("required", true);
        $("#startTime").prop("disabled", false).prop("required", true).prop("readonly", true);
        $("#endTime").prop("disabled", false).prop("required", true);
        $("#nombre_docente").prop("disabled", false).prop("required", true);
        $("#correo_docente").prop("disabled", false).prop("required", true);
        $("#telefono_docente").prop("disabled", false).prop("required", true);
        $("#programa").prop("disabled", false).prop("required", true);
        $("#asistentes").prop("disabled", false).prop("required", true);
        $("#materia_evento").prop("disabled", false).prop("required", true);
        $("#duracion_horas").prop("disabled", false).prop("required", true);
        // $("#lugar").prop("disabled", false).prop("required", true);
        $("#experiencia_nombre").prop("disabled", false).prop("required", true);
        $("#experiencia_objetivo").prop("disabled", false).prop("required", true);
        $("#fecha_reserva").prop("disabled", false).prop("required", true);
        $("#novedad").prop("disabled", false).prop("required", true);
        // ocultamos los campos que no necesitamos
        $("#motivo_reserva").prop("disabled", true).prop("required", false).val("");
    } else {
        // campos que mostramos.
        $("#ocultar_campos_formulario_normal").show();
        $("#ocultar_campos_formulario").hide();
        $("#motivo_reserva").prop("disabled", false).prop("required", true);
        // $("#startTime").prop("disabled", false).prop("required", true);
        $("#startTime").prop("disabled", false).prop("required", true).prop("readonly", false);
        $("#endTime").prop("disabled", false).prop("required", true);
        $("#fecha_reserva").prop("disabled", false).prop("required", true);
        //en caso de que sea 0 deshabilitamos los campos del formulario para solo dejarlos los que estaban antes.
        $("#nombre_docente").prop("disabled", true).prop("required", false).val("");
        $("#correo_docente").prop("disabled", true).prop("required", false).val("");
        $("#telefono_docente")
            .prop("disabled", true)
            .prop("required", false)
            .val("");
        $("#programa").prop("disabled", true).prop("required", false).val("");
        $("#asistentes").prop("disabled", true).prop("required", false).val("");
        $("#materia_evento").prop("disabled", true).prop("required", false).val("");
        $("#duracion_horas").prop("disabled", true).prop("required", false).val("");
        // $("#lugar").prop("disabled", true).prop("required", false).val("");
        $("#experiencia_nombre")
            .prop("disabled", true)
            .prop("required", false)
            .val("");
        $("#experiencia_objetivo")
            .prop("disabled", true)
            .prop("required", false)
            .val("");
        $("#novedad").prop("disabled", true).prop("required", false).val("");
    }
}

function ajustarTamanoModal(estado) {
    // buscamos el modal al que le queremos cambiar el tamaño
    var modal = $("#modalReserva .modal-dialog");
    modal.removeClass("modal-sm");
    if (estado == 1) {
        modal.addClass("modal-xl");
    }
}

function finalizaReservas() {
    $("#modal-reservasfinali").modal("show");

    if ($.fn.DataTable.isDataTable("#table_reservas_finali")) {
        $("#table_reservas_finali").DataTable().destroy();
    }

    $("#table_reservas_finali")
        .dataTable({
            aProcessing: true, //Activamos el procesamiento del datatables
            aServerSide: true, //Paginación y filtrado realizados por el servidor
            responsive: true,
            stateSave: true,
            dom: "tp",
            ajax: {
                url: "../controlador/disponibilidad_salones_admin.php?op=listarmisreservas&guia=f",
                type: "get",
                dataType: "json",
                error: function (e) {
                    // console.log(e.responseText);
                }
            },

            bDestroy: true,
            iDisplayLength: 20
            //"order": [[ 0, "desc" ]]//Ordenar (columna,orden)
        })
        .DataTable();
}
