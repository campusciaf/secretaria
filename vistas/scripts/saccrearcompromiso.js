var tabla;
var tabla2;
//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	mostrarformmeta(false);
	listar();
	listar2();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	
	$("#formulario_meta").on("submit",function(e2)
	{
		guardaryeditarmeta(e2);	
	});
	
	$.post("../controlador/saccrearcompromiso.php?op=selectPeriodo", function(r){
		
				$("#compromiso_anio").html(r);
				$('#compromiso_anio').selectpicker('refresh');
	
	});
	
	$.post("../controlador/saccrearcompromiso.php?op=selectListaSiNo", function(r){
				$("#compromiso_val_admin").html(r);
				$('#compromiso_val_admin').selectpicker('refresh');
	});
	
	$.post("../controlador/saccrearcompromiso.php?op=selectListaSiNo", function(r){
				$("#compromiso_val_usuario").html(r);
				$('#compromiso_val_usuario').selectpicker('refresh');
	});
	
	$.post("../controlador/saccrearcompromiso.php?op=selectListarCargo", function(r){
				$("#resposable_compromiso").html(r);
				$('#resposable_compromiso').selectpicker('refresh');
	});
	
	$.post("../controlador/compromiso.php?op=selectListarCorresponsable", function(r){
				$("#corresponsabilidad").html(r);
				$('#corresponsabilidad').selectpicker('refresh');
	});
	
	
	
//	**********************
	
	$.post("../controlador/saccrearcompromiso.php?op=selectEjes", function(r){
				$("#meta_ejes").html(r);
				$('#meta_ejes').selectpicker('refresh');
	
	});
	$.post("../controlador/saccrearcompromiso.php?op=selectListaSiNo", function(r){
				$("#meta_val_admin").html(r);
				$('#meta_val_admin').selectpicker('refresh');
	});
	
	$.post("../controlador/saccrearcompromiso.php?op=selectListaSiNo", function(r){
				$("#meta_val_usuario").html(r);
				$('#meta_val_usuario').selectpicker('refresh');
	});
	
	$.post("../controlador/crearcompromiso.php?op=selectPeriodo", function(r){
	            $("#meta_periodo").html(r);
	           	$('#meta_periodo').selectpicker('refresh');
	
	});
	
	$.post("../controlador/saccrearcompromiso.php?op=selectListarCargo", function(r){
				$("#meta_valida").html(r);
				$('#meta_valida').selectpicker('refresh');
	});
	
	$.post("../controlador/saccrearcompromiso.php?op=condiciones_institucionales&id=",function(r){
			$("#condiciones_institucionales").html(r);
		
	});
	
	$.post("../controlador/saccrearcompromiso.php?op=condiciones_programa&id=",function(r){
			$("#condiciones_programa").html(r);
		
	});

	
}

//Función limpiar
function limpiar()
{
	$("#id_compromiso").val("");
	$("#compromiso_nombre").val("");
	$("#compromiso_val_admin").val("0");
	$("#compromiso_val_admin").change();
	$("#compromiso_val_usuario").val("0");
	$("#compromiso_val_usuario").change();
	$("#compromiso_fecha").val("");
	$("#compromiso_anio").val("");
	$("#compromiso_anio").change();
	$('#compromiso_anio').selectpicker('refresh');
	$("#resposable_compromiso").val("");
	$("#resposable_compromiso").change();


}

