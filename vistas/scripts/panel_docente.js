$(document).ready(inicio);
var seleccion_actual = 1;
var estadoModalGlobal;
function inicio() {
    mostrarcheckbox();
    educacioncontinuada();
    mostrarcalendario();
    mostrarcalendarioeventos();
    ingresosCampus();
    //cajadeherramientas();
    //vershopping();
    mostrarcursosinscritos();
    // $("#modalAnuncio").modal("show");
    // listarEventosAcademicos();
    // listarEventos();
    $("#mycalendario").hide();
    $("#mycontenido").show();
    // verificarAutoevaluacion();
    verperfilactualizado();
    // encuestatic();
    // encuestaticnueva();
    // ejecutaeventos();
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });
    $("#formularioperfil").on("submit", function (e2) {
        actualizarperfil(e2);
    });
    $("#formulario-encuesta").on("submit", function (e3) {
        guardarencuestatic(e3);
    });
    $("#precarga").hide();
    $("#form-monitoreando-docente").off("submit").on("submit", function (e) {
        e.preventDefault();
        monitoreandoDocente();
    });
    // mostrarmodalmonitoreando();
}
//Función para listar los eventos
// function listarEventosAcademicos(){
// 	$.post("../controlador/paneldocente.php?op=listar-eventos-academicos",{},function(datos){
//         datos = JSON.parse(datos);
// 		$("#cal_academico_pic").html(datos.contenido);
// 		ejecutaeventos();
// 	});
// }
// //Función para listar los eventos
// function listarEventos(){
// 	$.post("../controlador/paneldocente.php?op=listar-eventos",{},function(datos){
//         datos = JSON.parse(datos);
// 		$("#cal_eventos_pic").html(datos.contenido);
// 		ejecutaeventos();
// 	});
// }
function guardarencuestatic(e3) {
    e3.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardarpregunta").hide();
    var formData = new FormData($("#formulario-encuesta")[0]);
    $.ajax({
        url: "../controlador/paneldocente.php?op=guardarencuestatic",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            data = JSON.parse(data);
            if (data == 1) {
                alertify.success("respuesta guardada");
                encuestaticnueva();
            } else {
                alertify.error("No sepudo guardar la encuesta");
                encuestaticnueva();
            }
        }
    });
}
function ingresosCampus() {
    $.post("../controlador/paneldocente.php?op=ingresosCampus", function (e) {
        var r = JSON.parse(e);
        $("#ingresosCampus").html(r.plantilla);
         
        if(r.racha==7){
            Swal.fire({
                position: "top-end",
                imageWidth: 150,
                imageHeight: 150,
                imageUrl: "../public/img/ganancia.gif",
                title: "🎯 ¡Toda la semana presente!<b> +5</b> puntos como recompensa 🤩",
                showConfirmButton: false,
                timer: 4000
            });
        }

        
        
    });
}


