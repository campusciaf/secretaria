<link rel="stylesheet" href="../public/css/estilos_chat.css">
<div class="selected-user con_chat_seleccionado p-0">
    <div class="row user-bar">
        <div class="col-xl-4 col-lg-4 col-md-5 col-5 mt-2">
            <div class="avatar">
                <img class="imagen_perfil" src=" " alt="Avatar">
            </div>
            <div class="name ml-1 pointer" title="Ver más" data-toggle="modal" data-target="#modalInformacionEstudiante" style="width:99px;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <span class="nombre_completo"> </span>
                <br>
                <span class="celular_perfil"> </span>
            </div>
        </div>
        <div class="col-xl-8 col-lg-8 col-md-7 col-7 mt-3 text-right ">
            <section class="btn-group">
                <!-- Botones con iconos y tooltips -->
                <button type="button" class="btn btn-outline-secondary btn_iniciar_seguimiento" data-toggle="tooltip"
                    title="Iniciar Seguimiento" onclick="ActivarSeguimiento()">
                    <i class="fas fa-people-arrows"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary btn_cerrar_seguimiento d-none"
                    data-toggle="tooltip" title="Finalizar Seguimiento" onclick="FinalizarSeguimiento()">
                    <i class="fas fa-window-close"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary btn_marcar_leido"
                    data-toggle="tooltip" title="Marcar como leido" onclick="MarcarComoLeido()">
                    <i class="fas fa-check-double"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary btn_agregar_tarea" data-toggle="tooltip" title="Agregar Tarea">
                    <i class="fas fa-plus"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary btn_redirigir_chat" title="Redirigir"
                    data-toggle="modal" data-target="#modalRedirigirChat">
                    <i class="fas fa-share"></i>
                </button>
                <button class="btn btn-outline-secondary " data-toggle="tooltip" title="Privatizar">
                    <i class="fas fa-lock"></i>
                </button>
            </section>
        </div>
    </div>
</div>
<div class="chat-container con_chat_seleccionado p-0" style="height: 75vh;">
    <ul class=" chat-box chatContainerScroll historial_mensajes p-2" style="height: 93%; overflow:auto">
    </ul>
    <div id="formas_de_envio">
        <div id="iniciar_chat_template" class=" mt-1 mb-1 ml-2">
            <button class="col-12 btn btn-info" onclick="listarTemplates()">
                Iniciar Conversación
            </button>
        </div>
        <form action="#" method="POST" id="send_message_ciaf" class=" mt-1 mb-1 ml-2">
            <div class="input-group">
                <div class="input-group-append">
                    <span class="input-group-text pointer border-0 text-secondary rounded-left"
                        onclick="abrirListaEmoji()">
                        <i class="fas fa-face-grin" id="smiley"></i>
                    </span>
                    <div class="emoji-list"></div>
                    <button class=" border-0 text-secondary dropdown-toggle opciones_de_subida" type="button"
                        data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-plus fa-2x"></i>
                    </button>
                    <div class="dropdown-menu p-2">
                        <a class="dropdown-item py-2" href="#" onclick="seleccionarDocumentos()"> <i
                                class="mr-2 fas fa-file-lines "> </i> Documento </a>
                        <a class="dropdown-item py-2" href="#" onclick="seleccionarFotoVideo()"> <i
                                class="mr-2 fas fa-images"></i> Fotos y videos</a>
                        <a class="dropdown-item py-2" href="#" onclick="ActivarCamara()"> <i
                                class="mr-2 fas fa-camera"></i> Cámara </a>
                        <a class="dropdown-item py-2" href="#"> <i class="mr-2 fas fa-bars"></i> Encuesta </a>
                        <a class="dropdown-item py-2" href="#" onclick="listarTemplates()"> <i
                                class="mr-2 fas fa-file-invoice"></i> Template </a>
                    </div>
                </div>
                <input type="hidden" name="tipo_mensaje" id="tipo_mensaje" value="text">
                <input type="hidden" name="nombre_template" id="nombre_template">
                <input type="hidden" name="send_numero_celular" id="send_numero_celular">
                <input type="hidden" name="variables_template" id="variables_template">
                <input type="file" name="fileFotoVideo[]" id="fileFotoVideo" class="d-none" accept="image/*, video/*"
                    multiple onchange="MostrarFotosVideo(this)">
                <input type="file" id="fileDocumentos" name="fileDocumentos[]" class="d-none"
                    accept=".txt, .xls, .xlsx, .doc, .docx, .ppt, .pptx, .pdf" multiple
                    onchange="MostrarDocumentos(this)">
                <input class="form-control form-control-lg" name="input_mensaje" id="input_mensaje"
                    placeholder="Escribe un mensaje" autocomplete="off" autofocus></input>
                <div class="input-group-append bg-transparent rounded-circle">
                    <div class="envio_texto d-none">
                        <button type="submit" class="send rounded-circle text-secondary">
                            <div class="circle">
                                <i class="fas fa-play"></i>
                            </div>
                        </button>
                    </div>
                    <div class="envio_audio">
                        <button type="button" class="send rounded-circle text-danger" id="btn_cancelar_grabacion"
                            onclick="CancelarGrabacion()">
                            <div class="circle">
                                <i class="fas fa-trash ml-0"></i>
                            </div>
                        </button>
                        <span class="recording-text">
                            Grabando...
                        </span>
                        <button type="button" class="send rounded-circle text-secondary" id="btn_empezar_grabacion"
                            onclick="empezarGrabacion()">
                            <div class="circle">
                                <i class="fas fa-microphone ml-0 icono_grabacion"></i>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="estado_seguimiento" class="text-center mt-2 mb-1 ml-2">
        <div class="badge badge-danger info_estado_seguimiento">
        </div>
    </div>
