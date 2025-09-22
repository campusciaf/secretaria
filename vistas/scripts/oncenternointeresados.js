var tabla;

//Función que se ejecuta al inicio
function init(){
	
	listar();// incializar la funcion listar
	
		$("#moverUsuario").on("submit",function(e4)
	{
		guardarMoverUsuario(e4);	
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
				title: 'Panel no interesados',
				intro: "Bienvenido a nuestro panel general de no interesados donde encontrarás todas las categorias, y tendrás acceso a toda la información correspondiente "
			},
			
			{
				title: 'Estados',
				element: document.querySelector('#t-eto'),
				intro: "Aquí podrás encontrar el panel general de cada categoría  "
			},

			{
				title: 'Campaña actual',
				element: document.querySelector('#t-Ca'),
				intro: "Aquí encontrarás  todos los resultados en nuestra campaña actual "
			},
			{
				title: 'Campaña anteriores',
				element: document.querySelector('#t-Cn'),
				intro: "Aquí encontrarás  todos los resultados de no interesados en nuestra campañas anteriores "
			},
			{
				title: 'Sede principal',
				element: document.querySelector('#t-paso0'),
				intro: "Aquí podrás encontrar  todos los resultados en nuestra sede prncipal "
			},
			{
				title: 'Marketing-digital',
				element: document.querySelector('#t-paso1'),
				intro: "Aquí podrás encontrar todos los resultados en marketin-digital"
			},
			{
				title: 'Web',
				element: document.querySelector('#t-paso2'),
				intro: " Aquí podrás encontrar todos los resultados por nuestra web"
			},
			{
				title: 'Súmate al parche',
				element: document.querySelector('#t-paso3'),
				intro: "Aquí podrás encontrar todos los resultados  en súmate al parche"
			},
			{
				title: 'volante',
				element: document.querySelector('#t-paso4'),
				intro: "Aquí podrás encontrar todos los resultados de nuestra categoría volante "
			},
			{
				title: 'Feria',
				element: document.querySelector('#t-paso5'),
				intro: "Aquí podrás encontrar todos los resultados de nuestras ferias "
			},
			
		]
			
	},
	console.log()
	
	).start();

}

function iniciarSegundoTour() {
	introJs().setOptions({
		"nextLabel": 'Siguiente',
		"prevLabel": 'Anterior',
		"doneLabel": 'Terminar',
		"showBullets": false,
		"showProgress": true,
		"showStepNumbers": true,
		"steps": [{
			"title": 'Panel no interesados',
			"intro": 'Bienvenido a nuestro panel general de registros de no interesados donde descubrirás por que aún no hacen parte de nuestras experencias creativas'
		},
		{
			"title": 'Programa',
			"element": document.querySelector('#t2-paso0'),
			"intro": "Aquí encontrarás los diferentes programas totales de las personas no interesadas "
		},
		{
			"title": 'Ninguno',
			"element": document.querySelector('#t2-paso1'),
			"intro": "Aquí encontrarás los registros si la persona  aún no ha definido en que horario recibirá sus experiencias creativas"
		},
		{
			"title": 'Diurna',
			"element": document.querySelector('#t2-paso2'),
			"intro": "Da un vistazo a los estudiantes que optaron por recibir sus experiencias creativas de día "
		},
		{
			"title": 'Nocturna',
			"element": document.querySelector('#t2-paso3'),
			"intro": "Da un vistazo a los estudiantes que optaron por recibir sus experiencias creativas de noche"
		},
		{
			"title": 'Fines de semana',
			"element": document.querySelector('#t2-paso4'),
			"intro": "Da un vistazo a los estudiantes que optaron por recibir sus experiencias creativas los fines de semana"
		},
		{
			"title": 'Sábados',
			"element": document.querySelector('#t2-paso5'),
			"intro": "Da un vistazo a los estudiantes que optaron por recibir sus experiencias creativas solo los sábados"
		},
		{
			"title": 'CAP',
			"element": document.querySelector('#t2-paso6'),
			"intro": "Da un vistazo a los estudiantes que optaron por recibir sus experiencias creativas en nuestra jornada CAP"
		},
		{
			"title": 'Volver',
			"element": document.querySelector('#t2-volt'),
			"intro": "Regresa el tiempo en nuestro campus y encontrarás nuevamente nuestro panel de no interesados"
		},


		
		]
	}).start();
}

