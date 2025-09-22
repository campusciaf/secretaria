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
				title: 'Medios',
				intro: "Bienvenido a la magia que hace posible nuestra comunicación con todas las personas que aún no hacen parte de nuestra institución"
			},
			{
				title: 'Agregar medio',
				element: document.querySelector('#t-Am'),
				intro: "Aquí puedes agregar un nuevo medio para que las personas conozcan mucho más sobre nosotros"
			},
			{
				title: 'Acciones',
				element: document.querySelector('#t-Ac'),
				intro: "Aquí podrás encontrar las diferentes funciones que puedes realizar para cada medio"
			},
			{
				title: 'Eliminar',
				element: document.querySelector('#t-El'),
				intro: "Aquí podrás eliminar el medio que ya no se utilice en nuestra institución"
			},
			{
				title: 'Editar',
				element: document.querySelector('#t-ed'),
				intro: "Da un vistazo y edita el nombre de alguno de nuestros medios si así se requiere"
			},
			{
				title: 'Desactivar',
				element: document.querySelector('#t-desc'),
				intro: "Aquí podrás desactivar los medios que tal ves nos puedan servir en un futuro, en click desctiva y activa "
			},
			{
				title: 'Nombre',
				element: document.querySelector('#t-no'),
				intro: "Encontrarás el nombre que previamente le has proporcionado"
			},
			{
				title: 'Activado',
				element: document.querySelector('#t-at'),
				intro: "Aquí podrás visualizar si el medio esta activo (SI) de lo contrario aparecerá un (NO) que significa que esta desactivado"
			},
			
			

		]
			
	},
	console.log()
	
	).start();

}

//Función limpiar
function limpiar()
{
	$("#id_medio").val("");	
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

//Función Listar
function listar(){
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
					url: '../controlador/oncentermedio.php?op=listar',
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

function mostrar(id_medio)
{
	$.post("../controlador/oncentermedio.php?op=mostrar",{id_medio : id_medio}, function(data, status)
	{
		
		data = JSON.parse(data);	
		mostrarform(true);
		$("#id_medio").val(data.id);
		$("#nombre").val(data.nombre);		
		$("#estado").val(data.estado);
		$("#estado").selectpicker('estado');
		


 	});
	
}

//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	
	$.ajax({
		url: "../controlador/oncentermedio.php?op=guardaryeditar",
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
					title: "Medio Creado",
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
					title: "No se puede crear el medio",
					showConfirmButton: false,
					timer: 1500
				});   
			}
			if(data.estado == "3"){
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: "Medio Actualizado",
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
					title: "No se puede actualizar el medio",
					showConfirmButton: false,
					timer: 1500
				});   
			}
			
	    }

	});
	limpiar();
}

function desactivar(id_medio){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de desactivar el medio?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/oncentermedio.php?op=desactivar", {id_medio : id_medio}, function(e){
				
				if(e == 1){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Medio Desactivado con éxito.",
						icon: "success"
					  });

					$('#tbllistado').DataTable().ajax.reload();
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Medio no se puede desactivar.",
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

function activar(id_medio){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de activar el Medio?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/oncentermedio.php?op=activar", {id_medio : id_medio}, function(e){
				
				if(e == 1){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Medio activado con éxito.",
						icon: "success"
					  });

					$('#tbllistado').DataTable().ajax.reload();
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Medio no se puede activar.",
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

function eliminar(id_medio){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar el medio?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/oncentermedio.php?op=eliminar", {id_medio : id_medio}, function(e){
				
				if(e == 'null'){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Medio eliminado con éxito.",
						icon: "success"
					  });

					$('#tbllistado').DataTable().ajax.reload();
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "MEdio no se puede eliminar.",
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