<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $submenu = 3802;
    $menu = 38;
    require 'header.php';
    if ($_SESSION['bolsa_empleo'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Ofertas Laborales</span><br>
                                <span class="fs-16 f-montserrat-regular">Gestione el Ofertas Laborales de los respectivos estudiantes</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión Ofertas Laborales</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
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
                                                    <span class="">Ofertas Laborales</span> <br>
                                                    <span class="text-semibold fs-20">Campus virtual</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 tono-3 text-right py-4 pr-4">
                                        <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar Ofertas Laboral</button>
                                    </div>
                                    <div class="col-12 table-responsive p-2" id="listadoregistros">
                                        <table id="tblistaofertalaboral" class="table" style="width: 100%;">
                                            <thead>
                                                <th>Opciones</th>
                                                <th>Nombre Empresa</th>
                                                <th>Cargo</th>
                                                <th>Tipo de contrato</th>
                                                <th>Programa Académico</th>
                                                <th>Salario</th>
                                                <th>Fecha de contratación</th>
                                                <th>Postulados</th>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-12 panel-body" id="formularioregistros">
                                        <form name="formulario_crearyeditarofertaslaborales" id="formulario_crearyeditarofertaslaborales" method="POST">
                                            <input type="number" class="d-none" id="id_bolsa_empleo_oferta" name="id_bolsa_empleo_oferta">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="title">Datos Empresa</h6>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select class="form-control border-start-0 selectpicker" data-live-search="true" name="tipo_contrato" id="tipo_contrato" required>
                                                                <option value="" disabled selected>Seleccione una opción</option>
                                                                <option value="1">Término Fijo</option>
                                                                <option value="2">Término indefinido</option>
                                                                <option value="3">Obra o labor</option>
                                                                <option value="4">civil por prestación de servicios</option>
                                                                <option value="5">Contrato de aprendizaje</option>
                                                            </select>
                                                            <label for="tipo_contrato">Tipo Contrato</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Por favor seleccione una opción válida</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3">
                                                        <div class="form-floating">
                                                            <input type="number" class="form-control border-start-0" name="salario" id="salario" required>
                                                            <label>Salario</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select class="form-control border-start-0 selectpicker" data-live-search="true" name="modalidad_trabajo" id="modalidad_trabajo" required>
                                                                <option value="" disabled selected>Seleccione una opción</option>
                                                                <option value="Virtual">Virtual</option>
                                                                <option value="Presencial">Presencial</option>
                                                            </select>
                                                            <label for="ciclo_propedeutico">Modalidad de trabajo</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Por favor seleccione una opción válida</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select class="form-control border-start-0 selectpicker" data-live-search="true" name="ciclo_propedeutico" id="ciclo_propedeutico" required>
                                                                <option value="" disabled selected>Seleccione una opción</option>
                                                                <option value="1">Técnico</option>
                                                                <option value="2">Tecnólogo</option>
                                                                <option value="3">Profesional</option>
                                                            </select>
                                                            <label for="ciclo_propedeutico">Ciclo propedéutico</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Por favor seleccione una opción válida</div>
                                                </div>
                                                <div class="col-12">
                                                    <h6 class="title">Perfil</h6>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="id_usuario" id="id_usuario"></select>
                                                            <label>Nombre Empresa</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control border-start-0" name="cargo" id="cargo" maxlength="100" onchange="this.value=this.value.toUpperCase();">
                                                            <label>Cargo</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="programa_estudio" id="programa_estudio"></select>
                                                            <label>Programa Estudio</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>


                                                <!-- <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select class="form-control border-start-0 selectpicker" data-live-search="true" name="programa_estudio" id="programa_estudio" required>
                                                                <option value="" disabled selected>Seleccione un programa</option>
                                                                <option value="Administración de empresas">Administración de empresas</option>
                                                                <option value="Ingeniería industrial">Ingeniería industrial</option>
                                                                <option value="Seguridad y Salud en el trabajo">Seguridad y Salud en el trabajo</option>
                                                                <option value="Programación de software">Programación de software</option>
                                                                <option value="Contaduría pública">Contaduría pública</option>
                                                            </select>
                                                            <label for="programa_estudio">Programa Estudio</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Por favor seleccione un programa</div>
                                                </div> -->
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3">
                                                        <div class="form-floating">
                                                            <input type="date" class="form-control border-start-0" name="fecha_contratacion" id="fecha_contratacion" required>
                                                            <label>Fecha de contratación</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <textarea rows="10" type="text" placeholder="" value="" class="form-control border-start-0" name="perfil_oferta" id="perfil_oferta" required></textarea>
                                                            <label>Perfil</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <textarea rows="10" type="text" placeholder="" value="" class="form-control border-start-0" name="funciones" id="funciones" required></textarea>
                                                            <label>Funciones</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-10 text-right p-2" style="z-index: 1; position:fixed; bottom:0px;">
                                                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Atras</button>
                                                    <button class="btn btn-success" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
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
        <!-- mostramos los usuarios postulados para esa oferta -->
        <div class="modal" id="ModalListarPostulados">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <h6 class="modal-title">Postulados
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
        <!-- modal para eliminar la oferta -->
        <div class="modal" id="ModalMotivoEliminarPostulacion">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar postulación</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form name="motivo_eliminacion" id="motivo_eliminacion" method="POST">
                        <input type="number" class="d-none" id="id_bolsa_empleo_oferta_desactivar_oferta" name="id_bolsa_empleo_oferta_desactivar_oferta">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="motivo_finalizacion">Motivo Eliminación</label>
                                        <input type="text" class="form-control" name="motivo_finalizacion" id="motivo_finalizacion" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" type="button" data-dismiss="modal">
                                    <i class="fa fa-arrow-circle-left"></i> Atrás
                                </button>
                                <button class="btn btn-success" type="submit" id="btnGuardarmotivoeliminacion">
                                    <i class="fa fa-save"></i> Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
    <script src="scripts/bolsa_empleo_ofertas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();

