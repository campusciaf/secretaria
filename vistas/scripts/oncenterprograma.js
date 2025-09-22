var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	
	$.post("../controlador/oncenterprograma.php?op=selectEscuela", function(r){
	            $("#escuela").html(r);
	            $('#escuela').selectpicker('refresh');
	});
	
	$("#form2").on("submit",function(e) {
		agregarCorte(e);
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
				title: 'Programas',
				intro: "Bienvenido a nuestra gestión de programas donde podrás tener acceso a nuestras funciones con respecto a los programas"
			},
			{
				title: 'Agregar programa',
				element: document.querySelector('#t-prom'),
				intro: " Aquí podrás agregar un nuevo programa creativo lleno de innovación y nuevas experiencias "
			},
			{
				title: 'Acciones',
				element: document.querySelector('#t-acc'),
				intro: "Da u vistazo a las herramientas que tienes disponibles para nuestros programas ya establecidos"
			},
			{
				title: 'Eliminar',
				element: document.querySelector('#t-eli'),
				intro: "En un click elimina el programa creativo que ya no haga parte de nuestra lista de opciones para ofrecer "
			},
			{
				title: 'Editar',
				element: document.querySelector('#t-edi'),
				intro:  "Aquí podrás editar el nombre de nuestro programa creativo"
			},
			{
				title: 'Desactivar',
				element: document.querySelector('#t-desc'),
				intro: "En un click desactiva el programa que ya no haga parte de nuestras ofertas académicas "
			},
			{
				title: 'Nombre',
				element: document.querySelector('#t-name'),
				intro: "Aquí podrás visualizar el nombre de nuestro programa creatio que tenemos para ofertar"
			},
			{
				title: 'Activo',
				element: document.querySelector('#t-act'),
				intro: "Da un vistazo si alguno de los programas creativos esta activo entre nuestras ofertas (SI) de lo contrario aparecerá un (NO)"
			},
			
		]
			
	},
	console.log()
	
	).start();

}




//Función limpiar
function limpiar()
{
	$("#id_programa").val("");	
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
					url: '../controlador/oncenterprograma.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			order: [[2, 'desc']],
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},

      });	
}
//Función para guardar o editar

function mostrar(id_programa)
{
	$.post("../controlador/oncenterprograma.php?op=mostrar",{id_programa : id_programa}, function(data, status)
	{
		
		data = JSON.parse(data);	
		mostrarform(true);
		
		$("#nombre").val(data.nombre);		
		$("#estado").val(data.estado);
		$("#estado").selectpicker('estado');
		$("#id_programa").val(data.id_programa);


 	});
	
}


//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	
	$.ajax({
		url: "../controlador/oncenterprograma.php?op=guardaryeditar",
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
					title: "Programa Creado",
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
					title: "No se puede crear el programa",
					showConfirmButton: false,
					timer: 1500
				});   
			}
			if(data.estado == "3"){
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: "Programa Actualizado",
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
					title: "No se puede actualizar el programa",
					showConfirmButton: false,
					timer: 1500
				});   
			}
			
	    }

	});
	limpiar();
}


function desactivar(id_programa){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de desactivar el programa?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/oncenterprograma.php?op=desactivar", {id_programa : id_programa}, function(e){
				
				if(e == 1){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Programa Desactivado con éxito.",
						icon: "success"
					  });

					$('#tbllistado').DataTable().ajax.reload();
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Programa no se puede desactivar.",
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
	


function activar(id_programa){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de activar el Programa?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/oncenterprograma.php?op=activar", {id_programa : id_programa}, function(e){
				
				if(e == 1){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Programa activado con éxito.",
						icon: "success"
					  });

					$('#tbllistado').DataTable().ajax.reload();
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Programa no se puede activar.",
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

	
function eliminar(id_programa){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar el programa?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/oncenterprograma.php?op=eliminar", {id_programa : id_programa}, function(e){
				
				if(e == 'null'){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Programa eliminado con éxito.",
						icon: "success"
					  });

					$('#tbllistado').DataTable().ajax.reload();
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Programa no se puede eliminar.",
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