$(document).ready(inicio);
function inicio() {
    //listar();
    $("#form_grupo").on("submit", function(e){
        agregar_grupo(e);
    });
 
    $("#form_docente").on("submit", function(e){
        agregar_docente(e);
    });

    $("#form_crear_grupo").on("submit", function(e){
        crear_grupo(e);
    });

    listar_datos();
    listar();
    
}

function listar() {
    $.post("../controlador/idiomas_datos_grupos.php?op=listar", function(dato){
        //console.log(dato);
        var r = JSON.parse(dato);
        $("#listardatos").html(r.conte);
        $("#tbl_grupos").DataTable();
    });
}

function listar_datos() {
    $.post("../controlador/idiomas_datos_grupos.php?op=listar_datos", function(dato){
        //console.log(dato);
        var r = JSON.parse(dato);
        $("#docente").html(r.docente);
        $("#tipo_grupo").html(r.tipo_grupo);
    });
}

function agregar_docente(e) {
    e.preventDefault();
    var formData = new FormData($("#form_docente")[0]);
    $.ajax({
        "url": "../controlador/idiomas_datos_grupos.php?op=agregar_docente",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function(datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == 'ok') {
                alertify.success(r.msj);
                listar_datos();
                $("#form_docente")[0].reset();
            } else {
                alertify.error(r.msj);
            }
        }
    });    
}

function agregar_grupo(e) {
    e.preventDefault();
    var formData = new FormData($("#form_grupo")[0]);
    $.ajax({
        "url": "../controlador/idiomas_datos_grupos.php?op=agregar_grupo",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function(datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == 'ok') {
                alertify.success(r.msj);
                $("#form_grupo")[0].reset();
                listar_datos();
            } else {
                alertify.error(r.msj);
            }
        }
    });    
}

function crear_grupo(e) {
    e.preventDefault();
    var formData = new FormData($("#form_crear_grupo")[0]);
    $.ajax({
        "url": "../controlador/idiomas_datos_grupos.php?op=crear_grupo",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function(datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == 'ok') {
                alertify.success(r.msj);
                $("#form_crear_grupo")[0].reset();
                listar();
            } else {
                alertify.error(r.msj);
            }
        }
    });    
}