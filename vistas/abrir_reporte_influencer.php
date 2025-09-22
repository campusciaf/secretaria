<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 15;
    $submenu = 1512;
    require 'header.php';
    if ($_SESSION['abrir_reporte_influencer'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Influencer +</span><br>
                                <span class="fs-14 f-montserrat-regular">Conecta con los estudiantes y supera los obstáculos</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                        </div>
                        <div class="col-12 migas mb-0">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Reporte Influencer</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid px-4">
                <div class="row">
                    <div class="col-12 panel-body " id="listadoregistros">
                        <div class="busqueda row">
                            <div class="col-12">
                                <form name="buscar_estudiante" id="buscar_estudiante" action="#" class="row col-12 py-3">
                                    <div class="col-4 pr-4">
                                        <div class="row">
                                            <div class="col-12 mb-2">
                                                Buscar estudiante por:
                                            </div>
                                            <div class="col-9 m-0 p-0">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating" id="t-B">
                                                        <input type="text" placeholder="" value="" required class="form-control border-start-0" name="input_estudiante" id="input_estudiante" maxlength="20">
                                                        <label>Número Identificación</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                            <div class="col-3 m-0 p-0">
                                                <button type="submit" class="btn btn-success btn-buscar btn-fla py-3" id="btn-buscar-estudiante"><i class="fas fa-search "></i> Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8" id="datos_estudiante">
                                        <div class="row">
                                            <div class="col-4 py-2 " id="t-NC">
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
                                            <div class="col-4 py-2" id="t-C">
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
                                            <div class="col-4 py-2" id="t-NT">
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
                                            <div class="col-4 py-2" id="t-CD">
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
                                            <div class="col-4 py-2" id="t-D">
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
                                    <div class="col-12" id="matriculaccordion">
                                        <div class="row">
                                            <div class="col-12 titulo-2 fs-14">
                                                Programas y cursos matriculados
                                            </div>
                                            <div class="col-12 lista_programas">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row" id="t-caso">
                                <div class="col-12 tono-3 p-4">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <span class="rounded bg-light-blue p-2 text-primary">
                                                        <i class="fa-solid fa-handshake-angle"></i>
                                                    </span>
                                                </div>
                                                <div class="col-10">
                                                    <span class="fs-12">Reportes</span> <br>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 text-right">
                                            <button data-toggle="modal" data-target="#modal-nuevo-caso" class="btn btn-success" id="btnabrircaso"> <i class="fas fa-plus" style="padding-right: 5px;" id="t-Acaso"></i>Abrir Caso</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 card">
                                    <div class="tabla_busquedas col-12 p-4">
                                        <table id="tabla_casos" class="table table-hover table-nowarp">
                                            <thead>
                                                <tr>
                                                    <th> Rspta </th>
                                                    <th> Nivel </th>
                                                    <th> Dimensión </th>
                                                    <th> Mensaje </th>
                                                    <th> Estado </th>
                                                    <th> Fecha </th>
                                                    <th> Hora </th>
                                                    <th> Periodo </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th colspan="11">
                                                        <div class=" text-center" style="margin:0px !important">
                                                            <h3>Aquí aparecerán los casos del estudiante.</h3>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div><!-- /.content-wrapper -->
        <!--Fin-Contenido-->
        <!--Modal Abrir Caso-->
        <div class="modal" tabindex="-1" role="dialog" id="modal-nuevo-caso" aria-labelledby="nuevoCaso">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h6 class="modal-title" id="gridSystemModalLabel">Abrir nuevo caso</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 pb-4">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="rounded bg-light-green p-2 text-success">
                                        <i class="fa-regular fa-user"></i>
                                    </span>
                                </div>
                                <div class="col-10">
                                    <span class="fs-12">Estudiante</span> <br>
                                    <span class="text-semibold fs-12 titulo-2 line-height-16" id="cedula-estudiante"></span>
                                </div>
                            </div>
                        </div>
                        <form name="reporteinfluencer" id="reporteinfluencer" method="POST" class="mt-3">
                            <input type='hidden' value="" id='id_estudiante_influencer' name='id_estudiante'>
                            <input type='hidden' value="" id='id_programa_ac' name='id_programa_ac'>
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
                                    <input type="radio" name="influencer_dimension" id="buen_desempeño" value="Buen Desempeño" required checked>
                                    <label for="buen_desempeño"> Buen Desempeño </label>
                                </div>
                                <div class="col">
                                    <h6> Psicosocial </h6>
                                    <input type="radio" name="influencer_dimension" id="EmocionalmenteEstable" value="Emocionalmente Estable" required />
                                    <label for="EmocionalmenteEstable"> Emocionalmente Estable </label>
                                </div>
                                <div class="col">
                                    <h6>Vocacional</h6>
                                    <input type="radio" name="influencer_dimension" id="Proactivo" value="Proactivo" required />
                                    <label for="Proactivo"> Proactivo </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="LiderazgoEmergente" value="Liderazgo Emergente" required />
                                    <label for="LiderazgoEmergente"> Liderazgo Emergente </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="ProyecciónAlta" value="Proyección Alta" required />
                                    <label for="ProyecciónAlta"> Proyección Alta </label>
                                </div>
                                <div class="col">
                                    <h6>Convivencia</h6>
                                    <input type="radio" name="influencer_dimension" id="RedDeApoyoPositiva" value="Red De Apoyo Positiva" required />
                                    <label for="RedDeApoyoPositiva"> Red De Apoyo Positiva </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="Participativo" value="Participativo" required />
                                    <label for="Participativo"> Participativo </label>
                                </div>
                            </div>
                            <div class="form-group row gestionPositiva gestionMedia gestionAlta">
                                <div class="col">
                                    <h6> Académica </h6>
                                    <input type="radio" name="influencer_dimension" id="BajoRendimiento" required value="Bajo Rendimiento" />
                                    <label for="BajoRendimiento"> Bajo Rendimiento </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="FaltaDeMotivación" required value="Falta De Motivación" />
                                    <label for="FaltaDeMotivación"> Falta De Motivación </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="RetrasoEnEntregas" required value="Retraso En Entregas" />
                                    <label for="RetrasoEnEntregas"> Retraso En Entregas </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="DificultadesDeAprendizaje" required value="Dificultades De Aprendizaje" />
                                    <label for="DificultadesDeAprendizaje"> Dificultades De Aprendizaje </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="NecesitaRefuerzo" required value="Necesita Refuerzo" />
                                    <label for="NecesitaRefuerzo"> Necesita Refuerzo </label>
                                    <br>
                                </div>
                                <div class="col">
                                    <h6> Financiera </h6>
                                    <input type="radio" name="influencer_dimension" id="DificultadDePago" required value="Dificultad De Pago" />
                                    <label for="DificultadDePago"> Dificultad De Pago </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="PendienteDeMatricula" required value="Pendiente De Matricula" />
                                    <label for="PendienteDeMatricula"> Pendiente De Matricula </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="SolicitaDescuento" required value="Solicita Descuento" />
                                    <label for="SolicitaDescuento"> Solicita Descuento </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="GestiónConFinanciera" required value="Gestión Con Financiera" />
                                    <label for="GestiónConFinanciera"> Gestión Con Financiera </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="RiesgoPorMotivoEconómico" required value="Riesgo Por Motivo Económico" />
                                    <label for="RiesgoPorMotivoEconómico"> Riesgo Por Motivo Económico </label>
                                    <br>
                                </div>
                                <div class="col">
                                    <h6> Psicosocial </h6>
                                    <input type="radio" name="influencer_dimension" id="Ansiedad" required value="Ansiedad" />
                                    <label for="Ansiedad"> Ansiedad </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="FamiliarEnfermo" required value="Familiar Enfermo" />
                                    <label for="FamiliarEnfermo"> Familiar Enfermo </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="FaltaDeRedDeApoyo" required value="Falta De Red De Apoyo" />
                                    <label for="FaltaDeRedDeApoyo"> Falta De Red DeApoyo </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="CrisisPersonal" required value="Crisis Personal" />
                                    <label for="CrisisPersonal"> Crisis Personal </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="NecesitaPsicología" required value="Necesita Psicología" />
                                    <label for="NecesitaPsicología"> Necesita Psicología </label>
                                    <br>
                                </div>
                                <div class="col">
                                    <h6>Vocacional</h6>
                                    <input type="radio" name="influencer_dimension" id="DudaSobrePrograma" required value="Duda Sobre Programa" />
                                    <label for="DudaSobrePrograma"> Duda Sobre Programa </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="CambioDeCarrera" required value="Cambio De Carrera" />
                                    <label for="CambioDeCarrera"> Cambio De Carrera </label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="FaltaDePropósito" required value="Falta De Propósito" />
                                    <label for="FaltaDePropósito"> Falta De Propósito </label>
                                    <br>
                                </div>
                                <div class="col">
                                    <h6>Convivencia</h6>
                                    <input type="radio" name="influencer_dimension" id="ConflictosConCompañeros" required value="Conflictos Con Compañeros" />
                                    <label for="ConflictosConCompañeros"> Conflictos Con Compañeros</label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="ConflictosConDocente" required value="Conflictos Con Docente" />
                                    <label for="ConflictosConDocente"> Conflictos Con Docente</label>
                                    <br>
                                    <input type="radio" name="influencer_dimension" id="Aislamiento" required value="Aislamiento" />
                                    <label for="Aislamiento"> Aislamiento</label>
                                    <br>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="influencer_mensaje">Describir la novedad:</label>
                                <textarea name="influencer_mensaje" id="influencer_mensaje" rows="5" class="form-control" required></textarea>
                                <small id="contador_texto">280</small>
                            </div>
                            <button type="submit" id="btnInfluencer" class="btn bg-purple btn-block">Enviar Reporte</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="modalMostrarInfoReporte" aria-labelledby="nuevoCaso">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h6 class="modal-title" id="gridSystemModalLabel">Seguimiento Influencer</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
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
                                    <div class="form-floating mt-3">
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

        <!--    cerrar modal abrir caso -->
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<!-- fullCalendar -->
<script src="../bower_components/moment/moment.js"></script>
<!-- Script para cargar los eventos js del calendario -->
<script src="scripts/abrir_reporte_influencer.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<!-- Page specific script -->