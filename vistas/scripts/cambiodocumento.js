function init(){
	$("#precarga").hide();
	$("#tarjeta").on("submit",function(e){
		cambiarTarjetaCedula(e);
	});
}
$('#botonTarjeta').off("click").on("click",function(e){
	e.preventDefault();
	var tarjeta = $("#documento1").val();
	verificarDocumento( tarjeta, "Tarjeta de Identidad");
});
$("#guardarcambios").off("click").on("click",function(e){
	e.preventDefault();
	var nueva_cedula = $("#num_cedula").val();
	var fecha_exp = $("#fecha_exp").val();
	verifCedulaCambio(nueva_cedula, fecha_exp);
});
$("#botonCedula").off("click").on("click",function(e){
	e.preventDefault();
	var cedula = $("#documento2").val();
	verificarCedula(cedula, "Cédula de Ciudadanía");
});
$('#cuadrar_documento').off("click").on("click",function(e){
	e.preventDefault();
	var cedula_nueva = $("#cedula_correcta").val();
	verifNuevaCedula(cedula_nueva);
});
//corrige el numero de documento del estudiante.
$("#botonCorregir")
	.off("click")
	.on("click", function (e) {
		e.preventDefault();
		var corregir_cedula = $("#corregir_cedula").val();
		corregirCedula(corregir_cedula);
	});

$("#formulariocorregirdocumento").on("submit", function (e1) {
	editardocumentoestudiante(e1);
});
/***************** Cambio Tarjeta a Cédula **************************/
function verificarDocumento(documento, tipoDocumento){
	$.ajax({
		"type":'POST',
		"url":'../controlador/cambio_documento.php?op=verificar',
		"data":{ "documento": documento, "tipoDocumento": tipoDocumento},
		success:function(msg){
			if(msg == 1) {
				swal({
					"title": "Documento no existe en la base de datos.", 
					"icon": "error", 
					"timer": 1500, 
					"buttons": false
				});
			}else{
				datos = JSON.parse(msg);
				$("#cambioDatos").modal();
				$("#numero_tarjeta").val(documento);
				$("#cambioDatos").modal({"backdrop": 'static', "keyboard": false});
				$("#id_reemplazar").val(datos['id_credencial']);
				$("#correo_institucional").val(datos['credencial_login']);
				$("#informacion_estudiante").html("<h5 class='mb-0'><b>Estudiante: </b>" + datos['credencial_nombre'] + " " + datos['credencial_nombre_2'] + " " + datos['credencial_apellido'] + " " + datos['credencial_apellido_2']+"</h5>");
			}
		},
		error: function(){
			swal({
				"title": "Error al ejecutar la consulta.",
				"icon": "error",
				"timer": 3000,
				"buttons": false
			});
		}
	});
};

function verifCedulaCambio(nueva_cedula	, fecha_exp){
	var id_reemplazar = $("#id_reemplazar").val();
	$.ajax({
		"type": 'POST',
		"url": '../controlador/cambio_documento.php?op=verificar_cedula_cambio',
		"data": {"nueva_cedula": nueva_cedula},
		success: function(msg){
			if(msg == 0) {
				cambiarTarjetaCedula(id_reemplazar, nueva_cedula, fecha_exp, "Cédula de Ciudadanía");
			}else{
				datos = JSON.parse(msg);
				swal({
					"title": "Documento ingresado ya existe en la base de datos, pertenece a: " + datos[0]['nombre'] + " " + datos[0]['apellidos'],
					"icon": "warning",
					"timer": 3000,
					"buttons": ["Entiendo"]
				});
			}
		},
		error:function(){
			swal({
				"title": "Error al procesar la peticíon.",
				"icon": "danger",
				"timer": 3000,
				"buttons": false
			});
		}
	});
};
//Función para guardar o editar
function cambiarTarjetaCedula(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btn_guardar1").prop("disabled",true);
	var formData = new FormData($("#tarjeta")[0]);
	$.ajax({
		"url": "../controlador/cambio_documento.php?op=cambiar_tarjeta_cedula",
	    "type": "POST",
	    "data": formData,
	    "contentType": false,
	    "processData": false,
	    success: function(datos){   
			if (datos == 1) {
				swal({
					"title": "Documento actualizado correctamente.",
					"icon": "success",
					"timer": 1500,
					"buttons": ["Entiendo"]
				});
				$("#verificar_tarjeta")[0].reset();
				$("#verificar_cedula")[0].reset();
				$("#btn_guardar1").prop("disabled",false);
				$("#cambioDatos").modal("hide");
			}else{
				swal({
					"title": "Error al procesar la peticíon.",
					"icon": "danger",
					"timer": 3000,
					"buttons": false
				});
			}          
	    }
	});
}
/*************** Cuadrar Cédula ******************/
function verificarCedula(documento, tipoDocumento){
	$.ajax({
		"type":'POST',
		"url":'../controlador/cambio_documento.php?op=verificar',
		"data":{"documento": documento, "tipoDocumento": tipoDocumento},
		success:function(msg){
			if(msg == 1) {
				swal({
					"title": "Documento no existe en la base de datos.",
					"icon": "error",
					"timer": 3000,
					"buttons": false
				});
			}else{
				datos = JSON.parse(msg);
				$("#cuadrarCedula").modal();
				$("#cuadrarCedula").modal({backdrop:'static', keyboard:false});
				$("#documento_antiguo_cambio").val(documento);
				$("#correo_institucional_cambio").val(datos['credencial_login']);
				$("#id_cuadrar").val(datos['id_credencial']);
				$("#nombre_estudiante").html(datos['credencial_nombre'] + " " + datos['credencial_nombre_2'] + " " + datos['credencial_apellido'] + " " + datos['credencial_apellido_2']);
			}
		},
		error:function(){
			swal({
				"title": "Error al procesar la peticíon.",
				"icon": "danger",
				"timer": 3000,
				"buttons": false
			});
		}
	});
};

