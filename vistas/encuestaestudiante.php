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
$menu=16;
$submenu=1601;
require 'header.php';
		if ($_SESSION['encuestaestudiante']==1)
	{
?>


<!--Contenido-->
<div class="content-wrapper">
   <section class="content">

      <div class="row m-0 p-0">
         
         <div class="contenido">

            <div>
               <h2 class="m-0">Encuestas </h2>
            </div>
            
            <div class="card col-xl-12 boton-mandos p-2">
               <div class="row">
                  
                  <div class="col-md-3 col-sm-6 col-12" id="creatividaddocente">
                     <a onclick="creatividaddocente()" style="cursor:pointer">
                        <div class="info-box bg-primary">
                           <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
                           <div class="info-box-content">
                              <span class="info-box-text">Encuesta creatividad docente</span>
                              <span class="info-box-number"><span id="publico_total"></span>/<span id="respuestas"></span></span>
                              <div class="progress" id="porcentaje">
                                 
                              </div>
                              <span class="progress-description" id="porcentajenumero">
                                 
                              </span>
                           </div>
                        </div>
                     </a>
                  </div>

                  <div class="col-md-3 col-sm-6 col-12">
                     <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
                        <div class="info-box-content">
                           <span class="info-box-text">Encuesta contingencia</span>
                           <span class="info-box-number">41,410</span>
                           <div class="progress">
                              <div class="progress-bar" style="width: 70%"></div>
                           </div>
                           <span class="progress-description">
                              70% Increase in 30 Days
                           </span>
                        </div>
                     </div>
                  </div>




               </div>
            </div>
         </div>

         




      </div> 

      <div class="row m-0 p-0">
         <div class="col-12 m-2">
            <div class="row"  id="resultado1">

            </div>

         </div>



      
            
      </div>

      <div class="row" id="resultado2">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
               <div class="card card-primary" style="padding: 2% 1%">	
                  <div class="panel-body table-responsive" id="listadoregistros">
                     <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                           <th>Usuario</th>
                           <th>Nombre Completo</th>
                           <th>Programa</th>
                           <th>Jornada</th>
                           <th>Semestre</th>
                           <th>Celular</th>
                           <th>Correo</th>
                           <th>Correo CIAF</th>
                           <th>¿Cómo ha afectado la emergencia actual a tu situación laboral?</th>
                           <th>¿Cómo te has sentido con esta modalidad remota?</th>
                           <th>¿Tu influencer estuvo pendiente de tus inquietudes académicas, económicas y psicosociales?</th>
                           <th>¿La continuidad de tus estudios depende de?</th>
                           <th>¿Te has acogido a los descuentos que ha ofrecido CIAF para el pago de las cuotas en estos meses de COVID-19?</th>
                           <th>¿Cómo crees que CIAF puede apoyarte para continuar tus estudios?</th>
                           <th>¿Cómo crees que puedes apoyar a CIAF para fortalecerla?</th>
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



   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->
    

<?php
}
	else
	{
	  require 'noacceso.php';
	}	
		
	
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/encuestaestudiante.js"></script>
<?php
}
	ob_end_flush();
?>
