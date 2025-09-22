var tabla;

//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});

	$("#formulariocrearvariableuno").on("submit", function (e1) {
		guardaryeditarvariable(e1);
	});

	$("#formularioopcion").on("submit", function (e2) {

		guardaryeditaropcion(e2);
	});

	$("#formulariocondicion").on("submit", function (e3) {

		guardaryeditarcondicion(e3);
	});

	$.post("../controlador/variables.php?op=selectCondicion", function (r) {
		$("#prerequisito").html(r);
		$('#prerequisito').selectpicker('refresh');
	});



}

//Función limpiar
function limpiar() {
	$("#id_categoria").val("");
	$("#id_tipo_pregunta").val("");
	$("#variable").val("");
	$("#obligatorio_no").prop('checked', false);
	$("#obligatorio_si").prop('checked', true);


}

//Función mostrar formulario
function mostrarform(flag) {
	//limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();

	}
	else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#myModalCrearVariable").modal("hide");
		$("#formularioregistroscrearvariableuno").hide();



	}
}

//Función cancelarform
function cancelarform() {
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar() {

	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());


	tabla = $('#tbllistado').dataTable(
		{
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
			"ajax":
			{
				url: '../controlador/variables.php?op=listar',
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},



			// funcion para cambiar el responsive del data table	

			'select': 'single',

			'drawCallback': function (settings) {
				api = this.api();
				var $table = $(api.table().node());

				if ($table.hasClass('cards')) {

					// Create an array of labels containing all table headers
					var labels = [];
					$('thead th', $table).each(function () {
						labels.push($(this).text());
					});

					// Add data-label attribute to each cell
					$('tbody tr', $table).each(function () {
						$(this).find('td').each(function (column) {
							$(this).attr('data-label', labels[column]);
						});
					});

					var max = 0;
					$('tbody tr', $table).each(function () {
						max = Math.max($(this).height(), max);
					}).height(max);

				} else {
					// Remove data-label attribute from each cell
					$('tbody td', $table).each(function () {
						$(this).removeAttr('data-label');
					});

					$('tbody tr', $table).each(function () {
						$(this).height('auto');
					});
				}
			}



		});


	var width = $(window).width();
	if (width <= 750) {
		$(api.table().node()).toggleClass('cards');
		api.draw('page');
	}
	window.onresize = function () {

		anchoVentana = window.innerWidth;
		if (anchoVentana > 1000) {
			$(api.table().node()).removeClass('cards');
			api.draw('page');
		} else if (anchoVentana > 750 && anchoVentana < 1000) {
			$(api.table().node()).removeClass('cards');
			api.draw('page');
		} else {
			$(api.table().node()).toggleClass('cards');
			api.draw('page');
		}
	}
	// ****************************** //



}
//Función para guardar o editar
function listarVariable(id_categoria) {
	$.post("../controlador/variables.php?op=listarVariable", { id_categoria: id_categoria }, function (data, status) {
		//console.log(data);
		data = JSON.parse(data);
		$("#myModalListarVariable").modal("show");
		$("#resultadolistarvariable").html("");
		$("#resultadolistarvariable").append(data["0"]["0"]);
		$(".tooltipVariable").tooltip()
	});
}
function crearvariable(id_categoria) {
	$.post("../controlador/variables.php?op=crearVariable", { id_categoria: id_categoria }, function (data, status) {
		data = JSON.parse(data);
		$("#myModalCrearVariable").modal("show");
		$("#resultadocrearvariable").html("");
		$("#resultadocrearvariable").append(data["0"]["0"]);
	});
}
function crearVariableDos(id_categoria, id_tipo_pregunta) {

	$("#formularioregistroscrearvariableuno").show();
	$("#formularioregistroscrearvariabledos").hide();
	$("#formularioregistroscrearvariablecuatro").hide();
	$("#id_categoria").val(id_categoria);
	$("#id_tipo_pregunta").val(id_tipo_pregunta);

	if (id_tipo_pregunta == 1) {
		$("#mensaje1").show();
		$("#mensaje2").hide();
		$("#mensaje3").hide();
		$("#mensaje4").hide();
		$("#mensaje5").hide();
		$("#mensaje6").hide();
		$("#mensaje7").hide();
		$("#mensaje8").hide();
	}
	if (id_tipo_pregunta == 2) {
		$("#mensaje1").hide();
		$("#mensaje2").show();
		$("#mensaje3").hide();
		$("#mensaje4").hide();
		$("#mensaje5").hide();
		$("#mensaje6").hide();
		$("#mensaje7").hide();
		$("#mensaje8").hide();
	}

	if (id_tipo_pregunta == 3) {
		$("#mensaje1").hide();
		$("#mensaje2").hide();
		$("#mensaje3").show();
		$("#mensaje4").hide();
		$("#mensaje5").hide();
		$("#mensaje6").hide();
		$("#mensaje7").hide();
		$("#mensaje8").hide();
	}

	if (id_tipo_pregunta == 4) {
		$("#mensaje1").hide();
		$("#mensaje2").hide();
		$("#mensaje3").hide();
		$("#mensaje4").show();
		$("#mensaje5").hide();
		$("#mensaje6").hide();
		$("#mensaje7").hide();
		$("#mensaje8").hide();
	}

	if (id_tipo_pregunta == 5) {
		$("#mensaje1").hide();
		$("#mensaje2").hide();
		$("#mensaje3").hide();
		$("#mensaje4").hide();
		$("#mensaje5").show();
		$("#mensaje6").hide();
		$("#mensaje7").hide();
		$("#mensaje8").hide();
	}

	if (id_tipo_pregunta == 6) {
		$("#mensaje1").hide();
		$("#mensaje2").hide();
		$("#mensaje3").hide();
		$("#mensaje4").hide();
		$("#mensaje5").hide();
		$("#mensaje6").show();
		$("#mensaje7").hide();
		$("#mensaje8").hide();
	}

	if (id_tipo_pregunta == 7) {
		$("#mensaje1").hide();
		$("#mensaje2").hide();
		$("#mensaje3").hide();
		$("#mensaje4").hide();
		$("#mensaje5").hide();
		$("#mensaje6").hide();
		$("#mensaje7").show();
		$("#mensaje8").hide();
	}
	if (id_tipo_pregunta == 8) {
		$("#mensaje1").hide();
		$("#mensaje2").hide();
		$("#mensaje3").hide();
		$("#mensaje4").hide();
		$("#mensaje5").hide();
		$("#mensaje6").hide();
		$("#mensaje7").hide();
		$("#mensaje8").show();
	}



}



