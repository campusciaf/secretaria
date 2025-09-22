$(document).ready(inicio);
var encuestaCompleta = false;
function inicio() {
    $("#precarga").hide();
    $.post("../controlador/verencuestadocente.php?op=listar", function(data) {
        console.log(data);
        var r = JSON.parse(data); 
        if (r.completo) {
            alertify.success("Ya completaste la evaluación docente.");
            $("#modal_evaluacion_docente").modal("hide");  
            setTimeout(function() {
                window.location.href = "panel_estudiante.php"; 
            }, 2000);  
        } else {
            $("#listar").html(r.conte); 
            for (let index = 0; index < r.cantidad; index++) {
                $(".form_preguntas_docente" + (index + 1)).on("submit", function(e) {
                    e.preventDefault();
                    registro(index + 1); 
                });
            }
        }
    });
}
function registro(val) {
    $(".enviar_datos").attr("disabled", true);  
    var formData = new FormData($(".form_preguntas_docente" + val)[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/verencuestadocente.php?op=registro_docente",
        data: formData,
        contentType: false,  
        processData: false,  
        success: function(datos) {
            var r = JSON.parse(datos);  
            if (r.status === "ok") {
                alertify.success("Registro exitoso.");
                $(".form_preguntas_docente" + val)[0].reset(); 
                inicio();
            } else {
                alertify.error("Error al hacer el registro.");
            }
        }
    });
}
