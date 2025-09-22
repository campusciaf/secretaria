<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 23;
    $submenu = 2308;
    require 'header.php';
    if ($_SESSION['sofi_consulta_credito'] == 1) {
?>
        <!--Contenido Content Wrapper. Contains page content -->
        <link rel="stylesheet" href="../public/css/morris.css">
        <div id="precargar"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Créditos Por Semestre</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php"> SOFI </a></li>
                                <li class="breadcrumb-item active"> Creditos X Semestre </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="row">
                                <div class="col-md-9">
                                    <select class="form-control" name="periodo" id="periodo">
                                    </select>
                                    <br>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-success buscar_estudiantes"> <i class="fas fa-search"></i> Buscar</button>
                                </div>
                                <div class="col-12">
                                    <table id="tabla_financiados" class="table table-hover table-nowarp search_cuota table-responsive">
                                        <thead>
                                            <th>Cédula</th>
                                            <th>Consecutivo</th>
                                            <th>Nombre</th>
                                            <th>Programa</th>
                                            <th>Semestre</th>
                                            <th>Jornada</th>
                                            <th>Credito</th>
                                            <th>Faltante</th>
                                            <th>Total Cuotas</th>
                                            <th>Cuotas Atrasadas</th>
                                            <th>Periodo</th>
                                            <th>Motivo</th>
                                            <th>Atraso</th>
                                            <th>Estado</th>
                                            <th>Ultimo Pago</th>
                                            <th>Finalizado</th>
                                        </thead>
                                        <tbody>
                                            <!-- Datos Impresos de la base de datos -->
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
<script src="scripts/sofi_consulta_creditos.js?<?= date("Y-m-d H:i:s") ?>"></script>