function verifNuevaCedula(nueva_cedula){
	var id_reemplazar = $("#id_cuadrar").val();
	$.ajax({
		"type": 'POST',
		"url": '../controlador/cambio_documento.php?op=verificar_cedula_cambio',
		"data": {"nueva_cedula": nueva_cedula},
		success:function(msg){
			if (msg == 0) {
				actualizarCedula(id_reemplazar, nueva_cedula);
			}else{
				datos = JSON.parse(msg);
				swal({
					"title": "Documento ingresado ya existe en la base de datos, pertenece a: " + datos[0]['credencial_nombre'] + " " + datos[0]['credencial_apellido'],
					"icon": "warning",
					"timer": 3000,
					"buttons": false
				});
			}
		},
		error:function(){
			swal({
				"title": "Error al procesar la peticíon.",
				"icon": "danger",
				"timer": 3000,
				"buttons": false
			});
		}
	});
};

function actualizarCedula(id_reemplazar, nueva_cedula){
	$.ajax({
		"type": 'POST',
		"url": '../controlador/cambio_documento.php?op=actualizar_cedula',
		"data": {
			"id_reemplazar": id_reemplazar, 
			"nueva_cedula": nueva_cedula,
			"documento_antiguo_cambio": $("#documento_antiguo_cambio").val(),
			"correo_institucional_cambio": $("#correo_institucional_cambio").val()
		},
		success:function(msg){
			if (msg==1) {
				swal({
					"title": "Documento actualizado correctamente.",
					"icon": "success",
					"timer": 1500,
					"buttons": ["Entiendo"]
				});
				$("#verificar_tarjeta")[0].reset();
				$("#verificar_cedula")[0].reset();
				$("#cuadrar_cedula")[0].reset();
				$("#cuadrarCedula").modal("toggle");
			}else{
				swal({
					"title": "Error al procesar la peticíon.",
					"icon": "danger",
					"timer": 3000,
					"buttons": false
				});
			}
		},
		error:function(){
			swal({
				"title": "Error al procesar la peticíon.",
				"icon": "danger",
				"timer": 3000,
				"buttons": false
			});
		}
	});
}

//función para verificar y corregir la cédula del estudiante.
function corregirCedula(cedula_estudiante) {
	$.ajax({
		type: "POST",
		url: "../controlador/cambio_documento.php?op=corregirCedula",
		data: { cedula_estudiante: cedula_estudiante },
		success: function (msg) {
			if (msg == 1) {
				swal({
					title: "Documento no existe en la base de datos.",
					icon: "error",
					timer: 1500,
					buttons: false
				});
			} else {
				datos = JSON.parse(msg);
				$("#numero_documento_estudiante").val(datos.credencial_identificacion);
				$("#id_credencial").val(datos.id_credencial);
				$("#ModalCorregirDocumento").modal("show");
			}
		},
		error: function () {
			swal({
				title: "Error al ejecutar la consulta.",
				icon: "error",
				timer: 3000,
				buttons: false
			});
		}
	});
}
//función para editar la cédula del estudiante.
function editardocumentoestudiante(e1) {
	e1.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulariocorregirdocumento")[0]);
	$.ajax({
		url: "../controlador/cambio_documento.php?op=editardocumentoestudiante",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			limpiar_formulario();
			$("#ModalCorregirDocumento").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Documento Actualizado.",
				showConfirmButton: false,
				timer: 1500
			});
		}
	});
}

function limpiar_formulario() {
	$("#numero_documento_estudiante").val("");
	$("#corregir_cedula").val("");
}
init();