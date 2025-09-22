var tabla;
//Función que se ejecuta al inicio
function init() {
	$("#precarga").hide();
	//Cargamos los items de los selects contrato
	$.post("../controlador/inspiradores.php?op=selectPeriodo", function (r) {
		$("#periodo").html(r);
		$('#periodo').selectpicker('refresh');
	});
}

//Función Listar
function tablas() {
	$.post("../controlador/inspiradores.php?op=datostabla", {}, function (data, status) {
	
		data = JSON.parse(data);
		var usuario = data.usuario;
		var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
		var f = new Date();
		var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		tabla = $('#tbllistado').dataTable({
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			"dom": 'Bfrtip',//Definimos los elementos del control de tabla
			"buttons": [{
				"extend": 'copyHtml5',
				"text": '<i class="fa fa-copy"></i>',
				"titleAttr": 'Copy'
			},{
				"extend": 'excelHtml5',
				"text": '<i class="fa fa-file-excel"></i>',
				"titleAttr": 'Excel'
			},{
				"extend": 'print',
				"text": '<i class="fas fa-print"></i>',
				"messageTop": '<div style="width:50%;float:left"><b>Usuario:</b>' + usuario + ' <b><br><b>Reporte:</b> Permanencia <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				"title": 'Empresas Amigas',
				"titleAttr": 'Print'
			}],
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},

		});

	});
}

function listar(periodo) {
	$("#precarga").show();
	$.post("../controlador/inspiradores.php?op=listar", { periodo: periodo }, function (data, status) {
		
		data = JSON.parse(data);
		$("#tbllistado").html("");
		$("#tbllistado").append(data["0"]["0"]);
		$("#precarga").hide();
		tablas();
	});
}
init();