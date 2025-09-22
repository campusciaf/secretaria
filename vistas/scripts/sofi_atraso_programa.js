// JavaScript Document
$(document).ready(init);
//definimos la variable la tabla
var tabla_atrasados;
//primera funcion que se ejecut cuando el documento esta listo 
function init() {
    $("#precarga").hide();
    cargarPrograma();
    $("#formularioTareassofi").on("submit", function (e2) {
        guardarTareaSofi(e2);
    });

    $("#formularioSeguimientos").on("submit", function (e1) {
        guardarSeguimientos(e1);
    });

    //listar_atrasados(); //listar todos los atrasados
}
//Cargamos los items de los selects
function cargarPrograma() {
    $.post("../controlador/sofi_atraso_programa.php?op=selectPrograma", function (r) {
        //console.log(r);
        $("#programa").html(r);
        $('#programa').selectpicker('refresh');
    });
}
//listar todos los que tienen cuotas a vencer 
function listar_atrasados(programa) {
    $("#precarga").show();
    tabla_atrasados = $('#tabla_atrasados').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "buttons": [{
            "extend": 'excelHtml5',
            "text": '<i class="fa fa-file-excel" style="color: green"></i>',
            "titleAttr": 'Excel'
        }, {
            "extend": 'print',
            "text": '<i class="fas fa-print" style="color: #ff9900"></i>',
            "title": 'Interés Mora',
            "titleAttr": 'Imprimir'
        }],
        "ajax": {
            "url": "../controlador/sofi_atraso_programa.php?op=listarAtrasados",
            "type": "POST",
            "data": { "programa": programa },
            "dataType": "json",
            "error": function (e) {
                // console.log(e.responseText);	
            }
        },
        "bDestroy": true,
        "iDisplayLength": 12,
        "initComplete": function () {
            $("#precarga").hide();
        }
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
    $('.dt-button').removeClass('dt-button');
}
//funcion para ver informacion del aprobado 
function verInfoSolicitante(id) {
    //muestra datos personales
    $.post("../controlador/sofi_atraso_programa.php?op=verInfoSolicitante", { id_persona: id }, function (data, status) {
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
    $.post("../controlador/sofi_atraso_programa.php?op=verRefeSolicitante", { id_persona: id }, function (data) {
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
function consutaTareaSeguimiento(id_persona, id_credencial) {
    $("#id_persona_seguimiento_sofi").val(id_persona);
    $("#id_credencial_seguimiento").val(id_credencial);
    verSeguimientos(id_credencial);
    $("#id_persona_tarea").val(id_persona);
    verTareas(id_persona);
}
//Funcion para ver la tareas agendadas 
function verTareas(id_persona) {
    tabla_tareas = $('#tabla_tareas').dataTable({
        "lengthChange": false,
        "stateSave": true,
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "aProcessing": true,
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
            "url": "../controlador/sofi_atraso_programa.php?op=verTareas",
            "type": "POST",
            "data": { "id_persona": id_persona },
            "dataType": "json",
            "error": function (e) {
                // console.log(e.responseText);	
            }
        },
        "bDestroy": true,
        "iDisplayLength": 12,
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
    $('.dt-button').removeClass('dt-button');
}
//Funcion para ver los seguimientos agendadas 
function verSeguimientos(id_credencial) {
    tabla_seguimiento = $('#tabla_seguimiento').dataTable({
        "lengthChange": false,
        "stateSave": true,
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "aProcessing": true,
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
            "url": "../controlador/sofi_atraso_programa.php?op=verSeguimientos",
            "type": "POST",
            "data": { "id_credencial": id_credencial },
            "dataType": "json",
            "error": function (e) {
                // console.log(e.responseText);	
            }
        },
        "bDestroy": true,
        "iDisplayLength": 12,
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
    $('.dt-button').removeClass('dt-button');
}
function guardarTareaSofi(e2) {
    e2.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardarTarea").prop("disabled", true);
    var formData = new FormData($("#formularioTareassofi")[0]);

    $.ajax({
        url: "../controlador/sofi_atraso_programa.php?op=guardarTareaSofi",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            // console.log(datos); 
            if (typeof datos === 'string') {
                datos = JSON.parse(datos);
            }
            if (datos.exito == 1) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(datos.info);
                // $("#tab_seg_1").removeClass("active");
                // $("#tab_seg_2").addClass("active");
                verTareas(datos.id_persona);
                $("#tabla_tareas").DataTable().ajax.reload();

            } else {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(datos.info);
            }
        }


    });

}
function guardarSeguimientos(e1) {
    e1.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardarTarea").prop("disabled", true);
    var formData = new FormData($("#formularioSeguimientos")[0]);
    $.ajax({
        url: "../controlador/sofi_atraso_programa.php?op=guardarSeguimientos",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            // console.log(datos); 
            if (typeof datos === 'string') {
                datos = JSON.parse(datos);
            }
            if (datos.exito == 1) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(datos.info);
                // $("#tab_seg_1").removeClass("active");
                // $("#tab_seg_2").addClass("active");
                verSeguimientos(datos.id_credencial);
                $("#tabla_seguimiento").DataTable().ajax.reload();
            } else {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(datos.info);
            }
        }
    });

}
//Muestra las cuotas del aprobado
function verCuotas(consecutivo) {
    $('#tabla_cuotas').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'rtip',
        "ajax": {
            "url": "../controlador/sofi_atraso_programa.php?op=verCuotas",
            "type": "POST",
            "data": { "consecutivo": consecutivo },
            "dataType": "json",
            "dataFilter": function (d) {
                $(".nombre_atrasado").html(JSON.parse(d).nombreAprobado);
                return d;
            },
            "error": function (e) {
                // console.log(e.responseText);	
            }
        },
        "bDestroy": true,
        "iDisplayLength": 12,
        "order": [[1, "asc"]]
    }).DataTable();
}