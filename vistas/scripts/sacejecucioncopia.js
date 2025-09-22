var tabla, id_metas;
$(document).ready(init);
//Función que se ejecuta al inicio
function init(){
	// listar();
	$("#formularioejecucion").on("submit",function(e){
		guardaryeditaraccion(e);	
	});
	mostrarIdAccion();
}
function subir_evidencia(idaccion){
	if($("#foto").val() != ""){
		var formData = new FormData($("#formSubirImagen"+idaccion)[0]);
		$("#info_preloader").html('<div class="preloader-box"></div>');
		$.ajax({
			url: "../controlador/sac_ejecucion.php?op=guardaryeditarImagen",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(datos){
				//console.log(datos);
				var data = JSON.parse(datos);
				if(data.estatus == 1){
					mostrarIdAccion();
					$("#iframe_evidencia").attr("src","../files/sac_evidencias/"+data.foto);
				}else{
					alertify.error(data.valor);
					$("#info_preloader").html('');
				}
			}
		});
	}
};
function mostrarIdAccion() {
	$.post("../controlador/sac_ejecucion.php?op=listarejecucion",function(data){
		//console.log(data);
		$("#precarga").hide();
		data = JSON.parse(data);
		$("#listarejecucion").html(data[0])
		$(function() {
			$(".tooltip-agregar").tooltip();
		})
	});
}
function id_ejecucion(id_accion) {
	$("#id_objetivo").val(id_accion)
	$("#ModalEjecucion").modal("show");
}
//Función cancelarform
function cancelarformejecucion(){
	cancelarformejecucion(false);
}

//Función guardo y edito accion 
function guardaryeditaraccion(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarEjecucion").prop("disabled",true);
	var formData = new FormData($("#formularioejecucion")[0]);
	$.ajax({
		"url": "../controlador/sac_ejecucion.php?op=guardaryeditaraccion",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			//console.log(datos);
			mostrarIdAccion();
			$("#ModalEjecucion").modal("hide");
			$("#formularioejecucion")[0].reset();
			$("#btnGuardarEjecucion").prop("disabled",false);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);
			
		}
	});
}
function mostrar_accion(id_accion){
	$.post("../controlador/sac_ejecucion.php?op=mostrar_accion",{"id_accion" : id_accion},function(data){
		//console.log(data);
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){
			mostrarIdAccion();
			$("#id_accion").val(data.id_accion);
			$("#nombre_accion").val(data.nombre_accion);
			$("#id_meta").val(data.id_meta);
			$("#fecha_accion").val(data.fecha_accion);
			$("#foto").val(data.evidencia_imagen);
			$("#ModalEjecucion").modal("show");
		}
	});
}
function mostrarEnGrande(archivo){
	$("#iframe_evidencia").attr("src", '../files/sac_evidencias/'+archivo);
	$("#modal_evidencias").modal("show");
}
// //Función para desactivar registros
function eliminar_accion(id_accion){
	alertify.confirm("¿Está Seguro de eliminar la accion?", function(result){
		if(result){
			$.post("../controlador/sac_ejecucion.php?op=eliminar_accion", {'id_accion' : id_accion}, function(e){
				//console.log(e);
				mostrarIdAccion();
				if(e){
					alertify.success("Eliminado correctamente");
				}else{
					alertify.error("Error");
				}
			});	
        }
	})
}
function dividirCadena(cadenaADividir,separador) {
    var arrayDeCadenas = cadenaADividir.split(separador);
    return arrayDeCadenas[0];
}
//funcion para confugirar el limite de la fecha 
function configurar_limite_fecha(id_meta, fecha) {
	$(".id_meta").val(id_meta)
	$("#fecha_accion").attr("max", fecha)
	$("#ModalEjecucion").modal("show");
}

