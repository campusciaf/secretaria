var tabla;


function init() {
    var fechaActual = new Date();
    var mesActual = fechaActual.getMonth();
    var nombresMeses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
    var nombreMesActual = nombresMeses[mesActual];
	// console.log(nombreMesActual);
    var botonActual = $("label[for='" + nombreMesActual + "']");
    cambiarEstilo(botonActual, nombreMesActual);
    $('#' + nombreMesActual).prop('checked', true);
    mostrarcheckbox(); // Carga los datos del mes actual
	
}

//Funcion para mostrar el checbox seleccionado de la 
function mostrarcheckbox(){
	$("#precarga").hide();
	var formData = new FormData($("#check_list")[0]);
	$.ajax({
		"url": "../controlador/sac_calendario_general.php?op=checkbox",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(e){
			e = JSON.parse(e);
			$(".info-mes").html(e[0]);
			$('#ver_sac_calendario').dataTable( {
					
					dom: 'Bfrtip',
					
					buttons: [
						{
							extend:    'excelHtml5',
							text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
							titleAttr: 'Excel'
						},
						
					],
			
			});
			
		}
	});
}

function cambiarEstilo(button, mes) {
    var checkbox = $("#" + mes);
    if (checkbox.is(':checked')) {
        $(button).removeClass("button-active");
    } else {
        $(button).addClass("button-active");
    }
	
}
function iniciarTour() {
	introJs().setOptions({
		"nextLabel": 'Siguiente',
		"prevLabel": 'Anterior',
		"doneLabel": 'Terminar',
		"showBullets": false,
		"showProgress": true,
		"showStepNumbers": true,
		"steps": [
			{
				"title": 'Filtro por mes',
				"element": document.querySelector('#tour_mostrar_meses'),
				"intro": 'Dependiendo del mes que seleccione se puede ver informacion detallada del proyecto, meta, acción y cargo.'
			},
			{
				"title": 'Proyecto',
				"element": document.querySelector('#tour_proyecto'),
				"intro": 'Muestra el nombre del proyecto donde se encuentra la meta.'
			},
			{
				"title": 'Meta',
				"element": document.querySelector('#tour_meta'),
				"intro": 'Muestra el nombre de la meta.'
			},
			{
				"title": 'Acción',
				"element": document.querySelector('#tour_accion'),
				"intro": 'Muestra el nombre de la acción'
			},
			{
				"title": 'Cargo',
				"element": document.querySelector('#tour_cargo'),
				"intro": 'Muestra el nombre del cargo.'
			},
			{
				"title": 'Foto',
				"element": document.querySelector('#tour_foto'),
				"intro": 'Muestra la foto del funcionario.'
			},
			{
				"title": 'Estado',
				"element": document.querySelector('#tour_estado'),
				"intro": 'Muestra el estado de la acción de la meta.'
			},
			{
				"title": 'Mes',
				"element": document.querySelector('#tour_mes'),
				"intro": 'Muestra el mes en el que se esta filtrando.'
			},
		]
	},
	).start();
}


init();
