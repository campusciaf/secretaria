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
$submenu=1303;
require 'header.php';

	if ($_SESSION['verificarcaracterizacion']==1)
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
               <h1 class="m-0"><small id="nombre_programa"></small>Verificar Caracterización </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión verificar</li>
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
               <div class="panel-body table-responsive" id="listadoregistros">
                  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                     <thead>
                        <th>Opciones</th>
                        <th>Identificación</th>
                        <th>Estudiante</th>
                        <th>Celular</th>
                        <th>Correo</th>
                        <th>Fecha Presentación</th>
                        <th>Periodo</th>
                     </thead>
                     <tbody>                            
                     </tbody>
                  </table>
               </div>
               <div class="panel-body" style="height: 400px;" id="formularioregistros">
                  <form name="formulario" id="formulario" method="POST">
                     <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label>Nombre:</label>
                        <input type="hidden" name="id_ejes" id="id_ejes">
                        <input type="text" class="form-control" name="nombre_ejes" id="nombre_ejes" maxlength="50" placeholder="Nombre del Eje" required>
                     </div>
                     <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label>Periodo:</label>
                        <select class="form-control" name="periodo" id="periodo" required>
                           <option value="2019-1" name="2019-1">2019-1</option>
                        </select>
                     </div>
                     <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label>Objetivo:</label>
                        <textarea class="form-control" name="objetivo" id="objetivo" rows="10" required>	
                        </textarea>
                     </div>
                     <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                        <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                     </div>
                  </form>
               </div>
               <!--Fin centro -->
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

<script type="text/javascript" src="scripts/verificarcaracterizacion.js"></script>

<?php
}
	ob_end_flush();
?>
