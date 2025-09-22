<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    date_default_timezone_set("America/Bogota");
    $menu = 16;
    $submenu = 1602;
    require 'header.php';
    if ($_SESSION['encuestatic'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Resultados Encuesta TIC</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Panel</a></li>
                                <li class="breadcrumb-item active">Resultados</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="panel-body table-responsive" id="listadoregistros">

                                <div class="col-12">
                                    <div class="row justify-content-end">
                                        <div class="campo-select col-xl-2">
                                            <select name="input_periodo" id="input_periodo" class="campo" onChange="listar(this.value)"></select>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label>Periodo:</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div id="datos" class="col-12"></div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <table id="tbllistado" class="table table-hover table-sm compact">
                                        <thead>
                                            <th> Documento </th>
                                            <th> Nombres </th>
                                            <th> Celular </th>
                                            <th> Email Personal </th>
                                            <th> Email CIAF </th>
                                            <th> Progreso </th>
                                            <th> Resultado </th>
                                            <th> Foto </th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="panel-body" id="información_grupos" hidden="true">
                                <div class="row">

                                </div>
                                <div class="box">
                                    <div class="box-body">
                                        <div class="col-md-12">
                                            <div id="tblgrupos">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->

            <!-- Modal Horario -->
            <div class="modal fade in" id="modal-resultados" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLongTitle">Resultado Autoevaluación</h3>
                        </div>
                        <div class="modal-body" >
                            
                            <div id="resultados-autoevaluacion"></div>
   
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>


        </div><!-- /.content-wrapper -->
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/encuestatic.js?<?php echo date('Y-m-d-h:i:s');?>"></script>