var tabla, id_ejes;
$(document).ready(init);
//Función que se ejecuta al inicio
function init(){
	// listar();

	$("#formularioobjetivosgenerales").on("submit",function(e){
		guardaryeditarobjetivogeneral(e);	
	});
	$('#ModalCrearObjetivosGenerales').on('hidden.bs.modal', function (e) {
		$('#formularioobjetivosgenerales')[0].reset();
	})
	$("#formularioobjetivosespecifico").on("submit",function(e){
		guardaryeditarobjetivoespecifico(e);	
	});
	$('#ModalCrearObjetivosEspecifico').on('hidden.bs.modal', function (e) {
		$('#formularioobjetivosespecifico')[0].reset();
	})
	$("#formularioguardometa").on("submit",function(e){
		guardaryeditometa(e);	
	});
	//listamos las condiciones institucionales en el html
	$.post("../controlador/sac_proyecto.php?op=condiciones_institucionales",function(r){
		$(".box_condiciones_institucionales").html(r);
	});
	//listamos las dependencias en el html
	$.post("../controlador/sac_proyecto.php?op=dependencias",function(r){
		$("#dependencias").html(r);
	});

	//listamos las condiciones de programa en el html
	$.post("../controlador/sac_proyecto.php?op=condiciones_programa&id=",function(r){
		$("#condiciones_programa").html(r);
	});

	//listamos el cargo en el html
	$.post("../controlador/sac_proyecto.php?op=selectListarCargo", function(r){
		$("#meta_responsable").html(r);
		$('#meta_responsable').selectpicker('refresh');
	});
}

//Función mostrar id ejes 
function mostrarIdEjes(id_eje) {
	id_ejes = id_eje;
	$.post("../controlador/sac_proyecto.php?op=listarobjetivosgenerales",{ "id_ejes": id_eje },function(data){
		console.log(data);
		$("#precarga").hide();
		data = JSON.parse(data);
		$("#listadoregistrosobjetivosgenerales").html(data[0])
		$(function() {
			$(".tooltip-agregar").tooltip();
		})
	});
}

//Función objetivos especificos 
function mostrar_objetivos_especificos(id_objetivo_especifico){
	$.post("../controlador/sac_proyecto.php?op=mostrar_objetivos_especificos",{ "id_objetivo_especifico": id_objetivo_especifico },function(data){
		data = JSON.parse(data);
		//console.log(Object.keys(data).length);
		if(Object.keys(data).length > 0){
			$("#ModalCrearObjetivosEspecifico").modal("show");
			$("#id_objetivo").val(data.id_objetivo);
			$("#id_objetivo_especifico").val(data.id_objetivo_especifico);
			$("#nombre_objetivo_especifico").val(data.nombre_objetivo_especifico);
		}
	});
}

//Función objetivos especificos 
function mostrar_objetivos_generales(id_objetivo){
	$.post("../controlador/sac_proyecto.php?op=mostrar_objetivos_generales",{ "id_objetivo": id_objetivo },function(data){
		// console.log(data);
		data = JSON.parse(data);
		if(Object.keys(data).length > 0){
			$("#ModalCrearObjetivosGenerales").modal("show");
			$(".id_objetivo_general").val(data.id_objetivo);
			$("#nombre_objetivo").val(data.nombre_objetivo);
		}
	});
}

//Función objetivos especificos 
function mostrar_editar_meta(id_meta){
	$.post("../controlador/sac_proyecto.php?op=mostrar_editar_meta",{ "id_meta": id_meta },function(data){
		data = JSON.parse(data);
		console.log(data);
		if(Object.keys(data.datos_meta).length > 0){
			$("#myModalMeta").modal("show");
			$(".id_meta").val(data.datos_meta.id_meta);
			$("#meta_nombre").val(data.datos_meta.meta_nombre);
			$("#meta_fecha").val(data.datos_meta.meta_fecha);
			$("#id_objetivo_especifico").val(data.datos_meta.id_objetivo_especifico);
			$("#meta_responsable").val(data.datos_meta.meta_responsable);
			//trae los datos almacenados y los muestra el check seleccionado
			$(".box_condiciones_institucionales").find('[value=' + data.condicion_institucional.join('], [value=') + ']').prop("checked", true);
			
			//trae los datos almacenados y los muestra el check seleccionado
			$("#dependencias").find('[value=' + data.dependencias.join('], [value=') + ']').prop("checked", true);
			//trae los datos almacenados y los muestra el check seleccionado
			$("#condiciones_programa").find('[value=' + data.condicion_programa.join('], [value=') + ']').prop("checked", true);
			$("#anio_eje").val(data.datos_meta.anio_eje);
		}
	});
}

function mostrarMeta(id_objetivo_especifico){
	$("#myModalMeta").modal("show");
	$(".id_objetivo_especifico").val(id_objetivo_especifico);
}

