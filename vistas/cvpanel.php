<?php

ob_start();

session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    // header("Location: login.html");
    header("Location: ../");
} else {
    $menu = 28;
    $submenu = 2802;
    if (($_SESSION["usuario_cargo"] == 'Docente')) {
        require 'header_docente.php';
    } else {
        require 'header.php';
    }
    require '../controlador/cv_info_usuario.php';

?>
    <div id="precarga" class="precarga" style="display: none;"></div>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-6">
                        <h2 class="m-0 line-height-16">
                            <span class="titulo-2 fs-18 text-semibold" id="nombre_programa">Hoja de vida única</span><br>
                            <span class="fs-16 f-montserrat-regular">....</span>
                        </h2>
                    </div>
                    <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                        <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour " onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                    </div>
                    <div class="col-12 migas">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href=<?= (($_SESSION["usuario_cargo"] == 'Docente')) ? 'panel_docente.php' : 'panel_admin.php' ?>>Inicio</a></li>
                            <li class="breadcrumb-item active">Hoja de vida única</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="row mx-0">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div style="padding: 2% 1%">
                                        <div class="box-body box-form-cv">
                                            <div class="row">
                                                <!-- MENU -->
                                                <div class="col">
                                                    <div class="timeline align-items-center">
                                                        <div class="col-12 timeline align-items-center">
                                                            <!-- <div id="mostrar_categorias" class="d-flex flex-row flex-md-column flex-wrap"> -->
                                                            <div id="mostrar_categorias" class="d-flex flex-row flex-md-column flex-nowrap" style="overflow-x:auto;">
                                                                <div class="py-3 pl-3" id="caract-1">
                                                                    <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-address-card"></i> </span>
                                                                    <a onclick="mostrarform(1)" class="fs-16 pointer font-weight-bolder">
                                                                        Datos Personales
                                                                    </a>
                                                                </div>
                                                                <div class="py-3 pl-3" id="caract-2">
                                                                    <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-user"></i> </span>
                                                                    <a onclick="mostrarform(2)" class="fs-16 pointer font-weight-bolder">
                                                                        Educación y formación
                                                                    </a>
                                                                </div>
                                                                <div class="py-3 pl-3" id="caract-3">
                                                                    <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-briefcase"></i> </span>
                                                                    <a onclick="mostrarform(3)" class="fs-16 pointer font-weight-bolder">
                                                                        Tu experiencia laboral
                                                                    </a>
                                                                </div>
                                                                <div class="py-3 pl-3" id="caract-4">
                                                                    <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-money-bill"></i> </span>
                                                                    <a onclick="mostrarform(4)" class="fs-16 pointer font-weight-bolder">
                                                                        Habilidades y aptitudes
                                                                    </a>
                                                                </div>
                                                                <div class="py-3 pl-3" id="caract-5">
                                                                    <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-school"></i></span>
                                                                    <a onclick="mostrarform(5)" class="fs-16 pointer font-weight-bolder">
                                                                        Portafolio
                                                                    </a>
                                                                </div>

                                                                <div class="py-3 pl-3" id="caract-6">
                                                                    <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-heart-pulse"></i> </span>
                                                                    <a onclick="mostrarform(6)" class="fs-16 pointer font-weight-bolder">
                                                                        Referencias Personales
                                                                    </a>
                                                                </div>
                                                                <div class="py-3 pl-3" id="caract-7">
                                                                    <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-heart-pulse"></i> </span>
                                                                    <a onclick="mostrarform(7)" class="fs-16 pointer font-weight-bolder">
                                                                        Referencias Laborales
                                                                    </a>
                                                                </div>
                                                                <div class="py-3 pl-3" id="caract-8">
                                                                    <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-heart-pulse"></i> </span>
                                                                    <a onclick="mostrarform(8)" class="fs-16 pointer font-weight-bolder">
                                                                        Documentos Obligatorios
                                                                    </a>
                                                                </div>
                                                                <div class="py-3 pl-3" id="caract-9">
                                                                    <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-heart-pulse"></i> </span>
                                                                    <a onclick="mostrarform(9)" class="fs-16 pointer font-weight-bolder">
                                                                        Documentación Adicional
                                                                    </a>
                                                                </div>
                                                                <div class="py-3 pl-3" id="caract-10">
                                                                    <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-heart-pulse"></i> </span>
                                                                    <a onclick="mostrarform(10)" class="fs-16 pointer font-weight-bolder">
                                                                        Áreas de Conocimiento
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="py-3 pl-3 d-none" id="caract-dropdown">
                                                                <div class="dropdown">
                                                                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                                                        <span class="label-text">Más</span>
                                                                    </a>
                                                                    <div class="dropdown-menu"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- paso 1 informacion personal -->
                                                <div class="col-12 col-sm-12 col-md-9 tono-2 px-4 pt-4" id="form1">
                                                    <div class="col-12">
                                                        <h6 class="title">Información personal</h6>
                                                    </div>
                                                    <form name="informacion_personal_form" id="informacion_personal_form" method="POST">
                                                        <div class="row">
                                                            <div class="col-md-6" hidden>
                                                                <label class="help-block"><i id="span-id_informacion_personal" class="fa"></i> ID Usuario(s):</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fas fa-user-tag"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="id_informacion_personal" id="id_informacion_personal" value="<?= $info_usuario['id_informacion_personal'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="nombres" id="nombres" maxlength="50" placeholder="Nombre Completo" required="" value="<?= $_SESSION["usuario_nombre"] ?>">
                                                                        <label>Nombres(*):</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>
                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="apellidos" id="apellidos" placeholder="Apellidos" required="" value="<?= $_SESSION["usuario_apellido"] ?>">
                                                                        <label>Apellidos:</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>
                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="date" class="form-control border-start-0" name="fecha_nacimiento" id="fecha_nacimiento" required="" value="<?= $info_usuario["fecha_nacimiento"] ?>">
                                                                        <label>Fecha de Nacimiento</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>
                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">

                                                                        <select class="form-control border-start-0" name="estado_civil" id="estado_civil">
                                                                            <option value="" disabled selected>Selecciona una opción</option>
                                                                            <option <?= ($info_usuario["estado_civil"] == "SOLTERO/A") ? "selected" : "" ?> value="SOLTERO/A">Soltero/a</option>
                                                                            <option <?= ($info_usuario["estado_civil"] == "UNIÓN LIBRE") ? "selected" : "" ?> value="UNIÓN LIBRE">Unión Libre</option>
                                                                            <option <?= ($info_usuario["estado_civil"] == "CASADO/A") ? "selected" : "" ?> value="CASADO/A">Casado/a</option>
                                                                            <option <?= ($info_usuario["estado_civil"] == "SEPERADO/A") ? "selected" : "" ?> value="SEPERADO/A">Separado/a</option>
                                                                            <option <?= ($info_usuario["estado_civil"] == "DIVORCIADO/A") ? "selected" : "" ?> value="DIVORCIADO/A">Judicialmente divorciado/a</option>
                                                                            <option <?= ($info_usuario["estado_civil"] == "VIUDO/A") ? "selected" : "" ?> value="VIUDO/A">Viudo/a</option>
                                                                        </select>

                                                                        <label id="span-estado_civil">Estado Civil:</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>
                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select required class="form-control border-start-0" data-live-search="true" name="departamento" id="departamento" onChange="mostrarmunicipio(this.value)">
                                                                            <option value="" selected disabled> --Departamento-- </option>
                                                                            <?php foreach ($departamentos_arr as $d) : ?>
                                                                                <option value="<?php echo $d['id']; ?>" <?php echo ($info_usuario['departamento'] == $d['id']) ? "selected" : ""; ?>>
                                                                                    <?php echo $d['departamento']; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <label for="departamento">Departamento</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>
                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select required class="form-control border-start-0" data-live-search="true" name="ciudad" id="ciudad">
                                                                            <option value="" selected disabled>Selecciona Municipio</option>
                                                                            <?php foreach ($municipios_arr as $ciudades) : ?>
                                                                                <option value="<?php echo $ciudades['id']; ?>" <?php echo ($info_usuario['ciudad'] == $ciudades['id']) ? "selected" : ""; ?>>
                                                                                    <?php echo $ciudades['municipio']; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <label for="ciudad">Municipio</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>
                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="direccion" id="direccion" maxlength="50" required="" value="<?php echo ($info_usuario['direccion']) ?>">
                                                                        <label>Dirección:</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>
                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="celular" id="celular" maxlength="50" required="" value="<?php echo ($info_usuario['celular']) ?>">
                                                                        <label>Celular:</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>
                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="nacionalidad" id="nacionalidad" maxlength="30" required="" value="<?php echo ($info_usuario['nacionalidad']) ?>">
                                                                        <label>Nacionalidad:</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>
                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="pagina_web" id="pagina_web" maxlength="50" required="" value="<?php echo ($info_usuario['pagina_web']) ?>">
                                                                        <label>Página Web:</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>


                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select class="form-control border-start-0" name="genero" id="genero" onchange="mostrarOtroGenero(this.value)">
                                                                            <option value="" disabled <?= ($info_usuario["genero"] == "") ? "selected" : "" ?>>Selecciona una opción</option>
                                                                            <option value="1" <?= ($info_usuario["genero"] == "1") ? "selected" : "" ?>>Masculino</option>
                                                                            <option value="2" <?= ($info_usuario["genero"] == "2") ? "selected" : "" ?>>Femenino</option>
                                                                            <option value="3" <?= ($info_usuario["genero"] == "3") ? "selected" : "" ?>>Otro</option>
                                                                        </select>
                                                                        <label for="genero">Género:</label>
                                                                    </div>
                                                                </div>
                                                                <div id="otro_genero_div" style="display: <?= ($info_usuario["genero"] == "3") ? 'block' : 'none' ?>;">
                                                                    <div class="form-floating mt-1">
                                                                        <input type="text" class="form-control" name="genero_otro" id="genero_otro" value="<?= $info_usuario["genero_otro"] ?? '' ?>">
                                                                        <label for="genero_otro">¿Cuál?</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <script>
                                                                function mostrarOtroGenero(valor) {
                                                                    document.getElementById('otro_genero_div').style.display = (valor === '3') ? 'block' : 'none';
                                                                }
                                                            </script>


                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select class="form-control border-start-0" name="tipo_vivienda" id="tipo_vivienda">
                                                                            <option value="" disabled <?= ($info_usuario["tipo_vivienda"] == "") ? "selected" : "" ?>>Selecciona una opción</option>
                                                                            <option value="1" <?= ($info_usuario["tipo_vivienda"] == "1") ? "selected" : "" ?>>Propia</option>
                                                                            <option value="2" <?= ($info_usuario["tipo_vivienda"] == "2") ? "selected" : "" ?>>Alquilada</option>
                                                                            <option value="3" <?= ($info_usuario["tipo_vivienda"] == "3") ? "selected" : "" ?>>Viviendo con Familiares</option>
                                                                            <option value="4" <?= ($info_usuario["tipo_vivienda"] == "4") ? "selected" : "" ?>>Otros</option>
                                                                        </select>
                                                                        <label for="tipo_vivienda">Tipo de vivienda:</label>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select class="form-control border-start-0" name="estrato" id="estrato">
                                                                            <option value="" disabled selected>Selecciona una opción</option>
                                                                            <?php for ($i = 1; $i <= 6; $i++): ?>
                                                                                <option <?= ($info_usuario["estrato"] == $i) ? "selected" : "" ?> value="<?= $i ?>"><?= $i ?></option>
                                                                            <?php endfor; ?>
                                                                        </select>
                                                                        <label for="estrato">Estrato:</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select class="form-control border-start-0 " name="numero_hijos" id="numero_hijos">
                                                                            <option value="" disabled selected>Selecciona una opción</option>
                                                                            <?php for ($i = 0; $i <= 5; $i++): ?>
                                                                                <option <?= ($info_usuario["numero_hijos"] == $i) ? "selected" : "" ?> value="<?= $i ?>"><?= $i ?></option>
                                                                            <?php endfor; ?>
                                                                        </select>
                                                                        <label for="numero_hijos">Número de hijos:</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select class="form-control border-start-0" name="hijos_menores_10" id="hijos_menores_10">
                                                                            <option value="" disabled selected>Selecciona una opción</option>
                                                                            <option <?= ($info_usuario["hijos_menores_10"] == 1) ? "selected" : "" ?> value="1">Sí</option>
                                                                            <option <?= ($info_usuario["hijos_menores_10"] == 0) ? "selected" : "" ?> value="0">No</option>
                                                                        </select>
                                                                        <label for="hijos_menores_10">¿Tiene hijos menores de 10 años?</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select class="form-control border-start-0" name="personas_a_cargo" id="personas_a_cargo">
                                                                            <option value="" disabled selected>Selecciona una opción</option>
                                                                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                                                                <option <?= ($info_usuario["personas_a_cargo"] == $i) ? "selected" : "" ?> value="<?= $i ?>"><?= $i ?></option>
                                                                            <?php endfor; ?>
                                                                        </select>
                                                                        <label for="personas_a_cargo">Personas a cargo:</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select class="form-control border-start-0" name="nivel_escolaridad" id="nivel_escolaridad">
                                                                            <option value="" disabled <?= ($info_usuario["nivel_escolaridad"] == "") ? "selected" : "" ?>>Selecciona una opción</option>
                                                                            <option value="1" <?= ($info_usuario["nivel_escolaridad"] == "1") ? "selected" : "" ?>>Primaria</option>
                                                                            <option value="2" <?= ($info_usuario["nivel_escolaridad"] == "2") ? "selected" : "" ?>>Secundaria</option>
                                                                            <option value="3" <?= ($info_usuario["nivel_escolaridad"] == "3") ? "selected" : "" ?>>Técnico</option>
                                                                            <option value="4" <?= ($info_usuario["nivel_escolaridad"] == "4") ? "selected" : "" ?>>Tecnólogo</option>
                                                                            <option value="5" <?= ($info_usuario["nivel_escolaridad"] == "5") ? "selected" : "" ?>>Profesional</option>
                                                                            <option value="6" <?= ($info_usuario["nivel_escolaridad"] == "6") ? "selected" : "" ?>>Especialización</option>
                                                                            <option value="7" <?= ($info_usuario["nivel_escolaridad"] == "7") ? "selected" : "" ?>>Maestría</option>
                                                                            <option value="8" <?= ($info_usuario["nivel_escolaridad"] == "8") ? "selected" : "" ?>>Doctorado</option>
                                                                        </select>
                                                                        <label for="nivel_escolaridad">Nivel de escolaridad:</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <h6 class="title">Contacto Emergencia</h6>
                                                            </div>
                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="nombre_emergencia" id="nombre_emergencia" maxlength="50" required="" value="<?php echo ($info_usuario['nombre_emergencia']) ?>">
                                                                        <label>Nombre completo:</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>

                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select required class="form-control border-start-0" data-live-search="true" name="parentesco" id="parentesco">
                                                                            <option value="" disabled selected> --Parentesco-- </option>
                                                                            <?php
                                                                            $parentescos = [
                                                                                "Padre",
                                                                                "Madre",
                                                                                "Hijo",
                                                                                "Hija",
                                                                                "Hermano",
                                                                                "Hermana",
                                                                                "Abuelo",
                                                                                "Abuela",
                                                                                "Nieto",
                                                                                "Nieta",
                                                                                "Tío",
                                                                                "Tía",
                                                                                "Sobrino",
                                                                                "Sobrina",
                                                                                "Primo",
                                                                                "Prima",
                                                                                "Padrastro",
                                                                                "Madrastra",
                                                                                "Hijastro",
                                                                                "Hijastra",
                                                                                "Cuñado",
                                                                                "Cuñada",
                                                                                "Suegro",
                                                                                "Suegra",
                                                                                "Yerno",
                                                                                "Nuera",
                                                                                "Esposo",
                                                                                "Esposa",
                                                                                "Pareja",
                                                                                "Tutor Legal",
                                                                                "Otro"
                                                                            ];
                                                                            foreach ($parentescos as $p) :
                                                                            ?>
                                                                                <option value="<?php echo $p; ?>" <?php echo ($info_usuario['parentesco'] == $p) ? "selected" : ""; ?>>
                                                                                    <?php echo $p; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <label for="parentesco">Parentesco</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Por favor seleccione un parentesco válido</div>
                                                            </div>

                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="numero_telefonico_emergencia" id="numero_telefonico_emergencia" maxlength="30" required="" value="<?php echo ($info_usuario['numero_telefonico_emergencia']) ?>">
                                                                        <label>Número de teléfono:</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>




                                                            <div class="col-12">
                                                                <h6 class="title">Perfil Profesional</h6>
                                                            </div>
                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="titulo_profesional" id="titulo_profesional" maxlength="50" required="" value="<?php echo ($info_usuario['titulo_profesional']) ?>">
                                                                        <label>Titulo Profesional:</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>
                                                            <div class="col-md-6 mt-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select required class="form-control border-start-0" name="categoria_profesion" id="categoria_profesion">
                                                                            <option value="" selected disabled>Selecciona una categoría</option>
                                                                            <?php foreach ($categorias_arr as $categoria) : ?>
                                                                                <option value="<?php echo $categoria['categoria']; ?>" <?php echo ($info_usuario['categoria_profesion'] == $categoria['categoria']) ? "selected" : ""; ?>>
                                                                                    <?php echo $categoria['categoria']; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <label for="categoria_profesion">Categoría Perfil</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>
                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select class="form-control border-start-0" name="situacion_laboral" id="situacion_laboral" required>
                                                                            <option value="nothing" disabled selected>Seleccione una opción</option>
                                                                            <option value="Sin trabajo" <?php echo ($info_usuario["situacion_laboral"] == "Sin trabajo") ? "selected" : ""; ?>>Sin trabajo</option>
                                                                            <option value="Buscando primer empleo" <?php echo ($info_usuario["situacion_laboral"] == "Buscando primer empleo") ? "selected" : ""; ?>>Buscando primer empleo</option>
                                                                            <option value="Con trabajo" <?php echo ($info_usuario["situacion_laboral"] == "Con trabajo") ? "selected" : ""; ?>>Con trabajo</option>
                                                                            <option value="Autoempleado" <?php echo ($info_usuario["situacion_laboral"] == "Autoempleado") ? "selected" : ""; ?>>Autoempleado</option>
                                                                        </select>
                                                                        <label for="situacion_laboral">Situación Laboral</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please select a valid option</div>
                                                            </div>
                                                            <div class="col-md-6 mt-3 mb-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <textarea class="form-control border-start-0" rows="5" id="resumen_perfil" name="resumen_perfil" placeholder="Resumir acá en máximo dos o tres frases su perfil profesional. Máx. 600 caracteres"><?php echo ($info_usuario['resumen_perfil']); ?></textarea>
                                                                        <label for="resumen_perfil">Resumen del perfil</label>
                                                                    </div>
                                                                    <!-- <i class="far fa-question-circle" data-toggle="tooltip" data-placement="top" title="Resumir acá en máximo dos o tres frases su perfil profesional. Ejemplo: “Administrador de empresas con larga experiencia en gerencia en diferentes empresas comercializadoras y exportadoras. Ha desarrollado grandes aptitudes de manejo de equipo. Muy buen conocimiento del sector energético latinoamericano.” Máx. 600 caracteres"></i> -->
                                                                </div>
                                                                <div class="invalid-feedback">Please enter a valid profile summary</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="help-block"><i id="span-experiencia" class="fa"></i> Experiencia en docencia:</label><br>

                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="experiencia_docente" id="experiencia_docente_si" value="1"
                                                                            <?php echo ($info_usuario["experiencia_docente"] == "1") ? "checked" : ""; ?>
                                                                            onchange="ActualizarEstadoExperienciaDocente(this.value, '<?php echo $id_usuario_cv; ?>', 'Experiencia Docente')">
                                                                        <label class="form-check-label" for="experiencia_docente_si">Sí</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="experiencia_docente" id="experiencia_docente_no" value="0"
                                                                            <?php echo ($info_usuario["experiencia_docente"] == "0") ? "checked" : ""; ?>
                                                                            onchange="ActualizarEstadoExperienciaDocente(this.value, '<?php echo $id_usuario_cv; ?>', 'Experiencia Docente')">
                                                                        <label class="form-check-label" for="experiencia_docente_no">No</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="help-block"><i id="span-experiencia" class="fa"></i> Persona Políticamente expuesta:</label><br>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="politicamente_expuesta" id="politicamente_expuesta_si" value="1"
                                                                            <?php echo ($info_usuario["politicamente_expuesta"] == "1") ? "checked" : ""; ?>
                                                                            onchange="ActualizarEstadoPoliticamenteExpuesto(this.value, '<?php echo $id_usuario_cv; ?>', 'Políticamente expuesta')">
                                                                        <label class="form-check-label" for="politicamente_expuesta_si">Sí</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="politicamente_expuesta" id="politicamente_expuesta_no" value="0"
                                                                            <?php echo ($info_usuario["politicamente_expuesta"] == "0") ? "checked" : ""; ?>
                                                                            onchange="ActualizarEstadoPoliticamenteExpuesto(this.value, '<?php echo $id_usuario_cv; ?>', 'Políticamente expuesta')">
                                                                        <label class="form-check-label" for="politicamente_expuesta_no">No</label>
                                                                    </div>
                                                                    <a class="ms-2 text-info" onclick="CrearPoliticamenteExpuestoPopover(event)" title="¿Qué es una Persona Políticamente Expuesta?">
                                                                        <i class="fa-solid fa-circle-info"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                        <br>
                                                        <div class="col-12 py-4">
                                                            <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                                                        </div>
                                                        <!-- <button type="submit" class="btn bg-primary btn-sm w-100">Guardar</button> -->
                                                    </form>
                                                </div>
                                                <!-- paso formulario para educacion y formacion paso 2-->
                                                <div class="col-12 col-sm-12 col-md-9 tono-2 px-4 pt-4" id="form2">
                                                    <button class="btn bg-primary btn-xs" onclick="CrearEducacionFormacionPopover(event)">
                                                        <i class="fas fa-plus-circle"></i> Educación y Formación
                                                    </button>
                                                    <div class="row">
                                                        <div class="col-md-12" style="margin-top: 40px;">
                                                            <h3 class="profile-username text-center">Educación</h3>
                                                            <div class="table-responsive">
                                                                <table id="table-educacion_formacion" class="table table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Opciones</th>
                                                                            <th>Institución Académica</th>
                                                                            <th>Título Obtenido</th>
                                                                            <th>Desde</th>
                                                                            <th>Hasta</th>
                                                                            <th>Detalles</th>
                                                                            <th>Certificado</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="body-educacion_formacion"></tbody>
                                                                </table>
                                                                <div class="col-12 mt-3 text-end" id="btnSiguiente_educacion_formacion" style="display: none;">
                                                                    <button class="btn btn-primary btn-sm" onclick="avanzarAlSiguientePaso()">Continuar</button>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="popoverFormularioEducacionyFormacion" class="popover-educacionformacion tono-1 borde rounded p-2" style="display:none; position:absolute; z-index:1055; width:90%; max-width:600px;">
                                                    <form id="form-educacion_formacion" name="form-educacion_formacion" class="p-3 m-0 rounded shadow tono-2" style="width: 100%;" method="POST">
                                                        <div style="text-align: right;">
                                                            <button type="button" onclick="cerrarPopoverEducacionformacion()" class="btn btn-sm btn-link" aria-label="Cerrar">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-12">
                                                            <h6 class="title">Educación y formación</h6>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control border-start-0" name="institucion_academica" id="institucion_academica" required>
                                                                    <label for="span-institucion_academica"> Institución Académica</label>
                                                                </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter a valid title</div>
                                                        </div>
                                                        <input type="hidden" name="id_formacion" id="id_formacion">
                                                        <div class="form-group mb-2">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control border-start-0" name="titulo_obtenido" id="titulo_obtenido" required>
                                                                    <label for="titulo_obtenido">Título Obtenido</label>
                                                                </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter a valid title</div>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                                <div class="form-floating">
                                                                    <input type="date" class="form-control border-start-0" name="desde_cuando_f" id="desde_cuando_f" required>
                                                                    <label for="desde_cuando_f">Desde</label>
                                                                </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please select a valid date</div>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                                <div class="form-floating">
                                                                    <input type="date" class="form-control border-start-0" name="hasta_cuando_f" id="hasta_cuando_f" required>
                                                                    <label for="hasta_cuando_f">Hasta</label>
                                                                </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please select a valid date</div>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                                <div class="form-floating">
                                                                    <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="nivel_formacion" id="nivel_formacion"></select>
                                                                    <label>Nivel formación</label>
                                                                </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label class="help-block"><i id="span-certificado_educacion" class="fa"></i> Certificado de educación </label>
                                                            <div class="input-group">
                                                                <input type="file" class="form-control" name="certificado_educacion" id="certificado_educacion">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="mas_detalles_f">Más Detalles</label>
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                                <div class="form-floating">
                                                                    <textarea class="form-control border-start-0" name="mas_detalles_f" id="mas_detalles_f" placeholder="Más detalles sobre su educación y formación. Ej: Premios, diplomas, otras informaciones sobre sus estudios." style="height: 150px;"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please provide more details if necessary</div>
                                                        </div>
                                                        <div class="col-12 mt-3">
                                                            <div class="alert alert-danger" role="alert">
                                                                <strong>Importante:</strong> Recuerda que para poder continuar, debes tener al menos dos registros.
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn bg-primary btn-sm w-100">Guardar</button>
                                                    </form>
                                                </div>
                                                <!-- paso para la experiencia laboral paso 3-->
                                                <div class="col-12 col-sm-12 col-md-9 tono-2 px-4 pt-4" id="form3">
                                                    <button class="btn bg-primary btn-xs" onclick="CrearLaboralPopover(event)">
                                                        <i class="fas fa-plus-circle"></i> Laboral
                                                    </button>
                                                    <div class="row">
                                                        <div class="col-md-12" style="margin-top: 40px;">
                                                            <h3 class="profile-username text-center">Laboral y Docente</h3>
                                                            <div class="table-responsive">
                                                                <table id="table-experiencias_laborales" class="table table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Opciones</th>
                                                                            <th>Nombre <br>Empresa</th>
                                                                            <th>Cargo </th>
                                                                            <th>Desde </th>
                                                                            <th>Hasta </th>
                                                                            <th>detalles </th>
                                                                            <th>Certificado </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="body-experiencias_laborales"></tbody>
                                                                </table>
                                                                <div class="col-12 mt-3 text-end" id="btnSiguiente_laboralydocente" style="display: none;">
                                                                    <button class="btn btn-primary btn-sm" onclick="avanzarAlSiguientePaso()">Continuar</button>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="popoverLaboral" class="popover-laboral tono-1 borde rounded p-2" style="display:none; position:absolute; z-index:1055; width:90%; max-width:600px;">
                                                    <form id="form-experiencia_laboral" name="form-experiencia_laboral" class="p-3 m-0 rounded shadow tono-2" style="width: 100%;" method="POST">
                                                        <div style="text-align: right;">
                                                            <button type="button" onclick="cerrarLaboral()" class="btn btn-sm btn-link" aria-label="Cerrar">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-12">
                                                            <h6 class="title">Laboral</h6>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="nombre_empresa" id="nombre_empresa" placeholder="" required>
                                                                        <label for="nombre_empresa">Nombre de la Empresa</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter a valid company name</div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="cargo_empresa" id="cargo_empresa" required placeholder="">
                                                                        <label for="cargo_empresa">Cargo</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter a valid position</div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="date" class="form-control border-start-0" name="desde_cuando" id="desde_cuando" required placeholder="">
                                                                        <label for="desde_cuando">Desde</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please select a valid date</div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12" id="ocultar_hasta_cuando">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="date" class="form-control border-start-0" name="hasta_cuando" id="hasta_cuando" placeholder="">
                                                                        <label for="hasta_cuando">Hasta</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please select a valid date</div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <label class="help-block"><i id="span-trabajo_actual" class="fa"></i> Trabajo Actual:</label>
                                                                <br>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="trabajo_actual" id="trabajo_actual_si" value="1" onchange="ocultar_input_hasta_cuando(this.value)">
                                                                    <label class="form-check-label" for="trabajo_actual_si">Sí</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="trabajo_actual" id="trabajo_actual_no" value="0" onchange="ocultar_input_hasta_cuando(this.value)">
                                                                    <label class="form-check-label" for="trabajo_actual_no">No</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mt-3">
                                                                <label class="help-block"><i id="span-certificado_laboral" class="fa"></i> Certificado Laboral </label>
                                                                <div class="input-group">
                                                                    <input type="file" class="form-control" name="certificado_laboral" id="certificado_laboral">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mt-3">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <textarea class="form-control border-start-0" rows="6" name="mas_detalles" id="mas_detalles" placeholder=""></textarea>
                                                                        <label for="mas_detalles">Más Detalles</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please provide additional details</div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" class="form-control" name="id_experiencia" id="id_experiencia">
                                                        <input type="hidden" class="form-control" name="id_experiencia_editar_img" id="id_experiencia_editar_img">
                                                        <button type="submit" class="btn bg-primary btn-sm w-100">Guardar</button>
                                                    </form>
                                                    <div class="alert alert-danger" role="alert" style="margin-top: 20px;">
                                                        <strong>Importante:</strong> Recuerda que para poder continuar, debes tener al menos dos registros.
                                                    </div>
                                                    </form>
                                                </div>
                                                <!-- paso para las habilidades paso 4-->
                                                <div class="col-12 col-sm-12 col-md-9 tono-2 px-4 pt-4" id="form4">
                                                    <button class="btn bg-primary btn-xs" onclick="CrearHabilidadesyAptitudesPopover(event)">
                                                        <i class="fas fa-plus-circle"></i> Nueva Habilidad
                                                    </button>
                                                    <div class="row">
                                                        <div class="col-md-12" style="margin-top: 40px;">
                                                            <div class="row">
                                                                <div class="col-md-12" style="margin-top: 40px;">
                                                                    <h3 class="profile-username text-center">Habilidades y aptitudes</h3>
                                                                    <div class="table-responsive">
                                                                        <table id="table-habilidades_aptitudes" class="table table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Opciones</th>
                                                                                    <th>Nombre de la Categoria</th>
                                                                                    <th>Nivel de Habilidad</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="body-habilidades_aptitudes"></tbody>
                                                                        </table>
                                                                        <div class="col-12 mt-3 text-end" id="btnSiguiente_habilidades" style="display: none;">
                                                                            <button class="btn btn-primary btn-sm" onclick="avanzarAlSiguientePaso()">Continuar</button>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="popoverhabilidadesyaptitudes" class="popover-habilidadesyaptitudes tono-1 borde rounded p-2" style="display:none; position:absolute; z-index:1055; width:90%; max-width:600px;">
                                                    <form id="form-habilidades_aptitudes" name="form-habilidades_aptitudes" class="p-3 m-0 rounded shadow tono-2" style="width: 100%;" method="POST">
                                                        <div style="text-align: right;">
                                                            <button type="button" onclick="cerrarHabilidadesyAptitudes()" class="btn btn-sm btn-link" aria-label="Cerrar">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-12">
                                                            <h6 class="title">Habilidad</h6>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12" hidden>
                                                                <label class="help-block"><i id="span-id_habilidad" class="fa"></i>Nombre de la categoria:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fas fa-stethoscope"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="id_habilidad" id="id_habilidad">
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="col-md-12 mt-4 mb-3">
                                                                    <div class="form-group mb-3 position-relative check-valid">
                                                                        <div class="form-floating">
                                                                            <input type="text" class="form-control border-start-0" name="categoria_habilidad" id="categoria_habilidad" required placeholder="">
                                                                            <label for="categoria_habilidad">Nombre de la Categoría</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="invalid-feedback">Please enter a valid category name</div>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="col-md-12 mt-2 mb-3">
                                                                    <div class="form-group mb-3 position-relative check-valid">
                                                                        <label for="nivel_habilidad" class="form-label">
                                                                            <i class="fas fa-square-full rango_del_color"></i> Nivel de habilidad
                                                                            <i class="far fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="El rango es de 1 a 5, Entre más alto, más nivel tienes."></i>
                                                                        </label>
                                                                        <input type="range" class="form-control" name="nivel_habilidad" id="nivel_habilidad" min="1" max="5" step="1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn bg-primary btn-sm w-100">Guardar</button>
                                                    </form>
                                                    <div class="alert alert-danger" role="alert" style="margin-top: 20px;">
                                                        <strong>Importante:</strong> Recuerda que para poder continuar, debes tener al menos cinco registros.
                                                    </div>
                                                    </form>
                                                </div>
                                                <!-- paso para el portafolio paso 5-->
                                                <div class="col-12 col-sm-12 col-md-9 tono-2 px-4 pt-4" id="form5">
                                                    <button class="btn bg-primary btn-xs" onclick="CrearPortafolioPopover(event)">
                                                        <i class="fas fa-plus-circle"></i> Nuevo Portafolio
                                                    </button>
                                                    <div class="row">
                                                        <div class="col-md-12" style="margin-top: 40px;">
                                                            <div class="row">
                                                                <div class="col-md-12" style="margin-top: 40px;">
                                                                    <h3 class="profile-username text-center">Areas de Conocimiento</h3>
                                                                    <div class="table-responsive">
                                                                        <table id="table-portafolio" class="table table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Opciones</th>
                                                                                    <th>Titulo </th>
                                                                                    <th>Descripción </th>
                                                                                    <th>Video url </th>
                                                                                    <th>Archivo </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="body-portafolio"></tbody>
                                                                        </table>
                                                                        <div class="col-12 mt-3 text-end" id="btnSiguiente_portafolio" style="display: none;">
                                                                            <button class="btn btn-primary btn-sm" onclick="avanzarAlSiguientePaso()">Continuar</button>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="popoverPortafolio" class="popover-portafolio tono-1 borde rounded p-2" style="display:none; position:absolute; z-index:1055; width:90%; max-width:600px;">
                                                    <form id="form-portafolio" name="form-portafolio" class="p-3 m-0 rounded shadow tono-2" style="width: 100%;" method="POST">
                                                        <div style="text-align: right;">
                                                            <button type="button" onclick="cerrarPortafolio()" class="btn btn-sm btn-link" aria-label="Cerrar">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-12">
                                                            <h6 class="title">Portafolio</h6>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="titulo_portafolio" id="titulo_portafolio" required placeholder="">
                                                                        <label for="titulo_portafolio">Título Portafolio</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter a valid portfolio title</div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="video_portafolio" id="video_portafolio" required placeholder="">
                                                                        <label for="video_portafolio">Video de YouTube</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter a valid YouTube video URL</div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <textarea class="form-control border-start-0" rows="6" name="descripcion_portafolio" id="descripcion_portafolio" placeholder=""></textarea>
                                                                        <label for="descripcion_portafolio">Descripción</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please provide a description</div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="file" class="form-control border-start-0" name="portafolio_archivo" id="portafolio_archivo" placeholder="">
                                                                        <label for="portafolio_archivo">Archivo PDF</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please upload a valid PDF file</div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn bg-primary btn-sm w-100">Guardar</button>
                                                    </form>
                                                    <div class="alert alert-danger" role="alert" style="margin-top: 20px;">
                                                        <strong>Importante:</strong>Recuerda que para poder continuar, debes tener al menos un registro.
                                                    </div>
                                                    </form>
                                                </div>
                                                <!-- paso para las referencias personales paso 6-->
                                                <div class="col-12 col-sm-12 col-md-9 tono-2 px-4 pt-4" id="form6">
                                                    <button class="btn bg-primary btn-xs" onclick="CrearReferenciaPersonalPopover(event)">
                                                        <i class="fas fa-plus-circle"></i> Nueva Referencia personal
                                                    </button>
                                                    <div class="row">
                                                        <div class="col-md-12" style="margin-top: 40px;">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h3 class="profile-username text-center">Referencias personales</h3>
                                                                    <table id="table-referencias_personales" class="table table-hover table-responsive-lg">
                                                                        <thead>
                                                                            <th>Opciones</th>
                                                                            <th>Nombre Completo </th>
                                                                            <th>Profesión o cargo </th>
                                                                            <th>Empresa de trabajo </th>
                                                                            <th>Teléfono </th>
                                                                        </thead>
                                                                        <tbody class="body-referencias_personales">
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="col-12 mt-3 text-end" id="btnSiguiente_referencias_personales" style="display: none;">
                                                                        <button class="btn btn-primary btn-sm" onclick="avanzarAlSiguientePaso()">Continuar</button>
                                                                    </div>
                                                                    <br>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="popoverReferenciaPersonal" class="popover-ReferenciaPersonal tono-1 borde rounded p-2" style="display:none; position:absolute; z-index:1055; width:90%; max-width:600px;">
                                                    <form id="form-referencias_personales" name="form-referencias_personales" class="p-3 m-0 rounded shadow tono-2" style="width: 100%;" method="POST">
                                                        <div style="text-align: right;">
                                                            <button type="button" onclick="cerrarReferenciaPersonal()" class="btn btn-sm btn-link" aria-label="Cerrar">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-12">
                                                            <h6 class="title">Referencia Personal</h6>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="referencias_nombre" id="referencias_nombre" required placeholder="">
                                                                        <label for="referencias_nombre">Nombre Completo</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please provide a valid name</div>
                                                            </div>
                                                            <div hidden>
                                                                <input type="text" class="form-control" name="id_referencias" id="id_referencias">
                                                            </div>
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="referencias_profesion" id="referencias_profesion" required placeholder="">
                                                                        <label for="referencias_profesion">Cargo o Profesión</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please provide a valid position or profession</div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="referencias_empresa" id="referencias_empresa" required placeholder="">
                                                                        <label for="referencias_empresa">Empresa</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please provide a valid company name</div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="number" class="form-control border-start-0" name="referencias_telefono" id="referencias_telefono" required placeholder="">
                                                                        <label for="referencias_telefono">Teléfono</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please provide a valid phone number</div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn bg-primary btn-sm w-100">Guardar</button>
                                                    </form>
                                                    <div class="alert alert-danger" role="alert" style="margin-top: 20px;">
                                                        <strong>Importante:</strong>Recuerda que para poder continuar, debes tener al menos dos registros.
                                                    </div>
                                                    </form>
                                                </div>
                                                <!-- paso para las referencias laborales paso 7-->
                                                <div class="col-12 col-sm-12 col-md-9 tono-2 px-4 pt-4" id="form7">
                                                    <button class="btn bg-primary btn-xs" onclick="CrearReferenciaLaboralPopover(event)">
                                                        <i class="fas fa-plus-circle"></i> Nueva Referencia Laborarles
                                                    </button>
                                                    <div class="row">
                                                        <div class="col-md-12" style="margin-top: 40px;">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h3 class="profile-username text-center">Referencias Laborarles</h3>
                                                                    <table id="table-referencias_laborales" class="table table-hover table-responsive-lg">
                                                                        <thead>
                                                                            <th>Opciones</th>
                                                                            <th>Nombre Completo </th>
                                                                            <th>Profesión o cargo </th>
                                                                            <th>Empresa de trabajo </th>
                                                                            <th>Teléfono </th>
                                                                        </thead>
                                                                        <tbody class="body-referencias_laborales">
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="col-12 mt-3 text-end" id="btnSiguiente_Referencia_laboral" style="display: none;">
                                                                        <button class="btn btn-primary btn-sm" onclick="avanzarAlSiguientePaso()">Continuar</button>
                                                                    </div>
                                                                    <br>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="popoverReferenciaLaboral" class="popover-ReferenciaLaboral tono-1 borde rounded p-2" style="display:none; position:absolute; z-index:1055; width:90%; max-width:600px;">
                                                    <form id="form-referencias_laborales" name="form-referencias_laborales" class="p-3 m-0 rounded shadow tono-2" style="width: 100%;" method="POST">
                                                        <div style="text-align: right;">
                                                            <button type="button" onclick="cerrarReferenciaLaboral()" class="btn btn-sm btn-link" aria-label="Cerrar">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-12">
                                                            <h6 class="title">Referencia Laboral</h6>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="referencias_nombrel" id="referencias_nombrel" required placeholder="">
                                                                        <label for="referencias_nombrel">Nombre Completo</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please provide a valid name</div>
                                                            </div>
                                                            <div hidden>
                                                                <input type="text" class="form-control" name="id_referenciasl" id="id_referenciasl">
                                                            </div>
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="referencias_profesionl" id="referencias_profesionl" required placeholder="">
                                                                        <label for="referencias_profesionl">Cargo o Profesión</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please provide a valid position or profession</div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="referencias_empresal" id="referencias_empresal" required placeholder="">
                                                                        <label for="referencias_empresal">Empresa</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please provide a valid company name</div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="number" class="form-control border-start-0" name="referencias_telefonol" id="referencias_telefonol" required placeholder="">
                                                                        <label for="referencias_telefonol">Teléfono</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please provide a valid phone number</div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn bg-primary btn-sm w-100">Guardar</button>
                                                    </form>
                                                    <div class="alert alert-danger" role="alert" style="margin-top: 20px;">
                                                        <strong>Importante:</strong>Recuerda que para poder continuar, debes tener al menos dos registros.
                                                    </div>
                                                    </form>
                                                </div>
                                                <!-- paso para los documentos obligatorios paso 8-->
                                                <div class="col-12 col-sm-12 col-md-9 tono-2 px-4 pt-4" id="form8">
                                                    <div class="row">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h6 class="title">Documentos Obligatorios</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div id="mostrar_documentos_obligatorios"></div>
                                                            <div id="boton_continuar" class="text-end mt-3" style="display: none;">
                                                                <button class="btn btn-primary btn-sm" onclick="avanzarAlSiguientePaso()">Continuar</button>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- pasos para los documentos adicionales paso 9-->
                                                <div class="col-12 col-sm-12 col-md-9 tono-2 px-4 pt-4" id="form9">
                                                    <button class="btn bg-primary btn-xs" onclick="CrearDocumentosAdicionalesPopover(event)">
                                                        <i class="fas fa-plus-circle"></i> Nuevo Documento Adicional
                                                    </button>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3 class="profile-username text-center">Documentos Adicionales</h3>
                                                            <table id="table-documentos_adicionales" class="table table-hover table-responsive-lg">
                                                                <thead>
                                                                    <th>Titulo </th>
                                                                    <th>Archivo </th>
                                                                    <th></th>
                                                                </thead>
                                                                <tbody class="body-documentos_adicionales">
                                                                </tbody>
                                                            </table>
                                                            <div class="col-12 mt-3 text-end" id="btnSiguiente_documentos_adicionales" style="display: none;">
                                                                <button class="btn btn-primary btn-sm" onclick="avanzarAlSiguientePaso()">Continuar</button>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="popoverDocumentosAdicionales" class="popover-DocumentosAdicionales tono-1 borde rounded p-2" style="display:none; position:absolute; z-index:1055; width:90%; max-width:600px;">
                                                    <form id="form-documentos_adicionales" name="form-documentos_adicionales" class="p-3 m-0 rounded shadow tono-2" style="width: 100%;" method="POST">
                                                        <div style="text-align: right;">
                                                            <button type="button" onclick="cerrarDocumentosAdicionales()" class="btn btn-sm btn-link" aria-label="Cerrar">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-12">
                                                            <h6 class="title">Documentos Adicionales</h6>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control border-start-0" name="referencias_nombrel" id="referencias_nombrel" required placeholder="">
                                                                        <label for="referencias_nombrel">Nombre Completo</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please provide a valid name</div>
                                                            </div>
                                                            <div hidden>
                                                                <input type="text" class="form-control" name="id_referenciasl" id="id_referenciasl">
                                                            </div>
                                                            <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <input type="text" placeholder="" value="" class="form-control border-start-0" name="documento_nombreA" id="documento_nombreA" required>
                                                                        <label>Título Portafolio</label>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="help-block"><i id="span-documento_archivoA" class="fa"></i> Documento </label>
                                                                <div class="input-group">
                                                                    <input type="file" class="form-control" name="documento_archivoA" id="documento_archivoA">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn bg-primary btn-sm w-100 mt-3">Guardar</button>
                                                    </form>
                                                    <div class="alert alert-danger" role="alert" style="margin-top: 20px;">
                                                        <strong>Importante:</strong>Recuerda que para poder continuar, debes tener al menos un registro.
                                                    </div>
                                                    </form>
                                                </div>
                                                <!-- paso para las areas de conocimient paso 10-->
                                                <div class="col-12 col-sm-12 col-md-9 tono-2 px-4 pt-4" id="form10">
                                                    <button class="btn bg-primary btn-xs" onclick="CrearAreaConocimientoPopover(event)">
                                                        <i class="fas fa-plus-circle"></i> Nuevo Área de Conocimiento
                                                    </button>
                                                    <div class="row">
                                                        <div class="col-md-12" style="margin-top: 40px;">
                                                            <h3 class="profile-username text-center">Areas de Conocimiento</h3>
                                                            <div class="table-responsive"> <!-- Contenedor responsive -->
                                                                <table id="table-areas_de_conocimiento" class="table table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Opciones</th>
                                                                            <th>Nombre Area </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="body-areas_de_conocimiento"></tbody>
                                                                </table>
                                                            </div>
                                                            <div class="col-12 mt-3 text-end" id="btnSiguiente_areas" style="display: none;">
                                                                <button class="btn btn-primary btn-sm" onclick="avanzarAlSiguientePaso()">Finalizar</button>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="popoverAreaConocimiento" class="popover-AreaConocimiento tono-1 borde rounded p-2" style="display:none; position:absolute; z-index:1055; width:90%; max-width:600px;">
                                                    <form id="form-areas_de_conocimiento" name="form-areas_de_conocimiento" class="p-3 m-0 rounded shadow tono-2" style="width: 100%;" method="POST">
                                                        <div style="text-align: right;">
                                                            <button type="button" onclick="cerrarAreaConocimiento()" class="btn btn-sm btn-link" aria-label="Cerrar">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-12">
                                                            <h6 class="title">Áreas de conocimiento</h6>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-12 mt-4">
                                                                <div class="form-group mb-3 position-relative check-valid">
                                                                    <div class="form-floating">
                                                                        <select name="nombre_area" class="form-control">
                                                                            <option value="Legislación laboral">Legislación laboral</option>
                                                                            <option value="Legislación comercial">Legislación comercial</option>
                                                                            <option value="Legislación tributaria">Legislación tributaria</option>
                                                                            <option value="Régimen de importaciones y exportaciones">Régimen de importaciones y exportaciones</option>
                                                                            <option value="Matemáticas">Matemáticas</option>
                                                                            <option value="Contabilidad">Contabilidad</option>
                                                                            <option value="Finanzas">Finanzas</option>
                                                                            <option value="Planeación">Planeación</option>
                                                                            <option value="Administración">Administración</option>
                                                                            <option value="Economía">Economía</option>
                                                                            <option value="Mercadeo">Mercadeo</option>
                                                                            <option value="Talento Humano">Talento Humano</option>
                                                                            <option value="Logística y distribución internacional">Logística y distribución internacional</option>
                                                                            <option value="Proyectos empresariales">Proyectos empresariales</option>
                                                                            <option value="Tecnologías de la Información">Tecnologías de la Información</option>
                                                                            <option value="Programación de Software">Programación de Software</option>
                                                                            <option value="Desarrollo en Java, PHP, HTML5 y CSS">Desarrollo en Java, PHP, HTML5 y CSS</option>
                                                                            <option value="Administración de bases de datos DBA">Administración de bases de datos DBA</option>
                                                                            <option value="Emprendimiento y planes de negocio">Emprendimiento y planes de negocio</option>
                                                                            <option value="Diseño gráfico">Diseño gráfico</option>
                                                                            <option value="Negocios Internacionales">Negocios Internacionales</option>
                                                                            <option value="Administración documental">Administración documental</option>
                                                                            <option value="Gestión Bancaria">Gestión Bancaria</option>
                                                                            <option value="Atención a la primera infancia">Atención a la primera infancia</option>
                                                                            <option value="Mantenimiento de computadores">Mantenimiento de computadores</option>
                                                                            <option value="Salud ocupacional">Salud ocupacional</option>
                                                                            <option value="Inglés">Inglés</option>
                                                                            <option value="Organización de eventos">Organización de eventos</option>
                                                                            <option value="Metodología de la investigación">Metodología de la investigación</option>
                                                                            <option value="Lectoescritura">Lectoescritura</option>
                                                                            <option value="Teoría del conocimiento">Teoría del conocimiento</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="invalid-feedback">Please enter valid input</div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn bg-primary btn-sm w-100">Guardar</button>
                                                    </form>
                                                    <div class="alert alert-danger" role="alert" style="margin-top: 20px;">
                                                        <strong>Importante:</strong>Recuerda que para poder continuar, debes tener al menos un registro.
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div id="info_preloader">
    </div>
    <div class="modal" id="modal-documentos_obligatorios" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="modalTitle">Documento Obligatorio</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" name="form-documentos_obligatorios" id="form-documentos_obligatorios">
                        <input type="hidden" id="id_usuario_cv_documento_obligatorio" name="id_usuario_cv_documento_obligatorio">
                        <input type="hidden" id="nombre_tipos_documentos" name="nombre_tipos_documentos">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="documento_archivo" class="help-block"><i class="fas fa-file-alt"></i> Documento</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <input type="file" class="form-control" name="documento_archivo" id="documento_archivo">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fas fa-arrow-alt-circle-left"></i> Cancelar</button>
                    <button type="submit" class="btn btn-success btn-flat"><i class="fas fa-save"></i> Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="porcentaje_avance" name="porcentaje_avance" value="<?= $info_usuario['porcentaje_avance'] ?>">
<?php
    require 'footer.php';
}
ob_end_flush();
?>
<script src="scripts/cvpanel.js"></script>
<script src="scripts/cvinformacion-personal.js"></script>
</body>

</html>