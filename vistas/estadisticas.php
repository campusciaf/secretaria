<?php
//INSERT INTO `permiso` (`id_permiso`, `permiso_nombre`, `orden`, `menu`, `permiso_nombre_original`) VALUES (NULL, 'estadisticas', '9.12', '9', 'Estadísticas');
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 13;
    $submenu = 1311;
    require 'header.php';

    if ($_SESSION['estadisticas'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <!--Contenido-->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><small id="nombre_programa"></small>Estadísticas</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión estadística</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="box-header with-border">
                                <form class="row" method="POST" action="#" id="formularioBusqueda">
                                    <div class="col-6">
                                        <select class="form-control" name="categoria" id="categoria" required>
                                            <option value="" disabled selected> -- selecciona una categoria -- </option>
                                        </select>
                                    </div>
                                    <div class="input-group col-6">
                                        <select class="form-control" name="periodo" id="periodo" required>
                                            <option value="" disabled selected> -- selecciona un periodo -- </option>
                                        </select>
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-info btn-flat">Listar!</button>
                                        </span>
                                    </div>
                                </form>
                                <div class="col-12">
                                    <table id="tbllistado" class="table table-hover" >
                                        <thead>
                                            <th>Edades</th>
                                            <th>cantidad</th>
                                        </thead>
                                        <tbody>
                                            <td colspan="2">
                                                <div class="jumbotron text-center">
                                                    <h3>Aquí se listarán los datos.</h3>
                                                </div>
                                            </td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </section>
        </div>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script src="scripts/estadisticas.js"></script>