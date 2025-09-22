<?php
ob_start();
require_once "../modelos/Estudiante.php";
$estudiante_c = new Estudiante();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 1;
    require 'header_estudiante.php';
    if (!empty($_SESSION['id_usuario'])) {
?>


        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">

                            <h2 class="m-0 line-height-16 pl-4">
                                <span class="titulo-2 fs-18 text-semibold">Hola</span><br>
                                <span class="fs-14 f-montserrat-regular">Plan de estudios y calendario</span>
                            </h2>
                            
                            <!-- <h2 class="m-0 line-height-16 pl-3">
                                <span id="nombre_programa"></span>
                            </h2> -->
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <!-- <div class="col-12 migas mb-0">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_estudiante.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Programas</li>
                            </ol>
                        </div> -->
                    </div>
                </div>
            </div>
            <section class="content mx-2">
                <div class="col-12 px-2">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card-body p-0">




                                <div id="opciones" class="row mx-0 px-0"></div>
                                <div id="tbllistado" class="row mx-0 px-0"></div>
                                <div id="horario" class="row mx-0 px-0"></div>
                                <div id="panel" class="p-2"></div>
                                <div id="descripcion" class="col-12"></div>
                                <div id="documentos" class="col-12"></div>
                                <div id="enlaces" class="col-12 m-0 p-0"></div>
                                <div id="ejercicios" class="col-12"></div>
                                <div id="glosario" class="col-12 tono-2">
                                    <div class="row">
                                        <div class="col-12" id="glosariocabecera"></div>
                                        <div class="col-12 p-4">
                                            <table id="tblglosario" class="table table-hover" style="width:100%">
                                                <thead>
                                                    <th>Palabra</th>
                                                    <th>Definición</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12" id="volver">
                                    <div class="row">
                                        <div class="col-6 tono-3 ">
                                            <div class="row align-items-center">
                                                <div class="pl-4">
                                                    <span class="rounded bg-light-blue p-3 text-primary ">
                                                        <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                                    </span>

                                                </div>
                                                <div class="col-10">
                                                    <div class="col-5 fs-14 line-height-18">
                                                        <span class="">Horario</span> <br>
                                                        <span class="text-semibold fs-20">de clases</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 tono-3  pr-4">
                                            <a onclick=volverhorario() class='btn btn-danger float-right text-white'><i class="fa-solid fa-xmark"></i> Cerrar calendario</a>
                                        </div>
                                        <div class="col-12" id="calendar" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </section>

            <div id="panelRecursos" class="offcanvas-custom">
                <div class="offcanvas-header-custom">
                    <h5>Actividades y recursos</h5>
                    <button class="btn btn-sm btn-light" onclick="cerrarPanel()">×</button>
                </div>
                <div id="contenidoPanelRecursos">
                    <p class="text-muted">Cargando contenido...</p>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal" id="crearGlosario">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Glosario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formulariocrearglosario" id="formulariocrearglosario" method="POST">
                                <input type="hidden" id="id_pea_glosario" name="id_pea_glosario">
                                <input type="hidden" id="id_pea_docentes_glosario" name="id_pea_docentes_glosario">
                                <div class="group col-xl-12">
                                    <input type="text" name="titulo_glosario" id="titulo_glosario" required maxlength="30" />
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Titulo glosario</label>
                                </div>
                                <div class="col-xl-12">
                                    <label>Definición glosario</label>
                                    <textarea name="definicion_glosario" id="definicion_glosario" required maxlength="240" rows="4" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <button class="btn btn-primary btn-block" type="submit" id="btnCrearGlosario"><i class="fa fa-save"></i> Publicar </button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal" id="subirejercicios">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Enviar Taller</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formulariocrearejercicios" id="formulariocrearejercicios" method="POST">
                                <input type="hidden" id="id_pea_documento" name="id_pea_documento">
                                <div class="col-xl-12">
                                    <label>Comentario</label>
                                    <textarea name="comentario_ejercicios" id="comentario_ejercicios" required maxlength="98" class="form-control" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="archivo_ejercicios">Archivo: <small class="text-danger font-weight-bold">Solo se permiten: Excel, PowerPoint, RAR, PDF, Word, ZIP, Jpg, Png, Jpeg</small> </label>
                                    <input type="file" name="archivo_ejercicios" class="form-control-file" id="archivo_ejercicios" required>
                                    <div id="error_peso" class="badge badge-danger mt-2" style="display: none; white-space: normal;">
                                        El archivo supera el tamaño máximo permitido de 5 MB.
                                    </div>
                                    <div id="error_tipo" class="badge badge-danger mt-2" style="display: none; white-space: normal;">
                                        Tipo de archivo no permitido. Solo se permiten archivos Excel, PowerPoint, RAR, PDF, Word, ZIP, Jpg, Png, Jpeg.
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <button class="btn btn-primary btn-block" type="submit" id="btnCrearEjercicios"><i class="fa fa-save"></i> Publicar </button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="subirenlace">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Enviar Enlace</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioenlace" id="formularioenlace" method="POST">
                                <input type="hidden" id="id_pea_enlace" name="id_pea_enlace">
                                <div class="col-xl-12">
                                    <label>Comentario</label>
                                    <textarea name="comentario_enlace" id="comentario_enlace" required maxlength="98" class="form-control" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="archivo_enlace">Archivo: <small class="text-danger font-weight-bold">Solo se permiten: Excel, PowerPoint, RAR, PDF, Word, ZIP, Jpg, Png, Jpeg</small> </label>
                                    <input type="file" name="archivo_enlace" class="form-control-file" id="archivo_enlace" required>
                                    <div id="error_peso" class="badge badge-danger mt-2" style="display: none; white-space: normal;">
                                        El archivo supera el tamaño máximo permitido de 5 MB.
                                    </div>
                                    <div id="error_tipo" class="badge badge-danger mt-2" style="display: none; white-space: normal;">
                                        Tipo de archivo no permitido. Solo se permiten archivos Excel, PowerPoint, RAR, PDF, Word, ZIP, Jpg, Png, Jpeg.
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <button class="btn btn-primary btn-block" type="submit" id="btnCrearEnlace"><i class="fa fa-save"></i> Publicar </button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="subirenlacelink">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Enviar Link de evidencia</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioenlacelink" id="formularioenlacelink" method="POST">
                                <div class="col-xl-12">
                                    <label>Link del archivo</label>
                                    <input type="hidden" id="id_pea_enlace_link" name="id_pea_enlace_link">
                                    <input type="text" name="link_archivo" id="link_archivo" class="form-control" required></input>
                                </div>
                                <div class="col-xl-12">
                                    <label>Comentario</label>
                                    <textarea name="comentario_enlace_link" id="comentario_enlace_link" required maxlength="98" class="form-control" rows="5"></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <button class="btn btn-primary btn-block" type="submit" id="btnCrearEnlaceLink"><i class="fa fa-save"></i> Enviar al docente </button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="subirenlaceDocumento">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Enviar Link de evidencia</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioenlacedocumento" id="formularioenlacedocumento" method="POST">
                                <div class="col-xl-12">
                                    <label>Link del archivo</label>
                                    <input type="hidden" id="id_pea_enlace_documento" name="id_pea_enlace_documento">
                                    <input type="text" name="link_archivo_documento" id="link_archivo_documento" class="form-control" required></input>
                                </div>
                                <div class="col-xl-12">
                                    <label>Comentario</label>
                                    <textarea name="comentario_enlace_documento" id="comentario_enlace_documento" required maxlength="98" class="form-control" rows="5"></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <button class="btn btn-primary btn-block" type="submit" id="btnCrearEnlaceDocumento"><i class="fa fa-save"></i> Enviar al docente </button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="subirdocumentomensaje">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Enviar Mensaje evidencia</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formulariodocumentomensaje" id="formulariodocumentomensaje" method="POST">
                                <div class="col-xl-12">
                                    <label>Respuesta Mensaje (Archivo)</label>
                                    <input type="hidden" id="id_pea_documento_mensaje" name="id_pea_documento_mensaje">
                                    <textarea name="comentario_archivo_mensaje" id="comentario_archivo_mensaje" class="form-control" required></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <button class="btn btn-primary btn-block" type="submit" id="btnCrearDocumentoMensaje"><i class="fa fa-save"></i> Enviar al docente </button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="subirenlacemensaje">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Enviar Mensaje evidencia</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formularioenlacemensaje" id="formularioenlacemensaje" method="POST">
                                <div class="col-xl-12">
                                    <label>Respuesta Mensaje</label>
                                    <input type="hidden" id="id_pea_enlace_mensaje" name="id_pea_enlace_mensaje">
                                    <textarea name="comentario_archivo" id="comentario_archivo" class="form-control" required></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <button class="btn btn-primary btn-block" type="submit" id="btnCrearEnlaceMensaje"><i class="fa fa-save"></i> Enviar al docente </button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="verDocumentoMensajeModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Mensaje Enviado</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <textarea name="comentario_documento_archivo_ver" id="comentario_documento_archivo_ver" class="form-control"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="verEnlaceMensajeModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Mensaje Enviado</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <textarea name="comentario_archivo_ver" id="comentario_archivo_ver" class="form-control"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="informacionDoc">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Información general</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row" id="resultadodoc"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="informacionEnlace">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Información general</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row" id="resultadoEnlace"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="informacionGlosario">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Información general</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row" id="resultadoGlosario"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="subirvideos">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Enviar Taller</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="formulariocrearvideos" id="formulariocrearvideos" method="POST">
                                <input type="hidden" id="id_pea_video" name="id_pea_video">
                                <div class="col-xl-12">
                                    <label>Comentario</label>
                                    <textarea name="comentario_video" id="comentario_video" required maxlength="98" class="form-control" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="archivo_video">Archivo: <small class="text-danger font-weight-bold">Solo se permiten: Excel, PowerPoint, RAR, PDF, Word, ZIP, Jpg, Png, Jpeg</small> </label>
                                    <input type="file" name="archivo_video" class="form-control-file" id="archivo_video" required>
                                    <div id="error_peso" class="badge badge-danger mt-2" style="display: none; white-space: normal;">
                                        El archivo supera el tamaño máximo permitido de 5 MB.
                                    </div>
                                    <div id="error_tipo" class="badge badge-danger mt-2" style="display: none; white-space: normal;">
                                        Tipo de archivo no permitido. Solo se permiten archivos Excel, PowerPoint, RAR, PDF, Word, ZIP, Jpg, Png, Jpeg.
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <button class="btn btn-primary btn-block" type="submit" id="btnCrearVideos"><i class="fa fa-save"></i> Publicar </button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer_estudiante.php';
    $estudiante = isset($_GET["id"]) ? $_GET["id"] : "";
}
ob_end_flush();
?>


<link href='../fullcalendar/css/main.css' rel='stylesheet' />
<script src='../fullcalendar/js/main.js'></script>
<script src='../fullcalendar/locales/es.js'></script>






<script type="text/javascript" src="scripts/estudiante.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>





<?php
if (!empty($estudiante)) {
    $ciclo = $_GET["ciclo"];
    $id_programa = $_GET["id_programa"];
    $grupo = $_GET["grupo"];
    $rspta2 = $estudiante_c->programaacademico($id_programa);
    echo "<script>listar('$estudiante','" . $ciclo . "','$id_programa','$grupo');</script>";
    echo "<script>$('#nombre_programa').html('<div class=line-height-14><h2 class=fs-18>" . $rspta2["original"] . '</h2><h3 class="fs-14 font-weight-lighter">' . $rspta2["nombre"] . "</h3></div>');</script>";
}
?>

<script src="https://www.youtube.com/iframe_api"></script>