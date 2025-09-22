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
						<th>3. ¿Consideras que el currículo de tu programa te forma de manera integral, combinando conocimientos, habilidades y valores para tu vida profesional y personal?</th>
                  <th>4. ¿Consideras que los métodos de enseñanza que utilizas en clase están en sintonía con las estrategias de evaluación que aplicas? ¿Ambos contribuyen de forma coherente a alcanzar los resultados de aprendizaje del curso?</th>
                  <th>5. ¿Crees que tu programa cuenta con suficientes docentes, bien formados y comprometidos con su labor, para garantizar un buen desarrollo académico?</th>
                  <th>6. ¿Consideras que los criterios que utiliza la institución para asignar las labores académicas (como clases, asesorías o proyectos) a los docentes son adecuados y están alineados con su perfil profesional y forma de contratación?</th>
                  <th>7. ¿Consideras que las políticas y estrategias de selección, formación y permanencia de los docentes permiten que tengamos docentes estables y en constante desarrollo?</th>
                  <th>8. ¿Consideras que los estímulos y beneficios que otorga la institución a los docentes son claros, transparentes y realmente ayudan a fortalecer su permanencia?</th>
                  <th>9. ¿Conoces los programas, estrategias o espacios que ofrece CIAF para apoyar tu desarrollo profesional y académico como docente?</th>
                  <th>10. ¿Consideras que las oportunidades de formación y las estrategias de bienestar que brinda la institución contribuyen con tu desarrollo integral en el ejercicio de tu rol dentro de la comunidad académica?</th>
                  <th>11. ¿Sientes que tu desarrollo profesional y humano como docente ha tenido un impacto positivo en la calidad del programa académico al que estás vinculado?</th>
                  <th>12. ¿Consideras que los criterios y mecanismos con los que se evalúa a los docentes son claros, transparentes y aplicados con equidad?</th>
                  <th>13. ¿Crees que los mecanismos de evaluación docente son eficaces, es decir, que se aplican, cumplen su propósito y realmente ayudan a mejorar tu labor académica?</th>
                  <th>14. ¿Sientes que los espacios prácticos (talleres, laboratorios, escenarios) del programa son adecuados y tienen capacidad suficiente para las actividades que realizas?</th>
                  <th>15. ¿Consideras que los espacios de práctica del programa están bien dotados y cuentan con los recursos necesarios para tus actividades académicas?</th>
                  <th>16. ¿Los recursos físicos y tecnológicos del programa (como salas, computadores, plataformas, conexión) son suficientes y útiles para tus actividades académicas?</th>
                  <th>17. ¿Consideras factible lograr los resultados de aprendizaje de tus asignaturas en este esquema, manteniendo estándares de calidad y una carga docente manejable?</th>
                  <th>18. ¿Consideras factible lograr los resultados de aprendizaje de tus asignaturas en esta modalidad?</th>
                  <th>19. ¿Consideras factible alcanzar los resultados de aprendizaje con un plan de 9 semestres sin comprometer la calidad?</th>
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

<script type="text/javascript" src="scripts/ev_programa_docente.js"></script>
<?php
}
	ob_end_flush();
?>
<script>

</script>
