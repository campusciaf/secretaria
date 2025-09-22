var tabla;
var api; // variable global para inicializar el responsive
var anchoVentana = window.innerWidth; // ancho de la ventana
const params = new URLSearchParams(window.location.search);
const global_id_docente_grupo= params.get("id");


function init() {
  $("#programaractividades").hide();
  $("#glosario").hide();
  //Cargamos los items de los selects
  $.post("../controlador/peadocente.php?op=selectTipoArchivo", function (data) {
    data = JSON.parse(data);
    $("#tipo_archivo").html("");
    $("#tipo_archivo").append(data["0"]["0"]);
    // $('#tipo_archivo').selectpicker('refresh');
  });

  $("#formulario").on("submit", function (e) {
    guardaryeditar(e);
  });

  $("#formulariocrearcarpeta").on("submit", function (e2) {
    guardaryeditaracarpeta(e2);
  });

  $("#formulariocreardocumento").on("submit", function (e3) {
    guardaryeditardocumento(e3);
  });

  $("#formulariocrearenlace").on("submit", function (e4) {
    guardaryeditarenlace(e4);
  });
  $("#formulariocrearglosario").on("submit", function (e5) {
    guardaryeditarglosario(e5);
  });

  $("#formulariocrearcarpetaejercicios").on("submit", function (e6) {
    guardaryeditaracarpetaejercicios(e6);
  });

  $("#formulariocrearejercicios").on("submit", function (e7) {
    guardaryeditarejercicios(e7);
  });

  $("#formulariocreardocumentolink").on("submit", function (e8) {
    guardaryeditardocumentolink(e8);
  });

  $("#formulariocrearvideo").on("submit", function (e9) {
    guardaryeditarvideo(e9);
  });
}

// ************************************* //
function listar(id_materia, id_programa, id_docente_grupo) {
  $("#precarga").show();
  $.post(
    "../controlador/peadocente.php?op=listar",
    {
      id_materia: id_materia,
      id_programa: id_programa,
      id_docente_grupo: id_docente_grupo,
    },
    function (data) {
      data = JSON.parse(data);
      $("#listadopea").html("");
      $("#listadopea").append(data["0"]["0"]);
      $("#precarga").hide();

      $(".post-module").hover(function () {
        $(this).find(".description").stop().animate(
          {
            height: "toggle",
            opacity: "toggle",
          },
          300
        );
      });
    }
  );
}

//Función Listar
function programartemas(id_tema, id_docente_grupo) {
  $("#listadoregistros").hide();

  $.post(
    "../controlador/peadocente.php?op=listaractividades",
    { id_tema: id_tema, id_docente_grupo: id_docente_grupo },
    function (data, status) {
      data = JSON.parse(data);
      $("#programaractividades").show();
      $("#listadosactividades").html("");
      $("#listadosactividades").append(data["0"]["0"]);
      $("#id_tema").val(id_tema);
      $("#id_docente_grupo").val(id_docente_grupo);
    }
  );
}

function volver() {
  $("#listadoregistros").show();
  $("#programaractividades").hide();
  $("#listadosactividades").html("");
}

//Función agregar actividad
function agregaractividad(tipo) {
  $("#myModalActividad").modal("show");
  $("#tipo_archivo_id").val(tipo);
  if (tipo == 1 || tipo == 2) {
    $("#campo").html(
      "<label>Imagen:</label><input type='file' class='form-control' name='archivo' id='archivo'><input type='hidden' name='archivoactual' id='archivoactual'><img src='' width='150px' height='120px' id='archivomuestra'>"
    );
  } else if (tipo == 3) {
    $("#campo").html(
      "<label>Link del Vídeo:</label><input type='text' class='form-control' name='archivo' id='archivo'></input>"
    );
  } else {
    $("#campo").html(
      "<label>Link del Archivo:</label><input type='text' class='form-control' name='archivo' id='archivo'></input>"
    );
  }
}

function guardaryeditar(e) {
  e.preventDefault(); //No se activará la acción predeterminada del evento
  var id_tema = $("#id_tema").val();
  var id_docente_grupo = $("#id_docente_grupo").val();
  $("#btnGuardar").prop("disabled", true);
  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "../controlador/peadocente.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      alertify.success(datos);
      $("#myModalActividad").modal("hide");
      programartemas(id_tema, id_docente_grupo);
      $("#btnGuardar").prop("disabled", false);
    },
  });
  limpiar();
}
function guardaryeditaracarpeta(e2) {
  e2.preventDefault(); //No se activará la acción predeterminada del evento

  $("#btnCrearCarpeta").prop("disabled", true);
  var formData = new FormData($("#formulariocrearcarpeta")[0]);

  $.ajax({
    url: "../controlador/peadocente.php?op=guardaryeditarcarpeta",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      data = JSON.parse(datos);
      if (data["0"]["0"] == 1) {
        alertify.success("Carpeta agregado");
      } else if (data["0"]["0"] == 2) {
        alertify.error("No se pudo agregar");
      } else if (data["0"]["0"] == 3) {
        alertify.success("Carpeta actualizada");
      } else {
        alertify.error("Carpeta no actualizada");
      }
      documentos(data["0"]["1"]);
      $("#carpetadocumento").modal("hide");
      $("#carpeta").val("");
      $("#btnCrearCarpeta").prop("disabled", false);
    },
  });
  limpiar();
}
function guardaryeditardocumento(e3) {
  e3.preventDefault(); //No se activará la acción predeterminada del evento

  $("#btnCrearDocumento").prop("disabled", true);
  var formData = new FormData($("#formulariocreardocumento")[0]);

  $.ajax({
    url: "../controlador/peadocente.php?op=guardaryeditardocumento",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      data = JSON.parse(datos);

      var id_materia=$("#id_materia_documento").val();
      var id_programa = $("#id_programa_documento").val();
      var id_pea = $("#id_pea_documento").val();
      var id_tema = $("#id_tema_documento").val();
      var id_pea_docente = $("#id_pea_docentes_subir").val();
      var ciclo = $("#ciclo_documento").val();

      if (data["0"]["0"] == 1) {
        alertify.success("Documento agregado");
        agregarrecurso(id_materia,id_programa,id_pea,id_tema,id_pea_docente,ciclo);
      } else if (data["0"]["0"] == 2) {
        alertify.error("No se pudo agregar");
      } else if (data["0"]["0"] == 3) {
        alertify.success("Documento actualizado");
        agregarrecurso(id_materia,id_programa,id_pea,id_tema,id_pea_docente,ciclo);
      } else if (data["0"]["0"] == 4) {
        alertify.error("Documento no actualizado");
      } else {
        alertify.error("Error de formato");
      }

      $("#subirdocumento").modal("hide");
      $("#nombre_documento").val("");
      $("#descripcion_documento").val("");
      $("#tipo").val("");
      $("#btnCrearDocumento").prop("disabled", false);
    },
  });
}
function guardaryeditardocumentolink(e8) {
  e8.preventDefault(); //No se activará la acción predeterminada del evento

  $("#btnCrearDocumentolink").prop("disabled", true);
  var formData = new FormData($("#formulariocreardocumentolink")[0]);

  $.ajax({
    url: "../controlador/peadocente.php?op=guardaryeditardocumentolink",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      data = JSON.parse(datos);
      var id_materia=$("#id_materia_subirlink").val();
      var id_programa = $("#id_programa_subirlink").val();
      var id_pea = $("#id_pea_documentolink").val();
      var id_tema = $("#id_tema_subirlink").val();
      var id_pea_docente = $("#id_pea_docentes_subirlink").val();
      var ciclo = $("#ciclo_subirlink").val();

      if (data["0"]["0"] == 1) {
        alertify.success("Documento agregado");
        agregarrecurso(id_materia,id_programa,id_pea,id_tema,id_pea_docente,ciclo);
      } else if (data["0"]["0"] == 2) {
        alertify.error("No se pudo agregar");
      } else if (data["0"]["0"] == 3) {
        alertify.success("Documento actualizado");
        agregarrecurso(id_materia,id_programa,id_pea,id_tema,id_pea_docente,ciclo);
      } else if (data["0"]["0"] == 4) {
        alertify.error("Documento no actualizado");
      } else {
        alertify.error("Error de formato");
      }

      $("#subirdocumentolink").modal("hide");
      $("#nombre_documentolink").val("");
      $("#descripcion_documentolink").val("");
      $("#tipolink").val("");
      $("#btnCrearDocumentolink").prop("disabled", false);
    },
  });
}

