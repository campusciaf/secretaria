$(document).ready(incio);
function incio() {
    $("#precarga").hide();
    $("#form_restaurar_admision").on("submit", function(e) {
        e.preventDefault();
        Listar_Usarios();
    });
}

function Listar_Usarios(){
    var cedula = $('#cedula').val();
    $.get("../controlador/hojavidaclavecliente.php?op=Listar_Usarios&cedula=" + cedula, function(data){
        data = JSON.parse(data);
        if(Object.keys(data).length > 0){
            $("#listar_usarios_repetidos").html(data.info);

            $("#tabla_listar_usuarios").dataTable({
                "bPaginate": false,

            });
        }
    });
}

function restablecer(usuario_email,usuario_identificacion) {
    swal({
        "title": "",
        "text": "¿Estás seguro de restablecer la contraseña?",
        "icon": "warning",
        "buttons": ["Cancelar", "Restablecer"],
        "dangerMode": true,
    }).then((willDelete) => {
        if (willDelete) {
            $("#precarga").removeClass("hide");
            var data = ({'usuario_email': usuario_email,'usuario_identificacion': usuario_identificacion});
            $.ajax({
                "url": "../controlador/hojavidaclavecliente.php?op=restablecer_clave_hoja_de_vida",
                "type": "POST",
                "data": data,
                success: function (datos) {
                    var r = JSON.parse(datos);
                    if (r.exito == 1) {
                        $("#precarga").addClass("hide");
                        swal(r.info, { "icon": "success" });
                        Listar_Usarios();
                    } else {
                        swal(r.info, { "icon": "error" });
                    }
                }
            });
        }
    });
}



