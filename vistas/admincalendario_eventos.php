<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login");
} else {
    $menu = 3;
    $submenu = 303;
    require 'header.php';
    if ($_SESSION['admincalendarioeventos'] == 1) {
?>
        <link rel="stylesheet" href="../public/css/fullcalendar.min.css">
        <link rel="stylesheet" href="../public/css/fullcalendar.print.min.css" media="print">

        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Administrador Eventos</span><br>
                                <span class="fs-14 f-montserrat-regular">Esta es la ventana a lo increible.</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas mb-0">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Administrador eventos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;" id="contenido2">
                <div class="row mx-0">
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
                        <div class="form-group mb-3 position-relative check-valid d-flex align-items-end">
                            <div class="form-floating flex-grow-1 me-2">
                                <select required class="form-control border-start-0 selectpicker" data-live-search="true" name="anio_filtro" id="anio_filtro"></select>
                                <label>Buscar Periodo</label>
                            </div>
                            <a onclick="volver()" class="btn btn-primary">Volver</a>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div class="card col-12 p-4">
                        <div class="row card card-primary" style="padding: 2% 1%">
                            <div class="col-lg-12 table-responsive">
                                <table id="tbllistaeventos" class="table compact table-striped table-condensed table-hover">
                                    <thead>
                                        <th>Opciones</th>
                                        <th></th>
                                        <th>Linea (Bienestar)</th>
                                        <th>Fecha</th>
                                        <th>Evento</th>
                                        <th>Total de participantes</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="container-fluid px-4" id="contenido1">
                <div class="row mx-0">
                    <div class="col-12 m-0 my-4" id="resultado_eventos"></div>
                    <div class="col-xl-8 col-lg-8 col-md-7 col-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div id="calendar"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-5 col-12" id="actividades"> </div>
                </div>
            </section>
        </div>

        <!-- Modal (Agregar, Modificar, Borrar Calendario)-->
        <div class="modal fade" id="modalCalendario" tabindex="-1" role="dialog" aria-labelledby="modalCalendario" aria-hidden="true">
            <form method="POST">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modalCalendarioLabel">Agregar Evento</h6>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="idActividad" name="idActividad" /><br>
                            <div class="form-row">

                                <div class="col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="txtTitulo" id="txtTitulo" maxlength="100">
                                            <label>Nombre de la actividad</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>

                                <div class="form-group col-12">
                                    <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4" cols="50" style="resize:none;" placeholder="Descripción de la actividad"></textarea>
                                </div>

                                <div class="col-6">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="date" placeholder="" value="" required="" class="form-control border-start-0" name="txtFechaInicio" id="txtFechaInicio">
                                            <label>Fecha Inicio</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="date" placeholder="" value="" required="" class="form-control border-start-0" name="txtFechaFin" id="txtFechaFin">
                                            <label>Fecha Fin</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="time" placeholder="" value="" required="" class="form-control border-start-0" name="txtTime" id="txtTime">
                                            <label>Hora inicio</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="txtActividadTipo" id="txtActividadTipo"></select>
                                            <label>Tipo de Actividad</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>



                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="botonAgregar" class="btn btn-success">Agregar</button>
                            <button type="button" id="botonModificar" class="btn btn-success">Modificar</button>
                            <button type="button" id="botonEliminar" class="btn btn-danger">Eliminar</button>
                            <button type="button" onclick="LimpiarFormulario()" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="gestioneventos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Gestión Eventos</h6>
                    </div>
                    <div class="modal-body" id="resultado_gestion">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .fc th {
                padding: 10px 0px;
                vertical-align: middle;
                background: #f2f2f2;
            }

            .fc-content {
                cursor: pointer;
            }

            .fc-day:hover {
                background-color: #b5d2da;
                cursor: pointer;
            }
        </style>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script src="../bower_components/moment/moment.js"></script>
<script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="../bower_components/fullcalendar/dist/locale/es.js"></script>


<script src='https://darsa.in/sly/examples/js/vendor/plugins.js'></script>
<script src='../public/js/sly.min.js'></script>





<script src="scripts/admincalendario_eventos.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>