<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 6;
    $submenu = 1003;
    require 'header_estudiante.php';
    if (!empty($_SESSION['id_usuario'])) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-24 py-4 pl-3">
                                <span class="fs-48 sunvalley">Renueva tu matrícula aquí</span><br>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-2 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                    </div>
                </div>
            </div>
            <section class="px-4 ">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 d-none">
                        <div class="row" id="mostrardatos"></div>
                    </div>
                    <div class="col-xl-4 col-lg-5 col-md-7 col-12 pt-0 mb-4 card" id="listadoregistros"></div>

                    <div class="panel-body col-12" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                        </form>
                    </div>
                    <div class="col-12">
                        <div id="listadomaterias" class="row col-12">
                        </div>
                        <div id="carrito" class="carrito card col-12" style="border-left:0px solid #000"></div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Modal para ver el recibo de pago -->
        <div class="modal fade" id="verrecibo" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Recibo de matrícula </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <a class="btn btn-warning float-right" href="javascript:imprSelec('historial')"><i class="fas fa-print"></i> Imprimir </a>
                        <div id="historial">
                            <div id="datosrecibo"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para ver el estado del crédito -->
        <div class="modal fade" id="verestadocredito" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Estado crédito </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="estadocredito"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para ver el estado del crédito -->
        <div class="modal fade" id="modal_modificar_ticket" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Nuevo valor </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="formularioModificarTicket">
                            <input type="hidden" id="id_ticket" name="id_ticket" value="">
                            <div class="form-group">
                                <label for="valor_ticket">Este valor es el monto minimo</label>
                                <input type="number" class="form-control" id="valor_ticket" name="valor_ticket" value="0">
                                <div class="invalid-feedback ">
                                    <span class="badge bg-danger feedback-ticket">

                                    </span>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-modificar-ticket">Modificar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para ver solicitar el crédito -->
        <div class="modal fade" id="modal_solicitud_credito" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content ">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <img src="https://www.ciaf.digital/public/img/logo-azul.png" class="py-2" width="125px">
                                    <h5>Solicitud de crédito</h5>
                                </div>
                                <div class="col-12 p-0 ">
                                    <div class="rounded-0 text-center bg-dark py-3 mb-3">
                                        <h2 class="text-white">
                                            Formulario de financiación <br>
                                            <small> Dale un giro a tu vida </small>
                                        </h2>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <form name="formularioCredito" class="col-12" id="formularioCredito" method="POST">
                                        <div class="row p-2">
                                            <div class="col-12 fondo_azul rounded-3 ">
                                                <div class="col-12 border border-3 border-white rounded mt-3 datos_personales">
                                                    <div class="col-12 p-2">
                                                        <span class="h6  submenus ps-1 fw-bold ms-2" style="position:absolute; left:6px; margin-top: -25px; width: 130px;"> Datos Generales </span>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <select class="form-control" id="tipo_documento" name="tipo_documento" aria-label="Seleccionar Tipo de Documento" required>
                                                                        <option selected disabled>Tipo de documento</option>
                                                                        <option value="Cédula de Ciudadanía">Cédula de Ciudadanía</option>
                                                                        <option value="Cédula de Extranjería">Cédula de Extranjería</option>
                                                                        <option value="Pasaporte">Pasaporte</option>
                                                                        <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                                                                        <option value="Número de Permiso">Número de Permiso</option>
                                                                        <option value="ppt">ppt</option>
                                                                    </select>
                                                                    <label class="" for="tipo_documento">Tipo de documento</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <input type="text" class="form-control" id="numero_documento" name="numero_documento" required>
                                                                    <label class="" for="numero_documento">Número Documento</label>
                                                                    <div class="invalid-feedback">
                                                                        <span class="badge bg-danger ">
                                                                            Tu número de documento no puede iniciar de esa manera
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <input type="text" class="form-control" id="nombres" name="nombres" required>
                                                                    <label class="" for="nombres"> Nombre(s) </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                                                    <label class="" for="apellidos"> Apellidos </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required min="1945-01-01" max="<?= date('Y-m-d', strtotime('-14 years')); ?>">
                                                                    <label class="" for="fecha_nacimiento"> Fecha Nacimiento </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <select class="form-control select-picker genero" id="genero" name="genero" required>
                                                                        <option value disabled selected> Género </option>
                                                                        <option value="Hombre">Hombre</option>
                                                                        <option value="Mujer">Mujer</option>
                                                                        <option value="No Binario">No Binario</option>
                                                                        <option value="Prefiero no decir">Prefiero no decir</option>
                                                                    </select>
                                                                    <label class="" for="genero">Género</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <select class="form-control select-picker" id="estado_civil" name="estado_civil" required>
                                                                        <option value disabled selected> Estado Civil </option>
                                                                        <option value="Soltero(a)">Soltero(a)</option>
                                                                        <option value="Casado(a)">Casado(a)</option>
                                                                        <option value="Divorciado(a)">Divorciado(a)</option>
                                                                        <option value="Viudo(a)">Viudo(a)</option>
                                                                        <option value="Unión Libre">Unión Libre</option>
                                                                    </select>
                                                                    <label class="" for="estado_civil">Estado Civil</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <select class="form-control select-picker" id="numero_hijos" name="numero_hijos" required>
                                                                        <option value disabled selected> Selecciona la cantidad </option>
                                                                        <option value="0">0</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5+</option>
                                                                    </select>
                                                                    <label class="" for="numero_hijos">Número de Hijos</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <select class="form-control select-picker" id="nivel_educativo" name="nivel_educativo" required>
                                                                        <option value disabled selected> Nivel Educativo </option>
                                                                        <option value="Secundaria">Secundaria</option>
                                                                        <option value="Bachillerato">Bachillerato</option>
                                                                        <option value="Universidad">Universidad</option>
                                                                        <option value="Otros">Otros</option>
                                                                    </select>
                                                                    <label class="" for="nivel_educativo">Nivel Educativo</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" required>
                                                                    <label class="" for="nacionalidad"> Nacionalidad </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                                                                    <label class="" for="direccion"> Dirección de Residencia </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <select class="form-control select-picker departamento" id="departamento" name="departamento" required onchange="mostrarMunicipios(this.value)">
                                                                    </select>
                                                                    <label class="" for="departamento">Departamento de Residencia</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <select class="form-control select-picker ciudad" id="ciudad" name="ciudad" required>
                                                                        <option value disabled selected>Selecciona primero el departamento </option>
                                                                    </select>
                                                                    <label class="" for="ciudad">Ciudad de Residencia</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <select class="form-control select-picker" name="estrato" id="estrato" required>
                                                                        <option value="" disabled selected> Selecciona un estrato </option>
                                                                        <option value="1">1 (Bajo - Bajo)</option>
                                                                        <option value="2">2 (Bajo)</option>
                                                                        <option value="3">3 (Medio - Bajo)</option>
                                                                        <option value="4">4 (Medio)</option>
                                                                        <option value="5">5 (Medio Alto)</option>
                                                                        <option value="6">6 (Alto)</option>
                                                                    </select>
                                                                    <label class="text-white" for="estrato"> Estrato </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <input type="email" class="form-control" name="email" id="email" maxlength="70" required>
                                                                    <label class="" for="email"> Correo Personal </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <select class="form-control select-picker" id="ocupacion" name="ocupacion" required>
                                                                        <option value disabled selected> Ocupación o Profesión </option>
                                                                        <option value="Empleado(a)">Empleado(a)</option>
                                                                        <option value="Independiente">Independiente</option>
                                                                        <option value="Desempleado(a)">Desempleado(a)</option>
                                                                        <option value="Pensionado(a)">Pensionado(a)</option>
                                                                        <option value="Ama de casa">Ama de casa</option>
                                                                        <option value="Otro">Otro</option>
                                                                    </select>
                                                                    <label class="" for="ocupacion"> Ocupación o Profesión </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 my-3">
                                                                <div class="form-floating ">
                                                                    <select class="form-control select-picker" id="personas_a_cargo" name="personas_a_cargo" required>
                                                                        <option value disabled selected> Personas a Cargo </option>
                                                                        <option value="0">0</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10</option>
                                                                    </select>
                                                                    <label class="" for="personas_a_cargo">Personas A Cargo</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 border border-3 border-white rounded mt-3">
                                                    <div class="custom-control custom-switch ">
                                                        <input type="checkbox" class="custom-control-input" id="labora_actualmente" checked>
                                                        <label class="custom-control-label h6  submenus ps-1 fw-bold ms-2" for="labora_actualmente">Ingresos - Presiona si <b class="badge bg-danger"> NO </b> laboras</label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-ingresos_labora col-12">
                                                            <div class="col-12 p-2">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                        <div class="form-floating ">
                                                                            <select class="form-control select-picker sector_laboral" id="sector_laboral" name="sector_laboral" required>
                                                                                <option value="" selected disabled>Sector Laboral</option>
                                                                                <option value="Educación">Educación</option>
                                                                                <option value="Salud">Salud</option>
                                                                                <option value="Construcción">Construcción</option>
                                                                                <option value="Comercio">Comercio</option>
                                                                                <option value="Industria/Manufactura">Industria/Manufactura</option>
                                                                                <option value="Transporte y logística">Transporte y logística</option>
                                                                                <option value="Servicios financieros">Servicios financieros</option>
                                                                                <option value="Tecnología/Informática">Tecnología/Informática</option>
                                                                                <option value="Gobierno/Sector público">Gobierno/Sector público</option>
                                                                                <option value="Turismo y hotelería">Turismo y hotelería</option>
                                                                                <option value="Agropecuario">Agropecuario</option>
                                                                                <option value="Otro">Otro</option>
                                                                            </select>
                                                                            <label class="" for="sector_laboral"> Sector Laboral </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                        <div class="form-floating ">
                                                                            <input type="number" class="form-control input-ingresos_labora" name="tiempo_servicio" id="tiempo_servicio" required>
                                                                            <label class="" for="tiempo_servicio"> Cuanto tiempo ha trabajado (En meses) </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                        <div class="form-floating ">
                                                                            <select class="form-control select-picker salario" id="salario" name="salario" required>
                                                                                <option value="" selected disabled> Rango de Ingresos </option>
                                                                                <option value="Menos de 1 SMLV">Menos de 1 SMLV</option>
                                                                                <option value="Entre 1 SMLV y 2 SMLV">Entre 1 SMLV y 2 SMLV</option>
                                                                                <option value="Entre 2 SMLV y 3.5 SMLV">Entre 2 SMLV y 3.5 SMLV</option>
                                                                                <option value="Más de 3.5 SMLV">Más de 3.5 SMLV</option>
                                                                            </select>

                                                                            <label class="" for="salario"> Rango de Ingresos Mensuales </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                        <div class="form-floating ">
                                                                            <select class="form-control select-picker" id="tipo_vivienda" name="tipo_vivienda" required>
                                                                                <option value disabled selected> Selecciona el tipo de vivienda </option>
                                                                                <option value="Propia">Propia</option>
                                                                                <option value="Alquilada">Alquilada</option>
                                                                                <option value="Viviendo con familiares">Viviendo con familiares</option>
                                                                                <option value="Otros">Otros</option>
                                                                            </select>
                                                                            <label class="" for="tipo_vivienda">Tipo De Vivienda</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 border border-3 border-white rounded mt-3 referencias">
                                                    <div class="col-12 p-2">
                                                        <span class="h6  submenus ps-1 fw-bold ms-2" style="position:absolute; left:6px; margin-top: -25px; width:93px">
                                                            Referencias
                                                        </span>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <input type="text" class="form-control" name="familiarnombre" id="familiarnombre" required>
                                                                    <label class="" for="familiarnombre"> Familiar - Nombre Completo </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <input type="number" class="form-control" name="familiartelefono" id="familiartelefono" required>
                                                                    <label class="" for="familiartelefono"> Familiar - Teléfono Contacto </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-3 border border-3 border-white rounded mt-3 referencias">
                                                    <div class="col-12 p-2">
                                                        <span class="h6  submenus ps-1 fw-bold ms-2" style="position:absolute; left:6px; margin-top: -25px; width:93px">
                                                            Codeudor
                                                        </span>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <input type="text" class="form-control" name="codeudornombre" id="codeudornombre" required>
                                                                    <label class="" for="codeudornombre"> Codeudor - Nombre Completo </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                <div class="form-floating ">
                                                                    <input type="number" class="form-control" name="codeudortelefono" id="codeudortelefono" required>
                                                                    <label class="" for="codeudortelefono"> Codeudor - Teléfono Contacto </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 border border-3 border-white rounded my-3 representante_menor">
                                                    <div class="col-12 p-2">
                                                        <span class="h6  submenus ps-1 fw-bold ms-2" style="position:absolute; left:6px; margin-top: -25px; width:175px"> Representante Legal </span>
                                                        <div class="row">
                                                            <div class="form-ingresos_labora col-12">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                        <div class="form-floating ">
                                                                            <input type="text" class="form-control input-representante" name="nombre_completo_acudiente" id="nombre_completo_acudiente">
                                                                            <label class="" for="nombre_completo_acudiente"> Acudiente - Nombre Completo </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                        <div class="form-floating ">
                                                                            <input type="number" class="form-control input-representante" name="numero_documento_acudiente" id="numero_documento_acudiente">
                                                                            <label class="" for="numero_documento_acudiente"> Acudiente - Número Documento </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                        <div class="form-floating ">
                                                                            <input type="date" class="form-control input-representante" name="fecha_expedicion_acudiente" id="fecha_expedicion_acudiente">
                                                                            <label class="" for="fecha_expedicion_acudiente"> Acudiente - Fecha Expedición Documento </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-2">
                                                                        <div class="form-floating ">
                                                                            <select class="form-control input-representante" name="parentesco" id="parentesco">
                                                                                <option selected disabled>Selecciona una opción</option>
                                                                                <option value="Madre">Madre</option>
                                                                                <option value="Padre">Padre</option>
                                                                                <option value="Acudiente">Acudiente</option>
                                                                                <option value="Representante legal ">Representante legal</option>
                                                                            </select>
                                                                            <label class="" for="parentesco"> Acudiente - Parentesco </label>
                                                                        </div>
                                                                        <input type="text" class="d-none" id="id_programa" name="id_programa">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input bg-1" type="checkbox" value="0" id="recibir_info" name="recibir_info">
                                                <label class="form-check-label fw-bold fs-16 text-center" for="recibir_info" style="color: #132252 !important;">
                                                    Acepto el envío de información a mi correo electrónico. He revisado las <a href="https://ciaf.digital/public/web_tratamiento_datos/Tratamiento_de_datos_CIAF_2024.pdf" target="_blank" style="color: #132252 !important;" class="politicas"> Políticas de Protección de Datos y la Política de Devoluciones y Acumulados.</a> También puedes conocer nuestra <a href="https://ciaf.digital/public/politica_cartera/reglamento-de-cartera.pdf" target="_blank" style="color: #132252 !important;"> Política de cartera </a>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 my-3">
                                            <div class="d-grid gap-2">
                                                <button class="btn-final btn btn-primary col-12 btn-lg" type="submit">
                                                    Realizar Solicitud
                                                    <i class="fas fa-handshake"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
    require 'footer_estudiante.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/rematriculafinanciera.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>