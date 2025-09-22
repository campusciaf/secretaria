var tabla;
var img_noticias;
var id_noticias;
var url_video_ok_global;

function init() {
	CKEDITOR.replace('contenido_noticias_editar');
	CKEDITOR.replace('contenido_noticias_video');
	CKEDITOR.replace('contenido_noticias_imagen');
	
	
	listarnoticias();
	$("#formularioeditarnoticias").on("submit", function (e) {
		guardaryeditarnoticias(e);
	});

	$("#formulariovideo").on("submit", function (e) {
		agregarvideo(e);
	});

	$("#formularioagregarimagen").on("submit", function (e) {
		agregarimagen(e);
	});

	$.post("../controlador/web_noticias.php?op=Categoria_noticia", function (r) {
		$("#categoria_noticias").html(r);
		$("#categoria_noticias").selectpicker("refresh");
	});

	$.post("../controlador/web_noticias.php?op=Categoria_video", function (r) {
		$("#categoria_noticias_video").html(r);
		$("#categoria_noticias_video").selectpicker("refresh");
	});

	$.post("../controlador/web_noticias.php?op=Categoria_video", function (r) {
		$("#categoria_noticias_imagen").html(r);
		$("#categoria_noticias_imagen").selectpicker("refresh");
	});
}

function listarnoticias() {
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
	tabla = $("#tbllistanoticias").dataTable({
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
				title: "Noticias",
				titleAttr: "Print",
			},
		],

		ajax: {
			url: "../controlador/web_noticias.php?op=listarnoticias",
			type: "get",
			dataType: "json",
			error: function (e) { },
		},
		bDestroy: true,
		iDisplayLength: 10, //Paginación
		order: [[0, "asc"]], //Ordenar (columna,orden)
		initComplete: function (settings, json) {
			$("#precarga").hide();
			$(".prueba_toolimg").tooltip();
		},
	});
}

//Función limpiar
function limpiar() {
	$("#id_noticias").val("");
	$("#titulo_noticias").val("");
	$("#subtitulo_noticias").val("");
	$("#contenido_noticias").val("");
	$("#muestra_noticia").attr("src", " ");
	$("#guardaimagennoticia").val("");
	$("#material").val("");
}

function limpiar_imagen() {
	$("#id_noticias").val("");
	$("#titulo_noticias_imagen").val("");
	$("#subtitulo_noticias_imagen").val("");
	$("#contenido_noticias_imagen").val("");
	$("#mostrar_video_noticia").attr("src", " ");
	$("#guardaimagennoticia").val("");
	$("#categoria_noticias_imagen").val("");
	$("#agregar_imagen").val("");
	$("#agregar_editar_imagen").val("");
	$("#material_imagen").val("");
}

function mostrar_noticias(id_noticias) {
	id_noticias_global = id_noticias;
	$.post(
		"../controlador/web_noticias.php?op=mostrar_noticias",
		{ id_noticias: id_noticias },
		function (data) {
			imagenyvideo(id_noticias);
			data = JSON.parse(data);
			if (Object.keys(data).length > 0) {
				$("#id_noticias").val(data.id_noticias);
				$("#titulo_noticias").val(data.titulo_noticias);
				$("#subtitulo_noticias").val(data.subtitulo_noticias);
				$("#categoria_noticias").val(data.id_categoria_noticias);
				$("#categoria_noticias").selectpicker("refresh");
				// $("#contenido_noticias_editar").val(data.contenido_noticias);
				CKEDITOR.instances.contenido_noticias_editar.setData(data.contenido_noticias);
				$("#link_noticia_imagen_editar").val(data.link_noticia);
				$("#imageneditarguardar").val(data.img_noticias);
				$("#material_estado").val(data.material);
				$("#ModalEditarNoticias").modal("show");
			}
		}
	);
}