function mostrar(id_objetivo_especifico){
	$.post("../controlador/sac_proyecto.php?op=mostrar",{id_objetivo_especifico : id_objetivo_especifico}, function(data){
		data = JSON.parse(data);		
		mostrarform(true);
		$("#id_objetivo_especifico").val(data.id_objetivo_especifico);
		//console.log(data);
	});
}

//Función cancelarform
function cancelarform(){
	mostrarform(false);
}
function listarobjetivosgenerales(){
	$.post("../controlador/sac_proyecto.php?op=listarobjetivosgenerales",{},function(data, status){
	data = JSON.parse(data);
	$("#tllistadoobjetivosgenerales").html("");
	$("#tllistadoobjetivosgenerales").append(data["0"]["0"]);
	$("#precarga").hide();
	});
}
//Función guardo y edito objetivo general
function guardaryeditarobjetivogeneral(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarObjetivoGeneral").prop("disabled",true);
	var formData = new FormData($("#formularioobjetivosgenerales")[0]);
	$.ajax({
		"url": "../controlador/sac_proyecto.php?op=guardaryeditarobjetivogeneral",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			$("#ModalCrearObjetivosGenerales").modal("hide");
			$("#formularioobjetivosgenerales")[0].reset();
			$("#btnGuardarObjetivoGeneral").prop("disabled",false);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);
			mostrarIdEjes(id_ejes);
		}
	});
	limpiar();
}
//Función guardo y edito objetivo especifico
function guardaryeditarobjetivoespecifico(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarObjetivoEspecifico").prop("disabled",true);
	var formData = new FormData($("#formularioobjetivosespecifico")[0]);
	$.ajax({
		"url": "../controlador/sac_objetivos_especificos.php?op=guardaryeditarobjetivoespecifico",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			mostrarIdEjes(id_ejes);
			$("#ModalCrearObjetivosEspecifico").modal("hide");
			$("#formularioobjetivosespecifico")[0].reset();
			$("#btnGuardarObjetivoEspecifico").prop("disabled",false);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}
//Función guardo y edito meta
function guardaryeditometa(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardometa").prop("disabled",true);
	var formData = new FormData($("#formularioguardometa")[0]);
	$.ajax({
		"url": "../controlador/sac_proyecto.php?op=guardaryeditometa",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			mostrarIdEjes(id_ejes);
			$("#myModalMeta").modal("hide");
			$("#formularioguardometa")[0].reset();
			$("#btnGuardometa").prop("disabled",false);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
			// listar();
			//console.log(datos);
		}
	});
}
//Función mostrar formulario
function mostrarformmeta(flag){
	if (flag){
		// $("#resultadometas").hide();
		$("#formularioguardometa").show();
		$("#btnGuardometa").prop("disabled",false);
		$("#btnAgregarMeta").hide();
	}else{
		// $("#resultadometas").show();
		$("#formularioguardometa").hide();
		$("#btnAgregarMeta").show();
	}
}

function id_objetivo_general(id_objeto) {
	$("#id_objetivo").val(id_objeto)
	$("#ModalCrearObjetivosGenerales").modal("show");
}

function add_id_objetivo_general(id_objeto) {
	$("#id_objetivo").val(id_objeto)
	$("#ModalCrearObjetivosEspecifico").modal("show");
}

function editar_objetivo_especifico(id_objeto, id_objetivo_especifico) {
	$("#id_objetivo_especifico").val(id_objetivo_especifico)
	$("#id_objetivo").val(id_objeto)
}

//Función para desactivar registros
function eliminar_objetivo_especifico(id_objetivo_especifico){

	alertify.confirm("¿Está Seguro de eliminar el Obejtivo especifico?"
	
	
	, function(result){
		if(result){
			$.post("../controlador/sac_proyecto.php?op=eliminar_objetivo_especifico", {'id_objetivo_especifico' : id_objetivo_especifico}, function(e){
				//console.log(e);
				if(e){
					alertify.success("Eliminado correctamente");
					mostrarIdEjes(id_ejes);
				}else{
					alertify.error("Error");
				}
			});	
        }
	})
}

//Función para desactivar registros
function eliminar_meta(id_meta){
	alertify.confirm("¿Está Seguro de eliminar la meta?", function(result){
		if(result){
			$.post("../controlador/sac_proyecto.php?op=eliminar_meta", {'id_meta' : id_meta}, function(e){
				//console.log(e);
				if(e){
					alertify.success("Eliminado correctamente");
					mostrarIdEjes(id_ejes);
				}else{
					alertify.error("Error");
				}
			});	
        }
	})
}
//Función para desactivar registros
function eliminar_objetivo_general(id_objetivo){
	alertify.confirm("¿Está Seguro de eliminar el Proyecto?", function(result){
		if(result){
			$.post("../controlador/sac_proyecto.php?op=eliminar_objetivo_general", {'id_objetivo' : id_objetivo}, function(e){
				//console.log(e);
				if(e){
					alertify.success("Eliminado correctamente");
					mostrarIdEjes(id_ejes);
				}else{
					alertify.error("Error");
				}
			});	
        }
	})
}