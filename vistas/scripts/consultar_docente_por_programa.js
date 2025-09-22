
function init(){
	listarprogramaconsultados(0);
	$("#precarga").hide();
}
//Función Listar Metas
function listarprogramaconsultados(ciclo_escuela){
	$("#precarga").show();
	
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistadoconsultaporprograma').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		dom: 'Bfrtip',
		buttons: [
			{
				extend:    'copyHtml5',
				text:      '<i class="fa fa-copy fa-2x" style="color: blue"></i>',
				titleAttr: 'Copy'
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			
		],
		
		"ajax":{ 
			url: '../controlador/consultar_docente_por_programa.php?op=listarprogramaconsultados&ciclo_escuela='+ciclo_escuela, 
			type : "get", 
			dataType : "json",						
			error: function(e){
				console.log(e);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 20,
		"order": [[2, "asc" ]],
		'initComplete': function (settings, json) {
			$("#precarga").hide();
		},
		
	});
	
}

init();