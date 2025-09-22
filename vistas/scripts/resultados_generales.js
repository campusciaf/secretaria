$(document).ready(inicio);
function inicio() {
    listar();
    $("#div_tablaResultados").hide();
    //Cargamos los items de los selects
    $.post("../controlador/resultados_generales.php?op=selectPeriodo", function (r) {
        var data = JSON.parse(r);
        if (Object.keys(data).length > 0) {
            var html = '';
            for (var i = 0; i < Object.keys(data).length; i++) {
                html += '<option value="' + data[i].periodo + '">' + data[i].periodo + '</option>';
            }
        }
        $("#input_periodo").html(html);
    });
}
function listar(periodo) {
    $("#precarga").show();
    $("#div_tablaDocentes").show();
    $("#div_tablaResultados").hide();
    $('#tlb_listar').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "buttons": [{
            "extend": 'excelHtml5',
            "text": '<i class="fa fa-file-excel" style="color: green"></i>',
            "titleAttr": 'Excel'
        }, {
            "extend": 'print',
            "text": '<i class="fas fa-print" style="color: #ff9900"></i>',
            "title": 'General evaluación',
            "titleAttr": 'Imprimir'
        }],
        "ajax": {
            "url": "../controlador/resultados_generales.php?op=consulta",
            "type": "POST",
            "data": { "periodo": periodo },
            "dataType": "json",
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 20,
        "initComplete": function () {
            $("#precarga").hide();
        }
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
    $('.dt-button').removeClass('dt-button');
    $('input[type=search]').addClass('form-control');
}