function guardaryeditarvideo(e9) {
  e9.preventDefault(); //No se activará la acción predeterminada del evento

  $("#btnCrearVideo").prop("disabled", true);
  var formData = new FormData($("#formulariocrearvideo")[0]);

  $.ajax({
    url: "../controlador/peadocente.php?op=guardaryeditarvideo",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: async function (datos) {
      data = JSON.parse(datos);

      var id_materia=$("#id_materia_video").val();
      var id_programa = $("#id_programa_video").val();
      var id_pea = $("#id_pea_video").val();
      var id_tema = $("#id_tema_video").val();
      var id_pea_docente = $("#id_pea_docentes_video").val();
      var ciclo = $("#ciclo_video").val();

      if (data["0"]["0"] == 1) {
        alertify.success("Video agregado");
        await agregarrecurso(id_materia,id_programa,id_pea,id_tema,id_pea_docente,ciclo);
      } else if (data["0"]["0"] == 2) {
        alertify.error("No se pudo agregar");
      } else if (data["0"]["0"] == 3) {
        alertify.success("Video actualizado");
        agregarrecurso(id_materia,id_programa,id_pea,id_tema,id_pea_docente,ciclo);
      } else if (data["0"]["0"] == 4) {
        alertify.error("Video no actualizado");
      } 
      else if (data["0"]["0"] == 5) {
        alertify.success("Guardo pero no cambio nada");
      } 
      else {
        alertify.error("Error de formato");
      }

      $("#subirvideo").modal("hide");
      $("#titulo_video").val("");
      $("#descripcion_video").val("");
      $("#tipo_video").val("");
      $("#btnCrearVideo").prop("disabled", false);
    },
  });
}


function guardaryeditarenlace(e4) {
  e4.preventDefault(); //No se activará la acción predeterminada del evento

  $("#btnCrearEnlace").prop("disabled", true);
  var formData = new FormData($("#formulariocrearenlace")[0]);

  $.ajax({
    url: "../controlador/peadocente.php?op=guardaryeditarenlace",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      data = JSON.parse(datos);
      var id_materia=$("#id_materia_enlace").val();
      var id_programa = $("#id_programa_enlace").val();
      var id_pea = $("#id_pea_enlaces").val();
      var id_tema = $("#id_tema_enlace").val();
      var id_pea_docente = $("#id_pea_docentes_enlace").val();
      var ciclo = $("#ciclo_enlace").val();


      if (data["0"]["0"] == 1) {
        alertify.success("Enlace agregado");
        agregarrecurso(id_materia,id_programa,id_pea,id_tema,id_pea_docente,ciclo);
      } else if (data["0"]["0"] == 2) {
        alertify.error("No se pudo agregar");
      } else if (data["0"]["0"] == 3) {
        alertify.success("Enlace actualizado");
        agregarrecurso(id_materia,id_programa,id_pea,id_tema,id_pea_docente,ciclo);
      } else if (data["0"]["0"] == 4) {
        alertify.error("Enlace no actualizado");
      } else {
        alertify.error("Error de formato");
      }

    

      $("#crearEnlaces").modal("hide");
      $("#titulo_enlace").val("");
      $("#descripcion_enlace").val("");
      $("#enlace").val("");
      $("#id_pea_docentes_enlace").val("");
      $("#id_pea_enlaces").val("");
      $("#btnCrearEnlace").prop("disabled", false);

      
     
    },
  });
}
function guardaryeditarglosario(e5) {
  e5.preventDefault(); //No se activará la acción predeterminada del evento

  $("#btnCrearGlosario").prop("disabled", true);
  var formData = new FormData($("#formulariocrearglosario")[0]);

  $.ajax({
    url: "../controlador/peadocente.php?op=guardaryeditarglosario",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      data = JSON.parse(datos);

      var id_materia=$("#id_materia_glosario").val();
      var id_programa = $("#id_programa_glosario").val();
      var id_pea = $("#id_pea_glosario").val();
      var id_tema = $("#id_tema_glosario").val();
      var id_pea_docente = $("#id_pea_docentes_glosario").val();
      var ciclo = $("#ciclo_glosario").val();


      if (data["0"]["0"] == 1) {
        alertify.success("Glosario agregado");
        agregarrecurso(id_materia,id_programa,id_pea,id_tema,id_pea_docente,ciclo);
      } else if (data["0"]["0"] == 2) {
        alertify.error("No se pudo agregar");
      } else if (data["0"]["0"] == 3) {
        alertify.success("Glosario actualizado");
         agregarrecurso(id_materia,id_programa,id_pea,id_tema,id_pea_docente,ciclo);
      } else if (data["0"]["0"] == 4) {
        alertify.error("Glosario no actualizado");
      } else {
        alertify.error("Error de formato");
      }
 
      $("#crearGlosario").modal("hide");
      $("#titulo_glosario").val("");
      $("#definicion_glosario").val("");
      $("#id_pea_docentes_glosario").val("");
      $("#id_pea_glosario").val("");
      $("#btnCrearGlosario").prop("disabled", false);


    },
  });
}
function guardaryeditaracarpetaejercicios(e6) {
  e6.preventDefault(); //No se activará la acción predeterminada del evento

  $("#btnCrearCarpetaEjercicios").prop("disabled", true);
  var formData = new FormData($("#formulariocrearcarpetaejercicios")[0]);

  $.ajax({
    url: "../controlador/peadocente.php?op=guardaryeditarcarpetaejercicios",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      data = JSON.parse(datos);
      if (data["0"]["0"] == 1) {
        alertify.success("Carpeta agregado");
      } else if (data["0"]["0"] == 2) {
        alertify.error("No se pudo agregar");
      } else if (data["0"]["0"] == 3) {
        alertify.success("Carpeta actualizada");
      } else {
        alertify.error("Carpeta no actualizada");
      }

      ejercicios(data["0"]["1"]);
      $("#carpetaejercicios").modal("hide");
      $("#carpeta_ejercicios").val("");
      $("#btnCrearCarpetaEjercicios").prop("disabled", false);
    },
  });
  limpiar();
}

function guardaryeditarejercicios(e7) {
  e7.preventDefault(); //No se activará la acción predeterminada del evento

  $("#btnCrearEjercicios").prop("disabled", true);
  var formData = new FormData($("#formulariocrearejercicios")[0]);

  $.ajax({
    url: "../controlador/peadocente.php?op=guardaryeditarejercicios",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      data = JSON.parse(datos);
      if (data["0"]["0"] == 1) {
        alertify.success("Ejercicio agregado");
      } else if (data["0"]["0"] == 2) {
        alertify.error("No se pudo agregar");
      } else if (data["0"]["0"] == 3) {
        alertify.success("Ejercicio actualizado");
      } else if (data["0"]["0"] == 4) {
        alertify.error("Ejercicios no actualizado");
      } else if (data["0"]["0"] == 5) {
        alertify.error("Error de formato");
      } else {
        alertify.error("Supera el 100%");
      }

      ejercicios(data["0"]["1"]);
      $("#subirejercicios").modal("hide");
      $("#nombre_ejercicios").val("");
      $("#descripcion_ejercicios").val("");
      $("#tipo_archivo_ejercicios").val("");
      $("#archivo_ejercicios").val("");
      $("#fecha_inicio").val("");
      $("#fecha_entrega").val("");
      $("#por_ejercicios").val("");
      $("#btnCrearEjercicios").prop("disabled", false);
    },
  });
}

function limpiar() {
  $("#nombre_actividad").val("");
  $("#descripcion_actividad").val("");
}

function mostrar(id_pea_actividades, tipo) {
  $.post(
    "../controlador/peadocente.php?op=mostrar",
    { id_pea_actividades: id_pea_actividades },
    function (data, status) {
      agregaractividad(tipo);
      data = JSON.parse(data);
      $("#myModalActividad").modal("show");

      $("#nombre_actividad").val(data.nombre_actividad);
      $("#descripcion_actividad").val(data.descripcion_actividad);
      $("#descripcion_actividad").val(data.descripcion_actividad);

      if (tipo == 1 || tipo == 2) {
        $("#archivomuestra").attr(
          "src",
          "../files/pea/" + data.archivo_actividad
        );
        $("#archivoactual").val(data.archivo_actividad);
      } else {
        $("#archivo").val(data.archivo_actividad);
      }

      $("#id_pea_actividades").val(data.id_pea_actividades);
    }
  );
}

//Función para eliminar actividades
function eliminar(id_pea_actividades, tipo, id_tema, id_docente_grupo) {
  alertify.confirm(
    "Eliminar la actividad del Pea",
    "¿Está Seguro de eliminar la actividad del Pea?",
    function () {
      $.post(
        "../controlador/peadocente.php?op=eliminar",
        { id_pea_actividades: id_pea_actividades, tipo: tipo },
        function (data) {
          data = JSON.parse(data);

          if (data == true) {
            programartemas(id_tema, id_docente_grupo);
          }
        }
      );
    },
    function () {
      alertify.error("Cancelado");
    }
  );
}

function descripcion(id_pea) {
  $("#precarga").show();
  $.post(
    "../controlador/peadocente.php?op=descripcion",
    { id_pea: id_pea },
    function (data) {
      data = JSON.parse(data);
      $("#descripcion").html("");
      $("#descripcion").append(data["0"]["0"]);
      $("#listadopea").hide();
      $("#documentos").hide();
      $("#descripcion").show();

      $("#precarga").hide();
    }
  );
}

