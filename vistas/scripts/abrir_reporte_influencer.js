var maxCaracteres = 280;

$(document).ready(inicio);
function inicio() {
    $("#buscar_estudiante").off("submit").on("submit", function (e) {
        e.preventDefault();
        buscar_estudiante();
    });
    $("#formabrircaso").off("submit").on("submit", function (e) {
        e.preventDefault();
        Abrircaso();
    });
    $("#formularioCierreReporte").on("submit", function (e) {
        cerrarReporteInfluencer(e);
    });
    $("#precarga").hide();
    $("#btnabrircaso").prop('disabled', true);

    $("input[name='influencer_nivel_accion']").on("change", function () {
        if ($(this).val() == "Media") {
            $("#BajoRendimiento").prop("checked", true);
            $(".label_influencer_accion_media").addClass("bg-info text-white");
            $(".label_influencer_accion_alta").removeClass("bg-info text-white");
            $(".label_influencer_accion_positiva").removeClass("bg-info text-white");
            $(".gestionPositiva").fadeOut(500);
            $(".gestionMedia").fadeIn(500);

        } else if ($(this).val() == "Alta") {
            $("#BajoRendimiento").prop("checked", true);
            $(".label_influencer_accion_media").removeClass("bg-info text-white");
            $(".label_influencer_accion_alta").addClass("bg-info text-white");
            $(".label_influencer_accion_positiva").removeClass("bg-info text-white");
            $(".gestionPositiva").fadeOut(500);
            $(".gestionAlta").fadeIn(500);
        } else {
            $("#buen_desempeño").prop("checked", true);
            $(".label_influencer_accion_media").removeClass("bg-info text-white");
            $(".label_influencer_accion_alta").removeClass("bg-info text-white");
            $(".label_influencer_accion_positiva").addClass("bg-info text-white");
            $(".gestionPositiva").fadeIn(500);
            $(".gestionMedia").fadeOut(500);
        }
    });
    $("#reporteinfluencer").on("submit", function (e) {
        enviarReporte(e);
    });
    $('#influencer_mensaje').on('input', function () {
        let texto = $(this).val();
        let caracteresRestantes = maxCaracteres - texto.length;
        // En caso de que el usuario pegue más texto del permitido
        if (caracteresRestantes < 0) {
            $(this).val(texto.substring(0, maxCaracteres));
            caracteresRestantes = 0;
        }
        $('#contador_texto').text(caracteresRestantes);
    });
    $(".div_historico_reporte").hide();
    $(".div_formulario_cierre").hide();
    $(".gestionMedia").fadeOut(500);
}
//mostrar datos personales del estudiante
function buscar_estudiante() {
    $.post("../controlador/abrir_reporte_influencer.php?op=buscar_estudiante", { dato_busqueda: $("#input_estudiante").val() }, function (datos) {//enlace al controlador para traer los datos del estudiante
        //console.table(datos);
        datos = JSON.parse(datos);
        if (datos.exito == '0') {
            alertify.error(datos.info);
            limpiar();
        } else {
            buscar_casos();
            $(".nombre_estudiante").text(datos.info.nombre_estudiante);
            $(".apellido_estudiante").text(datos.info.apellido_estudiante);
            $(".tipo_identificacion").text(datos.info.tipo_identificacion);
            $(".numero_documento").text(datos.info.numero_documento);
            $(".direccion").text(datos.info.direccion);
            $(".celular").text(datos.info.celular);
            $(".correo").text(datos.info.email);
            $(".img_estudiante").prop("src", datos.info.foto);
            $(".lista_programas").html(datos.programas);
            $("#btnabrircaso").parent().removeClass("hide");
            $("#cedula-estudiante").html(datos.info.numero_documento);
            $("#id-estudiante-nuevo-caso").val(datos.info.id_credencial);
            $("#btnabrircaso").prop('disabled', false);
            $("#id_programa_ac").val(datos.id_programa_ac);
            $("#id_estudiante_influencer").val(datos.id_estudiante);
        }
    });
}
//Guardar Caso
function Abrircaso() {
    var formData = new FormData($("#formabrircaso")[0]);
    $.ajax({
        "url": "../controlador/abrir_reporte_influencer.php?op=guardarcaso",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            console.log(datos);
            datos = JSON.parse(datos);
            if (datos.exito == '0') {
                alertify.error(datos.info);
            } else {
                alertify.success(datos.info);
                $("#formabrircaso")[0].reset();
                $('#modal-nuevo-caso').modal("hide");
                buscar_casos();
            }
        }
    });
}

