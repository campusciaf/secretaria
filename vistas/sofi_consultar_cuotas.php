<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.html");
} else {
    $menu = 23;
    $submenu = 2305;
    require 'header.php';
    if ($_SESSION["soficonsultarcuotas"] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Consultar Cuotas</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">SOFI</a></li>
                                <li class="breadcrumb-item active">Consultar Cuotas</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row d-none">
                    <div id="titulo" class="col-12 "></div>
                    <div class="col-4 p-4 card">
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
                                <div class="input-group has-validation">
                                    <input type="text" placeholder="" value="" class="form-control" name="dato" id="dato" required="" disabled="" placeholder="Ingresar..">
                                    <div class="invalid-feedback">
                                        Please choose a username.
                                    </div>
                                    <div class="input-group-prepend">
                                        <input type="submit" value="Buscar" onclick="consultacliente()" class="btn btn-success" disabled="" id="btnconsulta">
                                    </div>
                                </div>
                                <div class="form-group position-relative check-valid">
                                    <div class="form-floating">
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 borde-right" id="datos_estudiante">
                        <div class="col-12 px-2 py-3 ">
                            <div class="row align-items-center">
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
                            <div class="row align-items-center">
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
                            <div class="row align-items-center">
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
                    <div class="col-12 datos_table"></div>
                    <!-- <div class="row datos_table"></div> -->
                    <div class="col-12" id="panel_resultado"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card " style="padding: 2% 1%">
                            <form action="#" class="form-horizontal" name="busqueda_cuota" id="busqueda_cuota" method="post">
                                <div class="input-group mb-3 ">
                                    <select class="form-control col-2" name="tipo_busqueda" id="tipo_busqueda" required>
                                        <option value="" disabled selected>-- Buscar por --</option>
                                        <option value="1">Cédula</option>
                                        <option value="2">Consecutivo</option>
                                        <option value="3">Nombre o Apellido</option>
                                        <option value="4">Celular</option>
                                    </select>
                                    <input class="form-control col-9" type="text" id="dato_busqueda" name="dato_busqueda" placeholder="Buscar..." required>
                                    <button type="submit" class="btn btn-success btn-flat col-1 btnBuscarCuota"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-md-3 hidden-xs hiden-sm">
                                    <!-- este es el marcado. puedes cambiar los detalles (tu propio nombre, tu propio avatar, etc.) ¡pero no cambies la estructura básica! -->
                                    <aside class="profile-card bg-radial-blue">
                                        <header class="profile-header pt-2">
                                            <!-- Aquí el avatar -->
                                            <img height="100px" class="imagen_estudiante" src="../files/null.jpg">
                                            <!-- Nombre Completo -->
                                            <h3 class="nombre_completo"> Nombre Financiado </h3>
                                            <!-- Cedula -->
                                            <p class="apellido_completo cedula"> -------------- </p>
                                        </header>
                                        <!-- bit of a bio; who are you? -->
                                        <div class="profile-bio">
                                            <ul class="list-group list-group-unbordered" style="padding-right: 8px;padding-left: 8px;">
                                                <li class="list-group-item px-2 text-white">
                                                    <b class="profile-tipocc"> -------------- </b>
                                                    <a class="float-right box-profiledates profile-documento"> -------------- </a>
                                                </li>
                                                <li class="list-group-item px-2 text-white">
                                                    <b>Dirección: </b>
                                                    <a class="float-right box-profiledates profile-direccion"> -------------- </a>
                                                </li>
                                                <li class="list-group-item px-2 text-white">
                                                    <b>Cel: </b>
                                                    <a class="float-right box-profiledates profile-celular"> -------------- </a>
                                                </li>
                                                <li class="list-group-item px-2 text-white">
                                                    <b>Email: </b>
                                                    <a class="float-right box-profiledates profile-email"> -------------- </a>
                                                </li>
                                                <li class="list-group-item px-2 text-white">
                                                    <b>Estado financiación: </b>
                                                    <a class="float-right box-profiledates estado_financiacion"> -------------- </a>
                                                </li>
                                                <li class="list-group-item px-2 text-white">
                                                    <b>Estado CIAFI: </b>
                                                    <a class="float-right box-profiledates estado_ciafi"> -------------- </a>
                                                </li>
                                                <li class="list-group-item px-2 text-white">
                                                    <b>En cobro pre-juridico: </b>
                                                    <a class="float-right box-profiledates en_cobro"> -------------- </a>
                                                </li>
                                                <li class="list-group-item px-2 text-white ">
                                                    <b>Añadir Segumiento: </b>
                                                    <a class="float-right box-profiledates seguimientos_btn"> -------------- </a>
                                                </li>
                                                <li class="list-group-item px-2 text-white ">
                                                    <b>Categorizar: </b>
                                                    <a class="float-right box-profiledates categorizar_btn"> -------------- </a>
                                                </li>
                                                <li class="list-group-item px-2 text-white ">
                                                    <b>Días Atrasado: </b>
                                                    <a class="float-right box-profiledates dias_atrados_totales"> -------------- </a>
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
                                                            <li class="list-group-item px-2 text-white">
                                                                <b>Programa:</b> <a class="float-right box-profiledates profile-programa"> -------------- </a>
                                                            </li>
                                                            <li class="list-group-item px-2 text-white">
                                                                <b>Jornada:</b> <a class="float-right box-profiledates profile-jornada"> -------------- </a>
                                                            </li>
                                                            <li class="list-group-item px-2 text-white">
                                                                <b>Semestre:</b> <a class="float-right box-profiledates profile-semestre"> -------------- </a>
                                                            </li>
                                                            <li class="list-group-item px-2 text-white">
                                                                <b>Financiado:</b> <a class="float-right box-profiledates profile-valor_financiado"> -------------- </a>
                                                            </li>
                                                            <li class="list-group-item px-2 text-white">
                                                                <b>Forma De Pago:</b> <a class="float-right box-profiledates profile-forma_pago"> -------------- </a>
                                                            </li>
                                                            <li class="list-group-item px-2 text-white">
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
                                                    <td colspan="9" class="jumbotron text-center bg-navy rounded-0"> Aquí aparecen los estudiantes</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <td>Cuotas</td>
                                                <td>Periodo</td>
                                                <td>Consecutivo</td>
                                                <td>Nombre</td>
                                                <td>Programa</td>
                                                <td>Matrícula</td>
                                                <td>Financiado</td>
                                                <td>Descuento</td>
                                                <td>Inicio</td>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="tabla_cuotas">
                                        <li class="list-group-item px-2 ">
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
                                                <td>Pago (A-M-D)</td>
                                                <td>Interes</td>
                                                <td>Días Atrasado</td>
                                                <td>Editar</td>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="8" class="jumbotron text-center bg-navy rounded-0"> Aquí aparecen las cuotas</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            </section>
        </div>
        <!-- inicio modal agregar seguimiento -->
        <div class="modal" id="myModalAgregar">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Gestión seguimientos</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php require_once "agregar_segui_tareas.php" ?>
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
        <!---------------------------------   MODAL PAGOS(ABONAR)  ----------------------------------------->
        <div class="modal fade" id="modal_abonos" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-navy modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-blue color-palette">
                        <h4 class=" title_name_sol text-white">Abono de cuotas</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="box-body">
                        <form action="#" method="post" id="formulario_abonos">
                            <div class="alert alert-warning alert-abono" role="alert">
                                <strong>Upss!</strong> El valor insertado no corresponde a un abono.
                            </div>
                            <div class="col-sm-12 form-group mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </div>
                                    </div>
                                    <input type="number" class="form-control" name="cantidad_abono" id="cantidad_abono" placeholder="Cantidad de abono" required>
                                    <input type="hidden" name="id_financiamiento" id="id_financiamiento">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            .00
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success btn-flat" id="btn_abonar">Realizar Abono</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-------------------------   MODAL PAGOS(ADELANTOS)   ------------------------------>
        <div class="modal fade" id="modal_adelantos" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-navy modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-yellow color-palette">
                        <h4 class=" text-white">Adelanto de cuotas</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="box-body">
                        <form action="#" method="post" id="formulario_adelanto">
                            <div class="alert alert-warning alert-adelanto" role="alert">
                                <strong>Upss!</strong> El valor insertado no corresponde a un adelanto.
                            </div>
                            <div class="col-sm-12 form-group mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </div>
                                    </div>
                                    <input type="number" class="form-control" name="cantidad_adelanto" id="cantidad_adelanto" placeholder="Cantidad de adelanto" required>
                                    <input type="hidden" name="consecutivo" id="consecutivo">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            .00
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success btn-flat" id="btn_adelantar">Realizar Adelanto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-------------------------------   MODAL PAGOS(ATRASOS)   -------------------------------------->
        <div class="modal fade" id="modal_atrasos" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-navy modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red color-palette">
                        <h4 class=" text-white"> Atraso de cuotas </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert_mora"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-12 text-center mb-0 pt-1">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="chequear_mora" name="chequear_mora"> Presione para calcular e incluir Mora
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="#" method="POST" id="formulario_atraso" class="container">
                            <div class="row box_incluir_mora">
                                <div class="col">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="number" placeholder="" value="" required="" class="form-control border-start-0" id="cantidad_atrasado" name="cantidad_atrasado">
                                            <input type="hidden" id="cantidad_atrasado_no_mora">
                                            <label>Abono</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="hidden" id="consecutivo_atrasado" name="consecutivo_atrasado">
                                            <input type="hidden" id="financiamiento_atrasado" name="financiamiento_atrasado">
                                            <input type="number" placeholder="" value="" required="" class="form-control border-start-0 valor_cuota" id="valor_cuota" name="valor_cuota" readonly>
                                            <label>Deuda Total</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="number" placeholder="" value="" required="" class="form-control border-start-0 valor_mora" id="valor_mora" name="valor_mora" readonly>
                                            <label>Mora</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="number" placeholder="" value="" required="" class="form-control border-start-0 pago_con_mora" id="pago_con_mora" name="pago_con_mora" readonly>
                                            <label>Abono - Mora</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="box_tabla_intereses_mora text-center" id="box_tabla_intereses_mora">
                                    <span class="badge bg-danger">* Cuando se ingrese el valor que se va a pagar. primero se aplica el interés mora y el restante se aplicará a la cuota. </span>
                                    <table id="tabla_intereses_mora" class="table table-hover" style="margin: 0px; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Mes</th>
                                                <th>Dias</th>
                                                <th>Acumulado</th>
                                                <th>Interés</th>
                                                <th>Total + Interés</th>
                                                <th>%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-12 mb-3 font-weight-bold">
                                Cantidad de abono a ínteres: <span class="bg-info p-2" id="total_abono_interes"></span>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success btn_atraso">Desatrasar</button>
                                <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!----------------------------- MODAL HISTORIAL PAGOS  --------------------------------->
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
                                <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
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
                                <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <table id="tabla_historial_mora" class="table table-hover">
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
        <!--------------- MODAL HISTORIAL PAGOS  ------------------->
        <div class="modal fade" id="modal_editar_cuotas" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class=" text-white">Editar Cuota</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
                    </div>
                    <div class="box-body">
                        <form id="formularioEditarCuotas" method="POST" action="#">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="estado_cuota">Estado de cuota</label>
                                    <select class="form-control" id="estado_cuota" name="estado_cuota">
                                        <option disabled="" selected="">Seleccione Una opción</option>
                                        <option value="A Pagar">A Pagar</option>
                                        <option value="Abonado">Abonando</option>
                                        <option value="Pagado">Pagado</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="valor_pagado">Valor Pagado</label>
                                    <input type="number" class="form-control" id="valor_pagado" name="valor_pagado" placeholder="Valor Pagado">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_pago">Fecha Pago:</label>
                                    <input type="date" class="form-control" id="fecha_pago" placeholder="Fecha de Pago" name="fecha_pago">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_plazo_pago">Plazo Pago:</label>
                                    <input type="date" class="form-control unstyled" id="fecha_plazo_pago" placeholder="Fecha de plazo" name="fecha_plazo_pago">
                                </div>
                                <div class="col-12">
                                    <input type="hidden" id="id_editar_cuota" name="id_editar_cuota">
                                    <button type="submit" class="btn btn-success btn-flat btn_editar_cuotas"><i class="fas fa-save"></i> Guardar</button>
                                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </form>
                        <!-- <form class="row" id="form-editar_cuotas" method="POST" action="#"> </form> -->
                    </div>
                </div>
            </div>
        </div>
        <!----------------------------------------------------------------------- MODAL HISTORIAL PAGOS  --------------------------------------------------------------------------->
        <div class="modal fade" id="modal_categoria" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h6 class=" text-white">Categorización de Créditos</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
                    </div>
                    <div class="box-body">
                        <form id="formularioCategorizar" class="mb-0" method="POST" action="#">
                            <div class="card-body pb-0">
                                <div class="form-group">
                                    <label for="categoria_credito"> Categorias </label>
                                    <select class="form-control" id="categoria_credito" name="categoria_credito">
                                        <option disabled selected>Seleccione Una opción</option>
                                        <option value="Sin Categoría"> Sin Categoría </option>
                                        <option value="Categoría A"> Categoría A </option>
                                        <option value="Categoría B"> Categoría B </option>
                                        <option value="Categoría C"> Categoría C </option>
                                        <option value="Categoría D"> Categoría D </option>
                                        <option value="Categoría E"> Categoría E </option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" id="consecutivo_categoria" name="consecutivo_categoria">
                                    <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-success btn-flat btnCategoria" id="btnCategoria">
                                        <i class="fas fa-save"></i> Guardar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-----------------  MODALES(Ver whatsapp)   --------------------------------->
        <div class="modal fade" id="modal_whatsapp" tabindex="-1" role="dialog" aria-labelledby="modal_whatsapp_label">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h6 class="modal-title" id="modal_whatsapp_label"> WhatsApp CIAF</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 m-0 seccion_conversacion">
                                    <?php require_once 'whatsapp_module.php'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .btn_tablas {
                font-size: 25px;
                margin-bottom: 5px;
            }

            .profile-header img {
                border-radius: 50%;
                margin: 20px auto;
                display: block;
                width: 100px;
                border: 5px solid #fff;
            }

            .profile-card {
                border-top: 0px solid #26A69A;
                border-radius: 0px;
            }

            .profile-header {
                text-align: center;
            }

            .profile-header h3 {
                position: relative;
                text-align: center;
                color: #fff;
                text-shadow: 1px 1px rgba(0, 0, 0, 0.5);
                font-size: 25px;
                line-height: 25px;
                display: inline-block;
                padding: 10px;
                transition: all ease 0.250s;
            }

            .profile-header .cedula {
                text-align: center;
                color: #fff !important;
                text-shadow: 1px 1px rgba(0, 0, 0, 0.5);
                font-size: 17px;
                font-weight: normal;
                line-height: 0px;
                margin: 0;
            }

            .profile-bio {
                margin-top: 20px;
                padding: 1px 3px 10px 3px !important;
                transition: all linear 1.5s;
                font-size: 14px;
            }

            .list-group-item {
                background-color: transparent !important;
            }
        </style>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/sofi_consultar_cuotas.js?<?= date("Y-m-d") ?>"></script>
<script type="text/javascript" src="scripts/segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/agregar_segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="scripts/whatsapp_module.js?<?= date("Y-m-d") ?>"></script>