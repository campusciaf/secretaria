<?php
ob_start();

require_once "../modelos/Docente.php";
$docente=new Docente();// no se inicia session en este archivo porque esta dentro del modelo.

if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: login.html");
}
else
{
	$menu=1;
require 'header_docente.php';
if (!empty($_SESSION['id_usuario']))
	{
	

?>

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
		  
		  <section class="content-header">
			  <h1>
				Programa
				<small id="nombre_programa"></small>
			  </h1>
			  <ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="#">Tables</a></li>
				<li class="active">Data tables</li>
			  </ol>
			</section>

			
		  
        <section class="content">

			
			<div class="row">
				<div class="box">
					<div class="box-body">
						<div class="col-md-12">
							
						  <div id="tbllistado"></div>
						  <div id="tllistado"></div>
						
						</div>
					</div>
				</div>
			</div>
		  <!-- /.row -->
		</section>

		<!-- Modal registrar falta -->
		<div class="modal fade" id="modalFaltas" data-backdrop="static" tabindex="-1" role="dialog"
			aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<input type="hidden" id="ciclo">
						<input type="hidden" id="id_estudiante">
						<input type="hidden" id="id_programa">
						<input type="hidden" id="id_materia">
						
							<div class="form-group">
								<label for="exampleInputEmail1">Fecha de la falta:</label>
								<input type="date" class="form-control" id="fecha" aria-describedby="emailHelp" required>
								<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
									else.</small>
							</div>
							<button type="submit" onclick="registraFalta()" class="btn btn-success">Registrar falta</button>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal listar reportes -->

		<div class="modal fade" id="modalReportes" role="dialog">
			<div class="modal-dialog modal-lg">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Vista Previa</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body prueba">
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal enviar correo -->
		<div class="modal fade" id="modalEmail" data-backdrop="static" tabindex="-1" role="dialog"
			aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">Correo</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="exampleFormControlTextarea1">Contenido email</label>
							<textarea class="form-control" id="conteMail" rows="3" required></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						<button id="enviarEmail" class="btn btn-success">Enviar</button>
					</div>
				</div>
			</div>
		</div>

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>


<script type="text/javascript" src="scripts/docente.js?001"></script>
<?php 
$id_docente = isset($_GET["id"])?$_GET["id"]:""; 
if(!empty($id_docente)){
	$materia=$_GET["materia"];
	$ciclo=$_GET["ciclo"];
	$jornada=$_GET["jornada"];
	$id_programa=$_GET["id_programa"];
	$grupo=$_GET["grupo"];
	
	$rspta2 = $docente->programaacademico($id_programa);
	
	echo "<script>listar('$id_docente','".$ciclo."','".$materia."','".$jornada."','".$id_programa."','$grupo');</script>";
	echo "<script>
		$('#nombre_programa').html('".$rspta2["nombre"]." | <u>".$materia."</u>');
	</script>";
} 
?>



<?php
}
	ob_end_flush();
?>


