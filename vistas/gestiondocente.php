<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login");
} else {
    $menu = 6;
    $submenu = 601;
    require 'header.php';
    if ($_SESSION['gestiondocente'] == 1) {
?>
        <div id="precarga" class="precarga" style="display: none;"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><small id="nombre_programa"></small>Gestión Docente</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión docente</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row mx-0">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-hover table-nowarp">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Apellido</th>
                                        <th>Nombre</th>
                                        <th>Titulo obtenido</th>
                                        <th>Documento</th>
                                        <th>Celular</th>
                                        <th>Email Personal</th>
                                        <th>Email CIAF</th>
                                        <th>Tipo de Contrato</th>
                                        <th>Tiempo</th>
                                        <th>Foto</th>
                                        <th>Ultima Actualizacion</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 panel-body" id="formularioregistros">
                    <form name="formulario" id="formulario" method="POST">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="title">Datos Personales</h6>
                            </div>

                            <input type="hidden" name="id_usuario" id="id_usuario">

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="usuario_nombre" id="usuario_nombre"
                                        maxlength="100" required onchange="this.value=this.value.toUpperCase();">
                                    <label for="usuario_nombre">Primer Nombre</label>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="usuario_nombre_2" id="usuario_nombre_2"
                                        maxlength="100" onchange="this.value=this.value.toUpperCase();">
                                    <label for="usuario_nombre_2">Segundo Nombre</label>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="usuario_apellido" id="usuario_apellido"
                                        maxlength="100" required onchange="this.value=this.value.toUpperCase();">
                                    <label for="usuario_apellido">Primer Apellido</label>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="usuario_apellido_2" id="usuario_apellido_2"
                                        maxlength="100" onchange="this.value=this.value.toUpperCase();">
                                    <label for="usuario_apellido_2">Segundo Apellido</label>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select selectpicker" data-live-search="true"
                                        name="usuario_tipo_documento" id="usuario_tipo_documento" required></select>
                                    <label for="usuario_tipo_documento">Tipo Documento</label>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="usuario_identificacion"
                                        id="usuario_identificacion" maxlength="20" required>
                                    <label for="usuario_identificacion">Número Identificación</label>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" name="usuario_fecha_nacimiento"
                                        id="usuario_fecha_nacimiento" required>
                                    <label for="usuario_fecha_nacimiento">Fecha de Nacimiento</label>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select selectpicker" data-live-search="true"
                                        name="usuario_departamento_nacimiento" id="usuario_departamento_nacimiento" required></select>
                                    <label for="usuario_departamento_nacimiento">Departamento Nacimiento</label>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select selectpicker" data-live-search="true"
                                        name="usuario_municipio_nacimiento" id="usuario_municipio_nacimiento" required></select>
                                    <label for="usuario_municipio_nacimiento">Municipio Nacimiento</label>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="usuario_direccion_2"
                                        id="usuario_direccion_2" maxlength="250">
                                    <label for="usuario_direccion_2">Dirección</label>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select selectpicker" data-live-search="true"
                                        name="usuario_tipo_sangre" id="usuario_tipo_sangre" required></select>
                                    <label for="usuario_tipo_sangre">Tipo de Sangre</label>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="usuario_telefono"
                                        id="usuario_telefono" maxlength="7">
                                    <label for="usuario_telefono">Teléfono</label>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="usuario_celular_2"
                                        id="usuario_celular_2" maxlength="20">
                                    <label for="usuario_celular_2">Celular</label>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" name="usuario_email_p"
                                        id="usuario_email_p" maxlength="50">
                                    <label for="usuario_email_p">Email Personal</label>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select selectpicker" data-live-search="true"
                                        name="usuario_estado_civil" id="usuario_estado_civil" required></select>
                                    <label for="usuario_estado_civil">Estado Civil</label>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="usuario_email_ciaf"
                                        id="usuario_email_ciaf" maxlength="50" required>
                                    <label for="usuario_email_ciaf">Email CIAF/Login</label>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select selectpicker" data-live-search="true"
                                        name="usuario_genero" id="usuario_genero" required></select>
                                    <label for="usuario_genero">Género</label>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                <label for="usuario_imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" name="usuario_imagen" id="usuario_imagen">
                                <input type="hidden" name="imagenactual" id="imagenactual">
                                <img src="" width="150px" height="120px" id="imagenmuestra" class="mt-2 border rounded">
                            </div>

                            <div class="col-12 mt-3">
                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>

            </section>
        </div>

        <div class="modal" id="MymodalMostrarContrato">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Crear Contrato</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form name="formulariocrearcontrato" id="formulariocrearcontrato" method="POST">
                        <input type="text" class="d-none" id="documento_docente_contrato"
                            name="documento_docente_contrato">
                        <input type="text" class="d-none" id="nombre_docente_contrato"
                            name="nombre_docente_contrato">
                        <input type="text" class="d-none" id="apellido_docente_contrato"
                            name="apellido_docente_contrato">
                        <input type="text" class="d-none" id="usuario_email_p_contrato"
                            name="usuario_email_p_contrato">
                        <div class="modal-body">
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select value="" required
                                                    class="form-control border-start-0 selectpicker"
                                                    data-live-search="true" name="tipo_contrato_docente"
                                                    id="tipo_contrato_docente"
                                                    onchange="mostrar_datos_hora_catedra(this.value)">
                                                    <option value="1" selected>MEDIA JORNADA
                                                    </option>
                                                    <option value="2">TIEMPO COMPLETO</option>
                                                    <option value="3">HORA CATEDRA</option>
                                                    <option value="4">PRESTACIÓN DE
                                                        SERVICIOS</option>
                                                </select>
                                                <label>Tipo Contrato</label>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value=""
                                                    class="form-control border-start-0"
                                                    name="salario_docente" id="salario_docente"
                                                    maxlength="100" required>
                                                <label>Salario</label>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="cargo_docente_ocultar">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value=""
                                                    class="form-control border-start-0" name="cargo_docente"
                                                    id="cargo_docente">
                                                <label>Cargo Docente</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-md-6" id="cantidad_horas_ocultar">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value=""
                                                    class="form-control border-start-0"
                                                    name="cantidad_horas" id="cantidad_horas"
                                                    maxlength="100">
                                                <label>Cantidad Horas</label>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select value="" required
                                                    class="form-control border-start-0 selectpicker"
                                                    data-live-search="true" name="auxilio_transporte"
                                                    id="auxilio_transporte">
                                                    <option value="">selecciona una opcion</option>
                                                    <option value="1">SI</option>
                                                    <option value="0">NO</option>
                                                </select>
                                                <label>Requiere auxilio de transporte</label>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="valor_horas_ocultar">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value=""
                                                    class="form-control border-start-0" name="valor_horas"
                                                    id="valor_horas" maxlength="100">
                                                <label>Valor Horas</label>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="materia_docente_ocultar">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value=""
                                                    class="form-control border-start-0"
                                                    name="materia_docente" id="materia_docente">
                                                <label>Materia Docente</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="date" required
                                                    class="form-control border-start-0"
                                                    name="fecha_inicio_contrato" id="fecha_inicio_contrato">
                                                <label for="fecha_inicio_contrato">Fecha de Inicio:</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="date" required
                                                    class="form-control border-start-0"
                                                    name="fecha_final_contrato" id="fecha_final_contrato">
                                                <label for="fecha_final_contrato">Fecha de Final:</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select value="" required
                                                    class="form-control border-start-0 selectpicker"
                                                    data-live-search="true" name="periodo" id="periodo">
                                                    <option value="" disabled selected>Periodo</option>
                                                </select>
                                                <label>Año de ingreso</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success" type="submit" id="btnInsertarContrato">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-danger"
                                data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalEditarFuncionario" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tipo de Contrato</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="formularioeditarfuncionario" id="formularioeditarfuncionario"
                            method="POST" enctype="multipart/form-data">
                            <label for="exampleInputtext">Tipo de Contrato</label>
                            <div class="input-group mb-3">
                                <select id="tipo_contrato" name="tipo_contrato"
                                    class="form-control selectpicker" data-live-search="true"
                                    data-style="border" required></select>
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <!-- <input type="number" class="d-none id_meta" id="id_meta" name="id_meta"> -->
                                <input type="number" class="d-none documento_docente_editar"
                                    id="documento_docente_editar" name="documento_docente_editar">
                                <button type="submit" class="btn btn-primary mt-4" id="btnGuardarEjecucion">
                                    <i class="fa fa-save"></i> Guardar </button>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger"
                                data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
            </div>
        </div>

        <div class="modal" id="modalListarContratos">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Listado de contratos</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="datosusuario_contactanos"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Modalhojadevida" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Modalhojadevida">Hoja de vida docente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="paso1" data-toggle="tab" href="#paso_1" role="tab"
                                    aria-controls="paso_1" aria-selected="true" style="color: white !important;">Información
                                    personal</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="paso2" data-toggle="tab" href="#paso_2" role="tab"
                                    aria-controls="paso_2" aria-selected="false" style="color: white !important;">Educación y formación</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="paso3" data-toggle="tab" href="#paso_3" role="tab"
                                    aria-controls="paso_3" aria-selected="false" style="color: white !important;">Laboral y Docente</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="paso4" data-toggle="tab" href="#paso_4" role="tab"
                                    aria-controls="paso_4" aria-selected="false" style="color: white !important;">Habilidades y aptitudes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="paso5" data-toggle="tab" href="#paso_5" role="tab"
                                    aria-controls="paso_5" aria-selected="false" style="color: white !important;">Portafolio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="paso6" data-toggle="tab" href="#paso_6" role="tab"
                                    aria-controls="paso_6" aria-selected="false" style="color: white !important;">Referencias personales</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="paso7" data-toggle="tab" href="#paso_7" role="tab"
                                    aria-controls="paso_7" aria-selected="false" style="color: white !important;">Referencias Laborales</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="paso8" data-toggle="tab" href="#paso_8" role="tab"
                                    aria-controls="paso_8" aria-selected="false" style="color: white !important;">Documentos obligatorios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="paso9" data-toggle="tab" href="#paso_9" role="tab"
                                    aria-controls="paso_9" aria-selected="false" style="color: white !important;">Documentos Adicionales</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="paso10" data-toggle="tab" href="#paso_10" role="tab"
                                    aria-controls="paso_10" aria-selected="false" style="color: white !important;">Áreas de conocimiento</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="paso_1" role="tabpanel" aria-labelledby="paso_1">
                                <div class="row">
                                    <div class="col-md-6" hidden>
                                        <label class="help-block"><i id="span-id_informacion_personal" class="fa"></i> ID
                                            Usuario(s):</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fas fa-user-tag"></i>
                                            </div>
                                            <input type="text" class="form-control" name="id_informacion_personal"
                                                id="id_informacion_personal" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" disabled class="form-control border-start-0" name="nombres"
                                                    id="nombres" maxlength="50" placeholder="Nombre Completo" required=""
                                                    value="">
                                                <label>Nombres(*):</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-start-0" name="apellidos"
                                                    id="apellidos" placeholder="Apellidos" required="" value="">
                                                <label>Apellidos:</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="date" class="form-control border-start-0" name="fecha_nacimiento"
                                                    id="fecha_nacimiento" required="" value="">
                                                <label>Fecha de Nacimiento</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-start-0" name="estado_civil"
                                                    id="estado_civil" required="" value="">
                                                <label id="span-estado_civil">Estado Civil:</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-start-0" name="departamento"
                                                    id="departamento" required="" value="">
                                                <label for="departamento">Departamento</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-start-0" name="ciudad" id="ciudad"
                                                    required="" value="">
                                                <label for="ciudad">Municipio</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-start-0" name="direccion"
                                                    id="direccion" maxlength="50" required="" value="">
                                                <label>Dirección:</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-start-0" name="celular"
                                                    id="celular" maxlength="50" required="" value="">
                                                <label>Celular:</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-start-0" name="nacionalidad"
                                                    id="nacionalidad" maxlength="30" required="" value="">
                                                <label>Nacionalidad:</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-start-0" name="pagina_web"
                                                    id="pagina_web" maxlength="50" required="" value="">
                                                <label>Página Web:</label>
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
                                                <input type="text" class="form-control border-start-0" name="titulo_profesional"
                                                    id="titulo_profesional" maxlength="50" required="" value="">
                                                <label>Titulo Profesional:</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-start-0"
                                                    name="categoria_profesion" id="categoria_profesion" maxlength="50"
                                                    required="" value="">
                                                <label>Categoria:</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-start-0" name="situacion_laboral"
                                                    id="situacion_laboral" maxlength="50" required="" value="">
                                                <label>Situación Laboral:</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-md-6 mt-3 mb-3">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <textarea class="form-control border-start-0" rows="5" id="resumen_perfil"
                                                    name="resumen_perfil" placeholder=""></textarea>
                                                <label for="resumen_perfil">Resumen del perfil</label>
                                            </div>
                                            <!-- <i class="far fa-question-circle" data-toggle="tooltip" data-placement="top" title="Resumir acá en máximo dos o tres frases su perfil profesional. Ejemplo: “Administrador de empresas con larga experiencia en gerencia en diferentes empresas comercializadoras y exportadoras. Ha desarrollado grandes aptitudes de manejo de equipo. Muy buen conocimiento del sector energético latinoamericano.” Máx. 600 caracteres"></i> -->
                                        </div>
                                        <div class="invalid-feedback">Please enter a valid profile summary
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="help-block"><i id="span-situacion_laboral" class="fa"></i> Experiencia en
                                            docencia:</label>
                                        <div class="switch">
                                            <input type="radio" class="switch-input" name="view2" value="1" id="otro_ingreso">
                                            <label for="otro_ingreso"
                                                class="switch-label switch-otro_ingreso switch-label-off">Si</label>
                                            <input type="checkbox" class="switch-input" name="view2" value="0"
                                                id="otro_ingresoff">
                                            <label for="otro_ingresoff"
                                                class="switch-label switch-otro_ingreso switch-label-on">No</label>
                                            <span class="switch-selection"></span>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <br>
                            </div>
                            <div class="tab-pane fade" id="paso_2" role="tabpanel" aria-labelledby="paso_2">
                                <div id="educacion">
                                    <div class="row">
                                        <div class="col-md-12" style="margin-top: 40px;">
                                            <h3 class="profile-username text-center">Educación y formación</h3>
                                            <div class="table-responsive">
                                                <!-- Contenedor responsive -->
                                                <table id="table-educacion_formacion" class="table table-hover">
                                                    <thead>
                                                        <tr>
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
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="paso_3" role="tabpanel" aria-labelledby="paso_3">
                                <div id="experiencia_laboral">
                                    <div class="row">
                                        <div class="col-md-6 text-center hidden-xs hidden-sm" style="margin-top: 10px">
                                            <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                                <h2 style="font-size: 28px; margin-top: 10px">
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="margin-top: 40px;">
                                            <h3 class="profile-username text-center">Laboral y Docente</h3>
                                            <div class="table-responsive">
                                                <!-- Contenedor responsive -->
                                                <table id="table-experiencias_laborales" class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre <br>Empresa</th>
                                                            <th>Cargo </th>
                                                            <th>Desde </th>
                                                            <th>Hasta </th>
                                                            <th>detalles </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="body-experiencias_laborales"></tbody>
                                                </table>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="paso_4" role="tabpanel" aria-labelledby="paso_4">
                                <div id="habilidad">
                                    <div class="row">
                                        <div class="col-md-6 text-center hidden-xs hidden-sm" style="margin-top: 10px">
                                            <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                                <h2 style="font-size: 28px; margin-top: 10px">
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="margin-top: 40px;">
                                            <h3 class="profile-username text-center">Habilidades y aptitudes
                                            </h3>
                                            <div class="table-responsive">
                                                <!-- Contenedor responsive -->
                                                <table id="table-habilidades_aptitudes" class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre de la Categoria</th>
                                                            <th>Nivel de Habilidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="body-habilidades_aptitudes"></tbody>
                                                </table>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="paso_5" role="tabpanel" aria-labelledby="paso_5">
                                <div id="portafolio">
                                    <div class="row">
                                        <div class="col-md-12 text-center" style="margin-top: 10px">
                                            <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                                <h2 style="font-size: 28px; margin-top: 10px">
                                                </h2>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 40px;">
                                            <h3 class="profile-username text-center">Portafolio
                                            </h3>
                                            <div class="table-responsive">
                                                <!-- Contenedor responsive -->
                                                <table id="table-portafolio" class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Titulo </th>
                                                            <th>Descripción </th>
                                                            <th>Video url </th>
                                                            <th>Archivo </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="body-portafolio"></tbody>
                                                </table>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="paso_6" role="tabpanel" aria-labelledby="paso_6">
                                <div id="referencias_personales">
                                    <div class="row">
                                        <div class="col-md-6 text-center hidden-xs hidden-sm" style="margin-top: 10px">
                                            <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                                <h2 style="font-size: 28px; margin-top: 10px">
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="profile-username text-center">Referencias personales
                                            </h3>
                                            <table id="table-referencias_personales"
                                                class="table table-hover table-responsive-lg">
                                                <thead>
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
                                </div>
                            </div>
                            <div class="tab-pane fade" id="paso_7" role="tabpanel" aria-labelledby="paso_7">
                                <div id="referencias_laborales">
                                    <div class="row">
                                        <div class="col-md-6 text-center hidden-xs hidden-sm" style="margin-top: 10px">
                                            <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                                <h2 style="font-size: 28px; margin-top: 10px">
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="profile-username text-center">Referencias Laborarles
                                            </h3>
                                            <table id="table-referencias_laborales"
                                                class="table table-hover table-responsive-lg">
                                                <thead>
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
                            <div class="tab-pane fade" id="paso_8" role="tabpanel" aria-labelledby="paso_8">
                                <div id="documentos_obligatorios">
                                    <div class="row">
                                        <div class="col-md-6 text-center hidden-xs hidden-sm" style="margin-top: 10px">
                                            <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                                <h2 style="font-size: 28px; margin-top: 10px">
                                                    <strong>Documentos Obligatorios</strong>
                                                </h2>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div id="mostrar_documentos_obligatorios"></div>
                                            <br>
                                        </div>
                                        <div
                                            style="position: fixed; bottom: 70px; right: 20px; width: 100%; max-width: 300px; z-index: 1050;">
                                            <div class="row justify-content-center">
                                                <div class="col-6"
                                                    style="padding-right: 5px; padding-left: 15px; margin-top: 20px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="paso_9" role="tabpanel" aria-labelledby="paso_9">
                                <div id="documentos_adicionales">
                                    <div class="row">
                                        <div class="col-md-6 text-center hidden-xs hidden-sm" style="margin-top: 10px">
                                            <div class="col-md-12 text-left" style="color:#7b7b7b;">
                                                <h2 style="font-size: 28px; margin-top: 10px">
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="profile-username text-center">Documentos Adicionales
                                            </h3>
                                            <table id="table-documentos_adicionales"
                                                class="table table-hover table-responsive-lg">
                                                <thead>
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
                            <div class="tab-pane fade" id="paso_10" role="tabpanel" aria-labelledby="paso_10">
                                <div id="areas_conocimientos">
                                    <div class="row">
                                        <div class="col-md-12 text-left">
                                            <h2 style="font-size: 28px; margin-top: 10px">
                                                <div class="row">
                                                    <div class="col-md-12" style="margin-top: 40px;">
                                                        <h3 class="profile-username text-center">Areas de Conocimiento</h3>
                                                        <div class="table-responsive">
                                                            <!-- Contenedor responsive -->
                                                            <table id="table-areas_de_conocimiento" class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nombre Area </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="body-areas_de_conocimiento"></tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                                <div
                                                    style="position: fixed; bottom: 70px; right: 20px; width: 100%; max-width: 300px; z-index: 1050;">
                                                    <div class="row justify-content-center">
                                                        <div class="col-6"
                                                            style="padding-right: 5px; padding-left: 15px; margin-top: 20px;">
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                        <!-- <input type="number" class="d-none id_meta" id="id_meta" name="id_meta"> -->
                                        <input type="number" class="d-none documento_docente_editar"
                                            id="documento_docente_editar" name="documento_docente_editar">
                                    </div>
                                    </form>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalComentariosDocentes" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered     ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="staticBackdropLabel">Comentario Docente</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-0">
                        <!-- crear dos tabs uno para el form y el otro para ver las repseustas -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-dark active" id="comentarios-tab" data-toggle="tab" href="#comentarios" role="tab" aria-controls="comentarios" aria-selected="true">
                                    <span class="text-secondary">
                                        <i class="fas fa-file-signature"></i>
                                        <b>Comentario</b>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" id="historial-tab" data-toggle="tab" href="#historial" role="tab" aria-controls="historial" aria-selected="false">
                                    <span class="text-secondary">
                                        <i class="fas fa-clock-rotate-left"></i>
                                        <b>Historial Comentarios</b>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active div_formulario_comentario" id="comentarios" role="tabpanel" aria-labelledby="comentarios-tab">
                                <form name="comentario_docente" id="comentario_docente" method="POST" class="mt-3">
                                    <input type='hidden' value="" id='id_usuario_cv_comentario_docente' name='id_usuario_cv_comentario_docente'>
                                    <h6>Comentario:</h6>
                                    <div class="form-group col-12">
                                        <label for="mensaje_docente">Describir la novedad:</label>
                                        <textarea name="mensaje_docente" id="mensaje_docente" rows="5" class="form-control" required></textarea>
                                        <small id="contador_texto">280</small>
                                    </div>
                                    <button type="submit" id="btnComentario" class="btn bg-purple btn-block">Enviar Reporte</button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="historial" role="tabpanel" aria-labelledby="historial-tab">
                                <div class="table-responsive">
                                    <table class="col-12 table">
                                        <thead>
                                            <th> Mensaje Docente </th>
                                            <th> Fecha </th>
                                            <th> Hora </th>
                                            <th> Periodo </th>
                                        </thead>
                                        <tbody id="tbllistado_comentarios">
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-danger btn-block mt-4" data-dismiss="modal">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/gestiondocente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>