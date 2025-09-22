var tabla, tabla_tickets, api;
function init() {
    listar();
    //Cargamos los items de los selects
    listarPeriodos();
    $("#valor_total, #valor_ticket, #porcentaje_descuento, #valor_pecuniario, #aporte_social, #valor_ingles").on("keyup", actualizarValoresTicket);
    $("#formularioticket").on("submit", function (e) {
        e.preventDefault();
        if ($("#id_ticket").val() == "") {
            // Formato de dinero.
            valor_matricula = new Intl.NumberFormat().format($("#valor_total").val());
            Swal.fire({
                "title": "Recuerda!",
                "text": "Al momento de guardar el ticket, se generará en Yeminus la factura por el valor de $ " + valor_matricula,
                "icon": "warning",
                "showCancelButton": true,
                "confirmButtonColor": "#28a745",
                "cancelButtonColor": "#dc3545",
                "confirmButtonText": "Si, Guardar!",
                "cancelButtonText": "Cancelar !",
                "reverseButtons": true
            }).then((result) => {
                if (result.isConfirmed) {
                    guardarTicket();
                }
            });
        } else {
            editarTicket();
        }
    });
    $("#formAprobarEstudio").on("submit", function (e) {
        e.preventDefault();
        AprobarEstudio();
    });
    $("#formularioDatacredito").on("submit", function (e5) {
        GenerarScore(e5);
    });
    $("#agregar_ingles").on("change", listarPrecioIngles);
    cargarProgramas();
}

