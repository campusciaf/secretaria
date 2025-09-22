$(document).ready(inicio);
var seleccion_actual = 1;
var button_global;
var mes_global;
var estadoModalGlobal;
function inicio() {
    $("#precarga").hide();
    educacioncontinuada();
    mostrarcursosinscritos();
    ingresosCampus();
    //cajadeherramientas();
    // vershopping();
    ejecutaeventos();
    mostrarcalendario();
    mostrarcalendarioeventos();
    $("#form-monitoriando-administrativos").off("submit").on("submit", function (e) {
        e.preventDefault();
        MonitoriandoAdministrativos();
    });
    puntos();
     puntos_docente();
     puntos_colaborador();
    // mostrarmodalmonitoriando();
 

}

function abrirRequerimientos() {
  document.getElementById('panelRecursos').classList.add('show');
}
function cerrarRequerimientos() {
  document.getElementById('panelRecursos').classList.remove('show');
}
function puntos() {
    $.post("../controlador/panel_admin.php?op=puntos", {}, function (e) {
        var r = JSON.parse(e);
        $("#puntos").html(r.total_puntos);
    });
}

function puntos_docente() {
    $.post("../controlador/panel_admin.php?op=puntos_docente", {}, function (e) {
        var r = JSON.parse(e);
        $("#puntos_docente").html(r.total_puntos);
    });
}

function puntos_colaborador() {
    $.post("../controlador/panel_admin.php?op=puntos_colaborador", {}, function (e) {
        var r = JSON.parse(e);
        $("#puntos_colaborador").html(r.total_puntos);
    });
}

