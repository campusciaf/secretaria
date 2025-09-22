<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.php");
} else {
    $menu = 23;
    $submenu = 2304;
    require 'header.php';
    if ($_SESSION['sofipagosrematricula'] == 1) {
?>
        <div id="precarga" class="precarga" style="display: none;">
        </div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><small id="nombre_programa"></small>Gestión rematricula</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Rematriculas</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <!--Fondo de la vista -->
                <div class="row mx-0">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12" id="seleccionprograma">
                                <form name="formularioverificar" id="formularioverificar" method="POST">
                                    <div class="input-group input-group-md">
                                        <input type="number" class="form-control" name="credencial_identificacion" id="credencial_identificacion" maxlength="11" required placeholder="Número de Identificación">
                                        <span class="input-group-btn">
                                            <button type="submit" id="btnVerificar" class="btn btn-info btn-flat">Verificar</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div id="mostrardatos" class="col-lg-4 col-md-6 col-sm-12 col-xs-12 row">
                            </div>
                            <div class="panel-body" id="listadoregistros">
                                <table id="tbllistado" class="table table-hover text-nowrap">
                                    <thead>
                                        <th>Acciones</th>
                                        <th>Id estudiante</th>
                                        <th>Programa</th>
                                        <th>Jornada</th>
                                        <th>Semestre</th>
                                        <th>Grupo</th>
                                        <th>Pago</th>
                                        <th>Estado</th>
                                        <th>Nuevo del</th>
                                        <th>Periodo Activo</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-body" id="formularioregistros">
                                <form name="formulario" id="formulario" method="POST">
                                </form>
                            </div>
                            <div class="row">
                                <div id="listadomaterias" class="row" style="width: 100%"></div>
                            </div>
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <div class="modal fade" id="nuevopago" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Pago Especial</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form name="formularioticket" id="formularioticket" method="POST">
                            <input type='hidden' value="" id='id_estudiante' name='id_estudiante'>
                            <div class="form-group col-12">
                                <label>Nuevo monto</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type='number' value="" id='nuevo_valor' name='nuevo_valor' class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label>Motivo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <select id="motivo" name="motivo" class="form-control selectpicker" data-live-search="true" data-style="border" required></select>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label>Tipo de pago:</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_pago" id="opcion1" value="1">
                                    <label class="form-check-label" for="opcion1">Matrícula Completa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_pago" id="opcion2" value="2">
                                    <label class="form-check-label" for="opcion2">Media Matricula</label>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label>Fecha limite</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type="date" name="fecha_limite" id="fecha_limite" value="" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" id="btnNovedad" class="btn btn-info btn-block">Generar ticket</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalAprobarMatricula" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Aprobar Matricula</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form name="formAprobarMatricula" id="formAprobarMatricula" method="POST" class="row mb-0">
                            <div class="col-12 text-center text-danger no_datos_precios"></div>
                            <input type='hidden' value="" id='id_estudiante_matricula' name='id_estudiante_matricula'>
                            <div class="form-group col-6">
                                <label for="valor ">Valor Pecuniario</label>
                                <input type='number' id='total_pecuniario' name='total_pecuniario' class="calcularvalorapagar form-control" required>
                            </div>
                            <div class="form-group col-6">
                                <label for="valor ">Aporte social </label>
                                <input type='number' id='porcentaje_descuento' name='porcentaje_descuento' class="calcularvalorapagar form-control" required step="any">
                            </div>
                            <div class="form-group col-6">
                                <label>Tiempo Pago:</label>
                                <br>
                                <select id='tiempo_pago' name='tiempo_pago' class="tiempo_pago calcularvalorapagar form-control" required>
                                    <option value="2" selected>Ordiniaria</option>
                                    <option value="1">Pronto Pago</option>
                                    <option value="3">Extraordinaria</option>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="porcentaje_extraordinaria">% Extra ordinaria</label>
                                <select id='porcentaje_extraordinaria' name='porcentaje_extraordinaria' class="calcularvalorapagar form-control" required>
                                    <option value="5" selected>5 %</option>
                                    <option value="10">10 %</option>
                                    <option value="15">15 %</option>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="totaloferta">Valor Final</label>
                                <input type='number' id='totaloferta' name='totaloferta' class="form-control" required>
                            </div>
                            <div class="form-group col-6">
                                <label>Tipo de pago:</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_pago_matricula" id="matricula_completa" value="1" required checked>
                                    <label class="form-check-label" for="matricula_completa">Matrícula Completa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_pago_matricula" id="media_matricula" value="2" required>
                                    <label class="form-check-label" for="media_matricula">Media Matricula</label>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label for="forma_de_pago_fv">Forma de pago(Para la factura)</label>
                                <select class="form-control" name="forma_de_pago_fv" id="forma_de_pago_fv" required>
                                    <option value="" selected disabled>-- Selecciona una forma de pago -- </option>
                                    <option value="00">CONTADO</option>
                                    <option value="01">CREDITO (5 CUOTAS)</option>
                                    <option value="02">TARJETA DEBITO</option>
                                    <option value="03">TARJETA CREDITO</option>
                                    <option value="04">PROVEEDORES CONTADO</option>
                                    <option value="05">PROVEEDORES 30 DIAS</option>
                                    <option value="06">PROVEEDORES 60 DIAS</option>
                                    <option value="07">CREDITO (3 CUOTAS)</option>
                                    <option value="08">CREDITO (6 CUOTAS)</option>
                                    <option value="09">CREDITO (4 CUOTAS)</option>
                                    <option value="10">CREDITO (2 CUOTAS)</option>
                                    <option value="11">PROVEEDORES 15 DIAS</option>
                                    <option value="12">PROVEEDORES 20 DIAS</option>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="forma_de_pago_rc">Forma de pago(Recibo de caja)</label>
                                <select class="form-control" name="forma_de_pago_rc" id="forma_de_pago_rc" required>
                                    <option value="" selected disabled>-- Selecciona una forma de pago -- </option>
                                    <option value="13">CAJA PRINCIPAL</option>
                                    <option value="14">CAJAS MENORES</option>
                                    <option value="15">COLPATRIA CTA CTE 2136-6</option>
                                    <option value="16">BANCO DE OCCIDENTE 1299-9</option>
                                    <option value="17">DAVIVIENDA CTE 126269998517</option>
                                    <option value="18">Davivienda 126270218319</option>
                                    <option value="19">Colpatria 2082073399</option>
                                    <option value="20">Banco Occidente 065-82383-3</option>
                                    <option value="21">Cuenta Epayco</option>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="codigo_yeminus">Codigo producto</label>
                                <input type='text' id='codigo_yeminus' name='codigo_yeminus' class="form-control" required>
                            </div>
                            <div class="form-group col-6">
                                <label for="centro_de_costos">Centro de Costos</label>
                                <input type='text' id='centro_de_costos' name='centro_de_costos' class="form-control" required>
                            </div>
                            <div class="form-group col-6">
                                <label for="porcentaje_total_aplicado">Porcentaje Total</label>
                                <input type='text' id='porcentaje_total_aplicado' name='porcentaje_total_aplicado' class="form-control" required>
                            </div>
                            <div class="form-group col-6 text-center">
                                <button type="submit" id="btnAprobarMatricula" class="btn btn-info">Aprobar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="financiacion" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Pago Especial</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form name="formulariofinanciacion" id="formulariofinanciacion" method="POST">
                            <input type='hidden' value="" id='id_estudiante_financiacion' name='id_estudiante_financiacion'>
                            <div class="form-group col-12">
                                <label>Total semestre</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type='number' value="" id='valor_total' name='valor_total' class="form-control" readonly="readonly">
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label>Total financiado</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type='number' value="" id='valor_financiacion' name='valor_financiacion' class="form-control" readonly="readonly">
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label>Monto a pagar</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type='number' value="" id='nuevo_valor_financiacion' name='nuevo_valor_financiacion' class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label>Motivo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type='text' value="Efectivo/Financiado" id='motivo_financiado' name='motivo_financiado' class="form-control" readonly="readonly">
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label>Fecha limite</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type="date" name="fecha_limite_financiado" id="fecha_limite_financiado" value="" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" id="btnNovedad" class="btn btn-info btn-block">Generar ticket</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="verrecibo" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Recibo de matrícula</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <a class="btn btn-warning float-right" href="javascript:imprSelec('historial')"><i class="fas fa-print"></i>Imprimir</a>
                        <div id="historial">
                            <div id="datosrecibo"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="verestadocredito" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Estado crédito</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="estadocredito"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalGestionYeminus" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Gestión Yeminus</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-hover">
                                        <thead>
                                            <th>Número Factura</th>
                                            <th>Crear Factura</th>
                                            <th>Cierre Venta</th>
                                            <th>Contabilizar</th>
                                            <th>Recibo Caja</th>
                                        </thead>
                                        <tbody class="listado_gestion_yeminus">
                                            
                                        </tbody>
                                    </table>
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
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/sofi_pagosrematricula.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>