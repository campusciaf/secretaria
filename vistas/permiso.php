<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $submenu = 2;
    $menu = 1;
    require 'header.php';
    if ($_SESSION['permiso'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión Permisos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12" id="listadoregistros">
                <div id="tbllistado"></div>
                <div id="tllistado"></div>
                <div id="mostrar_agregar_permiso"></div>
                <div id="editar_permiso"></div>
            </div>
            <div class="modal" id="myModalActivarDesactivarPermiso">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <h6 class="modal-title">Activar y desactivar permiso.
                            </h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <!-- <div id="mostrar_agregar_permiso_2"></div> -->
                            <div class="col-12 table-responsive p-4" id="ocultar_tabla">
                                <table id="mostrar_funcionarios_permisos" class="table" style="width: 100%;">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Documento</th>
                                        <th>Nombre</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="myModalAgregarMenuFuncionario">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <h6 class="modal-title">Activar y desactivar Mneu permiso.
                            </h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 table-responsive p-4">
                                <table id="mostrar_menu_funcionarios_permisos" class="table" style="width: 100%;">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Documento</th>
                                        <th>Nombre</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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
    <script type="text/javascript" src="scripts/permiso.js"></script>
<?php
}
ob_end_flush();
?>