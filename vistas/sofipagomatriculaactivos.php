<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 23;
    $submenu = 2318;
    require 'header.php';
    if ($_SESSION['sofipagomatriculaactivos'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Pagos Activos</span><br>
                                <span class="fs-16 f-montserrat-regular"> Descubra el medio de pago de los estudiantes</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Medios de pago</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="row " id="tablaregistros">
                                <div class="col-xl-3 col-lg-4 col-md-4 col-8 m-0 p-0">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required="" class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo" id="periodo"></select>
                                            <label>Periodo Activo</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col-md-3 col-4 m-0 p-0">
                                    <button type="button" class="btn btn-success buscar_estudiantes p-3"> <i class="fas fa-search"></i> Buscar</button>
                                </div>
                                <div class="col-12 table-responsive">
                                    <table id="tabla_financiados" class="table table-hover table-nowarp search_cuota">
                                        <thead>
                                            <th>Cédula</th>
                                            <th>Nombre Completo</th>
                                            <th>Correo</th>
                                            <th>Programa</th>
                                            <th>Jornada</th>
                                            <th>Semestre</th>
                                            <th>Contado</th>
                                            <th>aprobo</th>
                                            <th>crédito</th>
                                            <th>Primer curso</th>
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
    <script src="scripts/sofipagomatriculaactivos.js?<?= date("Y-m-d H:i:s") ?>"></script>
<?php
}
ob_end_flush();
?>