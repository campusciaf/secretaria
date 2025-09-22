$(document).ready(inicio);
function inicio() {
    listar();
}
function listar() {
    $.post("../controlador/preguntasheteroevaluacion.php?op=listar", function (datos) {
        console.log(datos);
        var r = JSON.parse(datos);
        $("#datos").html(r.conte);
		$("#precarga").hide();
        for (let index = 0; index < r.cantidad; index++) {
            $("#pregunta"+(index+1)).on("submit", function (e) {
                e.preventDefault();
                guardar(index+1);
            })
        }    
    });
}
function guardar(val) {
    var formData = new FormData($("#pregunta"+val)[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/preguntasheteroevaluacion.php?op=guardar",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                alertify.success("Se actualizo la pregunta con exito.");
                $("#pregunta"+val)[0].reset();
                listar();
            } else {
                alertify.error("Error al actualizar la pregunta.");
            }
        }
    });
}