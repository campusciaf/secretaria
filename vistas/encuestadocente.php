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
$menu=16;
$submenu=1600;
require 'header.php';
		if ($_SESSION['encuestadocente']==1)
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
               <h1 class="m-0"><small id="nombre_programa"></small>Encuesta Docente </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active">Gestión encuesta</li>
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
						<th>Usuario</th>
						<th>Docente</th>
						<th>Telefono</th>
						<th>Correo</th>
						<th>¿Cómo docente diseñé estrategias que le permitieron construir el autoaprendizaje a los estudiantes. Dadas las circunstancias actuales el aprendizaje es autónomo en su mayoría?</th>
						<th>¿Como docente adecué los contenidos y estrategias a los medios remotos para la orientación de clase?</th>
						<th>¿Cómo docente utilicé el MEET, sus complementos, y otras plataformas tecnológicas.?</th>
						<th>¿Como docente establecí relaciones amables y cordiales con estudiantes y compañeros de CIAF?</th>
						<th>¿Cómo docente empaticé con los estudiantes?</th>
					  </thead>
					  <tbody>                            
					  </tbody>
					</table>
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

<script type="text/javascript" src="scripts/encuestadocente.js"></script>
<?php
}
	ob_end_flush();
?>
<script>

</script>
