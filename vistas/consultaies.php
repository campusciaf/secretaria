<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 10;
    $submenu = 1022;
    require 'header.php';
    if ($_SESSION['consultaies'] == 1) {
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Consulta IES</span><br>
                        <span class="fs-14 f-montserrat-regular">Módulo que permite realizar consultas sobre estudiantes
                            IES</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i
                            class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Consulta IES</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="container-fluid px-4">
        <div class="row">
            <div class="col-md-12">
                <form action="#" method="post" class="row" id="form_consulta_ies">
                    <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <select value="" required class="form-control border-start-0 selectpicker"
                                    data-live-search="true" name="jornada" id="jornada"></select>
                                <label>Seleccionar IES</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-4 col-12 m-0 p-0">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <select value="" required class="form-control border-start-0 selectpicker"
                                    data-live-search="true" name="periodo" id="periodo">
                                    <option value="" disabled selected>Periodo</option>
                                    <option value="todos3">Todos</option>
                                </select>
                                <label>Año de ingreso</label>
                            </div>
                        </div>

                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div class="col-3 m-0 p-0">
                        <input type="submit" value="Consultar" class="btn btn-success py-3" />
                    </div>
                    <div class="text-right col-4">
                       
                            <a onclick="mostrar()" class="text-center btn bg-light-green">
                                <i class="fas fa-user-check  text-success rounded-circle mb-2"
                                    aria-hidden="true"></i>
                                <h4 class="titulo-2 fs-12 mb-0 atrasados line-height-18">Periodo activo</h4>
                            </a>
                    </div>
                </form>

            </div>

            <div class="col-12 card p-4" id="ocultar_tb1">
                <div class="panel-body table-responsive p-4">
                    <table class="table table-hover" id="dtl_estudiantes" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Identificación</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Programa</th>
                                <th scope="col">Jornada</th>
                                <th scope="col">Semestre</th>
                                <th scope="col">Periodo de ingreso</th>
                                <th scope="col">Periodo activo</th>
                                <th scope="col">Faltas</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 card p-4" id="ocultar_tb2">
                <div class="panel-body table-responsive p-4">
                    <table class="table table-hover" id="mostrar" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Escuela IES</th>
                                <th scope="col">Identificación</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Programa</th>
                                <th scope="col">Jornada</th>
                                <th scope="col">Semestre</th>
                                <th scope="col">Periodo de ingreso</th>
                                <th scope="col">Faltas</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>

    <div class="modal fade bd-example-modal-lg" id="modalFaltas" tabindex="-1" role="dialog"
        aria-labelledby="modalFaltasLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFaltasLabel">Información de faltas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                    <div class="col-12 card p-4">
                        <table class="table table-hover" id="dtl_faltas" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha de falta</th>
                                    <th scope="col">Periodo de falta</th>
                                    <th scope="col">Motivo de falta</th>
                                    <th scope="col">Materia falta</th>
                            </thead>
                        </table>
                    </div>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
    <script type="text/javascript" src="scripts/consultaies.js"></script>