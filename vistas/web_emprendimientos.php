<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 33;
    $submenu = 3309;
    require 'header.php';

    if ($_SESSION['web_emprendimientos'] == 1) {
?>


        <!-- <div id="precarga" class="precarga"></div> -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Administrador Emprendimientos</span><br>
                                <span class="fs-16 f-montserrat-regular">Administra los emprendimientos de la pagina web.</span>
                            </h2>
                        </div>
                        <div class="col-6 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Administrador Emprendimientos</li>
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
                                                    <span class="text-semibold fs-20">Administrador Emprendimientos</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 text-right py-4 pr-4 tono-3">
                                        <button class="btn btn-success pull-right" id="btnagregar" onclick="mostraragregar(true)"><i class="fa fa-plus-circle"></i> Agregar Emprendimiento</button>
                                    </div>
                                    <div class="col-12">
                                        <div class="panel-body table-responsive p-4">
                                            <table id="tbllistadoemprendimiento" style="width:100%">
                                                <thead class="text-center">
                                                    <th>Opciones</th>
                                                    <th>Logo</th>
                                                    <th>Emprendimiento</th>
                                                    <th>Descripción</th>
                                                    <th>WhatsApp</th>
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
            <div class="modal fade" id="ModalAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Vitrina de emprendimientos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioagregar" id="formularioagregar" method="POST" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_emprendimiento" id="nombre_emprendimiento" required>
                                            <label>Nombre del emprendimiento</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_emprendedor" id="nombre_emprendedor" required>
                                            <label>Nombre del emprendedor</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-floating">
                                            <textarea type="text" placeholder="Descripción el emprendimiento" value="" class="form-control border-start-0" style="height: 164px;" name="descripcion_emprendimiento" id="descripcion_emprendimiento" required></textarea>
                                            <!-- <label>Descripción Programa</label> -->
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-floating">
                                            <input type="number" placeholder="" value="" maxlength="10" class="form-control border-start-0" name="telefono_contacto" id="telefono_contacto" required>
                                            <label>Número de whastapp</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label>Imagen del emprendimiento</label><br>
                                        <label for="agregar_imagen" style="cursor: pointer">
                                            <img src="../public/img/escritorio.svg" width="90px" height="110px" alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto">
                                        </label>
                                        <input id="agregar_imagen" name="agregar_imagen" type="file" style="display: none" />
                                    </div>
                                </div>

                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <input type="number" class="d-none id_web_emprendimientos" id="id_web_emprendimientos" name="id_web_emprendimientos">
                                    <input type="text" class="d-none" name="editarguardarimg" id="editarguardarimg">
                                    <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar emprendimiento</button>
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

            <div class="modal fade" id="ModalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar emprendimiento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioagregareditar" id="formularioagregareditar" method="POST" enctype="multipart/form-data">

                                <div class="row">
                                    

                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_emprendimiento_editar" id="nombre_emprendimiento_editar" required>
                                            <label>Nombre del emprendimiento</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_emprendedor_editar" id="nombre_emprendedor_editar" required>
                                            <label>Nombre del emprendedor</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-floating">
                                            <textarea type="text" placeholder="Descripción el emprendimiento" value="" class="form-control border-start-0" style="height: 164px;" name="descripcion_emprendimiento_editar" id="descripcion_emprendimiento_editar" required></textarea>
                                            <!-- <label>Descripción Programa</label> -->
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-floating">
                                            <input type="number" placeholder="" value="" maxlength="10" class="form-control border-start-0" name="telefono_contacto_editar" id="telefono_contacto_editar" required>
                                            <label>Número de whastapp</label>
                                        </div>
                                    </div>  
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <br>
                                        <label for="agregar_imagen_editar" style="cursor: pointer">
                                            <img src="../public/img/escritorio.svg" width="90px" height="110px" alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto">
                                        </label>
                                        <input id="agregar_imagen_editar" name="agregar_imagen_editar" type="file" style="display: none" />

                                    </div>
                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <input type="number" class="d-none id_web_emprendimientos_editar" id="id_web_emprendimientos_editar" name="id_web_emprendimientos_editar">
                                    <input type="text" class="d-none" name="editarguardarimg_editar" id="editarguardarimg_editar">
                                    <button class="btn btn-success btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar emprendimiento</button>
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

    <script type="text/javascript" src="scripts/web_emprendimientos.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>


<?php
}
ob_end_flush();
?>