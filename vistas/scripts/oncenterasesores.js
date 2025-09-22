function init(){
	$("#precarga").hide();
	//$("#listadoregistros").hide();
	$("#formulario").on("submit",function(e)
	{
		$("#precarga").show();
		buscarfiltrar(e);	
	});
	
	$.post("../controlador/oncenterasesores.php?op=selectAsesor", function(r){
		$("#asesor").html(r);
		$("#asesor").selectpicker('refresh');
	});
	datos();
	datosEtiquetas();

}
	
function iniciarTour(){
	introJs().setOptions({
		nextLabel: 'Siguiente',
		prevLabel: 'Anterior',
		doneLabel: 'Terminar',
		showBullets:false,
		showProgress:true,
		showStepNumbers:true,
		steps: [ 
			{
				title: 'Consultas',
				intro: "Bienvenido a nuestro modulo de consultas donde podrás visualizar todos los resultados de las diferentes campañas que se han llevado a cabo"
			},
			{
				title: 'Total clientes',
				element: document.querySelector('#t-tog'),
				intro: "Da un vistazo a la totalidad de nuestros clientes con cifras comparadas de campañas anteriores "
			},

		]
			
	},
	console.log()
	
	).start();

}

function buscarfiltrar(e){
	 
	e.preventDefault(); //No se activará la acción predeterminada del evento

	var formData = new FormData($("#formulario")[0]);

	var asesor=$("#asesor").val();
	var fecha_desde=$("#fecha_desde").val();
	var fecha_hasta=$("#fecha_hasta").val();
	$("#listadoregistros").show();
	$("#tbllistado").show();

	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor

	    dom: 'Bfrtip',
				buttons: [

					{
						extend:    'excelHtml5',
						text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
						titleAttr: 'Excel'
					},

					{
						extend: 'print',
						text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
						messageTop: '<div style="width:50%;float:left">Asesor '+asesor+'<br><b>Fecha de Impresión</b>: '+fecha+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
						title: 'Reporte Asesores',
						titleAttr: 'Print'
					},
				],
		"ajax":
				{
					url: '../controlador/oncenterasesores.php?op=listar&asesor='+asesor+'&fecha_desde='+fecha_desde+'&fecha_hasta='+fecha_hasta,
					type : "get",
					dataType : "json",						
					error: function(e){
						
						$("#precarga").hide();
					}
				},


			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			"order": [[ 2, "asc" ]],//Ordenar (columna,orden)
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},

		
		
      });

	
		
}

function datos(){
	$.post('../controlador/oncenterasesores.php?op=datos', function(datos){
		var r = JSON.parse(datos);
		$("#citas").html(r.citas);
		$("#llamada").html(r.llamada);
		$("#segui").html(r.segui);
		$("#whatsapp").html(r.whatsapp);
	});
}
	
function datosEtiquetas(){
	$.post('../controlador/oncenterasesores.php?op=datosEtiquetas', function(datos){
		var r = JSON.parse(datos);
	    $("#datosetiquetas").html(r.datos)
	});
}
	



init();