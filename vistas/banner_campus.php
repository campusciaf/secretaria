<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu=1;
    $submenu=124;
    require 'header.php';

    if ($_SESSION['banner_campus'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <!--Contenido-->
        <!-- Content Wrapper. Contains page content -->
        <!--Contenido-->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">

                        <div id="boton_agregar_banner"></div>
                       
                            
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Administrador Banner</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>



            <div class="modal fade" id="ModalEditarNoticias" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Banner Campus</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioeditarbannercampus" id="formularioeditarbannercampus" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group">

                                <span class="text-info">El tamaño de la imagen debe ser<b> 841x915 </b> y la extensión debe ser <b>.webp </b></span> 
                                    <br>
                                    <br>


                                    <label for="agregar_imagen_editar" style="cursor: pointer">
                                        <img src="../public/img/ingenieria-de-software.webp" width="480px" height="210px" alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto mobile">
                                    </label>
                                    <input id="agregar_imagen_editar" name="agregar_imagen_editar" type="file" style="display: none" />
                                </div>                               
                            </div>
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                            <input type="number" class="d-none id_banner_editar" id="id_banner_editar" name="id_banner_editar">
                            <input type="text" class="d-none" name="agregar_editar_imagen_editar" id="agregar_editar_imagen_editar">
                        
                                <button type="submit" class="btn btn-primary mt-4"> <i class="fa fa-save"></i> Guardar </button>
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
            <!-- Agregar imagen banner campus -->
            <div class="modal fade" id="ModalImagen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Agregar Imagen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioagregarimagen" id="formularioagregarimagen" method="POST" enctype="multipart/form-data">

                            <div class="row">
                                
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <br>
                                    <label for="agregar_imagen" style="cursor: pointer">
                                        <img src="../public/img/ingenieria-de-software.webp" width="470px" height="210px" alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto mobile">
                                    </label>
                                    <input id="agregar_imagen" name="agregar_imagen" type="file" style="display: none" />
                            </div>                                                
                        </div>
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                            <input type="number" class="d-none id_banner" id="id_banner" name="id_banner">
                            <input type="text" class="d-none" name="editarguardarimg" id="editarguardarimg">
                                <button type="submit" class="btn btn-primary mt-4"> <i class="fa fa-save"></i> Guardar </button>
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

            <!-- Mostrar imagen del banner -->
            <section class="content" style="padding-top: 0px;" >
                <div class="row card card-primary" style="padding: 2% 1%" >
                    
                    <div class="col-12">
                        <div>
                            <div class="col-lg-12 table-responsive">
                                <table id="tbllistaimagenen" class="table compact table-striped table-condensed table-hover">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Archivo</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>


        </div>

    <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>

    <script type="text/javascript" src="scripts/banner_campus.js"></script>

<?php
}
ob_end_flush();
?>