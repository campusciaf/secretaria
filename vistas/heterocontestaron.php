<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 24;
    $submenu = 2407;
    require 'header.php';
    if ($_SESSION['heterocontestaron'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Resultados Generales
                            </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión resultados</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="row" >

                            <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required="" class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo" id="periodo" onchange="listar(this.value)"></select>
                                        <label>Periodo</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                               

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <table class='table table-hover text-center table-compact table-sm' id='tbllistado'>
                                        <thead>
                                            <tr>
                                                <th> </th>
                                                <th> Estudiante </th>
                                                <th> Identificacion </th>
                                                <th> Jornada </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
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
<style>
    table.dataTable tbody td {
        vertical-align: middle;
        text-align: center;
    }
</style>
<script type="text/javascript" src="scripts/heterocontestaron.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>