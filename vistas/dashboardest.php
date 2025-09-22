<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
	header("Location: ../");
} else {
	$menu = 14;
	require 'header_estudiante.php';
?>
<?php
require_once "../modelos/Usuario.php";
$usuario = new Usuario();
$valor_estado = $usuario->consultar_Estado_Estudiante($_SESSION["credencial_identificacion"]);
// $estado_ciafi = $valor_estado['estado_ciafi'];

if (empty($valor_estado)) {
    $estado_ciafi = 1;
} else {

	$estado_ciafi = $valor_estado['estado_ciafi'];
   
}
if ($estado_ciafi == 1) {

		?>

<style>
/* Always set the map height explicitly to define the size of the div
   * element that contains the map. */
#map {
    height: 70vh;
}

/* Optional: Makes the sample page fill the window. */
</style>
<!-- fullCalendar -->
<link rel="stylesheet" href="../public/css/fullcalendar.min.css">
<link rel="stylesheet" href="../public/css/fullcalendar.print.min.css" media="print">

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                    <h2 class="m-0 line-height-16 pl-4">
                        <span class="titulo-2 fs-18 text-semibold">Mi Tablero</span><br>
                        <span class="fs-14 f-montserrat-regular">Tu plataforma virtual.</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i
                            class="fa-solid fa-play"></i> Tour</button>
                </div>

            </div>
        </div>
    </div>

    <section class="container-fluid px-4">
        <div class="contenido" id="mycontenido">
            <div class="row">

 

                <div class="col-xl-8">
                    <div class="row pb-2 boton-mandos">
                        <div class="col-xl-12 col-lg-12 d-flex  pb-2">
                            <ul>
                                <li><a onclick="listardatos(1)" id="opcion1"> Hoy </a></li>
                                <li><a onclick="listardatos(2)" id="opcion2"> Ayer </a></li>
                                <li><a onclick="listardatos(3)" id="opcion3"> Semana </a></li>
                                <li><a onclick="listardatos(4)" id="opcion4"> Mes </a></li>
                            </ul>
                        </div>
                        <div class="col-12 pt-2">
                            <div class="row">

                                <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2"
                                    onclick="mostrar_faltas()">
                                    <div class="row justify-content-center">
                                        <div class="col-12 hidden" id="t-paso14">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar rounded bg-light-red text-red">
                                                        <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <div class="col ps-0">
                                                    <div class="small mb-0">Faltas</div>
                                                    <h4 class="text-dark mb-0">
                                                        <span class="text-semibold" id="dato_faltas">0</span>
                                                        <small class="text-regular fs-12">Faltas</small>
                                                    </h4>
                                                    <div class="small">Reportadas<span class="text-green"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2"
                                    onclick="notasreportadas()">
                                    <div class="row justify-content-center" id="t-paso15">
                                        <div class="col-12 hidden">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar rounded bg-light-purple text-purple">
                                                        <i class="fa-solid fa-clipboard-check"></i>
                                                    </div>
                                                </div>
                                                <div class="col ps-0">
                                                    <div class="small mb-0">Notas</div>
                                                    <h4 class="text-dark mb-0">
                                                        <span class="text-semibold" id="dato_notas_reportadas">0</span>
                                                        <small class="text-regular fs-12">Notas</small>
                                                    </h4>
                                                    <div class="small">Reportadas<span class="text-green"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2"
                                    onclick="mostraractividadesnuevas()">
                                    <div class="row justify-content-center" id="t-paso16">
                                        <div class="col-12 hidden">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar rounded bg-light-purple text-purple">
                                                        <i class="fa-solid fa-file-circle-plus "></i>
                                                    </div>
                                                </div>
                                                <div class="col ps-0">
                                                    <div class="small mb-0">Actividades</div>
                                                    <h4 class="text-dark mb-0">
                                                        <span class="text-semibold" id="dato_actividades">0</span>
                                                        <small class="text-regular fs-12">Publicadas</small>
                                                    </h4>
                                                    <div class="small">Nuevas<span class="text-green"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-12 pt-3">

                            <div class="row">

                                <div id="t-paso19" class="col-xl-3 col-lg-4 col-md-6 col-6">

                                    <!-- <div class="" id="pendientes"></div> -->
                                    <div class="info-box">
                                        <span class="info-box-icon bg-light-green elevation-1 text-success">
                                            <i class="fa-solid fa-location-dot"></i>
                                        </span>
                                        <div class="info-box-content cursor-pointer">
                                            <span class="info-box-text">Dirección residencia</span>
                                            <span class="info-box-number"><a data-toggle="modal" id="iniciarMapa" data-target="#myModalDireccion" class="pointer " title="No es obligatorio, pero es necesario para mejorar la experiencia en CIAF, por ejemplo (Gestión de horarios)">
                                                    Validar aquí con mapa
                                                </a></span>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-xl-3 col-lg-4 col-md-6 col-6" id="t-paso20">
                                    <div class="info-box">
                                        <span class="info-box-icon">
                                            <i class="fa-solid fa-database"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Estoy caracterizado</span>
                                            <span class="info-box-number fs-12" id="dato_caracterizados">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-6" id="t-paso21">
                                    <div class="info-box">
                                        <span class="info-box-icon ">
                                            <i class="fa-solid fa-rss"></i>
                                        </span>
                                        <div class="info-box-content ">

                                            <span class="info-box-text">Novedades</span>
                                            <span class="info-box-number fs-12">Próximamente</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-4 col-md-6 col-6" id="t-paso22">
                                    <div class="info-box">
                                        <span class="info-box-icon">
                                            <i class="fa-solid fa-right-to-bracket"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <a onclick="mostrar_nombre_estudiante()" class="pointer">
                                                <span class="info-box-text">Ingresos CAMPUS</span>
                                                <span class="info-box-number" id="dato_ingresos">0</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="row">

                        <div class="col-6">
                            <div class="card col-12 pt-2" id="t-paso17">

                                <div class="row">
                                    <div class="col-4">
                                        <i
                                            class="fa-brands fa-buromobelexperte  bg-light-blue avatar rounded fa-2x text-azul"></i>
                                    </div>
                                    <div class="col-8 pt-2">
                                        <div class="small text-regular">Clases</div>
                                        <div class="fs-20">DEL DÍA</div>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>

                                    <div class="col-12" id="clasedeldiaa">

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-6" id="t-paso18">
                            <div class="card col-12 pt-2">

                                <div class="row">
                                    <div class="col-4">
                                        <i
                                            class="fa-solid fa-user-check bg-light-green avatar rounded fa-2x text-success"></i>
                                    </div>
                                    <div class="col-8 pt-2">
                                        <div class="small text-regular">Perfil</div>
                                        <div class="fs-20">OK</div>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                    

                                    <!-- <div class="smallchart80 mb-2">
                                    <canvas id="barchartpink" style="display: block; box-sizing: border-box; height: 80px; width: 172px;" width="172" height="80"></canvas>
                                    </div> -->

                                    <div class="col-12">
                                        <p class="text-secondary small mb-0">Ultima actualización</p>
                                        <p class="fs-12" id="dato_perfil_actualizado">--</p>
                                    </div>


                                    <div class="col-6">
                                        <p class="text-secondary small mb-0">Estudiantes</p>
                                        <p class=" " onclick="perfilesactualizadosestudiante()" id="dato_perfilest">
                                            1.5
                                            m</p>
                                    </div>

                                    <div class="col-6 text-right">
                                        <p class="text-secondary small mb-0">Total</p>
                                        <p>60.01 k</p>
                                    </div>
                               
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div><!-- /.row -->
        </div>
    </section>
   
    <section class="container-fluid px-4 mb-4 pb-4">
        <div class="row ">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">Ultimos ingresos al campus</div>
            <div id="chartContainer" style="height: 370px; width: 100%;" class="col-xl-7 col-lg-8 col-md-12 col-12"></div>
            <div class="col-12 mb-4"></div>
        </div>
      
    </section>
   

</div><!-- /.content-wrapper -->
<!-- Modal -->

<div class="modal fade" id="perfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12 tono-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="rounded bg-light-green p-3 text-success">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </span>

                        </div>
                        <div class="col-10 line-height-18">
                            <span class="">Actualizar perfil</span> <br>
                            <span class="text-semibold fs-20">Validar datos</span>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form name="formularioperfil" id="formularioperfil" method="POST">

                    <div class="col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="email" placeholder="" value="" required
                                    class="form-control border-start-0 usuario_email" name="email" id="email"
                                    maxlength="50">
                                <label>Correo Electronico personal (No CIAF)</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="number" placeholder="" value="" class="form-control border-start-0 "
                                    name="telefono" id="telefono" maxlength="20">
                                <label>Telefono fijo (si tiene)</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="number" placeholder="" value="" class="form-control border-start-0 "
                                    name="celular" id="celular" maxlength="20" required>
                                <label>Número celular</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="text" placeholder="" value="" required
                                    class="form-control border-start-0 usuario_direccion" name="barrio" id="barrio"
                                    maxlength="70" required onchange="javascript:this.value=this.value.toUpperCase();">
                                <label>Barrio de residencia</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>


                    <div class="col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="text" placeholder="" value="" required class="form-control border-start-0"
                                    name="direccion" id="direccion" maxlength="70" required
                                    onchange="javascript:this.value=this.value.toUpperCase();">
                                <label>Dirección de residencia</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <select value="" required class="form-control border-start-0 selectpicker"
                                    data-live-search="true" name="campo" id="campo">
                                    <option value="1">Bajo - bajo</option>
                                    <option value="2">Bajo</option>
                                    <option value="3">Medio-bajo</option>
                                    <option value="4">Medio</option>
                                    <option value="5">Medio-alto</option>
                                    <option value="6">Alto</option>
                                    <option value="7">Sin estrato</option>
                                </select>
                                <label>Estato (nivel socio-economico)</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar cambios </button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="myModalIngresosEstudiantes">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Ingreso Estudiantes</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="datosusuario_estudiante"></div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="myModalFaltas">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Faltas Reportadas</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="datosusuario_faltas"></div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="myModalActividades">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">

                <h4 class="modal-title">Actividades</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">

                <div id="datosusuario_actividades"></div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="myModalActividadesdocente">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">

                <h4 class="modal-title">Actividades</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="datosusuario_mostraractividades"></div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="myModalNotasReportada">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Notas Reportadas</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="datosusuario_nota_reportada"></div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver las acciones y los proyectos -->
<div class="modal fade" id="myModalClasesdelDia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" style="overflow-y: scroll ;">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Clase del Dia</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <div id="clasedeldia"></div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal encuesta -->
<div class="modal fade" id="modalCalendario" tabindex="-1" role="dialog" aria-labelledby="modalCalendario"
    aria-hidden="true">
    <form method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b>
                        <h3 class="modal-title" id="modalCalendarioLabel">Ver Evento</h3>
                    </b>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idActividad" name="idActividad" /><br>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Título: </label>
                            <input class="form-control" type="text" id="txtTitulo" name="txtTitulo"
                                placeholder="Título del Evento" disabled />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Fecha Inicio:</label>
                            <input class="form-control" type="date" id="txtFechaInicio" name="txtFechaInicio"
                                disabled />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Fecha Fin:</label>
                            <input class="form-control" type="date" id="txtFechaFin" name="txtFechaFin" disabled />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="LimpiarFormulario()" class="btn btn-primary"
                        data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="myModalEncuesta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Disculpa que te interrumpa pero quiero que me regales dos
                    minutos para mejorar tu experiencia académica en CIAF.</h5>
            </div>
            <div class="modal-body">
                <form name="formularioencuesta" id="formularioencuesta" method="POST">
                    <div class="col-12">
                        <p><b>Instrucciones</b></p>
                        <p> Selecciona la opción que corresponda en la calificación es de 1 a 5, teniendo en cuenta que
                            1
                            es la calificación más baja y 5 la calificación más alta.</p>
                    </div>
                    <div class="group col-xl-12">
                        <div class="col-xl-12">
                            <p><b>¿Has podido evidenciar elementos creativos e innovadores en tu experiencia
                                    académica?</b></p>
                            <select name="pre1" id="pre1" class="form-control">
                                <option value="1">Muy Insatisfecho </option>
                                <option value="2">Poco Satisfecho</option>
                                <option value="3">Regular</option>
                                <option value="4">Bueno</option>
                                <option value="5">Muy bueno</option>
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                        </div>
                    </div>
                    <div class="group col-xl-12">
                        <div class="col-xl-12">
                            <p><b>¿En el cumplimiento de tu meta, es decir, el grado ¿te sientes apoyado por la
                                    institución?</b></p>
                            <select name="pre2" id="pre2" class="form-control">
                                <option value="1">Muy Insatisfecho </option>
                                <option value="2">Poco Satisfecho</option>
                                <option value="3">Regular</option>
                                <option value="4">Bueno</option>
                                <option value="5">Muy bueno</option>
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                        </div>
                    </div>
                    <div class="group col-xl-12">
                        <div class="col-xl-12">
                            <p><b>¿Cuál crees tú que es el docente más creativo e innovador de la institución?</b></p>
                            <select name="pre3" id="pre3" class="form-control selectpicker" data-live-search="true"
                                required>
                            </select>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar cambios </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="myModalEncuestad" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>SEMANA ORIGINAL CIAF</strong></h4>
            </div>
            <div class="modal-body">
                <div id="preguntas"></div>
                <form name="formulario" id="formulario" method="POST">
                    <img src="../public/img/encuesta.jpg" width="100%">
                    <div class="well">
                        Apreciado estudiante y colaborador, para nuestra institución es muy importante tu opinión, para
                        ello nos interesa conocer cual de las siguientes actividades planteadas son de tu interés. La
                        información recopilada será utilizada para uso interno estadístico de acuerdo al tratamiento de
                        la información Habeas Data.<br><br>
                        <b>Nuestra semana original CIAF 2020, estará enfoca en actividades de gran interés, para ello te
                            solicitamos selecciones las actividades planteadas de manera remota que consideres
                            interesante:</b>
                        Iniciaremos con una serie de charlas virtuales dentro de un modelo dinámico, en esta oportunidad
                        conocerás las charlas de la noche del miércoles 21 de octubre.<br><br>
                    </div>
                    <h1 class="titulo-1">Primer bloque</h1>
                    <label>
                        <input type="radio" name="r1" id="r1" value="La Cajita Feliz">
                        La Cajita Feliz financiera: 6 tips para manejar las finanzas personales correctamente
                    </label><br>
                    <label>
                        <input type="radio" name="r1" id="r1" value="Ven y emprende">
                        Ven y emprende con la Alcaldía de Pereira: nacimiento del Valle del Software
                    </label><br>
                    <label>
                        <input type="radio" name="r1" id="r1" value="Redes sociales">
                        Redes sociales para la consultoría: un medio para dar a conocer a otros mi potencial
                    </label><br>
                    <label>
                        <input type="radio" name="r1" id="r1" value="Revolución del talento">
                        Revolución del talento: 3 Habilidades blandas en el mundo 4,0
                    </label>
                    <h1 class="titulo-1">Segundo Bloque</h1>
                    <label>
                        <input type="radio" name="r2" id="r2" value="Caso de éxito">
                        Caso de éxito: Emprendiendo con propósito
                    </label><br>
                    <label>
                        <input type="radio" name="r2" id="r2" value="El científico de datos">
                        El científico de datos, el profesional sexy del futuro ( qué es y para qué sirve)
                    </label><br>
                    <label>
                        <input type="radio" name="r2" id="r2" value="Gerencie con felicidad">
                        Gerencie con felicidad: Descubre como hacer feliz a tu equipo, Happiness Management 4.0
                    </label><br>
                    <label>
                        <input type="radio" name="r2" id="r2" value="Inteligencia artificial para fútbol">
                        Inteligencia artificial para fútbol<br>
                    </label>
                    <h1 class="titulo-1">Tercer Bloque</h1>
                    <label>
                        <input type="radio" name="r3" id="r3" value="consejos SST">
                        ¿Sigue abierto su lugar de trabajo durante el COVID -19? 6 consejos SST para su lugar de trabajo
                    </label><br>
                    <label>
                        <input type="radio" name="r3" id="r3" value="juego de ajedrez">
                        Sea estratégico en el juego: Inteligencia artificial para el juego de ajedrez
                    </label><br>
                    <label>
                        <input type="radio" name="r3" value="La importancia de saber respirar">
                        La importancia de saber respirar: ¿cómo afrontar un momento de estrés?
                    </label><br>
                    <label>
                        <input type="radio" name="r3" id="r3" value="tips para mejorar Memoria">
                        3 tips para mejorar Memoria<br>
                    </label>
                    <h1 class="titulo-1">Cuarto Bloque</h1>
                    <label>
                        <input type="radio" name="r4" id="r4" value="Networking">
                        Networking: 6 tips para hacer contactos en un mundo de negocios
                    </label><br>
                    <label>
                        <input type="radio" name="r4" id="r4" value="tips para hablar en público y convencer">
                        Vende tu idea a un auditorio: 3 tips para hablar en público y convencer
                    </label><br>
                    <label>
                        <input type="radio" name="r4" id="r4" value="En TIC Confío">
                        En TIC Confío: 3 Herramientas para afrontar con seguridad los riesgos del uso de las TIC
                    </label><br>
                    <label>
                        <input type="radio" name="r4" id="r4" value="Caso de éxito en clase">
                        Caso de éxito en clase: desarrollo de habilidades para el servicio<br>
                    </label><br>
                    <button class="btn btn-success btn-block" type="submit" id="btnGuardar">
                        <i class="fa fa-save"></i>
                        Guardar
                    </button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalEducacionContinuada" tabindex="-1" aria-labelledby="modalEducacionContinuadaLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">

                    <div class="row">
                        <div class="col-12 p-2">
                            <div class="row">
                                <div class="pl-4 d-flex align-items-center">
                                    <span class="rounded bg-light-yellow p-3 text-warning">
                                        <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                    </span>

                                </div>
                                <div class="col-8 fs-14 line-height-18 pl-4">

                                    <span class="categoria_curso text-capitalize">tipo</span> en: <br>
                                    <span class="text-semibold fs-18 nombre_curso">Eventos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div id="precarga_modal" class="precarga_modal"></div>
            <div class="modal-body py-1">


                <div class="row">

                    <div class="col-xl-12">
                        <div class="row justify-content-center">
                            <div class="col-xl-12 p-0"><img width="100%" class="img_curso" src="" alt="Angular"></div>
                        </div>
                    </div>

                    <div class="col-xl-12 pt-2">
                        <p class="descripcion_curso fs-16 "> - </p>
                    </div>

                    <div class="col-xl-12">

                        <div class="row mb-2 p-2">

                            <div class="col-xl-7">
                                <div class="row">

                                    <div class="col-xl-12 p-2 borde rounded">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="p-3 rounded bg-light-green text-success">
                                                    <i class="fa-solid fa-cart-shopping"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Inversión</div>

                                                <span class="boton fs-24 text-semibold">$ <span class="valor_curso"> -
                                                    </span>
                                            </div>
                                        </div>

                                        <div class="row boton_epayco"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-center borde rounded ml-3 ">
                                <div class="row">
                                    <div class="col-12 small text-center">Separa tu cupo</div>
                                    <div class="col-12 boton_inscripcion text-center justify-content-center"></div>
                                </div>

                            </div>

                        </div>
                        <div class="row tono-1 py-2 ">

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="p-2 rounded bg-light-blue text-primary">
                                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Nivel</div>

                                                <div class="text-semibold nivel_curso fs-14 text-capitalize">--</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="p-2 rounded bg-light-blue text-primary">
                                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Modalidad</div>

                                                <div class="text-semibold modalidad_curso fs-14 text-capitalize">--
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="p-2 rounded bg-light-blue text-primary">
                                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Duración</div>

                                                <div class="text-semibold duracion_curso fs-14 text-capitalize">--</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-12 my-4">
                            <div class="small mb-0">Fecha de inicio</div>
                            <h4 class="text-dark mb-0">
                                <span class="text-semibold fecha_inicio fs-14">0</span>
                            </h4>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModalDireccion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><strong>Ubicación residencia</strong></h6>
            </div>
            <div class="modal-body">
                <form method="POST" id="formulariomapas" name="formulariomapas">
                    <div class="row">
                        <input type="hidden" name="latitud" id="latitud">
                        <input type="hidden" name="longitud" id="longitud">
                        <div class="col-12 tono-3">
                            <span class="titulo-3">Ubicar el punto rojo del mapa en su dirección de residencia</span>
                        </div>
                        <div class="col-4 pt-2">
                            <button class="btn btn-success btn-lg" type="submit" id="btnMapas">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Clic aquí para guardar ubicación
                            </button>
                        </div>
                        <div class="col-12">
                            <div id="map"></div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php

		
}elseif ($estado_ciafi == 0) {
	?>
<div class="content-wrapper mt-5">
    <section class="content" style="padding-top: 0px;">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title mt-3">Acceso bloqueado</h5>
                        <p class="card-text mt-5"> ¡Por favor contáctanos al 📞 3126814341 para encontrar una solución
                            en conjunto!

                            Queremos seguir ofreciéndote el beneficio de la financiación directa para que cumplas tu
                            sueño de ser profesional. ¡Ayúdanos a cuidarla!🌞</p>
                        <a href="financiacion.php" class="btn btn-warning btn-lg text-dark">Realizar Pago</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div><!-- /.content-wrapper -->

<?php

}

?>

<?php
	require 'footer_estudiante.php';
}
ob_end_flush();
?>

<script src='../public/js/sly.min.js'></script> <!-- calendario de ventos -->
<script type="text/javascript" src="scripts/dashboardest.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>


<!-- <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-9GbQKtTGVtTsUJiUfMwFfbsB0hN8UGw&callback=initialize&v=weekly"
    async
    loading="lazy">
</script> -->






</body>

</html>