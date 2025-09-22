<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 14;
   $submenu = 1426;
   require 'header.php';

   if ($_SESSION['onpanel'] == 1) {
   ?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Configuración cliente</span><br>
                        <span class="fs-16 f-montserrat-regular">Configure el estado de los clientes</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour " onclick='iniciarTour()'><i
                            class="fa-solid fa-play"></i> Tour</button>
                    <button class="btn btn-sm btn-outline-warning px-2 py-0 d-none segundo_tour"
                        onclick='iniciarSegundoTour()'><i class="fa-solid fa-play"></i> Tour 2da parte</button>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Configuración cliente</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="container-fluid px-4 py-2">
        <div class="row">

            <div id="titulo" class="col-12 "></div>

            <div class="col-4 p-4 card">
                <div class="row" id="t-CL">
                    <input type="hidden" value="" name="tipo" id="tipo">


                    <div class="col-12">
                        <h3 class="titulo-2 fs-14">Buscar cliente por:</h3>
                    </div>
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill"
                                    href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                                    aria-selected="true" onclick="muestra(1)">Identificacion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                                    href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                                    aria-selected="false" onclick="muestra(2)">Caso</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                                    href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages"
                                    aria-selected="false" onclick="muestra(3)">Tel/Celular</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-12 mt-2" id="input_dato">
                        <div class="row">
                            <div class="col-10 m-0 p-0">
                                <div class="form-group position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" class="form-control border-start-0"
                                            name="dato" id="dato" required>
                                        <label id="valortitulo">Seleccionar tipo</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-2 m-0 p-0">

                                <input type="submit" value="Buscar" onclick="consulta()"
                                    class="btn btn-success py-3 btn-block" disabled id="btnconsulta" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-4 borde-right" id="datos_estudiante">
                <div class="col-12 px-2 py-3 " id="t-NC">
                    <div class="row align-items-center">
                        <div class="pl-4">
                            <span class="rounded bg-light-white p-2 text-gray ">
                                <i class="fa-solid fa-user-slash" aria-hidden="true"></i>
                            </span>

                        </div>
                        <div class="col-10">
                            <div class="col-5 fs-14 line-height-18">
                                <span class="">Nombres </span> <br>
                                <span class="text-semibold fs-14">Apellidos </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 px-2 py-2 " id="t-Ce">
                    <div class="row align-items-center">
                        <div class="pl-4">
                            <span class="rounded bg-light-white p-2 text-gray">
                                <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                            </span>

                        </div>
                        <div class="col-10">
                            <div class="col-5 fs-14 line-height-18">
                                <span class="">Correo electrónico</span> <br>
                                <span class="text-semibold fs-14">correo@correo.com</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 px-2 py-2 " id="t-NT">
                    <div class="row align-items-center">
                        <div class="pl-4">
                            <span class="rounded bg-light-white p-2 text-gray">
                                <i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
                            </span>

                        </div>
                        <div class="col-10">
                            <div class="col-5 fs-14 line-height-18">
                                <span class="">Número celular</span> <br>
                                <span class="text-semibold fs-14">+570000000</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-4 " id="panel_detalle">
                <div class="col-12  pt-3">
                    <div class="row" >
                        <div class="col-4 mnw-100 text-center pt-4" id="t2-Cas" >
                            <i class="fa-solid fa-trophy avatar avatar-50 bg-light-white text-gray rounded-circle mb-2 fa-2x"
                                aria-hidden="true"></i>
                            <h4 class="titulo-2 fs-18 mb-0">-----</h4>
                            <p class="small text-secondary">Caso</p>
                        </div>
                        <div class="col-4 mnw-100 text-center pt-4">
                            <i class="fa-solid fa-bullhorn avatar avatar-50 bg-light-white text-gray rounded-circle mb-2 fa-2x"
                                aria-hidden="true"></i>
                            <h4 class="titulo-2 fs-18 mb-0">-----</h4>
                            <p class="small text-secondary">Campaña</p>
                        </div>
                        <div class="col-4 mnw-100 text-center pt-4">
                            <i class="fa-solid fa-user-check avatar avatar-50 bg-light-white text-gray rounded-circle mb-2 fa-2x"
                                aria-hidden="true"></i>
                            <h4 class="titulo-2 fs-18 mb-0">-----</h4>
                            <p class="small text-secondary">Estado</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 datos_table">
                <div class="row mt-4" id="t-TP">
                    <div class="col-12 px-2 py-3 tono-3">
                        <div class="row align-items-center">
                            <div class="pl-4">
                                <span class="rounded bg-light-blue p-2 text-primary ">
                                    <i class="fa-solid fa-table"></i>
                                </span>

                            </div>
                            <div class="col-10">
                                <div class="col-5 fs-14 line-height-18">
                                    <span class="">Programas</span> <br>
                                    <span class="text-semibold fs-14">Matriculados</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 card p-4">

                        <table class="table" id="tbl_datos">
                            <thead>
                                <tr>
                                    <th id="t-Cs">Caso</th>
                                    <th id="t-P">Programa</th>
                                    <th id="t-Jr">Jornada</th>
                                    <th id="t-FI">Fecha ingresa</th>
                                    <th id="t-ME">Medio</th>
                                    <th id="t-ES">Estado</th>
                                    <th id="t-PC">Periodo campaña</th>
                                    <th id="t-AC">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>



                <div class="col-12" id="panel_resultado"></div>

            </div>
    </section>
</div>

<!-- inicio modal historial -->
<!-- The Modal -->
<div class="modal" id="myModalHistorial">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Historial</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row p-4">
                    <div id="historial" class="col-12"></div>

                    <div class="col-12 px-2 py-3 tono-3 mt-4">
                        <div class="row align-items-center">
                            <div class="pl-4">
                                <span class="rounded bg-light-green p-2 text-success ">
                                    <i class="fa-solid fa-table" aria-hidden="true"></i>
                                </span>

                            </div>
                            <div class="col-10">
                                <div class="col-5 fs-14 line-height-18">
                                    <span class="">Resultados</span> <br>
                                    <span class="text-semibold fs-14">Seguimientos</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card col-12 p-4 table-responsive">
                        <table id="tbllistadohistorialpanel" class="table table-hover" width="100%">
                            <thead>
                                <th>Caso</th>
                                <th>Motivo</th>
                                <th>Observaciones</th>
                                <th>Fecha de observación</th>
                                <th>Asesor</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<?php
   } else {
      require 'noacceso.php';
   }

   require 'footer.php';
   ?>

<script type="text/javascript" src="scripts/onpanel.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<script type="text/javascript" src="../public/webcam/js/webcam.min.js"></script>

<?php
}
ob_end_flush();
?>