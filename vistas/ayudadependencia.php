<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 25;
    $submenu = 2502;
    require 'header.php';
    if ($_SESSION['ayudadependencia'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Solicitudes Académicas y Administrativas</span><br>
                                <span class="fs-16 f-montserrat-regular">.....</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Consultas Contáctanos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="row">
                    <div class="col-12 p-4 tono-3">
                        <div class="row">
                            <div class="col-6 pt-4 pl-4 tono-3 ">
                                <div class="row align-items-center pt-2">
                                    <div class="pl-1">
                                        <span class="rounded bg-light-green p-3 text-success ">
                                            <i class="fa-solid fa-headset" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-12 col-3">
                                        <div class="fs-14 line-height-18">
                                            <span>Resultados</span> <br>
                                            <span class="text-semibold fs-16 parrafo-normal">Contáctanos</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-xl-12 mt-5">
                                <div class="row col-12">
                                    <div class="col-12 table-responsive" id="listadoregistros">
                                        <table id="tbllistado" class="table" style="width: 100%;">
                                            <thead>
                                                <th>Acción</th>
                                                <th>Caso</th>
                                                <th>Asunto</th>
                                                <th>Opción</th>
                                                <th>Mensaje</th>
                                                <th>Fecha</th>
                                                <th>Estado</th>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body" id="formularioregistros">
                    <form name="formulario" id="formulario" method="POST">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Asunto:</label>
                            <input type="hidden" name="id_credencial" id="id_credencial">
                            <input type="text" class="form-control" name="asunto" id="asunto" maxlength="50" placeholder="Asunto del Mensaje" required>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Mensaje:</label>
                            <textarea class="form-control" name="mensaje" id="mensaje" rows="10" required>
                            </textarea>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Dirigido a:</label>
                            <select class="form-control" name="dependencia" id="dependencia" class="form-control selectpicker" data-live-search="true" required>
                            </select>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Enviar</button>
                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                        </div>
                    </form>
                </div>
                <!-- modals -->
                <div class="modal" id="myModalTerminado">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Conversación</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div id="historialTerminado"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Conversación</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="historial" style="z-index: 100"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="myModalTerminado">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Conversación</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="historialTerminado"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="myModalContacto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Datos de Contacto</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="resultado_contacto"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!---------------------------------------------------------------------  MODALES(Ver whatsapp)   ---------------------------------------------------------------------------->
        <div class="modal fade" id="modal_whatsapp" tabindex="-1" role="dialog" aria-labelledby="modal_whatsapp_label">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h6 class="modal-title" id="modal_whatsapp_label"> WhatsApp CIAF</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 m-0 seccion_conversacion">
                                    <?php require 'whatsapp_module.php'; ?>
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
    ?>
    <script src="scripts/ayudadependencia.js"></script>
    <script src="scripts/whatsapp_module.js"></script>
<?php
}
ob_end_flush();
?>