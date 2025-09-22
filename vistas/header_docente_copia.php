<?php
if (strlen(session_id()) < 1) 
  session_start();
if(!$_SERVER['HTTP_REFERER'])
{
	echo "<script language='javascript'>window.location='login.html'</script>";
}
require_once "../modelos/Usuario.php";
$usuario=new Usuario();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CIAFI | Académico</title>
	<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-M9V2KQ4');</script>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="apple-touch-icon" sizes="57x57" href="../public/favicon/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="../public/favicon/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="../public/favicon/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="../public/favicon/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="../public/favicon/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="../public/favicon/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="../public/favicon/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="../public/favicon/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="../public/favicon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="../public/favicon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="../public/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="../public/favicon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="../public/favicon/favicon-16x16.png">
		<link rel="manifest" href="../public/favicon/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="../public/favicon/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">   
		<link rel="stylesheet" href="../public/css/estilos.css"><!-- estos son propios -->
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.5 -->
		<!--	<link rel="stylesheet" href="../public/css/bootstrap.min.css">-->
		<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">-->
		<link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<!-- Tempusdominus Bbootstrap 4 -->
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
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> 
		<!-- AdminLTE Skins. Choose a skin from the css/skins
		folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="../public/css/_all-skins.min.css">
		<!-- DATATABLES -->
		<link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">    
		<link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet"/>
		<link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">
		<!-- jQuery Alertify -->
		<link rel="stylesheet" href="../public/alertify/css/themes/default.css" />
		<link rel="stylesheet" href="../public/alertify/css/alertify.min.css" />
		<script src="../public/alertify/alertify.min.js"></script>
		<!-- ********************** -->	  
		<script src="../public/ckeditor/ckeditor.js"></script>
		<script src="../public/ckeditor/samples/js/sample.js"></script>	  
		<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
	</head>
<body class="hold-transition sidebar-mini layout-fixed">
	<noscript>
		<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M9V2KQ4" height="0" width="0" style="display:none;visibility:hidden"></iframe>
	</noscript>
