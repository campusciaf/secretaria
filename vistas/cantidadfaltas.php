<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.html");
} else {
    $menu = 10;
    $submenu = 1008;
    require 'header.php';
    if ($_SESSION['cantidadfaltas']) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Inasistencias</span><br>
                                <span class="fs-14 f-montserrat-regular">Vista que permite visualizar el comportamiento de las faltas en clase</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Inasistencias</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid px-4">
                <div id="chartContainer" style="height: 370px; width: 100%;" class="mb-4 col-12"></div>
                <div id="chartContainer1" style="height: 370px; width: 100%;" class="mb-4 col-12"></div>
                <div id="chartContainer2" style="height: 370px; width: 100%;" class="mb-4 col-12 "></div>
                <div class="row col-12">
                    <div class="col-12 pb-4 " id="escuelas"></div>
                    <div id="mostrardatos" class="col-lg-12 tono-3 pt-2">
                        <form id="formulario_tabla" method="POST">
                            <div class="row">
                                <div class="col-12 py-2">Consulta filtrada</div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-6">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select required class="form-control border-start-0 selectpicker" data-live-search="true" name="programa" id="programa" onChange="progra(this.value);">
                                                <option value="" disabled selected> - Programas - </option>
                                            </select>
                                            <label>Seleccionar programa</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col-xl-2 col-lg-4 col-md-4 col-6 dos">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select required class="form-control border-start-0 selectpicker" data-live-search="true" name="estado" id="estado">
                                                <option value="" selected disabled> - Faltas - </option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">≥ 4</option>
                                            </select>
                                            <label>Faltas</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <input type="hidden" name="c" class="ciclo">
                                <div class="col-xl-2 col-lg-4 col-md-4 col-6 dos">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select required class="form-control border-start-0" name="periodo" id="periodo"></select>
                                            <label>Periodo</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col-xl-2 col-lg-4 col-md-4 col-6 dos">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select required class="form-control border-start-0 " data-live-search="true" name="semestre" id="semestre"></select>
                                            <label>Semestre</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col-xl-2 col-lg-4 col-md-4 col-6 dos m-0 p-0">
                                    <input type="submit" value="Consultar" class="btn btn-success py-3" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- muestra la tabla -->
                    <div class="col-12 conte card p-4"></div>
                </div>
            </section>
        </div>
        <div class="modal fade" id="modalfaltas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Faltas</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="resultado_faltas"></div>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/cantidadfaltas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>