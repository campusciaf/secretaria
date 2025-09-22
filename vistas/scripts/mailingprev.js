$(document).ready(inicio);
function inicio(){
    listarPre();
    mostar();
    CKEDITOR.replace('editor1',{
        height: '800px',
    });
    CKEDITOR.editorConfig = function (config) {
        config.language = 'es';
        config.uiColor = '#F7B42C';
        config.height = 300;
        config.toolbarCanCollapse = true;
    };
    $("#form").on("submit", function (e) {
        e.preventDefault();
        aggbanner();
    });
    $("#form2").on("submit", function (e) {
        e.preventDefault();
        aggimg();
    });
}
function listarPre() {
    var id = $("#id_p").val();
    $.post("../controlador/mailing.php?op=listarPre", { id: id }, function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        //console.log(r.contenido);
        $("#titulo").val(r.titulo);
        CKEDITOR.instances.editor1.setData(r.contenido);
    });
}
function mostar() {
    $.post("../controlador/mailing.php?op=mostarimg", function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        $(".conte").html(r.conte);
        var vHeight = $(window).height(),
        vWidth = $(window).width(),
        cover = $('.cover');
        //console.log(vWidth);
        cover.css({ "height": (vHeight-150) });
    });
}
function editar() {
    var id = $("#id_p").val();
    var titulo = $("#titulo").val();
    var text = CKEDITOR.instances['editor1'].getData();
    $.post("../controlador/mailing.php?op=editar", { id: id, conte:text, titulo:titulo }, function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        if (r.status) {
            alertify.success("Plantilla editada con exito");
            listarPre();
        }else{
            alertify.error("Error al editar la plantilla");
        }
    });
}
function aggbanner() {
    var formData = new FormData($("#form")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/mailing.php?op=aggbanner",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                alertify.success("Banner subido con exito");
                $("#form")[0].reset();
                mostar();
                $("#exampleModal").modal("hide");
            } else {
                alertify.error("Error al subir el bnner");
            }
        }
    });
}
function aggimg() {
    var formData = new FormData($("#form2")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/mailing.php?op=aggimg",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                alertify.success("Imagen subido con exito");
                $("#form")[0].reset();
                mostar();
                $("#exampleModal2").modal("hide");
            } else {
                alertify.error("Error al subir el bnner");
            }
        }
    });
}