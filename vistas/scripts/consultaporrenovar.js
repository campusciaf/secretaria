var tabla;
function init(){
	listargeneral();
	$("#inactivotaba").hide();
	// formulario para guardar el seguimineto 
	$("#formularioAgregarSeguimiento").on("submit",function(e1)
	{
		guardarSeguimiento(e1);	
	});
	
	// formulario para guardar la tarea
	$("#formularioTarea").on("submit",function(e2)
	{
		guardarTarea(e2);	
	});

	$("#formularioreingreso").on("submit",function(e4)
	{
		guardaryeditarreingreso(e4);	
	});

	$.post("../controlador/consultaporrenovar.php?op=selectEstadoEgresado", function(r){
        $("#id_reingreso_estado").html(r);
        $('#id_reingreso_estado').selectpicker('refresh');
	});

	$("#btnconsulta").click(function() { // Asumiendo que tienes un botón para ejecutar la consulta
        var dato = $("#dato").val();
        consulta_desercion_busqueda(dato);
    });
}



//Función Listar
function volver(){
	listargeneral();
	$("#datos_table_desertado").hide();
}

function muestra() {
	$("#input_dato").show();
}
function consulta_desercion_busqueda(dato) {
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#datos_table_desertado').dataTable({

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
			url: '../controlador/consultaporrenovar.php?op=consulta_desercion&dato=' + dato,
			type: "get",
			dataType: "json",
			// data: {"dato": dato}, // Incluido como parte de los datos

			error: function (e) {
				// console.log(e.responseText);
			}
		},
		
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[0, "asc"]],//Ordenar (columna,orden)
		'initComplete': function (settings, json) {
			$(".box_credencial_identificacion").text(json.credencial_identificacion);
			$(".box_nombre_estudiante").text(json.credencial_nombre);
			$(".box_nombre_estudiante_seguimiento").text(json.credencial_nombre);
			$(".box_correo_electronico").text(json.email);
			$(".box_celular").text(json.celular);
			$("#precarga").hide();
			scroll(0,0);
		},
		
	});

	// $.post("../controlador/consultaporrenovar.php?op=agregar_mostrar_seguimiento",{id_credencial:id_credencial},function(data){
	// 	console.log(data)
	// });

}

// se agrega el seguimiento para el estudiante
function agregar_mostrar_seguimiento(id_credencial, id_estudiante_programa){
	$("#precarga").show();
	$("#btnGuardarSeguimiento").prop("disabled",false);
		$("#precarga").show();
		$("#id_estudiante_agregar").val(id_credencial);
		$("#id_estudiante_programa").val(id_estudiante_programa);
		$("#id_estudiante_tarea").val(id_credencial);

	$.post("../controlador/consultaporrenovar.php?op=agregar_mostrar_seguimiento",{id_credencial:id_credencial},function(data, status){
		// console.log(data)
		data = JSON.parse(data);// convertir el mensaje a json		
		$("#myModalAgregar").modal("show");
		$("#agregarContenido").html("");// limpiar el div resultado
		$("#agregarContenido").append(data["0"]["0"]);// agregar el resultao al div resultado
		$("#precarga").hide();

	});
}

//se guardan las tareas 
function guardarTarea(e2)
	{
		e2.preventDefault(); //No se activará la acción predeterminada del evento
		var formData = new FormData($("#formularioTarea")[0]);

		$.ajax({
			url: "../controlador/consultaporrenovar.php?op=agregarTarea",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,

			success: function(datos)
			{ 
				// console.log(datos)
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: "Tarea Actualizada.",
					showConfirmButton: false,
					timer: 1500
				});	
				limpiarTarea(); 
				$("#myModalAgregar").modal("hide");
				
			}

		});
		
	}


