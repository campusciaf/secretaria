function init(){
mostrarElementos();
mostrarElementosAdmin();
mostrarcategorias();
//formulario que edita y guarda la meta
$("#formulariosoftware").on("submit",function(e){
	guardaryeditarsoftware(e);	
});

//listamos el cargo en el html
$.post("../controlador/software_libre.php?op=softwareCategoria", function(r){
	$("#categoria_software").html(r);
	$('#categoria_software').selectpicker('refresh');
});
}

var formData;
var boolean_data;
var opcion;
var accion;
//Función para listar las metas por proyecto 
function mostrarElementos(permiso_software){
	
	$.post("../controlador/software_libre.php?op=mostrar_elementos",{ permiso_software:permiso_software},function(msg){
		// alert(msg);
		datos = JSON.parse(msg)
		// console.log(msg);

		$(".contenido_libre").html(datos);
		
		
	});
}

function mostrarElementosAdmin(){
$.ajax({
	url:'../controlador/software_libre.php?op=mostrar_admin',
	success:function(msg){
		datos = JSON.parse(msg)
		$(".contenido_libre_admin").html(datos);
		$(".infoLibro").hide();
	},
	error:function(){
		alert("Hay un error...");
	}
});
};

$("#btnAbrirModalSoftwareLibre").off("click").on("click",function(){
	$('#botonAgregar').show();
    $('#botonModificar').hide();
    $('#botonEliminar').hide();
	$("#file_url").show();
	$("#imagen_editar").hide();
	$("#modalSoftwareLibre").modal({backdrop:'static', keyboard:false});


	$('#botonAgregar').off("click").on("click",function(){
		boolean_data = recolectarInformacion();
		verificarInformacion(boolean_data, "agregar");
		$("#modalSoftwareLibre").modal('toggle');
	});
});

function mostrarcategorias(){
	
	$.post("../controlador/software_libre.php?op=mostrarcategorias",{},function(data){
		// console.log(data);
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){

				$("#mostrar_categorias").html(data);
			// $("#opcion").val(data.opcion);
			
		}
	});
}

/* ------------------------------------------------------------- */
function LimpiarFormulario(){
	$("#form_sw")[0].reset();
	// $('#tituloModalSoftwareLibre').html('Agregar Software Libre');
	// $("#id_software_libre").val('');
	// $("#file_url").val('');
	// $("#txtNombre").val('');
	// $("#txtSitio").val('');
	// $("#txtUrl").val('');
	// $("#txtDescripcion").val('');
	// $("#txtValor").val('');
	// $("#txtCategoria").val('');
};
function abrirModalSW(id_software){
	$('#botonAgregar').hide();
    $('#botonModificar').show();
    $('#botonEliminar').show();
	$("#imagen_editar").show();
	$("#modalSoftwareLibre").modal({backdrop:'static', keyboard:false});

	$('#botonModificar').off("click").on("click",function(){
		boolean_data = recolectarInformacion();
		verificarInformacion(boolean_data, "modificar");
		$("#modalSoftwareLibre").modal('toggle');
	});
	$('#botonEliminar').off("click").on("click",function(){
		boolean_data = recolectarInformacion();
		verificarInformacion(boolean_data, "eliminar");
		$("#modalSoftwareLibre").modal('toggle');
	});	

	$.ajax({
		type:'POST',
		url:'../controlador/software_libre.php?op=cargarFormulario',
		data:{id_software:id_software},
		success:function(msg){
			datos = JSON.parse(msg);
			$('#tituloModalSoftwareLibre').html(datos[0][1]);
			$("#id_software_libre").val(datos[0][0]);
			$("#imagen_editar").html('<img src="../public/img/software_libre/'+datos[0][4]+'" width="35%"><br><label>Imagen Actual</label><input name="respaldoimagen" type="text" class="hidden" value="'+datos[0][4]+'">');
			$("#txtNombre").val(datos[0][1]);
			$("#txtSitio").val(datos[0][2]);
			$("#txtUrl").val(datos[0][3]);
			$("#txtDescripcion").val(datos[0][5]);
			$("#txtValor").val(datos[0][6]);
			$("#txtCategoria").val(datos[0][7]);
		},
		error:function(){
			alert("Hay un error...");
		}
	});
};
// $("#filtro_0").off("click").on("click",function(){
// 	mostrarElementos();
// 	});

// $("#filtro_1").off("click").on("click",function(){
// 	opcion = 1;
// 	accion = "filtrar";
// 	filtrarSoftware(accion,opcion);
// 	});
// $("#filtro_2").off("click").on("click",function(){
// 	opcion = 2;
// 	accion = "filtrar";
// 	filtrarSoftware(accion,opcion);
// 	});
// $("#filtro_3").off("click").on("click",function(){
// 	opcion = 3;
// 	accion = "filtrar";
// 	filtrarSoftware(accion,opcion);
// 	});
// $("#filtro_4").off("click").on("click",function(){
// 	opcion = 4;
// 	accion = "filtrar";
// 	filtrarSoftware(accion,opcion);
// 	});
// $("#filtro_5").off("click").on("click",function(){
// 	opcion = 5;
// 	accion = "filtrar";
// 	filtrarSoftware(accion,opcion);
// 	});
// $("#filtro_6").off("click").on("click",function(){
// 	opcion = 6;
// 	accion = "filtrar";
// 	filtrarSoftware(accion,opcion);
// 	});

function filtrarSoftware(opcion){
	
	$.post("../controlador/software_libre.php?op=filtrar",{"opcion" : opcion},function(data){
		console.log(data);
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){

				$(".contenido_libre").html(data);
				$(".infoLibro").hide();//se esconde el boton por que nadie puede editarlo y aparace el boton de editar a los usuarios
			$("#mostrar_categorias").val(data);
			
		}
	});
}

function recolectarInformacion(){
	formData = new FormData($("#form_sw")[0]);
};

function verificarInformacion(boolean_data, accion){
	if (boolean_data == false) {
		alert("No es posible realizar la acción sin todos los campos llenos.");
	}else{
		EnviarInformacion(accion, formData);
	}
};

function  EnviarInformacion(accion, objEvento){
	$.ajax({
		type:'POST',
		url:'../controlador/software_libre.php?op='+accion,
		data:formData,
		contentType: false,
        processData: false,
		success:function(msg){
			if (msg == 1) {
				alertify.error("No es posible agregar sin todos los campos llenos, vuelve a intentarlo.");
			}else{
				alertify.success("Acción realizada correctamente.");
				mostrarElementos();
				LimpiarFormulario();
			}
		},
		error:function(){
			alertify.warning("Hay un error...");
		}
	});
};


function mostrar_software(id_software, nombre){
	
	$.post("../controlador/software_libre.php?op=mostrar_software_admin",{"id_software" : id_software, "nombre" : nombre},function(msg){
		
		datos = JSON.parse(msg)
		// console.log(datos);

		$("#id_software").val(id_software);
		
		$("#modalAdminBibliotecaDocente").modal("show");

		$("#nombre").val(nombre);
			


			
		
	});
}

//Función guardo y edito el nombre del proyecto
function guardaryeditarsoftware(e){
	// e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#botonAgregarHerramienta").prop("disabled",true);
	var formData = new FormData($("#formulariosoftware")[0]);
	$.ajax({
		"url": "../controlador/software_libre.php?op=guardaryeditarsoftware",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			$("#imagen_editar").show();
			window.location.reload();

			$("#modalAdminBibliotecaDocente").modal("hide");		
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);
			
			
		}
	});
}

init();