<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 1;
    $submenu = 9;
    require 'header.php';
    if ($_SESSION['restaurarcontrasena'] == 1) {
?>
    <div id="precarga" class="precarga"></div>
    <div class="content-wrapper ">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-xl-6 col-9">
                        <h2 class="m-0 line-height-16">
                            <span class="titulo-2 fs-18 text-semibold">Gestión de claves</span><br>
                            <span class="fs-16 f-montserrat-regular">Puedes restablecer la clave(Estudiante,Funcionario,Docente).</span>
                        </h2>
                    </div>
                    <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                        <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                    </div>
                    <div class="col-12 migas">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Restaurar cuenta</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="container-fluid px-4 py-2">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-11 p-3 card">
                    <div class="row ">
                        <input type="hidden" value="" name="tipo" id="tipo">
                        <div class="col-12">
                            <h3 class="titulo-2 fs-14">Restaurar Cuenta</h3>
                        </div>
                        <div class="col-12 mb-4">

                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="">
                                        <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true" onclick="filtroportipo(1)">Identificación</a>
                                    </li>
                          
                                <li class="">
                                    <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true" onclick="filtroportipo(2)">Correo</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-8 m-0 p-0">
                            <div class="form-group mb-3 position-relative check-valid" >
                                <div class="form-floating" >
                                    <select value=""  required class="form-control border-start-0 selectpicker" data-live-search="true" name="ubicacion" id="ubicacion" disabled>
                                        <option value="1">Estudiante</option>
                                        <option value="2">Docentes</option>
                                        <option value="3">Funcionarios</option>
                                    </select>
                                    <label>Usuario</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        

                        <div class="col-xl-6 col-lg-12 col-md-12 col-12 p-0 "  id="input_dato_estudiante">
                                <div class="form-group position-relative check-valid m-0">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" class="form-control border-start-0" name="dato_estudiante" id="dato_estudiante" required disabled>
                                        <label id="valortituloestudiante">Seleccionar tipo de busqueda</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            
                        </div>
                        <div class="col-xl-2 p-0">
                            <input type="submit" value="Buscar" onclick="consultaEstudiante()" class="btn btn-success py-3 btn-block" disabled id="btnconsulta" />
                        </div>
                      

                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-11" id="mostrar_datos_estudiante">
                    <div class="container">
                        <div class="row ">
                            <div class="col-sm">
                                <div class="px-2 pb-2">
                                    <div class="row align-items-center">
                                        <div class="col-xl-1 col-lg-2 col-md-2 col-2">
                                            <span class="rounded bg-light-blue p-2 text-primary ">
                                                <i class="fa-solid fa-user-slash"></i>
                                            </span>
                                        </div>
                                        <div class="col-10">
                                            <span class="">Nombre:</span> <br>
                                            <span class="text-semibold fs-12 box_nombre_estudiante">-
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-2 pb-2">
                                    <div class="row align-items-center">
                                        <div class="col-xl-1 col-lg-2 col-md-2 col-2">
                                            <span class="rounded bg-light-red p-2 text-danger">
                                                <i class="fa-regular fa-envelope"></i>
                                            </span>
                                        </div>
                                        <div class="col-10">
                                            <span class="">Correo electrónico</span> <br>
                                            <span class="text-semibold fs-12 box_correo_electronico">-</span>
                                        </div>
                                    </div>
                                </div>

                                <div class='form-group col-xl-6 col-lg-12 col-md-12 col-12 mt-3'>
                                    <div class='form-check'>
                                        <input class='form-check-input' type='checkbox' value='' id='enviar_correo'>
                                        <label class='form-check-label text-danger' for='enviar_correo'>
                                            <b> Enviar notificación al correo del cambio de contraseña </b>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-12 col-md-12 col-12 px-2 pb-2">
                                    <button type='submit' id="btnRestablecer" name='desactivar' class='btn btn-success btn-block' onclick=restablecer()> Restablecer contraseña </button>
                                </div>
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
<script type="text/javascript" src="scripts/restaurar_contrasena.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>