<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 23;
    $submenu = 2313;
    require 'header.php';
    if ($_SESSION['webtransacciones'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Ultimas Transaciones Página Web</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php"> Panel </a></li>
                                <li class="breadcrumb-item active">Transacciones por web</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="seleccion_filtro campo-select col-12 mb-3">
                                                <select name="filtro" id="filtro" onchange="cambiarFiltro(this.value)" class="campo" required="" data-style="border">
                                                    <option value="" disabled selected> Selecciona el filtro </option>
                                                    <option value="porIdentificacion"> Identificación </option>
                                                    <option value="porDia"> Día </option>
                                                    <option value="porPeriodo"> Periodo </option>
                                                </select>
                                                <span class="highlight"></span>
                                                <span class="bar"></span>
                                                <label>Semestre:</label>
                                            </div>
                                            <div class="input-group mb-2 col-4 filtros alert alert-info" id="porIdentificacion">
                                                <input type="number" name="input_identificacion" id="input_identificacion" class="form-control" onkeyup="listar('identificacion', this.value)" placeholder="Ingrese el documento">
                                                </input>
                                            </div>
                                            <div class="input-group mb-2 col-4 filtros alert alert-success" id="porDia">
                                                <input type="text" name="fecha_transaccion datarange" id="fecha_transaccion" class="form-control" value="<?= date("Y-m-d") ?>">
                                            </div>
                                            <div class="input-group mb-2 col-4 filtros alert alert-success" id="porPeriodo">
                                                <select name="input_periodo" id="input_periodo" class="form-control" onchange="listar('periodo', this.value)">
                                                </select>
                                            </div>
                                            <div class="input-group mb-2 col-4 filtros alert alert-success" id="porPeriodo">
                                                <select name="filtro_franquicia" id="filtro_franquicia" class="form-control" onchange="listar('periodo', this.value)">
                                                </select>
                                            </div>
                                            <table id="tbllistado" class="table table-hover">
                                                <thead>
                                                    <th class="yeminus_tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Esta columna indica si se agrego correctamente en yeminus"> Yeminus </th>
                                                    <th> Ref CIAF </th>
                                                    <th> Fecha </th>
                                                    <th> Factura </th>
                                                    <th> Valor </th>
                                                    <th> Identificación </th>
                                                    <th> Nombre </th>
                                                    <th> Celular </th>
                                                    <th> Medio Pago </th>
                                                    <th> Reg Cliente </th>
                                                    <th> Descripción </th>
                                                    <th> Estado </th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
            </div>
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
<script type="text/javascript" src="scripts/web_transacciones.js"></script>