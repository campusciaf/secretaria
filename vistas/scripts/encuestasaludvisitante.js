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
    
    $.post("../controlador/encuestasaludvisitante.php?op=buscar", { cc: cc }, function (data) {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        
        var r = JSON.parse(data);
        //console.log(r);

        /* if (r.estado == '1') { */
            /* $(".campos").attr("disabled", true); */
        /* }else{
            $(".campos").attr("disabled", false);
        } */

        if (r.bandera == "2") {
            $("#info_estudi").html(r.conte);
            $("#conte2").html("");
            $("#conte3").html("");
            $("#conte4").html("");
            $("#formulario").hide();
            if (r.status2 == "ok") {
                alertify.success(r.msj2);
                setTimeout(function () { location.reload(); }, 3000);
                
            } else {
                console.log(1);
                alertify.error(r.msj2);
            }
        }else{
            if (r.status == "ok") {
                $("#info_estudi").html(r.conte);
                $("#conte2").html(r.conte2);
                $("#conte3").html(r.conte3);
                $("#conte4").html(r.conte4);
                $("#formulario").show();
                alertify.success(r.msj);

            } else {
                console.log(2);
                alertify.error(r.msj);
            }
        }

    });
}

function registro() {
    $("#btn-enviar").attr("disabled",true);
    var formData = new FormData($("#form_encuesta")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/encuestasaludvisitante.php?op=registro",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                alertify.success("Registro exitoso.");
                $("#form_encuesta")[0].reset();
                $("#info_estudi").html("");
                $("#conte2").html("");
                $("#conte3").html("");
                $("#conte4").html("");
                $("#formulario").hide();
                $("#identifica").val("");
                $("#btn-enviar").attr("disabled", false);
                /* $(".campos").attr("disabled", false); */

            } else {
                $("#btn-enviar").attr("disabled", false);
                alertify.error("Error al hacer el registro.");
            }
        }
    });
}