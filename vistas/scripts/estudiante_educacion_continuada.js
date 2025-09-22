// JavaScript Document
$(document).ready(init);
//inicializacion de variables 
var tabla, tabla_cuotas;
//primera funcion que se ejecut cuando el documento esta listo 
function init() {
    listarCursosEducacionContinuada()
    //esconde la precarga0
    $("#precarga").hide();
}

//funcion para listar la cuota actual
function listarCursosEducacionContinuada() {  
    $.ajax({
        "url": "../controlador/estudiante_educacion_continuada.php?op=listarCursosEducacionContinuada",
        "type": "POST",
        "success": function (datos) {
            console.log(datos);
            //esconde la precarga
            datos = JSON.parse(datos);
            if (datos.exito == 1) {
                $("#listadoCursosEducacionContinuada").html(datos.html);
            } else {
                alertify.error(datos.html);
            }
        }
    });
}