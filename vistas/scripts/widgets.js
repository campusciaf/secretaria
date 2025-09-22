//Función que se ejecuta al inicio
function init() {
	ingresos();
    ingresos2();
    ingresos3();
    $("#precarga").hide();

}

function ingresos(){
    $(".canvasjs-chart-credit").hide();
    
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        backgroundColor: null,
    
        axisX: {
            gridThickness: 0,
            tickLength: 0,
            lineThickness: 0,
            labelFormatter: function(){
              return " ";
            }
        },
        axisY: {
            gridThickness: 0,
            tickLength: 0,
            lineThickness: 0,
            labelFormatter: function(){
              return " ";
            }
        },
        data: [{
            name: "Received",
            showInLegend: false,
            legendMarkerType: "square",
            type: "area",
            color: "rgba(0,204,204,0.6)",
            markerSize: 0,
            dataPoints: [
                { x: new Date(2023, 1, 6), y: 30 },
                { x: new Date(2023, 1, 7), y: 24 },
                { x: new Date(2023, 1, 8), y: 40 },
                { x: new Date(2023, 1, 9), y: 10 },
                { x: new Date(2023, 1, 10), y: 50 },
                { x: new Date(2023, 1, 11), y: 5 },
    
            ]
        },
        


            ]
    });
    chart.render();
    
}

function ingresos2(){
    $(".canvasjs-chart-credit").hide();
    
    var chart = new CanvasJS.Chart("chartContainer2", {
        animationEnabled: true,
        backgroundColor: null,
    
        axisX: {
            gridThickness: 0,
            tickLength: 0,
            lineThickness: 0,
            labelFormatter: function(){
              return " ";
            }
        },
        axisY: {
            gridThickness: 0,
            tickLength: 0,
            lineThickness: 0,
            labelFormatter: function(){
              return " ";
            }
        },
        data: [{
            name: "Received",
            showInLegend: false,
            legendMarkerType: "square",
            type: "area",
            color: "rgba(175,255,51,0.6)",
            markerSize: 0,
            dataPoints: [
                { x: new Date(2023, 1, 6), y: 30 },
                { x: new Date(2023, 1, 7), y: 24 },
                { x: new Date(2023, 1, 8), y: 40 },
                { x: new Date(2023, 1, 9), y: 10 },
                { x: new Date(2023, 1, 10), y: 50 },
                { x: new Date(2023, 1, 11), y: 5 },
    
            ]
        },
        


            ]
    });
    chart.render();
    
}

function ingresos3(){
    $(".canvasjs-chart-credit").hide();
    
    var chart = new CanvasJS.Chart("chartContainer3", {
        animationEnabled: true,
        backgroundColor: null,
    
        axisX: {
            gridThickness: 0,
            tickLength: 0,
            lineThickness: 0,
            labelFormatter: function(){
              return " ";
            }
        },
        axisY: {
            gridThickness: 0,
            tickLength: 0,
            lineThickness: 0,
            labelFormatter: function(){
              return " ";
            }
        },
        data: [{
            name: "Received",
            showInLegend: false,
            legendMarkerType: "square",
            type: "area",
            color: "rgba(255,51,197,0.6)",
            markerSize: 0,
            dataPoints: [
                { x: new Date(2023, 1, 6), y: 30 },
                { x: new Date(2023, 1, 7), y: 24 },
                { x: new Date(2023, 1, 8), y: 40 },
                { x: new Date(2023, 1, 9), y: 10 },
                { x: new Date(2023, 1, 10), y: 50 },
                { x: new Date(2023, 1, 11), y: 5 },
    
            ]
        },
        


            ]
    });
    chart.render();
    
}
init();