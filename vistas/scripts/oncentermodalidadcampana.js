var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	
	
}

//Función limpiar
function limpiar()
{
	$("#id_modalidad_campana").val("");	
	$("#nombre").val("");
	$("#estado").val("");

	
}

//Función mostrar formulario
function mostrarform(flag)
{
	//limpiar();
	if (flag)
	{
		$("#gestion").modal("show");
	}
	else
	{
		$("#gestion").modal("hide");
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
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
				title: 'Modalidad de campaña',
				intro: "Bienvenido a nuestras opciones de campaña donde tendrás la oportunidad de conocer como se crean los diferentes acercamientos que tenemos con las personas que desean ser parte nuestra comunidad de creatividad e innovación "
			},
			{
				title: 'Agregar modalidad',
				element: document.querySelector('#t-am'),
				intro: "Aquí podrás agregar una nueva opción para que las personas se animen a elegirnos como su institución de confianza para cumplir su sueño de ser un profesional"
			},
			{
				title: 'Acciones',
				element: document.querySelector('#t-acc'),
				intro: "Da un vistazo a las diferentes opciones para cada campaña creada"
			},
			{
				title: 'Eliminar',
				element: document.querySelector('#t-el'),
				intro: "Aquí tendrás la opción de eliminar una campaña que haya no haga parte de nuestra estrategia en la institución"
			},
			{
				title: 'Editar',
				element: document.querySelector('#t-ed'),
				intro: "De ser necesario aquí podrás cambiar el nombre de nuestra campaña"
			},
			{
				title: 'Desactivar/Activar',
				element: document.querySelector('#t-des'),
				intro: "Desactiva y actuva nuestra campaña en un click, si no hace parte de nuestra estrategia actual la podrás desactivar y guardar para próximas estrategias y actvarla nuevamente"
			},
			{
				title: 'Nombre',
				element: document.querySelector('#t-nom'),
				intro: "Aquí podrás visualizar el respectivo nombre que le ha asignado a nuestra campaña"
			},
			{
				title: 'Activado',
				element: document.querySelector('#t-act'),
				intro: "Da un vistazo a el estado de nuestra campaña si esta activo(SI) o en caso que este descativado(NO)"
			},
			
			
			
			

		]
			
	},
	console.log()
	
	).start();

}	


//Función Listar
function listar()
{
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
						title: 'Modalidad Campaña',
						titleAttr: 'Print'
					},
				],
		"ajax":
				{
					url: '../controlador/oncentermodalidadcampana.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		
			"bDestroy": true,
			"order": [[ 1, "desc" ]],//Ordenar (columna,orden)
            "iDisplayLength": 20,//Paginación
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},
      });
		
}
//Función para guardar o editar

function mostrar(id_modalidad_campana)
{
	$.post("../controlador/oncentermodalidadcampana.php?op=mostrar",{id_modalidad_campana : id_modalidad_campana}, function(data, status)
	{
		
		data = JSON.parse(data);	
		mostrarform(true);
		
		$("#nombre").val(data.nombre);		
		$("#estado").val(data.estado);
		$("#estado").selectpicker('estado');
		$("#id_modalidad_campana").val(data.id_modalidad_campana);


 	});
	
}




//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	
	$.ajax({
		url: "../controlador/oncentermodalidadcampana.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,
		
	    success: function(datos)
	    {   

			data = JSON.parse(datos);
			if(data.estado == "1"){
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: "Modalidad Creado",
					showConfirmButton: false,
					timer: 1500
				});   
				     
	          	mostrarform(false);
				  $('#tbllistado').DataTable().ajax.reload(); 
			}
			if(data.estado == "2"){
				Swal.fire({
					position: "top-end",
					icon: "error",
					title: "No se puede crear la modalidad",
					showConfirmButton: false,
					timer: 1500
				});   
			}
			if(data.estado == "3"){
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: "Modalidad Actualizado",
					showConfirmButton: false,
					timer: 1500
				});   
				     
	          	mostrarform(false);
				  $('#tbllistado').DataTable().ajax.reload(); 
			}
			if(data.estado == "4"){
				Swal.fire({
					position: "top-end",
					icon: "error",
					title: "No se puede actualizar la modalidad",
					showConfirmButton: false,
					timer: 1500
				});   
			}
			
	    }

	});
	limpiar();
}

function desactivar(id_modalidad_campana){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de desactivar la Modalidad?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/oncentermodalidadcampana.php?op=desactivar", {id_modalidad_campana : id_modalidad_campana}, function(e){
				
				if(e == 1){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Modalidad Desactivado con éxito.",
						icon: "success"
					  });

					$('#tbllistado').DataTable().ajax.reload();
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Modalidad no se puede desactivar.",
						icon: "error"
					  });
				}
        	});

		} else if (
		  /* Read more about handling dismissals below */
		  result.dismiss === Swal.DismissReason.cancel
		) {
		  swalWithBootstrapButtons.fire({
			title: "Cancelado",
			text: "Tu proceso está a salvo :)",
			icon: "error"
		  });
		}
	  });
}

function activar(id_modalidad_campana){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de activar la modalidad?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/oncentermodalidadcampana.php?op=activar", {id_modalidad_campana : id_modalidad_campana}, function(e){
				
				if(e == 1){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Modalidad activado con éxito.",
						icon: "success"
					  });

					$('#tbllistado').DataTable().ajax.reload();
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Modalidad no se puede activar.",
						icon: "error"
					  });
				}
	            
        	});

		} else if (
		  /* Read more about handling dismissals below */
		  result.dismiss === Swal.DismissReason.cancel
		) {
		  swalWithBootstrapButtons.fire({
			title: "Cancelado",
			text: "Tu proceso está a salvo :)",
			icon: "error"
		  });
		}
	  });
}

function eliminar(id_modalidad_campana){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar la modalidad?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/oncentermodalidadcampana.php?op=eliminar", {id_modalidad_campana : id_modalidad_campana}, function(e){
				
				if(e == 'null'){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Modalidad eliminado con éxito.",
						icon: "success"
					  });

					$('#tbllistado').DataTable().ajax.reload();
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Modadlidad no se puede eliminar.",
						icon: "error"
					  });
				}
        	});

		} else if (
		  /* Read more about handling dismissals below */
		  result.dismiss === Swal.DismissReason.cancel
		) {
		  swalWithBootstrapButtons.fire({
			title: "Cancelado",
			text: "Tu proceso está a salvo :)",
			icon: "error"
		  });
		}
	  });
}	
	


	

init();