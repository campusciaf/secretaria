var $meta = 0;
var valor_global;
var periodo_global = 0; 
$(document).ready(init);
//Función que se ejecuta al inicio
function init(){
	$("#grafico2").hide();
	buscar(1);
}

function actualizarPeriodo(value) {
	periodo_global = value;
	// Si ya hay una vista activa, actualizala directamente
	if (valor_global === 1 || valor_global === 2) {
		buscar(valor_global);
	}
}

//dependiendo del val ya sea 1 o 2 filtra las tablas 1 = condiciones de programas 2 = condiciones institucionales
function buscar(val) {
	valor_global = val;
	$("#precarga").show();
	$("#listadoregistros2").show();
	$("#grafico2").hide();
	programa(1);
	condiciones(1);
    $.post("../controlador/sac_listar_condicion.php?op=buscar",{val:val, periodo_global:periodo_global},function (data) {
        var r = JSON.parse(data);
        $(".listar_condiciones_programa").html(r.conte);
        $("#tbl_listar_condiciones_programa").DataTable({
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
            }],

			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},
	});
});
}
// muestra el grafico en el nav
function programa(valor){ 
	if(valor_global == 1){
        $("#opciones2").hide(); // Deshabilita el botón
    } else {
        $("#opciones2").show(); // Habilita el botón si valor_global no es 1
    }
	if(valor==1){
		$("#opciones").html('<a onclick="programa(2)"><i class="fas fa-chart-pie  float-right p-2"></i></a> <i class="fas fa-table float-right p-2 text-primary"></i>');
		
		$("#listadoregistros").show();
		$("#grafico1").hide();
	}else{
		grafico1();
		$("#opciones").html('<i class="fas fa-chart-pie float-right p-2 text-primary"></i> <a onclick="programa(1)"><i class="fas fa-table float-right p-2"></i></a>');
		$("#listadoregistros").hide();
		$("#grafico1").show();
	}
	
}

// muestra el grafico en el nav
function condiciones(valor){
	if(valor_global == 2){
        $("#opciones").hide(); // Deshabilita el botón
    } else {
        $("#opciones").show(); // Habilita el botón si valor_global no es 1
    }
	if(valor==1){
		$("#opciones2").html('<a onclick="condiciones(2)"><i class="fas fa-chart-pie  float-right p-2"></i></a> <i class="fas fa-table float-right p-2 text-primary"></i>');
		
		$("#listadoregistros2").show();
		$("#grafico2").hide();
	}else{
		grafico2();
		$("#opciones2").html('<i class="fas fa-chart-pie float-right p-2 text-primary"></i> <a onclick="condiciones(1)"><i class="fas fa-table float-right p-2"></i></a>');
		$("#listadoregistros2").hide();
		$("#grafico2").show();
	}
	
}
//Función mostrar formulario
function mostrarform(flag){
	if (flag){
		$("#listadoregistros").hide();
		$("#listadoregistros2").hide();

	
	}else{
		$("#listadoregistros").show();
		$("#listadoregistros2").show();
	}
}
//Función para mostrar nombre de la meta 
function nombre_meta_con_pro(id_con_pro){
	
	$.post("../controlador/sac_listar_condicion.php?op=nombre_meta_con_pro",{ "id_con_pro": id_con_pro, periodo_global:periodo_global },function(data){
		data = JSON.parse(data);
		$("#myModalMetaCondicion").modal("show");
		$(".id_con_pro").html(data);
	});
}
//Función para mostrar nombre de la meta 
function nombre_accion(id_con_pro){
	$.post("../controlador/sac_listar_condicion.php?op=nombre_accion",{ "id_con_pro": id_con_pro, periodo_global:periodo_global },function(data){
		data = JSON.parse(data);
		$("#myModalAccion").modal("show");
		$(".id_con_pro").html(data);
		
	});
}	
//Función para mostrar nombre de la meta 
function nombre_meta_con_ins(id_con_ins){
	$.post("../controlador/sac_listar_condicion.php?op=nombre_meta_con_ins",{ "id_con_ins": id_con_ins , periodo_global:periodo_global},function(data){
		data = JSON.parse(data);
		$("#myModalNombreMetaInstitucional").modal("show");
		$(".id_con_ins").html(data);
		
	});
}
//Función para mostrar nombre de la meta 
function nombre_accion_institucional(id_con_ins){
	$.post("../controlador/sac_listar_condicion.php?op=nombre_accion_institucional",{ "id_con_ins": id_con_ins, periodo_global:periodo_global },function(data){
		data = JSON.parse(data);
		$("#myModalAccionInstitucion").modal("show");
		$(".id_accion_institucional").html(data);
		
	});
}	

