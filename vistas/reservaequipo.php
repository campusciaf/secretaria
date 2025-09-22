<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login");
} else {
    $menu = 3;
    require 'header_docente.php';
?>
    <div id="precarga" class="precarga" style="display: none;"></div>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body text-center con" style="height: 100%;">
                    <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSdhndsQeKLIwrrPyPQDT8HpDDEIRhqtMdJ1i7JnTyKDQz97nA/viewform?embedded=true" width="640" height="1000" frameborder="0" marginheight="0" marginwidth="0"></iframe>
                </div>
            </div>
        </div>
    </div><!-- /.content-wrapper -->
    <?php
    require 'footer_docente.php';
    ?>
    <script type="text/javascript" src="scripts/disponibilidad_salones.js"></script>
<?php
}
ob_end_flush();
?>
<script>

</script>