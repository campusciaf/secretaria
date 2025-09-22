var tabla;
var img_programas;
var id_web_programa_descripcion;
var id_programa;
var tabla_acciones;

function init(){
	// ejecuta la accion para los formularios de guardar y agregar programa
	listarprogramas();
	$("#formularioeditarprogramas").on("submit",function(e){
		guardaryeditarprogramas(e);	
	});

	$("#formularioprograma").on("submit",function(e){
		agregarprograma(e);	
	});

	$("#formulariodesempenate").on("submit",function(e){
		agregarprogramadesempenate(e);
		
	});

	$("#formularioeditardesem").on("submit",function(e){
		guardaryeditardesempenate(e);
		
	});

	$.post("../controlador/web_programa_descripcion.php?op=Categoria_video", function(r){
		$("#categoria_noticias_video").html(r);
		$('#categoria_noticias_video').selectpicker('refresh');
	});
	
	$.post("../controlador/web_programa_descripcion.php?op=Categoria_video", function(r){
		$("#categoria_noticias_video_editar").html(r);
		$('#categoria_noticias_video_editar').selectpicker('refresh');
	});

	$.post("../controlador/web_programa_descripcion.php?op=Categoria_Prorgama", function(r){
		$("#categoria_programas").html(r);
		$('#categoria_programas').selectpicker('refresh');
	});
	$.post("../controlador/web_programa_descripcion.php?op=Categoria_Prorgama", function(r){
		$("#categoria_programas_editar").html(r);
		$('#categoria_programas_editar').selectpicker('refresh');
	});
	
}

//lista los programas
function listarprogramas(){
	$("#precarga").show();

	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistaprogramas').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		buttons: [
			{
				extend:    'copyHtml5',
				text:      '<i class="fa fa-copy fa-2x" style="color: blue"></i>',
				titleAttr: 'Copy'
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Programas',
				titleAttr: 'Print'
			},
		],
		
		"ajax":{ url: '../controlador/web_programa_descripcion.php?op=listarprogramas', type : "get", dataType : "json",						
		error: function(e){
		}
	},
	"bDestroy": true,
	"iDisplayLength": 10,//Paginación
	"order": [[ 0, "asc" ]],//Ordenar (columna,orden)
	'initComplete': function (settings, json) {
			$("#precarga").hide();
			$(".prueba_toolimg").tooltip();
			$(".tooltip-agregar").tooltip();
		},
	});
}

//muestra los programas con el id del Descripción para poder editarlo
function mostrar_programas_descripcion(id_web_programa_descripcion){
	imagenyvideo(id_web_programa_descripcion);
	$.post("../controlador/web_programa_descripcion.php?op=mostrar_programas_descripcion",{"id_web_programa_descripcion" : id_web_programa_descripcion},function(data){
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){

			$("#id_web_programa_descripcion_editar").val(data.id_web_programa_descripcion);
			$("#titulo_descripcion_editar").val(data.titulo_descripcion);
			$("#descripcion_programa_editar").val(data.descripcion_programa);
			$("#url_video_editar").val(data.video_descripcion);
			$("#categoria_noticias_video_editar").val(data.id_programa_desempenate);
			$("#categoria_noticias_video_editar").selectpicker('refresh');
			$("#id_programa").val(data.id_programas);
			$("#categoria_programas_editar").val(data.id_programas);
			$("#categoria_programas_editar").selectpicker('refresh');
			$("#guardar_img_programas_editar").val(data.imagen_descripcion);
			$("#ModalEditarProgramas").modal("show");

		}
	});

	
}
function mostrar_programas_desempenate(id_web_programa_descripcion,id_programa){
	$.post("../controlador/web_programa_descripcion.php?op=mostrar_programas_descripcion",{"id_web_programa_descripcion" : id_web_programa_descripcion, "id_programa" : id_programa},function(data){
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){				
			$("#id_programa").val(data.id_programas);
			$("#id_desempenate_descripcion").val(data.id_web_programa_descripcion);
			$("#Modaldesempenate").modal("show");
			limpiar_desempenate();
			desempenatemodal(id_programa);



		}
	});

	
}
function mostrar_modal_desempenate(id_programa_desempenate){
	$.post("../controlador/web_programa_descripcion.php?op=mostrar_desempenate_editar",{"id_programa_desempenate" : id_programa_desempenate},function(data){
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){		
			$("#nombre_desempenate_editar").val(data.nombre_desempenate);
			$("#id_programa_editar").val(data.id_programa);
			$("#id_desempenate_descripcion_editar").val(data.id_programa_desempenate);
			$("#Modaldesempenateeditar").modal("show");
			$("#Modaldesempenate").modal("hide");


		}
	});

	
}