function documentos(id_pea_docente) {
  $("#precarga").show();
  $.post(
    "../controlador/peadocente.php?op=documentos",
    { id_pea_docente: id_pea_docente },
    function (data) {
      data = JSON.parse(data);
      $("#documentos").html("");
      $("#documentos").append(data["0"]["0"]);
      $("#listadopea").hide();
      $("#descripcion").hide();
      $("#documentos").show();

      $("#precarga").hide();

      $(".post-module").hover(function () {
        $(this).find(".description").stop().animate(
          {
            height: "toggle",
            opacity: "toggle",
          },
          300
        );
      });
    }
  );
}

function volverContenidos() {
  $("#listadopea").show();
  $("#descripcion").hide();
  $("#documentos").hide();
  $("#enlaces").hide();
  $("#ejercicios").hide();
  $("#glosario").hide();
}

function carpetaDocumento(id_pea_docente) {
  $("#carpetadocumento").modal("show");
  $("#id_pea_docentes").val(id_pea_docente);
  $("#id_pea_documento_carpeta").val("");
  $("#carpeta").val("");
}

function editarCarpetaDocumento(id_pea_documento_carpeta, id_pea_docente) {
  $.post(
    "../controlador/peadocente.php?op=editarCarpetaDocumento",
    { id_pea_documento_carpeta: id_pea_documento_carpeta },
    function (data) {
      data = JSON.parse(data);
      $("#carpetadocumento").modal("show");
      $("#id_pea_docentes").val(id_pea_docente);
      $("#id_pea_documento_carpeta").val(id_pea_documento_carpeta);
      $("#carpeta").val(data.carpeta);
    }
  );
}

function editarCarpetaEjercicios(id_pea_ejercicios_carpeta, id_pea_docente) {
  $.post(
    "../controlador/peadocente.php?op=editarCarpetaEjercicios",
    { id_pea_ejercicios_carpeta: id_pea_ejercicios_carpeta },
    function (data) {
      data = JSON.parse(data);
      $("#carpetaejercicios").modal("show");
      $("#id_pea_docentes_ejercicios_carpeta").val(id_pea_docente);
      $("#id_pea_ejercicios_carpeta").val(id_pea_ejercicios_carpeta);
      $("#carpeta_ejercicios").val(data.carpeta_ejercicios);
    }
  );
}

function archivo(ciclo,tipo, id_pea_docentes_subir, id_tema_documento,  id_materia,id_programa) {
  $("#subirdocumento").modal("show");
  $("#id_pea_documento").val("");
  $("#id_tema_documento").val(id_tema_documento);
  $("#id_pea_docentes_subir").val(id_pea_docentes_subir);
  $("#archivo_documento").val("");
  $("#nombre_documento").val("");
  $("#descripcion_documento").val("");
  $("#tipo").val(tipo);

  $("#id_materia_documento").val(id_materia);
  $("#id_programa_documento").val(id_programa);
  $("#ciclo_documento").val(ciclo);

  $("#condicion_finalizacion_documento").val(1);
    // Reset radios de tipo_condicion_documento
  $("input[name='tipo_condicion_documento']").prop("checked", false);
  $("#contenedor_tipo_condicion_documento").hide(); // Ocultar el contenedor
  $("#fecha_inicio_documento").val("");
  $("#fecha_limite_documento").val("");
  $("#porcentaje_documento").val(0);
  $("#otorgar_puntos_documento").val(0);
  $("#puntos_actividad_documento").val("");

}

function archivolink(ciclo,tipo, id_pea_docente, id_tema_documento,  id_materia,id_programa) {
  $("#subirdocumentolink").modal("show");
  $("#id_pea_documentolink").val("");
  $("#id_tema_subirlink").val(id_tema_documento);
  $("#id_pea_docentes_subirlink").val(id_pea_docente);
  $("#archivo_documentolink").val("");

  $("#nombre_documentolink").val("");
  $("#descripcion_documentolink").val("");
  $("#tipolink").val(tipo);

  $("#id_materia_subirlink").val(id_materia);
  $("#id_programa_subirlink").val(id_programa);
  $("#ciclo_subirlink").val(ciclo);
}

function archivovideo(ciclo,tipo, id_pea_docentes, id_tema_video,  id_materia,id_programa) {
  $("#subirvideo").modal("show");
  $("#id_pea_video").val("");
  $("#id_tema_video").val(id_tema_video);
  $("#id_pea_docentes_video").val(id_pea_docentes);

  $("#titulo_video").val("");
  $("#descripcion_video").val("");
  $("#tipo_video").val(tipo);

  $("#id_materia_video").val(id_materia);
  $("#id_programa_video").val(id_programa);
  $("#ciclo_video").val(ciclo);

  $("#condicion_finalizacion_video").val(1);
    // Reset radios de tipo_condicion_video
  $("input[name='tipo_condicion_video']").prop("checked", false);
  $("#contenedor_tipo_condicion_video").hide(); // Ocultar el contenedor
  $("#fecha_inicio_video").val("");
  $("#fecha_limite_video").val("");
  $("#porcentaje_video").val(0);
  $("#otorgar_puntos_video").val(0);
  $("#puntos_actividad_video").val("");

}

