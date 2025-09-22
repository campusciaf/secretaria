$(document).ready(incio);
function incio(){}

function ingresocampus() {
    roll = $("#estado_ingreso").val();
    fecha_ingreso = $("#fecha_ingreso").val();
    $.post("../controlador/ingreso_campus.php?op=ingresocampus", { "roll_php": roll, "fecha_ingreso_php" : fecha_ingreso}, function (datos) {
        //console.table(datos);
        $("#ingreso").html(datos);
        $('.tooltip').remove();
        $(".tooltip-dato").tooltip(); 
    });
}

