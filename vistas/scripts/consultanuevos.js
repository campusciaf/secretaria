var tabla;

//Función que se ejecuta al inicio
function init(){
	
	$.post("../controlador/consultanuevos.php?op=periodo", function(data){
		data = JSON.parse(data);
		$("#precarga").show();
		listarNuevos(data.periodo,1);

	});	


}

$.post("../controlador/consultanuevos.php?op=selectPeriodo", function(r){
    $("#periodo").html(r);
    $('#periodo').selectpicker('refresh');
});

function configurar(){
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

	tabla=$('#tbllistadoconfig').dataTable(
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
					messageTop: '<div style="width:50%;float:left"><b>Programas Activos:</b> Estado activos (Programa_ac) <b><br><b>Reporte:</b> Programas <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Programas',
					 titleAttr: 'Print'
				},
	
			],
			"ajax":
					{
						url: '../controlador/consultanuevos.php?op=configurar',
						type : "get",
						dataType : "json",						
						error: function(e){
							// console.log(e.responseText);	
						}
					},
			
				"bDestroy": true,
				"iDisplayLength": 10,//Paginación
				"order": [[ 1, "asc" ]],
				'initComplete': function (settings, json) {
					$("#configurar").modal("show");

				},
	
		  });
}

function cambioestado(id_programa,estado){
	
	$.post("../controlador/consultanuevos.php?op=cambioestado",{id_programa:id_programa,estado:estado},function(data, status){
		data = JSON.parse(data);// convertir el mensaje a json
		if(data["0"]["0"]==1){
			alertify.success("Cambio de estado");
			$('#tbllistadoconfig').DataTable().ajax.reload();
		}else{
			alertify.error("No se ejecuto el cambio");
		}

		

	});
}


function listarNuevos(periodo,estado){
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	
	$("#precarga").show();
	$.post("../controlador/consultanuevos.php?op=listarDos",{periodo:periodo, estado:estado},function(data, status){	
		data = JSON.parse(data);// convertir el mensaje a json
		
		$(document).ready(function() {
			$('#tbllistado').DataTable({
				"paging":   false,
				
				dom: 'Bfrtip',
				buttons: [
					{
						extend:    'excelHtml5',
						text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
						titleAttr: 'Excel'
					},
					{
						extend: 'print',
						text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
						messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
						title: 'Ejes',
						titleAttr: 'Print'
					},
				],
						
				"language":{ 
					"url": "../public/datatables/idioma/Spanish.json"
				},
				"order": [[ 0, "asc" ]],//Ordenar (columna,orden)
				'initComplete': function (settings, json) {
					$("#precarga").hide();
					$("#dato_periodo").html("Nuevos " + periodo)
				},
				
			});
		} );

		
		$("#resultado").hide();
		$("#resultadoDos").show();
		$("#resultadoDos").html("");// limpiar el div resultado
		$("#resultadoDos").append(data["0"]["0"]);// agregar el resultao al div resultado
		$("#precarga").hide();
	});
}




function mostraranterior(periodo,estado){
	alert(periodo + '-' + estado);
}
function listar(){
	$("#precarga").show();
	$.post("../controlador/consultanuevos.php?op=listar",{},function(data, status){
		data = JSON.parse(data);// convertir el mensaje a json
		$("#resultado").show();
		$("#resultadoDos").hide();
		$("#resultado").html("");// limpiar el div resultado
		$("#resultado").append(data["0"]["0"]);// agregar el resultao al div resultado
		$("#precarga").hide();
		
		$.post("../controlador/consultanuevos.php?op=selectPeriodo",{},function(data, status){
    		data = JSON.parse(data);// convertir el mensaje a json
            var ancho=data["0"]["1"];
    		var a=0;
    		while(a < ancho){
    			$("#periodo_buscar" + a).html("");// limpiar el div resultado
    			$("#periodo_buscar" + a).append(data["0"]["0"]);// agregar el resultao al div resultado
    			a++;
    		}
        });
	});
}

function listarDos(periodo,estado){
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	
	$("#precarga").show();
	$.post("../controlador/consultanuevos.php?op=listarDos",{periodo:periodo, estado:estado},function(data, status){	
		data = JSON.parse(data);// convertir el mensaje a json
		
		$(document).ready(function() {
			$('#tbllistado').DataTable({
				"paging":   false,
				
				dom: 'Bfrtip',
				buttons: [
					{
						extend:    'excelHtml5',
						text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
						titleAttr: 'Excel'
					},
					{
						extend: 'print',
						text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
						messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
						title: 'Ejes',
						titleAttr: 'Print'
					},
				],
						
				"language":{ 
					"url": "../public/datatables/idioma/Spanish.json"
				},
				"order": [[ 0, "asc" ]]//Ordenar (columna,orden)
				
			});
		} );

		
		$("#resultado").hide();
		$("#resultadoDos").show();
		$("#resultadoDos").html("");// limpiar el div resultado
		$("#resultadoDos").append(data["0"]["0"]);// agregar el resultao al div resultado
		$("#precarga").hide();
	});
}

