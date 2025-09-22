var tabla, global_id_docente,id_global;
$(document).ready(incio);
function incio() {
    listar();
}
function listar() {
    $('#precarga').show();
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f = new Date();
    var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    $('#tbl_docente').dataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "responsive": false,
        "dom": 'Bfrtip',//Definimos los elementos del control de tabla
        "buttons":[{
            "extend": 'excelHtml5',
            "text": '<i class="fas fa-file-excel"></i>',
            "titleAttr" : 'Reporte Excel',
            "title" : 'Historial Docente'
        }
    
        ,{
            "extend": 'print',
            "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
            "messageTop": '<div style="width:50%;float:left"><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
            "title": 'Historial Docente',
            "titleAttr": 'Print'
        }
    ],
        "columnDefs": [{ "className": "dt-center", "targets": "_all" }],
		"order": [[ 1, "asc" ]],//Ordenar (columna,orden)
        "ajax":{
            "url" : '../controlador/historialdocente.php?op=listar',
            "type" : "get",
            "dataType" : "json",
            "error": function (e) {
                // console.log(e.responseText);
            }
        },
        "initComplete": function() {
            $('#precarga').hide();
        },
        "bDestroy": true,
        "iDisplayLength": 10,//Paginación
        "order": [[ 4, "asc" ]],//Ordenar (columna,orden)
    }).DataTable();
}
function ver_historial_del_docente(id) {
    $("#modal_historial").modal("show");
    historial(id);
}

function historial(id){
    id_global =id;
	$("#precarga").show();
    mostrar_cantidad(id);
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbl_historial').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		buttons: [
			{
				extend:    'copyHtml5',
				text:      '<i class="fa fa-copy"></i>',
				titleAttr: 'Copy'
			},
			{
				extend:    'excelHtml5',
				text:      '<i class="fa fa-file-excel"></i>',
				titleAttr: 'Excel'
			},
			{
                "extend": 'print',
                "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                "messageTop": '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				"title": 'Docentes',
                "titleAttr": 'Print'
            },
		],
		"ajax":{ url: '../controlador/historialdocente.php?op=listarHistorial&id='+id, type : "get", dataType : "json",						
			error: function(e){
				// console.log(e.responseText);	
			}
		},
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación
        "order": [[ 4, "asc" ]],//Ordenar (columna,orden)
		'initComplete': function (settings, json) {
			
			$("#precarga").hide();
		},
		
	});
	
}


function ingresos_campus_docentes(id) {

	global_id_docente = id;

    $.post(
        "../controlador/historialdocente.php?op=ingresos_campus_x_fecha",
        { id: id }, function (datos) {
            var r = JSON.parse(datos);
            // console.log(r);
        $("#myModaltraerpagos").modal("show");
        $("#modal_ingresos_docentes").html(r);

        $('#mostrarpagos').dataTable({

            dom: 'Bfrtip',

            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },

            ],

        });

        $("#modal_ingresos_docentes").show();     
        }
    );
}

function generarGrafica(){
    $.post( "../controlador/historialdocente.php?op=graficodocentes", { "global_id_docente": global_id_docente, "mes": $("#mes").val(), "anio": $("#anio").val() }, function (r) {
        r = JSON.parse(r);

        var datos = new Array();
        datos.push(r.datosuno);
        datos=JSON.parse(datos);
        
        var chart = new CanvasJS.Chart("chartContainer2", {
            "animationEnabled": true,
            "exportEnabled": true,
            "title": { "text": "Ingresos diarios al campus", "horizontalAlign": "left", "fontColor": "#fff", "fontSize": 16, "padding": 10, "margin": 20, "backgroundColor": "#015486", "borderThickness": 1, "cornerRadius": 5, "fontWeight": "bold"},
            "theme": "light2",
            "axisY": {
                "labelFontSize": 10,
                "includeZero": false,
            },
            axisX: {
                "labelFontSize": 12,
                "labelAngle": -30,
            },
            data: [{
                "indexLabelFontSize": 10,
                "type": "line",
                "dataPoints": datos,
            }],
        });
        chart.render();
    });
}


function historico_docentes_contrato(id_usuario) {


    $.post(
        "../controlador/historialdocente.php?op=historico_docentes_contrato",
        { id_usuario: id_usuario }, function (datos) {
            var r = JSON.parse(datos);
            // console.log(r);
        $("#myModalhistoricodocentescontrato").modal("show");
        $("#historicodocentescontrato").html(r);

        $('#historico_contrato_docentes').dataTable({

            dom: 'Bfrtip',

            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },

            ],

        });

        $("#historicodocentescontrato").show();     
        }
    );
}





function mostrar_cantidad(){

	$.post("../controlador/historialdocente.php?op=mostrar_total_horas",{ "id_global": id_global},function(data){
	
		data = JSON.parse(data);
		$("#mostar_video_modal").show();
		$("#mostar_video_modal").html(data);

		
		
	});
}
