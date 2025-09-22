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
$menu = 23;
$submenu = 2321;
require 'header.php';
	if ($_SESSION['sofiasesores']==1)
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
                     <span class="titulo-2 fs-18 text-semibold">Asesores seguimientos</span><br>
                     <span class="fs-16 f-montserrat-regular">Visualice el rendimiento de los asesores</span>
               </h2>
            </div>
            <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
               <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
            <div class="col-12 migas">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                     <li class="breadcrumb-item active">Asesores</li>
                  </ol>
            </div>
            
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>

   <section class="content" style="padding-top: 0px;">
      <div class="row justify-content-center">

         <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 mb-4">
            <div class="row col-12 d-flex justify-content-center">

               <div class="col-auto cursor-pointer ">
                  <div class="row justify-content-center">
                     <div class="col-12 hidden">
                              <div class="row align-items-center">
                                 <div class="col-auto">
                                 <div class="avatar rounded bg-light-blue text-primary">
                                          <i class="fa-solid fa-check" aria-hidden="true"></i>
                                 </div>
                                 </div>
                                 <div class="col ps-0">
                                 <div class="small mb-0">Total</div>
                                 <h4 class="text-dark mb-0">
                                    <span class="text-semibold text-regular" id="citas">0</span> 
                                 </h4>
                                 <div class="small">Citas <span class="text-green"></span></div>
                                 </div>
                              </div>
                     </div>
                  </div>
               </div>

               <div class="col-auto cursor-pointer">
                  <div class="row justify-content-center">
                     <div class="col-12 hidden">
                              <div class="row align-items-center">
                                 <div class="col-auto">
                                 <div class="avatar rounded bg-light-yellow text-warning">
                                       <i class="fa-solid fa-triangle-exclamation"></i>
                                 </div>
                                 </div>
                                 <div class="col ps-0">
                                 <div class="small mb-0">Total</div>
                                 <h4 class="text-dark mb-0">
                                    <span class="text-semibold text-regular" id="llamada">0</span>      
                                 </h4>
                                 <div class="small">Llamadas <span class="text-green"></span></div>
                                 </div>
                              </div>
                     </div>
                  </div>
               </div>

               <div class="col-auto cursor-pointer">
                  <div class="row justify-content-center">
                     <div class="col-12 hidden">
                        <div class="row align-items-center">
                           <div class="col-auto">
                           <div class="avatar rounded bg-light-red text-danger">
                                 <i class="fa-solid fa-xmark"></i>
                           </div>
                           </div>
                           <div class="col ps-0">
                           <div class="small mb-0">Total</div>
                           <h4 class="text-dark mb-0">
                              <span class="text-semibold text-regular" id="segui">0</span> 
                           </h4>
                           <div class="small">Seguimientos <span class="text-green"></span></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-auto cursor-pointer ">
                  <div class="row justify-content-center">
                     <div class="col-12 hidden">
                              <div class="row align-items-center">
                                 <div class="col-auto">
                                 <div class="avatar rounded bg-light-green text-success">
                                          <i class="fa-solid fa-check" aria-hidden="true"></i>
                                 </div>
                                 </div>
                                 <div class="col ps-0">
                                 <div class="small mb-0">Total</div>
                                 <h4 class="text-dark mb-0">
                                    <span class="text-semibold text-regular" id="whatsapp">0</span> 
                                 </h4>
                                 <div class="small">WhatsApp <span class="text-green"></span></div>
                                 </div>
                              </div>
                     </div>
                  </div>
               </div>
               
            </div>
         </div>
         <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 mb-4" id="datosetiquetas"></div>

         <div class="col-12">
            <form name="formulario" id="formulario" method="POST">
               <div class="row col-12">
                  <div class="card col-12 p-4">
                     <div class="row">
                        <div class="col-xl-5 col-lg-4 col-md-4 col-6 ">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="asesor" id="asesor"></select>
                                 <label>Asesor</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                              <div class="form-group mb-3 position-relative check-valid">
                                 <div class="form-floating">
                                    <input type="date" placeholder="" value="" required class="form-control border-start-0" name="fecha_desde" id="fecha_desde"  required>
                                    <label>Fecha Inicial</label>
                                 </div>
                              </div>
                              <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                              <div class="form-group mb-3 position-relative check-valid">
                                 <div class="form-floating">
                                    <input type="date" placeholder="" value="" required class="form-control border-start-0" name="fecha_hasta" id="fecha_hasta"  required>
                                    <label>Fecha Final</label>
                                 </div>
                              </div>
                              <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-xl-1 col-lg-3 col-md-3 col-6 ">
                           <div class="row">
                              <div class="col-12">
                                 <input type="submit" value="Consultar" class="btn btn-success py-3" />
                              </div>
                           </div>
                        </div>
                     

                        <div class="col-12" id="mostrartabla">
                           <div class="row">
                              <div class="panel-body table-responsive p-4" id="listadoregistros">
                                 <table id="tbllistado" class="table" style="width: 100%;">
                                    <thead>
                                       <th>Identificación</th>
                                       <th>Nombre</th>
                                       <th>Motivo</th>
                                       <th>Descripción</th>
                                       <th>Fecha</th>
                                       <th>Hora</th>
                                       <th>Asesor</th>
                                       <th>Etiqueta</th>
                                    </thead>
                                    <tbody>                            
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>

                     </div>
                  </div>

               </div>
            </form>
         </div>
         
      </div>
   </section>
</div>



<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>
<script type="text/javascript" src="scripts/sofiasesores.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
	ob_end_flush();
?>