function listarTres(nombre_estado,medio,periodo){
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	
	$("#precarga").show();
	$.post("../controlador/consultanuevos.php?op=listarTres",{nombre_estado:nombre_estado, medio:medio, periodo:periodo},function(data, status){	
		data = JSON.parse(data);// convertir el mensaje a json
		
		$(document).ready(function() {
			$('#tbllistado').DataTable({
				"paging":   false,
				
				dom: 'Bfrtip',
				buttons: [
					{
						extend:    'excelHtml5',
						text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
						titleAttr: 'Excel'
					},
					{
						extend: 'print',
						text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
						messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
						title: 'Ejes',
						titleAttr: 'Print'
					},
				],
						
				"language":{ 
					"url": "../public/datatables/idioma/Spanish.json"
				},
				"order": [[ 0, "asc" ]]//Ordenar (columna,orden)
				
			});
		} );

		
		$("#resultado").hide();
		$("#resultadoDos").show();
		$("#resultadoDos").html("");// limpiar el div resultado
		$("#resultadoDos").append(data["0"]["0"]);// agregar el resultao al div resultado
		$("#precarga").hide();
	});
}



function volver(){
	$("#resultado").show();
	$("#resultadoDos").hide();
	
}


// funcion para listar los estudaintes por programa y jornada
function verEstudiantes(periodo,jornada,fo_programa,estado)
{
	
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	$("#titulo").html("Programa: <b>"+fo_programa+"</b><br> Jornada:<b> "+jornada+"</b><br>Periodo: <b>"+periodo+"</b>");// limpiar el div resultado
	
	tabla=$('#tbllistadoestudiantes').dataTable(
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
                messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>'+periodo+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/consultanuevos.php?op=verEstudiantes&fo_programa='+fo_programa+'&jornada='+jornada+'&periodo='+periodo+'&estado='+estado,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
	
		$("#myModalListado").modal("show");// limpiar el div resultado
		$("#precarga").hide();
}

// funcion para listar los estudaintes por programa y jornada
function verEstudiantesmedio(nombre_programa,jornada,medio,estado,periodo)
{
	
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	$("#titulo").html("Programa: <b>"+nombre_programa+"</b><br> Jornada:<b> "+jornada+"</b><br>Estado: <b>"+estado+"</b>");// limpiar el div resultado
	
	tabla=$('#tbllistadoestudiantes').dataTable(
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
                messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>'+estado+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/consultanuevos.php?op=verEstudiantesMedio&nombre_programa='+nombre_programa+'&jornada='+jornada+'&medio='+medio+'&estado='+estado+'&periodo='+periodo,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
	
		$("#myModalListado").modal("show");// limpiar el div resultado
		$("#precarga").hide();
}

// funcion para listar los estudaintes por suma de programa y jornada
function verEstudiantesSuma(jornada,periodo,estado)
{
	
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	$("#titulo").html("Jornada:<b> "+jornada+"</b><br>Estado: <b>"+periodo+"</b>");// limpiar el div resultado
	
	tabla=$('#tbllistadoestudiantes').dataTable(
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
                messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>'+jornada+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/consultanuevos.php?op=verEstudiantesSuma&jornada='+jornada+'&periodo='+periodo+'&estado='+estado,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
	
		$("#myModalListado").modal("show");// limpiar el div resultado
		$("#precarga").hide();
}




// funcion para listar los estudaintes por suma de programa y jornada
function verEstudiantesTotal(periodo,estado)
{
	
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	$("#titulo").html("Estado: <b>"+periodo+"</b>");// limpiar el div resultado
	
	tabla=$('#tbllistadoestudiantes').dataTable(
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
                messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>'+periodo+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/consultanuevos.php?op=verEstudiantesTotal&periodo='+periodo+'&estado='+estado,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
	
		$("#myModalListado").modal("show");// limpiar el div resultado
		$("#precarga").hide();
}

// funcion para listar los estudaintes por suma de programa y jornada
function verEstudiantesTotalMedio(medio,periodo,estado)
{
	
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	$("#titulo").html("Estado: <b>"+estado+"</b>");// limpiar el div resultado
	
	tabla=$('#tbllistadoestudiantes').dataTable(
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
                messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>'+estado+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/consultanuevos.php?op=verEstudiantesTotalMedio&medio='+medio+'&estado='+estado+'&periodo='+periodo,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
	
		$("#myModalListado").modal("show");// limpiar el div resultado
		$("#precarga").hide();
}

init();// inicializa la funcion init