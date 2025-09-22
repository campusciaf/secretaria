$(document).ready(inicio);
function inicio() {
    verdatos();
    listar_docentes();
    listar_dependencias();
    guia_mostrarCategoria();
    buscar_docente();
    
    
    $("#form_seguimiento").on("submit", function (e) {
        e.preventDefault();
        guia_agregar_seguimiento();
    });

    $("#form_tarea").on("submit", function (e) {
        e.preventDefault();
        guia_agregar_tarea();
    });

    $("#form_guia_remision").on("submit", function (e) {
        e.preventDefault();
        guia_agregar_remision();
    });

    
    $("#form_guia_cerrar").on("submit", function (e) {
        e.preventDefault();
        guia_cerrar_caso();
    });
    listar_dependencias();
    var todayDate = new Date();
    $('.datepicker').datetimepicker({
        //defaultDate: new Date(),
        locale: 'es',
        format: 'YYYY-MM-DD hh:mm a',
        minDate: todayDate
    });

    
    guia_mostrarCategoria();
    $(".nuevo-seguimiento-contenedor").hide(); 

    
}
function guia_mostrarCategoria() {
    $.post("../controlador/guiavercaso.php?op=guia_mostrarCategoria", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        //console.log(r);
        opti += '<option value="" selected disabled> - Categorias - </option>';
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].nombre + '">' + r[i].nombre + '</option>';
        }
        $('#categoria_cerrar').html(opti);
    });
}

//mostrar datos personales del docente
function buscar_docente(){
    $.post("../controlador/guiavercaso.php?op=buscar_docente",{caso_id: $("#caso_id").val()},function (datos) {//enlace al controlador para traer los datos del docente
        //console.table(datos);
        datos = JSON.parse(datos);
        //console.log(datos);
        if(datos.exito == '0'){
            alertify.error(datos.info);
            limpiar();
        }else{
            $(".usuario_nombre").text(datos.info.usuario_nombre);
            $(".usuario_apellido").text(datos.info.usuario_apellido);
            $(".usuario_tipo_documento").text(datos.info.usuario_tipo_documento);
            $(".usuario_identificacion").text(datos.info.usuario_identificacion);
            $(".usuario_direccion").text(datos.info.usuario_direccion);
            $(".usuario_celular").text(datos.info.usuario_celular);
            $(".usuario_email_ciaf").text(datos.info.usuario_email_ciaf);
            $(".img_docente").prop("src", datos.info.foto);
            $(".lista_programas").html(datos.programas);
            $("#btnabrircaso").parent().removeClass("hide");
            $("#cedula-docente").html(datos.info.numero_documento);
            $("#id-docente-nuevo-caso").val(datos.info.id_credencial);
        }
    });
}

function listar_docentes() {
    $.post("../controlador/guiavercaso.php?op=listar_docentes", function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        var opti = '';
        opti += '<option value="" selected disabled> - Docentes - </option>';

        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].id_usuario + '">' + r[i].nombre.toUpperCase() + '</option>';

        }
        $(".select_docente").html(opti);
        $('.select_docente').selectpicker();
        $('.select_docente').selectpicker('refresh');
    });
}
function listar_dependencias() {
    $.post("../controlador/guiavercaso.php?op=listar_dependencias", function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        var opti = '';
        opti += '<option value="" selected disabled> - Dependencias - </option>';
        
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].id_usuario + '">' + r[i].nombre.toUpperCase() + '</option>';

        }
        $(".select_dependencia").html(opti);
    /*   $('.select_dependencia').selectpicker();
        $('.select_dependencia').selectpicker('refresh'); */
    });
}
function verdatos() {
    var id = $("#caso_id").val();
    $.post("../controlador/guiavercaso.php?op=verdatos", { "id" : id }, function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        $(".cabecera_seguimientos").html(r.conte);
    });
}
function guia_agregar_seguimiento() {
    $(".btn-enviar").attr("disabled", true);
    var formData = new FormData($("#form_seguimiento")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/guiavercaso.php?op=agregar_seguimiento",
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
            }else {
                $(".btn-enviar").attr("disabled", false);
                alertify.error(r.msj);
            }
        }
    });
}
function guia_agregar_tarea() {
    $(".btn-enviar").attr("disabled", true);
    var formData = new FormData($("#form_tarea")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/guiavercaso.php?op=agregar_tarea",
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
function guia_agregar_remision() {
    $(".btn-enviar").attr("disabled", true);
    var formData = new FormData($("#form_guia_remision")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/guiavercaso.php?op=guia_agregar_remision",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            
            console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                alertify.success("Registro exitoso.");
                $("#form_guia_remision")[0].reset();
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
function guia_cerrar_caso() {
    $(".btn-enviar").attr("disabled", true);
    var formData = new FormData($("#form_guia_cerrar")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/guiavercaso.php?op=guia_cerrar_caso",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                alertify.success("Caso cerrado con exitoso.");
                $("#form_guia_cerrar")[0].reset();
                $('#modal_cerrar').modal('hide');
                $(".btn-enviar").attr("disabled", false);
                verdatos();
            }else{
                $(".btn-enviar").attr("disabled", false);
                alertify.error(r.msj);
            }
        }
    });
}