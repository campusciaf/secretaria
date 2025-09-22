$(document).ready(inicio);
var estado="Preinscrito";
function inicio() {

	$("#precarga").hide();
	$("#input_dato").show();
	$( "#dato" ).prop( "disabled", true );
    
    $.post("../controlador/oncentercontinuada.php?op=selectPrograma", function(r){
        $("#curso_nc").html(r);
        $('#curso_nc').selectpicker('refresh');
    });

    $.post("../controlador/oncentercontinuada.php?op=selectMedio", function(r){
            
            $("#medio_nc").html(r);
            $('#medio_nc').selectpicker('refresh');
    });

    $.post("../controlador/oncentercontinuada.php?op=selectConocio", function(r){
            $("#conocio_nc").html(r);
            $('#conocio_nc').selectpicker('refresh');
    });

    $.post("../controlador/oncentercontinuada.php?op=selectContacto", function(r){
            $("#contacto_nc").html(r);
            $("#contacto_nc").selectpicker('refresh');
    });

    $("#formularionuevocurso").on("submit",function(e)
	{
		guardaryeditarnuevocurso(e);	
	});

	$("#formularionuevoestudiante").on("submit",function(e1)
	{
		guardaryeditarnuevoestudiante(e1);	
	});

	$("#nuevacredencialcondatos").on("submit",function(e1)
	{
		guardarnuevacredencialcondatos(e1);	
	});







	
    $("#moverUsuario").on("submit",function(e4)
	{
		guardarMoverUsuario(e4);	
	});
	$("#formularioAgregarSeguimiento").on("submit",function(e1)
	{
		guardarSeguimiento(e1);	
	});
	
	$("#formularioTarea").on("submit",function(e2)
	{
		guardarTarea(e2);	
	});
	
	$("#cambioDocumento").on("submit",function(e3)
	{
		guardarCambioDocumento(e3);	
	});
	

	$("#form_soporte").on("submit",function(e2)
	{
		e2.preventDefault();
		guardarsoporte();	
	});

	$("#form_soporte_digitales1").on("submit",function(e2)
	{
		e2.preventDefault();
		guardarsoporte_digitales1();	
	});
	$("#form_soporte_digitales2").on("submit",function(e2)
	{
		e2.preventDefault();
		guardarsoporte_digitales2();	
	});
	$("#form_soporte_digitales3").on("submit",function(e2)
	{
		e2.preventDefault();
		guardarsoporte_digitales3();	
	});
	$("#form_soporte_digitales4").on("submit",function(e2)
	{
		e2.preventDefault();
		guardarsoporte_digitales4();	
	});
	$("#form_soporte_digitales5").on("submit",function(e2)
	{
		e2.preventDefault();
		guardarsoporte_digitales5();	
	});

	$("#form_soporte_compromiso").on("submit",function(e2)
	{
		e2.preventDefault();
		guardarsoporte_compromiso();	
	});

	$("#form_soporte_proteccion_datos").on("submit",function(e2)
	{
		e2.preventDefault();
		guardarsoporte_proteccion_datos();	
	});

	Webcam.set({
		width: 320,
		height: 240,
		image_format: 'jpeg',
		jpeg_quality: 90
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
				intro: 'Aquí es donde ocurre la magia y podrás editar algunos datos de nuestro ser creativo' 
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
				title: 'Proceso de admisiones',
				element: document.querySelector('#t2-CP'),
				intro: "Aquí podrás editar los datos personales de nuestro ser creativo"
			},
			{
				title: 'Tomar foto',
				element: document.querySelector('#t2-tf'),
				intro: "Tendrás la opción de agregar una foto de nuestro ser creativo a su registro con nosostros"
			},
			{
				title: 'Seguimiento',
				element: document.querySelector('#t2-seg'),
				intro: "Aquí podrás agregar un nuevo seguimiento y visualizar los anteriores"
			},
			{
				title: 'ver historial',
				element: document.querySelector('#t2-vh'),
				intro: "Da un vistazo a el historial general de nuestro ser creativo"
			},
			{
				title: 'Cambiar de estado',
				element: document.querySelector('#t2-cd'),
				intro: "Aquí podrás cambiar de estado a nuestro ser creativo en este caso lo podemos visualizar como matriculado"
			},
			{
				title: 'Ver ficha completa',
				element: document.querySelector('#t2-vfc'),
				intro: "Da un vistazo a toda la información general de nuestro ser creativo"
			},
			{
				title: 'Eliminar',
				element: document.querySelector('#t2-el'),
				intro: "podrás eliminar todos los registros de nuestro ser creatvo de ser necesario"
			},
			{
				title: 'Proceso',
				element: document.querySelector('#t2-pro'),
				intro: "Da un vistazo a todas las categorias disponibles en todo el proceso de nuestro ser creativo"
			},
			{
				title: 'Estado',
				element: document.querySelector('#t2-st'),
				intro: "Aquí encontrarás las diferentes funciones para cada categoria de el procesop de nuestro ser creativo"
			},
			

		]

	},


	).start();

	console.log("holaaa");

}

