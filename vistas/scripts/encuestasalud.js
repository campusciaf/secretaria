$(document).ready(inicio);
function inicio() {
	$("#precarga").hide();
	$("#formulario").hide();
    $("#form_encuesta").on("submit", function (e) {
        e.preventDefault();
        registro();
    })
}

function buscar(cc) {
    $.post("../controlador/encuestasalud.php?op=buscar"+$(".tipo").val(), { cc: cc }, function (data) {
        
        console.log(data);
        var r = JSON.parse(data);

        if (r.bandera == "2") {
            $("#info_estudi").html(r.conte);
            if (r.status2 == "ok") {
                alertify.success(r.msj2);
                setTimeout(function () { location.reload(); }, 3000);
            } else {
                alertify.error(r.msj2);
            }
        }

        if (r.bandera == "1") {
            if (r.status == "ok") {
                $("#info_estudi").html(r.conte);
                $("#conte2").html(r.conte2);
                $("#conte3").html(r.conte3);
                $("#conte4").html(r.conte4);
                $("#formulario").show();
                alertify.success(r.msj);            
            }else{
                alertify.error(r.msj);
            }
        }

        

        

    });
}

function registro() {
    var formData = new FormData($("#form_encuesta")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/encuestasalud.php?op=registro",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                alertify.success("Registro exitoso.");
                $("#form_encuesta")[0].reset();
                $("#info_estudi").html("");
                $("#conte2").html("");
                $("#conte3").html("");
                $("#conte4").html("");
                $("#formulario").addClass("hidden");
                $("#identifica").val("");                
            } else {
                alertify.error("Error al hacer el registro.");
            }
        }
    });
}

function limpiar() {
    $("#identifica").val("");
    $("#info_estudi").html("");
    $("#conte2").html("");
    $("#conte3").html("");
    $("#conte4").html("");
    $("#formulario").addClass("hidden");
}