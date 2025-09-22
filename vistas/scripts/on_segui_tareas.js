function inicio() {


  autenticacion();

  $("#formularioAgregarSeguimiento").on("submit", function (e1) {
    guardarSeguimiento(e1);
  });

  $("#formularioTarea").on("submit", function (e2) {
    guardarTarea(e2);
  });
}


function autenticacion() {
  // Obtener el parámetro 'code' de la URL
  const urlParams = new URLSearchParams(window.location.search);
  const code = urlParams.get('code');  // Obtiene el valor de 'code'

  // Verifica si 'code' está presente
  if (code) {
      // Ahora puedes enviar este código en la solicitud POST
      $.post("../controlador/on_segui_tareas.php?op=autenticacion", { code: code }, function (data, status) {
          var r = JSON.parse(data);
          console.log(data)
      });
  } else {

       // Envía 'null' si 'code' no está presente
       $.post("../controlador/on_segui_tareas.php?op=autenticacion", { code: false }, function (data, status) {
          var r = JSON.parse(data);
              $("#ingreso").html(r.authUrl);
              console.log(data)
              
      });
  }
}


/* funcion para traer los datos del estudiante en la cabeera del modal */
function agregar(id_estudiante) {
  $("#btnGuardarSeguimiento").prop("disabled", false);
  $("#precarga").show();
  $("#id_estudiante_agregar").val(id_estudiante);
  $("#id_estudiante_tarea").val(id_estudiante);

  $.post(
    "../controlador/on_segui_tareas.php?op=agregar",
    { id_estudiante: id_estudiante },
    function (data, status) {
      // console.log(data);
      data = JSON.parse(data); // convertir el mensaje a json
      $("#myModalAgregar").modal("show");
      $("#agregarContenido").html(""); // limpiar el div resultado
      $("#agregarContenido").append(data["0"]["0"]); // agregar el resultao al div resultado
      $("#precarga").hide();
    }
  );
}

/* funcion para agregar un seguimiento */
function guardarSeguimiento(e) {
  e.preventDefault(); //No se activará la acción predeterminada del evento
  $("#btnGuardarSeguimiento").prop("disabled", true);
  var formData = new FormData($("#formularioAgregarSeguimiento")[0]);

  $.ajax({
    url: "../controlador/on_segui_tareas.php?op=agregarSeguimiento",
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
  $("#mensaje_seguimiento").val("");
}

function guardarTarea(e2) {
  e2.preventDefault(); //No se activará la acción predeterminada del evento
  // $("#btnGuardarTarea").prop("disabled",true);
  var formData = new FormData($("#formularioTarea")[0]);

  $.ajax({
    url: "../controlador/on_segui_tareas.php?op=crearevento",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      console.log(datos);
      alertify.set("notifier", "position", "top-center");
      alertify.success(datos);
      limpiarTarea();
      $("#myModalAgregar").modal("hide");
    }
  });
}

function limpiarTarea() {
  $("#mensaje_tarea").val("");
  $("#fecha_programada").val("");
  $("#hora_programada").val("");
}

// muestra el numero de caracteres limite en un textarea
function cuenta() {
  var max_chars = 600;

  $("#max").html(max_chars);

  $("#mensaje_seguimiento").keyup(function () {
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
