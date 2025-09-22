<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 15;
    $submenu = 1513;
    require 'header.php';
    if ($_SESSION['abrir_reporte_influencer'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Probabilidad de Riesgo</span><br>
                                <span class="fs-14 f-montserrat-regular"></span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                        </div>
                        <div class="col-12 migas mb-0">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Probabilidad de Riesgo</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid" style="padding-top: 0px;">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 pt-3 pl-3 tono-3 p-4">
                        <div class="row align-items-center pt-2">
                            <div class="pl-4 col-auto">
                                <span class="rounded bg-light-blue p-3 text-primary">
                                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fs-14 line-height-18">
                                    <span class="">Probabilidad</span> <br>
                                    <span class="text-semibold fs-16 titulo-2 fs-16 line-height-16" id="dato_periodo"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-xl-3 col-lg-4 col-md-4 col-6 pt-3 tono-3" id="seleccionar_periodo">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo_probabilidad" id="periodo_probabilidad"></select>
                                <label>Buscar Periodo</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div> -->
                    <div class="card col-12 p-4">
                        <div class="row mb-3 justify-content-center">
                            <div class="col-auto">
                                <button class="btn btn-nivel btn-outline-secondary active mx-1" data-nivel="Todos" style="min-width:110px;font-weight:600;" onclick="MostrarResultado(this)"> <i class="fas fa-list"></i> Todos
                                </button>
                                <button class="btn btn-nivel btn-outline-danger mx-1" data-nivel="80" style="min-width:110px;font-weight:600;" onclick="MostrarResultado(this)"> <i class="fas fa-fire"></i>Entre 80% y 100%
                                </button>
                                <button class="btn btn-nivel btn-outline-warning mx-1" data-nivel="60" style="min-width:110px;font-weight:600;" onclick="MostrarResultado(this)"> <i class="fas fa-exclamation-triangle"></i> Entre 60% y 20%
                                </button>
                                <button class="btn btn-nivel btn-outline-success mx-1" data-nivel="20" style="min-width:110px;font-weight:600;" onclick="MostrarResultado(this)"> <i class="fas fa-smile"></i>Entre 0% y 20%
                                </button>
                            </div>
                        </div>
                        <div class="row card card-primary" style="padding: 2% 1%">
                            <div class="col-lg-12 table-responsive">
                                <table id="tbllistaprobabilidad" class="table compact table-striped table-condensed table-hover">
                                    <thead>
                                        <th> Cedula </th>
                                        <th> Nombre Estudiante </th>
                                        <th> Porcentaje </th>
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
}
ob_end_flush();
?>

<script src="scripts/probabilidad_de_riesgo.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>