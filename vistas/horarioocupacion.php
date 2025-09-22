<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 7;
   $submenu = 712;
   require 'header.php';
   if ($_SESSION['horarioocupacion'] == 1) {
?>


<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
   <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Ocupacion</span><br>
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

                <div class="col-xl-2 col-lg-4 col-md-4 col-6" id="t-periodo">
                  <div class="form-group mb-3 position-relative check-valid">
                     <div class="form-floating">
                     <select value="" required name="periodo" id="periodo" class="form-control border-start-0 selectpicker" data-live-search="true" onChange="buscarDatos()"></select>
                     <label>Periodo académico</label>
                     </div>
                  </div>
                  <div class="invalid-feedback">Please enter valid input</div>
               </div>

                <div class="col-xl-2 col-lg-4 col-md-4 col-6" id="t-periodo">
                  <div class="form-group mb-3 position-relative check-valid">
                     <div class="form-floating">
                     <select value="" required name="sede" id="sede" class="form-control border-start-0 selectpicker" data-live-search="true" onChange="buscarDatos()"></select>
                     <label>Sede</label>
                     </div>
                  </div>
                  <div class="invalid-feedback">Please enter valid input</div>
               </div>

               <div class="col-xl-2 col-lg-4 col-md-4 col-6" id="t-programa">
                  <div class="form-group mb-3 position-relative check-valid">
                     <div class="form-floating">
                     <select value="" required name="dia" id="dia" class="form-control border-start-0 selectpicker" data-live-search="true" onChange="buscarDatos()">
                        <option value="">Seleccionar</option>   
                        <option value="Lunes">Lunes</option>
                        <option value="Martes">Martes</option>
                        <option value="Miercoles">Miercoles</option>
                        <option value="Jueves">Jueves</option>
                        <option value="Viernes">Viernes</option>
                        <option value="Sabado">Sabado</option>
                        <option value="Domingo">Domingo</option>
                     </select>
                     <label>Día</label>
                     </div>
                  </div>
                  <div class="invalid-feedback">Please enter valid input</div>
               </div>

               <div class="col-xl-2 col-lg-4 col-md-4 col-6" id="t-programa">
                  <div class="form-group mb-3 position-relative check-valid">
                     <div class="form-floating">
                     <select value="" required name="jornada" id="jornada" class="form-control border-start-0 selectpicker" data-live-search="true" onChange="buscarDatos()">
                        <option value="">Seleccionar</option>   
                        <option value="1">Mañana</option>
                        <option value="2">Tarde</option>
                        <option value="3">Noche</option>
                     </select>
                     <label>Jornada</label>
                     </div>
                  </div>
                  <div class="invalid-feedback">Please enter valid input</div>
               </div>

            </div>
               

         </form> 
         
         


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
              <div id="resultados"></div>
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

<script type="text/javascript" src="scripts/horarioocupacion.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>