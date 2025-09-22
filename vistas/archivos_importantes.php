<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $submenu = 3403;
    $menu = 34;
    require 'header.php';
    if ($_SESSION['archivos_importantes'] == 1) {
?>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Certificados Externos</span>
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
                                <li class="breadcrumb-item active">Certificados Externos</li>
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
                                                    <span>Certificados Externos</span> - <span id="area_usuario"></span> <br> <br>
                                                    <span class="text-semibold fs-20">Campus virtual</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 tono-3 text-right py-4 pr-4">
                                        <button class="btn btn-success" id="btncreararchivoimportante" onclick="creararchivoimportante()"><i class="fa fa-plus-circle"></i> Crear Certificados</button>
                                        <button class="btn btn-success" id="btnsubirdocumentoimportante" onclick="subirdocumentoimportante()"><i class="fa fa-plus-circle"></i> Crear Documento Importante</button>
                                        <button onclick="volver()" class="btn btn-danger btn-flat btn-sm text-semibold" id="btn_volver" style="color: white !important;"><i class="fa-solid fa-chevron-left"></i> Volver</button>
                                    </div>
                                    <div class="col-12 table-responsive p-4" id="archivos_importantes">
                                        <div class="panel-body table-responsive p-4">
                                            <table id="tblistadocumentos" class="table" style="width:100%">
                                                <thead class="text-center">
                                                    <th>Opciones </th>
                                                    <th>Entidad </th>
                                                    <th>Telefono </th>
                                                    <th>Fecha Creación </th>
                                                    <th>Hora </th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-12 table-responsive p-4" id="documentos">
                                        <div class="panel-body table-responsive p-4">
                                            <table id="mostrararchivosimportantes" class="table" style="width:100%">
                                                <thead class="text-center">
                                                    <th>Opciones </th>
                                                    <th>Nombre Archivo </th>
                                                    <th>Fecha </th>
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
        <div class="modal" id="creararchivoimportante">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="documento_texto"></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="formulariosubirarchivoimportante" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="id_dependencia_subir_documento" name="id_dependencia_subir_documento">
                            <input type="hidden" id="id_dependencia_archivo_importante" name="id_dependencia_archivo_importante">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="entidad" id="entidad" maxlength="100" required>
                                        <label>Entidad</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="number" placeholder="" value="" required="" class="form-control border-start-0" name="telefono" id="telefono">
                                        <label>Teléfono</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="date" placeholder="" value="" class="form-control border-start-0" name="fecha_vencimiento" id="fecha_vencimiento">
                                        <label>Fecha Vencimiento</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="detalles" id="detalles" maxlength="200" required>
                                        <label>Detalles</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
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
        <div class="modal" id="mostrardocumentosimportantes">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="archivo_texto"></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="formulariosubirdocumentoimportante" method="POST" enctype="multipart/form-data">
                            <input type="hidden" id="id_dependencia_subir_archivo_importante" name="id_dependencia_subir_archivo_importante">
                            <input type="hidden" id="id_archivos_importantes_documentos" name="id_archivos_importantes_documentos">
                            <input type="hidden" id="archivo_importante_nombre" name="archivo_importante_nombre">
                            <div class="form-group">
                                <label for="agregar_documento_archivo">Archivo</label>
                                <input type="file" name="agregar_documento_archivo" class="form-control-file" id="agregar_documento_archivo">
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
    <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
    <script src="scripts/archivos_importantes.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
