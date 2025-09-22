$(document).ready(incio);
function incio() {
    $("#precarga").hide();
    $("#form_consulta_filtrada").on("submit",function(e){
        e.preventDefault();
		consultaEstudiantes();	
	});
	//Cargamos los items de los selects
	$.post("../controlador/consultafiltrada.php?op=selectPrograma", function(r){
        $("#programa").html(r);
        $('#programa').selectpicker('refresh');
	})
    //Cargamos los items de los selects contrato
	$.post("../controlador/consultafiltrada.php?op=selectJornada", function(r){
        $("#jornada").html(r);
        $('#jornada').selectpicker('refresh');
	});
}
function consultaEstudiantes() {
    $("#precarga").show();
    var data = ({
        'programa': $("#programa").val(),
        'jornada': $("#jornada").val(),
        'semestre': $("#semestre").val()
    });
    if($.fn.DataTable.isDataTable('#dtl_estudiantes')){
        $('#dtl_estudiantes').DataTable().destroy();
    }
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
            "url": '../controlador/consultafiltrada.php?op=consultaEstudiantes',
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