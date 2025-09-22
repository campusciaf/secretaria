$(document).ready(incio);
function incio() {
    $("#precarga").hide();
    $("#ocultar_tb2").hide();

	$("#form_consulta_ies").on("submit",function(e) {
     e.preventDefault();  
     consultaies() 
    })
    //Cargamos los items de los selects para las IES
	$.post("../controlador/consultaies.php?op=selectIES", function(r){
        console.log(r)
        $("#jornada").html(r);
        $('#jornada').selectpicker('refresh');
	});
     //Cargamos los items de los selects para los periodos
    $.post("../controlador/consultaies.php?op=selectPeriodo", function(r){
        $("#periodo").html(r);
        $('#periodo').selectpicker('refresh');
	});
}

function consultaies() {
    $("#precarga").show();
    $("#ocultar_tb2").hide();
    $("#ocultar_tb1").show();
    var data = ({
        'jornada': $("#jornada").val(),
        'periodo': $("#periodo").val()
    });
    $('#dtl_estudiantes').dataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "responsive": true,
        "dom": 'Bfrtip',
        "buttons": [{
            "extend": 'excelHtml5',
            "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
            "titleAttr": 'Excel'
        },{
            "extend": 'print',
            "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
            "titleAttr": 'Imprimir'
        }],
        "columnDefs": [{ "className": "dt-center", "targets": "_all" }],
        "initComplete": function() {
            $("#precarga").hide();
        },
        "ajax":{
            "url": '../controlador/consultaies.php?op=consultaies',
            "type": "post",
            "dataType": "json",
            "data":data,
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        
        "bDestroy": true,
        "iDisplayLength": 10,//Paginación
        
    }).DataTable();
    
    
}

function mostrar() {
    $("#precarga").show();
    $("#ocultar_tb2").show();
    $("#ocultar_tb1").hide();
    $('#mostrar').dataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "responsive": true,
        "dom": 'Bfrtip',
        "buttons": [{
            "extend": 'excelHtml5',
            "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
            "titleAttr": 'Excel'
        },{
            "extend": 'print',
            "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
            "titleAttr": 'Imprimir'
        }],
        "columnDefs": [{ "className": "dt-center", "targets": "_all" }],
        "initComplete": function() {
            $("#precarga").hide();
        },
        "ajax":{
            "url": '../controlador/consultaies.php?op=mostrar',
            "type": "post",
            "dataType": "json",
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        
        "bDestroy": true,
        "iDisplayLength": 10,//Paginación
        
    }).DataTable();
    
    
}
function mostrarModal(id_estudiante,periodo_activo) {
    $("#precarga").show();
    var data = ({
        'id_estudiante':id_estudiante,
        'periodo_activo':periodo_activo
    });
    $('#dtl_faltas').dataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "responsive": true,
        "dom": 'Bfrtip',
        "buttons": [{
            "extend": 'excelHtml5',
            "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
            "titleAttr": 'Excel'
        },{
            "extend": 'print',
            "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
            "titleAttr": 'Imprimir'
        }],
        "columnDefs": [{ "className": "dt-center", "targets": "_all" }],
        "initComplete": function() {
            $("#precarga").hide();
        },
        "ajax":{
            "url": '../controlador/consultaies.php?op=verfaltas',
            "type": "post",
            "dataType": "json",
            "data":data,
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        
        "bDestroy": true,
        "iDisplayLength": 10,//Paginación
        
    }).DataTable();
    
    $('#modalFaltas').modal('show');
}