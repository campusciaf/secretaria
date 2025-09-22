var tabla;
var img_calidad;
var id_web_calidad_crecimiento;

function init(){

	listarcalidad();

	$("#formularioagregarimageneditar").on("submit",function(e1){
		guardaryeditarcalidad(e1);	
	});

	$("#formularioagregarimagen").on("submit",function(e){
		agregarimagen(e);	
	});
	
}

function listarcalidad(id_web_calidad_crecimiento){
	$("#precarga").show();
	
	$("#id_web_calidad_crecimiento").val(id_web_calidad_crecimiento);

	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistacalidad').dataTable({
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
				title: 'Calidads',
				titleAttr: 'Print'
			},
		],
		
		"ajax":{ url: '../controlador/web_calidad_crecimiento.php?op=listarcalidad&id_web_calidad_crecimiento='+id_web_calidad_crecimiento, type : "get", dataType : "json",						
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


function guardaryeditarcalidad(e1){
	e1.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioagregarimageneditar")[0]);
	$.ajax({
		"url": "../controlador/web_calidad_crecimiento.php?op=guardaryeditarcalidad",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){
			$("#ModalEditarCalidadCrecimiento").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Calidad Editado",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistacalidad").DataTable().ajax.reload();
			
		}
	});
}

function mostrar_imagen_editar(id_web_calidad_crecimiento){
	$("#ModalEditarCalidadCrecimiento").modal("show");
	$.post("../controlador/web_calidad_crecimiento.php?op=mostrar_imagen",{"id_web_calidad_crecimiento" : id_web_calidad_crecimiento},function(data){
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){
			$("#id_web_calidad_crecimiento_editar").val(data.id_web_calidad_crecimiento);
			$("#titulo_calidad_editar").val(data.titulo_calidad);
			$("#url_calidad_editar").val(data.url_calidad);
			$("#editarguardarimg_editar").val(data.imagen_calidad);
		}
	});
}

function agregarimagen(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioagregarimagen")[0]);
	$.ajax({
		"url": "../controlador/web_calidad_crecimiento.php?op=agregar_imagen",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			console.log(datos);
			$("#ModalCalidadCrecimiento").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Calidad Agregada",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistacalidad").DataTable().ajax.reload();
			
		}
	});
}

function mostraragregarimagen(flag)
{
	if (flag)
	{
		$("#ModalCalidadCrecimiento").modal("show");
		limpiar_agregar_calidad();
	}
	
}



function eliminar_calidad(
	id_web_calidad_crecimiento,imagen_calidad
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
					"../controlador/web_calidad_crecimiento.php?op=eliminar_calidad",
					{
						'id_web_calidad_crecimiento' : id_web_calidad_crecimiento,'imagen_calidad' : imagen_calidad
					},
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Eliminada con éxito.",
								icon: "success",
							});
							$("#tbllistacalidad").DataTable().ajax.reload();
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


function desactivar_calidad(
	id_web_calidad_crecimiento
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
			title: "¿Está Seguro de desactivar la calidad?",
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
					"../controlador/web_calidad_crecimiento.php?op=desactivar_calidad",
					{
						'id_web_calidad_crecimiento' : id_web_calidad_crecimiento
					},
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Calidad Desactivada con éxito.",
								icon: "success",
							});
							$("#tbllistacalidad").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Calidad no se puede desactivar.",
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


function activar_calidad(
	id_web_calidad_crecimiento
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
			title: "¿Está Seguro de activar la calidad?",
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
					"../controlador/web_calidad_crecimiento.php?op=activar_calidad",
					{
						'id_web_calidad_crecimiento' : id_web_calidad_crecimiento
					},
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Calidad activada con éxito.",
								icon: "success",
							});
							$("#tbllistacalidad").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Calidad no se puede activar.",
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
function limpiar_agregar_calidad()
{
	$("#id_web_calidad_crecimiento").val("");
	$("#titulo_calidad_agregar").val("");
	$("#url_calidad").val("");
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
				"title": 'Agregar Programa',
				"element": document.querySelector('#tour_agregar_imagen_calidad'),
				"intro": 'Agrega el programa en la pagina web.'
			},
			{
				"title": 'Opciones',
				"element": document.querySelector('#tour_opciones'),
				"intro": 'Columna donde puedes <span class="badge badge-primary p-1">editar</span>, <span class="badge badge-success p-1">desactivar</span> y <span class="badge badge-secondary p-1">activar</span> el programa.'
			},
			{
				"title": 'Archivos',
				"element": document.querySelector('#tour_archivos'),
				"intro": 'Muestra la imagen de la caliadad para la pagina web.'
			},
			{
				"title": 'Titulo',
				"element": document.querySelector('#tour_titulo'),
				"intro": 'Columna donde muestra el titulo de la calidad.'
			},
			{
				"title": 'Url',
				"element": document.querySelector('#tour_url'),
				"intro": 'Columna la url de la calidad.'
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