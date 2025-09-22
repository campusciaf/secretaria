<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 15;
   $submenu = 1508;
   require 'header.php';
   if ($_SESSION['veedores'] == 1) {

?>
      <div id="precarga" class="precarga"></div>
      <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-xl-6 col-9">
                     <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Veedores</span><br>
                        <span class="fs-16 f-montserrat-regular">...</span>
                     </h2>
                  </div>
                  <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                     <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                  </div>
                  <div class="col-12 migas">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Veedores</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <section class="container-fluid px-4 py-2">
            <div class="row">
               <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 p-3 card" id="buscar_estudiante">
                  <div class="row">
                     <input type="hidden" value="" name="tipo" id="tipo">
                     <div class="col-12">
                        <h3 class="titulo-2 fs-14">Buscar Estudiante:</h3>
                     </div>
                     <div class="col-12">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                           <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true" onclick="filtroportipo(1)">Identificacion</a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false" onclick="filtroportipo(2)">Nombre</a>
                           </li>
                        </ul>
                     </div>
                     <div class="col-12 mt-2" id="input_dato_estudiante">
                        <div class="row">
                           <div class="col-9 m-0 p-0 col-xl-9 col-lg-9 col-md-9 ">
                              <div class="form-group position-relative check-valid">
                                 <div class="form-floating">
                                    <input type="text" placeholder="" value="" class="form-control border-start-0" name="dato_estudiante" id="dato_estudiante">
                                    <label id="valortituloestudiante">Buscar Estudiante</label>
                                 </div>
                              </div>
                              <div class="invalid-feedback">Please enter valid input</div>
                           </div>
                           <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-3 m-0 p-0">
                              <input type="submit" value="Buscar" onclick="verificar_estudiante()" class="btn btn-success py-3 btn-block" disabled id="btnconsulta" />
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-8 col-lg-5 col-md-6 col-sm-12 col-12" id="mostrar_datos_estudiante">
                  <div class="container">
                     <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                           <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                              <div class="px-2  pb-2">
                                 <div class="row align-items-center">
                                    <div class="col-3">
                                       <span class="rounded bg-light-blue p-2 text-primary ">
                                          <i class="fa-solid fa-user-slash"></i>
                                       </span>
                                    </div>
                                    <div class="col-9">
                                       <span class="">Nombre:</span> <br>
                                       <span class="text-semibold fs-12 box_nombre_estudiante">-
                                       </span>
                                    </div>
                                 </div>
                              </div>
                              <div class="px-2 pb-2">
                                 <div class="row align-items-center ">
                                    <div class="col-3">
                                       <span class="rounded bg-light-green p-2 text-success">
                                          <i class="fa-solid fa-calendar-alt"></i>
                                       </span>
                                    </div>
                                    <div class="col-9">
                                       <span class="">Jornada</span> <br>
                                       <span class="text-semibold fs-12 box_jornada_e">-</span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                           <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                              <div class="px-2  pb-2">
                                 <div class="row align-items-center">
                                    <div class="col-3">
                                       <span class="rounded bg-light-red p-2 text-danger">
                                          <i class="fa-regular fa-envelope"></i>
                                       </span>
                                    </div>
                                    <div class="col-9">
                                       <span class="">Correo electrónico</span> <br>
                                       <span class="text-semibold fs-12 box_correo_electronico">-</span>
                                    </div>
                                 </div>
                              </div>
                              <div class="px-2 pb-2 mt-3">
                                 <div class="row align-items-center">
                                    <div class="col-3">
                                       <span class="rounded bg-light-green p-2 text-success">
                                          <i class="fa-solid fa-calendar"></i>
                                       </span>
                                    </div>
                                    <div class="col-9">
                                       <span class="">Semestre</span> <br>
                                       <span class="text-semibold fs-12 box_semestre_estudiante">-</span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                           <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                              <div class="px-2 pb-2">
                                 <div class="row align-items-center">
                                    <div class="col-3">
                                       <span class="rounded bg-light-green p-2 text-success">
                                          <i class="fa-solid fa-mobile-screen"></i>
                                       </span>
                                    </div>
                                    <div class="col-9">
                                       <span class="">Número celular</span> <br>
                                       <span class="text-semibold fs-12 box_celular">-</span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-xl-12 col-lg-12 col-md-12 col-12 px-3 pb-2 mt-4" onclick="enviarcorreo()" id="tour_btn_enviar">
                              <button class="btn border border-success titulo-2 fs-12 text-semibold" title="Enviar Invitación">
                              <i class="fas fa-paper-plane"></i>
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-top: 10px;" id="ocultar_tabla">
               <table class="table table-striped compact table-sm" id="datos_estudiantes">
                  <thead>
                        <tr>
                           <th scope="col">Enviar Invitación</th>
                           <th scope="col">Identificación</th>
                           <th scope="col">Apellidos</th>
                           <th scope="col">Nombres</th>
                        </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>

         </section>
      </div>
   <?php
      require 'footer.php';
   } else {
      require 'noacceso.php';
   }
   ?>
<?php
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/veedores.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

</body>

</html>