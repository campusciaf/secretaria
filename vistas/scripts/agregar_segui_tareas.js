function inicio() {
  $("#agregarSeguimientoSofi").on("submit", function (e1) {
    guardarSeguimiento(e1);
  });

  $("#agregarTareaSofi").on("submit", function (e2) {
    guardarTarea(e2);
  });
}

function agregarTareaSegui(id_credencial,id_persona) {
    $("#btnGuardarSeguimiento").prop("disabled", false);
    $("#precarga").show();
    $("#id_credencial_segui").val(id_credencial);
    $("#id_persona_segui").val(id_persona);
    $("#id_credencial_tarea").val(id_credencial);
    $("#id_persona_tarea").val(id_persona);

    $.post("../controlador/agregar_segui_tareas.php?op=agregar",{id_credencial:id_credencial , id_persona:id_persona},function (data) {
        data = JSON.parse(data); // convertir el mensaje a json
        $("#myModalAgregar").modal("show");
        $("#agregarContenidoTarea").html(""); // limpiar el div resultado
        $("#agregarContenidoTarea").append(data); // agregar el resultao al div resultado
        $("#precarga").hide();
      });
  }



/* funcion para agregar un seguimiento */
function guardarSeguimiento(e) {
  e.preventDefault(); //No se activará la acción predeterminada del evento
  $("#btnGuardarSeguimiento").prop("disabled", true);
  var formData = new FormData($("#agregarSeguimientoSofi")[0]);

  $.ajax({
    url: "../controlador/agregar_segui_tareas.php?op=agregarSeguimiento",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      alertify.set("notifier", "position", "top-center");
      alertify.success(datos);
      limpiarSeguimiento();
      $("#myModalAgregar").modal("hide");
    }
  });
}

function limpiarSeguimiento() {
  $("#seg_descripcion").val("");
}

function guardarTarea(e2) {
  e2.preventDefault(); //No se activará la acción predeterminada del evento
  // $("#btnGuardarTarea").prop("disabled",true);
  var formData = new FormData($("#agregarTareaSofi")[0]);

  $.ajax({
    url: "../controlador/agregar_segui_tareas.php?op=agregarTarea",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      // console.log(datos);
      alertify.set("notifier", "position", "top-center");
      alertify.success(datos);
      limpiarTarea();
      $("#myModalAgregar").modal("hide");
    }
  });
}

function limpiarTarea() {
  $("#tarea_observacion").val("");
  $("#tarea_fecha").val("");
  $("#tarea_hora").val("");
}

// muestra el numero de caracteres limite en un textarea
function cuentaSofi() {
  var max_chars = 600;

  $("#max").html(max_chars);

  $("#seg_descripcion").keyup(function () {
    var chars = $(this).val().length;
    var diff = max_chars - chars;
    $("#contador").html(diff);
  });
}

// muestra el numero de caracteres limite en un textarea
function cuentatarea() {
	
	var max_chars = 600;

	$("#max").html(max_chars);

	$("#mensaje_tarea").keyup(function () {
		var chars = $(this).val().length;
		var diff = max_chars - chars;
		$("#contadortarea").html(diff);
	});
}





inicio();