function mostrarMiniatura() {
  let url = document.getElementById("url_video").value;
  let videoId = "";

  // 1. Extraer el ID del video de YouTube (soporta varias formas de URL)
  let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=)([^#\&\?]*).*/;
  let match = url.match(regExp);

  if (match && match[2].length == 11) {
    videoId = match[2];
    // 2. Construir la miniatura
    document.getElementById("preview").innerHTML = `
      <img src="https://img.youtube.com/vi/${videoId}/hqdefault.jpg" 
           alt="Miniatura del video" width="100%" style="border:1px solid #ccc; border-radius:8px;">
    `;
  } else {
    // Si no es una URL válida, limpiar preview
    document.getElementById("preview").innerHTML = "";
  }
}

function editarArchivo(id_pea_documento, id_pea_docentes_subir) {
  $.post(
    "../controlador/peadocente.php?op=editarArchivo",
    { id_pea_documento: id_pea_documento },
    function (data) {
      data = JSON.parse(data);
      $("#subirdocumento").modal("show");
      $("#id_pea_documento").val(id_pea_documento);
      $("#id_pea_documento_carpeta_subir").val("");
      $("#id_pea_docentes_subir").val(id_pea_docentes_subir);
      $("#tipo").val(data.tipo_archivo);
      $("#nombre_documento").val(data.nombre_documento);
      $("#descripcion_documento").val(data.descripcion_documento);
      $("#archivo_documento").val("");
      $("#imagenmuestra").show();

      $("#imagenmuestra").html("");
      $("#imagenmuestra").append(data.archivo_documento);
      $("#imagenactual").val(data.archivo_documento);


      $("#id_tema_documento").val(data.id_tema);
      $("#id_materia_documento").val(data.id_materia);
      $("#id_programa_documento").val(data.id_programa);
      $("#ciclo_documento").val(data.ciclo);

          // Asignar valores a los campos del formulario desde data
      $("#condicion_finalizacion_documento").val(data.condicion_finalizacion_documento);

      // Mostrar el bloque de tipo_condicion si corresponde
      if (data.condicion_finalizacion_documento == "3") {
          $("#contenedor_tipo_condicion_documento").show();
          $("input[name='tipo_condicion_documento'][value='" + data.tipo_condicion_documento + "']").prop("checked", true);
      } else {
          $("#contenedor_tipo_condicion_documento").hide();
      }

      // Asignar fechas
      $("#fecha_inicio_documento").val(data.fecha_inicio_documento);
      $("#fecha_limite_documento").val(data.fecha_limite_documento);

      // Porcentaje
      $("#porcentaje_documento").val(data.porcentaje_documento);

      // Quiere otorgar puntos
      $("#otorgar_puntos_documento").val(data.otorgar_puntos_documento);

      // Mostrar el campo de puntos si corresponde
      $("#otorgar_puntos_documento").val(data.otorgar_puntos_documento);
      if (data.otorgar_puntos_documento == "1") {
          $("#campo_puntos_documento").show();
          $("#puntos_actividad_documento").val(data.puntos_actividad_documento);
      } else {
          $("#campo_puntos_documento").hide();
          $("#puntos_actividad_documento").val(""); // o puedes forzarlo a 0 si lo prefieres
      }


    }
  );
}



function editarArchivoLink(id_pea_documento, id_pea_docentes_subir) {
  $.post(
    "../controlador/peadocente.php?op=editarArchivo",
    { id_pea_documento: id_pea_documento },
    function (data) {
      data = JSON.parse(data);
      $("#subirdocumentolink").modal("show");
      $("#id_pea_documentolink").val(id_pea_documento);
      $("#id_pea_documento_carpeta_subirlink").val("");
      $("#id_pea_docentes_subirlink").val(id_pea_docentes_subir);
      $("#tipolink").val(data.tipo_archivo);
      $("#nombre_documentolink").val(data.nombre_documento);
      $("#descripcion_documentolink").val(data.descripcion_documento);
      $("#archivo_documentolink").val(data.archivo_documento);

      $("#id_tema_subirlink").val(data.id_tema);
      $("#id_materia_subirlink").val(data.id_materia);
      $("#id_programa_subirlink").val(data.id_programa);
      $("#ciclo_subirlink").val(data.ciclo);
    }
  );
}

//Función para eliminar archivo
function eliminarArchivo(id_pea_documento, mifila) {
  alertify.confirm(
    "Eliminar Archivo",
    "¿Está Seguro de eliminar el archivo?",
    function () {
      $.post(
        "../controlador/peadocente.php?op=eliminarArchivo",
        { id_pea_documento: id_pea_documento },
        function (data) {
          data = JSON.parse(data);

          if (data["0"]["0"] == 1) {
            alertify.success("Documento Eliminado");
           $("#mifila"+mifila).hide();
          } else {
            alertify.error("No sepuede eliminar");
          }
        }
      );
    },
    function () {
      alertify.error("Cancelado");
    }
  );
}

function eliminarVideo(id_pea_video, mifila) {
  alertify.confirm(
    "Eliminar Video",
    "¿Está Seguro de eliminar el video?",
    function () {
      $.post(
        "../controlador/peadocente.php?op=eliminarVideo",
        { id_pea_video: id_pea_video },
        function (data) {
          data = JSON.parse(data);

          if (data["0"]["0"] == 1) {
            alertify.success("Video Eliminado");
           $("#mifila"+mifila).remove();
          } else {
            alertify.error("No sepuede eliminar");
          }
        }
      );
    },
    function () {
      alertify.error("Cancelado");
    }
  );
}

//Función para eliminar archivo
function eliminarArchivoLink(id_pea_documento, mifila) {
  alertify.confirm(
    "Eliminar Archivo",
    "¿Está Seguro de eliminar el archivo?",
    function () {
      $.post(
        "../controlador/peadocente.php?op=eliminarArchivoLink",
        { id_pea_documento: id_pea_documento },
        function (data) {
          data = JSON.parse(data);

          if (data["0"]["0"] == 1) {
            alertify.success("Documento eliminado");
            $("#mifila"+mifila).hide();
          } else {
            alertify.error("No sepuede eliminar");
          }
        }
      );
    },
    function () {
      alertify.error("Cancelado");
    }
  );
}

//Función para eliminar enlace
function eliminarEnlace(id_pea_enlaces,mifila) {
  alertify.confirm(
    "Eliminar Enlace",
    "¿Está Seguro de eliminar el enlace?",
    function () {
      $.post(
        "../controlador/peadocente.php?op=eliminarEnlace",
        { id_pea_enlaces: id_pea_enlaces },
        function (data) {
          data = JSON.parse(data);

          if (data["0"]["0"] == 1) {
            alertify.success("Enlace eliminado");
            $("#mifila"+mifila).hide();
          } else {
            alertify.error("No sepuede eliminar");
          }
        }
      );
    },
    function () {
      alertify.error("Cancelado");
    }
  );
}

function archivoEjercicios(tipo, id_pea_ejercicios_carpeta, id_pea_docentes) {
  $("#subirejercicios").modal("show");
  $("#id_pea_ejercicios").val("");
  $("#id_pea_ejercicios_carpeta_subir").val(id_pea_ejercicios_carpeta);
  $("#id_pea_docente_subir_ejercicios").val(id_pea_docentes);
  $("#archivo_ejercicios").val("");

  $("#nombre_ejercicios").val("");
  $("#descripcion_ejercicios").val("");
  $("#tipo_archivo_ejercicios").val(tipo);
  $("#fecha_inicio").val("");
  $("#fecha_entrega").val("");
  $("#por_ejercicios").val("");
}

//Función para eliminar glosario
function eliminarGlosario(id_pea_glosario,mifila) {
  alertify.confirm(
    "Eliminar glosario",
    "¿Está Seguro de eliminar el glosario?",
    function () {
      $.post(
        "../controlador/peadocente.php?op=eliminarGlosario",
        { id_pea_glosario: id_pea_glosario },
        function (data) {
          data = JSON.parse(data);

          if (data["0"]["0"] == 1) {
            alertify.success("Glosario eliminado");
            $("#mifila"+mifila).hide();
          } else {
            alertify.error("No sepuede eliminar");
          }
        }
      );
    },
    function () {
      alertify.error("Cancelado");
    }
  );
}

//Función Listar los estudiantes que descargaron algun documento
function verDescargas(id_pea_documento) {
  $("#verDescargas").modal("show");

  var meses = new Array(
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre"
  );
  var diasSemana = new Array(
    "Domingo",
    "Lunes",
    "Martes",
    "Miércoles",
    "Jueves",
    "Viernes",
    "Sábado"
  );
  var f = new Date();
  var fecha =
    diasSemana[f.getDay()] +
    ", " +
    f.getDate() +
    " de " +
    meses[f.getMonth()] +
    " de " +
    f.getFullYear();

  tabla = $("#tbllistado")
    .dataTable({
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor

      dom: "Bfrtip",
      buttons: [
        {
          extend: "excelHtml5",
          text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
          titleAttr: "Excel",
        },

        {
          extend: "print",
          text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
          messageTop:
            '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: ' +
            fecha +
            '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
          title: "Programas Académicos",
          titleAttr: "Print",
        },
      ],
      ajax: {
        url:
          "../controlador/peadocente.php?op=verDescargas&id_pea_documento=" +
          id_pea_documento,
        type: "get",
        dataType: "json",
        error: function (e) {},
      },
      bDestroy: true,
      scrollX: false,
      iDisplayLength: 10, //Paginación
      order: [[2, "asc"]], //Ordenar (columna,orden)
      initComplete: function (settings, json) {
        $("#precarga").hide();
      },
    })
    .DataTable();
}

function enlaces(id_pea_docente) {
  $("#precarga").show();
  $.post(
    "../controlador/peadocente.php?op=enlaces",
    { id_pea_docente: id_pea_docente },
    function (data) {
      data = JSON.parse(data);
      $("#enlaces").html("");
      $("#enlaces").append(data["0"]["0"]);
      $("#listadopea").hide();
      $("#descripcion").hide();
      $("#documentos").hide();
      $("#enlaces").show();

      $("#precarga").hide();

      $(".post-module").hover(function () {
        $(this).find(".description").stop().animate(
          {
            height: "toggle",
            opacity: "toggle",
          },
          300
        );
      });
    }
  );
}

function crearEnlace(ciclo,id_pea_docente,id_tema,id_materia,id_programa) {
  $("#crearEnlaces").modal("show");
  $("#id_pea_enlaces").val("");
  $("#id_pea_docentes_enlace").val(id_pea_docente);
  $("#id_tema_enlace").val(id_tema);
  $("#id_materia_enlace").val(id_materia);
  $("#id_programa_enlace").val(id_programa);
  $("#ciclo_enlace").val(ciclo);
  $("#titulo_enlace").val("");
  $("#descripcion_enlace").val("");
  $("#enlace").val("");
  $("#condicion_finalizacion_enlace").val(1);
    // Reset radios de tipo_condicion_enlace
  $("input[name='tipo_condicion_enlace']").prop("checked", false);
  $("#contenedor_tipo_condicion_enlace").hide(); // Ocultar el contenedor
  $("#fecha_inicio_enlace").val("");
  $("#fecha_limite_enlace").val("");
  $("#porcentaje_enlace").val(0);
  $("#otorgar_puntos_enlace").val(0);
  $("#puntos_actividad_enlace").val("");

  
}

function editarEnlace(id_pea_enlaces, id_pea_docentes) {
  $.post("../controlador/peadocente.php?op=editarEnlace",{ id_pea_enlaces: id_pea_enlaces },function (data) {
      data = JSON.parse(data);
      $("#crearEnlaces").modal("show");
      $("#id_pea_enlaces").val(id_pea_enlaces);
      $("#id_pea_docentes_enlace").val(id_pea_docentes);
      $("#titulo_enlace").val(data.titulo_enlace);
      $("#descripcion_enlace").val(data.descripcion_enlace);
      $("#enlace").val(data.enlace);
      $("#id_tema_enlace").val(data.id_tema);
      $("#id_materia_enlace").val(data.id_materia);
      $("#id_programa_enlace").val(data.id_programa);
      $("#ciclo_enlace").val(data.ciclo);

      // Asignar valores a los campos del formulario desde data
      $("#condicion_finalizacion_enlace").val(data.condicion_finalizacion_enlace);

      // Mostrar el bloque de tipo_condicion si corresponde
      if (data.condicion_finalizacion_enlace == "3") {
          $("#contenedor_tipo_condicion_enlace").show();
          $("input[name='tipo_condicion_enlace'][value='" + data.tipo_condicion_enlace + "']").prop("checked", true);
      } else {
          $("#contenedor_tipo_condicion_enlace").hide();
      }

      // Asignar fechas
      $("#fecha_inicio_enlace").val(data.fecha_inicio_enlace);
      $("#fecha_limite_enlace").val(data.fecha_limite_enlace);

      // Porcentaje
      $("#porcentaje_enlace").val(data.porcentaje_enlace);

      // Quiere otorgar puntos
      $("#otorgar_puntos_enlace").val(data.otorgar_puntos_enlace);

      // Mostrar el campo de puntos si corresponde
      $("#otorgar_puntos_enlace").val(data.otorgar_puntos_enlace);
      if (data.otorgar_puntos_enlace == "1") {
          $("#campo_puntos_enlace").show();
          $("#puntos_actividad_enlace").val(data.puntos_actividad_enlace);
      } else {
          $("#campo_puntos_enlace").hide();
          $("#puntos_actividad_enlace").val(""); // o puedes forzarlo a 0 si lo prefieres
      }


    }
  );
}

function editarVideo(id_pea_video, id_pea_docentes) {
  $.post("../controlador/peadocente.php?op=editarVideo",{ id_pea_video: id_pea_video },function (data) {
      data = JSON.parse(data);
 
      $("#subirvideo").modal("show");
      $("#id_pea_video").val(id_pea_video);
      $("#id_pea_docentes_video").val(id_pea_docentes);
      $("#titulo_video").val(data.titulo_video);
      $("#descripcion_video").val(data.descripcion_video);
      $("#url_video").val(data.video);
      mostrarMiniatura(); // <- aquí fuerzas que se ejecute la preview
      $("#id_tema_video").val(data.id_tema);
      $("#id_materia_video").val(data.id_materia);
      $("#id_programa_video").val(data.id_programa);
      $("#ciclo_video").val(data.ciclo);

      // Asignar valores a los campos del formulario desde data
      $("#condicion_finalizacion_video").val(data.condicion_finalizacion_video);

      // Mostrar el bloque de tipo_condicion si corresponde
      if (data.condicion_finalizacion_video == "3") {
          $("#contenedor_tipo_condicion_video").show();
          $("input[name='tipo_condicion_video'][value='" + data.tipo_condicion_video + "']").prop("checked", true);
      } else {
          $("#contenedor_tipo_condicion_video").hide();
      }

      // Asignar fechas
      $("#fecha_inicio_video").val(data.fecha_inicio_video);
      $("#fecha_limite_video").val(data.fecha_limite_video);

      // Porcentaje
      $("#porcentaje_video").val(data.porcentaje_video);

      // Quiere otorgar puntos
      $("#otorgar_puntos_video").val(data.otorgar_puntos_video);

      // Mostrar el campo de puntos si corresponde
      $("#otorgar_puntos_video").val(data.otorgar_puntos_video);
      if (data.otorgar_puntos_video == "1") {
          $("#campo_puntos_video").show();
          $("#puntos_actividad_video").val(data.puntos_actividad_video);
      } else {
          $("#campo_puntos_video").hide();
          $("#puntos_actividad_video").val(""); // o puedes forzarlo a 0 si lo prefieres
      }


    }
  );
}


function carpetaEjercicios(id_pea_docente) {
  $("#carpetaejercicios").modal("show");
  $("#id_pea_docentes_ejercicios_carpeta").val(id_pea_docente);
  $("#id_pea_ejercicios_carpeta").val("");
  $("#carpeta_ejercicios").val("");
}

function ejercicios(id_pea_docente) {
  $("#precarga").show();
  $.post(
    "../controlador/peadocente.php?op=ejercicios",
    { id_pea_docente: id_pea_docente },
    function (data) {
      data = JSON.parse(data);
      $("#ejercicios").html("");
      $("#ejercicios").append(data["0"]["0"]);
      $("#listadopea").hide();
      $("#descripcion").hide();
      $("#ejercicios").show();
      $("#glosario").hide();

      $("#precarga").hide();

      $(".post-module").hover(function () {
        $(this).find(".description").stop().animate(
          {
            height: "toggle",
            opacity: "toggle",
          },
          300
        );
      });
    }
  );
}

function editarArchivoEjercicios(id_pea_ejercicios, id_pea_docentes_subir) {
  $.post(
    "../controlador/peadocente.php?op=editarArchivoEjercicios",
    { id_pea_ejercicios: id_pea_ejercicios },
    function (data) {
      data = JSON.parse(data);
      $("#subirejercicios").modal("show");
      $("#id_pea_ejercicios").val(id_pea_ejercicios);
      $("#id_pea_ejercicios_carpeta_subir").val("");
      $("#id_pea_docente_subir_ejercicios").val(id_pea_docentes_subir);
      $("#tipo_archivo_ejercicios").val(data.tipo_archivo);
      $("#nombre_ejercicios").val(data.nombre_ejercicios);
      $("#descripcion_ejercicios").val(data.descripcion_ejercicios);
      $("#archivo_ejercicios").val("");
      $("#fecha_inicio").val(data.fecha_inicio);
      $("#fecha_entrega").val(data.fecha_entrega);
      $("#por_ejercicios").val(data.por_ejercicios);
      $("#imagenmuestra_ejercicios").show();

      $("#imagenmuestra_ejercicios").html("");
      $("#imagenmuestra_ejercicios").append(data.archivo_ejercicios);
      $("#imagenactual_ejercicios").val(data.archivo_ejercicios);
    }
  );
}

//Función Listar los estudiantes que descargaron algun documento
function glosario(id_pea_docente) {
  $.post(
    "../controlador/peadocente.php?op=glosarioCabecera",
    { id_pea_docente: id_pea_docente },
    function (data) {
      data = JSON.parse(data);
      $("#glosariocabecera").html("");
      $("#glosariocabecera").append(data["0"]["0"]);
    }
  );

  var meses = new Array(
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre"
  );
  var diasSemana = new Array(
    "Domingo",
    "Lunes",
    "Martes",
    "Miércoles",
    "Jueves",
    "Viernes",
    "Sábado"
  );
  var f = new Date();
  var fecha =
    diasSemana[f.getDay()] +
    ", " +
    f.getDate() +
    " de " +
    meses[f.getMonth()] +
    " de " +
    f.getFullYear();

  tabla = $("#tblglosario")
    .dataTable({
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor

      dom: "Bfrtip",
      buttons: [
        {
          extend: "excelHtml5",
          text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
          titleAttr: "Excel",
        },

        {
          extend: "print",
          text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
          messageTop:
            '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: ' +
            fecha +
            '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
          title: "Programas Académicos",
          titleAttr: "Print",
        },
      ],
      ajax: {
        url:
          "../controlador/peadocente.php?op=glosario&id_pea_docente=" +
          id_pea_docente,
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e);
        },
      },
      bDestroy: true,
      scrollX: false,
      iDisplayLength: 10, //Paginación
      order: [[2, "asc"]], //Ordenar (columna,orden)
      initComplete: function (data) {

        $("#listadopea").hide();
        $("#descripcion").hide();
        $("#documentos").hide();
        $("#enlaces").hide();
        $("#glosario").show();
        $("#precarga").hide();
      },
    })
    .DataTable();
}

