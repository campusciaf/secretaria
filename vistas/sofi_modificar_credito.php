<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.html");
} else {
    $menu = 23;
    $submenu = 2311;
    require 'header.php';
    if ($_SESSION["sofi_modificar_credito"] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 titulo-4">Modificación de créditos</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">SOFI</a></li>
                                <li class="breadcrumb-item active">Modificar créditos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <form action="#" class="form-horizontal" name="busqueda_cuota" id="busqueda_cuota" method="post">
                                <div class="input-group mb-3 ">
                                    <select class="form-control col-2" name="tipo_busqueda" id="tipo_busqueda" required>
                                        <option value="" disabled selected>-- Buscar por --</option>
                                        <option value="1">Cédula</option>
                                        <option value="2">Consecutivo</option>
                                        <option value="3">Nombre o Apellido</option>
                                    </select>
                                    <input class="form-control col-9" type="text" id="dato_busqueda" name="dato_busqueda" placeholder="Buscar..." required>
                                    <button type="submit" class="btn btn-success btn-flat col-1 btnBuscarCuota"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="tabla_info">
                                        <table id="tabla_info" class="table table-hover ">
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
                                        </table>
                                    </div>
                                    <div class="tabla_cuotas">
                                        <li class="list-group-item">
                                            <b> Saldo Débito:<b class="historial_pagos"></b></b>
                                            <a class="float-right box-profiledates saldo_debito"> -------------- </a>
                                            <a class="float-right" style="padding-right: 2px">$ </a>
                                        </li>
                                        <table id="tabla_cuotas" class="table table-hover">
                                            <thead>
                                                <td>Cuota</td>
                                                <td>Estado</td>
                                                <td>Valor Cuota</td>
                                                <td>Valor Pagado</td>
                                                <td>Pago (AA-MM-DD)</td>
                                                <td>Plazo (AA-MM-DD)</td>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="8" class="jumbotron text-center bg-navy rounded-0"> Aquí aparecen las cuotas</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12 hidden-xs hiden-sm">
                                    <aside class="row bg-radial-blue">
                                        <header class="profile-header pt-4 col-12">
                                            <!-- Aquí el avatar -->
                                            <img height="200px" class="imagen_estudiante" src="../files/null.jpg">
                                            <!-- Nombre Completo -->
                                            <h3 class="nombre_completo"> Nombre Financiado </h3>
                                            <!-- Cedula -->
                                            <p class="apellido_completo cedula"> -------------- </p>
                                        </header>
                                        <div class="col-6 mt-3">
                                            <!-- bit of a bio; who are you? -->
                                            <div class="profile-bio">
                                                <ul class="list-group list-group-unbordered" style="padding-right: 8px;padding-left: 8px; background: white; color: black">
                                                    <li class="list-group-item">
                                                        <b class="profile-tipocc"> -------------- </b> <a class="float-right box-profiledates profile-documento"> -------------- </a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Dirección:</b> <a class="float-right box-profiledates profile-direccion"> -------------- </a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Cel:</b> <a class="float-right box-profiledates profile-celular"> -------------- </a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Email:</b> <a class="float-right box-profiledates profile-email"> -------------- </a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Estado financiación:  <b class="estado_financiacion"> -------------- </b></b>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Estado CIAFI:  <b class="estado_ciafi"> -------------- </b></b>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>En cobro pre-juridico:  <b class="en_cobro"> -------------- </b> </b>
                                                    </li>
                                                    <li class="list-group-item ">
                                                        <b>Añadir Segumiento: </b> <b class="seguimientos_btn"> -------------- </b>
                                                    </li>
                                                    <li class="list-group-item ">
                                                        <b>Categorizar: </b> <b class="categorizar_btn"> -------------- </b>
                                                    </li>
                                                </ul>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="col-6 mt-3">
                                            <div id="accordion">
                                                <div id="collapseThree" class="collapse show" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <ul class="list-group list-group-unbordered" style="padding-right: 8px;padding-left: 8px; background: white; color: black">
                                                            <li class="list-group-item">
                                                                <b>Programa:</b> <a class="float-right box-profiledates profile-programa"> -------------- </a>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <b>Jornada:</b> <a class="float-right box-profiledates profile-jornada"> -------------- </a>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <b>Semestre:</b> <a class="float-right box-profiledates profile-semestre"> -------------- </a>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <b>Financiado:</b> <a class="float-right box-profiledates profile-valor_financiado"> -------------- </a>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <b>Forma De Pago:</b> <a class="float-right box-profiledates profile-forma_pago"> -------------- </a>
                                                            </li>
                                                            <li class="list-group-item">
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
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!--------------------------------------------------------------------- MODAL TAREAS Y SEGUIMIENTOS ------------------------------------------------------------------------>
        <div class="modal modal-default fade" id="verTareas" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-air-force">
                        <h4 class="modal-title"> Tareas y Seguimientos </h4>
                        <button type="button" class="btn btn-outline-success agregarSegumiento">
                            Añadir
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body bg-white">
                        <div class="row">
                            <div class="col-12" id="forms_tareas_segs">
                                <div class="box-body">
                                    <div class="box-header form-group text-center col-12" style="background:#3c8dbc">
                                        <div class=" col-md-12 text-center">
                                            <h2 class="box-title" style="color: #ffffff;">
                                                <strong>Añadir Tarea</strong>
                                            </h2>
                                        </div>
                                    </div>
                                    <form name="formularioTareas" action="#" class="form-group" id="formularioTareas" method="POST">
                                        <div class="form-group col-12">
                                            <label class="help-block"><i id="span-tarea_motivo" class="fa"></i> Motivo De tarea: </label>
                                            <label class="radio-inline">
                                                <input type="radio" class="input-tarea" name="tarea_motivo" checked="" value="Llamada" required=""> Llamada</label>
                                            <label class="radio-inline">
                                                <input type="radio" class="input-tarea" name="tarea_motivo" value="Observacion" required=""> Observación</label>
                                            <label class="radio-inline">
                                                <input type="radio" class="input-tarea" name="tarea_motivo" value="Cita" required=""> Cita</label>
                                        </div>
                                        <div class="form-group col-12">
                                            <label class="help-block"><i id="span-tarea_descripcion" class="fa"></i> Descripción del tarea: </label>
                                            <textarea class="form-control col-md-12" rows="6" name="tarea_descripcion" id="tarea_descripcion" placeholder="Observaciones..." required=""></textarea>
                                        </div>
                                        <div class="form-group col-12">
                                            <label class="help-block"><i id="span-tarea_hora" class="fa"></i> Hora de la tarea: </label>
                                            <input type="time" class="form-control col-md-12 timepicker" name="tarea_hora" id="tarea_hora" required="">
                                        </div>
                                        <div class="form-group col-12">
                                            <label class="help-block"><i id="span-tarea_fecha" class="fa"></i> Fecha de la tarea: </label>
                                            <input type="date" class="form-control col-md-12" name="tarea_fecha" id="tarea_fecha" required="">
                                        </div>
                                        <input type="hidden" class="idpersonaseg" name="id_persona_tarea" id="id_persona_tarea" value="">
                                        <div class="btn-group col-12">
                                            <button class="btn btn-danger btn-flat mostrarSeguimientos" type="button"><i class="fas fa-undo-alt"></i> Regresar </button>
                                            <button type="submit" class="btn btn-success col-lg-6 col-md-6 col-sm-6 col-xs-6 btn-flat">
                                                <i class="fas fa-save"></i> Guardar </button>
                                        </div>
                                    </form>
                                    <div class="box-header form-group text-center col-12" style="background:#3c8dbc">
                                        <div class=" col-md-12 text-center">
                                            <h2 class="box-title" style="color: #ffffff;">
                                                <strong>Añadir Seguimiento</strong>
                                            </h2>
                                        </div>
                                    </div>
                                    <form name="formularioSeguimientos" class="form-group" id="formularioSeguimientos" method="POST">
                                        <div class="form-group col-12">
                                            <label class="help-block"><i id="span-seg_tipo" class="fa"></i> Tipo De Seguimiento: </label>
                                            <input type="text" class="form-control" maxlength="30" name="seg_tipo" id="seg_tipo" placeholder="Ej: Llamada, Observación..." required="">
                                        </div>
                                        <div class="form-group col-12">
                                            <label class="help-block"><i id="span-seg_descripcion" class="fa"></i> Descripción del seguimiento: </label>
                                            <textarea class="form-control col-md-12" rows="6" name="seg_descripcion" id="seg_descripcion" placeholder="Observaciones... "></textarea>
                                        </div>
                                        <input type="hidden" class="idpersonaseg" name="id_persona_seguimiento" id="id_persona_seguimiento" value="">
                                        <div class="btn-group col-12">
                                            <button class="btn btn-danger btn-flat mostrarSeguimientos" type="button"> <i class="fas fa-undo-alt"></i> Regresar </button>
                                            <button class="btn btn-success btn-flat" id="btnGuardarSeguimiento" type="submit">
                                                <i class="fas fa-save"></i> Guardar </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-12" id="tablas_tareas_segs">
                                <h3 class="text-center"> Tareas</h3>
                                <table id="tabla_tareas" class="table table-hover search_cuota">
                                    <thead>
                                        <th>Motivo </th>
                                        <th>Descripción </th>
                                        <th>Fecha </th>
                                        <th>Hora </th>
                                        <th>Asesor </th>
                                    </thead>
                                    <tbody>
                                        <!-- Datos Impresos de la base de datos -->
                                    </tbody>
                                    <tfoot>
                                        <th>Motivo </th>
                                        <th>Descripción </th>
                                        <th>Fecha </th>
                                        <th>Hora </th>
                                        <th>Asesor </th>
                                    </tfoot>
                                </table>
                                <h3 class="text-center"> Seguimientos </h3>
                                <table id="tabla_seguimiento" class="table table-hover search_cuota ">
                                    <thead>
                                        <th>Tipo </th>
                                        <th>Descripción </th>
                                        <th>Fecha y Hora </th>
                                        <th>Asesor </th>
                                    </thead>
                                    <tbody>
                                        <!-- Datos Impresos de la base de datos -->
                                    </tbody>
                                    <tfoot>
                                        <th>Tipo </th>
                                        <th>Descripción </th>
                                        <th>Fecha y Hora </th>
                                        <th>Asesor </th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-air-force">
                        <button type="button" class="btn btn-outline-secondary btn-cerrar pull-left" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-outline-success agregarSegumiento">Añadir <i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <!----------------------------------------------------------------------- MODAL HISTORIAL PAGOS  --------------------------------------------------------------------------->
        <div class="modal fade" id="modal_historial_pagos" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-purple color-palette">
                        <h4 class="modal-title">Historial de pago</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
                    </div>
                    <div class="box-body bg-white">
                        <table id="tabla_historial" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Concecutivo</th>
                                    <th>Cuota</th>
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
        <!----------------------------------------------------------------------- MODAL Categoria --------------------------------------------------------------------------->
        <div class="modal fade" id="modal_categoria" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h6 class="modal-title">Categorización de Créditos</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
                    </div>
                    <div class="box-body bg-white">
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
                                    <button type="submit" class="btn btn-success btn-flat btnCategoria" id="btnCategoria"><i class="fas fa-save"></i> Guardar</button>
                                </div>
                            </div>
                        </form>
                        <!-- <form class="row" id="form-editar_cuotas" method="POST" action="#"> </form> -->
                    </div>
                </div>
            </div>
        </div>
        <!----------------------------------------------------------------------- MODAL Categoria --------------------------------------------------------------------------->
        <div class="modal fade" id="modal_crear_cuota" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h6 class="modal-title">Insertar nueva cuota</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
                    </div>
                    <div class="box-body bg-white">
                        <form id="formularioCrearCuota" class="mb-0" method="POST" action="#">
                            <div class="form-row pb-0 p-2">
                                <div class="form-group col-6">
                                    <input type="hidden" id="consecutivo_cuota" name="consecutivo_cuota">
                                    <input type="hidden" id="persona_cuota" name="persona_cuota">
                                    <label for="numero_cuota"> Número de cuota </label>
                                    <input type="number" class="form-control" name="numero_cuota" id="numero_cuota">
                                </div>
                                <div class="form-group col-6">
                                    <label for="estado"> Estado </label>
                                    <select class="form-control" id="estado" name="estado">
                                        <option value="A Pagar"> A Pagar </option>
                                        <option value="Abonado"> Abonado </option>
                                        <option value="Pagado"> Pagado </option>
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label for="valor_cuota"> Valor de cuota </label>
                                    <input type="number" class="form-control" name="valor_cuota" id="valor_cuota">
                                </div>
                                <div class="form-group col-6">
                                    <label for="valor_pagado"> Valor pagado </label>
                                    <input type="number" class="form-control" name="valor_pagado" id="valor_pagado" value="0">
                                </div>
                                <div class="form-group col-6">
                                    <label for="fecha_pago"> Fecha de pago </label>
                                    <input type="date" class="form-control" name="fecha_pago" id="fecha_pago">
                                </div>
                                <div class="form-group col-6">
                                    <label for="plazo_pago"> Fecha de plazo </label>
                                    <input type="date" class="form-control" name="plazo_pago" id="plazo_pago">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-success btn-flat btnCrearCuota" id="btnCrearCuota"><i class="fas fa-save"></i> Guardar</button>
                                </div>
                            </div>
                        </form>
                        <!-- <form class="row" id="form-editar_cuotas" method="POST" action="#"> </form> -->
                    </div>
                </div>
            </div>
        </div>
        <!----------------------------------------------------------------------  STYLE DE CARD PROFILE  --------------------------------------------------------------------------->
        <style>
            .btn_tablas {
                background: white !important;
                font-size: 25px;
                margin-bottom: 5px;
            }

            .profile-header img {
                border-radius: 50%;
                margin: 20px auto;
                display: block;
                width: 200px;
                border: 5px solid #fff;
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
                border-top: 1px solid #fff;
                border-bottom: 1px solid #fff;
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
                padding: 1px 20px 10px 20px !important;
                transition: all linear 1.5s;
                color: #fff;
                font-size: 14px;
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
<script src="scripts/sofi_modificar_credito.js"></script>