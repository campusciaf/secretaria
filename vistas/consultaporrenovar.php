<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 31;
    $submenu = 3101;
    require 'header.php';
    if ($_SESSION['consultaporrenovar'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Consulta Por Renovar</span><br>
                                <span class="fs-16 f-montserrat-regular">Consulta Por Renovar</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour " onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Consulta Por Renovar</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid px-4 py-2">
                <div class="row">
                    <div id="titulo" class="col-xl-12 col-lg-12 col-md-12 col-12"></div>
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 p-4 card">
                        <div class="row" id="t-CL">
                            <input type="hidden" value="" name="tipo" id="tipo">
                            <div class="col-12">
                                <h3 class="titulo-2 fs-14">Buscar:</h3>
                            </div>
                            <div class="col-12 mt-2" id="input_dato">
                                <div class="row">
                                    <div class="col-xl-9 col-lg-12 col-md-12 col-9 m-0 p-0">
                                        <div class="form-group position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" class="form-control border-start-0" name="dato" id="dato" required>
                                                <label id="valortitulo">Digitar Cédula: </label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class=" col-3 m-0 p-0">
                                        <input type="submit" value="Buscar" onclick="consulta_desercion_busqueda()" class="btn btn-success py-3 btn-block" id="btnconsulta" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-11" id="mostrar_datos_estudiante">
                        <div class="container">
                            <div class="row ">
                                <div class="col-sm">
                                    <div class="px-2 pb-2">
                                        <div class="row align-items-center">
                                            <div class="col-xl-1 col-lg-2 col-md-2 col-2">
                                                <span class="rounded bg-light-blue p-2 text-primary ">
                                                    <i class="fa-solid fa-user-slash"></i>
                                                </span>
                                            </div>
                                            <div class="col-10">
                                                <span class="">Nombre:</span> <br>
                                                <span class="text-semibold fs-12 box_nombre_estudiante">-
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-2 pb-2">
                                        <div class="row align-items-center">
                                            <div class="col-xl-1 col-lg-2 col-md-2 col-2">
                                                <span class="rounded bg-light-red p-2 text-danger">
                                                    <i class="fa-regular fa-envelope"></i>
                                                </span>
                                            </div>
                                            <div class="col-10">
                                                <span class="">Correo electrónico</span> <br>
                                                <span class="text-semibold fs-12 box_correo_electronico">-</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-2 pb-2">
                                        <div class="row align-items-center">
                                            <div class="col-xl-1 col-lg-2 col-md-2 col-2">
                                                <span class="rounded bg-light-green p-2 text-success">
                                                    <i class="fas fa-phone"></i>
                                                </span>
                                            </div>
                                            <div class="col-10">
                                                <span class="">Celular</span> <br>
                                                <span class="text-semibold fs-12 box_celular">-</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 datos_table">
                        <div class="row mt-4" id="t-TP">
                            <div class="col-12 px-2 py-3 tono-3">
                                <div class="row align-items-center">
                                    <div class="pl-4">
                                        <span class="rounded bg-light-blue p-2 text-primary ">
                                            <i class="fa-solid fa-table"></i>
                                        </span>
                                    </div>
                                    <div class="col-10">
                                        <div class="col-12 fs-14 line-height-18">
                                            <span class="">Consulta</span> <br>
                                            <span class="text-semibold fs-14">Consulta Por renovar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12 card p-4">
                                <div class="panel-body table-responsive p-4">
                                    <table id="datos_table_desertado" class="table" style="width:100%">
                                        <thead class="text-center">
                                            <th>Opciones</th>
                                            <th>Identificación</th>
                                            <th>Correo personal</th>
                                            <th>Periodo Ingreso</th>
                                            <th>Estado</th>
                                            <th>Periodo Activo</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- inicio modals-->
        <!-- modal para editar el estado de los egresados -->
        <div class="modal fade" id="ModalReingreso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modificar Estado Egresado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="formularioreingreso" id="formularioreingreso" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_egresdado_est" id="id_egresdado_est" value="">
                            <input type="hidden" name="id_estudiante_estado" id="id_estudiante_estado" value="">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="id_reingreso_estado" id="id_reingreso_estado"></select>
                                        <label>Estado</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- inicio modal agregar seguimiento -->
        <div class="modal" id="myModalAgregar">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar seguimiento</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div style="overflow: auto">
                            <div class="col-md-12">
                                <div id="accordion">
                                    <div class="card ">
                                        <div class="card-header">
                                            <h4 class="card-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                    <div class="spinner-grow text-muted spinner-grow-sm"></div> Datos de contacto
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <dt>Nombre</dt>
                                                        <dd class="box_nombre_estudiante">-----</dd>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <dt>Cédula</dt>
                                                        <dd class="box_credencial_identificacion">-----</dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <form name="formularioAgregarSeguimiento" id="formularioAgregarSeguimiento" method="POST" class="col-12">
                                <h3>Registrar Seguimiento</h3>
                                <input type="hidden" name="id_estudiante_agregar" id="id_estudiante_agregar" value="">
                                <div class="form-group col-lg-12">
                                    <span id="contador">150 Caracteres permitidos</span>
                                    <textarea class="form-control" name="mensaje_seguimiento" id="mensaje_seguimiento" maxlength="150" placeholder="Escribir Seguimiento" rows="6" required onKeyUp="cuenta()"></textarea>
                                </div>
                                <div class="form-group col-lg-12">
                                    <div class="radio">
                                        <label><input type="radio" name="motivo_seguimiento" id="motivo_seguimiento" value="Cita" required>Cita</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="motivo_seguimiento" value="Llamada">Llamada</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="motivo_seguimiento" value="Seguimiento">Seguimiento</label>
                                    </div>
                                    <form id="form_soporte_digitales5" method="post" class="soporte_prueba"></form>
                                    <!-- <button class="btn btn-success" type="submit" id="btnGuardarSeguimiento"><i class="fa fa-save"></i> Registrar</button> -->
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
                                        <button class="btn btn-success btn-block" type="submit" id="btnGuardarSeguimiento"><i class="fa fa-save" aria-hidden="true"></i> Registrar</button>
                                    </div>
                                </div>
                            </form>
                            <form name="formularioTarea" id="formularioTarea" method="POST" class="card col-12">
                                <h3>Programar tarea</h3>
                                <input type="hidden" name="id_estudiante_tarea" id="id_estudiante_tarea">
                                <span id="contadortarea">150 Caracteres permitidos</span>
                                <textarea class="form-control" name="mensaje_tarea" id="mensaje_tarea" maxlength="100" placeholder="Escribir Mensaje" rows="6" required onKeyUp="cuentatarea()"></textarea>
                                <div class="row">
                                    <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12 mt-3">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="date" placeholder="" value="" required class="form-control border-start-0" name="fecha_programada" id="fecha_programada" required>
                                                <label>Día</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12 mt-3">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="time" placeholder="" value="" required class="form-control border-start-0" name="hora_programada" id="hora_programada" required>
                                                <label>Hora</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="customRadio4" name="motivo_tarea" value="cita" required="">
                                    <label class="custom-control-label" for="customRadio4">Cita</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="customRadio5" name="motivo_tarea" value="llamada" required="">
                                    <label class="custom-control-label" for="customRadio5">Llamada</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="customRadio6" name="motivo_tarea" value="seguimiento" required="">
                                    <label class="custom-control-label" for="customRadio6">Seguimiento</label>
                                </div>
                                <!-- <input type="submit" value="Programar Tarea" id="btnGuardarTarea" name="enviar tareas" class="btn btn-danger"> -->
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
                                    <button class="btn btn-success btn-block" value="Programar Tarea" name="enviar tareas" type="submit" id="btnGuardarTarea"><i class="fa fa-save" aria-hidden="true"></i> Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal historial tareas -->
        <div class="modal" id="myModalHistorialTareas">
            <div class="modal-dialog modal-md modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Historial</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div style="overflow: auto">
                            <!-- <div id="historial"></div> -->
                            <div class="col-md-12">
                                <div id="accordion">
                                    <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                                    <div class="card ">
                                        <div class="card-header">
                                            <h4 class="card-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                    <div class="spinner-grow text-muted spinner-grow-sm"></div> Datos de contacto
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <dt>Nombre</dt>
                                                        <dd class="box_nombre_estudiante">-----</dd>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <dt>Cédula</dt>
                                                        <dd class="box_credencial_identificacion">-----</dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="alert" style="width:100%; clear: both">
                                <h3>Historial Seguimiento</h3>
                                <div class="table-responsive">
                                    <table id="tbllistadohistorial" class="table" width="100%">
                                        <thead>
                                            <th>Caso</th>
                                            <th>Motivo</th>
                                            <th>Observaciones</th>
                                            <th>Fecha de observación</th>
                                            <th>Asesor</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <h3>Historial Tareas Programadas</h3>
                                <div class="table-responsive">
                                    <table id="tbllistadoHistorialTareas" class="table " width="100%">
                                        <thead>
                                            <th>Estado</th>
                                            <th>Motivo</th>
                                            <th>Observaciones</th>
                                            <th>Fecha de observación</th>
                                            <th>Asesor</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
<script type="text/javascript" src="scripts/consultaporrenovar.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>