function crearGlosario(ciclo,id_pea_docente,id_tema,id_materia,id_programa) {
  $("#crearGlosario").modal("show");
  $("#id_pea_glosario").val("");
  $("#id_pea_docentes_glosario").val(id_pea_docente);
  $("#titulo_glosario").val("");
  $("#definicion_glosario").val("");

  $("#ciclo_glosario").val(ciclo);
  $("#id_tema_glosario").val(id_tema);
  $("#id_materia_glosario").val(id_materia);
  $("#id_programa_glosario").val(id_programa);

  $("#otorgar_puntos_glosario").val(0);
  $("#puntos_actividad_glosario").val("");
 
}

function editarGlosario(id_pea_glosario, id_pea_docentes) {
  $.post(
    "../controlador/peadocente.php?op=editarGlosario",
    { id_pea_glosario: id_pea_glosario },
    function (data) {
      data = JSON.parse(data);
      $("#crearGlosario").modal("show");
      $("#id_pea_glosario").val(id_pea_glosario);
      $("#id_pea_docentes_glosario").val(id_pea_docentes);
      $("#titulo_glosario").val(data.titulo_glosario);
      $("#definicion_glosario").val(data.definicion_glosario);

      $("#id_tema_glosario").val(data.id_tema);
      $("#id_materia_glosario").val(data.id_materia);
      $("#id_programa_glosario").val(data.id_programa);
      $("#ciclo_glosario").val(data.ciclo);

            // Mostrar el campo de puntos si corresponde
      $("#otorgar_puntos_glosario").val(data.otorgar_puntos_glosario);
      if (data.otorgar_puntos_glosario == "1") {
          $("#campo_puntos_glosario").show();
          $("#puntos_actividad_glosario").val(data.puntos_actividad_glosario);
      } else {
          $("#campo_puntos_glosario").hide();
          $("#puntos_actividad_glosario").val(""); // o puedes forzarlo a 0 si lo prefieres
      }
      console.log(data.otorgar_puntos_glosario)
    }
  );
}

