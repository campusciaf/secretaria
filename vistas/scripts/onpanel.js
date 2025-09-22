$(document).ready(inicio);
var estado="Preinscrito";
var id_estudiante;
	function inicio() {
		$("#precarga").hide();
		$("#input_dato").show();
		$( "#dato" ).prop( "disabled", true );
	}

	
function consulta() {
	
    var dato = $("#dato").val();
    var tipo = $("#tipo").val();
    if (dato != "" && tipo != "") {
        $.post("../controlador/onpanel.php?op=consulta",{dato:dato,tipo:tipo}, function (datos) {
           
			var r = JSON.parse(datos);
			if (r.status != "error") {
				$("#datos_estudiante").html(r.conte2);
				$("#datos_estudiante").show();
				$(".datos_table").html(r.conte);
				
				
				var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
				var f=new Date();
				var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
				
				$("#tbl_datos").DataTable({
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
							messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
							title: 'Ejes',
							titleAttr: 'Print'
						},

					],
					
							"bDestroy": true,
							"iDisplayLength": 10,//Paginación
							'initComplete': function (settings, json) {
								$("#precarga").hide();
								volver();
							},





						  });



			} else {
				alertify.error("No se encontre ningun dato con esa referencia.");
			}
            
        });
    }else{
        alertify.error("Por favor completa los campos.");
    }
    
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
				title: 'Panel de control',
				intro: 'Bienvenido a nuestro panel de control donde podrás encontrar toda la información desde el día uno de nuestro ser creativo'
			},
			{
				title: 'Buscar cliente',
				element: document.querySelector('#t-CL'),
				intro: "Aquí podrás realizar tu busqueda con diferentes opciones seleccionando la que realmente necesites"
			},
			{
				title: 'Nombre completo',
				element: document.querySelector('#t-NC'),
				intro: "Una vez la busqueda sea exitosa tendrás el nombre completo de nuestro ser creativo"
			},
			{
				title: 'Correo electrónico',
				element: document.querySelector('#t-Ce'),
				intro: "Aquí podrás visualizar el correo institucional de nuestro ser creativo "
			},
			{
				title: 'Número telefonico',
				element: document.querySelector('#t-NT'),
				intro: "Da un vistazo a el número teléfono de nuestro ser creativo"
			},
			{
				title: 'Información',
				element: document.querySelector('#t-TP'),
				intro: "Aquí podrás observar la información de nuestro ser creativo sobre la experiencia creativa de su elección"
			},
			{
				title: 'Caso',
				element: document.querySelector('#t-Cs'),
				intro: "Observa el número de caso correspondiente a nuestro ser creativo, con este número podrás realizar la busqueda inicial"
			},
			{
				title: 'Programa',
				element: document.querySelector('#t-P'),
				intro: "Aquí podrás visualizar el programa al que pertenece nuestro ser creativo "
			},
			{
				title: 'Jornada',
				element: document.querySelector('#t-Jr'),
				intro: "Da un vistazo de la jornada elegida por nustro ser original para vivir todas sus experiencias craetivas"
			},
			{
				title: 'Fecha ingresa',
				element: document.querySelector('#t-FI'),
				intro: "Conoce la fecha en la que se convertió en parte de esta famiia y se nombró como ser creativo"
			},
			{
				title: 'Medio',
				element: document.querySelector('#t-ME'),
				intro: "Conoce su forma de contactarnos y como empezó su proceso para unirse a est gran familia creativa e innovadora"
			},
			{
				title: 'Estado',
				element: document.querySelector('#t-ES'),
				intro: "visualiza el estado actual de nuestro ser creativo en nuestra institución"
			},
			{
				title: 'Periodo de campaña',
				element: document.querySelector('#t-PC'),
				intro: "Aquí podrás ver en cual periodo de campaña se realizó el proceso de nuestro ser creativo"
			},
			{
				title: 'Acciones',
				element: document.querySelector('#t-AC'),
				intro: 'En un click podrás visualizar de manera más detallada la información de nuestro ser creativo teniendo en cuenta que podrás editar algún dato correspondiente a la información <button class="btn btn-primary"><i class="fa fa-eye"></i></button>'
			},
			
			

		]
			
	},
	console.log()
	
	).start();

}