function tareas(id_con_pro){
	$.post("../controlador/sac_listar_condicion.php?op=nombre_tareas",{ "id_con_pro": id_con_pro, periodo_global:periodo_global },function(data){
		data = JSON.parse(data);
		$("#myModalTareas").modal("show");
		$(".mostrar_tareas").html(data);
		
	});
}	
function tareas_insti(id_con_ins){
	$.post("../controlador/sac_listar_condicion.php?op=tareas_insti",{ "id_con_ins": id_con_ins, periodo_global:periodo_global },function(data){
		data = JSON.parse(data);
		$("#myModalTareas").modal("show");
		$(".mostrar_tareas").html(data);
		
	});
}	

function grafico1(){
	$.post("../controlador/sac_listar_condicion.php?op=grafico1",{periodo_global:periodo_global}, function(r){
		r = JSON.parse(r);
        var datos = new Array();
        datos.push(r.datosuno);
        datos=JSON.parse(datos);
		var chart = new CanvasJS.Chart("chartContainer1", {
			theme: "light",
			exportFileName: "Doughnut Chart",
			exportEnabled: false,
			animationEnabled: true,
			backgroundColor: "transparent", // Establecer fondo transparente
			title:{
				text: "Condiciones de programa",
				fontColor: "#607d8a" // Cambiar el color del título
			},
			legend:{
				cursor: "pointer",
				horizontalAlign: "right", // left, center ,right 
				verticalAlign: "center",  // top, center, bottom
				fontColor: "#607d8a", // Cambiar el color del título
				itemclick: explodePie
			},

			data: [{
				type: "doughnut",
				innerRadius: 90,
				showInLegend: true,
				indexLabelFontColor: "#607d8a", // Cambiar el color de la etiqueta
				toolTipContent: "<b>{name}</b>: ${y} (#percent%)",
				indexLabel: "{name} - #percent%",
				dataPoints: datos
			}]
		});
		chart.render();
	});
		function explodePie (e) {
			if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
				e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
			} else {
				e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
			}
			e.chart.render();
		}
}

function grafico2(){

	$.post("../controlador/sac_listar_condicion.php?op=grafico2",{periodo_global:periodo_global}, function(r){
		r = JSON.parse(r);
        var datos = new Array();
        datos.push(r.datosuno);
        datos=JSON.parse(datos);
		var chart = new CanvasJS.Chart("chartContainer2", {
			theme: "light",
			exportFileName: "Doughnut Chart",
			exportEnabled: false,
			animationEnabled: true,
			backgroundColor: "transparent", // Establecer fondo transparente
			title:{
				text: "Condiciones Institucionales",
				fontColor: "#607d8a" // Cambiar el color del título
			},
			legend:{
				cursor: "pointer",
				horizontalAlign: "right", // left, center ,right 
				verticalAlign: "center",  // top, center, bottom
				fontColor: "#607d8a", // Cambiar el color del título
				itemclick: explodePie
			},
			data: [{
				type: "doughnut",
				innerRadius: 90,
				showInLegend: true,
				indexLabelFontColor: "#607d8a", // Cambiar el color de la etiqueta
				toolTipContent: "<b>{name}</b>: ${y} (#percent%)",
				indexLabel: "{name} - #percent%",
				dataPoints: datos
			}]
		});

		chart.render();
	});
		function explodePie (e) {
			if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
				e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
			} else {
				e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
			}
			e.chart.render();
		}
		
		
}

function iniciarTour() {
	introJs().setOptions({
		"nextLabel": 'Siguiente',
		"prevLabel": 'Anterior',
		"doneLabel": 'Terminar',
		"showBullets": false,
		"showProgress": true,
		"showStepNumbers": true,
		"steps": [
			{
				"title": 'Condiciónes de programa',
				"element": document.querySelector('#tour_grafico'),
				"intro": 'Muestra las condiciones de programa por meta y acciones'
			},
			{
				"title": 'Condiciones Institucionales',
				"element": document.querySelector('#tour_condiciones_institucionales'),
				"intro": 'Muestra las condiciones Institucionales por meta y acciones'
			},
			{
				"title": 'Mostrar Datos',
				"element": document.querySelector('#tour_muestra_tabla'),
				"intro": 'Muestra las condiciones por tabla o por grafica'
			},
			{
				"title": 'Condiciones De programa',
				"element": document.querySelector('#tour_condiciones'),
				"intro": 'Muestra las condiciones Institucionales'
			},
			{
				"title": 'Metas',
				"element": document.querySelector('#tour_meta'),
				"intro": 'Muestra de manera detallada el nombre de la meta y las acciones'
			},
			{
				"title": 'Acciones',
				"element": document.querySelector('#tour_acciones'),
				"intro": 'Muestra las acciones de la condicion'
			},
		]
	},
	).start();
}
init();


