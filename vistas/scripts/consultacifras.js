var tabla;

//Función que se ejecuta al inicio
function init(){
    listarescuelas();
}


//Cargamos los items de los selects
function  cargarperiodo(){
    $.post("../controlador/consultacifras.php?op=selectPeriodo", function(r){
        $("#periodo").html(r);
        $('#periodo').selectpicker('refresh');
    });

}


    

function listarescuelas(){
    $("#precarga").show();

           
           $.post("../controlador/consultacifras.php?op=listarescuelas",{}, function(r){
               var e = JSON.parse(r);

               $("#escuelas").html(e.mostrar);
               $("#precarga").hide();
           });
}


function listar(id_escuela){
    $("#precarga").show();

           
           $.post("../controlador/consultacifras.php?op=listar",{id_escuela:id_escuela}, function(r){
               var e = JSON.parse(r);

               $("#resultado").html(e.mostrar);
               $("#precarga").hide();
           });
}

//Función ver estudiantes
function traerdatos(id_escuela,sede,periodo_anterior){
	$("#precarga").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		
		tabla=$('#tbllistado').dataTable(
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
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					 titleAttr: 'Print'
				},
	
			],
			"ajax":
					{
						url: '../controlador/consultacifras.php?op=traerdatos&id_escuela='+id_escuela+'&sede='+sede+'&periodo_anterior='+periodo_anterior,
						type : "get",
						dataType : "json",						
						error: function(e){
							console.log(e.responseText);	
						}
					},
			
				"bDestroy": true,
				"iDisplayLength": 10,//Paginación
				"order": [[ 1, "asc" ]],
				'initComplete': function (settings, json) {
					$("#modalDatos").modal("show");
					$("#precarga").hide();
				},
	
		  });
		
			
	}

	//Función ver estudiantes contaduria sede
function traerdatoscontaduriasede(id_escuela,sede,periodo_anterior){
	$("#precarga").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		
		tabla=$('#tbllistado').dataTable(
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
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					 titleAttr: 'Print'
				},
	
			],
			"ajax":
					{
						url: '../controlador/consultacifras.php?op=traerdatoscontaduriasede&id_escuela='+id_escuela+'&sede='+sede+'&periodo_anterior='+periodo_anterior,
						type : "get",
						dataType : "json",						
						error: function(e){
							console.log(e.responseText);	
						}
					},
			
				"bDestroy": true,
				"iDisplayLength": 10,//Paginación
				"order": [[ 1, "asc" ]],
				'initComplete': function (settings, json) {
					$("#modalDatos").modal("show");
					$("#precarga").hide();
				},
	
		  });
		
			
	}

		//Función ver estudiantes contaduria sede
function traerdatoscontaduriaintep(id_escuela,sede,periodo_anterior){
	$("#precarga").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		
		tabla=$('#tbllistado').dataTable(
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
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					 titleAttr: 'Print'
				},
	
			],
			"ajax":
					{
						url: '../controlador/consultacifras.php?op=traerdatoscontaduriaintep&id_escuela='+id_escuela+'&sede='+sede+'&periodo_anterior='+periodo_anterior,
						type : "get",
						dataType : "json",						
						error: function(e){
							console.log(e.responseText);	
						}
					},
			
				"bDestroy": true,
				"iDisplayLength": 10,//Paginación
				"order": [[ 1, "asc" ]],
				'initComplete': function (settings, json) {
					$("#modalDatos").modal("show");
					$("#precarga").hide();
				},
	
		  });
		
			
	}


//Función ver estudiantes
function traerdatosarticulacion(id_escuela,periodo_anterior,jornadaarticulacion){
	$("#precarga").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		
		tabla=$('#tbllistado').dataTable(
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
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					 titleAttr: 'Print'
				},
	
			],
			"ajax":
					{
						url: '../controlador/consultacifras.php?op=traerdatosarticulacion&id_escuela='+id_escuela+'&periodo_anterior='+periodo_anterior+'&jornadaarticulacion='+jornadaarticulacion,
						type : "get",
						dataType : "json",						
						error: function(e){
							console.log(e.responseText);	
						}
					},
			
				"bDestroy": true,
				"iDisplayLength": 10,//Paginación
				"order": [[ 1, "asc" ]],
				'initComplete': function (settings, json) {
					$("#modalDatos").modal("show");
					$("#precarga").hide();
				},
	
		  });

	}
//Función ver estudiantes
function traerdatosnuevos(id_escuela,periodo_actual,jornada){
	$("#precarga").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		
		tabla=$('#tbllistado').dataTable(
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
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					 titleAttr: 'Print'
				},
	
			],
			"ajax":
					{
						url: '../controlador/consultacifras.php?op=traerdatosnuevos&id_escuela='+id_escuela+'&periodo_actual='+periodo_actual+'&jornada='+jornada,
						type : "get",
						dataType : "json",						
						error: function(e){
							console.log(e.responseText);	
						}
					},
			
				"bDestroy": true,
				"iDisplayLength": 10,//Paginación
				"order": [[ 1, "asc" ]],
				'initComplete': function (settings, json) {
					$("#modalDatos").modal("show");
					$("#precarga").hide();
				},
	
		  });

}