function iniciarSegundoTour() {
	introJs().setOptions({
		nextLabel: 'Siguiente',
		prevLabel: 'Anterior',
		doneLabel: 'Terminar',
		showBullets: false,
		showProgress: true,
		showStepNumbers: true,
		steps: [
			{
				title: 'Configuración cliente',
				intro: 'Aquí es donde ocurre la magia y podrás editar alguns datos de nuestro ser creativo' 
			},
			{
				title: 'Caso',
				element: document.querySelector('#t2-Cas'),
				intro: "visualiza mejor el número de caso de nuestro ser creativo"
			},
			{
				title: 'Campaña',
				element: document.querySelector('#t2-Cam'),
				intro: "Visualiza el periodo de campaña de nuestro ser creativo"
			},
			{
				title: 'Estado',
				element: document.querySelector('#t2-EST'),
				intro: "visualiza el estado actual de nuestro ser creativo"
			},
			{
				title: 'Datos personales',
				element: document.querySelector('#t2-CP'),
				intro: "Aquí podrás editar los datos personales de nuestro ser creativo"
			},
			{
				title: 'Datos de contacto',
				element: document.querySelector('#t2-DC'),
				intro: "Aquí podrás editar los datos de contacto que nuestro ser creativo te proporsionó en todo el proceso"
			},
			{
				title: 'Datos de programa',
				element: document.querySelector('#t2-DP'),
				intro: "De ser necesario aquí podrás editar el programa y la jornada previamente establecida con nuestro ser original"
			},
			{
				title: 'Datos admisiones ',
				element: document.querySelector('#t2-DA'),
				intro: "De ser necesario podrás editar los datos de admisiones previamente diligenciados"
			},
			{
				title: 'Ver seguimiento ',
				element: document.querySelector('#t2-Hi'),
				intro: "Aquí podrás observar todo el seguimiento que se le ha realizado a el proceso de que nuestro ser original sea parte de este parche creativo e innovador"
			},
			{
				title: 'Volver a programas',
				element: document.querySelector('#t2-Vp'),
				intro: "Con nuestro botón del tiempo podrás regresar a nuestro panel de control en un click"
			},


			
			

		]

	},


	).start();

	console.log("holaaa");

}
     

