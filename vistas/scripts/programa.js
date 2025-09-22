var tabla;
var cortes_cantidad_global;
var datos = { exito: 0 }
let banderadeshabilitar = false;
//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	$("#monetizar").hide();
	$("#monetizarsemestres").hide();
	listar();
	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
	$("#formulariomonetizar").on("submit", function (e2) {
		guardarpecuniario(e2);
	});
	$("#formulariomonetizarsemestres").on("submit", function (e3) {
		guardarsemestres(e3);
	});
	$.post("../controlador/programa.php?op=selectEscuela", function (r) {
		$("#escuela").html(r);
		$('#escuela').selectpicker('refresh');
	});
	$.post("../controlador/programa.php?op=selectRelacion", function (r) {
		$("#relacion").html(r);
		$('#relacion').selectpicker('refresh');
	});
	$.post("../controlador/programa.php?op=selectCiclo", function (r) {
		$("#ciclo").html(r);
		$('#ciclo').selectpicker('refresh');
	});
	$("#form2").on("submit", function (e) {
		agregarCorte(e);
	});
	$("#formularioeditarvalores").on("submit", function (e4) {
		editarvalores(e4);
	});
	$.post("../controlador/programa.php?op=selectDirector", function (r) {
		$("#programa_director").html(r);
		$('#programa_director').selectpicker('refresh');
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
		"steps": [{
			"title": 'Gestión programas',
			"intro": 'Módulo para consultar los horarios por salones creados en el periodo actual.'
		},
		{
			"title": 'clases asignadas',
			"element": document.querySelector('#m-paso1'),
			"intro": ""
		}]
	},
	).start();
}
//Función limpiar
function limpiar() {
	$("#formulario")[0].reset();
}
//Función cancelarform
function cancelarform() {
	limpiar();
	$("#tbllistado").show();
	$("#listadoregistros").show();
	// $("#mostrar_agregar_programa").hide();
	mostrarform(false);
}
//Función cancelarform
function volver() {
	$("#filaagregar").show();
	$("#monetizar").hide();
	$("#listadoregistros").show();
	$("#monetizarsemestres").hide();
	$("#tabla_precios").hide();
	$("#tabla_precios").html("");
}
//Función Listar
function listar() {
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistado').dataTable({
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			"stateSave": true,
			"dom": 'Bfrtip',
			"buttons": [{
				"extend": 'excelHtml5',
				"text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				"titleAttr": 'Excel'
			},{
				"extend": 'print',
				"text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				"messageTop": '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
				"title": 'Programas Académicos',
				"titleAttr": 'Print'
			}
			],
			"ajax":{
				"url": '../controlador/programa.php?op=listar',
				"type": "get",
				"dataType": "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"order": [[9, "asc"]],
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},
			'select': 'single',
		});
}

$("#btnAgregar").click(function () {
	banderadeshabilitar = true;
	deshabilitarciclo();
});

$("#btnDeshabilitar").click(function () {
	banderadeshabilitar = false;
	deshabilitarciclo();
});
function deshabilitarciclo() {
	if (banderadeshabilitar) {
		$("#ciclo").prop('disabled', false);
	} else {
		$("#ciclo").prop('disabled', true);
	}
}
function mostrar(id_programa) {
	$.post("../controlador/programa.php?op=mostrar", { id_programa: id_programa }, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);
		deshabilitarciclo();
		$('#ciclo').prop('disable', true);
		$("#nombre").val(data.nombre);
		$("#cod_programa_pea").val(data.cod_programa_pea);
		$("#cod_snies").val(data.cod_snies);
		$("#cant_asignaturas").val(data.cant_asignaturas);
		$("#semestres").val(data.semestres);
		$("#inicio_semestre").val(data.inicio_semestre);
		$("#original").val(data.original);
		$("#carnet").val(data.carnet);
		$("#estado").val(data.estado);
		$("#estado").selectpicker('estado');
		$("#id_programa").val(data.id_programa);
		$("#cod_snies").val(data.cod_snies);
		$("#pertenece").val(data.pertenece);
		$("#estado").val(data.estado);
		$("#estado_nuevos").val(data.estado_nuevos);
		$("#estado_activos").val(data.estado_activos);
		$("#estado_graduados").val(data.estado_graduados);
		$("#panel_academico").val(data.panel_academico);
		$("#por_renovar").val(data.por_renovar);
		$("#universidad").val(data.universidad);
		$("#terminal").val(data.terminal);
		$("#relacion").val(data.relacion);
		$("#relacion").selectpicker('refresh');
		$("#programa_director").val(data.programa_director);
		$("#programa_director").selectpicker('refresh');
		$("#centro_costo_yeminus").val(data.centro_costo_yeminus);
		$("#codigo_producto").val(data.codigo_producto);
		$("#escuela").val(data.escuela);
		$("#escuela").selectpicker('refresh');
		$("#ciclo").val(data.ciclo);
		$("#ciclo").selectpicker('refresh');
		$("#corte").val(data.cortes);
		$(".quitar-editar").attr("disabled", true);
		datos = {
			exito: 1,
			c1: data.c1,
			c2: data.c2,
			c3: data.c3,
			c4: data.c4,
			c5: data.c5,
			c6: data.c6,
			c7: data.c7,
			c8: data.c8,
			c10: data.c10,
		}
		cantidad_cortes(datos)
	});
}
function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	// $("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		"url": "../controlador/programa.php?op=guardaryeditar",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			datos = JSON.parse(datos)
			if(datos.exito){
				alertify.success(datos.info);
				mostrarform(false);
				limpiar();
			}else{
				alertify.error(datos.info);
			}
		}
	});
}
//Función para desactivar registros
function desactivar(id_programa) {
	alertify.confirm('Desactivar Programa', "¿Está Seguro de desactivar el programa?", function () {
		$.post("../controlador/programa.php?op=desactivar", { id_programa: id_programa }, function (e) {
			// console.log(e);
			if (e == 1) {
				alertify.success("Programa Desactivado");
				tabla.ajax.reload();
			}
			else {
				alertify.error("Programa no se puede desactivar");
			}
		});
	},function () { alertify.error('Cancelado') });
}

