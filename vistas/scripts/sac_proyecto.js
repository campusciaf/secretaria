var tabla;
var seleccion_global;
var id_meta_global;
var id_proyecto_global;
var globalperidioseleccionado;
// var tabla_acciones;
// var tabla_ver_plan;

//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar_ejes();
	$("#ver_proyectos").hide();
	$("#ver_tareas_tabla").hide();
	$("#ver_metas").hide();
	$("#btnvolvergrafica").hide();
	$("#ver_acciones").hide();
	$("#ver_tareas").hide();
	$("#ver_total_metas_cumplidas").hide();
	$("#ocultargestionproyecto").hide();
	$("#ocultargestionproyecto2").hide();
	$("#ocultarmetas").hide();
	$("#ocultarmetas2").hide();
	$("#ver_tabla_proyecto_acciones").hide();
	$("#ver_tabla_tareas_mostrar").hide();

	//formulario que edita y guarda la meta
	$("#formularioguardometa").on("submit", function (e) {
		guardaryeditometa(e);
	});
	//se guarda y edita el proyecto
	$("#formularioproyecto").on("submit", function (e) {
		guardaryeditarproyecto(e);
	})

	$("#formularioaccion").on("submit", function (e) {
		guardaryeditaraccion(e);
	});

	//listamos el cargo en el html
	$.post("../controlador/sac_proyecto.php?op=selectListarCargo", function (r) {
		$("#meta_responsable").html(r);
		$('#meta_responsable').selectpicker('refresh');
	});
	//listamos las condiciones institucionales en el html
	$.post("../controlador/sac_proyecto.php?op=condiciones_institucionales", function (r) {
		$(".box_condiciones_institucionales").html(r);
	});

	//listamos las dependencias en el html
	$.post("../controlador/sac_proyecto.php?op=dependencias", function (r) {
		$("#dependencias").html(r);
	});

	//listamos las condiciones de programa en el html
	$.post("../controlador/sac_proyecto.php?op=condiciones_programa&id=", function (r) {
		$("#condiciones_programa").html(r);
	});

	$.post("../controlador/sac_proyecto.php?op=selectListarResponsableTrea", function (r) {
		$("#responsable_tarea").html(r);
		$('#responsable_tarea').selectpicker('refresh');
	});
	$.post("../controlador/sac_proyecto.php?op=selectlistaranios", function (respuesta) {
        $("#periodo_sac").html(respuesta);
        $('#periodo_sac').selectpicker('refresh');
    });
	$("#formulariocreartarea").on("submit",function(e){
	guardaryeditartarea(e);	
	});


	//listamos el cargo en el html
	// $.post("../controlador/sac_proyecto.php?op=selectListarTiposIndicadores", function (r) {
	// 	$("#indicador").html(r);
	// 	$('#indicador').selectpicker('refresh');
	// });

	// $(document).on('change', '#indicador', function () {
	// 	var seleccion = $(this).val();
	// 	mostrarElementosSegunSeleccion(seleccion);
	// });

}

//Función mostrar formulario
function mostrarformmeta(flag) {
	if (flag) {
		// $("#resultadometas").hide();
		$("#formularioguardometa").show();
		$("#btnGuardometa").prop("disabled", false);
		$("#btnAgregarMeta").hide();

	} else {
		// $("#resultadometas").show();
		$("#formularioguardometa").hide();
		$("#btnAgregarMeta").show();
	}
}

//Función para ver el proyecto 
function volver_panel() {

	$("#listar_ejes").show();
	$("#ver_plan").hide();
	$("#ver_tareas_tabla").hide();
	$("#ver_plan_proyecto").hide();
	$("#ver_total_metas_cumplidas").hide();
	$("#ver_tabla_proyecto_acciones").hide();
	$("#ver_tabla_tareas_mostrar").hide();
	$("#ocultartareastabla").hide();
	$("#ocultar_anio_meta").show();



	$("#ocultarpanelanio").show();
		$("#seleccionar_periodo").show();

}

function volver_panel_acciones() {

	// $("#listar_ejes").show();
	$("#ver_tabla_proyecto").hide();
	$("#ver_tabla_proyecto_acciones").show();
	$("#ver_plan").hide();
	$("#ver_total_metas_cumplidas").hide();
	$("#ocultaracciones").hide();
	$("#ocultaracciones2").hide();

}

function ver_plan() {
    $("#ocultar_anio_meta").hide();
    $("#precarga").show();
    $.post("../controlador/sac_proyecto.php?op=ver_plan", {"globalperidioseleccionado": globalperidioseleccionado}, function (data) {
        data = JSON.parse(data);
        $("#listar_ejes").hide();
        $("#ver_plan").show();
        $("#ver_plan").html(data);
		$("#ocultarpanelanio").hide();
		$("#seleccionar_periodo").hide();
        $("#precarga").hide();
    });
}



// function ver_plan() {
// 	$("#ocultar_anio_meta").hide();
// 	$("#precarga").show();

// 	periodoSeleccionado = $("#periodo_sac").val();


// 	$.post("../controlador/sac_proyecto.php?op=ver_plan", {"periodoSeleccionado": periodoSeleccionado}, function (data) {
	
// 		data = JSON.parse(data);
// 		$("#listar_ejes").hide();
// 		$("#ver_plan").show();
// 		$("#ver_plan").html(data);
// 		$("#precarga").hide();
// 	});
// }
function ver_plan_proyecto() {
	$("#precarga").show();
	$.post("../controlador/sac_proyecto.php?op=ver_plan_proyecto", {"globalperidioseleccionado": globalperidioseleccionado}, function (data) {

		data = JSON.parse(data);
		$("#listar_ejes").hide();
		$("#ocultar_anio_meta").hide();
		$("#ver_plan_proyecto").show();
		$("#ver_plan_proyecto").html(data);

		$("#ocultarpanelanio").hide();
		$("#seleccionar_periodo").hide();

		$("#precarga").hide();
	});
}

