var tabla, indice = 0;
//Función que se ejecuta al inicio
function init(){
	listarCategorias();
	listarPeriodos();
	$("#formularioBusqueda").on("submit", function(e) {
		e.preventDefault();
		listarEstudiantes();
	})
	$("#precarga").hide();
}
//funcion para listar las categorias
function listarCategorias() {
	$.post("../controlador/estadisticas.php?op=listarCategorias", function (data) {
		data = JSON.parse(data);
		var html = ``; 
		if(data.length > 0){
			for (let index = 0; index < data.length; index++) {
				html += `<option value="` + data[index]["id_categoria"] + `"> ` + data[index]["categoria_nombre"] +` </option>`;
			}
		}else{
			html += `<option value disabled selected > No Hay categorias </option>`;
		}
		$("#categoria").append(html);
	});
}
//funcion para listar los periodos
function listarPeriodos() {
	$.post("../controlador/estadisticas.php?op=listarPeriodos", function (data) {
		data = JSON.parse(data);
		var html = ``; 
		if(data.length > 0){
			for (let index = 0; index < data.length; index++) {
				html += `<option value="` + data[index]["periodo"] + `"> ` + data[index]["periodo"] +` </option>`;
			}
		}else{
			html += `<option value disabled selected > No Hay Periodos </option>`;
		}
		$("#periodo").append(html);
	});
}
//Funcion para listar los estudiantes que contestaron la categoria
function listarEstudiantes(){
	$("#precarga").show();
	var id_categoria = $("#categoria").val();
	var periodo = $("#periodo").val();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f = new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistado').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    'dom': 'Bfrtip',//Definimos los elementos del control de tabla
	    'buttons': [{
			"extend":    'excelHtml5',
			"text":      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
			"titleAttr": 'Excel'
		},{
			"extend": 'print',
			"text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
			"messageTop": '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
			"title": 'Ejes',
			"titleAttr": 'Print'
		}],
		"ajax":{ 
			"url": "../controlador/estadisticas	.php?op=listarEstudiantes&id_categoria="+id_categoria+"&periodo="+periodo, 
			"type" : "GET",
			"dataType" : "JSON",						
			"error": function(e){
				console.log(e.responseText);	
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"initComplete": function () {	
			$("#precarga").hide();
		},
		// funcion para cambiar el responsive del data table	
		"select": 'single',
        "drawCallback": function(){
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
            }else{
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
	if(width <= 750){
		$(api.table().node()).toggleClass('cards');
		api.draw('page');
	}
	window.onresize = function(){
		anchoVentana = window.innerWidth;
		if(anchoVentana > 1000){
			$(api.table().node()).removeClass('cards');
			api.draw('page');
		}else if(anchoVentana > 750 && anchoVentana < 1000){
			$(api.table().node()).removeClass('cards');
			api.draw('page');
		}else{
			$(api.table().node()).toggleClass('cards');
			api.draw('page');
		}
	}
}

init();