//Función Listar
function listarCalificar(id_docente_grupo, id_pea_ejercicios) {
  $("#precarga").show();
  var meses = new Array(
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre"
  );
 
  var diasSemana = new Array(
    "Domingo",
    "Lunes",
    "Martes",
    "Miércoles",
    "Jueves",
    "Viernes",
    "Sábado"
  );
  var f = new Date();
  var fecha =
    diasSemana[f.getDay()] +
    ", " +
    f.getDate() +
    " de " +
    meses[f.getMonth()] +
    " de " +
    f.getFullYear();

  tabla = $("#listadoCalificarDatos").dataTable({
    aProcessing: true, //Activamos el procesamiento del datatables
    aServerSide: true, //Paginación y filtrado realizados por el servidor
    autoWidth: false,

    // dom para el responsive
    dom:
      "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'<'float-md-right ml-2'B>f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

    dom: "Bfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
        titleAttr: "Excel",
      },

      {
        extend: "print",
        text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
        messageTop:
          '<div style="width:50%;float:left">Plan Educativo de Aula<br><b>Fecha de Impresión</b>: ' +
          fecha +
          '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
        title: "PEA",
        titleAttr: "Print",
      },
    ],
    ajax: {
      url:
        "../controlador/peadocente.php?op=listarCalificar&id_pea_ejercicios=" +
        id_pea_ejercicios +
        "&id_docente_grupo=" +
        id_docente_grupo,
      type: "get",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText);
      },
    },
    bDestroy: true,
    scrollX: false,
    iDisplayLength: 10, //Paginación
    order: [[2, "asc"]], //Ordenar (columna,orden)
    initComplete: function (settings, json) {
      $("#listadoCalificar").modal("show");
      $("#precarga").hide();
    },

    // funcion para cambiar el responsive del data table
  });

  // ****************************** //

  //	$.ajax({
  //		url: '../controlador/peadocente.php?op=listar&id_programa='+id_programa+'&materia='+materia,
  //	    type: "POST",
  //	    success: function(datos){
  //			console.log(datos);
  //	    }
  //
  //	});
}

//lista los estudiatnes de ese grupo
function listarCPrueba(id_docente_grupo, id_pea_ejercicios) {
  $("#precarga").show();
  $.get(
    "../controlador/pea_docente.php?op=listarCalificar",
    {
      id_docente_grupo: id_docente_grupo,
      id_pea_ejercicios: id_pea_ejercicios,
    },
    function (data, status) {
      data = JSON.parse(data);
      $("#tllistado").hide(); // ocultamos los pea
      $(document).ready(function () {
        $("#example").DataTable({
          paging: false,
          searching: false,
          scrollX: false,
          order: [[3, "asc"]],
          autoWidth: false,
          // dom para el responsive
          dom:
            "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'<'float-md-right ml-2'B>f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
          buttons: [],
        });
      });
      $("#listadoCalificarDatos").html("");
      $("#listadoCalificarDatoso").append(data["0"]["0"]);
      $("#listadoCalificar").modal("show");
      $("#precarga").hide();
    }
  );
}

function calificarTaller(id_pea_ejercicios_est) {
  var nota = $("#nota_" + id_pea_ejercicios_est).val();

  $.post(
    "../controlador/peadocente.php?op=calificarTaller",
    { id_pea_ejercicios_est: id_pea_ejercicios_est, nota: nota },
    function (data) {
      data = JSON.parse(data);

      if (data["0"]["0"] == 1) {
        alertify.success("Calificado");
      } else if (data["0"]["0"] == 2) {
        alertify.error("error");
      } else {
        alertify.error("Valor entre 0 y 5");
      }
    }
  );
}

//Función Listar
function listarCalificarCompleto2(id_docente_grupo, id_pea_ejercicios_carpeta) {
  $("#precarga").show();
  var meses = new Array(
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre"
  );
  var diasSemana = new Array(
    "Domingo",
    "Lunes",
    "Martes",
    "Miércoles",
    "Jueves",
    "Viernes",
    "Sábado"
  );
  var f = new Date();
  var fecha =
    diasSemana[f.getDay()] +
    ", " +
    f.getDate() +
    " de " +
    meses[f.getMonth()] +
    " de " +
    f.getFullYear();

  tabla = $("#listadoCalificarDatosCompleto").dataTable({
    aProcessing: true, //Activamos el procesamiento del datatables
    aServerSide: true, //Paginación y filtrado realizados por el servidor
    autoWidth: false,

    dom: "Bfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
        titleAttr: "Excel",
      },

      {
        extend: "print",
        text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
        messageTop:
          '<div style="width:50%;float:left">Plan Educativo de Aula<br><b>Fecha de Impresión</b>: ' +
          fecha +
          '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
        title: "PEA",
        titleAttr: "Print",
      },
    ],
    ajax: {
      url:
        "../controlador/peadocente.php?op=listarCalificarCompleto&id_pea_ejercicios_carpeta=" +
        id_pea_ejercicios_carpeta +
        "&id_docente_grupo=" +
        id_docente_grupo,
      type: "get",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText);
      },
    },
    bDestroy: true,
    scrollX: false,
    iDisplayLength: 10, //Paginación
    order: [[2, "asc"]], //Ordenar (columna,orden)
    initComplete: function (settings, json) {
      $("#listadoCalificarDatosCompleto").html("");
      $("#listadoCalificarDatosCompleto").append(data["0"]["0"]);
      $("#listadoCalificarCompleto").modal("show");
      $("#precarga").hide();
    },
  });

  // ****************************** //

  //	$.ajax({
  //		url: '../controlador/peadocente.php?op=listar&id_programa='+id_programa+'&materia='+materia,
  //	    type: "POST",
  //	    success: function(datos){
  //			console.log(datos);
  //	    }
  //
  //	});
}

//lista los estudiatnes de ese grupo
function listarCalificarCompleto(id_docente_grupo, id_pea_ejercicios_carpeta) {
  $("#precarga").show();
  var meses = new Array(
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre"
  );
  var diasSemana = new Array(
    "Domingo",
    "Lunes",
    "Martes",
    "Miércoles",
    "Jueves",
    "Viernes",
    "Sábado"
  );
  var f = new Date();
  var fecha =
    diasSemana[f.getDay()] +
    ", " +
    f.getDate() +
    " de " +
    meses[f.getMonth()] +
    " de " +
    f.getFullYear();
  $.get(
    "../controlador/peadocente.php?op=listarCalificarCompleto",
    {
      id_docente_grupo: id_docente_grupo,
      id_pea_ejercicios_carpeta: id_pea_ejercicios_carpeta,
    },
    function (data, status) {
      data = JSON.parse(data);

      $(document).ready(function () {
        $("#listadoCalificarDatosCompleto").DataTable({
          paging: false,
          searching: false,
          scrollX: false,
          order: [[2, "asc"]],
          autoWidth: false,
          // dom para el responsive
          dom:
            "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'<'float-md-right ml-2'B>f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
          buttons: [
            {
              extend: "excelHtml5",
              text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
              titleAttr: "Excel",
            },

            {
              extend: "print",
              text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
              messageTop:
                '<div style="width:50%;float:left">Plan Educativo de Aula<br><b>Fecha de Impresión</b>: ' +
                fecha +
                '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
              title: "PEA",
              titleAttr: "Print",
            },
          ],
          bDestroy: true,
        });
      });
      $("#listadoCalificarCompleto").modal("show");
      $("#precarga").hide();
      $("#listadoCalificarDatosCompleto").html("");
      $("#listadoCalificarDatosCompleto").append(data["0"]["0"]);

      $("#precarga").hide();
    }
  );
}
//Función para eliminar enlace
function borrararchivo(id_pea_ejercicios_est,nombre_ejercicios,credencial_login) {
  alertify.confirm(
    "Eliminar archivo",
    "¿Está Seguro de eliminar el archivo?",
    function () {
      $.post(
        "../controlador/peadocente.php?op=borrararchivo",
        { "id_pea_ejercicios_est":id_pea_ejercicios_est,"nombre_ejercicios":nombre_ejercicios,"credencial_login":credencial_login},
        function (data) {
          data = JSON.parse(data);
          if (data["0"]["0"] == 1) {
            alertify.success("Archivo eliminado");
            $('#listadoCalificarDatos').DataTable().ajax.reload();
          } else {
            alertify.error("No sepuede eliminar");
          }
        }
      );
    },
    function () {
      alertify.error("Cancelado");
    }
  );
}

function validartema(id_materia,id_programa,id_pea,id_tema,id_pea_docente,ciclo) {

  $.post( "../controlador/peadocente.php?op=validartema",{id_materia:id_materia, id_programa:id_programa, id_pea:id_pea, id_tema:id_tema, id_pea_docente:id_pea_docente, ciclo:ciclo },
    function (data) {
      r = JSON.parse(data);
      if(r.data1==1){
         alertify.success("Tema validado");
         listar(id_materia,id_programa,global_id_docente_grupo)
      }else{
        alertify.error("error");
      }

    }
  );
}

