// JavaScript Document
$(document).ready(init);
//definimos la variable la tabla
var tabla_atrasados;
//primera funcion que se ejecut cuando el documento esta listo 
function init() {
    $("#precarga").show();
    //Muestra Datos Personales
    listar_atrasados();
    metaAsesor();
    metaAsesorPagos();
}


//listar todos los que tienen cuotas a vencer 
function listar_atrasados() {
    tabla_atrasados = $('#tabla_atrasados').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "buttons": [{
            "extend": 'excelHtml5',
            "text": '<i class="fa fa-file-excel" style="color: green"></i>',
            "titleAttr": 'Excel',
            "filename": 'Cuotas_atrasadas_'
        }, {
            "extend": 'print',
            "text": '<i class="fas fa-print" style="color: #ff9900"></i>',
            "title": 'Interés Mora',
            "titleAttr": 'Imprimir',
            "filename": 'Cuotas_atrasadas_'
        }],
        "ajax": {
            "url": "../controlador/sofi_metas.php?op=listarAtrasados",
            "type": "POST",
            "data": {},
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
        }
    }).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
    $('.dt-button').removeClass('dt-button');
}
//funcion para ver informacion del aprobado 
function verInfoSolicitante(id) {
    //muestra datos personales
    $.post("../controlador/sofi_metas.php?op=verInfoSolicitante", { id_persona: id }, function (data, status) {
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
    $.post("../controlador/sofi_metas.php?op=verRefeSolicitante", { id_persona: id }, function (data) {
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
            "url": "../controlador/sofi_metas.php?op=verCuotas",
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

function cambiarEtiqueta(id_persona,valor) {
	$.post("../controlador/sofi_metas.php?op=cambiarEtiqueta",{id_persona:id_persona, valor:valor},function(data){
		if (data == 1) {
			alertify.success("Se cambio el asesor con exito");
		} else {
			alertify.error("Error al cambiar el asesor");
		}

	});
}

function metaAsesor() {
	$.post("../controlador/sofi_metas.php?op=metasAsesor",{},function(data){
        var r = JSON.parse(data);
        $("#metaasesor").html(r.meta);

	});
}


function metaAsesorPagos() {
	$.post("../controlador/sofi_metas.php?op=metasAsesorPagos",{},function(data){
        var r = JSON.parse(data);
        $("#metaasesorpagos").html(r.meta);

	});
}