function mostrar_video(id_noticias) {
	$.post(
		"../controlador/web_noticias.php?op=mostrar_video",
		{ id_noticias: id_noticias },
		function (data) {
			data = JSON.parse(data);
			if (Object.keys(data).length > 0) {
				$("#id_noticias_video").val(data.id_noticias);
				$("#titulo_noticias_video").val(data.titulo_noticias);
				$("#subtitulo_noticias_video").val(data.subtitulo_noticias);
				// $("#contenido_noticias_video").val(data.contenido_noticias);
				CKEDITOR.instances.contenido_noticias_video.setData(data.contenido_noticias);
				$("#url_video").val(data.url_video);
				$("#agregar_imagen_con_video").val(data.img_noticias);
				$("#categoria_noticias_video").val(data.id_categoria_noticias);
				$("#categoria_noticias_video").selectpicker("refresh");
				$("#agregar_video").val(data.img_noticias);
				$("#ModalVideo").modal("show");
			}
		}
	);
}

function mostrar_imagen(id_noticias) {
	$("#ModalVideo").modal("show");
	$.post(
		"../controlador/web_noticias.php?op=mostrar_imagen",
		{ id_noticias: id_noticias },
		function (data) {
			data = JSON.parse(data);
			if (Object.keys(data).length > 0) {
				$("#id_noticias_video").val(data.id_noticias);
				$("#titulo_noticias_imagen").val(data.titulo_noticias);
				$("#subtitulo_noticias_imagen").val(data.subtitulo_noticias);
				$("#contenido_noticias_imagen").val(data.contenido_noticias);
				$("#mostrar_video_noticia").val(data.url_video);
				$("#categoria_noticias_imagen").val(data.id_categoria_noticias);
				$("#categoria_noticias_imagen").selectpicker("refresh");
				$("#agregar_imagen").val(data.img_noticias);
				$("#agregar_editar_imagen").val(data.img_noticias);
				$("#agregar_editar_imagen_video").val(data.img_noticias);
				$("#material_imagen").val(data.material);
			}
		}
	);
}

function mostraragregarvideo(flag) {
	if (flag) {
		$("#ModalVideo").modal("show");
		limpiar();
	}
}
function agregarvideo(e) {
	var text = CKEDITOR.instances['contenido_noticias_video'].getData();// captura el valor del editor
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulariovideo")[0]);
	formData.append("contenido_noticias_video", text); // enviamos el contenido del editor
	$.ajax({
		url: "../controlador/web_noticias.php?op=agregarvideo",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			$("#ModalVideo").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Video Actualizado",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistanoticias").DataTable().ajax.reload();
		},
	});
}

function agregarimagen(e) {
	var text = CKEDITOR.instances['contenido_noticias_imagen'].getData();// captura el valor del editor
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioagregarimagen")[0]);
	formData.append("contenido_noticias_imagen", text); // enviamos el contenido del editor
	
	$.ajax({
		url: "../controlador/web_noticias.php?op=agregarimagen",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			$("#ModalImagen").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Noticia Actualizada",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistanoticias").DataTable().ajax.reload();
		},
	});
}

function mostraragregarimagen(flag) {
	if (flag) {
		$("#ModalImagen").modal("show");
		limpiar_imagen();
	}
}
function guardaryeditarnoticias(e) {
	var text = CKEDITOR.instances['contenido_noticias_editar'].getData();// captura el valor del editor
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioeditarnoticias")[0]);
	formData.append("contenido_noticias_editar", text); // enviamos el contenido del editor
	
	$.ajax({
		url: "../controlador/web_noticias.php?op=guardaryeditarnoticias",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			$("#ModalEditarNoticias").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Noticia Actualizada",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistanoticias").DataTable().ajax.reload();
		},
	});
}

