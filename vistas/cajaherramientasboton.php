<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 4;
    $submenu = 405;
    require 'header.php';

    if ($_SESSION['adminbtncajaherramientas'] == 1) {
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
                            <span class="titulo-4">Administrador Caja de Herramientas</span> 
                            
                        </h1>
                            
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Administrador Caja de Herramientas</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>


            <section class="content" style="padding-top: 0px;" >
                <div class="row card card-primary" style="padding: 2% 1%" >
                    
                    <div class="col-12">
                        <div>
                            <div class="col-lg-12 table-responsive">
                                <table id="tbllistadocentes" class="table compact table-striped table-condensed table-hover">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Nombre Docente</th>
                                        <th>Permiso Docente</th>
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


            <div class="modal fade" id="ModalDocente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modificar Permiso</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formulariodocente" id="formulariodocente" method="POST" enctype="multipart/form-data">


                                <div><label for="permiso_software">Permiso </label>
                                    <select class="form-control" id="permiso_software" name="permiso_software">
                                        <option value="" selected disabled>Selecciona una opción</option>
                                        <option value="1">No</option>
                                        <option value="0">Si</option>
                                    
                                    </select><br>
                                </div>
                    
                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                    <input type="number" class="d-none id_usuario" id="id_usuario" name="id_usuario">
                                    <button type="submit" class="btn btn-primary mt-4" id="btnGuardarDocente"> <i class="fa fa-save"></i> Guardar </button>
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
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>

    <script type="text/javascript" src="scripts/cajaherramientasboton.js"></script>

<?php
}
ob_end_flush();
?>