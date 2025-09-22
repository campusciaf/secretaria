let fechaInicio = moment().startOf('month');
let fechaFin = moment();

$(document).ready(function () {
    inicializarRangoFechas();
    cargarListadoGeneral();
    puntos_totales();
    puntos_totales_docente();
    puntos_totales_colaborador();
});

function inicializarRangoFechas() {
    if ($('#btnRangoFecha').length > 0 && $('#btnRangoFecha')[0]._flatpickr) {
        return;
    }


    $('#contenedor_botones_abajo').html(`
        <div data-bs-toggle="tooltip" title="Selecciona un rango de fechas">
            <input 
                id="btnRangoFecha" 
                class="btn btn-primary btn-sm text-center" 
                style="width: 320px; max-width: 100%;" 
            />
        </div>
    `);

   
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });

    // Flatpickr
    let primeraFecha = null;
    flatpickr("#btnRangoFecha", {
        mode: "range",
        dateFormat: "d/m/Y",
        locale: "es",
        maxDate: "today",
        disableMobile: true,
        defaultDate: [fechaInicio.toDate(), fechaFin.toDate()],
        onReady: function (selectedDates, dateStr, instance) {
            // Mostrar rango inicial en el "input-botón"
            $('#btnRangoFecha').val(`Del ${fechaInicio.format("DD/MM/YYYY")} al ${fechaFin.format("DD/MM/YYYY")}`);
        },
        onChange: function (selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                fechaInicio = moment(selectedDates[0]);
                fechaFin = moment(selectedDates[1]);
                $('#btnRangoFecha').val(`Del ${fechaInicio.format("DD/MM/YYYY")} al ${fechaFin.format("DD/MM/YYYY")}`);
                cargarListadoGeneral();
                puntos_totales();
                puntos_totales_docente();
                puntos_totales_colaborador();
            }
        },
        onOpen: () => { primeraFecha = null; }
    });
}

function cargarListadoGeneral(categoria = '') {
    // Mostrar la categoría seleccionada
    if (categoria) {
        $('#categoriaSeleccionada').text('Categoría: ' + categoria);
    } else {
        $('#categoriaSeleccionada').text('Todas las categorías');
    }

    $.post("../controlador/puntos_reporte.php?op=listado_general_puntos", {
        categoria: categoria,
        fecha_inicio: fechaInicio.format('YYYY-MM-DD'),
        fecha_fin: fechaFin.format('YYYY-MM-DD')
    }, function (data) {
        let personas = [];
        try {
            let jsonString = (typeof data === 'string') ? data : JSON.stringify(data);
            if (jsonString && jsonString.trim().startsWith('[')) {
                personas = JSON.parse(jsonString);
            } else {
                personas = [];
            }
        } catch (e) {
            console.error("Error al parsear JSON:", e, data);
            personas = [];
        }

        // Destruir DataTable si ya existe
        if ($.fn.DataTable.isDataTable("#tablaPuntosGeneral")) {
            $('#tablaPuntosGeneral').DataTable().clear().destroy();
        }

        // Llenar tabla con datos
        const tbody = $("#tablaPuntosGeneral tbody").empty();
        if (!personas || personas.length === 0) {
            tbody.append('<tr><td colspan="7" class="text-center">No hay datos</td></tr>');
        } else {
            personas.forEach(p => {
                tbody.append(`
                    <tr>
                        <td>${p.identificacion}</td>
                        <td>${p.nombre}</td>
                        <td>${p.apellido}</td>
                        <td>${p.cantidad_puntos}</td>
                        <td>${p.fecha}</td>
                        <td>${p.tipo}</td>
                        <td>${p.categoria}</td>
                    </tr>
                `);
            });
        }

       
        $('#tablaPuntosGeneral').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    title: 'Listado General de Puntos',
                    titleAttr: 'Imprimir'
                }
            ],
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            }
        });
    });
}

function puntos_totales() {
    $.post("../controlador/puntos_reporte.php?op=puntos_totales", {
        fecha_inicio: fechaInicio.format('YYYY-MM-DD'),
        fecha_fin: fechaFin.format('YYYY-MM-DD')
    }, function (e) {
        const r = JSON.parse(e);
        $("#puntos_totales_estudiante").html(r.total_puntos);
    });
}

function puntos_totales_docente() {
    $.post("../controlador/puntos_reporte.php?op=puntos_totales_docente", {
        fecha_inicio: fechaInicio.format('YYYY-MM-DD'),
        fecha_fin: fechaFin.format('YYYY-MM-DD')
    }, function (e) {
        const r = JSON.parse(e);
        $("#puntos_totales_docente").html(r.total_puntos);
    });
}

function puntos_totales_colaborador() {
    $.post("../controlador/puntos_reporte.php?op=puntos_totales_colaborador", {
        fecha_inicio: fechaInicio.format('YYYY-MM-DD'),
        fecha_fin: fechaFin.format('YYYY-MM-DD')
    }, function (e) {
        const r = JSON.parse(e);
        $("#puntos_totales_colaboradores").html(r.total_puntos);
    });
}