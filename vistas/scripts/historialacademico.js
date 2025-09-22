var tabla;
var tabla2;
var id_programa_ac_ = "";
var id_estudiante_ = "";
var ciclo_ = "";
var api; // variable global para inicializar el responsive
var anchoVentana = window.innerWidth; // ancho de la ventana


//Función que se ejecuta al inicio
function init(){
	listar();
	$("#nombretabla").show;
	
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
				title: 'Historial académico',
				intro: ''
			},
			{
				title: 'Acciones',
				element: document.querySelector('#t-paso1'),
				intro: ""
			},
			{
				title: 'Ver historial',
				element: document.querySelector('#t-paso2'),
				intro: ""
			},
			{
				title: 'Programa',
				element: document.querySelector('#t-paso3'),
				intro: ""
			},
			{
				title: 'Jornada',
				element: document.querySelector('#t-paso4'),
				intro: ""
			},
			{
				title: 'Semestre',
				element: document.querySelector('#t-paso5'),
				intro: ""
			},
			{
				title: 'Grupo',
				element: document.querySelector('#t-paso6'),
				intro: ""
			},
			{
				title: 'Estado',
				element: document.querySelector('#t-paso7'),
				intro: ""
			},

			{
				title: 'Periodo activo',
				element: document.querySelector('#t-paso8'),
				intro: ""
			},


		]
			
	},
	
	).start();

}

//Función Listar
function listar(){
	
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	$("#listadoregistros").show();
	
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
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Historial',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/historialacademico.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						// console.log(e.responseText);	
					}
				},
		
			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			"order": [[ 6, "asc" ]],
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},

      });
		
}

function mostrarmaterias(id_programa_ac,ciclo,id_estudiante){


	$("#precarga").show();
	$.post("../controlador/historialacademico.php?op=mostrarmaterias",{id_programa_ac : id_programa_ac, ciclo:ciclo, id_estudiante:id_estudiante}, function(data, status)
	{
		//console.log(data);
		data = JSON.parse(data);
		//$("#myModalAgregarPrograma").modal("show");
		$("#listadoregistros").hide();
		$("#listadomaterias").show();
		$("#listadomaterias").html("");
		$("#listadomaterias").append(data["0"]["0"]);
		$("#nombretabla").hide();
		$("#precarga").hide();
	});
	
}

function volver(){
	$("#listadoregistros").show();
	$("#listadomaterias").hide();
	$("#nombretabla").show();
	
}


init();