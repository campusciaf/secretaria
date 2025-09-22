var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	
	$("#imagenmuestra").hide();
	//Mostramos los permisos
	$.post("../controlador/usuario.php?op=permisos&id=",function(r){
	        $("#permisos").html(r);
		
	});
	
	//Cargamos los items de los selects
	$.post("../controlador/usuario.php?op=selectTipoDocumento", function(r){
	            $("#usuario_tipo_documento").html(r);
	            $('#usuario_tipo_documento').selectpicker('refresh');
	});
	
	//Cargamos los items de los selects
	$.post("../controlador/usuario.php?op=selectTipoSangre", function(r){
	            $("#usuario_tipo_sangre").html(r);
	            $('#usuario_tipo_sangre').selectpicker('refresh');
	});
	
	//Cargamos los items de los selects
	$.post("../controlador/usuario.php?op=selectDependencia", function(r){
	            $("#usuario_cargo").html(r);
	            $('#usuario_cargo').selectpicker('refresh');
	});
	
	//Cargamos los items al select ejes
	$.post("../controlador/usuario.php?op=selectDepartamento", function(r){
	            $("#usuario_departamento_nacimiento").html(r);
	           	$('#usuario_departamento_nacimiento').selectpicker('refresh');
	
	});
	
	$.post("../controlador/usuario.php?op=selectMunicipio", function(r){
	            $("#usuario_municipio_nacimiento").html(r);
	            $('#usuario_municipio_nacimiento').selectpicker('refresh');
	});
	
	$.post("../controlador/usuario.php?op=selectListaSiNo", function(r){
	            $("#usuario_poa").html(r);
	            $('#usuario_poa').selectpicker('refresh');
	});
	

	
}

//Función limpiar
function limpiar(){
	$("#id_usuario").val("");
	$("#usuario_tipo_documento").val("");
	$("#usuario_tipo_documento").selectpicker('refresh');
	$("#usuario_identificacion").val("");
	$("#usuario_nombre").val("");
	$("#usuario_nombre_2").val("");
	$("#usuario_apellido").val("");
	$("#usuario_apellido_2").val("");
	$("#usuario_fecha_nacimiento").val("");
	$("#usuario_departamento_nacimiento").val("");
	$("#usuario_departamento_nacimiento").selectpicker('refresh');
	$("#usuario_municipio_nacimiento").val("");
	$("#usuario_municipio_nacimiento").selectpicker('refresh');
	$("#usuario_tipo_sangre").val("");
	$("#usuario_tipo_sangre").selectpicker('refresh');
	
	$("#usuario_direccion").val("");
	$("#usuario_telefono").val("");
	$("#usuario_celular").val("");
	$("#usuario_email").val("");
	$("#usuario_poa").val("");
	$("#usuario_poa").selectpicker('refresh');
	$("#usuario_cargo").val("");
	$("#usuario_cargo").selectpicker('refresh');
	
	$("#usuario_login").val("");
	$("#imagenmuestra").attr("src"," ");
	$("#imagenactual").val("");
	
}

//Función mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform(){
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar(){
	
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
                titleAttr: 'Excel'
            },
			{
                extend: 'print',
			 	text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/usuario.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						// console.log(e.responseText);	
					}
				},
		
			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			"order": [[ 7, "asc" ]],
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},

      });
		
}

//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	
	$.ajax({
		url: "../controlador/usuario.php?op=guardaryeditar",
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
					title: "Usuario Creado",
					showConfirmButton: false,
					timer: 1500
				});   

				limpiar();   
	          	mostrarform(false);
				  $('#tbllistado').DataTable().ajax.reload(); 
			}
			if(data.estado == "2"){
				Swal.fire({
					position: "top-end",
					icon: "error",
					title: "No se puede crear",
					showConfirmButton: false,
					timer: 1500
				});   
			}
			if(data.estado == "3"){
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: "Datos Actualizados",
					showConfirmButton: false,
					timer: 1500
				});
				limpiar();
	          	mostrarform(false);
				  $('#tbllistado').DataTable().ajax.reload(); 
			}
			if(data.estado == "4"){
				Swal.fire({
					position: "top-end",
					icon: "error",
					title: "No se puede actualizar",
					showConfirmButton: false,
					timer: 1500
				});   
			}
	    }
	});
}

