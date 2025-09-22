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
$submenu=18;
require 'header.php';
	if ($_SESSION['datosactualizados']==1)
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
               <h1 class="m-0"><small id="nombre_programa"></small>Actualizados </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión actualizados</li>
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
                        <div class="col-xl-6 col-lg-8 col-md-12 col-12" style="padding: 10px;">
                           <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" onclick="consulta(1)" class="btn btn-success"><i class="fas fa-user"></i> Seleccionar actualizados activos</button>
                                <button type="button" onclick="consulta(0)" class="btn btn-danger"><i class="fas fa-user"></i>Seleccionar no actualizados activos</button>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="resultado"></div>
                    </div><!-- div panel footer -->
                    <!--Fin centro -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            
        </div><!-- /.row -->

    </section>
</div><!-- /.content-wrapper -->

<!--Fin-Contenido-->
<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/datosactualizados.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>