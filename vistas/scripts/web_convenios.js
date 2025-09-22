var tabla;
var img_convenios;
var id_web_convenio;

function init(){

	listarconvenios();

	$("#formularioeditarconvenios").on("submit",function(e){
		guardaryeditarconvenios(e);	
	});

	$("#formularioagregarconvenio").on("submit",function(e){
		agregarconvenio(e);	
	});

	$.post("../controlador/web_convenios.php?op=Categoria_Programas", function(r){
		$("#categoria_convenios_imagen").html(r);
		$('#categoria_convenios_imagen').selectpicker('refresh');
	});

	$.post("../controlador/web_convenios.php?op=Categoria_Programas", function(r){
		$("#categoria_convenios_imagen_editar").html(r);
		$('#categoria_convenios_imagen_editar').selectpicker('refresh');
	});
	
}

function listarconvenios(id_web_convenio){
	$("#precarga").show();
	$("#id_web_convenio").val(id_web_convenio);
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistaconvenios').dataTable({
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
				title: 'Noticias',
				titleAttr: 'Print'
			},
		],
		
		"ajax":{ url: '../controlador/web_convenios.php?op=listarconvenios&id_web_convenio='+id_web_convenio, type : "get", dataType : "json",						
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

function mostrar_convenios(id_web_convenio){
	
	$.post("../controlador/web_convenios.php?op=mostrar_convenios",{"id_web_convenio" : id_web_convenio},function(data){
	data = JSON.parse(data);
	if(Object.keys(data).length > 0){
		$("#id_web_convenio_editar").val(data.id_web_convenio);
		$("#nombre_convenio_editar").val(data.nombre_convenio);
		$("#url_convenio_editar").val(data.url_convenio);
		$("#descripcion_convenio_editar").val(data.descripcion_convenio);
		$("#categoria_convenios_imagen_editar").val(data.id_bienestar_programas);
		$("#categoria_convenios_imagen_editar").selectpicker('refresh');
		$("#agregar_editar_imagen_editar").val(data.imagen_convenio);
		$("#imageneditarguardar").val(data.imagen_convenio);
		$("#ModalEditarConvenio").modal("show");

	}
});


}

function agregarconvenio(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioagregarconvenio")[0]);
	$.ajax({
		"url": "../controlador/web_convenios.php?op=agregarconvenio",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			$("#ModalConvenio").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Convenio Actualizada",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistaconvenios").DataTable().ajax.reload();
			
		}
	});
}

function limpiar_imagen()
{
	$("#id_web_convenio").val("");
	$("#nombre_convenio").val("");
	$("#url_convenio").val("");
	$("#descripcion_convenio").val("");
	$("#editarguardarimg").val("");
	
}

function mostraragregarconvenio(flag)
{
	if (flag)
	{
		$("#ModalConvenio").modal("show");
		limpiar_imagen();
	}
	
}

function guardaryeditarconvenios(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioeditarconvenios")[0]);
	$.ajax({
		"url": "../controlador/web_convenios.php?op=guardaryeditarconvenios",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			$("#ModalEditarConvenio").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Convenio Actualizada",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistaconvenios").DataTable().ajax.reload();
			
		}
	});
}
function eliminar_convenios(id_web_convenio,imagen_convenio) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de eliminar el convenio?",
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
					"../controlador/web_convenios.php?op=eliminar_convenios",
					{ 'id_web_convenio' : id_web_convenio,'imagen_convenio' : imagen_convenio },
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Convenio eliminada con éxito.",
								icon: "success",
							});
							$("#tbllistaconvenios").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Convenio no se puede eliminar.",
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

function desactivar_convenio(id_web_convenio) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de desactivar el convenio?",
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
					"../controlador/web_convenios.php?op=desactivar_convenio",
					{ id_web_convenio: id_web_convenio },
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Convenio desactivar con éxito.",
								icon: "success",
							});

							$("#tbllistaconvenios").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Convenio no se puede desactivar.",
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
function activar_convenio(id_web_convenio) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});
	swalWithBootstrapButtons
		.fire({
			title: "¿Está Seguro de Activar el convenio?",
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
					"../controlador/web_convenios.php?op=activar_convenio",
					{ id_web_convenio: id_web_convenio },
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Convenio Activado con éxito.",
								icon: "success",
							});

							$("#tbllistaconvenios").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Convenio no se puede desactivar.",
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
				"title": 'Agregar Convenio',
				"element": document.querySelector('#tour_agregar_convenio'),
				"intro": 'Agrega el convenio en la pagina web.'
			},
			{
				"title": 'Opciones',
				"element": document.querySelector('#tour_opciones'),
				"intro": 'Columna donde puedes <span class="badge badge-primary p-1">editar</span>, <span class="badge badge-danger p-1">eliminar</span> , <span class="badge badge-success p-1">desactivar</span> y <span class="badge badge-secondary p-1">activar</span> el convenio.'
			},
			{
				"title": 'Archivo',
				"element": document.querySelector('#tour_archivo'),
				"intro": 'Muestra la imagen del convenio.'
			},
			{
				"title": 'Nombre Aliado',
				"element": document.querySelector('#tour_nombre_convenio'),
				"intro": 'Columna donde muestra el nombre del convenio.'
			},
			{
				"title": 'Url',
				"element": document.querySelector('#tour_descripcion_convenio'),
				"intro": 'Columna donde muestra la descripción del convenio.'
			},
			{
				"title": 'Estado',
				"element": document.querySelector('#tour_url_convenio'),
				"intro": 'Columna donde muestra la pagina web del convenio.'
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