var tabla;
var img_emprendimiento;
var id_web_emprendimientos;

function init(){

	listar();

	$("#formularioagregareditar").on("submit",function(e1){
		guardaryeditar(e1);	
	});

	$("#formularioagregar").on("submit",function(e){
		agregaremprendimiento(e);	
	});
	
}

function listar(){
	$("#precarga").show();
	
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistadoemprendimiento').dataTable({
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
				title: 'Emprendimientos',
				titleAttr: 'Print'
			},
		],
		
		"ajax":{ url: '../controlador/web_emprendimientos.php?op=listar',						
		error: function(e){
			console.log(e.responseText);	
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

function guardaryeditar(e1){
	e1.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioagregareditar")[0]);
	$.ajax({
		"url": "../controlador/web_emprendimientos.php?op=guardaryeditar",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			$("#ModalEditar").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Emprendimiento Editado",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistadoemprendimiento").DataTable().ajax.reload();
			
		}
	});
}
function editar(id_web_emprendimientos){
	$("#ModalEditar").modal("show");
	$.post("../controlador/web_emprendimientos.php?op=editar",{"id_web_emprendimientos" : id_web_emprendimientos},function(data){
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){
			$("#id_web_emprendimientos_editar").val(data.id_web_emprendimientos);
			$("#nombre_emprendimiento_editar").val(data.nombre_emprendimiento);
			$("#nombre_emprendedor_editar").val(data.nombre_emprendedor);
            $("#descripcion_emprendimiento_editar").val(data.descripcion_emprendimiento);
            $("#telefono_contacto_editar").val(data.telefono_contacto);
			$("#editarguardarimg_editar").val(data.imagen_emprendimiento);
		}
	});
}

function agregaremprendimiento(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioagregar")[0]);
	$.ajax({
		"url": "../controlador/web_emprendimientos.php?op=agregaremprendimiento",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			$("#ModalAgregar").modal("hide");

			$("#ModalEditar").modal("hide");
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Emprendimiento Editado",
				showConfirmButton: false,
				timer: 1500,
			});
			$("#tbllistadoemprendimiento").DataTable().ajax.reload();
			
		}
	});
}

function mostraragregar(flag)
{
	if (flag)
	{
		$("#ModalAgregar").modal("show");
		limpiar();
	}
	
}


function eliminar_emprendimiento(
	id_web_emprendimientos,imagen_emprendimiento
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
			title: "¿Está Seguro de eliminar el emprendimiento?",
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
					"../controlador/web_emprendimientos.php?op=eliminar_emprendimiento",
					{
						'id_web_emprendimientos' : id_web_emprendimientos,'imagen_emprendimiento' : imagen_emprendimiento
					},
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Emprendimiento eliminado con éxito.",
								icon: "success",
							});
							$("#tbllistadoemprendimiento").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "no se puede eliminar el emprendimiento.",
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





function desactivar_emprendimiento(
	id_web_emprendimientos
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
			title: "¿Está Seguro de desactivar el emprendimiento?",
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
					"../controlador/web_emprendimientos.php?op=desactivar_emprendimiento",
					{
						'id_web_emprendimientos' : id_web_emprendimientos
					},
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Emprendimiento desactivado con éxito.",
								icon: "success",
							});
							$("#tbllistadoemprendimiento").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "no se puede desactivar el emprendimiento.",
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



function activar_emprendimiento(
	id_web_emprendimientos
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
			title: "¿Está Seguro de activar el emprendimiento?",
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
					"../controlador/web_emprendimientos.php?op=activar_emprendimiento",
					{
						'id_web_emprendimientos' : id_web_emprendimientos
					},
					function (e) {
						if (e == "null") {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "Emprendimiento activado con éxito.",
								icon: "success",
							});
							$("#tbllistadoemprendimiento").DataTable().ajax.reload();
						} else {
							swalWithBootstrapButtons.fire({
								title: "Ejecutado!",
								text: "no se puede activar el emprendimiento.",
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
function limpiar()
{
	$("#id_web_emprendimientos").val("");
	$("#nombre_emprendimiento").val("");
	$("#nombre_emprendedor").val("");
    $("#descripcion_emprendimiento").val("");
    $("#telefono_contacto").val("");
	$("#editarguardarimg").val("");
	
}

init();