// JavaScript Document
$(document).ready(init);
var periodo;
//primera funcion que se ejecut cuando el documento esta listo 
function init() {
    //lista los preiodos existente en el sistema 
    listar_periodos();
    //lista todos los programas
    listarProgramas();
    //lista todos los DEPARTAMENTOS
    listarDepartamentos();
    //cierra el formulario y muestra la tabla 
    mostrarform(false);
    //envia a la funcion ue registra
    $("#formularioregistros").off("submit").on("submit", function (e) {
        e.preventDefault();
        editarDatospersona();
    });
    //envia a la funcion ue registra
    $("#formulariomatricula").off("submit").on("submit", function (e) {
        e.preventDefault();
        guardarMatricula();
    });
    //envia a la funcion ue registra
    $("#formularioanulacion").off("submit").on("submit", function (e) {
        e.preventDefault();
        anularSolicitud();
    });

    //llama a la funcion para cambiar el estado a pre-aprobado
    $(".pre-aprobacion").off("click").on("click", function () {
        preAprobarSolicitud();
    });
    //trae el filtro para los estudiantes
    $(".buscar_estudiantes").off("click").on("click", function () {
        periodo = $("#periodo").val();
        var estado = $("#estado").val();
        listar_financiados(estado, periodo);
    });
    //vaciar el campo del id al momento de la anulacion para evitar errores
    $('#confirmareliminacion').on('hidden.bs.modal', function () {
        $("#id_persona_anulada").val("");
    });
    //vaciar el campo del id al momento de la preaprobar para evitar errores
    $('#confirmarpreaprobacion').on('hidden.bs.modal', function () {
        $("#id_persona_pre_aprobada").val("");
    });
    //vaciar el campo del id al momento de la preaprobar para evitar errores
    $('#verTareas').on('hidden.bs.modal', function () {
        $("#id_persona_seguimiento").val("");
        $("#id_persona_tarea").val("");
    });
    //vaciar el campo del id al momento de la facturacion para evitar errores
    $('#confirmaraprobacion').on('hidden.bs.modal', function () {
        $("#id_persona").val("");
        $(".formulariohidden").removeClass("d-none");
        $(".tablacuotas").addClass("d-none");
    });
    //vacea el campo del id al momento de cerrar el modal
    $('#modal_detalles_anulado').on('hidden.bs.modal', function () {
        $(".text_motivo").text("-------");
        $(".text_realizado_por").text("-------");
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var tab = $(e.target) // newly activated tab
        if (tab.data("name") == "añadir_segs") {
            $(".regresar_tablas").removeClass("active");
        } else if (tab.data("name") == "regresar_tablas") {
            $(".añadir_segs").removeClass("active");
        }
        $("#formularioTareas")[0].reset();
        $("#formularioSeguimientos")[0].reset();
    });
}
//Función para verificar si lafecha seleccionada es un 31
function verificar_dia(campo) {
    var dias = campo.split("-").pop();
    if (dias == "31" || dias == 31) {
        alertify.error("Indica un dia diferente al 31.");
        $(".btn_aprobar_solucitud").attr("disabled", true);
    } else {
        $(".btn_aprobar_solucitud").attr("disabled", false);
    }
}
// lista en el selectpicker el departamento y municipio de nacimiento
function listarDepartamentos() {
    //console.log(val);
    $.post("../controlador/sofi_financiados.php?op=mostrarDepartamento", function (datos) {
        //console.log(datos);
        var option = '<option value="" selected disabled>-- Selecciona departamento --</option>';
        //console.log(r);
        var r = JSON.parse(datos);
        for (let i = 0; i < r.length; i++) {
            option += '<option value="' + r[i].id_departamento + '">' + r[i].departamento + '</option>';
        }
        $(".departamento").html(option);
    });
}
//listar municipios dependiendo del departamento
function listarMunicipios(departamento) {
    $.ajax({
        url: "../controlador/sofi_financiados.php?op=mostrarMunicipios",
        "type": "POST",
        "data": { "id_departamento": departamento },
        "async": false,
        success: function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            var option = '<option value="" selected disabled>-- Selecciona Municipio --</option>';
            for (let i = 0; i < r.length; i++) {
                option += '<option value="' + r[i].municipio + '">' + r[i].municipio + '</option>';
            }
            $(".ciudad").html(option);
        }
    });
}
//cuando seleccionan la opcion de matricular(verde) tira el id para insertar 
function infoPersona(id, id_programa) {
    $("#id_persona").val(id);
    $.ajax({
        "url": "../controlador/sofi_financiados.php?op=traerInfoTicket",
        "type": "POST",
        "data": { "id_persona": id },
        "async": false,
        success: function (datos) {
            console.log(datos);
            datos = JSON.parse(datos);
            $("#valor_total").val(datos.valor_total);
            $("#valor_financiacion").val(datos.valor_financiacion);
            $("#semestre").val(datos.ticket_semestre);
            $("#consecutivo").val(datos.factura_yeminus);
        }
    });
    $.ajax({
        url: "../controlador/sofi_financiados.php?op=traerPrograma",
        "type": "POST",
        "data": { "id_programa": id_programa },
        "async": false,
        success: function (datos) {
            console.log(datos);
            datos = JSON.parse(datos);
            $("#programa").val(datos.nombre_programa);
        }
    });
}
//cuando seleccionan la opcion de anular credito(rojo) tira el id para anular 
function infoAnulacion(id) {
    $("#id_persona_anulada").val(id);
}
//cuando seleccionan la opcion de anular credito(rojo) tira el id para anular 
function infoPreAprobado(id) {
    $("#id_persona_pre_aprobada").val(id);
}
//funcion para anular la solicitud
function anularSolicitud() {
    var datos = new FormData($("#formularioanulacion")[0]);
    $.ajax({
        url: "../controlador/sofi_financiados.php?op=anularSolicitud",
        type: "POST",
        data: datos,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log(datos);
            datos = JSON.parse(datos);
            if (datos.exito == "1") {
                alertify.success("Petición realizada con exito.");
                $('#formularioanulacion')[0].reset();
                tabla_financiados.ajax.reload();
                $('#confirmareliminacion').modal("hide");
            } else {
                alertify.error("Error al momento de realizar la petición.");
            }
        }
    });
}
//funcion para Pre Aprobar la solicitud
function preAprobarSolicitud() {
    var idpersona = $("#id_persona_pre_aprobada").val();
    $.post("../controlador/sofi_financiados.php?op=preAprobarSolicitud", { id_persona: idpersona }, function (e) {
        console.log(e);
        datos = JSON.parse(e);
        if (datos.exito == "1") {
            alertify.success("Petición realizada con exito.");
            $("#id_persona_pre_aprobada").val("");
            tabla_financiados.ajax.reload();
            $('#confirmarpreaprobacion').modal("hide");
        } else {
            alertify.error("Error al momento de realizar la petición.");
        }
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
//lista los periodos existen en el sistema
function listar_periodos() {
    $.post("../controlador/sofi_financiados.php?op=listarPeriodos", function (data, status) {
        /*console.log(data);*/
        var datos = JSON.parse(data);
        if (datos.exito == "1") {
            $("#periodo").html(datos.info);
            periodo = $("#periodo").val();
            estado = $("#estado").val();
            listar_financiados(estado, periodo);
        } else {
            alertify.error("No existe información");
        }
    });
}
//lista los periodos existen en el sistema
function listarProgramas() {
    $.post("../controlador/sofi_financiados.php?op=listarProgramas", function (data, status) {
        /*console.log(data);*/
        var datos = JSON.parse(data);
        if (datos.exito == "1") {
            $("#programa").html(datos.info);
        } else {
            alertify.error("No existe información");
        }
    });
}
//Lista toodos los estudiantes, por defecto siempre es los pendientes, luego se puede filtrar
function listar_financiados(datos, periodo) {
    tabla_financiados = $('#tabla_financiados').dataTable({
        "lengthChange": false,
        "stateSave": true,
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "aProcessing": true,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "buttons": [{
            extend: 'copyHtml5',
            text: '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
            titleAttr: 'Copy'
        }, {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel" style="color: green"></i>',
            titleAttr: 'Excel'
        }, {
            extend: 'csvHtml5',
            text: '<i class="fa fa-file-alt"></i>',
            titleAttr: 'CSV'
        }, {
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf" style="color: red"></i>',
            titleAttr: 'PDF',
        }],
        "ajax": {
            "url": "../controlador/sofi_financiados.php?op=listarFinanciados&estado=" + datos + "&periodo=" + periodo,
            "type": "POST",
            "dataType": "json",
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 20,
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
    $('.dt-button').removeClass('dt-button');
}
//muestra los intereses actuales
function mostrar(id_interes) {
    $.post("../controlador/sofi_financiados.php?op=mostrarInteres", { id_interes: id_interes }, function (data, status) {
        /*console.log(data);*/
        var datos = JSON.parse(data);
        if (datos.exito == "1") {
            mostrarform(true);
            $("#id_interes").val(datos.id_interes_mora);
            $("#mes_anio").val(datos.nombre_mes);
            $("#aplica_hasta").val(datos.fecha_mes);
            $("#porcentaje").val(datos.porcentaje);
        } else {
            alertify.error("No existe información");
        }
    });
}
//muestra o esconde el formulario de registro
function mostrarform(flag) {
    if (flag) {
        $("#tablaregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#tablaregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}
//Función cancelarform
function cancelarform() {
    mostrarform(false);
}

//funcion para guardar los datos
function guardarMatricula() {
    var datos = new FormData($("#formulariomatricula")[0]);
    $.ajax({
        "url": "../controlador/sofi_financiados.php?op=guardarMatricula",
        "type": "POST",
        "data": datos,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            console.log(datos);
            datos = JSON.parse(datos);
            if (datos.exito == 1) {
                alertify.success("Petición realizada con éxito.");
                generarPlan(datos.id_persona);
                tabla_financiados.ajax.reload();
            } else {
                alertify.error(datos.info);
            }
        }
    });
}
//Genera el plan de pago
function generarPlan(id_persona) {
    $('#formulariomatricula')[0].reset();
    $(".formulariohidden").addClass("d-none");
    $(".tablacuotas").removeClass("d-none");
    $.post("../controlador/sofi_financiados.php?op=generarPlan", { id_persona: id_persona }, function (data) {
        console.log(data);
        var datos = JSON.parse(data);
        if (datos.exito == 1) {
            var texto = insertarInfoPlan(datos.info);
            tablacuotas = $('#tblprintcuotas').dataTable({
                "aProcessing": true,//Activamos el procesamiento del datatables
                "aServerSide": true,//Paginación y filtrado realizados por el servidor
                dom: '<B>',//Definimos los elementos del control de tabla
                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print" style="color: #ff9900"></i>',
                        messageTop: texto.header,
                        title: '',
                        titleAttr: 'Print',
                        customize: function (win) {
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit')
                                .css('border', '2px solid #dddddd');
                        },
                        messageBottom: texto.footer,
                    }],
                "ajax": {
                    url: '../controlador/sofi_financiados.php?op=listarCuotas&consecutivo=' + datos.info.id,
                    type: "get",
                    dataType: "json",
                    error: function (e) {
                        console.log(e.responseText);
                    }
                },
                "language": {
                    "lengthMenu": "Mostrar : _MENU_ registros",
                    "buttons": {
                        "copyTitle": "Tabla Copiada",
                        "copySuccess": {
                            _: '%d líneas copiadas',
                            1: '1 línea copiada'
                        }
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 20,//Paginación	
                "order": [[0, "asc"]]//Ordenar (columna,orden)
            }).DataTable();
            $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
            $('.dt-button').removeClass('dt-button');
        } else {
            alertify.error(datos.info);
        }
    });
}
//Envia o saca de cobro pre-juridico
function enviarPrejuridico(id_persona, estado) {
    //dependiendo del estado en estos casos, 1 es cuando no esta y se quiere incluir a cobro y 2 es lo contrario
    if (estado == 1) {
        alertify.confirm('Enviar a Cobro Pre-Juridico', '¿ Estas segur@ de enviar a cobro Pre-Juridico ?', function () {
            $.post("../controlador/sofi_financiados.php?op=enviarPrejuridico", { id_persona: id_persona, estado: 0 }, function (data) {
                /*console.log(data);*/
                var obj = JSON.parse(data);
                if (obj.exito == 1) {
                    alertify.success('Enviado Con Exito');
                    listar_financiados("Aprobado", periodo);
                } else {
                    alertify.error('Error Inexperado en la petición.');
                }
            });
        }, function () {
            alertify.error('Has cancelado el envió');
        });
    } else if (estado == 0) {
        alertify.confirm('Sacar de Cobro Pre-Juridico', '¿ Estas segur@ de sacar de cobro Pre-Juridico ?', function () {
            $.post("../controlador/sofi_financiados.php?op=enviarPrejuridico", { id_persona: id_persona, estado: 1 }, function (data) {
                var obj = JSON.parse(data);
                if (obj.exito == 1) {
                    alertify.success('Sacado Con Exito');
                    listar_financiados("Aprobado", periodo);
                } else {
                    alertify.error('Error Inexperado en la petición.');
                }
            });
        }, function () {
            alertify.error('Has cancelado la acción');
        });
    }
}
//Revisa los detalles del anulamiento
function detallesAnulamiento(id_persona) {
    $.ajax({
        url: "../controlador/sofi_financiados.php?op=detallesAnulamiento",
        type: "POST",
        data: { id_persona: id_persona },
        success: function (datos) {
            /*console.log(datos);*/
            data = JSON.parse(datos);
            if (data.motivo_cancela == '') {
                $(".text_motivo").text("Sin Información");
            } else {
                $(".text_motivo").text(data.motivo_cancela);
            }
            if (data.anulado_por == '') {
                $(".text_realizado_por").text("Sin Información");
            } else {
                $(".text_realizado_por").text(data.anulado_por);
            }
        }
    });
}

function EditarinfoPersona(val) {
    mostrarform(true);
    //muestra datos personales
    $.post("../controlador/sofi_financiados.php?op=verInfoSolicitante", { id_persona: val }, function (data) {
        data = JSON.parse(data);
        $("#id_persona_editar").val(val);
        $("#tipo_documento").val(data.tipo_documento);
        $("#numero_documento").val(data.numero_documento);
        $("#nombres").val(data.nombres);
        $("#apellidos").val(data.apellidos);
        $("#fecha_nacimiento").val(data.fecha_nacimiento);
        $("#direccion").val(data.direccion);
        listarMunicipios(66);
        $("#ciudad").val(data.ciudad);
        $("#telefono").val(data.telefono);
        $("#celular").val(data.celular);
        $("#email").val(data.email);
        $("#ocupacion").val(data.ocupacion);
        $("#persona_a_cargo").val(data.persona_a_cargo);
    });
}

//funcion para editar Datos de la solicitud
function editarDatospersona() {
    var datos = new FormData($("#formularioregistros")[0]);
    $.ajax({
        url: "../controlador/sofi_financiados.php?op=editarDatospersona",
        type: "POST",
        data: datos,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log(datos);
            datos = JSON.parse(datos);
            if (datos.exito == "1") {
                alertify.success("Petición realizada con exito.");
                tabla_financiados.ajax.reload();
                $('#formularioregistros')[0].reset();
                cancelarform();
            } else {
                alertify.error("Error al momento de realizar la petición.");
            }
        }
    });
}

function enviarCampus(btn, persona) {
    $(btn).attr("disabled", true);
    alertify.confirm('Enviar notificación al Campus', 'Estas seguro de enviar al campus, recuerda que solo aplica para los que son de primer curso?', function () {
        $.post("../controlador/sofi_financiados.php?op=enviarCampus", { id_persona: persona }, function (data) {
            console.log(data);
            $(btn).attr("disabled", false);
            var obj = JSON.parse(data);
            if (obj.exito == 1) {
                alertify.success(obj.info);
                tabla_financiados.ajax.reload();
            } else {
                alertify.error(obj.info);
            }
        });
    }, function () {
        alertify.error('Cancelado');
        alertify.error(obj.info);
    });
}
//4002 4 administracion noche 1286399 934399 matriculo 20 julio mensual 5cuotas
//Técnica Profesional en Gestión Empresarial

function cambiarEtiqueta(id_persona,valor) {
	$.post("../controlador/sofi_financiados.php?op=cambiarEtiqueta",{id_persona:id_persona, valor:valor},function(data){
		if (data == 1) {
			alertify.success("Se cambio el asesor con exito");
		} else {
			alertify.error("Error al cambiar el asesor");
		}

	});
}