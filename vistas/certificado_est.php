<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $submenu = 3705;
    $menu = 38;
    require 'header.php';
    if ($_SESSION['gestion_servicio'] == 1) {
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Certificación de servicio social</span><br>
                        <span class="fs-16 f-montserrat-regular">Gestione los certificados de los estudiantes que cumplieron el servicio social</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i
                            class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión de certificados</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                <div class="row">
                    <div class="col-12 card">
                        <div class="row">
                            <div class="col-6 p-2 tono-3">
                                <div class="row align-items-center">
                                    <div class="pl-3">
                                        <span class="rounded bg-light-blue p-3 text-primary ">
                                            <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="col-10">
                                        <div class="col-5 fs-14 line-height-18">
                                            <span class="">Certificación</span> <br>
                                            <span class="text-semibold fs-20">Campus virtual</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 table-responsive p-2" id="listadoregistros">
                                <table id="tblistaofertalaboral" class="table" style="width: 100%;">
                                    
                                    <thead>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Celular</th>
                                        <th>Correo</th>
                                        <th>Certificado servicio social</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
 <script src="scripts/certificado_est.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
                            <?php
}
ob_end_flush();