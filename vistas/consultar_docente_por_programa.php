<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 6;
    $submenu = 613;
    require 'header.php';
    if ($_SESSION['consultar_docente_por_programa'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Consulta Docente Programa</span><br>
                                <span class="fs-16 f-montserrat-regular">Consulta los docentes por programa.</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Consulta Docente Programa</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row">
                            <div class="col-12 card">
                                <div class="row">
                                    <div class="col-6 p-4 tono-3">
                                        <div class="row align-items-center">
                                            <div class="pl-3">
                                                <span class="rounded bg-light-blue p-3 text-primary ">
                                                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                            <div class="col-10">
                                                <div class="col-5 fs-14 line-height-18">
                                                    <span class="">Consulta Docente Programa</span> <br>
                                                    <span class="text-semibold fs-20">Campus virtual</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 tono-3 text-right py-4 pr-4">
                                    </div>
                                    <div class="col-12 pl-4 mb-2">
                                        <div class="row">
                                            <div style="width:170px">
                                                <a onclick="listarprogramaconsultados(1)" title="ver cifras" class="row pointer m-2">
                                                    <div class="col-3 rounded bg-light-red">
                                                        <div class="text-red text-center pt-1">
                                                            <i class="fa-regular fa-calendar-check fa-2x  text-red" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-9 borde">
                                                        <span>Programa de</span><br>
                                                        <span class="titulo-2 fs-12 line-height-16"> Administración</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div style="width:170px">
                                                <a onclick="listarprogramaconsultados(6)" title="ver cifras" class="row pointer m-2">
                                                    <div class="col-3 rounded bg-light-purple">
                                                        <div class="text-red text-center pt-1">
                                                            <i class="fa-regular fa-calendar-check fa-2x  text-purple" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-9 borde">
                                                        <span>Programa de</span><br>
                                                        <span class="titulo-2 fs-12 line-height-16"> Contaduría</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div style="width:170px">
                                                <a onclick="listarprogramaconsultados(3)" title="ver cifras" class="row pointer m-2">
                                                    <div class="col-3 rounded bg-light-green">
                                                        <div class="text-red text-center pt-1">
                                                            <i class="fa-regular fa-calendar-check fa-2x  text-green" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-9 borde">
                                                        <span>Programa de</span><br>
                                                        <span class="titulo-2 fs-12 line-height-16"> SST</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div style="width:170px">
                                                <a onclick="listarprogramaconsultados(2)" title="ver cifras" class="row pointer m-2">
                                                    <div class="col-3 rounded bg-light-blue">
                                                        <div class="text-red text-center pt-1">
                                                            <i class="fa-regular fa-calendar-check fa-2x  text-blue" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-9 borde">
                                                        <span>Programa de</span><br>
                                                        <span class="titulo-2 fs-12 line-height-16"> Ingenieria</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div style="width:170px">
                                                <a onclick="listarprogramaconsultados(5)" title="ver cifras" class="row pointer m-2">
                                                    <div class="col-3 rounded bg-light-orange">
                                                        <div class="text-red text-center pt-1">
                                                            <i class="fa-regular fa-calendar-check fa-2x  text-orange" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-9 borde">
                                                        <span>Programa de</span><br>
                                                        <span class="titulo-2 fs-12 line-height-16"> Industrial</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div style="width:170px">
                                                <a onclick="listarprogramaconsultados(7)" title="ver cifras" class="row pointer m-2">
                                                    <div class="col-3 rounded bg-light-yellow">
                                                        <div class="text-red text-center pt-1">
                                                            <i class="fa-regular fa-calendar-check fa-2x  text-yellow" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-9 borde">
                                                        <span>Programa de</span><br>
                                                        <span class="titulo-2 fs-12 line-height-16"> Laborales</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div style="width:170px">
                                                <a onclick="listarprogramaconsultados(4)" title="ver cifras" class="row pointer m-2">
                                                    <div class="col-3 rounded bg-light-blue">
                                                        <div class="text-red text-center pt-1">
                                                            <i class="fa-regular fa-calendar-check fa-2x  text-blue" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-9 borde">
                                                        <span>Programa de</span><br>
                                                        <span class="titulo-2 fs-12 line-height-16"> Idiomas</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-sm">
                                                <div style="width:170px">
                                                    <a onclick="listarprogramaconsultados(0)" title="ver cifras" class="row pointer m-2">
                                                        <div class="col-3 rounded bg-light-yellow">
                                                            <div class="text-red text-center pt-1">
                                                                <i class="fa-regular fa-calendar-check fa-2x text-yellow"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-9 borde">
                                                            <span class="titulo-2 fs-12 line-height-16" id="total_general">Todos</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                    <br>
                                    <div class="row" style="width: 100%"></div>
                                    <div class="col-lg-12 table-responsive" id="listadoporprograma">
                                        <table id="tbllistadoconsultaporprograma" class="table">
                                            <thead>
                                                <th>Docente</th>
                                                <th>Documento</th>
                                                <th>Correo</th>
                                                <th>Telefono</th>
                                                <th>Tipo de Contrato</th>
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
            </section>
        </div>
    <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>

    <script type="text/javascript" src="scripts/consultar_docente_por_programa.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
ob_end_flush();
?>