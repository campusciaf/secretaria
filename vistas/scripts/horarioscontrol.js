var tabla;

//Función que se ejecuta al inicio
function init(){
    listarescuelas();
}

function listarescuelas(){
    $("#precarga").show();

           
           $.post("../controlador/horarioscontrol.php?op=listarescuelas",{}, function(r){
               var e = JSON.parse(r);

               $("#escuelas").html(e.mostrar);
               $("#precarga").hide();
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
				title: 'Control de horarios',
				intro: 'Te damos la bienvenida a nuestro control de horarios, donde podrás visualizar la información de cada escuela creativa'
			},
			{
				title: 'Escuelas',
				element: document.querySelector('#t-E'),
				intro: "Aquí podrás consultar el programa académico del cual deseas recibir información "
			},
			{
				title: 'Docente',
				element: document.querySelector('#t-D'),
				intro: "Aqui encontrarás todos los nombres de nuestros líderes creativos e innovadores "
			},
			{
				title: 'Asignatura',
				element: document.querySelector('#t-A'),
				intro: "Da un vistazo a la asignatura que serás dirigida por nuestro líder creativo formando así todas y cada una de nuestras experiencias creativas"
			},
			{
				title: 'Día',
				element: document.querySelector('#t-DI'),
				intro: "Aquí encontrarás la fecha establecida para nuestras experiencias creativas"
			},
			{
				title: 'Hora',
				element: document.querySelector('#t-H'),
				intro: "Podrás encontrar la hora exacta donde nuestros seres originales y nuestros líderes se reunen para la expereincia cada dia mas creativa e innovadora"
			},
			{
				title: 'Jornada',
				element: document.querySelector('#t-jor'),
				intro: "Aqui podrás encontrar la jornada donde nuestro líder creativo comienza la experiencia creativa de nuestros seres originales"
			},
			{
				title: 'Horas',
				element: document.querySelector('#t-Hs'),
				intro: "Revisa la cantidad de horas de nuestra experiencia creativa e innovadora"
			},
			{
				title: 'Fusión',
				element: document.querySelector('#t-F'),
				intro: "Encuentra la fusión entre los docentes y su respectivo salón donde vivirán toda la experiencia creativa e innovadora"
			},
			{
				title: 'Número de estudiantes',
				element: document.querySelector('#t-Ne'),
				intro: "Conoce le número de estudiantes que tendrás a cargo nuestros líderes creativos que los guiaran por el camino del conocimiento la creatividad y la innovación"
			},
			{
				title: 'Número de salón',
				element: document.querySelector('#t-Ns'),
				intro: "Aquí podrás encontrar el salón asignado donde líderes creativos y seres originales se reunirán para vivir la magia de la experiencia"
			},
			{
				title: 'Semestre',
				element: document.querySelector('#t-S'),
				intro: "Da un vistazo a el respectivo semestre de nuestros seres originales"
			},
			{
				title: 'Nivel',
				element: document.querySelector('#t-Ni'),
				intro: "El nivel de la carrera profesional en el que se encuentra nuestro grupo original"
			},
			
			
			

		]
			
	},
	console.log()
	
	).start();

}





//Función Listar
function listar(id_escuela)
{
$("#precarga").show();	
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	

	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
        "orderCellsTop": true,
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                titleAttr: 'Excel',
				
            },
			{
                extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Control horarios',
				titleAttr: 'Print',
            },

        ],
		"ajax":
				{
					url: '../controlador/horarioscontrol.php?op=listar&id_escuela='+id_escuela,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
	
			"bDestroy": true,
            "iDisplayLength":10,//Paginación
			"order": [[ 0, "desc" ]],
			'initComplete': function (settings, json) {
					$("#precarga").hide();
					$("#listadoregistros").show();

			},



	});

       

}


init();