function muestra(valor) {// funcion para saber si es una cedula validada o es un nuevo usuario
	$( "#dato" ).prop( "disabled", false );
	$( "#btnconsulta" ).prop( "disabled", false );
	
	$("#input_dato").show();

	var tipo = $("#tipo").val(valor);
	if(valor==1){
		$("#valortitulo").html("Ingresar número de identificacíon");
        $("#dato").val("");
	}
	if(valor==2){
		$("#valortitulo").html("Número temporal");
        var min = 1000000000;
        var max = 9999999999;
        var x = Math.floor(Math.random()*(max-min+1)+min);
        $("#dato").val("1"+x)

	}

}

function consultacliente() {
	
    var dato = $("#dato").val();
    var tipo = $("#tipo").val();

    if (dato != "" && tipo != "") {
        $.post("../controlador/oncentercontinuada.php?op=consultacliente",{dato:dato,tipo:tipo}, function (datos) {
           
			var r = JSON.parse(datos);
            $("#datos_estudiante").html(r.conte2);// muestra los datos del estudiante
            $(".datos_table").html(r.conte);// muestr ala tabla con los programas

				var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
				var f=new Date();
				var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

				if(r.status=="tienecurso"){
					
					$("#modalNuevoEstudiante").modal("show");
					$("#continuada_identificacion").val(dato);
				}
				if(r.status=="noexiste"){
					$("#continuada_identificacion").val(dato);
					$("#modalNuevoEstudiante").modal("show");

				}
				else{
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
									volver();
								},
	
	
					});
				}
				
				
        });

    }
	else{
        alertify.error("Por favor completa los campos.");
    }
    
}

function AgregarCurso(valor){
    $("#modalNuevoCurso").modal("show");
    $("#identificacion_nc").val(valor);
}

function guardaryeditarnuevocurso(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formularionuevocurso")[0]);

	$.ajax({
		url: "../controlador/oncentercontinuada.php?op=guardaryeditarnuevocurso",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   

            $("#modalNuevoCurso").modal("hide");
			$("#precarga").hide();
            consultacliente();
	        alertify.success(datos);          
			// setTimeout('document.location.reload()',3000);
			
	    }

	});
	
}


function habilitarModuloEstudiante(valor)
{
	$.post("../controlador/oncentercontinuada.php?op=mostrardatosestudiante",{valor:valor}, function(data, status)
	{
		data = JSON.parse(data);	
		$("#usuario_nombre_mc").val(data.credencial_nombre);
		$("#usuario_nombre_2_mc").val(data.credencial_nombre_2);
		$("#usuario_apellido_mc").val(data.credencial_apellido);
		$("#usuario_apellido_2_mc").val(data.credencial_apellido_2);
		$("#usuario_identificacion_mc").val(data.credencial_identificacion);
		$("#usuario_login_mc").val(data.credencial_login);
		


		$("#modalHabilitarModuloEstudiante").modal("show");
	});
}

function guardaryeditarnuevoestudiante(e1)
{
	e1.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formularionuevoestudiante")[0]);

	$.ajax({
		url: "../controlador/oncentercontinuada.php?op=guardaryeditarnuevoestudiante",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
            $("#modalHabilitarModuloEstudiante").modal("hide");
			$("#precarga").hide();
            consultacliente();
	        alertify.success(datos);          	
	    }

	});
	
}

function habilitarModuloDocente(valor){
	$.post("../controlador/oncentercontinuada.php?op=mostrardatosdocente",{valor:valor}, function(data, status)
	{
		data = JSON.parse(data);	
		$("#usuario_nombre_mc").val(data.usuario_nombre);
		$("#usuario_nombre_2_mc").val(data.usuario_nombre_2);
		$("#usuario_apellido_mc").val(data.usuario_apellido);
		$("#usuario_apellido_2_mc").val(data.usuario_apellido_2);
		$("#usuario_identificacion_mc").val(data.usuario_identificacion);
		$("#usuario_login_mc").val(data.usuario_login);
		


		$("#modalHabilitarModuloEstudiante").modal("show");
	});
}