function iniciarTour() {
    introJs()
        .setOptions({
            nextLabel: "Siguiente",
            prevLabel: "Anterior",
            doneLabel: "Terminar",
            showBullets: false,
            showProgress: true,
            showStepNumbers: true,
            steps: [
                {
                    title: "campus docentes",
                    intro:
                        "Bienvenido líder creativo para nosotros es muy importante que seas parte este parche creativo e innovador"
                },
                {
                    title: "clases asignadas",
                    element: document.querySelector("#m-paso1"),
                    intro:
                        "Aquí podrás encontrar todas tus clases asignadas de las que serás el mejor líder creativo para nuestros seres originales"
                },
                {
                    title: "Horario",
                    element: document.querySelector("#m-paso2"),
                    intro:
                        "visualiza de manera rápida tu horario, recuerda que como líder creativo debes ser muy puntual a la hora de comenzar con la experiencia creativa"
                },
                {
                    title: "Digital",
                    element: document.querySelector("#m-paso3"),
                    intro:
                        "Encuentra algunos de nuestros recursos que te serviran de gran ayuda para hacer aún más interesante y personalizada cada una de esas experiencias"
                },
                {
                    title: "Reservas",
                    element: document.querySelector("#m-paso4"),
                    intro:
                        "Recuerda que debes reservar tu salón para cumplir con la experiencia y no solo eso si no que también brindaremos un equipo previamente reservado y asistencia técnica por si lo necesitas"
                },
                {
                    title: "Menu hoja de vida",
                    element: document.querySelector("#m-paso5"),
                    intro:
                        "Aquí podrás visualizar tu hoja de vida personal, teniendo encuenta toda la información que has llenado previamente "
                },
                {
                    title: "Carnet",
                    element: document.querySelector("#m-paso6"),
                    intro:
                        "Como líder creativo conoce los diferentes beneficios que tenemos para ti,con el uso de tu carnet institucional"
                },
                {
                    title: "Caracterización",
                    element: document.querySelector("#m-carac"),
                    intro:
                        "Podrás realizar tu caracterización para conocer un poco más de nuestro líder creativo y también para ti sea una experiencia única"
                },
                {
                    title: "Formatos institucionales",
                    element: document.querySelector("#m-paso7"),
                    intro:
                        "Para que sea más facíl para ti contamos con diferentes formatos los cuales te ayudarán en las experiencias creativas brindadas"
                },
                {
                    title: "Configuracion de la cuenta",
                    element: document.querySelector("#m-paso8"),
                    intro:
                        "Tendrás la oportunidad de personalizar tu campus virtual con tu información y nuestro nuevo modo oscuro"
                },
                {
                    title: "Salir",
                    element: document.querySelector("#m-paso9"),
                    intro:
                        "Finaliza tu dia creativo cerrando tu sesión y descansando para empezar un nuevo dia lleno de innovación y creatividad para vivir la mejor experiencia creativa junto a nuestros seres originales"
                },
                {
                    title: "Faltas",
                    element: document.querySelector("#t-paso1"),
                    intro:
                        "Aquí podras encontrar todas tus faltas reportadas con toda la información correspondiente"
                },
                {
                    title: "Actividades",
                    element: document.querySelector("#t-paso2"),
                    intro:
                        "Aquí podrás crear tus diferentes actividades creativas para las experiencias de nuestros seres originales"
                },
                {
                    title: "Casos",
                    element: document.querySelector("#t-paso3"),
                    intro:
                        "Aquí podrás encontrar diferentes casos quédate que te han asignado para asegurar la permanencia de nuestro ser original y buscar la mejor solución "
                },
                {
                    title: "Ingreso campus",
                    element: document.querySelector("#t-paso4"),
                    intro:
                        "Visualiza tus entradas al campus y ten un control de las veces que has ingresado, además tendrás una calificación dependiendo de las veces de ingreso"
                },
                {
                    title: "Siguiente clase",
                    element: document.querySelector("#t-paso5"),
                    intro:
                        "Da un vistazo a tu proxima experiencia creativa con tus seres originales"
                },
                {
                    title: "Mis perfiles",
                    element: document.querySelector("#t-paso6"),
                    intro:
                        "Aquí podrás observar la ultima actualización que ha tenido tu perfil y fecha de caracterización"
                },
                {
                    title: "Estudiantes a cargo",
                    element: document.querySelector("#t-paso7"),
                    intro:
                        "Da un vistazo a los seres originales que tienes a tu cargo con su nombre completo e identificación y la materia a la que pertenecen"
                },
                {
                    title: "Evaluación docente",
                    element: document.querySelector("#t-paso8"),
                    intro:
                        "Da un vistazo a tu evaluación como líder creativo, teniendo en cuenta todas esas sugerencias y mejorando así la experiencia creativa para ti y tus seres originales a tu cargo"
                },
                {
                    title: "Hoja de vida",
                    element: document.querySelector("#t-paso9"),
                    intro:
                        "podrás visualizar la última actualización que le has agregado a tu hoja de vida, teniendo así toda tu información al día"
                },
                {
                    title: "Calendario académico",
                    element: document.querySelector("#t-paso10"),
                    intro:
                        "Entérate de todos nuestros eventos académicos programados para ti fomentando un espacio diferente donde podrás dejarte llevar por la creatividad e innovación de nuestras experiencias creativas"
                },
                {
                    title: "Vuelvete emprendedor",
                    element: document.querySelector("#t-paso11"),
                    intro:
                        "Formate permanentemente con nuestros programas innovadores y basados en tecnologia que se amolda a los requerimientos de la empresa o comunidad para que sigas preparando e innovando en nuestro parche cretivo y educativo mas grande del eje cafetero"
                },
                {
                    title: "Calendario eventos",
                    element: document.querySelector("#t-paso12"),
                    intro:
                        "Enterate de todas nuestras experiencias transformadoras que mejoran la calidad de vida de seres originales, docentes, colaboradores y sus familias incluyendo a sus inspiradores donde construirás un lazo de confianza,amor,amistad y respeto"
                },
                {
                    title: "QR",
                    element: document.querySelector("#t-paso13"),
                    intro: "¡Tu propio QR para escanear!"
                },
                {
                    title: "Salir",
                    element: document.querySelector("#t-paso14"),
                    intro:
                        "Finaliza tu dia creativo cerrando tu sesión y descansando para empezar un nuevo día lleno de innovación y creatividad para vivir la mejor experiencia creativa junto a nuestros seres originales"
                }
            ]
        })
        .start();
    // console.log("holaaa");
}
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../controlador/paneldocente.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function () {
            alertify.success("Gracias por superar las barreras");
            $("#myModalEncuesta").modal("hide");
        }
    });
}
function actualizarperfil(e2) {
    e2.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#formularioperfil")[0]);
    $.ajax({
        url: "../controlador/paneldocente.php?op=actualizarperfil",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            data = JSON.parse(datos);
            if ((data.estado = "si")) {
                alertify.success("Datos actualizados");
                verperfilactualizado();
                limpiarperfil();
            } else {
                alertify.error("Datos no actualizados");
            }
        }
    });
}
function calendariod() {
    $.post("../controlador/admin_calendario.php", function (e) {
        // console.log(e);
    });
    $(function () {
        /* initialize the external events
            -----------------------------------------------------------------*/
        function init_events(ele) {
            ele.each(function () {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                };
                // store the Event Object in the DOM element so we can get to it later
                $(this).data("eventObject", eventObject);
            });
        }
        init_events($("#external-events div.external-event"));
        /* initialize the calendar
            -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date();
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear();
        $("#calendar").fullCalendar({
            header: {
                left: "prev,next today",
                center: "title",
                right: "month,agendaWeek,agendaDay"
            },
            buttonText: {
                today: "Hoy",
                month: "Mes",
                week: "Semana",
                day: "Día"
            },
            events: "../controlador/admin_calendario.php",
            /*Función para abrir el modal*/
            eventClick: function (calEvent, jsEvent, view) {
                /*Título del evento*/
                $("#modalCalendarioLabel").html(calEvent.title);
                /*Mostrar la información del evento*/
                $("#idActividad").val(calEvent.id);
                $("#txtTitulo").val(calEvent.title);
                FechaInicio = calEvent.start._i.split(" ");
                $("#txtFechaInicio").val(FechaInicio[0]);
                /*Si se quiere habilitar la hora
                    se debe establecer la linea
                    FechaInicio[1]*/
                FechaFin = calEvent.end._i.split(" ");
                $("#txtFechaFin").val(FechaFin[0]);
                /*Si se quiere habilitar la hora
                    se debe establecer la linea
                    FechaFin[1]*/
                /*Línea para abrir el modal*/
                $("#modalCalendario").modal({ backdrop: "static", keyboard: false });
            }
        });
    });
    /* Función para limpiar el formulario al momento de cancelar la acción*/
    function LimpiarFormulario() {
        $("#modalCalendarioLabel").html("Agregar Evento");
        $("#idActividad").val("");
        $("#txtTitulo").val("");
        $("#txtFechaInicio").val("");
        $("#txtFechaFin").val("");
        $("#txtColor").val("");
    }
}
function encuestatic() {
    $.post("../controlador/paneldocente.php?op=encuestatic", {}, function (data) {
        data = JSON.parse(data);
        if (data == "0") {
            $("#encuestatic").modal({ backdrop: "static", keyboard: false }); // linea para desahbilitar el click de cerrar
            $("#encuestatic").modal("show");
        } else {
            $("#encuestatic").modal("hide");
        }
    });
}
function encuestaticnueva() {
    $.post(
        "../controlador/paneldocente.php?op=encuestaticnueva",
        {},
        function (data) {
            data = JSON.parse(data);
            if (data == "0") {
                $("#encuestatic").modal({ backdrop: "static", keyboard: false }); // linea para desahbilitar el click de cerrar
                $("#encuestatic").modal("show");
                $.post(
                    "../controlador/paneldocente.php?op=encuestaticpreguntas",
                    {},
                    function (datar) {
                        datar = JSON.parse(datar);
                        $("#pregunta").html(datar.pregunta);
                        $("#avancepregunta").html(datar.avancepregunta);
                        $("#btnGuardarpregunta").show();
                    }
                );
            } else {
                $("#encuestatic").modal("hide");
            }
        }
    );
}
//funcion para abrir el modal de la autoevaluación
function verificarAutoevaluacion() {
    $.post(
        "../controlador/paneldocente.php?op=verificarAutoevaluacion",
        {},
        function (data) {
            data = JSON.parse(data);
            if (data == "1") {
                $("#myModalEncuesta").modal({ backdrop: "static", keyboard: false }); // linea para desahbilitar el click de cerrar
                $("#myModalEncuesta").modal("show");
            } else {
                $("#myModalEncuesta").modal("hide");
            }
        }
    );
}
function verperfilactualizado() {
    $.post(
        "../controlador/paneldocente.php?op=verperfilactualizado",
        function (datos) {
            var r = JSON.parse(datos);
            if (r.estado == 2) {
                // paso el tiempo es hora de actualizar
                mostrar();
            } else {
                $("#perfil").modal("hide"); // perfil esta actaulziado detro del rango
            }
        }
    );
}
function mostrar() {
    $.post(
        "../controlador/paneldocente.php?op=mostrar",
        {},
        function (data, status) {
            data = JSON.parse(data);
            $("#usuario_email").val(data.usuario_email_p);
            $("#usuario_telefono").val(data.usuario_telefono);
            $("#usuario_celular").val(data.usuario_celular);
            $("#usuario_direccion").val(data.usuario_direccion);
            $("#perfil").modal({ backdrop: "static", keyboard: false });
            $("#perfil").modal("show");
        }
    );
}
function ejecutaeventos() {
    // -------------------------------------------------------------
    //   Centered Navigation
    // -------------------------------------------------------------
    (function () {
        var $frame = $("#forcecentered1");
        var $wrap = $frame.parent();
        // Call Sly on frame
        $frame.sly({
            horizontal: 1,
            itemNav: "centered",
            smart: 1,
            activateOn: "click",
            mouseDragging: 1,
            touchDragging: 1,
            releaseSwing: 1,
            startAt: 3,
            scrollBar: $wrap.find(".scrollbar"),
            scrollBy: 1,
            speed: 300,
            elasticBounds: 1,
            easing: "easeOutExpo",
            dragHandle: 1,
            dynamicHandle: 1,
            clickBar: 1,
            // Buttons
            // se mueve el slider con los botones
            prev: $wrap.find(".prev"),
            next: $wrap.find(".nextbtn"),
            // Cycling
            cycleBy: "items",
            cycleInterval: 3000,
            pauseOnHover: 1
        });
    })();
}
function iniciarcalendario() {
    $("#mycontenido").hide();
    $("#mycalendario").show();
    var date = new Date();
    $("#calendar").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay"
        },
        buttonText: {
            today: "Hoy",
            month: "Mes",
            week: "Semana",
            day: "Día"
        },
        /*Enlace para cargar los eventos de la base de datos*/
        events: "../controlador/admin_calendario.php"
    });
}
/* ******************************** */
function volver() {
    $("#mycontenido").show();
    $("#mycalendario").hide();
}
function mostrarcheckbox() {
    var formData = new FormData($("#check_list")[0]);
    $.ajax({
        url: "../controlador/paneldocente.php?op=checkbox",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (e) {
            e = JSON.parse(e);
            // console.log(e);
            $(".info-mes").html(e[0]);
        }
    });
}
function cambiarEstilo(button) {
    $(".button-calendario").removeClass("button-active");
    $(button).addClass("button-active");
}
function cajadeherramientas() {
    $.post(
        "../controlador/paneldocente.php?op=cajadeherramientas",
        {},
        function (e) {
            var r = JSON.parse(e);
            $(".conte").html(r.conte);
            mostrarcajadeherramientas();
        }
    );
}
function mostrarcajadeherramientas() {
    $(".mostrarcajadeherramientas").slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 2,
        autoplay: true,
        arrows: false,
        responsive: [
            {
                breakpoint: 1048,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 780,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    });
}
function mostrarcalendario() {
    var formData = new FormData($("#check_list")[0]);
    $.ajax({
        url: "../controlador/paneldocente.php?op=mostrarcalendario",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (e) {
            e = JSON.parse(e);
            $(".traer_calendario").html(e[0]);
            tarjetacalendario();
        }
    });
}
function mostrarcalendarioeventos() {
    var formData = new FormData($("#check_list")[0]);
    $.ajax({
        url: "../controlador/paneldocente.php?op=mostrarcalendarioeventos",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (e) {
            // console.log(e);
            e = JSON.parse(e);
            $(".traer_calendario_eventos").html(e[0]);
            tarjetaeventos();
        }
    });
}
function tarjetacalendario() {
    $(".academico").slick({
        infinite: true,
        slidesToShow: 3,
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
function tarjetaeventos() {
    $(".eventos").slick({
        infinite: true,
        slidesToShow: 3,
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
function vershopping() {
    $.post("../controlador/paneldocente.php?op=vershopping", {}, function (e) {
        var r = JSON.parse(e);
        $(".conte2").html(r.vershopping);
        mostrarvershopping();
    });
}
function mostrarvershopping() {
    $(".mostrarshopping").slick({
        infinite: true,
        slidesToShow: 3, // Mostrar un slide a la vez
        slidesToScroll: 3,
        autoplay: true,
        arrows: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 6,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 780,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    });
}
function mostrarcursosinscritos() {
    $.post(
        "../controlador/paneldocente.php?op=mostrarcursosinscritos",
        {},
        function (e) {
            var r = JSON.parse(e);
            $("#misCursos").html(r.conte);
        }
    );
}
function eliminarInscripcion(valor) {
    Swal.fire({
        title: "Estas seguro?",
        text: "deseas eliminar la inscripción!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar registro!",
        cancelButtonText: "cerrar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(
                "../controlador/paneldocente.php?op=eliminarInscripcion",
                { valor: valor },
                function (e) {
                    var r = JSON.parse(e);
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Registro eliminado",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    inicio();
                }
            );
        }
    });
}
function separarCupo(id_curso) {
    Swal.fire({
        title: "Separar mi cupo?",
        text: "Al dar clic en si, separar, se activara la inscripción!",
        icon: "success",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, separar!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(
                "../controlador/paneldocente.php?op=separarCupo",
                { id_curso: id_curso },
                function (e) {
                    var r = JSON.parse(e);
                    if (r.conte == "si") {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Ya cuentas con una suscripción a este curso!",
                            footer: "Puedes continuar con el proceso desde tu plataforma"
                        });
                    } else {
                        if (r.conte == "no") {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "No se pudo registrar el curso"
                            });
                        } else {
                            inicio();
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Cupo separado",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                }
            );
        }
    });
}
function monitoreandoDocente() {
    var formData = new FormData($("#form-monitoreando-docente")[0]);
    $.ajax({
        url: "../controlador/paneldocente.php?op=guardarmonitoreandodocente",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            var data = JSON.parse(datos);
            if (data.estatus == 1) {
                alertify.success(data.valor);
                $('#modalmonitoreandoDocente').modal('hide');
                $('#form-monitoreando-docente')[0].reset();
                $('input[type=radio]').prop('checked', false);
            } else {
                alertify.error(data.valor);
            }
        }
    });
}
function mostrarmodalmonitoreando() {
    $.post("../controlador/paneldocente.php?op=traer_estado_modal_docente", {}, function (e) {
        var r = JSON.parse(e);
        // Asignar el estado a la variable global
        estadoModalGlobal = r.estado;
        controlarModal(estadoModalGlobal);
    });
}
// controlamos como se va a mostrar el modal si el estado es igual a null lo muestra y si es 0 lo oculta
function controlarModal() {
    // Verificar si el estado es 1 o null (mostrar el modal) o 0 (ocultar)
    if (estadoModalGlobal === null) {
        // Mostrar el modal si el estado es 1 o null
        $("#modalmonitoreandoDocente").modal('show');
    } else if (estadoModalGlobal == 1) {
        // Ocultar el modal si el estado es 0
        $("#modalmonitoreandoDocente").modal('hide');
    }
}

function educacioncontinuada(){
    $.post("../controlador/paneldocente.php?op=listarCursosEC", function (e) {
        //  console.log(e);
        var r = JSON.parse(e);
        if(r.exito == "1"){
            $("#slides-continuada").html(r.info);
            continuada();
        }else{
            $("#slides-continuada").html(r.plantilla);
        }
    });
}

function continuada() {
    $(".continuada").slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        arrows: false,
        dots: false,
    });
   
}


