<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
error_reporting(0);
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    if ($_SESSION['usuario_cargo'] != "Docente") {
        header("Location: ../");
    } else {
        $menu = 1;
        require 'header_docente.php';
    }
?>
    <div id="precarga" class="precarga"></div>
    <div class="content-wrapper ">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-xl-6 col-9">
                        <h2 class="m-0 line-height-16">
                            <span class="titulo-2 fs-18 text-semibold">Construyendo Experiencias</span><br>
                            <span class="fs-14 f-montserrat-regular">Haz parte de la experiencia CIAF</span>
                        </h2>
                    </div>
                    <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                        <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        <button class="btn btn-sm btn-outline-warning px-2 py-0 d-none segundo_tour" onclick='iniciarSegundoTour()'><i class="fa-solid fa-play"></i> Tour 2da parte</button>
                    </div>
                    <div class="col-12 migas mb-0">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="panel_docente.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Clases</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="container-fluid px-4">
            <div class="row">
                <div class="col-6 tono-3 py-4">
                    <div class="row align-items-center">
                        <div class="col-auto pl-4">
                            <span class="rounded bg-light-blue p-3 text-primary ">
                                <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div class="col-auto line-height-18">
                            <span class="">Listado</span> <br>
                            <span class="titulo-2 text-semibold fs-20 line-height-18">de clases</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 tono-3 text-right pr-xl-4 pr-lg-4 pr-md-4 pr-2 pt-xl-4 pt-lg-4 pt-md-4 pt-2">
                    <p id="nombre_materia"></p>
                </div>
                <div class="card col-12" id="lista_programas">
                    <div class="row">
                        <div class="col-12 d-none" id="listadoregistrosgrupos">
                            <table id="tbllistadogrupos" class="table table-hover table-sm table-responsive" style="width:100%">
                                <thead>
                                    <th id="t-paso1">Programa</th>
                                    <th id="t-paso2">Asignatura</th>
                                    <th id="t-paso3">Jornada</th>
                                    <th id="t-paso4">Semestre</th>
                                    <th id="t-paso5">Horario</th>
                                    <th id="t-paso6">Salón</th>
                                    <th id="t-paso7">Acciones</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 m-0 p-0">
                        <div id="tbllistado" class="m-0 p-0"></div>
                        <div id="tllistado" class="m-0 p-0"></div>
                    </div>
                </div>
                <div id="horario" class="row mx-0 px-0"></div>
            </div>
        </section>
    </div>
    <!-- Modal registrar falta -->
    <div class="modal fade" id="modalFaltas" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-md">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Registrar Falta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_credencial" id="id_credencial">
                    <input type="hidden" name="id_docente_grupo" id="id_docente_grupo">
                    <input type="hidden" name="ciclo" id="ciclo">
                    <input type="hidden" name="id_estudiante" id="id_estudiante">
                    <input type="hidden" name="id_programa" id="id_programa">
                    <input type="hidden" name="id_materia" id="id_materia">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Motivo de la falta: </label>
                        <select name="motivo_falta" class="form-control" id="motivo_falta" required>
                        </select>
                    </div>
                    <button type="submit" onclick="registraFalta()" class="btn btn-success">Registrar falta</button>
                    <table id="tbfaltas" class="table-hover table mt-3 table-sm compact" width="100%">
                        <thead>
                            <th class="text-center">Opcion</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Motivo</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal listar reportes de contacto-->
    <div class="modal fade" id="modalReportes" role="dialog">
        <div class="modal-dialog modal-xl">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Vista Previa</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-responsive">
                    <table id="listadocontacto" class="table table-hover " style="width:100%">
                        <thead>
                            <th>Identificación</th>
                            <th>Nombre estudiante</th>
                            <th>Correo CIAF</th>
                            <th>Correo personal</th>
                            <th>Celular</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal listar reporte final-->
    <div class="modal fade" id="modalReporteFinal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Vista Previa</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="prueba"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal enviar correo -->
    <div class="modal fade" id="modalEmail" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Correo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Contenido email</label>
                        <textarea class="form-control" id="conteMail" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button id="enviarEmail" class="btn btn-success">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal enviar correo -->
    <div class="modal fade" id="modalHorarioEstudiante" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Horario estudiante</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12" id="horarioestudiante"></div>
                    <div class="col-12" id="calendar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal reporte influencer -->
    <div class="modal fade" id="modalReporteInfluencer" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-centered     ">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Influencer <i class="fas fa-plus"></i> </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <!-- crear dos tabs uno para el form y el otro para ver las repseustas -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link text-dark active" id="form-tab" data-toggle="tab" href="#formulario" role="tab" aria-controls="formulario" aria-selected="true">
                                <span class="text-secondary">
                                    <i class="fas fa-file-signature"></i>
                                    <b>Formulario</b>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" id="historial-tab" data-toggle="tab" href="#historial" role="tab" aria-controls="historial" aria-selected="false">
                                <span class="text-secondary">
                                    <i class="fas fa-clock-rotate-left"></i>
                                    <b>Historial</b>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="formulario" role="tabpanel" aria-labelledby="form-tab">
                            <form name="reporteinfluencer" id="reporteinfluencer" method="POST" class="mt-3">
                                <input type='hidden' value="" id='id_estudiante_in' name='id_estudiante_in'>
                                <input type='hidden' value="" id='id_docente_in' name='id_docente_in'>
                                <input type='hidden' value="" id='id_programa_in' name='id_programa_in'>
                                <input type='hidden' value="" id='id_materia_in' name='id_materia_in'>
                                <h6>Nivel de Acción:</h6>
                                <div class="form-group row text-center">
                                    <div class="col">
                                        <!-- input radio  con color Positiva, Suave, Inmediata -->
                                        <input type="radio" id="influencer_accion_positiva" name="influencer_nivel_accion" class="d-none" value="Positiva" required checked>
                                        <label for="influencer_accion_positiva" class="label_influencer_accion_positiva pointer text-success rounded rounded-pill ms-3 p-2 bg-info text-white"><i class="fas fa-circle text-success"></i> Observacion Positiva</label>
                                    </div>
                                    <div class="col">
                                        <input type="radio" id="influencer_accion_media" name="influencer_nivel_accion" class="d-none" value="Media" required>
                                        <label for="influencer_accion_media" class="label_influencer_accion_media pointer text-warning rounded rounded-pill ms-3 p-2"><i class=" fas fa-circle text-warning"></i> Atención Media (Acción en 1 sem.)</label>
                                    </div>
                                    <div class="col">
                                        <input type="radio" id="influencer_accion_alta" name="influencer_nivel_accion" class="d-none" value="Alta" required>
                                        <label for="influencer_accion_alta" class="label_influencer_accion_alta pointer text-danger rounded rounded-pill ms-3 p-2"><i class="fas fa-circle text-danger"></i> Ruta Inmediata (Acción en 24 Hrs.)</label>
                                    </div>
                                </div>
                                <div class="form-group row gestionPositiva">
                                    <div class="col">
                                        <h6> Académica </h6>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Académica')" id="buen_desempeño" value="Buen Desempeño" required checked>
                                        <label for="buen_desempeño"> Buen Desempeño </label>
                                    </div>
                                    <div class="col">
                                        <h6> Psicosocial </h6>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Psicosocial')" id="EmocionalmenteEstable" value="Emocionalmente Estable" required />
                                        <label for="EmocionalmenteEstable"> Emocionalmente Estable </label>
                                    </div>
                                    <div class="col">
                                        <h6>Vocacional</h6>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Vocacional')" id="Proactivo" value="Proactivo" required />
                                        <label for="Proactivo"> Proactivo </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Vocacional')" id="LiderazgoEmergente" value="Liderazgo Emergente" required />
                                        <label for="LiderazgoEmergente"> Liderazgo Emergente </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Vocacional')" id="ProyecciónAlta" value="Proyección Alta" required />
                                        <label for="ProyecciónAlta"> Proyección Alta </label>
                                    </div>
                                    <div class="col">
                                        <h6>Convivencia</h6>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Convivencia')" id="RedDeApoyoPositiva" value="Red De Apoyo Positiva" required />
                                        <label for="RedDeApoyoPositiva"> Red De Apoyo Positiva </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Convivencia')" id="Participativo" value="Participativo" required />
                                        <label for="Participativo"> Participativo </label>
                                    </div>
                                </div>
                                <div class="form-group row gestionPositiva gestionMedia gestionAlta">
                                    <div class="col">
                                        <h6> Académica </h6>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Académica')" id="BajoRendimiento" required value="Bajo Rendimiento" />
                                        <label for="BajoRendimiento"> Bajo Rendimiento </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Académica')" id="FaltaDeMotivación" required value="Falta De Motivación" />
                                        <label for="FaltaDeMotivación"> Falta De Motivación </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Académica')" id="RetrasoEnEntregas" required value="Retraso En Entregas" />
                                        <label for="RetrasoEnEntregas"> Retraso En Entregas </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Académica')" id="DificultadesDeAprendizaje" required value="Dificultades De Aprendizaje" />
                                        <label for="DificultadesDeAprendizaje"> Dificultades De Aprendizaje </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Académica')" id="NecesitaRefuerzo" required value="Necesita Refuerzo" />
                                        <label for="NecesitaRefuerzo"> Necesita Refuerzo </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Académica')" id="numero_faltas" required value="2 Faltas" />
                                        <label for="numero_faltas" id="label_numero_faltas"> 2 Faltas </label>
                                        <br>
                                    </div>
                                    <div class="col">
                                        <h6> Financiera </h6>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Financiera')" id="DificultadDePago" required value="Dificultad De Pago" />
                                        <label for="DificultadDePago"> Dificultad De Pago </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Financiera')" id="PendienteDeMatricula" required value="Pendiente De Matricula" />
                                        <label for="PendienteDeMatricula"> Pendiente De Matricula </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Financiera')" id="SolicitaDescuento" required value="Solicita Descuento" />
                                        <label for="SolicitaDescuento"> Solicita Descuento </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Financiera')" id="GestiónConFinanciera" required value="Gestión Con Financiera" />
                                        <label for="GestiónConFinanciera"> Gestión Con Financiera </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Financiera')" id="RiesgoPorMotivoEconómico" required value="Riesgo Por Motivo Económico" />
                                        <label for="RiesgoPorMotivoEconómico"> Riesgo Por Motivo Económico </label>
                                        <br>
                                    </div>
                                    <div class="col">
                                        <h6> Psicosocial </h6>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Psicosocial')" id="Ansiedad" required value="Ansiedad" />
                                        <label for="Ansiedad"> Ansiedad </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Psicosocial')" id="FamiliarEnfermo" required value="Familiar Enfermo" />
                                        <label for="FamiliarEnfermo"> Familiar Enfermo </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Psicosocial')" id="FaltaDeRedDeApoyo" required value="Falta De Red De Apoyo" />
                                        <label for="FaltaDeRedDeApoyo"> Falta De Red DeApoyo </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Psicosocial')" id="CrisisPersonal" required value="Crisis Personal" />
                                        <label for="CrisisPersonal"> Crisis Personal </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Psicosocial')" id="NecesitaPsicología" required value="Necesita Psicología" />
                                        <label for="NecesitaPsicología"> Necesita Psicología </label>
                                        <br>
                                    </div>
                                    <div class="col">
                                        <h6>Vocacional</h6>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Vocacional')" id="DudaSobrePrograma" required value="Duda Sobre Programa" />
                                        <label for="DudaSobrePrograma"> Duda Sobre Programa </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Vocacional')" id="CambioDeCarrera" required value="Cambio De Carrera" />
                                        <label for="CambioDeCarrera"> Cambio De Carrera </label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Vocacional')" id="FaltaDePropósito" required value="Falta De Propósito" />
                                        <label for="FaltaDePropósito"> Falta De Propósito </label>
                                        <br>
                                    </div>
                                    <div class="col">
                                        <h6>Convivencia</h6>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Convivencia')" id="ConflictosConCompañeros" required value="Conflictos Con Compañeros" />
                                        <label for="ConflictosConCompañeros"> Conflictos Con Compañeros</label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Convivencia')" id="ConflictosConDocente" required value="Conflictos Con Docente" />
                                        <label for="ConflictosConDocente"> Conflictos Con Docente</label>
                                        <br>
                                        <input type="radio" name="influencer_dimension" onclick="almacenarArea('Bienestar - Convivencia')" id="Aislamiento" required value="Aislamiento" />
                                        <label for="Aislamiento"> Aislamiento</label>
                                        <br>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <input type="hidden" name="area_responsable" id="area_responsable">
                                    <label for="influencer_mensaje">Describir la novedad:</label>
                                    <textarea name="influencer_mensaje" id="influencer_mensaje" rows="5" class="form-control" required></textarea>
                                    <small id="contador_texto">280</small>
                                </div>
                                <button type="submit" id="btnInfluencer" class="btn bg-purple btn-block">Enviar Reporte</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="historial" role="tabpanel" aria-labelledby="historial-tab">
                            <button class="btn btn-info mt-3" onclick="mostrarTablaReportes()"> <i class="fas fa-arrow-left"></i> Volver </button>
                            <div class="table-responsive div_tabla_reportes">
                                <table class="col-12 table">
                                    <thead>
                                        <th> Rspta </th>
                                        <th> Nivel </th>
                                        <th> Dimensión </th>
                                        <th> Mensaje </th>
                                        <th> Estado </th>
                                        <th> Fecha </th>
                                        <th> Hora </th>
                                        <th> Periodo </th>
                                    </thead>
                                    <tbody id="tbllistado_reporte_influencer">
                                        <!-- Aquí se cargarán los reportes -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="box box-primary direct-chat direct-chat-primary mt-3">
                                <div class="box-body div_historico_reporte" style="overflow-x:none !important">
                                    <div class="direct-chat-messages historico_reporte" style="height:auto !important">
                                    </div>
                                </div>
                                <div class="div_formulario_cierre">
                                    <form action="#" method="post" id="formularioCierreReporte">
                                        <input type="hidden" name="id_influencer_reporte" id="id_influencer_reporte">
                                        <h6 class="border-bottom pb-2 mb-3 mt-4">Tipo de cierre</h6>
                                        <div class="form-floating mb-3">
                                            <select class="form-control" id="tipo_cierre" name="influencer_tipo_cierre" required>
                                                <option value="" disabled selected>Seleccione el tipo de cierre</option>
                                                <option value="permanencia">Permanencia lograda / caso superado</option>
                                                <option value="retiro">Retiro o deserción</option>
                                                <option value="sinAvance">Caso sin avance, pero sin señales críticas</option>
                                            </select>
                                            <label for="tipo_cierre">Seleccione el tipo de cierre</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="reflexion" name="influencer_reflexion" placeholder=" " maxlength="150">
                                            <label for="reflexion">Reflexión breve</label>
                                        </div>
                                        <h6 class="border-bottom pb-2 mb-3 mt-4">Acciones realizadas</h6>
                                        <div class="form-group mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="influencer_acciones[]" value="Escucha activa" id="escucha">
                                                <label class="form-check-label" for="escucha">Escucha activa </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="influencer_acciones[]" value="Acompañamiento docente" id="acompanamiento">
                                                <label class="form-check-label" for="acompanamiento">Acompañamiento docente</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="influencer_acciones[]" value="Derivación a bienestar" id="bienestar">
                                                <label class="form-check-label" for="bienestar">Derivación a bienestar</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="influencer_acciones[]" value="poyo financiero" id="financiero">
                                                <label class="form-check-label" for="financiero">Apoyo financiero</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="influencer_acciones[]" value="Contacto con familia" id="familia">
                                                <label class="form-check-label" for="familia">Contacto con familia</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="influencer_acciones[]" value="" id="otroAccion">
                                                <label class="form-check-label" for="otroAccion">Otro (especificar)</label>
                                            </div>
                                            <input type="text" class="form-control mt-2" name="influencer_otra_accion" placeholder="Especifique otra acción">
                                        </div>
                                        <!-- Resultado final -->
                                        <h6 class="border-bottom pb-2 mb-3 mt-4">Resultado final</h6>
                                        <div class="form-floating">
                                            <select class="form-control" id="resultadoFinal" name="influencer_resultado_final" required>
                                                <option value="" disabled selected> Seleccione el resultado final </option>
                                                <option value="sigue">Sigue estudiando</option>
                                                <option value="cambio jornada">Cambió de jornada</option>
                                                <option value="aplazamiento">Pidió aplazamiento</option>
                                                <option value="retiro">Se retiró voluntariamente</option>
                                                <option value="desercion Silenciosa">Deserción silenciosa</option>
                                            </select>
                                            <label for="resultadoFinal">Seleccione el resultado final</label>
                                        </div>
                                        <!-- Comentario final -->
                                        <div class="form-floating">
                                            <textarea class="form-control" id="comentarioFinal" name="influencer_comentario_final" placeholder="" rows="4"></textarea>
                                            <label for="comentarioFinal">Comentario final (opcional)</label>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-block mt-4">Cerrar caso</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal reporte influencer -->
    <div class="modal fade" id="modalReporteInfluencerGrupo" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-centered    ">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Influencer <i class="fas fa-plus"></i> </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <!-- crear dos tabs uno para el form y el otro para ver las repseustas -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link text-dark active" id="form-tab" data-toggle="tab" href="#formulario_grupo" role="tab" aria-controls="formulario_grupo" aria-selected="true">
                                <span class="text-dark">
                                    <i class="fas fa-file-signature"></i>
                                    <b>Formulario</b>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" id="historial-tab" data-toggle="tab" href="#historial_grupo" role="tab" aria-controls="historial_grupo" aria-selected="false">
                                <span class="text-dark">
                                    <i class="fas fa-clock-rotate-left"></i>
                                    <b>Historial</b>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="formulario_grupo" role="tabpanel" aria-labelledby="form-tab">
                            <form name="reporteinfluencerGrupo" id="reporteinfluencerGrupo" method="POST" class="mt-3">
                                <input type="hidden" name="id_docente_grupo" id="reporte_id_docente_grupo">
                                <div class="form-group col-12">
                                    <label for="influencer_mensaje">Describir la novedad:</label>
                                    <textarea name="influencer_mensaje" id="influencer_mensaje" rows="5" class="form-control" required></textarea>
                                    <small id="contador_texto">280</small>
                                </div>
                                <button type="submit" id="btnInfluencer" class="btn bg-purple btn-block">Enviar Reporte</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="historial_grupo" role="tabpanel" aria-labelledby="historial_grupo-tab">
                            <div class="table-responsive div_tabla_reportes_grupo">
                                <table class="col-12 table">
                                    <thead>
                                        <th> Mensaje </th>
                                        <th> Fecha </th>
                                        <th> Hora </th>
                                        <th> Periodo </th>
                                    </thead>
                                    <tbody id="tbllistado_reporte_influencer_grupo">
                                        <!-- Aquí se cargarán los reportes -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="box box-primary direct-chat direct-chat-primary mt-3">
                                <div class="box-body div_historico_reporte_grupo" style="overflow-x:none !important">
                                    <div class="direct-chat-messages historico_reporte_grupo" style="height:auto !important">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .group input~label {
            top: 0px;
            font-size: 12px !important;
            color: #fff !important;
        }
    </style>
    </div>
<?php
    require 'footer_docente.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/docentegrupos.js?<?= date("Y-m-d-H:i:s") ?>"></script>
<link href='../fullcalendar/css/main.css' rel='stylesheet' />
<script src='../fullcalendar/js/main.js'></script>
<script src='../fullcalendar/locales/es.js'></script>