function init(){
	
	$("#precarga").hide();
	$.post("../controlador/oncenternuevocliente.php?op=selectTipoDocumento", function(r){
			$("#tipo_documento").html(r);
			$('#tipo_documento').selectpicker('refresh');

	});
	
	$.post("../controlador/oncenternuevocliente.php?op=selectPrograma", function(r){
			$("#fo_programa").html(r);
			$('#fo_programa').selectpicker('refresh');

	});
	
	$.post("../controlador/oncenternuevocliente.php?op=selectJornada", function(r){
			$("#jornada_e").html(r);
			$('#jornada_e').selectpicker('refresh');

	});
	
	$.post("../controlador/oncenternuevocliente.php?op=selectMedio", function(r){
		
			$("#medio").html(r);
			$('#medio').selectpicker('refresh');

	});
	
	$.post("../controlador/oncenternuevocliente.php?op=selectConocio", function(r){
		
			$("#conocio").html(r);
			$('#conocio').selectpicker('refresh');

	});
	
	$.post("../controlador/oncenternuevocliente.php?op=selectContacto", function(r){
			$("#contacto").html(r);
			$("#contacto").selectpicker('refresh');

	});


	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
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
				title: 'Nuevo cliente',
				intro: "Bienvenido a nuestro módulo nuevos clientes donde podrás agregar a personas interesadas en ser los proximos seres creativos"
			},
			
			{
				title: 'Datos de plataforma',
				element: document.querySelector('#t-dp'),
				intro: " Aquí podrás selccionar toda la información requerida por nuestra plataforma "
			},
			{
				title: 'Datos personales',
				element: document.querySelector('#t-dpe'),
				intro: "Ingresa aquí toda la información personal de nuestro nuevo cliente"
			},
			{
				title: 'Referencias personales',
				element: document.querySelector('#t-rp'),
				intro: "Aquí podrás diligenciar todas las refrencias personales de nuestro nuevo cliente"
			},
			{
				title: 'Datos campaña',
				element: document.querySelector('#t-ca'),
				intro: "Ingresa todos los datos de campaña requeridos para finalizar este proceso"
			},
			{
				title: 'Registrar',
				element: document.querySelector('#t-rr'),
				intro: "Finalmente en un click tendremos registrados a tdoso nuestros nuevos clientes para una campaña correspondiente "
			},



			
			
		]
			
	},
	console.log()
	
	).start();

}


function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controlador/oncenternuevocliente.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
			$("#precarga").show();
	        alertify.success(datos);          
			setTimeout('document.location.reload()',3000);
			
	    }

	});
	
}


	

init();