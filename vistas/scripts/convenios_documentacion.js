var id_convenio_carpeta_global;
var id_convenio_documento_global;

function init() {
    listar_carpetas_usuario();
    // formulario que activa el form para guardar las carpetas
    $("#formulariocrearcarpeta").on("submit", function (e) {
        guardaryeditarcarpeta(e);
    });
    // formulario que activa el form para guardar los items
    $("#formulariocrearchecklist").on("submit", function (e) {
        guardaryeditarchecklist(e);
    });
    // formulario que activa el form para guardar los archivos
    $("#formulariosubirarchivo").on("submit", function (e) {
        subirarchivoform(e);
    });
    // formulario que activa el form para guardar los comentarios
    $("#formulariocomentarios").on("submit", function (e) {
        crearcomentarios(e);
    });
}
// funcion para el boton de volver
function volver() {
    if ($("#mostrar_check_list").hasClass("active-table")) {
        // cuando estamos en la tabla tblistachecklist volvemos a la tabla tblistacarpeta
        $("#mostrar_check_list").removeClass("active-table").hide();
        $("#mostrar_carpeta").addClass("active-table").show();
        $("#lugar_tabla").html("Crear Convenios");
        // solo mostramos el boton de agregar carpeta en la tabla inicial 
        $("#btnagregarcarpeta").show();
        $("#btnagregarchecklist, #btnagregararchivo, #btnagregarcomentario").hide();
        $("#btn_volver").hide();
    } 
    else if ($("#verarchivoscheckList").hasClass("active-table")) {
        // si estamos dentro de la tabla verarchivoscheckList volvemos a tblistachecklist
        $("#verarchivoscheckList").removeClass("active-table").hide();
        $("#mostrar_check_list").addClass("active-table").show();
        $("#lugar_tabla").html("Items Convenio");
        //mostramos los botones del formulario para agregar los checklist y el boton de volver en la tabla tblistachecklist
        $("#btnagregarchecklist").show();
        $("#btnagregarcarpeta, #btnagregararchivo, #btnagregarcomentario").hide();
        $("#btn_volver").show();
    } 
    else if ($("#verarcomentarios").hasClass("active-table")) {
        //si estamos dentro de la tabla verarcomentarios cuando le dan en volver se devuelve a tblistachecklist
        $("#verarcomentarios").removeClass("active-table").hide();
        $("#mostrar_check_list").addClass("active-table").show();
        $("#lugar_tabla").html("Items Convenio");
        //mostramos los botones del formulario para agregar los checklist y el boton de volver en la tabla tblistachecklist
        $("#btnagregarchecklist").show();
        $("#btnagregarcarpeta, #btnagregararchivo, #btnagregarcomentario").hide();
        $("#btn_volver").show();
    }
}
//funcion para guardar las carpetas
function guardaryeditarcarpeta(e) {
    e.preventDefault();
    let formData = new FormData($("#formulariocrearcarpeta")[0]);
    $.ajax({
        url: "../controlador/convenios_documentacion.php?op=guardaryeditarcarpeta",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            let data = JSON.parse(datos);
            if (data["0"]["0"] == 1) {
                alertify.success("Carpeta agregada");
            } else if (data["0"]["0"] == 2) {
                alertify.error("No se pudo agregar");
            } else if (data["0"]["0"] == 3) {
                alertify.success("Carpeta actualizada");
            } else {
                alertify.error("Carpeta no actualizada");
            }
            $('#tblistacarpeta').DataTable().ajax.reload();
            $("#carpetadocumento").modal("hide");
            
            $("#carpeta").val("");
            $("#btnCrearCarpeta").prop("disabled", false);
        }
    });
}
//funcion para guardar los items
function guardaryeditarchecklist(e) {
    e.preventDefault();
    let formData = new FormData($("#formulariocrearchecklist")[0]);
    $.ajax({
        url: "../controlador/convenios_documentacion.php?op=guardaryeditarchecklist",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            $("#crearchecklistconvenio").modal("hide");
            let data = JSON.parse(datos);
            if (data["0"]["0"] == 1) {
                alertify.success("Item agregado");
                $('#tblistachecklist').DataTable().ajax.reload();
            } else if (data["0"]["0"] == 2) {
                alertify.error("No se pudo agregar");
                $('#tblistachecklist').DataTable().ajax.reload();
            } else if (data["0"]["0"] == 3) {
                alertify.success("Item actualizado");
                $('#tblistachecklist').DataTable().ajax.reload();
            } else if (data["0"]["0"] == 4) {
                alertify.error("Item no actualizado");
                $('#tblistachecklist').DataTable().ajax.reload();
            } else {
                alertify.error("Error de formato");
            }
        },
    });
}
//funcion para guardar los archivos
function subirarchivoform(e) {
    e.preventDefault();
    let formData = new FormData($("#formulariosubirarchivo")[0]);
    $.ajax({
        url: "../controlador/convenios_documentacion.php?op=subirarchivoform",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            $("#subirarchivo").modal("hide");
            $('#tablaverarchivoscheckList').DataTable().ajax.reload();
            let data = JSON.parse(datos);
            if (data["0"]["0"] == 1) {
                alertify.success("Documento agregado");
            } else if (data["0"]["0"] == 2) {
                alertify.error("No se pudo agregar");
            } else if (data["0"]["0"] == 3) {
                alertify.success("Documento actualizado");
            } else if (data["0"]["0"] == 4) {
                alertify.error("Documento no actualizado");
            } else {
                alertify.error("Error de formato");
            }
        },
    });
}
//funcion para guardar los comentarios
function crearcomentarios(e) {
    e.preventDefault();
    let formData = new FormData($("#formulariocomentarios")[0]);
    $.ajax({
        url: "../controlador/convenios_documentacion.php?op=crearcomentarios",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            $("#agregarcomentarios").modal("hide");
            $("#comentarios").val("");
            $('#tablavercomentarios').DataTable().ajax.reload();
            let data = JSON.parse(datos);
            if (data["0"]["0"] == "1") {
                alertify.success("Comentario agregado");
            } else if (data["0"]["0"] == "2") {
                alertify.error("No se pudo agregar el comentario");
            } else {
                alertify.error("Error");
            }
        },
    });
}
//lista la tabla de las carpetas
function listar_carpetas_usuario() {
    $("#mostrar_carpeta").addClass("active-table");
    $("#mostrar_check_list, #verarchivoscheckList, #verarcomentarios").removeClass("active-table").hide();
    $("#lugar_tabla").html("Crear Convenios");
    $("#btnagregarcarpeta").show();
    $("#btnagregarchecklist, #btnagregararchivo, #btnagregarcomentario").hide();
    $("#btn_volver").hide();
    $("#precarga").show();
    $("#btnagregarcomentario").hide();
    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    var f = new Date();
    var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tblistacarpeta').dataTable({
        "aProcessing": true, 
        "aServerSide": true, 
        dom: 'Bfrtip', 
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
            }
        ],
        "ajax": {
            url: '../controlador/convenios_documentacion.php?op=listar_carpetas_usuario',
            type: "post",
            data: {
                
            },
            dataType: "json",
            error: function (e) {
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, 
        "order": [[0, "asc"]],
        'initComplete': function (settings, json) {
            $("#precarga").hide();
            scroll(0, 0);
        }
    });
}
//lista la tabla de los items creados
function vercheclistcreados(id_convenio_carpeta) {
    id_convenio_carpeta_global = id_convenio_carpeta;
    $("#mostrar_check_list").addClass("active-table").show();
    $("#mostrar_carpeta, #verarchivoscheckList, #verarcomentarios").removeClass("active-table").hide();
    $("#lugar_tabla").html("Items Convenio");
    $("#btnagregarchecklist").show();
    $("#btnagregarcarpeta, #btnagregararchivo, #btnagregarcomentario").hide();
    $("#btn_volver").show();
    $("#precarga").show();
    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    var f = new Date();
    var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tblistachecklist').dataTable({
        "aProcessing": true, 
        "aServerSide": true, 
        dom: 'Bfrtip', 
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
            }
        ],
        "ajax": {
            url: '../controlador/convenios_documentacion.php?op=vercheclistcreados',
            type: "post",
            data: {
                id_convenio_carpeta: id_convenio_carpeta
            },
            dataType: "json",
            error: function (e) {
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, 
        "order": [[0, "asc"]],
        'initComplete': function (settings, json) {
            $("#precarga").hide();
            scroll(0, 0);
        }
    });
}
//lista la tabla deentro los items creados
function verarchivoscheckList(id_convenio_documento) {
    id_convenio_documento_global = id_convenio_documento;
    $("#precarga").show();
    $("#verarchivoscheckList").addClass("active-table").show();
    $("#mostrar_carpeta, #mostrar_check_list, #verarcomentarios").removeClass("active-table").hide();
    $("#lugar_tabla").html("Archivos Convenios");
    $("#btnagregararchivo").show();
    $("#btnagregarcarpeta, #btnagregarchecklist, #btnagregarcomentario").hide();
    $("#btn_volver").show();
    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    var f = new Date();
    var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tablaverarchivoscheckList').dataTable({
        "aProcessing": true, 
        "aServerSide": true, 
        dom: 'Bfrtip', 
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
            }
        ],
        "ajax": {
            url: '../controlador/convenios_documentacion.php?op=verarchivoscheckList',
            type: "post",
            data: {
                id_convenio_documento: id_convenio_documento
            },
            dataType: "json",
            error: function (e) {
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, 
        "order": [[0, "asc"]],
        'initComplete': function (settings, json) {
            $("#precarga").hide();
            scroll(0, 0);
        }
    });
}
// visualizar los comentarios 
function verarcomentarios(id_convenio_documento) {
    id_convenio_documento_global = id_convenio_documento;
    $("#precarga").show();
    $("#verarcomentarios").addClass("active-table").show();
    $("#mostrar_carpeta, #mostrar_check_list, #verarchivoscheckList").removeClass("active-table").hide();

    $("#lugar_tabla").html("Agregar Comentarios");
    $("#btnagregarcomentario").show();
    $("#btnagregarcarpeta, #btnagregarchecklist, #btnagregararchivo").hide();
    $("#btn_volver").show();
    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    var f = new Date();
    var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tablavercomentarios').dataTable({
        "aProcessing": true, 
        "aServerSide": true, 
        dom: 'Bfrtip', 
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
            }
        ],
        "ajax": {
            url: '../controlador/convenios_documentacion.php?op=verarcomentarios',
            type: "post",
            data: {
                id_convenio_documento: id_convenio_documento
            },
            dataType: "json",
            error: function (e) {
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, 
        "order": [[0, "asc"]],
        'initComplete': function (settings, json) {
            $("#precarga").hide();
            scroll(0, 0);
        }
    });
}
//abre el formulario para crear la carpeta
function carpetaDocumento(id_convenio_carpeta,carpeta) {
    $("#crear_convenio").html("Crear Carpeta");
    $("#carpetadocumento").modal("show");
    $("#id_convenio_carpeta").val(id_convenio_carpeta);
    $("#carpeta").val(carpeta);
}
//abre el formulario para crear los items
function crearchecklist() {
    $("#agregar_items").html("Crear Items");
    $("#crearchecklistconvenio").modal("show");
    $("#id_convenio_documento_subir").val(id_convenio_carpeta_global);
    $("#id_convenio_documento_subir_editar").val("");
    $("#nombre_documento").val("");
    $("#nombre_convenio").val("");
    $("#archivo_documento").val("");
    $("#imagenactual").val("");
}
//abre el formulario para subir los archivos de cada item
function subirarchivo() {
    $("#subirarchivo").modal("show");
    $("#id_convenio_subir_archivo").val(id_convenio_documento_global);
    $("#nombre_documento").val("");
    $("#archivo_documento").val("");
    $("#imagenactual").val("");
}
//abre el formulario para crear los comentarios
function agregarcomentario() {
    $("#agregarcomentarios").modal("show");
    $("#id_convenio_documento_comentarios").val(id_convenio_documento_global);
    $("#nombre_documento").val("");
    $("#archivo_documento").val("");
    $("#imagenactual").val("");
}
// finaliza el item
function terminar_item(id_convenio_documento) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de terminar el item?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/convenios_documentacion.php?op=terminar_item", { 'id_convenio_documento': id_convenio_documento }, function (e) {
				if (e) {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Item terminado con éxito.",
						icon: "success"
					});
					$('#tblistachecklist').DataTable().ajax.reload();
				} else {
					swalWithBootstrapButtons.fire({
						title: "Error!",
						text: "Item no se pudo terminar.",
						icon: "error"
					});
				}
			});
		} else if (result.dismiss === Swal.DismissReason.cancel) {
			swalWithBootstrapButtons.fire({
				title: "Cancelado",
				text: "Tu proceso está a salvo :)",
				icon: "error"
			});
		}
	});
}
function editar_carpeta(id_convenio_carpeta) {
	$.post("../controlador/convenios_documentacion.php?op=editar_carpeta", { "id_convenio_carpeta": id_convenio_carpeta }, function (data) {
		data = JSON.parse(data);
		if (Object.keys(data).length > 0) {
            $("#crear_convenio").html("Editar Carpeta");
			$("#id_convenio_carpeta").val(data.id_convenio_carpeta);
			$("#carpeta").val(data.carpeta);
			$("#carpetadocumento").modal("show");
		}
	});
}
function editar_items(id_convenio_documento) {
	$.post("../controlador/convenios_documentacion.php?op=editar_items", { "id_convenio_documento": id_convenio_documento }, function (data) {
		data = JSON.parse(data);
		if (Object.keys(data).length > 0) {
            $("#agregar_items").html("Editar Items");
			$("#id_convenio_documento_subir_editar").val(data.id_convenio_documento);
            $("#id_convenio_documento_subir").val(id_convenio_carpeta_global);
			$("#nombre_convenio").val(data.nombre_convenio);
			$("#crearchecklistconvenio").modal("show");
		}
	});
}
function eliminar_carpeta(id_convenio_carpeta) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar la carpeta?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/convenios_documentacion.php?op=eliminar_carpeta", { 'id_convenio_carpeta' : id_convenio_carpeta }, function (e) {
				if (e !== 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Carpeta eliminada con éxito.",
						icon: "success"
					});
					$('#tblistacarpeta').DataTable().ajax.reload();
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Carpeta no se puede eliminar.",
						icon: "error"
					});
				}
			});
		} else if (
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
function eliminar_items(id_convenio_documento) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar el item?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/convenios_documentacion.php?op=eliminar_items", { 'id_convenio_documento' : id_convenio_documento }, function (e) {
				if (e !== 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Item eliminado con éxito.",
						icon: "success"
					});
					$('#tblistachecklist').DataTable().ajax.reload();
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Carpeta no se puede eliminar.",
						icon: "error"
					});
				}
			});
		} else if (
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




init();