function mostrar(id_usuario)
{
	$.post("../controlador/usuario.php?op=mostrar",{id_usuario : id_usuario}, function(data, status)
	{
		
		// console.log(data);
		data = JSON.parse(data);	
		mostrarform(true);
		
		$("#usuario_tipo_documento").val(data.usuario_tipo_documento);
		$("#usuario_tipo_documento").selectpicker('refresh');
		
		$("#usuario_identificacion").val(data.usuario_identificacion);
		
		$("#usuario_nombre").val(data.usuario_nombre);
		$("#usuario_nombre_2").val(data.usuario_nombre_2);
		$("#usuario_apellido").val(data.usuario_apellido);
		$("#usuario_apellido_2").val(data.usuario_apellido_2);
		$("#usuario_fecha_nacimiento").val(data.usuario_fecha_nacimiento);

		// $("#usuario_direccion").val(data.usuario_direccion);
		$(".usuario_direccion").val(data.usuario_direccion);
		
		// $("#usuario_telefono").val(data.usuario_telefono);
		$(".usuario_telefono").val(data.usuario_telefono);
		// $("#usuario_celular").val(data.usuario_celular);
		$(".usuario_celular").val(data.usuario_celular);
		// $("#usuario_email").val(data.usuario_email);
		$(".usuario_email").val(data.usuario_email);
		
		$("#usuario_departamento_nacimiento").val(data.usuario_departamento_nacimiento);
		$("#usuario_departamento_nacimiento").selectpicker('refresh');
		
		$("#usuario_municipio_nacimiento").val(data.usuario_municipio_nacimiento);
		$("#usuario_municipio_nacimiento").selectpicker('refresh');
		
		$("#pagina_web").val(data.pagina_web);
		$("#pagina_web").selectpicker('refresh');

		$("#al_lado").val(data.al_lado);
		$("#al_lado").selectpicker('refresh');


		$("#usuario_poa").val(data.usuario_poa);
		$("#usuario_poa").selectpicker('refresh');
		
		$("#usuario_cargo").val(data.usuario_cargo);
		$("#usuario_cargo").selectpicker('refresh');
		
		$("#usuario_tipo_sangre").val(data.usuario_tipo_sangre);
		$("#usuario_tipo_sangre").selectpicker('refresh');
		
		$("#usuario_login").val(data.usuario_login);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/usuarios/"+data.usuario_imagen);
		$("#imagenactual").val(data.usuario_imagen);
		$("#id_usuario").val(data.id_usuario);

	});
		$.post("../controlador/usuario.php?op=permisos&id="+id_usuario,function(r){
		$("#permisos").html(r);
	});
}

function desactivar(id_usuario){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de desactivar el usuario?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/usuario.php?op=desactivar", {id_usuario : id_usuario}, function(e){
				
				if(e == 1){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Usuario Desactivado con éxito.",
						icon: "success"
					  });

					$('#tbllistado').DataTable().ajax.reload();
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Usuario no se puede desactivar.",
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
//Función para activar registros
function activar(id_usuario){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de activar el Usuario?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/usuario.php?op=activar", {id_usuario : id_usuario}, function(e){
				
				if(e == 1){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Usuario activado con éxito.",
						icon: "success"
					  });

					$('#tbllistado').DataTable().ajax.reload();
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Usuario no se puede activar.",
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

function mostrarmunicipio(departamento) {	
	
    $.post("../controlador/usuario.php?op=selectMunicipio",{departamento:departamento} ,function (datos) {
        $("#usuario_municipio_nacimiento").html(datos);
        $("#usuario_municipio_nacimiento").selectpicker('refresh');
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
				title: 'Usuarios',
				intro: "Bienvenido a nuestra gestión de usuarios que hacen parte de nuestra comunidad CIAF"
			},
		
		
			
		]
			
	},
	console.log()
	
	).start();

}
init();