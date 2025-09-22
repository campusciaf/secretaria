var tabla; listadoregistros
//Función que se ejecuta al inicio
function init() {
	listar();
	$("#precarga").show();
	//en caso de que el solicitante no labore, automaticamente se llenara la informacion
	$(".switch-ingresos_labora").off("click").on("click", function (e) {
		e.preventDefault();
		habilitar_otro_ingeso();
	});
	//cuando llenen todos los datos de la solicitud de credito
	$("#formularioCredito").off("submit").on("submit", function (e) {
		e.preventDefault();
		guardarCredito();
	});
	//cuando llenen todos los datos de la solicitud de credito
	$("#formularioModificarTicket").off("submit").on("submit", function (e) {
		e.preventDefault();
		ModificarTicket();
	});
	const prefijosUnicos = [
		"300", "301", "302", "303", "304", "305", "310", "311", "312", "313",
		"314", "315", "316", "317", "318", "319", "320", "321", "322", "323",
		"324", "350", "351", "333"
	];
	$(".representante_menor").hide();
	mostrarDepartamentos();	
	$("#valor_ticket").on("keyup", function () {
		verificarValorMinimoTicket();
	});
	$("#fecha_nacimiento").on("change", function () {
		// tomamos la fecha de nacimiento
		const fecha_nacimiento = new Date($("#fecha_nacimiento").val());
		// creamos una variable con la fecha actual
		const fecha_actual = new Date();
		// calculamos la edad en años
		let edad = fecha_actual.getFullYear() - fecha_nacimiento.getFullYear();
		// ajustamos en caso de que el mes o el día de la fecha aún no ha pasado este año
		if (fecha_actual.getMonth() < fecha_nacimiento.getMonth() || (fecha_actual.getMonth() === fecha_nacimiento.getMonth() && fecha_actual.getDate() < fecha_nacimiento.getDate())) {
			//le restamos 1 en caso de que la condicion se cumpla
			edad--;
		}
		//Si la edad es mayor o igual a 18 mostramos el tratamiento de datos para mayores
		if (edad >= 18) {
			//modificacmos el atributo href para el enlace de tratamientos para mayores
			$(".politicas").attr("href", "https://ciaf.digital/public/web_tratamiento_datos/Tratamiento_de_datos_CIAF_2024.pdf");
			//Escondemos en caso de que este visible los campos del representante legal
			$(".representante_menor").hide(500);
			//removemos el atributo de required a los campos para evitar errores de envio
			$(".input-representante").prop("required", false);
		} else {
			//modificacmos el atributo href para el enlace de tratamientos para menore
			$(".politicas").attr("href", "https://ciaf.digital/public/web_tratamiento_datos/Tratamiento_de_datos_menores_CIAF_2024.pdf");
			//mostramos en caso de que este oculto los campos del representante legal
			$(".representante_menor").show(500);
			//Agregamor el atributo required a los campos para obligarlo a llenar
			$(".input-representante").prop("required", true);
		}
	});
	$("#labora_actualmente").on("click", function () {
		habilitar_otro_ingeso();
	});
	$('#numero_documento').on('input', function () {
		const valor = $(this).val();
		const esInvalido = prefijosUnicos.some(prefijo => valor.startsWith(prefijo));
		if (esInvalido && valor.length == 10) {
			$(this).addClass('is-invalid');
			$(".btn-final").prop("disabled", true);
		} else {
			$(this).removeClass('is-invalid');
			$(".btn-final").prop("disabled", false);
		}
	});
}
// lista en el selectpicker el departamento y municipio de nacimiento
function datosCredito() {
	//console.log(val);
	$.post("../controlador/rematriculafinanciera.php?op=datosCredito", function (datos) {
		var r = JSON.parse(datos);
		console.log(r);
		if(r.exito == 1){
			$("#tipo_documento").val(r.tipo_documento);
			$("#numero_documento").val(r.numero_documento);
			$("#nombres").val(r.nombres);
			$("#apellidos").val(r.apellidos);
			$("#fecha_nacimiento").val(r.fecha_nacimiento);
			$("#genero").val(r.genero);
			$("#estado_civil").val(r.estado_civil);
			$("#numero_hijos").val(r.numero_hijos);
			$("#nivel_educativo").val(r.nivel_educativo);
			$("#nacionalidad").val(r.nacionalidad);
			$("#direccion").val(r.direccion);
			$("#departamento").val(r.departamento);
			$("#ciudad").val(r.ciudad);
			$("#celular").val(r.celular);
			$("#email").val(r.email);
			$("#ocupacion").val(r.ocupacion);
			$("#personas_a_cargo").val(r.personas_a_cargo);
			$("#sector_laboral").val(r.sector_laboral);
			$("#tiempo_servicio").val(r.tiempo_servicio);
			$("#salario").val(r.salario);
			$("#tipo_vivienda").val(r.tipo_vivienda);
			$("#familiarnombre").val(r.familiarnombre);
			$("#familiartelefono").val(r.familiartelefono);
			$("#codeudornombre").val(r.codeudornombre);
			$("#codeudortelefono").val(r.codeudortelefono);
			$("#nombre_completo_acudiente").val(r.nombre_completo_acudiente);
			$("#numero_documento_acudiente").val(r.numero_documento_acudiente);
			$("#fecha_expedicion_acudiente").val(r.fecha_expedicion_acudiente);
			$("#parentesco").val(r.parentesco);
		}
	});
}
// lista en el selectpicker el departamento y municipio de nacimiento
function mostrarDepartamentos() {
	//console.log(val);
	$.post("../controlador/sofi_inscribete.php?op=mostrarDepartamento", function (datos) {
		//console.log(datos);
		var option = '<option value="" selected disabled>-- Selecciona departamento --</option>';
		//console.log(r);
		var r = JSON.parse(datos);
		for (let i = 0; i < r.length; i++) {
			option += '<option value="' + r[i].id_departamento + '">' + r[i].departamento + '</option>';
		}
		$(".departamento").html(option);
	});
}
//listar municipios dependiendo del departamento
function mostrarMunicipios(departamento) {
	$.post("../controlador/sofi_inscribete.php?op=mostrarMunicipios", { "id_departamento": departamento }, function (datos) {
		//console.log(datos);
		var r = JSON.parse(datos);
		var option = '<option value="" selected disabled>-- Selecciona Municipio --</option>';
		for (let i = 0; i < r.length; i++) {
			option += '<option value="' + r[i].municipio + '">' + r[i].municipio + '</option>';
		}
		$(".ciudad").html(option);
	});
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
				"title": 'Rematricula financiera',
				"intro": 'Aquí podras encontrar la manera de renovar tu matricula en tan solo un click'
			},
			{
				"title": ' Renovar Programa',
				"element": document.querySelector('#t-paso1'),
				"intro": "En esta sección se encuentra tu programa y tu semestre a renovar,la jornada y si tu proceso de matricula ha sido aceptado "
			},
			{
				"title": 'Descargar recibo matricula',
				"element": document.querySelector('#t-paso2'),
				"intro": "Lleva el control de tu renovación descargando tu respectivo recibo "
			},
			{
				"title": 'Ver estado de crédito',
				"element": document.querySelector('#t-paso3'),
				"intro": "Descubre sobre tu proceso mirando tu estado de crédito o solicitalo aquí"
			},
			{
				"title": 'Valor pecuniario',
				"element": document.querySelector('#t-paso4'),
				"intro": "Puedes encontrar nuestro precio de aporte social"
			},
			{
				"title": 'matricula ordinaria',
				"element": document.querySelector('#t-paso5'),
				"intro": "Nuestro precio de matricula con una fecha limite sin el aumento"
			},
			{
				"title": 'Pagos en efectivo',
				"element": document.querySelector('#t-paso6'),
				"intro": "Encuentra nuestros diferentes puntos de pago"
			},
			{
				"title": 'Pagos PSE',
				"element": document.querySelector('#t-paso7'),
				"intro": "Tenemos la opción de que realices tu pago seguro en línea"
			},
			{
				"title": 'matricula extra ordinaria',
				"element": document.querySelector('#t-paso8'),
				"intro": "Nuestro precio de matricula con aumento y última fecha limite para hacer tu pago"
			},
		]
	},
	).start();
}
//Función Listar
function verificardocumento(e1) {
	$("#listadomaterias").hide();
	e1.preventDefault();
	var formData = new FormData($("#formularioverificar")[0]);
	$.ajax({
		"url": "../controlador/rematriculafinanciera.php?op=verificardocumento",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			data = JSON.parse(datos);
			var id_credencial = "";
			if (JSON.stringify(data["0"]["1"]) == "false") {// si llega vacio toca matricular
				alertify.error("Estudiante No Existe");
				$("#listadoregistros").hide();
				$("#mostrardatos").hide();
			}
			else {
				id_credencial = data["0"]["0"];
				$("#mostrardatos").show();
				alertify.success("Esta registrado");
				listar(id_credencial);
			}
		}
	});
}
//Función Listar datos
function listar() {
	$.post("../controlador/rematriculafinanciera.php?op=listar", {}, function (data) {
		data = JSON.parse(data);
		$("#listadoregistros").html(data[0]);
		$("#precarga").hide();
	});
}
//abre modal y asigna el credencial y el programa
function abrirModificarTicket(id_ticket, valor_ticket) {
	$("#id_ticket").val(id_ticket);
	$("#valor_ticket").val(valor_ticket);
	$("#modal_modificar_ticket").modal("show");
	verificarValorMinimoTicket()
}
//modifica el ticket
function verificarValorMinimoTicket() {
	var id_ticket = $("#id_ticket").val();
	var valor_ticket = $("#valor_ticket").val();
	$.post("../controlador/rematriculafinanciera.php?op=verificarValorMinimoTicket", { "id_ticket": id_ticket, "valor_ticket": valor_ticket }, function (data) {
		data = JSON.parse(data);
		if (data["exito"] == 1) {
			$(".btn-modificar-ticket").prop("disabled", false);
			$("#valor_ticket").removeClass("is-invalid");
			$("#valor_ticket").addClass("is-valid");
		}else{
			$(".btn-modificar-ticket").prop("disabled", true);
			$("#valor_ticket").addClass("is-invalid");
			$("#valor_ticket").removeClass("is-valid");
			$(".feedback-ticket").html(data["info"]);
		}
	});
}
//abre modal y asigna el credencial y el programa
function mostrarModalCredito(id_programa, id_credencial) {
	$("#id_programa").val(id_programa);
	$("#id_credencial").val(id_credencial);
	$("#modal_solicitud_credito").modal("show");
	datosCredito();
}
//modifica los input, dependiendo de la seleccion de laburacion
function habilitar_otro_ingeso() {
	if ($("#ingresos_labora").is(":checked")) {
		$(".input-ingresos_labora").prop("readonly", true);
		$("#ingresos_labora_off").prop('checked', true);
		$("#ingresos_labora").prop('checked', false);
		$("#empresa_laboral").val("No Aplica");
		$("#direccion_empresa").val("No Aplica");
		$("#telefono_empresa").val("0");
		$("#cargo_trabajo").val("No Aplica");
		$("#tiempo_servicio").val("No Aplica");
		$("#salario").val("0");
		$("#ing_arriendos").val("0");
		$("#ing_pensiones").val("0");
		$("#ing_empresas").val("0");
		$("#ing_dir_empresa").val("No Aplica");
		$("#ing_tel_empresa").val("0");
		$("#ing_neg_propio").val("0");
		$("#ing_dir_neg_propio").val("No Aplica");
		$("#ing_tel_neg_propio").val("0");
	} else if ($("#ingresos_labora_off").is(":checked")) {
		$(".input-ingresos_labora").prop("readonly", false);
		$("#ingresos_labora_off").prop('checked', false);
		$("#ingresos_labora").prop('checked', true);
		$("#empresa_laboral").val("");
		$("#direccion_empresa").val("");
		$("#telefono_empresa").val("");
		$("#cargo_trabajo").val("");
		$("#tiempo_servicio").val("");
		$("#salario").val("");
		$("#ing_arriendos").val("0");
		$("#ing_pensiones").val("0");
		$("#ing_empresas").val("0");
		$("#ing_dir_empresa").val("No Aplica");
		$("#ing_tel_empresa").val("0");
		$("#ing_neg_propio").val("0");
		$("#ing_dir_neg_propio").val("No Aplica");
		$("#ing_tel_neg_propio").val("0");
	}
}
//guadar credito
function guardarCredito() {
	var formData = new FormData($("#formularioCredito")[0]);
	$(".btn-final").prop("disabled", true);
	$.ajax({
		"url": "../controlador/rematriculafinanciera.php?op=guardarCredito",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			datos = JSON.parse(datos);
			if (datos.estatus == 1) {
				listar();
				alertify.success("Completado");
				$("#modal_solicitud_credito").modal("hide");
			} else {
				alertify.error(datos.info);
			}
		}
	});
}
//guadar credito
function ModificarTicket() {
	var formData = new FormData($("#formularioModificarTicket")[0]);
	$(".btn-modificar-ticket").prop("disabled", true);
	$.ajax({
		"url": "../controlador/rematriculafinanciera.php?op=ModificarTicket",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			datos = JSON.parse(datos);
			if (datos.exito == 1) {
				listar();
				alertify.success("Completado");
				$("#modal_modificar_ticket").modal("hide");
			} else {
				alertify.error(datos.info);
			}
		}
	});
}
//descarga el recibo
function descargarrecibo(id_estudiante) {
	$.post("../controlador/rematriculafinanciera.php?op=descargarrecibo", { id_estudiante: id_estudiante },
		function (data) {
			data = JSON.parse(data);
			$("#verrecibo").modal("show");
			$("#datosrecibo").html("");
			$("#datosrecibo").append(data["0"]["0"]);
		}
	);
}
//imprimir historial
function imprSelec(historial) {
	var ficha = document.getElementById(historial);
	var ventimp = window.open(' ', 'popimpr');
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
}
function nuevoNivel(nuevoid, est, pac, cic) {
	Swal.fire({
		"title": "Vamos a solicitar la nueva matrícula?",
		"showCancelButton": true,
		"confirmButtonText": "Continuar",
		"showCancelText": "Cancelar",
	}).then((result) => {
		if (result.isConfirmed) {
			$.post(
				"../controlador/rematriculafinanciera.php?op=nuevonivel", { nuevoid: nuevoid, est: est, pac: pac, cic: cic },
				function (data) {
					data = JSON.parse(data);
					if (data["0"]["0"] == "ok") {
						listar();
						Swal.fire("Creado!", "", "success");
					}
					else if (data["0"]["0"] == "perdio") {
						Swal.fire({
							"position": "top-end",
							"icon": "warning",
							"title": "No puede renovar por el momento",
							"showConfirmButton": false,
							"timer": 1500
						});
					}
					else {
						Swal.fire({
							"position": "top-end",
							"icon": "warning",
							"title": "Your work has been saved",
							"showConfirmButton": false,
							"timer": 1500
						});
					}
				}
			);
		} else if (result.isDenied) {
			Swal.fire("Changes are not saved", "", "info");
		}
	});
}
// Función para rellenar los datos de ingresos cuando no tienen
function habilitar_otro_ingeso() {
	if (!$("#labora_actualmente").is(":checked")) {
		$(".input-ingresos_labora").prop("readonly", true);
		$("#tiempo_servicio").val("No Aplica");
		$("#sector_laboral").val("No Aplica");
		$("#salario").val("0");
	} else {
		$(".input-ingresos_labora").prop("readonly", false);
		$("#sector_laboral").val("");
		$("#tiempo_servicio").val("");
		$("#salario").val("");
	}
}
init();