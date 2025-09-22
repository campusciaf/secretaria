$(document).ready(init);
var puntos_maximos_asignables = 0;
function init() {
    $(".precarga").hide();
    $("#formularioInsercionPuntos").hide();
    $("#formularioBusquedaEstudiante").on("submit", function (e) {
        BusquedaEstudiante(e);
    });
    $("#formularioInsercionPuntos").on("submit", function (e) {
        InsercionPuntos(e);
    });
    $("#punto_maximo").on("input", function () {
        if (parseInt($(this).val()) > puntos_maximos_asignables) {  
            Swal.fire({ "icon": "error", "title": "Error", "text": "El número de puntos no puede ser mayor a " + puntos_maximos_asignables });
            $(this).val(puntos_maximos_asignables);
        }   
    });
    ListarNombrePuntos();
}
function BusquedaEstudiante(e) {
    e.preventDefault();
    $("#btnBusquedaEstudiante").prop("disabled", true);
    var formData = new FormData($("#formularioBusquedaEstudiante")[0]);
    $.ajax({
        "url": "../controlador/puntos_billetera_docente.php?op=BusquedaEstudiante",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            $("#btnBusquedaEstudiante").prop("disabled", false);
            try {
                let data = JSON.parse(datos);
                if (data.exito == 1) {
                    $(".box_nombre_estudiante").html((data.nombre_estudiante == "") ? "Estudiante En Pre-registro" : data.nombre_estudiante);
                    $("#nombre_estudiante").val(data.nombre_estudiante);
                    $(".box_correo_electronico").html(data.correo_electronico);
                    $("#id_credencial_puntos").val(data.id_credencial);
                    $("#es_estudiante").val(data.es_estudiante);
                    $("#formularioInsercionPuntos").slideDown("slow");
                }
            } catch (error) {
                Swal.fire({ "icon": "error", "title": "Error", "text": "Hubo un problema al procesar la respuesta." });
            }
        }
    });
}
function InsercionPuntos(e) {
    e.preventDefault();
    $("#btnInsercionPuntos").prop("disabled", true);
    var formData = new FormData($("#formularioInsercionPuntos")[0]);
    $.ajax({
        "url": "../controlador/puntos_billetera_docente.php?op=InsercionPuntos",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            $("#btnInsercionPuntos").prop("disabled", false);
            try {
                let data = JSON.parse(datos);
                if (data.exito == 1) {
                    Swal.fire({ "position": "top-end", "icon": "success", "title": data.info, "showConfirmButton": false, "timer": 1500 });
                    $("#formularioInsercionPuntos").slideUp("slow");
                    $("#formularioInsercionPuntos")[0].reset();
                    $("#formularioBusquedaEstudiante")[0].reset();
                    $(".box_nombre_estudiante").html("-");
                    $(".box_correo_electronico").html("-");
                    $("#nombre_estudiante").val("");
                    $("#id_credencial_puntos").val("");
                    $("#es_estudiante").val("");
                }
            } catch (error) {
                Swal.fire({ "icon": "error", "title": "Error", "text": "Error al insertar" });
                console.log(datos)
            }
        }
    });
}
function ListarNombrePuntos() {
    $.post("../controlador/puntos_billetera_docente.php?op=ListarNombrePuntos", function (data, status) {
        data = JSON.parse(data);
        if (data.exito == 1) {
            $("#punto_nombre").html(data.info);
            $("#punto_nombre").on("change", ObtenerPuntosMaximos);
        }
    });
}
function ObtenerPuntosMaximos() {
    $.post("../controlador/puntos_billetera_docente.php?op=ObtenerPuntosMaximos", { "id_punto": $("#punto_nombre").val() }, function (data) {
        data = JSON.parse(data);
        if (data.exito == 1) {
            $("#punto_maximo").val(data.info);
            puntos_maximos_asignables = parseInt(data.info);
        }
    });
}