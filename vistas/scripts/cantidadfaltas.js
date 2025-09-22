$(document).ready(inicio);
var escuela_global_seleccionado = "";  
var graficoCargado = false; // 

function inicio() {
    //dpor defecto se coloca en 0 para listar todos los programas, y cuando se selecciona los programas se carga el select con los programas seleccionados 
    if (escuela_global_seleccionado) {
        //lista el programa seleccionado
        listarProgramas(escuela_global_seleccionado);
    } else {
        //llama todos los programas
        listarProgramas("0"); 
    }
    $("#escuela").on("change", function () {
        var nuevaEscuela = $(this).val();
        if (nuevaEscuela !== escuela_global_seleccionado) {
            escuela_global_seleccionado = nuevaEscuela;
            listarProgramas(nuevaEscuela); 
        }
    }); 
    grafico();
    listarescuelas();
    mostrarPeriodo();
    $("#formulario_tabla").on("submit", function (e) {
        e.preventDefault();
        consulta_tabla();
        grafico_consulta();
    });
    $("#precarga").hide();
    $(".dos").hide();
}
//muestra la tabala con los filtros por programa,faltas,periodo y semestre 
function consulta_tabla() {
    $("#precarga").show();
    var formData = new FormData($("#formulario_tabla")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/cantidadfaltas.php?op=consulta_tabla",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            var r = JSON.parse(datos);
            $(".conte").html(r.conte);
            $("#dtl_notas").DataTable({
                dom: "Bfrtip",
                buttons: [
                    {
                        extend: "pdfHtml5",
                        text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                        orientation: "landscape",
                        pageSize: "LEGAL"
                    },
                    {
                        extend: "excelHtml5",
                        text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel"
                    }
                ],
                columnDefs: [
                    {
                        className: "control",
                        orderable: false,
                        targets: 0
                    }
                ],
                order: [2, "asc"],
                initComplete: function () {
                    $("#precarga").hide();
                },
                iDisplayLength: 10
            });
        }
    });
}

function progra(val) {
    var opti = "";
    $.post("../controlador/consultanotas.php?op=progra", { val: val }, function (datos) {
        var r = JSON.parse(datos);
        opti += '<option value="" selected disabled>- Semestres -</option>';
        opti += '<option value="todos">Todos</option>';
        for (let i = 1; i <= r.semestres; i++) {
            opti += '<option value="' + i + '">' + i + "</option>";
        }
        $("#semestre").html(opti);
        $(".ciclo").val(r.ciclo);
        $(".dos").show();
    });
}


function listarProgramas(id_escuela) {
    // Si `id_escuela` está vacío o no se seleccionó una escuela, asignar valor `0` para obtener todos los programas
    if (!id_escuela) {
        id_escuela = "0"; // Valor especial para indicar que se desean todos los programas
    }
    $.post("../controlador/cantidadfaltas.php?op=listarProgramas", { id_escuela: id_escuela }, function (datos) {
        $("#programa").empty();
        var r = JSON.parse(datos);
        var opti = '<option value="" disabled> - Programas - </option>';
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].id_programa + '">' + r[i].nombre + "</option>";
        }
        $("#programa").html(opti);
        $("#programa").selectpicker();
        $("#programa").selectpicker("refresh");

    });
}
function mostrarPeriodo() {
    $.post("../controlador/actualidad.php?op=mostrarPeriodo", function (datos) {
        var opti = "";
        var r = JSON.parse(datos);
        opti += '<option value="" selected disabled> - Periodos - </option>';
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].periodo + '">' + r[i].periodo + "</option>";
        }
        $("#periodo").html(opti);
    });
}
// lista la tabla cuando selecciona la escuela.
function consultaescuela(id_escuela) {

    listarProgramas(id_escuela);
    // grafico_escuela(id_escuela);
    
    
    $("#precarga").show();
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/cantidadfaltas.php?op=consultaescuela&id_escuela=" + id_escuela,
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            var r = JSON.parse(datos);
            $(".conte").html(r.conte);
            $("#dtl_notas").DataTable({
                dom: "Bfrtip",
                buttons: [
                    {
                        extend: "pdfHtml5",
                        text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                        orientation: "landscape",
                        pageSize: "LEGAL"
                    },
                    {
                        extend: "excelHtml5",
                        text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel"
                    }
                ],
                columnDefs: [
                    {
                        className: "control",
                        orderable: false,
                        targets: 0
                    }
                ],
                order: [7, "desc"],
                initComplete: function () {
                    $("#precarga").hide();
                },
                iDisplayLength: 10
            });
            
        }
    });
}

