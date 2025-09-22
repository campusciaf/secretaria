$(document).ready(inicio);
function inicio() {
	consulta();
}

function consulta() {
	$("#precarga").attr("hidden",false);
    $.post("../controlador/sofiadmintareas.php?op=consulta",function(datos){
        //console.log(datos);
        var r = JSON.parse(datos);
		$(".datos").html(r.conte);
		$("#precarga").attr("hidden",true);
	});
}


function buscar(tipo,id,consulta) {
	$("#precarga").attr("hidden",false);
    $.post("../controlador/sofiadmintareas.php?op=buscar",{tipo:tipo,id:id,consulta:consulta},function(datos){
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
	$.post("../controlador/sofiadmintareas.php?op=cambiarasesor",{id_tarea:id_tarea,id_asesor:id_asesor},function(data){
		
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
	$.post("../controlador/sofiadmintareas.php?op=cambiarfecha",{id_tarea:id_tarea,fecha:fecha},function(data){
		
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


// fin agregar tareas, seguimiento y historial

function validarTarea(id_estudiante,tipo,consulta,id_tarea) {
	$.post("../controlador/sofiadmintareas.php?op=validarTarea",{id_tarea:id_tarea},function(data){
			
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