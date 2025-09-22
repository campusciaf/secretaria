var tabla;

function init(){

	listarbanner();

	$("#formulariobanner").on("submit",function(e){
		guardaryeditarbanner(e);	
	});
	
}

function listarbanner(id_banner){
	$("#precarga").show();
	$("#id_banner").val(id_banner);
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistabanner').dataTable({
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
				title: 'Ejes',
				titleAttr: 'Print'
			},
		],
		
		"ajax":{ url: '../controlador/web_baner.php?op=listarbanner&id_banner='+id_banner, type : "get", dataType : "json",						
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



//Función limpiar
function limpiar()
{
	$("#id_banner").val("");
	$("#titulo").val("");
	$("#subtitulo").val("");
	$("#descripcion").val("");
	$("#ruta_url").val("");
	$("#imagen_escritorio_2").val("");
	$("#imagen_celuar").val("");
	$("#imagenmuestra_celular2").attr("src"," ");
	$("#imagenmuestra_escritorio_2").val("");
	$("#imagenactual_escritorio").attr("src"," ");
	$("#imagenmuestra_celular").val("");
	
}

	function mostrar_banner(id_banner){
	$.post("../controlador/web_baner.php?op=mostrar_banner",{"id_banner" : id_banner},function(data){
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){
			$("#id_banner").val(data.id_banner);
			$("#titulo").val(data.titulo);
			$("#subtitulo").val(data.subtitulo);
			$("#descripcion").val(data.descripcion);
			$("#ruta_url").val(data.ruta_url);
			$("#imagen_escritorio_2").val(data.imagen_escritorio_2);
			$("#imagen_celuar").val(data.imagen_celuar);
			$("#imagenactual_escritorio").attr("src","../public/web_baner/"+data.img_pc);			
			$("#imagenmuestra_escritorio_2").val(data.img_pc);
			$("#imagenmuestra_celular2").attr("src","../public/web_baner/"+data.img_movil);
			$("#imagenmuestra_celular").val(data.img_movil);
			$("#ModalBanner").modal("show");
			
		}
	});
}

function mostraragregarbanner(flag)
{
	if (flag)
	{
		$("#ModalBanner").modal("show");
		limpiar();
	}
	else
	{
		$("#ModalBanner").modal("show");
	}
}

function guardaryeditarbanner(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarDocente").prop("disabled",true);
	var formData = new FormData($("#formulariobanner")[0]);
	$.ajax({
		"url": "../controlador/web_baner.php?op=guardaryeditarbanner",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			$("#ModalBanner").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Banner Actualizada",
				showConfirmButton: false,
				timer: 1500
			});
			$('#tbllistabanner').DataTable().ajax.reload();
			
		}
	});
}

function eliminar_banner(id_banner) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar el banner?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/web_baner.php?op=eliminar_banner", { id_banner: id_banner }, function (e) {

				if (e == 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Meta eliminada con éxito.",
						icon: "success"
					});

					$('#tbllistabanner').DataTable().ajax.reload();
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Meta no se puede eliminar.",
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
				"title": 'Agregar Banner',
				"element": document.querySelector('#tour_btnagregar'),
				"intro": 'Puedes agregar el banner para mostrarlo en la pagina web.'
			},
			{
				"title": 'Opciones',
				"element": document.querySelector('#tour_opciones'),
				"intro": 'Columna para editar y eliminar el banner.'
			},
			{
				"title": 'Titulo',
				"element": document.querySelector('#tour_titulo'),
				"intro": 'Columna donde muestra el titulo del banner.'
			},
			{
				"title": 'Subtitulo',
				"element": document.querySelector('#subtitulo'),
				"intro": 'Columna donde muestra el subtitulo del banner'
			},
			{
				"title": 'Descripción',
				"element": document.querySelector('#descripcion'),
				"intro": 'Columna donde muestra la descripción del banner'
			},
			
		]
	},
	).start();
}

init();