//listar en un datatable los casos
function buscar_casos() {
    $('#tabla_casos').dataTable({
        lengthChange: false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "dom": '<Bl<f>rtip>',//Definimos los elementos del control de tabla
        "columnDefs": [
            { "width": "10%", "targets": 0 }],
        "buttons": [
            {
                "extend": 'excelHtml5',
                "text": '<i class="fa fa-file-excel" style="color: green"></i>',
                "titleAttr": 'Excel'
            }],
        "ajax": {
            "url": '../controlador/abrir_reporte_influencer.php?op=buscar_casos',
            "type": "post",
            "data": { dato_busqueda: $("#input_estudiante").val() },
            "dataType": "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 12,//Paginación	
        "order": [[0, "desc"]]//Ordenar (columna,orden)
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat float-margin');
    $('.dt-button').removeClass('dt-button');
}
//esconder datos de los estudiantes
$('#datos_estudiante').on('hidden.bs.collapse', function () {
    $(".col-datos_e").removeClass("col-md-3");
    $(".col-datos_e").addClass("col-md-12");
    $(".tabla_busquedas").removeClass("col-md-9 col-lg-9");
    $(".tabla_busquedas").addClass("col-md-12 col-lg-12");
    $(".plusandminus").html('<i class="fas fa-plus"></i>');
});
//mostrar datos de los estudiantes
$('#datos_estudiante').on('shown.bs.collapse', function () {
    $(".col-datos_e").addClass("col-md-12");
    $(".col-datos_e").removeClass("col-md-12");
    $(".tabla_busquedas").addClass("col-md-12 col-lg-12");
    $(".tabla_busquedas").removeClass("col-md-12 col-lg-12");
    $(".plusandminus").html('<i class="fas fa-minus"></i>');
});
//Limpiar campos donde aparece info del estudiante
function limpiar() {
    $(".nombre_estudiante").text("----------------");
    $(".apellido_estudiante").text("----------------");
    $(".tipo_identificacion").text("---------------");
    $(".numero_documento").text("----------------");
    $(".direccion").text("----------------");
    $(".celular").text("---------------- ");
    $(".correo").text("--------------");
    $("#btnabrircaso").parent().addClass("hide");
    $(".img_estudiante").prop("src", '../files/null.jpg');
    $("#cedula-estudiante").html("");
    $("#id-estudiante-nuevo-caso").val("");
    $(".lista_programas").html('<li class="list-group-item"><b>Programa:</b> <br> <a class=" box-profiledates profile-programa">----------------</a></li><li class="list-group-item"><b>Semestre:</b> <a class="pull-right box-profiledates profile-semestre">----------------</a></li>');
}
//Función Listar
function enviarReporte(e) {
    e.preventDefault();
    var formData = new FormData($("#reporteinfluencer")[0]);
    $.ajax({
        "url": "../controlador/abrir_reporte_influencer.php?op=reporteinfluencer",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            datos = JSON.parse(datos);
            if (datos["0"] == "ok") {
                alertify.success("Reporte enviado");
                $("#modal-nuevo-caso").modal("hide");
                $("#reporteinfluencer")[0].reset();
                buscar_casos();
            } else {
                alertify.error('No se pudo crear el reporte');
            }
        },
    });
}
function mostrarInfoReporte(id_influencer_reporte) {
    $("#modalMostrarInfoReporte").modal("show")
    $(".div_historico_reporte").fadeIn(500);
    $(".div_tabla_reportes").fadeOut(500);
    $(".div_formulario_cierre").fadeOut(500);
    $.post("../controlador/abrir_reporte_influencer.php?op=mostrarInfoReporte", { "id_influencer_reporte": id_influencer_reporte }, function (data) {
        data = JSON.parse(data);
        if (data.exito == 1) {
            $(".historico_reporte").html(data.info);
        } else {
            Swal.fire("Error al mostrar el reporte: " + data.message);
        }
    });
}
function abrirFormCerrarCaso(id_influencer_reporte) {
    $("#id_influencer_reporte").val(id_influencer_reporte);
    $(".div_tabla_reportes").fadeOut(500);
    $(".div_historico_reporte").fadeOut(500);
    $(".div_formulario_cierre").fadeIn(500);
}
function cerrarReporteInfluencer(e) {
    e.preventDefault();
    var formData = new FormData($("#formularioCierreReporte")[0]);
    $.ajax({
        "url": "../controlador/abrir_reporte_influencer.php?op=cerrarReporteInfluencer",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            datos = JSON.parse(datos);
            if (datos.exito == 1) {
                alertify.success("Reporte enviado");
                $("#modalMostrarInfoReporte").modal("hide");
                $("#reporteinfluencer")[0].reset();
                buscar_casos();
            } else {
                alertify.error('No se pudo crear el reporte');
            }
        },
    });
}