<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 7;
    require 'header_docente.php';
    if (!empty($_SESSION['id_usuario'])) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Carnet</span><br>
                                <span class="fs-14 f-montserrat-regular">Un carnet sin fecha de vencimiento</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_docente.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Carnet</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="container-fluid px-4">
                <!-- <div class="row "> -->
                <div class="col-xl-12 conte mx-auto" style="padding: 0px;"></div>
                <!-- </div> -->
            </section>

        </div>
        <!--Fin-Contenido-->


    <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer_docente.php';
    ?>

    <script type="text/javascript" src="scripts/carnetdocente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>


</body>

</html>