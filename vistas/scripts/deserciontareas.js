$(document).ready(inicio);
function inicio() {
	consulta();
	$("#formularioAgregarSeguimiento").on("submit",function(e1)
	{
		guardarSeguimiento(e1);	
	});
	
	$("#formularioTarea").on("submit",function(e2)
	{
		guardarTarea(e2);	
	});
}

function consulta() {
	$("#precarga").show();
    $.post("../controlador/deserciontareas.php?op=consulta",function(datos){
        // console.log(datos);
        var r = JSON.parse(datos);
		$(".datos").html(r.conte);
		$("#precarga").hide();
	});
}

function buscar(tipo,id,consulta) {
	$("#precarga").show();
    $.post("../controlador/deserciontareas.php?op=buscar",{tipo:tipo,id:id,consulta:consulta},function(datos){
        // console.log(datos);
		var r = JSON.parse(datos);
        $(".datos").attr("hidden",true);
        $(".datos_usuario").attr("hidden",false);
		$(".datos_usuario").html(r.conte);
		$("#tbl_buscar").DataTable({
			"dom": 'Bfrtip',
            buttons: [{
                extend:    'copyHtml5',
                text:      '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel" style="color: green"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-alt"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf" style="color: red"></i>',
                titleAttr: 'PDF',
            }]
		});		
		$("#precarga").hide();
	});
}

function cambiarasesor(id_tarea,id_asesor,tipo,id_asesor_buscar,consulta) {
	$.post("../controlador/deserciontareas.php?op=cambiarasesor",{id_tarea:id_tarea,id_asesor:id_asesor},function(data){
		
		// console.log(data);
		var r  = JSON.parse(data);
		if (r.status == "ok") {
			alertify.success("Se cambio el asesor con exito");
			buscar(tipo,id_asesor_buscar,consulta)
		} else {
			alertify.success("Error al cambiar el asesor");
		}

	});
}

function cambiarfecha(id_tarea,fecha,tipo,id_asesor_buscar,consulta) {
	$.post("../controlador/deserciontareas.php?op=cambiarfecha",{id_tarea:id_tarea,fecha:fecha},function(data){
		
		// console.log(data);
		var r  = JSON.parse(data);
		if (r.status == "ok") {
			alertify.success("Se cambio la fecha con exito");
			buscar(tipo,id_asesor_buscar,consulta)
		} else {
			alertify.success("Error al cambiar la fecha");
		}

	});
}

