$(document).ready(inicio);
function inicio() {
	consulta();

}

function consulta() {
	$("#precarga").attr("hidden",false);
    $.post("../controlador/oncenteradmintareas.php?op=consulta",function(datos){
        //console.log(datos);
        var r = JSON.parse(datos);
		$(".datos").html(r.conte);
		$("#precarga").attr("hidden",true);
		$("#datogeneral").html(r.general);
		$("#cumplidas").html(r.cumplidas);
		$("#pendientes").html(r.pendientes);
		$("#nocumplidas").html(r.nocumplidas);
		$("#deldia").html(r.deldia);
	});
}


function buscar(tipo,id,consulta) {
	$("#precarga").attr("hidden",false);
    $.post("../controlador/oncenteradmintareas.php?op=buscar",{tipo:tipo,id:id,consulta:consulta},function(datos){
        //console.log(datos);
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
     
            }],
			
			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},

		
      });
	
	


	});
}

function cambiarasesor(id_tarea,id_asesor,tipo,id_asesor_buscar,consulta) {
	$.post("../controlador/oncenteradmintareas.php?op=cambiarasesor",{id_tarea:id_tarea,id_asesor:id_asesor},function(data){
		
		console.log(data);
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
	$.post("../controlador/oncenteradmintareas.php?op=cambiarfecha",{id_tarea:id_tarea,fecha:fecha},function(data){
		
		console.log(data);
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



	function verHistorial(id_estudiante){
		$("#precarga").show();
		$.post("../controlador/oncenteradmintareas.php?op=verHistorial",{id_estudiante:id_estudiante},function(data, status){
			//console.log(data);
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
						url: '../controlador/oncenteradmintareas.php?op=verHistorialTabla&id_estudiante='+id_estudiante,
						type : "get",
						dataType : "json",						
						error: function(e){
							console.log(e.responseText);	
						}
					},
		
			"bDestroy": true,
            "iDisplayLength": 20,//Paginación
			"order": [[ 0, "desc" ]],//Ordenar (columna,orden)
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},
		
		
		
      });
	
		
}
//Función para guardar o editar
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
						url: '../controlador/oncenteradmintareas.php?op=verHistorialTablaTareas&id_estudiante='+id_estudiante,
						type : "get",
						dataType : "json",						
						error: function(e){
							console.log(e.responseText);	
						}
					},
			
			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			"order": [[ 0, "desc" ]],//Ordenar (columna,orden)
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},
		
      });
	

		
}


// fin agregar tareas, seguimiento y historial

function validarTarea(id_estudiante,tipo,consulta,id_tarea) {
	$.post("../controlador/oncenteradmintareas.php?op=validarTarea",{id_tarea:id_tarea},function(data){
			
		//console.log(data);
		var r = JSON.parse(data);
		if (r.status == "ok") {
			alertify.success("OK");
			buscar(tipo,id_estudiante,consulta);
		} else {
			alertify.success("Error");
		}		

	});
}
function iniciarTour(){
	introJs().setOptions({
		nextLabel: 'Siguiente',
		prevLabel: 'Anterior',
		doneLabel: 'Terminar',
		showBullets:false,
		showProgress:true,
		showStepNumbers:true,
		steps: [ 
			{
				title: 'Admin tareas',
				intro: ""
			},
			{
				title: 'Total general',
				element: document.querySelector('#t-tog'),
				intro: ""
			},
			{
				title: 'Total cumplidas',
				element: document.querySelector('#t-toc'),
				intro: ""
			},
			{
				title: 'Total pendientes',
				element: document.querySelector('#t-top'),
				intro: ""
			},
			{
				title: 'Total no cumplidas',
				element: document.querySelector('#t-tcm'),
				intro: ""
			},
			{
				title: 'Total del dia',
				element: document.querySelector('#t-tod'),
				intro: ""
			},
			{
				title: 'Asesores',
				element: document.querySelector('#t-as'),
				intro: ""
			},
			{
				title: 'Citas',
				element: document.querySelector('#t-C'),
				intro: ""
			},
			{
				title: 'Seguimientos',
				element: document.querySelector('#t-seg'),
				intro: ""
			},
			{
				title: 'Llamadas',
				element: document.querySelector('#t-Lla'),
				intro: ""
			},
			{
				title: 'Totales',
				element: document.querySelector('#t-To'),
				intro: ""
			},
			
			
			
			
			

		]
			
	},
	console.log()
	
	).start();

}
function volver() {
	consulta();
	$(".datos").attr("hidden",false);
	$(".datos_usuario").attr("hidden",true);
}