function init(){
mostrarLibros();
}
var NuevoLibro;
var formData;
var boolean_data;
var busqueda;
function mostrarLibros(){
	$.ajax({
		url:'../controlador/bibliotecaciaf.php?op=mostrar',
		success:function(msg){
			datos = JSON.parse(msg);
			$(".contenido_libre").html(datos);
		},
		error:function(){
			alertify.warning("Hay un error...");
		}
	}); 
};

$("#btnAbrirModalLibro").off("click").on("click",function(){
	LimpiarFormulario();
	$('#botonAgregar').show();
    $('#botonModificar').hide();
    $('#botonEliminar').hide();
	$("#file_url").show();
	$("#imagen_editar").hide();
	$("#modalBiblioteca").modal({backdrop:'static', keyboard:false});


	$('#botonAgregar').off("click").on("click",function(){
		boolean_data = recolectarInformacion();
		verificarInformacion(boolean_data, "agregar");
		$("#modalBiblioteca").modal('toggle');
		mostrarLibros();
	});
});
/* ------------------------------------------------------------- */
$('#comenzar_busqueda').off("click").on("click",function(e){
	e.preventDefault();
	busqueda = $('#busquedad').val();
	BusquedaLibros(busqueda);
});
function BusquedaLibros(busqueda){
	$.ajax({
		type:'POST',
		url:'../controlador/bibliotecaciaf.php?op=buscar',
		data:{busqueda:busqueda},
		success:function(msg){
			datos = JSON.parse(msg);
			$(".contenido_libre").html(datos);
		},
		error:function(){
			alertify.warning("Hay un error...");
		}
	});

};
function LimpiarFormulario(){
	$('#tituloModalBiblioteca').html('Agregar Libro');
	$("#id_base_datos").val('');
	$("#file_url").val('');
	$("#txtTitulo").val('');
	$("#txtFechaLanz").val('');
	$("#txtAutor").val('');
	$("#txtCategoria").val('');
	$("#txtPrograma").val('');
	$("#txtEditorial").val('');
	$("#txtISBN").val('');
	$("#txtIdioma").val('');
	$("#paginas").val('');
	$("#txtFormato").val('');
	$("#txtDesc").val('');
	$("#txtPalClav").val('');
	$("#ejemplares").val('');
};
function abrirModalLibro(id_libro){
	$('#botonAgregar').hide();
    $('#botonModificar').show();
    $('#botonEliminar').show();
	$("#imagen_editar").show();
	$("#modalBiblioteca").modal({backdrop:'static', keyboard:false});

	$('#botonModificar').off("click").on("click",function(){
		boolean_data = recolectarInformacion();
		verificarInformacion(boolean_data, "modificar");
		$("#modalBiblioteca").modal('toggle');
		mostrarLibros();
	});
	$('#botonEliminar').off("click").on("click",function(){
		boolean_data = recolectarInformacion();
		verificarInformacion(boolean_data, "eliminar");
		$("#modalBiblioteca").modal('toggle');
		mostrarLibros();
	});	

	$.ajax({
		type:'POST',
		url:'../controlador/bibliotecaciaf.php?op=cargarFormulario',
		data:{id_libro:id_libro},
		success:function(msg){
			datos = JSON.parse(msg);
			$('#tituloModalBiblioteca').html(datos[0][2]);
			$("#id_libro").val(datos[0][0]);
			$("#imagen_editar").html('<img src="../public/img/bibliotecaciaf/'+datos[0][1]+'" width="35%"><br><label>Imagen Actual</label><input name="respaldoimagen" type="text" class="hidden" value="'+datos[0][1]+'">');
			$("#txtTitulo").val(datos[0][2]);
			$("#txtFechaLanz").val(datos[0][3]);
			$("#txtAutor").val(datos[0][4]);
			$("#txtCategoria").val(datos[0][5]);
			$("#txtPrograma").val(datos[0][6]);
			$("#txtEditorial").val(datos[0][7]);
			$("#txtISBN").val(datos[0][8]);
			$("#txtIdioma").val(datos[0][9]);
			$("#paginas").val(datos[0][10]);
			$("#txtFormato").val(datos[0][11]);
			$("#txtDesc").val(datos[0][12]);
			$("#txtPalClav").val(datos[0][13]);
			$("#ejemplares").val(datos[0][14]);
		},
		error:function(){
			alert("Hay un error...");
		}
	});
};

function recolectarInformacion(){
		formData = new FormData($("#form")[0]);
};
function verificarInformacion(boolean_data, accion){
	if (boolean_data == false) {
		alert("No es posible realizar la acción sin todos los campos llenos.");
	}else{
		EnviarInformacion(accion, formData);
	}
}

function  EnviarInformacion(accion, objEvento){
	$.ajax({
		type:'POST',
		url:'../controlador/bibliotecaciaf.php?op='+accion,
		data:formData,
		contentType: false,
        processData: false,
		success:function(msg){
			alertify.success("Acción realizada correctamente.");
		},
		error:function(){
			alertify.warning("Hay un error...");
		}
	});
}

init();