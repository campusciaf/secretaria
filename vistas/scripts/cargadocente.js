
//Función que se ejecuta al inicio
function init(){

	$("#precarga").hide();
	$("#creargrupo").hide();
	$("#listadoregistros").hide();

	//Cargamos los items de los selects contrato
	$.post("../controlador/cargadocente.php?op=selectPeriodo", function(r){
		$("#periodo").html(r);
		$('#periodo').selectpicker('refresh');
	});	

	$.post("../controlador/cargadocente.php?op=periodo", function(data){
		data = JSON.parse(data);
		$("#precarga").show();
		listar(data.periodo);

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
				title: 'Carga por docente',
				intro: 'Bienvenido a nuestra lista de docentes en donde podrás encontrar a todos nuestros lideres de experiencias creativas'
			},
			{
				title: 'Periodo académico',
				element: document.querySelector('#t-programa'),
				intro: "Aquí podrás encontrar nuestros diferentes periodos académicos los cuales podrás encontrar"
			},
			{
				title: 'foto',
				element: document.querySelector('#t-foto'),
				intro: "Da un vistazo a la foto de nuestros diferentes docentes"
			},

			{
				title: 'Cedula',
				element: document.querySelector('#t-cedula'),
				intro: "Información unica de nuestros líderes de experiencias creativas"
			},

			{
				title: 'Nombre',
				element: document.querySelector('#t-nombre'),
				intro: "El nombre nos indica quienes somos, es por eso que conocer y reconcer el nombre de nuestros líderes es de suma importancia"
			},
			{
				title: 'Contacto',
				element: document.querySelector('#t-contacto'),
				intro: "Para nosotros es importante mantener una buena comunicación, por eso en este campo podrás ver el número de nuestros líderes"
			}
			,
			{
				title: 'Correo',
				element: document.querySelector('#t-correo'),
				intro: "puedes contactarte de una segunda manera, a través de el correo electrónico proporsionado"
			}
			,
			{
				title: 'Contrato',
				element: document.querySelector('#t-contrato'),
				intro: "Conoce nuestros diferentes tipos de contrato que tiene cada líder de experiencias creativas"
			}
			,
			{
				title: 'Grupos',
				element: document.querySelector('#t-grupos'),
				intro: "Conoce la cantidad de grupos que nuestro docente guiará en nuestras diferentes experiencias creativas"
			}
			,
			{
				title: 'Horas de clase',
				element: document.querySelector('#t-horas'),
				intro: "Ten encuenta la cantidad de horas de el semestre y el segundo bloque de nuestros docentes"
			}
			,
			{
				title: 'Horas a convenir',
				element: document.querySelector('#t-horasc'),
				intro: "Agrega un horario diferente para nuestros docentes y así poder continuar con las experiencias creativas de nuestros seres originales"
			}
			
			
			

		]
			
	},
	console.log()
	
	).start();

}

//Función Listar
function listar(periodo){
$("#precarga").show();	
$("#dato_periodo").html("Carga " + periodo);
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
                titleAttr: 'Excel',
				
            },
			{
                extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Docentes',
				titleAttr: 'Print',
				exportOptions: {

					format: {
						body: function(data){
						//Antes de mandarse al PDF cada valor pasa por aqui y es evaluado
						var valor = data.toString(); //El campo debe ser STRING para que funcione
						valor = valor.replace("<br/>","\n");  //Aqui es donde le digo al JavaScript que reemplace <br/> el salto de linea HTML por el salto de linea \n
						return valor;
						}
					}
				}
            },

        ],
		"ajax":
				{
					url: '../controlador/cargadocente.php?op=listar&periodo='+periodo,
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

            }else {
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
	if(width <= 768){
		$(api.table().node()).toggleClass('cards');
		api.draw('page');
	}
}

function modalHorario(id_docente,periodo){

	$("#myModalHorario").modal("show");
	iniciarcalendario(id_docente,periodo);
}