//Función para ver el proyecto 
function ver_plan_metas() {
	$("#precarga").show();
	$.post("../controlador/sac_proyecto.php?op=ver_plan_metas", {"globalperidioseleccionado": globalperidioseleccionado}, function (data) {

		data = JSON.parse(data);
		$("#listar_ejes").hide();
		$("#ocultar_anio_meta").hide();
		$("#ver_plan_proyecto").show();
		$("#ver_plan_proyecto").html(data);
		$("#precarga").hide();

		$("#ocultarpanelanio").hide();
		$("#seleccionar_periodo").hide();
	});
}

//Función para ver el proyecto 
function ver_plan_accion() {
	$("#precarga").show();
	$.post("../controlador/sac_proyecto.php?op=ver_plan_accion", {"globalperidioseleccionado": globalperidioseleccionado}, function (data) {

		data = JSON.parse(data);
		$("#listar_ejes").hide();
		$("#ocultar_anio_meta").hide();
		$("#ver_tabla_proyecto_acciones").show();
		$("#ver_tabla_proyecto_acciones").html(data);
		$("#precarga").hide();
		$("#ocultarpanelanio").hide();
		$("#seleccionar_periodo").hide();
	});
}

//Función para ver las tareas cumplidas y las vencidas. 
// function ver_plan_tareas() {
// 	$("#precarga").show();
// 	$.post("../controlador/sac_proyecto.php?op=ver_plan_tareas", {"globalperidioseleccionado": globalperidioseleccionado}, function (data) {

// 		data = JSON.parse(data);
// 		$("#listar_ejes").hide();
// 		$("#ocultar_anio_meta").hide();
// 		$("#ver_tabla_tareas").show();
// 		$("#ver_tabla_tareas").html(data);
// 		$("#precarga").hide();
// 		$("#ocultarpanelanio").hide();
// 		$("#seleccionar_periodo").hide();
// 	});
// }
function ver_plan_tareas() {
	$("#precarga").hide();
	$("#listar_ejes").hide();
	$("#ocultar_anio_meta").hide();
	$("#ver_tareas_tabla").show();
	$("#ocultarpanelanio").hide();
	$("#seleccionar_periodo").hide();
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistadotareas').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Print'
			},
		],
		"ajax": {
			url: '../controlador/sac_proyecto.php?op=ver_plan_tareas&globalperidioseleccionado=' + globalperidioseleccionado, type: "get", dataType: "json",
			error: function (e) {
				// console.log(e);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [[0, "asc"]],
		'initComplete': function (settings, json) {
			$("#totalCumplidas").text(json.totalCumplidasTarea);
			$("#totalNoCumplidas").text(json.totalNoCumplidasTarea);
			$("#precarga").hide();
			scroll(0, 0);
		},
	});
}
//Función para ver el proyecto 
function acciones_por_vencer() {
	$("#precarga").show();
	$.post("../controlador/sac_proyecto.php?op=acciones_por_vencer", {"globalperidioseleccionado": globalperidioseleccionado}, function (data) {

		data = JSON.parse(data);
		$("#listar_ejes").hide();
		$("#ver_plan_proyecto").show();
		$("#ver_total_metas_cumplidas").hide();
		$("#ver_tabla_proyecto_acciones").hide();
		$("#ver_tabla_tareas_mostrar").hide();
		$("#ver_plan_proyecto").html(data);
		$("#precarga").hide();
	});
}

//Función para ver el total de las metas
function ver_total_metas_cumplidas() {
	$("#precarga").show();
	$.post("../controlador/sac_proyecto.php?op=ver_total_metas_cumplidas", {"globalperidioseleccionado": globalperidioseleccionado}, function (data) {

		data = JSON.parse(data);
		$("#listar_ejes").hide();
		$("#ver_plan_proyecto").hide();
		// $("#ver_total_metas_cumplidas").show();
		$("#ver_total_metas_cumplidas").html(data);
		ver_total_metas_cumplidas_grafico();
		$("#btnvolvergrafica").show();
		$("#precarga").hide();
		$("#grafico2").show();
		$("#vergrafica").show();
		$("#mostrargrafica").show();
		$("#vergrafica").show();
		$("#ocultargraficametas").show();
		$("#ocultargraficametas2").show();
	});
}



//Función lista los ejes estrategicos  
function listar_ejes() {

	const anioActual = new Date().getFullYear().toString();
    let periodoSeleccionado = $("#periodo_sac").val();
    if (!periodoSeleccionado || periodoSeleccionado === null) {
        periodoSeleccionado = anioActual;
        $("#periodo_sac").val(anioActual);
        $('#periodo_sac').selectpicker('refresh');
    }
	globalperidioseleccionado = periodoSeleccionado;
	$("#dato_periodo").html(periodoSeleccionado);
	$("#precarga").show();
	$.post("../controlador/sac_proyecto.php?op=listar_ejes", {"periodoSeleccionado": periodoSeleccionado}, function (data) {
		data = JSON.parse(data);
		$("#listar_ejes").show();
		$("#ver_plan").hide();
		$("#titulo_metas").hide();
		$("#titulo_acciones").hide();
		$("#slash").hide();
		$("#precarga").hide();
		$("#listar_ejes").html(data);
		mostrargraficosmeta(1);
		mostrargraficosmeta(2);
		mostrargraficosmeta(3);
		mostrargraficosmeta(4);
	});
}

//Funcion para mostrar la meta por el id de proyecto
function mostrarMeta(id_proyecto) {

	$("#myModalMeta").modal("show");
	// $("#indicadores_formula").show();
	$("#formularioguardometa")[0].reset();
	$(".id_proyecto").val(id_proyecto);


	// $("#indicadores_sin_formula").hide();
	// $("#indicadores_con_formula").hide();
	limpiar();

}

