var tabla,
global_id_estudiante,
global_id_programa_ac,
global_id_credencial,
global_id_matricula,
tipo_busqueda = 2
var tabla_cuotas;


//Función que se ejecuta al inicio
function init() {
    selectPrograma();
	selectJornada();
	selectTipoDocumento();
	selectNivelEscolaridad();
$("#ingresos_campus").hide();



mostrarform(false);
mostraringresoscampus(false);


$("#listadoregistros").hide();
$("#tbllistadosoportes").hide();
$("#tabla_cuotas_3").hide();
$("#ocultar_tablas_pago").hide();
$("#tabla_cuotas").hide();
$("#listadospqrtabla").hide();
$("#listadosquedate").hide();
$("#listadomaterias").hide();
$("#bton_volver").hide();
$("#IngresosCampus").hide();
$("#listaDatosocultar").hide();
$("#listadosinfluencer").hide();

$("#formularioverificar").on("submit", function (e1) {
    verificardocumento(e1);
});
$('#ModalConsultaFecha').on('hidden.bs.modal', function (event) {
    $("#chartContainer2").html("");
    $("#form_grafica")[0].reset();
})
if ($(window).width() <= 1083) {
    $("#tabla_cuotas").addClass("table-responsive");
    $("#tabla_info").addClass("table-responsive");
}else {
    $("#tabla_cuotas").removeClass("table-responsive");
    $("#tabla_info").removeClass("table-responsive");
}

$(".guardarDatosPersonales").on("submit", function (e) {
    e.preventDefault();
    editarDatosPersona();
});

$(".guardarDatos").on("submit", function (e) {
    cambiarContra(e);
});

$("#formularioeditarperfil").on("submit", function (e5) {
		editarPerfil(e5);
	});

$("#precarga").hide();

}

//Verifica el documento del estudiante
function verificardocumento(e1) {
$("#ingresos_campus").hide();
$("#listadomaterias").hide();
$("#listadospqrtabla").hide();
$("#listadoregistros").hide();
$("#listadomaterias").hide();
$("#tabla_cuotas_3").hide();
$("#ocultar_tablas_pago").hide();
$("#tabla_cuotas").hide();
$("#IngresosCampus").hide();
$("#pqr").hide();
$(".menutablist").hide();
$(".proceso_de_admision").hide();
$("#tbllistadosoportes").hide();
$("#listadosinfluencer").hide();


e1.preventDefault();
//$("#btnVerificar").prop("disabled",true);
var formData = new FormData($("#formularioverificar")[0]);

$.ajax({
    url: "../controlador/historial_estudiante.php?op=verificardocumento",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
    data = JSON.parse(datos);
    var id_credencial = "";
    if (JSON.stringify(data["0"]["1"]) == "false") {
        // si llega vacio toca matricular
        alertify.error("Estudiante No Existe");
        $("#listadoregistros").hide();
        $("#listadomaterias").hide();
        $("#listadospqrtabla").hide();
        $("#ocultar_tablas_pago").hide();
        $("#mostrardatos").hide();
        $("#ingresos_campus").hide();
        $("#IngresosCampus").hide();
        $("#tabla_cuotas_3").hide();
        $("#tabla_cuotas").hide();
        $("#pqr").hide();
        $("#listadosinfluencer").hide();
        $("#caracterizacion").hide();

    } else {
        
        id_credencial = data["0"]["0"];
        $("#mostrardatos").show();
        $("#ingresos_campus").hide();
        $("#IngresosCampus").hide();
        $("#listadospqrtabla").hide();
        $("#ocultar_tablas_pago").hide();
        $("#tabla_cuotas_3").hide();
        $("#tabla_cuotas").hide();
        $("#caracterizacion").hide();
        $("#pqr").hide();
        alertify.success("Esta registrado");
        mostrardatos(id_credencial);
        detalles(id_credencial);
        // ingresos_campus(id_credencial);

    }
    },
});
}
//Función Listar
function listar(id_credencial) {
$("#listadoregistros").show();
$("#ingresos_campus").hide();
$("#IngresosCampus").hide();
$("#tabla_cuotas_3").hide();
$("#tabla_cuotas").hide();
$("#bton_volver").hide();
$("#listadospqrtabla").hide();
$("#caracterizacion").hide();
$("#listadosinfluencer").hide();
  


$("#pqr").hide();
var meses = new Array(
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre"
);
var diasSemana = new Array(
    "Domingo",
    "Lunes",
    "Martes",
    "Miércoles",
    "Jueves",
    "Viernes",
    "Sábado"
);
var f = new Date();
var fecha =
    diasSemana[f.getDay()] +
    ", " +
    f.getDate() +
    " de " +
    meses[f.getMonth()] +
    " de " +
    f.getFullYear();

tabla = $("#tbllistado")
    .dataTable({
    aProcessing: true, //Activamos el procesamiento del datatables
    aServerSide: true, //Paginación y filtrado realizados por el servidor
    dom: "Bfrtip",
    buttons: [
        {
        extend: "excelHtml5",
        text: '<i class="fa fa-file-excel"></i>',
        titleAttr: "Excel",
        },
        {
        extend: "print",
        text: '<i class="fas fa-print"></i>',
        messageTop:
            '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: ' +
            fecha +
            '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
        title: "Programas Académicos",
        titleAttr: "Print",
        },
    ],
    ajax: {
        url:
        "../controlador/historial_estudiante.php?op=listar&id_credencial=" +
        id_credencial,
        type: "get",
        dataType: "json",
        error: function (e) {
        // //console.log(e);
        },
    },
    bDestroy: true,
    scrollX: false,
    iDisplayLength: 10, //Paginación
    order: [[2, "asc"]], //Ordenar (columna,orden)
    })
    .DataTable();
    mostrardatos(id_credencial);
    //detalles(id_credencial);
}

