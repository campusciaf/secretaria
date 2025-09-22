<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 24;
    $submenu = 2405;
    require 'header.php';
    if ($_SESSION['coevaluacion'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold"> Coevaluación Docentes </span><br>
                                <span class="fs-16 f-montserrat-regular"></span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour </button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Coevaluación Docentes</li>
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
                                                    <span class="">Coevaluación Docentes</span> <br>
                                                    <span class="text-semibold fs-20">Campus virtual</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 tono-3 text-right py-4 pr-4">
                                        <div class="row justify-content-end">
                                            <div class="col-4">
                                                <div class="input-group mb-2">
                                                    <select name="input_periodo" id="input_periodo" class="form-control" onChange="listar(this.value)">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12" id="div_tablaDocentes">
                                        <table class='table p-2' id='tlb_listar' style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th> Opciones </th>
                                                    <th> Documento </th>
                                                    <th> Nombres </th>
                                                    <th> Apellidos </th>
                                                    <th> Celular </th>
                                                    <th> Correo </th>
                                                    <th> Resultado </th>
                                                    <th> Foto </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="div_tablaResultados col-12" id="div_tablaResultados">
                                        <h4 class="title"><strong>Supera la Barreras</strong></h4>
                                        <form name="formulario" id="formulario" method="POST">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <input type="hidden" id="id_docente" name="id_docente">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                        <h6>¿El docente hace uso optimo del campus virtual CIAFi?</h6>
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <select value="" required class="form-control border-start-0" data-live-search="true" name="r1" id="r1" required="">
                                                                    <option value="" selected disabled>Selecciona una opción</option>
                                                                    <option value="3">Siempre</option>
                                                                    <option value="2">Casi siempre</option>
                                                                    <option value="1">A veces</option>
                                                                    <option value="0">Nunca</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                        <h6>El docente hace uso eficiente de las tecnologías de la información en el desarrollo de sus clases</h6>
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <select value="" required class="form-control border-start-0" data-live-search="true" name="r2" id="r2" required="">
                                                                    <option value="" selected disabled>Selecciona una opción</option>
                                                                    <option value="3">Siempre</option>
                                                                    <option value="2">Casi siempre</option>
                                                                    <option value="1">A veces</option>
                                                                    <option value="0">Nunca</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                        <h6>El docente apoya el plan de permanencia del estudiante con comunicación oportuna de inasistencias u observaciones especiales</h6>
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <select value="" required class="form-control border-start-0" data-live-search="true" name="r3" id="r3" required="">
                                                                    <option value="" selected disabled>Selecciona una opción</option>
                                                                    <option value="3">Siempre</option>
                                                                    <option value="2">Casi siempre</option>
                                                                    <option value="1">A veces</option>
                                                                    <option value="0">Nunca</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                        <h6>El docente conoce y aplica los reglamentos que intervienen en su labor</h6>
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <select value="" required class="form-control border-start-0" data-live-search="true" name="r4" id="r4" required="">
                                                                    <option value="" selected disabled>Selecciona una opción</option>
                                                                    <option value="3">Siempre</option>
                                                                    <option value="2">Casi siempre</option>
                                                                    <option value="1">A veces</option>
                                                                    <option value="0">Nunca</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                        <h6>El docente participa activamente en las actividades académicas programadas por la institución.</h6>
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <select value="" required class="form-control border-start-0" data-live-search="true" name="r5" id="r5" required="">
                                                                    <option value="" selected disabled>Selecciona una opción</option>
                                                                    <option value="3">Siempre</option>
                                                                    <option value="2">Casi siempre</option>
                                                                    <option value="1">A veces</option>
                                                                    <option value="0">Nunca</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                        <h6>El docente participa activamente en las actividades administrativas, deportivas y culturales programadas por la institución.</h6>
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <select value="" required class="form-control border-start-0" data-live-search="true" name="r6" id="r6" required="">
                                                                    <option value="" selected disabled>Selecciona una opción</option>
                                                                    <option value="3">Siempre</option>
                                                                    <option value="2">Casi siempre</option>
                                                                    <option value="1">A veces</option>
                                                                    <option value="0">Nunca</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                        <h6>El docente comunica oportunamente los ajustes realizados a las clases, tanto a las direcciones de escuela como a los estudiantes</h6>
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <select value="" required class="form-control border-start-0" data-live-search="true" name="r7" id="r7" required="">
                                                                    <option value="" selected disabled>Selecciona una opción</option>
                                                                    <option value="3">Siempre</option>
                                                                    <option value="2">Casi siempre</option>
                                                                    <option value="1">A veces</option>
                                                                    <option value="0">Nunca</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                        <h6>El docente demuestra dominio en su área o disciplina</h6>
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <select value="" required class="form-control border-start-0" data-live-search="true" name="r8" id="r8" required="">
                                                                    <option value="" selected disabled>Selecciona una opción</option>
                                                                    <option value="3">Siempre</option>
                                                                    <option value="2">Casi siempre</option>
                                                                    <option value="1">A veces</option>
                                                                    <option value="0">Nunca</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                        <h6>¿El docente dio cumplimiento al acuerdo de labor firmado?</h6>
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <select value="" required class="form-control border-start-0" data-live-search="true" name="r9" id="r9" required="">
                                                                    <option value="" selected disabled>Selecciona una opción</option>
                                                                    <option value="3">Siempre</option>
                                                                    <option value="2">Casi siempre</option>
                                                                    <option value="1">A veces</option>
                                                                    <option value="0">Nunca</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                        <h6>¿Muestra compromiso y entusiasmo en las actividades para docentes?</h6>
                                                        <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                                <select value="" required class="form-control border-start-0" data-live-search="true" name="r10" id="r10" required="">
                                                                    <option value="" selected disabled>Selecciona una opción</option>
                                                                    <option value="3">Siempre</option>
                                                                    <option value="2">Casi siempre</option>
                                                                    <option value="1">A veces</option>
                                                                    <option value="0">Nunca</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please enter valid input</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-12 p-2 text-right" style="z-index: 1; bottom:0px;">
                                                <input type="hidden" name="periodo_coevaluacion" id="periodo_coevaluacion" value="<?php echo $_SESSION['periodo_actual']; ?>">
                                                <button class="btn btn-success" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Calificar Docente</button>
                                                <button class="btn btn-danger" onClick="volverDocentes()" type="button"><i class="fa fa-arrow-circle-left"></i> Atras</button>
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
        <div class="modal" id="myModalMostrarRespuesta">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Respuestas Evaluación</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body p-0">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>¿El docente hace uso óptimo del campus virtual CIAFi?</td>
                                            <td class="text-center r1">-</td>
                                        </tr>
                                        <tr>
                                            <td>El docente hace uso eficiente de las tecnologías de la información en el desarrollo de sus clases</td>
                                            <td class="text-center r2">-</td>
                                        </tr>
                                        <tr>
                                            <td>El docente apoya el plan de permanencia del estudiante con comunicación oportuna de inasistencias u observaciones especiales</td>
                                            <td class="text-center r3">-</td>
                                        </tr>
                                        <tr>
                                            <td>El docente conoce y aplica los reglamentos que intervienen en su labor</td>
                                            <td class="text-center r4">-</td>
                                        </tr>
                                        <tr>
                                            <td>El docente participa activamente en las actividades académicas programadas por la institución</td>
                                            <td class="text-center r5">-</td>
                                        </tr>
                                        <tr>
                                            <td>El docente participa activamente en las actividades administrativas, deportivas y culturales programadas por la institución</td>
                                            <td class="text-center r6">-</td>
                                        </tr>
                                        <tr>
                                            <td>El docente comunica oportunamente los ajustes realizados a las clases, tanto a las direcciones de escuela como a los estudiantes</td>
                                            <td class="text-center r7">-</td>
                                        </tr>
                                        <tr>
                                            <td>El docente demuestra dominio en su área o disciplina</td>
                                            <td class="text-center r8">-</td>
                                        </tr>
                                        <tr>
                                            <td>¿El docente dio cumplimiento al acuerdo de labor firmado?</td>
                                            <td class="text-center r9">-</td>
                                        </tr>
                                        <tr>
                                            <td>¿Muestra compromiso y entusiasmo en las actividades para docentes?</td>
                                            <td class="text-center r10">-</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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
<script type="text/javascript" src="scripts/coevaluacion_docente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script> listar('<?php echo $_SESSION['periodo_actual']; ?>'); </script>