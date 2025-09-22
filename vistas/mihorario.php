<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 15;
    require 'header_estudiante.php';
?>
    <?php
    require_once "../modelos/Usuario.php";
    $usuario = new Usuario();
    $valor_estado = $usuario->consultar_Estado_Estudiante($_SESSION["credencial_identificacion"]);
    // $estado_ciafi = $valor_estado['estado_ciafi'];

    if (empty($valor_estado)) {
        $estado_ciafi = 1;
    } else {

        $estado_ciafi = $valor_estado['estado_ciafi'];
    }
    if ($estado_ciafi == 1) {

    ?>

        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span id="nombre_programa"></span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas mb-0">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_estudiante.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Programas</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid px-4">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card card-primary">
                            <div class="card-body p-0">

                                <div class="col-12 p-2" id="listado">

                                    <div class="row">
                                        <div class="col-12 p-2">
                                            <a onclick=iniciarcalendario() class='btn btn-primary float-right text-white'>
                                                <i class="fa-solid fa-calendar-days"></i> 
                                                Ver calendario
                                            </a>
                                        </div>
                                        <div class="col-12">
                                            <table id="tbllistado" class="table table-striped table-compact table-sm table-hover">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Asignatura</th>
                                                    <th scope="col">Nombre estudiante</th>
                                                    <th scope="col">Día</th>
                                                    <th scope="col">Hora inicio</th>
                                                    <th scope="col">Hora final</th>
                                                    <th scope="col">Salón</th>
                                                    </tr>
                                                </thead>
                                                            
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="col-12" id="calendario">
                                    <div class="row my-4">
                                        <div class="col-6 tono-3 ">
                                            <div class="row align-items-center">
                                                <div class="pl-4">
                                                    <span class="rounded bg-light-blue p-3 text-primary ">
                                                        <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                                    </span>

                                                </div>
                                                <div class="col-10">
                                                    <div class="col-5 fs-14 line-height-18">
                                                        <span class="">Horario</span> <br>
                                                        <span class="text-semibold fs-20">de clases</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 tono-3  pr-4">
                                            <a onclick=volverhorario() class='btn btn-danger float-right text-white'><i class="fa-solid fa-xmark"></i> Cerrar calendario</a>
                                        </div>
                                        <div class="col-12" id="calendar" style="width: 100%"></div>
                                    </div>
                                </div>
                           

                                <!-- <div id="panel" class="p-2"></div>
                                <div id="descripcion" class="col-12"></div>
                                <div id="documentos" class="col-12"></div>
                                <div id="enlaces" class="col-12"></div>
                                <div id="ejercicios" class="col-12"></div>
                                <div id="glosario" class="col-12">
                                    <div class="row">
                                        <div class="col-12" id="glosariocabecera"></div>
                                        <div class="col-12 p-4">
                                            <table id="tblglosario" class="table table-hover" style="width:100%">
                                                <thead>
                                                    <th>Palabra</th>
                                                    <th>Definición</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> -->

                                

                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Modal -->
            <div class="modal" id="crearGlosario">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Glosario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formulariocrearglosario" id="formulariocrearglosario" method="POST">
                                <input type="hidden" id="id_pea_glosario" name="id_pea_glosario">
                                <input type="hidden" id="id_pea_docentes_glosario" name="id_pea_docentes_glosario">
                                <div class="group col-xl-12">
                                    <input type="text" name="titulo_glosario" id="titulo_glosario" required maxlength="30" />
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Titulo glosario</label>
                                </div>
                                <div class="col-xl-12">
                                    <label>Definición glosario</label>
                                    <textarea name="definicion_glosario" id="definicion_glosario" required maxlength="240" rows="4" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <button class="btn btn-primary btn-block" type="submit" id="btnCrearGlosario"><i class="fa fa-save"></i> Publicar </button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal" id="subirejercicios">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ejercicios</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formulariocrearejercicios" id="formulariocrearejercicios" method="POST">
                                <input type="hidden" id="id_pea_ejercicios" name="id_pea_ejercicios">
                                <input type="hidden" id="id_pea_docente" name="id_pea_docente">
                                <div class="col-xl-12">
                                    <label>Comentario</label>
                                    <textarea name="comentario_ejercicios" id="comentario_ejercicios" required maxlength="98" class="form-control" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="archivo_ejercicios">Archivo: <small class="text-danger font-weight-bold">Solo se permiten: Excel, Word, Power Point, RAR y PDF</small> </label>
                                    <input type="file" name="archivo_ejercicios" class="form-control-file" id="archivo_ejercicios" required>
                                    <div id="error_peso" class="badge badge-danger mt-2" style="display: none; white-space: normal;">
                                        El archivo supera el tamaño máximo permitido de 5 MB.
                                    </div>
                                    <div id="error_tipo" class="badge badge-danger mt-2" style="display: none; white-space: normal;">
                                        Tipo de archivo no permitido. Solo se permiten archivos Excel, PowerPoint, RAR, PDF y Word.
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <button class="btn btn-primary btn-block" type="submit" id="btnCrearEjercicios"><i class="fa fa-save"></i> Publicar </button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php

}

?>

<?php
	require 'footer_estudiante.php';
}
ob_end_flush();
?>
<link href='../fullcalendar/css/main.css' rel='stylesheet' />
<script src='../fullcalendar/js/main.js'></script>
<script src='../fullcalendar/locales/es.js'></script>
<script type="text/javascript" src="scripts/mihorario.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
