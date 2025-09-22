$(document).ready(inicio);

function inicio() {
    listar();
}
function listar() {
    $.post("../controlador/idiomas_precios.php?op=listar", function(dato){
        //console.log(dato);
        var r = JSON.parse(dato);
        $("#listadoregistros").html(r.conte);

        $(".fomr_edi").on("submit", function(e){
            editar_val(e);
        });

    });
}

function editar_val(e) {
    e.preventDefault();
    var formselect = $(e.target).data('nombre');
    var formData = new FormData($("#"+formselect)[0]);


    $.ajax({
        "url": "../controlador/idiomas_precios.php?op=editar_val",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function(datos) {
            //esconde la precarga
            console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == 'ok') {
                alertify.success(r.msj);
                listar();
            } else {
                alertify.error(r.msj);
            }
        }
    });    
}