// JavaScript Document
$(document).ready(init);
//primera funcion que se ejecut cuando el documento esta listo 
function init() {
    listar_dashboard(); //listar interes mora actual
    $("#precarga").hide();
}
//listar interes mora actual
function listar_dashboard() {
    //post para ir al controlador y ejecutar la opcion de listar
    $.post("../controlador/sofi_panel.php?op=DatosPanel", function (datos) {
        //console.log(datos);
        datos = JSON.parse(datos);
        $(".RecaudadoHoy").html(datos.RecaudadoHoy);
        $(".NoRecaudadoHoy").html(datos.NoRecaudadoHoy);
        $(".NoRecaudadoTotal").html(datos.NoRecaudadoTotal);
        $(".percentMora").html(datos.procentaje);
        $(".countCuotasvencidas").html(datos.CuotasVencidas);
        $(".countCuotasavencer").html(datos.CuotasAVencer);
        $(".atrasados").html(datos.atrasados)
    });
    //post para ir al controlador y ejecutar la opcion de listar los pendientes
    $.post("../controlador/sofi_panel.php?op=listarTotalCreditos", function (datos) {
        datos = JSON.parse(datos);
        //console.log(datos);
        if (datos.exito == 1) {
            actual = datos.info_actual;
            comparado = datos.info_comparado;
            porcentaje_entre_anios = (100 * actual["Aprobado"]) / comparado["Aprobado"];
            span = '<small class="text-info"> ' + porcentaje_entre_anios.toFixed(2) + '% Del año anterior </small>';
            total_solicitudes_actual =  parseFloat(actual["Aprobado"]) + parseFloat(actual["Pre-Aprobado"]) + parseFloat(actual["Pendiente"]) + parseFloat(actual["Anulado"]);
            total_solicitudes_comparado = parseFloat(comparado["Aprobado"]) + parseFloat(comparado["Pre-Aprobado"]) + parseFloat(comparado["Pendiente"]) + parseFloat(comparado["Anulado"]);
            porcentaje_Aprobado_actual = Math.round((100 * actual["Aprobado"]) / total_solicitudes_actual);
            porcentaje_Pre_Aprobado_actual = Math.round((100 * actual["Pre-Aprobado"]) / total_solicitudes_actual);
            porcentaje_Pendiente_actual = Math.round((100 * actual["Pendiente"]) / total_solicitudes_actual);
            porcentaje_Anulado_actual = Math.round((100 * actual["Anulado"]) / total_solicitudes_actual);
            porcentaje_Aprobado_comparado = Math.round((100 * comparado["Aprobado"]) / total_solicitudes_comparado);
            porcentaje_Pre_Aprobado_comparado = Math.round((100 * comparado["Pre-Aprobado"]) / total_solicitudes_comparado);
            porcentaje_Pendiente_comparado = Math.round((100 * comparado["Pendiente"]) / total_solicitudes_comparado);
            porcentaje_Anulado_comparado = Math.round((100 * comparado["Anulado"]) / total_solicitudes_comparado);
            $(".porcentaje_Aprobado_actual").attr("aria-valuenow", porcentaje_Aprobado_actual).css("width", porcentaje_Aprobado_actual + "%");
            $(".porcentaje_Pre_Aprobado_actual").attr("aria-valuenow", porcentaje_Pre_Aprobado_actual).css("width", porcentaje_Pre_Aprobado_actual + "%");
            $(".porcentaje_Pendiente_actual").attr("aria-valuenow", porcentaje_Pendiente_actual).css("width", porcentaje_Pendiente_actual + "%");
            $(".porcentaje_Anulado_actual").attr("aria-valuenow", porcentaje_Anulado_actual).css("width", porcentaje_Anulado_actual + "%");
            $(".porcentaje_Aprobado_comparado").attr("aria-valuenow", porcentaje_Aprobado_comparado).css("width", porcentaje_Aprobado_comparado + "%");
            $(".porcentaje_Pre_Aprobado_comparado").attr("aria-valuenow", porcentaje_Pre_Aprobado_comparado).css("width", porcentaje_Pre_Aprobado_comparado + "%");
            $(".porcentaje_Pendiente_comparado").attr("aria-valuenow", porcentaje_Pendiente_comparado).css("width", porcentaje_Pendiente_comparado + "%");
            $(".porcentaje_Anulado_comparado").attr("aria-valuenow", porcentaje_Anulado_comparado).css("width", porcentaje_Anulado_comparado + "%");
            $(".total_Aprobado_actual").html(actual["Aprobado"]);
            $(".total_Pre-Aprobado_actual").html(actual["Pre-Aprobado"]);
            $(".total_Pendiente_actual").html(actual["Pendiente"]);
            $(".total_Anulado_actual").html(actual["Anulado"]);
            $(".total_Aprobado_comparado").html(comparado["Aprobado"]);
            $(".total_Pre-Aprobado_comparado").html(comparado["Pre-Aprobado"]);
            $(".total_Pendiente_comparado").html(comparado["Pendiente"]);
            $(".total_Anulado_comparado").html(comparado["Anulado"]);
            $(".porcentaje_entre_anios").html(span);
            $(".total_solicitudes_actual").html(total_solicitudes_actual);
            $(".total_solicitudes_comparado").html(total_solicitudes_comparado);
        }
    });
    //post para ir al controlador y ejecutar la opcion de listar
    $.post("../controlador/sofi_panel.php?op=listarCategorias", function (datos) {
        /*console.log(datos);*/
        datos = JSON.parse(datos);
        if (datos.exito == 1) {
            $("#total_sin_categoria").html(datos.info_sin_categoria);
            $("#total_categoria_a").html(datos.info_categoria_a);
            $("#total_categoria_b").html(datos.info_categoria_b);
            $("#total_categoria_c").html(datos.info_categoria_c);
            $("#total_categoria_d").html(datos.info_categoria_d);
            $("#total_categoria_e").html(datos.info_categoria_e);
        } else {
            $(".percentMora").html("0");
        }
    });
    //generar bar chart para estadisticas de cantidad de recaudo del periodo anterior
    $.post("../controlador/sofi_panel.php?op=BarChar", function (datos) {
        //console.log(datos);
        datos = JSON.parse(datos);
        if (datos.exito == 1) {
            var estadisticas_actual = JSON.parse(datos.info_actual);
            var estadisticas_comparado = JSON.parse(datos.info_comparado);
            var chart = new CanvasJS.Chart("barchart_estadistica_actual", {
                animationEnabled: true,
                backgroundColor: null,
                indexLabelFontSize: 30,
                height: 269,
                axisX: {
                    labelFontColor: "gray",
                },
                axisY: {
                    "gridThickness": 0,
                    "tickLength": 0,
                    "lineThickness": 0,
                    labelFormatter: function () {
                        return " ";
                    },
                },
                data: [{
                    indexLabelFontSize: 16,
                    showInLegend: false,
                    legendMarkerColor: "gray",
                    legendText: "MMbbl = one million barrels",
                    dataPoints: estadisticas_actual
                }]
            });
            chart.render();
            var chart = new CanvasJS.Chart("barchart_estadistica_comparado", {
                animationEnabled: true,
                backgroundColor: null,
                indexLabelFontSize: 30,
                height: 269,
                axisX: {
                    labelFontColor: "gray",
                },
                axisY: {
                    "gridThickness": 0,
                    "tickLength": 0,
                    "lineThickness": 0,
                    labelFormatter: function () {
                        return " ";
                    },
                },
                data: [{
                    indexLabelFontSize: 16,
                    showInLegend: false,
                    legendMarkerColor: "gray",
                    legendText: "MMbbl = one million barrels",
                    dataPoints: estadisticas_comparado
                }]
            });
            chart.render();
        }
    });
    //generar bar chart para estadisticas de cantidad de recaudo del periodo actual
    $.post("../controlador/sofi_panel.php?op=CharProyeccion&periodo=2024-1", function (datos) {
        //console.log(datos);
        datos = JSON.parse(datos);
        $(".porcentaje_avance_cartera").html(datos.porcentaje_avance_cartera);
        if (datos.exito == 1) {
            var chart = new CanvasJS.Chart("estadistica_periodica", {
                animationEnabled: true,
                backgroundColor: null,
                indexLabelFontSize: 30,
                height: 269,
                axisY: {
                    "gridThickness": 0,
                    "tickLength": 0,
                    "lineThickness": 0,
                    labelFormatter: function () {
                        return " ";
                    }
                },
                axisY2: {
                    "gridThickness": 0,
                    "tickLength": 0,
                    "lineThickness": 0,
                    labelFormatter: function () {
                        return " ";
                    },
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
                    name: "Por Recaudar",
                    legendText: "Por Recaudar",
                    showInLegend: true,
                    dataPoints: datos.PorRecaudar,
                    color: "#dc3545"
                },
                {
                    type: "column",
                    name: "Recaudado",
                    legendText: "Recaudado",
                    axisYType: "secondary",
                    showInLegend: true,
                    dataPoints: datos.Recaudado,
                    color:"#007bff"
                }, {
                    type: "column",
                    name: "Total",
                    legendText: "Total",
                    axisYType: "secondary",
                    showInLegend: true,
                    dataPoints: datos.Total,
                    color: "#28a745"
                }]
            });
            chart.render();
        }
    });
}
function toggleDataSeries(e) {
    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    }
    else {
        e.dataSeries.visible = true;
    }
    chart.render();
}