function iniciarcalendario(id_docente,periodo){


	$("#titulo").show();

	var calendarEl = document.getElementById('calendar');
	var calendar = new FullCalendar.Calendar(calendarEl, {
		initialView: 'timeGridWeek',
		locales: 'es',
		slotMinTime: "06:00:00",
    	slotMaxTime: "24:00:00",
		headerToolbar: {
				left: '',
				center: '',
				right: ''
		},
		slotLabelFormat:{
			hour: '2-digit',
			minute: '2-digit',
			hour12: true,
			meridiem: 'short',
		},
		eventTimeFormat: {
			hour: '2-digit',
			minute: '2-digit',
			hour12: true
		},
		

		events:"../controlador/cargadocente.php?op=iniciarcalendario&id_docente="+id_docente+"&periodo="+periodo,

		eventClick:function(info){
			$('#modalTitle').html(info.event.title);
			$('#modalDia').html(info.event.daysOfWeek);
			$('#myModalEvento').modal();

		},
		

	});
	calendar.render();



	// $('#btnPrint').click(function(){
	// 	window.print();
	// });

}



//Función Listar
function listarHorario2(id_docente,periodo)
{
	//$("#precarga").show();

var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	
	$.post("../controlador/cargadocente.php?op=listarhorario",{id_docente:id_docente, periodo:periodo }, function(data, status){
		
	data = JSON.parse(data);
		var nombre_docente=data["0"]["1"];
		
		if ($.fn.DataTable.isDataTable("#tbllistadohorario") ) {
			$("#tbllistadohorario").DataTable().destroy();
		}
		
		$("#tbllistadohorario").html("");
		$("#tbllistadohorario").append(data["0"]["0"]);
		var tabla=$('#tbllistadohorario').dataTable({
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
                messageTop: '<div style="width:50%;float:left"><b>Docente:</b> '+nombre_docente+' <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Horario Grupo',
				titleAttr: 'Print',
				exportOptions: {
					columns: ':visible',
				},
            },
		{
                extend: 'colvis',
				text: '<i class="fas fa-eye fa-2x"> Ocultar Columnas</i>',
				title: 'Ocultar columna',
				titleAttr: 'ocultar'
            },
        ],
		"bDestroy": true,
		"iDisplayLength": 71,//Paginación
		"order": [[ 0, "asc" ]],//Ordenar (columna,orden)
		"columnDefs": [{ "width": "20px", "targets": 0 },{"width": "60px", "targets": 1}],
		"createdRow": function( row, data, dataIndex ) {
			if ( data["2"] == "" && data["3"] == "" && data["4"] == "" && data["5"] == "" && data["6"] == "" && data["7"] == "" && data["8"] == "" && data["9"] == "" && data["10"] == "" && data["11"] == "" && data["12"] == ""){
				$('#tbllistadohorario').DataTable().rows($(row)).remove().draw();
			}
		},
			
		//"rowsGroup": [2,3,4,5,6,7,8,9,10],
			
	}).DataTable();
		
		//$("#precarga").hide();
});
	
}


//Función para mostrar nombre de la meta 
function modalaconvenir(id_usuario){
	
	$.post("../controlador/cargadocente.php?op=horasConvenir",{ "id_usuario": id_usuario },function(data){
		data = JSON.parse(data);
		console.log(data);
		$("#myModalaConvenir").modal("show");
		$("#escuela").html(data);
	});
}

// function guardarescuela(){
	
// 	var formData = new FormData($("#escuela")[0]);
// 	alert('alerta guardar escuela');
// 	$.ajax({
// 		"url": "../controlador/cargadocente.php?op=guardarConvenir",
// 		"type": "POST",
// 		"data": formData,
// 		"contentType": false,
// 		"processData": false,
// 		success: function(datos){ 
// 			console.log(datos);
// 			alertify.set('notifier','position', 'top-center');
// 			// $("#myModalaConvenir").hide();
// 			alertify.success(datos);	          
// 		}
// 	});
// }

function guardarescuela(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	alert('btn guardar');
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#escuela")[0]);
	$.ajax({
		url: "../controlador/cargadocente.php?op=guardarConvenir",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos){   
			console.log(datos);
			alertify.success(datos);	          
			mostrarform(false);
			// listar();
		}
	});
}

function buscarDatos(){

	periodo	= $('#periodo').val();
	if(periodo != "" ){	
		$("#listadoregistros").show();
		listar(periodo);
	}else{
		$("#listadoregistros").hide();
	}
}

init();