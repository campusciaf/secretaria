<?php
if (strlen(session_id()) < 1) session_start();
echo (!$_SERVER['HTTP_REFERER']) ? "<script language='javascript'>window.location='../index.php'</script>" : "";
require_once "../modelos/Usuario.php";
$usuario = new Usuario();
$valor_estado = $usuario->consultar_Estado_Estudiante($_SESSION["credencial_identificacion"]);
$estado_ciafi = (empty($valor_estado)) ? 1 : $valor_estado['estado_ciafi'];
$estado_veedor = $usuario->consultar_Estado_Veedor($_SESSION["id_usuario"]);
$estado_veedor = (empty($estado_veedor)) ? 0 : $estado_veedor['estado'];
?>
<!DOCTYPE html>
<html>

<head>
	<title>CIAFI | Académico</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" href="../public/favicon/favicon-16x16.png" type="image/x-icon">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="../public/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="../public/css/font-awesome.min.css" />
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet" href="../public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="../public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- JQVMap -->
	<link rel="stylesheet" href="../public/plugins/jqvmap/jqvmap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../public/dist/css/adminlte.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="../public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="../public/plugins/daterangepicker/daterangepicker.css">
	<!-- summernote -->
	<link rel="stylesheet" href="../public/plugins/summernote/summernote-bs4.css">
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="../public/css/_all-skins.min.css">
	<!-- DATATABLES -->
	<link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
	<link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet" />
	<link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet" />
	<!--selectpiker-->
	<link rel="stylesheet" href="../public/plugins/bootstrap/bootstrap-select.min.css">
	<!-- jQuery Alertify -->
	<link rel="stylesheet" href="../public/alertify/css/themes/default.css" />
	<link rel="stylesheet" href="../public/alertify/css/alertify.min.css" />
	<script src="../public/alertify/alertify.min.js"></script>
	<script src="../public/ckeditor/ckeditor.js"></script>
	<!-- <script src="../public/ckeditor/samples/js/sample.js"></script> -->
	<link href="../public/plugins/bootstrap/bootstrap-datetimepicker.css" rel="stylesheet">
	<!-- *********** SweetAlert2 ***** -->
	<script src="../public/plugins/sweetalert2@11.js"></script>
	<!-- ********************** -->
	<!-- * *************** slick ******************* -->
	<!-- Add the slick-theme.css if you want default styling -->
	<link rel="stylesheet" type="text/css" href="../public/plugins/slick.css" />
	<!-- Add the slick-theme.css if you want default styling -->
	<link rel="stylesheet" type="text/css" href="../public/plugins/slick-theme.css" />
	<!-- Incluir Dropzone CSS -->
	<link href="../public/plugins/dropzone.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../public/plugins/introjs.css"><!-- estilos del tour -->
	<link rel="stylesheet" href="../public/css/estilos.css"><!-- estos son propios -->
