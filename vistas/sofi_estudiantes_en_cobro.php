<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 23;
    $submenu = 2326;
    require 'header.php';
    if ($_SESSION['sofi_estudiantes_en_cobro'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content p-0">
                <div class="row p-0 m-0">
                    <div class="col-12 p-0 m-0 migas pb-2 pt-3 pl-4 ml-0 mr-0 mt-2">
                        <h1 class="m-0 titulo-4"> Estudiantes en cobro </h1>
                    </div>
                </div>
            </div>
            <section class="contenido ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="row" id="tablaregistros">
                                <div class="col-sm-12">
                                    <table id="tabla_estudiantes_en_cobro" class="table table-hover search_cuota">
                                        <thead>
                                            <th> Cédula </th>
                                            <th> Consecutivo </th>
                                            <th> Estudiante </th>
                                            <th> Correo </th>
                                            <th> Celular </th>
                                            <th> Deuda </th>
                                            <th> Incio </th>
                                            <th> Fin </th>
                                            <th> Periodo </th>
                                            <th> Referencia </th>
                                            <th> Contacto </th>
                                            <th> En cobro </th>
                                        </thead>
                                        <tbody>
                                            <th colspan="11">
                                                <div class='jumbotron text-center bg-green' style="margin:0px !important">
                                                    <div class='jumbotron text-center bg-green' style="margin:0px !important">
                                                        <h3>Aquí aparecerán los datos.</h3>
                                                    </div>
                                                </div>
                                            </th>
                                        </tbody>
                                    </table>
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
<script src="scripts/sofi_estudiantes_en_cobro.js?<?= date("Y-m-d-h-i-s") ?>"></script>