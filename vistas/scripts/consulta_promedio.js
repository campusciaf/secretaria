
//Función que se ejecuta al inicio
function init(){
    programas();
    periodo();
    $("#precarga").hide();
    $.post("../controlador/consulta_promedio.php?op=selectJornada", function(r) {
        $("#jornada_promedio").html(r);
        $('#jornada_promedio').selectpicker('refresh');
    });
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
    $.post("../controlador/consulta_promedio.php?op=listarPeriodo", function (datos) {
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
    var programa = $("#programa").val();
    var periodo = $("#periodo").val();
    var jornada = $("#jornada_promedio").val();
    if (!programa || !periodo || !jornada) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor seleccione programa, periodo y jornada antes de continuar.',
            confirmButtonColor: '#3085d6'
        });
        return; 
    }
    var data = {
        'programa': programa,
        'periodo': periodo,
        'jornada_promedio': jornada
    };
    $("#precarga").show();
    $("#div_promedio").show();
    $('#tld_promedio').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "responsive": true,
        "dom": 'Bfrtip',
        "buttons": [{
            "extend": 'excelHtml5',
            "text": '<i style="color:green;" class="fas fa-file-excel fa-2x"></i>',
            "titleAttr": 'Reporte Excel',
            "title": 'Registro municipios movilización'
        }],
        "columnDefs": [{ "className": "dt-center", "targets": "_all" }],
        "initComplete": function () {
            $("#precarga").hide();
        },
        "ajax": {
            "url": '../controlador/consulta_promedio.php?op=consultaPromedio',
            "data": data,
            "type": "POST",
            "dataType": "json",
            "error": function (e) {
                // console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 20,
        "order": [[5, "desc"]]
    }).DataTable();
}



init();































