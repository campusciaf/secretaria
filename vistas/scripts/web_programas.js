var tabla;
var img_programas;
var id_programas;

function init() {
	// ejecuta la accion para los formularios de guardar y agregar programa
	listarprogramas();
	$("#formularioeditarprogramas").on("submit", function (e) {
		guardaryeditarprogramas(e);
	});

	$("#formularioprograma").on("submit", function (e) {
		agregarprograma(e);
	});
}
//lista los programas
function listarprogramas() {
	$("#precarga").show();
	var meses = new Array(
		"Enero",
		"Febrero",
		"Marzo",
		"Abril",
		"Mayo",
		"Junio",
		"Julio",
		"Agosto",
		"Septiembre",
		"Octubre",
		"Noviembre",
		"Diciembre"
	);
	var diasSemana = new Array(
		"Domingo",
		"Lunes",
		"Martes",
		"Miércoles",
		"Jueves",
		"Viernes",
		"Sábado"
	);
	var f = new Date();
	var fecha_hoy =
		diasSemana[f.getDay()] +
		", " +
		f.getDate() +
		" de " +
		meses[f.getMonth()] +
		" de " +
		f.getFullYear();
	tabla = $("#tbllistaprogramas").dataTable({
		aProcessing: true, //Activamos el procesamiento del datatables
		aServerSide: true, //Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //Definimos los elementos del control de tabla
		buttons: [
			{
				extend: "copyHtml5",
				text: '<i class="fa fa-copy fa-2x" style="color: blue"></i>',
				titleAttr: "Copy",
			},
			{
				extend: "excelHtml5",
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: "Excel",
			},
			{
				extend: "print",
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop:
					'<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' +
					fecha_hoy +
					' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: "Programas",
				titleAttr: "Print",
			},
		],

		ajax: {
			url: "../controlador/web_programas.php?op=listarprogramas",
			type: "get",
			dataType: "json",
			error: function (e) { },
		},
		bDestroy: true,
		iDisplayLength: 30, //Paginación
		order: [[0, "asc"]], //Ordenar (columna,orden)
		initComplete: function (settings, json) {
			$("#precarga").hide();
			$(".prueba_toolimg").tooltip();
		},
	});
}

//muestra los programas con el id del programa para poder editarlo
function mostrar_programas(id_programas) {
	$.post(
		"../controlador/web_programas.php?op=mostrar_programas",
		{ id_programas: id_programas },
		function (data) {
			data = JSON.parse(data);
			if (Object.keys(data).length > 0) {
				$("#id_programas").val(data.id_programas);
				$("#nombre_programa").val(data.nombre_programa);
				$("#snies").val(data.snies);
				$("#frase_programa").val(data.frase_programa);
				$("#guardar_img_programas").val(data.img_programas);
				$("#guardar_img_programas_celular").val(data.img_programas_movil);
				$("#ModalEditarProgramas").modal("show");
				$("#nombre_programa_editar").val(data.nombre_programa);
				$("#snies_editar").val(data.snies);
				$("#frase_programa_editar").val(data.frase_programa);
				$("#guardar_img_programas_editar").val(data.img_programas);
				$("#guardar_imagen_celuar_programa_editar").val(
					data.img_programas_movil
				);
			}
		}
	);
}

//Función limpiar
function limpiar() {
	$("#id_programas").val("");
	$("#titulo_programa").val("");
	$("#subtitulo_programa").val("");
	$("#nombre_programa").val("");
	$("#snies").val("");
	$("#frase_programa").val("");
	$("#guardar_img_programas").val("");
}

function mostraragregarprogramas(flag) {
	if (flag) {
		$("#ModalPrograma").modal("show");
		limpiar();
	}
}

// agrega los programas
function agregarprograma(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioprograma")[0]);
	$.ajax({
		url: "../controlador/web_programas.php?op=agregarprorgama",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			$("#ModalPrograma").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Prorgama Agregado",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistaprogramas").DataTable().ajax.reload();
		},
	});
}

function guardaryeditarprogramas(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioeditarprogramas")[0]);
	$.ajax({
		url: "../controlador/web_programas.php?op=guardaryeditarprogramas",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			$("#ModalEditarProgramas").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Prorgama Editado",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistaprogramas").DataTable().ajax.reload();
		},
	});
}

