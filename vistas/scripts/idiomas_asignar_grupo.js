$(document).ready(inicio);
function inicio() {
    listar();
}
function listar() {
    $.post("../controlador/idiomas_asignar_grupo.php?op=listar", function(dato){
        //console.log(dato);
        var r = JSON.parse(dato);
        $("#listardatos").html(r.conte);
        $("#tbl_estu").DataTable();
        $('._tooltip').tooltip()
        // $("#select").selectpicker();
    });
}

function asignar_grupo(id,id_credencial) {
    $.post("../controlador/idiomas_asignar_grupo.php?op=asignar_grupo",{id:id,id_credencial:id_credencial}, function(dato){
        //console.log(dato);
        var r = JSON.parse(dato);
        if (r.status == 'ok') {
            alertify.success(r.msj);
            listar();
        } else {
            alertify.error(r.msj);
        }
    });
}

function sacar_grupo(id) {
    $.post("../controlador/idiomas_asignar_grupo.php?op=sacar_grupo",{id:id}, function(dato){
        console.log(dato);
        var r = JSON.parse(dato);
        if (r.status == 'ok') {
            alertify.success(r.msj);
            listar();
        } else {
            alertify.error(r.msj);
        }
    });
}