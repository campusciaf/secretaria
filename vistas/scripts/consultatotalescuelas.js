var tabla;

//Función que se ejecuta al inicio
function init(){
	$("#precarga").hide();
	listar();
}


function configurar(){
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

	tabla=$('#tbllistadoconfig').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
				   buttons: [
				{
					extend:    'excelHtml5',
					text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					titleAttr: 'Excel'
				},
				{
					extend: 'print',
					 text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					messageTop: '<div style="width:50%;float:left"><b>Programas Activos:</b> Estado activos (Programa_ac) <b><br><b>Reporte:</b> Programas <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Programas',
					 titleAttr: 'Print'
				},
	
			],
			"ajax":
					{
						url: '../controlador/consultatotalescuelas.php?op=configurar',
						type : "get",
						dataType : "json",						
						error: function(e){
							// console.log(e.responseText);	
						}
					},
			
				"bDestroy": true,
				"iDisplayLength": 10,//Paginación
				"order": [[ 1, "asc" ]],
				'initComplete': function (settings, json) {
					$("#configurar").modal("show");

				},
	
		  });
}

function cambioestado(id_programa,estado){
	
	$.post("../controlador/consultatotalescuelas.php?op=cambioestado",{id_programa:id_programa,estado:estado},function(data, status){
		data = JSON.parse(data);// convertir el mensaje a json
		if(data["0"]["0"]==1){
			alertify.success("Cambio de estado");
			$('#tbllistadoconfig').DataTable().ajax.reload();
		}else{
			alertify.error("No se ejecuto el cambio");
		}

		

	});
}

function listar(){
	$("#precarga").show();
	$.post("../controlador/consultatotalescuelas.php?op=listar",{},function(data, status){
		data = JSON.parse(data);// convertir el mensaje a json
		$("#resultado").html("");// limpiar el div resultado
		$("#resultado").append(data["0"]["0"]);// agregar el resultao al div resultado
		$("#precarga").hide();
	});
}


init();// inicializa la funcion init