<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
$menu = 1;
require 'header_estudiante.php';
if (isset($_SESSION['status_titulaciones_docente'])) {
?>
    <div id="precarga" class="precarga"></div>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Panel</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="panel.php">Panel</a></li>
                            <li class="breadcrumb-item active">Evaluación Docente</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary" style="padding: 2% 1%">
                        <div class="box-header with-border">
                            <div class="alert alert-danger">
                                <strong> Si tienen algun problema con la evaluación docente por favor, realiza tus solicitud por medio de este <a href="ayuda.php">Enlace.</a> </strong>
                            </div>
                            <div class="row" id="listar"></div>
                            <br><br><br><br>
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
require 'footer_estudiante.php';
ob_end_flush();
?>
<script type="text/javascript" src="scripts/verencuestadocente.js?v=<?php echo date('Y-m-d'); ?>"></script>