//Función para listar las metas por proyecto 
function listar_meta(id_proyecto) {
	id_proyecto_global = id_proyecto;

	$.post("../controlador/sac_proyecto.php?op=listar_meta", { "id_proyecto": id_proyecto }, function (data) {

		data = JSON.parse(data);
		$("#myModalNombreMetaUsuario").modal("show");
		$(".id_meta").html(data);
		$("#formularioguardometa")[0].reset();
		refrescartabla();
		$("#ver_total_metas_cumplidas").hide();
		$("#ver_plan").hide();
		$("#ver_plan_proyecto").hide();

		// $('#historico_indicadores').show();
		// $("#tabla_indicadores").hide();

	});
}

//Función para mostrar nombre de la meta 
function nombre_accion(id_meta) {
	$.post("../controlador/sac_proyecto.php?op=nombre_accion", { "id_meta": id_meta }, function (data) {
		data = JSON.parse(data);
		$("#myModalNombreAccionUsuario").modal("show");
		$(".id_meta").html(data);
	});
}

//Función guardo y edito el nombre del proyecto
function guardaryeditarproyecto(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarProyecto").prop("disabled", true);
	var formData = new FormData($("#formularioproyecto")[0]);
	$.ajax({
		"url": "../controlador/sac_proyecto.php?op=guardaryeditarproyecto",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Proyecto Actualizado",
				showConfirmButton: false,
				timer: 1500
			});
			$('#tbllistadometas').DataTable().ajax.reload();
			$("#nombre_proyecto").val("");
			$("#id_proyecto").val("");
			$("#ModalCrearProyecto").modal("hide");
			$("#btnGuardarProyecto").prop("disabled", false);

		}
	});
}

//se edita el nombre del proyecto
function mostrar_proyecto(id_proyecto) {

	$("#ModalCrearProyecto").modal("show");
	$.post("../controlador/sac_proyecto.php?op=mostrar_proyecto", { "id_proyecto": id_proyecto }, function (data) {
		data = JSON.parse(data);
		if (Object.keys(data).length > 0) {
			$("#nombre_proyecto").val(data.nombre_proyecto);
			$("#id_proyecto").val(data.id_proyecto);
		}
	});
}

//Función limpiar la meta responsable
function limpiar() {
	$("#meta_responsable").val("");
	$("#meta_responsable").change();
	// $("#indicador").val("");
	// $("#indicador").change();

}

//se edita la meta 
function listar_marcadas_meta(id_meta) {
	id_meta_global = id_meta;
	// $("#myModalNombreMetaUsuario").modal("show");
	$.post("../controlador/sac_proyecto.php?op=listar_marcadas_meta", { "id_meta": id_meta }, function (data) {
		data = JSON.parse(data);
		if (Object.keys(data).length > 0) {
			$("#myModalMeta").modal("show");
			$("#myModalNombreMetaUsuario").modal("hide");
			$(".id_meta").val(data.id_meta);
			$("#meta_nombre").val(data.meta_nombre);
			$("#meta_fecha").val(data.meta_fecha);
			$("#nombre_indicador").val(data.nombre_indicador);
			
			$("#anio_eje").val(data.anio_eje);
			$("#anio_eje").selectpicker('refresh');
			$("#porcentaje_avance_indicador").val(data.porcentaje_avance);

			$("#plan_mejoramiento").val(data.plan_mejoramiento);
			// $("input[name=meta_lograda][value=" + data.estado_meta + "]").prop('checked', true);
			// $("input[name=meta_lograda]").parent().removeClass("active");
			// $("input[name=meta_lograda][value=" + data.estado_meta + "]").parent().addClass("active");
			// var resultado = ((data.puntaje_actual - data.puntaje_anterior) / data.puntaje_anterior) * 100;
			// $(".mostrar_calculo").html(resultado);
			// var resultado_participa = (data.participa / data.poblacion) * 100;
			// $(".mostrar_calculo_participa").html(resultado_participa);
			// $("input[name=indicador_formula_o_sin_formula][value=" + data.tipo_indicador + "]").prop('checked', true);
			// $("input[name=indicador_formula_o_sin_formula]").parent().removeClass("active");
			// $("input[name=indicador_formula_o_sin_formula][value=" + data.tipo_indicador + "]").parent().addClass("active");
			// if (data.tipo_indicador == 1) {
			// 	indicadores_sin_formula();
			// } else {
			// 	indicadores_con_formula();
			// }
			// $("input[name=indicador_sin_formula][value=" + data.tipo_pregunta + "]").prop('checked', true);
			// $("input[name=indicador_sin_formula]").parent().removeClass("active");
			// $("input[name=indicador_sin_formula][value=" + data.tipo_pregunta + "]").parent().addClass("active");

			$("#meta_responsable").val(data.meta_responsable);
			$("#meta_responsable").selectpicker('refresh');
			if (data.condicion_institucional && Array.isArray(data.condicion_institucional)) {
				$("#box_condiciones_institucionales").find('[value=' + data.condicion_institucional.join('], [value=') + ']').prop("checked", true);
			}
			if (data.dependencias && Array.isArray(data.dependencias)) {
				$("#dependencias").find('[value=' + data.dependencias.join('], [value=') + ']').prop("checked", true);
			}
			if (data.condicion_programa && Array.isArray(data.condicion_programa)) {
				$("#condiciones_programa").find('[value=' + data.condicion_programa.join('], [value=') + ']').prop("checked", true);
			}

			// $("#indicador").val(data.select_tipo_indicador);
			// $("#indicador").selectpicker('refresh');


			// if (data.select_tipo_indicador === 1) {
			// 	$('#incrementos').show();
			// 	$('#indicadores_con_formula').hide();
			// 	$('#participacion').hide();

			// } else if (data.select_tipo_indicador === 2) {
			// 	$('#incrementos').hide();
			// 	$('#indicadores_con_formula').hide();
			// 	$('#participacion').show();

			// } else if (data.select_tipo_indicador === 3) {

			// 	$('#incrementos').hide();
			// 	$('#indicadores_con_formula').hide();
			// 	$('#participacion').hide();
			// }

			// if (data.tipo_indicador === 1) {
			// 	$("#indicadores_con_formula").hide();

			// } else if (data.tipo_indicador === 2) {
			// 	$("#indicadores_con_formula").show();

			// }

		}
	});
}

