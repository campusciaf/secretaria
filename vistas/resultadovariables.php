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
$submenu=1301;
require 'header.php';

if ($_SESSION['resultadovariables']==1)
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
               <h1 class="m-0"><small id="nombre_programa"></small>Resultados Caracterización</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión resultados</li>
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
               <div class="box-header with-border">
                  <div class="row">
                     <div class="col-12" id="botones"></div>
                     <!--  div para traer los botones-->
                  </div>
               </div>
               <div id="resultadolistarvariable" style="overflow: hidden"></div>
               <div class="panel-body" id="formularioregistros" style="display: block">
                  <form name="formulario" id="formulario" method="POST">
                     <input type="hidden" name="id_categoria" id="id_categoria" value="">
                     <input type="hidden" name="id_tipo_pregunta" id="id_tipo_pregunta" value="">
                     <div id="preguntas"></div>
                     <div class="alert col-lg-12 col-md-12 col-sm-12 col-xs-12">        
                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar y Continuar</button>
                     </div>
                  </form>
               </div>
               <!--Fin centro -->
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
<!-- Modal que contiene el resultado de listado estudiantes-->
<div class="modal" id="myModalEstudiantes">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">Listado de Estudiantes</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <table id="tbllistado" class="table table-striped table-condensed table-hover table-responsive " style="width: 100%;">
               <thead>
                  <th>Credencial</th>
                  <th>Identificación</th>
                  <th>Nombre</th>
                  <th>Sexo</th>
                  <th>Edad</th>
                  <th>Celular</th>
                  <th>Email P.</th>
                  <th>Email CIAF</th>
                  <th>Periodo</th>
               </thead>
               <tbody>                            
               </tbody>
            </table>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
         </div>
      </div>
   </div>
</div>
<!--****************************-->



<?php
}
	else
	{
	  require 'noacceso.php';
	}	
require 'footer.php';
?>
<script src="scripts/resultadovariables.js"></script>

<?php
}
	ob_end_flush();
?>