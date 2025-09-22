<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login");
} else {
    require 'header.php';
    if ($_SESSION['abrircaso'] == 1) {
        $caso_id = isset($_POST["caso"]) ? $_POST["caso"] : "2";
?>
        <!-- fullCalendar -->
        <link rel="stylesheet" href="../public/css/fullcalendar.min.css">
        <link rel="stylesheet" href="../public/css/fullcalendar.print.min.css" media="print">
        <!--<link rel="stylesheet" href="../public/css/casos.css" >-->

        <!--Contenido Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary ">
                                <div class="box-header with-border">
                                    <section class="content-header">
                                        <h1> Abrir caso <small class="hidden-xs">Quédate</small> </h1>
                                        <ol class="breadcrumb">
                                            <li><a href="panel.php"><i class="fas fa-desktop"></i> Escritorio</a></li>
                                            <li>Quédate</li>
                                            <li class="active">Ver Casos</li>
                                        </ol>
                                    </section>
                                </div>
                                <div class="panel-body table-responsive">
                                    <div class="row">
                                        <!-- Custom Tabs -->
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                                <input type="hidden" id="caso_id" value="<?php echo $caso_id ?>">
                                                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Caso #<?php echo $caso_id ?> </a></li>
                                                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Estudiante</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab_1">
                                                    <div class="tab-content-header cabecera_seguimientos">

                                                    </div>
                                                    <ul class="timeline">
                                                    </ul>
                                                </div>

                                                <!-- /.tab-pane -->
                                                <div class="tab-pane " id="tab_2">
                                                    The European languages are members of the same family. Their separate existence is a myth.
                                                    For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
                                                    in their grammar, their pronunciation and their most common words. Everyone realizes why a
                                                    new common language would be desirable: one could refuse to pay expensive translators. To
                                                    achieve this, it would be necessary to have uniform grammar, pronunciation and more common
                                                    words. If several languages coalesce, the grammar of the resulting language is more simple
                                                    and regular than that of the individual languages.
                                                </div>
                                                <!-- /.tab-pane -->
                                            </div>
                                            <!-- /.tab-content -->
                                        </div>
                                        <div class="col-md-10">
                                            <div class="nuevo-seguimiento-contenedor hide" id="nuevo">
                                                <div class="tab-content-header">
                                                    <h4 class="tab-content-title">Agregar Seguimiento <small class="text-muted"> a este caso</small></h4>
                                                </div>
                                                <form action="#" method="post" id="nuevoSeguimiento" class="form-horizontal">
                                                    <div class="form-group">
                                                        <label for="agregar-contenido" class="col-sm-2 control-label">Descripción</label>
                                                        <div class="col-sm-10">
                                                            <input type="hidden" name="caso_id" value="<?php echo $caso_id ?>">
                                                            <textarea required="" class="form-control" id="agregar-contenido" rows="3" placeholder="Contenido del Seguimiento" name="agregar-contenido"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="agregar-tipo" class="col-sm-2 control-label">Encuentro</label>
                                                        <div class="col-sm-10">
                                                            <select required="" name="agregar-tipo" id="agregar-tipo" class="form-control">
                                                                <option selected="" disabled="" value="">Tipo...</option>
                                                                <option value="Llamada">Llamada</option>
                                                                <option value="Mensaje">Mensaje</option>
                                                                <option value="Visita">Visita</option>
                                                                <option value="Correo">Correo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="agregar-beneficio" class="col-sm-2 control-label">Recomendación</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="agregar-beneficio" id="agregar-beneficio" placeholder="¿Cuál?" value="">
                                                            <small class="help-block">Si no, deje el campo vacío.</small>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="agregar-docente" class="col-sm-2 control-label">Docente</label>
                                                        <div class="col-sm-10">
                                                            <select class="my-select form-control" name="agregar-docente" data-live-search="true" tabindex="-98">
                                                            </select>
                                                        </div>
                                                    </div><br>
                                                    <div class="form-group">
                                                        <label for="agregar-evidencia" class="col-sm-2 control-label">Evidencia</label>
                                                        <div class="col-sm-10">
                                                            <input type="file" name="agregar-evidencia">
                                                            <small class="help-block">Solo imagenes o PDF.</small>
                                                            <small class="text-danger">No incluir tildes ni ñ en los nombres de los archivos porque se perderán.</small>
                                                        </div>
                                                    </div><br>
                                                    <div class="form-group">
                                                        <div class="col-sm-6 text-right">
                                                            <button type="submit" class="btn btn-success">AGREGAR</button>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <button type="reset" class="btn btn-secondary" id="btn-reset-seguimiento">CANCELAR</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- nav-tabs-custom -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
        </div><!-- /.content-wrapper -->


    <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>
    <!-- fullCalendar -->
    <script src="../bower_components/moment/moment.js"></script>
    <script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="../bower_components/fullcalendar/dist/locale/es.js"></script>
    <!-- Script para cargar los eventos js del calendario -->
    <script src="scripts/vercaso.js"></script>
    <!-- Page specific script -->
<?php
}
ob_end_flush();
?>