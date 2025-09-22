$(document).ready(inicio);
function inicio() {
    load();
    $("#form").on("submit", function(e){
        e.preventDefault();
        enviarMail();
    });
    $("#precarga").hide();
}
function load() {
    listarPlantillas();
    listarDise();
}
function listarPlantillas() {
    $.post("../controlador/mailing.php?op=listar", function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        $(".plantillas").html(r.conte);
    });
}
function listarDise() {
    $.post("../controlador/mailing.php?op=listardise", function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        $(".conte").html(r.conte);
    });
}
function visualizar_estructura(id) {
    $.post("../controlador/mailing.php?op=visualizar_estructura",{id:id} ,function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        $(".conte_estruc").html(r.contenido);
        $("#modal_vi").modal("show");
    });
}
function duplicar_estructura(id) {
    $.post("../controlador/mailing.php?op=duplicar",{id:id} ,function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        if (r.status = "ok") {
            alertify.success("Plantilla duplicada con exito");
            load();
        } else {
            alertify.error("Error al duplicar la plantilla");
        }
    });
}
function enviar_cor(id) {
    $("#id_p").val(id);
    $("#m_enviar").modal("show");
}
function enviarMail() {
    var formData = new FormData($("#form")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/mailing.php?op=enviarMail",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                alertify.success("Mensaje enviado");
                $("#form")[0].reset();
                $("#m_enviar").modal("hide");
            } else {
                alertify.error("Error al enviar el mensaje");
            }
        }
    });
}
function eliminarplantilla(id) {

    alertify.confirm('Eliminar plantilla', '¿Desea eliminar la plantilla? después no se podra revertir los cambios', function () { 
        $.post("../controlador/mailing.php?op=eliminarplantilla", { id: id }, function (datos) {
            console.log(datos);
            var r = JSON.parse(datos);
            if (r.status = "ok") {
                alertify.success("Eliminar plantilla con exito");
                load();
            } else {
                alertify.error("Error al eliminar la plantilla");
            }
        }); 
    }
    , function () { alertify.error('Cancel') });
}
function crear() {
    $.post("../controlador/mailing.php?op=crear", function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        if (r.status = "ok") {
            alertify.success("Plantilla creada con exito");
            load();
        } else {
            alertify.error("Error al crear la plantilla");
        }
    });
}