// JavaScript Document
$(document).ready(init);

//primera funcion que se ejecut cuando el documento esta listo 
function init(){
    listar_intereses(); //listar todos los intereses mora
    mostrarform(false);
    $("#formulario_interes_mora").off("submit").on("submit",function(e){
        e.preventDefault();
        guardaryeditar();
    });
}

function guardaryeditar(){
    var datos = new FormData($("#formulario_interes_mora")[0]);
    $.ajax({
		url: "../controlador/sofi_interes_mora.php?op=guardaryEditar",
	    type: "POST",
	    data: datos,
	    contentType: false,
	    processData: false,
	    success: function(datos){
            /*console.log(datos);*/
            datos = JSON.parse(datos);
            if(datos.exito == "1"){
                alertify.success("Petición realizada con exito.");
                mostrarform(false);
                tabla_intereses.ajax.reload();
            }else{
                alertify.error("Error al momento de realizar la petición.");
            }
        }
	});
}

function listar_intereses(){
    $("#precarga").show();
    tabla_intereses = $('#tabla_intereses').dataTable({
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
			"url": "../controlador/sofi_interes_mora.php?op=listarIntereses",
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

function mostrar(id_interes){
	limpiar();
	$.post("../controlador/sofi_interes_mora.php?op=mostrarInteres",{id_interes : id_interes}, function(data, status){
        /*console.log(data);*/
		var datos = JSON.parse(data);		
		if(datos.exito == "1"){
            mostrarform(true);		
            $("#id_interes").val(datos.id_interes_mora);
            $("#mes_anio").val(datos.nombre_mes);
            $("#aplica_hasta").val(datos.fecha_mes);
            $("#porcentaje").val(datos.porcentaje);  
        }else{
            alertify.error("No existe información");
        }
 	});
}

function limpiar(){
    $("#formulario_interes_mora")[0].reset();
    $("#id_interes").val("");
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