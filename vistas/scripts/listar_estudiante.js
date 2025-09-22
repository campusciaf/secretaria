$(document).ready(incio);
function incio() {
    listarEstudiante();
    $(".guardarDatos").on("submit", function (e) {
        editarDato(e);
    });
    $("#forDatos").hide();
}
function listarEstudiante(){
   // var tabla_estudiantes = $('#dtl_estudiantes').dataTable(
    var tabla_estudiantes = $("#dtl_estudiantes").DataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        "dom": "Bfrtip", //Definimos los elementos del control de tabla
        "buttons": [{
            "extend": "excelHtml5",
            "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
            "titleAttr": "Excel",
            "exportOptions": {
                "columns": ":visible",
            },
        }],
        "ajax": {
            "url": "../controlador/listar_estudiante.php?op=listar_estudiante",
            "type": "get",
            "dataType": "json",
            error: function (e) { console.log(e.responseText); },
        },
        "bDestroy": true,
        "iDisplayLength": 10, //Paginación
        "order": [[1, "asc"]],
        "initComplete": function (settings, json) {
            $("#precarga").hide();
        },
        "columnDefs": [
            {"visible": false, "targets": [9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36], "className": 'hidden' }
        ]
        // "columnDefs": [
        //     {"visible": false, "targets": [8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27], "className": 'hidden' }
        // ]
    });
    $("a.toggle-vis").on("click", function (e) { 
        var column = tabla_estudiantes.column($(this).attr("data-column"));
        column.visible(!column.visible());
    });
}

function editarDato(e) {
  $("#precarga").show();
  e.preventDefault();
  var formData = new FormData($("#form2")[0]);
  $.ajax({
    type: "POST",
    url: "../controlador/listar_estudiante.php?op=editar",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      //console.log(datos);
      var r = JSON.parse(datos);
      if (r.status == "ok") {
        alertify.success("Dato actualizado con exito");
        $("#forDatos").hide();

        $("#table_datos").show();
        listarEstudiante();
        $("#editarEstu").modal("hide");
      } else {
        $("#precarga").hide();
        alertify.error(r.status);
      }
    },
  });
}
function cancelar() {
  $("#precarga").show();
  $("#forDatos").hide();
  $("#table_datos").show();
  $("#form2")[0].reset();
  listarEstudiante();
}

function mostrarEstudiante(id) {
  $("#table_datos").hide();
  $("#forDatos").show();

  $.post(
    "../controlador/listar_estudiante.php?op=mostar",
    { id: id },
    function (data, status) {
      data = JSON.parse(data);
      //console.log(data);
      $("#tipo").val(data.tipo_documento);
      $("#identi").val(data.credencial_identificacion);
      $("#lu_expe").val(data.expedido_en);
      $("#de_na").val(data.departamento_nacimiento);
      $("#mu_na").val(data.lugar_nacimiento);
      $("#fe_expe").val(data.fecha_expedicion);
      $("#fe_na").val(data.fecha_nacimiento);
      $("#credencial").val(data.id_credencial);
      $("#nombre_1").val(data.credencial_nombre);
      $("#nombre_2").val(data.credencial_nombre_2);
      $("#apellido_1").val(data.credencial_apellido);
      $("#apellido_2").val(data.credencial_apellido_2);
      $("#correo").val(data.credencial_login);
      $("#correo_p").val(data.email);
      $("#celular").val(data.celular);
      $("#telefo").val(data.telefono);
      $("#municipio").val(data.municipio);
      $("#direccion").val(data.direccion);
      $("#barri").val(data.barrio);
      $("#tipo_resi").val(data.tipo_residencia);
      $("#zo_re").val(data.zona_residencia);
      $("#wha").val(data.whatsapp);
      $("#ins").val(data.instagram);
      $("#faceb").val(data.facebook);
      $("#twi").val(data.twiter);
    }
  );
}

function mostrar_foto_estudiante(foto_eliminar) {
  $.post(
    "../controlador/listar_estudiante.php?op=mostrar_foto_estudiante",
    { foto_eliminar: foto_eliminar },
    function (data) {
      // console.log(data);
      data = JSON.parse(data);
      $("#ModalEliminarFoto").modal("show");
      $("#imagenmuestra").show();
      $("#imagenmuestra").html(data);
    }
  );
}

function eliminar_foto_estudiante(foto_eliminar_est) {
  alertify.confirm("¿Está Seguro de eliminar", function (result) {
    if (result) {
      $.post(
        "../controlador/listar_estudiante.php?op=eliminar_foto_estudiante",
        { foto_eliminar_est: foto_eliminar_est },
        function (e) {
          // console.log(e);
          if (e) {
            alertify.success("Eliminado correctamente");
            $("#ModalEliminarFoto").modal("hide");
            window.location.href = "listar_estudiante.php";
          } else {
            alertify.error("Error");
          }
        }
      );
    }
  });
}
function activarBotonDt(boton) {
  $(boton).toggleClass("btn-danger");
}

function ocultarBotonDt(boton_2) {
  $(boton_2).addClass("btn-danger");
  // if($(boton_2).hasClass("btn-success")){
  //     // $(boton).removeClass("btn-danger");
  // }
}

function iniciarTour(){
	introJs().setOptions({
		nextLabel: 'Siguiente',
		prevLabel: 'Anterior',
		doneLabel: 'Terminar',
		showBullets:false,
		showProgress:true,
		showStepNumbers:true,
		steps: [ 
			{
				title: 'Usuarios',
				intro: "Bienvenido a nuestra gestión de información sobre todos nuestros seres originales"
			},
		
		
			
		]
			
	},
	console.log()
	
	).start();

}