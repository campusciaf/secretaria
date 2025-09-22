<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"]) && $_SESSION["roll"] != "Funcionario") {
    header("Location: ../");
} else {
    $menu = 8;
    $submenu = 800;
    require 'header.php';
    if ($_SESSION['cambiardocumento'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Cambio Documento</span><br>
                                <span class="fs-16 f-montserrat-regular">Puede cambiar de tarjeta de identidad a Cédula y tambien corregir la cedula</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión documento</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="row">
                    <!-- tarjeta 1 -->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-md-12" role="alert">
                                        <h4 class="titulo-2 fs-20 text-semibold">Tarjeta de Identidad a Cédula de Ciudadanía</h4>
                                    </div>
                                    <form action="" method="POST" id="verificar_tarjeta" name="verificar_tarjeta">
                                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group">
                                                    <div class="form-floating flex-grow-1">
                                                        <input type="text" pattern="[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Solo se permiten letras y números, estos caracteres no son permitidos < > = , ; * # $" placeholder=" " value="" class="form-control" name="documento1" id="documento1" required>
                                                        <label for="documento1">Número de Tarjeta de Identidad</label>
                                                    </div>
                                                    <button class="btn btn-success" value="Buscar" id="botonTarjeta"><i class="fa fa-search"></i> Buscar</button>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- tarjeta 2 -->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-md-12" role="alert">
                                        <h4 class="titulo-2 fs-20 text-semibold">Modificar Cédula de Ciudadanía</h4>
                                    </div>
                                    <form action="" method="POST" id="verificar_cedula" name="verificar_documento">
                                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group">
                                                    <div class="form-floating flex-grow-1">
                                                        <input type="text" pattern="[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Solo se permiten letras y números, estos caracteres no son permitidos < > = , ; * # $" placeholder=" " value="" class="form-control" name="documento2" id="documento2" required>
                                                        <label for="documento2">Número de Cédula de Ciudadanía</label>
                                                    </div>
                                                    <button class="btn btn-success" value="Buscar" id="botonCedula"><i class="fa fa-search"></i> Buscar</button>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- tarjeta 3 -->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-md-12" role="alert">
                                        <h4 class="titulo-2 fs-20 text-semibold">Corregir Documento</h4>
                                    </div>
                                    <form action="" method="POST" id="corregir_documento" name="corregir_documento">
                                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group">
                                                    <div class="form-floating flex-grow-1">
                                                        <input type="text" pattern="[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Solo se permiten letras y números, estos caracteres no son permitidos < > = , ; * # $" placeholder=" " value="" class="form-control" name="corregir_cedula" id="corregir_cedula" required>
                                                        <label for="corregir_cedula">Número de Documento</label>
                                                    </div>
                                                    <button class="btn btn-success" value="Buscar" id="botonCorregir"><i class="fa fa-search"></i> Buscar</button>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Modal Cambio de Tarjeta a Cédula -->
        <div class="modal fade" id="cambioDatos" tabindex="-1" role="dialog" aria-labelledby="cambioDatos" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div id="informacion_estudiante" class="col-md-12" style="text-transform: capitalize;"></div>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" id="tarjeta" name="tarjeta">
                            <input type="hidden" name="id_reemplazar" id="id_reemplazar">
                            <input type="hidden" name="numero_tarjeta" id="numero_tarjeta">
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <label>Correo Institucional:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="text" id="correo_institucional" name="correo_institucional" required readonly class="form-control" />
                                </div>
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <label>Número de Cédula de Ciudadanía:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="text" id="num_cedula" name="num_cedula" required="required" pattern="[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Solo se permiten letras y números, estos caracteres no son permitidos < > = , ; * # $" placeholder="Número de Cédula de Ciudadanía" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <label>Fecha de Expedición:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" id="fecha_exp" name="fecha_exp" required="required" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success" id="btn_guardar1">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Cuadrar Cédula de Ciudadanía -->
        <div class="modal fade" id="cuadrarCedula" tabindex="-1" role="dialog" aria-labelledby="cuadrarCedula" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nombre_estudiante"></h5>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST" id="cuadrar_cedula" name="cuadrar_cedula">
                            <input type="hidden" name="id_cuadrar" id="id_cuadrar">
                            <input type="hidden" name="documento_antiguo_cambio" id="documento_antiguo_cambio">
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <label> Correo Institucional: </label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="text" id="correo_institucional_cambio" name="correo_institucional_cambio" required readonly class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <input type="text" id="cedula_correcta" name="cedula_correcta" required="required" pattern="[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Solo se permiten letras y números, estos caracteres no son permitidos < > = , ; * # $" placeholder="Ingresa nueva cédula de ciudadania" class="form-control" />
                                        <span class="input-group-btn">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-success" id="cuadrar_documento">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para corregir el documento del estudiante -->
        <div class="modal" id="ModalCorregirDocumento">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Corregir Documento</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="panel-body p-3">
                            <form name="formulariocorregirdocumento" id="formulariocorregirdocumento" method="POST">
                                <div class="col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="numero_documento_estudiante" id="numero_documento_estudiante" required>
                                            <label>Documento</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="number" class="d-none" id="id_credencial" name="id_credencial">
                                    <button class="btn btn-success" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </form>
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
<script type="text/javascript" src="scripts/cambiodocumento.js"></script>