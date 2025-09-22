<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 23;
    $submenu = 2302;
    $estado = isset($_GET["estado"]) ? $_GET["estado"] : "Pendiente";
    require 'header.php';
    if ($_SESSION['sofisolicitud'] == 1) {
?>
        <!--Contenido Content Wrapper. Contains page content -->
        <link rel="stylesheet" href="../public/css/morris.css">
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Créditos</span><br>
                                <span class="fs-14 f-montserrat-regular">Consulta de créditos SOFI</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Créditos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="row " id="tablaregistros">

                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select name="estado" id="estado" class="form-control grupo_etnico">
                                                <option value="" disabled>- Selecciona un estado -</option>
                                                <option <?= ($estado == "Todos") ? "selected" : "" ?> value="Todos"> Todos los estados </option>
                                                <option <?= ($estado == "Pendiente") ? "selected" : "" ?> value="Pendiente"> Pendiente </option>
                                                <option <?= ($estado == "Pre-Aprobado") ? "selected" : "" ?> value="Pre-Aprobado"> Pre-Aprobado </option>
                                                <option <?= ($estado == "Aprobado") ? "selected" : "" ?> value="Aprobado"> Aprobado </option>
                                                <option <?= ($estado == "Anulado") ? "selected" : "" ?> value="Anulado"> Anulado </option>
                                            </select>
                                            <label>- Selecciona un estado -</label>
                                            <input type="hidden" value="No pertenece" class="form-control nom_et">
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>

                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select name="periodo" id="periodo" class="form-control grupo_etnico">
                                            </select>
                                            <label>- Periodo -</label>
                                            <input type="hidden" value="No pertenece" class="form-control nom_et">
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>


                                <div class="col-md-3">
                                    <button type="button" class="btn btn-success buscar_estudiantes py-3"> <i class="fas fa-search"></i> Buscar</button>
                                </div>
                                <div class="col-12 table-responsive">
                                    <table id="tabla_financiados" class="table table-hover table-nowarp table-sm search_cuota ">
                                        <thead>
                                            <th>Opciones</th>
                                            <th>Estado credito</th>
                                            <th>Cédula</th>
                                            <th>Nombre Completo</th>
                                            <th>Correo</th>
                                            <th>Labora</th>
                                            <th>Periodo</th>
                                            <th>Datacredito</th>
                                            <th>Ticket</th>
                                            <th>Estado</th>
                                            <th>Etiquéta</th>
                                        </thead>
                                        <tbody>
                                            <!-- Datos Impresos de la base de datos -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <form name="formulariopersona" class="row" id="formularioregistros" method="POST">
                                <input type="hidden" name="idpersona" id="editar_id_persona" value="4494">
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label class="help-block"><i id="span-tipo_documento" class="fa"></i> Tipo Documento <small>*</small>:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-id-card"></i>
                                            </div>
                                        </div>
                                        <select class="form-control select-picker" name="tipo_documento" id="tipo_documento" required="">
                                            <option value="CÉDULA">CÉDULA</option>
                                            <option value="NIT">NIT</option>
                                            <option value="TI">TARJETA DE IDENTIDAD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label class="help-block"><i id="span-numero_documento" class="fa"></i> Número Documento <small>*</small>:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hashtag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="numero_documento" id="numero_documento" placeholder="Documento" required="">

                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label class="help-block"><i id="span-nombres" class="fa"></i> Nombre(s) <small>*</small>:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-user-tag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="nombres" id="nombres" maxlength="50" placeholder="Nombre(s) del Estudiante" required="">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label class="help-block"><i id="span-apellidos" class="fa"></i> Apellidos <small>*</small>:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-user-tag"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Apellidos" required="">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label class="help-block"><i id="span-fecha_nacimiento" class="fa"></i> Fecha de nacimiento <small>*</small>:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </div>
                                        <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" required="">
                                    </div>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label class="help-block"><i id="span-estado_civil" class="fa"></i> Estado cívil <small>*</small>:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-heart"></i>
                                            </div>
                                        </div>
                                        <select class="form-control select-picker" name="estado_civil" id="estado_civil">
                                            <option value="SOLTERO/A">Soltero/a</option>
                                            <option value="UNIÓN LIBRE">Unión Libre</option>
                                            <option value="CASADO/A">Casado/a</option>
                                            <option value="SEPERADO/A">Separado/a</option>
                                            <option value="DIVORCIADO/A">Judicialmente divorciado/a</option>
                                            <option value="VIUDO/A">Viudo/a</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label class="help-block"><i id="span-direccion" class="fa"></i> Dirección <small>*</small>:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-home"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" name="direccion" id="direccion" maxlength="50" placeholder="Dirección de residencia" required="">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label class="help-block"><i id="span-ciudad" class="fa"></i> Departamento <small>*</small>:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-map"></i>
                                            </div>
                                        </div>
                                        <select class="form-control select-picker departamento" onchange="listarMunicipios(this.value)" name="departamento" id="departamento">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label class="help-block"><i id="span-ciudad" class="fa"></i> Ciudad <small>*</small>:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-map"></i>
                                            </div>
                                        </div>
                                        <select class="form-control select-picker ciudad" name="ciudad" id="ciudad" required="">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                    <label class="help-block"><i id="span-telefono" class="fa"></i>Teléfono <small>(Opcional)</small>:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                        </div>
                                        <input type="number" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="Teléfono">
                                    </div>
                                </div>
                                <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                    <label class="help-block"><i id="span-celular" class="fa"></i> Celular <small>*</small>:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-mobile-alt"></i>
                                            </div>
                                        </div>
                                        <input type="number" class="form-control" name="celular" id="celular" maxlength="20" placeholder="Número de celular" required="">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label class="help-block"><i id="span-email" class="fa"></i> Email <small>*</small>:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-envelope"></i>
                                            </div>
                                        </div>
                                        <input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email" required="">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label class="help-block"><i id="span-ocupacion" class="fa"></i> Ocupación <small>*</small>:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" maxlength="30" name="ocupacion" id="ocupacion" placeholder="Ocupación" required="">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label class="help-block"><i id="span-persona_a_cargo" class="fa"></i> Número de personas a cargo <small>*</small>: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>
                                        <input type="number" class="form-control" name="persona_a_cargo" id="persona_a_cargo" placeholder="Número de personas a cargo">
                                    </div>
                                </div>
                                <input type="hidden" name="tipo" id="tipo" value="Solicitante">
                                <input type="hidden" name="id_persona_editar" id="id_persona_editar">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button class="btn btn-success btn-flat" type="submit"> Guardar <i class="fa fa-forward"></i></button>
                                    <button class="btn btn-danger btn-flat" onclick="cancelarform()" type="button"> Cancelar </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-----------------------------------------------------------------------MODALES(Anular solicitud)------------------------------------------------------------------------>
        <div class="modal fade" id="confirmareliminacion" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content bg-danger">
                    <form name="formularioanulacion" id="formularioanulacion" method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title">Anular Solicitud</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body ">
                            <p>¿Deseas cancelar solicitud de financiamiento? </p>
                            <label for="motivo_cancela"> Motivo de anular </label>
                            <select class="form-control" name="motivo_cancela" id="motivo_cancela" required>
                                <option disabled selected value="">Selecciona un Motivo de financiación</option>
                                <option value="información errada">información errada</option>
                                <option value="Estudiante no adquiere el crédito, realiza Otro medio de pago">Estudiante no adquiere el crédito, realiza Otro medio de pago</option>
                                <option value="Motivos de retiro, no inicia proceso académico este semestre">Motivos de retiro, no inicia proceso académico este semestre</option </select>
                                <input type="hidden" name="id_persona_anulada" id="id_persona_anulada" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary float-left" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Anular Solicitud</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!----------------------------------------------------------------------MODALES(Ver detalles)------------------------------------------------------------------------------>
        <div class="modal fade" id="verInfoSolicitante">
            <div class="modal-dialog modal-md">
                <div class="modal-content bg-teal">
                    <div class="modal-header bg-teal-active color-palette">
                        <h4 class="modal-title title_name_sol">Nombre Estudiante</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="box-body nav-tabs-custom ">
                        <ul class="nav nav-pills p-2">
                            <li class="nav-item data_infosol"><a class="nav-link active" href="#tab_no_1" data-toggle="tab">Información Personal</a></li>
                            <li class="nav-item data_refsol"><a class="nav-link" href="#tab_no_2" data-toggle="tab">Referencias</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_no_1">
                                <table class="table  table-condensed">
                                    <tbody>
                                        <tr>
                                            <td><strong>Tipo De Documento: </strong><span class="float-right info-tipo_documento"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>N° Documento: </strong><span class="float-right info-numero_documento"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nombre Completo: </strong> <span class="float-right info-nombres"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Apellido: </strong><span class="float-right info-apellidos"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Fecha Nacimiento: </strong><span class="float-right info-fecha_nacimiento"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Dirección De Residencia: </strong> <span class="float-right info-direccion"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ciudad: </strong> <span class="float-right info-ciudad"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Teléfono: </strong> <span class="float-right info-telefono"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Celular: </strong> <span class="float-right info-celular"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email: </strong> <span class="float-right info-email"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ocupación: </strong> <span class="float-right info-ocupacion"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Periodo: </strong> <span class="float-right info-periodo"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input class="info-idsolicitante" type="hidden">
                            </div>
                            <div class="tab-pane" id="tab_no_2">
                                <table class="table  table-condensed">
                                    <tbody class="table-references">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!----------------------------MODALES(Pre-Aprobar)------------------------------------------------------------------------------>
        <div class="modal fade" id="confirmarpreaprobacion" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content bg-info">
                    <div class="modal-header">
                        <h4 class="modal-title">Pre-Aprobación de proceso</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body ">
                        <p>¿Estas segur@ de cambiar el estado a <strong>Pre-Aprobado?</strong> Si la respuesta es <strong>SI</strong> por favor, seleccione en aceptar. </p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="id_persona_pre_aprobada">
                        <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success pre-aprobacion" id="pre-aprobacion">Aceptar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-----------------------------------------------------------------------MODALES(Matricular)------------------------------------------------------------------------------>
        <div class="modal fade" id="confirmaraprobacion" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-green">
                    <div class="modal-header">
                        <h4 class="modal-title">Formulario Matrícula</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body ">
                        <div class="box-body">
                            <div class="formulariohidden">
                                <form name="formulariomatricula" id="formulariomatricula" class="row" method="POST">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block text-dark"><i id="span-consecutivo" class="span-consecutivo fa"></i> Consecutivo : </label>
                                        <input type="number" class="form-control rounded-0 consecutivo" name="consecutivo" id="consecutivo" placeholder="Número de consecutivo" required="">
                                        <input type="hidden" class="form-control rounded-0" name="id_persona" id="id_persona">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block text-dark"><i id="span-programa" class="span-programa fa"></i> Nombre del programa : </label>
                                        <select type="text" class="form-control rounded-0 col-md-12 programa" maxlength="100" name="programa" id="programa" data-live-search="true" data-style="btn-new" required>

                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block text-dark"><i id="span-semestre" class="span-semestre fa"></i> Semestre :</label>
                                        <input type="number" class="form-control rounded-0 semestre" maxlength="50" name="semestre" id="semestre" placeholder="Semestre del programa" required="">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block text-dark"><i id="span-jornada" class="span-jornada fa"></i> Jornada :</label>
                                        <select type="text" class="form-control rounded-0 col-md-12 jornada" maxlength="30" name="jornada" id="jornada" required="">
                                            <option disabled="" selected="">Selecciona una jornada</option>
                                            <option value="MAÑANA">Mañana</option>
                                            <option value="TARDE">Tarde</option>
                                            <option value="NOCHE">Noche</option>
                                            <option value="SABATINA">Sábados</option>
                                            <option value="FINES DE SEMANA">Fines de semana</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block text-dark"><i id="span-valor_total" class="span-valor_total fa"></i> Valor de la matrícula : </label>
                                        <input type="number" class="form-control rounded-0 valor_total" maxlength="30" name="valor_total" id="valor_total" placeholder="Valor total de la matrícula" required="">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block text-dark"><i id="span-valor_financiacion" class="span-valor_financiacion fa"></i> Valor A Financiar :</label>
                                        <input type="number" class="form-control rounded-0 valor_financiacion" maxlength="30" name="valor_financiacion" id="valor_financiacion" placeholder="Valor de la financiación" required="">
                                    </div>
                                    <div class="form-group col-12">
                                        <label class="help-block text-dark"> 
                                            Motivo Financiación:
                                        </label>
                                        <select class="form-control rounded-0 col-md-12 motivo_financiacion" name="motivo_financiacion" id="motivo_financiacion" required>
                                            <option disabled="" selected="" value="">Selecciona un Motivo de financiación</option>
                                            <option value="Financiación matricula">Financiación matricula</option>
                                            <option value="Financiación curso de ingles">Financiación curso de ingles</option>
                                            <option value="Financiación Seminario trabajo de grado">Financiación Seminario trabajo de grado</option>
                                            <option value="Financiación Derechos de grado">Financiación Derechos de grado</option>
                                            <option value="Entre Otros">Entre Otros</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block text-dark"><i id="span-descuento" class="span-descuento fa"></i> Descuento : <small>(Opcional)</small></label>
                                        <input type="number" class="form-control rounded-0 descuento" maxlength="30" name="descuento" id="descuento" placeholder="Si tiene algún descuento, indíquelo">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block text-dark"><i id="span-descuento_por" class="span-descuento_por fa"></i> Motivo Descuento : <small>(Opcional)</small></label>
                                        <input type="text" class="form-control rounded-0 descuento_por" maxlength="30" name="descuento_por" id="descuento_por" placeholder="Motivo del descuento">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block text-dark"><i id="span-fecha_inicial" class="span-fecha_inicial fa"></i> Fecha Inicial : <small style="color: darkred"> <strong>! Desde esta fecha empezará a contar la primera cuota. </strong></small> </label>
                                        <input type="date" class="form-control rounded-0 fecha_inicial" onchange="verificar_dia(this.value)" name="fecha_inicial" id="fecha_inicial" required="">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block text-dark"><i id="span-primer_curso" class="span-primer_curso fa"></i>El estudiante es de primer curso:</label>
                                        <br class="hidden-xs hidden-sm">
                                        <select class="form-control rounded-0 col-md-12" name="primer_curso" id="primer_curso">
                                            <option selected disabled value="">-- Selecciona una opcion --</option>
                                            <option value="1">Si</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block text-dark"><i id="span-dia_pago" class="span-dia_pago fa"></i> Modo de pago : </label>
                                        <select class="form-control rounded-0 select-picker dia_pago" name="dia_pago" id="dia_pago">
                                            <option value="Mensual">Mensual</option>
                                            <option value="Quincenal">Quincenal</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block text-dark"><i id="span-cantidad_tiempo" class="span-cantidad_tiempo fa"></i> ¿A cuántos meses? :</label>
                                        <input type="number" class="form-control rounded-0 cantidad_tiempo" maxlength="30" name="cantidad_tiempo" id="cantidad_tiempo" placeholder="Cantidad de meses" required="">
                                    </div>
                                    <div class="form-group col-12">
                                        <label class="help-block text-dark"><i id="span-periodo_credito" class="span-periodo_credito fa"></i> Periodo del crédito </label>
                                        <select class="form-control rounded-0 periodo_credito" name="periodo_credito" id="periodo_credito" required="">
                                            <option value="" selected disabled>-Elige un periodo-</option>
                                            <!-- <option value="2024-1" selected>2024-1</option> -->
                                            <option value="2025-1">2025-1</option>
                                            <option value="2025-2">2025-2</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <br>
                                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success float-right btn_aprobar_solucitud">Aprobar Solicitud</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tablacuotas d-none">
                                <table id="tblprintcuotas" class="table  table-condensed table-hover tblprintcuotas" style="width: 100% !important;">
                                    <thead>
                                        <tr>
                                            <th># de Cuota</th>
                                            <th>Valor Cuota</th>
                                            <th>Fecha Pago</th>
                                            <th>Plazo Máximo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Datos Impresos de la base de datos -->
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- inicio modal agregar seguimiento -->
        <div class="modal" id="myModalAgregar">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
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

        <!-- inicio modal historial -->
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

        <!----------------------------------------------------------------------MODAL DE INFORMACION DE ANULAMIENTO-------------------------------------->
        <div class="modal fade" id="modal_detalles_anulado" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-black">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Detalles de anulamiento de solicitud</h4>
                    </div>
                    <div class="modal-body" style="background-color: white !important; color: black !important;">
                        <table class="table  table-condensed">
                            <tbody>
                                <tr>
                                    <td><strong>Estado solicitud:</strong><br><span class="float-right estado_solicitud" style="color: red">Anulado</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Motivo anulamiento:</strong><br><span class="float-right text_motivo">-------</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Realizado por:</strong><br><span class="float-right text_realizado_por">-------</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer bg-black">
                        <button type="button" class="btn btn-outline btn-block pull-left" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
                <!--/.modal-content -->
            </div>
            <!--/.modal-dialog -->
        </div>

        <!---------------------------------------------------------------------  MODALES(Ver whatsapp)   ---------------------------------------------------------------------------->
        <div class="modal fade" id="modal_whatsapp" tabindex="-1" role="dialog" aria-labelledby="modal_whatsapp_label">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h6 class="modal-title" id="modal_whatsapp_label"> WhatsApp CIAF</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
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

    <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
    <script src="scripts/texto_carta_y_pagare.js?<?= date("Y-m-d H:i:s") ?>"></script>
    <script src="scripts/sofi_financiados.js?<?= date("Y-m-d H:i:s") ?>"></script>
    <script type="text/javascript" src="scripts/segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
    <script type="text/javascript" src="scripts/agregar_segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
    <script src="scripts/whatsapp_module.js?<?= date(" Y-m-d H:i:s") ?>"></script>
<?php
}
ob_end_flush();
?>