function ingresosCampus() {
    $.post("../controlador/panel_admin.php?op=ingresosCampus", function (e) {
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
    introJs().setOptions({
        nextLabel: 'Siguiente',
        prevLabel: 'Anterior',
        doneLabel: 'Terminar',
        showBullets: false,
        showProgress: true,
        showStepNumbers: true,
        steps: [
            {
                title: 'Panel administrativo',
                intro: '¡Bienvenido a CIAF  Estamos muy felices de contar con un nuevo miembro tan talentoso(a) dentro de nuestro equipo. Esperamos poder crecer juntos, por eso te presentamos las principales métricas que intervienen en la consecución de los objetivos de una estrategia.'
            },
            {
                title: 'Estudiantes',
                element: document.querySelector('#t-paso1'),
                intro: "Aqui podrás encontrar información de nuestros seres originales"
            },
            {
                title: 'PEA',
                element: document.querySelector('#t-paso2'),
                intro: "Como director es tu responsabilidad agregar los diferentes contenidos de tu programa"
            },
            {
                title: 'Banco vh',
                element: document.querySelector('#t-paso3'),
                intro: "Aquí encontrarás nuevas hojas de vida de nuestros diferentes colaboradores"
            },
            {
                title: 'Ingreso campus',
                element: document.querySelector('#t-paso4'),
                intro: "Ten un control de tus ingresos a nuestro campus, esto nos ayuda a tener encuenta la entrada de nuestros colaboradores y seres originales"
            },
            {
                title: 'Perfiles',
                element: document.querySelector('#t-paso5'),
                intro: "Mira cuantos perfiles actualizados tenemos entre seres originales y colaboradores"
            },
            {
                title: 'Faltas reportadas',
                element: document.querySelector('#t-paso6'),
                intro: "Faltas reportadas en clase por nuestros docentes, teniendo encuenta la información de nuestros seres originales y el motivo de su falta"
            },
            {
                title: 'Casos quédate',
                element: document.querySelector('#t-paso7'),
                intro: "Para nosotros es de suma importancia la permanencia de nuestros seres originales por eso lleva el control de nuestros casos quédate, ayudando a las personas a seguir en el parche más creativo del eje cafetero"
            },
            {
                title: 'PQRSF',
                element: document.querySelector('#t-paso8'),
                intro: "La importancia que le damos a la opinión de todas las personas que hacen parte de nuestra institución, para eso llevamos un control de preguntas,sugerencias quejas, reclamos, y felicitaciones  para seguir creciendo e innovando"
            },
            {
                title: 'Clases del día',
                element: document.querySelector('#t-paso9'),
                intro: "Aquí encontrarás diferentes experiencias creativas de todos los programas de nuestra institución en su fecha y horario del mismo día o días anteriores"
            },
            {
                title: 'Calendario académico',
                element: document.querySelector('#t-paso10'),
                intro: "Entérate de todos nuestros eventos académicos programados para nuestros seres originales"
            },
            {
                title: 'Vuelvete emprendedor',
                element: document.querySelector('#t-paso11'),
                intro: "Formate permanentemente con nuestros programas innovadores y basados en tecnologia que se amolda a los requerimientos de la empresa o comunidad para que sigas preparando e innovando en nuestro parche cretivo y educativo mas grande del eje cafetero"
            },
            {
                title: 'Calendario eventos',
                element: document.querySelector('#t-paso12'),
                intro: "Enterate de todas nuestras experiencias transformadoras que mejoran la calidad de vida de los estudiantes, docentes, colaboradores y sus familias construyendo un lazo de confianza,amor,amistad y respeto"
            },
            {
                title: 'ID',
                element: document.querySelector('#t-paso13'),
                intro: "Encontrarás tu identificación como colaborador CIAF con algunos de tus datos y tu respectivo cargo "
            },
            {
                title: 'QR',
                element: document.querySelector('#t-paso14'),
                intro: "Tu propio codigo QR para escanear"
            },
            {
                title: 'Notificaciones',
                element: document.querySelector('#t-paso15'),
                intro: "Revisa tus notificaciones para estar al tanto de todas las novedades"
            },
            {
                title: 'Mensajes',
                element: document.querySelector('#t-paso16'),
                intro: "Revisa tus mensajes para estar al tanto de todas las novedades"
            },
            {
                title: 'Salir',
                element: document.querySelector('#t-paso17'),
                intro: "Culmina tu jornada cerrando sesión y descansando para empezar un nuevo dia con toda la actitud"
            },
        ]
    },
    ).start();
}
function tarjetacalendario() {
    $(".academico").slick({
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
function mostrarcalendario() {
    var formData = new FormData($("#check_list")[0]);
    $.ajax({
        url: "../controlador/panel_admin.php?op=mostrarcalendario",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (e) {
 
            e = JSON.parse(e);
            $("#traer_calendario").html(e);
            tarjetacalendario();
        },
    });
}
function cambiarEstilo(button) {
    $(".button-calendario").removeClass("button-active");
    $(button).addClass("button-active");
}
function mostrarcalendarioeventos() {
    var formData = new FormData($("#check_list")[0]);
    $.ajax({
        url: "../controlador/panel_admin.php?op=mostrarcalendarioeventos",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (e) {
            e = JSON.parse(e);
            $(".traer_calendario_eventos").html(e[0]);
            tarjetaeventos();
        },
    });
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
            pauseOnHover: 1,
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
            right: "month,agendaWeek,agendaDay",
        },
        buttonText: {
            today: "Hoy",
            month: "Mes",
            week: "Semana",
            day: "Día",
        },
        /*Enlace para cargar los eventos de la base de datos*/
        events: "../controlador/admin_calendario.php",
    });
}
function calendario() {
    /* initialize the calendar*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
    $("calendar").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay",
        },
        buttonText: {
            today: "Hoy",
            month: "Mes",
            week: "Semana",
            day: "Día",
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
        },
    });
}
function cajadeherramientas() {
    $.post("../controlador/panel_admin.php?op=cajadeherramientas", {}, function (e) {
        var r = JSON.parse(e);
        $(".conte").html(r.conte);
        mostrarcajadeherramientas();
    });
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
                    slidesToScroll: 1,
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
function vershopping() {
    $.post("../controlador/panel_admin.php?op=vershopping", {}, function (e) {
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
    $.post("../controlador/panel_admin.php?op=mostrarcursosinscritos", {}, function (e) {
        var r = JSON.parse(e);
        $("#misCursos").html(r.conte);
    });
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
            $.post("../controlador/panel_admin.php?op=eliminarInscripcion", { valor: valor }, function (e) {
                var r = JSON.parse(e);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Registro eliminado",
                    showConfirmButton: false,
                    timer: 1500
                });
                inicio();
            });
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
            $.post("../controlador/panel_admin.php?op=separarCupo", { id_curso: id_curso }, function (e) {
                var r = JSON.parse(e);
                if (r.conte == "si") {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Ya cuentas con una suscripción a este curso!",
                        footer: 'Puedes continuar con el proceso desde tu plataforma'
                    });
                } else {
                    if (r.conte == "no") {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "No se pudo registrar el curso",
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
            });
        }
    });
}
function MonitoriandoAdministrativos() {
    var formData = new FormData($("#form-monitoriando-administrativos")[0]);
    $.ajax({
        url: "../controlador/panel_admin.php?op=guardarmonitoriandoadministrativos",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            var data = JSON.parse(datos);
            if (data.estatus == 1) {
                alertify.success(data.valor);
                $('#modalMonitoriandoAdministrativos').modal('hide');
                $('#form-monitoriando-administrativos')[0].reset();
                $('input[type=radio]').prop('checked', false);
            } else {
                alertify.error(data.valor);
            }
        }
    });
}
// trae el estado del usuario para saber si ya realizo la encuesta o aun no la a realizado 
function mostrarmodalmonitoriando() {
    $.post("../controlador/panel_admin.php?op=traer_estado_modal", {}, function (e) {
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
        $("#modalMonitoriandoAdministrativos").modal('show');
    } else if (estadoModalGlobal == 1) {
        // Ocultar el modal si el estado es 0
        $("#modalMonitoriandoAdministrativos").modal('hide');
    }
}
function educacioncontinuada() {
    $.post("../controlador/panel_admin.php?op=listarCursosEC", function (e) {
        //  console.log(e);
        var r = JSON.parse(e);
        if (r.exito == "1") {
            $("#slides-continuada").html(r.info);
            continuada();
        } else {
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

$(document).ready(function() {
    $.post("../controlador/panel_admin.php?op=verificarFotoPerfil", {}, function(resp) {
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
/**** codigo para la cuenta regresiva */
//===
// VARIABLES
//===
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
