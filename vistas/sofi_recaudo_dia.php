<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    require 'header.php';
    if ($_SESSION['sofipanel'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Recaudo cartera</span><br>
                                <span class="fs-14 f-montserrat-regular">Espacio que permite visualizar el recaudo de la cartera</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Recaudos</li>
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
                                <div class="col-8 py-3 pl-4" id="metaasesor">
                                    <p class="fw-light fs-18 mb-1 text-secondary pl-4">Valor Recaudado</p>
                                    <h1 class="titulo-2 fs-36 pl-4 text-semibold" id="valorrecaudo"></h1>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating filtros" id="porDia">
                                            <input type="text" class="form-control border-start-0" name="fecha_transaccion datarang" id="fecha_transaccion" value="<?= date("Y-m-d") ?>">
                                            <label>Rango de busquedad</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <table id="tbllistado" class="table table-hover">
                                        <thead>

                                            <th> Documento</th>
                                            <th> # Documento</th>
                                            <th> Consecutivo</th>
                                            <th> Fecha De Pago </th>
                                            <th> Valor Pagado </th>
                                            <th> Metodo </th>
                                            <th> En cobro </th>
                                            <th> # Semana del Pago </th>
                                            <th> # Semana de Cuota </th>
                                            <th> Fecha Cuota </th>
                                            <th> Observación</th>
                                            <th> Cuota </th>
                                            <th> Periodo </th>
                                            <th> Asesor </th>
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
        </div><!-- /.content-wrapper -->
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script src="scripts/sofi_recaudo_dia.js?<?= date("y-m-d") ?>"></script>