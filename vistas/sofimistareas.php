<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 23;
   $submenu = 2320;
   require 'header.php';

   if ($_SESSION['sofimistareas'] == 1) {
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
                        <span class="titulo-2 fs-18 text-semibold">Mis tareas</span><br>
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
                  <div class="row d-flex justify-content-center py-3">

                     <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                        <div class="row justify-content-center">
                           <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-tg">
                                 <div class="col-auto">
                                    <div class="avatar rounded bg-light-white text-black">
                                       <i class="fa-solid fa-tags"></i>
                                    </div>
                                 </div>
                                 <div class="col ps-0">
                                    <div class="small mb-0">Total</div>
                                    <h4 class="text-dark mb-0">
                                       <span class="titulo-2 fs-24" id="datogeneral">0</span>
                                       <small class="text-regular">OK</small>
                                    </h4>
                                    <div class="small">General <span class="text-green"></span></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                        <div class="row justify-content-center">
                           <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-tc">
                                 <div class="col-auto">
                                    <div class="avatar rounded bg-light-green text-success">
                                       <i class="fa-solid fa-check" aria-hidden="true"></i>
                                    </div>
                                 </div>
                                 <div class="col ps-0">
                                    <div class="small mb-0">Total</div>
                                    <h4 class="text-dark mb-0">
                                       <span class="titulo-2 fs-24" id="cumplidas">0</span>
                                       <small class="text-regular">OK</small>
                                    </h4>
                                    <div class="small">Cumplidas <span class="text-green"></span></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                        <div class="row justify-content-center">
                           <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-tp">
                                 <div class="col-auto">
                                    <div class="avatar rounded bg-light-yellow text-warning">
                                       <i class="fa-solid fa-triangle-exclamation"></i>
                                    </div>
                                 </div>
                                 <div class="col ps-0">
                                    <div class="small mb-0">Total</div>
                                    <h4 class="text-dark mb-0">
                                       <span class="titulo-2 fs-24" id="pendientes">0</span>
                                       <small class="text-regular">OK</small>
                                    </h4>
                                    <div class="small">Pendientes <span class="text-green"></span></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                        <div class="row justify-content-center">
                           <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-tn">
                                 <div class="col-auto">
                                    <div class="avatar rounded bg-light-red text-danger">
                                       <i class="fa-solid fa-xmark"></i>
                                    </div>
                                 </div>
                                 <div class="col ps-0">
                                    <div class="small mb-0">Total</div>
                                    <h4 class="text-dark mb-0">
                                       <span class="titulo-2 fs-24" id="nocumplidas">0</span>
                                       <small class="text-regular">OK</small>
                                    </h4>
                                    <div class="small">No Cumplidas <span class="text-green"></span></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-2 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                        <div class="row justify-content-center">
                           <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-td">
                                 <div class="col-auto">
                                    <div class="avatar rounded bg-light-blue text-primary">
                                       <i class="fa-regular fa-sun"></i>
                                    </div>
                                 </div>
                                 <div class="col ps-0">
                                    <div class="small mb-0">Total</div>
                                    <h4 class="text-dark mb-0">
                                       <span class="titulo-2 fs-24" id="deldia">0</span>
                                       <small class="text-regular">OK</small>
                                    </h4>
                                    <div class="small">Del día <span class="text-green"></span></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                  </div>
               </div>

               <div class="col-xl-4 datoshoy px-4"></div>

               <div class="col-xl-8 datos px-4"></div>

               <div class="col-md-12 datos_usuario px-4" hidden></div>
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

   <script type="text/javascript" src="scripts/sofimistareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
   <script type="text/javascript" src="scripts/segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
   <script type="text/javascript" src="scripts/agregar_segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
   <script type="text/javascript" src="scripts/whatsapp_module.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
ob_end_flush();
?>