function eliminar_noticia(id_noticias, img_noticias) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de eliminar la noticia?",
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
					"../controlador/web_noticias.php?op=eliminar_noticia",
					{ id_noticias: id_noticias, img_noticias: img_noticias },
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Noticia eliminada con éxito.",
								icon: "success",
							});
							$("#tbllistanoticias").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Noticia no se puede eliminar.",
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
function desactivar_noticia(id_noticias) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de desactivar la noticia?",
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
					"../controlador/web_noticias.php?op=desactivar_noticia",
					{ id_noticias: id_noticias },
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Noticia desactivar con éxito.",
								icon: "success",
							});

							$("#tbllistanoticias").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Noticia no se puede desactivar.",
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
function activar_noticia(id_noticias) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de activar la Noticia?",
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
					"../controlador/web_noticias.php?op=activar_noticia",
					{ id_noticias: id_noticias },
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Noticia Activada con éxito.",
								icon: "success",
							});

							$("#tbllistanoticias").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Noticia no se puede activar.",
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
function imagenyvideo(id_noticias) {
	$.post(
		"../controlador/web_noticias.php?op=imagenyvideo",
		{ id_noticias: id_noticias },
		function (data) {
			data = JSON.parse(data);
			$("#imagen_noticias").val(data.img_noticias);
			$("#imagen_noticias_video").val(data.img_noticias);
			$("#videoeimagen").show();
			$("#videoeimagen").html(data);
		}
	);
}

function ver_video(id_noticias) {
	$.post(
		"../controlador/web_noticias.php?op=ver_video",
		{ id_noticias: id_noticias },
		function (data) {
			data = JSON.parse(data);
			$("#ModalVerVideo").modal("show");
			$("#mostar_video_modal").show();
			$("#mostar_video_modal").html(data);
		}
	);
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
				"title": 'Agregar Noticia Con video',
				"element": document.querySelector('#tour_agregar_noticia_video'),
				"intro": 'Agrega la noticia solo con video.'
			},
			{
				"title": 'Agregar Noticia Con imagen',
				"element": document.querySelector('#tour_agregar_noticia_imagen'),
				"intro": 'Agrega la noticia solo con imagen.'
			},
			{
				"title": 'Opciones',
				"element": document.querySelector('#tour_opciones'),
				"intro": 'Columna donde puedes  <span class="badge badge-primary p-1">editar</span>, <span class="badge badge-danger p-1">eliminar</span> , <span class="badge badge-success p-1">desactivar</span> y <span class="badge badge-secondary p-1">activar</span> la noticia.'
			},
			{
				"title": 'Imagen',
				"element": document.querySelector('#tour_imagen'),
				"intro": 'Columna donde muestra la imagen que se va a mostrar en la noticia de la pagina web.'
			},
			{
				"title": 'Video',
				"element": document.querySelector('#tour_video'),
				"intro": 'Columna donde muestra un modal donde contiene el video que se va visualizar en la pagina web.'
			},
			{
				"title": 'Título',
				"element": document.querySelector('#tour_titulo'),
				"intro": 'Columna donde muestra el titulo de la noticia en la pagina web.'
			},
			{
				"title": 'Subtítulo',
				"element": document.querySelector('#tour_subtitulo'),
				"intro": 'Columna donde muestra el subtítulo de la noticia.'
			},
			{
				"title": 'Contenido',
				"element": document.querySelector('#tour_contenido'),
				"intro": 'Columna donde muestra el contenido de la noticia.'
			},
			{
				"title": 'Formato Noticia',
				"element": document.querySelector('#tour_formato_noticia'),
				"intro": 'Columna donde muestra el formato de la noticia ya sea <span class="badge badge-warning p-1">video</span>  o  <span class="badge badge-primary p-1">imagen</span>'
			},
			{
				"title": 'Estado',
				"element": document.querySelector('#tour_estado'),
				"intro": 'Columna donde muestra el estado de la noticia, ya sea si esta <span class="badge badge-primary p-1">activada</span> o <span class="badge badge-danger p-1">desactivado</span>'
			},
			
		]
	},
	).start();
}

init();
