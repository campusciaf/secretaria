<?php
if (strlen(session_id()) < 1) session_start();
if (!$_SERVER['HTTP_REFERER']) {
    echo "<script language='javascript'>window.location='../index.php'</script>";
}
require_once "../modelos/Usuario.php";
$usuario = new Usuario();
?>
<!DOCTYPE html>
<html>

<head>
    <title> CIAFI | Académico </title>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-M9V2KQ4');
    </script>
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
    <link rel="icon" type="image/png" sizes="192x192" href="../public/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../public/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../public/favicon/favicon-16x16.png">
    <link rel="manifest" href="../public/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="../public/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.min.css" />
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
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
    <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">
    <!-- jQuery Alertify -->
    <link rel="stylesheet" href="../public/alertify/css/themes/default.css" />
    <link rel="stylesheet" href="../public/alertify/css/alertify.min.css" />
    <script src="../public/alertify/alertify.min.js"></script>
    <!-- ********************** -->
    <!-- *********** SweetAlert2 ***** -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../public/ckeditor/ckeditor.js"></script>
    <script src="../public/ckeditor/samples/js/sample.js"></script>
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- * *************** slick ******************* -->
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://unpkg.com/intro.js/introjs.css"><!-- estilos del tour -->
    <link rel="stylesheet" href="../public/css/estilos.css"><!-- estos son propios -->
</head>