function eliminar_proyecto(id_proyecto) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar la meta?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/sac_proyecto.php?op=eliminar_proyecto", { id_proyecto: id_proyecto }, function (e) {

				if (e == 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Meta eliminada con éxito.",
						icon: "success"
					});

					$('#tbllistadometas').DataTable().ajax.reload();
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Meta no se puede eliminar.",
						icon: "error"
					});
				}
			});

		} else if (
			/* Read more about handling dismissals below */
			result.dismiss === Swal.DismissReason.cancel
		) {
			swalWithBootstrapButtons.fire({
				title: "Cancelado",
				text: "Tu proceso está a salvo :)",
				icon: "error"
			});
		}
	});
}

function eliminar_meta(id_meta) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar la meta?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/sac_proyecto.php?op=eliminar_meta", { 'id_meta': id_meta }, function (e) {

				if (e == 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Meta eliminado con éxito.",
						icon: "success"
					});

					$('#tbllistadometas').DataTable().ajax.reload();
					// listar_meta(id_proyecto);
					$("#myModalNombreMetaUsuario").modal("hide");
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Meta no se puede eliminar.",
						icon: "error"
					});
				}
			});

		} else if (
			/* Read more about handling dismissals below */
			result.dismiss === Swal.DismissReason.cancel
		) {
			swalWithBootstrapButtons.fire({
				title: "Cancelado",
				text: "Tu proceso está a salvo :)",
				icon: "error"
			});
		}
	});
}
//Función mostrar formulario
function mostrarform(flag) {
	if (flag) {
		$("#listadoregistros").hide();
		
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
		
	} else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform() {
	mostrarform(false);
}

//Función Listar
function volverejes() {
	$("#slash").hide();
	$("#ver_plan").hide();
	$("#ver_proyectos").hide();
	$("#ver_plan_proyecto").hide();
	$("#listar_ejes").show();
	$("#ver_metas").hide();
	$("#ver_acciones").hide();
	$("#ver_tareas").hide();
	$("#grafico2").hide();
	$("#ocultargestionproyecto").hide();
	$("#ocultargestionproyecto2").hide();
	$("#ocultarmetas").hide();
	$("#ocultarmetas2").hide();
	$("#vergrafica").show();
	$("#ocultargraficametas").show();
	$("#ocultargraficametas2").show();
	$("#ocultar_anio_meta").show();
	$("#ocultarpanelanio").show();
	$("#seleccionar_periodo").show();
	listar_ejes();
}

//Función Listar
function listar(id_ejes) {
	$("#precarga").show();
	$("#ver_proyectos").show();
	$("#ocultargestionproyecto").show();
	$("#ocultargestionproyecto2").show();
	$("#listar_ejes").hide();
	$("#ver_metas").hide();
	$("#ocultar_anio_meta").hide();
	$("#ver_acciones").hide();
	$("#ver_tareas").hide();
	$("#ocultarpanelanio").hide();
	$("#seleccionar_periodo").hide();
	$("#id_ejes").val(id_ejes);

	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistadometas').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Print'
			},
		],
		"ajax": {
			url: '../controlador/sac_proyecto.php?op=listar&id_ejes=' + id_ejes, type: "get", dataType: "json",
			error: function (e) {
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[0, "asc"]],//Ordenar (columna,orden)
		'initComplete': function (settings, json) {
			$("#precarga").hide();
			scroll(0, 0);
		},
	});
}

function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../controlador/sac_proyecto.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			alertify.success(datos);
			mostrarform(false);
			listar();
			limpiar();

		}
	});
}
//Función para mostrar nombre de la meta 
function nombre_ejes(id_eje) {
	$.post("../controlador/sac_proyecto.php?op=nombre_ejes", { id_eje: id_eje }, function (data) {
		data = JSON.parse(data);
		$("#myModalNombreMetaEje").modal("show");
		$(".id_eje").html(data);

	});
}

//Función para mostrar nombre de la meta 
function nombre_accion_ejes(id_eje) {
	$.post("../controlador/sac_proyecto.php?op=nombre_accion_ejes", { id_eje: id_eje }, function (data) {
		data = JSON.parse(data);
		$("#myModalNombreAccionEje").modal("show");
		$(".id_accion_label").html(data);

	});
}

//Función para desactivar registross
function eliminar(id_eje) {
	alertify.confirm("¿Está Seguro de eliminar la ejes?", function (result) {
		if (result) {
			$.post("../controlador/sac_proyecto.php?op=eliminar", { id_eje: id_eje }, function (e) {
				if (e == 'null') {
					alertify.success("Eliminado correctamente");
				}
				else {
					alertify.error("Error");
				}
			});
		}
	})
}

//Funcion para refrescar la tabla de Proyecto
function refrescartabla() {
	tabla = $('#tbllistado').DataTable();

	tabla.ajax.reload(function (json) {
		$('#tbllistado').val(json.lastInput);
	});
}
function refrescarmeta() {
	tabla = $('#tbllistadometa').DataTable();
	tabla.ajax.reload(function (json) {
		$('#tbllistadometa').val(json.lastInput);
	});
}

function refrescaraccion() {
	tabla = $('#tbllistaacciones').DataTable();
	tabla.ajax.reload(function (json) {
		$('#tbllistaacciones').val(json.lastInput);
	});
}

