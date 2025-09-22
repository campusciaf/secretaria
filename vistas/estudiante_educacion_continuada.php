<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 11;
    $seccion = "Educación Continuada";
    require 'header_estudiante.php';
    if (!empty($_SESSION['id_usuario'])) {
?>
        <link rel="stylesheet" href="../public/css/pure-tabs.css">
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h2 class="m-0 line-height-16">
                                <br>
                                <span class="fs-16 f-montserrat-regular pl-2">Los cursos y diplomados producen mayores ingresos
                                </span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid">
                <div class="row " id="listadoCursosEducacionContinuada">

                </div>
            </section>
        </div>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer_estudiante.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/estudiante_educacion_continuada.js"></script>