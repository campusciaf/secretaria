var tabla_docentes, api;
$(document).ready(inicio);
function inicio() {
    $("#div_tablaResultados").hide();
    $("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	});
    //Cargamos los items de los selects
	$.post("../controlador/coevaluacion_docente.php?op=selectPeriodo", function(r){
        var data = JSON.parse(r);
        if(Object.keys(data).length > 0){
            var html = '<option value="" disabled selected>-- Selecciona un periodo --</option>';
           for(var i = 0; i < Object.keys(data).length;i++ ){
               html += '<option value="'+data[i].periodo+'">'+data[i].periodo+'</option>';
           }
        }
        $("#input_periodo").html(html);
	});
}
function listar(periodo = null){
    $("#periodo_coevaluacion").val(periodo);
    $("#div_tablaDocentes").show();
    $("#div_tablaResultados").hide();
    tabla_docentes = $('#tlb_listar').dataTable({
        "aProcessing": true,
		"aServerSide": true,
		"autoWidth": false,
		"dom": 'Bfrtip',
        "buttons": [{
            "extend":    'excelHtml5',
            "text":      '<i class="fa fa-file-excel" style="color: green"></i>',
            "titleAttr": 'Excel'
        },{
            "extend": 'print',
            "text": '<i class="fas fa-print" style="color: #ff9900"></i>',
            "title": 'Coevaluación',
            "titleAttr": 'Imprimir'
        }],
		"ajax":{
            "url": "../controlador/coevaluacion_docente.php?op=consulta",
			"type" : "POST",
			"dataType" : "json",
			"data" : {"periodo": periodo},
			"error": function(e){
                console.log(e.responseText);	
			}
		},
        "bDestroy": true,
		"iDisplayLength": 20,
        "order": [[ 1 , "desc" ]],
        "initComplete": function() {
            $("#precarga").hide();
        },
        "select": 'single',
        "drawCallback": function(){
            api = this.api();
            var $table = $(api.table().node());
            if ($table.hasClass('cards')) {
                // Create an array of labels containing all table headers
                var labels = [];
                $('thead th', $table).each(function () {
                    labels.push($(this).text());
                });
               // Add data-label attribute to each cell
                $('tbody tr', $table).each(function () {
                    $(this).find('td').each(function (column) {
                        $(this).attr('data-label', labels[column]);
                    });
                });
                var max = 0;
                $('tbody tr', $table).each(function () {
                    max = Math.max($(this).height(), max);
                }).height(max);
            }else{
                // Remove data-label attribute from each cell
                $('tbody td', $table).each(function () {
                    $(this).removeAttr('data-label');
                });
                $('tbody tr', $table).each(function () {
                    $(this).height('auto');
                });
            }
        }
	}).DataTable();
    var width = $(window).width();
    if(width <= 750){
        $(api.table().node()).toggleClass('cards');
        api.draw('page');
    }
    window.onresize = function(){
        var anchoVentana = window.innerWidth;
        if(anchoVentana > 1000){
            $(api.table().node()).removeClass('cards');
            api.draw('page');
        }else if(anchoVentana > 750 && anchoVentana < 1000){
            $(api.table().node()).removeClass('cards');
            api.draw('page');
        }else{
            $(api.table().node()).toggleClass('cards');
            api.draw('page');
        }
    }
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
	$('.dt-button').removeClass('dt-button');
}
function mostrarFormulario(id_usuario){
    limpiar();
    $("#div_tablaDocentes").hide();
    $("#div_tablaResultados").show();
    $("#id_docente").val(id_usuario);
}
function volverDocentes(){
    limpiar();
    $("#div_tablaDocentes").show();
    $("#div_tablaResultados").hide();
}
function guardaryeditar(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		"url": "../controlador/coevaluacion_docente.php?op=guardaryeditar",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function(datos){
            $("#btnGuardar").prop("disabled",false);
            var data = JSON.parse(datos);
            if(data.exito == 1){
                alertify.success(data.info);
                tabla_docentes.ajax.reload();
                volverDocentes();
            }else{
                alertify.error(data.info);
            }
        }
	});
}
function visualizar_respuestas(id_usuario) {
    var periodo_seleccionado = $('#input_periodo').val();
	$.post("../controlador/coevaluacion_docente.php?op=visualizar_respuestas", { "id_usuario": id_usuario,"periodo_seleccionado":periodo_seleccionado }, function (data) {
		data = JSON.parse(data);
		$("#myModalMostrarRespuesta").modal("show");
        var respuestas = {
            0: "Nunca",
            1: "A veces",
            2: "Casi siempre",
            3: "Siempre"
        };
        for (let i = 1; i <= 10; i++) {
            $(".r" + i).html(respuestas[data.info[0]["r" + i]]);
        }
	});
}
function limpiar(){
    $("#formulario")[0].reset();
}