<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 24;
    $submenu = 2403;
    require 'header.php';
    if ($_SESSION['resultadosevaluaciondocente'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Heteroevaluación Docente</span><br>
                                <span class="fs-16 f-montserrat-regular">Establezca, ejecute y vigile el desempeño de sus profesores</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick="iniciarTour()"><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Heteroevaluación</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="row p-0 m-0">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="row  pb-3" id="div_tablaDocentes">
                            <div class="col-xl-6 col-lg-4 col-md-4 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select required="" class="form-control border-start-0 selectpicker" data-live-search="true" name="input_periodo" id="input_periodo" onChange="listar(this.value)"></select>
                                        <label>Seleccionar Periodo:</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-xl-6 text-right">
                                <div class="col-xl-12 pb-2">Activar o desactivar evaluación</div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="switch_heteroevaluacion">
                                    <label class="custom-control-label estado_heteroevaluacion" for="switch_heteroevaluacion" style="cursor: pointer;"> -- </label>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row" id="datos" id="datos"></div>
                            </div>
                            <div class="card col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="resultado">
                                <table class='table table-hover text-center table-compact table-sm' id='tlb_listar'>
                                    <thead>
                                        <tr>
                                            <th> </th>
                                            <th> Información Docente </th>
                                            <th> Celular </th>
                                            <th> Correo </th>
                                            <th>Puntuación</th>
                                            <th> Heteroevaluación </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="div_tablaResultados col-12" id="div_tablaResultados">
                            <button class="btn btn-danger btn-sm mb-2 float-right" onClick="volverDocentes()">
                                <i class="fas fa-angle-left"></i>
                                <i class="fas fa-angle-left"></i> Volver
                            </button>
                            <div class="input-group mb-2">
                                <input type="hidden" id="id_docente_activo" name="id_docente_activo">
                                <!--<select name="input_periodo" id="input_periodo" class="form-control" onChange="listarResultadoPeriodo(this.value)"></select>-->
                            </div>
                            <table class='table table-hover' id='tablaResutados'>
                                <thead>
                                    <tr>
                                        <th> # Grupo </th>
                                        <th> Programa </th>
                                        <th> Materia </th>
                                        <th> Jornada </th>
                                        <th> Suma Respuestas </th>
                                        <th> Cantidad Respuestas </th>
                                        <th> Estudiantes matriculados </th>
                                        <th> Promedio </th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalRespuestas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Preguntas Heteroevaluación </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class='table table-hover compact table-sm' id='preguntas_respuestas'>
                            <thead>
                                <tr>
                                    <th> #</th>
                                    <th> Pregunta </th>
                                    <th> Total </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalPreguntas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Comentarios Heteroevaluación </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class='table table-hover compact table-sm' id='preguntas_comentarios'>
                            <thead>
                                <tr>
                                    <th> #</th>
                                    <th> Comentarios </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
<style>
    table.dataTable tbody td {
        vertical-align: middle;
        text-align: center;
    }
</style>
<script type="text/javascript" src="scripts/resultadosevaluaciondocente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>