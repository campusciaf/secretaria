<?php
session_start();
//Activamos el almacenamiento en el buffer
ob_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 23;
    $submenu = 2306;
    require 'header.php';
    if ($_SESSION['sofi_reporte_quincenal'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Reporte Quincenal</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">SOFI</a></li>
                                <li class="breadcrumb-item active">Reporte Quincenal</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <select class="form-control rounded-0" name="periodo_buscar" id="periodo_buscar" onChange="listarReportes()">
                                        <option value="" disabled selected>- Selecciona Un Periodo -</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select class="form-control rounded-0" name="motivo_financiacion" id="motivo_financiacion" onChange="listarReportes()">
                                        <option disabled value="">Selecciona un Motivo de financiación</option>
                                        <option value="Financiación matricula" selected>Financiación matricula</option>
                                        <option value="Financiación curso de ingles">Financiación curso de ingles</option>
                                        <option value="Financiación Seminario trabajo de grado">Financiación Seminario trabajo de grado</option>
                                        <option value="Financiación Derechos de grado">Financiación Derechos de grado</option>
                                        <option value="Entre Otros">Entre Otros</option>
                                        <option value="Todos">Todos</option>
                                    </select>
                                </div>
                            </div>
                            <div id="tablaregistros">
                                <table id="tabla_reporte" class="table table-hover">
                                    <thead>
                                        <th>Mes</th>
                                        <th>Rango de Fecha</th>
                                        <th>Cuotas Totales</th>
                                        <th>Cuotas Pagadas</th>
                                        <th>Cuotas No Pagadas</th>
                                        <th>Valor Total</th>
                                        <th>Valor Pagado</th>
                                        <th>Valor Restante</th>
                                        <th>Porcentaje</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Mes</th>
                                        <th>Rango de Fecha</th>
                                        <th>Cuotas Totales</th>
                                        <th>Cuotas Pagadas</th>
                                        <th>Cuotas No Pagadas</th>
                                        <th>Valor Total</th>
                                        <th>Valor Pagado</th>
                                        <th>Valor Restante</th>
                                        <th>Porcentaje</th>
                                    </tfoot>
                                </table>
                            </div>
                            <div id="tabla_estudiantes_mes_wrapper ">
                                <table id="tabla_estudiantes_mes" class="table table-hover table-responsive">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Documento</th>
                                        <th>Nombre Completo</th>
                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th># atrasos</th>
                                        <th>Programa</th>
                                        <th>Semestre</th>
                                        <th>Jornada</th>
                                        <th>Labora</th>
                                        <th>En Cobro</th>
                                        <th>Periodo</th>
                                        <th>Fecha Inicial</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Opciones</th>
                                        <th>Documento</th>
                                        <th>Nombre Completo</th>
                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th># atrasos</th>
                                        <th>Programa</th>
                                        <th>Semestre</th>
                                        <th>Jornada</th>
                                        <th>Labora</th>
                                        <th>En Cobro</th>
                                        <th>Periodo</th>
                                        <th>Fecha Inicial</th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="modal fade" id="modal_cuotas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Mostrando Cuotas de: <b class="nombre_atrazado"></b> </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <table id="search_cuota" class="table dataTable table-responsive">
                            <thead>
                                <th>Estado</th>
                                <th># Cuota</th>
                                <th>Valor Cuota</th>
                                <th>Valor Pagado</th>
                                <th>Pago <small>(AA-MM-DD)</small></th>
                                <th>Plazo <small>(AA-MM-DD)</small></th>
                                <th>Días Atrasado</th>
                                <th>Opciones</th>
                            </thead>
                            <tbody>
                                <th colspan="11">
                                    <div class='jumbotron text-center' style="margin:0px !important">
                                        <h3>Aquí aparecerán los datos de la persona que tienen crédito.</h3>
                                    </div>
                                </th>
                            </tbody>
                            <tfoot>
                                <th>Estado</th>
                                <th># Cuota</th>
                                <th>Valor Cuota</th>
                                <th>Valor Pagado</th>
                                <th>Pago</th>
                                <th>Plazo</th>
                                <th>Días Atraso</th>
                                <th>Opciones</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-default fade" id="seguimientos" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div>
                    </div>
                    <div class="modal-header bg-air-force">
                        <h4 class="modal-title">Seguimientos</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="box-body nav-tabs-custom" style="background-color: white !important; color: black !important; padding:0px;margin:0px">
                        <div class="tab-content">
                            <div class="tab-pane" id="tab_seg_1">
                                <div class="box-body">
                                    <div class="box-header form-group text-center col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background:#3c8dbc">
                                        <div class=" col-md-12 text-center">
                                            <h2 class="box-title" style="color: #ffffff;"><strong>Añadir Seguimiento</strong></h2>
                                        </div>
                                    </div>
                                    <form name="formularioseg" class="form-group" id="formularioseg" method="POST">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label class="help-block"><i id="span-seg_tipo" class="fa"></i> Tipo De Seguimiento: </label>
                                            <input type="text" class="form-control" maxlength="30" name="seg_tipo" id="seg_tipo" placeholder="Ej: Llamada, Observación..." required>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label class="help-block"><i id="span-seg_descripcion" class="fa"></i> Descripción del seguimiento: </label>
                                            <textarea class="form-control col-md-12" rows="6" name="seg_descripcion" id="seg_descripcion" placeholder="Observaciones... "></textarea>
                                        </div>
                                        <input type="hidden" class="idpersonaseg" name="idpersona" id="idpersona" value="">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button class="btn btn-danger col-lg-6 col-md-6 col-sm-6 col-xs-6 btn-flat" type="button" href="#tab_seg_2" data-toggle="tab" aria-expanded="true"> <i class="fas fa-undo-alt"></i> Regresar </button>
                                            <button class="btn-seguimiento btn form-header col-lg-6 col-md-6 col-sm-6 col-xs-6 btn-flat" type="button"> <i class="fas fa-save"></i> Guardar </button>
                                        </div>
                                    </form>
                                    <div class="box-header form-group text-center col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background:#3c8dbc">
                                        <div class=" col-md-12 text-center">
                                            <h2 class="box-title" style="color: #ffffff;"><strong>Añadir Tarea</strong></h2>
                                        </div>
                                    </div>
                                    <form name="registrar_tarea" action="#" class="form-group" id="registrar_tarea" method="POST">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label class="help-block"><i id="span-tarea_motivo" class="fa"></i> Motivo De tarea: </label>
                                            <label class="radio-inline"><input type="radio" class="input-tarea" name="tarea_motivo" checked value="Llamada" required>Llamada</label>
                                            <label class="radio-inline"><input type="radio" class="input-tarea" name="tarea_motivo" value="Observacion" required>Observación</label>
                                            <label class="radio-inline"><input type="radio" class="input-tarea" name="tarea_motivo" value="Cita" required>Cita</label>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label class="help-block"><i id="span-tarea_descripcion" class="fa"></i> Descripción del tarea: </label>
                                            <textarea class="form-control col-md-12" rows="6" name="tarea_descripcion" id="tarea_descripcion" placeholder="Observaciones..." required></textarea>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label class="help-block"><i id="span-tarea_hora" class="fa"></i> Hora de la tarea: </label>
                                            <input type="text" class="form-control col-md-12 timepicker" name="tarea_hora" id="tarea_hora" required>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label class="help-block"><i id="span-tarea_fecha" class="fa"></i> Fecha de la tarea: </label>
                                            <input type="date" class="form-control col-md-12" name="tarea_fecha" id="tarea_fecha" required>
                                        </div>
                                        <input type="hidden" class="idpersonaseg" name="idpersona" id="idpersona" value="">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button class="btn btn-danger col-lg-6 col-md-6 col-sm-6 col-xs-6 btn-flat" type="button" href="#tab_seg_2" data-toggle="tab" aria-expanded="true"><i class="fas fa-undo-alt"></i> Regresar </button>
                                            <button type="submit" class="btn form-header col-lg-6 col-md-6 col-sm-6 col-xs-6 btn-flat" type="button"> <i class="fas fa-save"></i> Guardar </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane active tab-pane-segs" id="tab_seg_2">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-bottom: 5px;">
                                    <div class="box-header  text-center " style="background:#3c8dbc;margin-bottom: 5px;">
                                        <div class=" col-md-12 text-center">
                                            <h2 class="box-title" style="color: #ffffff;"><strong>Seguimientos</strong></h2>
                                        </div>
                                    </div>
                                    <ul class="timeline-seg timeline" style="margin-bottom: 5px;">
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="box-header  text-center " style="background:#3c8dbc;margin-bottom: 5px;">
                                        <div class=" col-md-12 text-center">
                                            <h2 class="box-title" style="color: #ffffff;"><strong>Tareas</strong></h2>
                                        </div>
                                    </div>
                                    <ul class="timeline timeline-tareas" style="margin-bottom: 5px;">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-air-force">
                        <button type="button" class="btn btn-outline btn-cerrar pull-left" data-dismiss="modal">Cerrar</button>
                        <button href="#tab_seg_1" data-toggle="tab" aria-expanded="false" type="button" class="btn btn-outline addseg" id="pre-aprobacion-ok" data-idpersona=""> Añadir <i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="verInfoSolicitante" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content bg-teal">
                    <div class="modal-header bg-teal-active color-palette">
                        <h4 class="modal-title title_name_sol">Nombre: </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="box-body nav-tabs-custom ">
                        <ul class="nav nav-pills p-2">
                            <li class="nav-item data_infosol"><a class="nav-link" href="#tab_no_1" data-toggle="tab">Información Personal</a></li>
                            <li class="nav-item data_refsol"><a class="nav-link active" href="#tab_no_2" data-toggle="tab">Referencias</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="tab_no_1">
                                <table class="table ">
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
                                            <td><strong>Ocupación: </strong> <span class="float-right info-ocupacion"> </span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Periodo: </strong> <span class="float-right info-periodo"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input class="info-idsolicitante" type="hidden">
                            </div>
                            <div class="tab-pane active" id="tab_no_2">
                                <table class="table">
                                    <tbody class="table-references">
                                        <tr>
                                            <td class="text-green text-center"><strong> Bancaria </strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tipo Cuenta:</strong><span class="pull-right"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Número Cuenta:</strong><span class="pull-right"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-green text-center"><strong> Personal </strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nombre Completo:</strong><span class="pull-right"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Teléfono:</strong><span class="pull-right"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-green text-center"><strong> Personal </strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nombre Completo:</strong><span class="pull-right"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Teléfono:</strong><span class="pull-right"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-green text-center"><strong> Comercial </strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nombre Completo:</strong><span class="pull-right"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Teléfono:</strong><span class="pull-right"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-green text-center"><strong> Familiar </strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nombre Completo:</strong><span class="pull-right"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Teléfono:</strong><span class="pull-right"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-green text-center"><strong> Familiar </strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nombre Completo:</strong><span class="pull-right"></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Teléfono:</strong><span class="pull-right"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
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
}
ob_end_flush();
?>
<script src="scripts/sofi_reporte_quincenal.js?<?= date("Y-m-d H:i:s") ?>"></script>