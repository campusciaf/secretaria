var tabla;
var nivelSeleccionado = "Todos";
function init() {
    listarprogramas();
    // ejecuta la accion para los formularios de guardar y agregar programa
    $.post("../controlador/reporte_influencer.php?op=selectPeriodo", function (r) {
        $("#periodo_filtro").html(r);
        $("#periodo_filtro").selectpicker("refresh");
        var periodopordefecto = $("#periodo_filtro option:eq(1)").val();
        $("#periodo_filtro").val(periodopordefecto).selectpicker("refresh");
        $("#dato_periodo").html(periodopordefecto);
    });
    $('#periodo_filtro').on('change', function () {
        listarprogramas(); // Llama a listar programas cuando cambia el período seleccionado
    });
    $("#form_respuesta_reporte").on("submit", function (e) {
        e.preventDefault();
        insertarRespuestaReporte();
    });
    $(".btn-nivel").on("click", function () {
        nivelSeleccionado = $(this).data("nivel");
        $(".btn-nivel").removeClass("active");
        $(this).addClass("active");
        listarprogramas();
    });
}
function listarprogramas() {
    $("#precarga").show();
    var periodoSeleccionado = $("#periodo_filtro").val();
    $("#dato_periodo").html(periodoSeleccionado);
    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    var f = new Date();
    var fecha = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tbllistaprogramas').dataTable({
        "aProcessing": true, // Activamos el procesamiento del datatables
        "aServerSide": true, // Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', // Definimos los elementos del control de tabla
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                titleAttr: 'Excel',
            },
            {
                extend: 'print',
                text: '<i class=" text-center fa fa-file-pdf fa-2x" style="color: red"></i>',
                messageTop: '<div style="width:50%;float:left">Reporte Influencer<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
                title: 'Reporte Influencer',
                titleAttr: 'Print'
            },
        ],
        "ajax": {
            url: '../controlador/reporte_influencer.php?op=listarprogramas',
            type: 'POST',
            "data": { periodoSeleccionado: periodoSeleccionado, nivelSeleccionado: nivelSeleccionado }, // Envía el periodo y nivel seleccionado
            dataType: "json",
            error: function (e) {
                // console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, // Paginación
        "order": [[0, "desc"]], // Ordenar (columna,orden)
        'initComplete': function (settings, json) {
            $("#precarga").hide();
            scroll(0, 0);
            $('[data-toggle="tooltip"]').tooltip({
                boundary: 'window',
            });
            // Escucha el evento 'shown.bs.tooltip' para ajustar el ancho de los tooltips una vez mostrados
            $('[data-toggle="tooltip"]').on('shown.bs.tooltip', function () {
                // Encuentra el último tooltip mostrado y ajusta su ancho
                var $tooltipInner = $('.tooltip.show .tooltip-inner');
                $tooltipInner.css('max-width', '600px'); // Ajusta esto a tus necesidades
            });
        },
    });
}
function mostrarInfoReporte(id_influencer_reporte, tipo_influencer) {
    $.post("../controlador/reporte_influencer.php?op=mostrarInfoReporte", { "id_influencer_reporte": id_influencer_reporte, "tipo_influencer": tipo_influencer }, function (data) {
        data = JSON.parse(data);
        if (data.exito == 1) {
            $("#modal-info-reporte").modal("show");
            $("#id_reporte_influencer").val(id_influencer_reporte);
            $(".historico_reporte").html(data.info);
            // almacenamos los datos del docente o funcionaro para enviar la notificacion.
            $("#docente_nombre").val(data.docente_nombre);
            $("#nombre_estudiante").val(data.nombre_estudiante);
            $("#usuario_login").val(data.usuario_login);
        } else {
            Swal.fire("Error al mostrar el reporte: " + data.message);
        }
    });
}
function insertarRespuestaReporte() {
    var formdata = new FormData($("#form_respuesta_reporte")[0]);
    $.ajax({
        "url": "../controlador/reporte_influencer.php?op=insertarRespuestaReporte",
        "type": "POST",
        "data": formdata,
        "contentType": false,
        "processData": false,
        success: function (data) {
            data = JSON.parse(data);
            if (data.exito == 1) {
                // $("#form_respuesta_reporte")[0].reset();
                //unicamente refrescamos el camppo de mensaje respuesta para que quede vacio.
                $("#mensaje_respuesta").val(""); 
                $(".historico_reporte").append(data.html);
            } else {
                Swal.fire(data.info, "", "error");
            }
        },
        error: function (xhr, status, error) {
            Swal.fire("Error al enviar la respuesta: " + error);
        }
    });
}
init();
