<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 30;
   $submenu = 3004;
   require 'header.php';

   if ($_SESSION['consultagraduados'] == 1) {
?>
      <div id="precarga" class="precarga"></div>
      <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                        <h2 class="m-0 line-height-16">
                           <span class="titulo-2 fs-18 text-semibold" id="nombre_programa">Panel</span><br>
                           <span class="fs-16 f-montserrat-regular">Establezca, ejecute y vigile el cumplimiento de nuestro propósito superior</span>
                        </h2>
                  </div>
                  <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                        <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                  </div>
                  <div class="col-12 migas">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                           <li class="breadcrumb-item active">Gestión panel</li>
                        </ol>
                  </div>
               </div>
            </div>
         </div>
         <section class="content" style="padding-top: 0px;">
            <div class="row mx-0">
               <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                  <div class="card card-primary" style="padding: 2% 1%">
                     <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                           <div class="form-floating">
                              <select value="" required class="form-control border-start-0 selectpicker" onChange="listarNuevos(this.value,1)" data-live-search="true" name="periodo" id="periodo"></select>
                              <label>Seleccionar Periodo</label>
                           </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                     </div>
                     <div class="row" style="margin: 0; padding: 0">
                        <div id="resultado"></div>
                     </div>
                     <div class="row" style="margin: 0; padding: 0">
                        <div id="resultadoDos" class="col-12"></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal" id="myModalListado">
               <div class="modal-dialog modal-xl modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h4 class="modal-title">Listado Consulta</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                     </div>
                     <div class="modal-body">
                        <div class="panel-body" id="listadoregistrostres">
                           <div id="titulo"></div>
                           <table id="tbllistadoestudiantes" class="table" style="width:100%">
                              <thead>
                                 <th>Identificación</th>
                                 <th>Nombre</th>
                                 <th>Programa</th>
                                 <th>Jornada</th>
                                 <th>Semestre</th>
                                 <th>Correo</th>
                                 <th>Celular</th>
                                 <th>Estado</th>
                              </thead>
                              <tbody>
                              </tbody>
                              <tfoot>
                                 <th>Identificación</th>
                                 <th>Nombre</th>
                                 <th>Programa</th>
                                 <th>Jornada</th>
                                 <th>Semestre</th>
                                 <th>Correo</th>
                                 <th>Celular</th>
                                 <th>Estado</th>
                              </tfoot>
                           </table>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
     
   <?php
   } else {
      require 'noacceso.php';
   }

   require 'footer.php';
   ?>

   <script type="text/javascript" src="scripts/consultagraduados.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php

}
ob_end_flush();
?>