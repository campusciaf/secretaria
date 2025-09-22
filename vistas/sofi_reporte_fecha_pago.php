<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 23;
    $submenu = 2322;
    require 'header.php';
    if ($_SESSION['sofi_reporte_fecha_pago'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Reporte Por Fechas de Pago</span><br>
                                <span class="fs-16 f-montserrat-regular">Filtra las fechas de pago para generar reportes más precisos y eficientes.</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 d-none segundo_tour" onclick='iniciarSegundoTour()'><i class="fa-solid fa-play"></i> Tour 2da parte</button>
                        </div>

                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="sofi_panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Reporte Por Fechas de Pago</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="seleccion_filtro campo-select col-12 mb-3">
                            <select name="filtro" id="filtro" onchange="cambiarFiltro(this.value)" class="campo" required="" data-style="border">
                                <option value="" disabled selected> Selecciona el filtro </option>
                                <option value="porIdentificacion"> Identificación </option>
                                <option value="porDia"> Fecha de cuota </option>
                                <option value="porPeriodo"> Periodo </option>
                                <option value="porFechaPago"> Fecha de pago </option>
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
                            <input type="text" name="fecha_transaccion datarang" id="fecha_transaccion" class="form-control" value="<?= date("Y-m-d") ?>">
                        </div>
                        <div class="input-group mb-2 col-4 filtros alert alert-primary" id="porFechaPago">
                            <input type="text" name="fecha_pago_realizado datarang" id="fecha_pago_realizado" class="form-control" value="<?= date("Y-m-d") ?>">
                        </div>
                        <div class="input-group mb-2 col-4 filtros alert alert-danger" id="porPeriodo">
                            <select name="input_periodo" id="input_periodo" class="form-control" onchange="listar('periodo', this.value)">
                            </select>
                        </div>
                        <table id="tbllistado" class="table table-hover">
                            <thead>
                                <th> Consecutivo </th>
                                <th> Documento </th>
                                <th> Nombres </th>
                                <th> Apellidos </th>
                                <th> Celular </th>
                                <th> Email </th>
                                <th> Número cuota </th>
                                <th> Fecha Cuota </th>
                                <th> Fecha Pago </th>
                                <th> Valor Pagado </th>
                                <th> Periodo </th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
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
<script type="text/javascript" src="scripts/sofi_reporte_fecha_pago.js?<?= date("Y-m-d") ?>"></script>