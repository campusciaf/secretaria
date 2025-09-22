var tabla;
//Función que se ejecuta al inicio
function init() {
    aceptoData();
    $("#formulariodata").on("submit", function (e5) {
		guardardata(e5);
	});
    $("#formulariodatos").on("submit", function (e6) {
		editar_guardar_caracter(e6);
	});
}

function aceptoData() {
	$.post(
		"../controlador/egresadoperfil.php?op=aceptoData",{ },
		function (data) {
			data = JSON.parse(data);
			if (data == 2) {
				//no tiene tratamiento de datos
				$("#myModalData").modal("show");
				$("#myModalCaraterizacion").modal("hide");
			} else if (data == 3) {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: "No tiene permisos para ejecutar esta opción.",
					showConfirmButton: false,
					timer: 1500
				});
			} else {
                $("#myModalData").modal("hide");
				listarPreguntas();
			}
		}
	);
}

function guardardata(e5) {
	e5.preventDefault();
	var formData = new FormData($("#formulariodata")[0]);

	$.ajax({
		url: "../controlador/egresadoperfil.php?op=guardardata",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {
			datos = JSON.parse(datos);
			if (datos.estado == "si") {
				Swal.fire({
					icon: "success",
					title: "Datos protegidos",
					showConfirmButton: false,
					timer: 1500
				});
				aceptoData();
			} else {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: "Ocurrió un error al guardar los datos hoy.",
					showConfirmButton: false,
					timer: 1500
				});
			}
		}
	});
}

function listarPreguntas() {
	
	$("#myModalData").modal("hide");
	$("#myModalCaraterizacion").modal("show");
	$.post(
		"../controlador/egresadoperfil.php?op=listarPreguntas",{ },
		function (data) {
			data = JSON.parse(data);
			$("#preguntas").html(data);
			inicializarEventosPreguntasOtro();
			inicializarCamposOtroVisibles();
			$("#precarga").hide();
		}
	);
}

function inicializarEventosPreguntasOtro() {

	toggleCampoOtroSelect('tipo_emprendimiento', '6', '#bloque_tipo_emprendimiento_otro');
	toggleCampoOtroSelect('red_social_activa', '5', '#bloque_nombre_red_social');
	toggleCampoOtroSelect('grupo_etnicos', '11', '#bloque_grupo_etnico_otro');
	toggleCampoOtroSelect('tiene_discapacidad', '1', '#bloque_descripcion_discapacidad');

	 // Evento para el select
    $(document).on('change', '#tipo_emprendimiento', function () {
        toggleCampoOtroSelect('tipo_emprendimiento', '6', '#bloque_tipo_emprendimiento_otro');
    });
	$(document).on('change', '#red_social_activa', function () {
        toggleCampoOtroSelect('red_social_activa', '5', '#bloque_nombre_red_social');
    });
	$(document).on('change', '#grupo_etnicos', function () {
        toggleCampoOtroSelect('grupo_etnicos', '11', '#bloque_grupo_etnico_otro');
    });
	$(document).on('change', '#tiene_discapacidad', function () {
        toggleCampoOtroSelect('tiene_discapacidad', '1', '#bloque_descripcion_discapacidad');
    });
	
	toggleCampoOtro('capacitaciones_complementarias', '7', '#bloque_capacitaciones_otro');
    toggleCampoOtro('habilidades_utiles', '9', '#bloque_habilidades_otro');
	toggleCampoOtro('sugerencias_plan_estudio', '9', '#bloque_sugerencias_otro');
	toggleCampoOtro('formas_conexion', '9', '#bloque_formas_conexion_otro');
	toggleCampoOtro('servicios_utiles', '9', '#bloque_servicios_utiles_otro');
    
    // Y cada vez que cambien los checkbox
	$(document).on('change', 'input[name="capacitaciones_complementarias[]"]', function () {
        toggleCampoOtro('capacitaciones_complementarias', '7', '#bloque_capacitaciones_otro');
    });
	$(document).on('change', 'input[name="tipo_emprendimiento[]"]', function () {
        toggleCampoOtro('tipo_emprendimiento', '6', '#bloque_tipo_emprendimiento_otro');
    });
    $(document).on('change', 'input[name="habilidades_utiles[]"]', function () {
        toggleCampoOtro('habilidades_utiles', '9', '#bloque_habilidades_otro');
    });
	$(document).on('change', 'input[name="sugerencias_plan_estudio[]"]', function () {
        toggleCampoOtro('sugerencias_plan_estudio', '9', '#bloque_sugerencias_otro');
    });
	$(document).on('change', 'input[name="formas_conexion[]"]', function () {
        toggleCampoOtro('formas_conexion', '9', '#bloque_formas_conexion_otro');
    });
	$(document).on('change', 'input[name="servicios_utiles[]"]', function () {
        toggleCampoOtro('servicios_utiles', '9', '#bloque_servicios_utiles_otro');
    });
}

