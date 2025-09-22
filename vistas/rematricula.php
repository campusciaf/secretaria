<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 6;
    $submenu = 1004;
    require 'header_estudiante.php';
    if (!empty($_SESSION['id_usuario'])) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h1 class="titulo-4"><small id="nombre_programa"></small> Renovar Matrícula Académica </h1>
                        </div>
                        <div class="col-sm-6" style="padding: 0px">
                            <ol>
                                <div class="row" style="margin-bottom: 10px; padding-right: 20px;" id="botoncarrito">

                                </div>
                            </ol>
                        </div>
                        <div class="col-12">
                            <table id="tbllistado" class="table table-hovered" style="width:100%">
                                <thead>
                                    <th> Acciones </th>
                                    <th> Programa </th>
                                    <th> Jornada </th>
                                    <th> Semestre </th>
                                    <th> Estado </th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="col">
                                <img src="../public/img/imagen_renovacion_academica.png" class="img-fluid" alt="CIAF Logo" width="100%">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row" id="listadomaterias"></div>
                        </div>
                        <div id="carrito" class="carrito card col-12" style="border-left:0px solid #000"></div>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer_estudiante.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/rematricula.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>