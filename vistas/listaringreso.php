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
	$submenu=2202;
    require 'header.php';
	if ($_SESSION['listaringreso'])
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
               <h1 class="m-0"><small id="nombre_programa"></small>Listar Ingresos</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión ingresos</li>
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
                        <div class="col-md-12">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" value="0" onclick="buscar(this.value)" class="btn btn-primary">Vistantes</button>
                                <button type="button" value="1" onclick="buscar(this.value)" class="btn btn-success">Estudiantes</button>
                                <button type="button" value="2" onclick="buscar(this.value)" class="btn btn-danger">Docentes</button>
                                <button type="button" value="3" onclick="buscar(this.value)" class="btn btn-warning">Adminstrativos</button>
                            </div>
                        </div> <br>
                        <div class="col-md-12 tbl_registros"></div>
            </div>
            <!-- /.box -->
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

<script type="text/javascript" src="scripts/listaringreso.js?001"></script>
<?php
}
	ob_end_flush();
?>