<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.php");
    if ($_SESSION['usuario_cargo'] != "Funcionario") {
        header("Location: ../");
    }
} else {
    $menu = 6;
    $submenu = 605;
    require 'header.php';
    if ($_SESSION['nuevodocente'] == 1) {
?>
        <div id="precarga" class="precarga" style="display: none;"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Nuevo Docente</span><br>
                                <span class="fs-16 f-montserrat-regular">Obtenga toda la información de sus clientes en un solo sitio</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour " onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour </button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php"> Inicio </a></li>
                                <li class="breadcrumb-item active"> Consulta Nuevo Docente </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 p-4 px-4 " id="seleccionprograma">
                <form name="formularioverificar" id="formularioverificar" method="POST">
                    <div class="row card">
                        <input type="hidden" value="" name="tipo" id="tipo">
                        <div class="col-12">
                            <h3 class="titulo-2 fs-14">Buscar docente por:</h3>
                        </div>
                        <div class="col-12">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li>
                                    <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true" onclick="muestra(1)">Identificacion</a>
                                </li>
                                <li>
                                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false" onclick="muestra(2)">Tel/Celular</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 mt-2" id="input_dato">
                            <div class="row">
                                <div class="col-10 m-0 p-0">
                                    <div class="form-group position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="usuario_identificacion" id="usuario_identificacion" required>
                                            <label id="valortitulo">Seleccionar tipo</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col-2 m-0 p-0">
                                    <input type="submit" value="Buscar" class="btn btn-success py-3 btn-block" disabled id="btnconsulta" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <section class="content" id="formulario_vista">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row">
                            <div class="col-12 card">
                                <div class="row">
                                    <div class="col-6 p-2 tono-3">
                                        <div class="row align-items-center">
                                            <div class="pl-3">
                                                <span class="rounded bg-light-blue p-3 text-primary ">
                                                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                            <div class="col-10">
                                                <div class="col-5 fs-14 line-height-18">
                                                    <span class="">Información Docente</span> <br>
                                                    <span class="text-semibold fs-20">Campus virtual</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 tono-3 text-right py-4 pr-4">
                                    </div>
                                    <div class="col-12 panel-body">
                                        <form name="formulario_hoja_v" class="row" id="formulario_hoja_v" method="POST">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="title">Datos Personales</h6>
                                                </div>
                                                <input type="hidden" name="id_usuario" id="id_usuario">
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="mostrar_usuario_nombre" id="mostrar_usuario_nombre" maxlength="100" disabled onchange="javascript:this.value=this.value.toUpperCase();">
                                                            <label>Primer Nombre</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="mostrar_usuario_apellido" id="mostrar_usuario_apellido" maxlength="100" disabled onchange="javascript:this.value=this.value.toUpperCase();">
                                                            <label>Segundo Nombre</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="mostrar_usuario_identificacion_docente" disabled id="mostrar_usuario_identificacion_docente" maxlength="20">
                                                            <label>Número Identificación</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="date" placeholder="" value="" class="form-control border-start-0" name="mostrar_usuario_fecha_nacimiento" disabled id="mostrar_usuario_fecha_nacimiento">
                                                            <label>Fecha de Nacimiento</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="mostrar_usuario_direccion_docente" disabled id="mostrar_usuario_direccion_docente" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                                            <label>Dirección</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="mostrar_usuario_celular_docente" disabled id="mostrar_usuario_celular_docente" maxlength="20">
                                                            <label>Celular</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="mostrar_usuario_email_p" disabled id="mostrar_usuario_email_p" maxlength="50">
                                                            <label>Email Personal</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <img src="" width="150px" height="120px" id="imagenmuestra">
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                </div>
                                                <div class="col-12">
                                                    <h6 class="title">Documentos Obligatorios</h6>
                                                </div>
                                                <div class="col-12" id="mostrar_documentos_obligatorios"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 panel-body" id="mostrar_formulario_crear_docente">
                                        <form name="formulario_crear_docente" class="row" id="formulario_crear_docente" method="POST">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="title">Formulario Crear Docente</h6>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="crear_usuario_nombre" id="crear_usuario_nombre" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                                            <label>Primer Nombre(*):</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="crear_usuario_nombre_2" id="crear_usuario_nombre_2" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                                            <label>Segundo Nombre</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="crear_usuario_apellido" id="crear_usuario_apellido" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                                            <label>Segundo Nombre</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="crear_usuario_apellido_2" id="crear_usuario_apellido_2" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                                            <label>Segundo Nombre</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="crear_usuario_tipo_documento" id="crear_usuario_tipo_documento"></select>
                                                            <label>Tipo Documento</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="crear_usuario_identificacion" id="crear_usuario_identificacion" maxlength="20">
                                                            <label>Número Identificación(*):</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="date" placeholder="" value="" class="form-control border-start-0" name="crear_usuario_fecha_nacimiento" id="crear_usuario_fecha_nacimiento">
                                                            <label>Fecha de Nacimiento</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="crear_usuario_departamento_nacimiento" id="crear_usuario_departamento_nacimiento"></select>
                                                            <label>Departamento Nacimiento:</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="crear_usuario_municipio_nacimiento" id="crear_usuario_municipio_nacimiento"></select>
                                                            <label>Municipio Nacimiento:</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="crear_usuario_tipo_contrato" id="crear_usuario_tipo_contrato"></select>
                                                            <label>Tipo de Contrato:</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="crear_usuario_tipo_sangre" id="crear_usuario_tipo_sangre"></select>
                                                            <label>Tipo de Sangre:</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0 crear_usuario_telefono" name="crear_usuario_telefono" id="crear_usuario_telefono" maxlength="20">
                                                            <label>Teléfono Fijo</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0 crear_usuario_celular" name="crear_usuario_celular" id="crear_usuario_celular" maxlength="20">
                                                            <label>Celular</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="crear_usuario_email_p" id="crear_usuario_email_p" maxlength="50">
                                                            <label>Email Personal</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="crear_usuario_estado_civil" id="crear_usuario_estado_civil"></select>
                                                            <label>Estado Civil:</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="usuario_genero" id="usuario_genero"></select>
                                                            <label>Género:</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="crear_usuario_email_ciaf" id="crear_usuario_email_ciaf" maxlength="50">
                                                            <label>Email CIAF/Login (*):</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Imagen:</label>
                                                    <input type="file" class="form-control-file" name="usuario_imagen_nuevo_docente" id="usuario_imagen_nuevo_docente">
                                                    <input type="hidden" name="imagenactual" id="imagenactual">
                                                    <img src="" width="150px" height="120px" id="imagenmuestra">
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <input type="hidden" name="verificacion_documento" id="verificacion_documento">
                                                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/nuevo_docente.js"></script>