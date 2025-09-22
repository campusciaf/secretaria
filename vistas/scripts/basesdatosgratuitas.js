function init(){
mostrarElementos();
mostrarElementosAdmin();
}

var formData;
var boolean_data;

function mostrarElementos(){
$.ajax({
	url:'../controlador/bases_datos_gratuitas.php?op=mostrar',
	success:function(msg){
		datos = JSON.parse(msg)
		$(".contenido_libre").html(datos);
	},
	error:function(){
		alert("Hay un error...");
	}
});
}
function mostrarElementosAdmin(){
$.ajax({
	url:'../controlador/bases_datos_gratuitas.php?op=mostrar_admin',
	success:function(msg){
		datos = JSON.parse(msg)
		$(".contenido_libre_admin").html(datos);
	},
	error:function(){
		alert("Hay un error...");
	}
});
}

$("#btnAbrirModalBaseDatos").off("click").on("click",function(){
	$('#botonAgregar').show();
    $('#botonModificar').hide();
    $('#botonEliminar').hide();
	$("#file_url").show();
	$("#imagen_editar").hide();
	$("#modalBasesDeDatos").modal({backdrop:'static', keyboard:false});


	$('#botonAgregar').off("click").on("click",function(){
		boolean_data = recolectarInformacion();
		verificarInformacion(boolean_data, "agregar");
		$("#modalBasesDeDatos").modal('toggle');
	});
});
/* ------------------------------------------------------------- */
function LimpiarFormulario(){
	$('#tituloModalBaseDatos').html('Agregar Base de Datos');
	$("#id_base_datos").val('');
	$("#file_url").val('');
	$("#txtNombre").val('');
	$("#txtSitio").val('');
	$("#txtUrl").val('');
	$("#txtDescripcion").val('');
	$("#txtValor").val('');
};
function abrirModalBD(id_base_datos){
	$('#botonAgregar').hide();
    $('#botonModificar').show();
    $('#botonEliminar').show();
	$("#imagen_editar").show();
	$("#modalBasesDeDatos").modal({backdrop:'static', keyboard:false});

	$('#botonModificar').off("click").on("click",function(){
		boolean_data = recolectarInformacion();
		verificarInformacion(boolean_data, "modificar");
		$("#modalBasesDeDatos").modal('toggle');
	});
	$('#botonEliminar').off("click").on("click",function(){
		boolean_data = recolectarInformacion();
		verificarInformacion(boolean_data, "eliminar");
		$("#modalBasesDeDatos").modal('toggle');
	});	

	$.ajax({
		type:'POST',
		url:'../controlador/bases_datos_gratuitas.php?op=cargarFormulario',
		data:{id_base_datos:id_base_datos},
		success:function(msg){
			datos = JSON.parse(msg);
			$('#tituloModalBaseDatos').html(datos[0][1]);
			$("#id_base_datos").val(datos[0][0]);
			$("#imagen_editar").html('<img src="../public/img/bd_gratuitas/'+datos[0][4]+'" width="35%"><br><label>Imagen Actual</label><input name="respaldoimagen" type="text" class="hidden" value="'+datos[0][4]+'">');
			$("#txtNombre").val(datos[0][1]);
			$("#txtSitio").val(datos[0][2]);
			$("#txtUrl").val(datos[0][3]);
			$("#txtDescripcion").val(datos[0][5]);
			$("#txtValor").val(datos[0][6]);
		},
		error:function(){
			alert("Hay un error...");
		}
	});
};

function recolectarInformacion(){
	formData = new FormData($("#form_bd")[0]);
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
		url:'../controlador/bases_datos_gratuitas.php?op='+accion,
		data:formData,
		contentType: false,
        processData: false,
		success:function(msg){
			if (msg == 1) {
				alertify.error("No es posible agregar sin todos los campos llenos, vuelve a intentarlo.");
			}else{
				alertify.success("Acción realizada correctamente.");
				mostrarElementos();
				mostrarElementosAdmin();
				LimpiarFormulario();
			}
		},
		error:function(){
			alertify.warning("Hay un error...");
		}
	});
};

init();