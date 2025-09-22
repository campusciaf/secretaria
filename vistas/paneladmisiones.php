<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 29;
    $submenu = 290;
    require 'header.php';

    if ($_SESSION['paneladmisiones'] == 1) {
?>


<div id="precarga" class="precarga"></div>
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Panel Comercial</span><br>
                        <span class="fs-16 f-montserrat-regular">Bienvenido a nuestro panel comercial</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Panel comercial</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <section class="content" style="padding-top: 0px;">
        <div class="row mx-0">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card card-primary" style="padding: 2% 1%">

                    <div class="row" >
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-3 col-lg-4 col-md-4 col-12 px-4 pt-4">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo" id="periodo" onChange="listar(this.value)"></select>
                                            <label>Seleccionar periodo</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12" id="resultado"></div>

                    </div>

                </div>


                <!-- /.card-->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->


    <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>

    <script type="text/javascript" src="scripts/paneladmisiones.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>
<script>

</script>