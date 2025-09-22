var tabla;

//Función que se ejecuta al inicio
function init(){
	//imprimimos la tabla principal 
	consultaegresados();
	//formulario para guardar seguimiento
	$("#formularioAgregarSeguimiento").on("submit",function(e1)
	{
		guardarSeguimiento(e1);	
	});
//formulario para guardar tareas
	$("#formularioTarea").on("submit",function(e2)
	{
		guardarTarea(e2);	
	});
	
	$("#precarga").hide();
	
}

//funcion para mostrar la consulta de los egresados y graduados 
function consultaegresados(estado){
	$("#precarga").show();
	$("#listadoregistros").show();

	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tblconsultaegresado').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		buttons: [
			
			{
				extend:    'excelHtml5',
				text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Consulta Egresados',
				titleAttr: 'Print'

			},
		],
		
		"ajax":{ url: '../controlador/consultaegresado.php?op=consultaegresados&estado='+estado, type : "get", dataType : "json",						
		error: function(e){
			
		}
	},
	"bDestroy": true,
	"iDisplayLength": 20,//Paginación
	"order": [[ 0, "asc" ]],//Ordenar (columna,orden)
	'initComplete': function (settings, json) {
			
			$("#precarga").hide();
			
		},
		
	});
	
}

//funcion para guardar el seguimiento de los estudiantes
function guardarSeguimiento(e)
{
	// e.preventDefault(); //No se activará la acción predeterminada del evento
	// $("#btnGuardarSeguimiento").prop("disabled",true);
	var formData = new FormData($("#formularioAgregarSeguimiento")[0]);

	$.ajax({
		url: "../controlador/consultaegresado.php?op=agregarSeguimiento",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    { 
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);
			$("#myModalAgregar").modal("hide");
	          
	    }

	});
	
}

//funcion para guardar las tareas 
function guardarTarea(e2)
{
	var formData = new FormData($("#formularioTarea")[0]);

	$.ajax({
		url: "../controlador/consultaegresado.php?op=agregarTarea",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function(datos)
		{ 
			
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);
			$("#myModalAgregar").modal("hide");
			
		}

	});
	
}

//funcion para traer el id credencial del estudiante 
function agregar_seguimiento_egresado(id_credencial){
	$("#myModalAgregar").modal("show");
	$("#id_credencial").val(id_credencial);
	$("#id_credencial_tarea").val(id_credencial);
	$("#id_credencial_tabla").val(id_credencial);
	
}

//funcion para abrir el modal que permite ver los seguimientos y tareas del estudiante
function verHistorial(id_credencial){
	$("#precarga").show();
	$("#myModalHistorial").modal("show");
	$("#precarga").hide();
	verHistorialTabla(id_credencial);
	verHistorialTablaTareas(id_credencial);
	
}

// funcion para listar el seguimiento de los estudiantes 
function verHistorialTabla(id_credencial_tabla)
{
var estado="Selecionado";	
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	$("#titulo").html("Estado: <b>"+estado+"</b>");// limpiar el div resultado
	
	tabla=$('#tbllistadohistorialegresado').dataTable(
	{
		
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
			{
				extend:    'excelHtml5',
				text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left">Reporte: <b>'+estado+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Seguimiento'
            },

        ],
		"ajax":
				{
					url: '../controlador/consultaegresado.php?op=verHistorialTabla&id_credencial_tabla='+id_credencial_tabla,
					type : "get",
					dataType : "json",						
					error: function(e){
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
		
}

// funcion para listar el seguimiento de los estudiantes 
function verHistorialTablaTareas(id_credencial_tarea)
{
var estado="Selecionado";	
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	$("#titulo").html("Estado: <b>"+estado+"</b>");// limpiar el div resultado
	
	tabla=$('#tblseguimientohistorialegresado').dataTable(
	{
		
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
			{
				extend:    'excelHtml5',
				text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left">Reporte: <b>'+estado+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Seguimiento'
            },

        ],
		"ajax":
				{
					url: '../controlador/consultaegresado.php?op=verTareasHistorialTabla&id_credencial_tarea='+id_credencial_tarea,
					type : "get",
					dataType : "json",						
					error: function(e){
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
		
}

function cuentatarea(){// muestra el numero de caracteres limite en un textarea
	var max_chars = 150;
	
	$('#max').html(max_chars);

	$('#mensaje_tarea').keyup(function() {
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		$('#contadortarea').html(diff);   
	});
}

function cuenta(){// muestra el numero de caracteres limite en un textarea
	var max_chars = 150;
	
	$('#max').html(max_chars);

	$('#mensaje_seguimiento').keyup(function() {
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		$('#contador').html(diff);   
	});
}


init();