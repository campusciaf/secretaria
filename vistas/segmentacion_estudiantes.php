<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.html");
} else {
    $menu = 29;
    $submenu = 298;
    require 'header.php';

    if ($_SESSION['segmentacion_estudiantes'] == 1) {
?>

        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Segmentación Estudiantil</span><br>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Segmentación Estudiantil</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="card card-primary" style="padding: 2% 1% 0% 1%">
                    <div class="row">
                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                            <div class="form-group position-relative check-valid">
                                <div class="form-floating">
                                    <select name="periodo" id="periodo" class="form-control border-start-0" onchange="buscar()"></select>
                                    <label>Periodo académico seleccionar</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>
                        <div class="col-xl-4 col-lg-3 col-md-3 col-6">
                            <div class="form-group position-relative check-valid">
                                <div class="form-floating">
                                    <select name="programa_ac" id="programa_ac" class="form-control border-start-0" onchange="buscar()"></select>
                                    <label>Progama académico</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>
                    </div>

                    <div class="row col-12" id="edadpromedioprograma"></div>
                    <div class="row col-12" id="mostrar_grafica"></div>
            </section>


            <!-- <section>
                <div class="col-xl-12" style="padding: 2% 1%">
                </div>
            </section> -->
        </div>
    <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>

    <script type="text/javascript" src="scripts/segmentacion_estudiantes.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>
<script>

</script>