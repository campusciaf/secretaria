<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 33;
    $submenu = 3308;
    require 'header.php';

    if ($_SESSION['web_reglamentos'] == 1) {
?>

        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Reglamentos</span><br>
                                <span class="fs-16 f-montserrat-regular">Administra los reglamentos de la pagina web.</span>
                            </h2>
                        </div>
                        <div class="col-6 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Reglamentos</li>
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
                                    <div class="col-6 p-4 tono-3" id="ocultargestionproyecto">
                                        <div class="row align-items-center">
                                            <div class="pl-4">
                                                <span class="rounded bg-light-blue p-3 text-primary ">
                                                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                            <div class="col-10">
                                                <div class="col-12 fs-14 line-height-18">
                                                    <span class="">Resultados</span> <br>
                                                    <span class="text-semibold fs-20">Administrador Programa</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 text-right py-4 pr-4 tono-3">
                                        <button class="btn btn-success pull-right" id="btnagregar" onclick="mostraragregarpdf(true)"><i class="fa fa-plus-circle"></i> Agregar Reglamento</button>
                                    </div>
                                    <div class="col-12">
                                        <div class="panel-body table-responsive p-4">
                                            <table id="tbllistareglamento" class="table" style="width:100%">
                                                <thead class="text-center">
                                                    <th>Opciones</th>
                                                    <th>Nombre Reglamento</th>
                                                    <th>Archivo</th>
                                                    <th>Categoria</th>
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
                </div>
            </section>

            <!-- section modals -->
            <div class="modal fade" id="Modalpdf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Agregar Reglamento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioagregarpdf" id="formularioagregarpdf" method="POST" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="form-group col-12">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_reglamento" id="nombre_reglamento" required>
                                            <label>Nombre Reglamento</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-12">

                                        <div class="mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="categoria_reglamento" id="categoria_reglamento">
                                                    <label>Categoria reglamento</label>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                        
                                    </div>
                                </div>

                                <div class="form-group col-xs-12">
                                    <br>
                                    <span class="text-info">Tamaño máximo del archivo PDF es 5 Megas</span><br>
                                    <label for="agregar_pdf" style="cursor: pointer">
                                        <img src="../public/img/adjuntar_archivo.svg" width="90px" height="110px" alt="Click aquí para adjuntar PDF" title="Click aquí para adjuntar PDF">
                                    </label>
                                    <input id="agregar_pdf" name="agregar_pdf" type="file" style="display: none" name="MAX_FILE_SIZE" value="500000" />

                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <input type="number" class="d-none id_web_reglamento" id="id_web_reglamento" name="id_web_reglamento">
                                    <input type="text" class="d-none" name="editarguardarimg" id="editarguardarimg">
                                    <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="ModalpdfEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reglamento Editar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioagregarpdfeditar" id="formularioagregarpdfeditar" method="POST" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="form-group col-12">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_reglamento_editar" id="nombre_reglamento_editar" required>
                                            <label>Nombre Reglamento</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <div class="mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="categoria_reglamento_editar" id="categoria_reglamento_editar">
                                                    <label>Categoria reglamento</label>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>                                     
                                    </div>
                                    <div class="form-group col-12">
                                        <br>
                                        <span class="text-info">Tamaño máximo del archivo PDF es 5 Megas</span><br>
                                        <label for="agregar_pdf_editar" style="cursor: pointer">
                                            <img src="../public/img/adjuntar_archivo.svg" width="90px" height="110px" alt="Click aquí para adjuntar PDF" title="Click aquí para adjuntar PDF">
                                        </label>
                                        <input id="agregar_pdf_editar" name="agregar_pdf_editar" type="file" style="display: none" />
                                    </div>
                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <input type="number" class="d-none id_web_reglamento_editar" id="id_web_reglamento_editar" name="id_web_reglamento_editar">
                                    <input type="text" class="d-none" name="editarguardarimg_editar" id="editarguardarimg_editar">
                                    <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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

    <script type="text/javascript" src="scripts/web_reglamentos.js"></script>

<?php
}
ob_end_flush();
?>