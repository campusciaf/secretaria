function init(){
	listarDatos();
	$("#listadoregistros").hide();

	
	$.post("../controlador/oncenterreferidos.php?op=selectCampana", function(r){
		$("#periodo_campana").html(r);
		$("#periodo_campana").selectpicker('refresh');
		
	});

	$.post("../controlador/oncenterreferidos.php?op=periodo", function(data){
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
				title: 'Referidos',
				intro: "Bienvenido a nuestro panel de referidos, donde encontrarás aquellas personas que se interesaron en nosotros por alguna recomendación"
			},
			{
				title: 'Comparativo',
				element: document.querySelector('#t-data'),
				intro: "En este campo podrás encontrar nuestros referidos a fecha actual y en nuestro tercer renglón encontrarás la comparativa de la campaña a fecha actual"
			},
			{
				title: 'Interesados',
				element: document.querySelector('#t-data2'),
				intro: "Aquí podrás encontrar el número de personas interesadas en formar parte de este parche creativo e innovador"
			},
			{
				title: 'Seleccionados',
				element: document.querySelector('#t-data3'),
				intro: "Este campo nos indica el número de personas que están en estado seleccionado"
			},
			{
				title: 'Matriculados',
				element: document.querySelector('#t-data4'),
				intro: "Este campo nos indica el número de personas referidas que tomaron la desición de formar parte de esta familia creativa"
			},
			{
				title: 'Nombre tabla',
				element: document.querySelector('#t-titulotabla'),
				intro: "Aquí podrás visualizar el periodo de campaña correspondiente y sus resultados "
			},
			{
				title: 'Seleccionar',
				element: document.querySelector('#t-buscar'),
				intro: "Selecciona el periodo académico a consultar "
			},
			{
				title: 'Nombre',
				element: document.querySelector('#t-nombre'),
				intro: "Aquí podrás encontrar a el nombre de la persona de nuestra comunidad que trae a la persona interesada en realizar el proceso de admisión "
			},
			{
				title: 'Correo',
				element: document.querySelector('#t-correo'),
				intro: "Aquí podrás encontrar a el correo electrónico de la persona de nuestra comunidad que trae a la persona interesada en realizar el proceso de admisión"
			},
			{
				title: 'Celular',
				element: document.querySelector('#t-celular'),
				intro: "Aquí podrás encontrar a el número de celular de la persona de nuestra comunidad que trae a la persona interesada en realizar el proceso de admisión"
			},
			{
				title: 'Fecha registro',
				element: document.querySelector('#t-fecha'),
				intro: "Visualiza la fecha en la que se registró a la persona que fue referida"
			},
			{
				title: 'Nombre referido',
				element: document.querySelector('#t-refiere'),
				intro: "En este campo podrás encontrar el nombre de la persona que esta interesada en realizar el proceso de admisiones y ser parte de nuestra familia"
			},
			{
				title: 'Caso',
				element: document.querySelector('#t-caso'),
				intro: "Aquí podrás encontrar el número único asociado a la persona interesada en nuestro proceso de admisión"
			},
			
			{
				title: 'Estado',
				element: document.querySelector('#t-estado'),
				intro: "En este campo encontrarás el estado de la persona referida interesada en realizar nuestro proceso de admisiones"
			}

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
				url: '../controlador/oncenterreferidos.php?op=listar&periodo_campana='+periodo_campana,
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

function listarDatos(){
	$.post("../controlador/oncenterreferidos.php?op=listarDatos", {},function(data, status)
	{		
		data = JSON.parse(data);
		$("#data1").html(data.data1);
	});
}



	
	



init();