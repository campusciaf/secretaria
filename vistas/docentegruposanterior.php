<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
error_reporting(0);
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    if ($_SESSION['usuario_cargo'] != "Docente") {
        header("Location: ../");
    } else {
        $menu = 1;
        require 'header_docente.php';
    }
?>
    <div id="precarga" class="precarga"></div>
    <div class="content-wrapper ">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-xl-6 col-9">
                        <h2 class="m-0 line-height-16">
                            <span class="titulo-2 fs-18 text-semibold">Construyendo Experiencias</span><br>
                            <span class="fs-14 f-montserrat-regular">Haz parte de la experiencia CIAF</span>
                        </h2>
                    </div>
                    <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                        <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        <button class="btn btn-sm btn-outline-warning px-2 py-0 d-none segundo_tour" onclick='iniciarSegundoTour()'><i class="fa-solid fa-play"></i> Tour 2da parte</button>
                    </div>
                    <div class="col-12 migas mb-0">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="panel_docente.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Clases</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="container-fluid px-4">
            <div class="row">
                <div class="col-6 tono-3 py-4">
                    <div class="row align-items-center">
                        <div class="col-auto pl-4">
                            <span class="rounded bg-light-blue p-3 text-primary ">
                                <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div class="col-auto line-height-18">
                            <span class="">Listado</span> <br>
                            <span class="titulo-2 text-semibold fs-20 line-height-18">de clases</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 tono-3 text-right pr-xl-4 pr-lg-4 pr-md-4 pr-2 pt-xl-4 pt-lg-4 pt-md-4 pt-2">
                    <p id="nombre_materia"></p>
                </div>
                <div class="card col-12" id="lista_programas">
                    <div class="row">
                        <div class="col-12 " id="listadoregistrosgrupos">
                            <table id="tbllistadogrupos" class="table table-hover table-sm table-responsive" style="width:100%">
                                <thead>
                                    <th id="t-paso1">Programa</th>
                                    <th id="t-paso2">Asignatura</th>
                                    <th id="t-paso3">Jornada</th>
                                    <th id="t-paso4">Semestre</th>
                                    <th id="t-paso5">Horario</th>
                                    <th id="t-paso6">Salón</th>
                                    <th id="t-paso7">Acciones</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 m-0 p-0">
                        <div id="tbllistado" class="m-0 p-0"></div>
                        <div id="tllistado" class="m-0 p-0"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Modal registrar falta -->
    <div class="modal fade" id="modalFaltas" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-md">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Registrar Falta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_credencial" id="id_credencial">
                    <input type="hidden" name="id_docente_grupo" id="id_docente_grupo">
                    <input type="hidden" name="ciclo" id="ciclo">
                    <input type="hidden" name="id_estudiante" id="id_estudiante">
                    <input type="hidden" name="id_programa" id="id_programa">
                    <input type="hidden" name="id_materia" id="id_materia">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Motivo de la falta: </label>
                        <select name="motivo_falta" class="form-control" id="motivo_falta" required>
                        </select>
                    </div>
                    <button type="submit" onclick="registraFalta()" class="btn btn-success">Registrar falta</button>
                    <table id="tbfaltas" class="table-hover table mt-3 table-sm compact" width="100%">
                        <thead>
                            <th class="text-center">Opcion</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Motivo</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal listar reportes de contacto-->
    <div class="modal fade" id="modalReportes" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Vista Previa</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="listadocontacto" class="table table-hover" style="width:100%">
                        <thead>
                            <th>Identificación</th>
                            <th>Nombre estudiante</th>
                            <th>Correo CIAF</th>
                            <th>Correo personal</th>
                            <th>Celular</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal listar reporte final-->
    <div class="modal fade" id="modalReporteFinal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Vista Previa</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="prueba"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal enviar correo -->
    <div class="modal fade" id="modalEmail" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Correo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Contenido email</label>
                        <textarea class="form-control" id="conteMail" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button id="enviarEmail" class="btn btn-success">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal enviar correo -->
    <div class="modal fade" id="modalHorarioEstudiante" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Horario estudiante</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12" id="horarioestudiante"></div>
                    <div class="col-12" id="calendar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal reporte influencer -->
    <div class="modal fade" id="modalReporteInfluencer" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Reporte influencer</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="reporteinfluencer" id="reporteinfluencer" method="POST">
                        <input type='hidden' value="" id='id_estudiante_in' name='id_estudiante_in'>
                        <input type='hidden' value="" id='id_docente_in' name='id_docente_in'>
                        <input type='hidden' value="" id='id_programa_in' name='id_programa_in'>
                        <input type='hidden' value="" id='id_materia_in' name='id_materia_in'>
                        <div class="form-group col-12">
                            <label>Describir la novedad:</label>
                            <textarea name="influencer_mensaje" id="influencer_mensaje" rows="5" class="form-control" required></textarea>
                        </div>
                        <button type="submit" id="btnInfluencer" class="btn bg-purple btn-block">Enviar Reporte</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    </div><!-- /.content-wrapper -->
    <style>
        
    </style>
<?php
    require 'footer_docente.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/docentegruposanterior.js?<?= date("Y-m-d-H:i:s") ?>"></script>
<link href='../fullcalendar/css/main.css' rel='stylesheet' />
<script src='../fullcalendar/js/main.js'></script>
<script src='../fullcalendar/locales/es.js'></script>