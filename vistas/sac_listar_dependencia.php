<?php
session_start();
//Activamos el almacenamiento en el buffer
ob_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header('Location: ../');
    exit();
} else {
    $menu = 2;
    $submenu = 215;
    require 'header.php';
    if ($_SESSION['sac_listar_dependencia'] == 1) {
?>
        <style>
            .popover-tarea {

                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            }

            .popover-tarea.oculto {
                visibility: hidden;
                /* o opacity: 0; */
                /* pero NO display: none; */
            }
        </style>

        <div id="popoverFormularioTarea" class="popover-tarea tono-1 borde rounded p-2" style="display:none; position:absolute; z-index:1055; width:300px;">
            <form id="formulariocreartarea" name="formulariocreartarea" class="p-3 m-0 rounded shadow tono-2" style="width: 100%;" method="POST">
                <div class="float-right">
                    <button type="button" onclick="cerrarPopoverTarea()" class="btn btn-link" aria-label="Cerrar">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="form-group mb-2">
                    <label for="nombre_tarea">Nombre Tarea</label>
                    <textarea rows="2" class="form-control" id="nombre_tarea" name="nombre_tarea" required></textarea>
                </div>
                <div class="form-group mb-2">
                    <label for="fecha_tarea">Fecha Tarea</label>
                    <input type="date" class="form-control" id="fecha_tarea" name="fecha_tarea" required>
                </div>
                <div class="form-group mb-2">
                    <label for="responsable_tarea">Responsable</label>
                    <select class="form-control selectpicker" data-live-search="true" id="responsable_tarea" name="responsable_tarea">
                        <!-- opciones -->
                    </select>
                </div>
                <input type="hidden" id="id_accion_tarea" name="id_accion_tarea">
                <input type="hidden" id="id_meta_tarea" name="id_meta_tarea">
                <button type="submit" class="btn bg-purple btn-sm w-100">Crear tarea</button>
            </form>
        </div>


        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2 mx-0">
                        <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Planificación</span><br>
                                <span class="fs-16 f-montserrat-regular">Define, planíifica y gestiona tu próximo sprint con tu equipo</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Planificación</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content" style="padding-top: 0px;">
                <div class="row mx-0">
                    <div class="col-12 px-4">
                        <div class="col-12 text-right d-none">
                            <button type="button" class="tooltip-agregar btn bg-purple btn-flat btn-xs" onclick="crear_meta()" title="Agregar metas" data-toggle="tooltip" data-placement="top">
                                <i class="fas fa-flag-checkered"></i> Agregar metas
                            </button>
                        </div>
                        <div class="col-12 text-right">
                            <button type="button" class="btn bg-purple btn-xs" data-toggle="modal" data-target="#modalmeta">
                                <i class="fas fa-flag-checkered"></i> Agregar meta
                            </button>
                        </div>
                        <div class="col-12">
                            <a id="btn-panel" onclick="guardarLocal(1)" class="btn btn-link btn-xs mb-2"><i class="fa-solid fa-sd-card"></i> Panel</a>
                            <a id="btn-cuadricula" onclick="guardarLocal(2)" class="btn btn-link btn-xs mb-2"><i class="fa-solid fa-table-cells"></i> Cuadricula</a>
                            <a id="ocultar_boton_volver" onclick="volver()" class="btn btn-danger btn-sm text-semibold float-right d-none"><i class="fa-solid fa-chevron-left"></i> Volver</a>
                        </div>


                        <div class="row" id="mostrar_ocultar_metas">
                            <div class="col-6  pt-4 tono-3 d-none" id="seleccionar_periodo">
                                <div class="col-12 text-md-left">
                                    <form name="formulario" id="formulario" method="POST">
                                        <div class="row" style="display:flex; justify-content: flex-end">
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-5 p-0 m-0">
                                                <div class="form-group">
                                                    <div class="form-floating">
                                                        <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo_sac" id="periodo_sac">
                                                            <option value="2025">2025</option>
                                                            <option value="2024">2024</option>
                                                            <option value="2023">2023</option>
                                                            <option value="2022">2022</option>
                                                        </select>
                                                        <label> Periodo</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-5 p-0 m-0">
                                                <a onclick="buscar()" value="" class="btn btn-success py-3 text-white">Buscar</a>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-5 p-0 m-0">
                                                <button type="button" class="tooltip-agregar btn bg-purple btn-flat btn-xs" onclick="crear_meta()" title="Agregar metas" data-toggle="tooltip" data-placement="top">
                                                    <i class="fas fa-flag-checkered"></i> Agregar metas
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>





                            <!-- <div class="card col-12 p-4 ">
                                <div class="row col-12">
                                    <div class="col-12 table-responsive">
                                        <table id="tbllistado" class="table" style="width: 100%;">
                                            <thead>
                                                <th id="tabla_ejemplo" scope="col">Responsable</th>
                                                <th scope="col">Cargo</th>
                                                <th scope="col">Metas asignadas</th>
                                                <th id="porcentaje_avance" scope="col">% Cumplimiento</th>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                    </div>
                </div>
            </section>

            <div class="d-flex justify-content-end">

            </div>
            <div id="verpanel">
                <div id="datopanel"> </div>
            </div>

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




        </div>

        <div class="modal fade" id="myModalNombreAccionUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Acciones</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label class="meta_responsable_accion">Acciones: </label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal crear y editar meta -->
        <div class="modal" id="myModalMeta" style="overflow-y: scroll;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="text-semibold fs-16 titulo-2 fs-16 line-height-16" id="editarycrearmeta"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="col-12 modal-body">
                        <form name="formulariocrearmetaeditar" id="formulariocrearmetaeditar" method="POST">
                            <div id="mostrar_ocultar_ejes" class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required="" class="form-control border-start-0 selectpicker" data-live-search="true" name="nombre_ejes" id="nombre_ejes" onChange="mostrarproyectos(this.value)"></select>
                                        <label>Ejes</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required="" class="form-control border-start-0 selectpicker" data-live-search="true" data-required="true" name="nombre_proyectos" id="nombre_proyectos"></select>
                                        <label>Proyectos</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            
                            <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" class="form-control border-start-0" name="plan_mejoramiento" id="plan_mejoramiento"  onchange="javascript:this.value=this.value.toUpperCase();">
                                        <label>Oportunidad de mejora</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="meta_nombre" id="meta_nombre"  required onchange="javascript:this.value=this.value.toUpperCase();">
                                        <label>Nombre de la meta</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div> -->
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <label>Condiciones Institucionales:</label>
                                <div class="box_condiciones_institucionales form-check" id="box_condiciones_institucionales" required=""></div>
                                <label>Condiciones De programa:</label>
                                <div class="condiciones_programa form-check" id="condiciones_programa" required=""></div>
                                <br>
                                <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="date" placeholder="" value="" required="" class="form-control border-start-0" name="meta_fecha" id="meta_fecha" required>
                                            <label>Fecha</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div> -->
                                <!-- <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select required class="form-control border-start-0 selectpicker" data-live-search="true" name="anio_eje" id="anio_eje">
                                            <option value="">Seleccione un año</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select required class="form-control border-start-0 selectpicker"
                                                    data-live-search="true"
                                                    name="meta_responsable"
                                                    id="meta_responsable">
                                                <option value="" disabled selected>Seleccione un responsable</option>
                                            </select>
                                            <label for="meta_responsable">Responsable</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Por favor selecciona un responsable.</div>
                                </div> -->

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_indicador" id="nombre_indicador">
                                            <label>Nombre del Indicador </label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col">
                                    <input type="number" name="porcentaje_avance_indicador" id="porcentaje_avance_indicador" class="form-control" placeholder="porcentaje de avance">
                                </div>
                            </div>
                            <br>
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <!-- <input type="text" class="d-noned id_proyecto" name="id_proyecto"> -->
                                <input type="number" class="d-none id_meta" id="id_meta" name="id_meta">
                                <!-- <button class="btn btn-primary" type="submit" id="btnGuardometa"><i class="fa fa-save"></i> Guardar</button> -->
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal para crear las tareas -->
        <div class="modal" id="ModalCrearTarea">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">CREAR TAREA</h6>
                        <button type="button" class="close" data-dismiss="modal" onclick="cancelarform()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="panel-body p-3">
                            <!-- <form name="formulariocreartarea" id="formulariocreartarea" method="POST">
                                <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <label>Nombre Tarea</label>
                                        <div class="form-floating">
                                            <textarea rows="3" type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_tarea" id="nombre_tarea" required></textarea>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <input type="date" required class="form-control border-start-0" name="fecha_tarea" id="fecha_tarea">
                                                    <label for="fecha_fin">Fecha Tarea:</label>
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="responsable_tarea" id="responsable_tarea"></select>
                                            <label>Responsable</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <label>Link Tarea</label>
                                        <div class="form-floating">
                                            <textarea rows="3" type="text" placeholder="" value="" class="form-control border-start-0" name="link_tarea" id="link_tarea"></textarea>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="number" class="d-none id_accion_tarea" id="id_accion_tarea" name="id_accion_tarea">
                                    <input type="number" class="d-none id_meta_tarea" id="id_meta_tarea" name="id_meta_tarea">
                                    <input type="number" class="d-none id_tarea_sac" id="id_tarea_sac" name="id_tarea_sac">
                                    <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="myModalMostrarTareas">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <h6 class="modal-title">Tareas
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="listar_tareas_accion"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal crear metodologia (accion) -->
        <div class="modal" id="ModalAccion">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Acciones</h6>
                        <button type="button" class="close" data-dismiss="modal" onclick="cancelarform()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="panel-body p-3">
                            <!-- <form name="formularioaccionguardar" id="formularioaccionguardar" method="POST">
                                <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <label>¿Nombre de la acción?</label>
                                        <div class="form-floating">
                                            <textarea rows="3" type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_accion" id="nombre_accion" required></textarea>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <input type="date" required class="form-control border-start-0" name="fecha_fin" id="fecha_fin">
                                                    <label for="fecha_fin">Fecha de entrega:</label>
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="time" class="form-control border-start-0" name="hora_accion" id="hora_accion" required>
                                            <label for="hora_accion">Hora de entrega</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese una hora válida</div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="number" class="d-none id_meta_accion" id="id_meta_accion" name="id_meta_accion">
                                    <input type="number" class="d-none id_accion" id="id_accion" name="id_accion">
                                    <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar acción</button>
                                </div>
                            </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal detalle de la meta-->
        <div class="modal fade" id="myModalNombreMetaUsuario" tabindex="-1" aria-labelledby="myModalNombreMetaUsuario" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
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

        <!-- Modal -->
        <div class="modal fade" id="modalmeta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar una meta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="formnuevameta" id="formnuevameta" method="POST">

                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="meta_nombre" id="meta_nombre" required onchange="javascript:this.value=this.value.toUpperCase();">
                                        <label>Nombre de la meta</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <!-- <div  class="col-xl-12 col-lg-12 col-md-12 col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select value="" required="" class="form-control border-start-0 selectpicker" data-live-search="true" name="nombre_ejes" id="nombre_ejes" ></select>
                                    <label>Ejes</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>  

                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select value="" required="" class="form-control border-start-0 selectpicker" data-live-search="true" data-required="true" name="nombre_proyectos_agregar" id="nombre_proyectos_agregar"  onchange="cargarProyectosPorEje(this.value)"></select>
                                    <label>Proyectos</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div> -->

                            <div id="mostrar_ocultar_ejes" class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required="" class="form-control border-start-0 selectpicker" data-live-search="true" name="id_eje" id="id_eje" onChange="mostrarproyectos_insertar(this.value)"></select>
                                        <label>Ejes</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required="" class="form-control border-start-0 selectpicker" data-live-search="true" data-required="true" name="id_proyecto" id="id_proyecto"></select>
                                        <label>Proyectos</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>


                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" class="form-control border-start-0" name="plan_mejoramiento" id="plan_mejoramiento" onchange="javascript:this.value=this.value.toUpperCase();">
                                        <label>Oportunidad de mejora</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>



                            <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select required class="form-control border-start-0 selectpicker" data-live-search="true" name="anio_eje" id="anio_eje">
                                            <option value="">Seleccione un año</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="date" placeholder="" value="" required="" class="form-control border-start-0" name="fecha_inicio" id="fecha_inicio" required>
                                        <label>Fecha de inicio</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="date" placeholder="" value="" required="" class="form-control border-start-0" name="meta_fecha" id="meta_fecha" required>
                                        <label>Fecha de vencimiento</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select required class="form-control border-start-0 selectpicker"
                                            data-live-search="true"
                                            name="meta_responsable"
                                            id="meta_responsable">
                                            <option value="" disabled selected>Seleccione un responsable</option>
                                        </select>
                                        <label for="meta_responsable">Responsable</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Por favor selecciona un responsable.</div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <input type="number" class="d-none id_meta" id="id_meta" name="id_meta">
                                <button class="btn btn-success" type="submit" id="btnGuardometa"><i class="fa fa-save"></i> Agregar tarea</button>
                            </div>
                        </form>
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

    <script type="text/javascript" src="scripts/saclistardependencia.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<?php
}
ob_end_flush();
?>