<!-- End Google Tag Manager (noscript) -->
    <div class="wrapper">
	<nav class="main-header navbar navbar-expand navbar-white navbar-light">
		<!-- Left navbar links -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			</li>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="panel.php" class="nav-link">Inicio</a>
			</li>
		</ul>
	</nav>
	<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
		<a href="panel.php" class="brand-link">
			<img src="../public/img/i_ciafi.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
		   style="opacity: .8">
			<span class="brand-text font-weight-light">CAMPUS VIRTUAL</span>
		</a>
		<!-- Sidebar -->
		<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
			<div class="user-panel mt-3 pb-3 mb-3 d-flex">
				<div class="image">
					<span class="">
						<?php
					   	if (file_exists('../files/docentes/'.$_SESSION['usuario_imagen'].'.jpg')) {
							echo $foto='<img src=../files/docentes/'.$_SESSION['usuario_imagen'].'.jpg class="img-circle elevation-2" alt="Usuario" style="width:30px;height:30px">';
						}else{
							echo $foto='<img src=../files/null.jpg width=50px height=50px class="img-circle elevation-2" alt="Usuario" style="width:30px;height:30px">';
						}
					   ?>
					</span>
				</div>
				<div class="info">
				  <a href="#" class="d-block"><?php echo $_SESSION['usuario_nombre'] . "  " . $_SESSION['usuario_apellido']; ?></a>
				</div>
			</div>
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">	
        <nav class="navbar navbar-static-top bg-primary navbar-dark" role="navigation">
          <!-- Sidebar toggle button-->
		<a class="sidebar-toggle" id="sidebarToggle" href="#" data-toggle="offcanvas" role="button">
        <i class="fas fa-bars"></i>
     	</a>
			<!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                   <span class="">
					   <?php
					   	if (file_exists('../files/docentes/'.$_SESSION['usuario_imagen'].'.jpg')) {
							echo $foto='<img src=../files/docentes/'.$_SESSION['usuario_imagen'].'.jpg class=user-image>';
						}else{
							echo $foto='<img src=../files/null.jpg width=50px height=50px class=user-image>';
						}
					   ?>
					</span>
					  <span class=""><?php echo $_SESSION['usuario_nombre'] . "  " . $_SESSION['usuario_apellido']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header" style="height: auto !important">
					   <?php
					   	if (file_exists('../files/docentes/'.$_SESSION['usuario_imagen'].'.jpg')) {
							echo $foto='<img src=../files/docentes/'.$_SESSION['usuario_imagen'].'.jpg class=img-circle>';
						}else{
							echo $foto='<img src=../files/null.jpg width=50px height=50px class=img-circle>';
						}
					   ?>
                    <p>
                      Docente
                      <small><?php echo $_SESSION['usuario_login']; ?></small><br>
						<a href="configurarcuentadocente.php" class="btn btn-dropbox">Gestiona tu cuenta CIAFI</a>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div>
                      <a href="../controlador/usuario.php?op=salir" class="btn btn-default btn-block">Cerrar sesión</a>
                    </div>
					 <div>
					 <a href="" class="btn">Política de privacidad</a> 
					</div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>
			  <?php
					$data= Array();
					$data["0"] ="";
						$rspta = $usuario->listarcursos($_SESSION['id_usuario']);
						$reg=$rspta;
			 ?>
			<?php if($menu==1){$activado="menu-open active";}else{$activado="";}   ?>
		  <li class="treeview <?php echo $activado;?> ">
			  <a href="#">
				<i class="fas fa-universal-access"></i> <span>Experiencias</span> <span class="label label-primary"><?php echo count($reg) ?></span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-left pull-right"></i>
				</span>
			  </a>
			   <ul class="treeview-menu">
			<li><a href="docentegrupos.php"><span class="btn btn-default btn-sm btn-block pull" style="text-align:left !important;">  Ver Lista de Grupos</span><small class="label pull-right bg-red"><i class="fas fa-eye"></i></small></a></li>
				   <?php
						for ($i=0;$i<count($reg);$i++){
                        $rspta2 = $usuario->datosPrograma($reg[$i]["id_programa"]);// consulta para traer los datos del programa
                        $reg2=$rspta2;
                        $jornada_real = $usuario->datosDiaReal($reg[$i]["jornada"]);// consulta para trer los datos reales de la jornada
                        $jor_real=$jornada_real["codigo"];// contiene el dia real 
                        $hora_grupo=$usuario->horaGrupo($reg[$i]["id_docente_grupo"]);
                        $dia=$hora_grupo["dia"];
                        $hora=$hora_grupo["hora"];
                        $salon=$hora_grupo["salon"];
                        $data["0"] .= '
                        <li class="header"> <span class="label label-success">'.$jor_real.' | G-'.$reg[$i]["grupo"].'</span>
                        '.$dia.' : '.$salon.'<br>' . $reg2["nombre"] .' <br> ' . $reg[$i]["materia"] .'<br>
                            <div class="btn-group">
                                <a href="docente.php?id='.$reg[$i]["id_docente"].'&ciclo='.$reg[$i]["ciclo"].'&materia='.$reg[$i]["materia"].'&jornada='.$reg[$i]["jornada"].'&id_programa='.$reg[$i]["id_programa"].' &grupo='.$reg[$i]["grupo"].' " title="'.$reg2["nombre"].'" class="btn btn-default btn-sm"> Grupo </a>';
                                    $data["0"] .= ' 
                                    <a href="peadocente.php?id='.$reg[$i]["id_docente_grupo"].'" class="btn btn-default btn-sm">PEA </a>';
                        $data["0"] .= '
                            </div>
                        </li>'; 
                    }
                      echo $data["0"];
					 ?>
				</ul>
			</li>
			  <?php if($menu==2){$activado="menu-open active";}else{$activado="";}   ?>
		  <li class="treeview <?php echo $activado;?> ">
			  <a href="#">
				<i class="fas fa-calendar"></i> <span>Horario</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-left pull-right"></i>
				</span>
			  </a>
			   <ul class="treeview-menu">
				<li><a href="horariodocentepersonal.php"><i class="fa fa-circle-o"></i> Horario</a></li>
				</ul>
			</li>
			  <?php if($menu==3){$activado="menu-open active";}else{$activado="";}   ?>
			  <li class="treeview <?php echo $activado;?>">
			  <a href="#">
				<i class="fas fa-users-cog"></i> <span>Digital</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-left pull-right"></i>
				</span>
			  </a>
			   <ul class="treeview-menu">
				<li><a href="bibliotecaciaf.php"><i class="fa fa-circle-o"></i> Biblioteca</a></li>
				<li class="d-none"><a href="https://elibro.net/es/lc/ciaf/inicio" target="_blank"><i class="fa fa-circle-o"></i> E-libro</a></li>
			    <li><a href="#"><i class="fa fa-circle-o"></i> Recursos</a></li>
				</ul>
			</li>
			  <?php if($menu==4){$activado="menu-open active";}else{$activado="";}   ?>
			  <li class="treeview <?php echo $activado;?>">
				  <a href="#">
					<i class="fas fa-chalkboard-teacher"></i> <span>Reservas</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href="disponibilidad_salones.php"><i class="fa fa-circle-o"></i> Reservar Salón</a></li>
					<li><a href="reservaequipo.php"><i class="fa fa-circle-o"></i> Reservas de Equipos</a></li>
					<li><a href="https://docs.google.com/forms/d/e/1FAIpQLScjONg2dF7waQCBjtFBDx2qDgUwHwjvXjjqeKtOOwgZicV6ww/viewform" target="_blank"><i class="fa fa-circle-o"></i> Asistencia Técnica</a></li>
				  </ul>
				</li>
			  <?php if($menu==5){$activado="active";}else{$activado="";}   ?>
				  <li class="<?php echo $activado;?> ">
					<a href="solicitudViaticos.php">
					  <i class="fas fa-car-alt" ></i> <span>Solicitud Viáticos</span>
					</a>
				  </li>
            <li>
              <a href="#">
                <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                <small class="label pull-right bg-red">PDF</small>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                <small class="label pull-right bg-yellow">IT</small>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>