var tabla;
var blog_img;
var id_blog;
var url_video_ok_global;

function init() {
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

	// $.post("../controlador/mi_blog.php?op=Categoria_noticia", function (r) {
	// 	$("#categoria_blog").html(r);
	// 	$("#categoria_blog").selectpicker("refresh");
	// });

	$.post("../controlador/mi_blog.php?op=Categoria_video", function (r) {
		$("#categoria_blog_video").html(r);
		$("#categoria_blog_video").selectpicker("refresh");
	});

	$.post("../controlador/mi_blog.php?op=Categoria_video", function (r) {
		$("#categoria_blog_imagen").html(r);
		$("#categoria_blog_imagen").selectpicker("refresh");
	});
	// contenido_blog_editar

	
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
			url: "../controlador/mi_blog.php?op=listarnoticias",
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
	$("#id_blog_video").val("");
	$("#titulo_blog_video").val("");
	$("#subtitulo_blog_video").val("");
	$("#url_video").val("");
	$("#link_noticia_video").val("");
	$("#editarvideoguardarconvideo").val("");
}

function limpiar_imagen() {
	$("#id_blog").val("");
	$("#titulo_blog_imagen").val("");
	$("#subtitulo_blog_imagen").val("");
	$("#subtitulo_blog_imagen").val("");
	$("#link_noticia_imagen").val("");
	$("#agregar_imagen").val("");

}

function mostrar_blog(id_blog) {
	id_blog_global = id_blog;
	$.post(
		"../controlador/mi_blog.php?op=mostrar_blog",
		{ id_blog: id_blog },
		function (data) {
			imagenyvideo(id_blog);
			data = JSON.parse(data);
			if (Object.keys(data).length > 0) {
				$("#id_blog").val(data.id_blog);
				$("#titulo_blog").val(data.titulo_blog);
				$("#subtitulo_blog").val(data.subtitulo_blog);
				$("#contenido_blog_editar").val(data.contenido_blog);
				$("#link_noticia_imagen_editar").val(data.link_blog);
				$("#imageneditarguardar").val(data.blog_img);
				$("#material_estado").val(data.material);
				$("#ModalEditarNoticias").modal("show");

				// if (CKEDITOR.instances['contenido_blog_editar']) {
                //     CKEDITOR.instances['contenido_blog_editar'].destroy();
                // }
				// CKEDITOR.replace('contenido_blog_editar', {
				// 	width: '100%',
				// 	// Configura la altura específica si lo deseas
				// 	height: 300
				// });

				if (CKEDITOR.instances['contenido_blog_editar']) {
					CKEDITOR.instances['contenido_blog_editar'].destroy();
				}
				CKEDITOR.replace('contenido_blog_editar', {
					width: '100%',
					height: 300
				});
				// Espera a que CKEditor esté listo y luego establece el contenido
				CKEDITOR.instances['contenido_blog_editar'].setData(data.contenido_blog);
			}
		}
	);
}

function mostrar_video(id_blog) {
	$.post(
		"../controlador/mi_blog.php?op=mostrar_video",
		{ id_blog: id_blog },
		function (data) {
			data = JSON.parse(data);
			if (Object.keys(data).length > 0) {
				$("#id_blog_video").val(data.id_blog);
				$("#titulo_blog_video").val(data.titulo_blog);
				$("#subtitulo_blog_video").val(data.subtitulo_blog);
				$("#contenido_blog_video").val(data.contenido_blog);
				$("#url_video").val(data.url_video);
				$("#agregar_imagen_con_video").val(data.blog_img);
				$("#agregar_video").val(data.blog_img);
				$("#ModalVideo").modal("show");

				if (CKEDITOR.instances['contenido_blog_video']) {
                    CKEDITOR.instances['contenido_blog_video'].destroy();
                }


				CKEDITOR.replace('contenido_blog_video', {
					width: '100%',
					// Configura la altura específica si lo deseas
					height: 300
				});
				CKEDITOR.instances['contenido_blog_video'].setData(data.contenido_blog);

				
			}
		}
	);
}

function mostrar_imagen(id_blog) {
	$("#ModalVideo").modal("show");
	$.post(
		"../controlador/mi_blog.php?op=mostrar_imagen",
		{ id_blog: id_blog },
		function (data) {
			data = JSON.parse(data);
			if (Object.keys(data).length > 0) {
				$("#id_blog_video").val(data.id_blog);
				$("#titulo_blog_imagen").val(data.titulo_blog);
				$("#subtitulo_blog_imagen").val(data.subtitulo_blog);
				$("#contenido_blog_imagen").val(data.contenido_blog);
				$("#mostrar_video_noticia").val(data.url_video);
				$("#agregar_imagen").val(data.blog_img);
				$("#agregar_editar_imagen").val(data.blog_img);
				$("#agregar_editar_imagen_video").val(data.blog_img);
				$("#material_imagen").val(data.material);

		


			}
		}
	);
}