function listarPrecioIngles() {
    $.post("../controlador/sofi_estudio_credito.php?op=listarPrecioIngles", function (r) {
        console.log(r);
        var data = JSON.parse(r);
        $("#valor_ingles").val(data.valor);
    });
}
function listarPeriodos() {
    $.post("../controlador/sofi_estudio_credito.php?op=selectPeriodo", function (r) {
        var data = JSON.parse(r);
        if (Object.keys(data).length > 0) {
            var html = '<option value="" disabled selected>-- Selecciona un periodo --</option>';
            for (var i = 0; i < Object.keys(data).length; i++) {
                html += '<option value="' + data[i].periodo + '">' + data[i].periodo + '</option>';
            }
        }
        $("#input_periodo").html(html);
    });
}
function actualizarValoresTicket() {
    if ($("#id_ticket").val() == "") {
        valor_pecuniario = parseInt($("#valor_pecuniario").val());
        aporte_social = parseInt($("#aporte_social").val());
        valor_descuento = parseInt($("#porcentaje_descuento").val());
        valor_ticket = parseInt($("#valor_ticket").val());
        valor_ingles = parseInt($("#valor_ingles").val());
        $("#valor_total").val(valor_pecuniario - aporte_social - valor_descuento + valor_ingles);
        valor_total = parseInt($("#valor_total").val());
        $("#valor_financiacion").val(valor_total - valor_ticket);
        valor_pecuniario = parseInt($("#valor_pecuniario").val());
        aporte_social = parseInt($("#aporte_social").val());
        valor_descuento = parseInt($("#porcentaje_descuento").val());
        valor_total = parseInt($("#valor_total").val());
        valor_ticket = parseInt($("#valor_ticket").val());
        valor_total = parseInt($("#valor_total").val());
        $("#valor_total").val(valor_pecuniario - aporte_social - valor_descuento);
        $("#valor_financiacion").val(valor_total - valor_ticket);
    }
}
/* Función para cargar la lsita de programas */
function cargarProgramas() {
    //Cargamos los items de los selects
    $.post("../controlador/sofi_estudio_credito.php?op=selectPrograma", function (r) {
        var data = JSON.parse(r);
        if (Object.keys(data).length > 0) {
            var html = '<option value="" disabled selected>-- Selecciona un Programa --</option>';
            for (var i = 0; i < Object.keys(data).length; i++) {
                html += '<option value="' + data[i].id_programa + '">' + data[i].nombre + '</option>';
            }
        }
        $("#id_programa_estudio").html(html);
        $("#id_programa_estudio").selectpicker("refresh");
    });
}
/* Función para listar los docentes que se encuentran activos */
function listar(periodo = null) {
    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    var f = new Date();
    var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "dom": 'Bfrtip',//Definimos los elementos del control de tabla
        "buttons": [{
            "extend": 'excelHtml5',
            "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
            "titleAttr": 'Excel'
        }, {
            "extend": 'print',
            "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
            "messageTop": '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
            "title": 'Docentes',
            "titleAttr": 'Print'
        }],
        "ajax": {
            "url": '../controlador/sofi_estudio_credito.php?op=listar',
            "type": "POST",
            "data": { "periodo": periodo },
            "dataType": "json",
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        "stateSave": true,
        "bDestroy": true,
        "initComplete": function () {
            $("#precarga").hide();
        }
    });
}
function detalletransaccion(id_pago) {
    $.post("../controlador/sofi_estudio_credito.php?op=detalletransaccion", { id_pago: id_pago }, function (data, status) {
        data = JSON.parse(data);
        $("#modaldetalle").modal("show");
        $("#resultado").html("");
        $("#resultado").append(data);
    });
}
function detalleTransaccionTicket(id_pagos) {
    $.post("../controlador/sofi_estudio_credito.php?op=detalleTransaccionTicket", { "id_pagos": id_pagos }, function (data, status) {
        console.log(data);
        data = JSON.parse(data);
        $("#modaldetalle").modal("show");
        $("#resultado").html("");
        $("#resultado").append(data);
    });
}
function generarTicket(id_programa, id_persona, periodo, id_estudiante, agregar_ingles) {
    $.post("../controlador/sofi_estudio_credito.php?op=precioPrograma", { "id_programa": id_programa, "periodo": periodo, "id_estudiante": id_estudiante, "id_persona": id_persona, "agregar_ingles": agregar_ingles }, function (data) {
        data = JSON.parse(data);
        $("#formularioticket")[0].reset();
        $(".aporte_y_pecuniario").show();
        $("#id_ticket").val("");
        $("#modalTicket").modal("show");
        $("#valor_total").val(data.valor_credito);
        $("#ticket_semestre").val(data.semestrematricular);
        $("#valor_pecuniario").val(data.valor_pecuniario);
        $("#aporte_social").val(data.valor_aporte);
        $("#agregar_ingles").val(agregar_ingles);
        $("#id_estudiante_credito").val(id_estudiante);
        $("#id_persona_credito").val(id_persona);
        (agregar_ingles == 1)?listarPrecioIngles():"";
    });
}
function AprEstudio(id_persona, numero_documento, periodo_pecuniario) {
    $("#modalAprobarEstudio").modal("show");
    $("#id_persona_estudio").val(id_persona);
    $.post("../controlador/sofi_estudio_credito.php?op=traerProgramasEstudiante", { "numero_documento": numero_documento, "periodo_pecuniario": periodo_pecuniario }, function (data) {
        data = JSON.parse(data);
        if (Object.keys(data).length > 0) {
            var html = '<option value="" disabled selected>-- Selecciona un Programa --</option>';
            for (var i = 0; i < Object.keys(data).length; i++) {
                html += '<option value="' + data[i].id_programa + '">' + data[i].nombre + '</option>';
            }
        }
        $("#periodo_pecuniario_estudio").val(periodo_pecuniario);
        $("#numero_documento_estudio").val(numero_documento);
        $("#id_programa_estudio").html(html);
        $("#id_programa_estudio").selectpicker("refresh");
    });
}
//Funcion para agregar un nuevo seguimiento al financiado
function guardarTicket() {
    $("#precarga").show();
    $("#btnNovedad").prop("disabled", true);
    var formData = new FormData($("#formularioticket")[0]);
    $.ajax({
        "url": "../controlador/sofi_estudio_credito.php?op=guardarTicket",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            console.log(datos);
            $("#precarga").hide();
            datos = JSON.parse(datos);
            $("#btnNovedad").prop("disabled", false);
            if (datos.exito == 1) {
                $("#modalTicket").modal("hide");
                Swal.fire({
                    "icon": "success",
                    "title": "Procesos",
                    "html": datos.info,
                    "showConfirmButton": true,
                    "allowOutsideClick": false
                });
                $("#formularioticket")[0].reset();
                listar($("#input_periodo").val());
            } else {
                Swal.fire({
                    "icon": "error",
                    "title": "Procesos",
                    "html": datos.info,
                    "showConfirmButton": true,
                    "allowOutsideClick": false
                });
            }
        }
    });
}
//Funcion para agregar un nuevo seguimiento al financiado
function AprobarEstudio() {
    $("#btnEstudio").prop("disabled", true);
    var formData = new FormData($("#formAprobarEstudio")[0]);
    $.ajax({
        "url": "../controlador/sofi_estudio_credito.php?op=AprobarEstudio",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            datos = JSON.parse(datos);
            $("#btnEstudio").prop("disabled", false);
            if (datos.exito == 1) {
                $("#modalAprobarEstudio").modal("hide");
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(datos.info);
                $("#formAprobarEstudio")[0].reset();
                listar($("#input_periodo").val());
            } else {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(datos.info);
            }
        }
    });
}
//traer todos los tickets
function aprobarTicket(id_persona, factura_yeminus) {
    $("#modalAprobarTicket").modal("show");
    tabla_tickets = $('#box_tickets').DataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "dom": '',//Definimos los elementos del control de tabla
        "ajax": {
            "url": '../controlador/sofi_estudio_credito.php?op=listarTickets',
            "type": "POST",
            "data": { "id_persona": id_persona, "factura_yeminus": factura_yeminus },
            "dataType": "json",
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        "stateSave": true,
        "bDestroy": true,
    });
}
//Funcion para agregar un nuevo seguimiento al financiado
async function guardarTicketAprobado(id_ticket, id_persona, id_estudiante, valor_ticket, factura_yeminus) {
    const { value: opciones } = await Swal.fire({
        "text": "Al momento de aprobar el ticket, se generará en Yeminus un recibo de caja por el valor de $ " + valor_ticket,
        "input": "select",
        "icon": "warning",
        "inputOptions": {
            11100611: "Efectivo (11100611)",
            11100506: "Pse y Tarjeta (11100506)",
        },
        "inputPlaceholder": "Selecciona Cuenta Contable",
        "showCancelButton": true,
        "confirmButtonColor": "#28a745",
        "cancelButtonColor": "#dc3545",
        "confirmButtonText": "Si, Guardar!",
        "cancelButtonText": "Cancelar !",
        "reverseButtons": true,
        inputValidator: (cuenta_contable) => {
            return new Promise((resolve) => {
                if (cuenta_contable === "") {
                    resolve("Debes seleccionar una cuenta");
                } else {
                    $.post("../controlador/sofi_estudio_credito.php?op=guardarTicketAprobado", { "id_ticket": id_ticket, "id_persona": id_persona, "id_estudiante": id_estudiante, "valor_ticket": valor_ticket, "factura_yeminus": factura_yeminus, "cuenta_contable": cuenta_contable }, function (data) {
                        console.log(data);
                        data = JSON.parse(data);
                        if (data.exito == 1) {
                            Swal.fire({
                                "icon": "success",
                                "title": "Procesos",
                                "html": data.info,
                                "showConfirmButton": true,
                                "allowOutsideClick": false
                            });
                            listar($("#input_periodo").val());
                            $("#modalAprobarTicket").modal("hide");
                        } else {
                            Swal.fire({
                                "icon": "error",
                                "title": "Procesos",
                                "html": data.info,
                                "showConfirmButton": true,
                                "allowOutsideClick": false
                            });
                        }
                    });
                }
            });
        }
    });
}
//Funcion para agregar un nuevo seguimiento al financiado
function eliminarTicket(id_ticket) {
    Swal.fire({
        "title": "Eliminar Ticket",
        "text": "¿ Estas segur@ de eliminar el ticket ?",
        "icon": "warning",
        "showCancelButton": true,
        "confirmButtonColor": "#28a745",
        "cancelButtonColor": "#dc3545",
        "confirmButtonText": "Eliminar",
        "cancelButtonText": "Cancelar",
        "reverseButtons": true,
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../controlador/sofi_estudio_credito.php?op=eliminarTicket", { "id_ticket": id_ticket }, function (data) {
                data = JSON.parse(data);
                if (data.exito == 1) {
                    Swal.fire({
                        "icon": "success",
                        "title": "Ticket eliminado correctamente",
                        "showConfirmButton": false,
                        "timer": 1500
                    });
                    listar($("#input_periodo").val());
                    $("#modalAprobarTicket").modal("hide");
                } else {
                    Swal.fire({
                        "icon": "error",
                        "title": "Error al eliminar el ticket",
                        "timer": 1500
                    });
                }
            });
        }
    });
}
//Funcion para agregar un nuevo seguimiento al financiado
function mostrarTicket(id_ticket) {
    $("#formularioticket")[0].reset();
    $("#modalTicket").modal("show");
    $.post("../controlador/sofi_estudio_credito.php?op=mostrarTicket", { "id_ticket": id_ticket }, function (data) {
        console.log(data);
        data = JSON.parse(data);
        $("#id_ticket").val(data.id_ticket);
        $("#id_estudiante_credito").val(data.id_estudiante);
        $("#id_persona_credito").val(data.id_persona);
        $("#porcentaje_descuento").val(data.valor_descuento);
        $("#valor_total").val(data.valor_total);
        $("#valor_ticket").val(data.valor_ticket);
        $("#valor_financiacion").val(data.valor_financiacion);
        $("#fecha_limite").val(data.fecha_limite);
        $('input:radio[name=tipo_pago][value=' + data.tipo_pago + ']').attr('checked', 'checked');
        $('input:radio[name=tiempo_pago][value=' + data.tiempo_pago + ']').attr('checked', 'checked');
        $(".aporte_y_pecuniario").hide();
    });
}
//Funcion para editar ticket
function editarTicket() {
    $("#precarga").show();
    $("#btnNovedad").prop("disabled", true);
    var formData = new FormData($("#formularioticket")[0]);
    $.ajax({
        "url": "../controlador/sofi_estudio_credito.php?op=editarTicket",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            console.log(datos);
            $("#precarga").hide();
            datos = JSON.parse(datos);
            $("#btnNovedad").prop("disabled", false);
            if (datos.exito == 1) {
                $("#modalTicket").modal("hide");
                Swal.fire({
                    "icon": "success",
                    "title": datos.info,
                    "showConfirmButton": true,
                });
                $("#formularioticket")[0].reset();
                tabla_tickets.ajax.reload();
            } else {
                Swal.fire({
                    "icon": "error",
                    "title": datos.info,
                    "showConfirmButton": false,
                    "timer": 1500
                });
            }
        }
    });
}
// Imprime los datos al formulario de Datacredito para enviarlos a revision
function mostrarDatosModal(id_persona_score, datacredito_documento, primer_apellido_datacredito) {
    $("#id_persona_score").val(id_persona_score);
    $("#datacredito_documento").val(datacredito_documento);
    $("#primer_apellido_datacredito").val(primer_apellido_datacredito);
    $("#modal_datacredito").modal("show");
}
// Obtiene los datos del Form de Datacredito y los envia por el API
function GenerarScore(e5) {
    $("#btnDatacredito").attr("disabled", true);
    $(".precarga").show();
    e5.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#formularioDatacredito")[0]);
    $.ajax({
        "url": "../controlador/sofi_estudio_credito.php?op=formularioDatacredito",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            $("#btnDatacredito").attr("disabled", false);
            $(".precarga").hide();
            try {
                datos = JSON.parse(datos);
                if (datos.exito == 1) {
                    Swal.fire({ position: 'top-end', icon: 'success', title: datos.info });
                    $(".score_id_" + datos.id_persona_score).html(datos.scoreValue);
                    $("#modal_datacredito").modal("hide");
                } else {
                    Swal.fire({ position: 'top-end', icon: 'error', title: datos.info });
                }
            } catch (error) {
                Swal.fire({ position: 'top-end', icon: 'error', title: "Error al analizar los datos." });
            }
        }
    });
}
init();