function habilitarModuloFuncionario(valor){
	$.post("../controlador/oncentercontinuada.php?op=mostrardatosfuncionario",{valor:valor}, function(data, status)
	{
		data = JSON.parse(data);		
		$("#usuario_nombre_mc").val(data.usuario_nombre);
		$("#usuario_nombre_2_mc").val(data.usuario_nombre_2);
		$("#usuario_apellido_mc").val(data.usuario_apellido);
		$("#usuario_apellido_2_mc").val(data.usuario_apellido_2);
		$("#usuario_identificacion_mc").val(data.usuario_identificacion);
		$("#usuario_login_mc").val(data.usuario_login);
		


		$("#modalHabilitarModuloEstudiante").modal("show");
	});
}


function guardarnuevacredencialcondatos(e1)
{
	e1.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#nuevacredencialcondatos")[0]);

	$.ajax({
		url: "../controlador/oncentercontinuada.php?op=guardarnuevacredencialcondatos",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
            $("#modalNuevoEstudiante").modal("hide");
			$("#precarga").hide();
            consultacliente();
	        alertify.success(datos);          	
	    }

	});
	
}













function detalles(val) {
	$(".primer_tour").addClass("d-none");
	$(".segundo_tour").removeClass("d-none");
    $("#panel_resultado").attr("hidden",false);
    $(".datos_table").attr("hidden",true);
    $.post("../controlador/oncentercontinuada.php?op=detalles",{val:val}, function (datos) {
       
        var r = JSON.parse(datos);
        $("#panel_resultado").html(r.conte);
		$("#panel_resultado").show();
		$("#panel_detalle").html(r.conte2);
		$("#panel_detalle").show();
    });
}

//Función para activar registros
function correo(id_estudiante){
	alertify.confirm('Enviar Mensaje', '¿Está Seguro de enviar las credenciales al usuario?', function(){ 
	
		$.post("../controlador/oncentercontinuada.php?op=correo", {id_estudiante : id_estudiante}, function(e){
			
			e = JSON.parse(e);// convertir el mensaje a json
			
        		if(e.resultado == 1){
				   alertify.success("Envio Correcto");
                   detalles(id_estudiante);
				   }
				else{
					alertify.error("Envio fallido");
				}
        	});	
	}
	, function(){ alertify.error('Cancelado')});

}

function validarDocumentos(id_estudiante){
	alertify.confirm('validar Documentos', '¿Está Seguro de validar los documentos?', function(){ 
	
		$.post("../controlador/oncentercontinuada.php?op=validarDocumentos", {id_estudiante : id_estudiante}, function(e){
			
			e = JSON.parse(e);// convertir el mensaje a json
			

        		if(e.resultado == 1){
				   alertify.success("Validación Correcta");
					detalles(id_estudiante);
				   }
				else{
					alertify.error("Error Validación");
				}
			
				if(e.estado==1){
				   	alertify.success("Cambio de estado Admitido");
					detalles(id_estudiante);
				   }
        	});	
	}
	, function(){ alertify.error('Cancelado')});

}


function selectModalidadCampana(){
//Cargamos los items de los selects
	$.post("../controlador/oncentercontinuada.php?op=selectModalidadCampana", function(r){
			$("#modalidad_campana").html(r);
			$('#modalidad_campana').selectpicker('refresh');
	});
}
function validarDocumento(id_estudiante,identificacion){
	//$("#precarga").show();
	$("#btnCambiar").prop("disabled",false);
	$("#myModalValidarDocumento").modal("show");
	$("#id_estudiante_documento").val(id_estudiante);
	$("#cambio_cedula").val(identificacion);
	$("#nuevo_documento").val("");
	$("#repetir_documento").val("");
	
	selectModalidadCampana();
}

