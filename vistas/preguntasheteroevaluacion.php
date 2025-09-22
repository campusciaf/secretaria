<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
  header("Location: ../");
}else{
   $menu = 24;
   $submenu = 2400;
   require 'header.php';
	if ($_SESSION['preguntasheteroevaluacion'] == 1){
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper">
   <!-- Main content -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0"><small id="nombre_programa"></small> Heteroevaluación </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php"> Inicio </a></li>
                  <li class="breadcrumb-item active"> Gestión heteroevaluación </li>
               </ol>
            </div><!-- /.col -->
         </div><!-- /.row -->
      </div><!-- /.container-fluid -->
   </div><!-- /.content-header -->
   <section class="content" style="padding-top: 0px;">
      <div class="row">
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card card-primary" style="padding: 2% 1%">
               <div class="col-md-12" id="datos" style="padding-top: 10px;"></div><!--Fin centro -->
            </div><!-- /.card -->
         </div><!-- /.col -->
      </div><!-- /.row -->
   </section><!-- /.content -->
</div>
<?php
   }else{
      require 'noacceso.php';
   }
   require 'footer.php';
}
	ob_end_flush();
?>
<script type="text/javascript" src="scripts/preguntasheteroevaluacion.js"></script>