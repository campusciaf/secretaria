<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 7;
   $submenu = 701;
   require 'header.php';
   if ($_SESSION['horarioprograma'] == 1) {
?>


<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-xl-6 col-9">
               <h2 class="m-0 line-height-16">
                     <span class="titulo-2 fs-18 text-semibold">Horario por programa</span><br>
                     <span class="fs-14 f-montserrat-regular">Visualice los horarios de clases por programa.</span>
               </h2>
            </div>
            <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
               <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
            <div class="col-12 migas mb-0">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                     <li class="breadcrumb-item active">Horario por programa</li>
                  </ol>
            </div>
         </div>
      </div>
   </div>
   <section class="content" style="padding-top: 0px;">
      <div class="row">

         <div class="col-12">
            <form id="buscar" name="buscar" method="POST">
               <div class="row">
                  <div class="col-xl-5 col-lg-4 col-md-4 col-6" id="t-programa">
                     <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                           <select value="" required name="programa_ac" id="programa_ac" class="form-control border-start-0 selectpicker" data-live-search="true" onChange="buscarDatos()"></select>
                           <label>Programa</label>
                        </div>
                     </div>
                     <div class="invalid-feedback">Please enter valid input</div>
                  </div>

                  <div class="col-xl-2 col-lg-4 col-md-4 col-6" id="t-jornada">
                     <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                           <select value="" required name="jornada" id="jornada" class="form-control border-start-0 selectpicker" data-live-search="true" onChange="buscarDatos()"></select>
                           <label>Jornada</label>
                        </div>
                     </div>
                     <div class="invalid-feedback">Please enter valid input</div>
                  </div>

                  <div class="col-xl-2 col-lg-4 col-md-4 col-6" id="t-semestre">
                              <div class="form-group mb-3 position-relative check-valid">
                                 <div class="form-floating">
                                    <select value="" required name="semestre" id="semestre" class="form-control border-start-0 selectpicker" data-live-search="true" onChange="buscarDatos()">
                                       <option value="1">1</option>
                                       <option value="2">2</option>
                                       <option value="3">3</option>
                                       <option value="4">4</option>
                                       <option value="5">5</option>
                                       <option value="6">6</option>
                                    </select>
                                    <label>Semestre</label>
                                 </div>
                              </div>
                              <div class="invalid-feedback">Please enter valid input</div>
                           </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-6" id="t-grupo">
                                 <div class="row">
                                    <div class="form-group mb-3 position-relative check-valid col-8 m-0 p-0">
                                       <div class="form-floating">
                                          <select value="" required name="grupo" id="grupo" class="form-control border-start-0 selectpicker" data-live-search="true" onChange="buscarDatos()">
                                          <option value="1">1</option>
                                             <option value="2">2</option>
                                             <option value="3">3</option>
                                             <option value="4">4</option>
                                             <option value="4">5</option>
                                             <option value="5">6</option>
                                             <option value="6">7</option>
                                             <option value="7">8</option>
                                             <option value="8">9</option>
                                             <option value="9">10</option>
                                             <option value="10">11</option>
                                             <option value="11">12</option>
                                             <option value="12">13</option>
                                             <option value="13">14</option>
                                             <option value="14">15</option>
                                             <option value="15">15</option>
                                             <option value="16">16</option>
                                             <option value="17">17</option>
                                             <option value="18">18</option>
                                             <option value="19">19</option>
                                             <option value="20">20</option>
                                          </select>
                                          <label>Grupo</label>
                                       </div>
                                    </div>
                                 </div>
                              <div class="invalid-feedback">Please enter valid input</div>
                           </div>
                     
                     <!-- <div class="col-xl-2">
                        <div class="campo-select col-lg-12">
                              <select name="periodo" id="periodo" data-live-search="true">
                              </select>
                              <span class="highlight"></span>
                              <span class="bar"></span>
                              <label>Periodo</label>
                        </div>
                     </div> -->

                  </div>
               </div>
            </form> 

         </div>

         <div class="col-12 tono-5" id="t-calendario">
            <!-- <h2 class="titulo-4" id="titulo"></h2> -->
            <div class="row">
               <table class="col-12 fs-14" id="demo-tour" cellpadding="5">
                  <thead class="borde-bottom-2">
                     <tr class="text-center titulo-2 fs-12 ">
                        <th class="py-2" style="width:130px">#</th>
                        <th class="py-2">dom </th>
                        <th class="py-2">Lunes</th>
                        <th class="py-2" style="width:150px">Martes</th>
                        <th class="py-2">Miercoles</th>
                        <th class="py-2">Jueves</th>
                        <th class="py-2">Viernes</th>
                        <th class="">Sabado</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">All Day</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">00:00 a.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">01:00 a.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th rowspan="3" class="p-2 borde-right-2" id="t-cal-1">

                           <div class="bg-white p-2 fs-12 border-left-primary">
                              <div class="fc-event-main-frame">
                                 <div class="fc-event-time">01:00 am - 04:00 am</div>
                                 <div class="fc-event-title-container">
                                    <div class="fc-event-title fc-sticky">Asignatura <br>Salón _____ <br> doc: _____ </div>
                                 </div>
                              </div>
                           </div>

                        </th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">02:00 a.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2" ></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">04:00 a.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">05:00 a.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">06:00 a.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">07:00 a.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">08:00 a.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2" rowspan="4" style="width:150px" id="t-cal-2">
                           <div class="row">
                              <div class="col-12">
                                 <div class="p-2 fs-12 border-left-primary" style="background:#252e53">
                                    <div class="fc-event-main-frame">
                                       <div class="fc-event-time">01:00 am - 04:00 am</div>
                                       <div class="fc-event-title-container">
                                          <div class="fc-event-title fc-sticky">Asignatura <br>Salón _____ <br> doc: _____ </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">09:00 a.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">10:00 a.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">11:00 a.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">12:00 p.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">01:00 p.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">02:00 p.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">03:00 p.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">04:00 p.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">05:00 p.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">06:00 p.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">07:00 p.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">08:00 p.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">09:00 p.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">10:00 p.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                     <tr class="borde-bottom-2">
                        <th class="borde-right-2">11:00 p.m</th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                        <th class="borde-right-2"></th>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>

         <div class="col-12 tono-3 p-4" id="titulo">
            <div class="row align-items-center">
               <div class="pl-2">
                     <span class="rounded bg-light-green p-2 text-success ">
                        <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                     </span> 
               </div>
               <div class="col-10">
               <div class="col-8 fs-14 line-height-18"> 
                     <span class="">Horario</span> <br>
                     <span class="text-semibold fs-16">CLASES</span> 
               </div> 
               </div>
            </div>
         </div>


         <div class="tono-5 col-12 p-0" id="calendar" style="width: 100%"></div>

 

      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->





   <div class="modal" id="myModalEvento">
      <div class="modal-dialog modal-sm modal-dialog-centered">
         <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
               <h6 class="modalTitulo">Información</h6>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
               <p id="modalDia"></p>
               <p id="modalTitle"></p>
            </div>
            <!-- Modal footer -->
         </div>
      </div>
   </div>



<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/horarioprograma.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>

  
<link href='../fullcalendar/css/main.css' rel='stylesheet' />
<script src='../fullcalendar/js/main.js'></script>
<script src='../fullcalendar/locales/es.js'></script>

