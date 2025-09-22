<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $submenu = 3701;
    $menu = 37;
    require 'header.php';
    if ($_SESSION['gestion_licitaciones'] == 1) {
?>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Gestión Procesos De Extensión</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'>
                                <i class="fa-solid fa-play"></i> Tour
                            </button>
                        </div>
                        <div class="col-12 migas mb-0">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión Procesos de Extensiones</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-6 p-4">
                        <div class="row align-items-center">
                            <div class="pl-3">
                                <span class="rounded bg-light-blue p-3 text-primary ">
                                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div class="col-10">
                                <div class="col-5 fs-14 line-height-18">
                                    <span class="" id="lugar_tabla"></span> <br>
                                    <span class="text-semibold fs-20">Campus virtual</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 text-right py-4 pr-4">
                        <button class="btn rounded bg-light-green  p-3 text-center" id="btnagregarcarpeta" onclick="CrearTarea()">
                            <i class="fa fa-plus-circle text-success p-2 fa-2x"></i>
                            <p class="text-muted fs-14 mb-1 pt-2 titulo-2 line-height-16">
                                Nuevo Proceso
                            </p>
                        </button>
                        <button class="btn rounded bg-light-green  p-3 text-center" id="btnagregaitem" onclick="CrearItem()">
                            <i class="fas fa-circle-plus text-success p-2 fa-2x"></i>
                            <p class="text-muted fs-14 mb-1 pt-2 titulo-2 line-height-16">
                                Nuevo Item
                            </p>
                        </button>
                        <button class="btn rounded bg-light-green  p-3 text-center" id="btnacomentariosglobales" onclick="ComentariosTotales()">
                            <i class="fas fa-comments text-success p-2 fa-2x"></i>
                            <p class="text-muted fs-14 mb-1 pt-2 titulo-2 line-height-16">
                                Comentarios
                            </p>
                        </button>
                        <button class="btn rounded bg-light-blue  p-3 text-center" id="btnHistoricoArchivos" onclick="HistoricoArchivos()">
                            <i class="fas fa-folder-open text-info p-2 fa-2x"></i>
                            <p class="text-muted fs-14 mb-1 pt-2 titulo-2 line-height-16">
                                Archivos
                            </p>
                        </button>
                        <button class="btn rounded bg-light-red  p-3 text-center" id="ocultar_boton_volver" onclick="volver()">
                            <i class="fa-solid fa-chevron-left text-danger p-2 fa-2x"></i>
                            <p class="text-muted fs-14 mb-1 pt-2 titulo-2 line-height-16">
                                Volver
                            </p>
                        </button>
                    </div>
                    <div class="col-12" id="mostrar_carpeta">
                        <div class="card p-1 panel-body table-responsive">
                            <table id="tblistatareas" class="table" style="width:100%">
                                <thead>
                                    <th>Opciones</th>
                                    <th>Proceso</th>
                                    <th>Progreso</th>
                                    <th>Prioridad</th>
                                    <th>Objeto</th>
                                    <th>Enlace</th>
                                    <th>Entidad</th>
                                    <th>Inicio</th>
                                    <th>Cierre</th>
                                    <th>Porcentaje</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12" id="mostrar_items">
                        <div class="card p-1 panel-body table-responsive">
                            <table id="tblistaitems" class="table" style="width:100%">
                                <thead class="text-center">
                                    <th>Opciones</th>
                                    <th>Nombre Items</th>
                                    <th>Responsable</th>
                                    <th>Estado</th>
                                </thead>
                                <tbody class="text-center">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Modal para Crear Carpeta -->
        <div class="modal fade" id="MymodalMostrarTarea" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crear_tarea"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form name="formulariocreartareas" id="formulariocreartareas" method="POST">
                            <div class="row mb-3">
                                <input type="hidden" id="id_licitaciones_tarea" name="id_licitaciones_tarea">
                                <div class="col-md-6">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select required class="form-control border-start-0" name="tipo_de_proceso" id="tipo_de_proceso" onchange="cambiarTipoProceso(this.value)">
                                                <option value="" disabled selected>Selecciona el tipo de proceso</option>
                                                <option value="Público">Público</option>
                                                <option value="Privado">Privado</option>
                                            </select>
                                            <label>Tipo Proceso</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" required class="form-control border-start-0" name="nombre_tarea" id="nombre_tarea" required>
                                            <label>Proceso</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 box_buscar_codigo_licitacion">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating input-group">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="buscar_codigo_licitacion" id="buscar_codigo_licitacion">
                                            <label>Buscar Código</label>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary btn-sm" type="button" id="btn_buscar_codigo"> <i class="fas fa-search"></i> Buscar </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 div_codigo_licitacion">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="codigo_licitacion" id="codigo_licitacion">
                                            <label for="codigo_licitacion">Codigos </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 box_codigo_licitacion">
                                    <table id="tabla_codigo_licitacion" class="table" style="width:100%">
                                        <thead>
                                            <th>Codigo</th>
                                            <th>Nombre</th>
                                            <th>Agregar</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="number" placeholder="" value="" required class="form-control border-start-0" name="valor" id="valor" required>
                                            <label for="valor">Presupuesto oficial</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select type="text" placeholder="" value="" required class="form-control border-start-0" name="entidad_contratante" id="entidad_contratante" required data-live-search="true" onchange="verificarEntidad(this.value)">
                                            </select>
                                            <label for="entidad_contratante">Entidad Contratante</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 box_otra_entidad_contratante" id="box_otra_entidad_contratante">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating input-group">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="otra_entidad_contratante" id="otra_entidad_contratante">
                                            <label>Razón Social</label>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-success btn-sm" type="button" id="btn_otra_entidad_contratante"> <i class="fas fa-plus"></i> Agregar </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="progreso_tarea" id="progreso_tarea">
                                                <option value="Creado">Creado</option>
                                                <option value="En revision">En revisión</option>
                                                <option value="Presentado">Presentado</option>
                                                <option value="En ajuste">En ajuste</option>
                                                <option value="Suscrito">Suscrito</option>
                                                <option value="Completado">Completado</option>
                                                <option value="Ejecutado">Ejecutado</option>
                                            </select>
                                            <label>Progreso</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="prioridad" id="prioridad"></select>
                                            <label>Prioridad</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="facultad" id="facultad">
                                                <option value="Administración de empresas">Administración de empresas</option>
                                                <option value="Contaduría Pública">Contaduría Pública</option>
                                                <option value="Ingenieria de software">Ingenieria de software</option>
                                                <option value="Ingenieria Industrial">Ingenieria Industrial</option>
                                                <option value="Seguridad y Salud en el Trabajo">Seguridad y Salud en el Trabajo</option>
                                                <option value="No Aplica">No Aplica</option>
                                            </select>
                                            <label>Facultad</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="tipo_contratacion" id="tipo_contratacion">
                                                <option value="Licitación pública">Licitación Pública</option>
                                                <option value="Concurso de méritos">Concurso de Méritos</option>
                                                <option value="Selección Abreviada">Selección Abreviada</option>
                                                <option value="Mínima cuantía">Mínima Cuantía</option>
                                                <option value="Contratación Directa">Contratación Directa</option>
                                                <option value="Convenio">Convenio</option>
                                            </select>
                                            <label for="tipo_contratacion">Tipo Contratación</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="date" placeholder="" value="" required class="form-control border-start-0" name="fecha_inicio" id="fecha_inicio" required>
                                            <label for="fecha_inicio">Fecha de Inicio</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="date" placeholder="" value="" required class="form-control border-start-0" name="fecha_vencimiento" id="fecha_vencimiento" required>
                                            <label for="fecha_vencimiento">Cierre de propuesta</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" required class="form-control border-start-0" name="enlace_proceso" id="enlace_proceso" required>
                                            <label for="enlace_proceso"> Enlace Proceso </label>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-12 mb-3">
                                    <label for="notas" class="form-label">Objeto</label>
                                    <textarea class="form-control" id="notas" name="notas" rows="3" placeholder="Escriba el objeto del proceso."></textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Añade observaciones del proceso."></textarea>
                                </div>
                            </div>
                            <button class="btn btn-success" type="submit" id="btnEnviarComentario">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal para mostrar los items -->
        <div class="modal" id="myModalListarItems">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <h6 class="modal-title">Items
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="mostrar_item_tabla"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- editar item-->
        <div class="modal" id="myModalGuardaryEditarItem">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Item</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form name="formulariocrearyeditaritems" id="formulariocrearyeditaritems" method="POST">
                        <input type="hidden" id="crear_editar_id_licitaciones_item" name="crear_editar_id_licitaciones_item">
                        <input type="hidden" id="item_id_licitaciones_tarea" name="item_id_licitaciones_tarea">
                        <div class="modal-body">
                            <div class="mb-3">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required class="form-control border-start-0" name="nombre_elemento" id="nombre_elemento" required>
                                        <label>Nombre</label>
                                    </div>
                                </div>
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="usuario_responsableitem" id="usuario_responsableitem"></select>
                                        <label>Responsable</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="date" min="2024-12-12" max="2024-12-17" placeholder="" value="" required class="form-control border-start-0" name="fecha_inicio_item" id="fecha_inicio_item" required>
                                            <label>Fecha de Inicio</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="date" placeholder="" value="" required class="form-control border-start-0" name="fecha_entregar_item" id="fecha_entregar_item" required>
                                            <label>Cierre de propuesta</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success" type="submit" id="btnInsertarItem">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- subir archivos por items -->
        <div class="modal" id="myModalSubirArchivos">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <h6 class="modal-title">Items
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="mostrar_archivos_items"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- mostrar si esta terminado o no  -->
        <div class="modal fade" id="MymodalEstadoCompletado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Estado Completado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form name="formulariofueaprobado" id="formulariofueaprobado" method="POST">
                            <input type="hidden" id="id_licitaciones_tarea_aprobado" name="id_licitaciones_tarea_aprobado">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="aprobado" id="aprobado">
                                                <option value="1">Fue Aprobado</option>
                                                <option value="0">No fue Aprobado</option>
                                            </select>
                                            <label>Estado</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required class="form-control border-start-0" name="porque_aprobado" id="porque_aprobado" required>
                                        <label>Porque Fue Aprobado</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success" type="submit" id="btnEnviarCompletado">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="myModalListarComentariosGlobales">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <h6 class="modal-title">Comentario Global
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="mostrar_global_tabla"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- total comentarios --->
        <div class="modal" id="myModalListarComentariosTotales">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <h6 class="modal-title">Comentario Global
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="mostrar_comentarios_totales_tabla"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- total comentarios --->
        <div class="modal" id="myModalHistoricoArchivos">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <h6 class="modal-title">Historico de archivos
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="mostrar_HistoricoArchivos">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
    <script src="scripts/licitaciones.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();