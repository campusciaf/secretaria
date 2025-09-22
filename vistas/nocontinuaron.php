<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 31;
    $submenu = 3105;
    require 'header.php';

    if ($_SESSION['nocontinuaron'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Cifras</span><br>
                                <span class="fs-16 f-montserrat-regular">Configure los datos personales del estudiante</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión panel</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="card card-primary" style="padding: 2% 1%">
                    <div class="col-12">
                        <p>Todos los que se graduaron del nivel 1, pero no continuaron con el nivel 2</p>
                    </div>
                    <div class="row">
                        <div class="col-12" id="escuelas"></div>
                        <div class="col-12" id="resultado"></div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-12" id="resultado">
                            <div class="col-12 tono-3 mt-2 px-4 py-2 ">
                                <p class="titulo-3 m-0">Escuela Consultada</p>
                            </div>
                            <div class="tono-3 m-0 p-1" style="border-bottom: 1px solid #dc3545"></div>
                            <div class="col-12 p-4 table-responsive card" id="listadoregistros">
                                   <table class="table table-hover" style="width:100%"> -->
                                <!-- <table id="tbllistado"  class="table table-hover" style="width:100%">
                                    <thead>
                                        <th>ID est. act</th>
                                        <th>identificación</th>
                                        <th>Nombre estudiante</th>
                                        <th>Programa</th>
                                        <th>Jornada</th>
                                        <th>Ingreso</th>
                                        <th>Activo</th>
                                        <th>Celular</th>
                                        <th>Correo</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>  -->
                </div>
            </section>
        </div>
    <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>

    <script type="text/javascript" src="scripts/nocontinuaron.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
ob_end_flush();
?>