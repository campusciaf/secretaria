<?php
if (strlen(session_id()) < 1) 
  session_start();
error_reporting(0);
if(!$_SERVER['HTTP_REFERER'])
{
	echo "<script language='javascript'>window.location='../index.php'</script>";
}
error_reporting(1);
?>
<!--<!DOCTYPE html>-->
<html>
  <head>
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
	  
    <title>CIAFI | Académico</title>
	  
	  <link rel="stylesheet" href="../public/css/estilos.css"><!-- estos son propios -->
	  
	  
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/fontawesome-free/css/all.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
	
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">


    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">    
    <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css">
		

	  
	  
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">
	  
	  
	<!-- jQuery Alertify -->
	<link rel="stylesheet" href="../public/alertify/css/themes/default.css" />
	<link rel="stylesheet" href="../public/alertify/css/alertify.min.css" />
	  	<script src="../public/alertify/alertify.min.js"></script>
	<!-- ********************** -->	  

	<script src="../public/ckeditor/ckeditor.js"></script>
	<script src="../public/ckeditor/samples/js/sample.js"></script>	  
	  

        <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

 
		  
<script type="text/javascript">
    var datefield=document.createElement("input")
    datefield.setAttribute("type", "date")
    if (datefield.type!="date"){ //if browser doesn't support input type="date", load files for jQuery UI Date Picker
        document.write('<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />\n')
        document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"><\/script>\n')
        document.write('<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"><\/script>\n') 
    }
</script>
 
<script>
if (datefield.type!="date"){ //if browser doesn't support input type="date", initialize date picker widget:
    jQuery(function($){ //on document.ready
        $('#compromiso_fecha').datepicker();
		 $('#meta_fecha').datepicker();
    })
}
</script>  
	  
	  
  </head>
  <body class="hold-transition skin-blue-light sidebar-mini fixed">
	  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M9V2KQ4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="panel.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>CAMPUS</b></span>
          <!-- logo for regular state and mobile devices -->
			<span class="logo-lg"><b>CAMPUS</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
		  
		 
        <nav class="navbar navbar-static-top bg-primary navbar-dark" role="navigation">
          <!-- Sidebar toggle button-->
		<a class="sidebar-toggle" id="sidebarToggle" href="#" data-toggle="offcanvas" role="button">
        <i class="fas fa-bars"></i>
     	</a>
			
<!--
			<span class="cerrar">
			<a href="../controlador/usuario.php?op=salir" class="btn btn-dropbox pull-right">
                <i class="far fa-times-circle fa-2x"></i> Salir
              </a>
			</span>
