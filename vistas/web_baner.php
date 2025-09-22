<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu=33;
    $submenu=3301;
    require 'header.php';

    if ($_SESSION['webbaner'] == 1) {
?>


    <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Administrador Banner</span><br>
                                <span class="fs-16 f-montserrat-regular">Administra el banner de la pagina web.</span>
                            </h2>
                        </div>
                        <div class="col-6 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Administrador Banner</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
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
                                                    <span class="text-semibold fs-20">Administrador Banner</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 text-right py-4 pr-4 tono-3" >
                                        <button class="btn btn-success pull-right" id="tour_btnagregar" onclick="mostraragregarbanner(true)"><i class="fa fa-plus-circle"></i> Agregar Banner</button>
                                    </div>

                                    <div class="col-12">
                                        <div class="panel-body table-responsive p-4">
                                            <table id="tbllistabanner" class="table" style="width:100%">
                                                <thead class="text-center">
                                                    <th id="tour_opciones">Opciones</th>
                                                    <th id="tour_titulo">Titulo</th>
                                                    <th id="subtitulo">Subtitulo</th>
                                                    <th id="descripcion">Descripción</th>
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

            <div class="modal fade" id="ModalBanner" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Banner</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formulariobanner" id="formulariobanner" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="titulo" id="titulo" required>
                                            <label>Título</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="subtitulo" id="subtitulo" required>
                                            <label>Subtítulo</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="descripcion" id="descripcion" required>
                                            <label>Descripción</label>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="ruta_url" id="ruta_url" required>
                                            <label>Url</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for='imagen_escritorio_2' style="cursor: pointer" >
                                    <img id='img_foto_hoja_vida' src='../public/img/escritorio.svg' width='90px' height='110px' alt='Click aquí para subir tu foto' title='Click aquí para subir tu foto escritorio' >
                                    </label>
                                    <input id='imagen_escritorio_2' name='imagen_escritorio_2' type='file' style="display: none" />
                                    <input type="hidden" name="imagenmuestra_escritorio_2" id="imagenmuestra_escritorio_2">
                                    <img src="" width="150px" height="120px" id="imagenactual_escritorio">
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for='imagen_celuar' style="cursor: pointer">
                                        <img id='img_foto_hoja_vida' src='../public/img/movil.svg' width='90px' height='110px' alt='Click aquí para subir tu foto' title='Click aquí para subir tu foto mobile'>
                                    </label>
                                    <input id='imagen_celuar' name='imagen_celuar' type='file' style="display: none" />
                                    <input type="hidden" name="imagenmuestra_celular" id="imagenmuestra_celular">
                                    <img src="" width="150px" height="120px" id="imagenmuestra_celular2">
                                </div>
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <input type="number" class="d-none id_banner" id="id_banner" name="id_banner">
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

    <script type="text/javascript" src="scripts/web_baner.js"></script>

<?php
}
ob_end_flush();
?>