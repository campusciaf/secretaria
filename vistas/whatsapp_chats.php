<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 36;
    $submenu = 3601;
    require 'header.php';
    if ($_SESSION['chatwhatsapp'] == 1) {
?>
        <link rel="stylesheet" href="../public/css/estilos_chat.css">
        <style>
            .dataTables_filter{
                height: 20px !important;
            }
        </style>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-6">
                            <h1 class="m-0">Gestión Cliente</h1>
                        </div>
                        <div class="col-xl-6 col-6 pcchat">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión</li>
                            </ol>
                        </div>
                        <div class="col-xl-6 col-6 movilchat d-none">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a onclick="volverlista()" class="btn btn-primary">Volver al listado</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card m-0">
                            <div class="row no-gutters">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 listado_chats" style="height: 83vh; overflow: auto">
                                    <div class="users-container p-0">
                                        <table class="users col-12" id="tblistadousers" style="padding: 0px !important;">
                                            <thead class="">
                                                <tr>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 d-xl-block d-lg-block d-md-block d-none seccion_conversacion">
                                    <div class="col-12 d-flex justify-content-center align-items-center sin_chat_seleccionado mt-4 pt-4">
                                        <div class="text-center sin_chat_seleccionado mt-4 pt-4">
                                            <i class="fab fa-whatsapp-square fa-8x mt-4 pt-4"></i>
                                            <p> Seleciona uno de los chats, una vez hecho, aqui aparecerá la información </p>
                                            <p class="text-center"><small>Tus mensajes personales están cifrados de extremo a extremo.</small></p>
                                        </div>
                                    </div>
                                    <div class="selected-user con_chat_seleccionado p-0">
                                        <div class="user-bar">
                                            <div class="mt-2" style="width: 20%;">
                                                <div class="avatar">
                                                    <img class="imagen_perfil" src=" " alt="Avatar">
                                                </div>
                                                <div class="name ml-1 " style="width:99px;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    <span class="nombre_completo"> </span>
                                                    <br>
                                                    <span class="celular_perfil"> </span>
                                                </div>
                                            </div>
                                            <div class="mt-3 text-right" style="width: 80%;">
                                                <section class="btn-group">
                                                    <!-- Botones con iconos y tooltips -->
                                                    <button type="button" class="btn btn-outline-secondary btn_iniciar_seguimiento" data-toggle="tooltip" title="Iniciar Seguimiento" onclick="ActivarSeguimiento()">
                                                        <i class="fas fa-people-arrows"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-secondary btn_cerrar_seguimiento d-none" data-toggle="tooltip" title="Finalizar Seguimiento" onclick="FinalizarSeguimiento()">
                                                        <i class="fas fa-window-close"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-secondary " data-toggle="tooltip" title="Agregar Tarea">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-secondary btn_redirigir_chat" title="Redirigir" data-toggle="modal" data-target="#modalRedirigirChat">
                                                        <i class="fas fa-share"></i>
                                                    </button>
                                                    <button class="btn btn-outline-secondary " data-toggle="tooltip" title="Privatizar">
                                                        <i class="fas fa-lock"></i>
                                                    </button>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat-container con_chat_seleccionado p-0">
                                   
                                        <ul class=" chat-box chatContainerScroll historial_mensajes p-2" style="height: 72vh; overflow: auto">
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
                                                        <span class="input-group-text pointer border-0 text-secondary rounded-left" onclick="abrirListaEmoji()">
                                                            <i class="fas fa-face-grin" id="smiley"></i>
                                                        </span>
                                                        <div class="emoji-list"></div>
                                                        <button class=" border-0 text-secondary dropdown-toggle opciones_de_subida" type="button" data-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-plus fa-2x"></i>
                                                        </button>
                                                        <div class="dropdown-menu p-2">
                                                            <a class="dropdown-item py-2" href="#" onclick="seleccionarDocumentos()"> <i class="mr-2 fas fa-file-lines "> </i> Documento </a>
                                                            <a class="dropdown-item py-2" href="#" onclick="seleccionarFotoVideo()"> <i class="mr-2 fas fa-images"></i> Fotos y videos</a>
                                                            <a class="dropdown-item py-2" href="#" onclick="ActivarCamara()"> <i class="mr-2 fas fa-camera"></i> Cámara </a>
                                                            <a class="dropdown-item py-2" href="#"> <i class="mr-2 fas fa-bars"></i> Encuesta </a>
                                                            <a class="dropdown-item py-2" href="#" onclick="listarTemplates()"> <i class="mr-2 fas fa-file-invoice"></i> Template </a>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="tipo_mensaje" id="tipo_mensaje" value="text">
                                                    <input type="hidden" name="nombre_template" id="nombre_template">
                                                    <input type="hidden" name="send_numero_celular" id="send_numero_celular">
                                                    <input type="file" name="fileFotoVideo[]" id="fileFotoVideo" class="d-none" accept="image/*, video/*" multiple onchange="MostrarFotosVideo(this)">
                                                    <input type="file" id="fileDocumentos" name="fileDocumentos[]" class="d-none" accept=".txt, .xls, .xlsx, .doc, .docx, .ppt, .pptx, .pdf" multiple onchange="MostrarDocumentos(this)">
                                                    <textarea class="form-control form-control-lg" name="input_mensaje" id="input_mensaje" placeholder="Escribe un mensaje" autocomplete="off" autofocus rows="1"></textarea> 
                                                    <div class="input-group-append bg-transparent rounded-circle">
                                                        <div class="envio_texto d-none">
                                                            <button type="submit" class="send rounded-circle text-secondary">
                                                                <div class="circle">
                                                                    <i class="fas fa-play"></i>
                                                                </div>
                                                            </button>
                                                        </div>
                                                        <div class="envio_audio">
                                                            <button type="button" class="send rounded-circle text-danger" id="btn_cancelar_grabacion" onclick="CancelarGrabacion()">
                                                                <div class="circle">
                                                                    <i class="fas fa-trash ml-0"></i>
                                                                </div>
                                                            </button>
                                                            <span class="recording-text">
                                                                Grabando...
                                                            </span>
                                                            <button type="button" class="send rounded-circle text-secondary" id="btn_empezar_grabacion" onclick="empezarGrabacion()">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
        <div class="modal fade" id="fotoVideoModal" tabindex="-1" role="dialog" aria-labelledby="fotoVideoModalLabel" aria-hidden="true">
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
        <div class="modal fade" id="camaraModal" tabindex="-1" role="dialog" aria-labelledby="camaraModalLabel" aria-hidden="true">
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
                                            <button class="btn btn-success rounded rounded-circle" id="tomarFoto" onclick="CapturarFoto()" style="height:50px; margin-top: -26px;">
                                                <i class="fas fa-camera fa-2x" style="color: white !important;"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="seccion_capturada">
                                        <canvas class="col-12 foto_capturada" id="canvas"></canvas>
                                        <div class="col-12 mt-3">
                                            <button type="button" class="btn btn-success btn-block" onclick="SubirFotoVideo()"> <i class="fas fa-upload"></i> Subir </button>
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
        <div class="modal fade" id="DocumentosModal" tabindex="-1" role="dialog" aria-labelledby="DocumentosModalLabel" aria-hidden="true">
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
                                    <button class="btn btn-success btn-block" type="submit"> <i class="fas fa-redo"></i> Redigir </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="modalTareas">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Tareas </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="container">
                            <?php require_once "segui_tareas.php"; ?>
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
}
ob_end_flush();
?>
<script src="scripts/whatsapp_chats.js?<?= date("Y-m-d H:i:s") ?>"></script>
<script src="scripts/segui_tareas.js?<?= date("Y-m-d H:i:s") ?>"></script>
<style>
    .bg-navy {
        color: white !important;
    }
</style>