-->
			<!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

            <li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                <i class="far fa-user" style="margin-top: 5px"></i>
                <span class="label label-warning cantidad_notifi"></span>
              </a>
              <ul class="dropdown-menu">
                <li class="header mensaje_cantidad"></li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;">
                    <ul class="menu" id="menu_notificaciones"></ul>
                    <div class="slimScrollBar" ></div>
                    <div class="slimScrollRail" ></div>
                  </div>
                </li>
              </ul>
            </li>

			<?php
				require_once "../modelos/AyudaDependencia.php";
				$ayudadep=new AyudaDependencia();
				$data= Array();
				$data["0"] ="";

				$rspta = $ayudadep->listar();
				$reg=$rspta;
				
			?>
			<li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="far fa-envelope" style="margin-top: 5px"></i>
              <span class="label label-success"><?php echo count($reg); ?> </span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Usted tiene <?php echo count($reg); ?> mensajes</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
				<?php
					for ($a=0;$a<count($reg);$a++){	
						
					echo '
					  <li>
						<a onclick=verAyuda('.$reg[$a]["id_ayuda"].')>
						  <div class="pull-left">';
						
						if (file_exists('../files/estudiantes/'.$reg[$a]['credencial_identificacion'].'.jpg')) {
							echo '<img src=../files/estudiantes/'.$reg[$a]['credencial_identificacion'].'.jpg class=direct-chat-img>';
						}else{
							echo '<img src=../files/null.jpg class=direct-chat-img>';
						}
						
							
					echo '</div>
						  <h4>'.$reg[$a]["asunto"].'
							<small><i class="fa fa-clock-o"></i> 5 mins</small>
						  </h4>
						  <p>'.$reg[$a]["mensaje"].'</p>
						</a>
					  </li>';
					}
				?>
                </ul>
              </li>
              <li class="footer"><a href="ayudadependencia.php">Ver todos los mensajes</a></li>
            </ul>
          </li>	
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                   <span class=""><img src="../files/usuarios/<?php echo $_SESSION['usuario_imagen']; ?>" class="user-image" alt="User Image"></span>
					  <span class=""><?php echo $_SESSION['usuario_nombre'] . "  " . $_SESSION['usuario_apellido']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header" style="height: auto !important">
                    <img src="../files/usuarios/<?php echo $_SESSION['usuario_imagen']; ?>" class="img-circle" alt="User Image">
                    <p>
                       <?php echo $_SESSION['usuario_cargo']; ?>
                      <small><?php echo $_SESSION['usuario_login']; ?></small><br>
					
						<a href="configurarcuenta.php" class="btn btn-dropbox">Gestiona tu cuenta CIAFI</a>
                    </p>
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
			  
	
			  if($_SESSION['menuadmin']==1){
				  if($menu==1){$activado="menu-open active";}else{$activado="";}
				  echo '
				  
				<li class="treeview '.$activado.'">
				  <a href="#">
					<i class="fas fa-users-cog"></i> <span>Administración</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu '.$activado.'">';
					
					if($_SESSION['usuario']==1){
						echo '
							<li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
						';
					}
				  if($_SESSION['permiso']==1){
					
						echo '  
							<li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
						';
				  }
				   if($_SESSION['programa']==1){
					
						echo '  
							<li><a href="programa.php"><i class="fa fa-circle-o"></i> Programa</a></li>
						';
				  }
				   if($_SESSION['materiasprograma']==1){
					
						echo '  
							<li><a href="materiasprograma.php"><i class="fa fa-circle-o"></i> Materias</a></li>
						';
				  }
				  
				   if($_SESSION['pea']==1){
					
						echo '  
							<li><a href="pea.php"><i class="fa fa-circle-o"></i> Pea</a></li>
						';
				  }
				  
				   if($_SESSION['adminformatosinstitucionales']==1){
					
						echo '  
							<li><a href="adminformatosinstitucionales.php"><i class="fa fa-circle-o"></i> Formatos Institucionales</a></li>
						';
				  }
				  if($_SESSION['salon']==1){
                        echo '
                            <li><a href="salones.php"><i class="fa fa-circle-o"></i> Gestión Salones</a></li>
                            
                        ';
                    }
				   if($_SESSION['cargarfoto']==1){
					
						echo '  
							<li><a href="cargar_foto.php"><i class="fa fa-circle-o"></i> Cargar Foto</a></li>
						';
				  }
				  if($_SESSION['restaurarcontrasena']==1){
					
						echo '  
							<li><a href="restaurar_contrasena.php"><i class="fa fa-circle-o"></i> Restaurar Clave</a></li>
						';
				  } 
				  if($_SESSION['eliminarestudiante']==1){
					
						echo '  
							<li><a href="eliminar_estudiante.php"><i class="fa fa-circle-o"></i> Eliminar Estudiante</a></li>
						';
				  }
				  if($_SESSION['estadoestudiante']==1){
					
						echo '  
							<li><a href="estado_estudiante.php"><i class="fa fa-circle-o"></i> Estado Estudiante</a></li>
						';
				  } 
				  if($_SESSION['faltas']==1){
					
						echo '  
							<li><a href="faltas.php"><i class="fa fa-circle-o"></i> Faltas</a></li>
						';
				  }
				  if($_SESSION['periodo']==1){
					
						echo '  
							<li><a href="periodo.php"><i class="fa fa-circle-o"></i> Periodo</a></li>
						';
				  }
				  
				   if($_SESSION['listarestudiante']==1){
                        echo '
                            <li><a href="listar_estudiante.php"><i class="fa fa-circle-o"></i> Datos Estudiante</a></li>
                            
                        ';
                    }
				  if($_SESSION['vermateriascanceladas']==1){
                        echo '
                            <li><a href="ver_materias_canceladas.php"><i class="fa fa-circle-o"></i> Materias Canceladas</a></li>
                            
                        ';
                    }
				   if($_SESSION['gestionparciales']==1){
                        echo '
                            <li><a href="gestionparciales.php"><i class="fa fa-circle-o"></i> Gestión Parciales</a></li>
                            
                        ';
                    }
				   if($_SESSION['verificarcalificaciones']==1){
                        echo '
                            <li><a href="verificarcalificaciones.php"><i class="fa fa-circle-o"></i> Reporte Parciales</a></li>
                            
                        ';
                    }
				  if($_SESSION['datosactualizados']==1){
                        echo '
                            <li><a href="datosactualizados.php"><i class="fa fa-circle-o"></i> Datos Actualizados</a></li>
                            
                        ';
                    }
				  if($_SESSION['proyeccionhorarios']==1){
                        echo '
                            <li><a href="proyeccionhorarios.php"><i class="fa fa-circle-o"></i> Proyección Horarios</a></li>
                            
                        ';
                    }
				  if($_SESSION['estadoegresado']==1){
                        echo '
                            <li><a href="estadoegresado.php"><i class="fa fa-circle-o"></i> Estado Egresado</a></li>
                            
                        ';
                    }
				  
				  if($_SESSION['carnet']==1){
                        echo '
                            <li><a href="carnet.php"><i class="fa fa-circle-o"></i> Carnetización</a></li>
                            
                        ';
                    }
				  
				echo '		
				  </ul>
				</li>
				  
				  ';
			  }
			  
			  if($_SESSION['menupoa']==1){
				   if($menu==2){$activado="menu-open active";}else{$activado="";}
				  echo '
				  
				<li class="treeview '.$activado.'">
				  <a href="#">
					<i class="fas fa-users-cog"></i> <span> POA</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu '.$activado.'">';
					
					if($_SESSION['adminejes']==1){
						echo '
							<li><a href="ejes.php"><i class="fa fa-circle-o"></i> Ejes Estratégicos</a></li>
						';
					}
				   if($_SESSION['arquitectura']==1){
						echo '
							<li><a href="arquitectura.php"><i class="fa fa-circle-o"></i> Arquitectura</a></li>
						';
					}
				  if($_SESSION['compromiso']==1){
						echo '
							<li><a href="compromiso.php"><i class="fa fa-circle-o"></i> Compromisos</a></li>
						';
					}
				  if($_SESSION['propuestapoa']==1){
						echo '
							<li><a href="propuestapoa.php"><i class="fa fa-eyes"></i> Propuesta POA</a></li>
						';
					}
				  
				  if($_SESSION['crearcompromiso']==1){
						echo '
							<li><a href="crearcompromiso.php"><i class="fa fa-circle-o"></i> Crear Compromisos</a></li>
						';
					}
				  
				  if($_SESSION['micompromiso']==1){
						echo '
							<li><a href="micompromiso.php"><i class="fa fa-circle-o"></i> Mis Compromisos</a></li>
						';
					} 
				  if($_SESSION['corresponsabilidad']==1){
						echo '
							<li><a href="corresponsabilidad.php"><i class="fa fa-circle-o"></i> Corresponsabilidades</a> </li>
						';
					}
				  
				  
				  if($_SESSION['validaciones']==1){
						echo '
							<li><a href="validaciones.php"><i class="fa fa-circle-o"></i> Validaciones</a></li>
						';
					}
				  if($_SESSION['estadisticapoa']==1){
						echo '
							<li><a href="estadisticapoa.php"><i class="fa fa-circle-o"></i> Estadistica</a></li>
						';
					}
				  if($_SESSION['calendariopoageneral']==1){
						echo '
							<li><a href="calendario_poa_general.php"><i class="fa fa-circle-o"></i> Calendario POA General</a></li>
						';
					}
				  if($_SESSION['calendariopoa']==1){
						echo '
							<li><a href="calendario_poa.php"><i class="fa fa-circle-o"></i> Calendario POA</a></li>
						';
					}
				  
				  if($_SESSION['verevidencia']==1){
						echo '
							<li><a href="verevidencia.php"><i class="fa fa-eyes"></i> Ver Evidencias</a></li>
						';
					}
				  
				  
				echo '		
				  </ul>
				</li>
				  
				  ';
			  }
			  
			  
			  if($_SESSION['menucalendario']==1){
				   if($menu==3){$activado="menu-open active";}else{$activado="";}
				  echo '
				  
				<li class="treeview '.$activado.'">
				  <a href="#">
					<i class="fas fa-calendar"></i> <span>Admin calendario</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu '.$activado.'">';
					
					if($_SESSION['admincalendario']==1){
						echo '
							<li><a href="admincalendario.php"><i class="fa fa-circle-o"></i> Admin calendario</a></li>
						';
					}
				  if($_SESSION['calendario']==1){
					
						echo '  
							<li><a href="calendario.php"><i class="fa fa-circle-o"></i> Calendario</a></li>
						';
				  }
				  if($_SESSION['admincalendarioeventos']==1){
					
						echo '  
							<li><a href="admincalendario_eventos.php"><i class="fa fa-circle-o"></i> Admin Calendario Eventos</a></li>
						';
				  }
				  if($_SESSION['calendarioeventos']==1){
					
						echo '  
							<li><a href="calendario_eventos.php"><i class="fa fa-circle-o"></i> Calendario Eventos</a></li>
						';
				  }
				echo '		
				  </ul>
				</li>
				  
				  ';
			  }
			  
			  
			  if($_SESSION['menubiblioteca']==1){
				   if($menu==4){$activado="menu-open active";}else{$activado="";}
				  echo '
				  
				<li class="treeview '.$activado.'">
				  <a href="#">
					<i class="fas fa-book"></i> <span>Biblioteca</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu '.$activado.'">';
					
					if($_SESSION['biblioteca']==1){
						echo '
							<li><a href="biblioteca.php"><i class="fa fa-circle-o"></i> Biblioteca</a></li>
							</li>
						';
					}
				  if($_SESSION['adminbiblioteca']==1){
						echo '
							<li><a href="adminbiblioteca.php"><i class="fa fa-circle-o"></i> Admin Biblioteca</a>
							</li>
						';
					}

				echo '		
				  </ul>
				</li>
				  
				  ';
			  }
			  
			  			  
			  if($_SESSION['menumatriculas']==1){
				   if($menu==5){$activado="menu-open active";}else{$activado="";}
				  echo '
				  
				<li class="treeview '.$activado.'">
				  <a href="#">
					<i class="fas fa-user-friends"></i> <span>Matriculas</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu '.$activado.'">';
					
					if($_SESSION['matricularestudiante']==1){
						echo '
							<li><a href="matriculaestudiante.php"><i class="fa fa-circle-o"></i> Matricular Estudiante</a>
							</li>
						';
					}
				  
				  if($_SESSION['matriculamateria']==1){
						echo '
							<li><a href="matriculamaterias.php"><i class="fa fa-circle-o"></i> Matricular Materias</a>
							</li>
						';
					}
				  
				  if($_SESSION['cancelarmateria']==1){
						echo '
							<li><a href="eliminar_materia.php"><i class="fa fa-circle-o"></i> Cancelar Materia</a>
							</li>
						';
					}

				echo '		
				  </ul>
				</li>
				  
				  ';
			  }
			  
			  
			  
			  if($_SESSION['docente']==1){
				   if($menu==6){$activado="menu-open active";}else{$activado="";}
				  echo '
				  
				<li class="treeview '.$activado.'">
				  <a href="#">
					<i class="fas fa-chalkboard-teacher"></i> <span>Docente</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu '.$activado.'">';
					
					if($_SESSION['gestiondocente']==1){
						echo '
							<li><a href="gestiondocente.php"><i class="fa fa-circle-o"></i> Gestión Docente</a></li>
							
						';
				  }
				  
				   if($_SESSION['cuentadocente']==1){
						echo '
							<li><a href="cuenta_docente.php"><i class="fa fa-circle-o"></i> Cuenta Docente</a></li>
							
						';
				  }
				  
				  if($_SESSION['docentehistorial']==1){
						echo '
							<li><a href="historialdocente.php"><i class="fa fa-circle-o"></i> Historial Docente</a></li>
							
						';
				  }
				echo '		
				  </ul>
				</li>
				  
				  ';
			  }
				  
			   if($_SESSION['menuhorarios']==1){
				  if($menu==7){$activado="menu-open active";}else{$activado="";}
				  echo '
				  
				<li class="treeview '.$activado.'">
				  <a href="#">
					<i class="fas fa-user-clock"></i> <span>Horarios</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu '.$activado.'">';
					
					if($_SESSION['gestionhorarios']==1){
						echo '
							<li><a href="gestionhorarios.php"><i class="fa fa-circle-o"></i> Gestión Horarios</a></li>
							
						';

						}
				   
					if($_SESSION['horarioprograma']==1){
						echo '
							<li><a href="horarioprograma.php"><i class="fa fa-circle-o"></i> Horario por Programa</a></li>
							
						';
					}
				   if($_SESSION['horariodocente']==1){
						echo '
							<li><a href="horariodocente.php"><i class="fa fa-circle-o"></i> Horario por Docente</a></li>
							
						';
					}
				   
				   
				   if($_SESSION['horariosalon']==1){
						echo '
							<li><a href="horariosalon.php"><i class="fa fa-circle-o"></i> Horario por Salon</a></li>
							
						';
					}
				   if($_SESSION['horariosalon']==1){
						echo '
							<li><a href="cargadocente.php"><i class="fa fa-circle-o"></i> Carga Docente</a></li>
							
						';
					}
				   
				echo '		
				  </ul>
				</li>
				  
				  ';
			  }
			  
			  
			   			  
			  if($_SESSION['menuregistroycontrol']==1){
				  if($menu==8){$activado="menu-open active";}else{$activado="";}
                  echo '
                  
                <li class="treeview '.$activado.'">
                  <a href="#">
                    <i class="fas fa-address-card"></i> <span>Registro y Control</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu '.$activado.'">';
                    if($_SESSION['cambiardocumento']==1){
                        echo '
                            <li><a href="cambiardocumento.php"><i class="fa fa-circle-o"></i> Cambiar Documento</a></li>
                            
                        ';
                    }
				  
				  if($_SESSION['buscarperfil']==1){
                        echo '
                            <li><a href="buscarperfil.php"><i class="fa fa-circle-o"></i> Gestión Perfiles</a></li>
                            
                        ';
                    }
				  
				  if($_SESSION['certificados']==1){
                        echo '
                            <li><a href="certificados.php"><i class="fa fa-circle-o"></i> Certificados</a></li>
                            
                        ';
                    }
				   if($_SESSION['certificadosporsemestre']==1){
                        echo '
                            <li><a href="certificadosporsemestre.php"><i class="fa fa-circle-o"></i> Certificado Por Semestre</a></li>
                            
                        ';
                    }
				  
				  if($_SESSION['calificarhuella']==1){
                        echo '
                            <li><a href="calificarhuella.php"><i class="fa fa-circle-o"></i> Calificar Huella</a></li>
                            
                        ';
                    }
				  if($_SESSION['reportesnies']==1){
                        echo '
                            <li><a href="reporte_snies.php"><i class="fa fa-circle-o"></i> Reporte SNIES</a></li>
                            
                        ';
                    }
                echo '      
                  </ul>
                </li>
                  
                  ';
              }
			  if($_SESSION['menuantes2012']==1){
				 if($menu==9){$activado="menu-open active";}else{$activado="";}
                  echo '
                  
                <li class="treeview '.$activado.'">
                  <a href="#">
                    <i class="fas fa-address-card"></i> <span>Menú antes 2012</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu '.$activado.'">';
                    if($_SESSION['registrarestudiante']==1){
                        echo '
                            <li><a href="registrar2012.php"><i class="fa fa-circle-o"></i> Registrar estudiante</a></li>
                            
                        ';
                    }
				  
                echo '      
                  </ul>
                </li>
                  
                  ';
              }
			  
			  if($_SESSION['menuconsultas']==1){
				   if($menu==10){$activado="menu-open active";}else{$activado="";}
                  echo '
                  
                <li class="treeview '.$activado.'">
                  <a href="#">
                    <i class="fas fa-search"></i> <span>Menú Consultas</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu '.$activado.'">';
                  
				   if($_SESSION['consultafiltrada']==1){
                        echo '
                            <li><a href="consultafiltrada.php"><i class="fa fa-circle-o"></i> Consulta Filtrada</a></li>
                            
                        ';
                    }
				  
				  if($_SESSION['consultaprograma']==1){
                        echo '
                            <li><a href="consultaprograma.php"><i class="fa fa-circle-o"></i> Grupos Programa</a></li>
                            
                        ';
                    }
				  
				  if($_SESSION['promedio']==1){
                        echo '
                            <li><a href="promedios.php"><i class="fa fa-circle-o"></i> Promedio</a></li>
                            
                        ';
                    }
				  
				  if($_SESSION['mejorpromedio']==1){
                        echo '
                            <li><a href="promedioalto.php"><i class="fa fa-circle-o"></i>Mejor Promedio</a></li>
                            
                        ';
                    }
				  
				  if($_SESSION['actualidad']==1){
                        echo '
                            <li><a href="actualidad.php"><i class="fa fa-circle-o"></i>Actualidad</a></li>
                            
                        ';
                    }
				  
				   if($_SESSION['consultasnotas']==1){
                        echo '
                            <li><a href="consultanotas.php"><i class="fa fa-circle-o"></i>Notas Perdidas/Aprobadas</a></li>
                            
                        ';
                    }
				  if($_SESSION['porrenovar']==1){
                        echo '
                            <li><a href="por_renovar.php"><i class="fa fa-circle-o"></i>Por renovar</a></li>
                            
                        ';
                    }
				  if($_SESSION['cantidadfaltas']==1){
                        echo '
                            <li><a href="cantidadfaltas.php"><i class="fa fa-circle-o"></i>Inasistencia</a></li>
                            
                        ';
                    }

                echo '      
                  </ul>
                </li>
                  
                  ';
              }
			  
			  
			  
			  if($_SESSION['menumovilizacion']==1){
				 if($menu==11){$activado="menu-open active";}else{$activado="";}
                  echo '
                  
                <li class="treeview '.$activado.'">
                  <a href="#">
                    <i class="fas fa-car-alt"></i> <span>Movilización</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu '.$activado.'">';
                    if($_SESSION['tarifasmovilizaciones']==1){
                        echo '
                            <li><a href="movilizacion.php"><i class="fa fa-circle-o"></i> Tarifas Movilizaciones</a></li>
                            
                        ';
                    }
                    if($_SESSION['solicitudesdocentes']==1){
                        echo '
                            <li><a href="solicitudesdocentes.php"><i class="fa fa-circle-o"></i> Solicitudes Docentes</a></li>
                            
                        ';
                    }
                    if($_SESSION['solicitudesaprobadas']==1){
                        echo '
                            <li><a href="solicitudes_aprobadas.php"><i class="fa fa-circle-o"></i> Solicitudes Aprobadas</a></li>
                            
                        ';
                    }
                    if($_SESSION['solicitudViaticos']==1){
                        echo '
                            <li><a href="solicitudViaticos.php"><i class="fa fa-circle-o"></i> Solicitud Viáticos</a></li>
                            
                        ';
                    }
                echo '      
                  </ul>
                </li>
                  
                  ';
              }
			  
			  if($_SESSION['menucomunicaciones']==1){
				   if($menu==12){$activado="menu-open active";}else{$activado="";}
                  echo '
                  
                <li class="treeview '.$activado.'">
                  <a href="#">
                   <i class="fab fa-font-awesome"></i> <span>Ménu Comunicaciones</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu '.$activado.'">';
                    if($_SESSION['recordatoriodocente']==1){
                        echo '
                            <li><a href="recordatoriodocente.php"><i class="fa fa-circle-o"></i> Recordatorio Docente</a></li>
                            
                        ';
                    } 
				  
				  if($_SESSION['mailing']==1){
                        echo '
                            <li><a href="mailing.php"><i class="fa fa-circle-o"></i> Mailing</a></li>
                            
                        ';
                    } 
				  
                echo '      
                  </ul>
                </li>
                  
                  ';
              }
			  
			  
			  			  
			  if($_SESSION['menupermanencia']==1){
				   if($menu==13){$activado="menu-open active";}else{$activado="";}
                  echo '
                  
                <li class="treeview '.$activado.'">
                  <a href="#">
                   <i class="far fa-handshake"></i> <span>Menú Permanencia</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu '.$activado.'">';
                    if($_SESSION['variables']==1){
                        echo '
                            <li><a href="variables.php"><i class="fa fa-circle-o"></i> Variables</a></li>
                            
                        ';
                    } 
				  if($_SESSION['resultadovariables']==1){
                        echo '
                            <li><a href="resultadovariables.php"><i class="fa fa-circle-o"></i> Resultado Caracterización</a></li>
                            
                        ';
                    } 
				  if($_SESSION['consultavariables']==1){
                        echo '
                            <li><a href="consultavariables.php"><i class="fa fa-circle-o"></i> Consultas Variables</a></li>
                            
                        ';
                    }
				  
				   if($_SESSION['verificarcaracterizacion']==1){
                        echo '
                            <li><a href="verificarcaracterizacion.php"><i class="fa fa-circle-o"></i> Verificar Caracterización</a></li>
                            
                        ';
                    }  
				  if($_SESSION['resultadoestudiante']==1){
                        echo '
                            <li><a href="resultadoestudiante.php"><i class="fa fa-circle-o"></i> Resultado Estudiante</a></li>
                            
                        ';
                    }
				  
				  if($_SESSION['geolocalizacion']==1){
                        echo '
                            <li><a href="geolocalizacion.php"><i class="fa fa-circle-o"></i> Geolocalización</a></li>
                            
                        ';
                    }
				  if($_SESSION['geolocalizacionzona']==1){
                        echo '
                            <li><a href="geolocalizacionzona.php"><i class="fa fa-circle-o"></i> Geolocalización Zona</a></li>
                            
                        ';
                    }
				  
				   if($_SESSION['convergeo']==1){
                        echo '
                            <li><a href="convergeo.php"><i class="fa fa-circle-o"></i> Convertir GEO</a></li>
                            
                        ';
                    }
				  if($_SESSION['convergeopostal']==1){
                        echo '
                            <li><a href="convergeopostal.php"><i class="fa fa-circle-o"></i> Convertir Postal</a></li>
                            
                        ';
                    }
				  
				   if($_SESSION['empresasamigas']==1){
                        echo '
                            <li><a href="empresasamigas.php"><i class="fa fa-circle-o"></i> Empresas Amigas</a></li>
                            
                        ';
                    }
				  
				  if($_SESSION['inspiradores']==1){
                        echo '
                            <li><a href="inspiradores.php"><i class="fa fa-circle-o"></i> Inspiradores</a></li>
                            
                        ';
                    }
                echo '      
                  </ul>
                </li>
                  
                  ';
              }
			  
			  if($_SESSION['menuoncenter']==1){
				 if($menu==14){$activado="menu-open active";}else{$activado="";}
                  echo '
                  
                <li class="treeview '.$activado.'">
                  <a href="#">
                   <i class="fas fa-object-group"></i> <span>Menú Admisiones</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu '.$activado.'">';
				  if($_SESSION['oncenterprograma']==1){
                        echo '
                            <li><a href="oncenterprograma.php"><i class="fa fa-circle-o"></i> Gestión Programas</a></li>
                            
                        ';
                    }
				   if($_SESSION['oncenterestado']==1){
                        echo '
                            <li><a href="oncenterestado.php"><i class="fa fa-circle-o"></i> Gestión Estados</a></li>
                            
                        ';
                    }
				  if($_SESSION['oncentermedio']==1){
                        echo '
                            <li><a href="oncentermedio.php"><i class="fa fa-circle-o"></i> Gestión Medios</a></li>
                            
                        ';
                    } 
				  if($_SESSION['oncenterconocio']==1){
                        echo '
                            <li><a href="oncenterconocio.php"><i class="fa fa-circle-o"></i> Gestión Conocio / Contacto</a></li>
                            
                        ';
                    }
				  if($_SESSION['oncentermodalidadcampana']==1){
                        echo '
                            <li><a href="oncentermodalidadcampana.php"><i class="fa fa-circle-o"></i> Gestión Modalidad Campaña</a></li>
                            
                        ';
                    }
          if($_SESSION["oncenteradmintareas"]==1){
                    echo '
                        <li><a href="oncenteradmintareas.php"><i class="fa fa-circle-o"></i> Admin tareas</a></li>
                        
                    ';
                  }
          if($_SESSION["oncentertrazabilidad"]==1){
                    echo '
                        <li><a href="oncentertrazabilidad.php"><i class="fa fa-circle-o"></i> Trazabilidad tareas</a></li>
                        
                    ';
                  }
          if($_SESSION["oncentermistareas"]==1){
                    echo '
                        <li><a href="oncentermistareas.php"><i class="fa fa-circle-o"></i> Mis tareas</a></li>
                        
                    ';
                  }
				  
				  
				  if($_SESSION["oncenterasesores"]==1){
                      echo '
                          <li><a href="oncenterasesores.php"><i class="fa fa-circle-o"></i> Asesores</a></li>
                          
                      ';
                  }
				  if($_SESSION["oncenterconsultas"]==1){
                      echo '
                          <li><a href="oncenterconsultas.php"><i class="fa fa-circle-o"></i> Consultas</a></li>
                          
                      ';
                  }
				  
				  
				   if($_SESSION['oncenternuevocliente']==1){
                        echo '
                            <li><a href="oncenternuevocliente.php"><i class="fa fa-circle-o"></i> Nuevo Cliente</a></li>
                            
                        ';
                    }
				  
				   if($_SESSION["oncentercliente"]==1){
                      echo '
                          <li><a href="oncentercliente.php"><i class="fa fa-circle-o"></i> Cliente</a></li>
                          
                      ';
                  } 
				  
				   if($_SESSION["oncenterclavecliente"]==1){
                      echo '
                          <li><a href="oncenterclavecliente.php"><i class="fa fa-circle-o"></i> Reestablecer Clave</a></li>
                          
                      ';
                  } 
				  
				  if($_SESSION["oncenternointeresados"]==1){
                      echo '
                          <li><a href="oncenternointeresados.php"><i class="fa fa-circle-o"></i> No Interesados</a></li>
                          
                      ';
                  }
				  
				   
				  
                    if($_SESSION['oncenterpanel']==1){
                        echo '
                            <li><a href="oncenterpanel.php"><i class="fa fa-circle-o"></i> Panel</a></li>
                            
                        ';
                    } 
				  if($_SESSION['oncenterinteresados']==1){
                        echo '
                            <li><a href="oncenterinteresados.php"><i class="fa fa-circle-o"></i> Interesados</a></li>
                            
                        ';
                    } 
				  if($_SESSION['oncenterpreinscrito']==1){
                        echo '
                            <li><a href="oncenterpreinscrito.php"><i class="fa fa-circle-o"></i> Preinscrito</a></li>
                            
                        ';
                    }
				  if($_SESSION['oncenterinscrito']==1){
                        echo '
                            <li><a href="oncenterinscrito.php"><i class="fa fa-circle-o"></i> Inscrito</a></li>
                            
                        ';
                    } 
				  if($_SESSION['oncenterseleccionado']==1){
                        echo '
                            <li><a href="oncenterseleccionado.php"><i class="fa fa-circle-o"></i> Seleccionados</a></li>
                            
                        ';
                    }
				  if($_SESSION['oncenteradmitido']==1){
                        echo '
                            <li><a href="oncenteradmitido.php"><i class="fa fa-circle-o"></i> Admitidos</a></li>
                            
                        ';
                    }
				  if($_SESSION['oncentermatriculado']==1){
                        echo '
                            <li><a href="oncentermatriculado.php"><i class="fa fa-circle-o"></i> Matriculados</a></li>
                            
                        ';
                    }
				  
				 			 
				  
				   if($_SESSION["oncentervalformulario"]==1){
                        echo '
                            <li><a href="oncentervalformulario.php"><i class="fa fa-circle-o"></i> Val Preinscrito</a></li>
                            
                        ';
                    }
				  
				   if($_SESSION["oncentervalinscripcion"]==1){
                        echo '
                            <li><a href="oncentervalinscripcion.php"><i class="fa fa-circle-o"></i> Val Inscripción</a></li>
                            
                        ';
                    }
				  if($_SESSION["oncentervalentrevista"]==1){
                        echo '
                            <li><a href="oncentervalentrevista.php"><i class="fa fa-circle-o"></i> Val Entevista</a></li>
                            
                        ';
                    }
          if($_SESSION["oncentervaldocumentos"]==1){
                        echo '
                            <li><a href="oncentervaldocumentos.php"><i class="fa fa-circle-o"></i> Val Documentos</a></li>
                            
                        ';
                    }
                  
                 

                 
				  
				  
                echo '      
                  </ul>
                </li>
                  
                  ';
              }
			  
			  if($_SESSION['menuquedate']==1){
				   if($menu==15){$activado="menu-open active";}else{$activado="";}
                  echo '
                  
                <li class="treeview '.$activado.'">
                  <a href="#">
                   <i class="fab fa-font-awesome"></i> <span>Menú Quédate</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu '.$activado.'">';
				  
                    if($_SESSION['abrircaso']==1){
                        echo '
                            <li><a href="quedateabrircaso.php"><i class="fa fa-circle-o"></i> Abrir Caso</a></li>
                            
                        ';
                    } 
				  
				            if($_SESSION['miscasos']==1){
                        echo '
                            <li><a href="quedatemiscasos.php"><i class="fa fa-circle-o"></i> Mis casos</a></li>
                            
                        ';
                    }

                    if($_SESSION['casosestado']==1){
                      echo '
                          <li><a href="quedatecasosestado.php"><i class="fa fa-circle-o"></i> Casos estado</a></li>
                          
                      ';
                    }
                    if($_SESSION['remisiones']==1){
                      echo '
                          <li><a href="quedateremisiones.php"><i class="fa fa-circle-o"></i> Remisiones</a></li>
                          
                      ';
                    }
                    if($_SESSION['casosfecha']==1){
                      echo '
                          <li><a href="quedatevercasofecha.php"><i class="fa fa-circle-o"></i> Casos por fecha</a></li>
                          
                      ';
                    }
                    if($_SESSION['quedatereporte']==1){
                      echo '
                          <li><a href="quedatereporte.php"><i class="fa fa-circle-o"></i> Reporte</a></li>
                          
                      ';
                    }
				 
                echo '      
                  </ul>
                </li>
                  
                  ';
              }
			  
			   if($_SESSION['menuencuestas']==1){
				    if($menu==16){$activado="menu-open active";}else{$activado="";}
                  echo '
                  
                <li class="treeview '.$activado.'">
                  <a href="#">
                   <i class="fab fa-font-awesome"></i> <span>Menú Encuestas</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu '.$activado.'">';
                    if($_SESSION['encuestadocente']==1){
                        echo '
                            <li><a href="encuestadocente.php"><i class="fa fa-circle-o"></i> Auto Evaluación</a></li>
                            
                        ';
                    } 
				    if($_SESSION['encuestaestudiante']==1){
                        echo '
                            <li><a href="encuestaestudiante.php"><i class="fa fa-circle-o"></i> Encuesta Estudiante</a></li>
                            
                        ';
                    } 
				 
                echo '      
                  </ul>
                </li>
                  
                  ';
              }

              if($_SESSION['menuevaluaciondocente']==1){
                if($menu==24){$activado="menu-open active";}else{$activado="";}
                      echo '
                      
                    <li class="treeview '.$activado.'">
                      <a href="#">
                       <i class="fab fa-font-awesome"></i> <span>Evaluación Docente</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu '.$activado.'">';
                        if($_SESSION['preguntasheteroevaluacion']==1){
                            echo '
                                <li><a href="preguntasheteroevaluacion.php"><i class="fa fa-circle-o"></i> Preguntas</a></li>
                            ';
                        } 
                        if($_SESSION['calificaciondocente']==1){
                            echo '
                                <li><a href="calificaciondocente.php"><i class="fa fa-circle-o"></i> Calificación Docente</a></li>
                            ';
                        }
                        if($_SESSION['pendientesevaluaciondocente']==1){
                          echo '
                              <li><a href="pendientesevaluaciondocente.php"><i class="fa fa-circle-o"></i> Pendientes</a></li>
                          ';
                        } 

                        if($_SESSION['resultadosevaluaciondocente']==1){
                          echo '
                              <li><a href="resultadosevaluaciondocente.php"><i class="fa fa-circle-o"></i> Resultados</a></li>
                          ';
                        } 
				  
				  		if($_SESSION['resultadosautoevaluacion']==1){
                          echo '
                              <li><a href="resultadosautoevaluacion.php"><i class="fa fa-circle-o"></i> Resultados Autoevaluación</a></li>
                          ';
                        }
             
                    echo '      
                      </ul>
                    </li>
                      
                      ';
                  }
			  
			  
		  	?>
			  
			  
			  
			  
			 <?php  if($menu==17){$activado="menu-open active";}else{$activado="";} ?>
	  
			  <li class="treeview <?php echo $activado;?>">
				  <a href="#">
					<i class="fas fa-chalkboard-teacher"></i> <span>Reservas</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu <?php echo $activado;?>">
					<li><a href="disponibilidad_salones_admin.php"><i class="fa fa-circle-o"></i> Reservar Salón</a></li>
					  
									
				  </ul>
				</li>
			  
			 <?php  if($menu==18){$activado="menu-open active";}else{$activado="";} ?>  
			  <!-- <li>
              <a href="http://ciaf.digital/permanencia?roll=<?php echo $_SESSION['usuario_cargo'];?>" target="_blank">
                <i class="fas fa-heartbeat" style="color:limegreen"></i> <span>Segui. Estudiante</span>
                <small class="label pull-right bg-green">Quédate</small>
              </a>
            </li> -->
			  
			  
			  <?php  if($menu==19){$activado="menu-open active";}else{$activado="";} ?>  
			  
			<li>
              <a href="http://ciaf.digital/permanencia_docente?roll=<?php echo $_SESSION['usuario_cargo'];?>" target="_blank">
                <i class="fas fa-heartbeat" style="color:red"></i> <span>Segui. Docente</span>
                <small class="label pull-right bg-green">Guía</small>
              </a>
            </li>
			  
			  <?php  if($menu==20){$activado="menu-open active";}else{$activado="";} ?>  
			  
			  <li>
              <a href="http://ciaf.digital/radicados?roll=<?php echo $_SESSION['usuario_cargo'];?>" target="_blank">
                <i class="far fa-paper-plane"></i> <span>Radicados</span>
                
              </a>
            </li>
			  <?php  if($menu==21){$activado="menu-open active";}else{$activado="";} ?>  
			  
		  	<li class="treeview <?php echo $activado;?>">
              <a href="formatosinstitucionales.php">
                <i class="fas fa-book-open"></i> <span>Formatos Institucionales</span>
              </a>
            </li>
			  
			 <?php 
			if($_SESSION['ingreso']==1){
				    if($menu==22){$activado="menu-open active";}else{$activado="";}
                  echo '
                  
                <li class="treeview '.$activado.'">
                  <a href="#">
                   <i class="fab fa-font-awesome"></i> <span>Menú Ingresos</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu '.$activado.'">';
                    if($_SESSION['ingresociaf']==1){
                        echo '
                            <li><a href="encuestasalud.php"><i class="fa fa-circle-o"></i> CIAF</a></li>
                            
                        ';
                    } 
				    if($_SESSION['ingresovisitante']==1){
                        echo '
                            <li><a href="encuestasaludvisitante.php"><i class="fa fa-circle-o"></i> Visitantes</a></li>
                            
                        ';
					
                    }  
					if($_SESSION['listaringreso']==1){
                        echo '
                            <li><a href="listaringreso.php"><i class="fa fa-circle-o"></i> listar Ingreso</a></li>
                            
                        ';
                    } 
				 
                echo '      
                  </ul>
                </li>
                  
                  ';
              } 
			  
			if($_SESSION['menusofi']==1){
				    if($menu==23){$activado="menu-open active";}else{$activado="";}
                  echo '
                  
                <li class="treeview '.$activado.'">
                  <a href="#">
                   <i class="fab fa-font-awesome"></i> <span>Menú SOFI</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu '.$activado.'">';
                    if($_SESSION['sofipanel']==1){
                        echo '
                            <li><a href="sofi_panel.php"><i class="fa fa-circle-o"></i> Panel</a></li>
                            
                        ';
                    } 
					 if($_SESSION['sofisolicitud']==1){
                        echo '
                            <li><a href="sofi_solicitud.php"><i class="fa fa-circle-o"></i> Solicitud</a></li>
                            
                        ';
                    }

				 
                echo '      
                  </ul>
                </li>
                  
                  ';
              } 
			  
			  ?>


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
