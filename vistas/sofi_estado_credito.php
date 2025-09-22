<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 23;
    $submenu = 2312;
    require 'header.php';
    if ($_SESSION['sofi_consulta_credito'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <link rel="stylesheet" href="../public/css/morris.css">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Crèditos Activos</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php"> SOFI </a></li>
                                <li class="breadcrumb-item active"> Créditos Activos </li>
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
                                    <button type="button" class="btn btn-success buscar_estudiantes_estado_activo"> <i class="fas fa-search"></i> Buscar</button>
                                </div>
                                <div class="col-12">
                                    <table id="tabla_financiados" class="table table-hover table-nowarp search_cuota table-responsive">
                                        <thead>
                                            <th>Cédula</th>
                                            <th>Consecutivo</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Celular</th>
                                            <th>Programa</th>
                                            <th>Semestre</th>
                                            <th>Jornada</th>
                                            <th>Cuota</th>
                                            <th>Fecha</th>
                                            <th>Pagada</th>
                                            <th>Cuota</th>
                                            <th>Pagado</th>
                                            <th>Periodo</th>
                                            <th>Motivo</th>
                                            <th>Atraso</th>
                                            <th>Estado</th>
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
    ?>
    <script src="scripts/sofi_estado_credito.js"></script>
<?php
}
ob_end_flush();
?>