</div>
<!-- Modal para ver imagenes en tamaño grande -->
<div class="modal" id="modalVerImagenGrande">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <img id="imgGrande" width="100%">
            </div>
        </div>
    </div>
</div>
<!-- Modal Informacion Personal -->
<div class="modal" id="modalInformacionEstudiante">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body p-0">
                <div class="container">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="row">
                        <div class="col-12 InformacionEstudiante">
                            <div class="row my-4">
                                <div class="col-12 text-center">
                                    <img src="../files/null.jpg" width="180px" height="180px" class="img-circle elevation-2 imagen_perfil" alt="Usuario" style="width:180px;height:180px">
                                </div>
                                <div class="col-12 text-center pt-2 font-weight-bolder fs-14 text-dark nombre_completo"> </div>
                                <div class="col-12 text-center text-dark fs-12 text-center mb-1 celular_perfil"></div>
                                <div class="col-12 text-center text-dark fs-12 text-center mb-1" id="info_fecha_nacimiento"></div>
                                <div class="col-12 text-center text-dark fs-12 text-center mb-1" id="info_tipo_documento"></div>
                                <div class="col-12 text-center text-dark fs-12 text-center mb-1" id="info_direccion"></div>
                                <div class="col-12 text-center text-dark fs-12 text-center mb-1" id="info_email"></div>
                                <div class="col-12 text-center text-dark fs-12 text-center mb-1" id="info_email_ciaf"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Plantillas -->
<div class="modal" id="modalTemplates">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title">Plantillas Disponibles</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-0">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <table id="templateList">
                                <thead>
                                    <th></th>
                                    <th> Nombre </th>
                                    <th> Mensaje </th>
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
<!-- Modal para Mostrar Imagenes a enviar -->
<div class="modal fade" id="fotoVideoModal" tabindex="-1" role="dialog" aria-labelledby="fotoVideoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm " role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="modal-title"> Previsualización </h3>
                            <div class="col-12" id="fotoVideoPreview" style="height: 360px;">
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="button" class="btn btn-success btn-block" onclick="SubirFotoVideo()">
                                <i class="fas fa-upload"></i>
                                Subir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal para tomar Foto -->
<div class="modal fade" id="camaraModal" tabindex="-1" role="dialog" aria-labelledby="camaraModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body m-0" id="camaraPreview">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="modal-title">Tomar Foto</h3>
                            <div class="seccion_captura">
                                <video id="seccion_camara" autoplay width="100%"></video>
                                <div class="col-12 text-center">
                                    <button class="btn btn-success rounded rounded-circle" id="tomarFoto"
                                        onclick="CapturarFoto()" style="height:50px; margin-top: -26px;">
                                        <i class="fas fa-camera fa-2x" style="color: white !important;"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="seccion_capturada">
                                <canvas class="col-12 foto_capturada" id="canvas"></canvas>
                                <div class="col-12 mt-3">
                                    <button type="button" class="btn btn-success btn-block" onclick="SubirFotoVideo()">
                                        <i class="fas fa-upload"></i> Subir </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal para Mostrar Documentos -->
<div class="modal fade" id="DocumentosModal" tabindex="-1" role="dialog" aria-labelledby="DocumentosModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body ">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="modal-title">Subir Documentos</h3>
                            <div class="list-group" id="DocumentosPreview">
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="button" class="btn btn-success btn-block" onclick="SubirDocumentos()">
                                <i class="fas fa-upload"></i>
                                Subir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal De redirección -->
<div class="modal" id="modalRedirigirChat">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title"> Redirigir chat </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-0">
                <div class="container">
                    <form action="#" method="POST" id="formularioRedirigirChat" class="row">
                        <div class="col-12">
                            <select class="form-control" name="dependencias" id="dependencias" required>
                            </select>
                        </div>
                        <div class="col-12 mt-3">
                            <button class="btn btn-success btn-block" type="submit"> <i class="fas fa-redo"></i> Redigir
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal De tareas -->
<div class="modal" id="modalTareas">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title">Tareas </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-0">
                <div class="container">
                    <?php require_once "segui_tareas.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="scripts/segui_tareas.js"></script>
<style>
    .bg-navy {
        color: white !important;
    }
</style>