//Función limpiar
function limpiar() {
    $("#id_credencial").val("");
    $("#credencial_nombre").val("");
    $("#credencial_nombre_2").val("");
    $("#credencial_apellido").val("");
    $("#credencial_apellido_2").val("");
    $("#credencial_login").val("");
}

//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#listadomaterias").hide();
        $("#tbllistadosoportes").hide();
        $("#listadospqrtabla").hide();
        $("#ingresos_campus").hide();
        $("#bton_volver").hide();
        $("#tabla_cuotas_3").hide();
        $("#ocultar_tablas_pago").hide();
        $("#tabla_cuotas").hide();
        $("#pqr").hide();
        $("#IngresosCampus").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
        $("#seleccionprograma").hide();
        $("#caracterizacion").hide(); 
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#listadospqrtabla").hide();
        $("#bton_volver").hide();
        $("#tabla_cuotas").hide();
        $("#tbllistadosoportes").hide();
        $("#ocultar_tablas_pago").hide();
        $("#ingresos_campus").hide();
        $("#IngresosCampus").hide();
        $("#pqr").hide();
        $("#caracterizacion").hide();
        $("#btnagregar").show();
        $("#seleccionprograma").show();
        $("#listadosinfluencer").hide();
    }
}

//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}

function historial_academico() {

    listar(global_id_credencial);
    $(".menutablist").hide();
    $("#tabla_cuotas_3").hide();
    $("#tabla_cuotas").hide();
    $("#listadosquedate").hide();
    $("#tbllistadosoportes").hide();
    $("#bton_volver").hide();
    $("#listadospqrtabla").hide();
    $("#listadosoportes").hide();
    $(".proceso_de_admision").hide();
    $("#caracterizacion").hide(); 
    $("#ocultar_tablas_pago").hide();
    $("#listadomaterias").hide();
    $("#ingresos_campus").hide();
    $("#IngresosCampus").hide();
    $("#pqr").hide();
    $("#listadosinfluencer").hide();
    $("#listaDatosocultar").hide();
}


function mostrardatos(id_credencial) {
    $.post(
        "../controlador/historial_estudiante.php?op=mostrardatos",
        { id_credencial: id_credencial },
        function (data, status) {
        data = JSON.parse(data);
        $("#mostrardatos").html("");
        $("#mostrardatos").append(data["0"]["0"]);
        }
    );
}

