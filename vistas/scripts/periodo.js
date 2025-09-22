$(document).ready(incio);
function incio() {
    periodoActual();
	$("#precarga").hide();
	$("#guardarEditar").hide();
}

function periodoActual() {
    $.post("../controlador/periodo.php?op=periodoActual", function (r) {
        var data = JSON.parse(r);
        $("#periodo_actual").val(data.periodo_actual);
    });
}

function editar() {
    $("#editar").hide();
    $("#guardarEditar").show();
    $("#periodo_actual").prop('disabled', false);
}

function guardarEditar() {
    $.post("../controlador/periodo.php?op=updatePeriodo", { "periodo": $("#periodo_actual").val()}, function (r) {
        var data = JSON.parse(r);
        if (data.status == "ok") {
            alertify.success("Periodo actualizado");
            $("#editar").show();
            $("#guardarEditar").hide();
            $("#periodo_actual").prop('disabled', true);
        }else{
            alertify.error("Error al actualizar el periodo");
        }
    });
}

function aggPeriodo() {

    if ($("#periodoNew").val() == "") {
        alertify.error("Por favor completa el campo.");
    } else {
        $.post("../controlador/periodo.php?op=aggPeriodo", { "periodo": $("#periodoNew").val() }, function (r) {
            var data = JSON.parse(r);
			console.log(r);
            if (data.status == "ok") {
                alertify.success("Periodo agregado con exito");
                $("#periodoNew").val("");
            } else {
                alertify.error("Error al agregar el periodo");
            }
        });
    }

    
}