//Función limpiar
function limpiarMeta()
{
	$("#id_meta").val("");
	$("#meta_nombre").val("");
	$("#meta_val_admin").val("0");
	$("#meta_val_admin").change();
	$("#meta_val_usuario").val("0");
	$("#meta_val_usuario").change();
	$("#fecha_compromiso").val("");
//	$("#meta_periodo").val("");
//	$("#meta_periodo").change();
//	$('#meta_periodo').selectpicker('refresh');
	$("#meta_valida").val("");
	$("#meta_valida").change();
	

	


}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función mostrar formulario
function mostrarformmeta(flag)
{
	limpiarMeta();
	if (flag)
	{
		$("#resultadometas").hide();
		$("#formularioregistrometa").show();
		$("#btnGuardarMeta").prop("disabled",false);
		$("#btnAgregarMeta").hide();
	}
	else
	{
		$("#resultadometas").show();
		$("#formularioregistrometa").hide();
		$("#btnAgregarMeta").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función cancelarform
function cancelarformmeta()
{
	limpiarMeta();
	mostrarformmeta(false);
}
//Función mostrar formulario

function numerocampo(numero)
{
	$("#id_usuario").val(numero);
}
function numerocompromiso(numero)
{

	$("#id_compromiso_meta").val(numero);
}


function listar3(){

	$.post("../controlador/saccrearcompromiso.php?op=listar",{},function(data, status){
	
	data = JSON.parse(data);
	$("#tllistado").html("");
	$("#tllistado").append(data["0"]["0"]);

	});
}

//Función Listar
function listar()
{
	
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
			{
				extend:    '',
				text:      '<i class="fa fa-calendar fa-2x"> Periodo actual</i>',
				titleAttr: 'Periodo'
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Print'
			},

		],
		"ajax":
				{
					url: '../controlador/saccrearcompromiso.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},
		// funcion para cambiar el responsive del data table	
		'select': 'single',

		'drawCallback': function (settings) {
			api = this.api();
			var $table = $(api.table().node());
			
			if ($table.hasClass('cards')) {

			// Create an array of labels containing all table headers
			var labels = [];
			$('thead th', $table).each(function () {
				labels.push($(this).text());
			});

			// Add data-label attribute to each cell
			$('tbody tr', $table).each(function () {
				$(this).find('td').each(function (column) {
					$(this).attr('data-label', labels[column]);
				});
			});

			var max = 0;
			$('tbody tr', $table).each(function () {
				max = Math.max($(this).height(), max);
			}).height(max);

			} else {
			// Remove data-label attribute from each cell
			$('tbody td', $table).each(function () {
				$(this).removeAttr('data-label');
			});

			$('tbody tr', $table).each(function () {
				$(this).height('auto');
			});
			}
		}
		
		
		
	});
	
	
		var width = $(window).width();
		if(width <= 750){
			$(api.table().node()).toggleClass('cards');
			api.draw('page');
		}
		window.onresize = function(){

			anchoVentana = window.innerWidth;
				if(anchoVentana > 1000){
					$(api.table().node()).removeClass('cards');
					api.draw('page');
				}else if(anchoVentana > 750 && anchoVentana < 1000){
					$(api.table().node()).removeClass('cards');
					api.draw('page');
				}else{
				$(api.table().node()).toggleClass('cards');
					api.draw('page');
				}
		}
		// ****************************** //
	
	
		
}
//Función para guardar o editar


//Función Listar
function listar2()
{
	
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

	
	
	tabla2=$('#tbllistado2').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
			{
				extend:    '',
				text:      '<i class="fa fa-calendar fa-2x"> Propuesta</i>',
				titleAttr: 'Periodo'
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Print'
			},

		],
		"ajax":
				{
					url: '../controlador/saccrearcompromiso.php?op=listar2',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}


function listarMeta(){

	$.post("../controlador/saccrearcompromiso.php?op=mostrarmeta",{},function(data, status){

	data = JSON.parse(data);
//		console.log(data);
	$("#resultadometas").html("");
	$("#resultadometas").append(data["0"]["0"]);

	});
}

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controlador/saccrearcompromiso.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function(datos)
		{ 
			console.log(datos);	
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
			mostrarform(false);
			listar();
			listar2();
		}

	});
	limpiar();
}

function guardaryeditarmeta(e2)
{
	var id_meta=$("#id_meta").val();
	var id_compromiso=$("#id_compromiso_meta").val();
	var fecha_compromiso=$("#compromiso_fecha").val();
	

	e2.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarMeta").prop("disabled",true);
	var formData = new FormData($("#formulario_meta")[0]);

	$.ajax({
		url: "../controlador/saccrearcompromiso.php?op=guardaryeditarmeta",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function(datos)
		{ 
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
			mostrarformmeta(false);
			
			if(id_meta == ""){
				$.post("../controlador/saccrearcompromiso.php?op=fechaLimite",{id_compromiso:id_compromiso}, function(r){
					
				var fechaLimite=r;
				mostrarMeta(id_compromiso,fechaLimite);	
				});
			}else{

					
			}
			
		}

	});
	limpiarMeta();
}

