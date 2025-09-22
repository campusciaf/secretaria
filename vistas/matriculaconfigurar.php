<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 5;
    $submenu = 504;
    require 'header.php';
    if ($_SESSION['matriculaconfigurar'] == 1) {
?>

        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Configurar Matricula</span><br>
                                <span class="fs-14 f-montserrat-regular"></span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas mb-0">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Configurar Matricula</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid px-4">
                <!--Fondo de la vista -->
                <div class="row col-12">
                    <div class="col-xl-4 col-lg-12 col-md-12 col-12" id="seleccionprograma">
                        <form name="formularioverificar" id="formularioverificar" method="POST" class="row">
                            <div class="col-xl-9 col-lg-9 col-md-9 col-9 m-0 p-0">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="number" placeholder="" required class="form-control border-start-0" name="credencial_identificacion" id="credencial_identificacion" maxlength="20" value="">
                                        <label>Número Identificación</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-3 m-0 p-0">
                                <button type="submit" id="btnVerificar" class="btn btn-success py-3">Buscar</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-8 col-lg-12 col-md-12 col-12" id="mostrardatos">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-12 py-2">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <span class="rounded bg-light-white p-2 text-gray ">
                                            <i class="fa-solid fa-user-slash" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="col-10">
                                        <span class="">Nombres </span> <br>
                                        <span class="text-semibold fs-14">Apellidos </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-12 py-2">
                                <div class="row align-items-center">
                                    <div class="col-2 ">
                                        <span class="rounded bg-light-white p-2 text-gray">
                                            <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="col-10">
                                        <span class="">Correo electrónico</span> <br>
                                        <span class="text-semibold fs-14">correo@correo.com</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-12 py-2">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <span class="rounded bg-light-white p-2 text-gray">
                                            <i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="col-10">
                                        <span class="">Número celular</span> <br>
                                        <span class="text-semibold fs-14">+570000000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-12" id="mostrardatos"></div>
                    <div class="card col-12   p-4" id="listadoregistros">
                        <table id="tbllistado" class="table table-hover table-responsive" style="width: 100%;">
                            <thead>
                                <th width="100px">Id estudiante</th>
                                <th>Programa</th>
                                <th>Jornada</th>
                                <th>Sistema de pago</th>
                                <th>Estado</th>
                                <th width="30px">Grupo</th>
                                <th>Nuevo del</th>
                                <th>Periodo Activo</th>
                                <th>Perfil</th>
                                <th>Admisiones</th>
                                <th>Homologado</th>
                                <th>Renovar</th>
                                <th>Temporada</th>
                                <th>Pago Renovar</th>
                                <th>Consulta Cifras</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <h5 class="pb-4">Generar Credenciales de Acceso</h5>
                        <form name="formulario" id="formulario" class="row" method="POST">
                            <input type="hidden" name="credencial_usuario" id="credencial_usuario">
                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <label class="sr-only" for="credencial_nombre">Primer Nombre</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user text-red"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="credencial_nombre" id="credencial_nombre" maxlength="100" placeholder="Primer Nombre" onchange="javascript:this.value=this.value.toUpperCase();" required>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <label class="sr-only" for="credencial_nombre_2">Segundo Nombre</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user text-red"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="credencial_nombre_2" id="credencial_nombre_2" maxlength="100" placeholder="Segundo Nombre" onchange="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <label class="sr-only" for="credencial_apellido">Primer Apellido</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user text-red"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="credencial_apellido" id="credencial_apellido" maxlength="100" placeholder="Primer Apellido" onchange="javascript:this.value=this.value.toUpperCase();" required>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <label class="sr-only" for="credencial_apellido_2">Segundo Apellido</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user text-red"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="credencial_apellido_2" id="credencial_apellido_2" maxlength="100" placeholder="Segundo Apellido" onchange="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <label class="sr-only" for="credencial_login">Correo Institucional</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-envelope text-red"></i></div>
                                    </div>
                                    <input type="mail" class="form-control" name="credencial_login" id="credencial_login" maxlength="30" placeholder="Correo Institucional" required>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>

        <div id="myModalAgregarPrograma" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Matricular Nuevo Programa Académico</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form name="formulario2" class="col-12 row" id="formulario2" method="POST">
                                <input type="hidden" id="id_credencial" name="id_credencial">
                                <div class="form-group col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required class="form-control border-start-0" data-live-search="true" name="fo_programa" id="fo_programa">
                                            </select>
                                            <label>Programa Académico </label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required class="form-control border-start-0" data-live-search="true" name="jornada_e" id="jornada_e">
                                            </select>
                                            <label>Jornada </label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required class="form-control border-start-0" data-live-search="true" name="grupo" id="grupo">
                                            </select>
                                            <label>Grupo</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button class="btn btn-primary btn-block" type="submit" id="btnGuardar2"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para ingresar los datos del estudiante al momento de cambiar el estado a graduado -->
        <div id="cambio_estado_graduado" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cambio Estado Graduado</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="box box-info">
                                <div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Atención!</h5>
                                    Campos obligatorios para registrar Estudiante Graduado
                                </div>
                                <input type="hidden" id="data" />
                                <input type="hidden" id="id_estudiante" />
                                <input type="hidden" id="id_credencial" />
                                <input type="hidden" id="id_programa_ac" />
                                <form id="datos_graduado" class="form-horizontal">
                                    <div class="box-body row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="periodo_grado" id="periodo_grado" maxlength="100" required>
                                                    <label>Periodo Grado</label>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="cod_saber_pro" id="cod_saber_pro" maxlength="100" required>
                                                    <label>Código Saber Pro</label>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="acta_grado" id="acta_grado" maxlength="100" required>
                                                    <label>Acta de Grado</label>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="folio" id="folio" maxlength="100" required>
                                                    <label>Folio</label>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <input type="date" placeholder="" value="" required="" class="form-control border-start-0" name="fecha_grado" id="fecha_grado">
                                                    <label>Fecha Grado</label>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="registrarGraduado()">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- mostrar modal solo para los tecnicos laborales  -->
        <div id="cambio_estado_certificado" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cambio Estado Certificado</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="box box-info">
                                <div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Atención!</h5>
                                    Campos obligatorios para registrar Estudiante Certificado
                                </div>
                                <input type="hidden" id="data_ciclo" />
                                <input type="hidden" id="id_estudiante_certificado" />
                                <input type="hidden" id="id_credencial_certificado" />
                                <input type="hidden" id="id_programa_ac_certificado" />
                                <form name="datos_certificado" id="datos_certificado" class="row" method="POST">
                                    <div class="box-body row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="acta_certificacion" id="acta_certificacion" maxlength="100" required>
                                                    <label>Acta de certificación</label>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <input type="date" placeholder="" value="" required="" class="form-control border-start-0" name="fecha_certificacion" id="fecha_certificacion">
                                                    <label>Fecha de certificación</label>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <input type="number" placeholder="" value="" class="form-control border-start-0" name="folio_certificado" id="folio_certificado">
                                                    <label>Folio</label>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid input</div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="registrarCertificado()">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
<script type="text/javascript" src="scripts/matriculaconfigurar.js"></script>