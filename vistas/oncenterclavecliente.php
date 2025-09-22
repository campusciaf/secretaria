<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 14;
   $submenu = 1412;
   require 'header.php';

   if ($_SESSION['oncenterclavecliente'] == 1) {

?>
      <div id="precarga" class="precarga"></div>
      <div class="content-wrapper">
         <div class="content-header">
         <div class="container-fluid">
            <div class="row mb-2">
               <div class="col-6">
                  <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Restablecer cuenta</span><br>
                        <span class="fs-16 f-montserrat-regular">Gestione el ingreso al proceso de admisiones con el numero de caso</span>
                  </h2>
               </div>
               <div class="col-6 pt-4 pr-4 text-right">
               <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
               </div>

               <div class="col-12 migas">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión clave</li>
                     </ol>
               </div>
               
               <!-- /.col -->
            </div>
            <!-- /.row -->
         </div>
         <!-- /.container-fluid -->
      </div>

         <section class="content p-4">
            <div class="row m-0 p-0" >
               <div class="card col-4 p-0 m-0" id="t-Cc">
                  <div class="row m-0 p-0">
                    
                     <div class="col-12 p-4 tono-3">
                           <div class="row align-items-center">
                              <div class="pl-1">
                                 <span class="rounded bg-light-blue p-3 text-primary ">
                                       <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                 </span> 
                              
                              </div>
                              <div class="col-10">
                              <div class="col-5 fs-14 line-height-18"> 
                                 <span class="">Consultas</span> <br>
                                 <span class="text-semibold fs-20">Casos</span> 
                              </div> 
                              </div>
                           </div>
                     </div>

                     <div class="col-12 p-4">
                        <form action="#" id="form_restaurar_admision" method="POST" class="row " >
                           <div class="col-8 m-0 p-0" id="t-nc">
                                 <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                       <input type="number" placeholder="" value="" required class="form-control border-start-0 usuario_celular" name="caso" id="caso" maxlength="5">
                                       <label>Número de caso</label>
                                    </div>
                                 </div>
                                 <div class="invalid-feedback">Please enter valid input</div>
                           </div>
                           <div class="col-4 m-0 p-0">
                              <input type="submit" value="Consultar" class="btn btn-success btn-block py-3" />
                           </div>

                        </form>
                        <div class="col-xl-12" id="consultaEstu">

                           <div class="col-12 px-2  pb-2 ">
                              <div class="row align-items-center" id="t-id">
                                 <div class="pl-4">
                                    <span class="rounded bg-light-white p-2 text-gray ">
                                       <i class="fa-solid fa-id-card" aria-hidden="true"></i>
                                    </span> 
                                 
                                 </div>
                                 <div class="col-10">
                                 <div class="col-10 fs-14 line-height-18"> 
                                    <span class="">Identificación </span> <br>
                                    <span class="text-semibold fs-14">----------- </span> 
                                 </div> 
                                 </div>
                              </div>
                           </div>

                           <div class="col-12 px-2 pt-4 pb-2 ">
                              <div class="row align-items-center" id="t-nm">
                                 <div class="pl-4">
                                    <span class="rounded bg-light-white p-2 text-gray ">
                                       <i class="fa-regular fa-user" aria-hidden="true"></i>
                                    </span> 
                                 
                                 </div>
                                 <div class="col-10">
                                 <div class="col-10 fs-14 line-height-18"> 
                                    <span class="">Nombre completo </span> <br>
                                    <span class="text-semibold fs-14">----------  </span> 
                                 </div> 
                                 </div>
                              </div>
                           </div>

                           <div class="col-12 px-2 pt-4 pb-4 ">
                              <div class="row align-items-center" id="t-cl">
                                 <div class="pl-4">
                                    <span class="rounded bg-light-white p-2 text-gray">
                                       <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                                    </span> 
                                 
                                 </div>
                                 <div class="col-10">
                                 <div class="col-10 fs-14 line-height-18"> 
                                    <span class="">Correo electrónico </span> <br>
                                    <span class="text-semibold fs-14">---------- </span> 
                                 </div> 
                                 </div>
                              </div>
                           </div>
                        </div>

                     </div>
                  </div>
               </div>


               <div class="col-5 d-flex align-items-center">
                  <div class="row col-12">
                     <div class="col-12 ">
                        <div class="row d-flex justify-content-center ">
                           <div class="col-3  text-center pt-4 " id="t-cs">
                                 <i class="fa-solid fa-trophy avatar avatar-50 bg-light-orange text-orange rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
                                 <h4 class="titulo-2 fs-18 mb-0">----</h4>
                                 <p class="small text-secondary">Caso</p>
                           </div>
                           <div class="col-3 text-center pt-4" id="t-cam">
                                 <i class="fa-solid fa-bullhorn avatar avatar-50 bg-light-green text-green rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
                                 <h4 class="titulo-2 fs-18 mb-0">-----</h4>
                                 <p class="small text-secondary">Campaña</p>
                           </div>
                           <div class="col-3  text-center pt-4" id="t-es">
                                 <i class="fa-solid fa-user-check avatar avatar-50 bg-light-yellow text-yellow rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
                                 <h4 class="titulo-2 fs-18 mb-0">-----</h4>
                                 <p class="small text-secondary">Estado</p>
                           </div>
                        </div>
                     </div>
   
                     <div class="col-12 mt-4">
                        <div class="row d-flex justify-content-center" id="t-cm">  
                           <div class="col-auto">
                              <i class="fa-regular fa-star avatar text-white bg-yellow  rounded-circle fa-2x"></i>
                           </div>
                           <div class="col-auto ps-0">
                              <div class="row">
                                 <div class="col-12">Gana 500 puntos</div>
                                 
                                 <div class="col-12 progress progress-sm">
                                       <div class="progress-bar bg-warning" style="width: 80%"></div>
                                 </div>
                                 <p class="text-secondary small">Completa tu meta</p>
                              </div>
                           </div>
                        </div>
                     </div>

                  </div>
               </div>

               <div class="col-3 d-flex align-items-center p-0 m-0" id="t-tip">
                  <div class="col-12 bg-tips p-0 m-0">
                     <div class="card-header tono-3">
                        <div class="row align-items-center">
                              <div class="col">
                                 <h6 class="titulo-2 fs-18 text-semibold">
                                    <i class="fa-regular fa-lightbulb text-warning"></i>
                                       Tips
                                 </h6>
                              </div>

                        </div>
                     </div>
                     <div class="card-body">
                        <h2 class="titulo-2 fs-24 text-semibold">Proceso de admisiones</h2>
                        <p>En esta parte se restablece la clave del interesado al numero de caso.</p>
                        <p>Para realizar el proceso de ingreso del cliente  a la plataforma, se debe realizar en el siguiente link 
                           <a href="https://ciaf.digital/inscripciones/" target="_blank">Proceso de admisiones</a>
                        </p>
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

   <script type="text/javascript" src="scripts/oncenterclavecliente.js"></script>
<?php
}
ob_end_flush();
?>