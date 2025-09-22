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
        $menu = 13;
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
                            <span class="titulo-2 fs-18 text-semibold">Docentes - Billetera Virtual </span><br>
                            <span class="fs-14 f-montserrat-regular">Motivando la creatividad</span>
                        </h2>
                    </div>
                    <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                        <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        <button class="btn btn-sm btn-outline-warning px-2 py-0 d-none segundo_tour" onclick='iniciarSegundoTour()'><i class="fa-solid fa-play"></i> Tour 2da parte</button>
                    </div>
                    <div class="col-12 migas mb-0">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="panel_docente.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Asigna puntos a nuestros seres creativos </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="container-fluid px-4 py-2">
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-12 col-md-9 col-lg-8 col-xl-7 card p-2">
                    <div class="row">
                        <form action="#" method="POST" id="formularioBusquedaEstudiante" class="col-12 col-sm-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
                            <div class="input-group">
                                <div class="form-floating">
                                    <input type="text" placeholder="" required class="form-control rounded-left " name="documento_estudiante" id="documento_estudiante">
                                    <label for="documento_estudiante"> Ingrese Número Documento </label>
                                </div>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-success" id="btnBusquedaEstudiante">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-8 mt-3" id="mostrar_datos_estudiante">
                            <div class="col-12 mx-auto">
                                <div class="px-2 pb-2">
                                    <div class="row align-items-center">
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-2 text-right">
                                            <span class="rounded bg-light-blue p-2 text-primary ">
                                                <i class="fa-solid fa-user-slash"></i>
                                            </span>
                                        </div>
                                        <div class="col-10">
                                            <span class="">Nombre: </span> <br>
                                            <span class="text-semibold fs-12 box_nombre_estudiante"> -
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-2 pb-2">
                                    <div class="row align-items-center">
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-2 text-right">
                                            <span class="rounded bg-light-red p-2 text-danger">
                                                <i class="fa-regular fa-envelope"></i>
                                            </span>
                                        </div>
                                        <div class="col-10">
                                            <span class="">Correo Electrónico: </span> <br>
                                            <span class="text-semibold fs-12 box_correo_electronico">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="#" method="POST" id="formularioInsercionPuntos" class="col-12">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-12 px-2 pb-2 mt-2">
                                    <div class="form-group position-relative check-valid m-0">
                                        <div class="form-floating">
                                            <input type="text" placeholder="" required class="form-control border-start-0" name="nombre_estudiante" id="nombre_estudiante"/>
                                            <label for="nombre_estudiante"> Nombre Estudiante: </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-12 px-2 pb-2 mt-2">
                                    <div class="form-group position-relative check-valid m-0">
                                        <div class="form-floating">
                                            <select type="text" placeholder="" required class="form-control border-start-0" name="punto_nombre" id="punto_nombre">
                                            </select>
                                            <label for="punto_nombre"> Nombre De Punto: </label>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-xl-4 col-lg-4 col-md-4 col-12 px-2 pb-2 mt-2">
                                    <div class="form-group position-relative check-valid m-0">
                                        <div class="form-floating">
                                            <input type="number" placeholder="" required class="form-control border-start-0" name="punto_maximo" id="punto_maximo" />
                                            <label for="punto_maximo">Nro. Puntos Maximos</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-12 px-2 pb-2 mt-3">
                                    <input type="hidden" name="id_credencial" id="id_credencial_puntos">
                                    <input type="hidden" name="es_estudiante" id="es_estudiante">
                                    <button type='submit' id="btnInsercionPuntos" class='btn btn-success btn-block'> Asignar Puntos </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php
    require 'footer_docente.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/puntos_billetera_docente.js?<?= date("Y-m-d-H:i:s") ?>"></script>