function eliminar_programas(
	id_programas,
	imagen_eliminar,
	img_programas_movil
) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de eliminar el Programa?",
			text: "¡No podrás revertir esto!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes, continuar!",
			cancelButtonText: "No, cancelar!",
			reverseButtons: true,
		})
		.then((result) => {
			if (result.isConfirmed) {
				$.post(
					"../controlador/web_programas.php?op=eliminar_programas",
					{
						id_programas: id_programas,
						imagen_eliminar: imagen_eliminar,
						img_programas_movil: img_programas_movil,
					},
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Programa eliminada con éxito.",
								icon: "success",
							});
							$("#tbllistaprogramas").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Programa no se puede eliminar.",
								icon: "error",
							});
						}
					}
				);
			} else if (
				/* Read more about handling dismissals below */
				result.dismiss === Swal.DismissReason.cancel
			) {
				swalWithBootstrapButtons.fire({
					title: "Cancelado",
					text: "Tu proceso está a salvo :)",
					icon: "error",
				});
			}
		});
}

function desactivar_programas(id_programas) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de desactivar el Programa?",
			text: "¡No podrás revertir esto!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes, continuar!",
			cancelButtonText: "No, cancelar!",
			reverseButtons: true,
		})
		.then((result) => {
			if (result.isConfirmed) {
				$.post(
					"../controlador/web_programas.php?op=desactivar_programas",
					{ id_programas: id_programas },
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Programa desactivado con éxito.",
								icon: "success",
							});
							$("#tbllistaprogramas").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Programa no se puede desactivar.",
								icon: "error",
							});
						}
					}
				);
			} else if (
				/* Read more about handling dismissals below */
				result.dismiss === Swal.DismissReason.cancel
			) {
				swalWithBootstrapButtons.fire({
					title: "Cancelado",
					text: "Tu proceso está a salvo :)",
					icon: "error",
				});
			}
		});
}

function activar_programas(id_programas) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de activar el Programa?",
			text: "¡No podrás revertir esto!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes, continuar!",
			cancelButtonText: "No, cancelar!",
			reverseButtons: true,
		})
		.then((result) => {
			if (result.isConfirmed) {
				$.post(
					"../controlador/web_programas.php?op=activar_programas",
					{ id_programas: id_programas },
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Programa activado con éxito.",
								icon: "success",
							});
							$("#tbllistaprogramas").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Programa no se puede activar.",
								icon: "error",
							});
						}
					}
				);
			} else if (
				/* Read more about handling dismissals below */
				result.dismiss === Swal.DismissReason.cancel
			) {
				swalWithBootstrapButtons.fire({
					title: "Cancelado",
					text: "Tu proceso está a salvo :)",
					icon: "error",
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
				"title": 'Agregar Programa',
				"element": document.querySelector('#tour_mostrar_agregar_programas'),
				"intro": 'Agrega el programa en la pagina web.'
			},
			{
				"title": 'Opciones',
				"element": document.querySelector('#tour_opciones'),
				"intro": 'Columna donde puedes <span class="badge badge-primary p-1">editar</span>, <span class="badge badge-success p-1">desactivar</span> y <span class="badge badge-secondary p-1">activar</span> el programa.'
			},
			{
				"title": 'Imagen Escritorio',
				"element": document.querySelector('#tour_imagen_escritorio'),
				"intro": 'Muestra la imagen para escritorio que debe ser de 1728x724.'
			},
			{
				"title": 'Imagen Celular',
				"element": document.querySelector('#tour_imagen_celular'),
				"intro": 'Columna donde muestra la imagen para el celular que debe ser de 428x400.'
			},
			{
				"title": 'Nombre de Programa',
				"element": document.querySelector('#tour_nombre_programa'),
				"intro": 'Columna donde muestra el nombre del programa.'
			},
			{
				"title": 'Snies',
				"element": document.querySelector('#tour_snies'),
				"intro": 'Columna donde muestra el snies del programa.'
			},
			{
				"title": 'Frase del programa',
				"element": document.querySelector('#tour_frase_del_programa'),
				"intro": 'Columna donde muestra la frase del programa.'
			},
			{
				"title": 'Estado',
				"element": document.querySelector('#tour_estado'),
				"intro": 'Columna donde muestra el estado del programa, ya sea si esta <span class="badge badge-success p-1">activada</span> o <span class="badge badge-danger p-1">desactivado</span>'
				
			},
			
		]
	},
	).start();
}



init();
