//JavaScript Document
$(document).ready(init);
//inicializacion de variables 
var tabla, tabla_cuotas;
//primera funcion que se ejecut cuando el documento esta listo 
function init() {
    $(".precarga").hide();
    $(".tabla_cuotas").hide();
    //busca un consulta especifica
    $("#busqueda_cuota").on("submit", function (e) {
        e.preventDefault();
        if ($("#tipo_busqueda").val() == 2) {
            tabla = "tabla_cuotas";
        } else {
            tabla = "tabla_info";
        }
        var tipo_busqueda = $("#tipo_busqueda").val();
        var dato_busqueda = $("#dato_busqueda").val();
        //envia a la funcion que lista la info
        listar_cuotas(tipo_busqueda, dato_busqueda, tabla);
    });
    //cuando cambie el tipo de busqueda que tambien lo haga la tabla
    $("#tipo_busqueda").on("change", function () {
        mostrar_tabla($("#tipo_busqueda").val());
    });
}
//selecciona una de las dos tablas a mostrar dependiendo del tipo de busqueda
function mostrar_tabla(valor) {
    if (valor == 2) {
        $(".tabla_cuotas").show();
        //$(".tabla_info").hide();
    } else {
        $(".tabla_info").show();
        $(".tabla_cuotas").hide();
        limpiarInfoSolicitante();
    }
}
//listar cuotas
function listar_cuotas(tipo_busqueda, dato_busqueda, tabla) {
    $(".btnBuscarCuota").prop("disabled", true);
    tabla_cuotas = $('#' + tabla).dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'rtip',
        "ajax": {
            "url": "../controlador/sofi_consultar_creditos_externos.php?op=listarCuotas",
            "type": "POST",
            "data": { "tipo_busqueda": tipo_busqueda, "dato_busqueda": dato_busqueda },
            "error": function (e) { console.log(e.responseText) }
        },
        "bDestroy": true,
        "iDisplayLength": 12,
        "ordering": false
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
    $('.dt-button').removeClass('dt-button');
    $(".btnBuscarCuota").prop("disabled", false);
    if (tipo_busqueda == 2) {
        verInfoSolicitante(dato_busqueda);
        saldo_debito(dato_busqueda);
    }
    mostrar_tabla(tipo_busqueda);
}
//funcion para limpiar informacion del aprobado
function limpiarInfoSolicitante() {
    $(".imagen_estudiante").attr("src", "../files/null.jpg");
    $(".profile-tipocc").html("---------------");
    $(".profile-documento").html("---------------");
    $(".nombre_completo").html("Nombre Financiado");
    $(".apellido_completo").html("---------------");
    $(".profile-direccion").html("---------------");
    $(".profile-celular").html("---------------");
    $(".profile-email").html("---------------");
    $(".info-periodo").html("---------------");
    $(".estado_financiacion").html("---------------");
    $(".estado_ciafi").html("---------------");
    $(".en_cobro").html("---------------");
    $(".categorizar_btn").html("---------------");
    $(".saldo_debito").html("---------------");
}
//funcion para ver informacion del aprobado
function verInfoSolicitante(consecutivo) {
    //muestra datos personales
    $.post("../controlador/sofi_consultar_creditos_externos.php?op=verInfoSolicitante", { consecutivo: consecutivo }, function (data) {
        //console.log(data);
        data = JSON.parse(data);
        if (data.exito == 1) {
            $(".imagen_estudiante").attr("src", "../files/estudiantes/" + data.numero_documento + ".jpg").on('error', function () {
                $(this).attr("src", "../files/null.jpg");
            });
            $(".profile-tipocc").html(data.tipo_documento);
            $(".profile-documento").html(data.numero_documento);
            $(".nombre_completo").html(data.nombres);
            $(".apellido_completo").html(data.apellidos);
            $(".profile-direccion").html(data.direccion);
            $(".profile-celular").html(data.celular + " - " + data.telefono);
            $(".profile-email").html(data.email);
            $(".info-periodo").html(data.periodo);
            $(".estado_financiacion").html(data.estado_financiacion);
            $(".estado_ciafi").html(data.estado_ciafi);
            $(".en_cobro").html(data.en_cobro);
            $(".categorizar_btn").html(data.categorizar);
            $(".historial_pagos").html(data.historial_pagos);
            $(".profile-consecutivo").html("# " + data.id);
            $(".profile-programa").html(data.programa);
            $(".profile-jornada").html(data.jornada);
            $(".profile-semestre").html(data.semestre);
            $(".profile-valor_financiado").html(data.valor_financiacion);
            $(".profile-forma_pago").html(data.dia_pago);
            $(".profile-cantidad_tiempo").html(data.cantidad_tiempo + " Meses");
            $(".estado_seguimientos").html(data.seguimiento);
        }
    });
}
//funcion para ver el saldo debito
function saldo_debito(consecutivo) {
    //muestra datos personales
    $.post("../controlador/sofi_consultar_creditos_externos.php?op=saldoDebito", { consecutivo: consecutivo }, function (data) {
        //console.log(data);
        data = JSON.parse(data);
        if (data.exito == 1) {
            $(".saldo_debito").html(data.saldo_debito);
            $("#input_saldo_debito").val(data.saldo_debito_sin_formato);
        }
    });
}
//listar historial de pagos
function historial_pagos(consecutivo) {
    $('#tabla_historial').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'rtip',
        "ajax": {
            "url": "../controlador/sofi_consultar_creditos_externos.php?op=historialPagos",
            "type": "POST",
            "data": { "consecutivo": consecutivo },
            "error": function (e) { console.log(e.responseText) }
        },
        "bDestroy": true,
        "iDisplayLength": 12,
        "ordering": false
    }).DataTable();
    $('#tabla_historial_mora').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'rtip',
        "ajax": {
            "url": "../controlador/sofi_consultar_creditos_externos.php?op=historialPagosMora",
            "type": "POST",
            "data": { "consecutivo": consecutivo },
            "error": function (e) { console.log(e.responseText) }
        },
        "bDestroy": true,
        "iDisplayLength": 12,
        "ordering": false
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
    $('.dt-button').removeClass('dt-button');
}
