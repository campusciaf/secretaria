function init(){
	cargarSelectorDependencias();
	cargarSelectorPeriodo();
	listar();
}
/* Función para cargar los options del select con los programas activos en el sistema */
function cargarSelectorDependencias(){
    /* Ajax para cargar todos los programas que existen en la base de datos */
	$.ajax({
		"type":'POST',
		"url":'../controlador/consultacontactanos.php?op=cargarDependencias',
		"success":function(msg){
			// console.log(msg);
            var datos = JSON.parse(msg);
			
         
			var predeterminada='';
			var posiciones = datos.length;
			


			let option = '<option value="0">Todos</option>';

			for (let i = 0; i < posiciones; i++) {
				option += '<option value="' + datos[i]['id_usuario'] + '">' + datos[i]['nombre'] + '</option>';
			}

			// Agregar todos los <option> de una vez
			$("#dependencias_consulta").html(option);

			// Refrescar el selectpicker
			$('#dependencias_consulta').selectpicker('refresh');



		},
		"error" :function(){
			alertify.error("Hay un error...");
		}
	});
}

/* Función para cargar los semestres según el programa seleccionado */
function cargarSelectorPeriodo(){
    $("#periodo").append("<option value='0' selected> Todos los periodos </option>");
    /* Ajax para validar en tiempo real cuántos semestres tiene el programa*/
	$.ajax({
		"type":'POST',
		"url":'../controlador/consultacontactanos.php?op=cargarPeriodo',
		"success":function(msg){
            var datos = JSON.parse(msg);
			
            var option = '';
			var posiciones = datos.length;
			for (var i = 0; i < posiciones; i++) {
				option = '<option value="'+datos[i]['periodo']+'">'+datos[i]['periodo']+'</option>';
				$("#periodo").append(option);
	            $('#periodo').selectpicker('refresh');
			}
		},
		"error" :function(){
			alertify.error("Hay un error...");
		}
	});
}
function listar(){
	var dependencias = $("#dependencias_consulta").val();
	var periodo = $("#periodo").val();
	// console.log(dependencias + '-' + periodo);
	
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f = new Date();
    var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tblrenovar').dataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "dom": 'Bfrtip',//Definimos los elementos del control de tabla
        "buttons": [{
                "extend":    'excelHtml5',
                "text":      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                "titleAttr": 'Excel'
            },{
                "extend": 'print',
                "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                "messageTop": '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				"title" : 'Docentes',
                "titleAttr": 'Print'
            }],
		"ajax":{
            "url": '../controlador/consultacontactanos.php?op=listar&dependencias='+dependencias+'&periodo='+periodo,
            "type" : "get",
            "dataType" : "json",						
            "error" : function(e){
                // console.log(e.responseText);	
            }

			
        },
		"bDestroy": true,
		"iDisplayLength": 10, // Paginación
		"columnDefs": [
			{ "width": "150px", "targets": 7 }
		],
		"order": [[ 4, "asc" ]], // Ordenar (columna, orden)
		"drawCallback": function(settings) {
			// $('[data-toggle="tooltip"]').tooltip({
				
			// 	boundary: 'window', 
			// });
			$('[data-toggle="tooltip"]').tooltip({html: true});


			$('[data-toggle="tooltip"]').on('shown.bs.tooltip', function() {
				var $tooltipInner = $('.tooltip.show .tooltip-inner');
				$tooltipInner.css('max-width', '600px'); // Ajusta esto a tus necesidades
			});
		},
		"initComplete": function(settings, json) {
			$("#precarga").hide();
			$("#finalizadas").text(json.totalFinalizado);
			$("#pendientes").text(json.totalPendientes);
			scroll(0,0);

			$('[data-toggle="tooltip"]').tooltip({
                    boundary: 'window', 
                });

                // Escucha el evento 'shown.bs.tooltip' para ajustar el ancho de los tooltips una vez mostrados
                $('[data-toggle="tooltip"]').on('shown.bs.tooltip', function() {
                    // Encuentra el último tooltip mostrado y ajusta su ancho
                    var $tooltipInner = $('.tooltip.show .tooltip-inner');
                    $tooltipInner.css('max-width', '600px'); // Ajusta esto a tus necesidades
                });
		}
	}).DataTable();

		
}

//Función Listar
function verAyudaTerminado(id_ayuda)
{
	$.post("../controlador/consultacontactanos.php?op=verAyudaTerminado",{id_ayuda:id_ayuda}, function(data, status)
	{
		
		data = JSON.parse(data);
			$("#myModalTerminado").modal("show");
			$("#historialTerminado").html("");
			$('#historialTerminado').append(data["0"]["0"]);
	});	
	
	
}


$("#datos_filtro_renovaciones").on("submit",function(e){
	e.preventDefault();
	listar();
});
init();