<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 17;
    $submenu = 1701;
    require 'header.php';
?>

    <div id="precarga" class="precarga"></div>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 mx-0">
                    <div class="col-xl-6 col-9">
                        <h2 class="m-0 line-height-16">
                            <span class="titulo-2 fs-18 text-semibold">Espacios de aprendizaje</span><br>
                            <span class="fs-14 f-montserrat-regular">Universitarios CIAF en la era digital</span>
                        </h2>
                    </div>
                    <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                        <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                    </div>
                    <div class="col-12 migas">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="panel_docente.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Reserva General</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content" style="padding-top: 0px;">
            <div class="row mx-0">
                <div class="card col-12 p-4" id="muestra_historico_reservas">
                    <h5 class="modal-title">Reservas General</h5>
                    <table id="table_histo_reservas" class="table table-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Salón</th>
                                <th scope="col">Motivo</th>
                                <th scope="col">Nombre Completo</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Hora</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Oppciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <div class="modal" id="modalReserva" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Salón <span id="nombresalon"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" onclick="cerrarModal()" aria-label="Close">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">Reserva para el día:<br><span id="fechaseleccionada" class="titulo-2 fs-16"></span></div>
                    <input type="hidden" name="estado_formulario" id="estado_formulario">
                    <div id="ocultar_campos_formulario_normal">
                        <div class="col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <input type="text" name="motivo_reserva" id="motivo_reserva" class="form-control">
                                    <label>Motivo reserva:</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>
                        <div class="form-group d-none">
                            <label for="hora">Fecha Reserva: </label>
                            <input type="date" class="form-control" name="fecha_reserva" id="fecha_reserva">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="time" name="startTime" id="startTime" class="form-control">
                                <label>Hora de inicio:</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="time" name="endTime" id="endTime" class="form-control" step="300">
                                <label>Hora de finalización:</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <!-- campos nuevos para el formulario Reserva de espacios CRAILAB - Medios Educativos-->
                    <div id="ocultar_campos_formulario">
                        <div class="col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nombre_docente" name="nombre_docente">
                                    <label>Nombre completo docente / expositor</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Ingrese el nombre completo</div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="correo_docente" name="correo_docente">
                                    <label>Correo electrónico</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Ingrese un correo válido</div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <input type="tel" class="form-control" id="telefono_docente" name="telefono_docente">
                                    <label>Teléfono / WhatsApp</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Ingrese un teléfono</div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select class="form-control" id="programa" name="programa">
                                        <option value="" selected disabled>Seleccione...</option>
                                        <option>Ingeniería de Software</option>
                                        <option>Ingeniería Industrial</option>
                                        <option>Administración de Empresas</option>
                                        <option>Contaduría Pública</option>
                                        <option>Seguridad y Salud en el Trabajo</option>
                                        <option>Auxiliar en Veterinaria</option>
                                        <option>Mecánica y Mantenimiento de Motoclicletas</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                    <label>El programa académico / empresa es...</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 d-none" id="programa_otro_wrap">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="programa_otro" name="programa_otro">
                                    <label>Otro (especifique)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select class="form-control" id="asistentes" name="asistentes">
                                        <option value="" selected disabled>Seleccione...</option>
                                        <option>5 a 10 personas</option>
                                        <option>11 a 20 personas</option>
                                        <option>21 a 30 personas</option>
                                        <option>31 a 50 personas</option>
                                        <option>51 a 60 personas</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                    <label>Espero que me lleguen entre...</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-none" id="asistentes_otro_wrap">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="asistentes_otro" name="asistentes_otro">
                                    <label>Otro (especifique)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="materia_evento" name="materia_evento">
                                    <label>El nombre de la materia / evento es...</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="experiencia_nombre" name="experiencia_nombre">
                                    <label>El nombre de la experiencia es...</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label>El objetivo de la experiencia es...</label>
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <textarea class="form-control" id="experiencia_objetivo" name="experiencia_objetivo" style="height: 100px"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select class="form-control" id="duracion_horas" name="duracion_horas">
                                        <option value="" selected disabled>Seleccione...</option>
                                        <option>1 hora</option>
                                        <option>2 horas</option>
                                        <option>3 horas</option>
                                        <option>4 horas</option>
                                        <option>5 horas</option>
                                        <option>8 horas</option>
                                    </select>
                                    <label>La clase / evento tendrá una duración de...</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-group mb-3 position-relative check-valid">
                                <label class="mb-2 d-block">Para la práctica necesito...</label>
                                <div class="row g-2">
                                    <div class="col-12 col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="req_legos" name="requerimientos[]" value="Set de Legos">
                                            <label class="form-check-label" for="req_legos">Set de Legos</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="req_marcadores" name="requerimientos[]" value="Marcadores y borradores de tablero">
                                            <label class="form-check-label" for="req_marcadores">Marcadores y borradores de tablero</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="req_oculus" name="requerimientos[]" value="Visores Oculus">
                                            <label class="form-check-label" for="req_oculus">Visores Oculus</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="req_videobeam" name="requerimientos[]" value="Video Beam">
                                            <label class="form-check-label" for="req_videobeam">Video Beam</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="req_tv" name="requerimientos[]" value="Pantalla TV">
                                            <label class="form-check-label" for="req_tv">Pantalla TV</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="req_hdmi" name="requerimientos[]" value="Cable HDMI">
                                            <label class="form-check-label" for="req_hdmi">Cable HDMI</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="req_portatil" name="requerimientos[]" value="Computador portátil">
                                            <label class="form-check-label" for="req_portatil">Computador portátil</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="req_mapping" name="requerimientos[]" value="Video mapping">
                                            <label class="form-check-label" for="req_mapping">Video mapping</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="req_craia" name="requerimientos[]" value="CRAIA">
                                            <label class="form-check-label" for="req_craia">CRAIA</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="req_sonido" name="requerimientos[]" value="Sonido adicional">
                                            <label class="form-check-label" for="req_sonido">Sonido adicional</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="req_sillas" name="requerimientos[]" value="Sillas">
                                            <label class="form-check-label" for="req_sillas">Sillas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="req_mesas" name="requerimientos[]" value="Mesas">
                                            <label class="form-check-label" for="req_mesas">Mesas</label>
                                        </div>
                                        <input type="text" class="form-control mt-2" name="requerimientos_otro" placeholder="Especifique otra acción">

                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <label>Quiero dejarles la siguiente novedad o requerimiento...</label>
                                    <div class="form-floating">
                                        <textarea class="form-control" id="novedad" name="novedad" style="height: 100px"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    require 'footer.php';
    ?>
    <script type="text/javascript" src="scripts/reserva_general.js"></script>
<?php
}
ob_end_flush();
?>
<script>

</script>