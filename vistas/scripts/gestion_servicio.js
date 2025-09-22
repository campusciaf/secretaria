var departamento_global;
var valor_global;
function init() {
    $("#mostrar_formulario_estudiante").hide();
    $("#info_personal_formulario").on("submit", function (e) {
        e.preventDefault();
    });
    $("#contrato").on("submit", function (e) {
        e.preventDefault();
        contratar();
    });
    
    $.post("../controlador/gestion_servicio.php?op=ListarEmpresas", function (r) {
        // Actualizar el select del modal "modal_contratar"
        $("#id_usuario").html(r);
        $("#id_usuario").selectpicker("refresh");
    
        // Actualizar el select del modal "modal_actividad"
        $("#id_usuario_actividad").html(r);
        $("#id_usuario_actividad").selectpicker("refresh");
    });
    $("#precarga").hide();
}
init();
function guardar_credencial(id_credencial_contrato) {
    $("#id_credencial_contrato").val(id_credencial_contrato);
    $("#modal_contratar").modal("show");
}
function verificarDocumento() {
    var dato = $("#dato_estudiante").val();
    var tipo = $("#tipo").val();
    var tabla_estudiantes = $("#datos_estudiantes").DataTable({
        aProcessing: true, //Activamos el procesamiento del datatables
        aServerSide: true, //Paginación y filtrado realizados por el servidor
        dom: "Bfrtip", //Definimos los elementos del control de tabla
        buttons: [
            {
                extend: "excelHtml5",
                text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                titleAttr: "Excel",
                exportOptions: {
                    columns: ":visible"
                }
            }
        ],
        ajax: {
            // Modificamos la URL para incluir el ID de la credencial como un parámetro
            url:
                "../controlador/gestion_servicio.php?op=listar_datos_estudiantes&dato=" +
                dato +
                " &tipo=" +
                tipo,
            type: "get",
            type: "get",
            dataType: "json",
            error: function (e) { }
        },
        bDestroy: true,
        iDisplayLength: 10, //Paginación
        order: [[1, "asc"]],
        initComplete: function (settings, json) {
            $("#precarga").hide();
        }
    });
}

/**** FUNCIONES PARA GUARDAR EL FORMULARIO DEL ESTUDIANTE ****/

function filtroportipo(valor) {
    $("#dato_estudiante").prop("disabled", false);
    $("#btnconsulta").prop("disabled", false);
    $("#input_dato_estudiante").show();
    $("#dato_estudiante").val("");
    $("#tipo").val(valor);
    valor_global = valor;
    if (valor == 1) {
        $("#valortituloestudiante").html("Ingresar número de identificación");
    }
    if (valor == 2) {
        $("#valortituloestudiante").html("Ingresar correo");
    }
    if (valor == 3) {
        $("#valortituloestudiante").html("Ingresar número de celular");
    }
    if (valor == 4) {
        $("#valortituloestudiante").html("Ingresar nombre");
    }
}

function listarEstudiante(idCredencial) {
    var dato = $("#dato_estudiante").val();

    var tabla_estudiantes = $("#datos_estudiantes").DataTable({
        aProcessing: true, //Activamos el procesamiento del datatables
        aServerSide: true, //Paginación y filtrado realizados por el servidor
        dom: "Bfrtip", //Definimos los elementos del control de tabla
        buttons: [
            {
                extend: "excelHtml5",
                text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                titleAttr: "Excel",
                exportOptions: {
                    columns: ":visible"
                }
            }
        ],
        ajax: {
            // Modificamos la URL para incluir el ID de la credencial como un parámetro
            url:
                "../controlador/gestion_servicio.php?op=listar_datos_estudiantes&id_credencial=" +
                idCredencial +
                "&valor_global=" +
                valor_global +
                "&dato=" +
                dato,
            type: "get",
            type: "get",
            dataType: "json",
            error: function (e) { }
        },
        bDestroy: true,
        iDisplayLength: 10, //Paginación
        order: [[1, "asc"]],
        initComplete: function (settings, json) {
            $("#precarga").hide();
        }
    });
}

function iniciarTour() {
    introJs()
        .setOptions({
            nextLabel: "Siguiente",
            prevLabel: "Anterior",
            doneLabel: "Terminar",
            showBullets: false,
            showProgress: true,
            showStepNumbers: true,
            steps: [
                {
                    title: "Gestión perfiles",
                    intro:
                        "Da un vistazo a nuestro modulo donde podrás observar todos nuestros horarios por salones activos"
                },
                {
                    title: "Salón",
                    element: document.querySelector("#t-programa"),
                    intro:
                        "Aquí podrás encontrar todos nuestros nuestros salones disponibles para que puedas consultar "
                }
            ]
        })
        .start();
}

function contratar() {
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#contrato")[0]);
    $.ajax({
        url: "../controlador/gestion_servicio.php?op=contratar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            $("#modal_contratar").modal("show");
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Estudiante contratado",
                showConfirmButton: false,
                timer: 1500
            });
            $("#datos_estudiantes").DataTable().ajax.reload();
        }
    });
}



function listar(id_escuela) {
    $("#precarga").show();
    $("#datos_estudiantes").hide();
    // var id_programa = $("#selector_programa").val();
    // var semestre = $("#selector_semestres").val();
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
    var fecha_hoy =
        diasSemana[f.getDay()] +
        ", " +
        f.getDate() +
        " de " +
        meses[f.getMonth()] +
        " de " +
        f.getFullYear();
    tabla = $("#tblrenovar")
        .dataTable({
            aProcessing: true, //Activamos el procesamiento del datatables
            aServerSide: true, //Paginación y filtrado realizados por el servidor
            dom: "Bfrtip", //Definimos los elementos del control de tabla
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: "Excel"
                },
                {
                    extend: "print",
                    text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop:
                        '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' +
                        fecha_hoy +
                        ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: "Docentes",
                    titleAttr: "Print"
                }
            ],
            ajax: {
                url:
                    "../controlador/gestion_servicio.php?op=listar&id_escuela=" +
                    id_escuela,
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            bDestroy: true,
            iDisplayLength: 10, //Paginación
            order: [[0, "desc"]], //Ordenar (columna,orden)
            initComplete: function (settings, json) {
                $("#precarga").hide();
            }
        })
        .DataTable();
}



function agregarActividad(id_credencial) {
    $("#id_credencial_actividad").val(id_credencial);
    $("#modal_actividad").modal("show");

}
$(document).ready(function () {
    $("#actividad").on("submit", function (e) {
        e.preventDefault();
        $("#btnGuardaractividad").prop("disabled", true);

        var formData = new FormData(this);
        $.ajax({
            url: "../controlador/gestion_servicio.php?op=Actividad",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Actividad registrada",
                    showConfirmButton: false,
                    timer: 1500
                });
                $("#modal_actividad").modal("hide");
                $("#actividad")[0].reset();
                $("#btnGuardaractividad").prop("disabled", false);
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se pudo registrar la actividad"
                });
                $("#btnGuardaractividad").prop("disabled", false);
            }
        });
    });
});


function listar_postulados(id_credencial) {
    $("#precarga").show();
    $.post(
        "../controlador/gestion_servicio.php?op=mostrar_listado_postulados",
        { id_credencial: id_credencial },
        function (e) {
            var r = JSON.parse(e);
            $("#usuarios_postulados").html(r[0]);
            $("#ModalListarPostulados").modal("show");
            $("#precarga").hide();

            $("#mostrarusuariospostulados").DataTable({
                destroy: true,
                dom: "Bfrtip",
                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Exportar a Excel",
                    },
                ],
            });
        }
    );
}