//Función Listar Metas
function listarmetas(id_ejes) {
	
	periodoSeleccionado = $("#periodo_sac").val();
	$("#precarga").show();
	$("#titulo_metas").show();
	$("#slash").show();
	$("#ver_metas").show();
	$("#listar_ejes").hide();
	$("#ocultar_anio_meta").hide();
	$("#ver_tareas").hide();
	$("#ver_acciones").hide();
	$("#ocultarmetas").show();
	$("#ocultarmetas2").show();
	$("#ver_tareas").hide();
	$("#ocultarpanelanio").hide();
	$("#seleccionar_periodo").hide();
	$("#id_ejes").val(id_ejes);

	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistadometa').dataTable({

		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Print'
			},
		],

		"ajax": {
			url: '../controlador/sac_proyecto.php?op=listarmetas&id_ejes=' + id_ejes,
			type: "get",
			dataType: "json",
			data: {"globalperidioseleccionado": globalperidioseleccionado}, // Incluido como parte de los datos

			error: function (e) {
				// console.log(e);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[0, "asc"]],//Ordenar (columna,orden)
		'initComplete': function (settings, json) {
			$("#numero_metas_cumplidas").text(json.totalCumplidas);
			$("#numero_metas_nocumplidas").text(json.totalNoCumplidas);
			$("#precarga").hide();
			scroll(0,0);
		},
	});
}

//Función para eliminar registros
function eliminometa(id_meta, id_proyecto) {
	alertify.confirm("¿Está Seguro de eliminar la meta?", function (result) {
		if (result) {
			$.post("../controlador/sac_proyecto.php?op=eliminar_meta", { 'id_meta': id_meta }, function (e) {

				// alert(id_meta);
				if (e) {
					alertify.success("Eliminado correctamente");
					// refrescartablaeditarmeta();
					listar_meta(id_proyecto);
					$("#myModalNombreMetaUsuario").modal("hide");
					refrescarmeta();
					// refrescarmeta();
				} else {
					alertify.error("Error");
				}
			});
		}
	})
}

function mostrar_accion(id_accion) {
	$.post("../controlador/sac_proyecto.php?op=mostrar_accion", { "id_accion": id_accion }, function (data) {
		data = JSON.parse(data);
		if (Object.keys(data).length > 0) {
			$("#fecha_accion_anterior_fin").val(data.fecha_fin);
			$("#hora_anterior").val(data.hora);
			$("#id_accion").val(data.id_accion);
			$("#nombre_accion").val(data.nombre_accion);
			$(".id_meta").val(data.id_meta);
			$("#fecha_accion").val(data.fecha_accion);
			$("#fecha_accion").selectpicker('refresh');
			$("#fecha_fin").val(data.fecha_fin);
			$("#hora_accion").val(data.hora);
			$("#fecha_fin").selectpicker('refresh');
			$("#ModalAccion").modal("show");
			$("#myModalNombreMetaUsuario").modal("hide");
			$("#formularioguardometa").modal("hide");
		}
	});
}

function eliminar_accion(id_accion) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar la acción?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/sac_proyecto.php?op=eliminar_accion", { 'id_accion': id_accion }, function (e) {

				if (e !== 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Acción eliminado con éxito.",
						icon: "success"
					});
					$("#myModalNombreMetaUsuario").modal("hide");
					//   refrescaraccion();
					$('#tbllistaacciones').DataTable().ajax.reload();
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Acción no se puede eliminar.",
						icon: "error"
					});
				}
			});

		} else if (
			/* Read more about handling dismissals below */
			result.dismiss === Swal.DismissReason.cancel
		) {
			swalWithBootstrapButtons.fire({
				title: "Cancelado",
				text: "Tu proceso está a salvo :)",
				icon: "error"
			});
		}
	});
}
//Función Listar las acciones
function listaracciones(id_ejes) {
	$("#precarga").show();
	$("#ver_acciones").show();
	$("#titulo_acciones").show();
	$("#slash").show();
	$("#listar_ejes").hide();
	$("#ocultar_anio_meta").hide();
	$("#ocultarpanelanio").hide();
	$("#seleccionar_periodo").hide();
	
	$("#id_ejes").val(id_ejes);

	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistaacciones').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		buttons: [

			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Print'
			},
		],

		"ajax": {
			url: '../controlador/sac_proyecto.php?op=listaracciones&id_ejes=' + id_ejes, type: "get", dataType: "json", data: {"globalperidioseleccionado": globalperidioseleccionado}, // Incluido como parte de los datos
			error: function (e) {
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[0, "asc"]],//Ordenar (columna,orden)
		'initComplete': function (settings, json) {
			refrescaraccion();
			$("#precarga").hide();
			scroll(0,0);
		},
	});

}

//Función guardo y edito accion 
function guardaryeditaraccion(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarAccion").prop("disabled", true);
	var formData = new FormData($("#formularioaccion")[0]);
	$.ajax({
		"url": "../controlador/sac_proyecto.php?op=guardaryeditaraccion",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Acción Actualizada",
				showConfirmButton: false,
				timer: 1500
			});
			
			$("#tbllistaacciones").DataTable().ajax.reload();
			
			$("#btnGuardarAccion").prop("disabled", false);
			$("#ModalAccion").modal("hide");
			// $("#formularioaccion")[0].reset();

			$("#myModalNombreMetaUsuario").modal("hide");
			$("#myModalNombreProyecto").modal("hide");
			// refrescaraccion();

		}
	});
}

// //Función para desactivar registros
function terminar_accion(id_accion) {
	alertify.confirm("¿Está Seguro de terminar la accion?", function (result) {
		if (result) {
			$.post("../controlador/sac_proyecto.php?op=terminar_accion", { 'id_accion': id_accion }, function (e) {

				if (e) {
					alertify.success("Terminado correctamente");
					$("#myModalNombreMetaUsuario").modal("hide");
					// listar();
				} else {
					alertify.error("Error");
				}
			});
		}
	})
}

