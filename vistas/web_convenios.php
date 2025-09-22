<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 33;
    $submenu = 3304;
    require 'header.php';

    if ($_SESSION['webconvenios'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Administrador Convenio</span><br>
                                <span class="fs-16 f-montserrat-regular">Administra los convenios de la pagina web.</span>
                            </h2>
                        </div>
                        <div class="col-6 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Administrador Convenio</li>
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
                                                    <span class="text-semibold fs-20">Administrador Convenio</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 text-right py-4 pr-4 tono-3">
                                        <button class="btn btn-success pull-right" id="tour_agregar_convenio" onclick="mostraragregarconvenio(true)"><i class="fa fa-plus-circle"></i> Agregar Convenio</button>
                                    </div>
                                    <div class="col-12">
                                        <div class="panel-body table-responsive p-4">
                                            <table id="tbllistaconvenios" class="table" style="width:100%">
                                                <thead class="text-center">
                                                    <th id="tour_opciones">Opciones</th>
                                                    <th id="tour_archivo">Archivo</th>
                                                    <th id="tour_nombre_convenio">Nombre Convenio</th>
                                                    <th id="tour_descripcion_convenio">Descripción Convenio</th>
                                                    <th id="tour_url_convenio">Url Convenio</th>
                                                    <th id="tour_estado">Estado</th>
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
            <div class="modal fade" id="ModalEditarConvenio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Convenio</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioeditarconvenios" id="formularioeditarconvenios" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="nombre_convenio_editar" id="nombre_convenio_editar" maxlength="100" required>
                                                <label>Nombre Convenio</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>

                                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="url_convenio_editar" id="url_convenio_editar" maxlength="100" required>
                                                <label>Url</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                        <div class="mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="categoria_convenios_imagen_editar" id="categoria_convenios_imagen_editar">
                                                    <label>Categoría</label>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <textarea type="text" placeholder="" value="" class="form-control border-start-0" style="height: 164px;" name="descripcion_convenio_editar" id="descripcion_convenio_editar" required></textarea>
                                                <label>Descripción</label>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <br>
                                            <label for="agregar_imagen_editar" style="cursor: pointer">
                                                <img src="../public/img/escritorio.svg" width="90px" height="110px" alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto mobile">
                                            </label>
                                            <input id="agregar_imagen_editar" name="agregar_imagen_editar" type="file" style="display: none" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <input type="number" class="d-none id_web_convenio_editar" id="id_web_convenio_editar" name="id_web_convenio_editar">
                                    <input type="text" class="d-none" name="agregar_editar_imagen_editar" id="agregar_editar_imagen_editar">
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
            <div class="modal fade" id="ModalConvenio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Agregar Convenio</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioagregarconvenio" id="formularioagregarconvenio" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="nombre_convenio" id="nombre_convenio" maxlength="100" required>
                                                <label>Nombre Convenio</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="url_convenio" id="url_convenio" maxlength="100" required>
                                                <label>Url</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                        
                                    </div>


                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                        <div class="mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="categoria_convenios_imagen" id="categoria_convenios_imagen">
                                                    <label>Categoría</label>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>



                                    <div class="form-group col-lg-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <textarea type="text" placeholder="" value="" class="form-control border-start-0" style="height: 164px;" name="descripcion_convenio" id="descripcion_convenio" required></textarea>
                                                <label>Descripción</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <br>
                                            <label for="agregar_imagen" style="cursor: pointer">
                                                <img src="../public/img/escritorio.svg" width="90px" height="110px" alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto mobile">
                                            </label>
                                            <input id="agregar_imagen" name="agregar_imagen" type="file" style="display: none" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <input type="number" class="d-none id_web_convenio" id="id_web_convenio" name="id_web_convenio">
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
        </div>

    <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>

    <script type="text/javascript" src="scripts/web_convenios.js"></script>

<?php
}
ob_end_flush();
?>