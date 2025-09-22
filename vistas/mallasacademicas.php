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
$menu=1;
$submenu=112;
require 'header.php';
	if ($_SESSION['mallasacademicas']==1)
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
               <h1 class="m-0"><small id="nombre_programa"></small>Mallas Académicas</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión mallas</li>
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
            <div class="card card-primary" style="padding: 2%" id="lista_programas">
               <div class="form-group col-xl-6 col-lg-12 col-md-12 col-12">
                  <label>Seleccionar Programa</label>		
                  <div class="input-group mb-3">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                     </div>
                     <select id="programa_ac" name="programa_ac"  class="form-control selectpicker" data-live-search="true"  onChange="listar(this.value)"></select>
                  </div>
               </div>
               </h1>
               <div class="box-tools pull-right">
               </div>
            </div>
            <!-- /.box-header -->
            <!-- centro -->
		  <div class="row" id="mallas" style="width: 100%"></div>

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

<script type="text/javascript" src="scripts/mallasacademicas.js"></script>
<?php
}
	ob_end_flush();
?>