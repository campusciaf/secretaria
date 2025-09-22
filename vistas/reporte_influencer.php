<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location:  ../");
} else {
    $menu = 15;
    $submenu = 1511;
    require 'header.php';
    if ($_SESSION['reporte_influencer'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Reporte Influencer</span><br>
                                <span class="fs-16 f-montserrat-regular">Reporte para influencer</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Reporte Influencer</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid" style="padding-top: 0px;">
                <div class="row">
                    <div class="col-xl-9 col-lg-8 col-md-8 col-6 pt-3 pl-3 tono-3" id="ocultarpanelanio">
                        <div class="row align-items-center pt-2">
                            <div class="pl-4 col-auto">
                                <span class="rounded bg-light-blue p-3 text-primary">
                                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fs-14 line-height-18">
                                    <span class="">Reporte</span> <br>
                                    <span class="text-semibold fs-16 titulo-2 fs-16 line-height-16" id="dato_periodo"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-4 col-6 pt-3 tono-3" id="seleccionar_periodo">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo_filtro" id="periodo_filtro"></select>
                                <label>Buscar Periodo</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div class="card col-12 p-4">
                        <div class="row mb-3 justify-content-center">
                            <div class="col-auto">
                                <button class="btn btn-nivel btn-outline-secondary active mx-1" data-nivel="Todos" style="min-width:110px;font-weight:600;"><i class="fas fa-list"></i> Todos</button>
                                <button class="btn btn-nivel btn-outline-success mx-1" data-nivel="Positiva" style="min-width:110px;font-weight:600;"><i class="fas fa-smile"></i> Positiva</button>
                                <button class="btn btn-nivel btn-outline-warning mx-1" data-nivel="Media" style="min-width:110px;font-weight:600;"><i class="fas fa-exclamation"></i> Media</button>
                                <button class="btn btn-nivel btn-outline-danger mx-1" data-nivel="Alta" style="min-width:110px;font-weight:600;"><i class="fas fa-bolt"></i> Alta</button>
                            </div>
                        </div>
                        <div class="row card card-primary" style="padding: 2% 1%">
                            <div class="col-lg-12 table-responsive">
                                <table id="tbllistaprogramas" class="table compact table-striped table-condensed table-hover">
                                    <thead>
                                        <th>Rspta</th>
                                        <th>Docente</th>
                                        <th>Cédula</th>
                                        <th>Estudiante</th>
                                        <th>Correo</th>
                                        <th>Programa</th>
                                        <th>Semestre</th>
                                        <th>Jornada</th>
                                        <th>Atención</th>
                                        <th>Nivel</th>
                                        <th>Mensaje</th>
                                        <th>Fecha</th>
                                        <th>Responsable</th>
                                        <th>Respuesta</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="modal" id="modal-info-reporte" aria-modal="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Conversación</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="box box-primary direct-chat direct-chat-primary">
                                <div class="box-body" style="overflow-x:none !important">
                                    <div class="direct-chat-messages historico_reporte" style="height:auto !important">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <form action="#" method="POST" id="form_respuesta_reporte" class="form-horizontal col-12">
                                <div class="form-group">
                                    <label for="mensaje_respuesta">Respuesta</label>
                                    <textarea class="form-control" name="mensaje_respuesta" id="mensaje_respuesta" rows="3" placeholder="Escribe tu respuesta aquí..." required></textarea>
                                </div>
                                <input type="hidden" id="docente_nombre" name="docente_nombre">
                                <input type="hidden" id="nombre_estudiante" name="nombre_estudiante">
                                <input type="hidden" id="usuario_login" name="usuario_login">
                                <input type="hidden" name="id_reporte_influencer" id="id_reporte_influencer">
                                <button type="submit" class="btn btn-primary">Enviar Respuesta</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </form>
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
    <script type="text/javascript" src="scripts/reporte_influencer.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>