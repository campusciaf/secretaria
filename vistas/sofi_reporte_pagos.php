<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 23;
    $submenu = 2315;
    require 'header.php';
    if ($_SESSION['sofi_reporte_pagos'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Reporte - Pagos de Crédito</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php"> Panel </a></li>
                                <li class="breadcrumb-item active">Pagos Créditos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="panel-body" id="listadoregistros">
                                <div class="row">
                                    <div class="seleccion_filtro mb-3 col-12">
                                        <select name="filtro" id="filtro" onchange="cambiarFiltro(this.value)" class="form-control">
                                            <option value="" disabled selected> Selecciona el filtro </option>
                                            <option value="porDia"> Día </option>
                                            <option value="porConsecutivo"> Consecutivo</option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-2 col-4 filtros alert alert-info" id="porConsecutivo">
                                        <input type="number" name="input_consecutivo" id="input_consecutivo" class="form-control" onkeyup="listar('consecutivo', this.value)" placeholder="Ingrese el consecutivo">
                                        </input>
                                    </div>
                                    <div class="input-group mb-2 col-4 filtros alert alert-success" id="porDia">
                                        <input type="text" name="fecha_transaccion" id="fecha_transaccion" class="form-control" value="<?= date("Y-m-d") ?>">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="tbllistado" class="table table-hover">
                                        <thead>
                                            <th> Yeminus </th>
                                            <th> Detalle </th>
                                            <th> Fecha </th>
                                            <th> Consecutivo </th>
                                            <th> Valor Pago </th>
                                            <th> Identificación </th>
                                            <th> Nombre</th>
                                            <th> Celular</th>
                                            <th> Medio Pago</th>
                                            <th> Descripción</th>
                                            <th> Estado</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="panel-body" id="información_grupos" hidden="true">
                                <div class="row"></div>
                                <div class="box">
                                    <div class="box-body">
                                        <div class="col-md-12">
                                            <div id="tblgrupos"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
            <!-- The Modal -->
            <div class="modal" id="modaldetalle">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Detalle</h4>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div id="resultado"></div>
                        </div>
                    </div>
                </div>
            </div>s
        </div>
        </div><!-- /.content-wrapper -->
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/sofi_reporte_pagos.js"></script>