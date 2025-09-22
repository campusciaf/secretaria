function init(){
	mostrarElementosSoftware();
	mostrarcategorias();
// mostrarElementosAdmin();
// mostrar_editar_software();

	//formulario que edita y guarda la meta
	$("#formulariosoftware").on("submit",function(e){
		
		guardaryeditarsoftware(e);	
	});

	//listamos el cargo en el html
	$.post("../controlador/cajaherramientasadmin.php?op=softwareCategoria", function(r){
		$("#categoria_software").html(r);
		$('#categoria_software').selectpicker('refresh');
	});


}

var formData;
var boolean_data;
var opcion;
var accion;

function mostrarElementosSoftware(){
$.ajax({
	url:'../controlador/cajaherramientasadmin.php?op=mostrar_elementos_software',
	success:function(msg){
		datos = JSON.parse(msg)
		$(".contenido_libre").html(datos);

	},
	error:function(){
		alert("Hay un error...");
	}
});
};



function mostrarcategorias(){
	
	$.post("../controlador/cajaherramientasadmin.php?op=mostrarcategorias",{},function(data){
		console.log(data);
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){

				$("#mostrar_categorias").html(data);
			// $("#opcion").val(data.opcion);
			
		}
	});
}


// function mostrar_software(id_software){
// 	$.post("../controlador/cajaherramientasadmin.php?op=mostrar_software_admin",{"id_software" : id_software},function(data){
// 		console.log(data);
// 		data = JSON.parse(data);
// 			if(Object.keys(data).length > 0){
// 			$("#id_software").val(data.id_software);
// 			$("#nombre").val(data.nombre);
// 			$("#sitio").val(data.sitio);
// 			$("#url").val(data.url);
// 			$("#descripcion").val(data.descripcion);
// 			$("#valor").val(data.valor);
// 			$("#categoria").val(data.categoria);
// 			$("#modalAdminBiblioteca").modal("show");
// 		}
// 	});
// }

function mostrar_software(id_software){
	$.post("../controlador/cajaherramientasadmin.php?op=mostrar_software_admin",{"id_software" : id_software},function(datos){
		// alert(datos);
		datos2 = JSON.parse(datos)
		// console.log(datos2);

		$("#id_software").val(id_software);
		$("#nombre_herramienta").val(datos2.nombre);
		$("#sitio_herramienta").val(datos2.sitio);
		$("#url_herramienta").val(datos2.url);
		$("#descripcion_herramienta").val(datos2.descripcion);
		$("#valor_herramienta").val(datos2.valor);
		$("#imagenmuestra").val(datos2.usuario_imagen);
		$("#categoria_software").val(datos2.id_software_categoria);
		$("#categoria_software").selectpicker('refresh');
		
		$("#modalAdminBiblioteca").modal("show");
		
	});
}




//Función guardo y edito el nombre del proyecto
function guardaryeditarsoftware(e){
	// e.preventDefault(); //No se activará la acción predeterminada del evento

    
	
	// $("#botonAgregarHerramienta").prop("disabled",true);
	var formData = new FormData($("#formulariosoftware")[0]);
    // formData.append("categoria_herramienta", id_software_categoria);
	$.ajax({
		"url": "../controlador/cajaherramientasadmin.php?op=guardaryeditarsoftware",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			
			// alert(datos);
			console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);
			$("#imagen_editar").show();
			window.location.reload();

			$("#modalAdminBiblioteca").modal("hide");		
			
			
		}
	});
}

//Función para desactivar registros
function eliminar_software(id_software){

	alertify.confirm("¿Está Seguro de eliminar", function(result){
		if(result){
			$.post("../controlador/cajaherramientasadmin.php?op=eliminar_software", {'id_software' : id_software}, function(e){
				// console.log(e);
				if(e){
					alertify.success("Eliminado correctamente");
					window.location.reload();

					
				}else{
					alertify.error("Error");
				}
			});	
        }
	})
}


// function mostrarElementos(){
// 	$.ajax({
// 		url:'../controlador/cajaherramientasadmin.php?op=mostrar_elementos_software',
// 		success:function(msg){
// 			datos = JSON.parse(msg)
// 			$(".contenido_libre").html(datos);
			
// 		},
// 		error:function(){
// 			alert("Hay un error...");
// 		}
// 	});
// 	};



// $("#filtro_0").off("click").on("click",function(){
// 	mostrarElementosSoftware();
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
	
		$.post("../controlador/cajaherramientasadmin.php?op=filtrar",{"opcion" : opcion},function(data){
			console.log(data);
			data = JSON.parse(data);
				if(Object.keys(data).length > 0){

					$(".contenido_libre").html(data);
					$(".infoLibro").hide();//se esconde el boton por que nadie puede editarlo y aparace el boton de editar a los usuarios
				$("#opcion").val(data.opcion);
				
			}
		});
	}

init();