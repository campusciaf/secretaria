$(document).ready(incio);

function incio() {
    $("#precarga").hide();
    cargarperiodo();
    selectPrograma();
    mostrar_grafica();
    buscar();
}
function cargarperiodo() {
    $.post(
        "../controlador/segmentacion_estudiantes.php?op=selectPeriodo",
        function (r) {
            $("#periodo").html(r);
            $("#periodo").selectpicker("refresh");
        }
    );
}
function selectPrograma() {
	$.post("../controlador/segmentacion_estudiantes.php?op=selectPrograma", function (r) {
		$("#programa_ac").html(r);
		$('#programa_ac').selectpicker('refresh');
	});
}

function buscar() {
    let periodo = $("#periodo").val();
    // Verifica que el periodo tenga un valor antes de continuar
    if (!periodo) {
        return; // Detiene la ejecución de la función si no hay periodo
    }
    let periodoAnterior = (parseInt(periodo.split('-')[0]) - 1) + '-' + periodo.split('-')[1];
    let programa = [];
    $('#programa_ac option:selected').each(function () {
        programa.push($(this).val());
    });
    $.post("../controlador/segmentacion_estudiantes.php?op=general", {
        periodo: periodo,
        programa: programa,
        periodoAnterior: periodoAnterior
    }, function (response) {
        var datos = JSON.parse(response);
        edadpromedioprograma();
        var dataPointsPeriodoActual = datos.dataPointsPeriodoActual || [];
        var dataPointsPeriodoAnterior = datos.dataPointsPeriodoAnterior || [];

        var chart = new CanvasJS.Chart("chartContainer2", {
            animationEnabled: true,
            title: {
                text: "Rango de Edades"
            },
            toolTip: {
                shared: true
            },
            legend: {
                cursor: "pointer",
                itemclick: toggleDataSeries
            },
            data: [
                {
                    type: "column",
                    name: "Periodo Actual (" + periodo + ")",
                    showInLegend: true,
                    dataPoints: dataPointsPeriodoActual,
                    color: "#283157" // Cambia este valor al color hexadecimal que desees para el Periodo Actual

                },
                {
                    type: "column",
                    name: "Periodo Anterior (" + periodoAnterior + ")",
                    showInLegend: true,
                    dataPoints: dataPointsPeriodoAnterior,
                    color: "#1e88e5" // Cambia este valor al color hexadecimal que desees para el Periodo Anterior

                }
            ]
        });
        chart.render();
    })
}

function toggleDataSeries(e) {
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else {
        e.dataSeries.visible = true;
    }
    chart.render();
}

function mostrar_grafica() {
    $("#precarga").show();
    $.post("../controlador/segmentacion_estudiantes.php?op=mostrar_grafica", {}, function (data) {
        data = JSON.parse(data);
        $("#mostrar_grafica").show();
        $("#mostrar_grafica").html(data);
        $("#precarga").hide();

        
    });
}

function edadpromedioprograma() {
    let periodo = $('#periodo').val();
    let programa = [];
    $('#programa_ac option:selected').each(function () {
        programa.push($(this).val());
    });
    $("#precarga").show();
    $.post("../controlador/segmentacion_estudiantes.php?op=edadpromedioprograma", { periodo: periodo,
        programa: programa}, function (data) {
        data = JSON.parse(data);
        $("#edadpromedioprograma").show();
        $("#edadpromedioprograma").html(data);
        $("#precarga").hide();

    
    });
}
