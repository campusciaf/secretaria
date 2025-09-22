var tabla;
var img_aliados;
var id_web_aliados;

function init(){

	listaraliados();
	$("#formularioagregarimageneditar").on("submit",function(e1){
		guardaryeditaraliados(e1);	
	});
	$("#formularioagregarimagen").on("submit",function(e){
		agregarimagen(e);	
	});
	
}
function listaraliados(id_web_aliados){
	$("#precarga").show();
	$("#id_web_aliados").val(id_web_aliados);
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistaaliados').dataTable({
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
				title: 'Aliados',
				titleAttr: 'Print'
			},
		],
		
		"ajax":{ url: '../controlador/web_aliados.php?op=listaraliados&id_web_aliados='+id_web_aliados, type : "get", dataType : "json",						
		error: function(e){
		}
	},
	"bDestroy": true,
	"iDisplayLength": 30,//Paginación
	"order": [[ 0, "asc" ]],//Ordenar (columna,orden)
	'initComplete': function (settings, json) {
			
			$("#precarga").hide();
			
		},
	});
}
function guardaryeditaraliados(e1){
	e1.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioagregarimageneditar")[0]);
	$.ajax({
		"url": "../controlador/web_aliados.php?op=guardaryeditaraliados",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			$("#ModalImagenEditar").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Aliado Actualizado",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistaaliados").DataTable().ajax.reload();
			
		}
	});
}

function mostrar_imagen_editar(id_web_aliados){
	$("#ModalImagenEditar").modal("show");
	$.post("../controlador/web_aliados.php?op=mostrar_imagen",{"id_web_aliados" : id_web_aliados},function(data){
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){
			$("#id_web_aliados_editar").val(data.id_web_aliados);
			$("#nombre_aliado_editar").val(data.nombre_aliado);
			$("#url_aliado_editar").val(data.url_aliado);
			$("#editarguardarimg_editar").val(data.imagen_aliado);
		}
	});
}
function agregarimagen(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioagregarimagen")[0]);
	$.ajax({
		"url": "../controlador/web_aliados.php?op=agregarimagen",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			$("#ModalImagen").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Imagen Actualizada",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistaaliados").DataTable().ajax.reload();
			
		}
	});
}
function mostraragregarimagen(flag)
{
	if (flag)
	{
		$("#ModalImagen").modal("show");
		limpiar_agregar_aliados();
	}
	
}
function eliminar_aliados(id_web_aliados,imagen_aliado) {
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
				$("#imagen_aliado").val(result.imagen_aliado);
				$.post(
					"../controlador/web_aliados.php?op=eliminar_aliados",
					{ id_web_aliados: id_web_aliados, imagen_aliado: imagen_aliado },
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Aliado eliminada con éxito.",
								icon: "success",
							});
							$("#tbllistaaliados").DataTable().ajax.reload();
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
function desactivar_aliados(id_web_aliados) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de desactivar el aliado?",
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
					"../controlador/web_aliados.php?op=desactivar_aliados",
					{ id_web_aliados: id_web_aliados },
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Noticia desactivar con éxito.",
								icon: "success",
							});

							$("#tbllistaaliados").DataTable().ajax.reload();
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
function activar_aliados(id_web_aliados) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de activar el Aliado?",
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
					"../controlador/web_aliados.php?op=activar_aliados",
					{ id_web_aliados: id_web_aliados },
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Activar Aliado con éxito.",
								icon: "success",
							});

							$("#tbllistaaliados").DataTable().ajax.reload();
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
//Función limpiar
function limpiar_agregar_aliados()
{
	$("#id_web_aliados").val("");
	$("#nombre_aliado").val("");
	$("#url_aliado").val("");
	$("#editarguardarimg").val("");
	
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
				"title": 'Agregar Aliado',
				"element": document.querySelector('#tour_agregar_aliado'),
				"intro": 'Agrega el aliado en la pagina web.'
			},
			{
				"title": 'Opciones',
				"element": document.querySelector('#tour_opciones'),
				"intro": 'Columna donde puedes <span class="badge badge-primary p-1">editar</span>, <span class="badge badge-danger p-1">eliminar</span> , <span class="badge badge-success p-1">desactivar</span> y <span class="badge badge-secondary p-1">activar</span> los aliados.'
			},
			{
				"title": 'Archivo',
				"element": document.querySelector('#tour_archivo'),
				"intro": 'Muestra la imagen coorporativa del aliado.'
			},
			{
				"title": 'Nombre Aliado',
				"element": document.querySelector('#tour_nombre_aliado'),
				"intro": 'Columna donde muestra el nombre del aliado.'
			},
			{
				"title": 'Url',
				"element": document.querySelector('#tour_url'),
				"intro": 'Columna donde muestra la la pagina web del aliado.'
			},
			
			{
				"title": 'Estado',
				"element": document.querySelector('#tour_estado'),
				"intro": 'Columna donde muestra el estado del aliado, ya sea si esta <span class="badge badge-success p-1">activada</span> o <span class="badge badge-danger p-1">desactivado</span>'
			},
			
		]
	},
	).start();
}

init();