function agregarrecurso(id_materia,id_programa,id_pea,id_tema,id_pea_docente,ciclo) {

  $.post( "../controlador/peadocente.php?op=agregarrecurso",{id_materia:id_materia, id_programa:id_programa, id_pea:id_pea, id_tema:id_tema, id_pea_docente:id_pea_docente, ciclo:ciclo },
    function (data) {
      r = JSON.parse(data);

    if (r.data1 == 3) {
      // Cargar el contenido dinámicamente
      document.getElementById('contenidoPanelRecursos').innerHTML = `
        <div>${r[0].opciones }</div>
      `;

      abrirPanel(); // Mostrar panel
    }
    }
  );
}

function abrirPanel() {
  document.getElementById('panelRecursos').classList.add('show');
}

function cerrarPanel() {
  document.getElementById('panelRecursos').classList.remove('show');
}

function marcarVisto(id_materia,id_programa,ciclo,id_pea_tema_ciclo) {

  Swal.fire({
  title: "Tema terminado?",
  text: "Estas seguro de realizar este paso!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Si, continuar!"
  }).then((result) => {

      $.post( "../controlador/peadocente.php?op=marcarvisto",{ciclo:ciclo, id_pea_tema_ciclo:id_pea_tema_ciclo },
      function (data) {
        r = JSON.parse(data);
        if(r[0].data1==1){
              if (result.isConfirmed) {
                Swal.fire({
                  title: "Excelente!",
                  text: "El tema termino con exíto.",
                  icon: "success"
                });
              }
          listar(id_materia,id_programa,global_id_docente_grupo)
        }
      }
    );

  });




}

function informacionDoc(id_pea_documento){

	$.post("../controlador/peadocente.php?op=informacionDoc", { id_pea_documento:id_pea_documento}, function (data) {
		r = JSON.parse(data);
		$("#informacionDoc").modal("show");
		$("#resultadodoc").html("");
		$("#resultadodoc").append(r.data1);
    $(document).ready(function () {
				$("#example").DataTable({
					"paging": false,
					"searching": false,
					"scrollX": false,
					"order": [[2, "asc"]],
					"autoWidth": false,

					"buttons": [],
				});
			});
	});

}

function informacionEnlace(param1){

	$.post("../controlador/peadocente.php?op=informacionEnlace", { param1:param1}, function (data) {
		r = JSON.parse(data);
		$("#informacionDoc").modal("show");
		$("#resultadodoc").html("");
		$("#resultadodoc").append(r.data1);
    $(document).ready(function () {
				$("#example").DataTable({
					"paging": false,
					"searching": false,
					"scrollX": false,
					"order": [[2, "asc"]],
					"autoWidth": false,

					"buttons": [],
				});
			});
	});

}

function informacionGlosario(param1){

	$.post("../controlador/peadocente.php?op=informacionGlosario", { param1:param1}, function (data) {
		r = JSON.parse(data);
		$("#informacionDoc").modal("show");
		$("#resultadodoc").html("");
		$("#resultadodoc").append(r.data1);
    $(document).ready(function () {
				$("#example").DataTable({
					"paging": false,
					"searching": false,
					"scrollX": false,
					"order": [[2, "asc"]],
					"autoWidth": false,

					"buttons": [],
				});
			});
	});

}

function formatTime(seconds) {
  var minutes = Math.floor(seconds / 60);
  var secs = Math.floor(seconds % 60);
  if (secs < 10) secs = "0" + secs;
  return minutes + ":" + secs;
}

