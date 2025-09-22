var tabla;
var estado = "Seleccionado";
//Función que se ejecuta al inicio
function init() {
	$("#listadoregistrostres").hide();
	listar();// incializar la funcion listar
	selectPrograma();
	selectJornada();
	selectTipoDocumento();
	selectNivelEscolaridad();
}
function iniciarTour() {
	introJs().setOptions({
		nextLabel: 'Siguiente',
		prevLabel: 'Anterior',
		doneLabel: 'Terminar',
		showBullets: false,
		showProgress: true,
		showStepNumbers: true,
		steps: [
			{
				title: 'Seleccionado',
				intro: "Bienvenido a nuestro módulo de seres creativos seleccionados"
			},
			{
				title: 'Estado admitido',
				element: document.querySelector('#t-ea'),
				intro: "Aquí podrás encontrar el estado de cada ser creativo en est caso matriculado "
			},
			{
				title: 'Campaña actual',
				element: document.querySelector('#t-Ca'),
				intro: "Aquí encontrarás a todos nuestros seres creativos que fueron selccionados en nuestra campaña actual "
			},
			{
				title: 'Campaña anteriores',
				element: document.querySelector('#t-Cn'),
				intro: "Aquí encontrarás a todos nuestros seres creativos que fueron selccionados en nuestras campañas anteriores "
			},
			{
				title: 'Sede principal',
				element: document.querySelector('#t-paso0'),
				intro: "Aquí podrás encontrar el programa que fue seleccionado en nuestra sede prncipal "
			},
			{
				title: 'Marketing-digital',
				element: document.querySelector('#t-paso1'),
				intro: "Aquí podrás encontrar el programa que fue seleccionado en marketin-digital"
			},
			{
				title: 'Web',
				element: document.querySelector('#t-paso2'),
				intro: " Aquí podrás encontrar el programa en el cual fue seleccionado por nuestra web"
			},
			{
				title: 'Súmate al parche',
				element: document.querySelector('#t-paso3'),
				intro: "Aquí podrás encontrar el programa en el cual fue seleccionado en súmate al parche"
			},
			{
				title: 'volante',
				element: document.querySelector('#t-paso4'),
				intro: "Aquí podrás encontrar el programa en el cua fue seleccionado por que nuestro ser creativo nos conoció por un volante "
			},
			{
				title: 'Feria',
				element: document.querySelector('#t-paso5'),
				intro: "Aquí podrás encontrar el programa en el cual fue seleccionado por que nuestro ser creativo nos conoció por medio de nuestra feria "
			},
			{
				title: 'Caso',
				element: document.querySelector('#t-cass'),
				intro: "Da un vistazo a el número de casos que se han llevado actualmente"
			},
			{
				title: 'Campaña',
				element: document.querySelector('#t-Cam'),
				intro: "Aqui encontrarás la campaña correspondiente"
			},
			{
				title: 'Estado',
				element: document.querySelector('#t-ms'),
				intro: "Da un vistazo a el estado de nuestros seres creativos en el caso de este módulo se refleja como matriculado"
			},
			{
				title: 'Estado matriculado',
				element: document.querySelector('#t-esm'),
				intro: "Encontrarás el panel donde tú como asesor podrás validar todos los documentos entregados por las personas interesadas en este proceso de sumarce a el parche más creativo del eje cafetero"
			},
		]
	},
		console.log()
	).start();
}
function iniciarSegundoTour() {
	introJs().setOptions({
		"nextLabel": 'Siguiente',
		"prevLabel": 'Anterior',
		"doneLabel": 'Terminar',
		"showBullets": false,
		"showProgress": true,
		"showStepNumbers": true,
		"steps": [{
			"title": 'Seleccionados',
			"intro": 'Bienvenido a nuestro módulo de seres creativos seleccionados'
		},
		{
			"title": 'Programa',
			"element": document.querySelector('#t2-paso0'),
			"intro": "Aquí encontrarás los diferentes programas a los que nuestros seres creativos han sido seleccionados "
		},
		{
			"title": 'Ninguno',
			"element": document.querySelector('#t2-paso1'),
			"intro": "Aquí encontrarás si la persona aún no ha definido en que horario resivirá sus experiencias creativas"
		},
		{
			"title": 'Diurna',
			"element": document.querySelector('#t2-paso2'),
			"intro": "Da un vistazo a los estudiantes que optaron por recibir sus experiencias creativas de día "
		},
		{
			"title": 'Nocturna',
			"element": document.querySelector('#t2-paso3'),
			"intro": "Da un vistazo a los estudiantes que optaron por recibir sus experiencias creativas de noche"
		},
		{
			"title": 'Fines de semana',
			"element": document.querySelector('#t2-paso4'),
			"intro": "Da un vistazo a los estudiantes que optaron por recibir sus experiencias creativas los fines de semana"
		},
		{
			"title": 'Sábados',
			"element": document.querySelector('#t2-paso5'),
			"intro": "Da un vistazo a los estudiantes que optaron por recibir sus experiencias creativas solo los sábados"
		},
		{
			"title": 'CAP',
			"element": document.querySelector('#t2-paso6'),
			"intro": "Da un vistazo a los estudiantes que optaron por recibir sus experiencias creativas a la nuestra jornada CAP"
		},
		{
			"title": 'Volver',
			"element": document.querySelector('#t2-vol'),
			"intro": "Regresa el tiempo en nuestro campus y encontrarás nuevamente nuestro panel de selccionados"
		},
		]
	}).start();
}
function cuenta() {// muestra el numero de caracteres limite en un textarea
	var max_chars = 150;
	$('#max').html(max_chars);
	$('#mensaje_seguimiento').keyup(function () {
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		$('#contador').html(diff);
	});
}
function cuentatarea() {// muestra el numero de caracteres limite en un textarea
	var max_chars = 150;
	$('#max').html(max_chars);
	$('#mensaje_tarea').keyup(function () {
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		$('#contadortarea').html(diff);
	});
}


