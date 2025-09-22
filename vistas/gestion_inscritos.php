<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"]) || $_SESSION["roll"] != "Funcionario"){
    header("Location: ../");
} else {
    $menu = 32;
    $submenu = 322;
    require 'header.php';
    if ($_SESSION['gestioninscritos'] == 1) {
?>
        <div id="precarga" class="precarga" style="display: none;"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><small id="nombre_programa"></small> Gestión inscritos <!-- <button class="btn btn-success btn-xs" onclick="mostrar_form(true)"> <i class="fas fa-plus"></i> Agregar </button> --></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#"> Inicio </a></li>
                                <li class="breadcrumb-item active"> Gestión Inscritos </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="row card card-primary" style="padding: 2% 1%">
                        <div id="listadoregistros" class="col-12">
                            <table id="tbllistado" class="table table-condensed table-hover">
                                <thead>
                                    <th></th>
                                    <th> Nombre completo</th>
                                    <th> Curso</th>
                                    <th> Roll</th>
                                    <th> Estado </th>
                                    <th> Pago</th>
                                    <th> Fecha inscripción</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div id="div_formulario" class="col-12">
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
<script src="scripts/gestion_inscritos.js"></script>
<style>
    .daterangepicker .calendar-table {
        border: 1px solid #fff;
        border-radius: 4px;
        background-color: #454d55 !important;
    }
</style>