$(document).ready(init);
//primera funcion que se ejecut cuando el documento esta listo 
function init() {
	listarEstudiantesEnCobro();
}
function listarEstudiantesEnCobro() {
	let tabla_estudiantes_en_cobro;
	$("#precarga").show();
	tabla_estudiantes_en_cobro = $('#tabla_estudiantes_en_cobro').dataTable({
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
			"titleAttr": 'Print'
		}],
		"ajax": {
			"url": "../controlador/sofi_estudiantes_en_cobro.php?op=listarEstudiantesEnCobro",
			"type": "POST",
			"dataType": "json",
			"error": function (e) {
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 12,
		"order": [[2, "desc"]]
	}).DataTable();
	$('.dt-button').addClass('btn btn-default btn-flat');
	$('.dt-button').removeClass('dt-button');
	$("#precarga").hide();
}