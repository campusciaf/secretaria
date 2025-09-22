<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 27;
    $submenu = 2702;
    require 'header.php';
    if ($_SESSION['guiamiscasos'] == 1) {

?>
        <div id="precarga" class="precarga" style="display: none;"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Estado de caso</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Estado caso</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary p-1">
                            <div class="btn-group col-12 m-2" role="group">
                                <button type="button" value="casos" onclick="buscar(this.value)" class="btn btn-primary">Mis casos</button>
                                <button type="button" value="remisiones" onclick="buscar(this.value)" class="btn btn-success">Remisiones</button>
                            </div>
                            <div class="col-12 tbl_casos"></div>
                            <div class="col-12 tbl_remisiones"></div>
                        </div>
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/guiamiscasos.js"></script>