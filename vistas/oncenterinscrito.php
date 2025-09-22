<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 14;
    $submenu = 1417;
    require 'header.php';
    if ($_SESSION['oncenterinscrito'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Inscritos</span><br>
                                <span class="fs-16 f-montserrat-regular">Es hora de conocer a los clientes</span>
                            </h2>
                        </div>
                        <div class="col-6 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 d-none segundo_tour" onclick='iniciarSegundoTour()'><i class="fa-solid fa-play"></i> Tour 2da parte</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Inscritos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content p-4">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div id="resultado" class="row col-12"></div>
                        <div id="resultadoDos" class="row col-12"></div>
                        <div class="row" id="listadoregistrostres">
                            <div id="titulo" class="col-lg-6 tono-3 py-3"></div>
                            <div class="col-lg-6 py-3 pr-4 tono-3"><a onClick="volverDos()" class="btn btn-danger float-right text-white"><i class="fas fa-arrow-circle-left"></i> Volver</a></div>
                            <div class="col-12 card p-4 table-responsive">
                                <table id="tbllistadoestudiantes" class="table table-hover" style="width:100%">
                                    <thead>
                                        <th>Acciones</th>
                                        <th>Caso</th>
                                        <th>Identificación</th>
                                        <th>Nombre</th>
                                        <th>Entrevista</th>
                                        <th>Conocio</th>
                                        <th>Contacto</th>
                                        <th>Medio</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <table id="tbllistadoestudiantessuma" class="table table-hover" style="width:100%">
                                    <thead>
                                        <th>Acciones</th>
                                        <th>Caso</th>
                                        <th>Identificación</th>
                                        <th>Nombre</th>
                                        <th>Programa de Interes</th>
                                        <th>Entrevista</th>
                                        <th>Conocio</th>
                                        <th>Contacto</th>
                                        <th>Medio</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <table id="tbllistadoestudiantestotal" class="table table-hover" style="width:100%">
                                    <thead>
                                        <th>Acciones</th>
                                        <th>Caso</th>
                                        <th>Identificación</th>
                                        <th>Nombre</th>
                                        <th>Programa de Interes</th>
                                        <th>Jornada</th>
                                        <th>Entrevista</th>
                                        <th>Conocio</th>
                                        <th>Contacto</th>
                                        <th>Medio</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <table id="tbllistadoestudiantesmedio" class="table table-hover" style="width:100%">
                                    <thead>
                                        <th>Acciones</th>
                                        <th>Caso</th>
                                        <th>Identificación</th>
                                        <th>Nombre</th>
                                        <th>Programa de Interes</th>
                                        <th>Jornada</th>
                                        <th>Entrevista</th>
                                        <th>Conocio</th>
                                        <th>Contacto</th>
                                        <th>Medio</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
        <div class="modal" id="myModalHistorial">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title">Listado Consulta</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="historial"></div>
                        <div class="col-12 mt-4">
                            <div class="card card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Seguimiento</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Tareas Programadas</a>
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
   
        <div id="myModalPerfilEstudiante" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Perfil Estudiante</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body" id="resultado_cambiar_documento">
                        <form name="formularioeditarperfil" id="formularioeditarperfil" method="POST">
                            <input type="hidden" id="id_estudiante" value="" name="id_estudiante">
                            <input type="hidden" id="fila" value="" name="fila">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <h5>Programa de Interes</h5>
                                    <select name="fo_programa" id="fo_programa" class="form-control selectpicker" data-live-search="true">
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <h5>Jornada de Interes</h5>
                                    <select name="jornada_e" id="jornada_e" class="form-control selectpicker" data-live-search="true">
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <h5>Tipo de Documento</h5>
                                    <select name="tipo_documento" id="tipo_documento" class="form-control selectpicker" data-live-search="true">
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <h5>Primer Nombre</h5>
                                    <input type="text" name="nombre" id="nombre" class="form-control" />
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <h5>Segundo Nombre</h5>
                                    <input type="text" name="nombre_2" id="nombre_2" class="form-control" />
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <h5>Primer Apellido</h5>
                                    <input type="text" name="apellidos" id="apellidos" class="form-control" />
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <h5>Segundo Apellido</h5>
                                    <input type="text" name="apellidos_2" id="apellidos_2" class="form-control" />
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <h5>Número de Contacto</h5>
                                    <input type="number" name="celular" id="celular" class="form-control" />
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <h5>Correo Personal</h5>
                                    <input type="email" name="email" id="email" class="form-control" />
                                </div>
                            </div>
                            <br><br>
                            <div class="row well">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <h5>Nivel de Escolaridad</h5>
                                    <select name="nivel_escolaridad" id="nivel_escolaridad" class="form-control selectpicker" data-live-search="true">
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <h5>Nombre del colegio</h5>
                                    <input name="nombre_colegio" id="nombre_colegio" class="form-control" />
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <h5>Fecha de graduación *</h5>
                                    <input type="date" name="fecha_graduacion" id="fecha_graduacion" value="" class="form-control">
                                </div>
                            </div>
                            <br><br>
                            <input type="submit" value="Guardar Cambios" id="btnEditar" class="btn btn-success btn-block">
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
        <div class="modal" id="myModalMover">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title">Mover usuario</h6>
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
                                        <label>Mover usuario</label>
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
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    Nombre del Padre<br>
                                    <input type="text" name="padre" id="padre" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    Nombre de la Madre<br>
                                    <input type="text" name="madre" id="madre" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    ¿Quien sostiene sus estudios?<br>
                                    <input type="text" name="sostiene" id="sostiene" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    ¿Dedicación del padre?<br>
                                    <textarea name="dedicacion_papa" id="dedicacion_papa" rows="3" class="form-control" readonly="readonly"></textarea>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    ¿Dedicación de la madre?<br>
                                    <textarea name="dedicacion_mama" id="dedicacion_mama" rows="3" class="form-control" readonly="readonly"></textarea>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    ¿Laboran actualmente?<br>
                                    <input type="text" name="labora" id="labora" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">
                                    ¿Qué salario mensual devengan?<br>
                                    <input type="text" name="salario" id="salario" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    ¿Dónde?<br>
                                    <input type="text" name="donde_labora" id="donde_labora" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    ¿Cuantos hermanos tiene?<br>
                                    <input type="text" name="hermanos" id="hermanos" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    ¿Qué lo motiva a estudiar este progama?<br>
                                    <textarea name="motiva" id="motiva" rows="3" class="form-control" readonly="readonly"></textarea>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    ¿Conoce el plan de estudios del programa?<br>
                                    <input type="text" name="conoce_plan" id="conoce_plan" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    ¿Contemplo la posibilidad de estudiar otro programa?<br>
                                    <input type="text" name="otro_programa" id="otro_programa" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    ¿Cual programa queria estudiar? <br>
                                    <input type="text" name="cual_programa" id="cual_programa" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    ¿Porque lo descarto?<br>
                                    <input type="text" name="descarto" id="descarto" class="form-control" value="" readonly="readonly">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    ¿Porque razón escogió la CIAF?<br>
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
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/oncenterinscrito.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/on_segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/whatsapp_module.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>