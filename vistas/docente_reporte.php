<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 6;
    $submenu = 608;
    require 'header.php';
    if ($_SESSION['docente_reporte'] == 1) {
?>


        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Reporte Docente</span><br>
                                <span class="fs-16 f-montserrat-regular">Reporte Docente</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Reporte Docente</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="row">
                    <div class="col-xl-9 col-lg-8 col-md-8 col-6 pt-3 pl-3 tono-3" id="ocultarpanelanio">
                        <div class="row align-items-center pt-2">
                            <div class="pl-4 col-auto">
                                <span class="rounded bg-light-blue p-3 text-primary">
                                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                </span>
                            </div>
                            <!-- <div class="col">
                                <div class="fs-14 line-height-18">
                                    <span class="">Reporte</span> <br>
                                    <span class="text-semibold fs-16 titulo-2 fs-16 line-height-16" id="dato_periodo"></span>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-4 col-6 pt-3 tono-3" id="seleccionar_periodo">
                        <form name="formulario" id="formulario" method="POST">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select value="" required onChange="buscarDatos()" class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo" id="periodo"></select>
                                    <label>Buscar Periodo</label>
                                </div>
                            </div>
                        </form>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>

                    <!-- <div class="panel-body" id="listadoregistros">
                        <table id="tbllistado" class="table table-hover" style="width:100%">
                            <thead>
                                <th style="height:50px; overflow:hidden">Foto</th>
                                <th>Cedula</th>
                                <th>Nombre</th>
                                <th>Contacto</th>
                                <th>Correo</th>
                                <th>Tipo de Contrato</th>
                                <th>Genero</th>
                                <th>Horas</th>
                                <th>Bloque</th>
                                <th>Total Grupos</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div> -->


                    <div class="card col-12 p-4" id="listadoregistros">
                        <div class="row card card-primary" style="padding: 2% 1%">
                            <div class="col-lg-12 table-responsive">
                                <table id="tbllistado" class="table compact table-striped table-condensed table-hover">
                                    <thead>
                                        <th style="height:50px; overflow:hidden">Foto</th>
                                        <th>Cedula</th>
                                        <th>Nombre</th>
                                        <th>Contacto</th>
                                        <th>Correo</th>
                                        <th>Tipo de Contrato</th>
                                        <th>Genero</th>
                                        <th>Horas</th>
                                        <th>Bloque</th>
                                        <th>Total Grupos</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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

    <script type="text/javascript" src="scripts/docente_reporte.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>