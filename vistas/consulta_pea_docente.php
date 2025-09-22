<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.php");
} else {
    $menu = 6;
    $submenu = 606;
    require 'header.php';
    if ($_SESSION['consulta_pea_docente'] == 1) {
?>
        <div id="precarga" class="precarga" style="display: none;">
        </div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><small id="nombre_programa"></small>Consulta Pea Docente</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Consulta Pea Docente</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <!--Fondo de la vista -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12" id="seleccionprograma">
                                <form name="formularioverificar" id="formularioverificar" method="POST">
                                    <div class="input-group input-group-md">
                                        <input type="number" class="form-control" name="usuario_identificacion" id="usuario_identificacion" maxlength="11" required placeholder="Número de Identificación">

                                        <span class="input-group-btn">
                                            <button type="submit" id="btnVerificar" class="btn btn-success btn-flat">Consultar</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-hover text-nowrap">
                                    <thead>
                                    <label class="titulo-4">Documentos</label>
                                        <th>Nombre Documento</th>
                                        <th>Descripción Documento</th>
                                        <th>Archivo Documento</th>
                                        <th>Fecha Actividad</th>
                                        <th>Hora Actividad</th>
                                    </thead>

                                </table>
                            </div>

                            <br>
                            <div id="mostrar_tablas_consulta">
                            </div>

                            <div id="mostrar_tablas_ejercicios_consulta">
                            </div>

                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
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
<script type="text/javascript" src="scripts/consulta_pea_docente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>