<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 30;
   $submenu = 3002;
   require 'header.php';
   if ($_SESSION['estadoegresado'] == 1) {
?>
      <div id="precarga" class="precarga"></div>
      <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                     <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Ver posibles egresados</span><br>
                        <span class="fs-16 f-montserrat-regular">Establezca, ejecute y vigile el cumplimiento de nuestro propósito superior</span>
                     </h2>
                  </div>
                  <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                     <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                  </div>
                  <div class="col-12 migas">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Ver posibles egresados</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <section class="content" style="padding-top: 0px;">
            <div class="row mx-0">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="card card-primary" style="padding: 2% 1%">
                     <form name="formulario" id="formulario" method="POST" class="col-12">
                        <div class="row">
                           <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                              <div class="form-group mb-3 position-relative check-valid">
                                 <div class="form-floating">
                                    <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="programa_ac" id="programa_ac"></select>
                                    <label>Seleccionar Programa</label>
                                 </div>
                              </div>
                              <div class="invalid-feedback">Please enter valid input</div>
                           </div>
                           <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                              <div class="form-group mb-3 position-relative check-valid">
                                 <div class="form-floating">
                                    <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo" id="periodo"></select>
                                    <label>Seleccionar periodo de ingreso</label>
                                 </div>
                              </div>
                              <div class="invalid-feedback">Please enter valid input</div>
                           </div>
                           <div class="col-xl-4 col-lg-6 col-md-12 col-12 m-0 p-0">
                              <button class="btn btn-success py-3" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Consultar</button>
                           </div>
                        </div>
                     </form>
                     <div class="row" style="width: 100%"></div>
                     <div class="panel-body" id="listadoregistros">
                        <table id="tbllistado" class="table">
                           <thead>
                              <th>identificación</th>
                              <th>id estudiante</th>
                              <th>Jornada</th>
                              <th>Estado</th>
                              <th>Semestre</th>
                              <th>Asig/apro</th>
                              <th>Periodo Activo</th>
                           </thead>
                           <tbody>
                           </tbody>
                        </table>
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

   <script type="text/javascript" src="scripts/estadoegresado.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>