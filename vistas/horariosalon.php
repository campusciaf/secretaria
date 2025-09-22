<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 7;
   $submenu = 703;
   require 'header.php';
   if ($_SESSION['horariosalon'] == 1) {
?>


<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
   <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Horario por salón</span><br>
                        <span class="fs-14 f-montserrat-regular">Visualice los horarios de salones de clase.</span>
                </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas mb-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Horario por salón</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
   <section class="content px-3">
      <div class="row">
         

         <form id="buscar" name="buscar" method="POST" class="col-12">
            <div class="row">

               <div class="col-xl-4 col-lg-4 col-md-4 col-6" id="t-programa">
                  <div class="form-group mb-3 position-relative check-valid">
                     <div class="form-floating">
                     <select value="" required name="salon" id="salon" class="form-control border-start-0 selectpicker" data-live-search="true" onChange="buscarDatos()"></select>
                     <label>Salón</label>
                     </div>
                  </div>
                  <div class="invalid-feedback">Please enter valid input</div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-4 col-6" id="t-periodo">
                  <div class="form-group mb-3 position-relative check-valid">
                     <div class="form-floating">
                     <select value="" required name="periodo" id="periodo" class="form-control border-start-0 selectpicker" data-live-search="true" onChange="buscarDatos()"></select>
                     <label>Periodo académico</label>
                     </div>
                  </div>
                  <div class="invalid-feedback">Please enter valid input</div>
               </div>

         </form> 
         
         
         <div class="col-12 tono-5" id="t-calendario">
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
                                       <div class="fc-event-title fc-sticky">Asignatura <br>Salón _____ <br> doc: _____ <br>#Est: _____</div>
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
                                             <div class="fc-event-title fc-sticky">Asignatura <br>Salón _____ <br> Doc: _____<br>#Est: _____ </div>
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
            <div class="row ">
               <div class="col-8">
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
               <div class="col-4 tono-3 text-right" >
                  <button class="btn bg-orange pointer text-white"  onclick="printCalendar()"> <i class="fas fa-print"></i> Imprimir </button>
               </div>
            </div>
         </div>
         


           <div class="card col-12 p-0">
               <div id="calendar" style="width: 100%"></div>
           </div>
 

      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->





<div class="modal" id="myModalEvento">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modalTitulo">Información</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <p id="modalDia"></p>
            <p id="modalTitle"></p>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
         </div>
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

<?php
}
	ob_end_flush();
?>

  
<link href='../fullcalendar/css/main.css' rel='stylesheet' />
<script src='../fullcalendar/js/main.js'></script>
<script src='../fullcalendar/locales/es.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/PrintArea/2.4.1/jquery.PrintArea.min.js" integrity="sha512-mPA/BA22QPGx1iuaMpZdSsXVsHUTr9OisxHDtdsYj73eDGWG2bTSTLTUOb4TG40JvUyjoTcLF+2srfRchwbodg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript" src="scripts/horariosalon.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>