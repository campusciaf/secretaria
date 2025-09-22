$(document).ready(incio);
function incio() {
    programas();
    listarJornada();
}
function programas() {
    $.post("../controlador/listarcategoria.php?op=listarProgra", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].id_programa +'">'+r[i].nombre+'</option>';
        }

        $("#programa").append(opti);
        $('#programa').selectpicker();
        $('#programa').selectpicker('refresh');
    });
}
function listarJornada() {
    $.post("../controlador/listarcategoria.php?op=listarJornada", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].nombre + '">' + r[i].nombre + '</option>';
        }

        $("#jornada").append(opti);
    });
}

function consultaEstudiantes() {
    var data = ({
        'programa': $("#programa").val(),
        'jornada': $("#jornada").val(),
        'semestre': $("#semestre").val()
    });
    //console.table(data);
    /* $.post("../controlador/listarcategoria.php?op=consultaEstudiantes",data, function (datos) {
        console.table(datos);
    }); */

    $("#precarga").removeClass('hide');
    if ($.fn.DataTable.isDataTable('#dtl_estudiantes')) {
        $('#dtl_estudiantes').DataTable().destroy();
    }
    $('#dtl_estudiantes').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            "columnDefs": [{ "className": "dt-center", "targets": "_all" }],
            'initComplete': function (settings, json) {
                $("#precarga").addClass('hide');
            },
            "ajax":
            {
                url: '../controlador/listarcategoria.php?op=consultaEstudiantes',
                type: "post",
                dataType: "json",
                data:data,
                error: function (e) {
                    console.log(e.responseText);
                }
            },

            "bDestroy": true,
            "iDisplayLength": 15,//Paginación
            //"order": [[ 0, "desc" ]]//Ordenar (columna,orden)
        }).DataTable();

}