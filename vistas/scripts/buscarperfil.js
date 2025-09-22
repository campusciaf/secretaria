var departamento_global;
var valor_global;
function init() {
	$("#mostrar_formulario_estudiante").hide();
	$("#info_personal_formulario").on("submit", function (e) {
        e.preventDefault();
        editar_personal();
    });
	$.post("../controlador/buscarperfil.php?op=selectDepartamento", function (r) {
		$("#departamento_nacimiento").html(r);
		$("#departamento_nacimiento").selectpicker("refresh");
	});
	$.post("../controlador/buscarperfil.php?op=selectDepartamento", function (r) {
		$("#depar_residencia").html(r);
		$("#depar_residencia").selectpicker("refresh");
	});
	$.post("../controlador/buscarperfil.php?op=selectGenero", function(r){
		$("#genero").html(r);
		$('#genero').selectpicker('refresh');
	});
	$.post("../controlador/buscarperfil.php?op=selectTipo_sangre", function(r){
		$("#tipo_sangre").html(r);
		$('#tipo_sangre').selectpicker('refresh');
	});
	$.post("../controlador/buscarperfil.php?op=selectGrupoEtnico", function(r){
		$("#grupo_etnico").html(r);
		$('#grupo_etnico').selectpicker('refresh');
	});
	$.post("../controlador/buscarperfil.php?op=selectEstado_civil", function(r){
		$("#estado_civil").html(r);
		$('#estado_civil').selectpicker('refresh');
	});
	$("#precarga").hide();
}
init();
function verificarDocumento(id_credencial_seleccionado) {
	var dato = $("#dato_estudiante").val();
    var tipo = $("#tipo").val();
    if (dato != "" && tipo != "") {
		$.post(
			"../controlador/buscarperfil.php?op=verificar",
			{ "dato": dato,"tipo": tipo,"id_credencial_seleccionado": id_credencial_seleccionado },
			function (data) {
				data = JSON.parse(data);
				if (data.exito == 1) {
					$("#mostrar_formulario_estudiante").hide();
					listarEstudiante(data.info.id_credencial);
					
				} else {
					Swal.fire({
						icon: "error",
						title: data.info,
						showConfirmButton: false,
						timer: 1500,
					});
				}
			}
		);
	}else{
		$("#mostrar_formulario_estudiante").hide();
		Swal.fire({
			position: "top-end",
			icon: "error",
			title: "Por favor completa los campos.",
			showConfirmButton: false,
			timer: 1500
		});

    }
}

/**** FUNCIONES PARA GUARDAR EL FORMULARIO DEL ESTUDIANTE ****/
function editar_personal() {
    var formData = new FormData($("#info_personal_formulario")[0]);
	$.ajax({
		type: "POST",
		url: "../controlador/buscarperfil.php?op=editar_personal",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			var r = JSON.parse(datos);
			if (r.status == "ok") {
				$("#ModalMostrarFormulario").modal("hide");
				Swal.fire({
						position: "top-end",
						icon: "success",
						title: "Estudiante Actualizado",
						showConfirmButton: false,
						timer: 1500,
				});
			} else {
				alertify.error(r.status);
			}
		}
	});
}
function mostrarmunicipio(departamento, municipio) {
	$.post(
		"../controlador/buscarperfil.php?op=selectMunicipio",
		{ "departamento": departamento },
		function (datos) {
			$("#municipio_nacimiento_estudiante").html(datos);
			$("#municipio_nacimiento_estudiante").selectpicker("refresh");
			$("#municipio_nacimiento_estudiante").val(municipio);
			$("#municipio_nacimiento_estudiante").selectpicker("refresh");
		}
	);
}
function mostrarmunicipioresidencia(departamento, municipio) {
	$.post(
		"../controlador/buscarperfil.php?op=selectMunicipio",
		{ "departamento": departamento },
		function (datos) {
			$("#municipio").html(datos);
			$("#municipio").selectpicker("refresh");
			$("#municipio").val(municipio);
			$("#municipio").selectpicker("refresh");
		}
	);
}
function filtroportipo(valor) {
    $("#dato_estudiante").prop("disabled", false);
    $("#btnconsulta").prop("disabled", false);
    $("#input_dato_estudiante").show();
    $("#dato_estudiante").val("");
    $("#tipo").val(valor);
	valor_global = valor;
    if(valor == 1){
        $("#valortituloestudiante").html("Ingresar número de identificación")
    }
    if(valor == 2){
        $("#valortituloestudiante").html("Ingresar correo")
    }
    if(valor == 3){
        $("#valortituloestudiante").html("Ingresar número de celular")
    }
    if(valor == 4){
        $("#valortituloestudiante").html("Ingresar nombre")
    }
}

function listarEstudiante(idCredencial) {

	var dato = $("#dato_estudiante").val();
    $("#mostrar_formulario_estudiante").hide();
    var tabla_estudiantes = $("#datos_estudiantes").DataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        "dom": "Bfrtip", //Definimos los elementos del control de tabla
        "buttons": [{
            "extend": "excelHtml5",
            "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
            "titleAttr": "Excel",
            "exportOptions": {
                "columns": ":visible",
            },
        }],
        "ajax": {
            // Modificamos la URL para incluir el ID de la credencial como un parámetro
            "url": "../controlador/buscarperfil.php?op=listar_datos_estudiantes&id_credencial=" + idCredencial+ "&valor_global=" + valor_global+ "&dato=" + dato,
            "type": "get",
            "type": "get",
            "dataType": "json",
            error: function(e) { 
			},
        },
        "bDestroy": true,
        "iDisplayLength": 10, //Paginación
        "order": [[1, "asc"]],
        "initComplete": function(settings, json) {
            $("#precarga").hide();
        }
    });
}