function toggleCampoOtro(nombreCampo, valorOtro, idBloque) {
	
    const selector = `input[name="${nombreCampo}[]"][value="${valorOtro}"]`;
    if ($(selector).length && $(selector).is(':checked')) {
        $(idBloque).show();
    } else {
        $(idBloque).hide();
    }
}

function toggleCampoOtroSelect(idSelect, valorOtro, idBloque) {
	
    const valorSeleccionado = $(`#${idSelect}`).val();
    if (valorSeleccionado === valorOtro) {
        $(idBloque).show();
    } else {
        $(idBloque).hide();
    }
}

function inicializarCamposOtroVisibles() {
	mostrarSiSeleccionado('#tipo_emprendimiento', '6', '#bloque_tipo_emprendimiento_otro');
	mostrarSiSeleccionado('#red_social_activa', '5', '#bloque_nombre_red_social');
	mostrarSiSeleccionado('#grupo_etnicos', '11', '#bloque_grupo_etnico_otro');
	mostrarSiSeleccionado('#tiene_discapacidad', '1', '#bloque_descripcion_discapacidad');


	mostrarSiMarcado('input[name="capacitaciones_complementarias[]"][value="7"]', '#bloque_capacitaciones_otro');
    mostrarSiMarcado('input[name="habilidades_utiles[]"][value="9"]', '#bloque_habilidades_otro');
    mostrarSiMarcado('input[name="sugerencias_plan_estudio[]"][value="9"]', '#bloque_sugerencias_otro');
    mostrarSiMarcado('input[name="formas_conexion[]"][value="9"]', '#bloque_formas_conexion_otro');
    mostrarSiMarcado('input[name="servicios_utiles[]"][value="9"]', '#bloque_servicios_utiles_otro');
}

function mostrarSiSeleccionado(selectorSelect, valorOtro, selectorDiv) {
    if ($(selectorSelect).val() === valorOtro) {
        $(selectorDiv).show();
    } else {
        $(selectorDiv).hide();
    }
}
function mostrarSiMarcado(selectorCheck, selectorDiv) {

    if ($(selectorCheck).is(':checked')) {
        $(selectorDiv).show();
    } else {
        $(selectorDiv).hide();
    }
}


function editar_guardar_caracter(e6) {
	$("#precarga").show();
	e6.preventDefault();
	var formData = new FormData($("#formulariodatos")[0]);

	$.ajax({
		type: "POST",
		url: "../controlador/egresadoperfil.php?op=guardar_editar_caracter",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			datos = JSON.parse(datos);
			console.log(datos)
			if (datos.estado == "si") {
				Swal.fire({
					icon: "success",
					title: "Datos actualizados",
					showConfirmButton: false,
					timer: 1500
				});

				listarPreguntas();
				
			} else {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: "Proceso rechazado!",
					showConfirmButton: false,
					timer: 1500
				});
			}
		}
	});
}



init();