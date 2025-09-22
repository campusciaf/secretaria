$(document).ready(inicio);
function inicio() {}

function consulta() {
    $("#precarga").show();
    var data = ({
        'cedula':$("#cedula").val()
    });
    $.post("../controlador/promedio.php?op=consulta", data, function (datos) {
        var r = JSON.parse(datos);
        $("#precarga").hide();
        $(".datos").html(r.datos);
        $("#table").html(r.table);
    });
}

function promedios(id_usuario,id_programa,ciclo) {
    $("#precarga").show();
    var data = ({
        'id_usuario': id_usuario,
        'id_programa': id_programa,
        'ciclo':ciclo
    });
    $.post("../controlador/promedio.php?op=consultaMaterias", data, function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        $("#precarga").hide();
        $("#table").html(r.notas);
    });
}
function volver() {
    consulta();
}