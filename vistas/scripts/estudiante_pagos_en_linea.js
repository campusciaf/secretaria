var tabla, global_id_encrypt;
//Función que se ejecuta al inicio
function init() {
	listarCuotaActual();
	listar();
	$("#precarga").hide();
	$("#factura_de_pago").hide();

}
//Función Listar
function listar() {
	$.post("../controlador/estudiante_pagos_en_linea.php?op=listar", function (e) {
		try{
			data = JSON.parse(e);
			if(data.exito == 1){
				$("#tipos_pagos_en_linea").html(data.info);
			}
		}catch(error){
			Swal.fire({
				"icon": "error", "title": "Error al traer Información, comunicaté con el area de desarrollo", "showConfirmButton": false, "timer": 1500,
			});
		}
	});
}
function generarFacturaPago(id_encrypt) {
	global_id_encrypt = id_encrypt;
	$("#precarga").show();
	$("#factura_de_pago").show();
	$("#tipos_pagos_en_linea").hide();
	$.post("../controlador/estudiante_pagos_en_linea.php?op=generarFacturaPago", { "id_encrypt": id_encrypt, "cantidad_semestres": $("#cantidad_semestres").val()}, function (e) {
		//console.log(e)
		try {
			data = JSON.parse(e);
			if (data.exito == 1) {
				$(".nombre_pago_en_linea").html(data.nombre_pago_en_linea);
				$(".numero_documento").html(data.numero_documento);
				$(".nombre_completo").html(data.nombre_completo);
				$(".celular_estudiante").html(data.celular_estudiante);
				$(".valor_transaccion").html(data.valor_transaccion);
				$(".botones_pago").html(data.botones_pago);
				if (data.requiere_cantidad == 1){
					$("#cantidad_semestres").attr("required", true);
					$("#cantidad_semestres").attr("disabled", false);
				}else{
					$("#cantidad_semestres").attr("required", false);
					$("#cantidad_semestres").attr("disabled", true);
				}
			}
			$("#precarga").hide();
		} catch (error) {
			Swal.fire({
				"icon": "error", "title": "Error al imprimir la factura, comunicaté con el area de desarrollo", "showConfirmButton": false, "timer": 1500,
			});
		}
	});
}
function volverTiposPagosEnLinea() {
	$("#factura_de_pago").hide();
	$("#tipos_pagos_en_linea").show();
	$("#cantidad_semestres").val(1);
}
function calcularNuevaCantidad(){
	generarFacturaPago(global_id_encrypt);
}
//funcion para listar la cuota actual
function listarCuotaActual() {
	$.ajax({
		"url": "../controlador/estudiante_pagos_en_linea.php?op=listarCuotaActual",
		"type": "POST",
		"success": function (datos) {
			console.log(datos);
			//esconde la precarga
			datos = JSON.parse(datos);
			if (datos.exito == 1) {
				$("#listadoCuotasActuales").html(datos.html);
				$(".div_otro_valor").hide();
			} else {
				alertify.error(datos.html);
			}
		}
	});
}
init();