function mostrar(id_programa) {
	$.post("../controlador/variables.php?op=mostrar", { id_programa: id_programa }, function (data, status) {

		data = JSON.parse(data);
		mostrarform(true);

		$("#nombre").val(data.nombre);
		$("#cod_programa_pea").val(data.cod_programa_pea);
		$("#ciclo").val(data.ciclo);
		$("#cod_snies").val(data.cod_snies);
		$("#cant_asignaturas").val(data.cant_asignaturas);
		$("#semestres").val(data.semestres);
		$("#cortes").val(data.cortes);
		$("#inicio_semestre").val(data.inicio_semestre);
		$("#escuela").val(data.escuela);
		$("#escuela").selectpicker('refresh');
		$("#original").val(data.original);
		$("#estado").val(data.estado);
		$("#estado").selectpicker('estado');
		$("#id_programa").val(data.id_programa);


	});

}

function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controlador/variables.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {


			alertify.success(datos);
			mostrarform(false);
			tabla.ajax.reload();

		}

	});
	limpiar();
}

function guardaryeditarvariable(e1) {
	e1.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulariocrearvariableuno")[0]);

	$.ajax({
		url: "../controlador/variables.php?op=guardaryeditarvariable",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {


			$("#formularioregistroscrearvariableuno").hide();
			$("#btnGuardar").prop("disabled", false);
			alertify.success(datos);
			mostrarform(false);
			tabla.ajax.reload();


		}

	});
	limpiar();
}


