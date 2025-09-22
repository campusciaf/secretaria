<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 7;
    $submenu = 710;
    require 'header.php';
    if ($_SESSION['reportedocenteprograma'] == 1) {
?>
    <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Reporte docente</span><br>
                                <span class="fs-14 f-montserrat-regular">Reporte de programa con carga horaria </span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Reporte docente</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid px-4" >
                <div class="row">
                    <form id="buscar" name="buscar" method="POST" class="col-12">
                        <div class="row">
                            <div class="col-4 p-0 m-0">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating" id="t-PA">
                                        <select placeholder="" value="" required="" class="form-control border-start-0 selectpicker" data-live-search="true"  name="id_programa" id="id_programa" onchange="buscarDatos()"></select>
                                        <label>Programa académico</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-3 p-0 m-0">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating" id="t-Jo">
                                        <select placeholder="" value="" required="" class="form-control border-start-0 selectpicker" data-live-search="true"  name="jornada_programa" id="jornada_programa" onchange="buscarDatos()"></select>
                                        <label>Jornada</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-3 p-0 m-0">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating" id="t-Pe">
                                        <select  placeholder="" value="" required="" class="form-control border-start-0 selectpicker" data-live-search="true"  name="periodo" id="periodo" onchange="buscarDatos()"></select>
                                        <label>Periodo</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                        </div>
                    </form>
                    <!-- muestra el contenido del reporte que se recibe desde el controlador -->
                    <div id="reporte_docente" class="col-12">
                        <div class="row ">
                            <div class="col-12">
                                <div class="card card-tabs">
                                    <div class="card-header p-0 pt-1">
                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                            <li class="nav-item">
                                                <a  id="t-s1" class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true" >Semestre 1</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Semestre 2</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Semestre 3</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Semestre 4</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body ">
                                        <div class="tab-content" id="custom-tabs-one-tabContent">
                                            <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col" id="t-As">Asignatura</th>
                                                        <th scope="col" id="t-Dc">Docente</th>
                                                        <th scope="col" id="t-I">Identificación</th>
                                                        <th scope="col" id="t-H">Horas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="titulo-2 fs-14">
                                                            <td>Nombre Asignatura</td>
                                                            <td>Nombre docente</td>
                                                            <td># identificación</td>
                                                            <td><span class="badge badge-primary mt-2">#horas</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Asignatura</th>
                                                        <th scope="col">Docente</th>
                                                        <th scope="col">Identificación</th>
                                                        <th scope="col">Horas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="titulo-2 fs-14">
                                                            <td>Nombre Asignatura</td>
                                                            <td>Nombre docente</td>
                                                            <td># identificación</td>
                                                            <td><span class="badge badge-primary mt-2">#horas</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Asignatura</th>
                                                        <th scope="col">Docente</th>
                                                        <th scope="col">Identificación</th>
                                                        <th scope="col">Horas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="titulo-2 fs-14">
                                                            <td>Nombre Asignatura</td>
                                                            <td>Nombre docente</td>
                                                            <td># identificación</td>
                                                            <td><span class="badge badge-primary mt-2">#horas</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Asignatura</th>
                                                        <th scope="col">Docente</th>
                                                        <th scope="col">Identificación</th>
                                                        <th scope="col">Horas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="titulo-2 fs-14">
                                                            <td>Nombre  11 Asignatura</td>
                                                            <td>Nombre docente</td>
                                                            <td># identificación</td>
                                                            <td><span class="badge badge-primary mt-2">#horas</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

<script type="text/javascript" src="scripts/reportedocenteprograma.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>