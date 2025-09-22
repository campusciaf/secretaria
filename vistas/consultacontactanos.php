<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 25;
    $submenu = 2501;
    require 'header.php';
    if ($_SESSION['consultascontactanos'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Gestión PQRS</span><br>
                                <span class="fs-16 f-montserrat-regular">Consulta las solicitidues de los estudiantes.</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Consulta general</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="row m-0">
                    <div class="col-12 px-4 tono-3">
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
                            <div class="col-xl-6 col-lg-3 col-md-12 col-12 pt-4">
                                <div class="row">
                                    <div class="col-12 p-0 m-0">
                                        <form name="datos_filtro_renovaciones" id="datos_filtro_renovaciones" method="POST">
                                            <div class="row">
                                                <div class="col-lg-5 col-md-5 col-12 p-0 m-0">
                                                    <div class="form-group">
                                                        <div class="form-floating">
                                                            <select required class="form-control border-start-0 selectpicker" data-live-search="true" name="dependencias_consulta" id="dependencias_consulta">
                                                            </select>
                                                            <label for="dependencias_consulta">Dependencias</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Segundo select, ocupa 6 columnas en dispositivos grandes y el 100% en móviles -->
                                                <div class="col-lg-5 col-md-5 col-12 p-0 m-0">
                                                    <div class="form-group">
                                                        <div class="form-floating">
                                                            <select required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo" id="periodo">
                                                            </select>
                                                            <label for="periodo">Periodo</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-12 p-0 m-0">
                                                    <input type="submit" value="Consultar" class="btn btn-success py-3" />
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-12 p-4">
                                <div class="row col-12">
                                    <div class="col-12 table-responsive" id="contenedor_tabla">


                                        <table id="tblrenovar" class="table" style="width: 100%;">

                                            <div class="row col-12 mb-3 mx-0">
                                                <div class="col-12 d-flex justify-content-end">
                                                    <div class="col-auto ">
                                                        <div class="row justify-content-center">
                                                            <div class="col-12 hidden">
                                                                <div class="row align-items-center">
                                                                    <div class="col-auto">
                                                                        <div class="avatar rounded bg-light-green text-success">
                                                                            <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col ps-0">
                                                                        <div class="small mb-0">Total</div>
                                                                        <h4 class="text-dark mb-0">
                                                                            <span class="text-semibold" id="finalizadas">--</span>
                                                                        </h4>
                                                                        <div class="small">Finalizado <span class="text-green"></span></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="row justify-content-center">
                                                            <div class="col-12 hidden">
                                                                <div class="row align-items-center">
                                                                    <div class="col-auto">
                                                                        <div class="avatar rounded bg-light-red text-danger">
                                                                            <i class="fa-solid fa-xmark"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col ps-0">
                                                                        <div class="small mb-0">Total</div>
                                                                        <h4 class="text-dark mb-0">
                                                                            <span class="text-semibold" id="pendientes">--</span>
                                                                        </h4>
                                                                        <div class="small">Pendiente <span class="text-green"></span></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <thead>
                                                <th> Accion</th>
                                                <th> Asunto</th>
                                                <th> Opción</th>
                                                <th> Mensaje </th>
                                                <th> Historial</th>
                                                <th> Fecha solicitud</th>
                                                <th> Dependencia</th>
                                                <th> Periodo</th>
                                                <th> Estado</th>
                                                <th> Fecha_cierre</th>
                                                <th> Tiempo respuesta</th>
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
        <!-- <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><small id="nombre_programa"></small>Consultas Contáctanos</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Contáctanos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="box-header with-border">
                                <div id="mostrardatos" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <form id="datos_filtro_renovaciones" method="POST">
                                        <div class="row">
                                            <div class="col-7">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-book-reader"> Dependencias</i></span>
                                                    </div>
                                                    <select name="dependencias" class="form-control" id="dependencias" class="form-control selectpicker" data-live-search="true" data-style="border" required>
                                                        <option value='0' selected> Todas las dependencias </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"> Periodo</i></span>
                                                    </div>
                                                    <select name="periodo" id="periodo" class="form-control selectpicker" data-live-search="true" data-style="border" required>
                                                        <option value='0' selected> Todos los periodos </option>
                                                    </select>
                                                    <span class="input-group-append">
                                                        <input type="submit" value="Consultar" class="btn btn-success" />
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="box">
                                <h4 class="mb-2 text-center">Listado de casos contáctanos</h4>
                                <div class="box-body">
                                    <div id="contenedor_tabla">
                                        <table id="tblrenovar" class="table table-hover table-nowarp">
                                            <thead>
                                                <tr align="center">
                                                    <th> Asunto</th>
                                                    <th> Opción</th>
                                                    <th> Mensaje</th>
                                                    <th> Historial</th>
                                                    <th> Fecha solicitud</th>
                                                    <th> Dependencia</th>
                                                    <th> Periodo</th>
                                                    <th> Estado</th>
                                                    <th> Fecha_cierre</th>
                                                    <th> Tiempo respuesta</th>

                                                </tr>
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
            </section>
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
        </div> -->

<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/consultacontactanos.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script src="scripts/whatsapp_module.js"></script>