<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $submenu = 3702;
    $menu = 38;
    require 'header.php';
    if ($_SESSION['gestion_servicio'] == 1) {
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Gestión de servicio social</span><br>
                        <span class="fs-16 f-montserrat-regular">Gestiona el servicio social de nuestros
                            estudiantes</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i
                            class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión de servicio social</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="container-fluid px-4 py-2">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 p-3 card">
                <div class="row">
                    <input type="hidden" value="" name="tipo" id="tipo">
                    <div class="col-12">
                        <h3 class="titulo-2 fs-14">Buscar Estudiante:</h3>
                    </div>
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill"
                                    href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                                    aria-selected="true" onclick="filtroportipo(1)">Identificacion</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-12 mt-2" id="input_dato_estudiante">
                        <div class="row">
                            <div class="col-9 m-0 p-0 col-xl-9 col-lg-9 col-md-9 ">
                                <div class="form-group position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" class="form-control border-start-0"
                                            name="dato_estudiante" id="dato_estudiante">
                                        <label id="valortituloestudiante">Buscar Estudiante</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-3 m-0 p-0">
                                <input type="submit" value="Buscar" onclick="verificarDocumento()"
                                    class="btn btn-success py-3 btn-block" disabled id="btnconsulta" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-top: 10px;">
                <table class="table table-striped compact table-sm" id="datos_estudiantes">
                    <thead>
                        <tr>
                            <th scope="col">Identificación</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Nombres</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Fecha Contratacion</th>
                            <th scope="col">Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>



            <div class="modal" tabindex="-1" id="modal_contratar">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Contratar estudiante</h5>

                        </div>
                        <div class="modal-body">
                            <form name="contrato" id="contrato" method="POST">
                                <div>
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="hidden" name="id_credencial_contrato"
                                                id="id_credencial_contrato" value="">

                                            <select value="" required class="form-control border-start-0 selectpicker"
                                                data-live-search="true" name="id_usuario" id="id_usuario"></select>
                                            <label>Nombre Empresa</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div>
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="date" placeholder="" value="" required
                                                class="form-control border-start-0" name="fecha_registro"
                                                id="fecha_registro" required>
                                            <label>Fecha de contrato</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <button class="btn btn-danger" type="button" data-dismiss="modal">
                                    <i class="fa fa-arrow-circle-left"></i> Atrás
                                </button>
                                <button class="btn btn-success" type="submit" id="btnGuardar">
                                    <i class="fa fa-save"></i> Guardar
                                </button>
                            </form>

                        </div>
                    </div>
                </div>



                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right p-2">
                    <input type="number" class="d-none cedula_estu" id="cedula_estu" name="cedula_estu">
                    <input type="number" class="d-none id_credencial_oculto" id="id_credencial_oculto"
                        name="id_credencial_oculto">
                    <input type="number" class="d-none id_credencial_guardar_estudiante"
                        id="id_credencial_guardar_estudiante" name="id_credencial_guardar_estudiante">
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

<div class="modal" id="ModalListarPostulados">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <h6 class="modal-title">Registro del servicio social
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="usuarios_postulados"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>





<div class="modal" tabindex="-1" id="modal_actividad">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar actividad</h5>

            </div>
            <div class="modal-body">
                <form name="actividad" id="actividad" method="POST">
                    <div>
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="hidden" name="id_credencial_actividad" id="id_credencial_actividad"
                                    value="">

                                <select value="" required class="form-control border-start-0 selectpicker"
                                    data-live-search="true" name="id_usuario_actividad"
                                    id="id_usuario_actividad"></select>
                                <label>Nombre Empresa</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div>

                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="text" placeholder="" value="" required class="form-control border-start-0"
                                    name="ac_realizadas" id="ac_realizadas" required>
                                <label>Actividad realizada</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div>
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="date" placeholder="" value="" required class="form-control border-start-0"
                                    name="fecha_participacion" id="fecha_participacion" required>
                                <label>Fecha de actividad</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div>
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="text" placeholder="" value="" required class="form-control border-start-0"
                                    name="firma_servicio" id="firma_servicio" required>
                                <label>Firma</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div>
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="number" placeholder="" value="" required
                                    class="form-control border-start-0" name="horas_servicio" id="horas_servicio"
                                    required>
                                <label>Horas</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>

                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <textarea rows="3" placeholder="" required class="form-control border-start-0"
                                name="actividades_competencias" id="actividades_competencias"></textarea>
                            <label>Competencias</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>

                    <button class="btn btn-danger" type="button" data-dismiss="modal">
                        <i class="fa fa-arrow-circle-left"></i> Atrás
                    </button>
                    <button class="btn btn-success" type="submit" id="btnGuardaractividad">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </form>

            </div>
        </div>
    </div>



    <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
    <script src="scripts/gestion_servicio.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
    <?php
}
ob_end_flush();