<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 2;
    $submenu = 222;
    require 'header.php';
    if ($_SESSION['sactareas'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Mi plan</span><br>
                                <span class="fs-16 f-montserrat-regular">Define, planíifica y gestiona tu próximo sprint con tu equipo</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Tareas</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid px-4">

                <div class="col-12">
                    <a id="btn-panel" onclick="guardarLocal(1)" class="btn btn-link btn-xs mb-2"><i class="fa-solid fa-sd-card"></i> Panel</a>
                    <a id="btn-cuadricula" onclick="guardarLocal(2)" class="btn btn-link btn-xs mb-2"><i class="fa-solid fa-table-cells"></i> Cuadricula</a>
                    <a id="btn-pendientes" onclick="guardarLocal(3)" class="btn btn-link btn-xs mb-2"><i class="fas fa-list-ul"></i> Tareas pendientes</a>
                    <a id="btn-realizadas" onclick="guardarLocal(4)" class="btn btn-link btn-xs mb-2"><i class="fas fa-list-check"></i> Tareas Realizadas</a>
                    <a id="ocultar_boton_volver" onclick="volver()" class="btn btn-danger btn-sm text-semibold float-right d-none"><i class="fa-solid fa-chevron-left"></i> Volver</a>
                </div>
                <div class="row mx-0">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row">
                            <div class=" col-12">
                                <div class="row">


                                    <!-- <div id="mostrar_metas">
                                        <div class="meta_responsable"> </div>
                                    </div> -->



                                    <div id="verpanel">
                                        <div id="datopanel"> </div>
                                    </div>
                                    <!-- tabla para colocarlo en modo cuadricula -->
                                    <div class="col-12 p-2" id="vercuadricula">
                                        <table id="tbcuadricula" class="table" style="width: 130%;">
                                            <thead>
                                                <th></th>
                                                <th>Nombre de la meta</th>
                                                <th>Responsable</th>
                                                <th>Participantes</th>
                                                <th>Acciones/tareas</th>
                                                <th>Fecha de inicio</th>
                                                <th>Fecha de vencimiento</th>
                                                <th>Eje estratégico</th>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>

                                        <!-- Tabla de tareas pendientes -->

                                        <div class="col-12 p-2 d-none" id="verpendientes">
                                            <h4>Tareas pendientes</h4>
                                            <table id="tbpendientes" class="table" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Nombre tarea</th>
                                                        <th>Fecha entrega</th>
                                                        <th>Link tarea</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Tabla de tareas finalizadas -->

                                        <div class="col-12 p-2 d-none" id="verfinalizadas">
                                            <h4>Tareas finalizadas</h4>
                                            <table id="tbfinalizadas" class="table" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Nombre tarea</th>
                                                        <th>Fecha entrega</th>
                                                        <th>Link tarea</th>
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


        <!-- Modal para agregar link de evidencia cuadricula -->
        <div id="popoverFormularioLinkTarea" class="popover-tarea tono-1 borde rounded p-2 d-none" style="position:absolute; z-index:1055; width:300px;">
            <div class="float-right">
                <button type="button" onclick="cerrarPopoverTarea()" class="btn btn-link" aria-label="Cerrar">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <input type="hidden" id="modal_id_tarea_sac">
            <div class="form-group">
                <label for="modal_link_evidencia_tarea_cuadricula">Link</label>
                <input type="text" class="form-control" id="modal_link_evidencia_tarea_cuadricula" placeholder="Ingrese el link de evidencia">
            </div>
            <button type="button" class="btn btn-danger" onclick="cerrarPopoverTarea()">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="guardarLinkDesdeModal()">Guardar</button>
        </div>



        <!-- Modal para agregar link de evidencia panel -->
        <div class="modal fade" id="modalLinkTarea" tabindex="-1" aria-labelledby="modalLinkTareaLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLinkTareaLabel">Agregar Link de Evidencia</h5>
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="modal_id_tarea_sac">
                        <div class="form-group">
                            <label for="modal_link_evidencia_tarea">Link</label>
                            <input type="text" class="form-control" id="modal_link_evidencia_tarea" placeholder="Ingrese el link de evidencia">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarLinkDesdeModal()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="myModalNombreMetaUsuario" tabindex="-1" aria-labelledby="myModalNombreMetaUsuario" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="row" id="detalleconte"></div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modalacciones" tabindex="-1" aria-labelledby="modalacciones" aria-hidden="true">
            <div class="modal-dialog modal-lg ">
                <div class="modal-content">

                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="row" id="detalleacciones"></div>
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
    <script type="text/javascript" src="scripts/sactareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>