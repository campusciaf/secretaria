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
$submenu=1308;
require 'header.php';
	if ($_SESSION['convergeopostal']==1)
	{
?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-9GbQKtTGVtTsUJiUfMwFfbsB0hN8UGw&callback&sensor=false" async defer></script> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

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
               <h1 class="m-0"><small id="nombre_programa"></small>Conversión </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión conversión</li>
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
				   <section class="cuerpo">
					<div style="text-align:center;">
					  <h4 style="margin: 0;padding: 0px;">Dirección a localizar con código postal en resultado</h4>
					  Escriba la dirección (texto) o coordenadas lat,lng separadas por coma (,):
					  <br>
					  <input id="address" type="textbox" size="38" maxlength="80" value="" placeholder="Dirección o Lat, Lng" />
					  <br> Latitud: <span style="color:#FF00AA;" id="x"></span>
					  <br> Longitud: <span style="color:#FF00AA;" id="y"></span>
					  <br> Dirección completa:
					  <br><span style="color:#FF00AA;" id="direccion"></span>
					  <h4> Código postal: <span style="color:#FF00AA;" id="CP"></span></h4>
					  <input type="button" class="button" value="Localizar" onclick="codeAddress()"> </div>
				  <div id="mapa"></div>
				  </section>
				  <div style="clear:both;"></div>                 
                      
                      
            
                      
           
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
<script type="text/javascript" src="scripts/convergeopostal.js"></script>



<?php
}
	ob_end_flush();
?>