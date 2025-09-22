<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"]) || $_SESSION['usuario_cargo'] != "Docente") {
    header("Location: ../");
} else {
    $menu = 1;
    require 'header_docente.php';
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Edución continuada</span><br>
                      <span class="fs-14 f-montserrat-regular">Explorar nuevos temas, desarrollar nuevas habilidades y aprender más sobre su campo</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel_docente.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Educación continuada</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>
        <section class="content" style="padding-top: 0px;">
            <div class="card card-primary col-12 m-0" style="padding: 2%" id="lista_programas">
                <div class="row">
                    <div class="col-12 table-responsive" id="listadoRegistrosCursos">
                        <table id="tablaListadoCursos" class="table table-sm  table-hover" width="100%">
                            <thead>
                                <th> Curso </th>
                                <th> Sede </th>
                                <th> Modalidad </th>
                                <th> Inicio </th>
                                <th> Fin </th>
                                <th> Horario </th>
                                <th> Listado </th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 m-0 p-0 div_listado_estudiantes">
                        <table id="tbllistado" class="table table-sm table-hover" width="100%">
                            <thead>
                                <th> Nombre </th>
                                <th> Apellidos </th>
                                <th> Curso </th>
                                <th> Roll </th>
                                <th> ¿Aprobó? </th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
                        <select name="motivo_falta" class="form-control" id="motivo_falta">
                            <option value="1"> Motivo 1 </option>
                        </select>
                    </div>
                    <button type="submit" onclick="registraFalta()" class="btn btn-success">Registrar falta</button>
                    <table id="tbfaltas" class="table-hover table mt-3" width="100%">
                        <thead>
                            <th class="text-center">Opcion </th>
                            <th class="text-center">Fecha </th>
                            <th class="text-center">Motivo </th>
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
                    <h5 class="modal-title">Vista Previa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="listadocontacto" class="table table-bordered compact table-sm table-hover" style="width:100%">
                        <thead>
                            <th>Identificación </th>
                            <th>Nombre estudiante </th>
                            <th>Correo CIAF </th>
                            <th>Correo personal </th>
                            <th>Celular </th>
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
                    <h5 class="modal-title">Vista Previa: Dar clic en el botón imprimir</h5>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Horario estudiante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12" id="horarioestudiante"></div>
                    <div class="col-12" id="calendar" style="width: 100%"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <style>
        .dt-buttons {
            margin-bottom: 5px;
        }
    </style>
<?php
    require 'footer_docente.php';
}
ob_end_flush();
?>
<link href='../fullcalendar/css/main.css' rel='stylesheet' />
<script src='../fullcalendar/js/main.js'></script>
<script src='../fullcalendar/locales/es.js'></script>
<script type="text/javascript" src="scripts/docente_cursos_ec.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>