<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 36;
    $submenu = 3602;
    require 'header.php';
    if ($_SESSION['whatsapp_dependencia'] == 1) {
?>
        <link rel="stylesheet" href="../public/css/estilos_chat.css">
        <style>
            .dataTables_filter {
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
            <section class="container-fluid">
                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card m-0">
                            <div class="row no-gutters">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 listado_chats" style="height: 83vh; overflow: auto">
                                    <form action="#" method="POST" id="formularioBusqueda" class="input-group mt-3 mb-0 px-2">
                                        <input type="text" class="form-control" placeholder="Cedula, Nombre, apellido, celular.... " aria-label="Ingresa el dato" name="valor_buscado" id="valor_buscado" required>
                                        <div class=" input-group-append">
                                            <button class="btn btn-outline-success" type="submit" id="BotonBusqueda"> <i class="fas fa-search"></i> Buscar </button>
                                        </div>
                                    </form>
                                    <div class="col-12">
                                        <div class="row text-center mt-2">
                                            <div class="col">
                                                <input class="estado_chat" type="radio" id="opcion_todos_chats" name="estado_chat" value="" checked>
                                                <label for="opcion_todos_chats" class=" rounded-pill px-3 py-1 mb-0"> Todos </label>
                                            </div>
                                            <div class="col">
                                                <input class="estado_chat" type="radio" id="opcion_pendientes_chats" name="estado_chat" value="Pendientes">
                                                <label for="opcion_pendientes_chats" class=" rounded-pill px-3 py-1 mb-0"> Pendientes </label>
                                            </div>
                                            <div class="col">
                                                <input class="estado_chat" type="radio" id="opcion_leidos_chats" name="estado_chat" value="Leidos">
                                                <label for="opcion_leidos_chats" class=" rounded-pill px-3 py-1 mb-0"> Leidos </label>
                                            </div>
                                        </div>
                                    </div>
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
                                    <?php require 'whatsapp_module.php'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script src="scripts/whatsapp_dependencia.js"></script>
<script src="scripts/whatsapp_module.js"></script>