</head>
<?php
if (file_exists('../files/estudiantes/' . $_SESSION['usuario_imagen'] . '.jpg')) {
	$foto = '<img src="../files/estudiantes/' . $_SESSION['usuario_imagen'] . '.jpg?' . date("Y-m-d H:i:s") . '" class="img-circle elevation-2" alt="Usuario" style="width:50px;height:50px">';
	$foto2 = '<img src="../files/estudiantes/' . $_SESSION['usuario_imagen'] . '.jpg?' . date("Y-m-d H:i:s") . '" class="img-circle elevation-2" alt="Usuario" style="width:30px;height:30px">';
} else {
	$foto = '<img src=../files/null.jpg width=50px height=50px class="img-circle elevation-2" alt="Usuario" style="width:50px;height:50px">';
	$foto2 = '<img src=../files/null.jpg  class="rounded-circle" alt="Usuario" style="width:36px;height:30px">';
}
?>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
	<div class="wrapper">
		<nav class="main-header navbar navbar-expand navbar-light nav-compact fixed-top cabecera">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
			</ul>
			<!-- Right navbar links -->
			<ul class="navbar-nav">
				<li class="breadcrumb-item active" aria-current="page"><a href="panel_estudiante.php" class="btn-link text-3">Inicio</a></li>
				<li class="breadcrumb-item d-none"><a href="#" style="color: var(--color-fuente);"><?= isset($seccion) ? $seccion : "" ?></a></li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown d-none" id="t-paso12">
					<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
						<i class="fas fa-qrcode"></i>
						<span class="badge badge-danger navbar-badge">QR</span>
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
						<a href="#" class="dropdown-item">
							<!-- Message Start -->
							<div class="media col-12">
								<div class="col-md-12" id="codigo"></div>
							</div>
							<!-- Message End -->
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item dropdown-footer">Codigo QR</a>
					</div>
				</li>
				<li class="nav-item dropdown " id="t-paso26">
					<a class="nav-link" href="perestudiante.php" title="Personalizar cuenta">
						<img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:25px;height:20px">
						<span class="text-danger font-weight-bolder" id="mispuntos"></span>
						<span class="text-danger font-weight-bolder">pts</span>
					</a>
				</li>
			</ul>
			<div class="nav-item">
				<div class="dropdown dropdown-toggle  p-1 rounded mr-1" id="m-paso26">
					<a class="pointer" data-toggle="dropdown" aria-expanded="false" title="Configurar Cuenta">
						<?php echo $foto2; ?> <?php echo $_SESSION['usuario_nombre']; ?>
					</a>
					<div class="dropdown-menu">
						<a class="btn btn-block text-left " href="configurarcuentaestudiante.php">
							<i class="fa-regular fa-user color-icono mr-2"></i> Mi Perfil
						</a>
						<a class="btn btn-block text-left " href="micarnet.php">
							<i class="fa-regular fa-address-card"></i> Mi carnet
						</a>
						<a class="btn btn-block text-left" href="perestudiante.php">
							<i class="fa-solid fa-arrow-up-right-from-square color-icono mr-2"></i> Personalizar
						</a>
						<div class="col-md-12" id="codigo"></div>
						<div class="dropdown-divider"></div>
						<a class="btn btn-block text-left" href="../controlador/usuario.php?op=salir">
							<i class="fa-solid fa-power-off color-icono mr-2"></i> Salir
						</a>
					</div>

				</div>
				<!-- <a href="../controlador/usuario.php?op=salir" class="nav-link" id="t-paso13">
					<i class="fa-solid fa-power-off" style="font-size:20px"></i>
				</a> -->
			</div>
		</nav>
		<aside class="main-sidebar sidebar-dark-primary elevation-1">



			


			<!-- Brand Logo -->
			<a href="panel_estudiante.php" class="brand-link pb-0 text-center">
				<div class="animadologo d-xl-block d-lg-block d-md-none d-none"><div class="iconologo"></div><img src="../public/img/iconologo.gif"></div>
				<!-- <img src="../public/img/i_ciafi.webp" alt="campus" class="brand-image"> -->
				<span class="text-white font-weight-bolder fs-20"><b>CIAF Virtual</b></span>
			</a>
			<!-- Sidebar -->
			<div class="sidebar">
				<nav class="mt-2">
					<!-- configurar cuenta  -->
					<div class="row usuario-nav">
						<div class="col-12 text-center py-2">
							<?php echo $foto; ?>
						</div>
						<div class="col-12 text-center pt-2 text-white font-weight-bolder fs-14">
							<?php echo $_SESSION['usuario_nombre'] . " " . $_SESSION['usuario_apellido']; ?>
						</div>
						<div class="col-12 text-center line-height-16 border-bottom pb-2">
							<h2 id="miprograma" class="fs-18  text-secondary line-height-16"></h2>
						</div>
						<div class="col-12 text-center pt-2 text-white">
							<i class="fa-brands fa-facebook fs-20 mx-2"></i>
							<i class="fa-brands fa-instagram fs-20 mx-2"></i>
							<i class="fa-brands fa-whatsapp fs-20 mx-2"></i>
						</div>
					</div>
					<!-- Navegación  -->
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<?php if ($menu == 0) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<!-- <li class="nav-item " id="m-paso8">
							<a href="panel_estudiante.php" class="nav-link <?php echo $activado; ?>">
								<i class="fa-solid fa-house"></i>
								<p>Inicio</p>
							</a>
						</li> -->
						<?php if ($menu == 16) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<li class="nav-item " id="m-paso8">
							<a href="configurarcuentaestudiante.php" class="nav-link <?php echo $activado; ?>">
								<i class="fa-solid fa-gear"></i>
								<p>Mi perfil</p>
							</a>
						</li>
						<?php if ($menu == 14) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<!-- <li class="nav-item " id="m-paso8">
							<a href="dashboardest.php" class="nav-link <?php echo $activado; ?>">
								<i class="fa-solid fa-chart-simple"></i>
								<p>Tablero</p>
							</a>
						</li> -->
						<?php if ($menu == 15) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<!-- <li class="nav-item " id="m-paso12">
							<a href="mihorario.php" class="nav-link <?php echo $activado; ?>">
								<i class="fa-solid fa-calendar-days"></i>
								<p>Horario de clases</p>
							</a>
						</li> -->
						<!-- programas  -->
						<?php if ($menu == 1) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}
						?>
						<?php
						if ($estado_ciafi == 1) {
						?>
							<li class="nav-item has-treeview <?php echo $abierto; ?>" id="m-paso1">
								<a href="#" class="nav-link <?php echo $activado; ?>">
									<i class="fa-solid fa-school-flag"></i>
									<p>
										Mi programa
										<i class="fas fa-angle-left right"></i>
										<!-- <span class="badge badge-success right" id="cantidad_titu"></span> -->
									</p>
								</a>
								<ul class="nav nav-treeview <?php echo $abierto; ?> progra-estudiantes">

									<!-- <li class="nav-item" id="contenido"></li> -->
									<li class="nav-item" id="m-paso4">
										<a href="estudiante.php" class="nav-link ">
											<p>Plan de estudios y calendario</p>
										</a>
									</li>
									<li class="nav-item" id="m-paso4">
										<a href="historialacademico.php" class="nav-link ">
											<p>Historial Académico</p>
										</a>
									</li>
									<li class="nav-item" id="m-paso5">
										<a href="micertificado.php" class="nav-link ">
											<p>Mis Certificados</p>
										</a>
									</li>
								</ul>
							</li>
						<?php } ?>
						<!-- **********************************  -->
						<!-- Recursos digitales  -->
						<?php if ($menu == 2) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<li class="nav-item has-treeview <?php echo $abierto; ?>" id="m-paso2">
							<a href="#" class="nav-link <?php echo $activado; ?>">
								<i class="fa-solid fa-globe"></i>
								<p>Mis medios educativos <i class="right fas fa-angle-left"></i></p>
							</a>
							<ul class="nav nav-treeview <?php echo $abierto; ?>">
								<li class="nav-item d-none">
									<a href="bibliotecaestudiantes.php" class="nav-link">
										<p>Biblioteca</p>
									</a>
								</li>
								<li class="nav-item ">
									<a href="https://elibro.net/es/lc/ciaf/inicio" target="_blank" class="nav-link">
										<p>E-libro</p>
									</a>
								</li>
								<li class="nav-item d-none">
									<a href="https://elibro.net/es/lc/ciafecoe/inicio " target="_blank" class="nav-link">
										<p>Biblioteca Digital ECOE</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="caja_herramientas_estudiantes.php" class="nav-link">
										<p>Herramientas Digitales</p>
									</a>
								</li>

							</ul>
						</li>
						<!-- **********************************  -->
						<!-- Caracterización  -->
						<?php if ($menu == 115) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<li class="d-none nav-item has-treeview <?php echo $abierto; ?>" id="m-paso2">
							<a href="#" class="nav-link <?php echo $activado; ?>">
								<i class="fa-solid fa-globe"></i>
								<p>Caracterización<i class="right fas fa-angle-left"></i></p>
							</a>
							<ul class="nav nav-treeview <?php echo $abierto; ?>">
								<li class="nav-item">
									<a href="carseresoriginales.php" class="nav-link">
										<p><span id="carseres"></span>Seres originales</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="carinspiradores.php" class="nav-link">
										<p><span id="carins"></span>Inspiradores</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="carempresas.php" class="nav-link">
										<p><span id="carempresas"></span>Empresas Amigas</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="carconfiamos.php" class="nav-link">
										<p><span id="carconfiamos"></span>Confiamos</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="carexperiencia.php" class="nav-link">
										<p><span id="carexperiencia"></span>Experiencia académica</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="carbienestar.php" class="nav-link">
										<p><span id="carbien"></span>Modelo de bienestar</p>
									</a>
								</li>
								<!--	<li class="nav-item d-none">
										<a href="https://elibro.net/es/lc/ciafecoe/inicio " target="_blank" class="nav-link">
											<p>Empresas amigas y Spin-off</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="caja_herramientas_estudiantes.php" class="nav-link">
											<p>Confiamos</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="caja_herramientas_estudiantes.php" class="nav-link">
											<p>Experiencia Académica</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="caja_herramientas_estudiantes.php" class="nav-link">
											<p>Modelo de bienestar</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="caja_herramientas_estudiantes.php" class="nav-link">
											<p>Comunidad</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="caja_herramientas_estudiantes.php" class="nav-link">
											<p>Emprendimiento</p>
										</a>
									</li> -->
							</ul>
						</li>
						<!-- **********************************  -->
						<!-- Caracterización  -->
						<?php if ($_SESSION['status_update'] == 1) { ?>
							<?php if ($menu == 3) {
								$abierto = "menu-open";
								$activado = "active";
							} else {
								$abierto = "";
								$activado = "";
							}   ?>
							<!-- <li class="nav-item" id="m-paso3">
									<a href="caracterizacion.php" class="nav-link <?php echo $activado; ?>">
										<i class="fa-solid fa-heart-circle-check"></i>
										<p>Caracterización<span class="right badge badge-success">Yo</span></p>
									</a>
								</li> -->
						<?php } ?>
						<!-- **********************************  -->
						<!-- Renovaciones -->
						<?php if ($menu == 6) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						} ?>
						<li class="nav-item has-treeview <?php echo $abierto; ?>" id="m-paso6">
							<a href="#" class="nav-link <?php echo $activado; ?>">
								<i class="fa-solid fa-retweet"></i>
								<p>Renovar mi semestre<i class="right fas fa-angle-left"></i></p>
							</a>
							<ul class="nav nav-treeview <?php echo $abierto; ?>">
								<li class="nav-item">
									<a href="rematriculafinanciera.php" class="nav-link ">
										<p>Paga tu semestre</p>
									</a>
								</li>
								<li class="nav-item	">
									<a href="rematricula.php" class="nav-link
									">
										<p>Matricula tus asignaturas</p>
									</a>
								</li>
								<li class="nav-item d-none" id="m-paso10">
									<a href="idiomas.php" class="nav-link <?php echo $activado; ?>">
										<p>Idiomas</p>
									</a>
								</li>
							</ul>
						</li>
						<!-- Pagos varios -->
						<?php if ($menu == 11) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<li class="nav-item d-none" id="m-paso8">
							<a href="pagogeneral.php" class="nav-link <?php echo $activado; ?>">
								<i class="fa-solid fa-money-bill-transfer"></i>
								<p>Pagos generales</p>
							</a>
						</li>
						<!-- Renovaciones -->
						<?php if ($menu == 13) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						} ?>
						<li class="nav-item has-treeview <?php echo $abierto; ?>" id="m-paso6">
							<a href="#" class="nav-link <?php echo $activado; ?>">
								<i class="fas fa-money-bill-1-wave"></i>
								<p>Gestión financiera<i class="right fas fa-angle-left"></i></p>
							</a>
							<ul class="nav nav-treeview <?php echo $abierto; ?>">
								<li class="nav-item">
									<a href="financiacion.php" class="nav-link">
										<p>Pagar Crédito</p>
									</a>
								</li>
								<li class="nav-item	">
									<a href="estudiante_pagos_en_linea.php" class="nav-link ">
										<p>Otros pagos</p>
									</a>
								</li>
								<li class="nav-item d-none" id="m-paso10">
									<a href="idiomas.php" class="nav-link <?php echo $activado; ?>">
										<p>Idiomas</p>
									</a>
								</li>
							</ul>
						</li>
						<!-- Mi financiación -->
						<?php if ($menu == 13) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<li class="d-none nav-item" id="m-paso7">
							<a href="estudiante_pagos_en_linea.php" class="nav-link <?php echo $activado; ?>">
								<i class="fas fa-money-bill-1-wave"></i>
								<p>Gestión financiera</p>
							</a>
						</li>
						<!-- Mi financiación -->
						<?php if ($menu == 8) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<li class="d-none nav-item" id="m-paso7">
							<a href="financiacion.php" class="nav-link <?php echo $activado; ?>">
								<i class="fa-solid fa-hand-holding-dollar"></i>
								<p>Mi Financiación</p>
							</a>
						</li>
						<!-- Mis Certificados  -->
						<?php if ($menu == 9) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<li class="d-none nav-item" id="m-paso5">
							<a href="micertificado.php" class="nav-link <?php echo $activado; ?>">
								<i class="fa-solid fa-paperclip"></i>
								<p>Mis Certificados</p>
							</a>
						</li>
						<!-- Historial académico  -->
						<?php if ($menu == 5) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<li class="d-none nav-item" id="m-paso4">
							<a href="historialacademico.php" class="nav-link <?php echo $activado; ?>">
								<i class="fa-solid fa-list-check"></i>
								<p>¡Historial Académico!</p>
							</a>
						</li>
						<!-- Feria de emprendimiento -->
						<?php if ($menu == 12) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<li class="nav-item " id="m-paso8">
							<a href="shopping.php" class="nav-link <?php echo $activado; ?>">
								<i class="fa-solid fa-bag-shopping text-orange"></i>
								<p>Feria de Emprendimiento</p>
							</a>
						</li>
						<?php if ($estado_veedor == 1): ?>
							<li class="nav-item">
								<a href="reporte_veedor.php" class="nav-link">
									<i class="fas fa-message"></i>
									<p>Reporte veedor</p>
								</a>
							</li>
						<?php endif;
						?>
						<!-- **********************************  -->
						<?php if ($menu == 11) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<li class=" nav-item" id="m-paso9">
							<a href="estudiante_educacion_continuada.php" class="nav-link <?php echo $activado; ?>">
								<i class="fa-regular fa-address-card"></i>
								<p>
									Educación continuada
								</p>
							</a>
						</li>
						<!-- Carnet -->
						<?php if ($menu == 7) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<li class="d-none nav-item" id="m-paso9">
							<a href="micarnet.php" class="nav-link <?php echo $activado; ?>">
								<i class="fa-regular fa-address-card"></i>
								<p>
									Carnet
								</p>
							</a>
						</li>
						<!-- Carnet -->
					
						<!-- **********************************  -->
						<!-- PQRS  -->
						<?php if ($menu == 10) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<!-- PQRS  -->
						<?php if ($menu == 4) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<li class="nav-item" id="m-paso11">
							<a href="ayuda.php" class="nav-link <?php echo $activado; ?>">
								<i class="fa-solid fa-question"></i>
								<p>PQRS</p>
							</a>
						</li>

						<?php if ($menu == 17) {
							$abierto = "menu-open";
							$activado = "active";
						} else {
							$abierto = "";
							$activado = "";
						}   ?>
						<li class="nav-item" id="m-paso17">
							<a href="egresadoperfil.php" class="nav-link <?php echo $activado; ?>">
								<i class="fa-solid fa-user-graduate"></i>
								<p>Egresado</p>
							</a>
						</li>

						<!-- **********************************  -->
					</ul>
					<!-- **********************************  -->
					<div class="row justify-content-center m-0" id="nivel">
						
					</div>

				</nav>
			</div><!-- /.sidebar -->
		</aside>
		<section class="mini col-12 bg-4 d-xl-none d-lg-none d-md-none d-sm-block" style="position:fixed; bottom:0px; z-index:1">
			<div class="row justify-content-center">
				<div class="col-auto text-center">
					<a href='panel_estudiante.php' class="btn"><i class="fa-solid fa-house text-white"></i><br><span class="text-white">Inicio</span></a>
				</div>
				<div class="col-auto text-center">
					<a href='estudiante.php' class="btn"><i class="fa-solid fa-database text-white"></i><br><span class="text-white">Horario</span></a>
				</div>
				
				<div class="col-auto text-center " style="position:relative">
					<div class="row">
						<div class="col-12 bg-1 rounded-circle shadow" style="margin-top: -16px; padding:12px">
							<a href='financiacion.php' class="btn"><i class="fa-solid fa-hand-holding-dollar text-white "></i></a>
						</div>
					</div>
				</div>
				<div class="col-auto text-center">
					<a href='configurarcuentaestudiante.php' class="btn"><i class="fa-solid fa-user text-white"></i><br><span class="text-white">Perfil</span></a>
				</div>
				<div class="col-auto text-center">
					<a href='ayuda.php' class="btn"><i class="fa-solid fa-heart-pulse text-white"></i><br><span class="text-white">PQRS</span></a>
				</div>
				
			</div>
		</section>
		<!-- Modal -->
		<div class="modal fade" id="myModalEncuestaBienestar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">PARA, te necesito...</h5>
					</div>
					<div class="modal-body">
						<form name="formularioencuestauno" id="formularioencuestauno" method="POST">
							<div class="col-xl-12">
								<p><span class="titulo-1 fs-18"><b>¿Te gustaría formar parte de algo transformador?… Maravilloso. </b></span><br>
									<span class="fs-16">Opiniones como la tuya
										son voces originales y auténticas para ayudarnos a formar el futuro. Tu
										perspectiva es única, es crucial para nosotros.</span>
								</p>
								<input type="radio" name="pre1" id="pre1" value="no" onclick=mostrarcuestionario(this.value)> No estoy interesado en contribuir al mejoramiento de mi proceso de aprendizaje profesional en CIAF<br>
								<input type="radio" name="pre1" id="pre1" value="si" onclick=mostrarcuestionario(this.value)> Si estoy interesado en contribuir al mejoramiento de mi proceso de aprendizaje profesional en CIAF<br>
							</div>
							<div class="" id="pre-cuestionario" style="display:none">
								<h2>Si tu decisión es contribuir ...</h2>
								<p>Te pido <b class="titulo-1 fs-18">5 minutos</b> para mejorar juntos esta maravillosa experiencia de aprendizaje,
									las siguientes preguntas están diseñadas para evaluar la pertinencia, metodología y calidad del curso de inglés que ha tenido la oportunidad de cursar</p>
								<hr>
								<div class="col-xl-12">
									<p><b>¿Considera que el contenido del curso de inglés aborda de manera adecuada los aspectos fundamentales del idioma, como gramática, vocabulario, comprensión auditiva y expresión oral?</b></p>
									<select name="pre2" id="pre2" class="form-control" required>
										<option value="">Seleccionar</option>
										<option value="si">Si </option>
										<option value="no">No</option>
										<option value="aveces">A veces</option>
									</select>
									<span class="highlight"></span>
									<span class="bar"></span>
								</div>
								<div class="group col-xl-12 mt-4">
									<div class="col-xl-12">
										<p><b>¿Cómo calificaría las metodologías de enseñanza empleadas en el curso para facilitar el aprendizaje?</b></p>
										<select name="pre3" id="pre3" class="form-control" required>
											<option value="">Seleccionar</option>
											<option value="muymal">Muy Mal </option>
											<option value="mal">Mal</option>
											<option value="regular">Regular</option>
											<option value="bien">Bien</option>
											<option value="muybien">Muy Bien</option>
										</select>
										<span class="highlight"></span>
										<span class="bar"></span>
									</div>
								</div>
								<div class="group col-xl-12">
									<div class="col-xl-12">
										<p><b>¿Cómo evalúa la capacidad del profesor para explicar conceptos de manera clara y comprensible, así como su habilidad para motivar y comprometer a los estudiantes en el proceso de aprendizaje del idioma inglés?</b></p>
										<select name="pre4" id="pre4" class="form-control" required>
											<option value="">Seleccionar</option>
											<option value="muymal">Muy Mal </option>
											<option value="mal">Mal</option>
											<option value="regular">Regular</option>
											<option value="bien">Bien</option>
											<option value="muybien">Muy Bien</option>
										</select>
										<span class="highlight"></span>
										<span class="bar"></span>
									</div>
								</div>
								<div class="group col-xl-12">
									<div class="col-xl-12">
										<p><b>¿Qué tan satisfecho se encuentra con el programa de inglés que se encuentra cursando?</b></p>
										<select name="pre5" id="pre5" class="form-control" required>
											<option value="">Seleccionar</option>
											<option value="muymal">Muy Mal </option>
											<option value="mal">Mal</option>
											<option value="regular">Regular</option>
											<option value="bien">Bien</option>
											<option value="muybien">Muy Bien</option>
										</select>
										<span class="highlight"></span>
										<span class="bar"></span>
									</div>
								</div>
								<div class="group col-xl-12">
									<div class="col-xl-12">
										<p><b>¿Qué tan satisfecho se encuentra con la plataforma utilizada para el programa de inglés?</b></p>
										<select name="pre6" id="pre6" class="form-control" required>
											<option value="">Seleccionar</option>
											<option value="muymal">Muy Mal </option>
											<option value="mal">Mal</option>
											<option value="regular">Regular</option>
											<option value="bien">Bien</option>
											<option value="muybien">Muy Bien</option>
										</select>
										<span class="highlight"></span>
										<span class="bar"></span>
									</div>
								</div>
								<div class="group col-xl-12">
									<div class="col-xl-12">
										<p><b>¿Qué recomendaciones tiene para mejorar el curso?</b></p>
										<textarea name="pre7" id="pre7" rows="5" class="form-control" required></textarea>
										<span class="highlight"></span>
										<span class="bar"></span>
									</div>
								</div>
							</div>
							<button class="btn btn-success" type="submit" style="display: none;" id="btn-enviar-encuesta-si"><i class="fa fa-save"></i> Enviar aporte </button>
							<a class="btn btn-success text-white" onclick="enviarno()" style="display: none;" id="btn-enviar-encuesta-no"><i class="fa fa-save"></i> Guardar cambios </a>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal evaluación docente-->
		<div id="modal_evaluacion_docente" class="modal fade" role="dialog">
			<div class="modal-dialog modal-dialog-centered modal-sm">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						
					</div>
					<div class="modal-body">
						<div class="col-md-12 text-center">
							<h4 class="modal-title"><strong>Tu opinión es muy importante para que sigamos creciendo juntos.</strong></h4>
							<p>
								Te invitamos a realizar estas preguntas para que sigamos mejorando la experiencia y la calidad académica 
							</p>
							<div class="alert alert-primary">
								<p>Tu participación es confidencial y anónima. ¡No dejes pasar esta oportunidad de hacer escuchar tu voz!</p>
							</div>
							<a class="btn btn-success text-decoration-none text-white" href="evaluaciondocente.php">¡Participa aquí ¡</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="modal_encuesta_docente" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"><strong>Evaluación docente</strong></h4>
					</div>
					<div class="modal-body">
						<div class="col-md-12 text-center">
							<h3>
							</h3>
						</div>
						<a class="btn btn-success text-decoration-none text-white" href="verencuestadocente.php">Ver evaluación docente</a>
					</div>
				</div>
			</div>
		</div>
		<a href="https://wa.me/3126814341?text=Hola" class="float-wa" target="_blank">
			<i class="fab fa-whatsapp" style="margin-top:10px;"></i>
		</a>
		<style>
			.float-wa {
				position: fixed;
				width: 50px;
				height: 50px;
				bottom: 80px;
				right: 25px;
				background-color: #25d366;
				color: #FFF;
				border-radius: 50px;
				text-align: center;
				font-size: 30px;
				z-index: 100;
			}

			.float-wa:hover {
				color: #FFF;
			}
		</style>			
		
<script>
const icon = document.querySelector('.iconologo');

let lastScrollY = window.scrollY;
let currentRotation = 0;
let velocity = 0;
let ticking = false;

function updateRotation() {
  currentRotation += velocity;
  velocity *= 0.95; // frena gradualmente

  icon.style.transform = `rotate(${currentRotation}deg)`;

  if (Math.abs(velocity) > 0.01) {
    requestAnimationFrame(updateRotation);
  } else {
    ticking = false;
  }
}

window.addEventListener('scroll', () => {
  const newScrollY = window.scrollY;
  const delta = newScrollY - lastScrollY;
  velocity = delta * 0.2; // ajustá esto para mayor o menor impulso
  lastScrollY = newScrollY;

  if (!ticking) {
    ticking = true;
    requestAnimationFrame(updateRotation);
  }
});
			</script>