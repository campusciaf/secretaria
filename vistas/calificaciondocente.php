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
$menu=24;
$submenu=2401;
require 'header.php';

	if ($_SESSION['calificaciondocente']==1)
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
               <h1 class="m-0"><small id="nombre_programa"></small>Calificación Docente </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión docente</li>
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
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card card-primary" style="padding: 2% 1%">
               <div class="row" style="margin: 0; padding: 0">
                  <div id="titulo" class="col-lg-12" hidden></div>
                  <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                     <label>Programa</label>	
                     <div class="input-group mb-3">
                        <div class="input-group-prepend">
                           <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <select id="programas" name="programas"  class="form-control selectpicker" data-live-search="true" data-style="border" required></select>
                     </div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                     <label>Jornada</label>	
                     <div class="input-group mb-3">
                        <div class="input-group-prepend">
                           <span class="input-group-text"><i class="fas fa-calendar-times"></i></span>
                        </div>
                        <select id="jornada" name="jornada"  class="form-control selectpicker" data-live-search="true" data-style="border" required></select>
                        <button class="btn btn-success" onclick="buscar()">Buscar</button>	
                     </div>
                  </div>
               </div>
               <div class="col-md-12 datos" style="margin-top: 10px;"></div>
               <!--Fin centro -->
            </div>
            <!-- /.card -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
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

<script type="text/javascript" src="scripts/calificaciondocente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
	ob_end_flush();
?>
