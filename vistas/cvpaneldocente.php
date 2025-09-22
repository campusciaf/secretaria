<?php

ob_start();
session_start();
error_reporting(0);
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 5;
    require 'header_docente.php';
?>
<!-- <div id="precarga" class="precarga"></div> -->
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<!--Contenido-->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><small id="nombre_programa"></small>Hoja de vida unica</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">hojas de vida</li>
                    </ol>
                </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>  <!-- /.container-fluid -->
    </div>
    <section class="content" style="padding-top: 0px;">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card card-primary" style="padding: 2% 1%">
                    <div class="box-body box-form-cv">
                        <ul class="nav nav-tabs nav-pills" role="tablist">
                            <li role="presentation" class="nav-item">
                                <a class="nav-link active" href="#personales" aria-controls="personales" role="tab" data-id="1" data-toggle="tab"><i class="fas fa-user-tie"></i> - Datos Personales </a>
                            </li>
                            <li role="presentation" class="nav-item"><a class="nav-link" href="#experiencia" aria-controls="experiencia" role="tab" data-id="2" data-toggle="tab"><i class="fas fa-cog fa-spin"></i> - Experiencia</a>
                            </li>
                            <li role="presentation"><a class="nav-link" href="#habilidad" aria-controls="habilidad" role="tab" data-id="3" data-toggle="tab"><i class="fas fa-lightbulb"></i> - Habilidades</a></li>

                            <li role="presentation"><a class="nav-link" href="#portafolio" aria-controls="portafolio" role="tab" data-id="4" data-toggle="tab"><i class="fas fa-briefcase"></i> - Portafolio</a></li>

                            <li role="presentation"><a class="nav-link" href="#referencias" aria-controls="referencias" role="tab" data-id="5" data-toggle="tab"><i class="fas fa-users"></i> - Referencias</a>
                            </li>

                            <li role="presentation"><a class="nav-link" href="#documentos" aria-controls="documentos" role="tab" data-id="6" data-toggle="tab"><i class="fas fa-users"></i> - Documentos</a>
                            </li>

                            <li role="presentation"><a class="nav-link" href="#areas_conocimientos" aria-controls="areas_conocimientos" data-id="7" role="tab" data-toggle="tab"><i class="fas fa-pencil-ruler"></i> - Areas de conocimiento</a>
                            </li>

                        </ul>

                        <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active show" id="personales">
                        <form name="informacion_personal_form" id="informacion_personal_form" method="POST">
                                    <div class="row">
                                        <div class="col-md-6" hidden>
                                            <label class="help-block"><i id="span-id_usuario_cv" class="fa"></i> ID Usuario(s):</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fas fa-user-tag"></i>
                                                </div>
                                                <input type="text" class="form-control" name="id_usuario_cv" id="id_usuario_cv" value="<?php echo $info_usuario['id_usuario_cv']?>">
                                            </div>
                                        </div> 
                                        
                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="input-group-prepend help-block label-nombre"><i id="span-nombres" class="fa"></i> Nombre(s):</label>
                                            <div class="input-group form-text">
                                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                                    <i class="fas fa-user-tag"></i>
                                                </div>
                                                <input type="text" class="form-control" name="nombres" id="nombres" maxlength="50" placeholder="Nombre Completo" required="" value="<?php echo $_SESSION["usuario_nombre"]?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="input-group-prepend help-block label-nombre"><i id="span-apellidos" class="fa"></i>  Apellidos:</label>
                                            <div class="input-group form-text">
                                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                                    <i class="fas fa-user-tag"></i>
                                                </div>
                                                <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Apellidos" required="" value="<?php echo $_SESSION["usuario_apellido"]?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="input-group-prepend help-block"><i id="span-fecha_nacimiento" class="fa"></i> Fecha de nacimiento:</label>
                                            <div class="input-group form-text">
                                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                                <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" required="" value="<?php echo $info_usuario["fecha_nacimiento"]?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="input-group-prepend help-block"><i id="span-estado_civil" class="fa"></i> Estado cívil:</label>
                                            <div class="input-group form-text">
                                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                                    <i class="fa fa-heart"></i>
                                                </div>
                                                <select class="form-control select-picker" name="estado_civil" id="estado_civil">
                                                    <option value="" disabled selected>Selecciona una opción</option>
                                                    <option <?php echo ($info_usuario["estado_civil"] == "SOLTERO/A")?"selected":"" ?> value="SOLTERO/A">Soltero/a</option>
                                                    <option <?php echo ($info_usuario["estado_civil"] == "UNIÓN LIBRE")?"selected":"" ?> value="UNIÓN LIBRE">Unión Libre</option>
                                                    <option <?php echo ($info_usuario["estado_civil"] == "CASADO/A")?"selected":"" ?> value="CASADO/A">Casado/a</option>
                                                    <option <?php echo ($info_usuario["estado_civil"] == "SEPERADO/A")?"selected":"" ?> value="SEPERADO/A">Separado/a</option>
                                                    <option <?php echo ($info_usuario["estado_civil"] == "DIVORCIADO/A")?"selected":"" ?> value="DIVORCIADO/A">Judicialmente divorciado/a</option>
                                                    <option <?php echo ($info_usuario["estado_civil"] == "VIUDO/A")?"selected":"" ?> value="VIUDO/A">Viudo/a</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="input-group-prepend help-block"><i id="span-departamento" class="fa"></i> Departamento:</label>
                                            <div class="input-group form-text">
                                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                                    <i class="fa fa-home"></i>
                                                </div>
                                                <select class="form-control departamento" name="departamento" id="departamento" data-live-search="true" data-style="border" required>
                                                    <option value="" selected disabled> --Departamento-- </option>
                                                    <?php foreach($departamentos_arr as $d): ?>
                                                    <option <?php echo ($info_usuario['departamento']==$d['id'])?"selected":"" ?> value="<?php echo $d['id'] ?>" class="option-depart"><?php echo $d['departamento'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="input-group-prepend help-block"><i id="span-ciudad" class="fa"></i> Municipio:</label>
                                            <div class="input-group form-text">
                                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                                    <i class="fa fa-map"></i>
                                                </div>
                                                <select class="form-control ciudad" name="ciudad" id="ciudad" data-live-search="true" required>
                                                    <option value="" selected disabled>Selecciona departamento</option>
                                                    <?php foreach($municipios_arr as $ciudades): ?>
                                                    <option <?php echo ($info_usuario['ciudad']==$ciudades['id'])?"selected":"" ?> value="<?php echo $ciudades['id'] ?>" class="option-depart"><?php echo $ciudades['municipio'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="input-group-prepend help-block"><i id="span-direccion" class="fa"></i> Dirección:</label>
                                            <div class="input-group form-text">
                                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                                    <i class="fa fa-home"></i>
                                                </div>
                                                <input type="text" class="form-control" name="direccion" id="direccion" maxlength="50" placeholder="Dirección de residencia" required="" value="<?php echo ($info_usuario['direccion']) ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="input-group-prepend help-block"><i id="span-celular" class="fa"></i> Celular:</label>
                                            <div class="input-group form-text">
                                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                                    <i class="fas fa-mobile-alt"></i>
                                                </div>
                                                <input type="number" class="form-control" name="celular" id="celular" maxlength="20" placeholder="Número de celular" required="" value="<?php echo ($info_usuario['celular']) ?>">
                                            </div>
                                        </div>
                                        
                                        <!-- <div class="col-md-6 mt-3 mb-3">
                                            <label class="help-block">Foto de perfil:</label>
                                            <input class="hidden" id="foto" name="foto" type="file" accept="image/x-png,image/gif,image/jpeg">
                                            <label class="help-block text-center" for="foto" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Click aquí para subir tu foto">
                                                <img id="foto" src="../files/usuarios/<?php echo $_SESSION["usuario_imagen_cv"]?>" width="100px" height="100px" alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto">
                                            </label>
                                        </div> -->

                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="help-block"><i id="span-nacionalidad" class="fa"></i> Nacionalidad:</label>
                                            <div class="input-group form-text">
                                            <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                                    <i class="fas fa-user-tie"></i>
                                                </div>
                                                <input type="text" class="form-control" maxlength="30" name="nacionalidad" id="nacionalidad" placeholder="Nacionalidad" required value="<?php echo ($info_usuario['nacionalidad']) ?>">

                                            </div>
                                        </div>

                                    <div class="col-md-6 mt-3 mb-3">
                                            <label class="input-group form-text"><i id="span-pagina_web" class="fa"></i> Página Web:</label>
                                            <div class="input-group form-text">
                                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                                    <i class="fas fa-link"></i>
                                                </div>
                                                <input type="text" class="form-control" maxlength="30" name="pagina_web" id="pagina_web" placeholder="Dirección url Página Web" required value="<?php echo ($info_usuario['pagina_web']) ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-12 text-center">
                                            <div class="col-md-12 text-left">
                                                <h2 style="color: #040404;font-size: 18px; margin-top: 10px"><strong>Perfil Profesional</strong></h2>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="input-group form-text"><i id="span-titulo_profesional" class="fa"></i> Titulo Profesional:</label>
                                            <div class="input-group form-text">
                                            <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                                    <i class="fas fa-user-tie"></i>
                                                </div>
                                                <input type="text" class="form-control" maxlength="30" name="titulo_profesional" id="titulo_profesional" placeholder="Titulo Profesional o labor" required value="<?php echo ($info_usuario['titulo_profesional']) ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label class="input-group form-text"><i id="span-categoria_profesion" class="fa"></i> Categoria perfil:</label>
                                            <div class="input-group form-text">
                                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                                    <i class="fas fa-briefcase"></i>
                                                </div>
                                                <select class="form-control" name="categoria_profesion" id="categoria_profesion" required>
                                                    <option value="" selected disabled>Selecciona departamento</option>
                                                        <?php foreach($categorias_arr as $categoria): ?>
                                                    <option <?php echo ($info_usuario['categoria_profesion']==$categoria['categoria'])?"selected":""?>  value="<?php echo $categoria['categoria'] ?>" class="option-depart"><?php echo $categoria['categoria'];?></option>

                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="input-group form-text"><i id="span-situacion_laboral" class="fa"></i> Situación laboral:</label>
                                            <div class="input-group form-text">
                                                <div class="input-group-text input-group-addon" style="background-color: white !important;" >
                                                        <i class="fa fa-map"></i>
                                                </div>
                                                <select class="form-control" name="situacion_laboral" id="situacion_laboral">
                                                    <option value="nothing" disabled selected="selected">Seleccione una opción</option>
                                                    <option <?php echo ($info_usuario["situacion_laboral"] == "Sin trabajo")?"selected":"" ?> value="Sin trabajo">Sin trabajo</option>
                                                    <option <?php echo ($info_usuario["situacion_laboral"] == "Buscando primer empleo")?"selected":"" ?> value="Buscando primer empleo">Buscando primer empleo</option>
                                                    <option <?php echo ($info_usuario["situacion_laboral"] == "Con trabajo")?"selected":"" ?> value="Con trabajo">Con trabajo</option>
                                                    <option <?php echo ($info_usuario["situacion_laboral"] == "Autoempleado")?"selected":"" ?> value="Autoempleado">Autoempleado</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-3 mb-3" >
                                            <label class="input-group form-text">
                                                <i id="span-resumen_perfil" class="fa"></i> Resumen del perfil:
                                                <i class="far fa-question-circle" data-toggle="tooltip" data-placement="top" title="Resumir acá en máximo dos o tres frases su perfil profesional. Ejemplo: “Administrador de empresas con larga experiencia en gerencia en diferentes empresas comercializadoras y exportadoras. Ha desarrollado grandes aptitudes de manejo de equipo. Muy buen conocimiento del sector energético latinoamericano.” Max. 600 carácteres"></i>
                                            </label>
                                            <textarea class="form-control" rows="4" id="resumen_perfil" name="resumen_perfil"><?php echo ($info_usuario['resumen_perfil']) ?></textarea>
                                        </div>

                                    <div class="col-md-6" >
                                        <label class="help-block"><i id="span-situacion_laboral" class="fa"></i> Experiencia en docencia:</label>
                                        <div class="switch">
                                            <input type="radio" class="switch-input" name="view2" value="1" id="otro_ingreso" <?php echo ($info_usuario["experiencia_docente"] == "1")?"checked":"" ?>>
                                            <label for="otro_ingreso" class="switch-label switch-otro_ingreso switch-label-off">Si</label>
                                            <input type="checkbox" class="switch-input" name="view2" value="0" id="otro_ingresoff" <?php echo ($info_usuario["experiencia_docente"] == "0")?"checked":"" ?>>
                                            <label for="otro_ingresoff" class="switch-label switch-otro_ingreso switch-label-on">No</label>
                                            <span class="switch-selection"></span>
                                        </div>
                                    </div>
                                    <br>
                                    </div> <!-- End-row -->
                                    <br>   
                                </form>
                                <br>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="experiencia">
                                <div class="row">
                                    <div class="col-md-6 text-center hidden-xs hidden-sm" style="margin-top: 10px">
                                        <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                            <h2 style="font-size: 28px; margin-top: 10px"><strong>Educación y formación</strong></h2>
                                        </div>

                                        <div class="col-md-12" style="margin-top: 10px;margin-bottom: 10px">
                                            <button class="btn btn-primary  btn-flat bg-yale " data-toggle="modal" data-target="#modal-educacion_formacion"><i class="fas fa-plus-circle fa-inverse"></i> Agregar un nuevo </button>
                                        </div>
                                    </div>

                                    <div class="col-md-6 text-center hidden-xs hidden-sm" style="margin-top: 10px">
                                        <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                            <h2 style="font-size: 28px; margin-top: 10px"><strong>Laboral y Docente</strong></h2>
                                        </div>

                                        <div class="col-md-12" style="margin-top: 10px;margin-bottom: 10px">
                                            <button class="btn btn-primary  btn-flat bg-yale " data-toggle="modal" data-target="#modal-experiencia_laboral"><i class="fas fa-plus-circle fa-inverse"></i> Agregar un nuevo </button>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <h3 class="profile-username text-center">Educación y Formación</h3>
                                            <table id="table-educacion_formacion" class="table table-hovered    table-responsive-lg">
                                                <thead>
                                                    <th>Opciones</th>
                                                    <th>Institución <br>Academica</th>
                                                    <th>Titulo Obtenido</th>
                                                    <th>Desde </th>
                                                    <th>Hasta </th>
                                                    <th>detalles </th>
                                                    <th>Certificado </th>
                                                </thead>
                                                <tbody class="body-educacion_formacion">
                                                </tbody>
                                            </table>
                                        <br>

                                    </div>

                                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <h1 class="profile-username text-center">Experiencias Laborales</h1>
                                        <table id="table-experiencias_laborales" class="table table-hovered table-responsive-lg">
                                            <thead>
                                                <th>Opciones</th>
                                                <th>Nombre <br>Empresa</th>
                                                <th>Cargo </th>
                                                <th>Desde </th>
                                                <th>Hasta </th>
                                                <th>detalles </th>
                                            </thead>
                                            <tbody class="body-experiencias_laborales">
                                            </tbody>
                                        </table>
                                        <br>
                                    </div>

                                    <div class="hidden-md hidden-lg mt-3" style ="position: fixed; bottom: 60px;right:10px; z-index: 100">
                                        <button class="btn btn-block btn-secondary btn-flat bg-yale" data-toggle="modal" data-target="#modal-educacion_formacion"><i class="fas fa-plus-circle fa-inverse"></i> Agregar Educación </button>
                                        <button class="btn btn-block btn btn-secondary btn-flat bg-yale" data-toggle="modal" data-target="#modal-experiencia_laboral"><i class="fas fa-plus-circle fa-inverse"></i> Agregar Experiencia </button>
                                    </div>
                                </div>
                                <br>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="habilidad">
                                <div class="row">
                                    <div class="col-md-12 text-center" style="margin-top: 10px">
                                        <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                            <h2 style="font-size: 28px; margin-top: 10px"><strong>Habilidades y aptitudes</strong></h2>
                                        </div>

                                        <div class="col-md-12" style="margin-top: 10px;margin-bottom: 10px">
                                            <button class="btn btn-primary btn-flat bg-yale" data-toggle="modal" data-target="#modal-habilidades_aptitudes"><i class="fas fa-plus-circle fa-inverse"></i> Agregar un nuevo  </button>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <h3 class="profile-username text-center">Habilidades y aptitudes</h3>
                                        <table id="table-habilidades_aptitudes" class="table table-hovered table-responsive-lg">
                                            <thead>
                                                <th>Opciones</th>
                                                <th>Nombre de la Categoria</th>
                                                <th>Nivel de Habilidad</th>
                                            </thead>
                                            <tbody class="body-habilidades_aptitudes">
                                            </tbody>
                                        </table>
                                        <br>
                                    </div>
                                </div>

                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="portafolio">
                                <div class="row">
                                    <div class="col-md-12 text-center" style="margin-top: 10px">
                                        <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                            <h2 style="font-size: 28px; margin-top: 10px"><strong>Portafolio</strong></h2>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 10px;margin-bottom: 10px">
                                            <button class="btn btn-primary  btn-flat bg-yale " data-toggle="modal" data-target="#modal-portafolio"><i class="fas fa-plus-circle fa-inverse"></i> Agregar un nuevo </button>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <h3 class="profile-username text-center">Areas de Conocimiento</h3>
                                        <table id="table-portafolio" class="table table-hovered table-responsive-lg">
                                            <thead>
                                                <th>Opciones</th>
                                                <th>Titulo </th>
                                                <th>Descripción </th>
                                                <th>Video url </th>
                                                <th>Archivo </th>
                                            </thead>
                                            <tbody class="body-portafolio">
                                            </tbody>
                                        </table>
                                        <br>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="referencias">
                                <div class="row">
                                    <div class="col-md-6 text-center" style="margin-top: 10px">
                                        <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                            <h2 style="font-size: 28px; margin-top: 10px"><strong>Referencias Personales</strong></h2>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 10px;margin-bottom: 10px">
                                            <button class="btn btn-primary btn-flat bg-yale" data-toggle="modal" data-target="#modal-referencias_personales"><i class="fas fa-plus-circle fa-inverse"></i> Agregar un nuevo </button>
                                        </div>

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
                                            <br>
                                        </div>
                                    </div>

                                    <div class="col-md-6 text-center" style="margin-top: 10px">
                                        <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                            <h2 style="font-size: 28px; margin-top: 10px"><strong>Referencias Laborales</strong></h2>
                                        </div>

                                        <div class="col-md-12" style="margin-top: 10px;margin-bottom: 10px">
                                            <button class="btn btn-primary  btn-flat bg-yale "  data-toggle="modal"     data-target="#modal-referencias_laborales"><i class="fas fa-plus-circle fa-inverse"></i> Agregar un nuevo 
                                            </button>
                                        </div>

                                        <div class="col-md-12">
                                            <h3 class="profile-username text-center">Referencias personales</h3>
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
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="documentos">
                                <div class="row">
                                    <div class="col-md-6 text-center" style="margin-top: 10px">
                                        <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                            <h2 style="font-size: 28px; margin-top: 10px"><strong>Obligatorios</strong></h2>
                                        </div>

                                        <div class="col-md-12" style="margin-top: 10px;margin-bottom: 10px">
                                            <button class="btn btn-primary btn-flat bg-yale"  data-toggle="modal" data-target="#modal-documentos_obligatorios"><i class="fas fa-plus-circle fa-inverse"></i> Agregar un nuevo </button>
                                        </div>

                                        <div class="col-md-12">
                                            <h3 class="profile-username text-center">Documentos Obligatorios</h3>
                                            <table id="table-documentos_obligatorios" class="table table-hover table-responsive-lg">
                                                <thead>
                                                    <th></th>
                                                    <th>Titulo </th>
                                                    <th>Archivo </th>
                                                </thead>
                                                <tbody class="body-documentos_obligatorios">
                                                </tbody>
                                            </table>
                                            <br>
                                        </div>
                                    </div>

                                    <div class="col-md-6 text-center" style="margin-top: 10px">
                                        <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                            <h2 style="font-size: 28px; margin-top: 10px"><strong>Adicionales</strong></h2>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 10px;margin-bottom: 10px">
                                            <button class="btn btn-primary btn-flat bg-yale " data-toggle="modal" data-target="#modal-documentos_adicionales"><i class="fas fa-plus-circle fa-inverse"></i> Agregar un nuevo 
                                            </button>
                                        </div>
                                        <div class="col-md-12">
                                            <h3 class="profile-username text-center">Documentos Adicionales</h3>
                                            <table id="table-documentos_adicionales" class="table table-hover table-responsive-lg">
                                                <thead>
                                                    <th></th>
                                                    <th>Titulo </th>
                                                    <th>Archivo </th>
                                                </thead>
                                                <tbody class="body-documentos_adicionales">
                                                </tbody>
                                            </table>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="areas_conocimientos">
                                <div class="row">
                                    <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                        <h2 style="font-size: 28px; margin-top: 10px"><strong>Áreas de Conocimiento</strong></h2>
                                    </div>
                                    <form method="POST" class="row col-12" name="form-areas_de_conocimiento" id="form-areas_de_conocimiento">
                                        <div class="col-md-6" style="margin-top: 10px;margin-bottom: 10px">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="background-color: white !important;">
                                                        <i class="fas fa-briefcase"></i>
                                                    </span>
                                                </div>
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
                                                <div class="input-group-append">
                                                    <span class="input-group-text p-0">
                                                        <button type="submit" class="btn btn-success btn-flat"><i class="fas fa-save"></i> Añadir</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <h3 class="profile-username text-center">Areas de Conocimiento</h3>
                                        <table id="table-areas_de_conocimiento" class="table table-hovered table-responsive-lg">
                                            <thead>
                                                <th>Opciones</th>
                                                <th>Nombre Area </th>
                                            </thead>
                                            <tbody class="body-areas_de_conocimiento">
                                            </tbody>
                                        </table>
                                        <br>
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
<div class="modal" id="modal-experiencia_laboral">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Experiencia Laboral</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" name="form-experiencia_laboral" id="form-experiencia_laboral">
                    <div class="row">
                        <div class="col-md-6 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-nombre_empresa" class="fa"></i> Nombre de la empresa</label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="far fa-building"></i>
                                </div>
                                <input type="text" class="form-control" name="nombre_empresa" id="nombre_empresa" placeholder="Nombre de la empresa" required>
                            </div>
                        </div>
                        <div hidden>
                            <input type="text" class="form-control" name="id_experiencia" id="id_experiencia">
                        </div>

                        <div class="col-md-6 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-cargo_empresa" class="fa"></i> Cargo</label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-stethoscope"></i>
                                </div>
                                <input type="text" class="form-control" name="cargo_empresa" id="cargo_empresa" required placeholder="Cargo que desempeñaba en la empresa">
                            </div>
                        </div>                            
                        <div class="col-md-6 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-tiempo_duracion" class="fa"></i>Tiempo de duración:</label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i> <strong>Desde:</strong> </i>
                                </div>
                                <input name="desde_cuando" id="desde_cuando" class="form-control" type="date" required>
                            </div>
                        </div>                            
                        <div class="col-md-6 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-tiempo_duracion" class="fa"></i>Tiempo de duración:</label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i> <strong>Hasta:</strong> </i>
                                </div>
                                <input name="hasta_cuando" id="hasta_cuando" class="form-control" required type="date">
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-mas_detalles" class="fa"></i>Mas Detalles <i class="far fa-question-circle" data-toggle="tooltip" data-placement="top" title=" Más detalles sobre funciones desempañadas, responsabilidades, logros, información de la empresa y más. Se recomienda usar un lenguaje positivo."></i></label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-pencil-ruler"></i>
                                </div>
                                <textarea type="text" rows="6" class="form-control" name="mas_detalles" id="mas_detalles"></textarea>
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
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal" id="modal-educacion_formacion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Educación y Formación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" name="form-educacion_formacion" id="form-educacion_formacion">
                    <div class="row">
                        <div class="col-md-6 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-institucion_academica" class="fa"></i> Instición Academica</label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-school"></i>
                                </div>
                                <input type="text" class="form-control" name="institucion_academica" id="institucion_academica" placeholder="Nombre de la institución" required>
                            </div>
                        </div>

                        <div hidden>
                            <input type="text" class="form-control" name="id_formacion" id="id_formacion">
                        </div>

                        <div class="col-md-6 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-titulo_obtenido" class="fa"></i>Titulo Obtenido</label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-stethoscope"></i>
                                </div>
                                <input type="text" class="form-control" name="titulo_obtenido" id="titulo_obtenido" required placeholder="Ej: Bachiller">
                            </div>
                        </div>                            

                        <div class="col-md-6 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-tiempo_duracion_formacion" class="fa"></i>Tiempo de duración:</label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i> <strong>Desde:</strong> </i>
                                </div>
                                <input name="desde_cuando_f" id="desde_cuando_f" class="form-control" type="date" required>
                            </div>
                        </div>                            

                        <div class="col-md-6 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-tiempo_duracion_formacion" class="fa"></i>Tiempo de duración:</label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i></i> <strong>Hasta:</strong> </i>
                                </div>
                                <input name="hasta_cuando_f" id="hasta_cuando_f" class="form-control" required type="date">
                            </div>
                        </div>

                        <div class="col-md-12 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-mas_detalles_f" class="fa"></i>Mas Detalles <i class="far fa-question-circle" data-toggle="tooltip" data-placement="top" title=" Más detalles sobre su educación y formación. Ej: Premios, diplomas, otras informaciones sobre sus estudios."></i></label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-pencil-ruler"></i>
                                </div>
                                <textarea type="text" rows="6" class="form-control" name="mas_detalles_f" id="mas_detalles_f"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-certificado_educacion" class="fa"></i>Certificado de educación </label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-pencil-ruler"></i>
                                </div>
                                <input type="file" class="form-control" name="certificado_educacion" id="certificado_educacion">
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

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal" id="modal-portafolio">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Portafolio</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" name="form-portafolio" id="form-portafolio">
                    <div class="row">
                        <div class="col-md-6 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-titulo_portafolio" class="fa"></i> Titulo Portafolio: </label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-school"></i>
                                </div>
                                <input type="text" class="form-control" name="titulo_portafolio" id="titulo_portafolio" placeholder="Titulo de Portafolio" required>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-video_portafolio" class="fa"></i>Video de youtube</label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-video"></i>
                                </div>
                                <input type="text" class="form-control" name="video_portafolio" id="video_portafolio" required placeholder="Ej: url del video">
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-descripcion_portafolio" class="fa"></i>Descripción: </label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-pencil-ruler"></i>
                                </div>
                                <textarea type="text" rows="6" class="form-control" name="descripcion_portafolio" id="descripcion_portafolio"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="help-block"><i id="span-portafolio_archivo" class="fa"></i>Archivo PDF: </label>
                            <div class="input-group">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-pencil-ruler"></i>
                                </div>
                                <input type="file" class="form-control" name="portafolio_archivo" id="portafolio_archivo">
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
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal" id="modal-habilidades_aptitudes">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Habilidades y Aptitudes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" name="form-habilidades_aptitudes" id="form-habilidades_aptitudes">
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
                        <div class="col-md-12 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-categoria_habilidad" class="fa"></i>Nombre de la categoria:</label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-stethoscope"></i>
                                </div>
                                <input type="text" class="form-control" name="categoria_habilidad" id="categoria_habilidad" required placeholder="Ej: Habilidades linguisticas">
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 mb-3">
                            <label class="input-group-prepend help-block"><i id="span-categoria_habilidad" class="fa"></i><i class="fas fa-square-full rango_del_color"></i> Nivel de habilidad: <i class="far fa-question-circle" data-toggle="tooltip" data-placement="top" title="El rango es de 1 a 5, Entre mas alto, mas nivel tienes."></i></label>
                            <div class="input-group form-text">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-stethoscope"></i>
                                </div>
                                <input type="range" class="form-control" name="nivel_habilidad" id="nivel_habilidad" min="1" max="5" step="1">
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
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal" id="modal-referencias_personales">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Referencias Personales</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" name="form-referencias_personales" id="form-referencias_personales">
                    <div class="row">
                        <div class="col-md-6 mt-3 mb-3">
                            <label class="help-block"><i id="span-referencias_nombre" class="fa"></i> Nombre Completo</label>
                            <div class="input-group">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="far fa-building"></i>
                                </div>
                                <input type="text" class="form-control" name="referencias_nombre" id="referencias_nombre" placeholder="Nombre de la empresa" required>
                            </div>
                        </div>
                        <div hidden>
                            <input type="text" class="form-control" name="id_referencias" id="id_referencias">
                        </div>
                        <div class="col-md-6 mt-3 mb-3">
                            <label class="help-block"><i id="span-referencias_profesion" class="fa"></i> Cargo o Profesión</label>
                            <div class="input-group">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-stethoscope"></i>
                                </div>
                                <input type="text" class="form-control" name="referencias_profesion" id="referencias_profesion" required placeholder="Cargo que desempeña en la empresa">
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mb-3">
                            <label class="help-block"><i id="span-referencias_empresa" class="fa"></i> Empresa</label>
                            <div class="input-group">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;"> 
                                    <i class="fas fa-stethoscope"></i>
                                </div>
                                <input type="text" class="form-control" name="referencias_empresa" id="referencias_empresa" required placeholder="Nombre de la empresa">
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mb-3">
                            <label class="help-block"><i id="span-referencias_telefono" class="fa"></i> Telefono</label>
                            <div class="input-group">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-stethoscope"></i>
                                </div>
                                <input type="text" class="form-control" name="referencias_telefono" id="referencias_telefono" required placeholder="Teléfono de contacto">
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
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal" id="modal-referencias_laborales">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Referencias Laborales</h4>                                       
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" name="form-referencias_laborales" id="form-referencias_laborales">
                    <div class="row">
                        <div class="col-md-6 mt-3 mb-3">
                            <label class="help-block"><i id="span-referencias_nombrel" class="fa"></i> Nombre Completo</label>
                            <div class="input-group">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="far fa-building"></i>
                                </div>
                                <input type="text" class="form-control" name="referencias_nombrel" id="referencias_nombrel" placeholder="Nombre de la empresa" required>
                            </div>
                        </div>
                        <div hidden>
                            <input type="text" class="form-control" name="id_referenciasl" id="id_referenciasl">
                        </div>
                        <div class="col-md-6 mt-3 mb-3">
                            <label class="help-block"><i id="span-referencias_profesionl" class="fa"></i> Cargo o Profesión</label>
                            <div class="input-group">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-id-card-alt"></i>
                                </div>
                                <input type="text" class="form-control" name="referencias_profesionl" id="referencias_profesionl" required placeholder="Cargo que desempeña en la empresa">
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mb-3">
                            <label class="help-block"><i id="span-referencias_empresal" class="fa"></i> Empresa</label>
                            <div class="input-group">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-stethoscope"></i>
                                </div>
                                <input type="text" class="form-control" name="referencias_empresal" id="referencias_empresal" required placeholder="Nombre de la empresa">
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mb-3">
                            <label class="help-block"><i id="span-referencias_telefonol" class="fa"></i> Telefono</label>
                            <div class="input-group">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-mobile"></i>
                                </div>
                                <input type="text" class="form-control" name="referencias_telefonol" id="referencias_telefonol" required placeholder="Teléfono de contacto">
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
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal" id="modal-documentos_obligatorios">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Documentación Obligatoria </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" name="form-documentos_obligatorios" id="form-documentos_obligatorios">
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label class="input-group-prepend help-block"><i id="span-documento_nombre" class="fa"></i>Tipo Documento</label> 
                            <div class="form-group">
                                <div class="input-group form-text">
                                    <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                        <i class="fas fa-id-card-alt"></i>
                                    </div>
                                    <select class="form-control" name="documento_nombre" id="documento_nombre" >
                                        <option value="Cédula de ciudadania">Cédula de ciudadania</option>
                                        <option value="Tarjeta Profesional">Tarjeta Profesional</option>
                                        <option value="Libreta Militar">Libreta Militar</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="help-block"><i id="span-documento_archivo" class="fa"></i> Documento </label>
                            <div class="input-group">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <input type="file" class="form-control" name="documento_archivo" id="documento_archivo">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fas fa-arrow-alt-circle-left"></i> Cancelar</button>
                        <button type="submit" class="btn btn-success btn-flat"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal" id="modal-documentos_adicionales">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Documentación Adicional </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" name="form-documentos_adicionales" id="form-documentos_adicionales">
                    <div class="row">
                        <div class="col-md-12 mt-3 mb-3">
                            <label class="help-block"><i id="span-documento_nombreA" class="fa"></i>Tipo Documento</label>
                            <div class="input-group">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;" >
                                    <i class="fas fa-id-card-alt"></i>
                                </div>
                                <input type="text" class="form-control" name="documento_nombreA" id="documento_nombreA" placeholder="Nombre de Documento" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="help-block"><i id="span-documento_archivoA" class="fa"></i> Documento </label>
                            <div class="input-group">
                                <div class="input-group-text input-group-addon" style="background-color: white !important;">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <input type="file" class="form-control" name="documento_archivoA" id="documento_archivoA">
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
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php

    require 'footer.php';

}

ob_end_flush();

?>

<script src="scripts/cvpaneldocente.js"></script>
<script src="scripts/cvinformacion-personal-docente.js"></script>

</body>

</html>