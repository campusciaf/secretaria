let chart;
let categoriaActual = '';
let fechaInicio = moment().subtract(15, 'days');
let fechaFin = moment();

$(document).ready(() => {
    inicializarRangoFechas();
    actualizarTodo();
});


function actualizarTodo() {
    cargarCategorias();
    cargarCategoriasSuperiores();
    puntos_totales();
    graficoPuntos(categoriaActual);
}
if (!$('#contenedor_botones_abajo').length) {
    $('<div id="contenedor_botones_abajo" class="d-flex flex-wrap align-items-center gap-2 mt-3 mb-3"></div>')
        .insertBefore($('#categorias_container')); // ahora queda antes de las categorías
}

// --- Función para rango de fechas ---
function inicializarRangoFechas() {
    if ($('#btnRangoFecha').length > 0 && $('#btnRangoFecha')[0]._flatpickr) {
        return;
    }

    $('#contenedor_botones_abajo').append(`
        <div data-bs-toggle="tooltip" title="Selecciona un rango de fechas (máximo 30 días)">
            <button id="btnRangoFecha" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-2">
                <i class="fas fa-calendar-alt"></i>
                <span id="textoRango">Del ${fechaInicio.format("DD/MM/YYYY")} al ${fechaFin.format("DD/MM/YYYY")}</span>
            </button>
        </div>
    `);

    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });

    let primeraFecha = null;
    flatpickr("#btnRangoFecha", {
        mode: "range",
        dateFormat: "d/m/Y",
        locale: "es",
        maxDate: "today",
        disableMobile: true,
        position: "below center",
        defaultDate: [moment(fechaInicio).toDate(), moment(fechaFin).toDate()],
        onChange: function (selectedDates, dateStr, instance) {
            if (selectedDates.length === 1) {
                primeraFecha = selectedDates[0];
                instance.set('maxDate', moment(primeraFecha).add(30, 'days').toDate());
            } else if (selectedDates.length === 2) {
                const dias = moment(selectedDates[1]).diff(moment(selectedDates[0]), 'days');
                if (dias > 30) {
                    instance.clear();
                    primeraFecha = null;
                    $('#textoRango').text("Máx. 30 días");
                } else {
                    fechaInicio = moment(selectedDates[0]);
                    fechaFin = moment(selectedDates[1]);
                    $('#textoRango').text(`Del ${fechaInicio.format("DD/MM/YYYY")} al ${fechaFin.format("DD/MM/YYYY")}`);
                    actualizarTodo();
                }
                instance.set('maxDate', "today");
            }
        },
        onOpen: () => { primeraFecha = null; }
    });
}



function cargarCategoriasSuperiores() { 
    $.post("../controlador/puntos_docente.php?op=totales_generales", {
        fecha_inicio: formatFecha(fechaInicio),
        fecha_fin: formatFecha(fechaFin)
    }, function (data) {
        let categorias = JSON.parse(data);
        let contenedor = $("#categorias_superiores").empty();

        categorias.forEach(cat => {
            contenedor.append(`
                <div class="col-6 col-md-4 col-lg-3">
                    <button class="btn btn-sm bg-purple text-white w-100 d-flex justify-content-between align-items-center px-2 py-1 mb-2" style="font-size: 13px;">
                        <span>${cat.punto_nombre}</span>
                        <span class="badge bg-warning text-dark">${cat.total}</span>
                    </button>
                </div>
            `);
        });
    });
}


