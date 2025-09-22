<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 10;
    $submenu = 1010;
    require 'header.php';
    if ($_SESSION['consultaprogramayrenovar'] == 1) {
?>
        <style>
            .dropdown-item {
                color: black !important;
            }
        </style>
        <div id="precarga" class="precarga" style="display: none;"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Grupos por programa | Por renovar</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active"># Programa | Por renovar</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="alert col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <select class="form-control" id="programa" name="programa" data-live-search="true" data-style="border">
                                        <option selected>Programa...</option>
                                    </select>
                                    <div class="input-group-append">
                                        <input type="button" onclick="consulta()" value="Consultar" class="btn btn-success" />
                                    </div>
                                </div>
                            </div>
                            <div class="col" style="padding: 1em;">
                                <table class="table table-hover table-nowarp" id="tdl_consulta">
                                    <thead>
                                        <tr>
                                            <th scope="col">Semestre</th>
                                            <th scope="col">Diurna</th>
                                            <th scope="col">Nocturna</th>
                                            <th scope="col">Sábados</th>
                                            <th scope="col">Fin de semana</th>
                                        </tr>
                                    </thead>
                                    <tbody id="imprime">
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section>
        </div><!-- /.content-wrapper -->

        <!-- Modal listar estudiantes -->
        <div id="listarEs" class="modal fade" data-backdrop='static' data-keyboard='false' role="dialog">
            <div class="modal-dialog modal-lg" style="width: 95%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-hover table-nowarp" id="tdl_mostrar" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th scope="col">Identificación</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Celular</th>
                                            <th scope="col">Correo CIAF</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-danger">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal listar estudiantes -->
        <div id="listarPorRenovar" class="modal fade" data-backdrop='static' data-keyboard='false' role="dialog">
            <div class="modal-dialog modal-lg" style="width: 95%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-hover" id="tblrenovar">
                                    <thead>
                                        <tr>
                                            <th scope="col">Identificación</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Celular</th>
                                            <th scope="col">Correo CIAF</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-danger">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/consultaprogramayrenovar.js"></script>