function init() {
	// oculta la precarga al inicializar
	$("#precarga").hide();
	// configura el submit para el formulario
	$("#formulario").on("submit", function (e) {
		// muestra la precarga cuando se envia el formulario
		$("#precarga").show();
		// funcion para realizar los datos del usuario por el rango de fechas
		buscarfiltrar(e);
	});
	// peticion para cargar los usuarios en el select
	$.post("../controlador/whatsapp_seguimiento.php?op=selectUsuario", function (r) {
		// Inserta la lista de usuarios en el select usuario
		$("#usuario").html(r);
		// refresca el selectpicker para que se actualice con los nuevos datos
		$("#usuario").selectpicker('refresh');
	});
	// carga la informacion inicial respecto a los tipos de seguimientos que hay
	datos();
	// carga la informacion inicial respecto a los tipos de etiquetas que hay
	datosEtiquetas();
}
function iniciarTour() {
	introJs().setOptions({
		"nextLabel": 'Siguiente',  
		"prevLabel": 'Anterior',  
		"doneLabel": 'Terminar',  
		"showBullets": false,     
		"showProgress": true,     
		"showStepNumbers": true,
		"steps": [
			{
				"title": 'Consultas',
				"intro": "Bienvenido a nuestro modulo de consultas donde podrás visualizar todos los resultados de las diferentes campañas que se han llevado a cabo"
			},
			{
				"title": 'Total clientes',
				"element": document.querySelector('#t-tog'),
				"intro": "Da un vistazo a la totalidad de nuestros clientes con cifras comparadas de campañas anteriores "
			},
		]
	}).start();
}
// funcion para realizar los datos del usuario por el rango de fechas
function buscarfiltrar(e) {
	// evita la accion predeterminada de recargar página
	e.preventDefault();
	// obtiene el valor del campo usuario
	var usuario = $("#usuario").val();
	// obtiene el valor del campo fecha_desde
	var fecha_desde = $("#fecha_desde").val();
	// obtiene el valor del campo fecha_hasta
	var fecha_hasta = $("#fecha_hasta").val();
	// muestra wl listado con los registros
	$("#listadoregistros").show();
	// muestra la tabla
	$("#tbllistado").show();
	// arrays para los nombres de los meses
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	// arrays para los nombres de los dias de la semana
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	// objeto para obtener la fecha actual
	var f = new Date();
	// formatea la fecha actual en fecha_esp
	var fecha = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	// dataTables con configuraciones
	tabla = $('#tbllistado').dataTable({
		"aProcessing": true,       
		"aServerSide": true,
		"dom": 'Bfrtip',
		"buttons": [{
				"extend": 'excelHtml5',
				"text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				"titleAttr": 'Excel'
			},
			{
				"extend": 'print',
				"text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				"messageTop": '<div style="width:50%;float:left"> Usuario ' + usuario + '<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
				"title": 'Reporte usuarioes',
				"titleAttr": 'Print'
			},
		],
		"ajax": {
			"url": '../controlador/whatsapp_seguimiento.php?op=listar&usuario=' + usuario + '&fecha_desde=' + fecha_desde + '&fecha_hasta=' + fecha_hasta,
			"type": "get",
			"dataType": "json",
			error: function (e) {
				$("#precarga").hide();
			}
		},
		"bDestroy": true,           
		"iDisplayLength": 10,      
		"order": [[2, "asc"]],
		'initComplete': function (settings, json) {
			// oculta la precarga cuando el DataTable esta listo
			$("#precarga").hide();
		},
	});
}
function datos() {
	// post para obtener datos de los tipos seguimiento
	$.post('../controlador/whatsapp_seguimiento.php?op=datos', function (datos) {
		var r = JSON.parse(datos);
		// Actualiza los html con los datos
		$("#citas").html(r.citas);
		$("#llamada").html(r.llamada);
		$("#segui").html(r.segui);
		$("#whatsapp").html(r.whatsapp);
	});
}
function datosEtiquetas() {
	// post para obtener datos de etiquetas
	$.post('../controlador/whatsapp_seguimiento.php?op=datosEtiquetas', function (datos) {
		var r = JSON.parse(datos);
		// datos de las etiqwuetas recibidos en el datosetiquetas
		$("#datosetiquetas").html(r.datos)
	});
}
// inicializar las configuraciones al cargar el script
init();