//Mostramos el seguimiento de los estudiantes
function seguimientoverHistorial(id_credencial){
	$("#precarga").show();
	$("#myModalHistorialTareas").modal("show");
	$.post("../controlador/consultaporrenovar.php?op=seguimientoverHistorial",{id_credencial:id_credencial},function(data, status){
		// console.log(data);
		data = JSON.parse(data);// convertir el mensaje a json
		$("#historial").html("");// limpiar el div resultado
		$("#historial").append(data["0"]["0"]);// agregar el resultao al div resultado
		$("#precarga").hide();
		verHistorialTabla(id_credencial);
		verHistorialTablaTareas(id_credencial);
	});
}



//Función para mostrar los datos de contactanos 
function listargeneral(){
	$("#precarga").show();
	$("#inactivotaba").hide();
	$.post("../controlador/consultaporrenovar.php?op=listargeneral",{},function(data){
        data = JSON.parse(data);
        $("#datos").html(data.total);
        $("#precarga").hide();
	});
}



// funcion para ver la el historial de los estudiantes
function verHistorialTabla(id_credencial) {
	$("#precarga").show();

	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistadohistorial').dataTable({
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
			url: '../controlador/consultaporrenovar.php?op=verHistorialTabla&id_credencial=' + id_credencial, type: "get", dataType: "json",
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

function verHistorialTablaTareas(id_credencial) {
	$("#precarga").show();

	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistadoHistorialTareas').dataTable({
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
			url: '../controlador/consultaporrenovar.php?op=verHistorialTablaTareas&id_credencial=' + id_credencial, type: "get", dataType: "json",
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


//funcion para guardar el seguimiento del estudiante
function guardarSeguimiento(e)
	{
		e.preventDefault(); //No se activará la acción predeterminada del evento
		var formData = new FormData($("#formularioAgregarSeguimiento")[0]);

		$.ajax({
			url: "../controlador/consultaporrenovar.php?op=agregarSeguimiento",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,

			success: function(datos)
			{ 
				// console.log(datos);
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: "Seguimiento Actualizado.",
					showConfirmButton: false,
					timer: 1500
				});	
				limpiarSeguimiento(); 
				// window.location.reload();
				$("#myModalAgregar").modal("hide");
				
			}

		});
		
	}


	function cuentatarea(){// muestra el numero de caracteres limite en un textarea
		var max_chars = 150;
		
		$('#max').html(max_chars);
	
		$('#mensaje_tarea').keyup(function() {
			var chars = $(this).val().length;
			var diff = max_chars - chars;
			$('#contadortarea').html(diff);   
		});
	}

	function cuenta(){// muestra el numero de caracteres limite en un textarea
		var max_chars = 150;
		
		$('#max').html(max_chars);
	
		$('#mensaje_seguimiento').keyup(function() {
			var chars = $(this).val().length;
			var diff = max_chars - chars;
			$('#contador').html(diff);   
		});
	}

	function limpiarSeguimiento(){
		$("#mensaje_seguimiento").val("");
		$("#formularioAgregarSeguimiento").val("");
		
	
	}

	function limpiarTarea(){
		$("#mensaje_tarea").val("");
		$("#fecha_programada").val("");
		$("#hora_programada").val("");
	}

//funcion para traer el id credencial del egresado, y el estado seleccionado para el egresado
function mostrar_reingreso(id_egresdado_est,id_reingreso_estado){
	$("#ModalReingreso").modal("show");
	$("#id_reingreso_estado").val(id_reingreso_estado);
	$("#id_egresdado_est").val(id_egresdado_est);	
}
//Función para editar el estado del egresado
function guardaryeditarreingreso(e4){
	e4.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioreingreso")[0]);
	$.ajax({
		"url": "../controlador/consultaporrenovar.php?op=guardaryeditarreingreso",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			// window.location.reload();
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Estado Actualizado.",
				showConfirmButton: false,
				timer: 1500
			});	
			$("#ModalReingreso").modal("hide");
			$('#datos_table_desertado').DataTable().ajax.reload();

		}
	});
}

init();