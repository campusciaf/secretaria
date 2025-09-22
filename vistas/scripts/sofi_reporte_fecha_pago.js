var tabla, api;
function init() {
    fecha = moment(); //Get the current date
    fecha = fecha.format("YYYY-MM-DD");
    listar("dia", {inicio: fecha, fin: fecha})
    $(".filtros").hide();
    ListarRango();
    //Cargamos los items de los selects
    $.post("../controlador/sofi_reporte_fecha_pago.php?op=selectPeriodo", function (r) {
        var data = JSON.parse(r);
        if (Object.keys(data).length > 0) {
            var html = '<option value="" disabled selected>-- Selecciona un periodo --</option>';
            for (var i = 0; i < Object.keys(data).length; i++) {
                html += '<option value="' + data[i].periodo + '">' + data[i].periodo + '</option>';
            }
        }
        $("#input_periodo").html(html);
    });
}
function ListarRango() {
    formatos = {
        "format": "MM/DD/YYYY",
        "separator": " - ",
        "applyLabel": "Buscar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "A",
        "customRangeLabel": "Determinado",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Ferbrero",
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
        ],
        "firstDay": 1
    }
    $('#fecha_transaccion').daterangepicker({ "locale": formatos}, function (start, end, label) {
        console.log(start, end)
        listar('dia', { "inicio": start.format('YYYY-MM-DD'), "fin": end.format('YYYY-MM-DD') });
    });
    $('#fecha_pago_realizado').daterangepicker({ "locale": formatos}, function (start, end, label) {
        console.log(start, end)
        listar('porFechaPago', { "inicio": start.format('YYYY-MM-DD'), "fin": end.format('YYYY-MM-DD') });
    });
}
function cambiarFiltro(filtro) {
    $(".filtros").hide();
    $("#" + filtro).show();
}
/* Función para listar los docentes que se encuentran activos */
function listar(tipo_busqueda, dato_busqueda) {
    $("#precarga").show();
    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    var f = new Date();
    var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tbllistado').DataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "dom": 'Bfrtip',//Definimos los elementos del control de tabla
        "buttons": [{
            "extend": 'excelHtml5',
            "text": '<i class="fa fa-file-excel"></i>',
            "titleAttr": 'Excel',
            "exportOptions": {
                "columns": ":visible",
            },
        }, {
            "extend": 'print',
            "text": '<i class="fas fa-print" ></i>',
            "messageTop": '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
            "title": 'Docentes',
            "titleAttr": 'Print'
            }, {
                "extend": 'colvis',
                "text": '<i class="fas fa-list" ></i>',
            },],
        "ajax": {
            "url": '../controlador/sofi_reporte_fecha_pago.php?op=listar',
            "type": "POST",
            "data": { "tipo_busqueda": tipo_busqueda, "dato_busqueda": dato_busqueda },
            "dataType": "json",
            "error": function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "search": { regex: true },
        "initComplete": function () {
            $("#precarga").hide();
            $(".dt-button-down-arrow").remove()
            $(".dt-button").remove()
        }
    });
}
function detalletransaccion(id_pago) {
    $.post("../controlador/sofi_reporte_fecha_pago.php?op=detalletransaccion", { id_pago: id_pago }, function (data, status) {
        data = JSON.parse(data);
        console.log(data);
        $("#modaldetalle").modal("show");
        $("#resultado").html("");
        $("#resultado").append(data);
    });
}
function activarBotonDt(boton) {
    $(boton).toggleClass("boton-datatable-inactivo");
}
init();