function mostrarmaterias(id_programa_ac, id_estudiante) {
    global_id_programa_ac = id_programa_ac;
    global_id_estudiante = id_estudiante;
    $("#precarga").show();
    $.post(
        "../controlador/historial_estudiante.php?op=mostrarmaterias",
        { id_programa_ac: id_programa_ac, id_estudiante: id_estudiante },
        function (data, status) {
        data = JSON.parse(data);
        $("#listadoregistros").hide();
        $("#tabla_cuotas_3").hide();
        $("#tabla_cuotas").hide();
        $("#listadospqrtabla").hide();
        $("#ingresos_campus").hide();
        $("#IngresosCampus").hide();
        $("#caracterizacion").hide(); 
        $("#bton_volver").show();
        $("#pqr").hide();
        $("#listadosinfluencer").hide();
        $("#listadomaterias").show();
        $("#listadomaterias").html("");
        $("#listadomaterias").append(data["0"]["0"]);
        $("#precarga").hide();
        $("#listaDatosocultar").hide();
        $('[data-toggle="tooltip"]').tooltip();
        }
    );
}

function detalles(id_credencial) {
global_id_credencial = id_credencial;
    $.post(
        "../controlador/historial_estudiante.php?op=botonesvisualizar",
        { id_credencial: id_credencial },
        function (datos) {
        var r = JSON.parse(datos);
        // //console.log(datos);
        $("#panel_resultado").html(r);
        $("#panel_resultado").show();
        $("#bton_volver").hide();
        $("#tabla_cuotas_3").hide();
        $("#listadospqrtabla").hide();
        $("#tabla_cuotas").hide();
        $("#caracterizacion").hide(); 
        $("#listadosinfluencer").hide(); 
        $("a.toggle-vis").on("click", function (datos) { 
        });
        }
    );
}

function verEntrevista(id_estudiante) {
    $.post(
        "../controlador/historial_estudiante.php?op=verEntrevista",
        { id_estudiante: id_estudiante },
        function (data) {
            data = JSON.parse(data);
            $("#sostiene").val(data.sostiene);
            $("#labora").val(data.labora);
            $("#cargo").val(data.cargo);
            $("#donde_labora").val(data.donde_labora);
            $("#motiva").val(data.motiva);
            $("#conoce_plan").val(data.conoce_plan);
            $("#descarto").val(data.descarto);
            $("#curso_ad").val(data.curso_ad);
            $("#talento").val(data.talento);
            $("#referir").val(data.referir);
            $("#dejar").val(data.dejar);
            $("#razon").val(data.razon);
            // Mostrar el modal
            $("#myModalEntrevista").modal("show");
        }
    );
}


function caso_por_fecha() {
    $("#ModalConsultaFecha").modal("show");
}

function generarGrafica(){
    $.post( "../controlador/historial_estudiante.php?op=grafico2", { "global_id_credencial": global_id_credencial, "mes": $("#mes").val(), "anio": $("#anio").val() }, function (r) {
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


function proceso_de_admision(){
    $("#listadosoportes").show();
    $("#tbllistadosoportes").show();
    $("#listadoregistros").hide();
    $("#tabla_cuotas_3").hide();
    $("#tabla_cuotas").hide();
    $("#listadomaterias").hide();
    $("#ocultar_tablas_pago").hide();
    $("#listadosquedate").hide();
    $("#listadospqrtabla").hide();
    $("#ingresos_campus").hide();
    $("#IngresosCampus").hide();
    $("#caracterizacion").hide(); 
    $("#bton_volver").hide();
    $("#listadosinfluencer").hide();
    $("#pqr").hide();
    $("#precarga").show();
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f=new Date();
    var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tbllistadosoportes').dataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [
            {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-copy fa-2x" style="color: blue"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                titleAttr: 'Excel'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                title: 'Ejes',
                titleAttr: 'Print'
            },
        ],
        
        "ajax":{ url: '../controlador/historial_estudiante.php?op=proceso_de_admision_soportes&global_id_credencial='+global_id_credencial, type : "get", dataType : "json",						
        error: function(e){
            // console.log(e.responseText);
        }
    },
    "bDestroy": true,
    "iDisplayLength": 30,//Paginación
    order: false,
    'initComplete': function (settings, json) {

            $("#precarga").hide();
            
        }, 
    });    
}


