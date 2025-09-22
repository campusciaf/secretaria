
//Función que se ejecuta al inicio
function init(){

	$("#precarga").hide();
	$("#creargrupo").hide();
	$("#listadoregistros").hide();
	$('[data-toggle="tooltip"]').tooltip('dispose');
	$('[data-toggle="tooltip"]').tooltip({
		trigger: 'hover'
	});
	
	

	//Cargamos los items de los selects contrato
	$.post("../controlador/docente_reporte.php?op=selectPeriodo", function(r){
		$("#periodo").html(r);
		$('#periodo').selectpicker('refresh');
	});	
	
}

//Función Listar
function listar(periodo)
{
$("#precarga").show();	
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
                titleAttr: 'Excel',
				
            },
			{
                extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Docentes',
				titleAttr: 'Print',
				exportOptions: {

					format: {
						body: function(data){
						//Antes de mandarse al PDF cada valor pasa por aqui y es evaluado
						var valor = data.toString(); //El campo debe ser STRING para que funcione
						valor = valor.replace("<br/>","\n");  //Aqui es donde le digo al JavaScript que reemplace <br/> el salto de linea HTML por el salto de linea \n
						return valor;
						}
					}
				}
            },

        ],
		"ajax":
				{
					url: '../controlador/docente_reporte.php?op=listar&periodo='+periodo,
					type : "get",
					dataType : "json",						
					error: function(e){
					}
				},
	
			"bDestroy": true,
            "iDisplayLength":10,//Paginación
			"order": [[ 0, "desc" ]],
			'initComplete': function (settings, json) {
					$("#precarga").hide();
					$("#listadoregistros").show();
			},

		
		
	// funcion para cambiar el responsive del data table	

		'select': 'single',

		'drawCallback': function (settings) {
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

            }else {
               // Remove data-label attribute from each cell
				$('tbody td', $table).each(function () {
					$(this).removeAttr('data-label');
				});

				$('tbody tr', $table).each(function () {
					$(this).height('auto');
				});
            }
		}
	});
	
	var width = $(window).width();
	if(width <= 768){
		$(api.table().node()).toggleClass('cards');
		api.draw('page');
	}
}



function buscarDatos(){

	periodo	= $('#periodo').val();
	if(periodo != "" ){	
		$("#listadoregistros").show();
		listar(periodo);
	}else{
		$("#listadoregistros").hide();
	}
}

init();