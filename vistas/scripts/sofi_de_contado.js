// JavaScript Document
$(document).ready(init);

//primera funcion que se ejecut cuando el documento esta listo 
function init(){
    mostrarform(false);
    listar_de_contado(); //listar todos los usuarios
	listarProgramas(); //listar todos los intereses mora
	$("#formulariomatricula").off("submit").on("submit",function(e){
        e.preventDefault();
        guardaryeditar();
    });
	$(".btn_documento").on("click",function(){
        BuscarInfoEstudiante();
    });
}

//lista los programas existen en el sistema
function listarProgramas() {
	$.post("../controlador/sofi_de_contado.php?op=listarProgramas", function (data, status) {
		/*console.log(data);*/
		var datos = JSON.parse(data);
		if (datos.exito == "1") {
			$("#programa").html(datos.info);
		} else {
			alertify.error("No existe información");
		}
	});
}

function BuscarInfoEstudiante() {
	var documento = $("#documento").val();
	$.post("../controlador/sofi_de_contado.php?op=mostrarInfoEstudiante", { documento: documento }, function (data) {
		var datos = JSON.parse(data);
		console.log(datos);
		if (datos.exito == 1) {
			$("#nombre").val(datos[0][0].nombre + " " + datos[0][0].nombre_2);
			$("#apellido").val(datos[0][0].apellidos + " " + datos[0][0].apellidos_2);
			$("#telefono").val(datos[0][0].celular);
			$("#email").val(datos[0][0].email);
			$("#programa").val(datos[0][0].fo_programa);
		} else {
			alertify.error("No existe información");
		}
	});

}

function guardaryeditar(){
	var datos = new FormData($("#formulariomatricula")[0]);
    $.ajax({
		"url": "../controlador/sofi_de_contado.php?op=guardaryEditar",
	    "type": "POST",
	    "data": datos,
	    "contentType": false,
	    "processData": false,
	    success: function(datos){
            /*console.log(datos);*/
            datos = JSON.parse(datos);
            if(datos.exito == "1"){
                alertify.success("Petición realizada con exito.");
                mostrarform(false);
				tabla_de_contado.ajax.reload();
            }else{
				alertify.error(datos.info);
            }
        }
	});
}

function listar_de_contado(){
    $("#precarga").show();
    tabla_de_contado = $('#tabla_de_contado').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		"autoWidth": false,
		"dom": 'Bfrtip',
        "buttons": [{
                "extend":    'excelHtml5',
                "text":      '<i class="fa fa-file-excel" style="color: green"></i>',
                "titleAttr": 'Excel'
            },
            {
                "extend": 'print',
			 	"text": '<i class="fas fa-print" style="color: #ff9900"></i>',
				"title": 'Interés Mora',
			 	"titleAttr": 'Print'
            }],
		"ajax":{
			"url": "../controlador/sofi_de_contado.php?op=listarContado",
			"type" : "POST",
			"dataType" : "json",
			"error": function(e){
				console.log(e.responseText);	
			}
		},
        "bDestroy": true,
		"iDisplayLength": 12,	
	    "order": [[ 2 , "desc" ]]
	}).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat');
	$('.dt-button').removeClass('dt-button');
    $("#precarga").hide();
}

function mostrar(id_contado){
	limpiar();
	$.post("../controlador/sofi_de_contado.php?op=mostrar",{id_contado : id_contado}, function(data){
        //console.log(data);
		var datos = JSON.parse(data);		
		if(datos.exito == 1){
            mostrarform(true);
			$("#id_contado").val(datos[0].id_contado);
			$("#documento").val(datos[0].documento);
			$("#nombre").val(datos[0].nombre);
			$("#apellido").val(datos[0].apellido);
			$("#direccion").val(datos[0].direccion);
			$("#telefono").val(datos[0].telefono);
			$("#email").val(datos[0].email);
			$("#programa").val(datos[0].programa);
			$("#semestre").val(datos[0].semestre);
			$("#jornada").val(datos[0].jornada);
			$("#valor_total").val(datos[0].valor_total);
			$("#valor_pagado").val(datos[0].valor_pagado);
			$("#motivo_pago").val(datos[0].motivo_pago);
			$("#primer_curso").val(datos[0].primer_curso);
			$("#descuento").val(datos[0].descuento);
			$("#motivo_descuento").val(datos[0].motivo_descuento);
        }else{
            alertify.error("No existe información");
        }
 	});
}

function limpiar(){
	$("#formulariomatricula")[0].reset();
    $("#id_contado").val("");
}

function mostrarform(flag){	
	if (flag){
		limpiar();
		$("#tablaregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		limpiar();
		$("#tablaregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform(){
	limpiar();
	mostrarform(false);
}

function enviarCampus(btn, persona) {
	$(btn).attr("disabled", true);
	alertify.confirm('Enviar notificación al Campus', 'Estas seguro de enviar al campus, recuerda que solo aplica para los que son de primer curso?', function () {
		$.post("../controlador/sofi_de_contado.php?op=enviarCampus", { id_persona: persona }, function (data) {
			//console.log(data);
			$(btn).attr("disabled", false);
			var obj = JSON.parse(data);
			if (obj.exito == 1) {
				alertify.success(obj.info);
				tabla_de_contado.ajax.reload();
			} else {
				alertify.error(obj.info);
			}
		});
	}, function () {
		alertify.error('Cancelado');
		alertify.error(obj.info);
	});
}