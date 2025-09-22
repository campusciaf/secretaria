var tabla;
function init() {
	listargeneral();
	$("#resultadoprofesional").hide();
}
//Función para mostrar los datos de contactanos 
function listargeneral() {
	$("#precarga").show();
	$("#resultadoprofesional").hide();
	$.post("../controlador/consultaprograma.php?op=listargeneral", {}, function (data) {
		data = JSON.parse(data);
		$("#datos").html(data.total);
		$("#precarga").hide();
	});
}
//Función para mostrar los datos de contactanos 
function profesional(valor) {
	$("#precarga").show();
	$.post("../controlador/consultaprograma.php?op=profesional", { valor: valor }, function (data) {
		data = JSON.parse(data);
		$("#resultadoprofesional").show();
		$("#profesional").html(data.total);
		$("#precarga").hide();
	});
}
//Función para mostrar los datos de contactanos 
function activarjornada(id_jornada, valor) {
	$("#precarga").show();
	$.post("../controlador/consultaprograma.php?op=activarjornada", { id_jornada: id_jornada, valor: valor }, function (data) {
		listargeneral();
	});
}
//Función ver estudiantes
function listarestudiantes(periodo, valor) {
	$("#precarga").show();
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistado').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
				{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					titleAttr: 'Excel'
				},
				{
					extend: 'print',
					text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					titleAttr: 'Print'
				},
			],
			"ajax":
			{
				url: '../controlador/consultaprograma.php?op=listarestudiantes&periodo=' + periodo + '&valor=' + valor,
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			"order": [[1, "asc"]],
			'initComplete': function (settings, json) {
				$("#exampleModal").modal("show");
				$("#precarga").hide();
			},
		});
}
//Función ver estudiantes
function listarestudiantesnivel(periodo, nivel, valor) {
	$("#precarga").show();
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistado').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
				{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					titleAttr: 'Excel'
				},
				{
					extend: 'print',
					text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					titleAttr: 'Print'
				},
			],
			"ajax":
			{
				url: '../controlador/consultaprograma.php?op=listarestudiantesnivel&periodo=' + periodo + '&nivel=' + nivel + '&valor=' + valor,
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			"order": [[1, "asc"]],
			'initComplete': function (settings, json) {
				$("#exampleModal").modal("show");
				$("#precarga").hide();
			},
		});
}
//Función ver estudiantes
function verestudiantes(id_programa, jornada, semestre, periodo, valor) {
	$("#precarga").show();
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistado').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
				{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					titleAttr: 'Excel'
				},
				{
					extend: 'print',
					text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					titleAttr: 'Print'
				},
			],
			"ajax":
			{
				url: '../controlador/consultaprograma.php?op=verestudiantes&id_programa=' + id_programa + '&jornada=' + jornada + '&semestre=' + semestre + '&periodo=' + periodo + '&valor=' + valor,
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			"order": [[1, "asc"]],
			'initComplete': function (settings, json) {
				$("#exampleModal").modal("show");
				$("#precarga").hide();
			},
		});
}
//Función ver estudiantes inactivos
function verestudiantesinactivos(id_programa, jornada, semestre, temporadainactivos) {
	$("#precarga").show();
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistado').dataTable({
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					titleAttr: 'Excel'
				},
				{
					extend: 'print',
					text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					titleAttr: 'Print'
				}],
			"ajax":
			{
				url: '../controlador/consultaprograma.php?op=verestudiantesinactivos&id_programa=' + id_programa + '&jornada=' + jornada + '&semestre=' + semestre + '&temporadainactivos=' + temporadainactivos,
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			"order": [[1, "asc"]],
			'initComplete': function (settings, json) {
				$("#exampleModal").modal("show");
				$("#precarga").hide();
			},
		});
}
init();
