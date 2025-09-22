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
$submenu=1425;
require 'header.php';
	if ($_SESSION['oncenterconsultas']==1)
{
		
?>

<div id="precarga" class="precarga"></div>

<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-xl-6 col-9">
               <h2 class="m-0 line-height-16">
                     <span class="titulo-2 fs-18 text-semibold">Referidos</span><br>
                     <span class="fs-16 f-montserrat-regular">Prospectos que llegan gracias a la labor de tus proveedores, clientes y colaboradores</span>
               </h2>
            </div>
            <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
               <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
            <div class="col-12 migas">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                     <li class="breadcrumb-item active">Referidos</li>
                  </ol>
            </div>
         </div>
      </div>
      <section class="container-fluid px-4">
         <div class="row">

            <div class="col-12 m-0 p-0" >
               <div class="row" id="data1"></div>
            </div>
            <div class="col-6 pt-4 pl-4 tono-3 " id="t-titulotabla">
               <div class="row align-items-center pt-2">
                  <div class="pl-2">
                        <span class="rounded bg-light-green p-3 text-success ">
                           <i class="fa-solid fa-headset" aria-hidden="true"></i>
                        </span> 
                  </div>
                  <div class="col-10" >
                  <div class="col-8 fs-14 line-height-18"> 
                        <span class="">Resultados</span> <br>
                        <span class="text-semibold fs-16" id="dato_periodo">Campaña</span> 
                  </div> 
                  </div>
               </div>
            </div>

            <div class="col-6 px-4 pt-4 tono-3" id="t-buscar">
               <form name="formulario" id="formulario" method="POST">
                  <div class="row">
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
            <div class="card col-12">
               <div class="row">

                  <div class="col-12 table-responsive px-4" id="listadoregistros">
                     <table id="tbllistado" class="table table-hover" style="width:100%">
                        <thead>
                           <th id="t-nombre">Nombre</th>
                           <th id="t-correo">Correo</th>
                           <th id="t-celular">Celular</th>
                           <th id="t-fecha">Fecha</th> 
                           <th id="t-refiere">Refiere a:</th> 
                           <th id="t-caso">Caso</th>
                           <th id="t-estado">Estado</th> 
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
</div>


<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>
<script type="text/javascript" src="scripts/oncenterreferidos.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
	ob_end_flush();
?>