<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 35;
   $submenu = 3502;
   require 'header.php';
   if ($_SESSION['pb-rematricula'] == 1) {
   }
?>
<style>
    iframe {
        border: none !important;
        outline: none !important;
    }
</style>
   <!-- <div id="precarga" class="precarga"></div> -->
   <div class="content-wrapper">

      <section class="content p-0">
         <div class="contenido p-4" id="mycontenido">
            <div class="row">
               <iframe style="position:relative; width:100%; height:100vh" src="https://lookerstudio.google.com/embed/reporting/8716f50d-a0ec-4844-b1ee-ab8827b54c3a/page/UiPXF" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
            </div>
            <div class="row">
               <iframe style="position:relative; width:100%; height:100vh" src="https://lookerstudio.google.com/embed/reporting/a02e1358-ab31-4e87-b579-70a965466607/page/NzAYF" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
            </div>
            <div class="row d-none">
               <div class="col-xl-12"> 

                <div id="reportContainer" style="height:96vh"></div>
                  
               </div>
              
            </div>
         </div>
      </section>
   </div>


<?php
   require 'footer.php';
}
ob_end_flush();
?>
<script src="https://cdn.jsdelivr.net/npm/powerbi-client@2.19.0/dist/powerbi.js"></script>
<script type="text/javascript" src="scripts/pb-rematricula.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>


</body>

</html>