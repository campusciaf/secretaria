function init(){

	$("#listadoregistros").hide();

	
	$.post("../controlador/oncenterconsultas.php?op=selectCampana", function(r){
	            $("#periodo_campana").html(r);
	            $("#periodo_campana").selectpicker('refresh');
		
	});

	$.post("../controlador/oncenterconsultas.php?op=periodo", function(data){
		data = JSON.parse(data);
		$("#precarga").show();
		buscar(data.periodo);

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
				title: 'Consultas',
				intro: "Bienvenido a nuestro modulo de consultas donde podrás visualizar todos los resultados de las diferentes campañas que se han llevado a cabo"
			},
			{
				title: 'Total clientes',
				element: document.querySelector('#t-tog'),
				intro: "Da un vistazo a la totalidad de nuestros clientes con cifras comparadas de campañas anteriores "
			},
			{
				title: 'Total cumplidas',
				element: document.querySelector('#t-tc'),
				intro: "Aquí podrás encontrar la cantidad de metas cumplidas"
			},
			{
				title: 'Total pendientes',
				element: document.querySelector('#t-tp'),
				intro: "Da un vistazo a la cantidad de las posibles metas pendientes "
			},
			{
				title: 'Total no cumplidas',
				element: document.querySelector('#t-tn'),
				intro: "Aquí podrás encontrar la cantidad de metas que no no han cumplido a lo largo de la campña "
			},
			{
				title: 'Seleccionar campaña',
				element: document.querySelector('#t-sn'),
				intro: "En un click podrás visualizar todos nuestros periodos de campaña disponibles "
			},
			{
				title: 'Caso',
				element: document.querySelector('#t-c'),
				intro: "Aquí encontrarás el número de caso único que se le asigno a cada uno de nuestros seres creativos"
			},
			{
				title: 'Identificación',
				element: document.querySelector('#t-id'),
				intro: "Aquí podrás encontrar la identificación de nuestro ser creativo"
			},
			{
				title: 'Programa',
				element: document.querySelector('#t-p'),
				intro: "Da un vistazo a el programa que ha elegido nuestro ser creativo para cumplir su sueño de ser un profesional"
			},
			{
				title: 'Jornada',
				element: document.querySelector('#t-j'),
				intro: "Encontrarás la jornada en la que nuestro ser original decidió recibir las experiencias creativas en nuestra aula de clases "
			},
			{
				title: 'Nombre completo',
				element: document.querySelector('#t-n'),
				intro: "Da un vistazo a el nombre de nuestro ser creativo"
			},
			{
				title: 'Fecha nacimiento',
				element: document.querySelector('#t-fn'),
				intro: "Aquí encontrarás la fecha de nacimiento de nuestro ser creativo"
			},
			{
				title: 'Celular',
				element: document.querySelector('#t-cu'),
				intro: "Da un vistazo a el número telefónico de nuestro ser original "
			},
			{
				title: 'Email',
				element: document.querySelector('#t-em'),
				intro: "Aquí encontrarás su correo electrónico personal"
			},
			{
				title: 'Periodo ingreso',
				element: document.querySelector('#t-pe'),
				intro: "visualiza el periodo en el cual cada person se convirtió en un ser creativo parte de nuestra institución"
			},
			{
				title: 'Fecha ingreso',
				element: document.querySelector('#t-fi'),
				intro: "Encontrarás la fecha exacta de ingreso de nuestro ser creativo"
			},
			{
				title: 'medio',
				element: document.querySelector('#t-me'),
				intro: "Aquí encontrarás como fue que nuestro ser creativo realizó todo su proceso para convertirse en parte fundamental de nuestra institución"
			},
			{
				title: 'Conocido',
				element: document.querySelector('#t-co'),
				intro: "Da un vistazo a como nos conoció nuestro ser creatvio "
			},
			{
				title: 'Contácto',
				element: document.querySelector('#t-con'),
				intro: "encontrarás como nos contactó para elegirnos como su institución de educación superior "
			},
			{
				title: 'Modalidad',
				element: document.querySelector('#t-m'),
				intro: "Aquí encontrás la modalidad por la cual nuestro ser creativo realizó su proceso de matrícula "
			},
			{
				title: 'Estado',
				element: document.querySelector('#t-e'),
				intro: "Aquí encontraremos el estado si ya esta matrículado o de lo contrario canceló su proceso"
			},
			{
				title: 'Seguimiento',
				element: document.querySelector('#t-se'),
				intro: "Da un vistazo a el seguimiento que se le ha realizado a cada uno de los pasos de segumiente para cada paso"
			},
			{
				title: 'Mailing',
				element: document.querySelector('#t-ma'),
				intro: "Conoce el número de correos enviados por nuestro equipo a las personas interesadas en nuestro proceso de matrícula"
			},
			{
				title: 'Periodo campaña',
				element: document.querySelector('#t-pc'),
				intro: "Aquí podrás encontrar el periodo en el que sea realizado el proceso de convertirse en un ser creativo de nuestra institución"
			},
			{
				title: 'Formulario',
				element: document.querySelector('#t-f'),
				intro: "Aquí podrás encontrar el número de formularios que se le han realizado a cada persona para su proceso de matrícula"
			},
			{
				title: 'Inscripción',
				element: document.querySelector('#t-ins'),
				intro: "Da un vistazo a la cantidad de inscripciones que se han realizado en cada uno de los procesos"
			},
			{
				title: 'Entrevista',
				element: document.querySelector('#t-en'),
				intro: "Da un vistazo a la cantidad de entrevistas que se han realizado en cada uno de los procesos"
			},
			{
				title: 'Docuemntos',
				element: document.querySelector('#t-dc'),
				intro: "Aquí encontrarás el número de documentos adjuntados por las personas interesadas en este proceso "
			},
			{
				title: 'Matrícula',
				element: document.querySelector('#t-mt'),
				intro: "Aquí encontrarás si la persona interesada ya realizo su proceso de matricula o aún no la ha realizado"
			},
			{
				title: 'Programa',
				element: document.querySelector('#t-po'),
				intro: "Da un vistazo si ya se realizó la inscripción al programa que ha elegido la persona interesada a en formar parte de este parche creativo e innovador"
			},
			

		]
			
	},
	console.log()
	
	).start();

}
function buscar(periodo_campana){
	$("#precarga").show();
	$("#dato_periodo").html("Campaña " + periodo_campana);

	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	tabla=$('#tbllistado').dataTable(
	{
		
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor

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
						messageTop: '<div style="width:50%;float:left">Asesor <br><b>Fecha de Impresión</b>: periodo_</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
						title: 'Reporte consultas',
						titleAttr: 'Print'
					},
				],
		"ajax":
			{
				url: '../controlador/oncenterconsultas.php?op=listar&periodo_campana='+periodo_campana,
				type : "get",
				dataType : "json",						
				error: function(e){
					
				}

			},
		

			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			"order": [[ 0, "asc" ]],//Ordenar (columna,orden)
			'initComplete': function (settings, json) {
				$("#listadoregistros").show();
				$("#precarga").hide();
				
			},

		
      });
}

function buscarfiltrar(e)
{
	
	e.preventDefault(); //No se activará la acción predeterminada del evento

	var formData = new FormData($("#formulario")[0]);

		var periodo_campana=$("#periodo_campana").val();
		
	


	
	
//	$.post('../controlador/oncenterconsultas.php?op=listar&asesor='+asesor+'&fecha_desde='+fecha_desde+'&fecha_hasta='+fecha_hasta, function(r){
//	            console.log(r);
//		
//	});		
}


	
	



init();