function posicionPantalla() {// coloca la pantalla al inicio con el contenido
	$('html, body').animate({ scrollTop: 0 }, 'slow');
}
function listar() {
	$("#precarga").show();
	$.post("../controlador/oncenterseleccionado.php?op=listar", {}, function (data, status) {
		data = JSON.parse(data);// convertir el mensaje a json
		$("#resultado").show();
		$("#resultadoDos").hide();
		$("#resultado").html("");// limpiar el div resultado
		$("#resultado").append(data["0"]["0"]);// agregar el resultao al div resultado
		$("#precarga").hide();
		
		$.post("../controlador/oncenterseleccionado.php?op=selectPeriodo", {}, function (data, status) {
			data = JSON.parse(data);// convertir el mensaje a json
			$("#periodo_buscar").html("");// limpiar el div resultado
			$("#periodo_buscar").append(data["0"]["0"]);// agregar el resultao al div resultado
			
		});
	});
}
function listarDos(periodo) {
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	$("#precarga").show();
	$.post("../controlador/oncenterseleccionado.php?op=listarDos", { periodo: periodo, }, function (data, status) {
		data = JSON.parse(data);// convertir el mensaje a json
		$(document).ready(function () {
			$('#tbllistado').DataTable({
				"scrollX": true,
				"paging": false,
				dom: 'Bfrtip',
				buttons: [
					{
						extend: 'excelHtml5',
						text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
						titleAttr: 'Excel'
					},
					{
						extend: 'print',
						text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
						messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
						title: 'Ejes',
						titleAttr: 'Print'
					},
				],
				"language": {
					"url": "../public/datatables/idioma/Spanish.json"
				},
				"order": [[0, "asc"]]//Ordenar (columna,orden)
			});
		});
		$("#resultado").hide();
		$("#resultadoDos").show();
		$("#resultadoDos").html("");// limpiar el div resultado
		$("#resultadoDos").append(data["0"]["0"]);// agregar el resultao al div resultado
		$("#precarga").hide();
		posicionPantalla();
	});
}
function listarTres(medio, periodo) {
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	$("#precarga").show();
	$(".primer_tour").addClass("d-none");
	$(".segundo_tour").removeClass("d-none");
	$.post("../controlador/oncenterseleccionado.php?op=listarTres", { medio: medio, periodo: periodo }, function (data, status) {
		data = JSON.parse(data);// convertir el mensaje a json
		$(document).ready(function () {
			$('#tbllistado').DataTable({
				"paging": false,
				dom: 'Bfrtip',
				buttons: [
					{
						//extend: 'excelHtml5',
						//text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
						//titleAttr: 'Excel'
					},
					{
						//extend: 'print',
						//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
						//messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
						//title: 'Ejes',
						//titleAttr: 'Print'
					},
				],
				"language": {
					"url": "../public/datatables/idioma/Spanish.json"
				},
				"order": [[0, "asc"]]//Ordenar (columna,orden)
			});
		});
		$("#resultado").hide();
		$("#resultadoDos").show();
		$("#resultadoDos").html("");// limpiar el div resultado
		$("#resultadoDos").append(data["0"]["0"]);// agregar el resultao al div resultado
		$("#precarga").hide();
		posicionPantalla();
	});
}
function volver() {
	$("#resultado").show();
	$("#resultadoDos").hide();
	$(".primer_tour").removeClass("d-none");
	$(".segundo_tour").addClass("d-none");
}
function volverDos() {
	$("#listadoregistrostres").hide();
	$("#resultadoDos").show();
}
// funcion para listar los estudaintes por programa y jornada
function verEstudiantes(nombre_programa, jornada, periodo) {
	var estado = "Selecionado";
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	$("#titulo").html("Programa: <b>" + nombre_programa + "</b><br> Jornada:<b> " + jornada + "</b><br>Estado: <b>" + estado + "</b>");// limpiar el div resultado
	tabla = $('#tbllistadoestudiantes').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
				{
					//extend: 'excelHtml5',
					//text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					//titleAttr: 'Excel'
				},
				{
					//extend: 'print',
					//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					//messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>' + estado + ' </b><br>Fecha Reporte: <b> ' + fecha_hoy + '</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					//title: 'Ejes',
					//titleAttr: 'Print'
				},
			],
			"ajax":
			{
				url: '../controlador/oncenterseleccionado.php?op=verEstudiantes&nombre_programa=' + nombre_programa + '&jornada=' + jornada + '&estado=' + estado + '&periodo=' + periodo,
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			"order": [[0, "desc"]]//Ordenar (columna,orden)
		}).DataTable();
	$("#resultadoDos").hide();
	$("#listadoregistrostres").show();// mostrar la tabla con programa y fecha
	$("#tbllistadoestudiantessuma").hide();
	$("#tbllistadoestudiantessuma_wrapper").hide();
	$("#tbllistadoestudiantes").show();
	$("#tbllistadoestudiantestotal").hide();
	$("#tbllistadoestudiantestotal_wrapper").hide();
	$("#tbllistadoestudiantesmedio").hide();
	$("#tbllistadoestudiantesmedio_wrapper").hide();
	$("#precarga").hide();
	posicionPantalla();
}
// funcion para listar los estudaintes por programa y jornada
function verEstudiantesmedio(nombre_programa, jornada, medio, periodo) {
	var estado = "Selecionado";
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	$("#titulo").html("Programa: <b>" + nombre_programa + "</b><br> Jornada:<b> " + jornada + "</b><br>Estado: <b>" + estado + "</b>");// limpiar el div resultado
	tabla = $('#tbllistadoestudiantes').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
				{
					//extend: 'excelHtml5',
					//text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					//titleAttr: 'Excel'
				},
				{
					//extend: 'print',
					//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					//messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>' + estado + ' </b><br>Fecha Reporte: <b> ' + fecha_hoy + '</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					//title: 'Ejes',
					//titleAttr: 'Print'
				},
			],
			"ajax":
			{
				url: '../controlador/oncenterseleccionado.php?op=verEstudiantesMedio&nombre_programa=' + nombre_programa + '&jornada=' + jornada + '&medio=' + medio + '&estado=' + estado + '&periodo=' + periodo,
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			"order": [[0, "desc"]]//Ordenar (columna,orden)
		}).DataTable();
	$("#resultadoDos").hide();
	$("#listadoregistrostres").show();// mostrar la tabla con programa y fecha
	$("#tbllistadoestudiantes").show();
	$("#tbllistadoestudiantes_wrapper").show();
	$("#tbllistadoestudiantessuma").hide();
	$("#tbllistadoestudiantessuma_wrapper").hide();
	$("#tbllistadoestudiantestotal").hide();
	$("#tbllistadoestudiantestotal_wrapper").hide();
	$("#tbllistadoestudiantesmedio").hide();
	$("#tbllistadoestudiantesmedio_wrapper").hide();
	$("#precarga").hide();
	posicionPantalla();
}
// funcion para listar los estudaintes por suma de programa y jornada
function verEstudiantesSuma(jornada, periodo) {
	var estado = "Selecionado";
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	$("#titulo").html("<br>Estado: <b>" + estado + "</b>");// limpiar el div resultado
	tabla = $('#tbllistadoestudiantessuma').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
				{
					//extend: 'excelHtml5',
					//text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					//titleAttr: 'Excel'
				},
				{
					//extend: 'print',
					//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					//messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>' + estado + ' </b><br>Fecha Reporte: <b> ' + fecha_hoy + '</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					//title: 'Ejes',
					//titleAttr: 'Print'
				},
			],
			"ajax":
			{
				url: '../controlador/oncenterseleccionado.php?op=verEstudiantesSuma&jornada=' + jornada + '&estado=' + estado + '&periodo=' + periodo,
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			"order": [[0, "desc"]]//Ordenar (columna,orden)
		}).DataTable();
	$("#resultadoDos").hide();
	$("#listadoregistrostres").show();// mostrar la tabla con programa y fecha
	$("#tbllistadoestudiantes").hide();
	$("#tbllistadoestudiantes_wrapper").hide();
	$("#tbllistadoestudiantessuma").show();
	$("#tbllistadoestudiantestotal").hide();
	$("#tbllistadoestudiantestotal_wrapper").hide();
	$("#tbllistadoestudiantesmedio").hide();
	$("#tbllistadoestudiantesmedio_wrapper").hide();
	$("#precarga").hide();
	posicionPantalla();
}
// funcion para listar los estudaintes por suma de programa y jornada
function verEstudiantesSumaMedio(nombre_programa, jornada, medio, periodo) {
	var estado = "Selecionado";
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	$("#titulo").html("Estado: <b>" + estado + "</b>");// limpiar el div resultado
	tabla = $('#tbllistadoestudiantessuma').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
				{
					//extend: 'excelHtml5',
					//text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					//titleAttr: 'Excel'
				},
				{
					//extend: 'print',
					//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					//messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>' + estado + ' </b><br>Fecha Reporte: <b> ' + fecha_hoy + '</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					//title: 'Ejes',
					//titleAttr: 'Print'
				},
			],
			"ajax":
			{
				url: '../controlador/oncenterseleccionado.php?op=verEstudiantesSumaMedio&jornada=' + jornada + '&medio=' + medio + '&periodo=' + periodo,
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			"order": [[0, "desc"]]//Ordenar (columna,orden)
		}).DataTable();
	$("#resultadoDos").hide();
	$("#listadoregistrostres").show();// mostrar la tabla con programa y fecha
	$("#tbllistadoestudiantessuma").show();
	$("#tbllistadoestudiantessuma_wrapper").show();
	$("#tbllistadoestudiantes").hide();
	$("#tbllistadoestudiantestotal").hide();
	$("#tbllistadoestudiantestotal_wrapper").hide();
	$("#tbllistadoestudiantesmedio").hide();
	$("#tbllistadoestudiantesmedio_wrapper").hide();
	$("#precarga").hide();
	posicionPantalla();
}
// funcion para listar los estudaintes por suma de programa y jornada
function verEstudiantesTotal(periodo) {
	var estado = "Selecionado";
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	$("#titulo").html("Estado: <b>" + estado + "</b>");// limpiar el div resultado
	tabla = $('#tbllistadoestudiantestotal').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
				{
					//extend: 'excelHtml5',
					//text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					//titleAttr: 'Excel'
				},
				{
					//extend: 'print',
					//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					//messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>' + estado + ' </b><br>Fecha Reporte: <b> ' + fecha_hoy + '</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					//title: 'Ejes',
					//titleAttr: 'Print'
				},
			],
			"ajax":
			{
				url: '../controlador/oncenterseleccionado.php?op=verEstudiantesTotal&periodo=' + periodo,
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			"order": [[0, "desc"]]//Ordenar (columna,orden)
		}).DataTable();
	$("#resultadoDos").hide();
	$("#listadoregistrostres").show();// mostrar la tabla con programa y fecha
	$("#tbllistadoestudiantes").hide();
	$("#tbllistadoestudiantes_wrapper").hide();
	$("#tbllistadoestudiantessuma").hide();
	$("#tbllistadoestudiantessuma_wrapper").hide();
	$("#tbllistadoestudiantestotal").show();
	$("#tbllistadoestudiantestotal_wrapper").show();
	$("#tbllistadoestudiantesmedio").hide();
	$("#tbllistadoestudiantesmedio_wrapper").hide();
	$("#precarga").hide();
	posicionPantalla();
}
// funcion para listar los estudaintes por suma de programa y jornada
function verEstudiantesTotalMedio(medio, periodo) {
	var estado = "Selecionado";
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	$("#titulo").html("Estado: <b>" + estado + "</b>");// limpiar el div resultado
	tabla = $('#tbllistadoestudiantesmedio').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
				{
					//extend: 'excelHtml5',
					//text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					//titleAttr: 'Excel'
				},
				{
					//extend: 'print',
					//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					//messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>' + estado + ' </b><br>Fecha Reporte: <b> ' + fecha_hoy + '</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					//title: 'Ejes',
					//titleAttr: 'Print'
				},
			],
			"ajax":
			{
				url: '../controlador/oncenterseleccionado.php?op=verEstudiantesTotalMedio&medio=' + medio + '&periodo=' + periodo,
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			"order": [[0, "desc"]]//Ordenar (columna,orden)
		}).DataTable();
	$("#resultadoDos").hide();
	$("#listadoregistrostres").show();// mostrar la tabla con programa y fecha
	$("#tbllistadoestudiantesmedio").show();
	$("#tbllistadoestudiantesmedio_wrapper").show();
	$("#tbllistadoestudiantes").hide();
	$("#tbllistadoestudiantes_wrapper").hide();
	$("#tbllistadoestudiantessuma").hide();
	$("#tbllistadoestudiantessuma_wrapper").hide();
	$("#tbllistadoestudiantestotal").hide();
	$("#tbllistadoestudiantestotal_wrapper").hide();
	$("#precarga").hide();
	posicionPantalla();
}
function verHistorial(id_estudiante) {
	$("#precarga").show();
	$.post("../controlador/oncenterseleccionado.php?op=verHistorial", { id_estudiante: id_estudiante }, function (data, status) {
		data = JSON.parse(data);// convertir el mensaje a json
		$("#myModalHistorial").modal("show");
		$("#historial").html("");// limpiar el div resultado
		$("#historial").append(data["0"]["0"]);// agregar el resultao al div resultado
		$("#precarga").hide();
		verHistorialTabla(id_estudiante);
		verHistorialTablaTareas(id_estudiante);
	});
}
function agregar(id_estudiante) {
	$("#btnGuardarSeguimiento").prop("disabled", false);
	$("#precarga").show();
	$("#id_estudiante_agregar").val(id_estudiante);
	$("#id_estudiante_tarea").val(id_estudiante);
	$.post("../controlador/oncenterseleccionado.php?op=agregar", { id_estudiante: id_estudiante }, function (data, status) {
		data = JSON.parse(data);// convertir el mensaje a json
		$("#myModalAgregar").modal("show");
		$("#agregarContenido").html("");// limpiar el div resultado
		$("#agregarContenido").append(data["0"]["0"]);// agregar el resultao al div resultado
		$("#precarga").hide();
	});
}
// funcion para listar los estudaintes por suma de programa y jornada
function verHistorialTabla(id_estudiante) {
	var estado = "Selecionado";
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	$("#titulo").html("Estado: <b>" + estado + "</b>");// limpiar el div resultado
	tabla = $('#tbllistadohistorial').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
				{
					//extend: 'excelHtml5',
					//text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					//titleAttr: 'Excel'
				},
				{
					//extend: 'print',
					//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					//messageTop: '<div style="width:50%;float:left">Reporte: <b>' + estado + ' </b><br>Fecha Reporte: <b> ' + fecha_hoy + '</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					//title: 'Ejes',
					//titleAttr: 'Seguimiento'
				},
			],
			"ajax":
			{
				url: '../controlador/oncenterseleccionado.php?op=verHistorialTabla&id_estudiante=' + id_estudiante,
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			"order": [[0, "desc"]]//Ordenar (columna,orden)
		}).DataTable();
}
// funcion para listar los estudaintes por suma de programa y jornada
function verHistorialTablaTareas(id_estudiante) {
	var estado = "Selecionado";
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	$("#titulo").html("Estado: <b>" + estado + "</b>");// limpiar el div resultado
	tabla = $('#tbllistadoHistorialTareas').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
				{
					//extend: 'excelHtml5',
					//text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					//titleAttr: 'Excel'
				},
				{
					//extend: 'print',
					//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					//messageTop: '<div style="width:50%;float:left">Reporte: <b>' + estado + ' </b><br>Fecha Reporte: <b> ' + fecha_hoy + '</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					//title: 'Ejes',
					//titleAttr: 'Tareas Programadas'
				},
			],
			"ajax":
			{
				url: '../controlador/oncenterseleccionado.php?op=verHistorialTablaTareas&id_estudiante=' + id_estudiante,
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			"order": [[0, "desc"]]//Ordenar (columna,orden)
		}).DataTable();
}
function selectModalidadCampana() {
	//Cargamos los items de los selects
	$.post("../controlador/oncenterseleccionado.php?op=selectModalidadCampana", function (r) {
		$("#modalidad_campana").html(r);
		$('#modalidad_campana').selectpicker('refresh');
	});
}
function selectEstado() {
	//Cargamos los items de los selects
	$.post("../controlador/oncenterseleccionado.php?op=selectEstado", function (r) {
		$("#estado").html(r);
		$('#estado').selectpicker('refresh');
	});
}
function mover(id_estudiante, fila) {
	selectEstado();
	$("#btnMover").prop("disabled", false);
	$("#myModalMover").modal("show");
	$("#id_estudiante_mover").val(id_estudiante);
	$("#fila_mover").val(fila);
}
function guardarMoverUsuario(e4) {
	e4.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnMover").prop("disabled", true);
	var formData = new FormData($("#moverUsuario")[0]);
	$.ajax({
		url: "../controlador/oncenterseleccionado.php?op=moverUsuario",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			alertify.set('notifier', 'position', 'top-center');
			alertify.success(datos);
			$("#myModalMover").modal("hide");
			var fila = $("#fila_mover").val();
			$(".fila" + fila).hide();
		}
	});
}
//Función para activar registros
/*function eliminar(id_estudiante, fila) {
	alertify.confirm('Eliminar Caso', '¿Está Seguro de eliminar el Caso?', function () {
		$.post("../controlador/oncenterseleccionado.php?op=eliminar", { id_estudiante: id_estudiante }, function (e) {
			if (e == 1) {
				alertify.success("Caso Eliminado");
				$(".fila" + fila).hide();
			}
			else {
				alertify.error("Caso no se puede eliminar");
			}
		});
	}
		, function () { alertify.error('Cancelado') });
}
*/

