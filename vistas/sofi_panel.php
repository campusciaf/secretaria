<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $periodo_actual = $_SESSION["periodo_actual"];
    $anio = substr($periodo_actual, 0, -2);
    $anioanterior = $anio - 1;
    $lastChar = substr($periodo_actual, -1);
    $periodo_comparado = $anioanterior . "-" . $lastChar;
    $_SESSION["periodo_comparado"] = $periodo_comparado;
    $menu = 23;
    $submenu = 2301;
    require 'header.php';
    if ($_SESSION['sofipanel'] == 1) {
?>
        <link rel="stylesheet" href="../public/css/morris.css">
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Panel SOFI</span><br>
                                <span class="fs-14 f-montserrat-regular">visualiza paneles de control, de un vistazo y accede a un sistema de CRM solido. </span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas mb-0">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Panel</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container-fluid px-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row estadisticas">
                            <a href="sofi_financiados.php?estado=Aprobado" class="col-xl-6 col-lg-4 py-3 col-md-4 col-12 pl-4">
                                <h5 class="fw-light mb-4 text-secondary pl-4">Total Aprobados,</h5>
                                <h1 class="titulo-2 fs-36 pl-4 text-semibold">
                                    <span class="total_Aprobado_actual"></span>
                                    <small class="fs-18">Creditos</small>
                                </h1>
                                <h5 class="pl-4 titulo-2 fs-18 text-semibold" data-toggle="tooltip" data-placement="top" title="Periodo Comparado">
                                    <span class="total_Aprobado_comparado"></span>
                                    <small class="text-success porcentaje_entre_anios"> </small>
                                </h5>
                            </a>
                            <div class="col-xl-6 col-lg-8 col-md-8 col-12">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-3 mnw-100 text-center pt-4">
                                        <a href="sofi_financiados.php">
                                            <i class="fa-solid fa-trophy avatar avatar-50 bg-light-yellow text-yellow rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
                                            <h4 class="titulo-2 fs-18 mb-0 total_Pendiente_actual line-height-18"> --- </h4>
                                            <p class="small text-secondary">Solicitudes<br>Pendientes</p>
                                        </a>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-3 mnw-100 text-center pt-4">
                                        <a href="sofi_cuotas_vencidas.php">
                                            <i class="fa-solid fa-triangle-exclamation avatar avatar-50 bg-light-orange text-orange rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
                                            <h4 class="titulo-2 fs-18 mb-0 countCuotasvencidas line-height-18"> --- </h4>
                                            <p class="small text-secondary">Cuotas <br>Vencidas</p>
                                        </a>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-3 mnw-100 text-center pt-4">
                                        <a href="sofi_cuotas_a_vencer.php">
                                            <i class="fa-solid fa-bullhorn avatar avatar-50 bg-light-orange text-orange rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
                                            <h4 class="titulo-2 fs-18 mb-0 countCuotasavencer line-height-18"> --- </h4>
                                            <p class="small text-secondary">Cuotas a <br>Vencer</p>
                                        </a>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-3 mnw-100 text-center pt-4">
                                        <a href="sofi_atrasados.php">
                                            <i class="fa-solid fa-triangle-exclamation avatar bg-light-red text-danger rounded-circle mb-2 fa-2x" aria-hidden="true"></i>
                                            <h4 class="titulo-2 fs-18 mb-0 atrasados line-height-18">Matriculado</h4>
                                            <p class="small text-secondary ">Atrasadas<br>General</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xxl-3">
                                <div class="rounded mb-4 bg-radial-blue text-white">
                                    <div class="card-body bg-none">
                                        <a href="sofi_interes_mora.php" class="row align-items-center text-white">
                                            <div class="col-auto">
                                                <div class="avatar bg-light-white rounded-circle">
                                                    <i class="fa-solid fa-percent"></i>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <p class="fs-12 mb-1">Tasa de interes actual</p>
                                                <h5><span class="percentMora">--</span><small>%</small></h5>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xxl-3">
                                <div class="rounded mb-4 bg-radial-green text-white">
                                    <div class="card-body bg-none">
                                        <a href="sofi_recaudo_dia.php" class="row align-items-center text-white">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar bg-light-white rounded-circle">
                                                        <i class="fa-solid fa-dollar-sign"></i>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <p class="fs-12 mb-1">Recuado del día</p>
                                                    <h5><span class="RecaudadoHoy">0</span><small> COP </small></h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xxl-3">
                                <div class="rounded mb-4 bg-radial-red text-white">
                                    <div class="card-body bg-none">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar bg-light-white rounded-circle">
                                                    <i class="fa-solid fa-dollar-sign"></i>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <p class="fs-12 mb-1">Dinero por recaudar del día</p>
                                                <h5><span class="NoRecaudadoHoy">0</span><small> COP </small></h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="dropdown d-inline-block dropleft">
                                                    <a class="text-white pointer" data-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end mt-4 p-2">
                                                        <li><a class="dropdown-item rounded" href="sofi_interes_mora.php">Editar</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xxl-3">
                                <div class="rounded mb-4 bg-radial-yellow text-white">
                                    <div class="card-body bg-none">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar bg-light-white rounded-circle">
                                                    <i class="fa-solid fa-percent"></i>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <p class="fs-12 mb-1">Cartera a hoy</p>
                                                <h5><span class="porcentaje_avance_cartera"></span><small>%</small></h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="dropdown d-inline-block dropleft">
                                                    <a class="text-white pointer" data-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end mt-4 p-2">
                                                        <li><a class="dropdown-item rounded" href="sofi_interes_mora.php">Editar</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!----------------DONUTS BAR DE LOS FINANCIAMIENTOS ------------------------------->
                            <div class="col-xl-5 col-lg-5 col-md-6 col-12 p-4">
                                <div class="row">
                                    <div class="col-12 card">
                                        <div class="row">
                                            <div class="col-12 py-4 tono-3">
                                                <div class="row align-items-center">
                                                    <div class="pl-2">
                                                        <span class="rounded bg-light-green p-3 text-success">
                                                            <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                                        </span>

                                                    </div>
                                                    <div class="col-10">
                                                        <div class="col-5 fs-14 line-height-18">
                                                            <span class="titulo-2 fs-14 line-height-16">Estadisticas</span> <br>
                                                            <span class="text-semibold fs-20"><?= $periodo_actual ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 pt-4">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h5 class="titulo-2 fs-24 "><span class="total_Aprobado_actual"></span> <small class="fs-12 fw-light text-green">Aprobadas</small></h5>
                                                    </div>
                                                    <div class="col-auto">
                                                        <p class="text-secondary fs-14"><span class="total_solicitudes_actual"></span> Solicitudes</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="progress rounded" style="height:30px">
                                                    <div class="progress-bar bg-success porcentaje_Aprobado_actual" title="Aprobados" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-red porcentaje_Anulado_actual" title="Anulados" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-yellow porcentaje_Pendiente_actual" title="Pendientes" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-primary porcentaje_Pre_Aprobado_actual" title="Pre_aprobados" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 py-4">
                                                <p class="text-secondary titulo-2 fs-12 d-inline-block"><span class="avatar avatar-10 bg-success m-1"></span>Aprobados</p>
                                                <p class="text-secondary titulo-2 fs-12 d-inline-block"><span class="avatar avatar-10 bg-red m-1"></span>Anulados</p>
                                                <p class="text-secondary titulo-2 fs-12 d-inline-block"><span class="avatar avatar-10 bg-yellow m-1"></span>Pendientes</p>
                                                <p class="text-secondary titulo-2 fs-12 d-inline-block"><span class="avatar avatar-10 bg-primary m-1"></span>Pre_aprobados</p>
                                            </div>
                                            <div class="col-12 ">
                                                <div id="barchart_estadistica_actual" style="margin-bottom:300px"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-6 col-12 p-4">
                                <div class="row">
                                    <div class="card col-12">
                                        <div class="row">
                                            <div class="col-12 py-4 tono-3">
                                                <div class="row align-items-center">
                                                    <div class="pl-2">
                                                        <span class="rounded bg-light-blue p-3 text-primary ">
                                                            <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="col-5 fs-14 line-height-18">
                                                            <span class="titulo-2 fs-14 line-height-16">Estadisticas</span> <br>
                                                            <span class="text-semibold fs-20"><?= $periodo_comparado ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 pt-4">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h5 class="titulo-2 fs-24"><span class="total_Aprobado_comparado"></span> <small class="fs-12 fw-light text-green">Aprobadas</small></h5>
                                                    </div>
                                                    <div class="col-auto">
                                                        <p class="text-secondary fs-14"><span class="total_solicitudes_comparado"></span> Solicitudes</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="progress rounded" style="height:30px">
                                                    <div class="progress-bar bg-success porcentaje_Aprobado_comparado" title="Aprobados" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-red porcentaje_Anulado_comparado" title="Anulados" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-yellow porcentaje_Pendiente_comparado" title="Pendientes" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-primary porcentaje_Pre_Aprobado_comparado" title="Pre_aprobados" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 py-4">
                                                <p class="text-secondary titulo-2 fs-12 d-inline-block"><span class="avatar avatar-10 bg-success m-1"></span>Aprobados</p>
                                                <p class="text-secondary titulo-2 fs-12 d-inline-block"><span class="avatar avatar-10 bg-red m-1"></span>Anulados</p>
                                                <p class="text-secondary titulo-2 fs-12 d-inline-block"><span class="avatar avatar-10 bg-yellow m-1"></span>Pendientes</p>
                                                <p class="text-secondary titulo-2 fs-12 d-inline-block"><span class="avatar avatar-10 bg-primary m-1"></span>Pre_aprobados</p>
                                            </div>
                                            <div class="col-12">
                                                <div id="barchart_estadistica_comparado" style="margin-bottom:300px"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-2 col-lg-2 col-xxl-2 pt-4">
                                <div class="col-12 p-0">
                                    <div class="rounded mb-4 bg-radial-purple text-white">
                                        <div class="card-body bg-none">
                                            <div class="row align-items-center text-center">
                                                <div class="col">
                                                    <div class="avatar bg-light-white rounded-circle">
                                                        <i class="fa-solid fa-percent"></i>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <p class="fs-12 mb-1">Avance cartera</p>
                                                    <h5><span class="porcentaje_avance_cartera"></span><small>%</small></h5>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 p-0">
                                    <div class="rounded mb-4 bg-radial-orange text-white">
                                        <div class="card-body bg-none">
                                            <div class="row align-items-center text-center">
                                                <div class="col">
                                                    <div class="avatar bg-light-white rounded-circle">
                                                        17
                                                        <i class="fa-solid fa-percent"></i>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <p class="fs-12 mb-1">No recaudado a hoy </p>
                                                    <h6><span class="NoRecaudadoTotal"> 0 </span> <small> COP</small></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 p-0">
                                    <div class="card col-12 pt-2">
                                        <div class="row">
                                            <div class="col-12 pt-2 ">
                                                <div class="small text-regular">Categoria</div>
                                                <div class="fs-20">Clientes</div>
                                            </div>
                                            <div class="col-12 pb-1">
                                                <hr class="m-0">
                                            </div>
                                            <div class="col-6">
                                                <p class="text-secondary small mb-0">Categoria A</p>
                                                <p class="pointer" id="total_categoria_a" title="Categoria A">0</p>
                                            </div>
                                            <div class="col-6 text-right">
                                                <p class="text-secondary small mb-0">Categoria B</p>
                                                <p class="pointer" id="total_categoria_b" title="Ver Estudiantes">1</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="text-secondary small mb-0">Categoria C</p>
                                                <p class=" pointer" id="total_categoria_c" title="Ver Estudiantes">1</p>
                                            </div>
                                            <div class="col-6 text-right">
                                                <p class="text-secondary small mb-0">Categoria D</p>
                                                <p class="pointer" id="total_categoria_d">0</p>
                                            </div>
                                            <div class="col-6 text-center">
                                                <p class="text-secondary small mb-0">Categoria E</p>
                                                <p class="mb-0 pointer" id="total_categoria_e">0</p>
                                            </div>
                                            <div class="col-6 text-center">
                                                <p class="text-secondary small mb-0">No Categoria </p>
                                                <p class="mb-0 pointer" id="total_sin_categoria">0</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-------------BAR CHAR - CANTIDAD RECAUDO Y CARTERA-------------------->
                            <!---------------- PROYECCION ESTADISTICA ------------------->
                            <div class="col-12 text-center pt-4 my-4">
                                <h3 class="titulo-3 text-bold fs-24">Visualice <span class="text-gradient">el crecimiento y la tendencia</span> de <span class="text-gradient">cartera</span></h3>
                                <p class="lead text-secondary">Grafica usada para visualizar la proyección estadística en tiempo real por mes.</p>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-12 card">
                                        <div class="row">
                                            <div class="col-12 py-4 tono-3">
                                                <div class="row align-items-center">
                                                    <div class="col-12" style="margin-bottom:300px">
                                                        <div class="col-12 ">
                                                            <h6 class="title fs-20 titulo-2 text-bold">Proyección Estadística</h6>
                                                        </div>
                                                        <div id="estadistica_periodica" class=""></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3 d-none">
                                    <div class="row">
                                        <div class="col-12 py-4 tono-3">
                                            <div class="row align-items-center">
                                                <div class="pl-2">
                                                    <span class="rounded bg-light-blue p-2 text-primary ">
                                                        <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                                <div class="col-10">
                                                    <div class="col-5 fs-14 line-height-18">
                                                        <span class="titulo-2 fs-14 line-height-16">Cartera</span> <br>
                                                        <span class="text-semibold fs-14">Recaudada</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 py-4 tono-3">
                                            <div class="row align-items-center">
                                                <div class="pl-2">
                                                    <span class="rounded bg-light-blue p-2 text-primary ">
                                                        <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                                    </span>

                                                </div>
                                                <div class="col-10">
                                                    <div class="col-5 fs-14 line-height-18">
                                                        <span class="titulo-2 fs-14 line-height-16">Cartera</span> <br>
                                                        <span class="text-semibold fs-14">Por recaudar</span>
                                                    </div>
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
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script src="scripts/sofi_panel.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>