function limpiar_desempenate()
{
	$("#nombre_desempenate").val("");

}

//Función limpiar
function limpiar()
{
	$("#id_web_programa_descripcion").val("");
	$("#titulo_programa").val("");
	$("#subtitulo_programa").val("");
	$("#nombre_programa").val("");
	$("#snies").val("");
	$("#frase_programa").val("");
	$("#guardar_img_programas").val("");
	
	$("#titulo_descripcion").val("");
	$("#descripcion_programa").val("");
	$("#url_video").val("");
	$("#agregar_imagen_descripcion").val("");


}
function mostraragregarprogramas(flag)
{
	if (flag)
	{
		$("#ModalPrograma").modal("show");
		limpiar();
	}
	
}

// agrega los programas
function agregarprograma(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioprograma")[0]);
	$.ajax({
		"url": "../controlador/web_programa_descripcion.php?op=agregarprorgama",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			$("#ModalPrograma").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Programa Desempeñate Agregado",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistaprogramas").DataTable().ajax.reload();
			
		}
	});
}





function listarmetas(id_ejes) {
	

	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistadometa').dataTable({

		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Print'
			},
		],

		"ajax": {
			url: '../controlador/sac_proyecto.php?op=listarmetas&id_ejes=' + id_ejes,
			type: "get",
			dataType: "json",
			data: {"globalperidioseleccionado": globalperidioseleccionado}, // Incluido como parte de los datos

			error: function (e) {
				console.log(e);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[0, "asc"]],//Ordenar (columna,orden)
		'initComplete': function (settings, json) {
			$("#precarga").hide();
		},
	});
}


// agrega los programas
function agregarprogramadesempenate(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulariodesempenate")[0]);
	$.ajax({
		"url": "../controlador/web_programa_descripcion.php?op=agregarprorgamadesempenate",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Programa Desempeñate Editado",
				showConfirmButton: false,
				timer: 1500,
			});
			var idprograma = $('#id_programa').val();
			desempenatemodal(idprograma);

			
		}
	});
}

function guardaryeditarprogramas(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioeditarprogramas")[0]);
	$.ajax({
		"url": "../controlador/web_programa_descripcion.php?op=guardaryeditarprogramas",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			$("#ModalEditarProgramas").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Programa Descripción Editado",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistaprogramas").DataTable().ajax.reload();
			
		}
	});
}

function guardaryeditardesempenate(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioeditardesem")[0]);
	$.ajax({
		"url": "../controlador/web_programa_descripcion.php?op=guardaryeditardesempenate",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			$("#Modaldesempenateeditar").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Programa Descripción Agregado",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistaprogramas").DataTable().ajax.reload();
		}
	});
}

function imagenyvideo(id_web_programa_descripcion_editar){
	$.post("../controlador/web_programa_descripcion.php?op=imagenyvideo",{id_web_programa_descripcion_editar : id_web_programa_descripcion_editar},function(data){
		data = JSON.parse(data);
		$("#videoeimagen").show();
		$("#videoeimagen").html(data);
		
	});
}

function desempenatemodal(id_programa){
	$.post("../controlador/web_programa_descripcion.php?op=desempenatemodal",{id_programa : id_programa},function(data){
		data = JSON.parse(data);

		$("#desempenatemostrar").show();
		$("#desempenatemostrar").html(data);
		tabla_acciones = $("#refrescartabla_accion").DataTable();
	});
}

