var tabla_categorias, tabla_preguntas;
$(document).ready(init);
//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    $("#listadoPreguntas").hide();
    listarCategorias();
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });
    $("#formularioAgregaryEditarCategoria").on("submit", function (e) {
        guardaryeditarCategoria(e);
    });
    $("#enlace_video_categoria").on("change", function () {
        enlace_video_categoria = $("#enlace_video_categoria").val();
        codigo_video = extractVideoId(enlace_video_categoria);
        $("#enlace_video_categoria").val(codigo_video);
    });
    // Evento para seleccionar la opción correcta
    $(document).on("click", ".btnSeleccionar", function () {
        // Limpiar cualquier selección previa
        $(".btnSeleccionar").removeClass("btn-success");
        // Elimina el estilo de seleccionada de los botones
        $("#opcion_correcta").val(""); // Limpia la opción previamente seleccionada
        // Marca la opción seleccionada
        var opcionSeleccionada = $(this).data("opcion");
        $(this).addClass("btn-success"); // Añade estilo para mostrar que está seleccionada
        $(this).removeClass("btn-primary"); // Añade estilo para mostrar que está seleccionada
        $("#opcion_correcta").val(opcionSeleccionada); // Guarda el nombre de la opción seleccionada
        console.log("Opción seleccionada:", opcionSeleccionada); // Verificación
    });
    // Evento para guardar los datos
    $(document).on("click", "#btnGuardar", function (event) {
        event.preventDefault(); // Prevenir el envío normal del formulario
        // Validar que la opción correcta haya sido seleccionada
        if (!$("#opcion_correcta").val()) {
            Swal.fire({
                icon: "warning",
                title: "Debe seleccionar una opción correcta."
            });
            return;
        }
        // Validar que los campos requeridos estén llenos
        if (!$("#texto_pregunta").val() || !$("#tipo_pregunta").val()) {
            Swal.fire({
                icon: "warning",
                title: "Debe completar todos los campos."
            });
            return;
        }
        // Llamar a la función para guardar
        guardaryeditar(event);
    });
    $("#ModalAgregaryEditarCategoria").on("hidden.bs.modal", function (e) {
        $("#id_induccion_docente_categoria").val("");
        $("#formularioAgregaryEditarCategoria")[0].reset();
        $("#btnGuardarCategoria").prop("disabled", false);
    })
}
function verVideo(id_induccion_docente_categoria) {
    $.post("../controlador/curso_docente.php?op=verVideo", { "id_induccion_docente_categoria": id_induccion_docente_categoria }, function (data) {
        data = JSON.parse(data);
        $("#ModalVerVideo").modal("show");
        $("#mostar_video_modal").show();
        $("#mostar_video_modal").html(data);
    }
    );
}
function extractVideoId(url) {
    let videoId = '';
    if (url.includes("youtube.com/watch?v=")) {
        videoId = url.split('v=')[1].split('&')[0];
    } else if (url.includes("youtu.be/")) {
        videoId = url.split('youtu.be/')[1].split('?')[0];
    }
    return videoId;
}
//Función limpiar
function limpiar() {
    $("#id_pregunta").val("");
    $("#texto_pregunta").val("");
    $("#tipo_pregunta").val("");
    $("#opcion1").val("");
    $("#opcion2").val("");
    $("#opcion3").val("");
    $("#opcion4").val("");
    $("#respuestaVerdadero").val("");
    $("#respuestaFalso").val("");
    $("#tipo_pregunta").selectpicker("refresh"); // Refresca el select
}
//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoPreguntas").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#listadoPreguntas").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
        $(".btnSeleccionar").removeClass("btn-success"); // Añade estilo para mostrar que está seleccionada
        $(".btnSeleccionar").addClass("btn-primary"); // Añade estilo para mostrar que está seleccionada
    }
    cambiarOpciones();
}
//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}
function volverCategorias() {
    $("#listadoPreguntas").hide();
    $("#listadoregistros").show();
}
//Función ListarCategorias
function listarCategorias() {
    tabla_categorias = $("#tbllistado").dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        "dom": "frtip", //Definimos los elementos del control de tabla
        "ajax": {
            "url": "../controlador/curso_docente.php?op=listarCategorias",
            "type": "get",
            "dataType": "json",
            error: function (e) {
                console.log(e.responseText);
                //tabla_categorias.ajax.reload();
            }
        },
        "language": {
            "search": "", // Removes the label text
            "searchPlaceholder": "Buscar..." // Adds placeholder
        },
        "bDestroy": true,
        "iDisplayLength": 10, //Paginación
        "ordering": false,
        initComplete: function (settings, json) {
            $("#precarga").hide();
        }
    }).DataTable();
}
//Función ListarPreguntas
function listarPreguntas(id_induccion_docente_categoria) {
    $("#categoria").val(id_induccion_docente_categoria);
    console.log($("#categoria").val())
    $("#listadoPreguntas").show();
    $("#listadoPreguntas").scrollTop(0);
    $("#listadoregistros").hide();
    tabla_preguntas = $("#tbllistadoPreguntas").dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        "dom": "frtip", //Definimos los elementos del control de tabla
        "ajax": {
            "url": "../controlador/curso_docente.php?op=listarPreguntas",
            "type": "POST",
            "data": { "id_induccion_docente_categoria": id_induccion_docente_categoria },
            "dataType": "json",
            error: function (e) {
                console.log(e.responseText);
                //tabla_preguntas.ajax.reload();
            }
        },
        "language": {
            "search": "", // Removes the label text
            "searchPlaceholder": "Buscar..." // Adds placeholder
        },
        "bDestroy": true,
        "iDisplayLength": 10, //Paginación
        "ordering": false,
        initComplete: function (settings, json) {
            $("#precarga").hide();
        }
    }).DataTable();
}
function mostrar(id_pregunta) {
    $.post(
        "../controlador/curso_docente.php?op=mostrar",
        { id_pregunta: id_pregunta },
        function (data, status) {
            data = JSON.parse(data);
            mostrarform(true);
            $("#id_pregunta").val(data.id_pregunta);
            $("#texto_pregunta").val(data.texto_pregunta);
            $("#opcion_correcta").val(data.opcion_correcta);
            $("#tipo_pregunta").val(data.tipo_pregunta);
            $("#tipo_pregunta").selectpicker("refresh");
            $("#categoria").val(data.categoria);
            $("button[data-opcion=" + data.opcion_correcta + "]").trigger("click");
            cambiarOpciones();
            if (data.tipo_pregunta == "multiple") {
                for (let index = 0; index < data["opciones"].length; index++) {
                    const element = data["opciones"][index];
                    $("#opcion" + (index + 1)).val(element.texto_opcion);
                }
            } else {
                $("#respuestaVerdadero").val(data["opciones"][0].texto_opcion);
                $("#respuestaFalso").val(data["opciones"][1].texto_opcion);
            }
        }
    );
}
function mostrarCategoria(id_induccion_docente_categoria) {
    $.post("../controlador/curso_docente.php?op=mostrarCategoria", { "id_induccion_docente_categoria": id_induccion_docente_categoria }, function (data, status) {
        data = JSON.parse(data);
        console.log("data:", data);
        $("#ModalAgregaryEditarCategoria").modal("show");
        $("#id_induccion_docente_categoria").val(data.id_induccion_docente_categoria);
        $("#nombre_categoria").val(data.nombre_categoria);
        $("#enlace_video_categoria").val(data.enlace_video_categoria);
    });
}
function eliminarCategoria(id_induccion_docente_categoria) {
    const swalWithBootstrapButtons = Swal.mixin({ "customClass": { "confirmButton": "btn btn-success", "cancelButton": "btn btn-danger" }, " buttonsStyling": false });
    swalWithBootstrapButtons.fire({ "title": "¿Está Seguro?", "text": "Al eliminar la categoria, tambien eliminarás las preguntas", "icon": "warning", "showCancelButton": true, "confirmButtonText": "Si, continuar!", "cancelButtonText": "No, cancelar!", "reverseButtons": true }).then(result => {
        if (result.isConfirmed) {
            $.post("../controlador/curso_docente.php?op=eliminarCategoria", { "id_induccion_docente_categoria": id_induccion_docente_categoria },
                function (e) {
                    data = JSON.parse(e);
                    if (data.exito == 1) {
                        swalWithBootstrapButtons.fire({
                            title: "Eliminada!", text: data.info, icon: "success"
                        });
                        tabla_categorias.ajax.reload();
                    } else {
                        swalWithBootstrapButtons.fire({
                            title: "Error!",
                            text: data.info,
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
function iniciarTour() {
    introJs().setOptions(
            { nextLabel: "Siguiente", prevLabel: "Anterior", doneLabel: "Terminar", showBullets: false, showProgress: true, showStepNumbers: true, steps: [
                    {
                        title: "Curso Docente",
                        intro:
                            "Bienvenido a nuestra gestión de usuarios que hacen parte de nuestra comunidad CIAF"
                    }
                ]
            },
            console.log()
        )
        .start();
}
function eliminar(id_pregunta) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons
        .fire({
            title: "¿Está Seguro de eliminar esta pregunta?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, continuar!",
            cancelButtonText: "No, cancelar!",
            reverseButtons: true
        })
        .then(result => {
            if (result.isConfirmed) {
                $.post(
                    "../controlador/curso_docente.php?op=eliminar",
                    {
                        id_pregunta: id_pregunta
                    },
                    function (e) {
                        data = JSON.parse(e);
                        if (data.exito == 1) {
                            swalWithBootstrapButtons.fire({
                                title: "Ejecutado!",
                                text: data.info,
                                icon: "success"
                            });
                            tabla_preguntas.ajax.reload();
                        } else {
                            swalWithBootstrapButtons.fire({
                                title: "Error!",
                                text: data.info,
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
function cambiarOpciones() {
    const tipoPregunta = document.getElementById("tipo_pregunta").value;
    const opcionesMultiples = document.getElementById("opcionesMultiples");
    const opcionesFalsoVerdadero = document.getElementById(
        "opcionesFalsoVerdadero"
    );
    if (tipoPregunta === "multiple") {
        opcionesMultiples.style.display = "block";
        opcionesFalsoVerdadero.style.display = "none";
    } else if (tipoPregunta === "falsoVerdadero") {
        opcionesMultiples.style.display = "none";
        opcionesFalsoVerdadero.style.display = "block";
    } else {
        opcionesMultiples.style.display = "none";
        opcionesFalsoVerdadero.style.display = "none";
    }
}
// Función para guardar y editar
function guardaryeditar(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../controlador/curso_docente.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log("Respuesta del servidor:", datos);
            try {
                let data = JSON.parse(datos);
                if (data.exito == "1") {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: data.info,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    limpiar();
                    mostrarform(false);
                    tabla_preguntas.ajax.reload();
                } else if (data.exito == "0") {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: data.info,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            } catch (error) {
                console.error("Error al procesar la respuesta: ", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al procesar la respuesta."
                });
            }
        }
    });
}
// Función para guardar y editar
function guardaryeditarCategoria(e) {
    e.preventDefault();
    $("#btnGuardarCategoria").prop("disabled", true);
    var formData = new FormData($("#formularioAgregaryEditarCategoria")[0]);
    $.ajax({
        "url": "../controlador/curso_docente.php?op=guardaryeditarCategoria",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            try {
                let data = JSON.parse(datos);
                if (data.exito == "1") {
                    $("#ModalAgregaryEditarCategoria").modal("hide");
                    Swal.fire({ "position": "top-end", "icon": "success", "title": data.info, "showConfirmButton": false, "timer": 1500 });
                    tabla_categorias.ajax.reload();
                    $("#btnGuardarCategoria").prop("disabled", false);
                } else if (data.exito == "0") {
                    Swal.fire({ "position": "top-end", "icon": "error", "title": data.info, "showConfirmButton": false, "timer": 1500 });
                }
            } catch (error) {
                console.error("Error al procesar la respuesta: ", error);
                Swal.fire({ "icon": "error", "title": "Error", "text": "Hubo un problema al procesar la respuesta." });
            }
        }
    });
}