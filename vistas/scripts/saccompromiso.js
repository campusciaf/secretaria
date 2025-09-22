var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	mostrarformmeta(false);
	listar();
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	
	$("#formulario_meta").on("submit",function(e2)
	{
		guardaryeditarmeta(e2);	
	});
	$.post("../controlador/saccompromiso.php?op=selectListaSiNo", function(r){
				$("#compromiso_val_admin").html(r);
				$('#compromiso_val_admin').selectpicker('refresh');
	});
	
	$.post("../controlador/saccompromiso.php?op=selectListaSiNo", function(r){
				$("#compromiso_val_usuario").html(r);
				$('#compromiso_val_usuario').selectpicker('refresh');
	});
	
	$.post("../controlador/saccompromiso.php?op=selectListarCargo", function(r){
				$("#resposable_compromiso").html(r);
				$('#resposable_compromiso').selectpicker('refresh');
	});
//	**********************
	
	$.post("../controlador/saccompromiso.php?op=selectEjes", function(r){
				$("#meta_ejes").html(r);
				$('#meta_ejes').selectpicker('refresh');
	
	});
	$.post("../controlador/saccompromiso.php?op=selectListaSiNo", function(r){
				$("#meta_val_admin").html(r);
				$('#meta_val_admin').selectpicker('refresh');
	});
	
	$.post("../controlador/saccompromiso.php?op=selectListaSiNo", function(r){
				$("#meta_val_usuario").html(r);
				$('#meta_val_usuario').selectpicker('refresh');
	});
	
	$.post("../controlador/saccompromiso.php?op=selectPeriodo", function(r){
				$("#meta_periodo").html(r);
				$('#meta_periodo').selectpicker('refresh');
	
	});
	
	$.post("../controlador/saccompromiso.php?op=selectListarCargo", function(r){
				$("#meta_valida").html(r);
				$('#meta_valida').selectpicker('refresh');
	});
	
	$.post("../controlador/saccompromiso.php?op=selectListarCorresponsable", function(r){
				$("#corresponsabilidad").html(r);
				$('#corresponsabilidad').selectpicker('refresh');
	});
	

	$.post("../controlador/saccompromiso.php?op=condiciones_institucionales&id=",function(r){
			$("#condiciones_institucionales").html(r);
		
	});
	
	$.post("../controlador/saccompromiso.php?op=condiciones_programa&id=",function(r){
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
	$("#fecha_compromiso").val("");
	$("#resposable_compromiso").val("");
	$("#resposable_compromiso").change();


}
//Función limpiar
function limpiarMeta()
{
	$("#id_meta").val("");
	$("#nombre_meta").val("");
	$("#meta_val_admin").val("0");
	$("#meta_val_admin").change();
	$("#meta_val_usuario").val("0");
	$("#meta_val_usuario").change();
	$("#meta_anio").val("");
	// $("#meta_periodo").val("");
	// $("#meta_periodo").change();
	// $('#meta_periodo').selectpicker('refresh');
	$("#meta_responsable").val("");
	$("#meta_responsable").change();
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
function cancelarformmeta()
{
	limpiarMeta();
	mostrarformmeta(false);
}
//Función mostrar formulario
function numerocampo(numero,periodo)
{
	$("#id_eje").val(numero);
	$("#compromiso_periodo").val(periodo);
}
function numerocompromiso(numero)
{
	$("#id_compromiso_meta").val(numero);
}
function listar(){
	$.post("../controlador/saccompromiso.php?op=listar",{},function(data, status){
	data = JSON.parse(data);
	$("#tllistado").html("");
	$("#tllistado").append(data["0"]["0"]);
	$("#precarga").hide();
	});
}
function listarMeta(){

	$.post("../controlador/saccompromiso.php?op=mostrarmeta",{},function(data, status){

	data = JSON.parse(data);
		
	$("#resultadometas").html("");
	$("#resultadometas").append(data["0"]["0"]);

	});
}
function imprimir(id_usuario){
	$("#myModalImprimir").modal("show");
	$.post("../controlador/saccompromiso.php?op=imprimir",{id_usuario : id_usuario}, function(data, status)
	{
		//console.log(data);
			data = JSON.parse(data);
				
			$("#resultado_imprimir").html("");
			$("#resultado_imprimir").append(data["0"]["0"]);


	});
}
function cerrar(){
	$('#myModalImprimir').fadeOut();
	$('.modal-backdrop').fadeOut();
}
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../controlador/saccompromiso.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function(datos)
		{ 
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
			mostrarform(false);
			listar();
		}

	});
	limpiar();
}
function guardaryeditarmeta(e2)
{
	var id_meta = $("#id_meta").val();
	var id_compromiso_meta=$("#id_compromiso_meta").val();
	var meta_fecha=$("#meta_fecha").val();
	e2.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarMeta").prop("disabled",true);
	var formData = new FormData($("#formulario_meta")[0]);
	$.ajax({
		url: "../controlador/saccompromiso.php?op=guardaryeditarmeta",
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
				$.post("../controlador/saccompromiso.php?op=fechaLimite",{id_compromiso_meta:id_compromiso_meta}, function(r){
					
				var fechaLimite=r;
				mostrarMeta(id_compromiso_meta,meta_fecha);	
				});
			}else{

			}
			
		}

	});
	limpiarMeta();
}
function mostrar(id_compromiso)
{
	$.post("../controlador/saccompromiso.php?op=mostrar",{id_compromiso : id_compromiso}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#id_compromiso").val(data.id_compromiso);
		$("#id_eje").val(data.id_eje);
		$("#nombre_compromiso").val(data.nombre_compromiso);
		$("#fecha_compromiso").val(data.fecha_compromiso);
		$("#compromiso_val_admin").val(data.compromiso_val_admin);
		$("#compromiso_val_admin").selectpicker('refresh');
		$("#compromiso_val_usuario").val(data.compromiso_val_usuario);
		$("#compromiso_val_usuario").selectpicker('refresh');
		$("#resposable_compromiso").val(data.resposable_compromiso);
		$("#resposable_compromiso").selectpicker('refresh');
		$("#compromiso_periodo").val(data.compromiso_periodo);
		$("#compromiso_periodo").selectpicker('refresh');
	});
}
//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}
function mostrarMeta(id_compromiso_meta,fecha)
{
	$("#myModalMeta").modal("show");
	$("#id_compromiso_meta").val(id_compromiso_meta);
	$("#meta_fecha").attr("max",fecha);
	$.post("../controlador/saccompromiso.php?op=mostrarmeta",{id_compromiso_meta : id_compromiso_meta}, function(data, status)
	{
			data = JSON.parse(data);
			$("#resultadometas").html("");
			$("#resultadometas").append(data["0"]["0"]);
	});
}
function mostrarMetaEditar(id_meta)
{
	$.post("../controlador/saccompromiso.php?op=mostrarmetaeditar",{id_meta : id_meta}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarformmeta(true);
		$("#id_meta").val(data.id_meta);
		$("#nombre_meta").val(data.nombre_meta);
		$("#meta_anio").val(data.meta_anio);
		$("#id_eje_meta").val(data.id_eje_meta);
		$("#id_eje_meta").selectpicker('refresh');
		$("#meta_val_admin").val(data.meta_val_admin);
		$("#meta_val_admin").selectpicker('refresh');		
		$("#meta_val_usuario").val(data.meta_val_usuario);
		$("#meta_val_usuario").selectpicker('refresh');		
		$("#meta_responsable").val(data.meta_responsable);
		$("#meta_responsable").selectpicker('refresh');		
		// $("#meta_periodo").val(data.meta_periodo);
		// $("#meta_periodo").selectpicker('refresh');
	});
	$.post("../controlador/saccompromiso.php?op=condiciones_institucionales&id="+id_meta,function(r){
			$("#condiciones_institucionales").html(r);
	});
	$.post("../controlador/saccompromiso.php?op=condiciones_programa&id="+id_meta,function(r){
			$("#condiciones_programa").html(r);
		
	});
}
//Función para desactivar registross
function eliminar(id_compromiso_meta)
{
	alertify.confirm("Eliminar Compromiso","¿Está Seguro de eliminar el compromiso?", function(){
			$.post("../controlador/saccompromiso.php?op=eliminar", {id_compromiso_meta : id_compromiso_meta}, function(e){
				if(e=='true'){
					alertify.success("Eliminado correctamente");
					listar();
				}
				else{
					alertify.error("Error")
				}
			});	
		} , function(){ alertify.error('Cancelado')}
	);
}
//Función para desactivar registros
function eliminarMeta(id_meta,linea)
{
	alertify.confirm("Eliminar Meta","¿Está Seguro de eliminar la meta?", function(){
			$.post("../controlador/saccompromiso.php?op=eliminarmeta", {id_meta : id_meta}, function(e){
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

//Función para desactivar registross
function validarCompromiso(id_compromiso)
{
	alertify.confirm("validar compromiso","¿Está Seguro de validar el compromiso?", function(){

			$.post("../controlador/saccompromiso.php?op=validarcompromiso", {id_compromiso : id_compromiso}, function(e){
				if(e=='true'){
					alertify.success("Validado correctamente correctamente");
					listar();
				}
				else{
					alertify.error("Error")
				}
			});	
		} , function(){ alertify.error('Cancelado')});
}


function printDiv(nombreDiv) {
	var contenido= document.getElementById(nombreDiv).innerHTML;
	var contenidoOriginal= document.body.innerHTML;
	document.body.innerHTML = contenido;
	window.print();
	document.body.innerHTML = contenidoOriginal;
}


init();