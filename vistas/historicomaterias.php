<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login");
} else {
    $menu = 6;
    $submenu = 611;
    require 'header.php';
    if ($_SESSION['historicomaterias'] == 1) {
?>
        <div id="precarga" class="precarga"></div>

        
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Histórico materias</span><br>
                        <span class="fs-16 f-montserrat-regular">Visualice todo el historico de materias</span>
                </h2>
                </div>

                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Historial materias</li>
                    </ol>
                </div>
                
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                <div class="row">
                    <div class="col-12 card">
                        <div class="row">

                            <div class="col-12 p-4 tono-3">
                                <div class="row align-items-center">
                                    <div class="pl-3">
                                        <span class="rounded bg-light-blue p-3 text-primary ">
                                            <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                        </span> 
                                    
                                    </div>
                                    <div class="col-10">
                                    <div class="col-5 fs-14 line-height-18"> 
                                        <span class="">Historico</span> <br>
                                        <span class="text-semibold fs-20">Materias</span> 
                                    </div> 
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 table-responsive px-4" id="listadoregistros">
                                <table id="tbllistado" class="table table-hover table-nowarp">
                                    <thead>
                                        <th>Asignatura</th>
                                        <th>Programa</th>
                                        <th>Jornada</th>
                                        <th>Docente</th>
                                        <th>Periodo</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

    

<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/historicomaterias.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>