function mostrar_formulario_editar(id_credencial_seleccionado) {
	
	$.post(
		"../controlador/buscarperfil.php?op=mostrar_formulario_editar",
		{ "id_credencial_seleccionado": id_credencial_seleccionado },
		function (data) {
			data = JSON.parse(data);
			if (data.exito == 1) {
					$("#ModalMostrarFormulario").modal("show");
					$("#mostrar_datos_estudiante").html(data.info.conte);
					$(".box_nombre_estudiante").html(data.info.credencial_nombre+" "+data.info.credencial_nombre_2+" "+data.info.credencial_apellido+" "+data.info.credencial_apellido_2);
					$(".box_programa").html(data.info.fo_programa);
					$(".box_programa_idiomas").html(data.info.fo_programa_idiomas);
					$(".box_celular").html(data.info.celular);
					$("#mostrar_datos_estudiante").show();	
					$("#cedula_estudiante").val(data.info.credencial_identificacion);
					$("#expedido_en").val(data.info.expedido_en);
					$("#fecha_expedicion").val(data.info.fecha_expedicion);
					$("#fecha_nacimiento").val(data.info.fecha_nacimiento);
					$("#id_municipio_nac").val(data.info.id_municipio_nac);
					$("#municipio").val(data.info.municipio);
					$("#tipo_residencia").val(data.info.tipo_residencia);
					$("#direccion_residencia").val(data.info.direccion);
					$("#barrio_residencia").val(data.info.barrio);
					$("#telefono").val(data.info.telefono);
					$("#celular").val(data.info.celular);
					$("#codigo_pruebas").val(data.info.codigo_pruebas);
					// Variables para la tabla credencial_estudiante
					$("#credencial_nombre").val(data.info.credencial_nombre);
					$("#credencial_nombre_2").val(data.info.credencial_nombre_2);
					$("#credencial_apellido").val(data.info.credencial_apellido);
					$("#credencial_apellido_2").val(data.info.credencial_apellido_2);
					$("#credencial_login").val(data.info.credencial_login);
					$("#nombre_etnico").val(data.info.nombre_etnico);
					$("#desplazado_violencia").val(data.info.desplazado_violencia);
					$("#conflicto_armado").val(data.info.conflicto_armado);
					$("#depar_residencia").val(data.info.depar_residencia);
					$("#zona_residencia").val(data.info.zona_residencia);
					$("#cod_postal").val(data.info.cod_postal);
					$("#estrato").val(data.info.estrato);
					$("#whatsapp").val(data.info.whatsapp);
					$("#instagram").val(data.info.instagram);
					$("#email").val(data.info.email);
					$(".box_correo_electronico").html(data.info.email);
					$("#fecha_actualizacion").val(data.info.fecha_actualizacion);
					//id oculto para la consulta
					$("#id_credencial_oculto").val(data.info.id_credencial);
					$("#id_credencial_guardar_estudiante").val(data.info.id_credencial);
					$("#lugar_nacimiento_oculto").val(data.info.lugar_nacimiento);
					// select
					$("#tipo_documento").val(data.info.tipo_documento);
					$("#tipo_documento").selectpicker("refresh");
					$("#departamento_nacimiento").val(data.info.departamento_nacimiento);
					$("#departamento_nacimiento").selectpicker("refresh");
					$("#depar_residencia").val(data.info.depar_residencia);
					$("#depar_residencia").selectpicker("refresh");
					$("#genero").val(data.info.genero);
					$("#genero").selectpicker("refresh");
					$("#tipo_sangre").val(data.info.tipo_sangre);
					$("#tipo_sangre").selectpicker("refresh");
					$("#grupo_etnico").val(data.info.grupo_etnico);
					$("#grupo_etnico").selectpicker("refresh");
					$("#estado_civil").val(data.info.estado_civil);
					$("#estado_civil").selectpicker("refresh");
					mostrarmunicipio(data.info.departamento_nacimiento, data.info.lugar_nacimiento);
					mostrarmunicipioresidencia(data.info.depar_residencia, data.info.municipio);
				} else {
					Swal.fire({
						icon: "error",
						title: data.info,
						showConfirmButton: false,
						timer: 1500,
					});
				}
			}
		);
}

function iniciarTour(){
	introJs().setOptions({
		nextLabel: 'Siguiente',
		prevLabel: 'Anterior',
		doneLabel: 'Terminar',
		showBullets:false,
		showProgress:true,
		showStepNumbers:true,
		steps: [ 
			{
				title: 'Gestión perfiles',
				intro: 'Da un vistazo a nuestro modulo donde podrás observar todos nuestros horarios por salones activos'
			},
			{
				title: 'Salón',
				element: document.querySelector('#t-programa'),
				intro: "Aquí podrás encontrar todos nuestros nuestros salones disponibles para que puedas consultar "
			},
		]
			
	},
	).start();

}

