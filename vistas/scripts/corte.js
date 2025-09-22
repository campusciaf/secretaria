$(document).ready(incio);
function incio() {
    consultaEstado();
}



function consultaEstado() {
    $.post('../controlador/corte.php?op=consulta', function (data) {
        //console.log(data);

        var r = JSON.parse(data);
        if (r.corte == "1") {
            $('#estadoCorte').bootstrapToggle('on');
        }else{
            $('#estadoCorte').bootstrapToggle('off');
        }

    });
}


$("#cambiar").click(function () {
    var corte = "";
    if ($("#estadoCorte").prop('checked')) {
        corte = "1";
    }else{
        corte = "2";
    }
    $.post('../controlador/corte.php?op=cambiarCorte', {'corte':corte} ,function (data) {
        var r = JSON.parse(data);
        console.log(r);
        if (r.status == "ok") {
            if (corte == "1") {
                $('#estadoCorte').bootstrapToggle('on');
            } else {
                $('#estadoCorte').bootstrapToggle('off');
            }
        } else {
            alertify.error(r.status);
        }
    });
});