function consulta2() {
	volver();
	var dato = $("#dato").val();
	var tipo = $("#tipo").val();
	if (dato != "" && tipo != "") {
		$.post("../controlador/onpanel.php?op=consulta",{dato:dato,tipo:tipo}, function (datos) {
			
			var r = JSON.parse(datos);
			if (r.status != "error") {
				$(".datos_estudiante").html(r.conte);
				$(".datos_table").html(r.conte2);
				
				var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
				var f=new Date();
				var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
				
				$("#tbl_datos").DataTable({
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
							messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
							title: 'Ejes',
							titleAttr: 'Print'
						},

					],
					
					"bDestroy": true,
					"iDisplayLength": 20,//Paginación
					'initComplete': function (settings, json) {
						$("#precarga").hide();
					},

				

				});


			} else {
				alertify.error("No se encontre ningun dato con esa referencia.");
			}
			
		});
	}else{
		alertify.error("Por favor completa los campos.");
	}
	
}
	function verHistorial(id_estudiante){
	$("#precarga").show();
	$.post("../controlador/onpanel.php?op=verHistorial",{id_estudiante: id_estudiante},function(data, status){
		// console.log(data);
		data = JSON.parse(data);// convertir el mensaje a json
		$("#myModalHistorial").modal("show");
		$("#historial").html("");// limpiar el div resultado
		$("#historial").append(data["0"]["0"]);// agregar el resultao al div resultado
		$("#precarga").hide();
		verHistorialTabla(id_estudiante);
	});
}

	// funcion para listar los estudaintes por suma de programa y jornada
	function verHistorialTabla(id_estudiante) {
		var estado="Inscrito";	
		var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
		var f=new Date();
		var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		$("#titulo").html("Estado: <b>"+estado+"</b>");// limpiar el div resultado
		
		tabla=$('#tbllistadohistorialpanel').dataTable(
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
						url: '../controlador/onpanel.php?op=verHistorialTabla&id_estudiante='+id_estudiante,
						type : "get",
						dataType : "json",						
						error: function(e){
							// console.log(e.responseText);	
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
	if(width <= 750){
		$(api.table().node()).toggleClass('cards');
		api.draw('page');
	}
	window.onresize = function(){

		anchoVentana = window.innerWidth;
			if(anchoVentana > 1000){
				$(api.table().node()).removeClass('cards');
				api.draw('page');
			}else if(anchoVentana > 750 && anchoVentana < 1000){
				$(api.table().node()).removeClass('cards');
				api.draw('page');
			}else{
			$(api.table().node()).toggleClass('cards');
				api.draw('page');
			}
	}
}

function muestra(valor) {
	$( "#dato" ).prop( "disabled", false );
	$( "#btnconsulta" ).prop( "disabled", false );
	
	$("#input_dato").show();

	var tipo = $("#tipo").val(valor);
	if(valor==1){
		$("#valortitulo").html("Ingresar número de identificacíon")
	}
	if(valor==2){
		$("#valortitulo").html("Ingresar número de caso")
	}
	if(valor==3){
		$("#valortitulo").html("Ingresar número de tel/cel")
	}
	
}


function volver() {
	$(".primer_tour").removeClass("d-none");
	$(".segundo_tour").addClass("d-none");
	$("#panel_resultado").attr("hidden",true);
	$(".datos_estudiante").attr("hidden",false);
	$(".datos_table").attr("hidden",false);
}


function detalles(val) {
	$(".primer_tour").addClass("d-none");
	$(".segundo_tour").removeClass("d-none");
    $("#panel_resultado").attr("hidden",false);
    $(".datos_table").attr("hidden",true);
    $.post("../controlador/onpanel.php?op=detalles",{val:val}, function (datos) {
       
        var r = JSON.parse(datos);
        $("#panel_resultado").html(r.conte);
		$("#panel_resultado").show();
		$("#panel_detalle").html(r.conte2);
		$("#panel_detalle").show();
    });
}


function editarnombre() {
	$(".editar-nombre").addClass("d-none");
	$("#nombre").attr('readonly', false);
	$(".guardar-nombre").removeClass("d-none");
	
}
function guardarnombre(){
	$(".guardar-nombre").addClass("d-none");
	$("#nombre").attr('readonly', true);
	$(".editar-nombre").removeClass("d-none");
	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditonombre",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}

function editarnombre_2() {

	$(".editar-nombre_2").addClass("d-none");
	$("#nombre_2").attr('readonly', false);
	$(".guardar-nombre_2").removeClass("d-none");

}

function guardoeditonombre_2(){

	$(".guardar-nombre_2").addClass("d-none");
	$("#nombre_2").attr('readonly', true)
	$(".editar-nombre_2").removeClass("d-none");

	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditonombre_2",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}

function editarapellidos() {

	$(".editar-apellidos").addClass("d-none");
	$("#apellidos").attr('readonly', false);
	$(".guardar-apellidos").removeClass("d-none");

}

function guardoeditoapellidos(){

	$(".guardar-apellidos").addClass("d-none");
	$("#apellidos").attr('readonly', true);
	$(".editar-apellidos").removeClass("d-none");

	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditoapellidos",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}

function editarapellidos_2() {

	$(".editar-apellidos_2").addClass("d-none");
	$("#apellidos_2").attr('readonly', false);
	$(".guardar-apellidos_2").removeClass("d-none");

}

function guardoeditoapellidos_2(){

	$(".guardar-apellidos_2").addClass("d-none");
	$("#apellidos_2").attr('readonly', true);
	$(".editar-apellidos_2").removeClass("d-none");
	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditoapellidos_2",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}
function editaridentificacion() {
	$(".editar-identificacion").addClass("d-none");
	$("#identificacion").attr('readonly', false);
	$(".guardar-identificacion").removeClass("d-none");

}

function guardoeditoidentificacion(){
	$(".guardar-identificacion").addClass("d-none");
	$("#identificacion").attr('readonly', true);
	$(".editar-identificacion").removeClass("d-none");

	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditoidentificacion",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			//console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
		
	});
}

function guardoeditoestado(){
	$(".guardar-estado").addClass("d-none");
	$("#estado").attr('readonly', true);
	$(".editar-estado").removeClass("d-none");
	
	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditoestado",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
		
	});
}

function guardoeditofoprorgama(){
	$(".guardar-programa").addClass("d-none");
	$("#fo_programa").attr('readonly', true);
	$(".editar-programa").removeClass("d-none");
	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditofoprorgama",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}

function editarjornadae() {

	$(".editar-jornadae").addClass("d-none");
	$("#jornada_e").attr('readonly', false);
	$(".guardar-jornadae").removeClass("d-none");

}

function guardoeditojornadae(){
	$(".guardar-jornadae").addClass("d-none");
	$("#jornada_e").attr('readonly', true);
	$(".editar-jornadae").removeClass("d-none");
	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditojornadae",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}

function editarfechanacimiento() {

	$(".editar-fechanacimiento").addClass("d-none");
	$("#fecha_nacimiento").attr('readonly', false);
	$(".guardar-fechanacimiento").removeClass("d-none");

}

function guardoeditofechanacimiento(){
	$(".guardar-fechanacimiento").addClass("d-none");
	$("#fecha_nacimiento").attr('readonly', true);
	$(".editar-fechanacimiento").removeClass("d-none");
	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditofechanacimiento",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}

function editarcelular() {

	$(".editar-celular").addClass("d-none");
	$("#celular").attr('readonly', false);
	$(".guardar-celular").removeClass("d-none");

}

function guardoeditocelular(){
	$(".guardar-celular").addClass("d-none");
	$("#celular").attr('readonly', true);
	$(".editar-celular").removeClass("d-none");
	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditocelular",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}

function editaremail() {

	$(".editar-email").addClass("d-none");
	$("#email").attr('readonly', false);
	$(".guardar-email").removeClass("d-none");

}


function guardoeditoemailpersonal(){
	$(".guardar-email").addClass("d-none");
	$("#email").attr('readonly', true);
	$(".editar-email").removeClass("d-none");
	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditoemailpersonal",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}

function editaremailciaf() {

	$(".editar-email_ciaf").addClass("d-none");
	$("#email_ciaf").attr('readonly', false);
	$(".guardar-email_ciaf").removeClass("d-none");

}

function guardoeditoemailciaf(){
	$(".guardar-email_ciaf").addClass("d-none");
	$("#email_ciaf").attr('readonly', true);
	$(".editar-email_ciaf").removeClass("d-none");
	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditoemailciaf",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}

function editarperiodocampana() {

	$(".editar-periodocampana").addClass("d-none");
	$("#periodo_campana").attr('readonly', false);
	$(".guardar-periodocampana").removeClass("d-none");

}

function guardoeditoperiodocampana(){
	$(".guardar-periodocampana").addClass("d-none");
	$("#periodo_campana").attr('readonly', true);
	$(".editar-periodocampana").removeClass("d-none");
	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditoperiodocampana",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}

function guardoeditoformulario(){
	$("#guardar-formulario").attr("readonly",true);

	$(".guardar-formulario").addClass("d-none");
	$("#formulario").attr('readonly', true);
	$(".editar-formulario").removeClass("d-none");
	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditoformulario",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}

function guardoeditoinscripcion(){
	$(".guardar-inscripcion").addClass("d-none");
	$("#inscripcion").attr('readonly', true);
	$(".editar-inscripcion").removeClass("d-none");
	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditoinscripcion",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}

function guardoeditoentrevista(){
	$(".guardar-entrevista").addClass("d-none");
	$("#entrevista").attr('readonly', true);
	$(".editar-entrevista").removeClass("d-none");
	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditoentrevista",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}

function guardoeditodocumentos(){
	$(".guardar-documentos").addClass("d-none");
	$("#documentos").attr('readonly', true);
	$(".editar-documentos").removeClass("d-none");
	var formData = new FormData($("#estudiante")[0]);
	$.ajax({
		"url": "../controlador/onpanel.php?op=guardoeditodocumentos",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);	          
		}
	});
}

