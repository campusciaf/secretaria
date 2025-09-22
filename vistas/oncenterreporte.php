<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 14;
   $submenu = 1431;
   require 'header.php';

   if ($_SESSION['oncenterreporte'] == 1) {
?>
      <div id="precarga" class="precarga"></div>
      <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <!--Contenido-->
      <div class="content-wrapper">
         <!-- Main content -->
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Avance nuevos</span><br>
                        <span class="fs-16 f-montserrat-regular">Optimice tu rendimiento gestionando tus tareas</span>
                     </h2>
                  </div>
                  <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                     <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                     <button class="btn btn-sm btn-outline-warning px-2 py-0 d-none segundo_tour" onclick='iniciarSegundoTour()'><i class="fa-solid fa-play"></i> Tour 2da parte</button>
                  </div>

                  <div class="col-12 migas">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Mis Tareas</li>
                     </ol>
                  </div>

                  <!-- /.col -->
               </div>
               <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
         </div>
         <section class="content" style="padding-top: 0px;">
            <div class="row">
               <div class="col-12">

                  
                  <div class="row">
                     <div class="col-12 px-3">
                        <div class="row" id="resultado"></div>
                     </div>
                  </div>

               </div>

               <!-- /.col -->
            </div>
            <!-- /.row -->
         </section>
         <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->





   <?php
   } else {
      require 'noacceso.php';
   }

   require 'footer.php';
   ?>

   <script type="text/javascript" src="scripts/oncenterreporte.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>


<?php
}
ob_end_flush();
?>