function cargarCategorias() {
    $.post("../controlador/puntos_docente.php?op=listar_categorias", {
        fecha_inicio: formatFecha(fechaInicio),
        fecha_fin: formatFecha(fechaFin)
    }, function (data) {
        const res = JSON.parse(data);
        const { categorias, total_general } = res;
        const contenedor = $("#categorias_container").empty();

        contenedor.append(`
            <div class="col-auto mb-3 me-2">
                <button class="btn btn-sm btn-secondary position-relative px-4 py-2" onclick="graficoPuntos('')">
                    Todos
                    <span class="badge bg-info position-absolute top-0 start-100 translate-middle">
                        ${total_general}
                    </span>
                </button>
            </div>
        `);

        categorias.forEach(cat => {
            const nombre = cat.nombre.replace(/'/g, "\\'");
            contenedor.append(`
                <div class="col-auto mb-3 me-2">
                    <button class="btn btn-sm bg-purple text-white position-relative px-4 py-2"
                            onclick="graficoPuntos('${nombre}')">
                        ${cat.nombre}
                        <span class="badge bg-warning position-absolute top-0 start-100 translate-middle">
                            ${cat.total}
                        </span>
                    </button>
                </div>
            `);
        });

        inicializarRangoFechas(); 
    });
}

function graficoPuntos(categoria) { 
    categoriaActual = categoria;

    $("#categorias_container button").removeClass("bg-success font-weight-bold border border-success")
        .addClass("bg-purple text-white")
        .css({ fontWeight: "normal", border: "none" });

    $("#categorias_container button").each(function () {
        let texto = this.innerText.trim().split('\n')[0].toLowerCase();
        let categoriaComparar = categoria.trim().toLowerCase();
        if ((categoriaComparar === '' && texto.includes("todos")) || texto === categoriaComparar) {
            $(this).removeClass("bg-purple")
                .addClass("bg-success font-weight-bold border border-success")
                .css({ color: "#fff" });
        }
    });

    $.post("../controlador/puntos_docente.php?op=grafico_puntos", {
        categoria,
        fecha_inicio: formatFecha(fechaInicio),
        fecha_fin: formatFecha(fechaFin)
    }, function (data) {
        let res = JSON.parse(data);
        let ctx = document.getElementById("canvas_puntos").getContext("2d");

        if (chart) chart.destroy();
        chart = new Chart(ctx, {
            type: "line",
            data: {
                labels: res.fechas,
                datasets: [{
                    label: categoria ? `Puntos otorgados - ${categoria}` : "Puntos otorgados (general)",
                    data: res.puntos,
                    borderColor: "rgb(75, 192, 192)",
                    fill: false,
                    tension: 0.3,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: { responsive: true }
        });

        const textoBtn = categoria ? `Ver listado de ${categoria}` : "Ver listado general";

        if (!$("#verListadoBtn").length) {
            $('#contenedor_botones_abajo').append(`
                <button class="btn btn-outline-primary btn-sm" id="verListadoBtn">${textoBtn}</button>
            `);
        } else {
            $("#verListadoBtn").text(textoBtn);
        }

        $("#verListadoBtn").off("click").on("click", () => {
            cargarListadoCategoria(categoria);
        });
    });
}

function cargarListadoCategoria(categoria) {
    $.post("../controlador/puntos_docente.php?op=listado_personas_categoria", {
        categoria: categoria,
        fecha_inicio: formatFecha(fechaInicio),
        fecha_fin: formatFecha(fechaFin)
    }, function (data) {
        const personas = JSON.parse(data);

        // Destruir DataTable si ya existe
        if ($.fn.DataTable.isDataTable("#tablaListado")) {
            $('#tablaListado').DataTable().clear().destroy();
        }

        // Llenar tabla con datos
        const tbody = $("#tablaListado tbody").empty();
        if (personas.length === 0) {
            tbody.append(`<tr><td colspan="4" class="text-center">No hay datos</td></tr>`);
        } else {
            personas.forEach(p => {
                const nombreCompleto = `${p.usuario_nombre} ${p.usuario_nombre_2 ?? ''} ${p.usuario_apellido} ${p.usuario_apellido_2 ?? ''}`;
                tbody.append(`
                    <tr>
                        <td>${p.usuario_identificacion}</td>
                        <td>${nombreCompleto}</td>
                        <td>${p.punto_fecha}</td>
                        <td>${p.puntos_cantidad}</td>
                    </tr>
                `);
            });
        }

        // Fecha de reporte
        var meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
        var diasSemana = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
        var f=new Date();
        var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

        // Inicializar DataTable con botones
        $('#tablaListado').DataTable({
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
                    messageTop: '<div style="width:50%;float:left"><b>Reporte de categoría:</b> '+categoria+' <br><b>Fecha Reporte:</b> '+fecha_hoy+'</div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Listado de Personas',
                    titleAttr: 'Imprimir'
                }
            ],
            destroy: true,  
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            }
        });

        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('modalListado'));
        modal.show();
    });
}

function puntos_totales() {
    $.post("../controlador/puntos_docente.php?op=puntos_totales", {
        fecha_inicio: formatFecha(fechaInicio),
        fecha_fin: formatFecha(fechaFin)
    }, function (e) {
        const r = JSON.parse(e);
        $("#puntos_totales").html(r.total_puntos);
    });
}

function formatFecha(date) {
    return date.toISOString().slice(0, 10);
}

 function aplicarScrollEnMovil() {
    if (window.innerWidth < 768) {
      const contenedor1 = document.getElementById("categorias_superiores");
      const contenedor2 = document.getElementById("categorias_container");

      if (contenedor1) {
        contenedor1.classList.remove("flex-wrap");
        contenedor1.classList.add("overflow-auto", "flex-nowrap");
      }

      if (contenedor2) {
        contenedor2.classList.remove("row");
        contenedor2.classList.add("d-flex", "overflow-auto", "flex-nowrap");
      }
    }
  }

  aplicarScrollEnMovil();
  window.addEventListener("resize", aplicarScrollEnMovil);