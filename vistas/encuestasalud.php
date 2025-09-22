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
	$menu=22;
	$submenu=2200;
    require 'header.php';
	if ($_SESSION['usuario_nombre'])
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
               <h1 class="m-0"><small id="nombre_programa"></small>ENCUESTA DE CONDICONES DE SALUD</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión salud</li>
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
               <form method="POST" id="form_encuesta">
                  <div class="row">
                     <div class="form-group col-xl-2 col-lg-2 col-md-6 col-6">
                        <label for="exampleFormControlSelect1">Tipo</label>
                        <select class="form-control tipo" name="tipo" onchange="limpiar()" id="exampleFormControlSelect1">
                           <option selected value="1">Estudiante</option>
                           <option value="2">Docente</option>
                           <option value="3">Administrativo</option>
                        </select>
                     </div>
                     <div class="form-group col-xl-4 col-lg-4 col-md-6 col-6">
                        <label>Código QR</label>
                        <input type="text" class="form-control" id="identifica" onChange=buscar(this.value); autocomplete="off" required placeholder="Código QR">
                     </div>
                  </div>
                  <div class="col-md-12" id="info_estudi"></div>
                  <div class="col-md-12" id="formulario">
                     <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="conte2"></div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" id="conte3"></div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" id="conte4"></div>
                        <div class="col-md-12 text-center">
                           <button type="submit" class="btn btn-success btn-lg">Registrar</button>
                        </div>
                     </div>
                  </div>
               </form>
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
	  
<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/encuestasalud.js"></script>
<?php
}
	ob_end_flush();
?>