<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 31;
    $submenu = 3106;
    require 'header.php';

    if ($_SESSION['reingresogeneral'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Cifras</span><br>
                                <span class="fs-16 f-montserrat-regular">Estudiantes que no continuaron con el programa</span>
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
                    </div>
                    <div class="row">
                        <div class="col-12" id="escuelas"></div>
                        <div class="col-12" id="resultado"></div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive p-4" id="listadoregistros">
                            <table id="tbllistado" class="table" style="width: 100%;">
                                <thead>
                                    <th>Acciones</th>
                                    <th>identificación</th>
                                    <th>Nombre completo</th>
                                    <th>Programa técnico</th>
                                    <th>Estado</th>
                                    <th>Periodo Ingreso</th>
                                    <th>Periodo activo</th>
                                    <th>Programa tecnológico</th>
                                    <th>Estado</th>
                                    <th>Periodo Ingreso</th>
                                    <th>Periodo activo</th>
                                    <th>Programa profesional</th>
                                    <th>Estado</th>
                                    <th>Periodo Ingreso</th>
                                    <th>Periodo activo</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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

    <script type="text/javascript" src="scripts/reingresogeneral.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
ob_end_flush();
?>