function casos_por_estudiante(){
    $("#listadosoportes").hide();
    $("#tabla_cuotas_3").hide();
    $("#tabla_cuotas").hide();
    $("#tbllistadosoportes").hide();
    $("#listadospqrtabla").hide();
    $("#listadoregistros").hide();
    $("#ocultar_tablas_pago").hide();
    $("#listadomaterias").hide();
    $("#ingresos_campus").hide();
    $("#IngresosCampus").hide();
    $("#caracterizacion").hide(); 
    $("#pqr").hide();
    $("#listadosinfluencer").hide();
    $("#listadosquedate").show();
    // $("#listadoquedate").show();
    // $("#precarga").show();
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f=new Date();
    var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tbllistaquedate').dataTable({
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: 'Bfrtip',//Definimos los elementos del control de tabla
    buttons: [
        {
        extend:    'copyHtml5',
        text:      '<i class="fa fa-copy fa-2x" style="color: blue"></i>',
        titleAttr: 'Copy'
        },
        {
        extend:    'excelHtml5',
        text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
        titleAttr: 'Excel'
        },
        {
        extend: 'print',
        text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
        messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
        title: 'Ejes',
        titleAttr: 'Print'
        },
    ],
    
    "ajax":{ url: '../controlador/historial_estudiante.php?op=quedate_estudiante&global_id_credencial='+global_id_credencial, type : "get", dataType : "json",						
    error: function(e){
        // console.log(e.responseText);
    }
    },
    "bDestroy": true,
    "iDisplayLength": 30,//Paginación
    order: false,
    'initComplete': function (settings, json) {
    
        $("#precarga").hide();
        
    },
    });
    
}

function modal_casos_quedate(casos_id) {
    $.post(
        "../controlador/historial_estudiante.php?op=mostrar_casos_quedate_estudiante",
        { casos_id: casos_id }, function (datos) {
            var r = JSON.parse(datos);
            // console.log(r);
        $("#myModalCasosQuedateEstudiante").modal("show");
        $("#casosquedateestudiante").html(r.conte);
        $("#casosquedateestudiante").show();     
        }
    );
}

function ingresos_campus() {
    $.post(
        "../controlador/historial_estudiante.php?op=ingresos_campus_x_fecha",
        { global_id_credencial: global_id_credencial },
        function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        $("#listadoregistros").hide();
        $("#listadosinfluencer").hide();
        $("#mostrardatos").hide();
        $("#listadosoportes").hide();
        $("#listadospqrtabla").hide();
        $("#ocultar_tablas_pago").hide();
        $("#tabla_cuotas_3").hide();
        $("#tabla_cuotas").hide();
        $("#tbllistadosoportes").hide();
        $("#listadoregistros").hide();
        $("#listadomaterias").hide();
        $("#listadosquedate").hide();
        $("#listadoquedate").hide();
        $("#pqr").hide();
        $("#caracterizacion").hide();  
        $("#ingresos_campus").html(r);
        $("#ingresos_campus").show();
        $.post("../controlador/historial_estudiante.php?op=selectlistaranios", function (respuesta) {
            $("#anio").html(respuesta);
            $('#anio').selectpicker('refresh');
        });
        }
    );
}

function mostraringresoscampus(flag) {
    // limpiar();
    if (flag) {

        $("#ingresos_campus").hide();
        $("#tabla_cuotas_3").hide();
        $("#tabla_cuotas").hide();
        $("#ocultar_tablas_pago").hide();
        $("#listadospqrtabla").hide();
        $("#IngresosCampus").hide();
        $("#caracterizacion").hide();
        } else {
        $("#ingresos_campus").hide();
        $("#ocultar_tablas_pago").hide();
        $("#tabla_cuotas_3").hide();
        $("#tabla_cuotas").hide();
        $("#listadospqrtabla").hide();
        $("#IngresosCampus").hide();
        $("#caracterizacion").hide();
        $("#listadosinfluencer").hide();
    }
}

function activarBotonDt(boton) {
    $(".botones_menu").removeClass("bg-success text-white");
    $(boton).toggleClass("bg-success text-white");
}

function pqr() {
    $.post(
        "../controlador/historial_estudiante.php?op=verAyudaTerminado",
        { global_id_credencial: global_id_credencial },
        function (datos) {
        // console.log(datos);
        var r = JSON.parse(datos);
        $("#tabla_cuotas_3").hide();
        $("#tabla_cuotas").hide();
        $("#ingresos_campus").hide();
        $("#IngresosCampus").hide();
        $("#mostrardatos").hide();
        $("#listadosoportes").hide();
        $("#tbllistadosoportes").hide();
        $("#ocultar_tablas_pago").hide();
        $("#listadoregistros").hide();
        $("#listadomaterias").hide();
        $("#listadosquedate").hide();
        $("#listadoquedate").hide();
        $("#caracterizacion").hide();
        $("#pqr").html(r);
        $("#pqr").show();
        $("#myModalPQR").modal("show");
        $("#listadosinfluencer").hide();
        }
    );
}

