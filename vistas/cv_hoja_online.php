<?php

if (strlen(session_id()) < 1) session_start();
if (!$_SERVER['HTTP_REFERER']) {
    header("Location: ../");
    die();
}

require_once("../controlador/cv_hoja_de_vida.php");

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
    <title>
        Hoja de vida - <?php echo $info_usuario['usuario_nombre'] . " " . $info_usuario['usuario_apellido'] ?>
    </title>
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
                            <td>Edad:</td>
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
                        <!-- agregamos los campos nuevos -->
                        <?php
                        $array_genero = [
                            "1" => "Masculino",
                            "2" => "Femenino",
                            "3" => "Otro"
                        ];

                        $array_tipo_vivienda = [
                            "1" => "Propia",
                            "2" => "Alquilada",
                            "3" => "Viviendo con Familiares",
                            "4" => "Otros"
                        ];

                        $array_nivel_escolaridad = [
                            "1" => "Primaria",
                            "2" => "Secundaria",
                            "3" => "Técnico",
                            "4" => "Tecnólogo",
                            "5" => "Profesional",
                            "6" => "Especialización",
                            "7" => "Maestría",
                            "8" => "Doctorado"
                        ];

                        $array_binario = [
                            "1" => "Sí",
                            "0" => "No"
                        ];

                        $array_politicamente_expuesto = [
                            "1" => "Sí",
                            "0" => "No"
                        ];
                        $array_experiencia_docente = [
                            "1" => "Sí",
                            "0" => "No"
                        ];

                        ?>

                        <tr>
                            <td>Género:</td>
                            <td>
                                <?php
                                if ($info_usuario["genero"] == "3" && !empty($info_usuario["genero_otro"])) {
                                    echo htmlspecialchars($info_usuario["genero_otro"]);
                                } else {
                                    echo $array_genero[$info_usuario["genero"]] ?? "No especificado";
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Tipo de vivienda:</td>
                            <td><?php echo $array_tipo_vivienda[$info_usuario["tipo_vivienda"]] ?? "No especificado"; ?></td>
                        </tr>

                        <tr>
                            <td>Estrato:</td>
                            <td><?php echo $info_usuario["estrato"]; ?></td>
                        </tr>

                        <tr>
                            <td>Número de hijos:</td>
                            <td><?php echo $info_usuario["numero_hijos"]; ?></td>
                        </tr>

                        <tr>
                            <td>¿Tiene hijos menores de 10 años?</td>
                            <td><?php echo $array_binario[$info_usuario["hijos_menores_10"]] ?? "No especificado"; ?></td>
                        </tr>

                        <tr>
                            <td>Personas a cargo:</td>
                            <td><?php echo $info_usuario["personas_a_cargo"]; ?></td>
                        </tr>

                        <tr>
                            <td>Nivel de escolaridad:</td>
                            <td><?php echo $array_nivel_escolaridad[$info_usuario["nivel_escolaridad"]] ?? "No especificado"; ?></td>
                        </tr>

                        <tr>
                            <td>Nombre de contacto de emergencia:</td>
                            <td><?php echo $info_usuario["nombre_emergencia"]; ?></td>
                        </tr>

                        <tr>
                            <td>Parentesco:</td>
                            <td><?php echo $info_usuario["parentesco"]; ?></td>
                        </tr>

                        <tr>
                            <td>Número telefónico de emergencia:</td>
                            <td><?php echo $info_usuario["numero_telefonico_emergencia"]; ?></td>
                        </tr>

                        <tr>
                            <td> Experiencia en docencia:</td>
                            <td><?php echo $array_experiencia_docente[$info_usuario["experiencia_docente"]] ?? "No especificado"; ?></td>
                        </tr>
                        <tr>
                            <td>Persona políticamente expuesta:</td>
                            <td><?php echo $array_politicamente_expuesto[$info_usuario["politicamente_expuesta"]] ?? "No especificado"; ?></td>
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

            for ($i = 0; $i < count($educacions_arr); $i++) {
                // $datos_url =  explode('../', $educacions_arr[$i]["certificado_educacion"]); 

                $datos_url = explode('../', $educacions_arr[$i]["certificado_educacion"] ?? '');

            ?>
                <div class="col-md-3">
                    <div class="box-body box-profile">
                        <a href="../cv/<?php echo $datos_url[1] ?>" target="_blank">
                            <img class="profile-user-img img-responsive img-circle" src="../cv/public/img/icon file.png" alt="User profile picture">
                        </a>
                        <br>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <h4 class="text-bold"><?php echo $educacions_arr[$i]["institucion_academica"]; ?></h4>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-calendar-alt"></i> <b> <?php echo $educacions_arr[$i]["desde_cuando_f"] . " " . $educacions_arr[$i]["hasta_cuando_f"]; ?> </b>
                                <!--<a class="pull-right">1,322</a>-->
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $educacions_arr[$i]["titulo_obtenido"]; ?></b>
                            </li>
                            <br>
                            <b><?php echo $educacions_arr[$i]["mas_detalles_f"]; ?></b>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>

            <?php

            }

            ?>
        </div>
        <div class="row">
            <div class="page-header">
                <h3>Experiencia laboral</h3>
            </div>

            <?php

            for ($i = 0; $i < count($experiencias_arr); $i++) {

            ?>
                <div class="col-md-3">
                    <div class="box-body box-profile">
                        <ul class="list-group ">
                            <li class="list-group-item">
                                <h4 class="text-bold"><?php echo $experiencias_arr[$i]["nombre_empresa"]; ?></h4>
                            </li>

                            <li class="list-group-item">
                                <i class="fas fa-calendar-alt"></i> <b> <?php echo $experiencias_arr[$i]["desde_cuando"] . " " . $experiencias_arr[$i]["hasta_cuando"]; ?> </b>
                                <!--<a class="pull-right">1,322</a>-->
                            </li>
                            <li class="list-group-item">
                                <b><?php echo $experiencias_arr[$i]["cargo_empresa"]; ?></b>
                            </li>

                            <li class="list-group-item">
                                <b><?php echo $experiencias_arr[$i]["mas_detalles"]; ?></b>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>

            <?php

            }

            ?>
        </div>
        <div class="row">
            <div class="page-header">
                <h3>Habilidades y Aptitudes</h3>
            </div>

            <?php

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

            for ($i = 0; $i < count($referencias_arr); $i++) {

            ?>
                <div class="col-md-3">
                    <div class="box-body box-profile">
                        <h4 class="text-bold"> <?php echo $referencias_arr[$i]["referencias_nombre"] ?></h4>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <i class="fas fa-user"></i>
                                <b> <?php echo $referencias_arr[$i]["referencias_profesion"] ?></b>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-city"></i>
                                <b><?php echo $referencias_arr[$i]["referencias_empresa"] ?></b>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-phone-square"></i> <b><?php echo $referencias_arr[$i]["referencias_telefono"] ?></b>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>

            <?php

            }

            ?>

        </div>
        <div class="row">
            <div class="page-header">
                <h3>Referencias Laborales</h3>
            </div>

            <?php

            for ($i = 0; $i < count($referenciasL_arr); $i++) {

            ?>
                <div class="col-md-3">
                    <div class="box-body box-profile">
                        <h4 class="text-bold"> <?php echo $referenciasL_arr[$i]["referencias_nombrel"] ?></h4>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <i class="fas fa-user"></i>
                                <b> <?php echo $referenciasL_arr[$i]["referencias_profesionl"] ?></b>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-city"></i>
                                <b><?php echo $referenciasL_arr[$i]["referencias_empresal"] ?></b>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-phone-square"></i>
                                <b><?php echo $referenciasL_arr[$i]["referencias_telefonol"] ?></b>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>

            <?php

            }

            ?>
        </div>
        <div class="row">
            <div class="page-header">
                <h3>Documentos </h3>
            </div>

            <?php

            for ($i = 0; $i < count($documentosO_arr); $i++) {
                // $datos_url =  explode('../', $documentosO_arr[$i]["documento_archivo"]);
                if (empty($documentosO_arr[$i]["documento_archivo"]) || $documentosO_arr[$i]["documento_archivo"] == "../") {
                    continue;
                }

                $datos_url =  explode('../', $documentosO_arr[$i]["documento_archivo"]);
            ?>
                <div class="col-md-12">
                    <table class="table table-condensed table-responsive ">
                        <tr>
                            <td>
                                <h4><?php echo $documentosO_arr[$i]["documento_nombre"] ?></h4>
                            </td>

                            <?php

                            if ($documentosO_arr[$i]["tipo_documento"] == "pdf") {
                            ?>
                                <td>
                                    <a href="../<?php echo $datos_url[1] ?>" target="_blank"><img src="../cv/public/img/pdf.png" width="10%" alt="">
                                    </a>
                                </td>

                            <?php

                            } else {

                            ?>
                                <td>
                                    <img src="../<?php echo $datos_url[1] ?>" width="100%">
                                </td>

                            <?php

                            }

                            ?>

                        </tr>
                    </table>
                </div>

            <?php

            }

            ?>

        </div>
        <div class="row">
            <div class="page-header">
                <h3>Archivos Adicionales </h3>
            </div>

            <?php

            for ($i = 0; $i < count($documentosA_arr); $i++) {
                $datos_url =  explode('../', $documentosA_arr[$i]["documento_archivoA"]);
            ?>
                <div class="col-md-12">
                    <table class="table table-condensed table-responsive ">
                        <tr>
                            <td>
                                <h4><?php echo $documentosA_arr[$i]["documento_nombreA"] ?></h4>
                            </td>

                            <?php

                            if ($documentosA_arr[$i]["tipo_documento"] == "pdf") {

                            ?>
                                <td>
                                    <a href="../<?php echo $datos_url[1] ?>" target="_blank"><img src="../cv/public/img/pdf.png" width="50%" alt="">
                                    </a>
                                </td>

                            <?php

                            } else {

                            ?>
                                <td>
                                    <img src="../<?php
                                                    echo $datos_url[1]
                                                    ?>" width="100%">
                                </td>

                            <?php

                            }

                            ?>
                        </tr>
                    </table>
                </div>

            <?php

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