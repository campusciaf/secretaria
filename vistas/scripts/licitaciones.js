var global_id_licitaciones_tarea, global_id_licitaciones_items, global_elemento, tabla_items;
function init() {
    $(".box_codigo_licitacion").hide();
    $("#box_otra_entidad_contratante").hide();
    listar_tareas();
    // formulario que activa el form para guardar las carpetas
    $("#formulariocreartareas").on("submit", function (e) {
        guardaryeditartareas(e);
    });
    $("#formulariocrearyeditaritems").on("submit", function (e) {
        guardaryeditaritems(e);
    });
    $.post("../controlador/licitaciones.php?op=UsuariosActivos", function (r) {
        $("#usuario_responsableitem").html(r);
        $("#usuario_responsableitem").selectpicker("refresh");
    });
    $.post("../controlador/licitaciones.php?op=Prioridad_Tarea", function (r) {
        $("#prioridad").html(r);
        $("#prioridad").selectpicker("refresh");
    });
    $.post("../controlador/licitaciones.php?op=listarEntidadesContratantes", function (r) {
        $("#entidad_contratante").html(r);
        $("#entidad_contratante").selectpicker("refresh");
    });
    $("#formulariofueaprobado").on("submit", function (e) {
        guardaryeditarfueaprobado(e);
    });
    $("#buscar_codigo_licitacion").on("keyup", function () {
        buscarCodigo();
    });
    $("#btn_otra_entidad_contratante").on("click", function () {
        var otra_entidad_contratante = $("#otra_entidad_contratante").val();
        if (otra_entidad_contratante == "") {
            alertify.error("Campo vacío");
            return;
        }
        AgregarEntidadContratante(otra_entidad_contratante);
    });
}
function buscarCodigo() {
    numero_codigo = $("#buscar_codigo_licitacion").val();
    if (numero_codigo.length >= 3) {
        $(".box_codigo_licitacion").show();
        tabla_codigos = $("#tabla_codigo_licitacion").dataTable({
            "aProcessing": true,
            "aServerSide": true,
            "dom": "tp",
            "ajax": {
                "url": "../controlador/licitaciones.php?op=buscarCodigo",
                "type": "post",
                "data": { "numero_codigo": numero_codigo },
                "dataType": "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 10,
            "order": [[0, "asc"]]
        });
    } else {
        $(".box_codigo_licitacion").hide();
    }
}
function agregarCodigo(numero_codigo) {
    window.scrollTo(0, 0);
    $(".box_codigo_licitacion").hide();
    $("#buscar_codigo_licitacion").focus();
    $("#codigo_licitacion").val($("#codigo_licitacion").val() + numero_codigo + ", ");
    $("#buscar_codigo_licitacion").val("");
    $("#tabla_codigo_licitacion").DataTable().destroy();
    $("#tabla_codigo_licitacion tbody").html("");
}
function MostrarTarea(id_licitaciones_tarea) {
    global_id_licitaciones_tarea = id_licitaciones_tarea;
    $.post("../controlador/licitaciones.php?op=mostrar_tarea", { "id_licitaciones_tarea": id_licitaciones_tarea }, function (data) {
        data = JSON.parse(data);
        if (Object.keys(data).length > 0) {
            $("#crear_tarea").html("Editar Licitación");
            $("#MymodalMostrarTarea").modal("show");
            $("#id_licitaciones_tarea").val(id_licitaciones_tarea);
            $("#nombre_tarea").val(data.nombre_tarea);
            $(".selectpicker").selectpicker("refresh");
            $(".selectpicker").selectpicker("refresh");
            $(".selectpicker").selectpicker("refresh");
            $(".selectpicker").selectpicker("refresh");
            $("#progreso_tarea").val(data.progreso_tarea);
            $(".selectpicker").selectpicker("refresh");
            $(".selectpicker").selectpicker("refresh");
            $("#prioridad").val(data.prioridad);
            $(".selectpicker").selectpicker("refresh");
            $("#fecha_inicio").val(data.fecha_inicio);
            $("#fecha_vencimiento").val(data.fecha_vencimiento);
            $("#notas").val(data.notas);
            $("#codigo_licitacion").val(data.codigo);
            $("#valor").val(data.valor);
            $("#entidad_contratante").val(data.entidad_contratante);
            $(".selectpicker").selectpicker("refresh");
            $("#facultad").val(data.facultad);
            $(".selectpicker").selectpicker("refresh");
            $("#tipo_contratacion").val(data.tipo_contratacion);
            $("#enlace_proceso").val(data.enlace_proceso);
            $("#tipo_de_proceso").val(data.tipo_de_proceso);
            $("#observaciones").val(data.observaciones);
            $("#entidad_contratante").val(data.entidad_contratante);
            $("#entidad_contratante").selectpicker("refresh");
        }
    }
    );
}
function listar_items(id_licitaciones_tarea, fecha_inicio, fecha_vencimiento) {
    global_id_licitaciones_items = id_licitaciones_tarea;
    $("#fecha_inicio_item").attr("min", fecha_inicio);
    $("#fecha_entregar_item").attr("max", fecha_vencimiento);
    $("#fecha_entregar_item").attr("min", fecha_inicio);
    $("#fecha_inicio_item").attr("max", fecha_vencimiento);
    $("#btn_volver").hide();
    $("#btnagregarcarpeta").hide();
    $("#precarga").show();
    $("#btnagregaitem").show();
    $("#btnHistoricoArchivos").show();
    $("#mostrar_items").show();
    $("#btnacomentariosglobales").show();
    $("#ocultar_boton_volver").show();
    $("#mostrar_carpeta").hide();
    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    var f = new Date();
    var fecha_hoy = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
    tabla_items = $("#tblistaitems").DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "dom": "Bfrtip",
        "buttons": [{
            "extend": "excelHtml5",
            "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
            "titleAttr": "Excel"
        }, {
            "extend": "print",
            "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
            "messageTop": '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
            "title": "Ejes",
            "titleAttr": "Print"
        }],
        "ajax": {
            "url": "../controlador/licitaciones.php?op=listar_items",
            "type": "post",
            "data": { "id_licitaciones_tarea": id_licitaciones_tarea },
            "dataType": "json",
            error: function (e) { }
        },
        "bDestroy": true,
        "iDisplayLength": 10,
        "ordering": false,
        initComplete: function (settings, json) {
            $("#precarga").hide();
            scroll(0, 0);
            $(".tooltips").tooltip();
        }
    });
}
function eliminar_licitacion(id_licitaciones_tarea) {
    const swalWithBootstrapButtons = Swal.mixin({
        "customClass": { "confirmButton": "btn btn-success", "cancelButton": "btn btn-danger" },
        "buttonsStyling": false
    });
    swalWithBootstrapButtons.fire({
        "title": "¿Está Seguro de eliminar la licitación?",
        "text": "¡No podrás revertir esto!",
        "icon": "warning",
        "showCancelButton": true,
        "confirmButtonText": "Yes, continuar!",
        "cancelButtonText": "No, cancelar!",
        "reverseButtons": true
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(
                "../controlador/licitaciones.php?op=eliminar_licitacion",
                { id_licitaciones_tarea: id_licitaciones_tarea },
                function (e) {
                    if (e != "null") {
                        swalWithBootstrapButtons.fire({
                            title: "Ejecutado!",
                            text: "Licitación eliminada con éxito.",
                            icon: "success"
                        });
                        $("#tblistatareas").DataTable().ajax.reload();
                    } else {
                        swalWithBootstrapButtons.fire({
                            title: "Ejecutado!",
                            text: "Licitación no se puede eliminar.",
                            icon: "error"
                        });
                    }
                }
            );
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "Tu proceso está a salvo :)",
                icon: "error"
            });
        }
    });
}
function estado_completado(id_licitaciones_tarea) {
    $("#MymodalEstadoCompletado").modal("show");
    $("#id_licitaciones_tarea_aprobado").val(id_licitaciones_tarea);
    mostrar_estado_completado(id_licitaciones_tarea);
    $("#porque_aprobado").val("");
    $("#aprobado").val("");
    $("#aprobado").selectpicker("refresh");
}
function mostrar_comentarios_globales(id_licitaciones_tarea) {
    $("#precarga").show();
    $.post("../controlador/licitaciones.php?op=mostrar_comentarios_globales", { "id_licitaciones_tarea": id_licitaciones_tarea }, function (e) {
        var r = JSON.parse(e);
        $("#myModalListarComentariosGlobales").modal("show");
        $("#mostrar_global_tabla").html(r);
        $("#precarga").hide();
        $("#mostrar_comentarios_globales").dataTable({
            "dom": "Bfrtip",
            "buttons": [{
                "extend": "excelHtml5",
                "text": '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                "titleAttr": "Excel"
            }]
        });
    });
}
function CrearTarea() {
    $("#formulariocreartareas")[0].reset();
    $("#crear_tarea").html("Nuevo Proceso");
    $("#listaElementos").html("");
    $("#id_licitaciones_tarea").val("");
    $("#formulariocreartareas select").val("").selectpicker("refresh");
    $("#MymodalMostrarTarea").modal("show");
    // $("#listaArchivos").html("");
    $("#listaComentarios").html("");
}
//funcion para guardar las carpetas
function guardaryeditartareas(e) {
    e.preventDefault();
    let formData = new FormData($("#formulariocreartareas")[0]);
    $.ajax({
        "url": "../controlador/licitaciones.php?op=guardaryeditartarea",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            let data = JSON.parse(datos);
            if (data["0"]["0"] == 1) {
                alertify.success("Licitación agregada");
            } else if (data["0"]["0"] == 2) {
                alertify.error("No se pudo agregar");
            } else if (data["0"]["0"] == 3) {
                alertify.success("Licitación actualizada");
            } else {
                alertify.error("Licitación no actualizada");
            }
            $("#tblistatareas").DataTable().ajax.reload();
            $("#MymodalMostrarTarea").modal("hide");
        }
    });
}
function guardaryeditarfueaprobado(e) {
    e.preventDefault();
    let formData = new FormData($("#formulariofueaprobado")[0]);
    $.ajax({
        "url": "../controlador/licitaciones.php?op=guardaryeditarfueaprobado",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            let data = JSON.parse(datos);
            if (data[0][0] == 1) {
                alertify.success("Licitación actualizado correctamente");
            } else {
                alertify.error("Error al actualizar el item");
            }
            $("#tblistatareas").DataTable().ajax.reload();
            $("#MymodalEstadoCompletado").modal("hide");
        }
    });
}
function CrearItem() {
    $("#item_crear_editar").html("Crear Item");
    $("#item_id_licitaciones_tarea").val(global_id_licitaciones_items);
    $("#nombre_elemento").val("");
    $("#fecha_inicio_item").val("");
    $("#fecha_entregar_item").val("");
    $("#crear_editar_id_licitaciones_item").val("");
    $("#usuario_responsableitem").val("");
    $("#usuario_responsableitem").selectpicker("refresh");
    $("#myModalGuardaryEditarItem").modal("show");
}
function guardaryeditaritems(e) {
    e.preventDefault();
    let formData = new FormData($("#formulariocrearyeditaritems")[0]);
    $.ajax({
        "url": "../controlador/licitaciones.php?op=guardaryeditaritems",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            let data = JSON.parse(datos);
            if (data["0"]["0"] == 1) {
                alertify.success("Item agregada");
            } else if (data["0"]["0"] == 2) {
                alertify.error("No se pudo agregar");
            } else if (data["0"]["0"] == 3) {
                alertify.success("Item actualizada");
            } else {
                alertify.error("Item no actualizada");
            }
            tabla_items.ajax.reload();
            $("#myModalGuardaryEditarItem").modal("hide");
        }
    });
}
function editarItem(id_licitaciones_item) {
    $.post("../controlador/licitaciones.php?op=mostrar_elemento", { "id_licitaciones_item": id_licitaciones_item }, function (data) {
        data = JSON.parse(data);
        $("#myModalGuardaryEditarItem").modal("show");
        $("#nombre_elemento").val(data.nombre_elemento);
        $("#crear_editar_id_licitaciones_item").val(data.id_licitaciones_item);
        $(".selectpicker").selectpicker("refresh");
        $("#usuario_responsableitem").val(data.id_usuario_responsable);
        $(".selectpicker").selectpicker("refresh");
        $("#fecha_inicio_item").val(data.fecha_inicio_item);
        $("#fecha_entregar_item").val(data.fecha_entregar_item);
        $("#item_id_licitaciones_tarea").val(global_id_licitaciones_items);
    });
}
//lista la tabla de las tareas
function listar_tareas() {
    $("#lugar_tabla").html("Crear proceso de Extensión");
    $("#precarga").show();
    // botons a ocultar
    $("#ocultar_boton_volver").hide();
    $("#btnagregaritem").hide();
    $("#btnagregaitem").hide();
    $("#btnHistoricoArchivos").hide();
    $("#btnacomentariosglobales").hide();
    $("#mostrar_items").hide();
    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    var f = new Date();
    var fecha_hoy = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
    tabla = $("#tblistatareas").dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "dom": "Bfrtip",
        "buttons": [{
            "extend": "excelHtml5",
            "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
            "titleAttr": "Excel"
        }, {
            "extend": "print",
            "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
            "messageTop": '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
            "title": "Ejes",
            "titleAttr": "Print"
        }],
        "ajax": {
            "url": "../controlador/licitaciones.php?op=listar_tareas",
            "type": "post",
            "data": {},
            "dataType": "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]],
        initComplete: function (settings, json) {
            $("#precarga").hide();
            scroll(0, 0);
            $(".tooltips").tooltip();
        }
    });
}
function guardarComentario() {
    let formData = new FormData($("#formulariocomentario")[0]); // Obtiene todos los datos del formulario
    $.ajax({
        "url": "../controlador/licitaciones.php?op=guardarcomentarioitem",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            let data = JSON.parse(datos);
            if (data.success === true) {
                alertify.success("Comentario agregado con éxito");
                // Recargamos la lista de comentarios llamando a la función con la licitacion
                let id_licitaciones_item = $(
                    "#formulariocomentario input[name='id_licitaciones_item']"
                ).val();
                mostrar_comentarios_elementos(id_licitaciones_item);
            } else {
                alertify.error(data.message || "No se pudo agregar el comentario.");
            }
        }
    });
}
function finalizarElemento(id_licitaciones_item, estado_item) {
    if (estado_item == 0) {
        guardarEstadoItem(id_licitaciones_item, estado_item, "");
    } else {
        Swal.fire({
            "title": "Indica el motivo por el cual no se cumplió",
            "input": "text",
            "inputAttributes": { "autocapitalize": "off" },
            "showCancelButton": true,
            "confirmButtonText": "Finalizar",
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result);
                guardarEstadoItem(id_licitaciones_item, estado_item, result.value);
            }
        });
    }
}
function guardarEstadoItem(id_licitaciones_item, estado_item, motivo_incumplido) {
    $.ajax({
        "url": "../controlador/licitaciones.php?op=finalizarelemento",
        "type": "POST",
        "data": { "id_licitaciones_item": id_licitaciones_item, "estado_item": estado_item, "motivo_incumplido": motivo_incumplido },
        success: function (response) {
            let data = JSON.parse(response);
            if (data.success) {
                $(`#elemento-${id_licitaciones_item}`).html(`
                        <span>${data.nombre_elemento}</span>
                        <span class="bg-success p-1 ms-2"><i class="fas fa-check-double"></i></span>
                    `);
                // listar_items(global_id_licitaciones_items);
                tabla_items.ajax.reload();
                $("#tblistatareas").DataTable().ajax.reload();
                alertify.success("Elemento finalizado correctamente.");
            }
        }
    });
}
function mostrar_comentarios_elementos(id_licitaciones_item) {
    $("#precarga").show();
    $.post(
        "../controlador/licitaciones.php?op=mostrar_comentarios_elementos",
        { id_licitaciones_item: id_licitaciones_item },
        function (e) {
            var r = JSON.parse(e);
            $("#myModalListarItems").modal("show");
            $("#mostrar_item_tabla").html(r);
            $("#precarga").hide();
            $("#mostrar_comentarios").dataTable({
                dom: "Bfrtip",
                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel"
                    }
                ]
            });
        }
    );
}
function volver() {
    $("#ocultar_boton_volver").hide();
    $("#btnagregaritem").hide();
    $("#btnagregaitem").hide();
    $("#btnHistoricoArchivos").hide();
    $("#mostrar_items").hide();
    $("#btnacomentariosglobales").hide();
    $("#mostrar_carpeta").show();
    $("#btnagregarcarpeta").show();
}
function mostrarFormularioComentario() {
    document.getElementById("formAgregarComentario").style.display = "block";
}
function ocultarFormularioComentario() {
    document.getElementById("formAgregarComentario").style.display = "none";
}
function mostrarFormularioArchivoItems() {
    document.getElementById("formAgregarArchivoItems").style.display = "block";
}
function ocultarFormularioArchivoItems() {
    document.getElementById("formAgregarArchivoItems").style.display = "none";
}
function mostrarFormularioComentarioGlobal() {
    document.getElementById("formAgregarComentarioGlobal").style.display =
        "block";
}
function ocultarFormularioComentarioGlobal() {
    document.getElementById("formAgregarComentarioGlobal").style.display = "none";
}
function eliminar_item(id_licitaciones_item) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons
        .fire({
            title: "¿Está Seguro de eliminar la licitación?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, continuar!",
            cancelButtonText: "No, cancelar!",
            reverseButtons: true
        })
        .then((result) => {
            if (result.isConfirmed) {
                $.post(
                    "../controlador/licitaciones.php?op=eliminar_item",
                    { id_licitaciones_item: id_licitaciones_item },
                    function (e) {
                        if (e != "null") {
                            swalWithBootstrapButtons.fire({
                                title: "Ejecutado!",
                                text: "Licitación eliminada con éxito.",
                                icon: "success"
                            });
                            tabla_items.ajax.reload();
                        } else {
                            swalWithBootstrapButtons.fire({
                                title: "Ejecutado!",
                                text: "Licitación no se puede eliminar.",
                                icon: "error"
                            });
                        }
                    }
                );
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "Tu proceso está a salvo :)",
                    icon: "error"
                });
            }
        });
}
function subir_archivos_item(id_licitaciones_item) {
    $("#precarga").show();
    $.post(
        "../controlador/licitaciones.php?op=subir_archivos_item",
        {
            id_licitaciones_item: id_licitaciones_item,
            global_id_licitaciones_items: global_id_licitaciones_items
        },
        function (e) {
            var r = JSON.parse(e);
            $("#myModalSubirArchivos").modal("show");
            $("#mostrar_archivos_items").html(r);
            $("#precarga").hide();
            $("#mostrar_archivo_por_items").dataTable({
                dom: "Bfrtip",
                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel"
                    }
                ]
            });
        }
    );
}
// formulario para subir los archivos por cada items.
function guardarSubirArchivoItem() {
    let formData = new FormData($("#formulariosubirArchivoItems")[0]); // Obtiene todos los datos del formulario
    $.ajax({
        url: "../controlador/licitaciones.php?op=guardarSubirArchivoItem",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            let data = JSON.parse(datos);
            // Accedemos a los datos mediante índices numéricos
            if (data[0] === true) {
                // Verificamos si la operación fue exitosa
                alertify.success(data[1]); // Mensaje de éxito
                let archivo_id_licitaciones_item = $(
                    "#formulariosubirArchivoItems input[name='archivo_id_licitaciones_item']"
                ).val();
                subir_archivos_item(archivo_id_licitaciones_item);
            } else {
                alertify.error(data[1] || "No se pudo agregar el archivo.");
            }
        }
    });
}
function mostrar_estado_completado(id_licitaciones_tarea) {
    $.post(
        "../controlador/licitaciones.php?op=mostrar_tarea",
        { id_licitaciones_tarea: id_licitaciones_tarea },
        function (data) {
            data = JSON.parse(data);
            if (Object.keys(data).length > 0) {
                $(".selectpicker").selectpicker("refresh");
                $("#aprobado").val(data.aprobado);
                $(".selectpicker").selectpicker("refresh");
                $("#porque_aprobado").val(data.porque_aprobado);
            }
        }
    );
}
function guardarComentarioGlobal() {
    let formData = new FormData($("#formulariocomentarioglobal")[0]); // Obtiene todos los datos del formulario
    $.ajax({
        url: "../controlador/licitaciones.php?op=guardarComentarioGlobal",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            let data = JSON.parse(datos);
            if (data.success === true) {
                alertify.success("Comentario agregado con éxito");
                // Recargamos la lista de comentarios llamando a la función con el id_elemento
                let id_elemento = $(
                    "#formulariocomentarioglobal input[name='id_elemento_comentario_global']"
                ).val();
                mostrar_comentarios_globales(id_elemento);
            } else {
                alertify.error(data.message || "No se pudo agregar el comentario.");
            }
        }
    });
}
function ComentariosTotales() {
    $("#precarga").show();
    $.post(
        "../controlador/licitaciones.php?op=comentarios_totales",
        { global_id_licitaciones_items: global_id_licitaciones_items },
        function (e) {
            var r = JSON.parse(e);
            $("#myModalListarComentariosTotales").modal("show");
            $("#mostrar_comentarios_totales_tabla").html(r);
            $("#precarga").hide();
        }
    );
}
function HistoricoArchivos() {
    $("#precarga").show();
    $.post(
        "../controlador/licitaciones.php?op=HistoricoArchivos",
        { global_id_licitaciones_items: global_id_licitaciones_items },
        function (e) {
            $("#precarga").hide();
            var r = JSON.parse(e);
            $("#myModalHistoricoArchivos").modal("show");
            $("#mostrar_HistoricoArchivos").html(r);
        }
    );
}
function cambiarTipoProceso(valor) {
    if (valor == "Público") {
        $(".box_buscar_codigo_licitacion").show(500);
        $(".div_codigo_licitacion").addClass("col-4");
        $(".div_codigo_licitacion").removeClass("col-12");
        $("#codigo_licitacion").attr("required", true);
        $("#codigo_licitacion").val("");
    } else {
        $.post(
            "../controlador/licitaciones.php?op=generarCodigoPrivado",
            function (data) {
                data = JSON.parse(data);
                if (data.exito == 1) {
                    $("#codigo_licitacion").val(data.codigo + ", ");
                }
            }
        );
    }
}
function verificarEntidad(nombre_entidad) {
    if (nombre_entidad == "otra") {
        $("#box_otra_entidad_contratante").show(500);
        $("#otra_entidad_contratante").attr("required", true);
    } else {
        $("#box_otra_entidad_contratante").hide(500);
        $("#otra_entidad_contratante").attr("required", false);
    }
}
function AgregarEntidadContratante(otra_entidad_contratante) {
    $("#precarga").show();
    $.post("../controlador/licitaciones.php?op=AgregarEntidadContratante", { "otra_entidad_contratante": otra_entidad_contratante }, function (e) {
        $("#precarga").hide();
        var r = JSON.parse(e);
        if (r.exito == 1) {
            alertify.success("Entidad contratante agregada con éxito");
            $("#box_otra_entidad_contratante").hide(500);
            $("#otra_entidad_contratante").val("");
            $("#otra_entidad_contratante").attr("required", false);
            $("#entidad_contratante").append(r.info);
            $("#entidad_contratante").selectpicker("refresh");
            $("#entidad_contratante").val(otra_entidad_contratante);
            $("#entidad_contratante").selectpicker("refresh");
        } else {
            alertify.error(r.info || "No se pudo agregar la entidad contratante.");
        }
    }
    );
}
init();