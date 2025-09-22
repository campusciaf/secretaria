<?php
session_start();
//Activamos el almacenamiento en el buffer
ob_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 23;
    $submenu = 2307;
    require 'header.php';
    if ($_SESSION['sofi_de_contado'] == 1) {
?>
        <!--Contenido Content Wrapper. Contains page content -->
        <link rel="stylesheet" href="../public/css/morris.css">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Pagos De Contado <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">SOFI</a></li>
                                <li class="breadcrumb-item active">Pagos de contado</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="row content_table" id="tablaregistros">
                                <div class="col-12">
                                    <table id="tabla_de_contado" class="table table-hover">
                                        <thead>
                                            <th>Opciones contado</th>
                                            <th>Documento</th>
                                            <th>Nombre</th>
                                            <th>Telefono </th>
                                            <th>Direccion</th>
                                            <th>Jornada</th>
                                            <th>Semestre</th>
                                            <th>Programa</th>
                                            <th>Valor total</th>
                                            <th>Valor pagado</th>
                                            <th>Descuento</th>
                                            <th>Motivo Desc</th>
                                            <th>Periodo</th>
                                        </thead>
                                        <tbody>
                                            <th colspan="12">
                                                <div class='jumbotron text-center bg-green' style="margin:0px !important">
                                                    <h3>Aquí aparecerán los datos sobre los contados.</h3>
                                                </div>
                                            </th>
                                        </tbody>
                                        <tfoot>
                                            <th>Opciones contado</th>
                                            <th>Documento</th>
                                            <th>Nombre</th>
                                            <th>Telefono </th>
                                            <th>Direccion</th>
                                            <th>Jornada</th>
                                            <th>Semestre</th>
                                            <th>Programa</th>
                                            <th>Valor total</th>
                                            <th>Valor pagado</th>
                                            <th>Descuento</th>
                                            <th>Motivo Desc</th>
                                            <th>Periodo</th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div id="formularioregistros">
                                <form class="row" name="formulariomatricula" id="formulariomatricula" method="POST">
                                    <div>
                                        <input type="hidden" class="id_contado" name="id_contado" id="id_contado" value="">
                                    </div>
                                    <div class="input-group col-12 mt-3">
                                        <input type="number" class="form-control documento" name="documento" id="documento" placeholder="Documento" required>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-info btn-flat btn_documento"><i class="fas fa-search"></i></button>
                                        </span>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-3">
                                        <label class="help-block"><i id="span-nombre" class="span-nombre fa"></i> Nombre(s) :</label>
                                        <input type="text" class="form-control nombre" maxlength="50" name="nombre" id="nombre" placeholder="Nombre(s) del cliente" required="">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-3">
                                        <label class="help-block"><i id="span-apellido" class="span-apellido fa"></i> Apellido(s) :</label>
                                        <input type="text" class="form-control apellido" maxlength="50" name="apellido" id="apellido" placeholder="Apellido(s) del cliente" required="">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-3">
                                        <label class="help-block"><i id="span-direccion" class="span-direccion fa"></i> Dirección :</label>
                                        <input type="text" class="form-control direccion" maxlength="50" name="direccion" id="direccion" placeholder="Dirección del cliente" required="">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-3">
                                        <label class="help-block"><i id="span-telefono" class="span-telefono fa"></i> telefono :</label>
                                        <input type="text" class="form-control telefono" maxlength="50" name="telefono" id="telefono" placeholder="Celular del cliente" required="">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-3">
                                        <label class="help-block"><i id="span-email" class="span-email fa"></i> E-mail:</label>
                                        <input type="text" class="form-control email" maxlength="50" name="email" id="email" placeholder="Correo electronico del cliente" required="">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-3">
                                        <label class="help-block"><i id="span-programa" class="span-programa fa"></i> Nombre del programa : </label>
                                        <select class="form-control col-md-12 programa" name="programa" id="programa" required>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block"><i id="span-semestre" class="span-semestre fa"></i> Semestre :</label>
                                        <input type="number" class="form-control semestre" maxlength="50" name="semestre" id="semestre" placeholder="Semestre del programa" required="">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block"><i id="span-jornada" class="span-jornada fa"></i> Jornada :</label>
                                        <select type="text" class="form-control col-md-12 jornada" maxlength="30" name="jornada" id="jornada" required>
                                            <option disabled="" selected="">Selecciona una jornada</option>
                                            <option value="MAÑANA">Mañana</option>
                                            <option value="TARDE">Tarde</option>
                                            <option value="NOCHE">Noche</option>
                                            <option value="SABATINA">Sábados</option>
                                            <option value="FINES DE SEMANA">Fines de semana</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block"><i id="span-valor_total" class="span-valor_total fa"></i> Valor de la matrícula : </label>
                                        <input type="number" class="form-control valor_total" maxlength="30" name="valor_total" id="valor_total" placeholder="Valor total de la matrícula" required="">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block"><i id="span-valor_pagado" class="span-valor_pagado fa"></i> Valor Pagado :</label>
                                        <input type="number" class="form-control valor_pagado" maxlength="30" name="valor_pagado" id="valor_pagado" placeholder="Valor Pagado" required="">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block"><i id="span-motivo_pago" class="span-motivo_pago fa"></i> Motivo Pago :</label>
                                        <select type="text" class="form-control col-md-12 motivo_pago" name="motivo_pago" id="motivo_pago" required>
                                            <option disabled selected value="">Selecciona un Motivo de pago</option>
                                            <option value="Matrícula">Matrícula</option>
                                            <option value="Curso de ingles">Curso de ingles</option>
                                            <option value="Seminario trabajo de grado">Seminario trabajo de grado</option>
                                            <option value="Derechos de grado">Derechos de grado</option>
                                            <option value="Entre Otros">Entre Otros</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block"><i id="span-primer_curso" class="span-primer_curso fa"></i> De primer curso? :</label>
                                        <select type="text" class="form-control col-md-12 primer_curso" name="primer_curso" id="primer_curso" required="">
                                            <option disabled="" selected="">Selecciona una opción</option>
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block"><i id="span-descuento" class="span-descuento fa"></i> Descuento : <small>(Opcional)</small></label>
                                        <input type="number" class="form-control descuento" maxlength="30" name="descuento" id="descuento" placeholder="Si tiene algún descuento, indíquelo">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <label class="help-block"><i id="span-motivo_descuento" class="span-motivo_descuento fa"></i> Motivo Descuento : <small>(Opcional)</small></label>
                                        <input type="text" class="form-control motivo_descuento" maxlength="30" name="motivo_descuento" id="motivo_descuento" placeholder="Motivo del descuento">
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                        <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script src="scripts/sofi_de_contado.js?01"></script>