<?php
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 15;
    $submenu = 1510;
    require 'header.php';
    if ($_SESSION['especial'] == 1) {
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper" style="padding-right: 3rem;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 mx-0">
                <div class="col-xl-6 col-9">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Diversidad en el Aula</span><br>
                        <span class="fs-16 f-montserrat-regular">Gestión de Estudiantes con Condiciones Diferentes</span>
                    </h2>
                    Revisar estudiantes con posible condición especial
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'>
                        <i class="fa-solid fa-play"></i> Tour
                    </button>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Diversidad en el Aula</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="container-fluid px-4 py-2" style="padding-right: 6rem;">
        <div class="row align-items-start">
          <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12 p-3 card">
                <div class="row">
                    <input type="hidden" value="" name="tipo" id="tipo">
                    <div class="col-12">
                        <h3 class="titulo-2 fs-14">Buscar Estudiante:</h3>
                    </div>
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                                    href="#" role="tab" aria-selected="true" onclick="filtroportipo(1)">Identificación</a>
                            </li>
                            <li class="nav-item">
    <a class="nav-link" href="#" id="btnListadoEstudiantes">
        Listado Estudiantes
    </a>
</li>

                        
                        </ul>
                    </div>

                    <div class="col-12 mt-2" id="input_dato_estudiante">
                        <div class="row">
                            <div class="col-8 p-0">
                                <div class="form-group position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" class="form-control border-start-0"
                                            name="dato_estudiante" id="dato_estudiante">
                                        <label id="valortituloestudiante">Buscar Estudiante</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Por favor ingresa una identificación válida</div>
                            </div>
                            <div class="col-4 p-0 pl-2">
                                <input type="submit" value="Buscar" onclick="verificarDocumento()"
                                    class="btn btn-success py-2 btn-block" disabled id="btnconsulta" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL -->
        <div class="modal fade" id="modalListadoEstudiantes" tabindex="-1" role="dialog"
            aria-labelledby="modalListadoEstudiantesLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalListadoEstudiantesLabel">Listado de Estudiantes</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="tablaModalEstudiantes" class="table table-hover table-sm text-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-0">Acciones</th>
                                        <th class="border-0">Identificación</th>
                                        <th class="border-0">Nombre</th>
                                        <th class="border-0">Apellido</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLA PRINCIPAL -->
        <div class="row">
            <div class="col-12 table-responsive pt-3">
                <table class="table table-striped compact table-sm" id="datos_estudiantes">
                    <thead>
                        <tr>
                            <th scope="col">Identificación</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Nombres</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="col-12" id="escuelas"></div>
            <div class="col-12" id="resultado"></div>

            <div class="col-12" id="tabla_es">
                <div class="card card-primary p-2 mt-3">
                    <h4 class="mb-2 text-center">Listado de Estudiantes</h4>
                    <div class="box-body">
                        <div id="contenedor_tabla" class="table-responsive">
                            <table id="tblrenovar" class="table table-hover compact text-sm">
                                <thead>
                                    <tr>
                                        <th>Acciones</th>
                                        <th>Identificación</th>
                                        <th>Nombre</th>
                                        <th>Programa</th>
                                        <th>Ciclo</th>
                                        <th>Estado</th>
                                        <th>Jornada</th>
                                        <th>Semestre</th>
                                        <th>Correo personal</th>
                                        <th>Celular</th>
                                        <th>Escuela</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="form-group col-lg-12 text-right p-2">
        <input type="number" class="d-none cedula_estu" id="cedula_estu" name="cedula_estu">
        <input type="number" class="d-none id_credencial_oculto" id="id_credencial_oculto" name="id_credencial_oculto">
        <input type="number" class="d-none id_credencial_guardar_estudiante" id="id_credencial_guardar_estudiante"
            name="id_credencial_guardar_estudiante">
    </div>

</div>

<?php
    require 'footer.php';
    } else {
        require 'noacceso.php';
    }
}
ob_end_flush();
?>

<script type="text/javascript" src="scripts/especial.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/agregar_segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script src="scripts/whatsapp_module.js?<?= date("Y-m-d H:i:s") ?>"></script>

