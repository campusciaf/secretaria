<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.html");
} else {
    $menu = 3;
    require 'header_docente.php';
?>
    <link rel="stylesheet" type="text/css" href="../public/css/biblioteca.css">

    <!--Contenido-->
    <div class="content-wrapper">
        <section class="content">
            <div class="row">

                <div class="contenido">

                    <div>
                        <h2 class="titulo-5">Herramientas Creativas</h2>
                    </div>

                    <!-- Botones -->

                    <style>
                        a:hover {
                            text-decoration: none;
                        }

                        a:link {
                            text-decoration: none;
                        }

                        a:visited {
                            text-decoration: none;
                        }

                        a:active {
                            text-decoration: none;
                        }
                    </style>
                    <div class="card col-xl-12 m-2 p-2">
                        <div class="btn-group btn-group-toggle  m-2 p-2" data-toggle="buttons">

                            <!-- <label class="btn bg-olive active">
						<input type="radio" name="options" id="mostrar_categorias" autocomplete="off" checked=""> 
					</label>  -->

                            <div class="btn-group btn-group-toggle" data-toggle="buttons" id="mostrar_categorias"></div>



                            <!-- <label class="btn bg-olive">
						<input type="radio" name="options" autocomplete="off"> <span id="mostrar_categorias"></span>
					</label> -->

                            <!-- <label class="btn bg-olive">
						<input type="radio" name="options" id="option_b2" autocomplete="off"> <span id="filtro_1">Almacenamiento en la nube</span>
					</label>
					<label class="btn bg-olive">
						<input type="radio" name="options" id="option_b3" autocomplete="off"> <span id="filtro_2">Bancos de imágenes</span>
					</label>
					<label class="btn bg-olive">
						<input type="radio" name="options" id="option_b3" autocomplete="off"> <span id="filtro_3">Edición de imagenes</span>
					</label>
					<label class="btn bg-olive">
						<input type="radio" name="options" id="option_b3" autocomplete="off"> <span id="filtro_4">Edición de audio y video</span>
					</label>
					<label class="btn bg-olive">
						<input type="radio" name="options" id="option_b3" autocomplete="off"> <span id="filtro_5">Programación</span>
					</label>
					<label class="btn bg-olive">
						<input type="radio" name="options" id="option_b3" autocomplete="off"> <span id="filtro_6">Envio de archivos</span>
					</label> -->
                        </div>


                        <!-- <div class="card col-xl-12 m-2 p-2">

                        <button class="btn btn-primary btn-sm float-right" onclick="mostrar_software()" title="Agregar"><i class="fa fa-plus"></i></button>
                    </div> -->



                        <div class="row"></div>
                        <div class="row contenido_libre">

                        </div>

                    </div>
        </section>
    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->


    <div class="modal fade" id="modalAdminBibliotecaDocente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Administrador Caja Herramientas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form name="formulariosoftware" id="formulariosoftware" method="POST" enctype="multipart/form-data">

                        <div class="row">

                            <div class="form-group col-6">
                                <label for="exampleInputEmail1">Ruta imagen</label>
                                <input type="file" class="form-control-file" id="file_url" name="file_url" required>
                                <div id="imagen_editar">
                                </div>
                            </div>

                            <div class="form-group col-6">
                                <label for="exampleInputEmail1">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                            <div class="form-group col-6">
                                <label for="exampleInputEmail1">Sitio</label>
                                <input type="text" class="form-control" id="sitio" name="sitio">
                            </div>
                            <div class="form-group col-6">
                                <label for="exampleInputEmail1">Url</label>
                                <input type="text" class="form-control" id="url" name="url">
                            </div>

                            <div class="form-group col-6">
                                <label for="exampleInputEmail1">Descripción</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion">
                            </div>
                            <div class="form-group col-6">
                                <label for="exampleInputEmail1">Valor</label>
                                <input type="text" class="form-control" id="valor" name="valor">
                            </div>

                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <label>Categoria:</label>
                                <div class="input-group mb-3">

                                    <select id="categoria_software" name="categoria_software" class="form-control selectpicker" data-live-search="true" data-style="border" required></select>


                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group col-6">
                                <label for="exampleInputEmail1">Categoria</label>
                                <select class="form-control" id="categoria_herramienta" name="categoria">
                                        <option value="" selected disabled>Selecciona una opción</option>
                                        <option value="Almacenamiento">Almacenamiento en la nube</option>
                                        <option value="Banco de Imágenes">Banco de Imágenes</option>
                                        <option value="Edición de Imágenes">Edición de Imágenes</option>
                                        <option value="Edición de audio y video">Edición de audio y video</option>
                                        <option value="Programación">Programación</option>
                                        <option value="Envio de archivos">Envio de archivos</option>
                                    
                                    </select><br>
                            </div> -->

                </div>
                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                    <input type="number" class="d-none id_software" id="id_software" name="id_software">
                    <button type="submit" class="btn btn-primary mt-4" id="botonAgregarHerramienta"> <i class="fa fa-save"></i> Guardar </button>
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

    <?php
    require 'footer_docente.php';
    ?>

    <script src="scripts/softwarelibre.js"></script>
    <!-- Page specific script -->

<?php
}
ob_end_flush();
?>