<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
error_reporting(0);

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 1;
   $submenu = 111;
   require 'header.php';
   if ($_SESSION['carnet']) {
?>
      <style>

         #pruebaimprimircarnet {
            width: 8.6cm;
            height: 5.4cm;
         }
         #carnet2 {
            width: 8.6cm;
            height: 5.4cm;
         }
      </style>
      <link rel="stylesheet" href="../public/css/print.min.css">
      <div id="precarga" class="precarga"></div>
      <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                     <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Carnet</span><br>
                        <span class="fs-16 f-montserrat-regular">..</span>
                     </h2>
                  </div>
                  <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                     <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                  </div>
                  <div class="col-12 migas">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión carnet</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <section class="content" style="padding-top: 0px;">
            <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="card card-primary" style="padding: 2% 1%">
                     <div class="form-group col-xl-6 col-lg-8 col-md-12 col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                           <div class="input-group">
                              <div class="form-floating flex-grow-1">
                                 <input type="number" placeholder="" class="form-control" name="cedula" id="cedula" maxlength="100" required>
                                 <label for="cedula">Mi carnet</label>
                              </div>
                              <input type="submit" value="Consultar" onclick="buscar()" class="btn btn-success" />
                           </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                     </div>
                     <div class="col-md-12" style="padding: 5px;"></div>
                     <div class="row">
                        <div class="col-lg-8 col-md-8 col-12 order-2 order-md-1">
                           <div class="cotenido_carnet">
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12 order-1 order-md-2" id="ocultar_select_programas">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <select required class="form-control border-start-0 selectpicker" data-live-search="true" name="programa_carnet" id="programa_carnet">
                                 </select>
                                 <label for="indicador">Programa</label>
                              </div>
                              <div class="invalid-feedback">Please enter valid input</div>
                           </div>
                        </div>
                     </div>


                     <div class="col-md-6 cad" style="padding: 0px;"></div>
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
   <script src="scripts/print.js"></script>
   <script type="text/javascript" src="scripts/carnet.js"></script>
<?php
}
ob_end_flush();
?>