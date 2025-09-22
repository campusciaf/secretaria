function init(){
mostrarElementos();
mostrarElementosAdmin();
mostrarcategorias();
}

var formData;
var boolean_data;
var opcion;
var accion;

function mostrarElementos(){
$.ajax({
	url:'../controlador/software_librea_admin.php?op=mostrar',
	success:function(msg){
		datos = JSON.parse(msg)
		$(".contenido_libre").html(datos);
		
	},
	error:function(){
		alert("Hay un error...");
	}
});
};
function mostrarElementosAdmin(){
$.ajax({
	url:'../controlador/software_librea_admin.php?op=mostrar_admin',
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
		url:'../controlador/software_librea_admin.php?op=cargarFormulario',
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
	



function filtrarSoftware(opcion){
	
	$.post("../controlador/software_librea_admin.php?op=filtrar",{"opcion" : opcion},function(data){
		console.log(data);
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){

				$(".contenido_libre").html(data);
				$(".infoLibro").hide();//se esconde el boton por que nadie puede editarlo y aparace el boton de editar a los usuarios
			$("#mostrar_categorias").val(data);
			
		}
	});
}



function mostrarcategorias(){
	
	$.post("../controlador/software_librea_admin.php?op=mostrarcategorias",{},function(data){
		console.log(data);
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){

				$("#mostrar_categorias").html(data);
			// $("#opcion").val(data.opcion);
			
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
		url:'../controlador/software_librea_admin.php?op='+accion,
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

init();