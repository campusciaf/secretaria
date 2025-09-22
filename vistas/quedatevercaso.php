<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 15;
    require 'header.php';
    if ($_SESSION['abrircaso'] == 1) {
        $caso_id = isset($_GET["caso"]) ? $_GET["caso"] : "2";
?>
        <link rel="stylesheet" href="../public/css/bootstrap-datetimepicker.min.css">
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Caso</span><br>
                                <span class="fs-14 f-montserrat-regular">Conectar con los estudiantes y superar los obstáculos</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary" style="padding: 1% 1%">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="nav-tabs-custom pb-4">
                                            <ul class="nav nav-tabs ml-auto pb-2">
                                                <input type="hidden" id="caso_id" value="<?php echo $caso_id ?>">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#tab_1" data-toggle="tab"><span class="text-white">Caso #<?php echo $caso_id ?></span></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a id="t-DTE" class="nav-link" href="#tab_2" data-toggle="tab">Datos estudiante</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1">
                                                <div class="tab-content-header cabecera_seguimientos row"></div>
                                                <div class="col-12">
                                                    <div class="timeline">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab_2">

                                                <div class="col-12" id="datos_estudiante">
                                                    <div class="row">
                                                        <div class="col-3 py-2 ">
                                                            <div class="row align-items-center">
                                                                <div class="col-2">
                                                                    <span class="rounded  text-gray ">
                                                                        <img src="../files/null.jpg" width="35px" height="35px" class="img-circle img_estudiante" img-bordered-sm="">
                                                                    </span>

                                                                </div>
                                                                <div class="col-10 line-height-16">
                                                                    <span class="fs-12 nombre_estudiante">-----</span> <br>
                                                                    <span class="text-semibold fs-12 titulo-2 line-height-16 apellido_estudiante"> ------ </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-3 py-2">
                                                            <div class="row align-items-center">
                                                                <div class="col-2">
                                                                    <span class="rounded bg-light-red p-2 text-red">
                                                                        <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                                                                    </span>

                                                                </div>
                                                                <div class="col-10">
                                                                    <span class="fs-12">Correo electrónico</span> <br>
                                                                    <span class="text-semibold fs-12 titulo-2 line-height-16 correo">-----</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-3 py-2">
                                                            <div class="row align-items-center">
                                                                <div class="col-2">
                                                                    <span class="rounded bg-light-green p-2 text-success">
                                                                        <i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
                                                                    </span>

                                                                </div>
                                                                <div class="col-10">
                                                                    <span class="fs-12">Número celular</span> <br>
                                                                    <span class="text-semibold fs-12 titulo-2 line-height-16 celular">-----</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-3 py-2">
                                                            <div class="row align-items-center">
                                                                <div class="col-2">
                                                                    <span class="rounded bg-light-green p-2 text-success">
                                                                        <i class="fa-regular fa-id-card"></i>
                                                                    </span>

                                                                </div>
                                                                <div class="col-10">
                                                                    <span class="fs-12 tipo_identificacion">----</span> <br>
                                                                    <span class="text-semibold fs-12 titulo-2 line-height-16 numero_documento">-----</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-3 py-2">
                                                            <div class="row align-items-center">
                                                                <div class="col-2">
                                                                    <span class="rounded bg-light-green p-2 text-success">
                                                                        <i class="fa-solid fa-location-dot"></i>
                                                                    </span>

                                                                </div>
                                                                <div class="col-10">
                                                                    <span class="fs-12">Dirección</span> <br>
                                                                    <span class="text-semibold fs-12 titulo-2 line-height-16 direccion">-----</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>


                                                <div class="col-12 tono-3 mt-4" id="matriculaccordion">
                                                    <div class="row">
                                                        <div class="col-12 titulo-2 fs-14 pt-4 pl-4">
                                                            Programas y cursos matriculados
                                                        </div>
                                                        <div class="col-12 lista_programas p-4">

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
                </div>
            </section>
        </div>
        <!-- Modal seguimiento-->
        <div class="modal fade" id="modal_seguimiento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Agregar Seguimiento</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="form_seguimiento">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Descripción</label>
                                <textarea class="form-control" rows="3" placeholder="Contenido del Seguimiento" name="descripcion" required></textarea>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $caso_id ?>">


                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required class="form-control border-start-0" name="encuentro" id="encuentro">
                                            <option value="" selected disabled> - Encuentro - </option>
                                            <option value="Llamada"> Llamada </option>
                                            <option value="Reunión"> Reunión </option>
                                            <option value="Visita"> Visita </option>
                                            <option value="Correo"> Correo </option>
                                            <option value="Campus"> Campus </option>
                                        </select>
                                        <label>Tipo de encuentro</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required class="form-control border-start-0 select_docente" data-live-search="true" name="docente" id="docente"></select>
                                        <label>Docentes</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>


                            <div class="form-group">
                                <label for="exampleInputPassword1">Recomendación</label>
                                <textarea type="text" class="form-control" row=3 name="recomendacion" id="exampleInputPassword1"></textarea>
                                <small id="emailHelp" class="form-text text-muted">Si no, deje el campo vacío.</small>
                            </div>

                            <div class="form-group">
                                <label>Evidencia</label>
                                <input type="file" class="form-control-file" name="evidencia">
                                <small id="emailHelp" class="form-text text-muted">Solo imagenes o PDF, No incluir tildes ni ñ en los nombres de los archivos porque se perderán</small>
                            </div>
                            <button type="submit" class="btn btn-primary btn-success btn-block">Agregar</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal tarea-->
        <div class="modal fade" id="modal_tarea" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Agregar Tarea</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="form_tarea">
                            <input type="hidden" name="id" value="<?php echo $caso_id ?>">

                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="asunto" id="asunto" maxlength="80">
                                        <label>Asunto corto</label>
                                        <small id="emailHelp" class="form-text text-muted">Max. 80 caracteres</small>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required class="form-control border-start-0 datepicker" name="fecha" id="fecha">
                                        <label>Fecha y hora</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>


                            <div class="form-group">
                                <label>Descripción (opcional)</label>
                                <textarea class="form-control" rows="3" placeholder="descripción" name="descripcion"></textarea>
                                <small id="emailHelp" name="descripcion" class="form-text text-muted">Opcional.</small>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="referencia" id="referencia">
                                            <option value="" selected disabled>-Referencia-</option>
                                            <option value="Caso">Caso</option>
                                            <option value="Estudiante">Estudiante</option>
                                        </select>
                                        <label>Guardar referencia para</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required class="form-control border-start-0 select_docente" name="docente" id="docente">
                                            <option value="" selected disabled>-Referencia-</option>
                                            <option value="Caso">Caso</option>
                                            <option value="Estudiante">Estudiante</option>
                                        </select>
                                        <label>Docente</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <button type="submit" class="btn btn-success btn-enviar btn-block">Agregar</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal remitir-->
        <div class="modal fade" id="modal_remitir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel"> Remitir a dependencia</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="form_remision">
                            <div class="form-group">
                                <label>Observación</label>
                                <input type="hidden" name="id" value="<?php echo $caso_id ?>">
                                <textarea class="form-control" rows="3" placeholder="observacion" name="observacion" required></textarea>
                            </div>


                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required class="form-control border-start-0 select_dependencia" name="dependencia" id="dependencia">
                                            <option value="" selected="" disabled=""> - Dependencias - </option>
                                            <option value="85">Dirección Financiera</option>
                                            <option value="85">Auxiliar Administrativa</option>
                                            <option value="83">Coordinación Escuelas</option>
                                            <option value="32">Dirección Investigación</option>
                                            <option value="31">Dirección Bienestar Institucional</option>
                                            <option value="42">Dirección De Programa De SST</option>
                                            <option value="29">Dirección De Programa De Ingenierías</option>
                                            <option value="28">Dirección De Programa De Administración</option>
                                            <option value="79">Dirección De Programa De Contaduría</option>
                                            <option value="26">Coordinación Registro Y Control</option>
                                            <option value="73">Dirección de Programa de Articulación y técnicos laborales</option>
                                            <option value="75">Coordinadora Programa laborales</option>

                                        </select>
                                        <label>Docente</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>


                            <button type="submit" class="btn btn-primary btn-enviar btn-block">Agregar</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal cerrar-->
        <div class="modal fade" id="modal_cerrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Cerrar caso</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form_cerrar" method="post">
                            <p class="alert alert-danger">¿Quieres cerrar este caso definitivamente?</p>
                            <p>Al confirmar aceptas que se dió por terminado este proceso. Ya nadie podra agregar seguimientos o participar de este
                                caso.</p>

                            <div class="form-group">
                                <label>Observación</label>
                                <input type="hidden" name="id" value="<?php echo $caso_id ?>">
                                <textarea class="form-control" rows="3" placeholder="observacion" name="observacion" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Evidencia</label>
                                <input type="file" name="evidencia" class="form-control-file" required>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" class="form-control border-start-0" name="logro" id="logro" maxlength="60" required onchange="javascript:this.value=this.value.toUpperCase();">
                                        <label>¿Que se logro?</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>


                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required class="form-control border-start-0" name="categorias_cerrado" id="categorias_cerrado"></select>
                                        <label>Categoria caso cerradoo</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                <label class="form-check-label titulo-2 fs-12 line-height-16" for="exampleCheck1">Me hago responsable al cerrar el caso por el motivo que se encuentra arriba descrito.</label>
                            </div>
                            <button type="submit" class="btn btn-success btn-enviar btn-block">Cerrar el caso </button>
                        </form>
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
<script src="../public/js/bootstrap-datetimepicker.min.js"></script>
<script src="../bower_components/moment/moment.js"></script>
<script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="../bower_components/fullcalendar/dist/locale/es.js"></script>
<script src="scripts/quedatevercaso.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>