<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.html");
} else {
    $menu = 43;
    $submenu = 4305;
    require 'header.php';
    if ($_SESSION['puntos']) {
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 mx-0">
                <div class="col-xl-6 col-9">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Reporte de Puntos</span><br>
                        <span class="fs-14 f-montserrat-regular">Reporte general de puntos otorgados</span>
                    </h2>
                </div>



                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i
                            class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas mb-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Reporte Puntos</li>
                    </ol>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div
                                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                <div>
                                    <h4 class="mb-0">Listado General de Puntos</h4>
                                    <span id="categoriaSeleccionada" class="fs-14"></span>
                                </div>
                                <div id="contenedor_botones_abajo" class="mt-2 mt-md-0"></div>
                            </div>


                            <div class="row mt-3 g-3">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center p-3 rounded shadow-sm  h-100">
                                        <div
                                            class="avatar avatar-50 rounded bg-light-yellow d-flex justify-content-center align-items-center">
                                            <i class="fa-solid fa-coins text-warning fa-2x"></i>
                                        </div>
                                        <div class="col ms-3">
                                            <p class="small mb-0">Total de puntos otorgados estudiantes</p>
                                            <h4 class="fw-medium text-secondary mb-0">
                                                <span id="puntos_totales_estudiante"></span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="d-flex align-items-center p-3  rounded shadow-sm  h-100">
                                        <div
                                            class="avatar avatar-50 rounded bg-light-yellow d-flex justify-content-center align-items-center">
                                            <i class="fa-solid fa-coins text-warning fa-2x"></i>
                                        </div>
                                        <div class="col ms-3">
                                            <p class="small mb-0">Total de puntos otorgados docentes</p>
                                            <h4 class="fw-medium text-secondary mb-0">
                                                <span id="puntos_totales_docente"></span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="d-flex align-items-center p-3 rounded shadow-sm  h-100">
                                        <div
                                            class="avatar avatar-50 rounded bg-light-yellow d-flex justify-content-center align-items-center">
                                            <i class="fa-solid fa-coins text-warning fa-2x"></i>
                                        </div>
                                        <div class="col ms-3">
                                            <p class="small mb-0">Total de puntos otorgados colaboradores</p>
                                            <h4 class="fw-medium text-secondary mb-0">
                                                <span id="puntos_totales_colaboradores"></span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tablaPuntosGeneral" class="table">
                                    <thead>
                                        <tr>
                                            <th>Identificación</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Cantidad Puntos</th>
                                            <th>Fecha</th>
                                            <th>Rol</th>
                                            <th>Categoría</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





            <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
            <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
            <script type="text/javascript" src="scripts/puntos_reporte.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>