var id_eje_seleccionado;
var id_proyecto_seleccionado;
var tabla;
var globalperidioseleccionado;
var seleccion_global;
var id_meta_global;
var id_proyecto_global;
var globalperidioseleccionado;
function init() {
	mostrarform(false);
	listar_ejes();
	$("#ver_proyectos").hide();
	$("#ver_metas").hide();
	$("#btnvolvergrafica").hide();
	$("#ver_acciones").hide();
	$("#ver_total_metas_cumplidas").hide();
	$("#ocultargestionproyecto").hide();
	$("#ocultargestionproyecto2").hide();
	$("#ocultarmetas").hide();
	$("#ocultarmetas2").hide();
	$("#ver_tabla_proyecto_acciones").hide();
	//listamos el cargo en el html
	$.post("../controlador/poa_por_usuario.php?op=selectListarCargo", function (r) {
		$("#meta_responsable").html(r);
		$('#meta_responsable').selectpicker('refresh');
	});
	//listamos las condiciones institucionales en el html
	$.post("../controlador/poa_por_usuario.php?op=condiciones_institucionales", function (r) {
		$(".box_condiciones_institucionales").html(r);
	});
	//listamos las condiciones de programa en el html
	$.post("../controlador/poa_por_usuario.php?op=condiciones_programa&id=", function (r) {
		$("#condiciones_programa").html(r);
	});

	$("#formulariocrearmetaeditar").on("submit", function (e) {
		guardarcreoyeditometa(e);
	});
	$.post("../controlador/sac_listar_dependencia.php?op=selectListarEjes", function (r) {
		$("#nombre_ejes").html(r);
		$('#nombre_ejes').selectpicker('refresh');
	});
}
//Función Listar
function listar(id_ejes) {
	id_eje_seleccionado = id_ejes;
	$("#precarga").show();
	$("#ver_proyectos").show();
	$("#ocultargestionproyecto").show();
	$("#ocultargestionproyecto2").show();
	$("#listar_ejes").hide();
	$("#ver_metas").hide();
	$("#ocultar_anio_meta").hide();
	$("#ver_acciones").hide();
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
			url: '../controlador/poa_por_usuario.php?op=listar&id_ejes=' + id_ejes, type: "get", dataType: "json", data: { "globalperidioseleccionado": globalperidioseleccionado }, // Incluido como parte de los datos
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
function listar_metas(id_proyecto) {
	$.post("../controlador/poa_por_usuario.php?op=listar_metas", { "id_proyecto": id_proyecto, "globalperidioseleccionado": globalperidioseleccionado }, function (data) {
		id_proyecto_seleccionado = id_proyecto;
		data = JSON.parse(data);
		$("#myModalNombreMetaUsuario").modal("show");
		$(".id_meta").html(data);
		$("#formulariocrearmetaeditar")[0].reset();
	});
}
//Función lista los ejes estrategicos  
function listar_ejes() {
	periodoSeleccionado = $("#periodo_sac").val();
	globalperidioseleccionado = periodoSeleccionado;
	$("#dato_periodo").html(periodoSeleccionado);
	$("#precarga").show();
	$.post("../controlador/poa_por_usuario.php?op=listar_ejes", { "periodoSeleccionado": periodoSeleccionado }, function (data) {
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
function crear_meta() {
	$("#formulariocrearmetaeditar")[0].reset();
	$("#myModalNombreMetaUsuario").modal("hide");
	$("#myModalMeta").modal("show");
	$("#editarycrearmeta").html("Crear Meta");
	$("#campo_ejes").show();
	$("#nombre_ejes").attr("required", "required");
	$("#mostrar_ocultar_proyectos").show();
	$("#nombre_proyectos").attr("required", "required");
	$("#nombre_ejes, #nombre_proyectos").selectpicker('refresh');
}
function mostrarproyectos(id_ejes) {
	$.post("../controlador/poa_por_usuario.php?op=selectListarProyectos", { id_ejes: id_ejes }, function (datos) {
		$("#nombre_proyectos").html(datos);
		$(".selectpicker").selectpicker('refresh');
		$("#nombre_proyectos").val(id_proyecto_seleccionado);
		$(".selectpicker").selectpicker('refresh');
	});
}
function mostrar_proyecto(id_proyecto) {
	$("#ModalCrearProyecto").modal("show");
	$.post("../controlador/poa_por_usuario.php?op=mostrar_proyecto", { "id_proyecto": id_proyecto }, function (data) {
		data = JSON.parse(data);
		if (Object.keys(data).length > 0) {
			$("#nombre_proyecto").val(data.nombre_proyecto);
			$("#id_proyecto").val(data.id_proyecto);
		}
	});
}
function guardarcreoyeditometa(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulariocrearmetaeditar")[0]);
	$.ajax({
		"url": "../controlador/poa_por_usuario.php?op=guardarcreoyeditometa",
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
			setTimeout(function () {
				location.reload();
			}, 1500);
			// $("#tbllistado").DataTable().ajax.reload();
			$("#myModalMeta").modal("hide");
			$("#formulariocrearmetaeditar").modal("hide");
			$("#tbllistadometa").modal("hide");
		}
	});
}
function mostrargraficosmeta(id_ejes) {
	$.post("../controlador/poa_por_usuario.php?op=mostrargraficosmeta", { "id_ejes": id_ejes, "globalperidioseleccionado": globalperidioseleccionado }, function (r) {
		r = JSON.parse(r);
		var datos = r;
		var datos = Array.isArray(r) ? r : r.datos_grafico;
		if (Array.isArray(datos)) {
			var data1 = {
				// labels: r.datos_grafico.map(item => item.name),
				datasets: [{
					data: r.datos_grafico.map(item => item.y),
					backgroundColor: ['#2e9c65', '#dd2255'],
					hoverOffset: 4
				}]
			};
			var config = {
				type: 'doughnut',
				data: data1,
				options: {
					plugins: {
						legend: {
							display: true,
							position: 'bottom',
						},
						tooltip: {
							titleFont: {
								size: 15
							},
							bodyFont: {
								size: 15
							}
						}
					}
				}
			};
		};
		// iniciar la grafica 1
		var ctx1 = document.getElementById('chart' + id_ejes).getContext('2d');
		new Chart(ctx1, config);
	});
}

function listar_marcadas_meta(id_meta) {
	id_meta_global = id_meta;
	// $("#myModalNombreMetaUsuario").modal("show");
	$.post("../controlador/poa_por_usuario.php?op=listar_marcadas_meta", { "id_meta": id_meta }, function (data) {
		data = JSON.parse(data);
		if (Object.keys(data).length > 0) {
			$("#nombre_ejes").val(id_eje_seleccionado);
			$("#nombre_ejes").selectpicker('refresh');
			mostrarproyectos(id_eje_seleccionado);
			$("#myModalMeta").modal("show");
			$("#myModalNombreMetaUsuario").modal("hide");
			$(".id_meta").val(data.id_meta);
			$("#meta_nombre").val(data.meta_nombre);
			$("#meta_fecha").val(data.meta_fecha);
			$("#indicador_inserta").val(data.observacion);
			$("#puntaje_actual").val(data.puntaje_actual);
			$("#puntaje_anterior").val(data.puntaje_anterior);
			$("#anio_eje").val(data.anio_eje);
			$("#anio_eje").selectpicker('refresh');
			$("#participa").val(data.participa);
			$("#poblacion").val(data.poblacion);
			$("#plan_mejoramiento").val(data.plan_mejoramiento);
			$("input[name=meta_lograda][value=" + data.estado_meta + "]").prop('checked', true);
			$("input[name=meta_lograda]").parent().removeClass("active");
			$("input[name=meta_lograda][value=" + data.estado_meta + "]").parent().addClass("active");
			var resultado = ((data.puntaje_actual - data.puntaje_anterior) / data.puntaje_anterior) * 100;
			$(".mostrar_calculo").html(resultado);
			var resultado_participa = (data.participa / data.poblacion) * 100;
			$(".mostrar_calculo_participa").html(resultado_participa);
			$("input[name=indicador_formula_o_sin_formula][value=" + data.tipo_indicador + "]").prop('checked', true);
			$("input[name=indicador_formula_o_sin_formula]").parent().removeClass("active");
			$("input[name=indicador_formula_o_sin_formula][value=" + data.tipo_indicador + "]").parent().addClass("active");
	
			$("input[name=indicador_sin_formula][value=" + data.tipo_pregunta + "]").prop('checked', true);
			$("input[name=indicador_sin_formula]").parent().removeClass("active");
			$("input[name=indicador_sin_formula][value=" + data.tipo_pregunta + "]").parent().addClass("active");
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
			
		}
	});
}
//Función para ver el proyecto 
function volver_panel() {
	$("#listar_ejes").show();
	$("#ver_plan").hide();
	$("#ver_plan_proyecto").hide();
	$("#ver_total_metas_cumplidas").hide();
	$("#ver_tabla_proyecto_acciones").hide();
	$("#ocultar_anio_meta").show();
	$("#ocultarpanelanio").show();
	$("#seleccionar_periodo").show();
}
//Función limpiar la meta responsable
function limpiar() {
	$("#meta_responsable").val("");
	$("#meta_responsable").change();
	$("#indicador").val("");
	$("#indicador").change();
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

//Función Listar Metas
function listarmetas(id_ejes) {
	periodoSeleccionado = $("#periodo_sac").val();
	$("#precarga").show();
	$("#titulo_metas").show();
	$("#slash").show();
	$("#ver_metas").show();
	$("#listar_ejes").hide();
	$("#ocultar_anio_meta").hide();
	$("#ver_acciones").hide();
	$("#ocultarmetas").show();
	$("#ocultarmetas2").show();
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
			url: '../controlador/poa_por_usuario.php?op=listarmetas&id_ejes=' + id_ejes,
			type: "get",
			dataType: "json",
			data: { "globalperidioseleccionado": globalperidioseleccionado }, // Incluido como parte de los datos
			error: function (e) {
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[0, "asc"]],//Ordenar (columna,orden)
		'initComplete': function (settings, json) {
			$("#numero_metas_cumplidas").text(json.totalCumplidas);
			$("#numero_metas_nocumplidas").text(json.totalNoCumplidas);
			$("#precarga").hide();
			scroll(0, 0);
		},
	});
}

//Función para listar las metas por proyecto 
function listar_proyecto_accion(id_meta) {
	$.post("../controlador/poa_por_usuario.php?op=listar_proyecto_accion", { "id_meta": id_meta }, function (data) {
		data = JSON.parse(data);
		$("#myModalNombreProyecto").modal("show");
		$(".nombre_proyecto_accion").html(data);
	});
}

function ver_total_metas_cumplidas_grafico() {
	$.post("../controlador/poa_por_usuario.php?op=ver_total_metas_cumplidas", {}, function (r) {
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

function listar_meta_2025(id_proyecto) {
	$.post("../controlador/poa_por_usuario.php?op=listar_meta_2025", { "id_proyecto": id_proyecto }, function (data) {
		data = JSON.parse(data);
		$("#myModalNombreMetaUsuario").modal("show");
		$(".id_meta").html(data);
		$("#formularioguardometa")[0].reset();
	});
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
			$.post("../controlador/poa_por_usuario.php?op=eliminar_meta", { 'id_meta': id_meta }, function (e) {
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
//Función Listar
function volverejes() {
	$("#slash").hide();
	$("#ver_plan").hide();
	$("#ver_proyectos").hide();
	$("#ver_plan_proyecto").hide();
	$("#listar_ejes").show();
	$("#ver_metas").hide();
	$("#ver_acciones").hide();
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
