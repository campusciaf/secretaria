<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    if ($_SESSION['usuario_cargo'] == "Docente" or $_SESSION['usuario_cargo'] == "Estudiante") {
        header("Location: ../");
    } else {
        $menu = 10001;
        require 'header.php';
    }
?>
<!-- fullCalendar -->
<link rel="stylesheet" href="../public/css/fullcalendar.min.css">
<link rel="stylesheet" href="../public/css/fullcalendar.print.min.css" media="print">
<div id="precarga" class="precarga"></div>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                    <h2 class="m-0 line-height-16 pl-4">
                        <span class="titulo-2 fs-18 text-semibold">Bienvenidos</span><br>
                        <span class="fs-14 f-montserrat-regular">Crear oportunidades para seres humanos que vibran por
                            un espacio en la sociedad.</span>
                    </h2>
                </div>

                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                    <button class="btn btn-sm btn-outline-primary px-2 py-0" onclick='abrirRequerimientos()'><i class="fa-solid fa-plus"></i> Nuevo requerimiento</button>
                </div>
            </div>
        </div>


    </div>

    <div id="panelRecursos" class="offcanvas-custom">
        <div class="offcanvas-header-custom">
            <h5>Formato requerimientos </h5>
            <button class="btn btn-sm btn-light" onclick=" cerrarRequerimientos()">×</button>
        </div>
        <div id="contenidoPanelRecursos">
            <iframe width="100%" height="94%" src="https://forms.office.com/r/qAUKGGPGQE?embed=true" frameborder="0" marginwidth="0" marginheight="0" style="border: none; max-width:100%; max-height:100vh" allowfullscreen webkitallowfullscreen mozallowfullscreen msallowfullscreen> </iframe>
        </div>
    </div>



    <div class="modal fade" id="modalFotoPerfil" tabindex="-1" role="dialog" aria-labelledby="modalFotoPerfilLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFotoPerfilLabel">¡Agrega o actualiza tu foto de perfil!</h5>
                </div>
                <div class="modal-body text-center">
                    <p>Colaborador CIAF es importante identificarte, por eso te invitamos a subir o actualizar tu foto
                        de perfil para mejorar tu experiencia</p>
                </div>
                <div class="modal-footer">
                    <a href="configurarcuenta.php" class="btn btn-primary">Agregar foto de perfil</a>
                </div>
            </div>
        </div>
    </div>
    <section class="content px-2">
        <div class="contenido" id="mycontenido">
            <div class="row g-4">


                <div class="col-12">   
                    <div class="row">
                        <div class="col-xl-9">
                            <div class="row">

                            
                                <!-- Estudiantes -->
                                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                    <div class="card py-2 px-3">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar avatar-50 rounded bg-light-yellow">
                                                    <i class="fa-solid fa-coins text-warning fa-2x"></i>
                                                </div>
                                            </div>
                                            <div class="col-auto pt-2">
                                                <p class="small text-secondary mb-0">Puntos otorgados estudiantes</p>
                                                <h4 class="fw-medium"><span id="puntos"></span></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Docentes -->
                                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                    <div class="card py-2 px-3">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar avatar-50 rounded bg-light-yellow">
                                                    <i class="fa-solid fa-coins text-warning fa-2x"></i>
                                                </div>
                                            </div>
                                            <div class="col-auto pt-2">
                                                <p class="small text-secondary mb-0">Puntos otorgados docentes</p>
                                                <h4 class="fw-medium"><span id="puntos_docente"></span></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Colaboradores -->
                                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                    <div class="card py-2 px-3">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar avatar-50 rounded bg-light-yellow">
                                                    <i class="fa-solid fa-coins text-warning fa-2x"></i>
                                                </div>
                                            </div>
                                            <div class="col-auto pt-2">
                                                <p class="small text-secondary mb-0">Puntos otorgados colaboradores</p>
                                                <h4 class="fw-medium"><span id="puntos_colaborador"></span></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- cursos de educacion contonuada -->
                                <div class="col-12">
                                    <div class="row" id="misCursos"></div>
                                </div>
                                    <!-- *********************************** -->
                                <!-- feria de emprendimientos -->
                                <div class="col-12 d-none">
                                    <div class="row tono-3 ml-1 py-4">
                                        <div
                                            class="col-xl-6 col-lg-12 col-md-12 col-12 d-flex align-items-center  rounded border-right">
                                            <div class="row justify-content-center pt-4">
                                                <div class="col-12 text-center fs-28 bold titulo-7 pt-0 mt-0 line-height-18 pb-4">Feria
                                                    de <br>Emprendimientos</div>
                                                <div class="col-12 text-center fs-40 bold titulo-7 pt-0 mt-0 ">No te detengas</div>
                                                <div class="col-2">
                                                    <div class="rounded-circle bg-7 text-white p-3 line-height-18 text-center"
                                                        style="width:70px">
                                                        <span id="days" class="fs-28 titulo-7"></span> <br>días
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="rounded-circle bg-7 text-white p-3 line-height-18 text-center"
                                                        style="width:70px">
                                                        <span id="hours" class="fs-28 titulo-7"></span> <br>horas
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="rounded-circle bg-7 text-white p-3 line-height-18 text-center"
                                                        style="width:70px">
                                                        <span id="minutes" class="fs-28 titulo-7"></span> min.
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="rounded-circle bg-7 text-white p-3 line-height-18 text-center"
                                                        style="width:70px">
                                                        <span id="seconds" class="fs-28 titulo-7"></span> seg.
                                                    </div>
                                                </div>
                                                <div class="col-12 text-center fs-40 bold titulo-7 pt-0 mt-0 pt-4">Te esperamos</div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                                            <div class="row">
                                                <div class="col-xl-12 rounded ">
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-auto">
                                                            <i class="fa-solid fa-hashtag p-3 fa-2x bg-light-blue rounded my-2"
                                                                aria-hidden="true"></i>
                                                        </div>
                                                        <div class="col-auto line-height-18">
                                                            <span class="">Eventos en</span> <br>
                                                            <span class="titulo-7 text-semibold fs-20">Exposición</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-4">
                                                    <div class="conte2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- *********************************** -->

                                <!-- calendarios -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="row ">
                                        <!-- calendario academico -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 p-3 " id="t-paso23">
                                            <div class="row align-items-center tono-3">
                                                <div class="col-xl-auto pl-4 pt-3 pb-2 text-regular text-center">
                                                    <span class="rounded bg-light-green p-2 text-success ">
                                                        <i class="fa-solid fa-calendar-days "></i>
                                                    </span>
                                                </div>
                                                <div class="col-xl-6 col-lg-5 col-md-5 col-5 fs-14 line-height-18">
                                                    <span class="">Calendario</span> <br>
                                                    <span class="text-semibold fs-20">Académico</span>
                                                </div>
                                                <div class="col-12 alert-card mt-2">
                                                    <form action="#" method="post" class="row m-0 p-0" name="check_list"
                                                        id="check_list">
                                                        <?php
                                                            $meses = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
                                                            // Suponiendo que recibes id_semestre_actual como un parámetro GET
                                                            $semestreActual = $_SESSION['semestre_actual'];;
                                                            // Ajustar el rango de meses basado en el semestre
                                                            $inicio = $semestreActual == 1 ? 0 : 6;
                                                            $fin = $semestreActual == 1 ? 6 : 12;
                                                            $mesActual = date('n') - 1;
                                                            for ($i = $inicio; $i < $fin; $i++) {
                                                            ?>
                                                        <label for="<?= $meses[$i] ?>"
                                                            class="pt-1 button-calendario text-center <?= ($i == $mesActual) ? 'button-active' : '' ?> col-2"
                                                            onclick="cambiarEstilo(this, '<?= $meses[$i] ?>')"><?= ucfirst($meses[$i]) ?></label>
                                                        <input style="display:none" id="<?= $meses[$i] ?>" type="radio"
                                                            <?= ($i == $mesActual) ? 'checked' : '' ?> name="check_list[]"
                                                            value="<?= ($i + 1) ?>" onchange="mostrarcalendario()">
                                                        <?php
                                                            }
                                                            ?>
                                                    </form>
                                                </div>
                                                <div class=" col-xl-12 col-sm-12">
                                                    <div class="row pt-4 m-0">
                                                        <div class="col-12">
                                                            <div id="traer_calendario"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- calendario de eventos -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 p-3" id="t-paso25">
                                            <div class="row p-0 tono-3">
                                                <div class="col-12 p-2">
                                                    <div class="row align-items-center">
                                                        <div class="pl-4">
                                                            <span class="rounded bg-light-green p-2 text-success ">
                                                                <i class="fa-regular fa-calendar-check"></i>
                                                            </span>
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="col-5 fs-14 line-height-18">
                                                                <span class="">Calendario</span> <br>
                                                                <span class="text-semibold fs-20">Eventos</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 py-4 tono-2">
                                                    <div class="traer_calendario_eventos pt-2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- calendarios -->


                                <!-- clase para mostrar el contenido de los card de la caja de herramientas en el panel admin y calendarios -->
                                <div class="col-xl-6 d-none">
                                    <div class="row">
                                        <div class="col-xl-12 py-4 ">
                                            <div class="row align-items-center">
                                                <div class="col-auto pl-4">
                                                    <span class="rounded bg-light-green p-3 text-success">
                                                        <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                                <div class="col-auto line-height-18">
                                                    <span class="">Herramientas</span> <br>
                                                    <span class="text-semibold fs-20">Digitales</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12 conte mb-4"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- eduacion continuada -->
                                <div class="col-xl-12 mb-4" id="t-paso24">
                                    <div id="slides-continuada"></div>
                                </div>
                                <!-- ******************************** -->
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-lg-3 col-md-3 col-12 mb-4 px-4" id="t-paso24">

                            <div class="row">             
                                <div class="col-12 mb-4 p-2">
                                    <div class="row">
                                        <div class="col-auto text-regular text-center pt-2">
                                            <span class="rounded bg-light-yellow p-2 text-warning">
                                                <i class="fa-solid fa-calendar-days "></i>
                                            </span>
                                        </div>
                                        <div class="col-auto col-lg-5 col-md-5 col-5 fs-14 line-height-18">
                                            <span class="">Siguiente</span> <br>
                                            <span class="text-semibold fs-20">Nivel</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 diario p-4">
                                    <div class="row">
                                        <div class="col-9">
                                        <h3 class="text-white fs-36">¡Hola de nuevo!</h3>
                                        <p class="text-white fs-18">Completa desafíos y recibe recompensas</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 p-4">
                                    <div class="row">
                                        <div class="col-6 fs-16 font-weight-bolder">Desafíos del día</div>
                                        <div class="col-6 text-right fs-18 font-weight-bolder text-warning"><i class="fa-solid fa-clock"></i> Pronto</div>
                                    </div>
                                </div>
                                <div class="col-12 ">
                                    <div class="row align-items-center d-none">
                                        <div class="col-4 text-center "><img src="../public/img/coin-2.webp" width="50px"></div>
                                        <div class="col-8">
                                            <span class="fs-18 font-weight-bolder">Gana 5 Pts</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                        </div>
                                        <div class="col-12 text-right">
                                            <p class="fs-16 font-weight-bolder"><i class="fa-solid fa-link"></i> Desafio Instagram</p>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row tono-2" id="ingresosCampus"></div>
                                    </div>

                                    <div class="col-12 borde p-4 my-4 rounded">
                                        <div class="row">
                                            <div class="col-2"><i class="fa-solid fa-lock fa-2x"></i></div>
                                            <div class="col-10 fs-14 font-weight-bolder">Estamos preparando más desafíos</div>
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
<div class="modal fade" id="modalAnuncio" tabindex="-1" role="dialog" aria-labelledby="modalCalendario"
    aria-hidden="true">
    <form method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="../public/img/hoja_vida.webp" class="btn btn-link" target="_blank">Descargar circular</a>
                </div>
                <div class="modal-body">
                    <img src="../public/img/hoja_vida.webp" alt="Circular Actualización Cv" width="100%">
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="LimpiarFormulario()" class="btn btn-primary"
                        data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="modalMonitoriandoAdministrativos" tabindex="-1" role="dialog"
    aria-labelledby="modalEncuestaFuncionarioLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <form method="POST" name="form-monitoriando-administrativos" id="form-monitoriando-administrativos">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <img src="../public/img/monitoriando_experiencia.jpg" alt="CIAF - Encuesta de Autoevaluación"
                        width="460px">
                    <div class="form-row mt-3">
                        <p>En CIAF, estamos comprometidos con la mejora continua y las experiencias de calidad a toda
                            nuestra comunidad. Para seguir mejorando, necesitamos conocer tu opinión sobre diversos
                            aspectos de nuestra institución.</p>
                        <p>Tu participación es muy importante para nosotros. Te invitamos a completar la siguiente
                            encuesta de percepción, donde podrás compartir tus impresiones y sugerencias sobre tu
                            experiencia en CIAF. Esto nos permitirá identificar oportunidades de mejora y fortalecer los
                            procesos que impactan tu formación y bienestar.</p>
                        <p>Agradecemos de antemano tu tiempo y disposición para ayudarnos a crecer juntos.</p>
                        <p><strong>Para cada afirmación, selecciona una opción en la siguiente escala de Likert del 1 al
                                5:</strong></p>
                        <ul>
                            <li>5: Se cumple plenamente.</li>
                            <li>4: Se cumple en gran medida.</li>
                            <li>3: Se cumple de manera aceptable.</li>
                            <li>2: Se cumple de forma insatisfactoria.</li>
                            <li>1: No se cumple.</li>
                        </ul>
                        <h4 class="mt-3">MECANISMOS DE SELECCIÓN Y EVALUACIÓN DE ESTUDIANTES
                        </h4>
                        <div class="likert">
                            <label>El reglamento estudiantil se encuentra disponible para ser consultado fácilmente y
                                permite su apropiación</label><br>
                            <input type="radio" name="p1" value="1" required> 1
                            <input type="radio" name="p1" value="2" required> 2
                            <input type="radio" name="p1" value="3" required> 3
                            <input type="radio" name="p1" value="4" required> 4
                            <input type="radio" name="p1" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>Los requisitos y criterios de inscripción, admisión y matrícula y grado de los
                                estudiantes son claros y transparentes.</label><br>
                            <input type="radio" name="p2" value="1" required> 1
                            <input type="radio" name="p2" value="2" required> 2
                            <input type="radio" name="p2" value="3" required> 3
                            <input type="radio" name="p2" value="4" required> 4
                            <input type="radio" name="p2" value="5" required> 5
                        </div>
                        <h4 class="mt-3">MECANISMOS DE SELECCIÓN Y EVALUACIÓN DE PROFESORES
                        </h4>
                        <div class="likert">
                            <label>El grupo profesores, en términos de dedicación, vinculación y disponibilidad, permite
                                el desarrollo de las labores formativas, académicas, docentes, científicas, culturales y
                                extensión.
                            </label><br>
                            <input type="radio" name="p3" value="1" required> 1
                            <input type="radio" name="p3" value="2" required> 2
                            <input type="radio" name="p3" value="3" required> 3
                            <input type="radio" name="p3" value="4" required> 4
                            <input type="radio" name="p3" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>Los docentes tienen la experiencia y el conocimiento adecuados para orientar los
                                procesos académicos y formativos.
                            </label><br>
                            <input type="radio" name="p4" value="1" required> 1
                            <input type="radio" name="p4" value="2" required> 2
                            <input type="radio" name="p4" value="3" required> 3
                            <input type="radio" name="p4" value="4" required> 4
                            <input type="radio" name="p4" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>Los docentes evalúan a los estudiantes de acuerdo con los criterios de evaluación
                                establecidos para identificar el logro de los resultados de aprendizaje.</label><br>
                            <input type="radio" name="p5" value="1" required> 1
                            <input type="radio" name="p5" value="2" required> 2
                            <input type="radio" name="p5" value="3" required> 3
                            <input type="radio" name="p5" value="4" required> 4
                            <input type="radio" name="p5" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>Los docentes desarrollan los planes institucionales y los procesos formativos según
                                el número de estudiantes proyectado.
                            </label><br>
                            <input type="radio" name="p6" value="1" required> 1
                            <input type="radio" name="p6" value="2" required> 2
                            <input type="radio" name="p6" value="3" required> 3
                            <input type="radio" name="p6" value="4" required> 4
                            <input type="radio" name="p6" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>El reglamento docente establece los criterios y mecanismos para el ingreso,
                                desarrollo, permanencia y evaluación de los docentes.
                            </label><br>
                            <input type="radio" name="p7" value="1" required> 1
                            <input type="radio" name="p7" value="2" required> 2
                            <input type="radio" name="p7" value="3" required> 3
                            <input type="radio" name="p7" value="4" required> 4
                            <input type="radio" name="p7" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>Los mecanismos implementados para el ingreso, desarrollo, permanencia y evaluación de
                                los docentes cumplen con principios de transparencia, mérito y objetividad.
                            </label><br>
                            <input type="radio" name="p8" value="1" required> 1
                            <input type="radio" name="p8" value="2" required> 2
                            <input type="radio" name="p8" value="3" required> 3
                            <input type="radio" name="p8" value="4" required> 4
                            <input type="radio" name="p8" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>Los planes de cualificación docente fortalecen la actualización y profundización de
                                conocimientos, para el mejoramiento de sus competencias investigativas y su desarrollo
                                pedagógico.
                            </label><br>
                            <input type="radio" name="p9" value="1" required> 1
                            <input type="radio" name="p9" value="2" required> 2
                            <input type="radio" name="p9" value="3" required> 3
                            <input type="radio" name="p9" value="4" required> 4
                            <input type="radio" name="p9" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label> CIAF otorga distinciones y estímulos a los docentes conforme a lo establecido en el
                                reglamento docente.
                            </label><br>
                            <input type="radio" name="p10" value="1" required> 1
                            <input type="radio" name="p10" value="2" required> 2
                            <input type="radio" name="p10" value="3" required> 3
                            <input type="radio" name="p10" value="4" required> 4
                            <input type="radio" name="p10" value="5" required> 5
                        </div>
                        <h4 class="mt-3">ESTRUCTURA ACADÉMICO ADMINISTRATIVA
                        </h4>
                        <div class="likert">
                            <label> Los estudiantes participan en los eventos de rendición de cuentas organizados por
                                CIAF.
                            </label><br>
                            <input type="radio" name="p11" value="1" required> 1
                            <input type="radio" name="p11" value="2" required> 2
                            <input type="radio" name="p11" value="3" required> 3
                            <input type="radio" name="p11" value="4" required> 4
                            <input type="radio" name="p11" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>CIAF dispone de medios que visibilizan los resultados y actividades de su gestión.
                            </label><br>
                            <input type="radio" name="p12" value="1" required> 1
                            <input type="radio" name="p12" value="2" required> 2
                            <input type="radio" name="p12" value="3" required> 3
                            <input type="radio" name="p12" value="4" required> 4
                            <input type="radio" name="p12" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>El sistema de políticas, estrategias, decisiones, estructuras y procesos de CIAF está
                                orientado al cumplimiento de su misión, bajo principios de gobernabilidad y gobernanza.
                            </label><br>
                            <input type="radio" name="p13" value="1" required> 1
                            <input type="radio" name="p13" value="2" required> 2
                            <input type="radio" name="p13" value="3" required> 3
                            <input type="radio" name="p13" value="4" required> 4
                            <input type="radio" name="p13" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>Los estudiantes tienen la oportunidad de participar en las decisiones institucionales
                                mediante su representatividad en los diferentes estamentos establecidos para ello.
                            </label><br>
                            <input type="radio" name="p14" value="1" required> 1
                            <input type="radio" name="p14" value="2" required> 2
                            <input type="radio" name="p14" value="3" required> 3
                            <input type="radio" name="p14" value="4" required> 4
                            <input type="radio" name="p14" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>CIAF dispone de canales de comunicación para que los estudiantes manifiesten sus
                                inquietudes y sugerencias y se responden de manera satisfactoria y oportuna.
                            </label><br>
                            <input type="radio" name="p15" value="1" required> 1
                            <input type="radio" name="p15" value="2" required> 2
                            <input type="radio" name="p15" value="3" required> 3
                            <input type="radio" name="p15" value="4" required> 4
                            <input type="radio" name="p15" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>Las políticas institucionales están articuladas a las expectativas y necesidades de
                                los contextos locales, regionales y globales.
                            </label><br>
                            <input type="radio" name="p16" value="1" required> 1
                            <input type="radio" name="p16" value="2" required> 2
                            <input type="radio" name="p16" value="3" required> 3
                            <input type="radio" name="p16" value="4" required> 4
                            <input type="radio" name="p16" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>La estructura organizacional de CIAF está descrita en sus medios de comunicación.
                            </label><br>
                            <input type="radio" name="p17" value="1" required> 1
                            <input type="radio" name="p17" value="2" required> 2
                            <input type="radio" name="p17" value="3" required> 3
                            <input type="radio" name="p17" value="4" required> 4
                            <input type="radio" name="p17" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>El manual de funciones de CIAF describe claramente las responsabilidades de sus
                                funcionarios.
                            </label><br>
                            <input type="radio" name="p18" value="1" required> 1
                            <input type="radio" name="p18" value="2" required> 2
                            <input type="radio" name="p18" value="3" required> 3
                            <input type="radio" name="p18" value="4" required> 4
                            <input type="radio" name="p18" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>Existe articulación entre los procesos, la organización y los cargos para asegurar
                                las labores formativas, académicas, científicas, culturales y de extensión que
                                desarrollan los docentes.
                            </label><br>
                            <input type="radio" name="p19" value="1" required> 1
                            <input type="radio" name="p19" value="2" required> 2
                            <input type="radio" name="p19" value="3" required> 3
                            <input type="radio" name="p19" value="4" required> 4
                            <input type="radio" name="p19" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>CIAF mantiene a la comunidad académica actualizada a través de sus diferentes medios
                                de comunicación institucionales.
                            </label><br>
                            <input type="radio" name="p20" value="1" required> 1
                            <input type="radio" name="p20" value="2" required> 2
                            <input type="radio" name="p20" value="3" required> 3
                            <input type="radio" name="p20" value="4" required> 4
                            <input type="radio" name="p20" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>La página web institucional y las redes sociales de CIAF están actualizadas con
                                información relevante.
                            </label><br>
                            <input type="radio" name="p21" value="1" required> 1
                            <input type="radio" name="p21" value="2" required> 2
                            <input type="radio" name="p21" value="3" required> 3
                            <input type="radio" name="p21" value="4" required> 4
                            <input type="radio" name="p21" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>El Campus Virtual de CIAF es accesible y funcional.
                            </label><br>
                            <input type="radio" name="p22" value="1" required> 1
                            <input type="radio" name="p22" value="2" required> 2
                            <input type="radio" name="p22" value="3" required> 3
                            <input type="radio" name="p22" value="4" required> 4
                            <input type="radio" name="p22" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>CIAF cuenta con un sistema de información que permite recopilar datos oportunos y
                                suficientes para la toma de decisiones.
                            </label><br>
                            <input type="radio" name="p23" value="1" required> 1
                            <input type="radio" name="p23" value="2" required> 2
                            <input type="radio" name="p23" value="3" required> 3
                            <input type="radio" name="p23" value="4" required> 4
                            <input type="radio" name="p23" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>CIAF dispone de herramientas y sistemas que facilitan la recopilación, divulgación y
                                organización de información entre sus usuarios.
                            </label><br>
                            <input type="radio" name="p24" value="1" required> 1
                            <input type="radio" name="p24" value="2" required> 2
                            <input type="radio" name="p24" value="3" required> 3
                            <input type="radio" name="p24" value="4" required> 4
                            <input type="radio" name="p24" value="5" required> 5
                        </div>
                        <h4 class="mt-3">CULTURA DE AUTOEVALUACIÓN
                        </h4>
                        <div class="likert">
                            <label>Los procesos de autoevaluación en CIAF contribuyen a la mejora institucional.
                            </label><br>
                            <input type="radio" name="p25" value="1" required> 1
                            <input type="radio" name="p25" value="2" required> 2
                            <input type="radio" name="p25" value="3" required> 3
                            <input type="radio" name="p25" value="4" required> 4
                            <input type="radio" name="p25" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>La evolución de CIAF se refleja a través de sus procesos de seguimiento y
                                mejoramiento continuo.
                            </label><br>
                            <input type="radio" name="p26" value="1" required> 1
                            <input type="radio" name="p26" value="2" required> 2
                            <input type="radio" name="p26" value="3" required> 3
                            <input type="radio" name="p26" value="4" required> 4
                            <input type="radio" name="p26" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>El proceso de autoevaluación da lugar a la elaboración de planes para la mejora
                                institucional.
                            </label><br>
                            <input type="radio" name="p27" value="1" required> 1
                            <input type="radio" name="p27" value="2" required> 2
                            <input type="radio" name="p27" value="3" required> 3
                            <input type="radio" name="p27" value="4" required> 4
                            <input type="radio" name="p27" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>
                                Se ha demostrado la existencia e implementación de políticas de autoevaluación y
                                autorregulación orientadas al mejoramiento continuo.
                            </label><br>
                            <input type="radio" name="p28" value="1" required> 1
                            <input type="radio" name="p28" value="2" required> 2
                            <input type="radio" name="p28" value="3" required> 3
                            <input type="radio" name="p28" value="4" required> 4
                            <input type="radio" name="p28" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>
                                El Sistema Interno de Aseguramiento de la Calidad contempla la sistematización, gestión
                                y uso de información requerida para proponer e implementar mejoras.
                            </label><br>
                            <input type="radio" name="p29" value="1" required> 1
                            <input type="radio" name="p29" value="2" required> 2
                            <input type="radio" name="p29" value="3" required> 3
                            <input type="radio" name="p29" value="4" required> 4
                            <input type="radio" name="p29" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>
                                El Sistema Interno de Aseguramiento de la Calidad incluye mecanismos que permiten la
                                participación de la comunidad académica y de los grupos de interés para contribuir al
                                proceso.
                            </label><br>
                            <input type="radio" name="p30" value="1" required> 1
                            <input type="radio" name="p30" value="2" required> 2
                            <input type="radio" name="p30" value="3" required> 3
                            <input type="radio" name="p30" value="4" required> 4
                            <input type="radio" name="p30" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>
                                El Sistema Interno de Aseguramiento de la Calidad articula los programas de mejoramiento
                                con la planeación y el presupuesto general de la institución.
                            </label><br>
                            <input type="radio" name="p31" value="1" required> 1
                            <input type="radio" name="p31" value="2" required> 2
                            <input type="radio" name="p31" value="3" required> 3
                            <input type="radio" name="p31" value="4" required> 4
                            <input type="radio" name="p31" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>
                                El Sistema Interno de Aseguramiento de la Calidad contempla mecanismos que permiten la
                                autoevaluación y autorregulación permanente.
                            </label><br>
                            <input type="radio" name="p32" value="1" required> 1
                            <input type="radio" name="p32" value="2" required> 2
                            <input type="radio" name="p32" value="3" required> 3
                            <input type="radio" name="p32" value="4" required> 4
                            <input type="radio" name="p32" value="5" required> 5
                        </div>
                        <h4 class="mt-3">MODELO DE BIENESTAR
                        </h4>
                        <div class="likert">
                            <label>
                                Los programas y servicios de bienestar se divulgan a través de los medios de
                                comunicación de CIAF.
                            </label><br>
                            <input type="radio" name="p33" value="1" required> 1
                            <input type="radio" name="p33" value="2" required> 2
                            <input type="radio" name="p33" value="3" required> 3
                            <input type="radio" name="p33" value="4" required> 4
                            <input type="radio" name="p33" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>
                                Bienestar Universitario brinda asesoría a los estudiantes en riesgo académico y de
                                deserción , orientación psicologica entre otros
                            </label><br>
                            <input type="radio" name="p34" value="1" required> 1
                            <input type="radio" name="p34" value="2" required> 2
                            <input type="radio" name="p34" value="3" required> 3
                            <input type="radio" name="p34" value="4" required> 4
                            <input type="radio" name="p34" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>
                                La comunidad de CIAF cuenta con mecanismos para evaluar los servicios de bienestar.
                            </label><br>
                            <input type="radio" name="p35" value="1" required> 1
                            <input type="radio" name="p35" value="2" required> 2
                            <input type="radio" name="p35" value="3" required> 3
                            <input type="radio" name="p35" value="4" required> 4
                            <input type="radio" name="p35" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>
                                CIAF implementa continuamente programas de capacitación y desarrollo para su personal.
                            </label><br>
                            <input type="radio" name="p36" value="1" required> 1
                            <input type="radio" name="p36" value="2" required> 2
                            <input type="radio" name="p36" value="3" required> 3
                            <input type="radio" name="p36" value="4" required> 4
                            <input type="radio" name="p36" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>
                                CIAF cuenta con una política de bienestar claramente definida.
                            </label><br>
                            <input type="radio" name="p37" value="1" required> 1
                            <input type="radio" name="p37" value="2" required> 2
                            <input type="radio" name="p37" value="3" required> 3
                            <input type="radio" name="p37" value="4" required> 4
                            <input type="radio" name="p37" value="5" required> 5
                        </div>
                        <h4 class="mt-3">RECURSOS SUFICIENTES
                        </h4>
                        <div class="likert">
                            <label>
                                CIAF dispone de infraestructura adecuada para el desarrollo de actividades
                                administrativas y académicas, incluyendo áreas de dirección, oficinas de directores de
                                programa, salas de reuniones y ambientes de aprendizaje.
                            </label><br>
                            <input type="radio" name="p38" value="1" required> 1
                            <input type="radio" name="p38" value="2" required> 2
                            <input type="radio" name="p38" value="3" required> 3
                            <input type="radio" name="p38" value="4" required> 4
                            <input type="radio" name="p38" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>
                                Las herramientas tecnológicas disponibles en CIAF son suficientes para el desarrollo de
                                las actividades académicas.
                            </label><br>
                            <input type="radio" name="p39" value="1" required> 1
                            <input type="radio" name="p39" value="2" required> 2
                            <input type="radio" name="p39" value="3" required> 3
                            <input type="radio" name="p39" value="4" required> 4
                            <input type="radio" name="p39" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>
                                CIAF cuenta con políticas y mecanismos para atraer, desarrollar y retener el talento
                                humano.
                            </label><br>
                            <input type="radio" name="p40" value="1" required> 1
                            <input type="radio" name="p40" value="2" required> 2
                            <input type="radio" name="p40" value="3" required> 3
                            <input type="radio" name="p40" value="4" required> 4
                            <input type="radio" name="p40" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>
                                El talento humano, junto con los recursos físicos, tecnológicos y financieros, es
                                suficiente y está alineado con la oferta académica.
                            </label><br>
                            <input type="radio" name="p41" value="1" required> 1
                            <input type="radio" name="p41" value="2" required> 2
                            <input type="radio" name="p41" value="3" required> 3
                            <input type="radio" name="p41" value="4" required> 4
                            <input type="radio" name="p41" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>
                                El clima institucional en CIAF favorece la convivencia entre los miembros de la
                                comunidad educativa.
                            </label><br>
                            <input type="radio" name="p42" value="1" required> 1
                            <input type="radio" name="p42" value="2" required> 2
                            <input type="radio" name="p42" value="3" required> 3
                            <input type="radio" name="p42" value="4" required> 4
                            <input type="radio" name="p42" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>
                                CIAF reconoce el trabajo y esfuerzo de su personal.
                            </label><br>
                            <input type="radio" name="p43" value="1" required> 1
                            <input type="radio" name="p43" value="2" required> 2
                            <input type="radio" name="p43" value="3" required> 3
                            <input type="radio" name="p43" value="4" required> 4
                            <input type="radio" name="p43" value="5" required> 5
                        </div>
                        <div class="likert">
                            <label>
                                CIAF cuenta con mecanismos para divulgar sus políticas financieras.
                            </label><br>
                            <input type="radio" name="p44" value="1" required> 1
                            <input type="radio" name="p44" value="2" required> 2
                            <input type="radio" name="p44" value="3" required> 3
                            <input type="radio" name="p44" value="4" required> 4
                            <input type="radio" name="p44" value="5" required> 5
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enviar Respuestas</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
    require 'footer.php';
}
ob_end_flush();
?>
<script src='../public/js/sly.min.js'></script> <!-- calendario de ventos -->
<!-- fullCalendar -->
<script src="../bower_components/moment/moment.js"></script>
<!-- <script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="../bower_components/fullcalendar/dist/locale/es.js"></script> -->
<script type="text/javascript" src="scripts/panel_admin.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<!-- <script type="text/javascript" src="../public/js/educacion-continuada.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script> -->
<!-- <script src='../public/js/sly.min.js'></script> -->
</body>

</html>