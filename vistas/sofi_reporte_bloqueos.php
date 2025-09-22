<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    require 'header.php';
    $menu = '23';
    $submenu = '2328';
    if ($_SESSION['sofi_reporte_bloqueos'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Reporte Bloqueos Plataforma</span><br>
                                <span class="fs-14 f-montserrat-regular">Espacio que permite visualizar a los estudiantes bloqueados por falta de pago</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Historial de bloqueos</li>
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
                                            <th> Consecutivo </th>
                                            <th> Documento </th>
                                            <th> Nombre </th>
                                            <th> Celular </th>
                                            <th> Email </th>
                                            <th> Fecha </th>
                                            <th> Hora </th>
                                            <th> Estado </th>
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
        </div>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script src="scripts/sofi_reporte_bloqueos.js?<?= date("y-m-d") ?>"></script>