function mostraranterior(periodo,estado){
	alert(periodo + '-' + estado);
}

function listar(){
	$("#precarga").show();
	$.post("../controlador/oncenternointeresados.php?op=listar",{},function(data, status){
		data = JSON.parse(data);// convertir el mensaje a json
		$("#resultado").show();
		$("#resultadoDos").hide();
		$("#resultado").html("");// limpiar el div resultado
		$("#resultado").append(data["0"]["0"]);// agregar el resultao al div resultado
		$("#precarga").hide();
		
		$.post("../controlador/oncenternointeresados.php?op=selectPeriodo",{},function(data, status){
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
	$.post("../controlador/oncenternointeresados.php?op=listarDos",{periodo:periodo, estado:estado},function(data, status){	
		data = JSON.parse(data);// convertir el mensaje a json
		
		$(document).ready(function() {
			$('#tbllistado').DataTable({
				"paging":   false,
				
				dom: 'Bfrtip',
				buttons: [
					{
						//extend:    'excelHtml5',
						//text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
						//titleAttr: 'Excel'
					},
					{
						//extend: 'print',
						//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
						//messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
						//title: 'Ejes',
						//titleAttr: 'Print'
					},
				],
						
				"language":{ 
					"url": "../public/datatables/idioma/Spanish.json"
				},
				"order": [[ 0, "asc" ]],//Ordenar (columna,orden)
				
				
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
	$(".primer_tour").addClass("d-none");
	$(".segundo_tour").removeClass("d-none");
	$.post("../controlador/oncenternointeresados.php?op=listarTres",{nombre_estado:nombre_estado, medio:medio, periodo:periodo},function(data, status){	
		data = JSON.parse(data);// convertir el mensaje a json
		
		$(document).ready(function() {
			$('#tbllistado').DataTable({
				"paging":   false,
				
				dom: 'Bfrtip',
				buttons: [
					{
						//extend:    'excelHtml5',
						//text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
						//titleAttr: 'Excel'
					},
					{
						//extend: 'print',
						//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
						//messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
						//title: 'Ejes',
						//titleAttr: 'Print'
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
	$(".primer_tour").removeClass("d-none");
	$(".segundo_tour").addClass("d-none");
	
}


// funcion para listar los estudaintes por programa y jornada
function verEstudiantes(nombre_programa,jornada,estado,periodo)
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
                //extend:    'excelHtml5',
               // text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
               // titleAttr: 'Excel'
            },
			{
                //extend: 'print',
			 	//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                //messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>'+estado+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				//title: 'Ejes',
			 	//titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/oncenternointeresados.php?op=verEstudiantes&nombre_programa='+nombre_programa+'&jornada='+jornada+'&estado='+estado+'&periodo='+periodo,
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
                //extend:    'excelHtml5',
                //text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                //titleAttr: 'Excel'
            },
			{
                //extend: 'print',
			 	//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                //messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>'+estado+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				//title: 'Ejes',
			 	//titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/oncenternointeresados.php?op=verEstudiantesMedio&nombre_programa='+nombre_programa+'&jornada='+jornada+'&medio='+medio+'&estado='+estado+'&periodo='+periodo,
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
function verEstudiantesSuma(jornada,estado,periodo)
{
	
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	$("#titulo").html("Jornada:<b> "+jornada+"</b><br>Estado: <b>"+estado+"</b>");// limpiar el div resultado
	
	tabla=$('#tbllistadoestudiantes').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	           buttons: [
            {
                //extend:    'excelHtml5',
                //text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                ///titleAttr: 'Excel'
            },
			{
               // extend: 'print',
			 	//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
               // messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>'+estado+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				//title: 'Ejes',
			 	//titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/oncenternointeresados.php?op=verEstudiantesSuma&jornada='+jornada+'&estado='+estado+'&periodo='+periodo,
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
function verEstudiantesSumaMedio(jornada,medio,estado,periodo)
{
	
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	$("#titulo").html("Jornada:<b> "+jornada+"</b><br>Estado: <b>"+estado+"</b>");// limpiar el div resultado
	
	tabla=$('#tbllistadoestudiantes').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	           buttons: [
            {
               // extend:    'excelHtml5',
               // text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
               // titleAttr: 'Excel'
            },
			{
                //extend: 'print',
			 	//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                //messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>'+estado+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				//title: 'Ejes',
			 	//titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/oncenternointeresados.php?op=verEstudiantesSumaMedio&jornada='+jornada+'&medio='+medio+'&estado='+estado+'&periodo='+periodo,
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
	
	$("#titulo").html("Estado: <b>"+estado+"</b>");// limpiar el div resultado
	
	tabla=$('#tbllistadoestudiantes').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	           buttons: [
            {
                //extend:    'excelHtml5',
                //text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                //titleAttr: 'Excel'
            },
			{
                //extend: 'print',
			 	//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                //messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>'+estado+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				//title: 'Ejes',
			 	//titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/oncenternointeresados.php?op=verEstudiantesTotal&estado='+estado+'&periodo='+periodo,
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
                //extend:    'excelHtml5',
               // text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                //titleAttr: 'Excel'
            },
			{
                //extend: 'print',
			 	//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                //messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b>'+estado+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				//title: 'Ejes',
			 	//titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/oncenternointeresados.php?op=verEstudiantesTotalMedio&medio='+medio+'&estado='+estado+'&periodo='+periodo,
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

function selectEstado(){
	//Cargamos los items de los selects
	$.post("../controlador/oncenternointeresados.php?op=selectEstado", function(r){
	            $("#estado").html(r);
	            $('#estado').selectpicker('refresh');
	});
}

function selectPeriodoDos(){
	//Cargamos los items de los selects
	$.post("../controlador/oncenternointeresados.php?op=selectPeriodoDos", function(r){
	            $("#periodo_dos").html(r);
	            $('#periodo_dos').selectpicker('refresh');
	});
}


function mover(id_estudiante,fila){
	selectEstado();
	selectPeriodoDos();
	$("#btnMover").prop("disabled",false);
	$("#myModalMover").modal("show");
	$("#id_estudiante_mover").val(id_estudiante);
	$("#fila_mover").val(fila);
	

}

function guardarMoverUsuario(e4)
{
	e4.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnMover").prop("disabled",true);
	var formData = new FormData($("#moverUsuario")[0]);

	$.ajax({
		url: "../controlador/oncenternointeresados.php?op=moverUsuario",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    { 
			
			alertify.set('notifier','position', 'top-center');
	        alertify.success(datos);	 
			$("#myModalMover").modal("hide");
			var fila=$("#fila_mover").val();
	        $(".fila"+fila).hide(); 
			tabla.ajax.reload();
	    }

	});
	
}


function limpiarTarea(){
	$("#mensaje_tarea").val("");
	$("#fecha_programada").val("");
	$("#hora_programada").val("");
}

function verHistorial(id_estudiante){
	$("#precarga").show();
	$.post("../controlador/oncenternointeresados.php?op=verHistorial",{id_estudiante:id_estudiante},function(data, status){
		
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
var estado="No_interesados";	
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
                //extend:    'excelHtml5',
                //text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                //titleAttr: 'Excel'
            },
			{
               // extend: 'print',
			 	//text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                //messageTop: '<div style="width:50%;float:left">Reporte: <b>'+estado+' </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				//title: 'Ejes',
			 	//titleAttr: 'Seguimiento'
            },

        ],
		"ajax":
				{
					url: '../controlador/oncenternointeresados.php?op=verHistorialTabla&id_estudiante='+id_estudiante,
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
	

		
}

// funcion para listar los estudaintes por suma de programa y jornada
function verHistorialTablaTareas(id_estudiante)
{
var estado="No_interesados";	
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
                //extend:    'excelHtml5',
                //text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                //titleAttr: 'Excel'
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
					url: '../controlador/oncenternointeresados.php?op=verHistorialTablaTareas&id_estudiante='+id_estudiante,
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
	

		
}

//Función para activar registros
function eliminar(id_estudiante,fila)
{
	alertify.confirm('Eliminar Caso', '¿Está Seguro de eliminar el Caso?', function(){ 
	
		$.post("../controlador/oncenternointeresados.php?op=eliminar", {id_estudiante : id_estudiante}, function(e){
			
        		if(e == 1){
				   alertify.success("Caso Eliminado");
					$(".fila"+fila).hide(); 
					tabla.ajax.reload();
				   }
				else{
					alertify.error("Caso no se puede eliminar");
				}
        	});
	
	}
                , function(){ alertify.error('Cancelado')});


}

init();// inicializa la funcion init