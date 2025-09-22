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
$submenu=1014;
require 'header.php';

	if ($_SESSION['consultatotalescuelas']==1)
	{
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Total estudiantes</span><br>
                      <span class="fs-14 f-montserrat-regular">Vista que contiene el total de estudiantes por escuela</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Total estudiantes</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>

    <section class="container-fluid px-4">
        <div class="row">

            <div class="col-12 text-right pb-4 px-4">
               <a onclick="configurar()" type="button" class="btn btn-primary btn-sm" >
                  Configurar programas
               </a>
            </div>

            <div class="row justify-content-md-center" id="resultado"></div>

        </div>
    </section><!-- /.content -->
</div><!-- Main content -->


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
         <div class="panel-body col-12 ">
            <table id="tbllistadoconfig" class="table table-striped table-bordered table-condensed table-hover responsive" style="width:100%">
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

<script type="text/javascript" src="scripts/consultatotalescuelas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
	ob_end_flush();
?>