// inicio agregar tareas, seguimiento y historial

	function agregar(id_estudiante){
		// $("#btnGuardarSeguimiento").prop("disabled",false);
		$("#precarga").show();
		$("#id_estudiante_agregar").val(id_estudiante);
		$("#id_estudiante_tarea").val(id_estudiante);
		
		$.post("../controlador/deserciontareas.php?op=agregar",{id_estudiante:id_estudiante},function(data, status){
			// console.log(data);
			data = JSON.parse(data);// convertir el mensaje a json
			$("#myModalAgregar").modal("show");
			$("#agregarContenido").html("");// limpiar el div resultado
			$("#agregarContenido").append(data["0"]["0"]);// agregar el resultao al div resultado
			$("#precarga").hide();

		});
	}

	function verHistorial(id_estudiante){
		$("#precarga").show();
		$.post("../controlador/deserciontareas.php?op=verHistorial",{id_estudiante:id_estudiante},function(data, status){
			// console.log(data);
			data = JSON.parse(data);// convertir el mensaje a json
			$("#myModalHistorial").modal("show");
			$("#historial").html("");// limpiar el div resultado
			$("#historial").append(data["0"]["0"]);// agregar el resultao al div resultado
			$("#precarga").hide();
			verHistorialTabla(id_estudiante);
			verHistorialTablaTareas(id_estudiante);
		});
	}

	// funcion para listar los estudaintes por suma de programa y jornada
	function verHistorialTabla(id_estudiante)
	{
	var estado="Inscrito";	
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		$("#titulo").html("Estado: <b>"+estado+"</b>");// limpiar el div resultado
		
		tabla=$('#tbllistadohistorial').dataTable(
		{
			
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
				buttons: [
				{
					extend:    'excelHtml5',
					text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					titleAttr: 'Excel'
				},
				{
					extend: 'print',
					text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					messageTop: '<div style="width:50%;float:left">Reporte: <b>'+estado+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Ejes',
					titleAttr: 'Seguimiento'
				},

			],
			"ajax":
					{
						url: '../controlador/deserciontareas.php?op=verHistorialTabla&id_estudiante='+id_estudiante,
						type : "get",
						dataType : "json",						
						error: function(e){
							// console.log(e.responseText);	
						}
					},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			"order": [[ 0, "desc" ]]//Ordenar (columna,orden)
		}).DataTable();
		

			
	}

	// funcion para listar los estudaintes por suma de programa y jornada
	function verHistorialTablaTareas(id_estudiante)
	{
	var estado="Inscrito";	
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		$("#titulo").html("Estado: <b>"+estado+"</b>");// limpiar el div resultado
		
		tabla=$('#tbllistadoHistorialTareas').dataTable(
		{
			
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
				buttons: [
				{
					extend:    'excelHtml5',
					text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					titleAttr: 'Excel'
				},
				{
					extend: 'print',
					text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					messageTop: '<div style="width:50%;float:left">Reporte: <b>'+estado+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Ejes',
					titleAttr: 'Tareas Programadas'
				},

			],
			"ajax":
					{
						url: '../controlador/deserciontareas.php?op=verHistorialTablaTareas&id_estudiante='+id_estudiante,
						type : "get",
						dataType : "json",						
						error: function(e){
							// console.log(e.responseText);	
						}
					},
			"bDestroy": true,
			"iDisplayLength": 10,//Paginación
			"order": [[ 0, "desc" ]]//Ordenar (columna,orden)
		}).DataTable();
		

			
	}

	function guardarSeguimiento(e){
		e.preventDefault(); //No se activará la acción predeterminada del evento
		// $("#btnGuardarSeguimiento").prop("disabled",true);
		var formData = new FormData($("#formularioAgregarSeguimiento")[0]);
		$.ajax({
			url: "../controlador/deserciontareas.php?op=agregarSeguimiento",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(datos){ 
				// console.log(datos);
				alertify.set('notifier','position', 'top-center');
				alertify.success(datos);	
				limpiarSeguimiento(); 
				$("#myModalAgregar").modal("hide");
			}

		});
		
	}
	function limpiarSeguimiento(){
		$("#mensaje_seguimiento").val("");
	}
	function guardarTarea(e2){
		e2.preventDefault(); //No se activará la acción predeterminada del evento
		// $("#btnGuardarTarea").prop("disabled",true);
		var formData = new FormData($("#formularioTarea")[0]);
		$.ajax({
			url: "../controlador/deserciontareas.php?op=agregarTarea",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function(datos){
				//console.log(datos)
				alertify.set('notifier','position', 'top-center');
				alertify.success(datos);	
				limpiarTarea(); 
				$("#myModalAgregar").modal("hide");
				
			}
		});
	}
	function limpiarTarea(){
		$("#mensaje_tarea").val("");
		$("#fecha_programada").val("");
		$("#hora_programada").val("");
	}
// fin agregar tareas, seguimiento y historial

function volver() {
	consulta();
	$(".datos").attr("hidden",false);
	$(".datos_usuario").attr("hidden",true);
}
function validarTarea(id_estudiante,tipo,consulta,id_tarea) {
	$.post("../controlador/deserciontareas.php?op=validarTarea",{id_tarea:id_tarea},function(data){
			
		// console.log(data);
		var r = JSON.parse(data);
		if (r.status == "ok") {
			alertify.success("OK");
			buscar(tipo,id_estudiante,consulta);
		} else {
			alertify.success("Error");
		}		

	});
}

// agregamos modal para ver las tareas que tienen todos los funcionarios
function vizualizartareashoy(){
	// $("#precarga").show();
	$.post("../controlador/deserciontareas.php?op=vizualizartareashoy",{},function(data, status){
		// console.log(data);
		data = JSON.parse(data);// convertir el mensaje a json
		$("#myModalvizualizartareashoy").modal("show");
		$(".datostareas2").html("");// limpiar el div resultado
		$(".datostareas2").append(data["0"]["0"]);// agregar el resultao al div resultado
		$('#tareasparahoy').dataTable( {
					
			dom: 'Bfrtip',
			
			buttons: [
				{
					extend:    'excelHtml5',
					text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
					titleAttr: 'Excel'
				},
				
			],
	
		});
	});


	
}