<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 14;
    $submenu = 1429;
    require 'header.php';

    if ($_SESSION['on_eliminar_estudiante'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <!--Contenido-->
        <!-- Content Wrapper. Contains page content -->
        <!--Contenido-->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Eliminar Estudiantes</span><br>
                                <span class="fs-16 f-montserrat-regular">Eliminar Soporte estudiante</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour " onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 d-none segundo_tour" onclick='iniciarSegundoTour()'><i class="fa-solid fa-play"></i> Tour 2da parte</button>
                        </div>

                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Eliminar Estudiantes</li>
                            </ol>
                        </div>

                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>

            <section class="container-fluid px-4 py-2">
                <div class="row">

                    <div id="titulo" class="col-12 "></div>

                    <div class="col-4 p-4 card" id="t-CL">
                        <div class="row">
                            <input type="hidden" value="" name="tipo" id="tipo">


                            <div class="col-12">
                                <h3 class="titulo-2 fs-14">Buscar cliente por:</h3>
                            </div>
                            <div class="col-12">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true" onclick="muestra(1)">Identificacion</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false" onclick="muestra(2)">Caso</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false" onclick="muestra(3)">Tel/Celular</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-12 mt-2" id="input_dato">
                                <div class="row">
                                    <div class="col-10 m-0 p-0">
                                        <div class="form-group position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" class="form-control border-start-0" name="dato" id="dato" required>
                                                <label id="valortitulo">Seleccionar tipo</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>

                                    <div class="col-2 m-0 p-0">
                                        <input type="submit" value="Buscar" onclick="consultacliente()" class="btn btn-success py-3 btn-block" disabled id="btnconsulta" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-4 borde-right" id="datos_estudiante">


                        <div class="col-12 px-2 py-3 ">
                            <div class="row align-items-center" id="t-NC">
                                <div class="pl-4">
                                    <span class="rounded bg-light-white p-2 text-gray ">
                                        <i class="fa-solid fa-user-slash" aria-hidden="true"></i>
                                    </span>

                                </div>
                                <div class="col-10">
                                    <div class="col-5 fs-14 line-height-18">
                                        <span class="">Nombres </span> <br>
                                        <span class="text-semibold fs-14">Apellidos </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-2 py-2 ">
                            <div class="row align-items-center" id="t-Ce">
                                <div class="pl-4">
                                    <span class="rounded bg-light-white p-2 text-gray">
                                        <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                                    </span>

                                </div>
                                <div class="col-10">
                                    <div class="col-5 fs-14 line-height-18">
                                        <span class="">Correo electrónico</span> <br>
                                        <span class="text-semibold fs-14">correo@correo.com</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-2 py-2 ">
                            <div class="row align-items-center" id="t-NT">
                                <div class="pl-4">
                                    <span class="rounded bg-light-white p-2 text-gray">
                                        <i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
                                    </span>

                                </div>
                                <div class="col-10">
                                    <div class="col-5 fs-14 line-height-18">
                                        <span class="">Número celular</span> <br>
                                        <span class="text-semibold fs-14">+570000000</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="col-4 " id="panel_detalle">
                        <div class="col-12  pt-3">
                            <div class="row">
                                <div class="col-4 mnw-100 text-center pt-4">
                                    <i class="fa-solid fa-trophy avatar avatar-50 bg-light-white text-gray rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
                                    <h4 class="titulo-2 fs-18 mb-0">-----</h4>
                                    <p class="small text-secondary">Caso</p>
                                </div>
                                <div class="col-4 mnw-100 text-center pt-4">
                                    <i class="fa-solid fa-bullhorn avatar avatar-50 bg-light-white text-gray rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
                                    <h4 class="titulo-2 fs-18 mb-0">-----</h4>
                                    <p class="small text-secondary">Campaña</p>
                                </div>
                                <div class="col-4 mnw-100 text-center pt-4">
                                    <i class="fa-solid fa-user-check avatar avatar-50 bg-light-white text-gray rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
                                    <h4 class="titulo-2 fs-18 mb-0">-----</h4>
                                    <p class="small text-secondary">Estado</p>
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
                                        <div class="col-5 fs-14 line-height-18">
                                            <span class="">Programas</span> <br>
                                            <span class="text-semibold fs-14">Matriculados</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 card p-4">

                                <table class="table" id="tbl_datos">
                                    <thead>
                                        <tr>
                                            <th id="t-CS">Caso</th>
                                            <th id="t-P">Programa</th>
                                            <th id="t-Jr">Jornada</th>
                                            <th id="t-FI">Fecha ingresa</th>
                                            <th id="t-ME">Medio</th>
                                            <th id="t-ES">Estado</th>
                                            <th id="t-PC">Periodo campaña</th>
                                            <th id="AC">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row datos_table"></div> -->
                <div class="col-12" id="panel_resultado"></div>
            </section>
        </div>


        <!-- inicio modal entrevista -->
        <div id="myModalEntrevista" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Entrevista</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="mercadeo_entrevista_2.php" method="post" class="alert">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    ¿Quien sostiene sus estudios?<br>
                                    <input type="text" name="sostiene" id="sostiene" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    ¿Laboras actualmente?<br>
                                    <input type="text" name="labora" id="labora" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    ¿Empresa?<br>
                                    <input type="text" name="donde_labora" id="donde_labora" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">
                                    ¿cargo?<br>
                                    <input type="text" name="cargo" id="cargo" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    ¿Conoces el plan de estudios del programa?<br>
                                    <input type="text" name="conoce_plan" id="conoce_plan" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="form-group col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    ¿Qué curso te gustaría tomar adicional?<br>
                                    <input name="curso_ad" id="curso_ad" placeholder="Que curso te gustaria tomar" class="form-control" readonly="readonly"></input>
                                </div>
                                <div class="form-group col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    ¿Te gustaría referir a personas para que inicien su proceso de formación en CIAF?<br>
                                    <input name="referir" id="referir" placeholder="Referir a personas" class="form-control" readonly="readonly"></input>
                                </div>
                                <div class="form-group col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    ¿Cuál crees que es tu mejor talento o habilidad?<br>
                                    <input name="talento" id="talento" placeholder="Tienes algún talento o habilidad" class="form-control" readonly="readonly"></input>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    ¿Qué te motivó a estudiar este programa?<br><br>
                                    <textarea name="motiva" id="motiva" rows="3" class="form-control" readonly="readonly"></textarea>
                                </div>
                                <div class="form-group col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                    ¿Cuál sería el motivo o razón para que dejes de estudiar?<br>
                                    <input name="dejar" id="dejar" placeholder="motivo o razón para que dejes de estudiar" class="form-control" readonly="readonly"></input>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    ¿Por qué eliges CIAF?<br>
                                    <textarea name="razon" id="razon" rows="3" class="form-control" readonly="readonly"></textarea>
                                </div>
                            </div>
                            <!-- cierra row -->
                        </form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal entrevista -->
        <!-- inicio modal ver soportes -->
        <div id="myModaVerSoportesDigitales" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Soportes</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body" id="resultado_cambiar_documento">
                        <form id="form_soporte_digitales1" method="post" class="soporte_cedula"></form>
                        <form id="form_soporte_digitales2" method="post" class="soporte_diploma"></form>
                        <form id="form_soporte_digitales3" method="post" class="soporte_acta"></form>
                        <form id="form_soporte_digitales4" method="post" class="soporte_salud"></form>
                        <form id="form_soporte_digitales5" method="post" class="soporte_prueba"></form>
                        <form id="form_soporte_compromiso" method="post" class="soporte_compromiso"></form>
                        <form id="form_soporte_proteccion_datos" method="post" class="soporte_proteccion_datos"></form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal ver soportes -->

        <!-- inicio modal agregar seguimiento -->
        <div class="modal" id="myModalAgregar">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title">Agregar seguimiento</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">

                        <?php require_once "on_segui_tareas.php" ?>

                    </div>

                </div>
            </div>
        </div>

        <!-- inicio modal ficha -->
        <div class="modal" id="myModalFicha">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Ficha Estudiante</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div id="resultado_ficha"></div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal ficha -->
        <!-- inicio modal historial -->
        <!-- The Modal -->
        <div class="modal" id="myModalHistorial">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title">Historial</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div id="historial" class="col-12"></div>

                            <div class="col-12 mt-4">
                                <div class="card card-tabs">
                                    <div class="card-header p-0 pt-1">
                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Seguimiento</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Tareas
                                                    Programadas</a>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="tab-content" id="custom-tabs-one-tabContent">
                                            <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

                                                <div class="row">
                                                    <div class="col-12 p-4">
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
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">

                                                <table id="tbllistadoHistorialTareas" class="table" width="100%">
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
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- fin modal historial -->
        <!-- inicio modal mover -->
        <div class="modal" id="myModalMover">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title">Cambiar de estado</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form name="moverUsuario" id="moverUsuario" method="POST" class="row">
                            <input type="hidden" id="id_estudiante_mover" value="" name="id_estudiante_mover">

                            <p class="pl-3">Mover el estado de cliente</p>

                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="estado" id="estado"></select>
                                        <label>Cambiar por:</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-12">
                                <input type="submit" value="Mover usuario" id="btnMover" class="btn btn-success btn-block">
                            </div>


                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- inicio modal camara -->
        <div id="modalwebacam" class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Foto para cliente</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" id="cc">
                                <input type="hidden" id="url">
                                <h2>Camara</h2>
                                <div class="col-md-12" id="my_camera"></div>
                            </div>
                            <div class="col-md-6 img"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="tomarfoto()" class="btn btn-info">Tomar foto</button>
                        <button type="button" onclick="restablecer()" class="btn btn-warning">Restablecer</button>
                        <button type="button" onclick="guardar()" class="btn btn-success">Guardar Foto</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- fin modal camara -->
        <!-- inicio modal soporte_inscripcion -->
        <div class="modal fade" id="soporte_inscripcion">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Soporte de inscripcion</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body" id="resultado_ficha">
                        <form id="form_soporte" method="post">
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Soporte</label>
                                <input type="hidden" name="id" class="id_es">
                                <input type="file" name="soporte" class="form-control-file" id="exampleFormControlFile1">
                            </div>
                            <button type="submit" id="btnGuardarsoporte" class="btn btn-success"><i class="fa fa-save"></i>
                                Guardar</button>
                        </form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal soporte_inscripcion -->
        <div class="modal" id="myModalValidarDocumento">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Cambio de Documento</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <!-- Modal body -->
                    <div class="modal-body" id="resultado_cambiar_documento">
                        <div class="alert alert-info">
                            Este paso deja al interesado en <b>preinscrito</b> y tiene acceso a la plataforma de mercadeo para
                            llenar formulario de inscripción.
                        </div>
                        <h3>Documento actual</h3>
                        <input type="text" id="cambio_cedula" value="" name="cambio_cedula" class="form-control" readonly="readonly">
                        <h3>Nuevo Documento</h3>
                        <form name="cambioDocumento" id="cambioDocumento" method="POST">
                            <input type="hidden" id="id_estudiante_documento" value="" name="id_estudiante_documento">
                            <input type="text" id="nuevo_documento" name="nuevo_documento" class="form-control" placeholder="Nuevo Documento" required="">
                            <input type="text" id="repetir_documento" name="repetir_documento" class="form-control" placeholder="Repetir Documento" required="">
                            <h5>Modalidad Campaña</h5>
                            <select name="modalidad_campana" id="modalidad_campana" class="form-control selectpicker" data-live-search="true" required>
                            </select>
                            <input type="submit" value="Cambiar Documento" id="btnCambiar" class="btn btn-success btn-block">
                        </form>
                        <div id="resultado_cedula"></div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!---------------------------------------------------------------------  MODALES(Ver Cuotas)   ---------------------------------------------------------------------------->
        <div class="modal fade" id="modal_whatsapp" tabindex="-1" role="dialog" aria-labelledby="modal_whatsapp_label">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h6 class="modal-title" id="modal_whatsapp_label"> Whatapp </h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 m-0 seccion_conversacion">
                                    <?php require_once "whatsapp_module.php" ?>
                                </div>
                            </div>
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
    ?>

    <script type="text/javascript" src="scripts/on_eliminar_estudiante.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
ob_end_flush();
?>