//Función guardo y edito el nombre del proyecto
function guardaryeditometa(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioguardometa")[0]);
	$.ajax({
		"url": "../controlador/sac_proyecto.php?op=guardaryeditometa",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Meta Actualizada",
				showConfirmButton: false,
				timer: 1500
			});
			$("#tbllistadometas").DataTable().ajax.reload();
			$("#myModalMeta").modal("hide");
			$("#formularioguardometa").modal("hide");
			$("#tbllistadometa").modal("hide");

			// refrescartabla();

		}
	});
}

//Función para listar las metas por proyecto |E444444444444333333
function listar_proyecto_accion(id_meta) {
	$.post("../controlador/sac_proyecto.php?op=listar_proyecto_accion", { "id_meta": id_meta }, function (data) {
		data = JSON.parse(data);
		$("#myModalNombreProyecto").modal("show");
		$(".nombre_proyecto_accion").html(data);
	});
}

//Función para listar las metas por proyecto 
function listar_meta_2022(id_proyecto) {
	$.post("../controlador/sac_proyecto.php?op=listar_meta_2022", { "id_proyecto": id_proyecto }, function (data) {
		data = JSON.parse(data);
		$("#myModalNombreMetaUsuario").modal("show");
		$(".id_meta").html(data);
		$("#formularioguardometa")[0].reset();
	});
}

function listar_meta_2024(id_proyecto) {
	$.post("../controlador/sac_proyecto.php?op=listar_meta_2024", { "id_proyecto": id_proyecto }, function (data) {
		data = JSON.parse(data);
		$("#myModalNombreMetaUsuario").modal("show");
		$(".id_meta").html(data);
		$("#formularioguardometa")[0].reset();
	});
}

function listar_meta_2025(id_proyecto) {
	$.post("../controlador/sac_proyecto.php?op=listar_meta_2025", { "id_proyecto": id_proyecto }, function (data) {
		data = JSON.parse(data);
		$("#myModalNombreMetaUsuario").modal("show");
		$(".id_meta").html(data);
		$("#formularioguardometa")[0].reset();
	});
}


// function indicadores_con_formula() {
// 	$("#indicadores_con_formula").show();
// 	$("#indicadores_sin_formula").hide();
// }
// function indicadores_sin_formula() {
// 	$("#indicadores_con_formula").hide();
// 	$("#indicadores_sin_formula").show();
// }
// Formula para los indicadores de incremento
// function calcular_formula() {
// 	var puntaje_actual = $("#puntaje_actual").val();
// 	var puntaje_anterior = $("#puntaje_anterior").val();
// 	var resultado = ((puntaje_actual - puntaje_anterior) / puntaje_anterior) * 100
// 	if (resultado == "Infinity") {
// 		$(".mostrar_calculo").html("00");
// 	} else {
// 		$(".mostrar_calculo").html(resultado);
// 	}

// }
// Formula para los indicadores de participacion
// function calcular_formula_paticipacion() {
// 	var participa = $("#participa").val();
// 	var poblacion = $("#poblacion").val();
// 	var resultado_participa = (participa / poblacion) * 100;
// 	if (resultado_participa == "Infinity") {
// 		$(".mostrar_calculo_participa").html("00");
// 	} else {
// 		$(".mostrar_calculo_participa").html(resultado_participa);
// 	}

// }
// function mostrarElementosSegunSeleccion(seleccion) {
// 	// Ocultar todos los elementos dentro de #inputs
// 	$('#inputs > div').hide();
// 	seleccion_global = seleccion;
// 	// Mostrar elementos específicos según la opción seleccionada
// 	if (seleccion === '1') {
// 		$('#incrementos').show();
// 		$('#indicadores_con_formula').hide();
// 		$('#participacion').hide();

// 	} else if (seleccion === '2') {
// 		$('#incrementos').hide();
// 		$('#indicadores_con_formula').hide();
// 		$('#participacion').show();

// 	} else if (seleccion === '3') {

// 		$('#incrementos').hide();
// 		$('#indicadores_con_formula').hide();
// 		$('#participacion').hide();


// 	}
// }

//Función para listar las metas por proyecto 
// function historico_tabla_indicadores() {
// 	$.post("../controlador/sac_proyecto.php?op=historico_tabla_indicadores", { "id_meta_global": id_meta_global }, function (data) {
// 		data = JSON.parse(data);
// 		$("#tabla_indicadores").html(data);
// 		$("#tabla_indicadores").show();
// 	});
// }

function ver_total_metas_cumplidas_grafico() {
	$.post("../controlador/sac_proyecto.php?op=ver_total_metas_cumplidas", {}, function (r) {
		r = JSON.parse(r);
		var datos = r.datos_grafico; // Asignación directa
		var chart = new CanvasJS.Chart("chartContainer2", {
			theme: "light",
			exportFileName: "Doughnut Chart",
			exportEnabled: true,
			animationEnabled: true,
			backgroundColor: "transparent", // Establecer fondo transparente
			title: {
				text: "Cumplimiento de metas",
				fontColor: "#607d8a" // Cambiar el color del título
			},
			legend: {
				cursor: "pointer",
				horizontalAlign: "left", // left, center ,right 
				verticalAlign: "center",  // top, center, bottom
				itemclick: explodePie,
				fontColor: "#607d8a" // Cambiar el color del título
			},

			data: [{
				type: "doughnut",
				innerRadius: 60,
				showInLegend: true,
				toolTipContent: "<b>{name}</b>: {y} (#percent%)",
				indexLabel: "{name} - #percent%",
				indexLabelFontColor: "#607d8a", // Cambiar el color de la etiqueta
				dataPoints: datos
			}]
		});
		chart.render();
	});
	function explodePie(e) {
		if (typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
			e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
		} else {
			e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
		}
		e.chart.render();
	}
}