//Función para activar registros
function activar(id_programa) {
	alertify.confirm('Activar Programa', '¿Está Seguro de activar el Programa?', function () {
		$.post("../controlador/programa.php?op=activar", { id_programa: id_programa }, function (e) {
			if (e == 1) {
				alertify.success("Programa Activado");
				tabla.ajax.reload();
			}else {
				alertify.error("Programa no se puede activar");
			}
		});
	}, function () { alertify.error('Cancelado') });
}
function cortes(id, cant, estado) {
	//console.log(id+' '+cant+' '+estado);
	if (estado == "1") {
		$.post("../controlador/programa.php?op=listarCortes", { id_programa: id, cantidad: cant }, function (e) {
			//console.log(e);
			var r = JSON.parse(e);
			if (r.status == "ok") {
				$("#aggcortes").modal("show");
				$(".conte").html(r.conte);
			} else {
				alertify.error(r.status);
			}
		});
	} else {
		alertify.error('No es posible agrega el porcentaje porqué el programa esta inhabilitado.');
	}
}
function agregarCorte(e) {
	e.preventDefault();
	var formData = new FormData($("#form2")[0]);
	$.ajax({
		"type": "POST",
		"url": "../controlador/programa.php?op=agregar",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			//console.log(datos);
			var r = JSON.parse(datos);
			if (r.status == "ok") {
				alertify.success(r.result);
				$("#form2")[0].reset();
				$("#aggcortes").modal("hide");
			} else {
				alertify.error(r.status);
			}
		}
	});
}
function monetizar(id_programa) {// funcion para agregar valores a los programas
	$.post("../controlador/programa.php?op=monetizar", { id_programa: id_programa }, function (data) {
		data = JSON.parse(data);
		var valor_pecuniario = data["0"];
		$("#listadoregistros").hide();
		$("#monetizar").show();
		$("#id_programa_monetizar").val(id_programa);
		$("#valor_pecuniario").val(valor_pecuniario);
		if (valor_pecuniario > 0) {
			$("#btnGuardarPrecioPecuniario").hide();
			$("#btnGuardarEditarPecuniario").show();
			$("#monetizarsemestres").show();
			$("#id_programa_monetizar_semestres").val(id_programa);
			tablaprecios(id_programa);

		} else {
			$("#btnGuardarPrecioPecuniario").show();
			$("#btnGuardarEditarPecuniario").hide();
		}
		$("#filaagregar").hide();
		$("#titulo").html("");
		$("#titulo").append(data["1"]);
	});
}
function guardarpecuniario(e2) {
	e2.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulariomonetizar")[0]);
	$.ajax({
		"url": "../controlador/programa.php?op=guardarpecuniario",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			data = JSON.parse(datos);
			var id_programa = (data["0"]);// contiene el id del programa este rsultado
			alertify.success("Valor guardado");
			monetizar(id_programa);
		}
	});
	limpiar();
}
function guardarsemestres(e3) {
	e3.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulariomonetizarsemestres")[0]);
	$.ajax({
		"url": "../controlador/programa.php?op=guardarsemestres",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			data = JSON.parse(datos);
			var id_programa = data["0"];
			alertify.success("Valor semestre guardado");
			tablaprecios(id_programa);
		}
	});
	limpiar();
}
function actualizarpecuniario() {
	var id_programa = $("#id_programa_monetizar").val();
	var valor = $("#valor_pecuniario").val();
	$.post("../controlador/programa.php?op=actualizarpecuniario", { id_programa: id_programa, valor: valor }, function (data) {
		data = JSON.parse(data);
		alertify.success("Pecuniario actualizado");
	});
}
function tablaprecios(id_programa) {
	$.post("../controlador/programa.php?op=tablaprecios", { id_programa: id_programa }, function (data) {
		data = JSON.parse(data);
		$("#tabla_precios").show();
		$("#tabla_precios").html("");
		$("#tabla_precios").append(data["0"]);
	});
}
//Función para activar registros
function eliminar(id_lista_precio_programa, id_programa) {
	alertify.confirm("Eliminar precio semestre", "¿Desea Eliminar este valor?", function () {
		$.post("../controlador/programa.php?op=eliminar", { id_lista_precio_programa: id_lista_precio_programa }, function (datos){
			var r = JSON.parse(datos);
			if (r.status == 1) {
				alertify.success("Precio eliminado");
				tablaprecios(id_programa);
			}else {
				alertify.error("precio no se pudo  Eliminar");
			}
		});
	}
		, function () { alertify.error('Cancelado') });
}
function editarvalores(e4) {
	e4.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioeditarvalores")[0]);
	$.ajax({
		"url": "../controlador/programa.php?op=editarvalores",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			var r = JSON.parse(datos);
			if (r.status == 1) {
				$("#ModalEditar").modal("hide");
				alertify.success("Precio editado");
				tablaprecios(r.id_programa);
			}else {
				alertify.error("precio no se pudo Editar " + r.status);
			}
		}
	});
}
function mostrareditar(id_lista_precio_programa, id_programa) {
	$.post("../controlador/programa.php?op=mostrareditar", { id_lista_precio_programa: id_lista_precio_programa }, function (data){
		// console.log(data);
		data = JSON.parse(data);
		if (Object.keys(data).length > 0) {
			$("#ModalEditar").modal("show");
			$("#id_lista_precio_programa_m").val(data.id_lista_precio_programa);
			$("#id_programa_m").val(data.id_programa);
			$("#semestre_m").val(data.semestre);
			$("#ordinaria_m").val(data.matricula_ordinaria);
			$("#aporte_m").val(data.aporte_social);
			$("#extra_m").val(data.matricula_extraordinaria);
			$("#valor_credito_m").val(data.valor_por_credito);
			$("#pago_renovar_m").val(data.pago_renovar);
			$("#pago_renovar_m").selectpicker('refresh');
		}
	});
}
function mostrar_agregar_programa() {
	var valor_cortes = 1; // Opción 1: Asignar un valor directamente
	$("#corte").change(function () {
		valor_cortes = parseInt($(this).val());
		if (valor_cortes == 1) {
			$("#corte1").show();
			$("#corte2").hide();
		} else {
			$("#corte1").hide();
			$("#corte2").show();
		}
	});
	$.post("../controlador/programa.php?op=mostrar_agregar_programa", { cortes_cantidad: valor_cortes }, function (data) {
		// console.log(data);
		data = JSON.parse(data);
		$("#cod_programa_pea").val(data.ultimo_pea);
		$("#ciclo").prop('', false);
		$("#div_cortes").html($.parseHTML(data.cortes_cantidad));
	});
}
//Función mostrar formulario
function mostrarform(flag) {
	//limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnagregar").hide();
	}else{
		listar();
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}
//Función cancelarform
function cancelarform() {
	limpiar();
	mostrarform(false);
}
function cantidad_cortes(datos) {
	var cortes_cantidad = $("#corte").val();
	$.ajax({
		"url": "../controlador/programa.php?op=mostrar_agregar_programa",
		"method": "POST",
		"data": { "cortes_cantidad": cortes_cantidad },
		success: function (response) {
			var data = JSON.parse(response);
			// Actualizar el contenido del div con el ID 'div_cortes'
			$("#div_cortes").html(data.cortes_cantidad);
			$(".campo-corte").attr("disabled", false);
			if (datos.exito == 1) {
				for (i = 1; i <= Object.keys(datos).length; i++) {
					$("#corte" + i).val(datos["c" + i]);
					$(".campo-corte").attr("disabled", true);
				}
			}
		},
		error: function (xhr, status, error) {
			console.error(error);
		}
	});
}
init();