<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 4;
    $submenu = 406;
    require 'header.php';

    if ($_SESSION['adminbtncajaherramientascategoria'] == 1) {
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
                        <h1 class="m-0">
                            <span class="titulo-4">Administrador Categorías</span> 
                            
                        </h1>
                            
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Administrador Categorías</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>

           

             <!-- Modal Crear Proyecto -->
             <div class="modal fade" id="ModalCrearCategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Crear Categoría</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formulariocategoria" id="formulariocategoria" method="POST">
                                <div class="form-group">
                                    <label for="exampleInputtext">Nombre Categoría</label>
                                    <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" placeholder="Nombre Categoría">
                                </div>

                                <input type="number" class="d-none" id="id_software_categoria" name="id_software_categoria">
                                <button type="submit" class="btn btn-primary" id="btnGuardarCategoria"><i class="fa fa-save"></i> Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <section class="content" style="padding-top: 0px;" >
                <div class="row card card-primary" style="padding: 2% 1%" >
                <div class="col-12">
                <button class="btn btn-primary btn-flat btn-sm" data-toggle="modal" data-target="#ModalCrearCategoria"> Agregar Categoría</button>
                <br><br>
            </div>
                    <div class="col-12">
                        <div>
                            <div class="col-lg-12 table-responsive">
                                <table id="tbllistacategorias" class="table compact table-striped table-condensed table-hover">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Nombre Categoría</th>
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
            </div>  -->

    <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>

    <script type="text/javascript" src="scripts/cajaherramientascategoria.js"></script>

<?php
}
ob_end_flush();
?>