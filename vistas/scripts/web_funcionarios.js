var tabla;
var nuevoValor;



function init(){
	$("#formularioeditarfuncionario").on("submit",function(e){
		guardaryeditarfuncionario(e);	
	});
	$.post("../controlador/web_funcionarios.php?op=selectFuncionarios", function (r) {
		$("#selec_funcionarios").html(r);
		$('#selec_funcionarios').selectpicker('refresh');
	});
	mostrar_funcionarios();
}


function mostrar_funcionarios(){
	$("#precarga").show();
	$.post("../controlador/web_funcionarios.php?op=mostrar_funcionarios",{},function(data){
		// console.log(data);
		data = JSON.parse(data);
		$("#mostrar_funcionarios").show();
		$("#mostrar_funcionarios").html(data);
		$("#precarga").hide();
	});
}

function editar_funcionario(id_web_cargos){
	$("#id_web_cargos").val(id_web_cargos);
	$("#ModalEditarFuncionario").modal("show");
}

//Función guardo y edito accion 
function guardaryeditarfuncionario(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioeditarfuncionario")[0]);
	$.ajax({
		"url": "../controlador/web_funcionarios.php?op=guardaryeditarfuncionario",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Funcionario Actualizado",
				showConfirmButton: false,
				timer: 1500
			});
			mostrar_funcionarios();
			// 
			$("#ModalEditarFuncionario").modal("hide");
		}
	});
}

function removerCargo(id_cargo_web_usuario) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar el funcionario?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/web_funcionarios.php?op=removerCargo", { id_cargo_web_usuario: id_cargo_web_usuario }, function (e) {
				if (e == 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Funcionario eliminado con éxito.",
						icon: "success"
					});
					mostrar_funcionarios();
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Funcionario no se puede eliminar.",
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
				"title": 'Cargo',
				"element": document.querySelector('#tour_cargo_funcionario'),
				"intro": 'Muestra el cargo actual del funcionario para la pagina web.'
			},
			{
				"title": 'Editar Funcionario',
				"element": document.querySelector('#tour_editar_funcionario'),
				"intro": 'Edita y agrega el funcionario para su respectivo cargo para la pagina web.'
			},
			{
				"title": 'Eliminar Funcionario',
				"element": document.querySelector('#tour_eliminar_funcionario'),
				"intro": 'Elimina el funcionario para su respectivo cargo para la pagina web.'
			},
		]
	},
	).start();
}

init();