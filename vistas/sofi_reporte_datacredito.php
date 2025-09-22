<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 23;
    $submenu = 2329;
    require 'header.php';
    if ($_SESSION['sofi_reporte_datacredito'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Reporte Datacrédito</span><br>
                                <span class="fs-14 f-montserrat-regular">Espacio para descargar Reporte Datacrédito </span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Reporte Datacrédito</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="contenido">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="row">
                                <div class="col-4 d-none">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating filtros" id="porDia">
                                            <input type="text" class="form-control border-start-0" name="fecha_transaccion datarang" id="fecha_transaccion" value="<?= date("Y-m-d") ?>">
                                            <label>Rango de busquedad</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 table-responsive">
                                    <table id="tbllistado" class="table table-hover">
                                        <thead>
                                            <th>TIPO DE IDENTIFICACION</th>
                                            <th>NRO. DE IDENTIFICACION</th>
                                            <th>NOMBRE COMPLETO</th>
                                            <th>NRO. OBLIGACION</th>
                                            <th>FECHA APERTURA</th>
                                            <th>FECHA VENCIMIENTO</th>
                                            <th>RESPONSABLE</th>
                                            <th>NOVEDAD</th>
                                            <th>SITUACION DE CARTERA </th>
                                            <th>VALOR INICIAL</th>
                                            <th>VALOR SALDO DEUDA</th>
                                            <th>VALOR DISPONIBLE</th>
                                            <th>V CUOTA MENSUAL</th>
                                            <th>VALOR SALDO MORA</th>
                                            <th>TOTAL CUOTAS</th>
                                            <th>CUOTAS CANCELADAS</th>
                                            <th>CUOTAS EN MORA</th>
                                            <th>FECHA LIMITE DE PAGO</th>
                                            <th>FECHA DE PAGO</th>
                                            <th>CIUDAD DE CORRESPONDENCIA</th>
                                            <th>DIRECCION DE CORRESPONDENCIA</th>
                                            <th>CORREO ELECTRONICO DEL CLIENTE</th>
                                            <th>CELULAR DEL CLIENTE</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
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
<script src="scripts/sofi_reporte_datacredito.js?<?= date("y-m-d") ?>"></script>