<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 4;
    $submenu = 402;
    require 'header.php';
    if ($_SESSION['adminbiblioteca'] == 1) {
?>
        <link rel="stylesheet" type="text/css" href="../public/css/biblioteca.css">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><small id="nombre_programa"></small>Biblioteca </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Biblioteca CIAF</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="fondo_stamp col-xs-12 col-sm-12 col-md-12 col-lg-12 row" style="margin-top: -20px;">
                                <!-- Botones -->
                                <div class="col-12">
                                    <div class="row" style="text-align: right">
                                        <a class="btn btn-primary col p-3" href="biblioteca.php" style="text-decoration: none;">
                                            <i class="fas fa-eye"></i> Biblioteca
                                        </a>
                                        <a href="https://elibro.net/es/lc/ciaf/" target="_blank" class="btn btn-warning col p-3 d-none">
                                            <img src="../public/img/e-libro.png" width="20px"> E-LIBRO
                                        </a>
                                        <a href="software_libre.php" class="btn btn-success col p-3">
                                            <i class="fas fa-desktop"></i> Software Libre
                                        </a>
                                        <a href="bases_datos_gratuitas.php" class="btn btn-danger col p-3">
                                            <i class="fas fa-database"></i> Bases de Datos
                                        </a>
                                    </div>
                                    <br>
                                </div>
                                <div class="alert col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="text-center">
                                        <h1 style="font-size:40px; color:#fff"><strong>LLEVA TODA TU BIBLIOTECA </strong></h1>
                                        <h2 style="color:#fff">EN UN SOLO BOLSILLO</h2>
                                    </div>
                                </div>
                                <div class="alert col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <form action="#" class="col-xs-12 col-sm-12 col-md-12 col-lg-6 offset-lg-3" method="post" id="busqueda_libro">
                                        <div class="input-group mb-3 ">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> <i class="fas fa-book-open"></i></span>
                                            </div>
                                            <input type="text" id="busquedad" name="busquedad" required="required" pattern="[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Solo se permiten letras y números, estos caracteres no son permitidos < > = , ; * # $" placeholder="Titulo, Autor, Palabra clave o ISBN" class="form-control">
                                            <div class="input-group-append">
                                                <button class=" btn btn-primary" id="comenzar_busqueda">Buscar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-success" id="btnAbrirModalLibro"><i class="fas fa-book"> Agregar Libro</i></button>
                    </div>
                    <div id="demo" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="contenido_libre row">
                        </div>
                    </div>
                </div>
            </section>
        </div><!-- /.content-wrapper -->
        <!--Modal-->
        <div class="modal fade" id="modalBiblioteca" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Información del libro</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="#" id="form">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-6 d-none">
                                    <label for="exampleInputEmail1">ID Libro</label>
                                    <input type="text" class="form-control" id="id_libro" name="id_libro">
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1">Imagen</label>
                                    <input type="file" class="form-control-file" id="file_url" name="file_url">
                                    <div id="imagen_editar">
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1">Titulo</label>
                                    <input type="text" class="form-control" id="txtTitulo" name="txtTitulo">
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1">Fecha de Lanzamiento</label>
                                    <input type="date" class="form-control" id="txtFechaLanz" name="txtFechaLanz">
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1">Autor</label>
                                    <input type="text" class="form-control" id="txtAutor" name="txtAutor">
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1">Categoria</label>
                                    <input type="text" class="form-control" id="txtCategoria" name="txtCategoria">
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1">Programa</label>
                                    <input type="text" class="form-control" id="txtPrograma" name="txtPrograma">
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1">Editorial</label>
                                    <input type="text" class="form-control" id="txtEditorial" name="txtEditorial">
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1">ISBN</label>
                                    <input type="text" class="form-control" id="txtISBN" name="txtISBN">
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1">Idioma</label>
                                    <input type="text" class="form-control" id="txtIdioma" name="txtIdioma">
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1">Paginas</label>
                                    <input type="number" class="form-control" id="paginas" name="paginas">
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1">Formato</label>
                                    <input type="text" class="form-control" id="txtFormato" name="txtFormato">
                                </div>
                                <div class="form-group col-12">
                                    <label for="exampleInputEmail1">Descripción</label>
                                    <textarea type="text" class="form-control" rows="3" id="txtDesc" name="txtDesc">
                            </textarea>
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1">Palabra Clave</label>
                                    <input type="text" class="form-control" id="txtPalClav" name="txtPalClav">
                                </div>
                                <div class="form-group col-6">
                                    <label for="exampleInputEmail1">Ejemplares</label>
                                    <input type="number" class="form-control" id="ejemplares" name="ejemplares">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-success btn-block" id="botonAgregar">Guardar</button>
                            <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

            .barra-libros {
                background-color: #000;
                overflow: hidden;
                border-radius: 0px;
                border-top: 8px solid #000;
                padding: 0px;
                margin: 0px;
                height: 135px;
            }
        </style>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script src="scripts/biblioteca.js"></script>