function volver(){
        $("#ingresos_campus").hide();
        $("#IngresosCampus").hide();
        $("#tabla_cuotas_3").hide();
        $("#tabla_cuotas").hide();
        $("#listadospqrtabla").hide();
        $("#ocultar_tablas_pago").hide();
        $("#mostrardatos").hide();
        $("#listadosoportes").hide();
        $("#tbllistadosoportes").hide();
        $("#listadoregistros").hide();
        $("#listadomaterias").hide();
        $("#listadosquedate").hide();
        $("#listadoquedate").hide();
        $("#listadoregistros").show();
        $("#caracterizacion").hide(); 
        $("#listadosinfluencer").hide();

}

function listar_cuotas(){
    $("#ingresos_campus").hide();
    $("#listadosoportes").hide();
    $("#listadosquedate").hide();
    $("#listadoregistros").hide();
    $("#listadomaterias").hide();
    $("#IngresosCampus").hide();
    $("#listadospqrtabla").hide();
    $("#pqr").hide();
    $(".menutablist").hide();
    $(".proceso_de_admision").hide();
    $("#caracterizacion").hide();
    $("#bton_volver").hide(); 
    $("#listaDatos").hide(); 
    $("#listadosinfluencer").hide();

    $(".btnBuscarCuota").prop("disabled",true);
    $("#precarga").hide();
    tabla_cuotas = $('#tabla_info').dataTable({
        "aProcessing": true,
		"aServerSide": true,
		"autoWidth": false,
		"dom": 'rtip',
		"ajax": {
			"url" : "../controlador/historial_estudiante.php?op=listarCuotas",
			"type" : "POST",
            "data" : { "tipo_busqueda": tipo_busqueda, "global_id_credencial": global_id_credencial },
			"error" : function(e){ 
                // console.log(e.responseText) 
            }
		},
        "bDestroy": true,
		"iDisplayLength": 12,
        "ordering": false,
        "initComplete": function () {
            $(".tooltip-button").tooltip();
        },
	}).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
	$('.dt-button').removeClass('dt-button');
    $(".btnBuscarCuota").prop("disabled", false);
    $("#tabla_cuotas_3").show();
    $("#tabla_cuotas").hide();
    $("#caracterizacion").hide();
    $("#ocultar_tablas_pago").show();
}


function modal_traer_pagos(id_matricula) {

    $.post(
        "../controlador/historial_estudiante.php?op=MostrarPagosEstudiante",
        { id_matricula: id_matricula }, function (datos) {
            var r = JSON.parse(datos);
            // console.log(r);
        $("#myModaltraerpagos").modal("show");
        $("#modal_pagos_estudiante").html(r);

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

        $("#modal_pagos_estudiante").show();     
        }
    );
    $("#ingresos_campus").hide();
    $("#listadomaterias").hide();
    $("#listadospqrtabla").hide();
    $("#listadoregistros").hide();
    $("#listadomaterias").hide();
    $("#IngresosCampus").hide();
    $("#pqr").hide();
    $(".menutablist").hide();
    $(".proceso_de_admision").hide();
    $("#tbllistadosoportes").hide();
    $("#caracterizacion").hide();
    $("#listadosinfluencer").hide();
}


function casos_pqr(){
    $("#listadosoportes").hide();
    $("#tabla_cuotas_3").hide();
    $("#tabla_cuotas").hide();
    $("#tbllistadosoportes").hide();
    $("#listadoregistros").hide();
    $("#ocultar_tablas_pago").hide();
    $("#listadomaterias").hide();
    $("#ingresos_campus").hide();
    $("#IngresosCampus").hide();
    $("#bton_volver").hide();
    $("#pqr").hide();
    $("#listadospqrtabla").show();
    $("#listadosquedate").hide();
    $("#caracterizacion").hide();  
    $("#listadosinfluencer").hide();
    // $("#listadoquedate").show();
    // $("#precarga").show();
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f=new Date();
    var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tbllistapqr').dataTable({
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: 'Bfrtip',//Definimos los elementos del control de tabla
    buttons: [
        {
        extend:    'copyHtml5',
        text:      '<i class="fa fa-copy fa-2x" style="color: blue"></i>',
        titleAttr: 'Copy'
        },
        {
        extend:    'excelHtml5',
        text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
        titleAttr: 'Excel'
        },
        {
        extend: 'print',
        text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
        messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
        title: 'Ejes',
        titleAttr: 'Print'
        },
    ],
    
    "ajax":{ url: '../controlador/historial_estudiante.php?op=casos_pqr&global_id_credencial='+global_id_credencial, type : "get", dataType : "json",						
    error: function(e){
        // console.log(e.responseText);
    }
    },
    "bDestroy": true,
    "iDisplayLength": 30,//Paginación
    order: false,
    'initComplete': function (settings, json) {
    
        $("#precarga").hide();
        
    },
    });
    
}



