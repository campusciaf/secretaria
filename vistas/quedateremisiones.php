<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 15;
    $submenu = 1504;
    require 'header.php';
    if ($_SESSION['remisiones'] == 1) {
?>
        <div id="precarga" class="precarga" hidden></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Remisiones</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Remisiones</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group col-12 col-sm-12 col-md-6">
                            <label for="exampleFormControlSelect1">Año</label>
                            <select id="select-programa-ano" class="form-control">
                                <option value="" disabled selected>--Seleccionar Año--</option>
                                <?php
                                $fecha = 2020;
                                $actual = date('Y');
                                while ($actual >= $fecha) {
                                    echo '<option value="' . $actual . '">' . $actual . '</option>';
                                    $actual--;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="card card-primary" style="padding: 1% 1%">
                            <div class="btn-group col-md-12" role="group" aria-label="Basic example" style="margin:10px;">
                                <button type="button" value="casos" onclick="buscar(1)" class="btn btn-primary">Visualizados</button>
                                <button type="button" value="remisiones" onclick="buscar(0)" class="btn btn-success">No visualisados</button>
                            </div>
                            <div class="col-md-12 tbl_remisiones"></div>
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
<script type="text/javascript" src="scripts/quedateremisiones.js"></script>