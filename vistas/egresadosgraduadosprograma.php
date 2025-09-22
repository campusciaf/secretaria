<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 30;
   $submenu = 3005;
   require 'header.php';

   if ($_SESSION['egresadosgraduadosprograma'] == 1) {
?>
      <div id="precarga" class="precarga"></div>
      <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                        <h2 class="m-0 line-height-16">
                           <span class="titulo-2 fs-18 text-semibold">Panel</span><br>
                           <span class="fs-16 f-montserrat-regular"></span>
                        </h2>
                  </div>
                  <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                        <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                  </div>
                  <div class="col-12 migas">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                           <li class="breadcrumb-item active">Gestión panel</li>
                        </ol>
                  </div>
               </div>
            </div>
      </div>
         <section class="content" style="padding-top: 0px;">
            <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                  <div class="card card-primary" style="padding: 2% 1%">

                     <div class="col-xl-2 col-lg-12 col-md-12 col-12">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <select value="" required class="form-control border-start-0 selectpicker" onChange="listar(this.value,1)" data-live-search="true" name="programa" id="programa"></select>
                                 <label>Seleccionar Programa</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                     </div>
                     <div class="row" style="margin: 0; padding: 0">
                        <div id="resultado" class="col-12 table-responsive">
                           <table id="tbllistado" class="table" style="width:100%">
                           
                              <thead>
                                 <th>Identificación</th>
                                 <th>Nombre</th>
                                 <th>Programa</th>
                                 <th>Jornada</th>
                                 <th>Semestre</th>
                                 <th>Correo</th>
                                 <th>Celular</th>
                                 <th>Estado</th>
                                 <th>Periodo Activo</th>
                              </thead>
                              <tbody>
                              </tbody>
                           </table>
                        </div>
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

   <script type="text/javascript" src="scripts/egresadosgraduadosprograma.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
ob_end_flush();
?>