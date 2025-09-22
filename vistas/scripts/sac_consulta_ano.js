var tabla;
var fechaActual = new Date(); 
var anoActual = fechaActual.getFullYear();

function init(){
	buscar(anoActual);

	$("#formularioaccion").on("submit",function(e){
		guardaryeditaraccion(e);	
	});
	
}
function buscar(fecha_ano) {
    $.post("../controlador/sac_consulta_ano.php?op=buscar", {"fecha_ano": fecha_ano}, function(data) {
        $("#precarga").hide();
		data = JSON.parse(data);
		$("#contenido").html(data[0]);
    });
}
function agregaraccion(id_meta) {
	$("#id_meta").val(id_meta)
	$("#ModalAccion").modal("show");	
}

function guardaryeditaraccion(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarAccion").prop("disabled",true);
	var formData = new FormData($("#formularioaccion")[0]);
	$.ajax({
		"url": "../controlador/sac_consulta_ano.php?op=guardaryeditaraccion",
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
			buscar($("#fecha_ano").val());
			$("#btnGuardarAccion").prop("disabled",false);
			$("#ModalAccion").modal("hide");
			$("#formularioaccion")[0].reset();
		}
	});
}
function mostrar_accion(id_accion){
	$.post("../controlador/sac_consulta_ano.php?op=mostrar_accion",{"id_accion" : id_accion},function(data){
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){
			$("#id_accion").val(data.id_accion);
			$("#nombre_accion").val(data.nombre_accion);
			$("#id_meta").val(data.id_meta);
			$("#fecha_accion").val(data.fecha_accion);
			$("#fecha_accion").selectpicker('refresh');
			$("#fecha_fin").val(data.fecha_fin);
			$("#hora_accion").val(data.hora);
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
			$.post("../controlador/sac_consulta_ano.php?op=eliminar_accion", { 'id_accion' : id_accion }, function (e) {
				if (e !== 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Acción eliminada con éxito.",
						icon: "success"
					});
					buscar($("#fecha_ano").val());
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
			$.post("../controlador/sac_consulta_ano.php?op=terminar_accion", { 'id_accion' : id_accion }, function (e) {
				if (e !== 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Acción Terminada con éxito.",
						icon: "success"
					});
					buscar($("#fecha_ano").val());
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
				"title": 'Filtro año',
				"element": document.querySelector('#tour_buscar'),
				"intro": 'Filtro por medio de año'
			},
			{
				"title": 'Nombre proyecto',
				"element": document.querySelector('#tour_proyecto'),
				"intro": 'Muestra el nombre del proyecto'
			},
			
		]
	},
	).start();ww
}
init();

