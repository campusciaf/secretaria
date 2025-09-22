var tabla;
//Función que se ejecuta al inicio
function init() {
	periodo = $("#periodo").val();
	listar_estudiantes(periodo);
}

function listar_estudiantes(periodo) {
	$(".precarga").show();
	tabla = $('#listado_estudiantes').DataTable({
		"language": {
			"processing": "<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span>"
		},
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		"dom": 'Bfrtip',
		"buttons": [{
			"extend": 'excelHtml5',
			"text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
			"titleAttr": 'Excel'
		}, {
			"extend": 'print',
			"text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
			"titleAttr": 'Print'
		},
		],
		"ajax": {
			"url": '../controlador/sofi_reporte_general.php?op=listar_estudiantes',
			"type": "POST",
			"data": { "periodo": periodo },
			"dataType": "json",
			error: function (e) {
				console.log(e.responseText)
				$(".precarga").hide();
			}
		},
		"initComplete": function () {
			$(".precarga").hide();
		},
		"bDestroy": true,
		"scrollX": false,
		"iDisplayLength": 10,//Paginación
		"order": [[2, "asc"]],//Ordenar (columna,orden)
	});
	$("#modalListarEstudiantes").modal("show");
}
init();// inicializa la funcion init