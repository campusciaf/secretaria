<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 2;
    $submenu = 212;
    require 'header.php';

    if ($_SESSION['sac_planeacion'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2 mx-0">
                        <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Gestión de proyectos</span><br>
                                <span class="fs-16 f-montserrat-regular">Establezca, ejecute y vigile el cumplimiento de nuestro propósito superior</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión de proyectos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid px-4">
                <div class="row mx-0">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row mx-0">
                            <div class="card col-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-8 p-1 tono-3 py-3" id="ocultargestionproyecto">
                                        <div class="row align-items-center">
                                            <div class="col-auto pl-4"> <!-- Clase col-auto para el ícono -->
                                                <div class="rounded bg-light-blue p-3 text-primary ">
                                                    <i class="fa-solid fa-gear"></i>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <span>Gestión</span> <br>
                                                <span class="text-semibold fs-16 parrafo-normal">Proyectos</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-4 text-right py-4 pr-4 tono-3" id="ocultargestionproyecto2">
                                        <a onclick="volverejes()" class="btn btn-danger btn-flat text-semibold" style="color: white !important;"><i class="fa-solid fa-chevron-left"></i> Volver</a>
                                    </div>
                                    <div class="col-12 pt-2" id="ver_proyectos">
                                        <button class="btn btn-success " data-toggle="modal" data-target="#ModalCrearProyecto"><i class="fa fa-plus-circle"></i>Nuevo proyecto</button>
                                        <div class="panel-body table-responsive p-4" id="listadoregistros">
                                            <table id="tbllistadometas" class="table" style="width:100%">
                                                <thead class="text-center">
                                                    <th>Opciones</th>
                                                    <th>Nombre del Proyecto</th>
                                                    <th>Total de metas 2025</th>
                                                    <th>Total de metas 2024</th>
                                                    <th>Total de metas 2023</th>
                                                    <th>Total de metas 2022</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-12 pt-2" id="ver_tareas_tabla">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-3 pl-4 d-flex justify-content-end">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="row ">
                                                        <div class="col-12 hidden">
                                                            <div class="row ">
                                                                <div class="col-auto">
                                                                    <div class="avatar rounded bg-light-green text-success">
                                                                        <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="col ps-0">
                                                                    <div class="small mb-0">Total</div>
                                                                    <h4 class="text-dark mb-0">
                                                                        <span class="text-semibold" id="totalCumplidas">--</span>
                                                                        <small class="text-regular">OK</small>
                                                                    </h4>
                                                                    <div class="small">Tareas Cumplidas <span class="text-green"></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="row">
                                                        <div class="col-12 hidden">
                                                            <div class="row ">
                                                                <div class="col-auto">
                                                                    <div class="avatar rounded bg-light-red text-danger">
                                                                        <i class="fa-solid fa-xmark"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="col ps-0">
                                                                    <div class="small mb-0">Total</div>
                                                                    <h4 class="text-dark mb-0">
                                                                        <span class="text-semibold" id="totalNoCumplidas">--</span>
                                                                        <small class="text-regular">OK</small>
                                                                    </h4>
                                                                    <div class="small">Tareas No Cumplidas <span class="text-green"></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-8 p-4">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto pl-4">
                                                            <div class="rounded bg-light-blue p-3 text-primary ">
                                                                <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="col-12 fs-14 line-height-18">
                                                                <span class="">Resultados</span> <br>
                                                                <span class="text-semibold fs-20 parrafo-normal">Tareas</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-4 text-right py-4 pr-4">
                                                    <a onclick="volver_panel()" class="btn btn-danger btn-flat float-right text-semibold" style="color: white !important;"><i class="fa-solid fa-chevron-left"></i> Volver</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body table-responsive p-4" id="listadotareas">
                                            <table id="tbllistadotareas" class="table" style="width:100%">
                                                <thead class="text-center">
                                                    <th>Meta</th>
                                                    <th>Acción</th>
                                                    <th>Nombre Tarea</th>
                                                    <th>Fecha entrega</th>
                                                    <th>Link evidencia</th>
                                                    <th>Nombre Funcionario</th>
                                                    <th>Estado Tarea</th>
                                                    <th>Estado Vencida</th>
                                                    <th>Días</th>
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
                </div>
            </section>
            <section class="container-fluid px-4" id="ver_metas">
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
                                                <span class="text-semibold" id="numero_metas_cumplidas">--</span>
                                                <small class="text-regular">OK</small>
                                            </h4>
                                            <div class="small">Metas Cumplidas <span class="text-green"></span></div>
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
                                                <span class="text-semibold" id="numero_metas_nocumplidas">--</span>
                                                <small class="text-regular">OK</small>
                                            </h4>
                                            <div class="small">Metas No Cumplidas <span class="text-green"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mx-0">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row mx-0">
                            <div class="card col-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-8 p-1 tono-3 py-3" id="ocultarmetas">
                                        <div class="row align-items-center">
                                            <div class="col-auto pl-4"> <!-- Clase col-auto para el ícono -->
                                                <div class="rounded bg-light-blue p-3 text-primary ">
                                                    <i class="fa-solid fa-gear"></i>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="fs-14 line-height-18">
                                                    <span>Resultados</span> <br>
                                                    <span class="text-semibold fs-16 parrafo-normal">Metas</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-4 text-right py-4 pr-4 tono-3" id="ocultarmetas2">
                                        <a onclick="volverejes()" class="btn btn-danger btn-flat btn-sm text-semibold" style="color: white !important;"><i class="fa-solid fa-chevron-left"></i> Volver</a>
                                    </div>
                                    <div class="col-12" id="ver_proyectos">
                                        <div class="panel-body table-responsive p-4" id="listadoregistrosmeta">
                                            <table id="tbllistadometa" class="table" style="width:100%">
                                                <thead>
                                                    <th>Estado</th>
                                                    <th>Nombre Meta</th>
                                                    <th>Proyecto</th>
                                                    <th>Porcentaje</th>
                                                    <th>Acciones</th>
                                                </thead>
                                                <tbody class="parrafo-normal fs-14">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="container-fluid px-4" id="ver_acciones">
                <div class="row mx-0">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row mx-0">
                            <div class="card col-12">
                                <div class="row mx-0">
                                    <div class="col-12 " id="ocultarmetas_acciones">
                                        <div class="row mx-0">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-8 p-1 tono-3 py-3">
                                                <div class="row">
                                                    <div class="col-auto pl-4">
                                                        <div class="rounded bg-light-blue p-3 text-primary ">
                                                            <i class="fa-solid fa-gear"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <span>Resultados</span> <br>
                                                        <span class="text-semibold fs-16 parrafo-normal fs-14">Acciones</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-4 text-right py-4 pr-4 tono-3" id="ocultarmetas2">
                                                <a onclick="volverejes()" class="btn btn-danger btn-flat btn-sm text-semibold" style="color: white !important;"><i class="fa-solid fa-chevron-left"></i> Volver</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12" id="ver_proyectos">
                                        <div class="panel-body table-responsive p-4" id="listadoregistrosmeta">
                                            <table id="tbllistaacciones" class="table" style="width:100%">
                                                <thead>
                                                    <th>Opciones</th>
                                                    <th>Nombre Acción</th>
                                                    <th>Meta</th>
                                                </thead>
                                                <tbody class="parrafo-normal fs-14">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="container-fluid px-4" id="ver_tareas">
                <div class="row mx-0">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row mx-0">
                            <div class="card col-12">
                                <div class="row">
                                    <div class="col-12 " id="ocultarmetas_tareas">
                                        <div class="row mx-0">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-8 p-1 tono-3 py-3">
                                                <div class="row">
                                                    <div class="col-auto pl-4">
                                                        <div class="rounded bg-light-blue p-3 text-primary ">
                                                            <i class="fa-solid fa-gear"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <span>Resultados</span> <br>
                                                        <span class="text-semibold fs-16 parrafo-normal fs-14">Tareas</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-4 text-right py-4 pr-4 tono-3" id="ocultarmetas2">
                                                <a onclick="volverejes()" class="btn btn-danger btn-flat btn-sm text-semibold" style="color: white !important;"><i class="fa-solid fa-chevron-left"></i> Volver</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12" id="ver_proyectos">
                                        <div class="panel-body table-responsive p-4" id="listadoregistrosmeta">
                                            <table id="tbllistatareas" class="table" style="width:100%">
                                                <thead>
                                                    <th scope="col">Opciones</th>
                                                    <th scope="col">Nombre Tarea</th>
                                                    <th scope="col">Fecha entrega</th>
                                                    <th scope="col">Responsable</th>
                                                    <th scope="col">Link tarea</th>
                                                    <th scope="col">Estado</th>
                                                </thead>
                                                <tbody class="parrafo-normal fs-14">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="container-fluid px-4">
                <div class="row mx-0">
                    <div class="col-xl-9 col-lg-8 col-md-8 col-6  pl-3 " id="ocultarpanelanio">
                        <div class="row align-items-center pt-2">
                            <div class="pl-4 col-auto">
                                <span class="rounded bg-light-blue p-3 text-primary">
                                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fs-14 line-height-18">
                                    <span class="">Planeación</span> <br>
                                    <span class="text-semibold fs-16 titulo-2 fs-16 line-height-16" id="dato_periodo"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-4 col-6 " id="seleccionar_periodo">
                        <form name="formulario" id="formulario" method="POST" class="row mx-0">
                            <div class="col-12 p-0 m-0" id="tour_buscar">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo_sac" id="periodo_sac" onchange="listar_ejes(this.value)"></select>
                                        <label>Buscar periodo</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12">
                        <div class="row mx-0" id="contenido"></div>
                        <div class="row mx-0" id="listar_ejes"></div>
                        <div class="row mx-0" id="ver_plan"></div>
                    </div>
                    <div class="col-12 m-0 p-0" id="ver_tabla_proyecto_acciones"></div>
                    <div class="col-12 m-0 p-0" id="ver_tabla_tareas"></div>
                    <div class="col-12 m-0 p-0" id="ver_plan_proyecto"></div>
                </div>
            </section>
        </div>

        <!-- Modal Crear Proyecto -->
        <div class="modal" id="ModalCrearProyecto">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Nuevo proyecto</h6>
                        <button type="button" class="close" data-dismiss="modal" onclick="cancelarform()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="panel-body p-3">
                            <form name="formularioproyecto" id="formularioproyecto" method="POST">
                                <div class="col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_proyecto" id="nombre_proyecto" required>
                                            <label>Nombre</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="number" class="d-none" id="id_ejes" name="id_ejes">
                                    <input type="number" class="d-none" id="id_proyecto" name="id_proyecto">
                                    <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal Nombre Accion Eje -->
        <div class="modal fade" id="myModalNombreAccionEje" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Acciones</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label class="id_accion_label"> Acciones: </label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal Nombre Usuario -->
        <div class="modal fade" id="myModalNombreMetaUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll;">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Meta</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="id_meta  col-12"> Nombre Meta: </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para ver las acciones y los proyectos -->
        <div class="modal fade" id="myModalNombreProyecto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll ;">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Acciones</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label class="nombre_proyecto_accion"></label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal Nombre Accion Usuario -->
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
                        <label class="id_meta"> Nombre Accion: </label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Crear Objetivos ESPECIFICOS -->
        <div class="modal fade" id="ModalCrearObjetivosEspecifico" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Crear Obejtivo Especifico</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="#" name="formularioobjetivosespecifico" id="formularioobjetivosespecifico" method="POST">
                            <div class="form-group">
                                <label for="exampleInputtext">Nombre</label>
                                <input type="text" class="form-control" id="nombre_objetivo_especifico" name="nombre_objetivo_especifico" placeholder="Nombre Objetivo">
                            </div>
                            <div>
                                <input type="number" class="d-none" id="id_objetivo" name="id_objetivo">
                                <input type="number" class="d-none" id="id_objetivo_especifico" name="id_objetivo_especifico">
                            </div>
                            <button type="submit" class="btn btn-primary" id="btnGuardarObjetivoEspecifico"><i class="fa fa-save"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="ModalAccion">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">CREAR METODOLOGÍA</h6>
                        <button type="button" class="close" data-dismiss="modal" onclick="cancelarform()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="panel-body p-3">
                            <form name="formularioaccion" id="formularioaccion" method="POST">
                                <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <textarea rows="3" type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_accion" id="nombre_accion" required></textarea>
                                            <label>¿Cómo?</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="row">
                                    <!-- <div class="col-sm">
                                        <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <input type="date" required class="form-control border-start-0" name="fecha_accion" id="fecha_accion">
                                                    <label for="fecha_accion">Desde:</label>
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                    </div> -->
                                    <div class="col-sm">
                                        <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <input type="date" required class="form-control border-start-0" name="fecha_fin" id="fecha_fin">
                                                    <label for="fecha_fin">Hasta:</label>
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
                                            <label for="hora_accion">Hora</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese una hora válida</div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="number" class="d-none id_meta" id="id_meta" name="id_meta">
                                    <input type="number" class="d-none id_accion" id="id_accion" name="id_accion">

                                    <input type="date" class="d-none fecha_accion_anterior_fin" id="fecha_accion_anterior_fin" name="fecha_accion_anterior_fin">
                                    <input type="time" class="d-none hora_anterior" id="hora_anterior" name="hora_anterior">
                                    <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Meta -->
        <div class="modal" id="myModalMeta" style="overflow-y: scroll;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Crear Meta</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="col-12 modal-body">
                        <form name="formularioguardometa" id="formularioguardometa" method="POST">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="plan_mejoramiento" id="plan_mejoramiento" maxlength="100" required onchange="javascript:this.value=this.value.toUpperCase();">
                                        <label>Plan de Mejoramiento</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="meta_nombre" id="meta_nombre" maxlength="100" required onchange="javascript:this.value=this.value.toUpperCase();">
                                        <label>Nombre de la meta</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <label>Condiciones Institucionales:</label>
                                <div class="box_condiciones_institucionales form-check" id="box_condiciones_institucionales">
                                </div>
                                <label>Condiciones De programa:</label>
                                <div class="condiciones_programa form-check" id="condiciones_programa" required>

                                </div>
                                <!-- <label>Corresponsable:</label>
                                    <div class="form-check" id="dependencias" required>
                                    </div> -->
                                <br>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="date" placeholder="" value="" required class="form-control border-start-0" name="meta_fecha" id="meta_fecha" required>
                                            <label>Fecha</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="anio_eje" id="anio_eje">
                                                <label>Año</label>
                                                <?php
                                                for ($i = 2021; $i <= 2030; $i++) {
                                                ?>
                                                    <option value="<?php echo $i ?>" name="<?php echo $i ?>"><?php echo $i ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="meta_responsable" id="meta_responsable"></select>
                                            <label>Responsable</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_indicador" id="nombre_indicador" required>
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
                            <!-- <div class="row">
                                    <label>Meta cumplida</label>
                                    <div class="btn-group btn-group-toggle col-12" data-toggle="buttons">
                                        <label class="btn btn-info col-12 ">
                                            <input style="height: 0.5px" type="radio" id="meta_lograda" name="meta_lograda" value="1"> SI
                                        </label>
                                        <label class="btn btn-info active col-12">
                                            <input style="height: 0.5px" name="meta_lograda" value="0" type="radio"> NO
                                        </label>
                                    </div>
                                </div> -->
                            <br>
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <input type="text" class="d-none id_proyecto" name="id_proyecto">
                                <input type="number" class="d-none id_meta" id="id_meta" name="id_meta">
                                <button class="btn btn-primary" type="submit" id="btnGuardometa"><i class="fa fa-save"></i> Guardar</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>



            </div>

        </div>

        <div class="modal" id="ModalCrearTarea">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">CREAR TAREA</h6>
                        <button type="button" class="close" data-dismiss="modal" onclick="cancelarform()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="panel-body p-3">
                            <form name="formulariocreartarea" id="formulariocreartarea" method="POST">
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
                                            <textarea rows="3" type="text" placeholder="" value="" class="form-control border-start-0" name="link_tarea" id="link_tarea" required></textarea>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <!-- <input type="number" class="d-nonef id_accion_tarea" id="id_accion_tarea" name="id_accion_tarea">
                                        <input type="number" class="d-nonef id_meta_tarea" id="id_meta_tarea" name="id_meta_tarea"> -->
                                    <input type="number" class="d-none id_tarea_sac" id="id_tarea_sac" name="id_tarea_sac">
                                    <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                </div>
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

    <script type="text/javascript" src="scripts/sac_proyecto.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <style>
        .zoom {
            transition: transform .2s;
        }

        .zoom:hover {
            transform: scale(3);
            /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
        }
    </style>
<?php
}
ob_end_flush();
?>