<?php
if (strlen(session_id()) < 1) session_start();
    require_once("../controlador/cv_hoja_de_vida_personal.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Hoja de vida - <?php echo $info_usuario['usuario_nombre'] . " " . $info_usuario['usuario_apellido'] ?></title>
    <link rel="stylesheet" href="../cv/public/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../cv/public/css/font-awesome-5.css" />
    <link rel="stylesheet" href="../cv/public/css/AdminLTE.min.css" />
    <link rel="stylesheet" href="../cv/public/css/_all-skins.min.css" />
    <link rel="stylesheet" href="../cv/public/css/bootstrap-select.min.css" />
    <link rel="stylesheet" href="../cv/public/css/bootstrap-datetimepicker.css" />
    <link rel="stylesheet" href="../cv/public/css/estilos_panel.css" />
    <link rel="stylesheet" href="../cv/public/css/palette-colors.css" />
    <link rel="stylesheet" href="../cv/public/datatables/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="../cv/public/datatables/buttons.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../cv/public/datatables/responsive.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../cv/public/alertify/css/themes/default.css" />
    <link rel="stylesheet" href="../cv/public/alertify/css/alertify.min.css" />
    <link rel="shortcut icon" type="image/png" href="../cv/public/images/icon_cv.png" />
    
</head>
<body class="hold-transition skin-blue-light sidebar-mini fixed">
    <section class="container">
         
        <div class="row">
            <div class="bg-white" style="margin-top: 4em">
                <h1 class="text-center"><?php echo $info_usuario['usuario_nombre'] . " " . $info_usuario['usuario_apellido']; ?></h1>
                <h2 class="text-center text-gray"><?php echo $info_usuario['titulo_profesional']; ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="page-header" style=" margin-bottom: 0px;">
                <h3>Datos Personales</h3>
            </div>
            <div class="table-datos_personales">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <td width="182">Nombre: </td>
                            <td width="925"><?php echo $info_usuario['usuario_nombre']; ?></td>
                            <td width="925" rowspan="12" valign="top" align="right">
                                <img src="../cv/files/usuarios/<?php echo $info_usuario['usuario_imagen']; ?>" width="50%">
                            </td>
                        </tr>
                        <tr>
                            <td>Apellidos:</td>
                            <td><?php echo $info_usuario['usuario_apellido']; ?></td>
                        </tr>
                        <tr>
                            <td>Cédula:</td>
                            <td><?php echo $info_usuario['usuario_identificacion']; ?></td>
                        </tr>
                        <tr>
                            <td>Fecha de nacimiento: </td>
                            <td><?php echo $info_usuario['fecha_nacimiento']; ?></td>
                        </tr>
                        <tr>
                            <td> Edad: </td>
                            <td><?php echo $info_usuario['edad']; ?></td>
                        </tr>
                        <tr>
                            <td>Nacionalidad: </td>
                            <td> <?php echo $info_usuario['nacionalidad']; ?></td>
                        </tr>
                        <tr>
                            <td>Estado civil: </td>
                            <td><?php echo $info_usuario['estado_civil']; ?></td>
                        </tr>
                        <tr>
                            <td>Dirección:</td>
                            <td><?php echo $info_usuario['direccion']; ?></td>
                        </tr>
                        <tr>
                            <td>Departamento: </td>
                            <td><?php echo $info_usuario['departamento']; ?></td>
                        </tr>
                        <tr>
                            <td>Vivo en: </td>
                            <td><?php echo $info_usuario['ciudad']; ?></td>
                        </tr>
                        <tr>
                            <td>E-mail:</td>
                            <td><?php echo $info_usuario['usuario_email']; ?></td>
                        </tr>
                        <tr>
                            <td>Números de teléfono:</td>
                            <td><?php echo $info_usuario['celular']; ?></td>
                        </tr>
                        <tr>
                            <td>Sitio web: </td>
                            <td><?php echo $info_usuario['pagina_web']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> 

        <div class="row">
            <div class="page-header">
                <h3>Perfil</h3>
            </div>
            <p class="text-justify"><?php echo $info_usuario['resumen_perfil']; ?></p>
        </div>

        <div class="row">
    <div class="page-header">
        <h3>Formación Académica</h3>
    </div>
    <?php
    if (count($educacions_arr) > 0) {
        for ($i = 0; $i < count($educacions_arr); $i++) {
            $datos_url = explode('../', $educacions_arr[$i]["certificado_educacion"]);
            if (empty($educacions_arr[$i]["certificado_educacion"])) {
                $ultimo = '<div class="mb-8"></div>';
            } else {
                $ultimo = '<a href="../cv/' . $datos_url[1] . '" target="_blank">
                                <img class="profile-user-img img-responsive img-circle" src="../cv/public/img/icon file.png" alt="User profile picture">
                            </a>';
            }
            if (empty($educacions_arr[$i]["institucion_academica"])) {
                echo '<span class="text-center col-md-12">No hay Formación Académica disponible.</span>';
            } else {
                echo '
                <div class="col-md-3 form-group">
                    <div class="box-body box-profile"> 
                        <ul class="list-group">
                            <li class="list-group-item">
                                ' . $ultimo . '
                            </li>
                            <li class="list-group-item">
                                <h4 class="text-bold">' . $educacions_arr[$i]["institucion_academica"] . '</h4>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-calendar-alt"></i><b>' . $educacions_arr[$i]["desde_cuando_f"] . " " . $educacions_arr[$i]["hasta_cuando_f"] . ' </b>
                            </li>
                            <li class="list-group-item">
                                <b>' . $educacions_arr[$i]["titulo_obtenido"] . '</b>
                            </li>
                            <li class="list-group-item">
                                <b>' . $educacions_arr[$i]["mas_detalles_f"] . '</b>
                            </li>
                        </ul>
                    </div>
                </div>
                ';
            }
        }
    } 

    ?>
</div>
<div class="row">
    <br>
    <div class="page-header">
        <h3>Experiencia laboral</h3>
    </div>

    <?php
    if (count($experiencias_arr) > 0) {
        for ($i = 0; $i < count($experiencias_arr); $i++) {
            if (empty($experiencias_arr[$i]["nombre_empresa"])) {
                echo '<span class="text-center col-md-12">No hay experiencias laborales disponibles.</span>';
            } else {
                echo '
                <div class="col-md-3">
                    <div class="box-body box-profile">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <h4 class="text-bold">' . $experiencias_arr[$i]["nombre_empresa"] . '</h4>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-calendar-alt"></i> <b>' . $experiencias_arr[$i]["desde_cuando"] . ' ' . $experiencias_arr[$i]["hasta_cuando"] . '</b>
                            </li>
                            <li class="list-group-item">
                                <b>' . $experiencias_arr[$i]["cargo_empresa"] . '</b>
                            </li>
                            <li class="list-group-item">
                                <b>' . $experiencias_arr[$i]["mas_detalles"] . '</b>
                            </li>
                        </ul>
                    </div>
                </div>
                ';
            }
        }
    } else {
        echo '<span class="text-center col-md-12">No hay experiencias laborales disponibles.</span>';
    }
    ?>
</div>


        <div class="row">
            <div class="page-header">
                <h3>Habilidades y Aptitudes</h3>
            </div><?php

                    for ($i = 0; $i < count($habilidad_arr); $i++) {

                    ?>

                <div class="col-md-3" style="margin-bottom: 20px">
                    <div class="progress-group">
                        <span class="progress-text"><?php echo $habilidad_arr[$i]["nombre_categoria"]; ?></span>
                        <span class="progress-number"><b><?php echo $habilidad_arr[$i]["nivel_habilidad"]; ?></b>/5</span>
                        <div class="progress active">
                            <div class="progress-bar progress-bar-striped <?php echo $habilidad_arr[$i]["color"]; ?>" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo (intval($habilidad_arr[$i]["nivel_habilidad"]) * 2) ?>0%">
                            </div>
                        </div>

                    </div>
                </div>

            <?php

                    }

            ?>

        </div>

        <div class="row">
    <div class="page-header">
        <h3>Referencias personales</h3>
    </div>

    <?php
    if (count($referencias_arr) > 0) {
        for ($i = 0; $i < count($referencias_arr); $i++) {
            if (empty($referencias_arr[$i]["referencias_nombre"])) {
                echo '<span class="text-center col-md-12">No hay referencias personales disponibles.</span>';
            } else {
                echo '
                <div class="col-md-3">
                    <div class="box-body box-profile">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <h4 class="text-bold">' . $referencias_arr[$i]["referencias_nombre"] . '</h4>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-calendar-alt"></i> <b>' . $referencias_arr[$i]["referencias_profesion"] . '</b>
                            </li>
                            <li class="list-group-item">
                                <b>' . $referencias_arr[$i]["referencias_empresa"] . '</b>
                            </li>
                            <li class="list-group-item">
                                <b>' . $referencias_arr[$i]["referencias_telefono"] . '</b>
                            </li>
                        </ul>
                    </div>
                </div>
                ';
            }
        }
    } else {
        echo '<span class="text-center col-md-12">No hay referencias personales disponibles.</span>';
    }
    ?>

</div>


<div class="row">
    <div class="page-header">
        <h3>Referencias Laborales</h3>
    </div>

    <?php
    if (count($referenciasL_arr) > 0) {
        for ($i = 0; $i < count($referenciasL_arr); $i++) {
            if (empty($referenciasL_arr[$i]["referencias_nombrel"])) {
                echo '<span class="text-center col-md-12">No hay referencias laborales disponibles.</span>';
            } else {
                echo '
                <div class="col-md-3">
                    <div class="box-body box-profile">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <h4 class="text-bold">' . $referenciasL_arr[$i]["referencias_nombrel"] . '</h4>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-user"></i> <b>' . $referenciasL_arr[$i]["referencias_profesionl"] . '</b>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-city"></i> <b>' . $referenciasL_arr[$i]["referencias_empresal"] . '</b>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-phone-square"></i> <b>' . $referenciasL_arr[$i]["referencias_telefonol"] . '</b>
                            </li>
                        </ul>
                    </div>
                </div>
                ';
            }
        }
    } else {
        echo '<span class="text-center col-md-12">No hay referencias laborales disponibles.</span>';
    }
    ?>
</div>


<div class="row">
    <div class="page-header">
        <h3>Documentos</h3>
    </div>

    <?php
    for ($i = 0; $i < count($documentosO_arr); $i++) {
        // $datos_url =  explode('../', );

        if (empty($documentosO_arr[$i]["documento_nombre"])) {
            echo '<span class="text-center col-md-12">No hay documentos disponibles.</span>';
        } else {
            echo '
            <div class="col-md-12">
                <table class="table table-condensed table-responsive">
                    <tr>
                        <td>
                            <h4>' . $documentosO_arr[$i]["documento_nombre"] . '</h4>
                            <div class="col-md-3">
                                <div class="box-body box-profile">
                                    <a href="' . $documentosO_arr[$i]["documento_archivo"] . '" target="_blank">
                                        <img class="profile-user-img img-responsive img-circle" src="../cv/public/img/icon file.png" alt="User profile picture">
                                    </a>
                                </div>
                            </div>
                        </td>
                        
                    </tr>
                </table>
            </div>
            ';
        }
    }
    ?>

</div>

<div class="row">
    <div class="page-header">
        <h3>Archivos Adicionales</h3>
    </div>

    <?php
    for ($i = 0; $i < count($documentosA_arr); $i++) {
        $datos_url =  explode('../', $documentosA_arr[$i]["documento_archivoA"]);

        if (empty($documentosA_arr[$i]["documento_nombreA"])) {
            echo '<div class="text-center col-md-12">No hay archivos adicionales disponibles.</div>';
        } else {
            echo '
            <div class="col-md-12">
                <table class="table table-condensed table-responsive">
                    <tr>
                        <td>
                            <h4>' . $documentosA_arr[$i]["documento_nombreA"] . '</h4>
                            <div class="col-md-3">
                                <div class="box-body box-profile">
                                    <a href="../' . $datos_url[1] . '" target="_blank">
                                        <img class="profile-user-img img-responsive img-circle" src="../cv/public/img/icon file.png" alt="User profile picture">
                                    </a>
                                </div>
                            </div>
                        </td>
                        
                    </tr>
                </table>
            </div>
            ';
        }
    }
    ?>

</div>


    </section>

    <script src="../cv/public/js/jquery-3.1.1.min.js"></script>
    <script src="../cv/public/js/bootstrap.min.js"></script>
    <script src="../cv/public/js/app.min.js"></script>
    <script src="../cv/public/js/bootbox.min.js"></script>
    <script src="../cv/public/js/bootstrap-select.min.js"></script>
    <script src="../cv/public/js/jquery.slimscroll.min.js"></script>
    <script src="../cv/public/js/eventlisten.js"></script>
    <script src="../cv/public/js/moment-with-locales.js"></script>
    <script src="../cv/public/datatables/jquery.dataTables.min.js"></script>
    <script src="../cv/public/datatables/dataTables.buttons.min.js"></script>
    <script src="../cv/public/datatables/buttons.colVis.min.js"></script>
    <script src="../cv/public/datatables/buttons.flash.min.js"></script>
    <script src="../cv/public/datatables/buttons.html5.min.js"></script>
    <script src="../cv/public/datatables/buttons.print.min.js"></script>
    <script src="../cv/public/datatables/jszip.min.js"></script>
    <script src="../cv/public/datatables/pdfmake.min.js"></script>
    <script src="../cv/public/datatables/vfs_fonts.js"></script>
    <script src="../cv/public/canvasjs/canvasjs.min.js"></script>
    <script src="../cv/public/alertify/alertify.min.js"></script>
    <script src="../cv/public/ckeditor/ckeditor.js"></script>
    <script src="../cv/public/ckeditor/samples/js/sample.js"></script>

</html>