<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 33;
    $submenu = 3305;
    require 'header.php';

    if ($_SESSION['webprogramas'] == 1) {
?>


        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Administrador Programa</span><br>
                                <span class="fs-16 f-montserrat-regular">Administra los programas de la pagina web.</span>
                            </h2>
                        </div>
                        <div class="col-6 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Administrador Programa</li>
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
                                        <button class="btn btn-success pull-right" id="tour_mostrar_agregar_programas" onclick="mostraragregarprogramas(true)"><i class="fa fa-plus-circle"></i> Agregar Programa</button>
                                    </div>
                                    <div class="col-12">
                                        <div class="panel-body table-responsive p-4">
                                            <table id="tbllistaprogramas" class="table" style="width:100%">
                                                <thead class="text-center">
                                                    <th id="tour_opciones">Opciones</th>
                                                    <th id="tour_imagen_escritorio">Imagen Escritorio</th>
                                                    <th id="tour_imagen_celular">Imagen Celular</th>
                                                    <th id="tour_nombre_programa">Nombre Programa</th>
                                                    <th id="tour_snies">Snies</th>
                                                    <th id="tour_frase_del_programa">Frase del Programa</th>
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
            <div class="modal fade" id="ModalEditarProgramas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Programa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioeditarprogramas" id="formularioeditarprogramas" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="nombre_programa_editar" id="nombre_programa_editar" maxlength="100" required>
                                                <label>Nombre Programa</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="snies_editar" id="snies_editar" maxlength="100" required>
                                                <label>Snies</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="frase_programa_editar" id="frase_programa_editar" maxlength="100" required>
                                                <label>Frase del Programa</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <br>
                                        <span class="text-info">Escritorio debe ser de 1728x724</span>
                                        <label for="agregar_imagen_programa_editar" style="cursor: pointer">
                                            <img src="../public/img/escritorio.svg" width="90px" height="110px" alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto">
                                        </label>
                                        <input id="agregar_imagen_programa_editar" name="agregar_imagen_programa_editar" type="file" style="display: none" require>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <br>
                                        <span class="text-info">Móvil debe ser de 428x400</span>
                                        <label for='imagen_celuar_programa_editar' style="cursor: pointer">
                                            <img class="mt-2" id='img_foto_hoja_vida' src='../public/img/movil.svg' width='90px' height='110px' alt='Click aquí para subir tu foto' title='Click aquí para subir tu foto móvil'>
                                        </label>
                                        <input id='imagen_celuar_programa_editar' name='imagen_celuar_programa_editar' type='file' style="display: none" require>
                                    </div>
                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <input type="number" class="d-none id_programas" id="id_programas" name="id_programas">
                                    <input type="text" class="d-none" name="guardar_img_programas_editar" id="guardar_img_programas_editar">
                                    <input type="text" class="d-none" name="guardar_imagen_celuar_programa_editar" id="guardar_imagen_celuar_programa_editar">

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
                            <h5 class="modal-title" id="exampleModalLabel">Agregar Programa </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioprograma" id="formularioprograma" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="nombre_programa" id="nombre_programa" maxlength="100" required>
                                                <label>Nombre Programa</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="snies" id="snies" maxlength="100" required>
                                                <label>Snies</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="frase_programa" id="frase_programa" maxlength="100" required>
                                                <label>Frase del Programa</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <br>
                                        <span class="text-info">Escritorio debe ser de 1728x724</span>
                                        <label for="agregar_imagen_programa" style="cursor: pointer">
                                            <img src="../public/img/escritorio.svg" width="90px" height="110px" alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto Escritorio">
                                        </label>
                                        <input id="agregar_imagen_programa" name="agregar_imagen_programa" type="file" style="display: none" />
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <br>
                                        <span class="text-info">Móvil debe ser de 428x400</span>
                                        <label for='imagen_celuar_programa' style="cursor: pointer">
                                            <img class="mt-2" id='img_foto_hoja_vida' src='../public/img/movil.svg' width='90px' height='110px' alt='Click aquí para subir tu foto' title='Click aquí para subir tu foto móvil'>
                                        </label>
                                        <input id='imagen_celuar_programa' name='imagen_celuar_programa' type='file' style="display: none" />
                                    </div>
                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <input type="number" class="d-none id_programas" id="id_programas" name="id_programas">
                                    <input type="text" class="d-none" name="guardar_img_programas" id="guardar_img_programas">
                                    <input type="text" class="d-none" name="guardar_img_programas_celular" id="guardar_img_programas_celular">
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

    <script type="text/javascript" src="scripts/web_programas.js"></script>

<?php
}
ob_end_flush();
?>