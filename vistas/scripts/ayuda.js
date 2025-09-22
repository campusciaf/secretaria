var tabla;
//Función que se ejecuta al inicio
function init() {
	listar();
	$("#formulario").on("submit", function (e) {
		guardarayuda(e);
	})
	//Cargamos los items de los selects
	$.post("../controlador/ayuda.php?op=selectDependencia", function (r) {
		$("#dependencia").html(r);
		$('#dependencia').selectpicker('refresh');
	});
	//Cargamos los items de los selects
	$.post("../controlador/ayuda.php?op=selectAsunto", function (r) {
		$("#id_asunto").html(r);
		$('#id_asunto').selectpicker('refresh');
	});
}
function listaropciones(id_asunto) {
	$.post("../controlador/ayuda.php?op=listaropciones", { id_asunto: id_asunto }, function (data, status) {
		data = JSON.parse(data);
		// console.log(data);
		$("#listar_opciones").html("");
		$('#listar_opciones').append(data["0"]["0"]);
	});
}
//Función limpiar
function limpiar() {
	$("#id_ayuda").val("");
	$("#asunto").val("");
	$("#mensaje").val("");
}
//Función mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
		$('#dependencia').selectpicker('refresh');
	}
	else {
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
//Función Listar
function listar() {
	$.post("../controlador/ayuda.php?op=listar", {}, function (data, status) {
		data = JSON.parse(data);
		$("#precarga").hide();
		$("#listadoregistros").html("");
		$('#listadoregistros').append(data["0"]["0"]);
	});
}
function listar2() {
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
					extend: 'copyHtml5',
					text: '<i class="fa fa-copy fa-2x" style="color: blue"></i>',
					titleAttr: 'Copy'
				},
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
				url: '../controlador/ayuda.php?op=listar',
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
			"iDisplayLength": 5,//Paginación
			"order": [[0, "desc"]]//Ordenar (columna,orden)
		}).DataTable();
}
function guardarayuda(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../controlador/ayuda.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			alertify.success(datos);
			// console.log(datos);
			mostrarform(false);
			listar();
		}
	});
	limpiar();
}
function mostrar(id_ejes) {
	$.post("../controlador/ayuda.php?op=mostrar", { id_ejes: id_ejes }, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);
		$("#id_ejes").val(data.id_ejes);
		$("#nombre_ejes").val(data.nombre_ejes);
		$("#periodo").val(data.periodo);
		$("#objetivo").val(data.objetivo);
	});
}
//Función para desactivar registross
function eliminar(id_ejes) {
	alertify.confirm("¿Está Seguro de eliminar la ejes?", function (result) {
		if (result) {
			$.post("../controlador/ayuda.php?op=eliminar", { id_ejes: id_ejes }, function (e) {
				if (e == 'null') {
					alertify.success("Eliminado correctamente");
					tabla.ajax.reload();
				}
				else {
					alertify.error("Error")
				}
			});
		}
	})
}
document.addEventListener("DOMContentLoaded", function () {
    const abrirModalBtn = document.getElementById("btnAbrirModalPQRS");

    if (abrirModalBtn) {
        abrirModalBtn.addEventListener("click", function () {
            $("#modalPQRS").modal("show");
        });
    }
});

init();