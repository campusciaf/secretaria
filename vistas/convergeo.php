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
$menu=13;
$submenu=1307;
require 'header.php';
	if ($_SESSION['geolocalizacion']==1)
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
               <h1 class="m-0"><small id="nombre_programa"></small>Conversor dirección </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión conversor</li>
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
               <div id="resultado"></div>
               <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
               <div class="container">
                  <h2 id="text-center">Enter Location: </h2>
                  <form id="location-form">
                     <input type="text" id="location-input" class="form-control form-control-lg">
                     <br>
                     <button type="submit" class="btn btn-primary btn-block">Submit</button>
                  </form>
                  <div class="card-block" id="formatted-address"></div>
                  <div class="card-block" id="address-components"></div>
                  <div class="card-block" id="geometry"></div>
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
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>
<script type="text/javascript" src="scripts/convergeo.js"></script>

<?php
}
	ob_end_flush();
?>