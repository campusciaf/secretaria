var tabla_reporte;
$(document).ready(generar_reporte);
function generar_reporte() {
    $("#precarga").hide();
    $("#tabla_estudiantes_mes_wrapper").hide();
    listarPeriodos();
    $("#modal-referencias").on("hidden.bs.modal", function () {
        limpiar_referencias();
    });
}
function listarPeriodos() {
    $.ajax({
        "url": "../controlador/sofi_reporte_quincenal.php?op=listarperiodos",
        "type": "POST",
        "success": function (e) {
            //periodo_buscar
            //console.log(e);
            e = JSON.parse(e);
            var html = '<option value="" disabled >- Selecciona Un Periodo -</option>';
            for (var i = 0; i < e.length; i++) {
                if ((i + 1) < e.length) {
                    html += '<option value="' + e[i].periodo + '">' + e[i].periodo + '</option>';
                } else {
                    html += '<option value="' + e[i].periodo + '" selected> ' + e[i].periodo + '</option>';
                }
            }
            $("#periodo_buscar").html(html);
            listarReportes();
        }
    });
}
function listarReportes() {
    $("#precarga").show();
    periodo_buscar = $("#periodo_buscar").val();
    motivo_financiacion = $("#motivo_financiacion").val();
    tabla_reporte = $('#tabla_reporte').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "buttons": [{
            "extend": 'copyHtml5',
            "text": '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
            "titleAttr": 'Copy'
        }, {
            "extend": 'excelHtml5',
            "text": '<i class="fa fa-file-excel" style="color: green"></i>',
            "titleAttr": 'Excel'
        },
        {
            "extend": 'csvHtml5',
            "text": '<i class="fa fa-file-alt"></i>',
            "titleAttr": 'CSV'
        },
        {
            "extend": 'pdfHtml5',
            "text": '<i class="fa fa-file-pdf" style="color: red"></i>',
            "titleAttr": 'PDF',
        }
        ],
        "ajax": {
            "url": "../controlador/sofi_reporte_quincenal.php?op=reporte_quincenal",
            "data": { "periodo_buscar": periodo_buscar, "motivo_financiacion": motivo_financiacion },
            "type": "POST",
            "dataType": "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "initComplete": function name(params) {
            $('[data-toggle="tooltip"]').tooltip();
            $("#precarga").hide();
        },
        "language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "search": "",
            "searchPlaceholder": "Buscar...",
            "zeroRecords": "Cero datos.",
            "emptyTable": "<div class='jumbotron text-center' style='margin:0px !important; background: #007bff; color:white'><h3> Excelente, No hay estudiantes atrazados (ﾉ◕ヮ◕)ﾉ*:･ﾟ✧.</h3></div>",
            "buttons": {
                "copyTitle": "Tabla Copiada",
                "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            }
        },
        "bDestroy": true,
        "iDisplayLength": 12,
        "order": []
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat float-margin');
    $('.dt-button').removeClass('dt-button');
}
function verporfecha(fecha_ini, fecha_fin, periodo) {
    $('#tablaregistros').hide(500);
    $('#tabla_estudiantes_mes_wrapper').show(500);
    tabla_estudiantes_mes = $('#tabla_estudiantes_mes').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "buttons": [{
            "extend": 'copyHtml5',
            "text": '<i class="fa fa-copy" padding-top : 0px;"></i>',
            "titleAttr": 'Copy'
        }, {
            "extend": 'excelHtml5',
            "text": '<i class="fa fa-file-excel"></i>',
            "titleAttr": 'Excel'
        }, {
            "extend": 'csvHtml5',
            "text": '<i class="fa fa-file-alt"></i>',
            "titleAttr": 'CSV'
        }, {
            "extend": 'pdfHtml5',
            "text": '<i class="fa fa-file-pdf"></i>',
            "titleAttr": 'PDF',
        }, {
            "text": '<i class="fas fa-arrow-left" style="color: red"></i> Volver',
            "className": "button-back",
            "action": function (e, node, config) {
                $('#tablaregistros').show(500);
                $('#tabla_estudiantes_mes_wrapper').hide(500);
            },
            "titleAttr": 'Regresar a la lista',
        }
        ],
        "ajax": {
            "url": "../controlador/sofi_reporte_quincenal.php?op=estudiante_x_mes",
            "type": "POST",
            "data": {
                "fecha_inicial": fecha_ini,
                "fecha_final": fecha_fin,
                "periodo": periodo,
                "motivo_financiacion": $("#motivo_financiacion").val()
            },
            "dataType": "json",
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        "language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "search": "",
            "searchPlaceholder": "Buscar...",
            "zeroRecords": "Cero datos.",
            "emptyTable": "<div class='jumbotron text-center' style='margin:0px !important; background: #007bff; color:white'><h3> Excelente, No hay estudiantes atrazados (ﾉ◕ヮ◕)ﾉ*:･ﾟ✧.</h3></div>",
            "buttons": {
                "copyTitle": "Tabla Copiada",
                "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            }
        },
        "bDestroy": true,
        "iDisplayLength": 12,
        "order": []
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat float-margin');
    $('.dt-button').removeClass('dt-button');
}
function verporfechaPagados(fecha_ini, fecha_fin, periodo) {
    $('#tablaregistros').hide(500);
    $('#tabla_estudiantes_mes_wrapper').show(500);
    tabla_estudiantes_mes = $('#tabla_estudiantes_mes').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "buttons": [{
            "extend": 'copyHtml5',
            "text": '<i class="fa fa-copy" padding-top : 0px;"></i>',
            "titleAttr": 'Copy'
        }, {
            "extend": 'excelHtml5',
            "text": '<i class="fa fa-file-excel"></i>',
            "titleAttr": 'Excel'
        }, {
            "extend": 'csvHtml5',
            "text": '<i class="fa fa-file-alt"></i>',
            "titleAttr": 'CSV'
        }, {
            "extend": 'pdfHtml5',
            "text": '<i class="fa fa-file-pdf"></i>',
            "titleAttr": 'PDF',
        }, {
            "text": '<i class="fas fa-arrow-left" style="color: red"></i> Volver',
            "className": "button-back",
            "action": function (e, node, config) {
                $('#tablaregistros').show(500);
                $('#tabla_estudiantes_mes_wrapper').hide(500);
            },
            "titleAttr": 'Regresar a la lista',
        }
        ],
        "ajax": {
            "url": "../controlador/sofi_reporte_quincenal.php?op=estudiante_x_mes_pagados",
            "type": "POST",
            "data": {
                "fecha_inicial": fecha_ini,
                "fecha_final": fecha_fin,
                "periodo": periodo,
                "motivo_financiacion": $("#motivo_financiacion").val()
            },
            "dataType": "json",
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        "language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "search": "",
            "searchPlaceholder": "Buscar...",
            "zeroRecords": "Cero datos.",
            "emptyTable": "<div class='jumbotron text-center' style='margin:0px !important; background: #007bff; color:white'><h3> Excelente, No hay estudiantes atrazados (ﾉ◕ヮ◕)ﾉ*:･ﾟ✧.</h3></div>",
            "buttons": {
                "copyTitle": "Tabla Copiada",
                "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            }
        },
        "bDestroy": true,
        "iDisplayLength": 12,
        "order": []
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat float-margin');
    $('.dt-button').removeClass('dt-button');
}
function mostrarcuotas(elem, consecutivo) {
    $(".nombre_atrazado").html($(elem).data("name_user"));
    listarCuotas({ 'op': 'search', 'dato_busqueda': consecutivo, 'tipo_busqueda': 'Consecutivo' });
}
function listarCuotas(datos) {
    search_cuota = $('#search_cuota').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'rtip',
        "ajax": {
            "url": '../controlador/sofi_reporte_quincenal.php?op=' + datos.op,
            "type": "POST",
            "dataType": "json",
            "data": datos,
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        "columnDefs": [{ "width": "10%", "targets": 0 },
        { "width": "10%", "targets": 1 },
        { "width": "20%", "targets": 2 },
        { "width": "15%", "targets": 5 },
        {
            "targets": [7],
            "visible": false,
            "searchable": false
        },
        {
            "targets": 6,
            "createdCell": function (td, cellData, rowData, row, col) {
                if (cellData > 0) {
                    if (!(rowData["0"].indexOf("Atrazado") == -1)) {
                        $(td).css('color', 'red')
                    } else {
                        $(td).html('0');
                    }
                }
            }
        }, {
            "targets": 0,
            "createdCell": function (td, cellData, rowData, row, col) {
                if (!(rowData["0"].indexOf("A Pagar") == -1)) {
                    $(td).html('A Pagar');
                } else if (!(rowData["0"].indexOf("En proceso") == -1)) {
                    $(td).css('color', '#f39c12');
                    $(td).html('En proceso');
                } else if (!(rowData["0"].indexOf("Atrazado") == -1)) {
                    $(td).css('color', 'red');
                    $(td).html('Atrazado');
                } else if (!(rowData["0"].indexOf("Pagado") == -1)) {
                    $(td).css('color', '#00a65a');
                    $(td).html('Pagado');
                }
            }
        }],
        "language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "emptyTable": "<div class='jumbotron text-center bg-teal' style='margin:0px !important'><h3>No se encontraron datos de este estudiante.</h3></div>",
            "buttons": {
                "copyTitle": "Tabla Copiada",
                "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            },
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
        },
        "bDestroy": true,
        "iDisplayLength": 12,
        "order": [[1, "asc"]]
    }).DataTable();
}
function addseguimiento() {
    var formData = new FormData($("#formularioseg")[0]);
    $.ajax({
        "url": "../controlador/seguimientos.php?op=guardaryeditar",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            //console.log(datos);
            datos = JSON.parse(datos);
            if (datos.length > 2) {
                for (i = 0; i < datos.length; i++) {
                    if (datos[i].estatus) {
                        $("#" + datos[i].data).parent().removeClass("has-error");
                        $("#" + datos[i].data).parent().addClass("has-success");
                        $("#span-" + datos[i].data).removeClass("fa-times");
                        $("#span-" + datos[i].data).addClass("fa-check");
                    } else {
                        $("#" + datos[i].data).parent().removeClass("has-success");
                        $("#" + datos[i].data).parent().addClass("has-error");
                        $("#span-" + datos[i].data).addClass("fa-times");
                        $("#span-" + datos[i].data).removeClass("fa-check");
                    }
                }
            } else {
                if (datos.estatus) {
                    alertify.success(datos.valor);
                    mostrarseg($(".idpersonaseg").val());
                    limpiarsegs();
                    ordenarsegs();
                } else {
                    alertify.error(datos.valor);
                }
            }
        }
    });
}
function mostrarseg(idpersona) {
    vertareas(idpersona);
    $(".idpersonaseg").val(idpersona);
    $(".timeline-seg").html(`<div class="col-md-12 bg">
        <div class="loader" id="loader-2">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>`);
    $.post("../controlador/seguimientos.php?op=mostrar", { idpersona: idpersona }, function (e, status) {
        $(".timeline-seg").html(e);
    });
}
function limpiar_referencias() {
    $(".banco_nombre").html("");
    $(".banco_cuenta").html("");
    $(".banco_numero").html("");
    $(".entidad_nombre").html("");
    $(".entidad_telefono").html("");
    $(".familia_nombre1").html("");
    $(".familia_telefono1").html("");
    $(".familia_nombre2").html("");
    $(".familia_telefono2").html("");
    $(".persona_nombre1").html("");
    $(".persona_telefono1").html("");
    $(".persona_nombre2").html("");
    $(".persona_telefono2").html("");
}
//funcion para Pre Aprobar la solicitud
function verInfoSolicitante(id) {
    //muestra datos personales
    $.post("../controlador/sofi_financiados.php?op=verInfoSolicitante", { id_persona: id }, function (data, status) {
        data = JSON.parse(data);
        $(".info-tipo_documento").html(data.tipo_documento);
        $(".info-numero_documento").html(data.numero_documento);
        $(".info-nombres").html(data.nombres);
        $(".info-apellidos").html(data.apellidos);
        $(".info-fecha_nacimiento").html(data.fecha_nacimiento);
        $(".info-direccion").html(data.direccion);
        $(".info-ciudad").html(data.ciudad);
        $(".info-telefono").html(data.telefono);
        $(".info-celular").html(data.celular);
        $(".info-email").html(data.email);
        $(".info-ocupacion").html(data.ocupacion);
        $(".info-periodo").html(data.periodo);
        $(".title_name_sol").html("Nombre: " + data.nombres + " " + data.apellidos);
    });
    //muestra referencias
    $.post("../controlador/sofi_financiados.php?op=verRefeSolicitante", { id_persona: id }, function (data) {
        data = JSON.parse(data);
        //console.log(data);
        var html = ``;
        for (var i = 0; i < Object.keys(data).length; i++) {
            if (data[i].tipo_referencia == "Bancaria") {
                html += `<tr><td class="text-green text-center"><strong> ` + data[i].tipo_referencia + ` </strong></td></tr>
				    <tr><td><strong>Tipo Cuenta:</strong><span class="pull-right">`+ data[i].tipo_cuenta + `</span></td></tr>
                    <tr><td><strong>Número Cuenta:</strong><span class="pull-right">`+ data[i].numero_cuenta + ` </span></td></tr>`;
            } else {
                html += `<tr><td class="text-green text-center"><strong> ` + data[i].tipo_referencia + ` </strong></td></tr>
                <tr><td><strong>Nombre Completo:</strong><span class="pull-right">`+ data[i].nombre + `</span></td></tr>
                <tr><td><strong>Teléfono:</strong><span class="pull-right">`+ data[i].telefono + ` - ` + data[i].celular + ` </span></td></tr>`;
            }
        }
        $(".table-references").html(html);
    });
}
function limpiarcampos() {
    $(".info-tipo_documento").html("");
    $(".info-numero_documento").html("");
    $(".info-nombres").html("");
    $(".info-apellidos").html("");
    $(".info-fecha_nacimiento").html("");
    $(".info-estado_civil").html("");
    $(".info-direccion").html("");
    $(".info-ciudad").html("");
    $(".info-telefono").html("");
    $(".info-celular").html("");
    $(".info-email").html("");
    $(".info-ocupacion").html("");
    $(".info-persona_a_cargo").html("");
    $(".info-universidad").html("");
    $(".info-periodo").html("");
    $(".info-estado").html("");
    $(".ingreso-empresa_laboral").html("");
    $(".ingreso-direccion_empresa").html("");
    $(".ingreso-telefono_empresa").html("");
    $(".ingreso-cargo_trabajo").html("");
    $(".ingreso-tiempo_servicio").html("");
    $(".ingreso-salario").html("");
    $(".ingreso-ing_arriendos").html("");
    $(".ingreso-ing_pensiones").html("");
    $(".ingreso-ing_empresas").html("");
    $(".ingreso-ing_dir_empresa").html("");
    $(".ingreso-ing_tel_empresa").html("");
    $(".ingreso-ing_neg_propio").html("");
    $(".ingreso-ing_dir_neg_propio").html("");
    $(".ingreso-int_tel_neg_propio").html("");
    $(".ingreso-total_ingresos").html("");
    $(".gasto-alimentacion").html("");
    $(".gasto-cuota_arrendamiento").html("");
    $(".gasto-educacion").html("");
    $(".gasto-salud").html("");
    $(".gasto-otros_gastos").html("");
    $(".gasto-total_gastos").html("");
    $(".bienes-clase").html();
    $(".bienes-direccion_bien").html("");
    $(".bienes-valor_comercial").html("");
    $(".bienes-numero_matricula").html("");
    $(".bienes-hipotecado").html("");
    $(".bienes-saldo_hipoteca").html("");
    $(".clase_vehiculo").html("");
    $(".marca_vehiculo").html("");
    $(".modelo_vehiculo").html("");
    $(".placa_vehiculo").html("");
    $(".valor_vehiculo").html("");
    $(".prenda_vehiculo").html("");
    $(".saldo_deuda").html("");
    $(".banco_nombre").html("");
    $(".banco_cuenta").html("");
    $(".banco_numero").html("");
    $(".entidad_nombre").html("");
    $(".entidad_telefono").html("");
    $(".familia_nombre1").html("");
    $(".familia_telefono1").html("");
    $(".familia_nombre2").html("");
    $(".familia_telefono2").html("");
    $(".persona_nombre1").html("");
    $(".persona_telefono1").html("");
    $(".persona_nombre2").html("");
    $(".persona_telefono2").html("");
}
function listarPorPeriodo(valor) {
    $("#tabla_estudiantes_mes_wrapper").hide();
    tabla_reporte = $('#tabla_reporte').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "buttons": [{
            "extend": 'copyHtml5',
            "text": '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
            "titleAttr": 'Copy'
        }, {
            "extend": 'excelHtml5',
            "text": '<i class="fa fa-file-excel" style="color: green"></i>',
            "titleAttr": 'Excel'
        }, {
            "extend": 'csvHtml5',
            "text": '<i class="fa fa-file-alt"></i>',
            "titleAttr": 'CSV'
        }, {
            "extend": 'pdfHtml5',
            "text": '<i class="fa fa-file-pdf" style="color: red"></i>',
            "titleAttr": 'PDF',
        }],
        "ajax": {
            "url": "../controlador/sofi_reporte_quincenal.php?op=reporte_quincenal",
            "type": "POST",
            "data": { "periodo": valor },
            "dataType": "json",
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        "language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "search": "",
            "searchPlaceholder": "Buscar...",
            "zeroRecords": "Cero datos.",
            "emptyTable": "<div class='jumbotron text-center' style='margin:0px !important; background: #007bff; color:white'><h3> Excelente, No hay estudiantes atrazados (ﾉ◕ヮ◕)ﾉ*:･ﾟ✧.</h3></div>",
            "buttons": {
                "copyTitle": "Tabla Copiada",
                "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            }
        },
        "bDestroy": true,
        "iDisplayLength": 12,
        "order": []
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat float-margin');
    $('.dt-button').removeClass('dt-button');
    $("#modal-referencias").on("hidden.bs.modal", function () {
        limpiar_referencias();
    });
}
//funcion para Pre Aprobar la solicitud
function verInfoSolicitante(id) {
    //muestra datos personales
    $.post("../controlador/sofi_financiados.php?op=verInfoSolicitante", { id_persona: id }, function (data, status) {
        data = JSON.parse(data);
        $(".info-tipo_documento").html(data.tipo_documento);
        $(".info-numero_documento").html(data.numero_documento);
        $(".info-nombres").html(data.nombres);
        $(".info-apellidos").html(data.apellidos);
        $(".info-fecha_nacimiento").html(data.fecha_nacimiento);
        $(".info-direccion").html(data.direccion);
        $(".info-ciudad").html(data.ciudad);
        $(".info-telefono").html(data.telefono);
        $(".info-celular").html(data.celular);
        $(".info-email").html(data.email);
        $(".info-ocupacion").html(data.ocupacion);
        $(".info-periodo").html(data.periodo);
        $(".title_name_sol").html("Nombre: " + data.nombres + " " + data.apellidos);
    });
    //muestra referencias
    $.post("../controlador/sofi_financiados.php?op=verRefeSolicitante", { id_persona: id }, function (data) {
        data = JSON.parse(data);
        //console.log(data);
        var html = ``;
        for (var i = 0; i < Object.keys(data).length; i++) {
            if (data[i].tipo_referencia == "Bancaria") {
                html += `<tr><td class="text-green text-center"><strong> ` + data[i].tipo_referencia + ` </strong></td></tr>
				    <tr><td><strong>Tipo Cuenta:</strong><span class="pull-right">`+ data[i].tipo_cuenta + `</span></td></tr>
                    <tr><td><strong>Número Cuenta:</strong><span class="pull-right">`+ data[i].numero_cuenta + ` </span></td></tr>`;
            } else {
                html += `<tr><td class="text-green text-center"><strong> ` + data[i].tipo_referencia + ` </strong></td></tr>
                <tr><td><strong>Nombre Completo:</strong><span class="pull-right">`+ data[i].nombre + `</span></td></tr>
                <tr><td><strong>Teléfono:</strong><span class="pull-right">`+ data[i].telefono + ` - ` + data[i].celular + ` </span></td></tr>`;
            }
        }
        $(".table-references").html(html);
    });
}
