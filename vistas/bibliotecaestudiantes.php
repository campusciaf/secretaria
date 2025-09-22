<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
	header("Location: ../");
} else {
	$menu = 2;
	require 'header_estudiante.php';
?>
	<link rel="stylesheet" type="text/css" href="../public/css/biblioteca.css?<?= date("Y-m-d H") ?>">
	<div class="content-wrapper ">
		<section class="content bg-black">
			<div class="row m-0 p-0">
				<div class="col-12 fondo_stamp p-0">
					<div class="row">

						<div class="col-xl-12 p-4 mt-4" >
							<h2 class="text-white fs-36" ><i class="fa-solid fa-bookmark text-primary"></i> Biblioteca CIAF</h2>
						</div>
			

						<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-4 mt-4">
							<div class="text-center">
								<h1 style="font-size:40px; color:#fff"><strong>LLEVA TODA TU BIBLIOTECA </strong></h1>
								<h2 style="color:#fff">EN UN SOLO BOLSILLO</h2>
							</div>
						</div>
						<div class="alert col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<form action="#" method="post" id="busqueda_libro">
								<div class="input-group col-xs-12 col-sm-12 col-md-12 col-lg-6 centrar_campo" style="margin: 0px auto;">
									<span class="input-group-text rounded-0"><i class="fas fa-book-open"></i></span>
									<input type="text" id="busquedad" name="busquedad" required="required" pattern="[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Solo se permiten letras y números, estos caracteres no son permitidos < > = , ; * # $" placeholder="Titulo, Autor, Palabra clave o ISBN" class="form-control " />
									<span class="input-group-text p-0 m-0 rounded-0">
										<button id="comenzar_busqueda" class="btn bg-olive rounded-0 m-0">Buscar</button>
									</span>
								</div>
							</form>
						</div>
					</div>
					<!-- Final fondo stamp -->
				
					<div class="barra-libros col-12 p-4 mt-4" style=" border-radius: 0px; padding: 0px; margin-bottom: 150px; height: 135px;">
						<div class="alert col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px; margin: 0px">
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
				
					<div class="d-none col-12 m-0 text-center" style="background-color: #000; border-radius: 0px; padding: 0px; margin: 0px">
						<button type="button" class="white btn bg-link text-white btn-lg">
							<i class="fas fa-angle-down fa-1x fa-spin"></i> Mas Libros
						</button>
					</div>

					<div class="default-ltr-cache-dulgtd col-12">
						<div class="curve-container">
							<div class="default-ltr-cache-1f97ztc"></div>
						</div>
						<div class="default-ltr-cache-jtcpfi col-12"></div>
					</div>

				</div>

				<div class="col-xl-6 col-lg-6 col-md-6 col-7 px-4 ">
			
					<div class="row">
						<div class="p-2">
							<div class="row  ">
								<div class="col-auto">
									<div class="avatar avatar-50 rounded bg-light-blue">
									<i class="fa-solid fa-book text-primary fa-2x"></i>
									</div>
								</div>
								<div class="col-auto pt-2">
									<p class="small text-secondary mb-0">Titulos</p>
									<h4 class="fw-medium">Disponibles</h4>
								</div>
							</div>
						</div>
					</div>

				</div>

				

				<div id="demo" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-4">
					<div class="contenido_libre row">
					</div>
				</div>
		</section>
	</div><!-- /.content-wrapper -->
	<!--Fin-Contenido-->
	<?php
	require 'footer_estudiante.php';
	?>
	<script src="scripts/bibliotecaestudiantes.js"></script>
<?php
}
ob_end_flush();
?>