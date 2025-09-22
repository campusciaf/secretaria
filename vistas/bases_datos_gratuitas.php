<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
	header("Location: login.html");
} else {
	require 'header_docente.php';
?>
	<link rel="stylesheet" type="text/css" href="../public/css/biblioteca.css">
	<!--Contenido-->
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Main content -->
		<section class="content" style="padding-top: 0px;">
			<!--Fondo de la vista -->
			<div class="row">
				<div class="col-md-12">
					<div class="fondo_stamp col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: -20px;">
						<div class="alert col-xs-12 col-sm-12 col-md-4 col-lg-4 logo_3_0" style="background-color: rgba(201,201,201,0.4); border-radius: 4px;">
							<p class="text-center" style="font-size:30px; color: #fff; font-weight: bolder;">Biblioteca CIAF</p>
						</div>
						<!-- Botones -->
						<div class="btn-group alert col-xs-12 col-sm-12 col-md-8 col-lg-8">
							<div style="text-align: right">
								<a class="btn btn-primary col-xs-12 col-sm-12 col-md-12 col-lg-3" href="bibliotecaciaf.php" ; style="text-decoration: none;">
									<i class="fas fa-eye"></i> Biblioteca</a>
								<a href="e-libro.php" class="btn btn-warning col-xs-12 col-sm-12 col-md-4 col-lg-3 d-none">
									<img src="../public/img/imagenes/e-libro.png" width="20px"> E-LIBRO</a>
								<a href="software_libre.php" class="btn btn-success col-xs-12 col-sm-12 col-md-4 col-lg-3">
									<i class="fas fa-desktop"></i> Software Libre</a>
								<a href="bases_datos_gratuitas.php" class="btn btn-danger col-xs-12 col-sm-12 col-md-4 col-lg-3">
									<i class="fas fa-database"></i> Bases de Datos</a>
							</div>
						</div>
						<style>
							a:hover {
								text-decoration: none;
							}

							a:link {
								text-decoration: none;
							}

							a:visited {
								text-decoration: none;
							}

							a:active {
								text-decoration: none;
							}
						</style>
						<!-- Final fondo stamp -->
					</div>
				</div>
			</div>
			<div class="row contenido_libre">
			</div>
		</section>
	</div><!-- /.content-wrapper -->
	<!--Fin-Contenido-->
	<?php
	require 'footer.php';
	?>
	<script src="scripts/basesdatosgratuitas.js"></script>
	<!-- Page specific script -->
<?php
}
ob_end_flush();
?>