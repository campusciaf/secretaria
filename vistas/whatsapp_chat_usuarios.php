<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 36;
    $submenu = 3606;
    require 'header.php';
    if ($_SESSION['whatsapp_mis_activos'] == 1) {
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
                                        <div class="col-12">
                                            <div class="form-group my-3 position-relative check-valid">
                                                <div class="form-floating">
                                                    <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="usuario" id="usuario" onchange="listarChats(this.value)">
                                                    </select>
                                                    <label>Usuario</label>
                                                </div>
                                            </div>
                                        </div>
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
<script src="scripts/whatsapp_chat_usuarios.js?<?= date("Y-m-d-h-i-s") ?>"></script>
<script src="scripts/whatsapp_module.js?<?= date("Y-m-d-h-i-s") ?>"></script>