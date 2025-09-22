var tabla;
//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });
}
//Función limpiar
function limpiar() {
    $("#formulario")[0].reset();
}
//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}
//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}
//Función Listar
function listar() {
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
    var fecha_hoy =
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
                url: "../controlador/puntos_asignar_billetera.php?op=listar",
                type: "get",
                dataType: "json",
                error: function (e) {
                    // console.log(e.responseText);
                }
            },
            initComplete: function () {
                $("#precarga").hide();
            },
            bDestroy: true,
            iDisplayLength: 10, //Paginación
            order: [[0, "desc"]] //Ordenar (columna,orden)
        })
        .DataTable();
}
//Función Listar
function billeterasActivas(id_docente) {
    $("#modalBilleterasDocente").modal("show");
    $("#precarga").show();
    $.post("../controlador/puntos_asignar_billetera.php?op=billeterasActivas", { id_docente: id_docente }, function (data, status) {
        $("#precarga").hide();
        data = JSON.parse(data);
        if (data.exito == 1) {
            $("#billeterasActivas").html(data.info);
        }
    });
}
//Función para guardar o editar
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../controlador/puntos_asignar_billetera.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            datos = JSON.parse(datos)
            // console.log(datos);
            if (datos.exito == 1) {
                alertify.success(datos.info);
                mostrarform(false);
                tabla.ajax.reload();
            } else {
                alertify.error(datos.info);
            }
        }
    });
    limpiar();
}
function mostrar(id_usuario) {
    mostrarform(true);
    $("#id_docente_puntos").val(id_usuario);
}
init();