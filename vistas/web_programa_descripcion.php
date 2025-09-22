<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 33;
    $submenu = 3307;
    require 'header.php';

    if ($_SESSION['web_programa_descripcion'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Administrador Programa Descripción</span><br>
                                <span class="fs-16 f-montserrat-regular">Administra la descripcion de los programas de la pagina web.</span>
                            </h2>
                        </div>
                        <div class="col-6 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Administrador Programa Descripción</li>
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
                                        <button class="btn btn-success pull-right" id="tour_agregar_programas_descripcion" onclick="mostraragregarprogramas(true)"><i class="fa fa-plus-circle"></i> Agregar Descripción</button>
                                    </div>
                                    <div class="col-12">
                                        <div class="panel-body table-responsive p-4">
                                            <table id="tbllistaprogramas" class="table" style="width:100%">
                                                <thead class="text-center">
                                                    <th id="tour_opciones">Opciones</th>
                                                    <th id="tour_programa">Programa</th>
                                                    <th id="tour_imagen_escritorio">Imagen Escritorio</th>
                                                    <th id="tour_video">Video</th>
                                                    <th id="tour_titulo_descripcion">Titulo Descripción</th>
                                                    <th id="tour_descripcion_programa">Descripción Programa</th>
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

            <div class="modal fade" id="ModalEditarProgramas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Programa Descripción</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioeditarprogramas" id="formularioeditarprogramas" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <textarea type="text" placeholder="Titulo Descripción" value="" class="form-control border-start-0" style="height: 164px;" name="titulo_descripcion_editar" id="titulo_descripcion_editar" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <textarea type="text" placeholder="Descripción Programa" value="" class="form-control border-start-0" style="height: 164px;" name="descripcion_programa_editar" id="descripcion_programa_editar" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                        <div class="mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="categoria_programas_editar" id="categoria_programas_editar">
                                                    <label>Programa</label>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12" id="videoeimagen"></div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <br>
                                        <span class="text-info">Escritorio debe ser de 428x306</span>
                                        <label for="agregar_imagen_programa_editar" style="cursor: pointer">
                                            <img src="../public/img/escritorio.svg" width="90px" height="110px" alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto">
                                        </label>
                                        <input id="agregar_imagen_programa_editar" name="agregar_imagen_programa_editar" type="file" style="display: none" require>
                                    </div>
                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <input type="number" class="d-none id_web_programa_descripcion_editar" id="id_web_programa_descripcion_editar" name="id_web_programa_descripcion">
                                    <input type="text" class="d-none" name="guardar_img_programas_editar" id="guardar_img_programas_editar">
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
            <div class="modal fade" id="ModalPrograma" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Agregar Descripción </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioprograma" id="formularioprograma" method="POST" enctype="multipart/form-data">

                                <div class="row">

                                    <div class="form-group col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <textarea type="text" placeholder="Titulo Descripción" value="" class="form-control border-start-0" style="height: 164px;" name="titulo_descripcion" id="titulo_descripcion" required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <textarea type="text" placeholder="Descripción Programa" value="" class="form-control border-start-0" style="height: 164px;" name="descripcion_programa" id="descripcion_programa" required></textarea>
                                                <!-- <label>Descripción Programa</label> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="url_video" id="url_video" required>
                                            <label>Url Video</label>
                                        </div>
                                    </div>

                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                        <div class="mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="categoria_programas" id="categoria_programas">
                                                    <label>Programa</label>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <br>
                                        <span class="text-info">Escritorio debe ser de 428x306</span>
                                        <label for="agregar_imagen_descripcion" style="cursor: pointer">
                                            <img src="../public/img/escritorio.svg" width="90px" height="110px" alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto Escritorio">
                                        </label>
                                        <input id="agregar_imagen_descripcion" name="agregar_imagen_descripcion" type="file" style="display: none" />
                                    </div>

                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <input type="number" class="d-none id_web_programa_descripcion" id="id_web_programa_descripcion" name="id_web_programa_descripcion">
                                    <input type="text" class="d-none" name="guardar_img_programas" id="guardar_img_programas">
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
            <div class="modal fade" id="Modaldesempenate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Campo profesional</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formulariodesempenate" id="formulariodesempenate" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                        <input type="number" class="d-none id_programa" id="id_programa" name="id_programa">
                                        <input type="number" class="d-none id_desempenate_descripcion" id="id_desempenate_descripcion" name="id_desempenate_descripcion">
                                    </div>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12" id="desempenatemostrar"></div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="ModalVerVideoProgramaDescripcion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ver video Programas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formulariovervideo" id="formulariovervideo" method="POST" enctype="multipart/form-data">

                                <div class="row">

                                    <div id="mostar_video_modal_descripcion"></div>
                                </div>
                            </form>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                </div>
            </div>
            <div class="modal fade" id="Modaldesempenateeditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Prorgama Desempeñate</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioeditardesem" id="formularioeditardesem" method="POST" enctype="multipart/form-data">

                                <div class="col-12">

                                    <div class="form-group col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <textarea type="text" placeholder="Nombre desempeñate" value="" class="form-control border-start-0" style="height: 164px;" name="nombre_desempenate_editar" id="Programa Desempeñate" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <textarea type="text" placeholder="" value="" class="form-control border-start-0" style="height: 164px;" name="nombre_desempenate_editar" id="nombre_desempenate_editar" required></textarea>
                                            <label>Programa Desempeñate</label>
                                        </div>
                                    </div> -->

                                </div>
                                <div class="col-12">
                                    <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <input type="number" class="d-none id_programa_editar" id="id_programa_editar" name="id_programa_editar">
                                    <input type="number" class="d-none id_desempenate_descripcion_editar" id="id_desempenate_descripcion_editar" name="id_desempenate_descripcion_editar">

                                </div>

                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                </div>
            </div>

        </div>

    <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>

    <script type="text/javascript" src="scripts/web_programa_descripcion.js"></script>

<?php
}
ob_end_flush();
?>