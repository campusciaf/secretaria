$(document).ready(inicio);
function inicio() {
    listar();
    datospanel();

    $("#div_tablaResultados").hide();
    //Cargamos los items de los selects
	$.post("../controlador/ver_encuentas.php?op=selectPeriodo", function(r){
        var data = JSON.parse(r);
        if(Object.keys(data).length > 0){
            var html = '';
           for(var i = 0; i < Object.keys(data).length;i++ ){
               html += '<option value="'+data[i].periodo+'">'+data[i].periodo+'</option>';
           }
        }
        $("#input_periodo").html(html);
     
	});
    //verifica si la evaluacion esta activa o inactiva
    mostrarEstadoEvalaucion();
    //activa o desactiva la heteroevalaucion
    $('#switch_evaluacion_docente').change(function(){
        estado = ($(this).prop('checked'))?1:0;
        $.post("../controlador/ver_encuentas.php?op=cambiarEstadoEvalaucion", {"tipo": "evaluaciondocente", "estado": estado}, function(r){
            console.log(r);
            r = JSON.parse(r);
            if (r.exito == 1) { 
                alertify.success("Cambio exitoso"); 
                mostrarEstadoEvalaucion(); 
            }else{ 
                alertify.error("Error al cambiar de estado la evaluación docente"); 
            }
        });
    });
}

function datospanel() {
    var periodobuscar=$("#input_periodo").val();
    $.post("../controlador/ver_encuentas.php?op=datospanel",{periodobuscar:periodobuscar}, function(r){
        var data = JSON.parse(r);
        $("#datos").html(data);
    });
}

function mostrarEstadoEvalaucion() {
    $.post("../controlador/ver_encuentas.php?op=mostrarEstadoEvalaucion",{"tipo": "evaluaciondocente"}, function(r){
        var data = JSON.parse(r);
        if(data.estado == 0){
            $('#switch_evaluacion_docente').prop("checked", false);
            $('.estado_evaluacion_docente').text("Inactiva");
        }else{
            $('#switch_evaluacion_docente').prop("checked", true);
            $('.estado_evaluacion_docente').text("Activa");
        }
	});
}

function listar(periodo){
    $("#precarga").show();
    $("#div_tablaDocentes").show();
    $("#div_tablaResultados").hide();
    $('#tlb_listar').dataTable({
        "aProcessing": true,
		"aServerSide": true,
		"autoWidth": false,
		"dom": 'Bfrtip',
        "buttons": [{
            "extend":    'excelHtml5',
            "text":      '<i class="fa fa-file-excel" style="color: green"></i>',
            "titleAttr": 'Excel'
        },{
            "extend": 'print',
            "text": '<i class="fas fa-print" style="color: #ff9900"></i>',
            "title": 'Resultado heteroevaluación',
            "titleAttr": 'Imprimir'
        }],
		"ajax":{
            "url": "../controlador/ver_encuentas.php?op=consulta",
			"type" : "POST",
            "data":{periodo : periodo},
			"dataType" : "json",
			"error": function(e){
                console.log(e.responseText);	
			}
		},
        "bDestroy": true,
		"iDisplayLength": 20,
        "order": [[ 4 , "desc" ]],
        "initComplete": function() {
            datospanel();
            $("#precarga").hide();
           
            
        }
	}).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
	$('.dt-button').removeClass('dt-button');
}


function listarResultados(id_usuario, periodo = null){
    $("#id_docente_activo").val(id_usuario);
    $("#div_tablaDocentes").hide();
    $("#div_tablaResultados").show();
    $("#precarga").show();
    $('#tablaResutados').dataTable({
        "aProcessing": true,
		"aServerSide": true,
		"autoWidth": false,
		"dom": 'Bfrtip',
        "buttons": [{
            "extend":    'excelHtml5',
            "text":      '<i class="fa fa-file-excel" style="color: green"></i>',
            "titleAttr": 'Excel'
        },{
            "extend": 'print',
            "text": '<i class="fas fa-print" style="color: #ff9900"></i>',
            "title": 'Heteroevaluación',
            "titleAttr": 'Imprimir'
        }],
		"ajax":{
            "url": "../controlador/ver_encuentas.php?op=listarResultados",
			"type" : "POST",
            "data" : {id_docente : id_usuario, periodo : periodo}, 
			"dataType" : "json",
			"error": function(e){
                console.log(e.responseText);	
			}
		},
        "bDestroy": true,
		"iDisplayLength": 20,
        "order": [[ 2 , "desc" ]],
        "initComplete": function() {
            $("#precarga").hide();
        }
	}).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
	$('.dt-button').removeClass('dt-button');
}
function volverDocentes(){
    $("#div_tablaDocentes").show();
    $("#div_tablaResultados").hide();
}