function selectPrograma() {
	//Cargamos los items de los selects
	$.post("../controlador/oncenterseleccionado.php?op=selectPrograma", function (r) {
		$("#fo_programa").html(r);
		$('#fo_programa').selectpicker('refresh');
	});
}
function selectJornada() {
	//Cargamos los items de los selects
	$.post("../controlador/oncenterseleccionado.php?op=selectJornada", function (r) {
		$("#jornada_e").html(r);
		$('#jornada_e').selectpicker('refresh');
	});
}
function selectTipoDocumento() {
	//Cargamos los items de los selects
	$.post("../controlador/oncenterseleccionado.php?op=selectTipoDocumento", function (r) {
		$("#tipo_documento").html(r);
		$('#tipo_documento').selectpicker('refresh');
	});
}
function selectNivelEscolaridad() {
	//Cargamos los items de los selects
	$.post("../controlador/oncenterseleccionado.php?op=selectNivelEscolaridad", function (r) {
		$("#nivel_escolaridad").html(r);
		$('#nivel_escolaridad').selectpicker('refresh');
	});
}
// funcion pra mostrar los datos en el formulario del perfil del estudiante
function perfilEstudiante(id_estudiante, identificacion, fila) {
	//$("#precarga").show();
	$("#btnCambiar").prop("disabled", false);
	$("#myModalPerfilEstudiante").modal("show");
	$("#id_estudiante").val(id_estudiante);
	$("#fila").val(fila);
	$.post("../controlador/oncenterseleccionado.php?op=perfilEstudiante", { id_estudiante: id_estudiante }, function (data, status) {
		data = JSON.parse(data);
		$("#fo_programa").val(data.fo_programa);
		$("#fo_programa").selectpicker('refresh');
		$("#jornada_e").val(data.jornada_e);
		$("#jornada_e").selectpicker('refresh');
		$("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#nombre").val(data.nombre);
		$("#nombre_2").val(data.nombre_2);
		$("#apellidos").val(data.apellidos);
		$("#apellidos_2").val(data.apellidos_2);
		$("#celular").val(data.celular);
		$("#email").val(data.email);
		$("#nivel_escolaridad").val(data.nivel_escolaridad);
		$("#nivel_escolaridad").selectpicker('refresh');
		$("#fecha_graduacion").val(data.fecha_graduacion);
		$("#nombre_colegio").val(data.nombre_colegio);
	});
}
function verDocumentos(id_estudiante) {
	$.post("../controlador/oncenterseleccionado.php?op=verDocumentos", { id_estudiante: id_estudiante }, function (data) {
		data = JSON.parse(data);
		$("#resultadodocumento").html("");// limpiar el div resultado
		$("#resultadodocumento").append(data["0"]["0"]);// agregar el resultao al div resultado		
		$("#myModalDocumentos").modal("show");
	});
}
init();// inicializa la funcion init