function listarescuelas() {
    $("#precarga").show();
    $.post("../controlador/cantidadfaltas.php?op=listarescuelas", {}, function (r) {
        var e = JSON.parse(r);
        $("#escuelas").html(e.mostrar);
        $("#precarga").hide();
        $("#escuelas a").click(function () {
            var id_escuela = $(this).attr("onclick").match(/\d+/)[0];
             escuela_global_seleccionado = id_escuela;

            consultaescuela(id_escuela);
        });
    });
}
function verfaltas(id_estudiante, id_materia) {
    $.post("../controlador/cantidadfaltas.php?op=verfaltas", { id_estudiante: id_estudiante, id_materia: id_materia }, function (r) {
        var e = JSON.parse(r);
        $("#resultado_faltas").html(e.mostrar);
        $("#modalfaltas").modal("show");
    });
}

//funcion que imprime el grafico cuando se selecciona la escuela 
function grafico_escuela(id_escuela) {
    if (graficoCargado) return; // Evitar cargar si ya se cargó
    graficoCargado = true; // Marcamos como cargado la primera vez
    $.post("../controlador/cantidadfaltas.php?op=grafico_escuela", { id_escuela: id_escuela }, function (r) {
        var data = JSON.parse(r);
        var puntosGrafico = data.datosuno.map(function (point) {
            return {
                x: new Date(point.x),
                y: point.y
            };
        });
        var chart = new CanvasJS.Chart("chartContainer1", {
            animationEnabled: true,
            exportEnabled: true,
            backgroundColor: null,
            theme: "light1", // "light1", "light2", "dark1", "dark2"
            axisX: {
                valueFormatString: "DD-MM",
                labelFontColor: "#4F81BC"
            },
            axisY: {
                valueFormatString: "#,###",
                gridThickness: 0,
                tickLength: 0,
                lineThickness: 0,
                labelFormatter: function () {
                    return " ";
                }
            },
            data: [
                {
                    type: "column", 
                    indexLabelFontColor: "#5A5757",
                    indexLabelFontSize: 16,
                    indexLabelPlacement: "outside",
                    dataPoints: puntosGrafico
                }
            ]
            
        });

        chart.render();
        $("#chartContainer2").hide();
        $("#chartContainer1").show();
        $("#chartContainer").hide();
    });
}
function grafico() {
    $.post("../controlador/cantidadfaltas.php?op=grafico", {}, function (r) {
        r = JSON.parse(r);
        var datos = r.datosuno.map(function (point) {
            return {
                x: new Date(point.x),
                y: point.y
            };
        });
        var chart = new CanvasJS.Chart("chartContainer", {
            "animationEnabled": true,
            "exportEnabled": true,
            "backgroundColor": null,
            "theme": "light1", // "light1", "light2", "dark1", "dark2"
            
            "axisX": {
                "valueFormatString": "DD-MM",
                "labelFontColor": "#4F81BC",
            },
            "axisY": {
                "valueFormatString": "#,###",
                "gridThickness": 0,
                "tickLength": 0,
                "lineThickness": 0,
                labelFormatter: function () {
                    return "";
                }
            }, 
            "data": [{
                //change type to bar, line, area, pie, etc
                "type": "column", 
                //indexLabel: "{y}", //Shows y value on all Data Points
                "indexLabelFontColor": "#5A5757",
                "indexLabelFontSize": 16,
                "indexLabelPlacement": "outside",
                "dataPoints": datos    
            }]
        });
        chart.render();
        $("#chartContainer").show();
        $("#chartContainer1").hide();
        $("#chartContainer2").hide();
    });
}
// se ejecuta cuando se consulta por medio del formulario 
function grafico_consulta() {
    var formData = new FormData($("#formulario_tabla")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/cantidadfaltas.php?op=grafico_consulta",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            $("#chartContainer2").show();
            var data = JSON.parse(datos);
            var datos = data.datosuno.map(function (point) {
                return {
                    x: new Date(point.x),
                    y: point.y
                };
            });
            var chart = new CanvasJS.Chart("chartContainer2", {
                animationEnabled: true,
                exportEnabled: true,
                backgroundColor: null,
                theme: "light1", // "light1", "light2", "dark1", "dark2"
                "axisX": {
                "valueFormatString": "DD-MM",
                "labelFontColor": "#4F81BC",
            },
            "axisY": {
                "valueFormatString": "#,###",
                "gridThickness": 0,
                "tickLength": 0,
                "lineThickness": 0,
                labelFormatter: function () {
                    return "";
                }
            }, 
               "data": [{
                //change type to bar, line, area, pie, etc
                "type": "column", 
                //indexLabel: "{y}", //Shows y value on all Data Points
                "indexLabelFontColor": "#5A5757",
                "indexLabelFontSize": 16,
                "indexLabelPlacement": "outside",
                "dataPoints": datos    
            }]
            });

            chart.render();
            $("#chartContainer1").hide();
            $("#chartContainer").hide();
        }
    });
}
