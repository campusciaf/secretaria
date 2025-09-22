var tabla;
//Función que se ejecuta al inicio
function init(){
	$("#precarga").hide();

	
	$("#titulo").hide();
	
	//Cargamos los items de los selects contrato
	$.post("../controlador/caracterizacionprograma.php?op=selectPrograma", function(r){
		$("#id_programa_ac").html(r);
		$('#id_programa_ac').selectpicker('refresh');
    });
    //Cargamos los items de los selects contrato
	$.post("../controlador/caracterizacionprograma.php?op=selectCategoria", function(r){
		$("#id_categoria").html(r);
		$('#id_categoria').selectpicker('refresh');
    });
	//Cargamos los items de los periodos
	$.post("../controlador/caracterizacionprograma.php?op=selectPeriodo", function(r){
        $("#periodo").html(r);
        $('#periodo').selectpicker('refresh');
	});

	$("#buscar").on("submit",function(e){
		buscar(e);	
		
	});

	$("#formularioAgregarGrupo").on("submit",function(e){
		guardaryeditar(e);	
	});



}

function comprobar()
{
	var id_programa_ac=$("#id_programa_ac").val();
	var id_categoria=$("#id_categoria").val();
	var periodo=$("#periodo").val();

	if(id_programa_ac!="" && id_categoria!="" && periodo!=""){
		listar(id_programa_ac,id_categoria,periodo);
	}

}

function tablas(){

	
	$.post("../controlador/caracterizacionprograma.php?op=datostabla",{}, function(data, status){
		data = JSON.parse(data);
		var usuario=data.usuario;
		
		var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
		var f=new Date();
		var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
			
		tabla=$('#tbllistado').dataTable(
			{
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
						messageTop: '<div style="width:50%;float:left"><b>Usuario:</b>'+usuario+' <b><br><b>Reporte:</b> Permanencia <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
						title: 'Empresas Amigas',
						 titleAttr: 'Print'
					},
		
				],
		
					"bDestroy": true,
					"iDisplayLength": 10,//Paginación
					'initComplete': function (settings, json) {
						$("#precarga").hide();
					},
		
				
			  });
			
			
			
				
	});
			
}

function listar(id_programa_ac,id_categoria,periodo){
	
	$("#precarga").show();
	
	$.post("../controlador/caracterizacionprograma.php?op=listar",{id_programa_ac:id_programa_ac, id_categoria:id_categoria, periodo:periodo}, function(data, status)
	{
		data = JSON.parse(data);
		
		$("#tbllistado").html("");
		$("#tbllistado").append(data["0"]["0"]);
		$("#precarga").hide();
		tablas();
 	});
}




init();

