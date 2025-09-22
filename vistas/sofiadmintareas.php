<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 23;
   $submenu = 2319;
   require 'header.php';

   if ($_SESSION['sofiadmintareas'] == 1) {
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
                        <span class="titulo-2 fs-18 text-semibold">Admin tareas</span><br>
                        <span class="fs-16 f-montserrat-regular"> Gestiona las tareas de los asesores</span>
                     </h2>
                  </div>
                  <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                     <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                  </div>

                  <div class="col-12 migas">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Tareas asesores</li>
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
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-3">
                  <div class="row">
                     <div class="col-12 datos"></div>
                     <div class="col-12 datos_usuario" hidden></div>
                  </div>
                  <!-- /.card -->
               </div>
               <!-- /.col -->
            </div>
            <!-- /.row -->
         </section>
         <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <!--Fin-Contenido-->

      <!-- inicio modal agregar seguimiento -->
      <div class="modal" id="myModalAgregar">
         <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
               <!-- Modal Header -->
               <div class="modal-header">
                  <h6 class="modal-title">Gestión seguimientos</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <?php require_once "agregar_segui_tareas.php" ?>
               </div>

            </div>
         </div>
      </div>
      <!-- fin modal agregar seguimiento -->
       
      <!-- inicio modal historial -->
      <div class="modal" id="myModalHistorial">
         <div class="modal-dialog modal-xl modal-dialog-centered">
         <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                  <h6 class="modal-title">Listado Consulta</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <?php require_once "segui_tareas.php" ?>
            </div>

         </div>
         </div>
      </div>


      <div class="modal fade" id="modal_whatsapp" tabindex="-1" role="dialog" aria-labelledby="modal_whatsapp_label">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header bg-success">
						<h6 class="modal-title" id="modal_whatsapp_label"> Whatapp </h6>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body p-0">
						<div class="container">
							<div class="row">
								<div class="col-12 m-0 seccion_conversacion">
									<?php require_once "whatsapp_module.php" ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

   <?php
   } else {
      require 'noacceso.php';
   }

   require 'footer.php';
   ?>

   <script type="text/javascript" src="scripts/sofiadmintareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
   <script type="text/javascript" src="scripts/segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
   <script type="text/javascript" src="scripts/agregar_segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
   <script type="text/javascript" src="scripts/whatsapp_module.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>