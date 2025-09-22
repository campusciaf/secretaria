<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: ../");
}
	else
{
$menu=14;
$submenu=1409;
require 'header.php';
	if ($_SESSION['oncenterconsultas']==1)
{
		
?>

<div id="precarga" class="precarga"></div>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<!--Contenido-->
<div class="content-wrapper">
   <!-- Main content -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h2 class="m-0 line-height-16">
                     <span class="titulo-2 fs-18 text-semibold">Consultas</span><br>
                     <span class="fs-16 f-montserrat-regular">Visualice los resultados de las campañas</span>
               </h2>
            </div>
            <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
               <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
            <div class="col-12 migas">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                     <li class="breadcrumb-item active">Consultas</li>
                  </ol>
            </div>
            
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <section class="content" style="padding-top: 0px;">
      <div class="row">

         <div class="col-6 py-3 pl-4" id="t-tog" >
            <h5 class="fw-light mb-4 text-secondary pl-4">Total Clientes,</h5>
            <h1 class="titulo-2 fs-36 pl-4 text-semibold">2562460.00 <small>USD</small></h1>
            <h5 class="pl-4 titulo-2 fs-18 text-semibold">46124.28 <small class="text-success">18.0% <i class="fa-solid fa-arrow-up"></i></small></h5>
         </div>

         <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 d-flex align-items-center">
            <div class="row col-12 d-flex justify-content-end">

               <div class="col-auto cursor-pointer ">
                  <div class="row justify-content-center">
                     <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-tc">
                                 <div class="col-auto">
                                 <div class="avatar rounded bg-light-green text-success">
                                          <i class="fa-solid fa-check" aria-hidden="true"></i>
                                 </div>
                                 </div>
                                 <div class="col ps-0" >
                                 <div class="small mb-0">Total</div>
                                 <h4 class="text-dark mb-0">
                                          <span class="text-semibold" id="dato_caracterizados">0</span> 
                                          <small class="text-regular">OK</small>
                                 </h4>
                                 <div class="small">Cumplidas <span class="text-green"></span></div>
                                 </div>
                              </div>
                     </div>
                  </div>
               </div>

               <div class="col-auto cursor-pointer">
                  <div class="row justify-content-center">
                     <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-tp">
                                 <div class="col-auto">
                                 <div class="avatar rounded bg-light-yellow text-warning">
                                       <i class="fa-solid fa-triangle-exclamation"></i>
                                 </div>
                                 </div>
                                 <div class="col ps-0">
                                 <div class="small mb-0">Total</div>
                                 <h4 class="text-dark mb-0">
                                          <span class="text-semibold" id="dato_caracterizados">0</span> 
                                          <small class="text-regular">OK</small>
                                 </h4>
                                 <div class="small">Pendientes <span class="text-green"></span></div>
                                 </div>
                              </div>
                     </div>
                  </div>
               </div>

               <div class="col-auto cursor-pointer">
                  <div class="row justify-content-center">
                     <div class="col-12 hidden">
                              <div class="row align-items-center" id="t-tn">
                                 <div class="col-auto">
                                 <div class="avatar rounded bg-light-red text-danger">
                                       <i class="fa-solid fa-xmark"></i>
                                 </div>
                                 </div>
                                 <div class="col ps-0">
                                 <div class="small mb-0">Total</div>
                                 <h4 class="text-dark mb-0">
                                          <span class="text-semibold" id="dato_caracterizados">0</span> 
                                          <small class="text-regular">OK</small>
                                 </h4>
                                 <div class="small">No Cumplidas <span class="text-green"></span></div>
                                 </div>
                              </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-12 p-4">
            <div class="row">
               <div class="col-6 pt-4 pl-4 tono-3 ">
                  <div class="row align-items-center pt-2">
                     <div class="pl-4 ">
                           <span class="rounded bg-light-green p-3 text-success ">
                              <i class="fa-solid fa-headset" aria-hidden="true"></i>
                           </span> 
                     </div>
                     <div class="col-10">
                     <div class="col-8 fs-14 line-height-18"> 
                           <span class="">Resultados</span> <br>
                           <span class="text-semibold fs-16" id="dato_periodo">Campaña</span> 
                     </div> 
                     </div>
                  </div>
               </div>

               <div class="col-6 pt-4 tono-3">
                  <form name="formulario" id="formulario" method="POST">
                     <div class="row" id="t-sn">
                        <div class="col-10 p-0 m-0">
                           <div class="form-group position-relative check-valid">
                              <div class="form-floating">
                                 <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo_campana" id="periodo_campana"></select>
                                 <label>Seleccionar campaña</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                        </div>
                        <div class="col-2 p-0 m-0">
                           <a onclick="buscar(periodo_campana.value)" value="" class="btn btn-success py-3 text-white" >Buscar</a>
                        </div>
                     </div>
                  </form>
               </div>

               <div class="card col-12 p-4">
                  <div class="row col-12">
                     <div class="col-12 table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table" style="width: 100%;">
                           <thead>
                              <th id="t-c">Caso</th>
                              <th id="t-id">Identificación</th>
                              <th id="t-p">Programa</th>
                              <th id="t-j">Jornada</th>
                              <th id="t-n">Nombre Completo</th>
                              <th id="t-fn">Fecha nacimiento</th>
                              <th id="t-cu">Celular</th>
                              <th id="t-em">Email</th>
                              <th id="t-pe">Periodo Ingreso</th>
                              <th id="t-fi">Fecha Ingreso</th>
                              <th id="t-me">Medio</th>
                              <th id="t-co">Conocio</th>
                              <th id="t-con">Contácto</th>
                              <th id="t-m">Modalidad</th>
                              <th id="t-e">Estado</th>
                              <th id="t-se">Seguimiento</th>
                              <th id="t-ma">Mailing</th>
                              <th id="t-pc">Periodo Campana</th>
                              <th id="t-f">Formulario</th>
                              <th id="t-f">Inscripción</th>
                              <th id="t-en">Entrevista</th>
                              <th id="t-dc">Documentos</th>
                              <th id="t-mt">Matrícula</th>
                              <th id="t-po">Programa</th>
                           </thead>
                           <tbody>                            
                           </tbody>
                        </table>
                     </div>

                  </div>
               </div>
            </div>
         </div>

      </div>      <!-- /.row -->
   </section>
 
</div><!-- /.content-wrapper -->

<!--Fin-Contenido-->

<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>
<script type="text/javascript" src="scripts/oncenterconsultas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
	ob_end_flush();
?>