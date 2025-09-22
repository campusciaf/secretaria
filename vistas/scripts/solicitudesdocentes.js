$(document).ready(incio);
function incio() {
    listar_solicitudes('enviadas');
	$("#precarga").hide();
}

function listar_solicitudes(guia) {
    $('#tbl_solicitudes').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            responsive: true,
            "stateSave": true,
            "columnDefs": [{ "className": "dt-center", "targets": "_all" }],
            "ajax":
            {
                url: '../controlador/solicitudViaticosDirectivos.php?op=listar_solicitudes_docente_director&guia=' + guia,
                type: "get",
                dataType: "json",

                error: function (e) {
                    console.log(e.responseText);
                }
            },

            "bDestroy": true,
            "iDisplayLength": 5,//Paginación
            // "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
        }).DataTable();
}
function filtrar_solicitudes_aprobadas() {
    $('#icono_btn_solicitudes_aprobadas').css('display', 'inline');
    $('#icono_btn_solicitudes_rechazadas').css('display', 'none');
    $('#icono_btn_solicitudes_todas').css('display', 'none');
    listar_solicitudes('3');
}
function filtrar_solicitudes_rechazadas(valor) {
    $('#icono_btn_solicitudes_rechazadas').css('display', 'inline');
    $('#icono_btn_solicitudes_aprobadas').css('display', 'none');
    $('#icono_btn_solicitudes_todas').css('display', 'none');
    listar_solicitudes('4');
}
function filtar_todas() {
    $('#icono_btn_solicitudes_todas').css('display', 'inline');
    $('#icono_btn_solicitudes_aprobadas').css('display', 'none');
    $('#icono_btn_solicitudes_rechazadas').css('display', 'none');
    listar_solicitudes('enviadas');
}
function ver_actividades(id, estado) {
    $('#modal_clases_registradas').modal('show');
    $('#tbl_clases').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            responsive: true,
            "stateSave": true,
            "columnDefs": [
                { "className": "dt-center", "targets": "_all" },
                {
                    "targets": [5],
                    "visible": false,
                    "searchable": false
                }
            ],
            "ajax":
            {
                url: '../controlador/solicitudesdoce.php?op=listar_clases_solicitud&id_solicitud=' + id,
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },

            "bDestroy": true,
            "iDisplayLength": 5,//Paginación
            "order": [[4, "desc"]]//Ordenar (columna,orden)
        }).DataTable();
}

function gestion_solicitud_dir(id, guia) {
    var mensaje = "";
    var mensaje_2 = "";
    var respuesta = "";
    if (guia == "3") {
        mensaje = "Aceptar solicitud";
        mensaje_2 = "Presione el botón aceptar para confirmar la aprobación de la solicitud";
        respuesta = "Solicitud aceptada con exito";
    }
    else {
        mensaje = "Rechazar solicitud";
        mensaje_2 = "Presione el botón aceptar para confirmar el rechazo de la solicitud";
        respuesta = "Solicitud rechazada con exito";
    }
    alertify.confirm(mensaje, mensaje_2, function () {
        $('#div_loading').show();
        $.post("../controlador/solicitudesdoce.php?op=respuesta_solicitud_dir", { id: id, guia: guia }, function (r) {
            if (r == 1) {
                listar_solicitudes('enviadas');
                alertify.success(respuesta);
            }
            else {
                alertify.error("Problemas con el servidor al realziar la acción, intentelo de nuevo");
            }
        });

    }, function () { }).set('labels', { ok: 'Aceptar', cancel: 'Cancelar' });
}