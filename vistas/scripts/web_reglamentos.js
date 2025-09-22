var tabla;
var img_reglamento;
var id_web_reglamento;

function init(){

	listarreglamento();

	$("#formularioagregarpdfeditar").on("submit",function(e1){
		guardaryeditarreglamento(e1);	
	});

	$("#formularioagregarpdf").on("submit",function(e){
		agregarpdf(e);	
	});


	$.post("../controlador/web_reglamentos.php?op=selectCategoriasReglamentos", function (r) {
		$("#categoria_reglamento").html(r);
		$("#categoria_reglamento").selectpicker("refresh");
	});

	$.post("../controlador/web_reglamentos.php?op=selectCategoriasReglamentos", function (r) {
		$("#categoria_reglamento_editar").html(r);
		$("#categoria_reglamento_editar").selectpicker("refresh");
	});
	
	
}




function listarreglamento(id_web_reglamento){
	$("#precarga").show();
	
	$("#id_web_reglamento").val(id_web_reglamento);
	
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistareglamento').dataTable({
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
				title: 'reglamento',
				titleAttr: 'Print'
			},
		],
		
		"ajax":{ url: '../controlador/web_reglamentos.php?op=listarreglamento&id_web_reglamento='+id_web_reglamento, type : "get", dataType : "json",						
		error: function(e){
		
		}
	},
	"bDestroy": true,
	"iDisplayLength": 10,//Paginación
	"order": [[ 0, "asc" ]],//Ordenar (columna,orden)
	'initComplete': function (settings, json) {
		
			$("#precarga").hide();
			
		},
	});
}


function guardaryeditarreglamento(e1){
	e1.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioagregarpdfeditar")[0]);
	$.ajax({
		"url": "../controlador/web_reglamentos.php?op=guardaryeditarreglamento",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			
			
			$("#ModalpdfEditar").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Reglamento Editado",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistareglamento").DataTable().ajax.reload();
			
		}
	});
}

function mostrar_pdf_editar(id_web_reglamento){
	$("#ModalpdfEditar").modal("show");
	$.post("../controlador/web_reglamentos.php?op=mostrar_pdf",{"id_web_reglamento" : id_web_reglamento},function(data){
		
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){
			$("#id_web_reglamento_editar").val(data.id_web_reglamentos);
			$("#nombre_reglamento_editar").val(data.nombre_reglamento);
			// $("#url_reglamento_editar").val(data.url_reglamento);
			$("#editarguardarimg_editar").val(data.url_reglamento);
			$("#categoria_reglamento_editar").val(data.id_categoria_reglamento);
			$("#categoria_reglamento_editar").selectpicker("refresh");
			
			

		}
	});
}

function agregarpdf(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioagregarpdf")[0]);
	$.ajax({
		"url": "../controlador/web_reglamentos.php?op=agregarpdf",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			console.log(datos);
			$("#Modalpdf").modal("hide");
			
			// alertify.success(datos);
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Reglamento Agregado",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistareglamento").DataTable().ajax.reload();

			
		}
	});
}

function mostraragregarpdf(flag)
{
	if (flag)
	{
		$("#Modalpdf").modal("show");
		limpiar_agregar_reglamento();
		
	}
	
}

function eliminar_reglamento(
	id_web_reglamento,pdf_reglamento
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
				$("#pdf_reglamento").val(result.pdf_reglamento);
				$.post(
					"../controlador/web_reglamentos.php?op=eliminar_reglamento",
					{
						'id_web_reglamento' : id_web_reglamento,'pdf_reglamento' : pdf_reglamento
					},
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Eliminada con éxito.",
								icon: "success",
							});
							$("#tbllistareglamento").DataTable().ajax.reload();
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

function desactivar_reglamento(
	id_web_reglamento
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
			title: "¿Está Seguro de desactivar el reglamento?",
			text: "¡No podrás revertir esto!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes, continuar!",
			cancelButtonText: "No, cancelar!",
			reverseButtons: true,
		})
		.then((result) => {
			if (result.isConfirmed) {
				$("#pdf_reglamento").val(result.pdf_reglamento);
				$.post(
					"../controlador/web_reglamentos.php?op=desactivar_reglamento",
					{
						'id_web_reglamento' : id_web_reglamento
					},
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Reglamento desactivado con éxito.",
								icon: "success",
							});
							$("#tbllistareglamento").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "no se puede desactivar el reglamento.",
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

function activar_reglamento(
	id_web_reglamento
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
			title: "¿Está Seguro de activar el reglamento?",
			text: "¡No podrás revertir esto!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes, continuar!",
			cancelButtonText: "No, cancelar!",
			reverseButtons: true,
		})
		.then((result) => {
			if (result.isConfirmed) {
				$("#pdf_reglamento").val(result.pdf_reglamento);
				$.post(
					"../controlador/web_reglamentos.php?op=activar_reglamento",
					{
						'id_web_reglamento' : id_web_reglamento
					},
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Reglamento activado con éxito.",
								icon: "success",
							});
							$("#tbllistareglamento").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "no se puede activar el reglamento.",
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
function limpiar_agregar_reglamento()
{
	$("#id_web_reglamento").val("");
	$("#nombre_reglamento").val("");
	$("#editarguardarimg").val("");
	
}

init();