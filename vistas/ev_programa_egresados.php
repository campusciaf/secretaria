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
               <h1 class="m-0"><small id="nombre_programa"></small>Encuesta Egresados </h1>
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
      <div class="row mx-0">
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card card-primary" style="padding: 2% 1%">				
				<div class="panel-body table-responsive" id="listadoregistros">
					<table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <th>Credencial</th>
                            <th>Identificación</th>
                            <th>Docente</th>
                            <th>Correo CIAF</th>
                            <th>Correo personal</th>
                            <th>1. ¿Consideras que lo que aprendes en tu programa está alineado con las necesidades y demandas reales del mercado, tanto a nivel local como nacional?</th>
                            <th>2. ¿Tu programa impulsa proyectos que se vinculan con empresas, instituciones u organizaciones sociales de la región y que realmente aportan a su desarrollo?</th>
                            <th>3. ¿Estarías interesado(a) en cursar un posgrado con CIAF en los próximos 12–24 meses?</th>
                            <th>4. ¿Qué posgrado te gustaría cursar con CIAF?</th>
                            <th>5. Pensando en tu disponibilidad, ¿Qué modalidad preferirías para un posgrado?:</th>
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

<script type="text/javascript" src="scripts/ev_programa_egresados.js"></script>
<?php
}
	ob_end_flush();
?>
<script>

</script>
