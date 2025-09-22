// JavaScript Document
$(document).ready(init);
var periodo;
//primera funcion que se ejecut cuando el documento esta listo 
function init() {
	listar_periodos();
	//cierra el formulario y muestra la tabla 
	mostrarform(false);
	$(".buscar_estudiantes_estado_activo").off("click").on("click", function () {
		periodo = $("#periodo").val();
		listarCreditosActivos(periodo);
	});
}
//Lista toodos los estudiantes, por defecto siempre es los pendientes, luego se puede filtrar
function listarCreditosActivos(periodo) {
	$("#precarga").show();
	tabla_financiados = $('#tabla_financiados').dataTable({
		"lengthChange": false,
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		"aProcessing": true,
		"autoWidth": false,
		"dom": 'Bfrtip',
		"buttons": [{
			"extend": 'copyHtml5',
			"text": '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
			"titleAttr": 'Copy'
		}, {
			"extend": 'excelHtml5',
			"text": '<i class="fa fa-file-excel" style="color: green"></i>',
			"titleAttr": 'Excel'
		}, {
			"extend": 'csvHtml5',
			"text": '<i class="fa fa-file-alt"></i>',
			"titleAttr": 'CSV'
		}, {
			"extend": 'pdfHtml5',
			"text": '<i class="fa fa-file-pdf" style="color: red"></i>',
			"titleAttr": 'PDF',
		}],
		"ajax": {
			"url": "../controlador/sofi_estado_credito.php?op=listarCreditosActivos&periodo=" + periodo,
			"type": "POST",
			"dataType": "json",
			"error": function (e) {
				// console.log(e.responseText);	
			}
		},
		"initComplete": function () {
			$("#precarga").hide();
		},
		"bDestroy": true,
		"iDisplayLength": 12,
	}).DataTable();
	$('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
	$('.dt-button').removeClass('dt-button');
}
//muestra o esconde el formulario de registro
function mostrarform(flag) {
	if (flag) {
		$("#tablaregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
	} else {
		$("#tablaregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}
//Función cancelarform
function cancelarform() {
	mostrarform(false);
}
function listar_periodos() {
	$.post("../controlador/sofi_estado_credito.php?op=listarPeriodos", function (data, status) {
		var datos = JSON.parse(data);
		if (datos.exito == "1") {
			$("#periodo").html(datos.info);
			$("#periodo").val('2022-1');
			var periodo = $("#periodo").val();
			listarCreditosActivos(periodo);
		} else {
			alertify.error("No existe información");
		}
	});
}