//Función ver estudiantes
function traerdatosrenovacion(id_escuela,periodo_actual){
	$("#precarga").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		
		tabla=$('#tbllistado').dataTable(
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
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					 titleAttr: 'Print'
				},
	
			],
			"ajax":
					{
						url: '../controlador/consultacifras.php?op=traerdatosrenovacion&id_escuela='+id_escuela+'&periodo_actual='+periodo_actual,
						type : "get",
						dataType : "json",						
						error: function(e){
							console.log(e.responseText);	
						}
					},
			
				"bDestroy": true,
				"iDisplayLength": 10,//Paginación
				"order": [[ 1, "asc" ]],
				'initComplete': function (settings, json) {
					$("#modalDatos").modal("show");
					$("#precarga").hide();
				},
	
		  });

}

//Función ver estudiantes
function traerdatosreintegro(id_escuela,periodo_actual){
	$("#precarga").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		
		tabla=$('#tbllistado').dataTable(
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
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					 titleAttr: 'Print'
				},
	
			],
			"ajax":
					{
						url: '../controlador/consultacifras.php?op=traerdatosreintegro&id_escuela='+id_escuela+'&periodo_actual='+periodo_actual,
						type : "get",
						dataType : "json",						
						error: function(e){
							console.log(e.responseText);	
						}
					},
			
				"bDestroy": true,
				"iDisplayLength": 10,//Paginación
				"order": [[ 1, "asc" ]],
				'initComplete': function (settings, json) {
					$("#modalDatos").modal("show");
					$("#precarga").hide();
				},
	
		  });

}



//Función ver estudiantes
function traerdatosreintegrointerno(id_escuela,periodo_actual){
	$("#precarga").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		
		tabla=$('#tbllistado').dataTable(
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
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					 titleAttr: 'Print'
				},
	
			],
			"ajax":
					{
						url: '../controlador/consultacifras.php?op=traerdatosreintegrointerno&id_escuela='+id_escuela+'&periodo_actual='+periodo_actual,
						type : "get",
						dataType : "json",						
						error: function(e){
							console.log(e.responseText);	
						}
					},
			
				"bDestroy": true,
				"iDisplayLength": 10,//Paginación
				"order": [[ 1, "asc" ]],
				'initComplete': function (settings, json) {
					$("#modalDatos").modal("show");
					$("#precarga").hide();
				},
	
		  });

}

//Función ver estudiantes
function traerdatosrenovacioninterna(id_escuela,periodo_actual){
	$("#precarga").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		
		tabla=$('#tbllistado').dataTable(
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
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					 titleAttr: 'Print'
				},
	
			],
			"ajax":
					{
						url: '../controlador/consultacifras.php?op=traerdatosrenovacioninterna&id_escuela='+id_escuela+'&periodo_actual='+periodo_actual,
						type : "get",
						dataType : "json",						
						error: function(e){
							console.log(e.responseText);	
						}
					},
			
				"bDestroy": true,
				"iDisplayLength": 10,//Paginación
				"order": [[ 1, "asc" ]],
				'initComplete': function (settings, json) {
					$("#modalDatos").modal("show");
					$("#precarga").hide();
				},
	
		  });

}

//Función ver estudiantes
function traerdatosrenovacioninternaarticulacion(id_escuela,periodo_actual,jornada){
	$("#precarga").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		
		tabla=$('#tbllistado').dataTable(
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
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					 titleAttr: 'Print'
				},
	
			],
			"ajax":
					{
						url: '../controlador/consultacifras.php?op=traerdatosrenovacioninternaarticulacion&id_escuela='+id_escuela+'&periodo_actual='+periodo_actual+'&jornada='+jornada,
						type : "get",
						dataType : "json",						
						error: function(e){
							console.log(e.responseText);	
						}
					},
			
				"bDestroy": true,
				"iDisplayLength": 10,//Paginación
				"order": [[ 1, "asc" ]],
				'initComplete': function (settings, json) {
					$("#modalDatos").modal("show");
					$("#precarga").hide();
				},
	
		  });

}

//Función ver estudiantes
function traerdatosrenovacionarticulacion(id_escuela,periodo_actual,jornada){
	$("#precarga").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		
		tabla=$('#tbllistado').dataTable(
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
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Renovaciones',
					 titleAttr: 'Print'
				},
	
			],
			"ajax":
					{
						url: '../controlador/consultacifras.php?op=traerdatosrenovacionarticulacion&id_escuela='+id_escuela+'&periodo_actual='+periodo_actual+'&jornada='+jornada,
						type : "get",
						dataType : "json",						
						error: function(e){
							console.log(e.responseText);	
						}
					},
			
				"bDestroy": true,
				"iDisplayLength": 10,//Paginación
				"order": [[ 1, "asc" ]],
				'initComplete': function (settings, json) {
					$("#modalDatos").modal("show");
					$("#precarga").hide();
				},
	
		  });

}
init();// inicializa la funcion init