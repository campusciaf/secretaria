$(document).ready(inicio);
function inicio() {
    $("#precarga").hide();
}

function buscar(val) {
$("#precarga").show();
    $.post("../controlador/listaringreso.php?op=buscar", { val: val }, function (data) {

        //console.log(data);
        var r = JSON.parse(data);
        $(".tbl_registros").html(r.conte);
        $("#tl_listar").DataTable(
            {
                "order": [],
                'initComplete': function (settings, json) {
                    $("#precarga").hide();
                },
                "iDisplayLength": 20,//Paginación
            }
        );
    });
}