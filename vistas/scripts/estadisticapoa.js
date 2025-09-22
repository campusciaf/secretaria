var tabla;

//Función que se ejecuta al inicio
function init(){
	listar();
	$("#precarga").hide();
}


//Función Listar
function listar()
{

	$.post("../controlador/estadisticapoa.php?op=listar",{},function(edata, status){

		edata = JSON.parse(edata);
		var valor=JSON.parse(edata);
		var valor2=JSON.parse(edata);

		var largocadena=valor.length;
		var datos = new Array();
		var i=0;
		for(i=0;i<largocadena/2;i++){
			datos.push(valor[i]);	
		}
		var datos2 = new Array();
		var k=4;
		for(k=4;k<largocadena;k++){
			datos2.push(valor[k]);	
		}
console.log(datos);
			var chart = new CanvasJS.Chart("chartContainer", {
				exportEnabled: true,
				animationEnabled: true,
				title:{
					text: "Total Metas"
				},
				subtitles: [{
					text: "Haga clic en Leyenda para ocultar o mostrar series de datos"
				}], 
				axisX: {
					title: "Ejes"
				},
				axisY: {
					title: "Total Metas",
					titleFontColor: "#4F81BC",
					lineColor: "#4F81BC",
					labelFontColor: "#4F81BC",
					tickColor: "#4F81BC"
				},
				axisY2: {
					title: "Metas Realizadas",
					titleFontColor: "#C0504E",
					lineColor: "#C0504E",
					labelFontColor: "#C0504E",
					tickColor: "#C0504E"
				},
				toolTip: {
					shared: true
				},
				legend: {
					cursor: "pointer",
					itemclick: toggleDataSeries
				},
				data: [{
					type: "column",
					name: "Total metas",
					showInLegend: true,      
					yValueFormatString: "#,##0.# Metas",
					dataPoints: datos
					
				},
				{
					type: "column",
					name: "Realizadas",
					axisYType: "secondary",
					showInLegend: true,
					yValueFormatString: "#,##0.# Metas",
					dataPoints: datos2
					
				}
					  ]
			});
			chart.render();

				function toggleDataSeries(e) {
				if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
					e.dataSeries.visible = false;
				} else {
					e.dataSeries.visible = true;
				}
				e.chart.render();
			}
	
	});		
	
}


init();