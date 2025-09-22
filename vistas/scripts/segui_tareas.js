function inicio() { }
function verHistorial(id_credencial) {
    $("#precarga").show();
    $.post("../controlador/segui_tareas.php?op=verHistorial", { id_credencial: id_credencial }, function (data, status) {
        data = JSON.parse(data);// convertir el mensaje a json
        $("#myModalHistorial").modal("show");
        $("#historial2").html("");// limpiar el div resultado
        $("#historial2").append(data["0"]["0"]);// agregar el resultao al div resultado
        $("#precarga").hide();
        verSeguimiento(id_credencial);
        verTareasProgramadas(id_credencial);
    });
}
// funcion para listar los seguimientos
function verSeguimiento(id_credencial) {
    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    var f = new Date();
    var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tbllistadohistorial').dataTable({
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
                messageTop: '<div style="width:50%;float:left">Fecha Reporte: <b> ' + fecha_hoy + '</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                title: 'Ejes',
                titleAttr: 'Seguimiento'
            },
        ],
        "ajax":
        {
            url: '../controlador/segui_tareas.php?op=verSeguimiento&id_credencial=' + id_credencial,
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10,//Paginación
        "order": [[3, "asc"]],//Ordenar (columna,orden)
        'initComplete': function (settings, json) {
            $("#precarga").hide();
        },
    });
}
// funcion para listar las tareas programadas
function verTareasProgramadas(id_credencial) {
    var estado = "Inscrito";
    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    var f = new Date();
    var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tbllistadoHistorialTareas').dataTable({
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
                messageTop: '<div style="width:50%;float:left">Fecha Reporte: <b> ' + fecha_hoy + '</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                title: 'Ejes',
                titleAttr: 'Tareas Programadas'
            },
        ],
        "ajax":
        {
            url: '../controlador/segui_tareas.php?op=verTareasProgramadas&id_credencial=' + id_credencial,
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10,//Paginación
        "order": [[3, "asc"]],//Ordenar (columna,orden)
        'initComplete': function (settings, json) {
            $("#precarga").hide();
        },
    });
}
inicio();