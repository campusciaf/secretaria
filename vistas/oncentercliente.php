<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 14;
    $submenu = 1411;
    require 'header.php';

    if ($_SESSION['oncentercliente'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <!--Contenido-->
        <!-- Content Wrapper. Contains page content -->
        <!--Contenido-->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Consulta Clientes</span><br>
                                <span class="fs-16 f-montserrat-regular">Obtenga toda la información de sus clientes en un solo
                                    sitio</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour " onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                            <button class="btn btn-sm btn-outline-warning px-2 py-0 d-none segundo_tour" onclick='iniciarSegundoTour()'><i class="fa-solid fa-play"></i> Tour 2da parte</button>
                        </div>

                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Consulta clientes</li>
                            </ol>
                        </div>

                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            
            <section class="container-fluid px-4 py-2">
                <div class="row mx-0">

                    <div id="titulo" class="col-12 "></div>

                    <div class="col-4 p-4 card" id="t-CL">
                        <div class="row">
                            <input type="hidden" value="" name="tipo" id="tipo">


                            <div class="col-12">
                                <h3 class="titulo-2 fs-14">Buscar cliente por:</h3>
                            </div>
                            <div class="col-12">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="">
                                        <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true" onclick="muestra(1)">Identificación</a>
                                    </li>
                                    <li class="">
                                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false" onclick="muestra(2)">Caso</a>
                                    </li>
                                    <li class="">
                                        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false" onclick="muestra(3)">Tel/Celular</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-12 mt-2" id="input_dato">
                                <div class="row">
                                    <div class="col-10 m-0 p-0">
                                        <div class="form-group position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" class="form-control border-start-0" name="dato" id="dato" required>
                                                <label id="valortitulo">Seleccionar tipo</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>

                                    <div class="col-2 m-0 p-0">
                                        <input type="submit" value="Buscar" onclick="consultacliente()" class="btn btn-success py-3 btn-block" disabled id="btnconsulta" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-4 borde-right" id="datos_estudiante">


                        <div class="col-12 px-2 py-3 ">
                            <div class="row align-items-center" id="t-NC">
                                <div class="pl-4">
                                    <span class="rounded bg-light-white p-2 text-gray ">
                                        <i class="fa-solid fa-user-slash" aria-hidden="true"></i>
                                    </span>

                                </div>
                                <div class="col-10">
                                    <div class="col-5 fs-14 line-height-18">
                                        <span class="">Nombres </span> <br>
                                        <span class="text-semibold fs-14">Apellidos </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-2 py-2 ">
                            <div class="row align-items-center" id="t-Ce">
                                <div class="pl-4">
                                    <span class="rounded bg-light-white p-2 text-gray">
                                        <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                                    </span>

                                </div>
                                <div class="col-10">
                                    <div class="col-5 fs-14 line-height-18">
                                        <span class="">Correo electrónico</span> <br>
                                        <span class="text-semibold fs-14">correo@correo.com</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-2 py-2 ">
                            <div class="row align-items-center" id="t-NT">
                                <div class="pl-4">
                                    <span class="rounded bg-light-white p-2 text-gray">
                                        <i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
                                    </span>

                                </div>
                                <div class="col-10">
                                    <div class="col-5 fs-14 line-height-18">
                                        <span class="">Número celular</span> <br>
                                        <span class="text-semibold fs-14">+570000000</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="col-4 " id="panel_detalle">
                        <div class="col-12  pt-3">
                            <div class="row">
                                <div class="col-4 mnw-100 text-center pt-4">
                                    <i class="fa-solid fa-trophy avatar avatar-50 bg-light-white text-gray rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
                                    <h4 class="titulo-2 fs-18 mb-0">-----</h4>
                                    <p class="small text-secondary">Caso</p>
                                </div>
                                <div class="col-4 mnw-100 text-center pt-4">
                                    <i class="fa-solid fa-bullhorn avatar avatar-50 bg-light-white text-gray rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
                                    <h4 class="titulo-2 fs-18 mb-0">-----</h4>
                                    <p class="small text-secondary">Campaña</p>
                                </div>
                                <div class="col-4 mnw-100 text-center pt-4">
                                    <i class="fa-solid fa-user-check avatar avatar-50 bg-light-white text-gray rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
                                    <h4 class="titulo-2 fs-18 mb-0">-----</h4>
                                    <p class="small text-secondary">Estado</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 datos_table">
                        <div class="row mt-4" id="t-TP">
                            <div class="col-12 px-2 py-3 tono-3">
                                <div class="row align-items-center">
                                    <div class="pl-4">
                                        <span class="rounded bg-light-blue p-2 text-primary ">
                                            <i class="fa-solid fa-table"></i>
                                        </span>

                                    </div>
                                    <div class="col-10">
                                        <div class="col-5 fs-14 line-height-18">
                                            <span class="">Programas</span> <br>
                                            <span class="text-semibold fs-14">Matriculados</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 card p-4">

                                <table class="table" id="tbl_datos">
                                    <thead>
                                        <tr>
                                            <th id="t-CS">Caso</th>
                                            <th id="t-P">Programa</th>
                                            <th id="t-Jr">Jornada</th>
                                            <th id="t-FI">Fecha ingresa</th>
                                            <th id="t-ME">Medio</th>
                                            <th id="t-ES">Estado</th>
                                            <th id="t-PC">Periodo campaña</th>
                                            <th id="AC">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row datos_table"></div> -->
                <div class="col-12" id="panel_resultado"></div>
            </section>
        </div>


        <!-- inicio modal entrevista -->
        <div id="myModalEntrevista" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Entrevista</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="formentrevista.php" method="POST">
                    <div class="row">
                        <input type="hidden" id="id_estudiante" name="id_estudiante">
                        <div class="form-group col-md-6">
                        <label for="salud_fisica">¿Cómo describirías tu salud física actualmente?</label>
                        <select name="salud_fisica" id="salud_fisica" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="5">Excelente</option>
                            <option value="4">Buena</option>
                            <option value="3">Regular</option>
                            <option value="2">Mala</option>
                            <option value="1">Muy mala</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6">
                        <label for="salud_mental">¿Cómo describirías tu salud mental actualmente?</label>
                        <select name="salud_mental" id="salud_mental" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="5">Excelente</option>
                            <option value="4">Buena</option>
                            <option value="3">Regular</option>
                            <option value="2">Mala</option>
                            <option value="1">Muy mala</option>
                        </select>
                        </div>

                        <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-12 pb-2">
                            <label for="condicion_especial">¿Tienes alguna condición médica, neurológica o emocional que requiera atención especial en CIAF?</label>
                            </div>
                            <div class="form-group col-4">
                            <select name="condicion_especial" id="condicion_especial" class="form-control">
                                <option value="" disabled selected>-- Selecciona una opción --</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                            </div>
                            <div class="form-group col-md-8">
                            <input type="text" name="nombre_condicion_especial" id="nombre_condicion_especial" class="form-control" placeholder="Ingrese su condición">
                            </div>
                        </div>
                        </div>

                        <div class="form-group col-md-12 p-2">
                        <label for="estres_reciente">¿Has sentido estrés, ansiedad o tristeza con frecuencia en los últimos 6 meses?</label>
                        <select name="estres_reciente" id="estres_reciente" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-md-12 p-2">
                        <label for="desea_apoyo_mental">¿Te gustaría recibir apoyo en temas relacionados con la salud mental durante tu tiempo en CIAF?</label>
                        <select name="desea_apoyo_mental" id="desea_apoyo_mental" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="costea_estudios">¿Eres tú quien asume los costos de tus estudios?</label>
                        <select name="costea_estudios" id="costea_estudios" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="labora_actualmente">¿Laboras actualmente?</label>
                        <select name="labora_actualmente" id="labora_actualmente" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="donde_labora">¿En qué empresa laboras?</label>
                        <input type="text" name="donde_labora" id="donde_labora" class="form-control" placeholder="Ingrese empresa">
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="tiempo_laborando">¿Cuánto tiempo llevas laborando en esta entidad?</label>
                        <select name="tiempo_laborando" id="tiempo_laborando" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="0 a 6 meses">0 a 6 meses</option>
                            <option value="6 meses a 1 año">6 meses a un año</option>
                            <option value="un año a dos años">un año a dos años</option>
                            <option value="mayor a dos años">mayor a dos años</option>
                        </select>
                        </div>

                        <div class="form-group col-xl-12 p-2">
                        <label for="desea_beca">¿Has solicitado o estás interesado en solicitar algún tipo de beca o ayuda financiera?</label>
                        <select name="desea_beca" id="desea_beca" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-xl-12 p-2">
                        <label for="responsabilidades_familiares">¿Tienes responsabilidades familiares que podrían afectar tu tiempo de estudio?</label>
                        <select name="responsabilidades_familiares" id="responsabilidades_familiares" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-xl-12 p-2">
                        <label for="seguridad_carrera">¿Qué tan seguro/a te sientes de que es el programa correcto para ti?</label>
                        <select name="seguridad_carrera" id="seguridad_carrera" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="5">Muy seguro</option>
                            <option value="4">Seguro</option>
                            <option value="3">Indeciso</option>
                            <option value="2">Poco seguro</option>
                            <option value="1">Nada seguro</option>
                        </select>
                        </div>

                        <div class="form-group col-xl-12 p-2">
                        <label for="penso_abandonar">¿Has considerado abandonar tus estudios en algún momento antes de comenzar?</label>
                        <select name="penso_abandonar" id="penso_abandonar" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="desea_referir">¿Te gustaría referir personas para que inicien su experiencia profesional en CIAF?</label>
                        <select name="desea_referir" id="desea_referir" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-xl-6 p-2">
                        <label for="rendimiento_prev">¿Cómo describirías tu rendimiento académico en el colegio o estudios anteriores?</label>
                        <select name="rendimiento_prev" id="rendimiento_prev" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="5">Excelente</option>
                            <option value="4">Buena</option>
                            <option value="3">Regular</option>
                            <option value="2">Malo</option>
                            <option value="1">Muy malo</option>
                        </select>
                        </div>

                        <div class="col-12 py-2">
                        <div class="row">
                            <div class="col-12 pb-2">
                            <label for="necesita_apoyo_academico">¿Tienes alguna materia o área en la que sientas que necesitas apoyo adicional?</label>
                            </div>
                            <div class="form-group col-4">
                            <select name="necesita_apoyo_academico" id="necesita_apoyo_academico" class="form-control">
                                <option value="" disabled selected>-- Selecciona una opción --</option>
                                <option value="1">Sí</option>
                                <option value="2">No</option>
                            </select>
                            </div>
                            <div class="form-group col-md-8">
                            <input type="text" name="nombre_materia" id="nombre_materia" class="form-control" placeholder="¿Cuál materia?">
                            </div>
                        </div>
                        </div>

                        <div class="form-group col-xl-6 p-2">
                        <label for="tiene_habilidades_organizativas">¿Tienes las habilidades necesarias para organizarte y enfrentar las exigencias académicas?</label>
                        <select name="tiene_habilidades_organizativas" id="tiene_habilidades_organizativas" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-xl-6 p-2">
                        <label for="comodidad_herramientas_digitales">¿Qué tan cómodo te sientes con el uso de herramientas digitales para el aprendizaje?</label>
                        <select name="comodidad_herramientas_digitales" id="comodidad_herramientas_digitales" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="5">Muy cómodo</option>
                            <option value="4">Cómodo</option>
                            <option value="3">Neutral</option>
                            <option value="2">Poco cómodo</option>
                            <option value="1">Nada cómodo</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="acceso_internet">¿Tienes internet en casa?</label>
                        <select name="acceso_internet" id="acceso_internet" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="acceso_computador">¿Tienes computador en casa?</label>
                        <select name="acceso_computador" id="acceso_computador" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6">
                        <label for="estrato">¿Cuál es tu estrato socioeconómico?</label>
                        <select name="estrato" id="estrato" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                        </div>

                        <div class="form-group col-md-6">
                        <label for="municipio_residencia">¿En qué municipio resides actualmente?</label>
                        <input type="text" name="municipio_residencia" id="municipio_residencia" class="form-control" placeholder="Ingrese el nombre">
                        </div>

                        <div class="form-group col-md-6">
                        <label for="direccion_residencia">¿Cuál es tu dirección de residencia actual?</label>
                        <input type="text" name="direccion_residencia" id="direccion_residencia" class="form-control" placeholder="Ingrese el nombre">
                        </div>

                        <div class="form-group col-xl-6 p-2">
                        <label for="nombre_referencia_familiar">Nombre completo de tu referencia familiar</label>
                        <input type="text" name="nombre_referencia_familiar" id="nombre_referencia_familiar" class="form-control" placeholder="Ingrese el nombre">
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="telefono_referencia_familiar">Número de contacto de tu referencia familiar</label>
                        <input type="text" name="telefono_referencia_familiar" id="telefono_referencia_familiar" class="form-control" placeholder="Teléfono">
                        </div>

                        <div class="form-group col-md-6 p-2">
                        <label for="parentesco_referencia_familiar">Parentesco con tu referencia familiar</label>
                        <select name="parentesco_referencia_familiar" id="parentesco_referencia_familiar" class="form-control">
                            <option value="" disabled selected>-- Selecciona una opción --</option>
                            <option value="Padre">Padre</option>
                            <option value="Madre">Madre</option>
                            <option value="Pareja">Pareja</option>
                            <option value="Hermano/a">Hermano/a</option>
                            <option value="Tío/a">Tío/a</option>
                            <option value="Abuelo/a">Abuelo/a</option>
                            <option value="Otro">Otro</option>
                        </select>
                        </div>

                    </div>

                    <button type="button" class="btn btn-success" onclick="editarEntrevistaAsesor()">Guardar Entrevista</button>
                </form>


            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

        <!-- fin modal entrevista -->
        <!-- inicio modal ver soportes -->
        <div id="myModaVerSoportesDigitales" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Soportes</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body" id="resultado_cambiar_documento">
                        <form id="form_soporte_digitales1" method="post" class="soporte_cedula"></form>
                        <form id="form_soporte_digitales2" method="post" class="soporte_diploma"></form>
                        <form id="form_soporte_digitales3" method="post" class="soporte_acta"></form>
                        <form id="form_soporte_digitales4" method="post" class="soporte_salud"></form>
                        <form id="form_soporte_digitales5" method="post" class="soporte_prueba"></form>
                        <form id="form_soporte_compromiso" method="post" class="soporte_compromiso"></form>
                        <form id="form_soporte_proteccion_datos" method="post" class="soporte_proteccion_datos"></form>
                        <form id="form_compromiso_ingles" method="post" class="soporte_ingles"></form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal ver soportes -->

        <!-- inicio modal agregar seguimiento -->
        <div class="modal" id="myModalAgregar">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title">Agregar seguimiento</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">

                        <?php require_once "on_segui_tareas.php" ?>

                    </div>

                </div>
            </div>
        </div>

        <!-- inicio modal ficha -->
        <div class="modal" id="myModalFicha">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Ficha Estudiante</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div id="resultado_ficha"></div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal ficha -->
        <!-- inicio modal historial -->
        <!-- The Modal -->
        <div class="modal" id="myModalHistorial">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title">Historial</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div id="historial" class="col-12"></div>

                            <div class="col-12 mt-4">
                                <div class="card card-tabs">
                                    <div class="card-header p-0 pt-1">
                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Seguimiento</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Tareas
                                                    Programadas</a>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="tab-content" id="custom-tabs-one-tabContent">
                                            <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

                                                <div class="row">
                                                    <div class="col-12 p-4">
                                                        <table id="tbllistadohistorial" class="table" width="100%">
                                                            <thead>
                                                                <th>Caso</th>
                                                                <th>Motivo</th>
                                                                <th>Observaciones</th>
                                                                <th>Fecha de observación</th>
                                                                <th>Asesor</th>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">

                                                <table id="tbllistadoHistorialTareas" class="table" width="100%">
                                                    <thead>
                                                        <th>Estado</th>
                                                        <th>Motivo</th>
                                                        <th>Observaciones</th>
                                                        <th>Fecha de observación</th>
                                                        <th>Asesor</th>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
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
        <!-- fin modal historial -->
        <!-- inicio modal mover -->
        <div class="modal" id="myModalMover">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title">Cambiar de estado</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form name="moverUsuario" id="moverUsuario" method="POST" class="row">
                            <input type="hidden" id="id_estudiante_mover" value="" name="id_estudiante_mover">

                            <p class="pl-3">Mover el estado de cliente</p>

                            <div class="col-12">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="estado" id="estado"></select>
                                        <label>Cambiar por:</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>
                            <div class="col-12">
                                <input type="submit" value="Mover usuario" id="btnMover" class="btn btn-success btn-block">
                            </div>


                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- inicio modal camara -->
        <div id="modalwebacam" class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Foto para cliente</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" id="cc">
                                <input type="hidden" id="url">
                                <h2>Camara</h2>
                                <div class="col-md-12" id="my_camera"></div>
                            </div>
                            <div class="col-md-6 img"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="tomarfoto()" class="btn btn-info">Tomar foto</button>
                        <button type="button" onclick="restablecer()" class="btn btn-warning">Restablecer</button>
                        <button type="button" onclick="guardar()" class="btn btn-success">Guardar Foto</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- fin modal camara -->
        <!-- inicio modal soporte_inscripcion -->
        <div class="modal fade" id="soporte_inscripcion">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Soporte de inscripcion</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body" id="resultado_ficha">
                        <form id="form_soporte" method="post">
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Soporte</label>
                                <input type="hidden" name="id" class="id_es">
                                <input type="file" name="soporte" class="form-control-file" id="exampleFormControlFile1">
                            </div>
                            <button type="submit" id="btnGuardarsoporte" class="btn btn-success"><i class="fa fa-save"></i>
                                Guardar</button>
                        </form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal soporte_inscripcion -->
        <div class="modal" id="myModalValidarDocumento">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Cambio de Documento</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <!-- Modal body -->
                    <div class="modal-body" id="resultado_cambiar_documento">
                        <div class="alert alert-info">
                            Este paso deja al interesado en <b>preinscrito</b> y tiene acceso a la plataforma de mercadeo para
                            llenar formulario de inscripción.
                        </div>
                        <h3>Documento actual</h3>
                        <input type="text" id="cambio_cedula" value="" name="cambio_cedula" class="form-control" readonly="readonly">
                        <h3>Nuevo Documento</h3>
                        <form name="cambioDocumento" id="cambioDocumento" method="POST">
                            <input type="hidden" id="id_estudiante_documento" value="" name="id_estudiante_documento">
                            <input type="text" id="nuevo_documento" name="nuevo_documento" class="form-control" placeholder="Nuevo Documento" required="">
                            <input type="text" id="repetir_documento" name="repetir_documento" class="form-control" placeholder="Repetir Documento" required="">
                            <h5>Modalidad Campaña</h5>
                            <select name="modalidad_campana" id="modalidad_campana" class="form-control selectpicker" data-live-search="true" required>
                            </select>
                            <input type="submit" value="Cambiar Documento" id="btnCambiar" class="btn btn-success btn-block">
                        </form>
                        <div id="resultado_cedula"></div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!---------------------------------------------------------------------  MODALES(Ver Cuotas)   ---------------------------------------------------------------------------->
        <div class="modal fade" id="modal_whatsapp" tabindex="-1" role="dialog" aria-labelledby="modal_whatsapp_label">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h6 class="modal-title" id="modal_whatsapp_label"> Whatapp </h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 m-0 seccion_conversacion">
                                    <?php require_once "whatsapp_module.php" ?>
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

    require 'footer.php';
    ?>

    <script type="text/javascript" src="scripts/oncentercliente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
    <script type="text/javascript" src="scripts/on_segui_tareas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
    <script type="text/javascript" src="scripts/whatsapp_module.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
    <script type="text/javascript" src="../public/webcam/js/webcam.min.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
ob_end_flush();
?>