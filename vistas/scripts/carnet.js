var cc;
$(document).ready(inicio);

function inicio() {
    $("#precarga").hide();
    $("#ocultar_select_programas").hide();

    $('#cedula').change(function () {
        cc = $(this).val(); // Actualiza cc con el nuevo valor

        // Una vez que cc tiene un valor, realiza la petición a selectProgramaCarnet
        $.post("../controlador/carnet.php?op=selectProgramaCarnet", { cc: cc }, function (r) {
            $("#programa_carnet").html(r);
            $('#programa_carnet').selectpicker('refresh');
            valorSeleccionado = $("#programa_carnet").val();
            // Aquí podrías llamar a buscar(), si es necesario y apropiado en este punto
        });
    });

    $('#programa_carnet').on('changed.bs.select', function () {
        valorSeleccionado = $(this).val();
        buscar(valorSeleccionado);
    });

}
function buscar() {
    cc = $("#cedula").val();
    $("#ocultar_select_programas").show();
    if (cc != "") {
        $.post("../controlador/carnet.php?op=buscar", { cc: cc, valorSeleccionado: valorSeleccionado }, function (e) {
            var r = JSON.parse(e);
            if (r.status == "ok") {
                $(".cotenido_carnet").html(r.cotenido_carnet);
                $(".cad").html(r.conte2);
            } else {
                $(".cotenido_carnet").html("");
                $(".cad").html("");
                alertify.error("Error: El estudiante no se encuentra o no tiene un programa activo.");
                // alertify.error("Error, no se encuentra el estudiante");
            }
        });
    } else {
        alertify.error("Error, completa el campo");
    }
}

function imprime() {
    printJS({
        printable: 'carnet_frontal',
        type: 'html',
        targetStyles: ['*'],
        css: '../public/css/estilos.css'
    });
}

function imprime2() {
    printJS({
        printable: 'carnet_back',
        type: 'html',
        targetStyles: ['*'],
        css: '../public/css/estilos.css'
    });
}

  
