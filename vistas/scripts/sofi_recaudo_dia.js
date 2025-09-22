// JavaScript Document
$(document).ready(init);
//primera funcion que se ejecut cuando el documento esta listo 
function init() {
    fecha = moment(); //Get the current date
    fecha = fecha.format("YYYY-MM-DD");
    listar(fecha, fecha);
    valorrecaudado(fecha, fecha);
    ListarRango();
}
function ListarRango() {
    $('#fecha_transaccion').daterangepicker({
        "locale": {
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
    }, function (start, end, label) {
        const dia = { "inicio": start.format('YYYY-MM-DD'), "fin": end.format('YYYY-MM-DD') }
        listar(dia.inicio, dia.fin);
        valorrecaudado(dia.inicio, dia.fin);
    });
}
// Función Listar
function listar(fechaini, fechafin) {
    var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    var diasSemana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
    var f = new Date();
    var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true, // Activamos el procesamiento del datatables
        "aServerSide": true, // Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', // Definimos los elementos del control de tabla
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
            }
        ],
        "ajax": {
            url: '../controlador/sofi_recaudo_dia.php?op=listar',
            type: "POST", // Cambia el método a POST
            data: {
                fechaini: fechaini, // Envía fechaini
                fechafin: fechafin  // Envía fechafin
            },
            dataType: "json",
            error: function (e) {
                // console.log(e.responseText);	
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, // Paginación
        "order": [[0, "asc"]],
        'initComplete': function (settings, json) {
            $("#precarga").hide();
        }
    });
}
function valorrecaudado(fechaini, fechafin) {
    $.post("../controlador/sofi_recaudo_dia.php?op=valorrecaudo", { fechaini: fechaini, fechafin: fechafin }, function (datos) {
        var r = JSON.parse(datos);
        var valor = r.valor;
        // Asegúrate de que r.valor es un número
        if (typeof valor !== 'number') {
            // Si es una cadena, intenta convertirla a un número
            valor = parseFloat(valor);
        }
        // Verificamos que valor sea un número válido
        if (!isNaN(valor)) {
            // Formatear el valor como pesos colombianos
            var valorFormateado = valor.toLocaleString('es-CO', { style: 'currency', currency: 'COP' });
            // Asignar el valor formateado al HTML
            $("#valorrecaudo").html(valorFormateado);
        } else {
            // console.error("El valor no es un número válido.");
            $("#valorrecaudo").html("0,00");
        }
    });
}
