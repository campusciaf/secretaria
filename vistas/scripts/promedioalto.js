$(document).ready(incio);
function incio() {
    programas();
    periodo();
    $("#precarga").hide();
}
function programas() {
    $.post("../controlador/listarcategoria.php?op=listarProgra", function (datos) {
        var opti = "";
        var r = JSON.parse(datos);
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].id_programa + '">' + r[i].nombre + '</option>';
        }
        $("#programa").append(opti);
        $('#programa').selectpicker();
        $('#programa').selectpicker('refresh');
    });
}
function periodo() {
    $.post("../controlador/promedioalto.php?op=listarPeriodo", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        //console.log(r);
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].periodo + '">' + r[i].periodo + '</option>';
        }
        $("#periodo").append(opti);
        $('#periodo').selectpicker();
        $('#periodo').selectpicker('refresh');
    });
}
function consultaPromedios() {
    var data = ({
        'programa': $("#programa").val(),
        'periodo': $("#periodo").val()
    });
    $("#precarga").show();
    $("#div_promedio").show();
    $('#tld_promedio').dataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "responsive": true,
        "dom": 'Bfrtip',//Definimos los elementos del control de tabla
        "buttons":[{
            "extend": 'excelHtml5',
            "text": '<i style="color:green;" class="fas fa-file-excel fa-2x"></i>',
            "titleAttr": 'Reporte Excel',
            "title": 'Registro municipios movilización'
        }],
        "columnDefs": [{ "className": "dt-center", "targets": "_all" }],
        "initComplete": function(){
            $("#precarga").hide();
        },
        "ajax":{
            "url": '../controlador/promedioalto.php?op=consultaPromedio',
            "data":data,
            "type": "POST",
            "dataType": "json",
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 20,//Paginación
        "order": [[5, "desc"]]//Ordenar (columna,orden)
    }).DataTable();
}