function getYoutubeId(url) {
  const regex = /(?:youtube\.com\/(?:.*v=|.*\/|embed\/)|youtu\.be\/)([^"&?/ ]{11})/i;
  const match = url.match(regex);
  return match ? match[1] : null;
}


var player;
var video_id;
function informacionVideo(param1)
{
  video_id = param1;
	$.post("../controlador/peadocente.php?op=informacionVideo", { param1:param1}, function (data) {
		r = JSON.parse(data);
		$("#informacionDoc").modal("show");
		$("#resultadodoc").html("");
		$("#resultadodoc").append(r.data1);
    $(document).ready(async function () {
				$("#example").DataTable({
					"paging": false,
					"searching": false,
					"scrollX": false,
					"order": [[2, "asc"]],
					"autoWidth": false,

					"buttons": [],
				});

        var id_video = await getYoutubeId(r.video);

        player = new YT.Player('player', {
          height: '390',
          width: '640',
          videoId: id_video,
          events: {
            // 'onStateChange': onPlayerStateChange
          }
        });

        $(document).off("click", ".btn-save-question").on("click", ".btn-save-question", function(e) {
          e.preventDefault();

          let tiempo = $(this).data("time");
          let current = $(this).data("current");
          let pregunta = $(`input[name="preguntas[${current}]"]`).val();
          let tipo = $(`input[name="type-question${tiempo}"]:checked`).val();

          $(this).prop("disabled", true);
          $(this).parent().parent().remove();

          if (pregunta.trim() !== "") {
            $.post("../controlador/peadocente.php?op=saveQuestionVideo", {
              video: param1,
              tiempo: tiempo,
              pregunta: pregunta,
              tipo: tipo,
            }, async function (res) {
              var r = JSON.parse(res)

              var tipoTexto = (tipo == 1) ? "Verdadero / Falso" : "Texto corta";

              alertify.success("Pregunta guardada");

              var nuevaFila = `
                <tr>
                  <td>${tiempo}</td>
                  <td>${pregunta}</td>
                  <td>${tipoTexto}</td>
                  <td>
                    <button class="btn btn-sm btn-primary edit-question" data-id="${r.id_pregunta}" data-tiempo="${tiempo}'" data-pregunta="${pregunta}" data-tipo="'.$tipo.'">
                      <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger delete-question" data-id="${r.id_pregunta}">
                      <i class="fa fa-trash"></i>
                    </button>
                  </td>
                </tr>
              `;

              $("#times-video").append(nuevaFila);


              $(".add-field-list-question").prop("disabled", false);
            });
          } else {
            alertify.error("La pregunta no puede estar vacía");
          }
        });

        $(document).off("click", ".delete-question").on("click", ".delete-question", function(e) {
          e.preventDefault();
          let id = $(this).data("id");

          let row = $(this).closest("tr");

          alertify.confirm(
            "Eliminar preguntra del video",
            "¿Está Seguro de eliminar la pregunta del video?",
            function () {
              $.post(
                "../controlador/peadocente.php?op=deleteQuestionVideo",
                {  id_pregunta: id },
                function (data) {
                  data = JSON.parse(data);

                  if (data == true) {
                    //informacionVideo(param1);
                    row.remove();
                  }
                }
              );
            },
            function () {
              alertify.error("Cancelado");
            }
          );
        });

        $(document).off("click", ".edit-question").on("click", ".edit-question", function(e) {
          e.preventDefault();

          let id = $(this).data("id");
          let tiempo = $(this).data("tiempo");
          let pregunta = $(this).data("pregunta");
          let tipo = $(this).data("tipo");

          let row = $(this).closest("tr");

          let editRow = `
            <td>${tiempo}</td>
            <td>
              <input type="text" class="form-control form-control-sm pregunta-edit" 
                    value="${pregunta}" data-id="${id}">
            </td>
            <td>
              <div class="form-check">
                <input class="form-check-input" type="radio" value="1" 
                      name="tipo-${id}" id="tipo-${id}-1" ${tipo == 1 ? "checked" : ""}>
                <label class="form-check-label" for="tipo-${id}-1">Verdadero / Falso</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" value="2" 
                      name="tipo-${id}" id="tipo-${id}-2" ${tipo == 2 ? "checked" : ""}>
                <label class="form-check-label" for="tipo-${id}-2">Texto corta</label>
              </div>
            </td>
            <td>
              <button class="btn btn-sm btn-success save-question" data-id="${id}">
                <i class="fa fa-save"></i>
              </button>
              <button class="btn btn-sm btn-secondary cancel-edit" data-id="${id}" 
                      data-tiempo="${tiempo}" data-pregunta="${pregunta}" data-tipo="${tipo}">
                <i class="fa fa-times"></i>
              </button>
            </td>
          `;

          row.html(editRow);
        });

        $(document).off("click", ".cancel-edit").on("click", ".cancel-edit", function (e) {
          e.preventDefault();

          let id = $(this).data("id");
          let tiempo = $(this).data("tiempo");
          let pregunta = $(this).data("pregunta");
          let tipo = $(this).data("tipo");

          let row = $(this).closest("tr");

          row.html(`
            <td>${tiempo}</td>
            <td>${pregunta}</td>
            <td>${tipo == 1 ? "Verdadero / Falso" : "Texto corta"}</td>
            <td>
              <button class="btn btn-sm btn-primary edit-question" 
                      data-id="${id}" data-tiempo="${tiempo}" data-pregunta="${pregunta}" data-tipo="${tipo}">
                <i class="fa fa-edit"></i>
              </button>
              <button class="btn btn-sm btn-danger delete-question" data-id="${id}">
                <i class="fa fa-trash"></i>
              </button>
            </td>
          `);
        });

        $(document).off("click", ".save-question").on("click", ".save-question", function (e) {
          e.preventDefault();

          let id = $(this).data("id");
          let row = $(this).closest("tr");

          let texto = row.find(".pregunta-edit").val();
          let tipo = row.find("input[name='tipo-" + id + "']:checked").val();

          $.post("../controlador/peadocente.php?op=editQuestionVideo", {
            id: id,
            pregunta: texto,
            tipo: tipo,
          }, async function (respuesta) {
              row.html(`
              <td>${row.find("td:first").text()}</td>
              <td>${texto}</td>
              <td>${tipo == 1 ? "Verdadero / Falso" : "Texto corta"}</td>
              <td>
                <button class="btn btn-sm btn-primary edit-question" 
                        data-id="${id}" data-tiempo="${row.find("td:first").text()}" 
                        data-pregunta="${texto}" data-tipo="${tipo}">
                  <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger delete-question" data-id="${id}">
                  <i class="fa fa-trash"></i>
                </button>
              </td>
            `);
            alertify.success("Pregunta actualizada");
            informacionVideo(param1);
          });

        });
			});
	});
}

$(document).on("click", ".add-field-list-question", function (e) {
  e.preventDefault();

  $(".add-field-list-question").prop("disabled", true);

  var currentTime = Math.floor(player.getCurrentTime());
  var tiempoFormateado = formatTime(currentTime);

  if (tiempoFormateado !== "0:00") {
    var nuevaFila = `
      <tr>
        <td>${tiempoFormateado}</td>
        <td>
          <input type="text" data-time="${tiempoFormateado}" name="preguntas[${currentTime}]" 
            class="form-control pregunta-input"
            placeholder="Escribe tu pregunta aquí">
        </td>
        <td>
          <div class="form-check">
            <input class="form-check-input" type="radio" value="1" name="type-question${tiempoFormateado}" id="type-question${currentTime}1">
            <label class="form-check-label" for="type-question${currentTime}1">
              (Verdadero / Falso)
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" value="2" name="type-question${tiempoFormateado}" id="type-question${currentTime}2" checked>
            <label class="form-check-label" for="type-question${currentTime}2">
              Texto corta
            </label>
          </div>
        </td>
        <td>
          <button class="btn btn-success btn-save-question" 
                  data-time="${tiempoFormateado}" 
                  data-current="${currentTime}">
            <i class="fa fa-save"></i>
          </button>
        </td>
      </tr>
    `;

    $("#times-video").append(nuevaFila);
  }
});

function verRespuestasEstudiante(id_pea_video, credencial_identificacion) {

  $.post("../controlador/peadocente.php?op=respuestasEstudiante", { param1: id_pea_video, param2:credencial_identificacion }, function (data) {
    r = JSON.parse(data);
    $("#informacionDoc").modal("hide");
    $("#respuestasEstudianteVideo").modal("show");
    $("#resultadoRespuestasEstudiante").html("");
    $("#resultadoRespuestasEstudiante").append(r.data1);

    $(document).ready(async function () {
      if ( $.fn.DataTable.isDataTable("#example") ) {
        $("#example").DataTable().clear().destroy();
      }

      $("#example").DataTable({
        paging: false,
        searching: false,
        scrollX: false,
        order: [[2, "asc"]],
        autoWidth: false,
        buttons: [],
      });
    });

  });
}

function revertirInfoVideo() {
  informacionVideo(video_id);
  $("#informacionDoc").modal("show");
}


function verDocumentoMensaje(id_pea_ejercicios_est,id_pea_documento) {
  // Pides los datos al backend
  $.post("../controlador/peadocente.php?op=documentoMensaje", { id_pea_ejercicios_est:id_pea_ejercicios_est, id_pea_documento:id_pea_documento }, function (data) {
    const r = JSON.parse(data);

    // 1) Crea el editor una sola vez
    if (!CKEDITOR.instances.comentario_documento_archivo_ver) {
      CKEDITOR.replace('comentario_documento_archivo_ver', {
        height: 400,
        readOnly: true,                // Solo lectura (estás viendo)
        removePlugins: 'elementspath,resize',
        toolbar: [                     // Si quieres, deja la barra mínima
          { name: 'document', items: ['Undo', 'Redo'] },
          { name: 'styles',   items: ['Format'] },
          { name: 'basicstyles', items: ['Bold','Italic'] },
          { name: 'links',    items: ['Link','Unlink'] },
          { name: 'insert',   items: ['Image','Table'] },
          { name: 'lists',    items: ['BulletedList','NumberedList'] },
          { name: 'paragraph',items: ['JustifyLeft','JustifyCenter','JustifyRight'] }
        ],
        format_tags: 'p;h1;h2'
      });
    }

    // 2) Setea el contenido HTML devuelto por tu API
    CKEDITOR.instances.comentario_documento_archivo_ver.setData(r.data1 || '');

    // 3) Abre el modal al final (ya con el contenido cargado)
    $("#verDocumentoMensajeModal").modal("show");
  });
}
$('#verDocumentoMensajeModal').on('hidden.bs.modal', function () {
  if (CKEDITOR.instances.comentario_documento_archivo_ver) {
    CKEDITOR.instances.comentario_documento_archivo_ver.setData('');
  }
});

function verEnlaceMensaje(id_pea_enlaces_est,id_pea_enlaces) {
  // Pides los datos al backend
  $.post("../controlador/peadocente.php?op=enlaceMensaje", { id_pea_enlaces_est:id_pea_enlaces_est, id_pea_enlaces:id_pea_enlaces }, function (data) {
    const r = JSON.parse(data);

    // 1) Crea el editor una sola vez
    if (!CKEDITOR.instances.comentario_enlace_archivo_ver) {
      CKEDITOR.replace('comentario_enlace_archivo_ver', {
        height: 400,
        readOnly: true,                // Solo lectura (estás viendo)
        removePlugins: 'elementspath,resize',
        toolbar: [                     // Si quieres, deja la barra mínima
          { name: 'document', items: ['Undo', 'Redo'] },
          { name: 'styles',   items: ['Format'] },
          { name: 'basicstyles', items: ['Bold','Italic'] },
          { name: 'links',    items: ['Link','Unlink'] },
          { name: 'insert',   items: ['Image','Table'] },
          { name: 'lists',    items: ['BulletedList','NumberedList'] },
          { name: 'paragraph',items: ['JustifyLeft','JustifyCenter','JustifyRight'] }
        ],
        format_tags: 'p;h1;h2'
      });
    }

    // 2) Setea el contenido HTML devuelto por tu API
    CKEDITOR.instances.comentario_enlace_archivo_ver.setData(r.data1 || '');

    // 3) Abre el modal al final (ya con el contenido cargado)
    $("#verEnlaceMensajeModal").modal("show");
  });
}
$('#verEnlaceMensajeModal').on('hidden.bs.modal', function () {
  if (CKEDITOR.instances.comentario_enlace_archivo_ver) {
    CKEDITOR.instances.comentario_enlace_archivo_ver.setData('');
  }
});

function notaDocumento(valor,para1,para2,para3) {

    $.post( "../controlador/peadocente.php?op=notadocumento",{ valor:valor, para1:para1, para2:para2 },function (data) {
      r = JSON.parse(data);
      alertify.success("Nota registrada");
      informacionDoc(para3);
    }

  );
}
function notaEnlace(valor,para1,para2,para3) {

    $.post( "../controlador/peadocente.php?op=notaenlace",{ valor:valor, para1:para1, para2:para2 },function (data) {
      r = JSON.parse(data);
      alertify.success("Nota registrada");
      informacionEnlace(para3);
    }

  );
}

function enviarPuntos(param1,param2,param3){

    Swal.fire({
    title: "Estas seguro?",
    text: "Enviar puntos por este taller!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Enviar!"
  }).then((result) => {
    if (result.isConfirmed) {

    $.post("../controlador/peadocente.php?op=enviarPuntos", { param1:param1, param2:param2 }, function (data) {
      r = JSON.parse(data);
      if(r.puntos=="si"){
                    
        Swal.fire({
          position: "top-end",
          imageWidth: 150,
          imageHeight: 150,
          imageUrl: "../public/img/ganancia.gif",
          title: "Se enviaron " + r.puntosotorgados +" puntos, por cumplir con el taller",
          showConfirmButton: false,
          timer: 4000
        });
        informacionDoc(param3);

      }

    });


    }
  });

}

function enviarPuntosEnlace(param1,param2,param3){
  Swal.fire({
    title: "Estas seguro?",
    text: "Enviar puntos por este taller!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Enviar!"
  }).then((result) => {
    if (result.isConfirmed) {

    $.post("../controlador/peadocente.php?op=enviarPuntosEnlace", { param1:param1, param2:param2 }, function (data) {
      r = JSON.parse(data);
      if(r.puntos=="si"){
                    
        Swal.fire({
          position: "top-end",
          imageWidth: 150,
          imageHeight: 150,
          imageUrl: "../public/img/ganancia.gif",
          title: "Se enviaron " + r.puntosotorgados +" puntos, por cumplir con el taller",
          showConfirmButton: false,
          timer: 4000
        });
        informacionEnlace(param3);

      }

    });


    }
  });

}

init();