function mostraragregarvideo(flag) {
	if (flag) {
		$("#ModalVideo").modal("show");
		limpiar();
		if (CKEDITOR.instances['contenido_blog_video']) {
            CKEDITOR.instances['contenido_blog_video'].destroy();
        }
		CKEDITOR.replace('contenido_blog_video', {
			width: '100%',
			// Configura la altura específica si lo deseas
			height: 300
		});
	}
}
function agregarvideo(e) {
	e.preventDefault();
	var contenido_blog_video = CKEDITOR.instances.contenido_blog_video.getData();
	$("#contenido_blog_video").val(contenido_blog_video);

	var formData = new FormData($("#formulariovideo")[0]);
	$.ajax({
		url: "../controlador/mi_blog.php?op=agregarvideo",
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
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var contenido_blog_imagen = CKEDITOR.instances.contenido_blog_imagen.getData();
	$("#contenido_blog_imagen").val(contenido_blog_imagen);
	var formData = new FormData($("#formularioagregarimagen")[0]);
	$.ajax({
		url: "../controlador/mi_blog.php?op=agregarimagen",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			$("#ModalImagen").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Blog Agregado",
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
		if (CKEDITOR.instances['contenido_blog_imagen']) {
            CKEDITOR.instances['contenido_blog_imagen'].destroy();
        }
		CKEDITOR.replace('contenido_blog_imagen', {
			width: '100%',
			// Configura la altura específica si lo deseas
			height: 300
		});
	}
}
function guardaryeditarnoticias(e) {

	e.preventDefault(); //No se activará la acción predeterminada del evento
	var contenido_blog_editar = CKEDITOR.instances.contenido_blog_editar.getData();
	$("#contenido_blog_editar").val(contenido_blog_editar);
	var formData = new FormData($("#formularioeditarnoticias")[0]);
	$.ajax({
		url: "../controlador/mi_blog.php?op=guardaryeditarnoticias",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			 $("#ModalEditarNoticias").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Blog Actualizada",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistanoticias").DataTable().ajax.reload();
		},
	});
}

function eliminar_blog(id_blog, blog_img) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de eliminar el blog?",
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
					"../controlador/mi_blog.php?op=eliminar_blog",
					{ id_blog: id_blog, blog_img: blog_img },
					function (e) {
                        data = JSON.parse(e);
						if (data == null) {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Blog eliminado con éxito.",
								icon: "success",
							});
							$("#tbllistanoticias").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Blog no se puede eliminar.",
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
function desactivar_noticia(id_blog) {
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
					"../controlador/mi_blog.php?op=desactivar_noticia",
					{ id_blog: id_blog },
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Blog desactivar con éxito.",
								icon: "success",
							});

							$("#tbllistanoticias").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Blog no se puede desactivar.",
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
function activar_noticia(id_blog) {
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
					"../controlador/mi_blog.php?op=activar_noticia",
					{ id_blog: id_blog },
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Blog Activada con éxito.",
								icon: "success",
							});

							$("#tbllistanoticias").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Blog no se puede activar.",
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
function imagenyvideo(id_blog) {
	$.post(
		"../controlador/mi_blog.php?op=imagenyvideo",
		{ id_blog: id_blog },
		function (data) {
			data = JSON.parse(data);
			$("#imagen_blog").val(data.blog_img);
			$("#imagen_blog_video").val(data.blog_img);
			$("#videoeimagen").show();
			$("#videoeimagen").html(data);
		}
	);
}

function ver_video(id_blog) {
	$.post(
		"../controlador/mi_blog.php?op=ver_video",
		{ id_blog: id_blog },
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
				"title": 'Agregar Blog Con video',
				"element": document.querySelector('#tour_agregar_noticia_video'),
				"intro": 'Agrega la Blog solo con video.'
			},
			{
				"title": 'Agregar Blog Con imagen',
				"element": document.querySelector('#tour_agregar_noticia_imagen'),
				"intro": 'Agrega la Blog solo con imagen.'
			},
			{
				"title": 'Opciones',
				"element": document.querySelector('#tour_opciones'),
				"intro": 'Columna donde puedes  <span class="badge badge-primary p-1">editar</span>, <span class="badge badge-danger p-1">eliminar</span> , <span class="badge badge-success p-1">desactivar</span> y <span class="badge badge-secondary p-1">activar</span> el blog.'
			},
			{
				"title": 'Imagen',
				"element": document.querySelector('#tour_imagen'),
				"intro": 'Columna donde muestra la imagen que se va a mostrar en el Blog de la pagina web.'
			},
			{
				"title": 'Video',
				"element": document.querySelector('#tour_video'),
				"intro": 'Columna donde muestra un modal donde contiene el video que se va visualizar en la pagina web.'
			},
			{
				"title": 'Título',
				"element": document.querySelector('#tour_titulo'),
				"intro": 'Columna donde muestra el titulo del Blog en la pagina web.'
			},
			{
				"title": 'Subtítulo',
				"element": document.querySelector('#tour_subtitulo'),
				"intro": 'Columna donde muestra el subtítulo del blog.'
			},
			{
				"title": 'Contenido',
				"element": document.querySelector('#tour_contenido'),
				"intro": 'Columna donde muestra el contenido del blog.'
			},
			{
				"title": 'Formato Noticia',
				"element": document.querySelector('#tour_formato_noticia'),
				"intro": 'Columna donde muestra el formato de la Blog ya sea <span class="badge badge-warning p-1">video</span>  o  <span class="badge badge-primary p-1">imagen</span>'
			},
			{
				"title": 'Estado',
				"element": document.querySelector('#tour_estado'),
				"intro": 'Columna donde muestra el estado del blog, ya sea si esta <span class="badge badge-primary p-1">activada</span> o <span class="badge badge-danger p-1">desactivado</span>'
			},
			
		]
	},
	).start();
}

init();
