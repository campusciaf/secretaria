// JavaScript Document
$(document).ready(init);
//definimos la variable la tabla
var tabla_atrasados;
//primera funcion que se ejecut cuando el documento esta listo 
function init() {
    $("#precarga").show();
    //Muestra Datos Personales
    $.post("../controlador/sofi_atrasados.php?op=traerPeriodos", {}, function (data) {
        data = JSON.parse(data);
        html = '<option value="" disabled >- Selecciona un periodo --</option>';
        html += '<option value="todos" > Todos los periodos </option>';
        for (let index = 0; index < data.length; index++) {
            const element = data[index]["periodo"];
            selected = (index == 0) ? "selected" : "";
            html += '<option value="' + element + '" ' + selected + '>' + element + '</option>'
        }
        $("#periodo").html(html);
        //listar todos los atrasados
        listar_atrasados($("#periodo").val());
    });
    $("#agregarMensajeTodos").on("submit", function (e) {
        e.preventDefault();
        agregarMensajeTodos();
    });
}
function mostrarFormsSeguimientos() {
    $(".tabla_seguimientos, .formularios_seguimientos").toggleClass("d-none");
}
//guardar mensaje para todos
//Funcion para agregar una nueva tarea al financiado
function agregarMensajeTodos() {
    $("#btnAgregarMensajeTodos").prop("disabled", true);
    var formData = new FormData($("#agregarMensajeTodos")[0]);
    $.ajax({
        "url": "../controlador/sofi_atrasados.php?op=agregarMensajeTodos",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            //console.log(datos);
            $("#btnAgregarMensajeTodos").prop("disabled", false);
            datos = JSON.parse(datos);
            if (datos.exito == 1) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(datos.info);
                $("#agregarSeguimientoTodos").modal("hide");
            } else {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(datos.info);
            }
        }
    });
}
//listar todos los que tienen cuotas a vencer 
function listar_atrasados(periodo) {
    tabla_atrasados = $('#tabla_atrasados').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "buttons": [{
            "extend": 'excelHtml5',
            "text": '<i class="fa fa-file-excel" style="color: green"></i>',
            "titleAttr": 'Excel',
            "filename": 'Cuotas_atrasadas_' + periodo,
            "exportOptions": {
                "format": {
                    body: function (data, row, column, node) {
                        // Si la celda contiene un <select>, obten solo la opción seleccionada
                        if ($(node).find('select').length > 0) {
                            return $(node).find('select option:selected').text();
                        }
                        // Convertir `data` a cadena, si no lo es, para evitar errores
                        data = typeof data === 'string' ? data : String(data);
                        // Eliminar cualquier etiqueta HTML una expresión regular para eliminar HTML
                        return data.replace(/<\/?[^>]+(>|$)/g, ""); 
                    }
                }
            }
        }, {
            "extend": 'print',
            "text": '<i class="fas fa-print" style="color: #ff9900"></i>',
            "title": 'Interés Mora',
            "titleAttr": 'Imprimir',
            "filename": 'Cuotas_atrasadas_' + periodo
        }],
        "ajax": {
            "url": "../controlador/sofi_atrasados.php?op=listarAtrasados",
            "type": "POST",
            "data": { "periodo": periodo },
            "dataType": "json",
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]],
        "initComplete": function () {
            $("#precarga").hide();
            $('.selectpicker_asesor').selectpicker('refresh');
        }
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
    $('.dt-button').removeClass('dt-button');
}
//funcion para ver informacion del aprobado 
function verInfoSolicitante(id) {
    //muestra datos personales
    $.post("../controlador/sofi_atrasados.php?op=verInfoSolicitante", { id_persona: id }, function (data, status) {
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
    $.post("../controlador/sofi_atrasados.php?op=verRefeSolicitante", { id_persona: id }, function (data) {
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
//Muestra las cuotas del aprobado
function verCuotas(consecutivo) {
    $('#tabla_cuotas').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'rtip',
        "ajax": {
            "url": "../controlador/sofi_atrasados.php?op=verCuotas",
            "type": "POST",
            "data": { "consecutivo": consecutivo },
            "dataType": "json",
            "dataFilter": function (d) {
                $(".nombre_atrasado").html(JSON.parse(d).nombreAprobado);
                return d;
            },
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 12,
        "order": [[1, "asc"]]
    }).DataTable();
}
function cambiarEtiqueta(id_persona, valor) {
    $.post("../controlador/sofi_atrasados.php?op=cambiarEtiqueta", { id_persona: id_persona, valor: valor }, function (data) {
        if (data == 1) {
            alertify.success("Se cambio el asesor con exito");
        } else {
            alertify.error("Error al cambiar el asesor");
        }
    });
}
function cambiarAsesor(id, valor) {
    $.post("../controlador/sofi_atrasados.php?op=cambiarAsesor", { id: id, valor: valor }, function (data) {
        if (data == 1) {
            alertify.success("Se cambio el asesor con exito");
        } else {
            alertify.error("Error al cambiar el asesor");
        }
    });
}