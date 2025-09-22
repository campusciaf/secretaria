<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
	header("Location: login.html");
} else {
	$menu = 3;
	require 'header_docente.php';
?>
	<link rel="stylesheet" type="text/css" href="../public/css/biblioteca.css">
	<div class="content-wrapper">
		<!-- Main content -->
		<section class="content" style="padding-top: 0px;">
			<div class="fondo_stamp row" style="padding: 2% 0%">
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 logo_3_0" style="background-color: rgba(201,201,201,0.4); border-radius: 4px;">
					<p class="text-center" style="font-size:30px; color: #fff; font-weight: bolder;"> Biblioteca CIAF </p>
				</div>
				<!-- Botones -->
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
					<div class="btn-group " style="text-align: right">
						<a class="btn bg-olive" href="bibliotecaciaf.php" style="text-decoration: none;"> <i class="fas fa-eye"></i> Biblioteca</a>
						<a href="https://elibro.net/es/lc/ciaf/inicio/" target="_blank" class="btn bg-olive d-none"> <img src="../public/img/e-libro.png" width="20px"> E-LIBRO</a>
						<a href="software_libre.php" class="btn bg-olive"> <i class="fas fa-desktop"></i> Software Libre </a>
					</div>
				</div>
				<div class="alert col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="text-center">
						<h1 style="font-size:40px; color:#fff"><strong>LLEVA TODA TU BIBLIOTECA </strong></h1>
						<h2 style="color:#fff">EN UN SOLO BOLSILLO</h2>
					</div>
				</div>
				<div class="alert col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<form action="#" method="post" id="busqueda_libro">
						<div class="input-group col-xs-12 col-sm-12 col-md-12 col-lg-6 centrar_campo" style="margin: 0px auto;">
							<span class="input-group-addon"><i class="fas fa-book-open fa-2x"></i></span>
							<input type="text" id="busquedad" name="busquedad" required="required" pattern="[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Solo se permiten letras y números, estos caracteres no son permitidos < > = , ; * # $" placeholder="Titulo, Autor, Palabra clave o ISBN" class="form-control input-lg" />
							<span class="input-group-btn">
								<button id="comenzar_busqueda" class="btn btn-success btn-lg">Buscar</button>
							</span>
						</div>
					</form>
				</div>
				<!-- Final fondo stamp -->
			</div>
			<div class="barra-libros row" style="background-color: #000; overflow: hidden; border-radius: 0px; border-top: 8px solid #000; padding: 0px">
				<div class="alert col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px; ">
					<div class="marquee">
						<?php
						$p = 0;
						$pic = 0;
						$archivo = 10;
						echo "<p class='row'>";
						while ($pic < 12) {
							echo "<span class='col-xs-3 col-sm-3 col-md-1 col-lg-1' style='margin:0px; padding:0px'>";
							echo "<a href='#'> <img src='../public/img/biblioteca/$archivo.jpg'></a>";
							echo "</span>";
							$pic++;
							$archivo++;
						}
						echo "</p>";
						echo "<p class='row'>";
						while ($pic < 24) {
							echo "<span class='col-xs-3 col-sm-3 col-md-1 col-lg-1' style='margin:0px; padding:0px'>";
							echo "<a href='#'> <img src='../public/img/biblioteca/$archivo.jpg'></a>";
							echo "</span>";
							$pic++;
							$archivo++;
						}
						echo "</p>";
						echo "<p class='row'>";
						while ($pic < 36) {
							echo "<span class='col-xs-3 col-sm-3 col-md-1 col-lg-1' style='margin:0px; padding:0px'>";
							echo "<a href='#'> <img src='../public/img/biblioteca/$archivo.jpg'></a>";
							echo "</span>";
							$pic++;
							$archivo++;
						}
						echo "</p>";
						?>
					</div>
				</div>
			</div>
			<div class="row text-center" style="background-color: #000; border-radius: 0px; padding: 0px; margin: 0px">
				<button type="button" class="white btn btn-link btn-lg">
					<i class="fas fa-angle-down fa-1x fa-spin"></i> Mas Libros
				</button>
			</div>
			<div id="demo" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="contenido_libre row">
				</div>
			</div>
		</section>
	</div><!-- /.content-wrapper -->
	</div>
	<?php
	require 'footer_docente.php';
	?>
	<script src="scripts/bibliotecaciaf.js"></script>
<?php
}
ob_end_flush();
?>