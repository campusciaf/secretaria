var tabla;
function init(){
	$("#precarga").hide();
	$("#formularioaccion").on("submit",function(e){
		guardaryeditaraccion(e);	
	});

    // peticion para cargar los usuarios en el select
	$.post("../controlador/metodologia_poa_general.php?op=selectUsuario", function (r) {
		// Inserta la lista de usuarios en el select usuario
		$("#usuario").html(r);
		// refresca el selectpicker para que se actualice con los nuevos datos
		$("#usuario").selectpicker('refresh');
	});
}
//Función para mostrar nombre de la meta 
function listar(id_usuario){

	$.post("../controlador/metodologia_poa_general.php?op=listar",{ id_usuario:id_usuario},function(data){
		$("#precarga").hide();
		data = JSON.parse(data);
		$("#contenido").html(data);
	});
}
function agregaraccion(id_meta,id_usuario) {
	$("#nombre_accion").val("");
	$("#id_usuario").val(id_usuario);
	$("#id_meta").val(id_meta);
	$("#id_accion").val("");
	$("#ModalAccion").modal("show");
}

function editaraccion(id_accion,id_usuario) {
	$.post("../controlador/metodologia_poa_general.php?op=mostrar_accion",{id_accion : id_accion}, function(data, status)
	{
		
		data = JSON.parse(data);	
		$("#id_accion").val(id_accion);
		$("#fecha_fin").val(data.fecha_accion);
		$("#hora_accion").val(data.hora);
		$("#nombre_accion").val(data.nombre_accion);
		$("#id_usuario").val(id_usuario);
		$("#ModalAccion").modal("show");

    });
}





//Función guardo y edito accion 
function guardaryeditaraccion(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarAccion").prop("disabled",true);
	var formData = new FormData($("#formularioaccion")[0]);
	$.ajax({
		"url": "../controlador/metodologia_poa_general.php?op=guardaryeditaraccion",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Acción Actualizada",
				showConfirmButton: false,
				timer: 1500
			});
			id_usuario=$("#id_usuario").val();
			listar(id_usuario);
			$("#btnGuardarAccion").prop("disabled",false);
			$("#ModalAccion").modal("hide");
			$("#formularioaccion")[0].reset();
		}
	});
}
function mostrar_accion(id_accion){
	$.post("../controlador/metodologia_poa_general.php?op=mostrar_accion",{"id_accion" : id_accion},function(data){
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){
			$("#id_accion").val(data.id_accion);
			$("#nombre_accion").val(data.nombre_accion);
			$("#id_meta").val(data.id_meta);
			$("#fecha_accion").val(data.fecha_accion);
			$("#fecha_accion").selectpicker('refresh');
			$("#fecha_fin").val(data.fecha_fin);
			$("#fecha_fin").selectpicker('refresh');
			$("#ModalAccion").modal("show");
		}
	});
}
function eliminar_accion(id_accion,id_usuario) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar la acción?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/metodologia_poa_general.php?op=eliminar_accion", { id_accion : id_accion }, function (e) {
				console.log(e);
				if (e == 'false') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Acción eliminada con éxito.",
						icon: "success"
					});
					// $('#tbllistadometas').DataTable().ajax.reload();

					listar(id_usuario);
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Acción no se puede eliminar.",
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
function terminar_accion(id_accion) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de terminar la acción?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/metodologia_poa_general.php?op=terminar_accion", { 'id_accion' : id_accion }, function (e) {
				if (e == 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Acción Terminada con éxito.",
						icon: "success"
					});
					listar();
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Acción no se puedo terminar.",
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
function iniciarTour() {
	introJs().setOptions({
		"nextLabel": 'Siguiente',
		"prevLabel": 'Anterior',
		"doneLabel": 'Terminar',
		"showBullets": false,
		"showProgress": true,
		"showStepNumbers": true,
		"steps": [
			{
				"title": 'Nombre Proyecto',
				"element": document.querySelector('#nombre_proyecto'),
				"intro": 'Muestra el nombre del proyecto.'
			},
			{
				"title": 'Agregar Acción',
				"element": document.querySelector('#agregar_accion'),
				"intro": 'Agrega una acción al proyecto.'
			},
			{
				"title": 'Estado Acción',
				"element": document.querySelector('#terminar_accion'),
				"intro": 'Aqui puedes terminar, editar la acción y eliminar la acción.'
			},
		]
	},
	).start();
}
init();