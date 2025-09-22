<?php

if (strlen(session_id()) < 1) session_start();
if (!$_SERVER['HTTP_REFERER']) {
    header("Location: ../");
    die();
}

require_once("../controlador/hv_fun_hoja_de_vida.php");

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
        Hoja de vida - <?php echo $info_usuario['cvadministrativos_nombre'] . " " . $info_usuario['usuario_apellido']; ?>
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
                <h1 class="text-center"><?php echo $info_usuario['cvadministrativos_nombre'] . " " . $info_usuario['usuario_apellido']; ?></h1>
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
                            <td width="925"><?php echo $info_usuario['cvadministrativos_nombre'] . " " . $info_usuario['usuario_apellido']; ?></td>

                            <?php
                            // Si el usuario no tiene imagen, usamos una por defecto
                            $foto_usuario = !empty($info_usuario['usuario_imagen']) ? "../cv_funcionarios/usuarios/" . htmlspecialchars($info_usuario['usuario_imagen']) : "../cv_funcionarios/usuarios/avatar_hombre.png";
                            ?>

                            <td width="925" rowspan="12" valign="top" align="right">
                                <div>
                                    <input class="form-control mb-3 hidden" onchange="comprimirImagen('nombre_imagen1')" type="file" id="nombre_imagen1" name="nombre_imagen1" accept="image/png, image/jpeg, image/jpg">
                                    <input type="hidden" id="b_nombre_imagen1" name="b_nombre_imagen1">

                                    <img class="elevation-2 img_user" id="preview_nombre_imagen1" src="<?php echo $foto_usuario . '?' . time(); ?>" data-server-src="<?php echo $foto_usuario; ?>" alt="Foto del usuario" width="150"
                                        height="150">

                                    <span style="margin-top:6px;">
                                        <i class="btn btn-warning btn-xs edit-nombre_imagen1" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Imagen" onclick="document.getElementById(`nombre_imagen1`).click();" role="button">
                                            <i class="fas fa-edit"></i> Editar
                                        </i>
                                        <button class="btn btn-success hidden mt-2 rounded-0 btn_nombre_imagen1 guardar-nombre_imagen1" onclick="cambiarImagen('nombre_imagen1')">Guardar</button>
                                        <button class="btn btn-danger hidden mt-2 rounded-0 btn_nombre_imagen1 cancel-nombre_imagen1" onclick="cancelar_input('nombre_imagen1')">Cancelar</button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Cédula:</td>
                            <td><?php echo $info_usuario['cvadministrativos_identificacion']; ?></td>
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
                            <td><?php echo $info_usuario['cvadministrativos_correo']; ?></td>
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

                        $array_si_no = [
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
                            <td><?php echo $array_si_no[$info_usuario["hijos_menores_10"]] ?? "No especificado"; ?></td>
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
                            <td><?php echo $array_si_no[$info_usuario["experiencia_docente"]] ?? "No especificado"; ?></td>
                        </tr>
                        <tr>
                            <td>Persona políticamente expuesta:</td>
                            <td><?php echo $array_si_no[$info_usuario["politicamente_expuesta"]] ?? "No especificado"; ?></td>
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
                        <a href="../<?php echo $datos_url[1] ?>" target="_blank">
                            <img class="profile-user-img img-responsive img-circle" src="../cv_funcionarios/public/icon_file.png" alt="User profile picture">
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
                // verifica si la variable esta vacia, si la encuentra vacia salta al siguiente y lo omite para que no muestre en caso de que le den en no a Registro Único Tributario (RUT) y Tarjeta Profesionalno muestre el archivo vacio
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
                                    <a href="../<?php echo $datos_url[1] ?>" target="_blank"><img src="../cv_funcionarios/public/pdf.png" width="10%" alt="">
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
                $archivo = $documentosA_arr[$i]["documento_archivoA"];
                $datos_url = !empty($archivo) ? explode('../', $archivo) : null;
            ?>
                <div class="col-md-12">
                    <table class="table table-condensed table-responsive ">
                        <tr>
                            <td>
                                <h4><?php echo $documentosA_arr[$i]["documento_nombreA"] ?></h4>
                            </td>

                            <?php if (!empty($archivo)) { ?>
                                <?php if ($documentosA_arr[$i]["tipo_documento"] == "pdf") { ?>
                                    <td>
                                        <a href="../<?php echo $datos_url[1] ?>" target="_blank">
                                            <img src="../cv_funcionarios/public/pdf.png" width="10%" alt="">
                                        </a>
                                    </td>
                                <?php } else { ?>
                                    <td>
                                        <a href="../<?php echo $datos_url[1] ?>" target="_blank">
                                            <img src="../cv_funcionarios/public/icon_file.png" width="10%" alt="">
                                        </a>
                                    </td>
                                <?php } ?>
                            <?php } ?>
                        </tr>
                    </table>
                </div>
            <?php } ?>
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


    <script>
        var valor_defecto = null;
        var image_ant = null;
        var id_cvadministrativos = "<?php echo $info_usuario['id_cvadministrativos']; ?>";
        var cvadministrativos_identificacion = "<?php echo $info_usuario['cvadministrativos_identificacion']; ?>";

        function comprimirImagen(file_input) {
            const porcentajeCalidad = 20;
            var imagenComoArchivo = $("#" + file_input)[0];
            if (!imagenComoArchivo || imagenComoArchivo.files.length <= 0) {
                return;
            }
            imagenComoArchivo = imagenComoArchivo.files[0];
            var esPNG = imagenComoArchivo.type === "image/png" || /\.png$/i.test(imagenComoArchivo.name);
            var elem_canvas = document.createElement("canvas");
            var ctx = elem_canvas.getContext("2d");
            var obj_imagen = new Image();
            obj_imagen.src = URL.createObjectURL(imagenComoArchivo);
            obj_imagen.onload = () => {
                elem_canvas.width = obj_imagen.width;
                elem_canvas.height = obj_imagen.height;
                if (!esPNG) {
                    ctx.fillStyle = "#fff";
                    ctx.fillRect(0, 0, elem_canvas.width, elem_canvas.height);
                }
                ctx.drawImage(obj_imagen, 0, 0);
                // Definir el formato de salida
                var mime = esPNG ? "image/png" : "image/jpeg";
                var calidad = esPNG ? 1 : (porcentajeCalidad / 100);
                elem_canvas.toBlob(function(blob) {
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        $("#b_" + file_input).val(reader.result);
                        $("#preview_" + file_input).attr("src", reader.result);
                        $(".btn_" + file_input).removeClass("hidden");
                        $(".edit-" + file_input).toggleClass("hidden");
                    }
                }, mime, calidad);
            };
        }

        function cancelar_input(campo) {
            //toma el valor que tenia antes del cambio y lo reemplaza
            $(".input-" + campo).val(valor_defecto);
            //funcion para activr o desactivar onputs
            activar_input(campo);
            $(".img_user").attr("src", image_ant);
        }

        function activar_input(campo) {
            //guarda el valor por defecto que tiene el input antes de ser editado
            valor_defecto = $(".input-" + campo).val();
            image_ant = $("#preview_" + campo).data("server-src");
            //si esta readonly lo pasa a false y si esta false lo pasa a true
            ($(".input-" + campo).prop('readonly')) ? $(".input-" + campo).prop('readonly', false): $(".input-" + campo).prop('readonly', true);
            //activa el focus del campo a editar
            $(".input-" + campo).focus();
            //si el boton guardar tiene hidden elimina la clase y si no la tiene se la pone
            $(".guardar-" + campo).toggleClass("hidden");
            //si el boton cancelar tiene hidden elimina la clase y si no la tiene se la pone
            $(".cancel-" + campo).toggleClass("hidden");
            //si el boton editar tiene hidden elimina la clase y si no la tiene se la pone
            $(".edit-" + campo).toggleClass("hidden");
        }

        function cambiarImagen(campo) {
            var input = $("#b_" + campo).val();
            var $img = $("#preview_" + campo);
            var actual = ($img.data("server-src") || "").toString();
            var imagen_anterior = /(avatar_hombre\.png|default_user\.webp)$/i.test(actual);
            $.ajax({
                url: "../controlador/cambiar_imagen_hoja_vida.php?op=cambiarImagenHojaVida",
                type: "POST",
                data: {
                    campo: campo,
                    valor: input,
                    id_cvadministrativos: id_cvadministrativos,
                    cvadministrativos_identificacion: cvadministrativos_identificacion
                },
                dataType: "JSON",
                success: function(datos) {
                    if (datos.exito == 1) {
                        $(".guardar-" + campo).addClass("hidden");
                        $(".cancel-" + campo).addClass("hidden");
                        $(".edit-" + campo).removeClass("hidden");
                        $("#b_" + campo).val("");
                        var base = null;
                        if (datos.url) {
                            base = datos.url;
                        } else if (datos.filename) {
                            base = "../cv_funcionarios/usuarios/" + datos.filename.replace(/^\/+/, "");
                        }
                        if (base) {
                            $img.data("server-src", base);
                            $img.attr("src", base + "?" + Date.now());
                        }
                        if (imagen_anterior) {
                            setTimeout(function() {
                                location.reload(true);
                            }, 300);
                        }
                        alertify.success(datos.info);
                    } else {
                        alertify.error(datos.info);
                    }
                },

            });
        }




        // function cambiarImagen(campo) {
        //     var input = $("#b_" + campo).val();
        //     if (!input) {
        //         alertify.error("Debes subir la imagen de tu documento para continuar");
        //         return;
        //     }

        //     // 1) ¿La imagen actual es la de defecto?
        //     var $img = $("#preview_" + campo);
        //     var current = ($img.data("server-src") || "").toString();
        //     var imagen_anterior = /(?:avatar_hombre\.png|default_user\.webp)$/i.test(current);

        //     $.ajax({
        //         url: "../controlador/cambiar_imagen_hoja_vida.php?op=cambiarImagenHojaVida",
        //         type: "POST",
        //         data: {
        //             campo: campo,
        //             valor: input
        //         },
        //         dataType: "JSON",
        //         success: function(datos) {
        //             if (datos.exito == 1) {
        //                 $(".guardar-" + campo).addClass("hidden");
        //                 $(".cancel-" + campo).addClass("hidden");
        //                 $(".edit-" + campo).removeClass("hidden");
        //                 var previewData = $("#b_" + campo).val();
        //                 $("#b_" + campo).val("");

        //                 // 2) Si backend da ruta, úsala; si no, usa el preview base64
        //                 var base = null;
        //                 if (datos.url && typeof datos.url === "string") {
        //                     base = datos.url;
        //                 } else if (datos.filename && typeof datos.filename === "string") {
        //                     base = "../cv_funcionarios/usuarios/" + datos.filename.replace(/^\/+/, "");
        //                 }

        //                 if (base) {
        //                     if (!/^(\.\.\/|\/|https?:\/\/)/i.test(base)) base = "../" + base.replace(/^\/+/, "");
        //                     $img.data("server-src", base);
        //                     $img.attr("src", base + "?" + Date.now());
        //                 } else if (previewData) {
        //                     // muestra la nueva al instante
        //                     $img.attr("src", previewData);
        //                 }

        //                 // 3) Si antes era default, fuerza refresh completo (para ya cargar la ruta nueva desde PHP)
        //                 if (imagen_anterior) {
        //                     // pequeño delay para que se vea el toast
        //                     setTimeout(function() {location.reload(true);}, 300);
        //                 }

        //                 alertify.success(datos.info || "Imagen actualizada");
        //             } else {
        //                 alertify.error(datos.info || "No se pudo actualizar la imagen");
        //             }
        //         },
        //         error: function(e) {
        //             alertify.error(e.responseText || "Error al actualizar");
        //             console.log(e.responseText);
        //         }
        //     });
        // }
    </script>


</html>