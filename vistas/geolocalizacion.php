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
$submenu=1305;
require 'header.php';
	if ($_SESSION['geolocalizacion']==1)
	{
?>


<style>
  /* Always set the map height explicitly to define the size of the div
   * element that contains the map. */
  #map {
	height: 100vh;
  }
  /* Optional: Makes the sample page fill the window. */
  html, body {
	height: 100%;
	margin: 0;
	padding: 0;
  }
</style>

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
               <h1 class="m-0"><small id="nombre_programa"></small>Geolocalización </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión geolocalización</li>
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
         <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="card card-primary" style="padding: 2% 1%">
               <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                  <form name="formulario" id="formulario" method="POST">
                     <div class="row">
                        <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                           <label>Seleccionar programa:</label>		
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-user"></i></span>
                              </div>
                              <select name="programa" id="programa" class="form-control" data-live-search="true" required></select>
                           </div>
                        </div>
                        <div class="form-group col-xl-3 col-lg-6 col-md-12 col-12">
                           <label>Seleccionar Joranda:</label>		
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-user"></i></span>
                              </div>
                              <select name="jornada" id="jornada" class="form-control" required></select>
                           </div>
                        </div>
                        <div class="form-group col-xl-3 col-lg-6 col-md-12 col-12">
                           <label>Seleccionar Semestre:</label>		
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <span class="input-group-text"><i class="fas fa-user"></i></span>
                              </div>
                              <select name="semestre" id="semestre" class="form-control" required>
                                 <option value="">Seleccionar Semestre</option>
                                 <option value="todas">Todos los semestres</option>
                                 <option value="1">1</option>
                                 <option value="2">2</option>
                                 <option value="3">3</option>
                                 <option value="4">4</option>
                                 <option value="5">5</option>
                                 <option value="6">6</option>
                                 <option value="7">7</option>
                                 <option value="8">8</option>
                                 <option value="9">9</option>
                                 <option value="10">10</option>
                              </select>
                              <input type="submit" value="Consultar" class="btn btn-success">
                           </div>
                        </div>
                        <!--
                           <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                           	<div class="input-group">
                           		<span class="input-group-addon"><i class="fas fa-user"></i></span>
                           		<select name="periodo" id="periodo" class="form-control" required>
                           		</select>
                           		
                           	</div>
                           
                           </div>
                           -->
                     </div>
                  </form>
               </div>
               <div class="row" id="resultado">
                  <div class="alert alert-success col-xl-3 col-lg-5 col-md-6 col-12" id="cantidad"></div>
               </div>
               <div class="col-xl-12 col-lg-12 col-md-12 col-12" id="mapa">
                  <div id="map"></div>
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



<script type="text/javascript" src="scripts/geolocalizacion.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-9GbQKtTGVtTsUJiUfMwFfbsB0hN8UGw&callback" async defer></script>  

<?php
}
	ob_end_flush();
?>