<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 13;
    $submenu = 1313;
    require 'header.php';
    if ($_SESSION['carverseresoriginales'] == 1) {
?>
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Seres originales</span><br>
                      <span class="fs-14 f-montserrat-regular">Universitarios CIAF en la era digital</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Seres originales</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>
   <section class="container-fluid px-4 mb-4">
      <div class="row">

        

        <div class="col-12 pl-4 mb-2" style="display: none;" id="buscarprogramas">
            <div class="row">

                    <div style="width:170px">
                        <a onclick="listar(1)" title="ver cifras" class="row pointer m-2">
                            <div class="col-3 rounded bg-light-red">
                                <div class="text-red text-center pt-1">
                                    <i class="fa-regular fa-calendar-check fa-2x  text-red" aria-hidden="true"></i>
                                </div>
                                
                            </div>
                            <div class="col-9 borde">
                                <span>Escuela de</span><br>
                                <span class="titulo-2 fs-12 line-height-16"> Administración</span>
                            </div>
                        </a>
                    </div>

                    <div style="width:170px">
                        <a onclick="listar(6)" title="ver cifras" class="row pointer m-2">
                            <div class="col-3 rounded bg-light-purple">
                                <div class="text-red text-center pt-1">
                                    <i class="fa-regular fa-calendar-check fa-2x  text-purple" aria-hidden="true"></i>
                                </div>
                                
                            </div>
                            <div class="col-9 borde">
                                <span>Escuela de</span><br>
                                <span class="titulo-2 fs-12 line-height-16"> Contaduría</span>
                            </div>
                        </a>
                    </div>

                    <div style="width:170px">
                        <a onclick="listar(3)" title="ver cifras" class="row pointer m-2">
                            <div class="col-3 rounded bg-light-green">
                                <div class="text-red text-center pt-1">
                                    <i class="fa-regular fa-calendar-check fa-2x  text-green" aria-hidden="true"></i>
                                </div>
                                
                            </div>
                            <div class="col-9 borde">
                                <span>Escuela de</span><br>
                                <span class="titulo-2 fs-12 line-height-16"> SST</span>
                            </div>
                        </a>
                    </div>

                    <div style="width:170px">
                        <a onclick="listar(2)" title="ver cifras" class="row pointer m-2">
                            <div class="col-3 rounded bg-light-blue">
                                <div class="text-red text-center pt-1">
                                    <i class="fa-regular fa-calendar-check fa-2x  text-blue" aria-hidden="true"></i>
                                </div>
                                
                            </div>
                            <div class="col-9 borde">
                                <span>Escuela de</span><br>
                                <span class="titulo-2 fs-12 line-height-16"> Ingenieria</span>
                            </div>
                        </a>
                    </div>

                    <div style="width:170px">
                        <a onclick="listar(5)" title="ver cifras" class="row pointer m-2">
                            <div class="col-3 rounded bg-light-orange">
                                <div class="text-red text-center pt-1">
                                    <i class="fa-regular fa-calendar-check fa-2x  text-orange" aria-hidden="true"></i>
                                </div>
                                
                            </div>
                            <div class="col-9 borde">
                                <span>Escuela de</span><br>
                                <span class="titulo-2 fs-12 line-height-16"> Industrial</span>
                            </div>
                        </a>
                    </div>

                    <div style="width:170px">
                        <a onclick="listar(7)" title="ver cifras" class="row pointer m-2">
                            <div class="col-3 rounded bg-light-yellow">
                                <div class="text-red text-center pt-1">
                                    <i class="fa-regular fa-calendar-check fa-2x  text-yellow" aria-hidden="true"></i>
                                </div>
                                
                            </div>
                            <div class="col-9 borde">
                                <span>Escuela de</span><br>
                                <span class="titulo-2 fs-12 line-height-16"> Laborales</span>
                            </div>
                        </a>
                    </div>

                    <div style="width:170px">
                        <a onclick="listar(4)" title="ver cifras" class="row pointer m-2">
                            <div class="col-3 rounded bg-light-blue">
                                <div class="text-red text-center pt-1">
                                    <i class="fa-regular fa-calendar-check fa-2x  text-blue" aria-hidden="true"></i>
                                </div>
                                
                            </div>
                            <div class="col-9 borde">
                                <span>Escuela de</span><br>
                                <span class="titulo-2 fs-12 line-height-16"> Idiomas</span>
                            </div>
                        </a>
                    </div>
            </div>
        </div>

        <div class="card col-12 " id="listadoregistros">
            <table id="tbllistado" class="table table-hover table-sm table-responsive">
            </table>
        </div>
      </div>
   </section><!-- /.content -->

</div><!-- Main content -->

    <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
    <script type="text/javascript" src="scripts/carverseresoriginales.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>