function guardaryeditaropcion(e2) {
	var id_variable = $("#id_variable").val();
	var camponumerodiv = $("#camponumerodiv").val();

	e2.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarOpcion").prop("disabled", true);
	var formData = new FormData($("#formularioopcion")[0]);

	$.ajax({
		url: "../controlador/variables.php?op=guardaryeditaropcion",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {



			alertify.success(datos);
			$("#btnGuardarOpcion").prop("disabled", false);
			$("#myModalOpcion").modal("hide");

			$.post("../controlador/variables.php?op=recargaropcion", { id_variable: id_variable, camponumerodiv: camponumerodiv }, function (datarecargar, status) {
				datarecargar = JSON.parse(datarecargar);
				$("#fila" + camponumerodiv).html("");
				$("#fila" + camponumerodiv).append(datarecargar["0"]["0"]);
				$("#nombre_opcion").val();
			});


		}

	});
}

function guardaryeditarcondicion(e3) {
	var id_variable = $("#id_variable_pre").val();
	var camponumerodiv = $("#camponumerodivpre").val();

	e3.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarOpcion").prop("disabled", true);
	var formData = new FormData($("#formulariocondicion")[0]);

	$.ajax({
		url: "../controlador/variables.php?op=guardaryeditarcondicion",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datos) {



			alertify.success(datos);
			$("#btnGuardarCondicion").prop("disabled", false);
			$("#myModalCondicion").modal("hide");

			$.post("../controlador/variables.php?op=recargaropcion", { id_variable: id_variable, camponumerodiv: camponumerodiv }, function (datarecargar, status) {
				datarecargar = JSON.parse(datarecargar);
				$("#fila" + camponumerodiv).html("");
				$("#fila" + camponumerodiv).append(datarecargar["0"]["0"]);
				$("#nombre_opcion").val();
			});


		}

	});
}


function agregarOpcion(id_variable, numerodiv) {
	$("#myModalOpcion").modal("show");
	$("#id_variable").val(id_variable);
	$("#camponumerodiv").val(numerodiv);

}

function prerequisito(id_variable, numerodiv) {
	$("#myModalCondicion").modal("show");
	$("#id_variable_pre").val(id_variable);
	$("#camponumerodivpre").val(numerodiv);

}


//Función para desactivar registros
function desactivar(id_programa) {


	alertify.confirm('Desactivar Programa', "¿Está Seguro de desactivar el programa?", function () {

		$.post("../controlador/variables.php?op=desactivar", { id_programa: id_programa }, function (e) {

			if (e == 1) {
				alertify.success("Programa Desactivado");
				tabla.ajax.reload();
			}
			else {
				alertify.error("Programa no se puede desactivar");
			}


		});
	}
		, function () { alertify.error('Cancelado') });

}

//Función para activar registros
function activar(id_programa) {
	alertify.confirm('Activar Programa', '¿Está Seguro de activar el Programa?', function () {

		$.post("../controlador/variables.php?op=activar", { id_programa: id_programa }, function (e) {

			if (e == 1) {
				alertify.success("Programa Activado");
				tabla.ajax.reload();
			}
			else {
				alertify.error("Programa no se puede activar");
			}
		});

	}
		, function () { alertify.error('Cancelado') });


}


function editar_pregunta(id_variable) {
	limpiarBotonesVariables(id_variable);
    $('#nombre_variable_editar'+id_variable).prop('readonly', false);
    $('#nombre_variable_editar'+id_variable).focus();
}


function guardar_cambios(id_variable) {
	var nombre_variable = $('#nombre_variable_editar'+id_variable).val();
	
    $.post("../controlador/variables.php?op=guardaryeditareditar_pregunta", { "id_variable": id_variable, "nombre_variable": nombre_variable }, function (data) {
		data = JSON.parse(data);
        if (data.exito == 1) {
			alertify.success(data.info);
            $('#nombre_variable_editar'+id_variable).prop('readonly', true);
			$('#nombre_real_editar' + id_variable).val($("#nombre_variable_editar" + id_variable).val());
			limpiarBotonesVariables(id_variable);
        }else{
			alertify.error(data.info);
		}
    });
}

function cancelar_pregunta(id_variable) {
	limpiarBotonesVariables(id_variable);
	$('#nombre_variable_editar'+id_variable).prop('readonly', true);
	$('#nombre_variable_editar' + id_variable).val($("#nombre_real_editar"+id_variable).val());
}

function limpiarBotonesVariables(id_variable){
	$(".editar_pregunta_" + id_variable).toggleClass("d-none");
	$(".cancelar_pregunta_" + id_variable).toggleClass("d-none");
	$(".guardar_pregunta_" + id_variable).toggleClass("d-none");
}



init();