var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	
	$.post("../controlador/oncenterestado.php?op=selectEscuela", function(r){
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
				title: 'Gestión de estados',
				intro: "Bienvenido a nuestra gestión de estados aquí podrás encontrar las diferentes funciones a las que tienes acceso "
			},
			{
				title: 'Agregar estado',
				element: document.querySelector('#t-As'),
				intro: "Agrega un nuevo estado en tan solo un click"
			},
			{
				title: 'Acciones',
				element: document.querySelector('#t-Ac'),
				intro: "Aquí podrás encontrar las diferentes funciones que puedes realizar para cada estado"
			},
			{
				title: 'Eliminar',
				element: document.querySelector('#t-El'),
				intro: "Aquí podrás eliminar el estado que ya no se utilice en nuestra institución"
			},
			{
				title: 'Editar',
				element: document.querySelector('#t-ed'),
				intro: "Da un vistazo y edita el nombre de alguno de nuestros estados si así se requiere"
			},
			{
				title: 'Desactivar',
				element: document.querySelector('#t-desc'),
				intro: "Aquí podrás desactivar los estados que tal ves nos puedan servir en un futuro, en click desctiva y activa "
			},
			{
				title: 'Nombre',
				element: document.querySelector('#t-no'),
				intro: "Encontrarás el nombre que previamente le has proporcionado"
			},
			{
				title: 'Activado',
				element: document.querySelector('#t-at'),
				intro: "Aquí podrás visualizar si el estado esta activo (SI) de lo contrario aparecerá un (NO) que significa que esta desactivado"
			},
			
			

		]
			
	},
	console.log()
	
	).start();

}


//Función limpiar
function limpiar()
{
	$("#id_estado").val("");	
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
						messageTop: '<div style="width:50%;float:left">Reporte estados Académicos<br><b>Fecha de Impresión</b>: '+fecha+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
						title: 'estados Académicos',
						titleAttr: 'Print'
					},
				],
		"ajax":
				{
					url: '../controlador/oncenterestado.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
		 	"order": [[ 2, "desc" ]],//Ordenar (columna,orden)
			'initComplete': function (settings, json) {
			$("#precarga").hide();
			},

      });
	
}
//Función para guardar o editar

function mostrar(id_estado)
{
	$.post("../controlador/oncenterestado.php?op=mostrar",{id_estado : id_estado}, function(data, status)
	{
		data = JSON.parse(data);	

		mostrarform(true);
		
		$("#nombre").val(data.nombre_estado);		
		$("#estado").val(data.estado);
		$("#estado").selectpicker('estado');
		$("#id_estado").val(data.id_estado);
 	});
	
}



//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	
	$.ajax({
		url: "../controlador/oncenterestado.php?op=guardaryeditar",
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
					title: "Estado Creado",
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
					title: "No se puede crear el estado",
					showConfirmButton: false,
					timer: 1500
				});   
			}
			if(data.estado == "3"){
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: "Estado Actualizado",
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
					title: "No se puede actualizar el estado",
					showConfirmButton: false,
					timer: 1500
				});   
			}
			
	    }

	});
	limpiar();
}

function desactivar(id_estado){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de desactivar el estado?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/oncenterestado.php?op=desactivar", {id_estado : id_estado}, function(e){
				
				if(e == 1){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Estado Desactivado con éxito.",
						icon: "success"
					  });

					$('#tbllistado').DataTable().ajax.reload();
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Estado no se puede desactivar.",
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
	
function activar(id_estado){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de activar el Estado?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/oncenterestado.php?op=activar", {id_estado : id_estado}, function(e){
				
				if(e == 1){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Estado activado con éxito.",
						icon: "success"
					  });

					$('#tbllistado').DataTable().ajax.reload();
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Estado no se puede activar.",
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
	
function eliminar(id_estado){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar el estado?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/oncenterestado.php?op=eliminar", {id_estado : id_estado}, function(e){
				
				if(e == 'null'){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Estado eliminado con éxito.",
						icon: "success"
					  });

					$('#tbllistado').DataTable().ajax.reload();
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Estado no se puede eliminar.",
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