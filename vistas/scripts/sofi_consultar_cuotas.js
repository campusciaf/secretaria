//JavaScript Document
$(document).ready(init);
//inicializacion de variables 
var tabla, tabla_cuotas;
//primera funcion que se ejecut cuando el documento esta listo 
function init() {
    //esconde la tabla de intereses 
    $(".box_tabla_intereses_mora").hide();
    //esconde el abono de interes debajo de la tabla de intereses 
    $("#total_abono_interes").hide();
    //esconde la tabla de informacion 
    $(".tabla_info").hide();
    //esconde la precarga0
    $("#precarga").hide();
    //esconde los formularios de tareas y seguimientos
    $("#forms_tareas_segs").hide();
    //esconde la caja que muestra la info de mora 
    $("#box_incluir_mora").hide();
    //escondemos el alert de error cuando se ingresa un monto mayor al abonado
    $(".alert-abono").hide();
    //escondemos el alert de error cuando se ingresa un monto menor a lo que se adelanta
    $(".alert-adelanto").hide();
    //busca un consulta especifica
    $("#formulario_abonos").on("submit", function (e) {
        e.preventDefault();
        //envia a la funcion que lista la info
        abonar_cuota();
    });
    //cuando se inserte el valor del adelanto envia el form
    $("#formulario_adelanto").on("submit", function (e) {
        e.preventDefault();
        //envia a la funcion que guarda la info
        adelantar_cuota();
    });
    //cuando se inserte el valor del adelanto envia el form
    $("#formulario_atraso").on("submit", function (e) {
        e.preventDefault();
        //envia a la funcion que guarda la info
        desatrasoCuota();
    });
    //guardar segumiento
    $("#formularioCategorizar").on("submit", function (e) {
        e.preventDefault();
        //envia a la funcion que guarda la info
        categoria_credito();
    });
    //guardar segumiento
    $("#formularioEditarCuotas").on("submit", function (e) {
        e.preventDefault();
        //envia a la funcion que guarda la info
        editarCuota();
    });
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
    //cambiar al formuilario
    $(".agregarSegumiento").off("click").on("click", function () {
        $("#forms_tareas_segs").show();
        $("#tablas_tareas_segs").hide();
    });
    //cambiar a las tablas
    $(".mostrarSeguimientos").off("click").on("click", function () {
        $("#forms_tareas_segs").hide();
        $("#tablas_tareas_segs").show();
    });
    //cuando cambie el tipo de busqueda que tambien lo haga la tabla
    $("#tipo_busqueda").on("change", function () {
        mostrar_tabla($("#tipo_busqueda").val());
    });
    //cuando cambie el check realizar la inclusion del mora
    $("#chequear_mora").on("change", function () {
        var cantidad_atrasado = $("#input_saldo_debito").val();
        vericar_valor_atrasado(cantidad_atrasado);
    });
    //vacea el campo del id al momento de cerrar el modal
    $('#modal_abonos').on('hidden.bs.modal', function () {
        limpiarInfoAbono();
    });
    //vacea el form al momento de cerrar el modal
    $('#modal_adelantos').on('hidden.bs.modal', function () {
        limpiarInfoAdelanto();
    });
    //vacea el form al momento de cerrar el modal
    $('#modal_atrasos').on('hidden.bs.modal', function () {
        limpiarInfoAtrasos();
    });
    $("#cantidad_atrasado").on("keyup", function () {
        $("#pago_con_mora").val(parseInt($("#cantidad_atrasado").val()) - parseInt($("#valor_mora").val()))
    });
}
function muestra(valor) {
    $("#dato").prop("disabled", false);
    $("#btnconsulta").prop("disabled", false);
    $("#input_dato").show();
    var tipo = $("#tipo").val(valor);
    if (valor == 1) {
        $(this).attr("placeholder", "Type your answer here");
        $("#valortitulo").html("Ingresar número de identificacíon")
    }
    if (valor == 2) {
        $("#valortitulo").html("Ingresar número de caso")
    }
    if (valor == 3) {
        $("#valortitulo").html("Ingresar número de tel/cel")
    }
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
            "url": "../controlador/sofi_consultar_cuotas.php?op=listarCuotas",
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
    $(".seguimientos_btn").html("---------------");
    $(".categorizar_btn").html("---------------");
    $(".dias_atrados_totales").html("---------------");
    $(".saldo_debito").html("---------------");
}
//funcion para ver informacion del aprobado
function verInfoSolicitante(consecutivo) {
    //muestra datos personales
    $.post("../controlador/sofi_consultar_cuotas.php?op=verInfoSolicitante", { consecutivo: consecutivo }, function (data) {
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
            $(".seguimientos_btn").html(data.seguimiento);
            $(".categorizar_btn").html(data.categorizar);
            $(".dias_atrados_totales").html(data.dias_atrados);
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
    //muestra datos personales
    $.post("../controlador/sofi_consultar_cuotas.php?op=saldoDebito", { consecutivo: consecutivo }, function (data) {
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
            "url": "../controlador/sofi_consultar_cuotas.php?op=historialPagos",
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
            "url": "../controlador/sofi_consultar_cuotas.php?op=historialPagosMora",
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
//cambia en estado de la financiacion
function cambiar_estado_financiacion(estado_financiacion, consecutivo, id_persona) {
    alertify.confirm('Confirmar', '¿ Estas segur@ de cambiar el estado de financiación ?', function () {
        $.post("../controlador/sofi_consultar_cuotas.php?op=cambiarEstadoFinanciacion", { estado_financiacion: estado_financiacion, id_persona: id_persona }, function (data) {
            data = JSON.parse(data);
            if (data.exito == 1) {
                alertify.success('Cambio de estado correcto');
                verInfoSolicitante(consecutivo);
                tabla_cuotas.ajax.reload();
            } else {
                alertify.error('Error en el cambio de estado');
            }
        });
    }, function () {
        alertify.error('Has cancelado el cambio de estado')
    });
}
//cambia en estado en el ciafi
function cambiar_estado_ciafi(estado_ciafi, consecutivo) {
    alertify.confirm('Confirmar', '¿ Estas segur@ de cambiar el estado de ciafi ?', function () {
        $.post("../controlador/sofi_consultar_cuotas.php?op=cambiarEstadoCiafi", { estado_ciafi: estado_ciafi, consecutivo: consecutivo }, function (data) {
            data = JSON.parse(data);
            if (data.exito == 1) {
                alertify.success('Cambio de estado correcto');
                verInfoSolicitante(consecutivo);
            } else {
                alertify.error('Error en el cambio de estado');
            }
        });
    }, function () {
        alertify.error('Has cancelado el cambio de estado')
    });
}
//cambia en estado en el cobro
function cambiar_estado_cobro(en_cobro, consecutivo) {
    alertify.confirm('Confirmar', '¿ Estas segur@ de cambiar el estado de ciafi ?', function () {
        $.post("../controlador/sofi_consultar_cuotas.php?op=cambiarEstadoCobro", { en_cobro: en_cobro, consecutivo: consecutivo }, function (data) {
            data = JSON.parse(data);
            if (data.exito == 1) {
                alertify.success('Cambio de estado correcto');
                verInfoSolicitante(consecutivo);
            } else {
                alertify.error('Error en el cambio de estado');
            }
        });
    }, function () {
        alertify.error('Has cancelado el cambio de estado')
    });
}
//funcion para pagar el total de la cuota
function pagar_cuota(id_financiamiento, consecutivo, tabla) {
    alertify.confirm('Confirmar', '¿ Estas segur@ de pagar la cuota ?', function () {
        $.post("../controlador/sofi_consultar_cuotas.php?op=pagarCuota", { id_financiamiento: id_financiamiento }, function (data) {
            data = JSON.parse(data);
            if (data.exito == 1) {
                alertify.success('Cuota pagada correctamente');
                listar_cuotas(2, consecutivo, tabla);
            } else {
                alertify.error('Error al pagar la cuota');
            }
        });
    }, function () {
        alertify.error('Has cancelado el pago de la cuota')
    });
}
//ajusta para que no se pase del valor establecido
function ajustes_abono(valor_cuota, id_financiamiento) {
    $("#id_financiamiento").val(id_financiamiento);
    $("#cantidad_abono").keyup(function () {
        var cantidad_abono = $("#cantidad_abono").val();
        vericar_valor(valor_cuota, cantidad_abono);
    });
}
//ajusta para que no se pase del valor establecido
function vericar_valor(valor_cuota, cantidad_abono) {
    if (valor_cuota <= cantidad_abono) {
        $(".alert-abono").show();
        $("#btn_abonar").attr("disabled", true);
    } else {
        $(".alert-abono").hide();
        $("#btn_abonar").attr("disabled", false);
    }
}
//limpiar informacion del form de abonos
function limpiarInfoAbono() {
    $("#formulario_abonos")[0].reset();
}
//registra el abono realizado
function abonar_cuota() {
    $("#btn_abonar").prop("disabled", true);
    var formData = new FormData($("#formulario_abonos")[0]);
    $.ajax({
        "url": "../controlador/sofi_consultar_cuotas.php?op=abonarCuota",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function (datos) {
            datos = JSON.parse(datos);
            $("#btn_abonar").prop("disabled", false);
            alertify.set('notifier', 'position', 'top-center');
            if (datos.exito == 1) {
                alertify.success(datos.info);
                listar_cuotas(2, datos.consecutivo, "tabla_cuotas");
                $("#modal_atrasos").modal('hide');
            } else {
                alertify.error(datos.info);
            }
        }
    });
}
//funcion para pagar el total de la cuota
function total_abono_cuota(id_financiamiento, consecutivo, tabla) {
    alertify.confirm('Confirmar', '¿ Estas segur@ de pagar la cuota ?', function () {
        $.post("../controlador/sofi_consultar_cuotas.php?op=totalAbonoCuota", { id_financiamiento: id_financiamiento }, function (data) {
            data = JSON.parse(data);
            if (data.exito == 1) {
                alertify.success('Cuota desatrasada correctamente');
                listar_cuotas(2, consecutivo, tabla);
            } else {
                alertify.error('Error al pagar la cuota');
            }
        });
    }, function () {
        alertify.error('Has cancelado el pago de la cuota')
    });
}
//limpiar informacion del form de abonos
function limpiarInfoAdelanto() {
    $("#formulario_adelanto")[0].reset();
}
//limpiar informacion del form de abonos
function limpiarInfoAtrasos() {
    $("#formulario_atraso")[0].reset();
    $(".box_tabla_intereses_mora").hide();
    $("#chequear_mora").prop("checked", false);
}
//registra el abono realizado
function adelantar_cuota() {
    $("#btn_adelantar").prop("disabled", true);
    var formData = new FormData($("#formulario_adelanto")[0]);
    $.ajax({
        "url": "../controlador/sofi_consultar_cuotas.php?op=adelantarCuota",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function (datos) {
            console.log(datos);
            datos = JSON.parse(datos);
            $("#btn_adelantar").prop("disabled", false);
            alertify.set('notifier', 'position', 'top-center');
            if (datos.exito == 1) {
                alertify.success(datos.info);
                listar_cuotas(2, datos.consecutivo, "tabla_cuotas");
                $("#modal_adelantos").modal('hide');
            } else {
                alertify.error(datos.info);
            }
        }
    });
}
//ajusta para que no sea menor el valor establecido
function ajustes_adelanto(valor_cuota, consecutivo) {
    $("#consecutivo").val(consecutivo);
    $("#cantidad_adelanto").keyup(function () {
        var cantidad_adelanto = $("#cantidad_adelanto").val();
        vericar_valor_adelanto(valor_cuota, cantidad_adelanto);
    });
}
//ajusta para que no sea menor el valor establecido
function vericar_valor_adelanto(valor_cuota, cantidad_adelanto) {
    if (valor_cuota >= cantidad_adelanto) {
        $(".alert-adelanto").show();
        $("#btn_adelantar").attr("disabled", true);
    } else {
        $(".alert-adelanto").hide();
        $("#btn_adelantar").attr("disabled", false);
    }
}
//ajusta para que no sea menor el valor establecido
function ajustes_atrasado(id_financiamiento, valor_cuota, consecutivo) {
    $("#financiamiento_atrasado").val(id_financiamiento);
    $("#consecutivo_atrasado").val(consecutivo);
    $("#cantidad_atrasado").val(valor_cuota);
    $("#cantidad_atrasado_no_mora").val(valor_cuota);
    $(".valor_cuota").val(parseInt($("#input_saldo_debito").val()));
    $(".pago_con_mora").val(0);
    $(".valor_mora").val(0);
}
//verificar e incluir mora
function vericar_valor_atrasado(cantidad_atrasado) {
    var consecutivo = $("#consecutivo_atrasado").val();
    if ($("#chequear_mora").is(':checked')) {
        $(".box_tabla_intereses_mora").show();
        $("#total_abono_interes").show();
        $('#tabla_intereses_mora').dataTable({
            "aProcessing": true,
            "aServerSide": true,
            "autoWidth": false,
            "dom": 'rt',
            "ajax": {
                "url": "../controlador/sofi_consultar_cuotas.php?op=calcularInteres",
                "type": "POST",
                "data": { "consecutivo": consecutivo },
                "error": function (e) {
                    console.log(e.responseText);
                }
            },
            "initComplete": function (settings, json) {
                console.log(json);
                $(".valor_cuota").val(parseInt(cantidad_atrasado));
                $(".valor_mora").val(parseInt(json.total_interes));
                $("#total_abono_interes").text();
                pago_a_realizar = $("#cantidad_atrasado").val();
                $("#cantidad_atrasado").val((parseInt(pago_a_realizar) + parseInt(json.total_interes)));
                $(".pago_con_mora").val((parseInt($("#cantidad_atrasado").val()) - parseInt(json.total_interes)));
            },
            "bDestroy": true,
            "iDisplayLength": 1000,
            "ordering": false
        }).DataTable();
        $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
        $('.dt-button').removeClass('dt-button');
    } else {
        $(".valor_cuota").val(parseInt(cantidad_atrasado));
        $("#cantidad_atrasado").val(parseInt($("#cantidad_atrasado_no_mora").val()));
        $(".valor_mora").val(0);
        $(".pago_con_mora").val(0);
        $(".box_tabla_intereses_mora").hide();
        $("#total_abono_interes").hide();
    }
}
//registra el abono realizado
function desatrasoCuota() {
    $(".btn_atraso").prop("disabled", true);
    var formData = new FormData($("#formulario_atraso")[0]);
    $.ajax({
        "url": "../controlador/sofi_consultar_cuotas.php?op=desatrasoCuota",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function (datos) {
            $(".btn_atraso").prop("disabled", false);
            console.log(datos);
            alertify.set('notifier', 'position', 'top-center');
            datos = JSON.parse(datos);
            if (datos.exito == 1) {
                alertify.success(datos.info);
                listar_cuotas(2, datos.consecutivo, "tabla_cuotas");
                $("#modal_atrasos").modal('hide');
            } else {
                alertify.error(datos.info);
            }
        }
    });
}
function ajustes_info_cuotas(id_cuota) {
    $.post("../controlador/sofi_consultar_cuotas.php?op=verInfoCuota", { id_cuota: id_cuota }, function (data) {
        //console.log(data)
        obj = JSON.parse(data);
        $("#estado_cuota").val(obj.estado);
        $("#valor_pagado").val(obj.valor_pagado);
        $("#fecha_pago").val(obj.fecha_pago);
        $("#fecha_plazo_pago").val(obj.plazo_pago);
        $("#id_editar_cuota").val(obj.id_financiamiento);
    });
}
function editarCuota() {
    $(".btn_editar_cuotas").prop("disabled", true);
    var formData = new FormData($("#formularioEditarCuotas")[0]);
    $.ajax({
        "url": "../controlador/sofi_consultar_cuotas.php?op=editarCuota",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function (datos) {
            $(".btn_editar_cuotas").prop("disabled", false);
            //console.log(datos);
            alertify.set('notifier', 'position', 'top-center');
            datos = JSON.parse(datos);
            if (datos.exito == 1) {
                alertify.success(datos.info);
                tabla_cuotas.ajax.reload();
                $("#modal_editar_cuotas").modal('hide');
            } else {
                alertify.error(datos.info);
            }
        }
    });
}
function modal_categoria(consecutivo) {
    $("#consecutivo_categoria").val(consecutivo);
    $.post("../controlador/sofi_consultar_cuotas.php?op=traerCategoria", { "consecutivo": consecutivo }, function (data) {
        console.log(data);
        data = JSON.parse(data);
        if (data.exito == 1) {
            $("#categoria_credito").val(data.info);
        }
    });
}
function categoria_credito() {
    $("#btnCategoria").prop("disabled", true);
    var formData = new FormData($("#formularioCategorizar")[0]);
    $.ajax({
        "url": "../controlador/sofi_consultar_cuotas.php?op=guardarCategoria",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            datos = JSON.parse(datos);
            $("#btnCategoria").prop("disabled", false);
            if (datos.exito == 1) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(datos.info);
                verInfoSolicitante($("#dato_busqueda").val());
                $("#modal_categoria").modal("hide");
            } else {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(datos.info);
            }
        }
    });
}