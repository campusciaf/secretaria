<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 33;
    $submenu = 3311;
    require 'header.php';

    if ($_SESSION['webblog'] == 1) {
?>


        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Administrador Blog</span><br>
                                <span class="fs-16 f-montserrat-regular">Administra las contenidos de su interés.</span>
                            </h2>
                        </div>
                        <div class="col-6 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Administrador Blog</li>
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
                                                    <span class="text-semibold fs-20">Administrador Blog</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 text-right py-4 pr-4 tono-3">
                                        <button class="btn btn-success pull-right" id="tour_agregar_noticia_video" onclick="mostraragregarvideo(true)"><i class="fa fa-plus-circle"></i> Agregar Blog con Video</button>
                                        <button class="btn btn-success pull-right" id="tour_agregar_noticia_imagen" onclick="mostraragregarimagen(true)"><i class="fa fa-plus-circle"></i> Agregar Blog con Imagen</button>
                                    </div>

                                    <div class="col-12">
                                        <div class="panel-body table-responsive p-4">
                                            <table id="tbllistanoticias" class="table" style="width:100%">
                                                <thead class="text-center">
                                                    <th id="tour_opciones">Opciones</th>
                                                    <th id="tour_imagen">Imagen</th>
                                                    <th id="tour_video">Video</th>
                                                    <th id="tour_titulo">Título</th>
                                                    <th id="tour_subtitulo">Subtítulo</th>
                                                    <th id="tour_contenido">Contenido</th>
                                                    <th id="tour_formato_noticia">Formato Noticia</th>
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
            <div class="modal fade" id="ModalEditarNoticias" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Noticia</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioeditarnoticias" id="formularioeditarnoticias" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="titulo_blog" id="titulo_blog" maxlength="100" required>
                                                <label>Título</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="subtitulo_blog" id="subtitulo_blog" maxlength="100" required>
                                                <label>Subtítulo</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <!-- <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="categoria_blog" id="categoria_blog">
                                                    <label>Categoría</label>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div> -->
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="link_noticia_imagen_editar" id="link_noticia_imagen_editar" maxlength="100" required>
                                                <label>Link amigable</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="form-group col-lg-12">

                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <textarea type="text" placeholder="" value="" class="form-control border-start-0" style="height: 164px;" name="contenido_blog_editar" id="contenido_blog_editar" required></textarea>
                                            </div>
                                        </div>
                                        <div id="videoeimagen"></div>
                                    </div>
                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <input type="number" class="d-none id_blog" id="id_blog" name="id_blog">
                                    <input type="text" class="d-none" name="imageneditarguardar" id="imageneditarguardar">
                                    <input type="number" class="d-none" name="material_estado" id="material_estado">
                                    <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
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
            <div class="modal fade" id="ModalVideo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Agregar BLOG con video</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formulariovideo" id="formulariovideo" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" class="form-control border-start-0" name="titulo_blog_video" id="titulo_blog_video" required>
                                                <label>Título</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" class="form-control border-start-0" name="subtitulo_blog_video" id="subtitulo_blog_video" required>
                                                <label>Subtítulo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                        <div class="mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="categoria_blog_video" id="categoria_blog_video">
                                                    <label>Categoría</label>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div> -->
                                    <div class="form-group col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" class="form-control border-start-0" maxlength="100" name="url_video" id="url_video" required>
                                                <label>Iframe Video</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <textarea type="text" placeholder="" value="" class="form-control border-start-0" style="height: 164px;" name="contenido_blog_video" id="contenido_blog_video" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" class="form-control border-start-0" maxlength="100" name="link_noticia_video" id="link_noticia_video" required>
                                                <label>link amigable noticia</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <br>
                                        <label for="agregar_imagen_con_video" style="cursor: pointer">
                                            <img src="../public/img/escritorio.svg" width="90px" height="110px" alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto mobile">
                                        </label>
                                        <input id="agregar_imagen_con_video" name="agregar_imagen_con_video" type="file" style="display: none" />
                                    </div>
                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <input type="number" class="d-none id_blog_video" id="id_blog_video" name="id_blog_video">
                                    <input type="text" class="d-none" name="editarvideoguardar" id="editarvideoguardar">
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
            <div class="modal fade" id="ModalVerVideo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ver video Noticias</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formulariovervideo" id="formulariovervideo" method="POST" enctype="multipart/form-data">

                                <div class="row">

                                    <div id="mostar_video_modal"></div>
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
            <div class="modal fade" id="ModalImagen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Agregar blog con imagen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioagregarimagen" id="formularioagregarimagen" method="POST" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" class="form-control border-start-0" name="titulo_blog_imagen" id="titulo_blog_imagen" required>
                                                <label>Título</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">                                
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="subtitulo_blog_imagen" id="subtitulo_blog_imagen" required>
                                            <label>Subtítulo</label>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-12">

                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <textarea type="text" placeholder="" value="" class="form-control border-start-0" style="height: 164px;" name="contenido_blog_imagen" id="contenido_blog_imagen" ></textarea>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="form-group col-12">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" class="form-control border-start-0" name="link_noticia_imagen" id="link_noticia_imagen" required>
                                                <label>Link Noticia Amigable</label>
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
                                    <input type="number" class="d-none id_blog" id="id_blog" name="id_blog">
                                    <input type="text" class="d-none" name="editarguardarimg" id="editarguardarimg">
                                    <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
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

    <script type="text/javascript" src="scripts/web_blog.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>