<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 2;
    $submenu = 219;
    require 'header.php';
    if ($_SESSION['poa_por_usuario'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">POA 2025</span><br>
                                <span class="fs-16 f-montserrat-regular">Establezca, ejecute y vigile el cumplimiento de nuestro propósito superior</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">POA 2025</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid px-4">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row">
                            <div class="card col-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-8 p-1 tono-3 py-3" id="ocultargestionproyecto">
                                        <div class="row align-items-center">
                                            <div class="col-auto pl-4">
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
                                        <div class="panel-body table-responsive p-4" id="listadoregistros">
                                            <table id="tbllistadometas" class="table" style="width:100%">
                                                <thead class="text-center">
                                                    <th>Nombre del Proyecto</th>
                                                    <th>Total de metas 2025</th>
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
                <div class="row col-12 mb-3">
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
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row">
                            <div class="card col-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-8 p-1 tono-3 py-3" id="ocultarmetas">
                                        <div class="row align-items-center">
                                            <div class="col-auto pl-4">
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

            <!-- <section class="container-fluid px-4" id="ver_acciones">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row">
                            <div class="card col-12">
                                <div class="row">
                                    <div class="col-12 " id="ocultarmetas_acciones">
                                        <div class="row">
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
                                                    <th>Nombre Acción</th>
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
            </section> -->
            <section class="container-fluid px-4">
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
                                    <span class="">Planeación</span> <br>
                                    <span class="text-semibold fs-16 titulo-2 fs-16 line-height-16" id="dato_periodo"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-4 col-6 pt-3 tono-3" id="seleccionar_periodo">
                        <form name="formulario" id="formulario" method="POST" class="row align-items-center">
                            <div class="col-4 text-left">
                                <button type="button" class="tooltip-agregar btn bg-purple btn-flat btn-xs" onclick="crear_meta()" title="Agregar metas" data-toggle="tooltip" data-placement="top">
                                    <i class="fas fa-flag-checkered"></i> Agregar metas
                                </button>
                            </div>
                            <div class="col-8 p-0" id="tour_buscar">
                                <div class="form-floating">
                                    <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo_sac" id="periodo_sac" onchange="listar_ejes(this.value)">
                                        <option value="2025">2025</option>
                                        <option value="2024">2024</option>
                                        <option value="2023">2023</option>
                                        <option value="2022">2022</option>
                                    </select>
                                    <label>Buscar periodo</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row m-0 p-0" id="listar_ejes"></div>
                </div>
            </section>
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
                            <div class="nombre_proyecto_accion"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Meta -->
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
                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="nombre_ejes" id="nombre_ejes" onChange="mostrarproyectos(this.value)"></select>
                                            <label>Ejes</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div id="mostrar_ocultar_proyectos" class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="nombre_proyectos" id="nombre_proyectos"></select>
                                            <label>Proyectos</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
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
                                            <textarea rows="3" type="text" placeholder="" value="" required="" class="form-control border-start-0" name="meta_nombre" id="meta_nombre" maxlength="100" required onchange="javascript:this.value=this.value.toUpperCase();"></textarea>
                                            <label>¿El Qué?</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <label>Condiciones Institucionales:</label>
                                    <div class="box_condiciones_institucionales form-check" id="box_condiciones_institucionales"></div>
                                    <label>Condiciones De programa:</label>
                                    <div class="condiciones_programa form-check" id="condiciones_programa" required></div>
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
                                                    <?php for ($i = 2021; $i <= 2030; $i++) { ?>
                                                        <option value="<?php echo $i ?>" name="<?php echo $i ?>"><?php echo $i ?></option>
                                                    <?php } ?>
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
                                    <br>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                        <input type="text" class="d-none id_proyecto" name="id_proyecto">
                                        <input type="number" class="d-none id_meta" id="id_meta" name="id_meta">
                                        <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="myModalNombreMetaUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalLabel">Metas del area</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="id_meta"> </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
    <script type="text/javascript" src="scripts/poa_por_usuario.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
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