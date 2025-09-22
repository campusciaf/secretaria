<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 14;
   $submenu = 1414;
   require 'header.php';

   if ($_SESSION['oncenterpanel'] == 1) {
?>
      <div id="precarga" class="precarga"></div>
      <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Panel</span><br>
                        <span class="fs-16 f-montserrat-regular">Visualice el avance de sus clientes en los procesos de admisiones</span>
                     </h2>
                  </div>
                  <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                     <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                     <button class="btn btn-sm btn-outline-warning px-2 py-0 d-none segundo_tour" onclick='iniciarSegundoTour()'><i class="fa-solid fa-play"></i> Tour 2da parte</button>
                  </div>
                  <div class="col-12 migas">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Panel</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <section class="content" style="padding-top: 0px;">
            <div class="row mx-0">
               <div class="col-12">
                  <div class="row d-flex justify-content-center py-3">
                     <div class="row px-4 mx-0" id="resultado"></div>
                     <div class="row px-4 mx-0" id="resultadoDos"></div>
                  </div>
               </div>
            </div>
         </section>
      </div>

      <div class="modal" id="myModalListado">
         <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header">
                  <h6 class="modal-title">Listado Consulta</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <div class="panel-body table-responsive" id="listadoregistrostres">
                     <div id="titulo"></div>
                     <table id="tbllistadoestudiantes" class="table table-hover" style="width:100%">
                        <thead>
                           <th>Acciones</th>
                           <th>Caso</th>
                           <th>Identificación</th>
                           <th>Nombre</th>
                           <th>Programa de Interes</th>
                           <th>Jornada</th>
                           <th>Ingreso</th>
                           <th>Medio</th>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="modal" id="myModalHistorial">
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <div class="modal-header">
                  <h6 class="modal-title">Listado Consulta</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <div id="historial"></div>
                  <div class="col-12 mt-4">
                     <div class="card card-tabs">
                        <div class="card-header p-0 pt-1">
                           <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                              <li class="nav-item">
                                 <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Seguimiento</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Tareas Programadas</a>
                              </li>
                           </ul>
                        </div>
                        <div class="card-body p-0">
                           <div class="tab-content" id="custom-tabs-one-tabContent">
                              <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                 <div class="row">
                                    <div class="col-12 p-4">
                                       <table id="tbllistadohistorial" class="table" width="100%">
                                          <thead>
                                             <th>Caso</th>
                                             <th>Motivo</th>
                                             <th>Observaciones</th>
                                             <th>Fecha de observación</th>
                                             <th>Asesor</th>
                                          </thead>
                                          <tbody>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                 <table id="tbllistadoHistorialTareas" class="table" width="100%">
                                    <thead>
                                       <th>Estado</th>
                                       <th>Motivo</th>
                                       <th>Observaciones</th>
                                       <th>Fecha de observación</th>
                                       <th>Asesor</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- inicio modal agregar seguimiento -->
      <div class="modal" id="myModalAgregar">
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <div class="modal-header">
                  <h6 class="modal-title">Agregar seguimiento</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <?php require_once "on_segui_tareas.php" ?>
               </div>

            </div>
         </div>
      </div>
      <!-- inicio modal mover -->
      <div class="modal" id="myModalMover">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Modal Header -->
               <div class="modal-header">
                  <h6 class="modal-title">Mover usuario</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Modal body -->
               <div class="modal-body">
                  <form name="moverUsuario" id="moverUsuario" method="POST" class="row">
                     <input type="hidden" id="id_estudiante_mover" value="" name="id_estudiante_mover">
                     <p class="pl-3">Mover el estado de cliente</p>
                     <div class="col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                           <div class="form-floating">
                              <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="estado" id="estado"></select>
                              <label>Mover usuario</label>
                           </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                     </div>
                     <div class="col-12">
                        <input type="submit" value="Mover usuario" id="btnMover" class="btn btn-success btn-block">
                     </div>
                  </form>
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

   <script type="text/javascript" src="scripts/oncenterpanel.js"></script>
   <script type="text/javascript" src="scripts/on_segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
ob_end_flush();
?>