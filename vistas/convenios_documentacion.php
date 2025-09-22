<?php
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $submenu = 3402;
    $menu = 34;
    require 'header.php';

    if ($_SESSION['convenios_documentacion'] == 1) {
?>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Gestión Convenios</span>
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
                                <li class="breadcrumb-item active">Gestión Convenios</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row">
                            <div class="col-12 card">
                                <div class="row">
                                    <div class="col-6 p-4 tono-3">
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
                                    <div class="col-6 tono-3 text-right py-4 pr-4">
                                        <button class="btn btn-success" id="btnagregarcarpeta" onclick="carpetaDocumento()"><i class="fa fa-plus-circle"></i> Crear Convenio</button>
                                        <button class="btn btn-success" id="btnagregarchecklist" onclick="crearchecklist()"><i class="fa fa-plus-circle"></i> Agregar Items</button>
                                        <button class="btn btn-success" id="btnagregararchivo" onclick="subirarchivo()"><i class="fa fa-plus-circle"></i>Subir Documento</button>
                                        <button class="btn btn-success" id="btnagregarcomentario" onclick="agregarcomentario()"><i class="fa fa-plus-circle"></i> Agregar Comentario</button>
                                        <button onclick="volver()" class="btn btn-danger btn-flat btn-sm text-semibold" id="btn_volver" style="color: white !important;"><i class="fa-solid fa-chevron-left"></i> Volver</button>
                                    </div>
                                    <div class="col-12 table-responsive p-4" id="mostrar_carpeta">
                                        <div class="panel-body table-responsive p-4">
                                            <table id="tblistacarpeta" class="table" style="width:100%">
                                                <thead class="text-center">
                                                    <th>Opciones</th>
                                                    <th>Nombre Convenio</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                    
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-12 table-responsive p-4" id="mostrar_check_list">
                                        <div class="panel-body table-responsive p-4">
                                            <table id="tblistachecklist" class="table" style="width:100%">
                                                <thead class="text-center">
                                                    <th>Opciones</th>
                                                    <th>Nombre</th>
                                                    <th>Estado</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-12 table-responsive p-4" id="verarchivoscheckList">
                                        <div class="panel-body table-responsive p-4">
                                            <table id="tablaverarchivoscheckList" class="table" style="width:100%">
                                                <thead class="text-center">
                                                    <th>Nombre Archivo</th>
                                                    <th>Fecha</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-12 table-responsive p-4" id="verarcomentarios">
                                        <div class="panel-body table-responsive p-4">
                                            <table id="tablavercomentarios" class="table" style="width:100%">
                                                <thead class="text-center">
                                                    <th>Comentarios</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
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
        </div>
        <!-- Modal para Crear Carpeta -->
        <div class="modal" id="carpetadocumento">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crear_convenio"> </h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="formulariocrearcarpeta" method="POST">
                            <input type="hidden" id="id_convenio_carpeta" name="id_convenio_carpeta">
                            <!-- <div class="form-group">
                                <input type="text" name="carpeta" id="carpeta" required maxlength="28" class="form-control" placeholder="Nombre Convenio" />
                            </div> -->
                            <div class="form-group col-lg-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <textarea type="text" placeholder="" value="" class="form-control border-start-0" style="height: 164px;" name="carpeta" id="carpeta" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit" id="btnCrearCarpeta"><i class="fa fa-save"></i> Guardar</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para agregar los items -->
        <div class="modal" id="crearchecklistconvenio">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="agregar_items"></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="formulariocrearchecklist" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="id_convenio_documento_subir" name="id_convenio_documento_subir">
                            <input type="hidden" id="id_convenio_documento_subir_editar" name="id_convenio_documento_subir_editar">
                            <!-- <div class="form-group">
                                <input type="text" name="nombre_convenio" id="nombre_convenio" required maxlength="28" class="form-control" placeholder="Nombre" />
                            </div> -->
                            <div class="form-group col-lg-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <textarea type="text" placeholder="" value="" class="form-control border-start-0" style="height: 164px;" name="nombre_convenio" id="nombre_convenio" ></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit" id="btnCrearDocumento"><i class="fa fa-save"></i> Publicar</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="buscarArchivosModal" tabindex="-1" aria-labelledby="buscarArchivosLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="buscarArchivosLabel">Archivos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="buscararchivoscarpeta" class="table" style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nombre Archivo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal para subir los archivos -->
        <div class="modal" id="subirarchivo">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Archivo</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="formulariosubirarchivo" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="id_convenio_subir_archivo" name="id_convenio_subir_archivo">
                            <!-- <div class="form-group">
                                <input type="text" name="comentarios" id="comentarios" required maxlength="28" class="form-control" placeholder="Comentarios" />
                            </div> -->
                            <div class="form-group">
                                <label for="archivo_documento">Archivo</label>
                                <input type="file" name="archivo_documento" class="form-control-file" id="archivo_documento">
                                <input type="hidden" name="imagenactual" id="imagenactual">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit" id="btnCrearDocumento"><i class="fa fa-save"></i> Publicar</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal para agregar los comentarios -->
        <div class="modal" id="agregarcomentarios">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Comentario</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="formulariocomentarios" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="id_convenio_documento_comentarios" name="id_convenio_documento_comentarios">

                            <div class="form-group col-lg-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <textarea type="text" placeholder="" value="" class="form-control border-start-0" style="height: 164px;" name="comentarios" id="comentarios" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <input type="text" name="comentarios" id="comentarios" required maxlength="28" class="form-control" placeholder="Comentarios" />
                            </div> -->
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit" id="btnCrearDocumento"><i class="fa fa-save"></i> Publicar</button>
                            </div>
                        </form>
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
    <script src="scripts/convenios_documentacion.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
ob_end_flush();
