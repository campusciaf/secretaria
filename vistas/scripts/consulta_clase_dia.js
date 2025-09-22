$(document).ready(inicio);
function inicio() {
    listarperiodo();
    $("#form_consulta").on("submit", function (e) {
        e.preventDefault();
        consulta();
    });
}

function listarperiodo() {
    $.post("../controlador/consulta_clase_dia.php?op=listarperiodo", function (datos) {
        //console.log(datos);
        var opti = "";
        var r = JSON.parse(datos);
        //console.log(r);
        opti += '<option value="" selected disabled> - Periodo - </option>';
        
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].periodo + '">' + r[i].periodo + '</option>';
        }
        //$("#comunidad_negra").removeClass("hide");
        $("#periodo").html(opti);
        $('#periodo').selectpicker();
        $('#periodo').selectpicker('refresh');
    });
}

function consulta() {
    $("#precarga").removeClass('hide');
    var formData = new FormData($("#form_consulta")[0]);    
    $.ajax({
        type: "POST",
        url: "../controlador/consulta_clase_dia.php?op=consulta",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            $("#conte").html(r.conte);
            $('#dtl_consulta').DataTable({
                dom: 'Bfrtip',
                'initComplete': function (settings, json) {
                    $("#precarga").addClass('hide');
                },
                buttons: [
                    'excel', 'pdf'
                ]
            });
        }
    });
}