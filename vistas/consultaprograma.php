<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 10;
   $submenu = 1002;
   require 'header.php';
   if ($_SESSION['consultaprograma'] == 1) {
?>
      <div id="precarga" class="precarga"></div>
      <div class="content-wrapper ">
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-xl-6 col-9">
                     <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Vista General</span><br>
                        <span class="fs-14 f-montserrat-regular">Universitarios CIAF en la era digital</span>
                     </h2>
                  </div>
                  <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                     <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                  </div>
                  <div class="col-12 migas">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Población estudiantil</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <section class="content" style="padding-top: 0px;">
            <div class="card card-primary" style="padding: 2% 1% 0% 1%">
               <div class="row p-0 m-0">
                  <div id="datos" class="col-12"></div>
               </div>
            </div>
         </section>
         <section class="content" style="padding-top: 0px;" id="resultadoprofesional">
            <div class="card card-primary" style="padding: 2% 1% 0% 1%">
               <div class="row p-0 m-0">
                  <div id="profesional" class="col-12 m-2 p-2"></div>
               </div>
            </div>
         </section>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Listado estudiantes</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-12">
                        <table id="tbllistado" class="table compact table-sm table-hover" style="width:100%">
                           <thead>
                              <th>Id estu.</th>
                              <th>Identificación</th>
                              <th>Nombre estudiante</th>
                              <th>Programa</th>
                              <th>Correo CIAF</th>
                              <th>Correo personal</th>
                              <th>Celular</th>
                              <th>Periodo Ingreso</th>
                              <th>Periodo Activo</th>
                           </thead>
                           <tbody>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               </div>
            </div>
         </div>
      </div>
      <!----MODALES(Ver whatsapp)  ------>
      <div class="modal fade" id="modal_whatsapp" tabindex="-1" role="dialog" aria-labelledby="modal_whatsapp_label">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
               <div class="modal-header bg-success">
                  <h6 class="modal-title" id="modal_whatsapp_label"> WhatsApp CIAF</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
               </div>
               <div class="modal-body p-0">
                  <div class="container">
                     <div class="row">
                        <div class="col-12 m-0 seccion_conversacion">
                           <?php require_once 'whatsapp_module.php'; ?>
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
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/consultaprograma.js"></script>
<script type="text/javascript" src="scripts/whatsapp_module.js?<?= date("Y-m-d") ?>"></script>