function markCompleted(id) {
    const circle = document.getElementById(`circle-${id}`);
    circle.classList.remove('border', 'border-dark', 'text-dark');
    circle.classList.add('bg-success', 'text-white');
}


$(document).ready(function() {
    $.post("../controlador/paneldocente.php?op=verificarFotoPerfil", {}, function(resp) {
        var data = JSON.parse(resp);
        if (data.mostrar) {
            // Muestra el modal solo si no tiene foto
            $("#modalFotoPerfil").modal({
                backdrop: "static",
                keyboard: false
            });
            $("#modalFotoPerfil").modal("show");
        }
    });
});

/*


/**** codigo para la cuenta regresiva */
/*****************************mes/dia/año **********/
// const DATE_TARGET = new Date('08/30/2024 6:00 PM');
// const SPAN_DAYS = document.querySelector('span#days');
// const SPAN_HOURS = document.querySelector('span#hours');
// const SPAN_MINUTES = document.querySelector('span#minutes');
// const SPAN_SECONDS = document.querySelector('span#seconds');
// const MILLISECONDS_OF_A_SECOND = 1000;
// const MILLISECONDS_OF_A_MINUTE = MILLISECONDS_OF_A_SECOND * 60;
// const MILLISECONDS_OF_A_HOUR = MILLISECONDS_OF_A_MINUTE * 60;
// const MILLISECONDS_OF_A_DAY = MILLISECONDS_OF_A_HOUR * 24
// function updateCountdown() {
//     const NOW = new Date()
//     const DURATION = DATE_TARGET - NOW;
//     const REMAINING_DAYS = Math.floor(DURATION / MILLISECONDS_OF_A_DAY);
//     const REMAINING_HOURS = Math.floor((DURATION % MILLISECONDS_OF_A_DAY) / MILLISECONDS_OF_A_HOUR);
//     const REMAINING_MINUTES = Math.floor((DURATION % MILLISECONDS_OF_A_HOUR) / MILLISECONDS_OF_A_MINUTE);
//     const REMAINING_SECONDS = Math.floor((DURATION % MILLISECONDS_OF_A_MINUTE) / MILLISECONDS_OF_A_SECOND);
//     SPAN_DAYS.textContent = REMAINING_DAYS;
//     SPAN_HOURS.textContent = REMAINING_HOURS;
//     SPAN_MINUTES.textContent = REMAINING_MINUTES;
//     SPAN_SECONDS.textContent = REMAINING_SECONDS;
// }
// updateCountdown();
// setInterval(updateCountdown, MILLISECONDS_OF_A_SECOND);
