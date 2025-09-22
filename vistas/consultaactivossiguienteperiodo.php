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
$submenu=1022;
require 'header.php';

	if ($_SESSION['consultaactivos']==1)
	{
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-xl-6 col-9">
               <h2 class="m-0 line-height-16">
               <span class="titulo-2 fs-18 text-semibold">Activos del sigueinte periodo</span><br>
               <span class="fs-14 f-montserrat-regular">Vista que contiene los estudiantes activos del periodo siguiente</span>
               </h2>
            </div>
            <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
               <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
            <div class="col-12 migas">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                     <li class="breadcrumb-item active">Activos</li>
                  </ol>
            </div>
         </div>
      </div>
   </div>
   <section class="container-fluid px-4">
      <div class="row">

         <div class="col-xl-8 col-lg-8 col-md-8 col-12 pt-2 pl-4 tono-3">
            <div class="row align-items-center pt-2">
               <div class="col-xl-auto col-lg-auto col-md-auto col-2">
                     <span class="rounded bg-light-green p-3 text-success ">
                        <i class="fa-solid fa-headset" aria-hidden="true"></i>
                     </span> 
               </div>
               <div class="col-xl-10 col-lg-10 col-md-10 col-10">
                  
                     <span class="fs-14 line-height-18">Activos</span> <br>
                     <span class="text-semibold fs-16 titulo-2 line-height-16" id="dato_periodo">Periodo actual </span> 
                  
               </div>
            </div>
         </div>

         <div class="col-xl-4 text-right tono-3 p-4">
            <a onclick="configurar()" type="button" class="btn btn-primary btn-sm" >
            <i class="fa-solid fa-gear"></i> Configurar programas
            </a>
         </div>
   
         <div id="resultado" class="col-12"></div>
         <div id="resultadoDos" class="card col-12 p-4"></div>

      </div>
   </section>
</div>


<!-- Modal -->
<div class="modal" id="myModalListado">
   <div class="modal-dialog modal-lg" style="max-width:99% !important">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h6 class="modal-title">Listado Consulta</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <div class="card" >
            <div class="table-responsive p-4" id="listadoregistrostres">
               <div id="titulo"></div>
               <table id="tbllistadoestudiantes" class="table table-hover" style="width:100%">
                  <thead>
                     <th>Identificación</th>
                     <th>Primer Nombre</th>
                     <th>Segundo Nombre</th>
                     <th>Primer Apellido</th>
                     <th>Segundo Apellido</th>
                     <th>Programa</th>
                     <th>Jornada</th>
                     <th>Semestre</th>
                     <th>Correo</th>
                     <th>Celular</th>
                     <th>Dirección residencia</th>
                     <th>Fecha nacimiento</th>
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


<!-- Modal -->
<div class="modal fade" id="configurar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Configurar programas</h5>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close"> x </button>
      </div>
      <div class="modal-body">
        <div class="row">
         <div class="panel-body col-12 responsive">
            <table id="tbllistadoconfig" class="table table-hover" style="width:100%">
               <thead>
                  <th>Programa</th>
                  <th>Estado</th>
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


<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/consultaactivossiguienteperiodo.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
	ob_end_flush();
?>