<?php
if (file_exists('../files/docentes/' . $_SESSION['usuario_imagen'] . '.jpg')) {
    $foto = '<img src="../files/docentes/' . $_SESSION['usuario_imagen'] . '.jpg?' . date("Y-m-d H:i:s") . '" class="img-circle" alt="Usuario" style="width:50px;height:50px">';
    $foto2 = '<img src="../files/docentes/' . $_SESSION['usuario_imagen'] . '.jpg?' . date("Y-m-d H:i:s") . '" class="img-circle" alt="Usuario" style="width:30px;height:30px">';
} else {
    $foto = '<img src=../files/null.jpg width=50px height=50px class="img-circle" alt="Usuario" style="width:50px;height:50px">';
    $foto2 = '<img src=../files/null.jpg  class="rounded-circle" alt="Usuario" style="width:36px;height:30px">';
}
?>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
    <noscript> <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M9V2KQ4" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top cabecera">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="panel_docente.php" class="nav-link"> Inicio </a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown" id="t-paso13">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fas fa-qrcode"></i>
                        <span class="badge badge-danger navbar-badge">QR</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <div class="col-md-12" id="codigo"></div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">Codigo QR</a>
                    </div>
                </li>
                <li class="nav-item dropdown " id="t-paso26">
                    <a class="nav-link" href="#" title="Billetera de puntos">
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
                        <a class="btn btn-block text-left " href="configurarcuentadocente.php">
                            <i class="fa-regular fa-user color-icono mr-2"></i> Mi Perfil
                        </a>
                        <a class="btn btn-block text-left " href="carnetdocente.php">
                            <i class="fa-regular fa-address-card"></i> Mi carnet
                        </a>
                        <a class="btn btn-block text-left" href="perdocente.php">
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
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->

            <!-- Brand Logo -->
            <a href="panel_docente.php" class="brand-link pb-0 text-center">
                <div class="animadologo d-xl-block d-lg-block d-md-none d-none">
                    <div class="iconologo"></div><img src="../public/img/iconologo.gif">
                </div>
                <!-- <img src="../public/img/i_ciafi.webp" alt="campus" class="brand-image"> -->
                <span class="text-white font-weight-bolder fs-20"><b>CIAF Virtual</b></span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar" style="margin-top: 5px">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <div class="row usuario-nav">
                            <div class="col-12 text-center">
                                <?php
                                if (file_exists('../files/docentes/' . $_SESSION['usuario_imagen'] . '.jpg')) {
                                    echo $foto = '<img src=../files/docentes/' . $_SESSION['usuario_imagen'] . '.jpg class="img-circle elevation-2" alt="Usuario" style="width:60px;height:60px">';
                                    
                                } else {
                                    echo $foto = '<img src=../files/null.jpg width=60px height=60px class="img-circle elevation-2" alt="Usuario" style="width:60px;height:60px">';
                                }
                                echo '<div id="estrella" style="position:absolute;left:140px;top:1px"> </div>';
                                echo '<div id="influencer" style="position:absolute;left:145px;top:26px"></div>';
                                ?>
                            </div>
                            <div class="col-12 text-center p-2 text-white font-weight-bolder">
                                <?php echo $_SESSION['usuario_nombre'] . " " . $_SESSION['usuario_apellido'] . ""; ?>
                            </div>
                            <div class="col-12 text-center">
                                <div class="row justify-content-center">
                                    <div class="col-2">
                                        <div class="dropdown" id="m-paso8">
                                            <a class="pointer" data-toggle="dropdown" aria-expanded="false" title="Configurar Cuenta">
                                                <i class="fa-solid fa-gear color-icono"></i>
                                            </a>
                                            <div class="dropdown-menu" style="margin-left:-50px">
                                                <a class="btn btn-block text-left " href="configurarcuentadocente.php">
                                                    <i class="fa-regular fa-user color-icono mr-2"></i> Mi Perfil
                                                </a>
                                                <a class="btn btn-block text-left" href="perdocente.php">
                                                    <i class="fa-solid fa-arrow-up-right-from-square color-icono mr-2"></i> Personalizar
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="btn btn-block text-left" href="../controlador/usuario.php?op=salir">
                                                    <i class="fa-solid fa-power-off color-icono mr-2"></i> Salir
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2" id="m-paso9">
                                        <a href="../controlador/usuario.php?op=salir" class="" title="Salir">
                                            <i class="fa-solid fa-power-off color-icono"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($menu == 0) {
                            $abierto = "menu-open";
                            $activado = "active";
                        } else {
                            $abierto = "";
                            $activado = "";
                        }
                        ?>
                        <li class="nav-item" id="m-paso6">
                            <a href="panel_docente.php" class="nav-link <?php echo $activado; ?>">
                                <i class="fa-solid fa-house"></i>
                                <p>Inicio</p>
                            </a>
                        </li>

                        <?php
                        if ($menu == 7) {
                            $abierto = "menu-open";
                            $activado = "active";
                        } else {
                            $abierto = "";
                            $activado = "";
                        }
                        ?>
                        <li class="nav-item " id="m-paso6">
                            <a href="configurarcuentadocente.php" class="nav-link <?php echo $activado; ?>">
                                <i class="fa-solid fa-id-badge"></i>
                                <p>Mi perfil</p>
                            </a>
                        </li>

                        <?php
                        $data = array();
                        $data["0"] = "";
                        $rspta = $usuario->listarcursos($_SESSION['id_usuario']);
                        $reg = $rspta;
                        if ($menu == 1) {
                            $abierto = "menu-open";
                            $activado = "active";
                        } else {
                            $abierto = "";
                            $activado = "";
                        }
                        ?>
                        <li class="nav-item has-treeview <?php echo $abierto; ?>" id="m-paso1">
                            <a href="#" class="nav-link <?php echo $activado; ?>">
                                <i class="fa-solid fa-school-circle-check"></i>
                                <p>
                                    Mis clases

                                    <i class="fas fa-angle-left right"></i>
                                    <span class="right badge badge-danger mr-2">Ver</span>
                                </p>
                            </a>
                            <ul class="nav nav-treeview <?php echo $abierto; ?>">
                                <li class="nav-item">
                                    <a href="docentegrupos.php" class="nav-link">
                                        <p>Lista de grupos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="docentegruposanterior.php" class="nav-link">
                                        <p>Lista grupo anterior</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="docente_cursos_ec.php" class="nav-link">
                                        <p>Educación continuada</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="horariodocentepersonal.php" class="nav-link">
                                        <p>
                                            Horario general
                                        </p>
                                    </a>
                                </li>
                                <?php
                                /*
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
                                                <li class="nav-item">
                                                    <span class="text-white-50 nav-link">
                                                        <p class="small">'.$jor_real.' | G-'.$reg[$i]["grupo"].' '.$dia.' : '.$salon.'<br>' . substr($reg2["nombre"],0,30) .'... <br> ' . substr($reg[$i]["materia"],0,30) .'...</p><br>
                                                        <div class="btn-group">
                                                            <a href="docente.php?id='.$reg[$i]["id_docente"].'&ciclo='.$reg[$i]["ciclo"].'&materia='.$reg[$i]["materia"].'&jornada='.$reg[$i]["jornada"].'&id_programa='.$reg[$i]["id_programa"].' &grupo='.$reg[$i]["grupo"].' " title="'.$reg2["nombre"].'" class="btn btn-default btn-sm"> Grupo </a>
                                                            <a href="peadocente.php?id='.$reg[$i]["id_docente_grupo"].'" class="btn btn-default btn-sm">PEA </a>
                                                        </div>
                                                    </span>
                                                </li>
                                            ';  
                                        }
                                        echo $data["0"];
                                */
                                ?>
                            </ul>
                        </li>

                        <?php
                        if ($menu == 3) {
                            $abierto = "menu-open";
                            $activado = "active";
                        } else {
                            $abierto = "";
                            $activado = "";
                        }
                        ?>
                        <li class="nav-item has-treeview <?php echo $abierto; ?>" id="m-paso3">
                            <a href="#" class="nav-link <?php echo $activado; ?>">
                                <i class="fa-solid fa-laptop-code"></i>
                                <p>
                                    Medios educativos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview <?php echo $abierto; ?>">
                                <li class="nav-item">
                                    <a href="bibliotecaciaf.php" class="nav-link">
                                        <p>Biblioteca</p>
                                    </a>
                                </li>
                                <li class="nav-item">
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
                                    <a href="software_libre.php" class="nav-link">
                                        <p>Caja de herramientas</p>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a href="disponibilidad_salones.php" class="nav-link">
                                        <p>Reservar Salón</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="reservaequipo.php" class="nav-link">
                                        <p>Reservas de Equipos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://docs.google.com/forms/d/e/1FAIpQLScjONg2dF7waQCBjtFBDx2qDgUwHwjvXjjqeKtOOwgZicV6ww/viewform" target="_blank" class="nav-link">
                                        <p>Asistencia Técnica</p>
                                    </a>
                                </li>
                                <li class="nav-item" id="m-paso7">
                                    <a href="formatoinstitucionaldocente.php" class="nav-link">
                                        <p>Formatos Institucionales</p>
                                    </a>
                                </li>
                            </ul>
                        </li>



                        <?php
                        if ($menu == 11) {
                            $abierto = "menu-open";
                            $activado = "active";
                        } else {
                            $abierto = "";
                            $activado = "";
                        }
                        ?>
                        <li class="nav-item" id="m-paso6">
                            <a href="dashboarddoc.php" class="nav-link <?php echo $activado; ?>">
                                <i class="fa-solid fa-chart-simple"></i>
                                <p>Mis estadística</p>
                            </a>
                        </li>

                        <?php
                        if ($menu == 2) {
                            $abierto = "menu-open";
                            $activado = "active";
                        } else {
                            $abierto = "";
                            $activado = "";
                        }
                        ?>
                        <li class="nav-item d-none" id="m-paso2">
                            <a href="horariodocentepersonal.php" class="nav-link <?php echo $activado; ?>">
                                <i class="fa-regular fa-clock"></i>
                                <p>
                                    Horario
                                    <span class="right badge badge-danger">Ver</span>
                                </p>
                            </a>
                        </li>

                        <?php if ($menu == 5) {
                            $abierto = "menu-open";
                            $activado = "active";
                        } else {
                            $abierto = "";
                            $activado = "";
                        }   ?>
                        <li class="nav-item has-treeview <?php echo $abierto; ?> " id="m-paso5">
                            <a href="#" class="nav-link <?php echo $activado; ?>">
                                <i class="fa-solid fa-closed-captioning"></i>
                                <p>
                                    Mi hoja de vida
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview <?php echo $abierto; ?>">
                                <li class="nav-item">
                                    <a href="cv_hoja_online.php" class="nav-link" target="_blank">
                                        <p>Ver Hoja de vida online</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="cvpanel.php" class="nav-link">
                                        <p>Hoja de vida</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php if ($menu == 6) {
                            $abierto = "menu-open";
                            $activado = "active";
                        } else {
                            $abierto = "";
                            $activado = "";
                        }   ?>

                        <?php
                        if ($menu == 13) {
                            $abierto = "menu-open";
                            $activado = "active";
                        } else {
                            $abierto = "";
                            $activado = "";
                        }
                        ?>
                        <li class="nav-item" id="m-paso6">
                            <a id="m-carac" href="puntos_billetera_docente.php" class="nav-link <?php echo $activado; ?>">
                                <i class="fas fa-wallet"></i>
                                <p>Billetera Docente</p>
                            </a>
                        </li>
                        <?php
                        if ($menu == 12) {
                            $abierto = "menu-open";
                            $activado = "active";
                        } else {
                            $abierto = "";
                            $activado = "";
                        }
                        ?>
                        <li class="nav-item" id="m-paso6">
                            <a id="m-carac" href="curso_para_creativos.php" class="nav-link <?php echo $activado; ?>">
                                <i class="fas fa-hands-holding-circle text-center"></i>
                                <p>CIAF Virtual</p>
                            </a>
                        </li>
                        <?php
                        if ($menu == 10) {
                            $abierto = "menu-open";
                            $activado = "active";
                        } else {
                            $abierto = "";
                            $activado = "";
                        }
                        ?>
                        <li class="nav-item d-none" id="m-paso6">
                            <a id="m-carac" href="caracterizaciondocente.php" class="nav-link <?php echo $activado; ?>">
                                <i class="fa-solid fa-database text-center"></i>
                                <p>Caracterización</p>
                            </a>
                        </li>
                        <?php
                        if ($menu == 8) {
                            $abierto = "menu-open";
                            $activado = "active";
                        } else {
                            $abierto = "";
                            $activado = "";
                        }
                        ?>
                        <li class="nav-item">
                            <a href="reporte_influencer.php" class="nav-link d-none <?php echo $activado; ?>">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>Reporte Influencer</p>
                            </a>
                        </li>
                        <li class="nav-header inactive d-none">General</li>
                        <?php
                        if ($menu == 9) {
                            $abierto = "menu-open";
                            $activado = "active";
                        } else {
                            $abierto = "";
                            $activado = "";
                        }
                        ?>
                        <li class="nav-item d-none" id="m-paso7">
                            <a href="formatoinstitucionaldocente.php" class="nav-link <?php echo $activado; ?>">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>Formatos Institucionales</p>
                            </a>
                        </li>
                        <div class="row justify-content-center m-0" id="nivel">
                        </div>
                    </ul>
                </nav>
            </div><!-- /.sidebar -->
        </aside>
        <section class="mini col-12 bg-4 d-xl-none d-lg-none d-md-none d-sm-block" style="position:fixed; bottom:0px; z-index:1">
            <div class="row justify-content-center">
                <div class="col-auto text-center">
                    <a href='panel_docente.php' class="btn"><i class="fa-solid fa-house text-white"></i><br><span class="text-white">Inicio</span></a>
                </div>
                <div class="col-auto text-center">
                    <a href='dashboarddoc.php' class="btn"><i class="fa-solid fa-chart-simple text-white"></i><br><span class="text-white">Tablero</span></a>
                </div>
                <div class="col-auto text-center " style="position:relative">
                    <div class="row">
                        <div class="col-12 bg-1 rounded-circle shadow" style="margin-top: -16px; padding:12px">
                            <a href='docentegrupos.php' class="btn"><i class="fa-solid fa-calendar-days text-white "></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-center">
                    <a href='cvpanel.php' class="btn"><i class="fa-solid fa-heart-pulse text-white"></i><br><span class="text-white">Cv</span></a>
                </div>
                <div class="col-auto text-center">
                    <a href='caracterizaciondocente.php' class="btn"><i class="fa-solid fa-database text-white"></i><br><span class="text-white">Datos</span></a>
                </div>
            </div>
        </section>
        <div class="modal fade" id="modalcurso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h4>Domina el campus virtual</h4>
                        <hr>
                        <p class="text-justify">
                            Bienvenido <b>Docente CIAF</b> en este curso aprenderás a navegar en el campus virtual, a subir tus
                            actividades, calificar a nuestros seres originales e interactuar con ellos, explorando todas las
                            herramientas disponibles que tenemos para ti.
                        </p>
                        <a href="curso_para_creativos.php" class="btn btn-outline-primary"> <i class="fas fa-face-grin-stars fa-3x"></i> <br> Empezar el curso</a>
                    </div>
                </div>
            </div>
        </div>

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