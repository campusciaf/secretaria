
var usuario_identificacion = "";
var identificacion_global;
//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	$("#listadoregistros").hide();
	$("#agregar_docente").hide();
	$("#editar_docente").hide();
	$("#mostrar_formulario_crear_docente").hide();
	$("#activar_boton_crear_docente").hide();
	$("#formularioverificar").on("submit", function (e1) {
		verificardocumento(e1);
		$("#formulario_vista").show();
	});
	$("#imagenmuestra").hide();
	//Cargamos los items de los selects
	$.post("../controlador/nuevo_docente.php?op=selectTipoDocumento", function (r) {
		$("#crear_usuario_tipo_documento").html(r);
		$('#crear_usuario_tipo_documento').selectpicker('refresh');
	});
	//Cargamos los items de los selects
	$.post("../controlador/nuevo_docente.php?op=selectTipoSangre", function (r) {
		$("#crear_usuario_tipo_sangre").html(r);
		$('#crear_usuario_tipo_sangre').selectpicker('refresh');
	});
	//Cargamos los items de los selects contrato
	$.post("../controlador/nuevo_docente.php?op=selectTipoContrato", function (r) {
		$("#crear_usuario_tipo_contrato").html(r);
		$('#crear_usuario_tipo_contrato').selectpicker('refresh');
	});
	//Cargamos los items al select ejes
	$.post("../controlador/nuevo_docente.php?op=selectDepartamento", function (r) {
		$("#crear_usuario_departamento_nacimiento").html(r);
		$('#crear_usuario_departamento_nacimiento').selectpicker('refresh');
	});
	$.post("../controlador/nuevo_docente.php?op=selectMunicipio", function (r) {
		$("#crear_usuario_municipio_nacimiento").html(r);
		$('#crear_usuario_municipio_nacimiento').selectpicker('refresh');
	});
	$.post("../controlador/nuevo_docente.php?op=selectListaEstadoCivil", function (r) {
		$("#crear_usuario_estado_civil").html(r);
		$('#crear_usuario_estado_civil').selectpicker('refresh');
	});
	$.post("../controlador/nuevo_docente.php?op=selectListaGenero", function (r) {
		$("#usuario_genero").html(r);
		$('#usuario_genero').selectpicker('refresh');
	});
	$("#formulario_crear_docente").on("submit", function (e) {
		guardar_docente(e);
	});
}
function guardar_docente(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	// $("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario_crear_docente")[0]);
	$.ajax({
		"url": "../controlador/nuevo_docente.php?op=creadocentenuevo",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			datos = JSON.parse(datos);
			if(datos.exito == 1 ){
				mostrar_documentos_obligatorios(usuario_identificacion);
				$("#mostrar_formulario_crear_docente").hide();
				alertify.success(datos.info);
			}else{
				alertify.error(datos.info);
			}
		}
	});
	// limpiar();
}
//Función Listar los docentes 
function verificardocumento(e1) {
    var tipo = $("#tipo").val();
	$("#listadomaterias").hide();
	$("#mostrar_formulario_crear_docente").hide();
	e1.preventDefault();
	var formData = new FormData($("#formularioverificar")[0]);
	formData.append("tipo", tipo);
	$.ajax({
		"url": "../controlador/nuevo_docente.php?op=verificardocumento",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			limpiar();
			data = JSON.parse(datos);
			// si llega vacio toca matricular
			if (data.exito == 0) {
				alertify.error("Docente no se puede crear <br> No tiene hoja de vida");
				$("#formulario_vista").hide();
			}else{
				usuario_identificacion = data.info;
				$("#mostrar_formulario_crear_docente").hide();
				mostrardatos(usuario_identificacion);
				alertify.success("Docente tiene hoja de vida");
				consultardocentenuevo(usuario_identificacion);
				mostrar_documentos_obligatorios(usuario_identificacion);
			}
		}
	});
}
function consultardocentenuevo() {
	$.post("../controlador/nuevo_docente.php?op=consultardocentenuevo&usuario_identificacion=" + usuario_identificacion, function (data) {
		data = JSON.parse(data);
		// si llega vacio toca matricular
		if (data.exito == 0) {
			// alert(usuario_identificacion);
			var usuario_nombre = $("#mostrar_usuario_nombre").val();
			usuario_nombre1 = usuario_nombre.split(" ");
			$("#crear_usuario_nombre").val(usuario_nombre1[0]);
			var usuario_nombre_2 = $("#mostrar_usuario_nombre").val();
			array_nombre_completo = usuario_nombre_2.split(" ");
			tamano_array = array_nombre_completo.length;
			if (tamano_array == 2) {
				$("#crear_usuario_nombre_2").val(array_nombre_completo[1]);
			} else {
				for (let index = 1; index < tamano_array; index++) {
					if (array_nombre_completo[index] != "") {
						$("#crear_usuario_nombre_2").val(array_nombre_completo[index]);
						break;
					}
				}
			}
			var usuario_apellido = $("#mostrar_usuario_apellido").val();
			usuario_apellido1 = usuario_apellido.split(" ");
			$("#crear_usuario_apellido").val(usuario_apellido1[0]);
			var usuario_apellido2 = $("#mostrar_usuario_apellido").val();
			usuario_apellido2 = usuario_apellido2.split(" ");
			$("#crear_usuario_apellido_2").val(usuario_apellido2[1]);
			var usuario_apellido2 = $("#mostrar_usuario_apellido").val();
			array_nombre_completo = usuario_apellido2.split(" ");
			tamano_array = array_nombre_completo.length;
			if (tamano_array == 2) {
				$("#crear_usuario_apellido_2").val(array_nombre_completo[1]);
			} else {
				for (let index = 1; index < tamano_array; index++) {
					if (array_nombre_completo[index] != "") {
						$("#crear_usuario_apellido_2").val(array_nombre_completo[index]);
						break;
					}
				}
			}
			var usuario_identificacion = $("#mostrar_usuario_identificacion_docente").val();
			$("#crear_usuario_identificacion").val(usuario_identificacion);
			var usuario_fecha_nacimiento = $("#mostrar_usuario_fecha_nacimiento").val();
			$("#crear_usuario_fecha_nacimiento").val(usuario_fecha_nacimiento);
			var direccion = $("#mostrar_usuario_direccion_docente").val();
			$("#crear_usuario_direccion").val(direccion);
			var telefono = $("#mostrar_usuario_celular_docente").val();
			$("#crear_usuario_celular").val(telefono);
			var usuario_email = $("#mostrar_usuario_email_p").val();
			$("#crear_usuario_email_p").val(usuario_email);
			$("#mostrar_formulario_crear_docente").show();
			$("#agregar_docente").show();
			alertify.error("Docente No esta en el campus");
			$("#activar_boton_crear_docente").hide();
		} else {
			$("#activar_boton_crear_docente").hide();
			usuario_identificacion = data.info;
			alertify.success("Docente ya se encuentra en el campus");
			$("#agregar_docente").hide();
			// $("#activar_boton_crear_docente").hide();
		}
	});
}
// muestra los datos de los docentes
function mostrardatos(usuario_identificacion) {
	$.post("../controlador/nuevo_docente.php?op=mostrar_datos_docente", { usuario_identificacion: usuario_identificacion }, function (data, status) {
		data = JSON.parse(data);
		$("#mostrar_usuario_nombre").val(data.usuario_nombre);
		// $("#usuario_nombre_2").val(data.usuario_nombre_2);
		$("#mostrar_usuario_apellido").val(data.usuario_apellido);
		// $("#usuario_apellido_2").val(data.usuario_apellido_2);
		$("#mostrar_usuario_identificacion_docente").val(data.usuario_identificacion);
		$("#verificacion_documento").val(data.usuario_identificacion);
		$("#mostrar_usuario_fecha_nacimiento").val(data.fecha_nacimiento);
		$("#mostrar_usuario_email_ciaf").val(data.usuario_email_ciaf);
		$("#mostrar_usuario_email_p").val(data.usuario_email);
		$("#mostrar_usuario_celular_docente").val(data.telefono);
		// $("#usuario_telefono_docente_h").val(data.telefono);
		$("#mostrar_usuario_direccion_docente").val(data.direccion);
		$("#mostrar_usuario_tipo_documento").val(data.usuario_tipo_documento);
		$("#mostrar_usuario_tipo_documento").selectpicker('refresh');
		$("#mostrar_usuario_departamento_nacimiento").val(data.departamento);
		// $("#usuario_departamento_nacimiento").selectpicker('refresh');
		$("#usuario_municipio_nacimiento_docente").val(data.ciudad);
		$("#usuario_municipio_nacimiento_docente").selectpicker('refresh');
		$("#usuario_tipo_contrato").val(data.usuario_tipo_contrato);
		$("#usuario_tipo_contrato").selectpicker('refresh');
		$("#usuario_tipo_sangre").val(data.usuario_tipo_sangre);
		$("#usuario_tipo_sangre").selectpicker('refresh');
		$("#usuario_estado_civil").val(data.estado_civil);
		$("#usuario_estado_civil").selectpicker('refresh');
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src", "../cv/files/docentes/" + data.usuario_imagen);
		$("#imagenactual").val(data.usuario_imagen);
		$("#id_usuario").val(data.id_usuario);
	});
}
//Función limpiar
function limpiar() {
	$("#id_usuario").val("");
	$("#usuario_tipo_documento").val("");
	$("#usuario_tipo_documento").selectpicker('refresh');
	$("#usuario_identificacion_docente").val("");
	$("#usuario_nombre").val("");
	$("#usuario_nombre_2").val("");
	$("#usuario_apellido").val("");
	$("#usuario_apellido_2").val("");
	$("#usuario_fecha_nacimiento").val("");
	$("#usuario_departamento_nacimiento").val("");
	$("#usuario_departamento_nacimiento").selectpicker('refresh');
	$("#usuario_municipio_nacimiento_docente").val("");
	$("#usuario_municipio_nacimiento_docente").selectpicker('refresh');
	$("#usuario_direccion_docente").val("");
	$("#usuario_tipo_contrato").val("");
	$("#usuario_tipo_contrato").selectpicker('refresh');
	$("#usuario_tipo_sangre").val("");
	$("#usuario_tipo_sangre").selectpicker('refresh');
	$("#usuario_telefono_docente_h").val("");
	$("#usuario_celular_docente").val("");
	$("#usuario_email_p").val("");
	$("#usuario_estado_civil").val("");
	$("#usuario_estado_civil").selectpicker('refresh');
	$("#usuario_email_ciaf").val("");
	$("#imagenmuestra").attr("src", " ");
	$("#imagenactual").val("");
}
//Función mostrar formulario
function mostrarform(flag) {
	if (flag) {
		$("#formulario_vista").show();
	}else {
		$("#formulario_vista").hide();
	}
}
//Función cancelarform
function cancelarform() {
	limpiar();
	verificardocumento(false);
}
function mostrar_documentos_obligatorios() {
	$.post(
		"../controlador/nuevo_docente.php?op=mostrar_documentos_obligatorios",{ usuario_identificacion: usuario_identificacion },function (data) {
            var r = JSON.parse(data);
            $("#mostrar_documentos_obligatorios").html(r);
			$("#mostrar_documentos_obligatorios").show();
			$("#documentosobligatorios").dataTable({
                dom: "Bfrtip",
                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
				"iDisplayLength": 15,
            });
		});
}
function muestra(valor) {
	$( "#btnconsulta" ).prop( "disabled", false );
	$("#input_dato").show();
	$("#tipo").val(valor);
	if(valor==1){
		$("#valortitulo").html("Ingresar número de identificacíon")
		$("#usuario_identificacion").val("");
	}
	if(valor==2){
		$("#valortitulo").html("Ingresar número de tel/cel")
		$("#usuario_identificacion").val("");
	}
}


init();