<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 11;
    require 'header_docente.php';
?>
    <div id="precarga" class="precarga"></div>
    <div class="content-wrapper ">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-xl-6 col-9">
                        <h2 class="m-0 line-height-16">
                            <span class="titulo-2 fs-18 text-semibold">Configurar cuenta</span><br>
                            <span class="fs-14 f-montserrat-regular">Vive la experiencia al interactuar con tu página web</span>
                        </h2>
                    </div>
                    <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                        <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                    </div>
                    <div class="col-12 migas">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="panel_docente.php">Inicio</a></li>
                            <li class="breadcrumb-item active">COnfigurar cuenta</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content mt-2">

            <div class="row ">

                <div class="col-12 text-center pt-4">
                    <h3 class="titulo-3 text-bold fs-24">Optimiza <span class="text-gradient">tu experiencia visual</span>&nbsp;con nuestro <span class="text-gradient">modo oscuro</span></h3>
                    <p class="lead text-secondary">¡tu pantalla, tus reglas!</p>
                </div>



                <div class="col-12 modo d-flex align-content-center justify-content-center flex-wrap pb-4">
                    <div class="row">

                        <div class="col-12 text-center">
                            <div class="switch">
                                <input id="switch" class="switch__input" name="switch" type="checkbox" onclick="cambioTema()">
                                <label class="switch__label" for="switch"></label>
                            </div>
                        </div>
                        <div class="col-6 text-right ">Light</div>
                        <div class="col-6 border-left">Dark</div>

                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="mostrar-uno"></div>
                </div>

            </div>
        </section>
    </div>






    <?php

    require 'footer_docente.php';
    ?>
    <script src="scripts/perdocente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
ob_end_flush();
?>