function listarcaracterizacionestudiante() {

    $.post(
        "../controlador/historial_estudiante.php?op=listarcaracterizacionestudiante",
        { global_id_credencial: global_id_credencial }, function (datos) {
            var r = JSON.parse(datos);
            // console.log(r);
            $("#caracterizacion").html(r);
            $("#caracterizacion").show(); 
        }
    );

    

    $("#listadomaterias").hide();
    $("#listadospqrtabla").hide();
    $("#listadoregistros").hide();
    $("#IngresosCampus").hide();
    $("#pqr").hide();
    $(".menutablist").hide();
    $(".proceso_de_admision").hide();
    $("#tbllistadosoportes").hide();
    $("#ocultar_tablas_pago").hide();
    $("#listadosquedate").hide();
    $("#listadosoportes").hide();
    $("#ingresos_campus").hide();
    $("#listadomterias").hide();
    $("#IngresosCampus").hide();
    $("#bton_volver").hide();
    $("#listadosinfluencer").hide();
}


// function listarcaracterizacionestudiante(id_credencial)
// {

//     $("#ingresos_campus").hide();
//     $("#listadosoportes").hide();
//     $("#listadosquedate").hide();
//     $("#listadoregistros").hide();
//     $("#listadomaterias").hide();
//     $("#IngresosCampus").hide();
//     $("#listadospqrtabla").hide();
//     $("#pqr").hide();
//     $(".menutablist").hide();
//     $(".proceso_de_admision").hide();
//     $("#bton_volver").hide();
// 	$.post("../controlador/historial_estudiante.php?op=listarcaracterizacionestudiante",{id_credencial : id_credencial}, function(data, status)
// 	{
// 		console.log(data);
// 		data = JSON.parse(data);		
// 		$("#caracterizacion").html("");
// 		$("#caracterizacion").append(data["0"]["0"]);
//         $("#caracterizacion").show();    
// 		// $("#myModalResultados").modal("show");
// 		// 

//  	});
// }


function listaDatos(id_credencial) {
    
    $("#caracterizacion").hide();
    $("#listadomaterias").hide();
    $("#listadospqrtabla").hide();
    $("#listadoregistros").hide();
    $("#IngresosCampus").hide();
    $("#pqr").hide();
    $(".menutablist").hide();
    $(".proceso_de_admision").hide();
    $("#tbllistadosoportes").hide();
    $("#ocultar_tablas_pago").hide();
    $("#listadosquedate").hide();
    $("#listadosoportes").hide();
    $("#ingresos_campus").hide();
    $("#listadomterias").hide();
    $("#IngresosCampus").hide();
    $("#bton_volver").hide();  
    $("#mostrardatos").hide();
    $("#listadosinfluencer").hide();

	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#listadatos').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: 'Bfrtip',//Definimos los elementos del control de tabla
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Print'
			},
		],
		"ajax": {
			url: '../controlador/historial_estudiante.php?op=listaDatos&id_credencial=' + id_credencial, type: "get", dataType: "json",
			error: function (e) {
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[0, "asc"]],//Ordenar (columna,orden)
		'initComplete': function (settings, json) {
			$("#listaDatosocultar").show();
			scroll(0, 0);
		},
	});
}

//cambia en estado en el ciafi
function cambiar_estado_ciafi(estado_ciafi, consecutivo) {
    alertify.confirm('Confirmar', '¿ Estas segur@ de cambiar el estado de ciafi ?', function () {
        $.post("../controlador/historial_estudiante.php?op=cambiarEstadoCiafi", { estado_ciafi: estado_ciafi, consecutivo: consecutivo }, function (data) {
            data = JSON.parse(data);
            if (data.exito == 1) {
                alertify.success('Cambio de estado correcto');
                listar_cuotas(null);
            } else {
                alertify.error('Error en el cambio de estado');
            }
        });
    }, function () {
        alertify.error('Has cancelado el cambio de estado')
    });
}