//Función para activar registros
function validarFormularioInscripcion(id_estudiante){
	alertify.confirm('validar Formulario Inscripción', '¿Está Seguro de validar el formulario de inscripción del estudiante?', function(){ 
	
		$.post("../controlador/oncentercontinuada.php?op=validarFormularioInscripcion", {id_estudiante : id_estudiante}, function(e){
		
			e = JSON.parse(e);// convertir el mensaje a json
			
	
        		if(e.resultado == 1){
				   alertify.success("Validación Correcta");
					detalles(id_estudiante);
				   }
				else{
					alertify.error("Error Validación");
				}
			
				if(e.estado==1){
				   	alertify.success("Cambio de estado Inscrito");
					detalles(id_estudiante);
				   }
        	});	
	}
	, function(){ alertify.error('Cancelado')});

}

//Función para activar registros
function validarReciboInscripcion(id_estudiante){
	alertify.confirm('validar Formulario Inscripción', '¿Está Seguro de validar el formulario de inscripción del estudiante?', function(){ 
	
		$.post("../controlador/oncentercontinuada.php?op=validarInscripcion", {id_estudiante : id_estudiante}, function(e){
		
			e = JSON.parse(e);// convertir el mensaje a json
			
	
        		if(e.resultado == 1){
				   alertify.success("Validación Correcta");
					detalles(id_estudiante);
				   }
				else{
					alertify.error("Error Validación");
				}
			
				if(e.estado==1){
				   	alertify.success("Cambio de estado Inscrito");
					detalles(id_estudiante);
				   }
        	});	
	}
	, function(){ alertify.error('Cancelado')});

}

function verEntrevista(id_estudiante){
	$.post("../controlador/oncentercontinuada.php?op=verEntrevista", {id_estudiante : id_estudiante}, function(data){		
			
		data = JSON.parse(data);
		$("#sostiene").val(data.sostiene);
		$("#labora").val(data.labora);
		$("#cargo").val(data.cargo);
		$("#donde_labora").val(data.donde_labora);
		$("#motiva").val(data.motiva);
		$("#conoce_plan").val(data.conoce_plan);
		$("#descarto").val(data.descarto);
        $("#curso_ad").val(data.curso_ad);
        $("#talento").val(data.talento);
        $("#referir").val(data.referir);
        $("#dejar").val(data.dejar);
		$("#razon").val(data.razon);
		$("#myModalEntrevista").modal("show");
	});
	

}

//Función para activar registros
function validarEntrevista(id_estudiante){
	alertify.confirm('validar Entrevista', '¿Está Seguro de validar la entrevista del estudiante?', function(){ 
	
		$.post("../controlador/oncentercontinuada.php?op=validarEntrevista", {id_estudiante : id_estudiante}, function(e){
		
			e = JSON.parse(e);// convertir el mensaje a json
			
	
        		if(e.resultado == 1){
				   alertify.success("Validación Correcta");
				   detalles(id_estudiante);
				   }
				else{
					alertify.error("Error Validación");
				}
        	});	
	}
                , function(){ alertify.error('Cancelado')});

}

function verSoportes(id_estudiante){

	$.post("../controlador/oncentercontinuada.php?op=ver_soportes", {id_estudiante : id_estudiante}, function(e){
		$("#myModaVerSoportesDigitales").modal("show");
		
		e = JSON.parse(e);// convertir el mensaje a json
	
		$(".soporte_cedula").html("");
		$(".soporte_cedula").append(e.cedula);// agrega contenido al div de cédula	
		
		$(".soporte_diploma").html("");
		$(".soporte_diploma").append(e.diploma);// agrega contenido al div de diploma
		
		$(".soporte_acta").html("");
		$(".soporte_acta").append(e.acta);// agrega contenido al div de acta
		
		$(".soporte_salud").html("");
		$(".soporte_salud").append(e.salud);// agrega contenido al div de salud
		
		$(".soporte_prueba").html("");
		$(".soporte_prueba").append(e.prueba);// agrega contenido al div de salud

		$(".soporte_compromiso").html("");
		$(".soporte_compromiso").append(e.compromiso);// agrega contenido al div de compromiso

		$(".soporte_proteccion_datos").html("");
		$(".soporte_proteccion_datos").append(e.aceptardatos);// agrega contenido al div de compromiso
	});
}

function validar(id_estudiante,soporte){

	$.post("../controlador/oncentercontinuada.php?op=validar", {id_estudiante : id_estudiante, soporte:soporte}, function(e){
	
		e = JSON.parse(e);// convertir el mensaje a json
			if(e==1){
				alertify.success("Soporte validado");				
				verSoportes(id_estudiante);
				detalles(id_estudiante);
				
			}else{
				alertify.error("Soporte no se pudo validar");
			}		
	});
}