function mostrar(id_compromiso)
{
	$.post("../controlador/saccrearcompromiso.php?op=mostrar",{id_compromiso : id_compromiso}, function(data, status)
	{
		
		data = JSON.parse(data);		
		mostrarform(true);
		
		$("#id_compromiso").val(data.id_compromiso);
		$("#id_usuario").val(data.id_usuario);
		$("#compromiso_nombre").val(data.compromiso_nombre);
		$("#compromiso_fecha").val(data.compromiso_fecha);
		
		
		$("#compromiso_val_admin").val(data.compromiso_val_admin);
		$("#compromiso_val_admin").selectpicker('refresh');
		
		$("#compromiso_val_usuario").val(data.compromiso_val_usuario);
		$("#compromiso_val_usuario").selectpicker('refresh');
		
		$("#resposable_compromiso").val(data.resposable_compromiso);
		$("#resposable_compromiso").selectpicker('refresh');
		
		$("#compromiso_anio").val(data.compromiso_anio);
		$("#compromiso_anio").selectpicker('refresh');


	});
}

function mostrarMeta(id_compromiso,fecha,periodo){

	$("#meta_periodo").val(periodo);
	$("#myModalMeta").modal("show");
	$("#id_compromiso_meta").val(id_compromiso);
	$("#fecha_compromiso").attr("max",fecha);

	$.post("../controlador/saccrearcompromiso.php?op=mostrarmeta",{id_compromiso : id_compromiso}, function(data, status)
	{
			//console.log(data);
			data = JSON.parse(data);
				
			$("#resultadometas").html("");
			$("#resultadometas").append(data["0"]["0"]);


			});
}

function mostrarMeta2(id_compromiso,fecha,periodo)
{

	$("#meta_periodo").val(periodo);
	$("#myModalMeta").modal("show");
	$("#id_compromiso_meta").val(id_compromiso);
	$("#fecha_compromiso").attr("max",fecha);

	$.post("../controlador/saccrearcompromiso.php?op=mostrarmeta2",{id_compromiso : id_compromiso}, function(data, status)
	{
			//console.log(data);
			data = JSON.parse(data);
				
			$("#resultadometas").html("");
			$("#resultadometas").append(data["0"]["0"]);


			});
}

function mostrarMetaEditar(id_meta)
{

	$.post("../controlador/saccrearcompromiso.php?op=mostrarmetaeditar",{id_meta : id_meta}, function(data, status)
	{

		data = JSON.parse(data);		
		mostrarformmeta(true);
		$("#id_meta").val(data.id_meta);

		$("#meta_nombre").val(data.meta_nombre);
		$("#fecha_compromiso").val(data.fecha_compromiso);
		
		$("#meta_ejes").val(data.id_eje);
		$("#meta_ejes").selectpicker('refresh');
		
		$("#meta_val_admin").val(data.meta_val_admin);
		$("#meta_val_admin").selectpicker('refresh');
		
		$("#meta_val_usuario").val(data.meta_val_usuario);
		$("#meta_val_usuario").selectpicker('refresh');
		
		$("#meta_valida").val(data.meta_valida);
		$("#meta_valida").selectpicker('refresh');
		
		$("#meta_periodo").val(data.meta_periodo);
		$("#meta_periodo").selectpicker('refresh');


	});
	
	$.post("../controlador/saccrearcompromiso.php?op=condiciones_institucionales&id="+id_meta,function(r){
			$("#condiciones_institucionales").html(r);
		
	});
	
	$.post("../controlador/saccrearcompromiso.php?op=condiciones_programa&id="+id_meta,function(r){
			$("#condiciones_programa").html(r);
		
	});
	
	
}


//Función para desactivar registross
function eliminar(id_compromiso)
{
	alertify.confirm("Eliminar Compromiso","¿Está Seguro de eliminar el compromiso?", function(){

			$.post("../controlador/saccrearcompromiso.php?op=eliminar", {id_compromiso : id_compromiso}, function(e){
				//console.log(e);
				if(e=='true'){
					alertify.success("Eliminado correctamente");
					listar();
					listar2();
				}
				else{
					alertify.error("Error")
				}
			});	
		} 
					, function(){ alertify.error('Cancelado')});

}

//Función para desactivar registross
function eliminarMeta(id_meta,linea)
{

	alertify.confirm("Eliminar Meta","¿Está Seguro de eliminar la meta?", function(){

			$.post("../controlador/saccrearcompromiso.php?op=eliminarmeta", {id_meta : id_meta}, function(e){
				
				if(e=='true'){
					alertify.success("Eliminado correctamente");
					$("#linea_borrar_"+linea).hide();
				}
				else{
					alertify.error("Error")
				}
			});	
		} , function(){ alertify.error('Cancelado')});

}


init();