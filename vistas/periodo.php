<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["periodo"]))
{
  header("Location: ../");
}
else
{
$menu=1;
$submenu=13;
require 'header.php';
	if ($_SESSION['periodo']==1)
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
               <h1 class="m-0"><small id="nombre_programa"></small>Periodo Académico</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión periodos</li>
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
            <div class="card card-primary" style="padding: 2%">
               <div class="row">
                  <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                     <label>Periodo Actual:</label>	
                     <div class="input-group mb-3">
                        <div class="input-group-prepend">
                           <span class="input-group-text"><i class="fa fa-calendar-times"></i></span>
                        </div>
                        <input type="text" class="form-control" id="periodo_actual" disabled >
                        <span class="input-group-btn" id="btn_modal_periodo_actual">
                        <button type="button" class="btn btn-warning" style="height: 34px;" id="editar" onclick="editar()">
                        <i class="fa fa-pencil-alt"></i>
                        </button>
                        <button type="button" class="btn btn-success " style="height: 34px;" id="guardarEditar"
                           onclick="guardarEditar()">
                        <i class="far fa-edit"></i>
                        </button>
                        </span>
                     </div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                     <label>Agregar Periodo:</label>	
                     <div class="input-group mb-3">
                        <div class="input-group-prepend">
                           <span class="input-group-text"><i class="fa fa-calendar-times"></i></span>
                        </div>
                        <input type="text" class="form-control" id="periodoNew" placeholder="Nuevo Periodo">
                        <span class="input-group-btn" id="btn_modal_periodo_actual">
                        <button type="button" class="btn btn-success" style="height: 34px;" onclick="aggPeriodo()">
                        <i class="far fa-edit"></i>
                        </button>
                        </span>
                     </div>
                  </div>
               </div>
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
	else{
	  require 'noacceso.php';
	}	
	
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/periodo.js"></script>
<?php
}
	ob_end_flush();
?>
<script>

</script>