// inicio agregar tareas, seguimiento y historial

	function agregar(id_estudiante){
		$("#btnGuardarSeguimiento").prop("disabled",false);
		$("#precarga").show();
		$("#id_estudiante_agregar").val(id_estudiante);
		$("#id_estudiante_tarea").val(id_estudiante);
		
		$.post("../controlador/oncentercontinuada.php?op=agregar",{id_estudiante:id_estudiante},function(data, status){
			
			data = JSON.parse(data);// convertir el mensaje a json
			$("#myModalAgregar").modal("show");
			$("#agregarContenido").html("");// limpiar el div resultado
			$("#agregarContenido").append(data["0"]["0"]);// agregar el resultao al div resultado
			$("#precarga").hide();

		});
	}

	function verHistorial(id_estudiante){
		$("#precarga").show();
		$.post("../controlador/oncentercontinuada.php?op=verHistorial",{id_estudiante:id_estudiante},function(data, status){
		
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
						url: '../controlador/oncentercontinuada.php?op=verHistorialTabla&id_estudiante='+id_estudiante,
						type : "get",
						dataType : "json",						
						error: function(e){
						
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
		// ****************************** //
	
	
		
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
						url: '../controlador/oncentercontinuada.php?op=verHistorialTablaTareas&id_estudiante='+id_estudiante,
						type : "get",
						dataType : "json",						
						error: function(e){
								
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
		// ****************************** //
	
	
		
}

	function guardarSeguimiento(e)
	{
		e.preventDefault(); //No se activará la acción predeterminada del evento
		$("#btnGuardarSeguimiento").prop("disabled",true);
		var formData = new FormData($("#formularioAgregarSeguimiento")[0]);

		$.ajax({
			url: "../controlador/oncentercontinuada.php?op=agregarSeguimiento",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,

			success: function(datos)
			{ 
				
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
	function guardarTarea(e2)
	{
		e2.preventDefault(); //No se activará la acción predeterminada del evento
		// $("#btnGuardarTarea").prop("disabled",true);
		var formData = new FormData($("#formularioTarea")[0]);

		$.ajax({
			url: "../controlador/oncentercontinuada.php?op=agregarTarea",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,

			success: function(datos)
			{ 
				console.log(datos);
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


function selectEstado(){
	//Cargamos los items de los selects
	$.post("../controlador/oncentercontinuada.php?op=selectEstado", function(r){
		$("#estado").html(r);
		$('#estado').selectpicker('refresh');
	});
}

function mover(id_estudiante){
	selectEstado();
	$("#myModalMover").modal("show");
	$("#id_estudiante_mover").val(id_estudiante);

}

function guardarMoverUsuario(e4)
{
	e4.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnMover").prop("disabled",true);
	var formData = new FormData($("#moverUsuario")[0]);

	$.ajax({
		url: "../controlador/oncentercontinuada.php?op=moverUsuario",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    { 
			
			alertify.set('notifier','position', 'top-center');
	        alertify.success(datos);	 
			$("#myModalMover").modal("hide");
			$("#btnMover").prop("disabled",false);
			var id_estudiante =$("#id_estudiante_mover").val();
			detalles(id_estudiante);
	    }

	});
	
}

function eliminar(id_estudiante)
{
	alertify.confirm('Eliminar Caso', '¿Está Seguro de eliminar el Caso?', function(){ 
	
		$.post("../controlador/oncenterpreinscrito.php?op=eliminar", {id_estudiante : id_estudiante}, function(e){
			
        		if(e == 1){
				   alertify.success("Caso Eliminado");
					   	consultacliente();
					   	$(".datos_estudiante").html('');
						$(".datos_table").html('');
					   	$("#panel_resultado").html('');
				   }
				else{
					alertify.error("Caso no se puede eliminar");
				}
        	});
	
	}
                , function(){ alertify.error('Cancelado')});


}

function abrirmodalwebcam(cc) {
	$("#modalwebacam").modal("show");
	$("#cc").val(cc);
	Webcam.reset();
	Webcam.attach('#my_camera');
}
function tomarfoto() {
	Webcam.snap( function(data_uri) {
		// display results in page
		$(".img").html('<h2>Foto</h2><img src="'+data_uri+'"/>');
		$("#url").val(data_uri);
	} );
}
function restablecer() {
	$(".img").html('');
}
function guardar() {
	var cc = $("#cc").val();
	var url = $("#url").val();
	$.post("../controlador/oncentercontinuada.php?op=cargar_imagen",{cc:cc,url:url},function(data){
		
		var r = JSON.parse(data);
		if (r.status) {
			alertify.success("Imagen subida con exito.");
			var id = $("#estudiante_id").text();
			detalles(id);
		} else {
			alertify.error("Error al subir la imagen.");
		}
	});
}

function verficha(id_estudiante) {
	
	$.post("../controlador/oncentercontinuada.php?op=mostrar_ficha",{id:id_estudiante},function(data){
	
		var r = JSON.parse(data);
		$("#myModalFicha").modal("show");
		$("#resultado_ficha").html(r.conte);
	});
	
}
function imprimir() {
	var ficha = document.getElementById('hoja');
	var ventimp=window.open(' ','popimpr');
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
}

function volver() {
	$(".primer_tour").removeClass("d-none");
	$(".segundo_tour").addClass("d-none");
    $("#panel_resultado").attr("hidden",true);
    $(".datos_estudiante").attr("hidden",false);
    $(".datos_table").attr("hidden",false);
}

function soporte_inscripcion(id) {
	$(".id_es").val(id);
	$("#soporte_inscripcion").modal("show");
}

function eliminar_soporte_inscripcion(id) {
	alertify.confirm('Eliminar Soporte', '¿Está Seguro de eliminar el soporte?', function(){ 
	
		$.post("../controlador/oncentercontinuada.php?op=eliminar_soporte_inscripcion", {id : id}, function(e){
			
			var r = JSON.parse(e);
			if(r.status == 'ok'){
				alertify.success("Soporte eliminado con exito.");
				detalles(id);
			}
			else{
				alertify.error("Error al eliminar el soporte.");
			}
		});
	
	}
	, function(){ alertify.error('Cancelado')});
}

function eliminar_soporte_cc(id) {
	alertify.confirm('Eliminar Soporte', '¿Está Seguro de eliminar el soporte?', function(){ 
	
		$.post("../controlador/oncentercontinuada.php?op=eliminar_soporte_cc", {id : id}, function(e){
			
			var r = JSON.parse(e);
			if(r.status == 'ok'){
				alertify.success("Soporte eliminado con exito.");
				verSoportes(id);
			}
			else{
				alertify.error("Error al eliminar el soporte.");
			}
		});
	
	}
	, function(){ alertify.error('Cancelado')});
}

function eliminar_soporte_diploma(id) {
	alertify.confirm('Eliminar Soporte', '¿Está Seguro de eliminar el soporte?', function(){ 
	
		$.post("../controlador/oncentercontinuada.php?op=eliminar_soporte_diploma", {id : id}, function(e){
		
			var r = JSON.parse(e);
			if(r.status == 'ok'){
				alertify.success("Soporte eliminado con exito.");
				verSoportes(id);
			}
			else{
				alertify.error("Error al eliminar el soporte.");
			}
		});
	
	}
	, function(){ alertify.error('Cancelado')});
}

function eliminar_soporte_acta(id) {
	alertify.confirm('Eliminar Soporte', '¿Está Seguro de eliminar el soporte?', function(){ 
	
		$.post("../controlador/oncentercontinuada.php?op=eliminar_soporte_acta", {id : id}, function(e){
			
			var r = JSON.parse(e);
			if(r.status == 'ok'){
				alertify.success("Soporte eliminado con exito.");
				verSoportes(id);
			}
			else{
				alertify.error("Error al eliminar el soporte.");
			}
		});
	
	}
	, function(){ alertify.error('Cancelado')});
}

function eliminar_soporte_salud(id) {
	alertify.confirm('Eliminar Soporte', '¿Está Seguro de eliminar el soporte?', function(){ 
	
		$.post("../controlador/oncentercontinuada.php?op=eliminar_soporte_salud", {id : id}, function(e){
		
			var r = JSON.parse(e);
			if(r.status == 'ok'){
				alertify.success("Soporte eliminado con exito.");
				verSoportes(id);
			}
			else{
				alertify.error("Error al eliminar el soporte.");
			}
		});
	
	}
	, function(){ alertify.error('Cancelado')});
}

function eliminar_soporte_prueba(id) {
	alertify.confirm('Eliminar Soporte', '¿Está Seguro de eliminar el soporte?', function(){ 
	
		$.post("../controlador/oncentercontinuada.php?op=eliminar_soporte_prueba", {id : id}, function(e){
		
			var r = JSON.parse(e);
			if(r.status == 'ok'){
				alertify.success("Soporte eliminado con exito.");
				verSoportes(id);
			}
			else{
				alertify.error("Error al eliminar el soporte.");
			}
		});
	
	}
	, function(){ alertify.error('Cancelado')});
}

function eliminar_soporte_compromiso(id) {
	alertify.confirm('Eliminar Compromiso', '¿Está Seguro de eliminar el soporte?', function(){ 
	
		$.post("../controlador/oncentercontinuada.php?op=eliminar_soporte_compromiso", {id : id}, function(e){
		
			var r = JSON.parse(e);
			if(r.status == 'ok'){
				alertify.success("Soporte eliminado con exito.");
				verSoportes(id);
			}
			else{
				alertify.error("Error al eliminar el soporte.");
			}
		});
	
	}
	, function(){ alertify.error('Cancelado')});
}

function eliminar_soporte_proteccion_datos(id) {
	alertify.confirm('Eliminar soporte protección de datos', '¿Está Seguro de eliminar el soporte?', function(){ 
	
		$.post("../controlador/oncentercontinuada.php?op=eliminar_soporte_proteccion_datos", {id : id}, function(e){
		
			var r = JSON.parse(e);
			if(r.status == 'ok'){
				alertify.success("Soporte eliminado con exito.");
				verSoportes(id);
			}
			else{
				alertify.error("Error al eliminar el soporte.");
			}
		});
	
	}
	, function(){ alertify.error('Cancelado')});
}

function guardarsoporte(){
	$("#btnGuardarsoporte").prop("disabled",true);
	var formData = new FormData($("#form_soporte")[0]);

	$.ajax({
		url: "../controlador/oncentercontinuada.php?op=soporte_inscripcion",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos)
		{ 
			
			var r = JSON.parse(datos);
			if (r.status == "ok") {
				alertify.success(r.msj);
				$("#btnGuardarsoporte").prop("disabled",false);
				$("#soporte_inscripcion").modal("hide");
				detalles(r.id_estudiante);
			} else {
				alertify.error(r.msj);
				$("#btnGuardarsoporte").prop("disabled",false);
			}
		}

	});
}

function guardarsoporte_digitales1(){
	$("#btnGuardarsoporte_digital").prop("disabled",true);
	var formData = new FormData($("#form_soporte_digitales1")[0]);

	$.ajax({
		url: "../controlador/oncentercontinuada.php?op=soporte_digitales1",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos)
		{ 
			
			var r = JSON.parse(datos);
			if (r.status == "ok") {
				alertify.success(r.msj);
				$("#form_soporte_digitales1")[0].reset();
				$("#btnGuardarsoporte_digital").prop("disabled",false);
				$("#myModaVerSoportesDigitales").modal("hide");
			} else {
				alertify.error(r.msj);
				$("#btnGuardarsoporte_digital").prop("disabled",false);
			}
		}

	});
}
function guardarsoporte_digitales2(){
	$("#btnGuardarsoporte_digital").prop("disabled",true);
	var formData = new FormData($("#form_soporte_digitales2")[0]);

	$.ajax({
		url: "../controlador/oncentercontinuada.php?op=soporte_digitales2",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos){
			
			var r = JSON.parse(datos);
			if (r.status == "ok") {
				alertify.success(r.msj);
				$("#form_soporte_digitales2")[0].reset();
				$("#btnGuardarsoporte_digital").prop("disabled",false);
				$("#myModaVerSoportesDigitales").modal("hide");
			} else {
				alertify.error(r.msj);
				$("#btnGuardarsoporte_digital").prop("disabled",false);
			}
		}

	});
}

function guardarsoporte_digitales3(){
	$("#btnGuardarsoporte_digital").prop("disabled",true);
	var formData = new FormData($("#form_soporte_digitales3")[0]);

	$.ajax({
		url: "../controlador/oncentercontinuada.php?op=soporte_digitales3",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos)
		{ 
			
			var r = JSON.parse(datos);
			if (r.status == "ok") {
				alertify.success(r.msj);
				$("#form_soporte_digitales3")[0].reset();
				$("#btnGuardarsoporte_digital").prop("disabled",false);
				$("#myModaVerSoportesDigitales").modal("hide");
			} else {
				alertify.error(r.msj);
				$("#btnGuardarsoporte_digital").prop("disabled",false);
			}
		}

	});
}

function guardarsoporte_digitales4(){
	$("#btnGuardarsoporte_digital").prop("disabled",true);
	var formData = new FormData($("#form_soporte_digitales4")[0]);

	$.ajax({
		url: "../controlador/oncentercontinuada.php?op=soporte_digitales4",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos)
		{ 
			
			var r = JSON.parse(datos);
			if (r.status == "ok") {
				alertify.success(r.msj);
				$("#form_soporte_digitales4")[0].reset();
				$("#btnGuardarsoporte_digital").prop("disabled",false);
				$("#myModaVerSoportesDigitales").modal("hide");
			} else {
				alertify.error(r.msj);
				$("#btnGuardarsoporte_digital").prop("disabled",false);
			}
		}

	});
}
function guardarsoporte_digitales5(){
	$("#btnGuardarsoporte_digital").prop("disabled",true);
	var formData = new FormData($("#form_soporte_digitales5")[0]);

	$.ajax({
		url: "../controlador/oncentercontinuada.php?op=soporte_digitales5",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos)
		{ 
			
			var r = JSON.parse(datos);
			if (r.status == "ok") {
				alertify.success(r.msj);
				$("#form_soporte_digitales5")[0].reset();
				$("#btnGuardarsoporte_digital").prop("disabled",false);
				$("#myModaVerSoportesDigitales").modal("hide");
			} else {
				alertify.error(r.msj);
				$("#btnGuardarsoporte_digital").prop("disabled",false);
			}
		}

	});
}


function guardarCambioDocumento(e3)
{	
	e3.preventDefault(); //No se activará la acción predeterminada del evento
		
		var formData = new FormData($("#cambioDocumento")[0]);
	
		var nuevo_documento=$("#nuevo_documento").val();
		var repetir_documento=$("#repetir_documento").val();
		var fila=$("#fila").val();
	
	if(nuevo_documento==repetir_documento){
		
		
		$.ajax({
			url: "../controlador/oncentercontinuada.php?op=verificarDocumento&nuevodocumento="+nuevo_documento,
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,

			success: function(datos)
			{ 

				datos = JSON.parse(datos);// convertir el mensaje a json
			
				if(datos.estado==0){// si el documento no existe
					alertify.set('notifier','position', 'top-center');
				    alertify.success("cambio de documento realizado");
					$("#btnCambiar").prop("disabled",true);
					limpiarSeguimiento(); 
					$("#myModalValidarDocumento").modal("hide");
					$("#panel_resultado").hide();
					
				 }else{// si el documento ya existe
				   	alertify.set('notifier','position', 'top-center');
				 	alertify.success("Documento ya existe"+datos.coincidencia + " Igual se registra");
					$("#btnCambiar").prop("disabled",true);
					limpiarSeguimiento(); 
					$("#myModalValidarDocumento").modal("hide");
					
				 }

			}

		});
	   }else{
			alertify.set('notifier','position', 'top-center');
			alertify.error("Documentos no coinciden");
	   }
	
}


function guardarsoporte_compromiso(){
	$("#btnGuardarsoporte_digital").prop("disabled",true);
	var formData = new FormData($("#form_soporte_compromiso")[0]);

	$.ajax({
		url: "../controlador/oncentercontinuada.php?op=soporte_compromiso",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos)
		{ 
			
			var r = JSON.parse(datos);
			if (r.status == "ok") {
				alertify.success(r.msj);
				$("#form_soporte_compromiso")[0].reset();
				$("#btnGuardarsoporte_digital").prop("disabled",false);
				$("#myModaVerSoportesDigitales").modal("hide");
			} else {
				alertify.error(r.msj);
				$("#btnGuardarsoporte_digital").prop("disabled",false);
			}
		}

	});

}


function guardarsoporte_proteccion_datos(){
	$("#btnGuardarsoporte_digital").prop("disabled",true);
	var formData = new FormData($("#form_soporte_proteccion_datos")[0]);

	$.ajax({
		url: "../controlador/oncentercontinuada.php?op=soporte_proteccion_datos",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos)
		{ 
			
			var r = JSON.parse(datos);
			if (r.status == "ok") {
				alertify.success(r.msj);
				$("#form_soporte_proteccion_datos")[0].reset();
				$("#btnGuardarsoporte_digital").prop("disabled",false);
				$("#myModaVerSoportesDigitales").modal("hide");
			} else {
				alertify.error(r.msj);
				$("#btnGuardarsoporte_digital").prop("disabled",false);
			}
		}

	});

}
