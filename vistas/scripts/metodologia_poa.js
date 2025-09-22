var tabla;
function init(){
	listar();
	$("#formularioaccion").on("submit",function(e){
		guardaryeditaraccion(e);	
	});
	$("#formulariocreartarea").on("submit",function(e){
		guardaryeditartarea(e);	
	});
	$.post("../controlador/metodologia_poa.php?op=selectListarCargo", function (r) {
		$("#meta_responsable").html(r);
		$('#meta_responsable').selectpicker('refresh');
	});
}
//Función para mostrar nombre de la meta 
function listar(){
	$.post("../controlador/metodologia_poa.php?op=listar",{ },function(data){
		$("#precarga").hide();
		data = JSON.parse(data);
		$("#contenido").html(data);
	});
}
function agregaraccion(id_meta) {
	$("#id_meta").val(id_meta)
	$("#ModalAccion").modal("show");
}
//Función guardo y edito accion 
function guardaryeditaraccion(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarAccion").prop("disabled",true);
	var formData = new FormData($("#formularioaccion")[0]);
	$.ajax({
		"url": "../controlador/metodologia_poa.php?op=guardaryeditaraccion",
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
			listar();
			$("#btnGuardarAccion").prop("disabled",false);
			$("#ModalAccion").modal("hide");
			$("#formularioaccion")[0].reset();
		}
	});
}
function mostrar_accion(id_accion){
	$.post("../controlador/metodologia_poa.php?op=mostrar_accion",{"id_accion" : id_accion},function(data){
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
function eliminar_accion(id_accion) {
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
			$.post("../controlador/metodologia_poa.php?op=eliminar_accion", { 'id_accion' : id_accion }, function (e) {
				if (e == 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Acción eliminada con éxito.",
						icon: "success"
					});
					// $('#tbllistadometas').DataTable().ajax.reload();
					listar();
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
			$.post("../controlador/metodologia_poa.php?op=terminar_accion", { 'id_accion' : id_accion }, function (e) {
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
// mostramos el formulario para crear la tarea
function CrearTarea(id_accion) {
	$("#id_accion_tarea").val(id_accion)
	$("#ModalCrearTarea").modal("show");
}
//Función guardo y edito tarea
function guardaryeditartarea(e){
	e.preventDefault(); //No se activará la tarea predeterminada del evento
	$("#btnGuardarAccion").prop("disabled",true);
	var formData = new FormData($("#formulariocreartarea")[0]);
	$.ajax({
		"url": "../controlador/metodologia_poa.php?op=guardaryeditartarea",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Tarea Actualizada",
				showConfirmButton: false,
				timer: 1500
			});
			listar();
			$("#ModalCrearTarea").modal("hide");
			$("#formulariocreartarea")[0].reset();
		}
	});
}


function Visualizar_Tareas(id_accion) {
    $("#precarga").show();

    $.post(
        "../controlador/metodologia_poa.php?op=visualizar_tareas",
        { id_accion: id_accion }, 
        function (e) {
            var r = JSON.parse(e);
            $("#myModalMostrarTareas").modal("show");
            $("#listar_tareas_accion").html(r);
            $("#precarga").hide();
            $("#mostrartareas").dataTable({
                dom: "Bfrtip",
                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class="text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
            });
        }
    );
}


function terminar_tarea_accion(id_tarea_sac, id_accion) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de terminar la tarea?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/metodologia_poa.php?op=terminar_tarea_accion", { 'id_tarea_sac' : id_tarea_sac }, function (e) {
				const resultado = JSON.parse(e);
				if (resultado === true) {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Tarea terminada con éxito.",
						icon: "success"
					}).then(() => {
						//refrescamos la tabla de tareas
						Visualizar_Tareas(id_accion);
						listar();
					});
				} else {
					swalWithBootstrapButtons.fire({
						title: "Error!",
						text: "Tarea no se pudo terminar.",
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