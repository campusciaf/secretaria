$(document).ready(incio);
function incio() {
   $("#precarga").hide();
}

function consultaEstudiante() {
    var data = ({
        'cedula': $("#cedula").val()
    });

    $.ajax({
        url: "../controlador/estado_estudiante.php?op=consultaEstudiante",
        type: "POST",
        data: data,
        cdataType: 'json',
        success: function (datos) {
            if (datos == "false") {
                $("#consultaEstu").html('<div class="alert alert-danger" role="alert">No existe el estudiante. </div >');
            } else {
                $("#consultaEstu").html(datos);
            }
        }
    });

}

function estadoEst(estado) {
    
    var titulo,conte = "";
    if (estado == 1) {
        titulo = "Activar Estudiante";
        conte = "¿Seguro que deseas activar al estudiante?";
    } else {
        titulo = "Desactivar Estudiante";
        conte = "¿Seguro que deseas desactivar al estudiante?";
    }

    var data = ({
        'estado': estado,
        'cedula': $("#id_cedula").val()
    });

    alertify.confirm(titulo, conte, function () {
        $("#precarga").show();

        $.ajax({
            url: "../controlador/estado_estudiante.php?op=estadoEst",
            type: "POST",
            data: data,
            cdataType: 'json',
            success: function (datos) {
                //console.log(datos);
                var r = JSON.parse(datos);
				console.log(r.status);
                if (r.status == 'ok') {
                    alertify.success("Estado actualizado con exito");
                    consultaEstudiante();
                    $("#precarga").hide();

                } else {
                    alertify.error("Error al actualizar el estado");
                }
            }
        });
        }
        , function () { alertify.error('Cancel') });
}