function influencer_por_estudiante(id_credencial){
    global_id_credencial = id_credencial;

    // Ocultamos todo menos influencer
    $("#listadosoportes, #tabla_cuotas_3, #tabla_cuotas, #tbllistadosoportes, #listadospqrtabla, #listadoregistros, #ocultar_tablas_pago, #listadomaterias, #ingresos_campus, #IngresosCampus, #caracterizacion, #pqr, #listadosquedate").hide();
    $("#listadosinfluencer").show();

    var meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    var diasSemana = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
    var f = new Date();
    var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

    tabla = $('#tbllistainfluencer').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excelHtml5', text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>', titleAttr: 'Excel' },
            { extend: 'print', text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
              messageTop: '<div style="width:50%;float:left"><b>Reporte Influencer</b><br>Fecha: '+fecha_hoy+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_ciaf_web.png" width="200px"></div>',
              title: 'Reporte Influencer', titleAttr: 'Print'
            }
        ],
        "ajax": {
            url: '../controlador/historial_estudiante.php?op=influencer_caso&global_id_credencial='+global_id_credencial,
            type : "get",
            dataType : "json"
        },
        "bDestroy": true,
        "iDisplayLength": 30,
        order: false,
        'initComplete': function () { $("#precarga").hide(); }
    });
}

function selectPrograma() {
	//Cargamos los items de los selects
	$.post("../controlador/historial_estudiante.php?op=selectPrograma", function (r) {
		$("#fo_programa").html(r);
		$('#fo_programa').selectpicker('refresh');
	});
}
function selectJornada() {
	//Cargamos los items de los selects
	$.post("../controlador/historial_estudiante.php?op=selectJornada", function (r) {
		$("#jornada_e").html(r);
		$('#jornada_e').selectpicker('refresh');
	});
}
function selectTipoDocumento() {
	//Cargamos los items de los selects
	$.post("../controlador/historial_estudiante.php?op=selectTipoDocumento", function (r) {
		$("#tipo_documento").html(r);
		$('#tipo_documento').selectpicker('refresh');
	});
}
function selectNivelEscolaridad() {
	//Cargamos los items de los selects
	$.post("../controlador/historial_estudiante.php?op=selectNivelEscolaridad", function (r) {
		$("#nivel_escolaridad").html(r);
		$('#nivel_escolaridad').selectpicker('refresh');
	});
}
function perfilEstudiante(id_estudiante, identificacion, fila) {
	//$("#precarga").show();
	$("#btnCambiar").prop("disabled", false);
	$("#myModalPerfilEstudiante").modal("show");
	$("#id_estudiante").val(id_estudiante);
	$("#fila").val(fila);
	$.post("../controlador/historial_estudiante.php?op=perfilEstudiante", { id_estudiante: id_estudiante }, function (data, status) {
		data = JSON.parse(data);
		$("#fo_programa").val(data.fo_programa);
		$("#fo_programa").selectpicker('refresh');
		$("#jornada_e").val(data.jornada_e);
		$("#jornada_e").selectpicker('refresh');
		$("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#nombre").val(data.nombre);
		$("#nombre_2").val(data.nombre_2);
		$("#apellidos").val(data.apellidos);
		$("#apellidos_2").val(data.apellidos_2);
		$("#celular").val(data.celular);
		$("#email").val(data.email);
		$("#nivel_escolaridad").val(data.nivel_escolaridad);
		$("#nivel_escolaridad").selectpicker('refresh');
		$("#fecha_graduacion").val(data.fecha_graduacion);
		$("#nombre_colegio").val(data.nombre_colegio);
	});
}
function editarPerfil(e5) {
	e5.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioeditarperfil")[0]);
	$.ajax({
		url: "../controlador/historial_estudiante.php?op=editarPerfil",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			console.log(datos);
			if (datos == 1) {
				alertify.success("Perfil Actualizado");
				$('#tbllistado').DataTable().ajax.reload();
				$("#myModalPerfilEstudiante").modal("hide");
			}
			else if (datos == 2) {
				alertify.error("Perfil no se pudo Actualizar");
			}
			else {
				alertify.error("Perfil ya bloqueado por validación");
			}
		}
	});
}
init();
