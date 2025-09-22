    <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 4.0
        </div>
        <strong>Copyright &copy; 2019-2022 <a href="htts://www.ciaf.edu.co">CIAF</a>.</strong> All rights reserved.
    </footer>    
    <!-- jQuery -->
    <script src="../public/js/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap 3.3.5 -->

	<script src="../public/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../public/js/app.min.js"></script>

    <!-- DATATABLES -->
    <script src="../public/datatables/jquery.dataTables.min.js"></script> 
  	<script src="../public/datatables/dataTables.buttons.min.js"></script>
	<script src="../public/datatables/buttons.colVis.min.js"></script>
	<script src="../public/datatables/buttons.flash.min.js"></script>
	<script src="../public/datatables/buttons.html5.min.js"></script>
    <script src="../public/datatables/buttons.print.min.js"></script>
    <script src="../public/datatables/jszip.min.js"></script>
    <script src="../public/datatables/pdfmake.min.js"></script>
    <script src="../public/datatables/vfs_fonts.js"></script> 
	<script src="../public/datatables/dataTables.fixedHeader.min.js" type="text/javascript"></script>
	<script src="//cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>
	<script src="../public/datatables/dataTables.responsive.min.js"></script>


	


    <script src="../public/js/bootbox.min.js"></script> 
    <script src="../public/js/bootstrap-select.min.js"></script>

	<script src="../public/js/jquery.slimscroll.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

	<script src="../public/canvasjs/canvasjs.min.js"></script>
    <script src="scripts/header.js"></script>
    <script>
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
        
        function setupTimers () {
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
        $(document).ready(function(){
            // do some other initialization
            setupTimers();
        });
    </script>

  </body>
</html>