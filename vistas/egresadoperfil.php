<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 17;
    require 'header_estudiante.php';
?>


<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                    <h2 class="m-0 line-height-16 pl-4">
                        <span class="titulo-2 fs-18 text-semibold">Perfil egresado</span><br>
                        <span class="fs-14 f-montserrat-regular">¡Un vinculo que no termina!</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                </div>

            </div>
        </div>
    </div>

    <section class="content mx-2">
        <div class="row m-0">

            <form class="px-4" name="formulariodatos" id="formulariodatos" method="POST">
                <div class="col-xl-12" id="preguntas"></div>
            </form>
        </div>
    </section>

    <div class="modal fade" id="myModalData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <section class="container-fluid px-4">
                    <!-- First Section: Data Authorization -->
                    <div id="section-authorization" class="row">
                    <div class="col-12 tono-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="rounded bg-light-blue p-3 text-primary">
                                <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div class="col-10 line-height-18">
                                <span class="">Caracterización</span> <br>
                                <span class="titulo-2 text-semibold fs-20 line-height-18">Egresado</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 py-4">
                        <p class="text-justify">
                            ¡Te invitamos a responder las siguientes preguntas, queremos conocerte más para que sigamos creando experiencias juntos!
                        </p>
                        <h2 class="fs-18 titulo-2 text-semibold">Autorización de datos personales</h2>
                        <p class="text-justify">
                            Conforme lo establece la Ley 1581 de 2012 y sus decretos reglamentarios,
                            manifiesto, de manera libre, previa y expresa, que con el diligenciamiento
                            de la presento encuesta, autorizo a CIAF, para realizar la recolección,
                            tratamiento, almacenamiento y uso de los datos que suministro, cuya finalidad es:
                            Brindar al estudiante servicios de bienestar institucional y social,
                            Realizar Gestión administrativa, contable y financiera, Atención de (PQRS),
                            Obtener datos con Fines históricos y estadísticos, Realizar Publicidad y mercadeo,
                            Cumplir Requerimientos institucionales y del Ministerio de Educación Nacional.
                        </p>
                        <p class="text-justify">
                            En virtud de lo anterior, autorizo a CORPORACIÓN INSTITUTO DE ADMINISTRACIÓN Y FINANZAS –CIAF-,
                            a realizar el tratamiento de datos personales para los fines previamente comunicados y acepto la política
                            de tratamiento de datos personales publicada
                            <a href="https://ciaf.edu.co/tratamientodatos" target="_blank" title="Tratamiento de datos">https://ciaf.edu.co/tratamientodatos</a>
                        </p>
                        <form name="formulariodata" id="formulariodata" method="POST">
                            <div class="checkbox">
                                <label>
                                <input type="checkbox" value="1" name="acepto" id="acepto" required>
                                <a href="https://ciaf.digital/public/web_tratamiento_datos/politicaciaf_tratamientodatos.pdf" target="_blank">Acepto términos y condiciones</a>
                                </label><br>
                                <button class="btn btn-success btn-block" type="submit" id="btnData">Continuar</button>
                            </div>
                        </form>
                    </div>
                    </div>

                </section>
            </div>
        </div>
        </div>
    </div>


</div>

<?php require 'footer_estudiante.php'; }
ob_end_flush(); ?>

<script src="scripts/egresadoperfil.js?<?php echo date('Y-m-d-H:i:s'); ?>"></script>