function eliminar_programas(
	id_web_programa_descripcion,imagen_eliminar
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
			title: "¿Está Seguro de eliminar?",
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
					"../controlador/web_programa_descripcion.php?op=eliminar_programas",
					{
						'id_web_programa_descripcion' : id_web_programa_descripcion,'imagen_eliminar' : imagen_eliminar
					},
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Eliminada con éxito.",
								icon: "success",
							});
							
							$("#tbllistaprogramas").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "no se puede eliminar.",
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

function desactivar_programas(
	id_web_programa_descripcion
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
			title: "¿Está Seguro de desactivar el programa?",
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
					"../controlador/web_programa_descripcion.php?op=desactivar_programas",
					{
						'id_web_programa_descripcion' : id_web_programa_descripcion
					},
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Desactivado con éxito.",
								icon: "success",
							});
							$("#tbllistaprogramas").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "no se puede desactivar el programa.",
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

function activar_programas(
	id_web_programa_descripcion
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
			title: "¿Está Seguro de activar el programa?",
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
					"../controlador/web_programa_descripcion.php?op=activar_programas",
					{
						'id_web_programa_descripcion' : id_web_programa_descripcion
					},
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Activada con éxito.",
								icon: "success",
							});
							$("#tbllistaprogramas").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "no se puede activar el programa.",
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

function ver_video(id_programas){

	$.post("../controlador/web_programa_descripcion.php?op=ver_video",{id_programas : id_programas},function(data){
		data = JSON.parse(data);
		$("#ModalVerVideoProgramaDescripcion").modal("show");
		$("#mostar_video_modal_descripcion").show();
		$("#mostar_video_modal_descripcion").html(data);
	});
}
function eliminar_programa_desempenate(
	id_programa_desempenate
) 

{
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de eliminar?",
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
					"../controlador/web_programa_descripcion.php?op=eliminar_programa_desempenate",
					{
						'id_programa_desempenate' : id_programa_desempenate
					},
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Eliminada con éxito.",
								icon: "success",
							});
							var idprograma = $('#id_programa').val();
							desempenatemodal(idprograma);
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "no se puede eliminar.",
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
				"element": document.querySelector('#tour_agregar_programas_descripcion'),
				"intro": 'Agrega la descripción del programa en la pagina web.'
			},
			{
				"title": 'Opciones',
				"element": document.querySelector('#tour_opciones'),
				"intro": 'Columna donde puedes <span class="badge badge-primary p-1">editar</span>, <span class="badge badge-success p-1">desactivar</span> y <span class="badge badge-secondary p-1">activar</span> ademas agregar el Campo profesional del programa.'
			},
			{
				"title": 'Programa',
				"element": document.querySelector('#tour_programa'),
				"intro": 'Muestra el nombre del programa.'
			},
			{
				"title": 'Imagen escritorio',
				"element": document.querySelector('#tour_imagen_escritorio'),
				"intro": 'Columna donde muestra la imagen de escritorio del programa que debe ser de 428x306.'
			},
			{
				"title": 'Url',
				"element": document.querySelector('#tour_video'),
				"intro": 'Columna la url del video en un modal.'
			},
			{
				"title": 'Titulo',
				"element": document.querySelector('#tour_titulo_descripcion'),
				"intro": 'Columna donde muestra el titulo del programa'
				
			},
			{
				"title": 'Estado',
				"element": document.querySelector('#tour_descripcion_programa'),
				"intro": 'Columna donde muestra la drescripción del programa'
				
			},
			{
				"title": 'Estado',
				"element": document.querySelector('#tour_estado'),
				"intro": 'Columna donde muestra el estado de la calidad, ya sea si esta <span class="badge badge-success p-1">activada</span> o <span class="badge badge-danger p-1">desactivado</span>'
				
			},
			
		]
	},
	).start();
}






init();