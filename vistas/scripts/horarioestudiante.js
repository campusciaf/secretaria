var tabla;

//Función que se ejecuta al inicio
function init(){
	$("#precarga").hide();
	
	mostrarform(false);

	$("#listadomaterias").hide();
	
	$("#formularioverificar").on("submit",function(e1)
	{
		verificardocumento(e1);	
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
				title: 'Horarios Estudiantes',
				intro: 'Da un vistazo a nuestro horario original donde no solo tu, si no también nuestros seres originales podrán visualizar su horario'
			},
			{
				title: 'Busquedad',
				element: document.querySelector('#t-identificacion'),
				intro: "Ingresa el número de cedula de nuestro ser original para poder realizar tu busquedad"
			},
			{
				title: 'Nombre completo',
				element: document.querySelector('#t-personal'),
				intro: "Aquí podrás encontrar el nombre completo y la foto de nuestro ser original"
			},

			{
				title: 'Correo',
				element: document.querySelector('#t-correo'),
				intro: "Aquí podrás encontrar su respectivo correo electrónico"
			},

			{
				title: 'contacto',
				element: document.querySelector('#t-celular'),
				intro: "Aquí podrás encontrar su respectivo número de celular"
			},
			{
				title: 'Información',
				element: document.querySelector('#t-info'),
				intro: "Da un vitazo a toda la información de nuestro ser original"
			}
	        ,
			{
				title: 'Acciones',
				element: document.querySelector('#t-acciones'),
				intro: "Aquí podras encontrar las diferentes materias que tiene matriculadas nuestro ser original"
			}
			,
			{
				title: 'Id estudiante',
				element: document.querySelector('#t-idE'),
				intro: "Este la identificación unica que se le asigna en nustra institución"
			}
			,
			{
				title: 'Programa',
				element: document.querySelector('#t-programas'),
				intro: "Aquí podrás encontrar el programa al que pertenece"
			}
			,
			{
				title: 'Jornada',
				element: document.querySelector('#t-jornadas'),
				intro: "La jornada a la cual pertenece "
			}
			,
			{
				title: 'Semestre',
				element: document.querySelector('#t-semestres'),
				intro: "También podrás visualizar su respectivo semestre"
			}
			,
			{
				title: 'Grupo',
				element: document.querySelector('#t-grupos'),
				intro: "Visualiza el respectivo grupo de nuestro ser original"
			}
			,
			{
				title: 'Estado',
				element: document.querySelector('#t-estado1'),
				intro: "Revisa el estado actual de nustro ser original"
			}
			,
			{
				title: 'Nuevo del',
				element: document.querySelector('#t-nuevo'),
				intro: "Da un vistazo a la fecha en la que nuestro ser original decidio formar parte de nuestro parche creativo"
			}
			,
			{
				title: 'Periodo activo',
				element: document.querySelector('#t-periodo'),
				intro: "Observa la fecha de periodo activo de nuestro ser original"
			}

		]
			
	},
	console.log()
	
	).start();

}

//Función limpiar
function limpiar()
{
	$("#id_credencial").val("");
	$("#credencial_nombre").val("");
	$("#credencial_nombre_2").val("");
	$("#credencial_apellido").val("");
	$("#credencial_apellido_2").val("");
	//$("#credencial_identificacion").val("");
	$("#credencial_login").val("");

}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		$("#seleccionprograma").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#seleccionprograma").show();
		
	
	}
}

//Función Listar
function verificardocumento(e1)
{
	$("#listadomaterias").hide();
	
		e1.preventDefault();
		//$("#btnVerificar").prop("disabled",true);
		var formData = new FormData($("#formularioverificar")[0]);


		$.ajax({
		url: "../controlador/horarioestudiante.php?op=verificardocumento",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,
	    success: function(datos)
	    {   	
	        data = JSON.parse(datos);
			var id_credencial="";
			if(JSON.stringify(data["0"]["1"])=="false"){// si llega vacio toca matricular
				alertify.error("Estudiante No Existe");
				$("#listadoregistros").hide();
				$("#mostrardatos").hide();
			   }
			else{
				id_credencial=data["0"]["0"];
				$("#mostrardatos").show();
				alertify.success("Esta registrado");
				listar(id_credencial);
				
			}
			
	    }

	});
	

	
}
		   
//Función Listar
function listar(id_credencial)
{
	$("#listadoregistros").show();
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
						messageTop: '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: '+fecha+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
						title: 'Programas Académicos',
						titleAttr: 'Print'
					},
				],
		"ajax":
				{
					url: '../controlador/horarioestudiante.php?op=listar&id_credencial='+id_credencial,
					type : "get",
					dataType : "json",						
					error: function(e){
							
					}
				},
		"bDestroy": true,
		"scrollX": false,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 2, "asc" ]],//Ordenar (columna,orden)
		'initComplete': function (settings, json) {
			mostrardatos(id_credencial);
			$("#precarga").hide();
		},

	}).DataTable();
	

}

function mostrardatos(id_credencial){
	$.post("../controlador/horarioestudiante.php?op=mostrardatos",{id_credencial : id_credencial}, function(data, status)
	{

		data = JSON.parse(data);
		$("#datos_estudiante").hide();
		$("#mostrardatos").html("");
		$("#mostrardatos").append(data["0"]["0"]);
			
	});
}



function mostrarmaterias(id,ciclo,id_programa,grupo)
{
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

	$("#precarga").show();

	$.post("../controlador/horarioestudiante.php?op=mostrarmaterias",{id:id , ciclo:ciclo, id_programa:id_programa, grupo:grupo  },function(data, status){
	
	data = JSON.parse(data);
		
	$("#listadoregistros").hide();
	$("#listadomaterias").show();
	$("#listadomaterias").html("");
	$("#listadomaterias").append(data["0"]["0"]);
	$("#precarga").hide();



		$(document).ready(function() {
			$('#example').DataTable( {


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
						messageTop: '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: '+fecha+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
						title: 'Horario estudiante',
						titleAttr: 'Print'
					},
				],
				"language":{ 
					"url": "../public/datatables/idioma/Spanish.json"
				},
				columnDefs: [

				{ className: 'text-center', targets: [1,2,3,4,5,6,7,8] },
			  ],
			  'initComplete': function (settings, json) {

				$("#precarga").hide();
			},
			  

      });
	



		} );

		
	});
}

init();