var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
		
	});
	
	$("#formulario_fuente").on("submit",function(e2)
	{
		guardaryeditarfuente(e2);
		
	});
	
//		Cargamos los items al select de ejes
	$.post("../controlador/micompromiso.php?op=selectEjes", function(r){
	            $("#meta_ejes").html(r);
	           	$('#meta_ejes').selectpicker('refresh');
	
	});
	
	$.post("../controlador/micompromiso.php?op=selectPeriodo", function(r){
	            $("#meta_periodo").html(r);
	           	$('#meta_periodo').selectpicker('refresh');
	
	});
	
	$.post("../controlador/micompromiso.php?op=selectListaSiNo", function(r){
	            $("#meta_val_admin").html(r);
	            $('#meta_val_admin').selectpicker('refresh');
	});
	
	$.post("../controlador/micompromiso.php?op=selectListaSiNo", function(r){
	            $("#meta_val_usuario").html(r);
	            $('#meta_val_usuario').selectpicker('refresh');
	});
	
		$.post("../controlador/micompromiso.php?op=selectListaCargo", function(r){
	            $("#meta_valida").html(r);
	            $('#meta_valida').selectpicker('refresh');
	});
	
}

//Función limpiar
function limpiar()
{
	$("#id_micompromiso").val("");
	$("#meta_nombre").val("");
	$("#meta_val_admin").val("0");
	$("#meta_val_admin").change();
	$("#meta_val_usuario").val("0");
	$("#meta_val_usuario").change();
	$("#meta_fecha").val("");
	$("#meta_periodo").val("");
	$("#meta_periodo").change();
	$('#meta_periodo').selectpicker('refresh');
	$("#meta_valida").val("");
	$("#meta_valida").change();



}

//Función limpiar
function limpiarfuente()
{
	$("#id_fuente").val("");
	$("#fuente_archivo").val("");

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
function mostrarformfuente(flag)
{
	limpiar();
	if (flag)
	{
		$("#myModalFuente").modal("show");
	}
	else
	{
		$("#myModalFuente").modal("hide");
		
	}
}


//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función cancelarform
function cancelarformfuente()
{
	limpiarfuente();
	mostrarformfuente(false);
	$("#myModalFuente").modal("hide");
}

//Función mostrar formulario

function numerocampo(numero,fecha)
{
	$("#id_compromiso").val(numero);
	$("#meta_fecha").attr("max",fecha);
	$("#campo_val_admin").show();
	$("#campo_val_usuario").show();


}


//funcion para cativar campos cuando edita
function activarCampos(){
	$("#campo_val_admin").hide();
	$("#campo_val_usuario").hide();
}

function listar(){
	
	$.post("../controlador/micompromiso.php?op=listar",{},function(data, status){
	//console.log(data);
	data = JSON.parse(data);
		
	$("#tllistado").html("");
	$("#tllistado").append(data["0"]["0"]);
	
	$("#progreso").html("");
	$("#progreso").prepend(data["0"]["1"]);
	$("#precarga").hide();
	});
}


function guardaryeditar(e)
{
	
	
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controlador/micompromiso.php?op=guardaryeditar",
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


function guardaryeditarfuente(e2)
{
	
	
	e2.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarFuente").prop("disabled",true);
	var formData = new FormData($("#formulario_fuente")[0]);

	$.ajax({
		url: "../controlador/micompromiso.php?op=guardaryeditarfuente",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    { 

			 alertify.set('notifier','position', 'top-center');
			if(datos=="error"){
			   alertify.error("No permitido");
			   }
	         else{
			    alertify.success(datos);
			   }
			
	          mostrarformfuente(false);
	          listar();
	    }

	});
	limpiarfuente();
}


function mostrar(id_meta)
{
	$.post("../controlador/micompromiso.php?op=mostrar",{id_meta : id_meta}, function(data, status)
	{

		data = JSON.parse(data);		
		mostrarform(true);
		$("#id_meta").val(data.id_meta);
		$("#id_compromiso").val(data.id_compromiso);
		$("#meta_nombre").val(data.meta_nombre);
		$("#meta_fecha").val(data.meta_fecha);
		
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
}



//Función para desactivar registross
function eliminar(id_meta)
{
	alertify.confirm("Eliminar Meta","¿Está Seguro de eliminar la meta?", function(){

        	$.post("../controlador/micompromiso.php?op=eliminar", {id_meta : id_meta}, function(e){
				console.log(e);
				if(e=='true'){
					alertify.success("Eliminado correctamente");
					 listar();
				}
				else{
					alertify.error("Error")
				}
        	});	
        }, function(){ alertify.error('Cancelado')});
	
}

//Función para desactivar registross
function mostrarfuente(id_meta)
{
	$("#id_meta_fuente").val(id_meta);
	$.post("../controlador/micompromiso.php?op=mostrarfuente",{id_meta : id_meta}, function(data, status)
	{
		data = JSON.parse(data);				
		mostrarformfuente(true);
		$("#btnGuardarFuente").prop("disabled",false);

 	});

	
}

//Función para desactivar registross
function validarMeta(id_meta,fecha,correo_usuario)
{
	alertify.confirm('Validar meta', '¿Esta seguro de realizar la acción?', function(){ 
	$("#precarga").show();
		$.post("../controlador/micompromiso.php?op=validarMeta",{id_meta : id_meta, fecha:fecha, correo_usuario:correo_usuario}, function(data, status)
			{
				
				if(data==1){
				   alertify.success("Validado Correctamente, se envia alerta");
					listar();
					$("#precarga").hide();
				   }
				else{
					alertify.error("Error");
					$("#precarga").hide();
				}

			});
	}
    , function(){ alertify.error('Cancelado')});
	
	
}
//Función para desactivar registross
function eliminarFuente(fuente,id_meta)
{

	
	alertify.confirm('Eliminar Fuente', '¿Está Seguro de eliminar la fuente de verificación?', function(){ 

		$.post("../controlador/micompromiso.php?op=eliminarFuente",{fuente:fuente,id_meta:id_meta}, function(data, status)
			{
				
				data = JSON.parse(data);
				if(data==true){
				   alertify.success("Eliminado Correctamente");
					listar();
				   }

			});
	}
    , function(){ alertify.error('Cancelado')});
	
	
	
}

init();