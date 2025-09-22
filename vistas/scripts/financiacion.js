// JavaScript Document
$(document).ready(init);
//inicializacion de variables 
var tabla, tabla_cuotas;
//primera funcion que se ejecut cuando el documento esta listo 
function init() {
    listarCuotaActual()
    cargar_financiacion();
    ListarCreditosFinalizados();
    //esconde la precarga0
    $("#precarga").hide();
    //guardar segumiento
    $("#formularioPagarCuotas").on("submit", function (e) {
        e.preventDefault();
        //envia a la funcion que guarda la info
        pagarCuota();
    });
    $("input[name=optionsRadios]").on("click", function () {
        $(".btn_pagar_cuotas").attr("disabled", false);
        if ($("#optionsRadios3").is(':checked')) {
            $("#otro_valor").attr("disabled", false);
            $("#otro_valor").attr("required", true);
            $(".div_otro_valor").show();
        } else {
            $("#otro_valor").attr("disabled", true);
            $("#otro_valor").attr("required", false);
            $(".div_otro_valor").hide();
        }
    });
    if ($(window).width() <= 1083) {
        $("#tabla_cuotas").addClass("table-responsive");
    } else {
        $("#tabla_cuotas").removeClass("table-responsive");
    }
}
function datosPago(consecutivo) {
    saldo_debito(consecutivo);
    validarDatosYeminus(consecutivo)
    $("#consecutivo_pago").val(consecutivo);
}
function pagarCuota() {
    $(".pagos").hide();
    //muestra la precarga
    $("#precarga").show();
    $("#btn_pagar_cuota").prop("disabled", true);
    var formData = new FormData($("#formularioPagarCuotas")[0]);
    $.ajax({
        "url": "../controlador/financiacion.php?op=PagarCuota",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function (datos) {
            //esconde la precarga
            $("#precarga").hide();
            datos = JSON.parse(datos);
            if (datos.exito == 1) {
                $(".opciones_pagar_cuotas").fadeOut(500);
                $(".pagos").fadeIn(500);
                $(".pagos").html(datos.info);
            } else {
                alertify.error(datos.info);
            }
        }
    });
}
//funcion para buscar los datos de la persona que va a financiar
function cargar_financiacion() {
    //muestra datos personales
    $.post("../controlador/financiacion.php?op=cargarFinanciacion", {}, function (data) {
        data = JSON.parse(data);
        listar_cuotas(data["0"]["0"], data["0"]["1"], data["0"]["2"]);
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
    }
}
//listar cuotas
function listar_cuotas(tipo_busqueda, dato_busqueda, tabla) {
    $(".btnBuscarCuota").prop("disabled", true);
    $("#precarga").hide();
    tabla_cuotas = $('#' + tabla).dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'rtip',
        "ajax": {
            "url": "../controlador/financiacion.php?op=listarCuotas",
            "type": "POST",
            "data": { "tipo_busqueda": tipo_busqueda, "dato_busqueda": dato_busqueda },
            "error": function (e) { console.log(e.responseText) }
        },
        "bDestroy": true,
        "iDisplayLength": 12,
        "ordering": false,
        "initComplete": function () {
            if (tabla == "tabla_cuotas") {
                $(".tooltip-button").tooltip();
                $('html, body').animate({ scrollTop: $('.scroll_btn_pagar').offset().top},'slow');
            }
        },
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
    $('.dt-button').removeClass('dt-button');
    $(".btnBuscarCuota").prop("disabled", false);
    if (tipo_busqueda == 2) {
        verInfoSolicitante(dato_busqueda);
        saldo_debito(dato_busqueda);
        validarDatosYeminus(dato_busqueda);
    }
    mostrar_tabla(tipo_busqueda);
}
//listar cuotas
function listar_cuotas_finalizadas(tipo_busqueda, dato_busqueda, tabla) {
    $(".btnBuscarCuota").prop("disabled", true);
    $("#precarga").hide();
    tabla_cuotas = $('#' + tabla).dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'rtip',
        "ajax": {
            "url": "../controlador/financiacion.php?op=listarCuotasFinalizadas",
            "type": "POST",
            "data": { "tipo_busqueda": tipo_busqueda, "dato_busqueda": dato_busqueda },
            "error": function (e) { console.log(e.responseText) }
        },
        "bDestroy": true,
        "iDisplayLength": 12,
        "ordering": false,
        "initComplete": function () {
            if (tabla == "tabla_cuotas") {
                $(".tooltip-button").tooltip();
                $('html, body').animate({ scrollTop: $('.tabla_cuotas').offset().top},'slow');
            }
        },
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
    $('.dt-button').removeClass('dt-button');
    $(".btnBuscarCuota").prop("disabled", false);
    if (tipo_busqueda == 2) {
        verInfoSolicitante(dato_busqueda);
        saldo_debito(dato_busqueda);
        validarDatosYeminus(dato_busqueda);
    }
    mostrar_tabla(tipo_busqueda);
}
//listar cuotas
function ListarCreditosFinalizados() {
    $("#precarga").hide();
    tabla_creditos_finalizados = $('#tabla_creditos_finalizados').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'rtip',
        "ajax": {
            "url": "../controlador/financiacion.php?op=listarCreditosFinalizados",
            "type": "POST",
            "data": {},
            "error": function (e) { console.log(e.responseText) }
        },
        "bDestroy": true,
        "iDisplayLength": 12,
        "ordering": false,
        "initComplete": function () {
        },
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
    $('.dt-button').removeClass('dt-button');
}
//
function validarDatosYeminus(dato_busqueda) {
    $("#precarga").show();
    $.ajax({
        "url": "../controlador/financiacion.php?op=validarDatosFactura",
        "type": "POST",
        "data": { "dato_busqueda": dato_busqueda },
        success: function (datos) {
            $("#precarga").hide();
            $("#ingresar_inscripcion").prop("disabled", false);
            datos = JSON.parse(datos);
            $("#documento_yeminus").val(datos.info.codigoTercero);
            $("#prefijo").val(datos.info.prefijo);
            $("#tipoDocumento").val(datos.info.tipoDocumento);
        }
    });
}
//funcion para ver informacion del aprobado
function verInfoSolicitante(consecutivo) {
    //muestra datos personales
    $.post("../controlador/financiacion.php?op=verInfoSolicitante", { consecutivo: consecutivo }, function (data) {
        data = JSON.parse(data);
        if (data.exito == 1) {
            var image = $('<img src="../files/estudiantes/' + data.numero_documento + '.jpg" />');
            if (image.attr('width') > 0) {
                $(".imagen_estudiante").attr("src", "../files/estudiantes/" + data.numero_documento + ".jpg");
            } else {
                $(".imagen_estudiante").attr("src", "../files/null.jpg");
            }
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
            $(".seguimientos_btn").html(data.seguimiento);
            $(".historial_pagos").html(data.historial_pagos);
            $(".profile-consecutivo").html("# " + data.id);
            $(".profile-programa").html(data.programa);
            $(".profile-jornada").html(data.jornada);
            $(".profile-semestre").html(data.semestre);
            $(".profile-valor_financiado").html(data.valor_financiacion);
            $(".profile-forma_pago").html(data.dia_pago);
            $(".profile-cantidad_tiempo").html(data.cantidad_tiempo + " Meses");
        }
    });
}
//funcion para ver el saldo debito
function saldo_debito(consecutivo) {
    $('#tabla_intereses_mora').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'rtip',
        "ajax": {
            "url": "../controlador/financiacion.php?op=saldoDebito",
            "type": "POST",
            "data": { "consecutivo": consecutivo },
            "error": function (e) { console.log(e.responseText);}
        },
        "initComplete": function (settings, json) {
            console.log(json);
            if (json.atraso == 1) {
                $(".box_intereses").removeClass("d-none");
            } else {
                $(".box_intereses").addClass("d-none");
            }
            // Formatear el número como dinero
            var pago_minimo = parseInt(json.pago_minimo).toLocaleString('en-US', { "style": 'currency', "currency": 'USD'});
            var valor_total = parseInt(json.valor_total).toLocaleString('en-US', { "style": 'currency', "currency": 'USD'});
            $(".pagar_minimo").html(pago_minimo);
            $("#input_pagar_minimo").val(json.pago_minimo);
            $(".saldo_debito").html(valor_total);
            $(".pagar_total").html(valor_total);
            $("#input_pagar_total").val(json.valor_total);
            $("#input_mora").val(json.total_interes);
        },
        "bDestroy": true,
        "iDisplayLength": 12,
        "ordering": false
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
    $('.dt-button').removeClass('dt-button');
}
//funcion para listar la cuota actual
function listarCuotaActual() {  
    $.ajax({
        "url": "../controlador/financiacion.php?op=listarCuotaActual",
        "type": "POST",
        "success": function (datos) {
            console.log(datos);
            //esconde la precarga
            datos = JSON.parse(datos);
            if (datos.exito == 1) {
                $("#listadoCuotasActuales").html(datos.html);
                $(".div_otro_valor").hide();
            } else {
                alertify.error(datos.html);
            }
        }
    });
}