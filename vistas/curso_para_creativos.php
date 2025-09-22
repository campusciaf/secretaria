<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    if ($_SESSION['usuario_cargo'] != "Docente") {
        header("Location: ../");
    } else {
        $menu = 12;
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
                            <span class="titulo-2 fs-18 text-semibold">Transformando la Educación</span><br>
                            <span class="fs-14 f-montserrat-regular">Crecemos. Enseñamos. Evolucionamos.</span>
                        </h2>
                    </div>
                    <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                        <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        <button class="btn btn-sm btn-outline-warning px-2 py-0 d-none segundo_tour" onclick='iniciarSegundoTour()'><i class="fa-solid fa-play"></i> Tour 2da parte</button>
                    </div>
                    <div class="col-12 migas mb-0">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="panel_docente.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Domina El Campus Virtual</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="container-fluid p-4">
            <div class="row" id="listado_categorias">
                <div class="col-6 p-4">
                    <div class="row align-items-center">
                        <div class="pl-3">
                            <span class="rounded bg-light-blue p-3 text-primary ">
                                <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div class="col-10">
                            <div class="col-5 fs-14 line-height-18">
                                <span class="" id="lugar_tabla"> Listado </span> <br>
                                <span class="text-semibold fs-20"> Videos</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-10 p-4 mx-auto">

                    <div class="row row-cols-1 row-cols-md-3" id="listado_videos">
                    </div>
                </div>
            </div>
            <div class="row" id="video_preguntas">
                <div class="col-12 mb-3">
                    <button class="btn btn-danger btn-sm" onclick="listarCategorias()"> <i class="fas fa-hand-point-left"></i> Regresar </button>
                </div>
                <div class="col-8 ">
                    <div class="card p-0">
                        <div class="card-body p-0 div_video">
                            <div id="player" class="col-12" style="height: 70vh;"></div>
                            <p id="duracion_video"></p>
                        </div>
                    </div>
                </div>
                <div class="col-4 p-0">
                    <div class="card p-0">
                        <div class="card-body p-0 m-0">
                            <div class="card-header bg-light">
                                <h3 class="card-title fs-18 ">Preguntas</h3>
                            </div>
                            <div class="card-body">
                                <form action="#" method="post" id="form_preguntas">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Modal Video Pregunta Aprobada -->
    <div class="modal fade" id="ModalVideoPreguntaAprobada" tabindex="-1" role="dialog" aria-labelledby="ModalVideoPreguntaAprobadaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalVideoPreguntaAprobadaLabel">Video Pregunta Aprobada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="video_pregunta_aprobada"></div>
                </div> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<?php
    require 'footer_docente.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/curso_para_creativos.js?<?= date("Y-m-d-H:i:s") ?>"></script>
<script src="https://www.youtube.com/iframe_api"></script>