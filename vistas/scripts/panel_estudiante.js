var seleccion_actual = 1;
var estadoModalGlobal;
function inicio() {
   // mostrarcursosinscritos();
    //educacioncontinuada();
    mostrarcalendario();// significa que carga los eventos del calendario del mes actual
    // pendientes();
    
    // mostrarcheckbox();
    
    ejecutaeventos();
    
    mostrarcalendarioeventos();
    ingresosCampus();
    //vershopping();
    //cajadeherramientas();
    // publicidad();
    // $("#formularioencuesta").on("submit", function (e3) {
    //     guardarencuesta(e3);
    // });
    // mostrartoast();
    verperfilactualizado();
    $("#formularioperfil").on("submit", function (e2) {
        actualizarperfil(e2);
    });
    //Cargamos los items al select ejes
    // $.post("../controlador/panel_estudiante.php?op=selectDepartamento", function (r) {
    //     $("#departamento_res").html(r);
    // });
    $("#form-monitoreando-estudiante").off("submit").on("submit", function (e) {
        e.preventDefault();
        monitoreandoEstudiante();
    });
    // mostrarmodalmonitoreando();
    
}
function ingresosCampus() {
    $.post("../controlador/panel_estudiante.php?op=ingresosCampus", function (e) {
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

function publicidad() {
    $("#modalpublicidad").modal("show")
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
                title: 'Panel estudiante',
                intro: '¡Bienvenido a tus experiencias creativas,para nosotros es de gran alegria poder darte el nombre de ser original,porque eso es lo que eres una persona llena de creatvidad e innovación entre otras cualidades que te hacen ser unico(a) y que tu paso por nuestra institución sea memorable!'
            },
            {
                title: 'programas',
                element: document.querySelector('#m-paso1'),
                intro: "Da un vistazo a tus respectivos programas de tu elección con el que decidiste convertirte en un profesional creativo e innovador de la mano de nuestros docentes y la institución en general te apoyaremos en cada uno de tus pasos"
            },
            {
                title: 'Recursos digitales',
                element: document.querySelector('#m-paso2'),
                intro: "Apoyate con estos increibles recursos que como ser orignal tienes acceso, herramientas que te pueden ayudar a lo largo de tu trayectoria recibiendo diferentes experiencias creativas e innovadoras "
            },
            {
                title: 'Caracterización',
                element: document.querySelector('#m-paso3'),
                intro: "Ayudanos a formar un lazo cada ves más familiar contigo realizando tu inscripción como ser original caracterizado, para desarrollar todas nuestras estrategias de bienestar, mercadeo y extensión"
            },
            {
                title: '¡Historial académico',
                element: document.querySelector('#m-paso4'),
                intro: "Aquí podrás encontrar toda tu historia en este laberinto del saber,revive tu trayectoria revisando un poco sobre tu historial académico"
            },
            {
                title: 'Mis certificados',
                element: document.querySelector('#m-paso5'),
                intro: "Lleva un control de los diferentes certificados que puedes solicitar en  el área de registro y control en nuestra institución"
            },
            {
                title: 'Renovación',
                element: document.querySelector('#m-paso6'),
                intro: "Como ser original debe ser muy importante para ti  realizar la renovación tanto financiera como académica, una ves culmines satisfactoriamente puedes hacer tu renovación para que sigas siendo parte de el parche creativo más grande del eje cafetero "
            },
            {
                title: 'Mi financiación',
                element: document.querySelector('#m-paso7'),
                intro: "Para nosotros la confianza que tenemos en ti es muy importante es por eso que tambien debes de llevar un control de tu financiación y nos ayudes a que sigas siendo parte de este parche creativo e innovador"
            },
            {
                title: 'Pagos generales',
                element: document.querySelector('#m-paso8'),
                intro: "Aquí podrás encontrar un control de todos los pagos que has realizado de diferentes requerimientos a lo largo de todo tu esfuerzo y empeño"
            },
            {
                title: 'Mi carnet',
                element: document.querySelector('#m-paso9'),
                intro: "Para nosotros es muy importante reconocerte como un ser original de nuestra institución, aqui podras encontrar tu carnet que te identifica como un ser original de nuestro centro de idiomas"
            },
            {
                title: 'Idiomas',
                element: document.querySelector('#m-paso10'),
                intro: "Da un vistazo a nuestro centro de idiomas donde podras observar el nivel de inglés que estas cursando y los que te faltan por cursar de nuestro módulo, recuerda que es un requisito de grado haber cursado el módulo de manera satisfactoria en tu respectivo semestre"
            },
            {
                title: 'PQRS',
                element: document.querySelector('#m-paso11'),
                intro: "Aquí podrás dejar todas tus preguntas,quejas,reclamos y sugerencias ayudándonos así a mejorar como institución y cada ves seguir siendo el mejor parche creativo e innovador de todo el eje cafetero "
            },
            {
                title: 'QR',
                element: document.querySelector('#t-paso12'),
                intro: "¡Tu propio QR para escanear!"
            },
            {
                title: 'Salir',
                element: document.querySelector('#t-paso13'),
                intro: "Culmina tus experiencias creativas del día cerrando sesión, para empezar un nuevo día con las espectativas de siempre aprender algo nuevo mediante las expeiencias que te brinda nuestra intución soñando que seas un ser original creativo(a) e innovador(a)"
            },
            {
                title: 'Faltas',
                element: document.querySelector('#t-paso14'),
                intro: "Aquí podrás observar tus faltas reportadas por tu respectivo docente"
            },
            {
                title: 'Notas',
                element: document.querySelector('#t-paso15'),
                intro: "Aquí podrás observar tus notas subidas por tu respectivo docente, anteriormente obtenidas por las respectivas experiencias creativas "
            },
            {
                title: 'Actividades',
                element: document.querySelector('#t-paso16'),
                intro: "Enterate de todas las actividades propuestas por tu docente que seguramente serán de todo tu agrado para así seguir viviendola creatividad al máximo "
            },
            {
                title: 'Clases del día',
                element: document.querySelector('#t-paso17'),
                intro: "Da un vistazo a tus clases y preparate para la experiencia creativa del día"
            },
            {
                title: 'Perfil',
                element: document.querySelector('#t-paso18'),
                intro: "Enterate de todos los seres originales que conforman nuestra institución y cada ves son más los que deciden sumarse a este parche creativo"
            },
            {
                title: 'Dirección residencia',
                element: document.querySelector('#t-paso19'),
                intro: "¡Valida aquí tu lugar de recidencia!"
            },
            {
                title: 'Estoy Caracterizado',
                element: document.querySelector('#t-paso20'),
                intro: "Aquí podrás encontrar la fecha desde que estas caracterizado y te convertiste en un completo ser original"
            },
            {
                title: 'Novedades',
                element: document.querySelector('#t-paso21'),
                intro: "Enterate de todas nuestras novedades e innovaciones que tenemos para ti"
            },
            {
                title: 'Ingresos campus',
                element: document.querySelector('#t-paso22'),
                intro: "Ten un control de todos tus ingresos a nuestro campus virtual "
            },
            {
                title: 'Calendario',
                element: document.querySelector('#t-paso23'),
                intro: "Entérate de todos nuestros eventos académicos programados para ti fomentando un espacio diferente donde podrás dejarte llevar por la creatividad e innovación de nuestras experiencias creativas"
            },
            {
                title: 'Vuelvete emprendedor',
                element: document.querySelector('#t-paso24'),
                intro: "Formate permanentemente con nuestros programas innovadores y basados en tecnologia que se amolda a los requerimientos de la empresa o comunidad para que sigas preparando e innovando en nuestro parche cretivo y educativo mas grande del eje cafetero"
            },
            {
                title: 'Calendario eventos',
                element: document.querySelector('#t-paso25'),
                intro: "Enterate de todas nuestras experiencias transformadoras que mejoran la calidad de vida de seres originales como tú, docentes, colaboradores y sus familias incluyendo a tus inspiradores donde construirás un lazo de confianza,amor,amistad y respeto"
            },
            {
                title: 'Ajustes',
                element: document.querySelector('#m-paso26'),
                intro: "Personaliza como tu quieras el campus virtual con tu perfil, donde te podrás apropiar realmente de tu espacio virtual y seguro de nuestra institución "
            },
            {
                title: 'salir',
                element: document.querySelector('#m-paso27'),
                intro: "Culmina tus experiencias creativas del día cerrando sesión, para empezar un nuevo día con las espectativas de siempre aprender algo nuevo mediante las expeiencias que te brinda nuestra intución soñando que seas un ser original creativo(a) e innovador(a)"
            },
        ]
    },
    ).start();
}
/* Función para limpiar el formulario al momento de cancelar la acción*/
function LimpiarFormulario() {
    $('#modalCalendarioLabel').html('Agregar Evento');
    $('#idActividad').val('');
    $('#txtTitulo').val('');
    $('#txtFechaInicio').val('');
    $('#txtFechaFin').val('');
    $('#txtColor').val('');
}
function mostrartoast() {
    $.ajax({
        type: 'POST',
        url: '../controlador/panel_estudiante.php?op=alertacalendario',
        success: function (alerttoast) {
            var alertavacia = alerttoast;
            if (alertavacia == null || alertavacia == undefined || alertavacia == "") {
                $('.toast').toast('hide')
            } else {
                // $('.toast').toast('show');
                $("#alerta_calendario_toast").html(alerttoast);
            }
        },
    });
}
/* *****  para la encuesta ****** */
function verificarencuesta() {
    $.post("../controlador/panel_estudiante.php?op=verificarencuesta", function (r) {
        data = JSON.parse(r);
        if (data.estado != "1") {
            encuesta();
            listardocentesactivos();
        } else {
            $("#myModalEncuesta").modal("hide");
        }
    });
}
function encuesta() {
    $("#myModalEncuesta").modal({ backdrop: 'static', keyboard: false });
    $("#myModalEncuesta").modal("show");
}
function listardocentesactivos() {
    $.post("../controlador/panel_estudiante.php?op=listardocentesactivos", function (r) {
        $("#pre3").html(r);
        $('#pre3').selectpicker('refresh');
    });
}
function guardarencuesta(e3) {
    e3.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#formularioencuesta")[0]);
    $.ajax({
        url: "../controlador/panel_estudiante.php?op=guardarencuesta",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            data = JSON.parse(datos);
            if (data.estado = "1") {
                alertify.success("Encuesta enviada");
                verificarencuesta();
            } else {
                alertify.error("Encuesta errada");
            }
        }
    });
}
function ejecutaeventos() {
    // -------------------------------------------------------------
    //   Centered Navigation
    // -------------------------------------------------------------
    (function () {
        var $frame = $('#forcecentered1');
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
            // se mueve el slider con los botones 
            prev: $wrap.find('.prev'),
            next: $wrap.find('.nextbtn'),
            // Cycling
            cycleBy: 'items',
            cycleInterval: 3000,
            pauseOnHover: 1,
        });
    }());
}
function mostrarcheckbox() {
    var formData = new FormData($("#check_list")[0]);
    $.ajax({
        "url": "../controlador/panel_estudiante.php?op=checkbox",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (e) {
            e = JSON.parse(e);
            $(".info-mes").html(e[0]);
        }
    });
}
function cambiarEstilo(button) {
    $(".button-calendario").removeClass("button-active");
    $(button).addClass("button-active");
}
function pendientes() {
    $.post("../controlador/panel_estudiante.php?op=pendientes", function (data) {
        var r = JSON.parse(data);
        $("#pendientes").html(r[0]);
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
function mostrarcalendario() {
    var formData = new FormData($("#check_list")[0]);
    $.ajax({
        url: "../controlador/panel_estudiante.php?op=mostrarcalendario",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (e) {
            e = JSON.parse(e);
            $(".traer_calendario").html(e[0]);
            tarjetacalendario();
        },
    });
}
function mostrarcalendarioeventos() {
    var formData = new FormData($("#check_list")[0]);
    $.ajax({
        url: "../controlador/panel_estudiante.php?op=mostrarcalendarioeventos",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (e) {
            e = JSON.parse(e);
            $(".traer_calendario_eventos").html(e[0]);
            tarjetaeventos();
            $("#precarga").hide();
        },
    });
}
function verperfilactualizado() {
    $.post("../controlador/panel_estudiante.php?op=verperfilactualizado", function (datos) {
        var r = JSON.parse(datos);
        if (r.estado == 2) {// paso el tiempo es hora de actualizar
            mostrar();
        } else {
            $("#perfil").modal("hide");// perfil esta actaulziado detro del rango
        }
    });
}
function mostrar() {
    $.post("../controlador/panel_estudiante.php?op=mostrar", {}, function (data, status) {
        data = JSON.parse(data);
        $("#email").val(data.email);
        $("#estrato").val(data.estrato);
        $("#telefono").val(data.telefono);
        $("#celular").val(data.celular);
        $("#barrio").val(data.barrio);
        $("#direccion").val(data.direccion);
        $("#perfil").modal({ backdrop: 'static', keyboard: false });
        $("#perfil").modal("show");
    });
}
function actualizarperfil(e2) {
    e2.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#formularioperfil")[0]);
    $.ajax({
        url: "../controlador/panel_estudiante.php?op=actualizarperfil",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            data = JSON.parse(datos);
            if (data.estado = "si") {
                alertify.success("Datos actualizados");
                verperfilactualizado();
            } else {
                alertify.error("Datos no actualizados");
            }
        }
    });
}
function vershopping() {
    $.post("../controlador/panel_estudiante.php?op=vershopping", {}, function (e) {
        var r = JSON.parse(e);
        $(".conte2").html(r.vershopping);
        mostrarvershopping();
    });
}
function mostrarvershopping() {
    $(".mostrarshopping").slick({
        infinite: true,
        slidesToShow: 4, // Mostrar un slide a la vez
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
function cajadeherramientas() {
    $.post("../controlador/panel_estudiante.php?op=cajadeherramientas", {}, function (e) {
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
function mostrarcursosinscritos() {
    $.post("../controlador/panel_estudiante.php?op=mostrarcursosinscritos", {}, function (e) {
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
            $.post("../controlador/panel_estudiante.php?op=eliminarInscripcion", { valor: valor }, function (e) {
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
            $.post("../controlador/panel_estudiante.php?op=separarCupo", { id_curso: id_curso }, function (e) {
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
function monitoreandoEstudiante() {
    var formData = new FormData($("#form-monitoreando-estudiante")[0]);
    $.ajax({
        url: "../controlador/panel_estudiante.php?op=guardarmonitoreandoestudiante",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            var data = JSON.parse(datos);
            if (data.estatus == 1) {
                alertify.success(data.valor);
                $('#modalmonitoreandoestudiante').modal('hide');
                $('#form-monitoreando-estudiante')[0].reset();
                $('input[type=radio]').prop('checked', false);
            } else {
                alertify.error(data.valor);
            }
        }
    });
}
function mostrarmodalmonitoreando() {
    $.post("../controlador/panel_estudiante.php?op=traer_estado_modal_estudiante", {}, function (e) {
        var r = JSON.parse(e);
        // Asignar el estado a la variable global
        estadoModalGlobal = r.estado;
        controlarModal(estadoModalGlobal);
    });
}

function educacioncontinuada(){
    $.post("../controlador/panel_estudiante.php?op=listarCursosEC", function (e) {
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


// controlamos como se va a mostrar el modal si el estado es igual a null lo muestra y si es 0 lo oculta
function controlarModal() {
    // Verificar si el estado es 1 o null (mostrar el modal) o 0 (ocultar)
    if (estadoModalGlobal === null) {
        // Mostrar el modal si el estado es 1 o null
        $("#modalmonitoreandoestudiante").modal('show');
    } else if (estadoModalGlobal == 1) {
        // Ocultar el modal si el estado es 0
        $("#modalmonitoreandoestudiante").modal('hide');
    }
}
/**** codigo para la cuenta regresiva */
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
inicio();