var tabla;

function init(){

	listardocetes();

	$("#formulariodocente").on("submit",function(e){
		guardaryeditardocente(e);	
	});
	
}

function listardocetes(id_usuario){
	$("#precarga").show();
	
	$("#id_usuario").val(id_usuario);

	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistadocentes').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
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
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Print'
			},
		],
		
		"ajax":{ url: '../controlador/cajaherramientasboton.php?op=listardocente&id_usuario='+id_usuario, type : "get", dataType : "json",						
		error: function(e){
			// console.log(e.responseText);	
		}
	},
	"bDestroy": true,
	"iDisplayLength": 20,//Paginación
	"order": [[ 0, "asc" ]],//Ordenar (columna,orden)
	'initComplete': function (settings, json) {
			
			$("#precarga").hide();
			
		},
		
		
	});

	
	
}

	function mostrar_docente(id_usuario){
	$.post("../controlador/cajaherramientasboton.php?op=mostrar_docentes",{"id_usuario" : id_usuario},function(data){
		// console.log(data);
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){

			$("#id_usuario").val(data.id_usuario);
			$("#permiso_software").val(data.permiso_software);
			$("#ModalDocente").modal("show");
			
		}
	});
}

//Función guardo y edito docente 
function guardaryeditardocente(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarDocente").prop("disabled",true);
	var formData = new FormData($("#formulariodocente")[0]);
	$.ajax({
		"url": "../controlador/cajaherramientasboton.php?op=guardaryeditardocente",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			$("#btnGuardarDocente").prop("disabled",false);
			$("#ModalDocente").modal("hide");
			window.location.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);
			
		}
	});
}

init();