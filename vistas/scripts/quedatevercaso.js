$(document).ready(inicio);
function inicio() {

    verdatos();
    $("#form_seguimiento").on("submit", function (e) {
        e.preventDefault();
        agregar_seguimiento();
    });
    $("#form_tarea").on("submit", function (e) {
        e.preventDefault();
        agregar_tarea();
    });
    $("#form_remision").on("submit", function (e) {
        e.preventDefault();
        agregar_remision();
    });
    $("#form_cerrar").on("submit", function (e) {
        e.preventDefault();
        cerrar_caso();
    });
    listar_docentes();
    listar_dependencias();
    var todayDate = new Date();
    $('.datepicker').datetimepicker({
        //defaultDate: new Date(),
        locale: 'es',
        format: 'YYYY-MM-DD hh:mm a',
        minDate: todayDate
    });
    buscar_estudiante();
    mostrarCategoria();
    $(".nuevo-seguimiento-contenedor").hide();
    $("#precarga").hide();
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
                title: 'Ver caso',
                intro: 'Bienvenido al lugar donde con nuestra creatividad e innovación ayudaremos a nuestro ser original a continuar con sueño de ser un profesional'
            },
            {
                title: 'Seguimiento',
                element: document.querySelector('#t-S'),
                intro: "En un click podrás añadir la información de las diferentes tareas que se han asignado para solución de este caso"
            },
            {
                title: 'Tarea',
                element: document.querySelector('#t-T'),
                intro: "Aquí podrás añadir diferentes soluciones para continuar con el proceso de solución para nuestro ser original"
            },
            {
                title: 'Remitir',
                element: document.querySelector('#t-R'),
                intro: "De igual manera si ya no esta en tus manos manejar el caso de nuestro ser original puedes remitir el caso a otra área y así buscar la mejor solución entre todos"
            },
            {
                title: 'Cerrar',
                element: document.querySelector('#t-CER'),
                intro: "Da por finalizado este caso con tan solo un click teniendo en cuenta las observaciones finales, logros, adjuntar evidencias y si es un caso cerrado existoso o simplemente se hizo la cancelación del mismo"
            },
            {
                title: 'Tareas',
                element: document.querySelector('#t-TAE'),
                intro: "Aquí podrás visualizar todas las tareas asignadas para dar una solución pronta y efectiva a este caso"
            },
            {
                title: 'Segimiento',
                element: document.querySelector('#t-SG'),
                intro: "En este campo tendrás la oportunidad de conocer todos los pasos que se han seguido con una pequeña descripción de lo que se ha realizado a lo largo del proceso"
            },
            {
                title: 'Datos de estudiante',
                element: document.querySelector('#t-DTE'),
                intro: "Encuentra la información personal de nuestro ser original que podría serte útil en algún momento de este caso"
            },

        ]

    },

    ).start();

}
function mostrarCategoria() {
    $.post("../controlador/quedatevercaso.php?op=mostrarCategoria", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        //console.log(r);
        opti += '<option value="" selected disabled> - Categorias - </option>';
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].nombre + '">' + r[i].nombre + '</option>';
        }
        $('#categorias_cerrado').html(opti);
    });
}
function buscar_estudiante() {
    var id_caso = $("#caso_id").val();
    $.post("../controlador/quedatevercaso.php?op=buscar_estudiante", { id_caso: id_caso }, function (datos) {//enlace al controlador para traer los datos del estudiante
        //console.table(datos);
        datos = JSON.parse(datos);
        if (datos.exito == '0') {
            alertify.error(datos.info);
        } else {
            $(".nombre_estudiante").text(datos.info.nombre_estudiante);
            $(".apellido_estudiante").text(datos.info.apellido_estudiante);
            $(".tipo_identificacion").text(datos.info.tipo_identificacion);
            $(".numero_documento").text(datos.info.numero_documento);
            $(".direccion").text(datos.info.direccion);
            $(".celular").text(datos.info.celular);
            $(".correo").text(datos.info.email);
            $(".img_estudiante").prop("src", datos.info.foto);
            $(".lista_programas").html(datos.programas);
            $("#btnabrircaso").parent().removeClass("hide");
            $("#cedula-estudiante").html(datos.info.numero_documento);
            $("#id-estudiante-nuevo-caso").val(datos.info.id_credencial);
        }
    });
}
function listar_docentes() {
    $.post("../controlador/quedatevercaso.php?op=listar_docentes", function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        var opti = '';
        opti += '<option value="" selected disabled> - Docentes - </option>';
        opti += '<option value=""> NINGUNO </option>';

        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].id_usuario + '">' + r[i].nombre.toUpperCase() + '</option>';

        }
        $(".select_docente").html(opti);
        $('.select_docente').selectpicker();
        $('.select_docente').selectpicker('refresh');
    });
}
function listar_dependencias() {
    $('.select_dependencia').selectpicker();
    $('.select_dependencia').selectpicker('refresh');
    /* $.post("../controlador/quedatevercaso.php?op=listar_dependencias", function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        var opti = '';
        opti += '<option value="" selected disabled> - Dependencias - </option>';

        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].id_usuario + '">' + r[i].nombre.toUpperCase() + '</option>';

        }
        $(".select_dependencia").html(opti);
    }); */
}
function verdatos() {
    var id = $("#caso_id").val();
    $.post("../controlador/quedatevercaso.php?op=verdatos", { id: id }, function (datos) {
        console.log(datos);
        var r = JSON.parse(datos);
        $(".cabecera_seguimientos").html(r.conte);
    });
}
function agregar_seguimiento() {
    $(".btn-enviar").attr("disabled", true);
    var formData = new FormData($("#form_seguimiento")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/quedatevercaso.php?op=agregar_seguimiento",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                alertify.success("Registro exitoso.");
                $("#form_seguimiento")[0].reset();
                $('#modal_seguimiento').modal('hide');
                $(".btn-enviar").attr("disabled", false);
                verdatos();
            } else {
                $(".btn-enviar").attr("disabled", false);
                alertify.error(r.msj);
            }
        }
    });
}
function agregar_tarea() {
    $(".btn-enviar").attr("disabled", true);
    var formData = new FormData($("#form_tarea")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/quedatevercaso.php?op=agregar_tarea",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                alertify.success("Registro exitoso.");
                $("#form_tarea")[0].reset();
                $('#modal_tarea').modal('hide');
                $(".btn-enviar").attr("disabled", false);
                verdatos();

            } else {
                $(".btn-enviar").attr("disabled", false);
                alertify.error('Error al hacer el registro.');
            }
        }
    });
}
function agregar_remision() {
    $(".btn-enviar").attr("disabled", true);
    var formData = new FormData($("#form_remision")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/quedatevercaso.php?op=agregar_remision",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                alertify.success("Registro exitoso.");
                $("#form_remision")[0].reset();
                $('#modal_remitir').modal('hide');
                $(".btn-enviar").attr("disabled", false);
                verdatos();

            } else {
                $(".btn-enviar").attr("disabled", false);
                alertify.error('Error al hacer el registro.');
            }
        }
    });
}
function cerrar_caso() {
    $(".btn-enviar").attr("disabled", true);
    var formData = new FormData($("#form_cerrar")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/quedatevercaso.php?op=cerrar_caso",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                alertify.success("Caso cerrado con exitoso.");
                $("#form_cerrar")[0].reset();
                $('#modal_cerrar').modal('hide');
                $(".btn-enviar").attr("disabled", false);
                verdatos();
            } else {
                $(".btn-enviar").attr("disabled", false);
                alertify.error(r.msj);
            }
        }
    });
}