var tabla;
//Función que se ejecuta al inicio
function init() {
	listar();
	mostrarform(false);
	$("#precarga").show();
	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
	$("#formularioverificar").on("submit", function (e1) {
		verificardocumento(e1);
	});
	$("#formularionovedadjornada").on("submit", function (e2) {
		actualizarCambioJornada(e2);
	});
	$("#formularionovedadperiodo").on("submit", function (e3) {
		actualizarCambioPeriodo(e3);
	});
	$("#formularionovedadgrupo").on("submit", function (e4) {
		actualizarCambioGrupo(e4);
	});
	$.post("../controlador/rematricula.php?op=selectPrograma", function (r) {
		$("#fo_programa").html(r);
		$('#fo_programa').selectpicker('refresh');
	});
	$.post("../controlador/rematricula.php?op=selectJornada", function (r) {
		$("#jornada_e").html(r);
		$('#jornada_e').selectpicker('refresh');
	});
	$.post("../controlador/rematricula.php?op=selectPeriodo", function (r) {
		$("#periodo").html(r);
		$('#periodo').selectpicker('refresh');
	});
	$.post("../controlador/rematricula.php?op=selectGrupo", function (r) {
		$("#grupo").html(r);
		$('#grupo').selectpicker('refresh');
	});
}
//Función limpiar
function limpiar() {
	$("#id_credencial").val("");
	$("#credencial_nombre").val("");
	$("#credencial_nombre_2").val("");
	$("#credencial_apellido").val("");
	$("#credencial_apellido_2").val("");
	//$("#credencial_identificacion").val("");
	$("#credencial_login").val("");
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
	} else {
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
function verificardocumento(e1) {
	$("#listadomaterias").hide();
	e1.preventDefault();
	//$("#btnVerificar").prop("disabled",true);
	var formData = new FormData($("#formularioverificar")[0]);
	$.ajax({
		"url": "../controlador/rematricula.php?op=verificardocumento",
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
			} else {
				id_credencial = data["0"]["0"];
				$("#mostrardatos").show();
				alertify.success("Esta registrado");
				listar(id_credencial);
			}
		}
	});
}
//Función Listar
function listar() {
	$("#listadoregistros").show();
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistado').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		"dom": 'Bip',
		"buttons": [],
		"ajax": {
			"url": '../controlador/rematricula.php?op=listar',
			"type": "get",
			"dataType": "json",
			"error": function (e) {
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		'initComplete': function (settings, json) {
			$("#precarga").hide();
		},
	});
}
function mostrardatos() {
	$.post("../controlador/rematricula.php?op=mostrardatos", {}, function (data, status) {
		data = JSON.parse(data);
		$("#mostrardatos").html("");
		$("#mostrardatos").append(data["0"]["0"]);
	});
}
function mostrarmaterias(id_programa_ac, id_estudiante) {
	$("#precarga").show();
	$.post("../controlador/rematricula.php?op=mostrarmaterias", { id_programa_ac: id_programa_ac, id_estudiante: id_estudiante }, function (data, status) {
		data = JSON.parse(data);
		if (data["0"]["1"] == 1) {
			//$("#myModalAgregarPrograma").modal("show");
			$("#listadoregistros").hide();
			$("#listadomaterias").show();
			$("#listadomaterias").html("");
			$("#listadomaterias").append(data["0"]["0"]);
			$("#precarga").hide();
		} else {
			$("#listadomaterias").html("");
			$("#listadomaterias").append(data["0"]["0"]);
			location.href = "https://ciaf.digital";
		}
	});
}
function matriculaprograma(id_credencial) {
	$.post("../controlador/rematricula.php?op=matriculaprograma", { id_credencial: id_credencial }, function (data, status) {
		data = JSON.parse(data);
		$("#mostrardatos").html("");
		$("#mostrardatos").append(data["0"]["0"]);
	});
}
function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar2").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);
	var credencial = $("#credencial_identificacion").val();
	$.ajax({
		url: "../controlador/rematricula.php?op=guardaryeditar&credencial_identificacion=" + credencial,
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			data = JSON.parse(datos);
			alertify.success(data["0"]["0"]);
			mostrarform(false);
			listar(data["0"]["1"]);
		}
	});
	limpiar();
}
function addcompraperdida(id_estudiante, id_materia, id_programa_ac) {
	$("#precarga").show();
	$.post("../controlador/rematricula.php?op=addcompraperdida", { id_estudiante: id_estudiante, id_materia: id_materia, id_programa_ac: id_programa_ac }, function (data, status) {
		data = JSON.parse(data);
		if (data["0"]["0"] == 1) {
			alertify.success("Matriculada");
			mostrarmaterias(id_programa_ac, id_estudiante);
		}
		else if (data["0"]["0"] == 2) {
			alertify.error("error, no se puede matricular");
			$("#precarga").hide();
		}
		else if (data["0"]["0"] == 3) {
			alertify.error("error, creditos superados");
			$("#precarga").hide();
		}
		else if (data["0"]["0"] == 4) {
			alertify.error("error, esta tratando de matricular un prerequisito, podemos reportarlo");
			$("#precarga").hide();
		}
		else {
			alertify.error("Fraude, sus datos fueron reportados");
			$("#precarga").hide();
		}
	});
}
function addcompra(id_estudiante, id_materia, id_programa_ac) {
	alertify.confirm("Matricular materia", "¿Desea matricular esta materia, una vez hecho no se puede devolver los cambios?", function () {
		$("#precarga").show();
		$.post("../controlador/rematricula.php?op=addcompra", { id_estudiante: id_estudiante, id_materia: id_materia, id_programa_ac: id_programa_ac }, function (data, status) {
			data = JSON.parse(data);
			console.log(data["0"]["0"]);
			if (data["0"]["0"] == 1) {
				alertify.success("Matriculada");
				mostrarmaterias(id_programa_ac, id_estudiante);
			} else if (data["0"]["0"] == 2) {
				alertify.error("error, no se puede matricular");
				$("#precarga").hide();
			} else if (data["0"]["0"] == 3) {
				alertify.error("error, creditos superados");
				$("#precarga").hide();
			} else if (data["0"]["0"] == 4) {
				alertify.error("error, esta tratando de matricular un prerequisito");
				$("#precarga").hide();
			} else {
				alertify.error("Fraude, sus datos fueron reportados");
				$("#precarga").hide();
			}
		});
	}, function () { alertify.error('Cancelado') });
}
function eliminarMateria(id_estudiante, id_programa_ac, id_materia, semestres_del_programa, id_materia_matriculada, promedio_materia_matriculada) {
	$("#precarga").show();
	$.post("../controlador/rematricula.php?op=eliminarMateria", { id_estudiante: id_estudiante, id_materia: id_materia, semestres_del_programa: semestres_del_programa, id_materia_matriculada: id_materia_matriculada, promedio_materia_matriculada: promedio_materia_matriculada }, function (data, status) {
		data = JSON.parse(data);
		if (data == true) {
			alertify.success("Materia eliminada");
			mostrarmaterias(id_programa_ac, id_estudiante);
		} else {
			alertify.error("error");
		}
	});
}
function cambioJornada(id_materia, jornada, ciclo, id_programa_ac, id_estudiante) {
	$("#myModalMatriculaNovedad").modal("show");
	$("#id_materia").val(id_materia);
	$("#ciclo").val(ciclo);
	$("#id_programa_ac").val(id_programa_ac);
	$("#id_estudiante").val(id_estudiante);
	$("#jornada_e").val(jornada);
	$("#jornada_e").selectpicker('refresh');
}
function cambioPeriodo(id_materia, periodo, ciclo, id_programa_ac, id_estudiante) {
	$("#myModalMatriculaNovedadPeriodo").modal("show");
	$("#id_materia_j").val(id_materia);
	$("#ciclo_j").val(ciclo);
	$("#id_programa_ac_j").val(id_programa_ac);
	$("#id_estudiante_j").val(id_estudiante);
	$("#periodo").val(periodo);
	$("#periodo").selectpicker('refresh');
}
function cambioGrupo(id_materia, periodo, ciclo, id_programa_ac, id_estudiante, grupo) {
	$("#myModalMatriculaNovedadGrupo").modal("show");
	$("#id_materia_g").val(id_materia);
	$("#ciclo_g").val(ciclo);
	$("#id_programa_ac_g").val(id_programa_ac);
	$("#id_estudiante_g").val(id_estudiante);
	$("#grupo").val(grupo);
	$("#grupo").selectpicker('refresh');
}
//Función Listar
function actualizarCambioJornada(e2) {
	e2.preventDefault();
	//$("#btnVerificar").prop("disabled",true);
	var formData = new FormData($("#formularionovedadjornada")[0]);
	$.ajax({
		"url": "../controlador/rematricula.php?op=actualizarJornada",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			datos = JSON.parse(datos);
			$("#myModalMatriculaNovedad").modal("hide");
			var id_programa_ac = datos["0"]["0"];
			var id_estudiante = datos["0"]["1"];
			alertify.success("Cambio Correcto");
			mostrarmaterias(id_programa_ac, id_estudiante);
		}
	});
}
//Función Listar
function actualizarCambioPeriodo(e3) {
	e3.preventDefault();
	//$("#btnVerificar").prop("disabled",true);
	var formData = new FormData($("#formularionovedadperiodo")[0]);
	$.ajax({
		"url": "../controlador/rematricula.php?op=actualizarPeriodo",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			datos = JSON.parse(datos);
			$("#myModalMatriculaNovedadPeriodo").modal("hide");
			var id_programa_ac = datos["0"]["0"];
			var id_estudiante = datos["0"]["1"];
			alertify.success("Cambio Correcto");
			mostrarmaterias(id_programa_ac, id_estudiante);
		}
	});
}
//Función Listar
function actualizarCambioGrupo(e4) {
	e4.preventDefault();
	//$("#btnVerificar").prop("disabled",true);
	var formData = new FormData($("#formularionovedadgrupo")[0]);
	$.ajax({
		"url": "../controlador/rematricula.php?op=actualizarGrupo",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			datos = JSON.parse(datos);
			$("#myModalMatriculaNovedadGrupo").modal("hide");
			var id_programa_ac = datos["0"]["0"];
			var id_estudiante = datos["0"]["1"];
			alertify.success("Cambio Correcto");
			mostrarmaterias(id_programa_ac, id_estudiante);
		}
	});
}
function descargarrecibo(id_estudiante) {
	$.post(
		"../controlador/rematricula.php?op=descargarrecibo",
		{ id_estudiante: id_estudiante },
		function (data, status) {
			data = JSON.parse(data);
			$("#verrecibo").modal("show");
			$("#datosrecibo").html("");
			$("#datosrecibo").append(data["0"]["0"]);
		}
	);
}
function imprSelec(historial) {
	var ficha = document.getElementById(historial);
	var ventimp = window.open(' ', 'popimpr');
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
}
function verestadocredito(id_persona) {// ver estado del credito con el id persona de la tabla sofi persona
	$.post(
		"../controlador/rematricula.php?op=verestadocredito",
		{ id_persona: id_persona },
		function (data, status) {
			data = JSON.parse(data);
			$("#estadocredito").html("");
			$("#estadocredito").append(data["0"]["0"]);
			$("#verestadocredito").modal("show");
			$
		}
	);
}
function addmodalidad(id_programa_ac, id_materia, id_estudiante, id_materias_ciafi_modalidad) {
	alertify.confirm("Matricular modalidad", "¿Desea matricular esta materia, una vez hecho no se puede devolver los cambios?", function () {
		$("#precarga").show();
		$.post("../controlador/rematricula.php?op=addmodalidad", { id_programa_ac: id_programa_ac, id_materia: id_materia, id_estudiante: id_estudiante, id_materias_ciafi_modalidad: id_materias_ciafi_modalidad }, function (data, status) {
			data = JSON.parse(data);
			// console.log(data["0"]["0"]);
			if (data["0"]["0"] == 1) {// todo correcto
				alertify.success("Modalidad matriculada");
				mostrarmaterias(id_programa_ac, id_estudiante);
			}
			else if (data["0"]["0"] == 2) {// ya esta matriculada
				alertify.error("error, no se puede matricular");
				$("#precarga").hide();
			}
			else if (data["0"]["0"] == 4) {
				alertify.error("Fraude, sus datos fueron reportados");
				$("#precarga").hide();
			}
			else {
				alertify.error("Fraude, sus datos fueron reportados");
				$("#precarga").hide();
			}
		});
	}
		, function () { alertify.error('Cancelado') });
}
init();
