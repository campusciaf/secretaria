var tabla;
//Función que se ejecuta al inicio
function init() {
	$("#precarga").hide();
	mostrarform(false);
	$("#listadoregistros").hide();
	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
	$("#fomaddmodalidad").on("submit", function (e2) {
		guardaryeditarmodalidad(e2);
	});
	$.post("../controlador/materiasprograma.php?op=selectEscuela", function (r) {
		$("#escuela").html(r);
		$('#escuela').selectpicker('refresh');
	});
	$.post("../controlador/materiasprograma.php?op=selectPrograma", function (r) {
		$("#programa_ac").html(r);
		$('#programa_ac').selectpicker('refresh');
	});
	$.post("../controlador/materiasprograma.php?op=selectPrograma", function (r) {
		$("#programa").html(r);
		$('#programa').selectpicker('refresh');
	});
	$.post("../controlador/materiasprograma.php?op=selectEscuela", function (r) {
		$("#escuela").html(r);
		$('#escuela').selectpicker('refresh');
	});
	$.post("../controlador/materiasprograma.php?op=selectArea", function (r) {
		$("#area").html(r);
		$('#area').selectpicker('refresh');
	});
}
//Función limpiar
function limpiar() {
	$("#id").val("");
	$("#nombre").val("");
	$("#semestre").val("");
	$("#area").val("");
	$("#area").selectpicker('refresh');
	$("#creditos").val("");
	$("#codigo2").val("");
	$("#presenciales").val("");
	$("#independiente").val("");
	$("#escuela").val("");
	$("#escuela").selectpicker('refresh');
}
//Función mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
		$("#seleccionprograma").hide();
	}else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#seleccionprograma").show();
	}
}
//Función cancelarform
function cancelarform() {
	limpiar();
	mostrarform(false);
}
//Función Listar
function listar(programa) {
	// alert(programa);
	$("#programa").val(programa);
	$("#programa").selectpicker("refresh");
	$("#listadoregistros").show();
	$("#precarga").show();
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	// $('#tbllistado').DataTable().ajax.reload();
	tabla = $('#tbllistado').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		"dom": 'Bfrtip',
		"buttons": [{
				"extend": 'excelHtml5',
				"text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				"titleAttr": 'Excel'
			},{
				"extend": 'print',
				"text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				"messageTop": '<div style="width:50%;float:left">Reporte materias Académicos<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
				"title": 'materias Académicos',
				"titleAttr": 'Print'
			},
		],
		"ajax":{
			"url": '../controlador/materiasprograma.php?op=listar&programa=' + programa,
			"type": "get",
			"dataType": "json",
			error: function (e) {
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 14,//Paginación
		"order": [[2, "asc"]],
		'initComplete': function (settings, json) {
			$("#btnagregar").show();
			$("#precarga").hide();
		},
	});
	$("#precarga").hide();
}
//mostrar materias
function mostrar(id) {
	$.post("../controlador/materiasprograma.php?op=mostrar", { id: id }, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);
		$("#programa").val(data.programa);
		$("#programa").selectpicker('refresh');
		$("#nombre").val(data.nombre);
		$("#semestre").val(data.semestre);
		$("#area").val(data.area);
		$("#area").selectpicker('refresh');
		$("#creditos").val(data.creditos);
		$("#codigo2").val(data.codigo);
		$("#presenciales").val(data.presenciales);
		$("#independiente").val(data.independiente);
		$("#escuela").val(data.escuela);
		$("#escuela").selectpicker('refresh');
		$("#id").val(data.id);
		$("#modelo").val(data.modelo);
		$("#modelo").selectpicker('refresh');
		$("#modalidad_grado").val(data.modalidad_grado);
		$("#modalidad_grado").selectpicker('refresh');
	});
}
//Guaudar o editar materia
function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		"url": "../controlador/materiasprograma.php?op=guardaryeditar",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			alertify.success(datos);
			mostrarform(false);
			$('#tbllistado').DataTable().ajax.reload();
		}
	});
}
//Guardar o editar Modalidad
function guardaryeditarmodalidad(e2) {
	e2.preventDefault();
	var formData = new FormData($("#fomaddmodalidad")[0]);
	$.ajax({
		"url": "../controlador/materiasprograma.php?op=guardaryeditarmodalidad",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (data) {
			data = JSON.parse(data);
			if (data.datos == 1) {
				alertify.success("Modalidad agregada");
				modalidadGrado(data.id);
				$("#modalidad_add").val('');
			}else {
				alertify.error("Modalidad no agregada");
			}
		}
	});
}
//modalidad de grado
function modalidadGrado(id_materia) {
	$.post("../controlador/materiasprograma.php?op=ModalidadGrado", { id_materia: id_materia }, function (data, status) {
		data = JSON.parse(data);
		$("#id_materia_add").val(data.id);
		$("#modal_modalidad_grado").modal("show");
		$("#resultado_modalidad").html(data.datos)
	});
}
//Función para activar registros
function eliminarmodalidad(id_materias_ciafi_modalidad, id_materia) {
	alertify.confirm('Eliminar Modalidad', '¿Está Seguro de eliminar la modalidad?', function () {
		$.post("../controlador/materiasprograma.php?op=eliminarmodalidad", { id_materias_ciafi_modalidad: id_materias_ciafi_modalidad }, function (data) {
			data = JSON.parse(data);
			if (data.datos == 1) {
				alertify.success("Modalidad Eliminada");
				modalidadGrado(id_materia);
			}else {
				alertify.error("Modalidad no se pudo eliminar");
			}
		});
	}, function () { alertify.error('Cancelado') });
}
init();