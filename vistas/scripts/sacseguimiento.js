$(document).ready(init);
//Función que se ejecuta al inicio
function init(){
	// seguimiento();
	// listardependencia();

	$("#formularioejecucion").on("submit",function(e){
		guardaryeditaraccion(e);	
	});
	$("#formularievidencia").on("submit",function(e){
		guardaryeditarevidencia(e);	
	});
	
	$("#fecha_fin, #fecha_accion").on("change",function() {
		fecha_fin = $("#fecha_fin").val();
		fecha_inicio =  $("#fecha_accion").val();
		if(parseInt(fecha_inicio) > parseInt(fecha_fin) || isNaN(parseInt(fecha_fin)) || isNaN(parseInt(fecha_inicio))  ){
			$("#btnGuardarEjecucion").attr("disabled", true);
		}else{
			alertify.error("La fecha final debe ser superior a la inicial.");
			$("#btnGuardarEjecucion").attr("disabled", false);
		}
	})
	//mostrarIdUsuario();
	listarejecucion();
	
}


//Función guardo y edito accion 
function guardaryeditarevidencia(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularievidencia")[0]);
	$.ajax({
		"url": "../controlador/sac_seguimiento.php?op=guardaryeditarevidencia",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			var data = JSON.parse(datos);
			//console.log(datos);
			if(data.estatus == 1){
				$("#btnGuardarEvidencia").attr("disabled", true);
				listarejecucion();
				// $("#modal_evidencia").attr("src","../files/sac_evidencias/"+data.foto);
			}else{
				alertify.error(data.valor);
				$("#info_preloader").html('');
			}
			$("#modal_evidencia").modal("hide");
			$("#formularievidencia")[0].reset();
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);
			
		}
	});
	
}

function subirEvidencia(id_meta){
	$("#modal_evidencia").modal("show");
	$(".id_meta").val(id_meta);
	
}

function mostrarIdUsuario() {
	$.post("../controlador/sac_seguimiento.php?op=mostrar",{"id_usuario": $("#id_usuario").val()},function(data){
		//
		// console.log(data);
		$("#precarga").hide();
		data = JSON.parse(data);
		$("#usuario_cargo").val(data.usuario_cargo);
		$("#listarejecucion").html(data[0])
		$(function() {
			$('.tooltip').remove();
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
		"url": "../controlador/sac_seguimiento.php?op=guardaryeditaraccion",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			listarejecucion();
			$("#ModalEjecucion").modal("hide");
			$("#formularioejecucion")[0].reset();
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);
			
		}
	});
}

function mostrar_accion(id_accion){
	$.post("../controlador/sac_seguimiento.php?op=mostrar_accion",{"id_accion" : id_accion},function(data){
		// console.log(data);
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){
			listarejecucion();
			$("#id_accion").val(data.id_accion);
			$("#nombre_accion").val(data.nombre_accion);
			$("#id_meta").val(data.id_meta);
			$("#fecha_accion").val(data.fecha_accion);
			$("#fecha_fin").val(data.fecha_fin);
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
			$.post("../controlador/sac_seguimiento.php?op=eliminar_accion", {'id_accion' : id_accion}, function(e){
				// console.log(e);
				listarejecucion();
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

// function seguimiento() {
// 	$.post("../controlador/sac_seguimiento.php?op=seguimiento",function(data){
// 		console.log(data);
// 		$("#precarga").hide();
// 		data = JSON.parse(data);
// 		$("#listarejecucion").html(data[0])
// 	});
// }

function listarejecucion() {
	$.post("../controlador/sac_seguimiento.php?op=listarejecucion",{"id_usuario" : $("#id_usuario").val()},function(data){
		// console.log(data);
		$("#precarga").hide();
		data = JSON.parse(data);
		$("#listarejecucion").html(data[0])
		$(function() {
			$('.tooltip').remove();
			$(".tooltip-agregar").tooltip();
		})
	});
}




