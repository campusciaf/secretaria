<?php
if (strlen(session_id()) < 1) session_start();
error_reporting(0);
if (!$_SERVER['HTTP_REFERER']) {
    echo "<script language='javascript'>window.location='../index.php'</script>";
}
error_reporting(1);
require_once "../modelos/AyudaDependencia.php";
$ayudadep = new AyudaDependencia();
$reg = $ayudadep->listar();
// Inicializar con un valor por defecto si no está definida
$submenu = (isset($submenu)) ? $submenu : 0;
$activado = (isset($activado)) ? $activado : "";
?>
<html lang="es">

<head>
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
    <link rel="icon" type="image/x-icon" href="../public/favicon/favicon-16x16.png">
    <meta name="theme-color" content="#ffffff">
    <title>CIAF | Campus</title>
    <!-- estos son propios -->
    <link rel="stylesheet" href="../public/css/estilos_panel_cv.css" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css?001">
    <!-- iCheck -->
    <link rel="stylesheet" href="../public/plugins/icheck-bootstrap/icheck-bootstrap.min.css?001">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../public/plugins/jqvmap/jqvmap.min.css?001">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/dist/css/adminlte.min.css?001">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css?001">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../public/plugins/daterangepicker/daterangepicker.css?001">
    <!-- summernote -->
    <link rel="stylesheet" href="../public/plugins/summernote/summernote-bs4.css?001">
    <!-- Google Font: Source Sans Pro
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css?001">
    <!-- DATATABLES -->
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css?001">
    <link href="../public/datatables/buttons.dataTables.min.css?001" rel="stylesheet" />
    <link href="../public/datatables/responsive.dataTables.min.css?001" rel="stylesheet" />
    <link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css?001">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../public/css/bootstrap-select.min.css?001">
    <!-- jQuery Alertify -->
    <link rel="stylesheet" href="../public/alertify/css/themes/default.css?001" />
    <link rel="stylesheet" href="../public/alertify/css/alertify.min.css?001" />
    <script src="../public/alertify/alertify.min.js"></script>
    <!-- SweetAlert 2  -->
    <script src="../public/plugins/sweetalert2@11.js"></script>
    <script src="../public/ckeditor/ckeditor.js?001"></script>
    <link href="../public/plugins/bootstrap/bootstrap-datetimepicker.css" rel="stylesheet">
    <!--  slick  -->
    <link rel="stylesheet" type="text/css" href="../public/plugins/slick.css" />
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="../public/plugins/slick-theme.css" />
    <link rel="stylesheet" href="../public/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../public/plugins/introjs.css"><!-- estilos del tour -->
    <link rel="stylesheet" href="../public/css/estilos.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M9V2KQ4" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-light nav-compact fixed-top cabecera">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="panel_admin.php" class="nav-link ">Inicio</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">


                <li class="nav-item dropdown" id="t-paso13">
                    <a class="nav-link" href="#" title="Billetera de puntos">
                        <img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:25px;height:20px">
                        <span class="text-danger font-weight-bolder" id="mispuntos"></span>
                        <span class="text-danger font-weight-bolder">pts</span>
                    </a>
                </li>

                <li class="nav-item dropdown" id="t-paso14">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false" title="Código QR">
                        <i class="fas fa-qrcode"></i>
                        <span class="badge badge-danger navbar-badge">QR</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                        <a href="#" class="dropdown-item">
                            <div class="media">
                                <div class="col-md-12" id="codigo"></div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">Codigo QR</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments" id="t-paso15"></i>
                        <span class="badge badge-danger navbar-badge cantidad_notifi"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="mensaje_cantidad" style="padding: 8px 0px"></div>
                        <div class="dropdown-divider"></div>
                        <span id="menu_notificaciones"></span>
                        <a href="#" class="dropdown-item dropdown-footer">Quédate</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-envelope" id="t-paso16"></i>
                        <span class="badge badge-warning navbar-badge"><?php echo count($reg); ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">Usted tiene <?php echo count($reg); ?> mensajes</span>
                        <div class="dropdown-divider"></div>
                        <?php
                        for ($a = 0; $a < count($reg); $a++) {
                            echo '<a onclick=verAyuda(' . $reg[$a]["id_ayuda"] . ') class="dropdown-item">';
                            if (file_exists('../files/estudiantes/' . $reg[$a]['credencial_identificacion'] . '.jpg')) {
                                echo '<img src=../files/estudiantes/' . $reg[$a]['credencial_identificacion'] . '.jpg class="direct-chat-img" style="width:30px; height:30px">';
                            } else {
                                echo '<img src=../files/null.jpg class="direct-chat-img" style="width:30px; height:30px">';
                            }
                            echo ' ' . substr($reg[$a]["asunto"], 0, 15) . '...
                                    <span class="float-right text-muted text-sm">' . $reg[$a]["fecha_solicitud"] . '</span>
                                </a>';
                        }
                        ?>
                        <div class="dropdown-divider"></div>
                        <a href="ayudadependencia.php" class="dropdown-item dropdown-footer">Notificaciones Contáctanos</a>
                    </div>
                </li>
            </ul>


            <div class="nav-item">
                <div class="dropdown dropdown-toggle  p-1 rounded mr-1" id="m-paso26">
                    <a class="pointer" data-toggle="dropdown" aria-expanded="false" title="Configurar Cuenta">
                        <?php echo $_SESSION['usuario_nombre']; ?>
                    </a>
                    <div class="dropdown-menu">
                        <a class="btn btn-block text-left " href="configurarcuenta.php">
                            <i class="fa-regular fa-user color-icono mr-2"></i> Mi Perfil
                        </a>

                        <a class="btn btn-block text-left" onclick="datosCarnet()" style="cursor:pointer">
                            <i class="fas fa-id-card"></i><span class="badge badge-success navbar-badge">Carnet</span>
                        </a>


                        <a class="btn btn-block text-left" href="percolaborador.php">
                            <i class="fa-solid fa-arrow-up-right-from-square color-icono mr-2"></i> Personalizar
                        </a>

                        <div class="dropdown-divider"></div>
                        <a class="btn btn-block text-left" href="../controlador/usuario.php?op=salir">
                            <i class="fa-solid fa-power-off color-icono mr-2"></i> Salir
                        </a>
                    </div>

                </div>
            </div>

        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="panel_admin.php" class="brand-link pb-0 text-center">
                <div class="animadologo d-xl-block d-lg-block d-md-none d-none">
                    <div class="iconologo"></div><img src="../public/img/iconologo.gif">
                </div>
                <!-- <img src="../public/img/i_ciafi.webp" alt="campus" class="brand-image"> -->
                <span class="text-white font-weight-bolder fs-20"><b>CIAF Virtual</b></span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <div class="row usuario-nav">
                            <div class="col-12 text-center">
                                <?php
                                if (file_exists('../files/usuarios/' . @$_SESSION['usuario_imagen'])) {
                                    echo $foto = '<img src=../files/usuarios/' . @$_SESSION['usuario_imagen'] . ' class="img-circle elevation-2" alt="Usuario" style="width:60px;height:60px">';
                                } else {
                                    echo $foto = '<img src=../files/null.jpg width=60px height=60px class="img-circle elevation-2" alt="Usuario" style="width:60px;height:60px">';
                                }
                                if (@$_SESSION['abrir_reporte_influencer'] == 1) {

                                    echo '<div id="influencer" style="position:absolute;left:140px;top:0px"><i class="fa-solid fa-heart text-danger fs-24" title="Influencer +"></i></div>';
                                }
                                ?>
                            </div>
                            <div class="col-12 text-center pt-2 text-white font-weight-bolder fs-14">
                                <?php echo @$_SESSION['usuario_nombre'] . " " . @$_SESSION['usuario_apellido'] ?>
                            </div>
                            <div class="col-12 text-center text-white fs-12 text-center"><?php echo $_SESSION['usuario_cargo']  ?></div>
                            <div class="col-12 text-center py-2">
                                <div class="row justify-content-center">
                                    <div class="col-2">
                                        <div class="dropdown">
                                            <a class="pointer" data-toggle="dropdown" aria-expanded="false" title="Configurar Cuenta">
                                                <i class="fa-solid fa-gear color-icono"></i>
                                            </a>
                                            <div class="dropdown-menu" style="margin-left:-50px">
                                                <a class="btn btn-block text-left " href="configurarcuenta.php">
                                                    <i class="fa-regular fa-user color-icono mr-2"></i> Mi Perfil
                                                </a>
                                                <a class="btn btn-block text-left" href="percolaborador.php">
                                                    <i class="fa-solid fa-arrow-up-right-from-square color-icono mr-2"></i> Personalizar
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="btn btn-block text-left" href="../controlador/usuario.php?op=salir">
                                                    <i class="fa-solid fa-power-off color-icono mr-2"></i> Salir
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <a href="../controlador/usuario.php?op=salir" class="" title="Salir">
                                            <i class="fa-solid fa-power-off color-icono"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($menu == 10001) {
                            $activado = "active";
                        } else {
                            $activado = "";
                        }
                        ?>
                        <li class="nav-item">
                            <a href="panel_admin.php" class="nav-link <?php echo $activado; ?>">
                                <p><i class="fa-solid fa-gauge"></i> Inicio</p>
                            </a>
                        </li>
                        <?php

                        if (@$_SESSION['menudashboard'] == 1) {
                            if ($menu == 35) {
                                $abierto = "menu-open";
                                $activado = "active";
                            } else {
                                $abierto = "";
                                $activado = "";
                            }
                            echo '
                            <li class="nav-item has-treeview ' . $abierto . '">
                                <a href="#" class="nav-link ' . @$activado . '">
                                    <div class="mi-ico"><i class="fa-solid fa-chart-line"></i></div>
                                    <p>
                                        Dashboard Power BI
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview ' . $abierto . '">';

                            if (@$_SESSION['pb-rematricula'] == 1) {
                                if ($submenu == 3402) {
                                    $activo = "active";
                                } else {
                                    $activo = "";
                                } // condicional para el boton activado
                                echo '<li class="nav-item">
                                                <a href="pb-rematricula.php" class="nav-link ' . $activo . '">
                                                    <p>Rematricula</p>
                                                </a>
                                            </li>';
                            }
                            echo '      
                                </ul>
                            </li>';
                        }
                        if (@$_SESSION['menupoa'] == 1) {
                            if ($menu == 2) {
                                $abierto = "menu-open";
                                $activado = "active";
                            } else {
                                $abierto = "";
                                $activado = "";
                            }
                            echo '
                            <li class="nav-item has-treeview ' . $abierto . '">
                                    <a href="#" class="nav-link ' . $activado . '">
                                    <div class="mi-ico"><i class="fa-solid fa-plane-up"></i></div>
                                        <p>Estratégica  <i class="fas fa-angle-left right"></i></p>
                                    </a>
                                <ul class="nav nav-treeview ' . $abierto . '">';
                            if (@$_SESSION['adminejes'] == 1) {
                                if ($submenu == 200) {
                                    $activo = "active";
                                } else {
                                    $activo = "";
                                } // condicional para el boton activado
                                echo '<li class="nav-item">
                                            <a href="ejes.php" class="nav-link ' . $activo . '">
                                                <p>Ejes temáticos</p>
                                            </a>
                                        </li>';
                            }


                            if (@$_SESSION['sac_planeacion'] == 1) {
                                if ($submenu == 212) {
                                    $activo = "active";
                                } else {
                                    $activo = "";
                                } // condicional para el boton activado
                                echo '<li class="nav-item">
                                                    <a href="sac_proyecto.php" class="nav-link ' . $activo . '">
                                                        <p>Visión del plan</p>
                                                    </a>
                                                </li>';
                            }

                            if (@$_SESSION['sac_listar_dependencia'] == 1) {
                                if ($submenu == 215) {
                                    $activo = "active";
                                } else {
                                    $activo = "";
                                } // condicional para el boton activado
                                echo '<li class="nav-item">
                                            <a href="sac_listar_dependencia.php" class="nav-link ' . $activo . '">
                                                <p>Planificación</p>
                                            </a>
                                        </li>';
                            }



                            if (@$_SESSION['sactareas'] == 1) {
                                if ($submenu == 222) {
                                    $activo = "active";
                                } else {
                                    $activo = "";
                                } // condicional para el boton activado
                                echo '<li class="nav-item">
                                                    <a href="sactareas.php" class="nav-link ' . $activo . '">
                                                        <p>Mi POA</p>
                                                    </a>
                                                </li>';
                            }
                            echo '
                                </ul>
                            </li>';
                        }


                        ?>
                    </ul>
                    <br><br>
                </nav>
            </div>
        </aside>
        <!-- Modal -->
        <div class="modal fade" id="perfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Actualizar perfil</h5>
                    </div>
                    <div class="modal-body">
                        <form name="formularioperfil" id="formularioperfil" method="POST">
                            <div class="group col-xl-12">
                                <input type="email" required name="usuario_email" id="usuario_email">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Correo Electronico personal (No CIAF)</label>
                            </div>
                            <div class="group col-xl-12">
                                <input type="text" name="usuario_telefono" id="usuario_telefono">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Telefono fijo</label>
                            </div>
                            <div class="group col-xl-12">
                                <input type="text" name="usuario_celular" id="usuario_celular">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Número celular</label>
                            </div>
                            <div class="group col-xl-12">
                                <input type="text" name="usuario_direccion" id="usuario_direccion">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Dirección de residencia</label>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar cambios </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal carnet -->
        <div class="modal fade" id="modalcarnet">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="frente"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <section class="mini col-12 bg-4 d-xl-none d-lg-none d-md-none d-sm-block" style="position:fixed; bottom:0px; z-index:1">
            <div class="row justify-content-center">
                <div class="col-2 text-center p-0">
                    <a href='panel_admin.php' class="btn"><i class="fa-solid fa-house text-white"></i><br><span class="text-white">Inicio</span></a>
                </div>
                <div class="col-2 text-center">
                    <a href='general.php' class="btn"><i class="fa-solid fa-chart-simple text-white"></i><br><span class="text-white">Tablero</span></a>
                </div>
                <div class="col-3 text-center p-0" style="position:relative">
                    <div class="row justify-content-center">
                        <div class=" bg-1 rounded-circle shadow" style="margin-top: -16px; padding:12px">
                            <a href='sac_ejecucion.php' class="btn"><i class="fa-solid fa-calendar-days text-white "></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-2 text-center p-0">
                    <a href='cvpanel.php' class="btn"><i class="fa-solid fa-heart-pulse text-white"></i><br><span class="text-white">Cv</span></a>
                </div>
                <div class="col-2 text-center p-0">
                    <a href='mi_blog.php' class="btn"><i class="fa-solid fa-database text-white"></i><br><span class="text-white">Blog</span></a>
                </div>
            </div>
        </section>
        <audio id="notification-sound" src="../sonido.mp3" preload="auto"></audio>
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