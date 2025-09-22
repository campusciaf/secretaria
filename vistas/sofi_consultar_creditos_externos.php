<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.html");
} else {
    $menu = 23;
    $submenu = 2325;
    require 'header.php';
    if ($_SESSION["sofi_consultar_creditos_externos"] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16 pl-4">
                                <span class="titulo-2 fs-18 text-semibold">Externos - Consultar Créditos</span><br>
                                <span class="fs-14 f-montserrat-regular">Consulta información del crédito de nuestros seres originales.</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick="iniciarTour()"><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <form class="col-12 mt-3" action="#" name="busqueda_cuota" id="busqueda_cuota" method="post">
                            <div class="input-group mb-3 ">
                                <select class="form-control col-2" name="tipo_busqueda" id="tipo_busqueda" required>
                                    <option value="" disabled selected>-- Buscar por --</option>
                                    <option value="1"> Cédula</option>
                                    <option value="2"> Consecutivo</option>
                                    <option value="3"> Nombre o Apellido</option>
                                </select>
                                <input class="form-control col-9" type="text" id="dato_busqueda" name="dato_busqueda" placeholder="Buscar..." required>
                                <button type="submit" class="btn btn-success btn-flat col-1 btnBuscarCuota"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-md-3 hidden-xs hiden-sm">
                            <!-- este es el marcado. puedes cambiar los detalles (tu propio nombre, tu propio avatar, etc.) ¡pero no cambies la estructura básica! -->
                            <aside class="profile-card bg-radial-blue">
                                <header class="profile-header pt-2 text-center">
                                    <!-- Aquí el avatar -->
                                    <img height="100px" width="100px" class="imagen_estudiante img-thumbnail rounded-circle mb-3" src="../files/null.jpg">
                                    <br>
                                    <!-- Nombre Completo -->
                                    <h3 class="nombre_completo text-dark h3 badge bg-white" style="font-size: 1rem !important;"> Nombre Financiado </h3>
                                    <br>
                                    <!-- Cedula -->
                                    <p class="apellido_completo cedula  text-dark h3 badge bg-white" style="font-size: 1rem !important;"> -------------- </p>
                                </header>
                                <!-- bit of a bio; who are you? -->
                                <div class="profile-bio">
                                    <ul class="list-group list-group-unbordered" style="padding-right: 8px;padding-left: 8px;">
                                        <li class="list-group-item px-2">
                                            <b class="profile-tipocc"> -------------- </b>
                                            <a class="float-right box-profiledates profile-documento"> -------------- </a>
                                        </li>
                                        <li class="list-group-item px-2">
                                            <b>Dirección: </b>
                                            <a class="float-right box-profiledates profile-direccion"> -------------- </a>
                                        </li>
                                        <li class="list-group-item px-2">
                                            <b>Cel: </b>
                                            <a class="float-right box-profiledates profile-celular"> -------------- </a>
                                        </li>
                                        <li class="list-group-item px-2">
                                            <b>Email: </b>
                                            <a class="float-right box-profiledates profile-email"> -------------- </a>
                                        </li>
                                        <li class="list-group-item px-2">
                                            <b>Estado financiación: </b>
                                            <a class="float-right box-profiledates estado_financiacion"> -------------- </a>
                                        </li>
                                        <li class="list-group-item px-2">
                                            <b>Seguimientos: </b>
                                            <a class="float-right box-profiledates estado_seguimientos"> -------------- </a>
                                        </li>
                                        <li class="list-group-item px-2">
                                            <b>Estado CIAFI: </b>
                                            <a class="float-right box-profiledates estado_ciafi"> -------------- </a>
                                        </li>
                                        <li class="list-group-item px-2">
                                            <b>En cobro pre-juridico: </b>
                                            <a class="float-right box-profiledates en_cobro"> -------------- </a>
                                        </li>
                                        <li class="list-group-item px-2 ">
                                            <b>Categorizar: </b>
                                            <a class="float-right box-profiledates categorizar_btn"> -------------- </a>
                                        </li>
                                    </ul>
                                    <br>
                                </div>
                                <div id="accordion">
                                    <div class="card rounded-0">
                                        <div class="card-header">
                                            <h4 class="card-title w-100">
                                                <a class="d-block w-100" data-toggle="collapse" href="#collapseThree" aria-expanded="true">
                                                    Consecutivo
                                                    <b class="profile-consecutivo float-right"># ---- </b>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseThree" class="collapse show bg-radial-blue" data-parent="#accordion">
                                            <div class="card-body px-1 pb-0">
                                                <ul class="list-group list-group-unbordered" style="padding-right: 8px;padding-left: 8px">
                                                    <li class="list-group-item px-2">
                                                        <b>Programa:</b> <a class="float-right box-profiledates profile-programa"> -------------- </a>
                                                    </li>
                                                    <li class="list-group-item px-2">
                                                        <b>Jornada:</b> <a class="float-right box-profiledates profile-jornada"> -------------- </a>
                                                    </li>
                                                    <li class="list-group-item px-2">
                                                        <b>Semestre:</b> <a class="float-right box-profiledates profile-semestre"> -------------- </a>
                                                    </li>
                                                    <li class="list-group-item px-2">
                                                        <b>Financiado:</b> <a class="float-right box-profiledates profile-valor_financiado"> -------------- </a>
                                                    </li>
                                                    <li class="list-group-item px-2">
                                                        <b>Forma De Pago:</b> <a class="float-right box-profiledates profile-forma_pago"> -------------- </a>
                                                    </li>
                                                    <li class="list-group-item px-2">
                                                        <b>Tiempo:</b> <a class="float-right box-profiledates profile-cantidad_tiempo"> -------------- </a>
                                                    </li>
                                                </ul>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </aside>
                        </div>
                        <div class="col-sm-9 ">
                            <div class="tabla_info table-responsive">
                                <table id="tabla_info" class="table table-hover">
                                    <thead>
                                        <td>Cuotas</td>
                                        <td>Periodo</td>
                                        <td>Consecutivo</td>
                                        <td>Nombre</td>
                                        <td>Programa</td>
                                        <td>Matrícula</td>
                                        <td>Financiado</td>
                                        <td>Descuento</td>
                                        <td>Inicio</td>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="9" class="text-center rounded-0"> Aquí aparecen los estudiantes</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tabla_cuotas">
                                <li class="list-group-item px-2">
                                    <b> Saldo Débito:
                                        <b class="historial_pagos">
                                        </b>
                                    </b>
                                    <a class="float-right box-profiledates saldo_debito"> -------------- </a>
                                    <input type="hidden" id="input_saldo_debito" name="input_saldo_debito">
                                    <a class="float-right" style="padding-right: 2px">$ </a>
                                </li>
                                <table id="tabla_cuotas" class="table table-hover ">
                                    <thead>
                                        <td>Estado</td>
                                        <td># Cuota</td>
                                        <td>Valor Cuota</td>
                                        <td>Valor Pagado</td>
                                        <td>Fecha Pago (A-M-D)</td>
                                        <td>Días Atrasado</td>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="8" class="text-center rounded-0"> Aquí aparecen las cuotas</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!----------------------------------------------------------------------- MODAL HISTORIAL PAGOS  --------------------------------------------------------------------------->
        <div class="modal fade" id="modal_historial_pagos" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-purple color-palette">
                        <h4 class=" text-white">Historial de pago</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
                    </div>
                    <div class="box-body">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <table id="tabla_historial" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th># Concecutivo</th>
                                                <th># Cuota</th>
                                                <th>Fecha Cuota</th>
                                                <th>Fecha De Pago</th>
                                                <th>Valor Pagado</th>
                                            </tr>
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
        <!-- fin modal agregar seguimiento -->
        <div class="modal" id="myModalHistorial">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title">Listado Consulta</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php require_once "segui_tareas.php" ?>
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
<script type="text/javascript" src="scripts/segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/agregar_segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/sofi_consultar_creditos_externos.js?<?= date("Y-m-d") ?>"></script>
