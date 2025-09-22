var tabla;

//Función que se ejecuta al inicio
function init(){
	//listar();
	$("#precarga").hide();
	cargacreatividad();

	$("#resultado2").hide();
}


//Función Listar
function listar()
{
	
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
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                titleAttr: 'Excel'
            },
			{
                extend: 'print',
			 	text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Docentes',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/encuestaestudiante.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		'initComplete': function (settings, json) {
				$("#precarga").hide();
			},

	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function cargacreatividad(){
	$.post("../controlador/encuestaestudiante.php?op=cargacreatividad", function (e) {
		var r = JSON.parse(e);
		$("#publico_total").html(r.publico_estudiantil);
		$("#respuestas").html(r.respuestas);
		$("#porcentaje").html(r.porcentaje);
		$("#porcentajenumero").html(r.porcentajenumero);
	});
}

function creatividaddocente(){
	$.post("../controlador/encuestaestudiante.php?op=creatividaddocente", function (e) {
		var r = JSON.parse(e);
		$("#resultado1").html(r.respuesta);

	});
}

init();