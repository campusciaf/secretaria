<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 10;
    $submenu = 1024;
    require 'header.php';
    if ($_SESSION['consulta_promedio'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Consulta Mejor Promedio</span><br>
                                <span class="fs-14 f-montserrat-regular">Visualiza los estudiantes con los promedios académicos más altos del periodo actual.</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Mejor Promedio</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid px-4">
                <div class="card card-primary" style="padding: 2% 1%">
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-12 col-md-4 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="programa" id="programa">
                                        <option value="todos1">Todos</option>
                                        <!-- Aquí puedes agregar más opciones dinámicamente si es necesario -->
                                    </select>
                                    <label>Seleccionar Programa</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-4 col-6" id="t-jornada">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select value="" required name="jornada_promedio" id="jornada_promedio" class="form-control border-start-0 selectpicker" data-live-search="true"></select>
                                    <label>Jornada</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-12 col-md-4 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="d-flex align-items-stretch">
                                    <div class="form-floating flex-grow-1 me-2">
                                        <select id="periodo" required class="form-control border-start-0 selectpicker h-100" data-live-search="true" name="periodo">
                                            <option selected disabled>Periodo...</option>
                                        </select>
                                        <label for="periodo">Seleccionar Periodo</label>
                                    </div>
                                    <button type="button" onclick="consultaPromedios()" class="btn btn-success w-auto h-100">
                                        Consultar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="card p-4" id="div_promedio">
                            <div id="titulo"></div>
                            <table id="tld_promedio" class="table table-hover " style="width:100%">
                                <thead>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Jornada</th>
                                    <th># Materias matriculadas</th>
                                    <th>Semestre</th>
                                    <th>Promedio</th>
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
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/consulta_promedio.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>