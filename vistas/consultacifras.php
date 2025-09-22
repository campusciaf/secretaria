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
$menu=10;
$submenu=1017;
require 'header.php';

	if ($_SESSION['consultacifras']==1)
	{
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-xl-6 col-9">
               <h2 class="m-0 line-height-16">
                     <span class="titulo-2 fs-18 text-semibold">Cifras</span><br>
                     <span class="fs-14 f-montserrat-regular">Vista que contiene los estudiantes a primer curso</span>
               </h2>
            </div>
            <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
               <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
            <div class="col-12 migas">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                     <li class="breadcrumb-item active">Cifras</li>
                  </ol>
            </div>
         </div>
      </div>
   </div>
   <section class="container-fluid px-4">
      <div class="col-12" id="escuelas"></div>
         <div class="col-12" id="resultado"></div>
    </section>
            

</div>

<!-- Modal -->
<div class="modal fade" id="modalDatos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Listado estudiantes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

         <div class="row">
            <div class="col-12">
               <div class="panel-body table-responsive" id="listadoregistros">
                  <table id="tbllistado" class="table table-bordered compact table-sm table-hover" style="width:99%">
                     <thead>
                        <th>ID est. act</th>
                        <th>identificación</th>
                        <th>Nombre estudiante</th>
                        <th>Programa</th>
                        <th>Jornada</th>
                        <th>Celular</th>
                        <th>Renovación</th>
                        <th>Estado</th>

                     </thead>
                     <tbody>                            
                     </tbody>
                  </table>
               </div>
            </div>
         </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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

<script type="text/javascript" src="scripts/consultacifras.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
	ob_end_flush();
?>
