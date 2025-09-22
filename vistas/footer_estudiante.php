<div id="myModalAcepto" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-1">¡Desafío de liderazgo! ¿Estás listo para crear experiencias extraordinarias?</h5>
            </div>
            <div class="modal-body p-4">
                <h4>Estimado/a Estudiante: </h4>
                <p class="text-justify">
                    Llegó el momento de nuestros veedores,
                    <br> <br>  
                    El reto es apoyar el proceso de aprendizaje para que nuestros estudiantes se conviertan en profesionales capaces de liderar la era digital.
                    <br> <br>
                    ¿Estas listo?
                </p>
                <h3 class="fs-4">Autorización de datos personales</h3>
                <p class="text-justify">
                    Conforme lo establece la Ley 1581 de 2012 y sus decretos reglamentarios,
                    manifiesto, de manera libre, previa y expresa, que con el diligenciamiento
                    de la presento encuesta, autorizo a CIAF, para realizar la recolección,
                    tratamiento, almacenamiento y uso de los datos que suministro, cuya finalidad es:
                    Brindar al estudiante servicios de bienestar institucional y social,
                    Realizar Gestión administrativa, contable y financiera, Atención de (PQRS),
                    Obtener datos con Fines históricos y estadísticos, Realizar Publicidad y mercadeo,
                    Cumplir Requerimientos institucionales y del Ministerio de Educación Nacional.
                </p>

                <p class="text-justify">
                    En virtud de lo anterior, autorizo a CORPORACIÓN INSTITUTO DE ADMINISTRACIÓN Y FINANZAS –CIAF-,
                    a realizar el tratamiento de datos personales para los fines previamente comunicados y acepto la política
                    de tratamiento de datos personales publicada
                    <a href="https://ciaf.edu.co/tratamientodatos" target="_blank" title="Tratamiento de datos">https://ciaf.edu.co/tratamientodatos</a>
                </p>

                <form name="formularioConfirmarVeedor" id="formularioConfirmarVeedor" method="POST">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="1" name="acepto" id="acepto" required>
                            <a href="https://ciaf.digital/public/web_tratamiento_datos/politicaciaf_tratamientodatos.pdf" target="_blank">Acepto terminos y condiciones</a></label><br>
                        <button class="btn btn-success btn-block" type="submit" id="btnData"> Si, Estoy listo,comprometido y feliz.</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>

<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- jQuery -->
<script src="../public/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../public/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../public/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../public/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../public/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../public/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../public/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../public/plugins/moment/moment.min.js"></script>
<script src="../public/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../public/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/dist/js/adminlte.js"></script>

<script type="text/javascript" src="../public/plugins/intro.js"></script><!-- js para el tour -->
<script type="text/javascript" src="../public/plugins/slick.min.js"></script>


<!-- DATATABLES -->
<script src="../public/datatables/jquery.dataTables.min.js"></script>
<script src="../public/datatables/dataTables.buttons.min.js"></script>
<script src="../public/datatables/buttons.colVis.min.js"></script>
<script src="../public/datatables/buttons.flash.min.js"></script>
<script src="../public/datatables/buttons.html5.min.js"></script>
<script src="../public/datatables/buttons.print.min.js"></script>
<script src="../public/datatables/jszip.min.js"></script>
<!-- <script src="../public/datatables/pdfmake.min.js"></script> -->
<script src="../public/datatables/vfs_fonts.js"></script>
<script src="../public/datatables/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<!-- <script src="//cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script> -->
<script src="../public/datatables/dataTables.responsive.min.js"></script>
<script src="../public/js/bootbox.min.js"></script>
<script src="../public/plugins/bootstrap/js/bootstrap-select.min.js"></script>
<script src="../public/js/jquery.slimscroll.min.js"></script>
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script> -->
<script src="../public/canvasjs/canvasjs.min.js"></script>
<script src="../public/plugins/sweetalert.min.js"></script>
<!--<script type="text/javascript" src="scripts/panel.js"></script>-->
<!-- <script>
    var timeoutInMiliseconds = 600000;
    var timeoutId;

    function startTimer() {
        // window.setTimeout returns an Id that can be used to start and stop a timer
        timeoutId = window.setTimeout(doInactive, timeoutInMiliseconds)
    }

    function doInactive() {
        // does whatever you need it to actually do - probably signs them out or stops polling the server for info
        window.location.href = "../controlador/usuario.php?op=salir";
    }

    function setupTimers() {
        document.addEventListener("mousemove", resetTimer, false);
        document.addEventListener("mousedown", resetTimer, false);
        document.addEventListener("keypress", resetTimer, false);
        document.addEventListener("touchmove", resetTimer, false);

        startTimer();
    }

    function resetTimer() {
        window.clearTimeout(timeoutId)
        startTimer();
    }
    $(document).ready(function() {
        // do some other initialization
        setupTimers();
    });
</script> -->
<!-- fullCalendar -->
<script src="../bower_components/moment/moment.js"></script>
<!-- <script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="../bower_components/fullcalendar/dist/locale/es.js"></script> -->
<script type="text/javascript" src="scripts/header_estudiante.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<!-- Page specific script -->