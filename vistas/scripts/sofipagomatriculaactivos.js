// JavaScript Document
$(document).ready(init);
var periodo;
//primera funcion que se ejecut cuando el documento esta listo 
function init() {
	//lista los preiodos existente en el sistema 
	$("#precarga").show();
	listar_periodos();
	//trae el filtro para los estudiantes
	$(".buscar_estudiantes").off("click").on("click", function () {
		periodo = $("#periodo").val();
		listaractivos(periodo);
	});
}
//Función para verificar si lafecha seleccionada es un 31
function verificar_dia(campo) {
	var dias = campo.split("-").pop();
	if (dias == "31" || dias == 31) {
		alertify.error("Indica un dia diferente al 31.");
		$(".btn_aprobar_solucitud").attr("disabled", true);
	} else {
		$(".btn_aprobar_solucitud").attr("disabled", false);
	}
}
//lista los periodos existen en el sistema
function listar_periodos() {
	$.post("../controlador/sofipagomatriculaactivos.php?op=listarPeriodos", function (data, status) {
		/*console.log(data);*/
		var datos = JSON.parse(data);
		if (datos.exito == "1") {
			$("#periodo").html(datos.info);
			$('#periodo').selectpicker('refresh');
			periodo = $("#periodo").val();
			listaractivos(periodo);
		} else {
			alertify.error("No existe información");
		}
	});
}
//Lista toodos los estudiantes, de la tabla activos por periodo
function listaractivos(periodo) {
	$("#precarga").show();
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tabla_financiados').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		"dom": 'Bfrtip',//Definimos los elementos del control de tabla
		"buttons": [{
			"extend": 'excelHtml5',
			"text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
			"titleAttr": 'Excel',
			"filename": 'pago_matriculas_activas_' + periodo
		},{
			"extend": 'print',
			"text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
			"messageTop": '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
			"title": 'Renovaciones',
			"titleAttr": 'Print',
			"filename": 'pago_matriculas_activas_' + periodo
		}],
		"ajax":{
			"url": '../controlador/sofipagomatriculaactivos.php?op=listarFinanciados&periodo=' + periodo,
			"type": "get",
			"dataType": "json",
			error: function (e) {
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[1, "asc"]],
		'initComplete': function (settings, json) {
			$("#precarga").hide();
		},
	});
}