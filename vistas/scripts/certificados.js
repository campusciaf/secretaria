var lista_ids = ['', "calificaciones_todos", "calificaciones_actual", "calificaciones_anterior", "estudio_actual", "estudio_siguiente", "cesantias", "paz_y_salvo", "buena_conducta"]
var id_seleccionado = 0;
function init() {
	$("#precarga").hide();
	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
}
//Función para guardar o editar
function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#precarga").show();
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../controlador/certificados.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			datos = JSON.parse(datos);
			if (datos == 1) {
				$("#cargar_diploma").modal("hide");
				$("#btnGuardar").prop("disabled", true);
				alertify.success("Certificado Correcto");
				$("#precarga").hide();
			}
			else if (datos == 1) {
				$("#btnGuardar").prop("disabled", true);
				$("#cargar_diploma").modal("hide");
				alertify.error("Certificado no se pudo cargar");
				$("#precarga").hide();
			}
			else {
				alertify.error("Formato incorrecto solo (PDF)");
				$("#precarga").hide();
			}
		}
	});
	limpiar();
}
function cargarFormatosCertificados() {
	$.post("../controlador/certificados.php?op=selectcertificados", function (r) {
		$("#consulta").html(r);
		$('#consulta').selectpicker('refresh');
	});
}
/* Función para limpiar los campos al momento de realizar una nueva búsqueda */
function limpiarInfo() {
	$("#user-photograph").attr("src", "../files/null.jpg");
	$("#nombre_completo_estudiante").html("");
	$("#correo_estudiante").html("");
	$("#info_programa_matriculado").html("");
	$("#info_jornada_matriculado").html("");
	$("#id_credencial").val('');
	$("#id_estudiante").val('');
	$("#consulta").val('a');
	$("#contenido_vista_previa").html("");
	$("#calificaciones_actual").attr("hidden", true);
	$("#calificaciones_todos").attr("hidden", true);
	$("#calificaciones_anterior").attr("hidden", true);
	$("#estudio_actual").attr("hidden", true);
	$("#pie_certificado").attr("hidden", true);
	$("#cesantias").attr("hidden", true);
	$("#numero_sn").attr("hidden", true);
	$("#buena_conducta").attr("hidden", true);
	$("#imprimir").attr("hidden", true);
	$("#descargarCertificado").attr("hidden", true);
	$("#generador_certificados").attr("hidden", true);
	$("#paz_y_salvo").attr("hidden", true);
}
/**********************/
/* Código para buscar en la base de datos al estudiante y 
cargar la informaciòn del perfil al cual se le generará el certificado */
$("#buscar_estudiante").off("click").on("click", function (e) {
	limpiarInfo();
	var cedula = $("#input_cedula").val();
	/* Condicional para verificar que si se haya ingresado un número de documento válido */
	if (cedula == "") {
		$("#informacion_estudiante").prop("hidden", "true");
		alertify.error("Digite por favor un documento a buscar");
	} else {
		/* Ajax para validar en tiempo real el documento del estudiante y revisar que si esté en la base de datos */
		$.ajax({
			type: 'POST',
			url: '../controlador/certificados.php?op=verificar',
			data: { cedula: cedula },
			success: function (msg) {
				if (msg == 1) {
					$("#informacion_estudiante").prop("hidden", "true");
					alertify.error("Documento no existe en la base de datos.");
				} else {
					datos = JSON.parse(msg);
					var id_credencial = datos[0]['id_credencial'];
					listar(id_credencial);
					$("#informacion_estudiante").removeAttr("hidden");
					datos = JSON.parse(msg);
					$("#id_credencial").val(datos[0]['id_credencial']);
					nombre_completo = datos[0]['credencial_nombre'] + " " + datos[0]['credencial_nombre_2'] + " " + datos[0]['credencial_apellido'] + " " + datos[0]['credencial_apellido_2'];
					$("#nombre_completo_estudiante").html(nombre_completo + "<br>");
					$("#correo_estudiante").html(datos[0]['credencial_login']);
					var ruta = "../files/estudiantes/" + datos[0]['credencial_identificacion'] + ".jpg";
					revisarFichero(ruta);
					// cargarInformacion();
				}
			},
			error: function () {
				alertify.error("Hay un error...");
			}
		});
	}
});
/* Función para listar los programas en los que se encuentra matriculado el estudiante */
function listar(id_credencial) {
	$("#listadoregistros").removeAttr("hidden");
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistado').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',
			buttons: [
				{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel" style="color: green"></i>',
					titleAttr: 'Excel'
				},
				{
					extend: 'print',
					text: '<i class="fas fa-print" style="color: #ff9900"></i>',
					messageTop: '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
					title: 'Programas Académicos',
					titleAttr: 'Print'
				},
			],
			"ajax":
			{
				url: '../controlador/certificados.php?op=listar&id_credencial=' + id_credencial,
				type: "get",
				dataType: "json",
				error: function (e) {
				}
			},
			"bDestroy": true,
			"scrollX": false,
			"iDisplayLength": 10,//Paginación
			"order": [[2, "asc"]],//Ordenar (columna,orden)
		}).DataTable();
	// mostrardatos(id_credencial);
}
/* Función para mostrar la opción de impresión y ocultar la tabla */
function mostrar(id_credencial, id_estudiante, id_programa_ac) {
	cargarFormatosCertificados();
	$("#id_credencial").val(id_credencial);
	$("#id_estudiante").val(id_estudiante);
	$("#id_programa_ac").val(id_programa_ac);
	$("#listadoregistros").attr("hidden", true);
	$("#generador_certificados").removeAttr("hidden");
	$("#id_credencial2").val(id_credencial);
	$("#id_estudiante2").val(id_estudiante);
	$("#id_programa_ac2").val(id_programa_ac);
}
/* Función para cargar los datos del programa del estudiante */
function cargarInformacion() {
	var id_credencial = $("#id_credencial").val();
	$.ajax({
		type: 'POST',
		url: '../controlador/certificados.php?op=cargar',
		data: { id_credencial: id_credencial },
		success: function (msg) {
			datos = JSON.parse(msg);
			/* Bucle para validar si el estudiante está matriculado en más de un programa
			para imprimirlo en la vista */
			/*
			for (var contador = 0; contador < datos.length; contador++) {
				$("#info_programa_matriculado").append(datos[contador]['fo_programa']+"<br>");
				$("#info_jornada_matriculado").append(datos[contador]['jornada_e']+"<br>");
				$("#id_estudiante").val(datos[contador]['id_estudiante']);
			}
			*/
		},
		error: function () {
			alertify.error("Hay un error...");
		}
	});
}
/* Código para validar que el usuario tenga foto en la base de datos */
function revisarFichero(data) {
	$.ajax({
		url: data,
		type: 'HEAD',
		error: function () {
			alertify.success("Por favor agregar Fotografía");
		},
		success: function () {
			$("#user-photograph").attr("src", data);
		}
	});
}
/* Código para buscar el historial de certificados expedidos al estudiante consultado */
$("#certificadosExpedidos").off("click").on("click", function (e) {
	$("#cuerpo_tabla").html('');
	$("#certificadosExpedidos_modal").modal({ backdrop: 'static', keyboard: false });
	cargarCertificadosExpedidos();
});
/* Código para cargar el historial de certificados expedidos*/
function cargarCertificadosExpedidos() {
	var credencial = $("#id_credencial").val();
	var cedula = $("#input_cedula").val();
	/* Validar que no haya un dataTable creado, y en caso de existir, destruirlo */
	if ($.fn.DataTable.isDataTable('#expedidosTabla')) {
		$('#expedidosTabla').DataTable().destroy();
	}
	var nombre_completo = $("#nombre_completo_estudiante").text();
	var fechahoy = new Date();
	var fechahoyesp = getDatennow(1, fechahoy);
	/* Cargar DataTable para ver los certificados expedidos */
	$('#expedidosTabla').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		responsive: true,
		"stateSave": true,
		"dom": "Bfrtip",
		buttons: [
			{
				extend: 'copyHtml5',
				text: '<i class="fa fa-copy" style="color: blue"></i>',
				titleAttr: 'Copy'
			},
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'csvHtml5',
				text: '<i class="fa fa-file-alt"></i>',
				titleAttr: 'CSV'
			},
			{
				extend: 'pdfHtml5',
				text: '<i class="fa fa-file-pdf" style="color: red"></i>',
				titleAttr: 'PDF'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Estudiante: </b>' + nombre_completo + '<br><b>Fecha Reporte: </b>' + fechahoyesp + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/imagenes/logo_nuevo.png" width="280px"></div>',
				title: 'Historial',
				titleAttr: 'Print'
			},
		],
		"ajax":
		{
			url: '../controlador/certificados.php?op=historialCertificadosExpedidos',
			type: 'POST',
			data: { credencial: credencial, cedula: cedula },
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 20,
		//"order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
/* Función para generar el certificado y tener una vista previa */
$("#ver_certificado").on("submit", function (e1) {
	e1.preventDefault();
	var tipo_certificado = $("#consulta").val();
	var id_estudiante = $("#id_estudiante").val();
	var id_credencial = $("#id_credencial").val();
	var fechahoy = new Date();
	var fechahoyesp = getDatennow(1, fechahoy);
	id_seleccionado = lista_ids[tipo_certificado];
	console.log(id_credencial);
	$("#verificar").show();
	if (tipo_certificado == "1") {
		/* Si el certificado seleccionado es Todas las Calificaciones */
		limpiarModalCertificados();
		$.ajax({
			type: 'POST',
			url: '../controlador/certificados.php?op=cargarDatosEstudiante',
			data: { id_estudiante: id_estudiante, id_credencial: id_credencial },
			success: function (msg) {
				/* Se trae el arreglo con los datos consultados */
				datos = JSON.parse(msg);
				/* Habilitar el modal, el encabezado de los certificados y 
				el texto predeterminado de todas las calificaciones */
				$("#vistaprevia_modal").modal({ backdrop: 'static', keyboard: false });
				$('#encabezado_certificados').removeAttr("hidden");
				$("#calificaciones_todos").removeAttr("hidden");
				$("#pie_certificado").removeAttr("hidden");
				$("#fecha_certificado").html(fechahoyesp);
				/* Para rellenar los datos del párrafo del certificado */
				$("#certificado_1_nombre_estudiante").html(datos[0][0]);
				$("#certificado_1_tipo_doc").html(datos[0][1]);
				$("#certificado_1_identificacion").html(datos[0][2]);
				$("#certificado_1_expedido_en").html(datos[0][3]);
				$("#certificado_1_romano").html(datos[0][4]);
				$("#certificado_1_programa").html(datos[0][5] + datos[0][10]);
				/* Se asignan las variables que requiere la función 
				que carga las calificaciones en el certificado*/
				var ciclo = datos[0][6];
				var semestres_programa = datos[0][7];
				var semestre_estudiante = datos[0][8];
				cargarTodasCalificaciones(id_estudiante, ciclo, semestres_programa, semestre_estudiante);
			},
			error: function () {
				alertify.error("Hay un error...");
			}
		});
	} else if (tipo_certificado == "2") {
		/* Si el certificado es Calificaciones Semestre Actual */
		limpiarModalCertificados();
		$.ajax({
			type: 'POST',
			url: '../controlador/certificados.php?op=cargarDatosEstudiante',
			data: { id_estudiante: id_estudiante, id_credencial: id_credencial },
			success: function (msg) {
				/* Se trae el arreglo con los datos consultados */
				datos = JSON.parse(msg);
				var periodo_activo = datos[0][9];
				var periodo_actual = datos[0][11];
				/* Condicional para validar que el estudiante se encuentra activo en este 
				semestre y es posible generar el certificado */
				if (periodo_activo == periodo_actual) {
					/* Habilitar el modal, el encabezado de los certificados y 
					el texto predeterminado de las calificaciones del semestre actual */
					$("#vistaprevia_modal").modal({ backdrop: 'static', keyboard: false });
					$('#encabezado_certificados').removeAttr("hidden");
					$("#calificaciones_actual").removeAttr("hidden");
					$("#pie_certificado").removeAttr("hidden");
					$("#fecha_certificado").html(fechahoyesp);
					/* Para rellenar los datos del párrafo del certificado */
					$("#certificado_2_nombre_estudiante").html(datos[0][0]);
					$("#certificado_2_tipo_doc").html(datos[0][1]);
					$("#certificado_2_identificacion").html(datos[0][2]);
					$("#certificado_2_expedido_en").html(datos[0][3]);
					$("#certificado_2_romano").html(datos[0][4]);
					$("#certificado_2_programa").html(datos[0][5] + datos[0][10]);
					$("#certificado_2_periodo_actual").html(datos[0][11]);
					/* Se asignan las variables que requiere la función 
					que carga las calificaciones en el certificado*/
					var ciclo = datos[0][6];
					var semestre_estudiante = datos[0][8];
					cargarSemestreActual(id_estudiante, ciclo, semestre_estudiante, periodo_activo);
				} else {
					/* Si el periodo activo del estudiante es diferente al periodo actual 
					que tiene el sistema no le permitirá generar el certificado*/
					alertify.error("No es posible generar el certificado.");
				}
			},
			error: function () {
				alertify.error("Hay un error...");
			}
		});
	} else if (tipo_certificado == "3") {
		/* Si el certificado es Calificaciones Semestre Anterior */
		limpiarModalCertificados();
		$.ajax({
			type: 'POST',
			url: '../controlador/certificados.php?op=cargarDatosEstudiante',
			data: { id_estudiante: id_estudiante, id_credencial: id_credencial },
			success: function (msg) {
				/* Se trae el arreglo con los datos consultados */
				datos = JSON.parse(msg);
				var periodo_activo = datos[0][9];
				var periodo_actual = datos[0][11];
				var estado = datos[0][14];
				var semestre_estudiante = datos[0][8];
				/* Condicional para validar que el estudiante se encuentra matriculado en este 
				semestre y es posible generar el certificado */
				if (estado == 1) {
					/* Condicional para validar que el estudiante si está matriculado actualmente */
					if (periodo_activo == periodo_actual) {
						/* Si el estudiante está en primer semestre no generará semestre anterior que no existe*/
						if (semestre_estudiante == 1) {
							alertify.error("No existe semestre anterior");
						} else {
							/* Si el semestre actual es diferente a 1 se puede generar el certificado 
							Se asignan las variables necesarias para la función 
							que carga las calificaciones en el certificado */
							var ciclo = datos[0][6];
							var semestre_anterior = semestre_estudiante - 1;
							var periodo_anterior = datos[0][12];
							cargarSemestreAnterior(id_estudiante, ciclo, semestre_anterior, periodo_anterior);
							/* Convertir la variable semestre anterior en número romano para el certificado */
							romano = convertirSemestreRomano(1, semestre_anterior);
							/* Habilitar el modal, el encabezado de los certificados y 
							el texto predeterminado de las calificaciones del semestre anterior */
							$("#vistaprevia_modal").modal({ backdrop: 'static', keyboard: false });
							$('#encabezado_certificados').removeAttr("hidden");
							$("#calificaciones_anterior").removeAttr("hidden");
							$("#pie_certificado").removeAttr("hidden");
							$("#fecha_certificado").html(fechahoyesp);
							/* Para rellenar los datos del párrafo del certificado */
							$("#certificado_3_nombre_estudiante").html(datos[0][0]);
							$("#certificado_3_tipo_doc").html(datos[0][1]);
							$("#certificado_3_identificacion").html(datos[0][2]);
							$("#certificado_3_expedido_en").html(datos[0][3]);
							$("#certificado_3_romano").html(romano);
							$("#certificado_3_programa").html(datos[0][5] + datos[0][10]);
							$("#certificado_3_periodo_anterior").html(periodo_anterior);
						}
					} else {
						alertify.error("No es posible generar el certificado.");
					}
				} else {
					/* Si el estudiante no está matriculado no se puede generar el certificado */
					alertify.error("No es posible generar el certificado.");
				}
			},
			error: function () {
				alertify.error("Hay un error...");
			}
		});
	} else if (tipo_certificado == "4") {
		/* Si el certificado es de Estudio del Semestre Actual */
		limpiarModalCertificados();
		$.ajax({
			type: 'POST',
			url: '../controlador/certificados.php?op=cargarDatosEstudiante',
			data: { id_estudiante: id_estudiante, id_credencial: id_credencial },
			success: function (msg) {
				/* Se trae el arreglo con los datos consultados */
				datos = JSON.parse(msg);
				/* Se asignan las variables que se necesitan para la función actual */
				var periodo_activo = datos[0][9];
				var periodo_actual = datos[0][11];
				var estado = datos[0][14];
				var jornada = datos[0][15];
				var programa = datos[0][5];
				/* Se invoca la función que define el horario respecto al programa y la jornada del estudiante */
				var horario = definirHorario(jornada, programa);
				/* Condicional para validar que el estudiante esté matriculado actualmente */
				if (estado == 1) {
					/* Condicional para validar que el estudiante se encuentra activo en este 
					semestre y si es posible generar el certificado */
					$("#vistaprevia_modal").modal({ backdrop: 'static', keyboard: false });
					$('#encabezado_certificados').removeAttr("hidden");
					$('#estudio_actual').removeAttr("hidden");
					$("#pie_certificado").removeAttr("hidden");
					$("#fecha_certificado").html(fechahoyesp);
					/* Se llenan los campos del contenedor */
					$("#certificado_4_nombre_estudiante").html(datos[0][0]);
					$("#certificado_4_tipo_doc").html(datos[0][1]);
					$("#certificado_4_identificacion").html(datos[0][2]);
					$("#certificado_4_expedido_en").html(datos[0][3]);
					$("#certificado_4_semestre_activo").html(datos[0][4]);
					$("#certificado_4_programa").html(datos[0][5]);
					$("#certificado_4_periodo_actual").html(datos[0][11]);
					$("#certificado_4_jornada").html(datos[0][15]);
					$("#certificado_4_horario").html(horario);
				} else {
					/* Si el estudiante no está matriculado no se permite generar el certificado */
					alertify.error("No es posible generar el certificado");
				}
			},
			error: function () {
				alertify.error("Hay un error...");
			}
		});
	} else if (tipo_certificado == "5") {
		/* Si el certificado es de Estudio (Inscripción siguiente semestre)) */
		limpiarModalCertificados();
		$.ajax({
			type: 'POST',
			url: '../controlador/certificados.php?op=cargarDatosEstudiante',
			data: { id_estudiante: id_estudiante, id_credencial: id_credencial },
			success: function (msg) {
				/* Se trae el arreglo con los datos consultados y se asigna a sus 
				respectivas variables para las condiciones del programa*/
				datos = JSON.parse(msg);
				var semestre_estudiante = datos[0][8];
				var semestres_programa = datos[0][7];
				var estado = datos[0][14];;
				var jornada = datos[0][15];
				var programa = datos[0][5];
				/* Se invoca la función para definir el horario según la jornada y el programa */
				var horario = definirHorario(jornada, programa);
				/* Condicional para validar que el estudiante esté matriculado actualmente */
				if (estado == 1) {
					/* Condicional para validar si el estudiante se encuentra en el último semestre del programa,
					si es así no se podrá generar el certificado, no podría estar matriculado a un siguiente semestre */
					if (semestre_estudiante == semestres_programa) {
						alertify.error("No es posible generar este certificado");
					} else {
						semestre_siguiente = datos[0][16];
						romano = convertirSemestreRomano(1, semestre_siguiente);
						/* Habilitar el modal, el encabezado de los certificados y 
						el texto predeterminado de de la inscripción al siguiente semestre */
						$("#vistaprevia_modal").modal({ backdrop: 'static', keyboard: false });
						$('#encabezado_certificados').removeAttr("hidden");
						$('#estudio_siguiente').removeAttr("hidden");
						$("#pie_certificado").removeAttr("hidden");
						$("#fecha_certificado").html(fechahoyesp);
						/* Se llenan los campos del contenedor */
						$("#certificado_5_nombre_estudiante").html(datos[0][0]);
						$("#certificado_5_tipo_doc").html(datos[0][1]);
						$("#certificado_5_identificacion").html(datos[0][2]);
						$("#certificado_5_expedido_en").html(datos[0][3]);
						$("#certificado_5_semestre_siguiente").html(romano);
						$("#certificado_5_programa").html(datos[0][5]);
						$("#certificado_5_jornada").html(datos[0][15]);
						$("#certificado_5_horario").html(horario);
					}
				} else {
					/* Si el estudiante no está en estado matriculado no se podrá generar este certificado */
					alertify.error("No es posible generar el certificado");
				}
			},
			error: function () {
				alertify.error("Hay un error...");
			}
		});
	} else if (tipo_certificado == "6") {
		/* Si el certificado es de Cesantías */
		limpiarModalCertificados();
		$.ajax({
			type: 'POST',
			url: '../controlador/certificados.php?op=cargarDatosEstudiante',
			data: { id_estudiante: id_estudiante, id_credencial: id_credencial },
			success: function (msg) {
				datos = JSON.parse(msg);
				var estado = datos[0][14];;
				/* Condicional para validar que el estudiante esté matriculado actualmente */
				if (estado == 1) {
					/* Habilitar el modal, el encabezado de los certificados y 
					el texto predeterminado de certificación de cesantías */
					$("#vistaprevia_modal").modal({ backdrop: 'static', keyboard: false });
					$('#encabezado_certificados').removeAttr("hidden");
					$('#cesantias').removeAttr("hidden");
					$("#pie_certificado").removeAttr("hidden");
					$("#fecha_certificado").html(fechahoyesp);
					$('#numero_sn').removeAttr("hidden");
					/* Se llenan los campos del contenedor */
					$("#certificado_6_nombre_estudiante").html(datos[0][0]);
					$("#certificado_6_tipo_doc").html(datos[0][1]);
					$("#certificado_6_identificacion").html(datos[0][2]);
					$("#certificado_6_expedido_en").html(datos[0][3]);
					$("#certificado_6_semestre_actual").html(datos[0][4]);
					$("#certificado_6_programa").html(datos[0][5]);
				} else {
					/* Si está en un estado diferente a matriculado no se puede generar el certificado*/
					alertify.error("No es posible generar el certificado");
				}
			},
			error: function () {
				alertify.error("Hay un error...");
			}
		});
	} else if (tipo_certificado == "7") {
		/* Si el certificado es de Paz y Salvo */
		limpiarModalCertificados();
		$.ajax({
			type: 'POST',
			url: '../controlador/certificados.php?op=cargarDatosEstudiante',
			data: { id_estudiante: id_estudiante, id_credencial: id_credencial },
			success: function (msg) {
				datos = JSON.parse(msg);
				/* Habilitar el modal, el encabezado de los certificados y 
				el texto predeterminado de certificación de paz y salvo */
				$("#vistaprevia_modal").modal({ backdrop: 'static', keyboard: false });
				$('#encabezado_certificados').removeAttr("hidden");
				$('#paz_y_salvo').removeAttr("hidden");
				$("#pie_certificado").removeAttr("hidden");
				$("#fecha_certificado").html(fechahoyesp);
				$('#numero_sn').removeAttr("hidden");
				/* Se llenan los campos del contenedor */
				$("#certificado_7_nombre_estudiante").html(datos[0][0]);
				$("#certificado_7_tipo_doc").html(datos[0][1]);
				$("#certificado_7_identificacion").html(datos[0][2]);
				$("#certificado_7_expedido_en").html(datos[0][3]);
				$("#certificado_7_semestre_actual").html(datos[0][4]);
				$("#certificado_7_programa").html(datos[0][5]);
			},
			error: function () {
				alertify.error("Hay un error...");
			}
		});
	} else if (tipo_certificado == "8") {
		/* Si el certificado es de Buena Conducta */
		limpiarModalCertificados();
		$.ajax({
			type: 'POST',
			url: '../controlador/certificados.php?op=cargarDatosEstudiante',
			data: { id_estudiante: id_estudiante, id_credencial: id_credencial },
			success: function (msg) {
				datos = JSON.parse(msg);
				/* Habilitar el modal, el encabezado de los certificados y 
				el texto predeterminado de certificación de Buena Conducta */
				$("#vistaprevia_modal").modal({ backdrop: 'static', keyboard: false });
				$('#encabezado_certificados').removeAttr("hidden");
				$('#buena_conducta').removeAttr("hidden");
				$("#pie_certificado").removeAttr("hidden");
				$("#fecha_certificado").html(fechahoyesp);
				/* Se llenan los campos del contenedor */
				$("#certificado_8_nombre_estudiante").html(datos[0][0]);
				$("#certificado_8_tipo_doc").html(datos[0][1]);
				$("#certificado_8_identificacion").html(datos[0][2]);
				$("#certificado_8_expedido_en").html(datos[0][3]);
				$("#certificado_8_semestre_actual").html(datos[0][4]);
				$("#certificado_8_programa").html(datos[0][5]);
			},
			error: function () {
				alertify.error("Hay un error...");
			}
		});
	}
	else if (tipo_certificado == "9") {
		/* Si el certificado es de Buena Conducta */
		limpiarModalCertificados();
		$("#tipo_certificado").val(tipo_certificado);
		$("#cargar_diploma").modal({ backdrop: 'static', keyboard: false });
	}
});
/* Función para validar si el estudiante ya ha solicitado certificados */
$("#boton_verificar").off("click").on("click", function () {
	var id_estudiante = $("#id_estudiante").val();
	$("#verificar").hide();
	$.ajax({
		type: 'POST',
		url: '../controlador/certificados.php?op=verificar_certificados_expedidos',
		data: { id_estudiante: id_estudiante },
		success: function (msg) {
			if (msg) {
				alertify.confirm('Ya se han generado certificados',
					'¿Está seguro que quiere generar este certificado? Tendrá Cobro',
					function () {
						$("#imprimir").removeAttr("hidden");
						$("#descargarCertificado").removeAttr("hidden");
					}, function () {
						alertify.error('Operación Cancelada');
					});
			} else {
				$("#imprimir").removeAttr("hidden");
				$("#descargarCertificado").removeAttr("hidden");
			}
		},
		error: function () {
			alertify.error("Hay un error...");
		}
	});
});
/* Botón para activar la función de impresión de los certificados */
$("#boton_imprimir").off("click").on("click", function () {
	alertify.confirm('Imprimir Certificado',
		'¿Está seguro que quiere imprimir este certificado?',
		function () {
			var id_contenedor_imprimir = "cuerpo_vista_previa";
			var tipo_certificado = $("#consulta").val();
			var id_estudiante = $("#id_estudiante").val();
			var id_credencial = $("#id_credencial").val();
			var id_programa = $("#id_programa_ac").val();
			var fechahoy = new Date();
			var fechahoyesp = getDatennow(0, fechahoy);
			imprimirCertificado(id_contenedor_imprimir);
			guardarRegistroCertificado(tipo_certificado, id_estudiante, id_credencial, id_programa, fechahoyesp);
		}, function () {
			alertify.error('Operación Cancelada');
		});
});
/* Botón para activar la función de impresión de los certificados */
$("#boton_descargar").off("click").on("click", function () {
	alertify.confirm('Descargar Certificado',
		'¿Está seguro que quiere descargar este certificado?',
		function () {
			var tipo_certificado = $("#consulta").val();
			var id_estudiante = $("#id_estudiante").val();
			var id_credencial = $("#id_credencial").val();
			var id_programa = $("#id_programa_ac").val();
			var fechahoy = new Date();
			var fechahoyesp = getDatennow(0, fechahoy);
			guardarRegistroCertificado(tipo_certificado, id_estudiante, id_credencial, id_programa, fechahoyesp);
			generar_certificado();
		}, function () {
			alertify.error('Operación Cancelada');
		});
});
/* Función para imprimir los certificados */
function imprimirCertificado(nombre) {
	var ficha = document.getElementById(nombre);
	var ventimp = window.open('', '_blank');
	// Obtener los estilos CSS de la página
	var styles = document.head.innerHTML;
	// Crear la estructura HTML con los estilos incluidos
	ventimp.document.write(`
        <html>
        <head>
            <title>Certificado</title>
            ${styles} <!-- Incluye los estilos en la nueva ventana -->
            <style>
                @media print {
                    body {
                        -webkit-print-color-adjust: exact;
                        print-color-adjust: exact;
						background: transparent;
                    }
                    /* Marca de agua */
                    #marca-agua::after {
                        content: "";
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-image: url('../files/formatos/marca_de_agua_certificados.jpg');
                        background-size: contain;
                        background-repeat: no-repeat;
                        background-position: center;
                        z-index: -1;
                    }
                    /* Asegura que el contenido sea legible */
                    #${nombre} {
                        position: relative;
                        z-index: 1;
                        background: transparent; /* Fondo blanco para evitar problemas de impresión */
                        padding: 20px;
                    }
                }
            </style>
        </head>
        <body>
            <div id="marca-agua">
                <div id="${nombre}">
                    ${ficha.innerHTML}
                </div>
            </div>
            <script>
                window.onload = function() {
                    window.print();
                    window.onafterprint = function() { window.close(); };
                };
            </script>
        </body>
        </html>
    `);
	ventimp.document.close();
}
/* Función para guardar el registro de la impresión del certificado en la base de datos */
function guardarRegistroCertificado(tipo_certificado, id_estudiante, id_credencial, id_programa_ac, fechahoyesp) {
	$.ajax({
		type: 'POST',
		url: '../controlador/certificados.php?op=guardarRegistroCertificado',
		data: { tipo_certificado: tipo_certificado, id_estudiante: id_estudiante, id_credencial: id_credencial, id_programa_ac: id_programa_ac, fechahoyesp: fechahoyesp },
		success: function (msg) {
			if (msg != 1) {
				alertify.success("Certificado Impreso");
			} else {
				alertify.error("Error al imprimir certificado");
			}
		},
		error: function () {
			alertify.error("Hay un error...");
		}
	});
}
/* Función para limpiar los datos del modal de vista previa */
function limpiarModalCertificados() {
	$("#contenido_vista_previa").html("");
	$("#calificaciones_actual").attr("hidden", true);
	$("#calificaciones_todos").attr("hidden", true);
	$("#calificaciones_anterior").attr("hidden", true);
	$("#pie_certificado").attr("hidden", true);
	$("#estudio_actual").attr("hidden", true);
	$("#estudio_siguiente").attr("hidden", true);
	$("#cesantias").attr("hidden", true);
	$("#numero_sn").attr("hidden", true);
	$("#buena_conducta").attr("hidden", true);
	$("#paz_y_salvo").attr("hidden", true);
	$("#imprimir").attr("hidden", true);
	$("#descargarCertificado").attr("hidden", true);
}
/* Función para escoger el horario según la jornada */
function definirHorario(jornada, programa) {
	var horario_clase = "";
	if (jornada == "D01") {
		horario_clase = "Lunes a Viernes de 7:00am a 11:45am.";
	} else if (jornada == "N01") {
		horario_clase = "Lunes a Viernes de 6:30pm a 9:45pm.";
	} else if (jornada == "CAP") {
		horario_clase = "6:30pm a 9:45pm de Lunes a viernes.";
	} else if (jornada == "F01" && programa == "Técnica Profesional en Gestión Empresarial") {
		horario_clase = "Viernes de 6:30pm a 9:30pm y Sábados de 2:00pm a 8:00pm.";
	} else if (jornada == "F01") {
		horario_clase = "Viernes de 6:30pm a 9:30pm y Sábados de 1:00pm a 9:00pm.";
	}
	return horario_clase;
}
/* Función para cargar el certificado de todas las calificaciones */
function cargarTodasCalificaciones(id_estudiante, ciclo, semestres_programa, semestre_estudiante) {
	$.ajax({
		type: 'POST',
		url: '../controlador/certificados.php?op=cargarTodasCalificaciones',
		data: { id_estudiante: id_estudiante, ciclo: ciclo, semestres_programa: semestres_programa, semestre_estudiante: semestre_estudiante },
		success: function (msg) {
			$("#contenido_vista_previa").html(msg);
		},
		error: function () {
			alertify.error("Hay un error...");
		}
	});
}
/* Función para cargar la información del certificado de calificaciones del semestre actual */
function cargarSemestreActual(id_estudiante, ciclo, semestre_estudiante, periodo_activo) {
	$.ajax({
		type: 'POST',
		url: '../controlador/certificados.php?op=cargarSemestreActual',
		data: { id_estudiante: id_estudiante, ciclo: ciclo, semestre_estudiante: semestre_estudiante, periodo_activo: periodo_activo },
		success: function (msg) {
			$("#contenido_vista_previa").html(msg);
		},
		error: function () {
			alertify.error("Hay un error...");
		}
	});
}
/* Función para cargar la información del certificadod de calificaciones del semestre anterior */
function cargarSemestreAnterior(id_estudiante, ciclo, semestre_anterior, periodo_anterior) {
	$.ajax({
		type: 'POST',
		url: '../controlador/certificados.php?op=cargarSemestreAnterior',
		data: { id_estudiante: id_estudiante, ciclo: ciclo, semestre_anterior: semestre_anterior, periodo_anterior: periodo_anterior },
		success: function (msg) {
			$('#contenido_vista_previa').html(msg);
		},
		error: function () {
			alertiify.error("Hay un error");
		}
	});
}
/* Función para imprimir la fecha en el pie de página del certificado */
function cargarFechaPie(flag, date) {
	if (flag == 1) {
		$.ajax({
			type: 'POST',
			url: '../controlador/certificados.php?op=fecha_pie',
			data: { date: date },
			success: function (msg) {
				console.log(msg);
				$('#pie_certificado').append(msg);
			},
			error: function () {
				alertiify.error("Hay un error");
			}
		});
	}
}
/* Función para convertir el número de semestre en número romano */
function convertirSemestreRomano(flag, semestre) {
	if (flag) {
		var romano;
		if (semestre == 1) {
			romano = "I";
		} else if (semestre == 2) {
			romano = "II";
		} else if (semestre == 3) {
			romano = "III";
		} else if (semestre == 4) {
			romano = "IV";
		} else if (semestre == 5) {
			romano = "V";
		} else if (semestre == 6) {
			romano = "VI";
		} else if (semestre == 7) {
			romano = "VII";
		} else if (semestre == 8) {
			romano = "VIII";
		} else if (semestre == 9) {
			romano = "IX";
		} else if (semestre == 10) {
			romano = "X";
		}
	}
	return romano;
}
/* Función para pasar la fecha a formato español */
function getDatennow(flag, fecha) {
	var today = new Date(fecha);
	var dd = today.getDate();
	var mm = today.getMonth() + 1; //January is 0!
	var yyyy = today.getFullYear();
	var hh = today.getHours();
	var mi = today.getMinutes();
	var ss = today.getSeconds();
	if (dd < 10) {
		dd = '0' + dd;
	}
	if (mm < 10) {
		mm = '0' + mm;
	}
	if (mi < 10) {
		mi = '0' + mi;
	}
	if (hh < 10) {
		hh = '0' + hh;
	}
	if (ss < 10) {
		ss = '0' + ss;
	}
	if (flag) {
		var days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
		const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
			"Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
		var date = days[today.getDay()] + ' (' + dd + ') de ' + monthNames[today.getMonth()] + ' de (' + yyyy + ')';
		//today = dd + '/' + mm + '/' + yyyy+ " Hora:  " + hh + ":" + mi + ":" + ss;
		return date;
	} else {
		date = yyyy + '-' + mm + '-' + dd;
		return date;
	}
}
//Función para activar registros
function eliminarDiploma(id_certificado) {
	alertify.confirm("Eliminar Diploma", "¿Desea Eliminar esta diploma?", function () {
		$.post("../controlador/certificados.php?op=eliminarDiploma", { id_certificado: id_certificado }, function (datos) {
			var r = JSON.parse(datos);
			console.log(r.status);
			if (r.status == 1) {
				alertify.success("Diploma eliminado");
				$('#expedidosTabla').DataTable().ajax.reload();
			}
			else {
				alertify.error("Diploma no se pudo  Eliminar");
			}
		});
	}
		, function () { alertify.error('Cancelado') });
}
function generar_certificado() {
	$.post("../controlador/certificados.php?op=documento_word_certificado",
		{ "texto_principal": $("#" + id_seleccionado).text(), "pie_certificado": $("#pie_certificado").text(), "tabla_html": $("#contenido_vista_previa").html() }
		, function (datos) {
			let data = JSON.parse(datos);
			if (data.success) {
				let fileUrl = data.fileUrl;
				window.location.href = fileUrl;
				setTimeout(function () {
					$.post("../controlador/certificados.php?op=eliminarDocumentoTemporal", function (data) {
						console.log(data);
					});
				}, 5000);
			} else {
				alert("Error al generar el archivo.");
			}
		}
	);
}

init();
