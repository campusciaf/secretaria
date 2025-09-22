<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 24;
    $submenu = 2408;
    require 'header.php';
    if ($_SESSION['ver_encuentas'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Resultados Heteroevaluación
                            </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión resultados</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="row" id="div_tablaDocentes">

                                <div class="col-12">
                                    <div class="row justify-content-end">
                                        <div class="campo-select col-xl-2">
                                            <select name="input_periodo" id="input_periodo" class="campo" onChange="listar(this.value)"></select>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label>Periodo:</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div id="datos"></div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <table class='table table-hover text-center table-compact table-sm' id='tlb_listar'>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="switch_evaluacion_docente">
                                                        <label class="custom-control-label estado_evaluacion_docente" for="switch_evaluacion_docente" style="cursor: pointer;"> -- </label>
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th> </th>
                                                <th> Informacion Docente </th>
                                                <th> Celular </th>
                                                <th> Correo </th>
                                                <th>Puntuación</th>
                                                <th> Evaluacion Docente </th>
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
                </div>
            </section>
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
<script type="text/javascript" src="scripts/ver_encuentas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>