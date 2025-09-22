<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.php");
} else {
    $menu = 5;
    $submenu = 502;
    require 'header.php';
    if ($_SESSION['matriculamateria'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Matricula materias</span><br>
                                <span class="fs-14 f-montserrat-regular">Espacio para gestionar la malla académica de los estudiantes.</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas mb-0">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Matricular estudiante</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid px-4">
                <!--Fondo de la vista -->
                <div class="row col-12">
                    <div class="col-xl-4 col-lg-12 col-md-12 col-12" id="seleccionprograma">
                        <form name="formularioverificar" id="formularioverificar" method="POST" class="row">
                            <div class="col-xl-9 col-lg-9 col-md-9 col-9 m-0 p-0">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" required class="form-control border-start-0" name="credencial_identificacion" id="credencial_identificacion" maxlength="20" value="">
                                        <label>Número Identificación</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-3 m-0 p-0">
                                <button type="submit" id="btnVerificar" class="btn btn-success py-3">Buscar</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-8 col-lg-12 col-md-12 col-12" id="mostrardatos">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-12 py-2">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <span class="rounded bg-light-white p-2 text-gray ">
                                            <i class="fa-solid fa-user-slash" aria-hidden="true"></i>
                                        </span>

                                    </div>
                                    <div class="col-10">
                                        <span class="">Nombres </span> <br>
                                        <span class="text-semibold fs-14">Apellidos </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-12 py-2">
                                <div class="row align-items-center">
                                    <div class="col-2 ">
                                        <span class="rounded bg-light-white p-2 text-gray">
                                            <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="col-10">
                                        <span class="">Correo electrónico</span> <br>
                                        <span class="text-semibold fs-14">correo@correo.com</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-12 py-2">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <span class="rounded bg-light-white p-2 text-gray">
                                            <i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="col-10">
                                        <span class="">Número celular</span> <br>
                                        <span class="text-semibold fs-14">+570000000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="card col-12   p-4" id="listadoregistros">
                        <table id="tbllistado" class="table table-hover table-responsive" style="width:100%">
                            <thead>
                                <th>Acciones</th>
                                <th>Id estudiante</th>
                                <th>Programa</th>
                                <th>Jornada</th>
                                <th>Semestre</th>
                                <th>Grupo</th>
                                <th>Estado</th>
                                <th>Nuevo del</th>
                                <th>Periodo Activo</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
       
                    
                    <div class="row">
                        <div id="listadomaterias" class="row" style="width: 100%"></div>
                    </div>
                </div>
            </section>
        </div><!-- /.content-wrapper -->
        <div class="modal fade" id="myModalMatriculaNovedad" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Cambio</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form name="formularionovedadjornada" id="formularionovedadjornada" method="POST">
                            <input type='hidden' value="" id='id_materia' name='id_materia'>
                            <input type='hidden' value="" id='ciclo' name='ciclo'>
                            <input type='hidden' value="" id='id_programa_ac' name='id_programa_ac'>
                            <input type='hidden' value="" id='id_estudiante' name='id_estudiante'>
                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="jornada_e" id="jornada_e"></select>
                                        <label>Cambio de Jornada a:</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-12">
                                <button type="submit" id="btnNovedad" class="btn btn-success btn-block">Cambiar Jornada</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalMatriculaNovedadPeriodo" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Cambio</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form name="formularionovedadperiodo" id="formularionovedadperiodo" method="POST">
                            <input type='hidden' value="" id='id_materia_j' name='id_materia_j'>
                            <input type='hidden' value="" id='ciclo_j' name='ciclo_j'>
                            <input type='hidden' value="" id='id_programa_ac_j' name='id_programa_ac_j'>
                            <input type='hidden' value="" id='id_estudiante_j' name='id_estudiante_j'>
                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo" id="periodo"></select>
                                        <label>Cambio de periodo a:</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-12">
                                <button type="submit" id="btnNovedadPeriodo" class="btn btn-success btn-block">Cambiar Periodo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="verdetalles"></div>
        <!-- Modal matricular_asignatura especial -->
        <div class="modal fade" id="myModalMatriculaNovedadGrupo" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Cambio</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form name="formularionovedadgrupo" id="formularionovedadgrupo" method="POST">
                            <input type='hidden' value="" id='id_materia_g' name='id_materia_g'>
                            <input type='hidden' value="" id='ciclo_g' name='ciclo_g'>
                            <input type='hidden' value="" id='id_programa_ac_g' name='id_programa_ac_g'>
                            <input type='hidden' value="" id='id_estudiante_g' name='id_estudiante_g'>
                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="grupo" id="grupo"></select>
                                        <label>Cambio de grupo a:</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-12">
                                <button type="submit" id="btnNovedadGrupo" class="btn btn-success btn-block">Cambiar Grupo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODALES -->
        <div class="modal fade" id="HorariosDeClaseModal" tabindex="-1" aria-labelledby="HorariosDeClaseModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="HorariosDeClaseModalLabel"> Horarios de clases </h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body body-modal-clases">
                        <div class="container-fluid pb-1">
                            <div class="row divEscuelas">
                                <div class="col-12 py-2">Seleccionar escuela</div>
                                <div style="width:170px">
                                    <a onclick="ListarHorariosEscuela(1)" title="ver cifras" class="row pointer m-2">
                                        <div class="col-3 rounded bg-light-red">
                                            <div class="text-red text-center pt-1">
                                                <i class="fa-regular fa-calendar-check fa-2x  text-red" aria-hidden="true"></i>
                                            </div>

                                        </div>
                                        <div class="col-9 borde">
                                            <span>Escuela de</span><br>
                                            <span class="titulo-2 fs-12 line-height-16"> Administración</span>
                                        </div>
                                    </a>
                                </div>
                                <div style="width:170px">
                                    <a onclick="ListarHorariosEscuela(6)" title="ver cifras" class="row pointer m-2">
                                        <div class="col-3 rounded bg-light-purple">
                                            <div class="text-red text-center pt-1">
                                                <i class="fa-regular fa-calendar-check fa-2x  text-purple" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="col-9 borde">
                                            <span>Escuela de</span><br>
                                            <span class="titulo-2 fs-12 line-height-16"> Contaduría</span>
                                        </div>
                                    </a>
                                </div>
                                <div style="width:170px">
                                    <a onclick="ListarHorariosEscuela(3)" title="ver cifras" class="row pointer m-2">
                                        <div class="col-3 rounded bg-light-green">
                                            <div class="text-red text-center pt-1">
                                                <i class="fa-regular fa-calendar-check fa-2x  text-green" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="col-9 borde">
                                            <span>Escuela de</span><br>
                                            <span class="titulo-2 fs-12 line-height-16"> SST</span>
                                        </div>
                                    </a>
                                </div>
                                <div style="width:170px">
                                    <a onclick="ListarHorariosEscuela(2)" title="ver cifras" class="row pointer m-2">
                                        <div class="col-3 rounded bg-light-blue">
                                            <div class="text-red text-center pt-1">
                                                <i class="fa-regular fa-calendar-check fa-2x  text-blue" aria-hidden="true"></i>
                                            </div>

                                        </div>
                                        <div class="col-9 borde">
                                            <span>Escuela de</span><br>
                                            <span class="titulo-2 fs-12 line-height-16"> Ingenieria</span>
                                        </div>
                                    </a>
                                </div>
                                <div style="width:170px">
                                    <a onclick="ListarHorariosEscuela(5)" title="ver cifras" class="row pointer m-2">
                                        <div class="col-3 rounded bg-light-orange">
                                            <div class="text-red text-center pt-1">
                                                <i class="fa-regular fa-calendar-check fa-2x  text-orange" aria-hidden="true"></i>
                                            </div>

                                        </div>
                                        <div class="col-9 borde">
                                            <span>Escuela de</span><br>
                                            <span class="titulo-2 fs-12 line-height-16"> Industrial</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <input type="hidden" id="id_materia_matriculada" name="id_materia_matriculada">
                            <input type="hidden" id="ciclo_matriculado" name="ciclo_matriculado">
                            <input type="hidden" id="id_estudiante_especial" name="id_estudiante_especial">
                        </div>
                    </div>
                    <div id="clasesDelDia" class="p-2">
                    </div>
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
<link href='../fullcalendar/css/main.css' rel='stylesheet' />
<script src='../fullcalendar/js/main.js'></script>
<script src='../fullcalendar/locales/es.js'></script>
<script type="text/javascript" src="scripts/matriculamaterias.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<style>
    .modal-fullscreen {
        width: 100vw;
        max-width: none;
        height: 100%;
        margin: 0;
    }

    .fc-daygrid-event-harness {
        cursor: pointer;
    }
</style>