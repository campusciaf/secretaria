<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 23;
    $submenu = 2327;
    require 'header.php';
    if ($_SESSION['sofi_base_originacion'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Base Originación</span><br>
                                <span class="fs-16 f-montserrat-regular">Este es tú punto de partida para estructurar buenos análisis.</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 d-none segundo_tour" onclick='iniciarSegundoTour()'><i class="fa-solid fa-play"></i> Tour 2da parte</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="sofi_panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Reporte Por Fechas de Pago</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content-body contenido">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="row" id="tablaregistros">
                                <div class="col-sm-12 table-responsive">
                                    <table id="tabla_base_originacion" class="table table-hover search_cuota">
                                        <thead>
                                            <th>Nombre</th>
                                            <th>Tipo</th>
                                            <th>Documento</th>
                                            <th>Consecutivo</th>
                                            <th>Género</th>
                                            <th>Fecha Nacimiento</th>
                                            <th>Edad</th>
                                            <th>Estado Civil</th>
                                            <th>Estrato</th>
                                            <th># Hijos</th>
                                            <th>Nivel Educativo</th>
                                            <th>Ocupación</th>
                                            <th>Sector</th>
                                            <th>Antigüedad</th>
                                            <th>Ingresos</th>
                                            <th>Vivienda</th>
                                            <th>Ubicación</th>
                                            <th>Nacionalidad</th>
                                            <th>Personas a cargo</th>
                                            <th>Fecha aprobacion crédito</th>
                                            <th>Fecha Fin Crédito</th>
                                            <th>Valor</th>
                                            <th>Cuotas</th>
                                            <th>Programa</th>
                                            <th>Semestre</th>
                                            <th>Periodo</th>
                                        </thead>
                                        <tbody>
                                            <th colspan="11">
                                                <div class='jumbotron text-center bg-green' style="margin:0px !important">
                                                    <div class='jumbotron text-center bg-green' style="margin:0px !important">
                                                        <h3>Aquí aparecerán los datos.</h3>
                                                    </div>
                                                </div>
                                            </th>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script src="scripts/sofi_base_originacion.js?<?= date("Y-m-d-h-i-s") ?>"></script>