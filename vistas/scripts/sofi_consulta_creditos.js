// JavaScript Document
$(document).ready(init);
var periodo;
//primera funcion que se ejecut cuando el documento esta listo 
function init(){
    //lista los preiodos existente en el sistema 
    listar_periodos();
    //cierra el formulario y muestra la tabla 
    mostrarform(false);
    //trae el filtro para los estudiantes
    $(".buscar_estudiantes").off("click").on("click",function(){
        periodo = $("#periodo").val();
        listar_financiados("Aprobado", periodo);
    });
}
//lista los periodos existen en el sistema
function listar_periodos(){
	$.post("../controlador/sofi_consulta_creditos.php?op=listarPeriodos", function(data, status){
        /*console.log(data);*/
		var datos = JSON.parse(data);		
		if(datos.exito == "1"){
            $("#periodo").html(datos.info);
            periodo = $("#periodo").val();
            listar_financiados("Aprobado", periodo);
        }else{
            alertify.error("No existe información");
        }
 	});
}
//Lista toodos los estudiantes, por defecto siempre es los pendientes, luego se puede filtrar
function listar_financiados(datos, periodo){
    tabla_financiados = $('#tabla_financiados').dataTable({
		"lengthChange": false,	
		"stateSave": true,
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "aProcessing": true,
		"autoWidth": false,
		"dom": 'Bfrtip',
        "buttons": [{
               "extend":    'copyHtml5',
               "text":      '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
               "titleAttr": 'Copy'
           },{
               "extend":    'excelHtml5',
               "text":      '<i class="fa fa-file-excel" style="color: green"></i>',
               "titleAttr": 'Excel'
           },{
               "extend":    'csvHtml5',
               "text":      '<i class="fa fa-file-alt"></i>',
               "titleAttr": 'CSV'
           },{
               "extend":    'pdfHtml5',
               "text":      '<i class="fa fa-file-pdf" style="color: red"></i>',
               "titleAttr": 'PDF',
           }],
		"ajax":{
			"url": "../controlador/sofi_consulta_creditos.php?op=listarFinanciados&estado="+datos+"&periodo="+periodo,
			"type" : "POST",
			"dataType" : "json",
			"error": function(e){
				// console.log(e.responseText);	
			}
		},
        "bDestroy": true,
		"iDisplayLength": 12,	
	}).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
	$('.dt-button').removeClass('dt-button');
}
//muestra o esconde el formulario de registro
function mostrarform(flag){	
	if (flag){
		$("#tablaregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		$("#tablaregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}
//Función cancelarform
function cancelarform(){
	mostrarform(false);
}