// function mostrargraficosmeta(id_ejes) {
// 	$.post("../controlador/sac_proyecto.php?op=mostrargraficosmeta", { "id_ejes": id_ejes,"globalperidioseleccionado": globalperidioseleccionado }, function (r) {
// 		r = JSON.parse(r);
// 		var datos = r;
// 		var datos = Array.isArray(r) ? r : r.datos_grafico;

// 		if (Array.isArray(datos)) {
// 			var data1 = {
// 				// labels: r.datos_grafico.map(item => item.name),
// 				datasets: [{
// 					data: r.datos_grafico.map(item => item.y),
// 					backgroundColor: ['#2e9c65', '#dd2255'],
// 					hoverOffset: 4
// 				}]
// 			};
// 			var config = {
// 				type: 'doughnut',
// 				data: data1,
// 				options: {
// 					plugins: {
// 						legend: {
// 							display: true,
// 							position: 'bottom',
// 						},
// 						tooltip: {
// 							titleFont: {
// 								size: 15
// 							},
// 							bodyFont: {
// 								size: 15
// 							}
// 						}
// 					}
// 				}
// 			};

// 		};
// 		// iniciar la grafica 1
// 		var ctx1 = document.getElementById('chart' + id_ejes).getContext('2d');
// 		new Chart(ctx1, config);

// 	});
// }
// function mostrargraficosmeta(id_ejes) {
//     $.post("../controlador/sac_proyecto.php?op=mostrargraficosmeta", {
//         id_ejes: id_ejes,
//         globalperidioseleccionado: globalperidioseleccionado
//     }, function (respuesta) {
//         const { datos_grafico, promedio_avance } = JSON.parse(respuesta);

//         // Plugin para dibujar el texto central
//         const centerTextPlugin = {
//             id: 'centerText',
//             beforeDraw(chart) {
//                 const { width, height, ctx } = chart;
//                 ctx.save();

//                 const fontSize = (height / 100).toFixed(2);
//                 ctx.font = `${fontSize}em sans-serif`;
//                 ctx.textBaseline = "middle";
//                 ctx.fillStyle = "#ffffff";

//                 const text = `${promedio_avance}%`;
//                 const textX = (width - ctx.measureText(text).width) / 2;
//                 const textY = height / 2;

//                 ctx.fillText(text, textX, textY);
//                 ctx.restore();
//             }
//         };

//         // Configurar los datos del gráfico
//         const chartData = {
//             labels: datos_grafico.map(d => d.name),
//             datasets: [{
//                 data: datos_grafico.map(d => d.y),
//                        backgroundColor: ['#26c6f9', '#cfd8dc'],


//                 hoverOffset: 4
//             }]
//         };

//         const chartOptions = {
//             type: 'doughnut',
//             data: chartData,
//             options: {
//                 cutout: '60%', // tamaño del agujero interior
//                 plugins: {
//                     legend: { display: false }
//                 }
//             },
//             plugins: [centerTextPlugin]
//         };

//         // Renderizar el gráfico
//         const ctx = document.getElementById('chart' + id_ejes).getContext('2d');
//         new Chart(ctx, chartOptions);
//     });
// }


function mostrargraficosmeta(id_ejes) {
    $.post("../controlador/sac_proyecto.php?op=mostrargraficosmeta", {
        id_ejes: id_ejes,
        globalperidioseleccionado: globalperidioseleccionado
    }, function (respuesta) {
        const { promedio_avance } = JSON.parse(respuesta);
        const centerTextPlugin = {
            id: 'centerText',
            beforeDraw(chart) {
                const { width, height, ctx } = chart;
                ctx.save();
                // const fontSize = (height / 100).toFixed(2);
                // ctx.font = `${fontSize}em sans-serif`;
                // ctx.textBaseline = "middle";
                // ctx.fillStyle = "#D3D3D3";
				// agregamos la clase titulo-2 para que se ajuste el color dependiendo si esta en el tema oscuro o blanco.
				const tempSpan = document.createElement("span");
				tempSpan.className = "titulo-2";
				tempSpan.style.display = "none";
				document.body.appendChild(tempSpan);
				const computedStyle = getComputedStyle(tempSpan);
				const color = computedStyle.color || "#333333"; 
				const fontSize = parseInt(computedStyle.fontSize) || (height / 10);
				const fontFamily = computedStyle.fontFamily || "sans-serif";
				document.body.removeChild(tempSpan); 
				ctx.font = `${fontSize}px ${fontFamily}`;
				ctx.textBaseline = "middle";
				ctx.fillStyle = color;
                const text = `${promedio_avance}%`;
                const textX = (width - ctx.measureText(text).width) / 2;
                const textY = height / 2;
                ctx.fillText(text, textX, textY);
                ctx.restore();
            }
        };
		const chartData = {
			labels: ['% Avance'], // opcional, puedes quitarlo si no usas leyenda
			datasets: [{
				data: [promedio_avance, 100 - promedio_avance],
				backgroundColor: ['#4CAF50', '#FFFFFF'], // Avance verde, restante blanco
				hoverOffset: 4,
				borderWidth: 0 // opcional, elimina bordes si no los quieres
			}]
		};
		const chartOptions = {
		type: 'doughnut',
		data: chartData,
		options: {
			cutout: '60%',
			plugins: {
				legend: { display: false },
				tooltip: {
					callbacks: {
						label: function (context) {
							if (context.dataIndex === 0) {
								return `Avance: ${context.parsed}%`;
							}
							return '';
						}
					},
					filter: function (tooltipItem) {
						return tooltipItem.dataIndex === 0;
					}
				}
			},
			hover: {
				mode: 'nearest',
				intersect: true
			},
			interaction: {
				mode: 'nearest',
				intersect: true
			}
		},
		plugins: [centerTextPlugin]
	};
	const ctx = document.getElementById('chart' + id_ejes).getContext('2d');
	new Chart(ctx, chartOptions);
    });
}




function listartareas(id_ejes) {
	$("#precarga").show();
	$("#ver_tareas").show();
	$("#slash").show();
	$("#listar_ejes").hide();
	$("#ocultar_anio_meta").hide();
	$("#ocultarpanelanio").hide();
	$("#seleccionar_periodo").hide();
	$("#id_ejes").val(id_ejes);
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistatareas').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		buttons: [

			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Print'
			},
		],

		"ajax": {
			url: '../controlador/sac_proyecto.php?op=listartareas&id_ejes=' + id_ejes, type: "get", dataType: "json", data: {"globalperidioseleccionado": globalperidioseleccionado}, // Incluido como parte de los datos
			error: function (e) {
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[0, "asc"]],//Ordenar (columna,orden)
		'initComplete': function (settings, json) {
			$("#precarga").hide();
			scroll(0,0);
		},
	});

}

function mostrar_tarea(id_tarea_sac){
	$.post("../controlador/sac_proyecto.php?op=mostrar_tarea",{"id_tarea_sac" : id_tarea_sac},function(data){
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){
			$("#ModalCrearTarea").modal("show");
			$("#id_tarea_sac").val(data.id_tarea_sac);
			$("#nombre_tarea").val(data.nombre_tarea);
			$("#fecha_tarea").val(data.fecha_entrega_tarea);
			$("#responsable_tarea").val(data.responsable_tarea);
			$("#responsable_tarea").selectpicker('refresh');
			$("#link_tarea").val(data.link_evidencia_tarea);
			// $("#ModalCrearTarea").modal("hide");
		}
	});
}

function guardaryeditartarea(e){
	e.preventDefault(); //No se activará la tarea predeterminada del evento
	$("#btnGuardarAccion").prop("disabled",true);
	var formData = new FormData($("#formulariocreartarea")[0]);
	$.ajax({
		"url": "../controlador/sac_proyecto.php?op=guardaryeditartarea",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Tarea Actualizada",
				showConfirmButton: false,
				timer: 1500
			});
			$('#tbllistatareas').DataTable().ajax.reload();
			// listar();
			// nombre_meta_usuario(meta_responsable_global,fecha_ano_global);
			$("#ModalCrearTarea").modal("hide");
			$("#formulariocreartarea")[0].reset();
		}
	});
}


function eliminar_tareas(id_tarea_sac) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de eliminar la tarea?",
			text: "¡No podrás revertir esto!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes, continuar!",
			cancelButtonText: "No, cancelar!",
			reverseButtons: true,
		})
		.then((result) => {
			if (result.isConfirmed) {
				$.post(
					"../controlador/sac_proyecto.php?op=eliminar_tareas",
					{ id_tarea_sac: id_tarea_sac },
					function (e) {
                        data = JSON.parse(e);
						if (data !== null) {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Tarea eliminado con éxito.",
								icon: "success",
							});
							$('#tbllistatareas').DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Tarea no se puede eliminar.",
								icon: "error",
							});
						}
					}
				);
			} else if (
				/* Read more about handling dismissals below */
				result.dismiss === Swal.DismissReason.cancel
			) {
				swalWithBootstrapButtons.fire({
					title: "Cancelado",
					text: "Tu proceso está a salvo :)",
					icon: "error",
				});
			}
		});
}

//actualiazmos el porcentaje dependiendo del id_meta y el porcentaje de avance 
function actualizarPorcentaje(id_meta, porcentaje_avance) {
	$.post("../controlador/sac_proyecto.php?op=actualizarPorcentaje", 
		{ "id_meta": id_meta, "porcentaje_avance": porcentaje_avance }, 
		function (data) {
			if (data === "true") {
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: "Porcentaje actualizado",
					showConfirmButton: false,
					timer: 1500
				});
			} else {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: "Error al actualizar el porcentaje"
				});
			}
		}
	);
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
				"title": 'Visión General',
				"element": document.querySelector('#vision_general'),
				"intro": 'Genera un reporte general por cada eje, proyecto y meta, acompañado de la información de las areas responsables. <img src="../files/img_tours/sac_vision_general.png" width="100%" class="zoom">'
			},
			{
				"title": 'Reporte Proyectos',
				"element": document.querySelector('#plan_proyecto'),
				"intro": 'Genera un reporte general de todos los proyectos existentes y creados para cada Eje.'
			},
			{
				"title": 'Reporte Metas',
				"element": document.querySelector('#ver_plan_metas'),
				"intro": 'Genera un reporte general de todas las metas creadas para cada proyecto.'
			},
			{
				"title": 'Reporte Acciones',
				"element": document.querySelector('#ver_plan_accion'),
				"intro": 'Genera un reporte general de todas las acciones creadas para cada meta, incluyendo el area responsable.'
			},
			{
				"title": 'Estadisticas Por Eje',
				"element": document.querySelector('#card_para_eje'),
				"intro": 'Información detallada de cada eje'
			},
			{
				"title": 'Titulo Eje',
				"element": document.querySelector('#tour_titulo_eje'),
				"intro": 'Nombre y número de eje'
			},
			{
				"title": 'Gráfica Avances De Metas ',
				"element": document.querySelector('#tour_chart'),
				"intro": 'Esta gráfica, muestra el avance de las metas que corresponden al eje'
			},
			{
				"title": 'Proyectos por eje ',
				"element": document.querySelector('#tour_proyectos_eje'),
				"intro": 'Listado de proyectos que corresponden al eje'
			},
			{
				"title": 'Metas por eje ',
				"element": document.querySelector('#tour_metas_eje'),
				"intro": 'Listado de metas que corresponden al eje'
			},
			{
				"title": 'Acciones por eje ',
				"element": document.querySelector('#tour_acciones_eje'),
				"intro": 'Listado de acciones que corresponden al eje'
			},
		]
	},
	).start();
}
init();