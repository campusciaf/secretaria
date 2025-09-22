<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
  header("Location: ../");
}else{
	$menu=10;
	$submenu=1005;
    require 'header.php';
	if ($_SESSION['actualidad']==1){
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Nuevos y Activos</span><br>
                      <span class="fs-14 f-montserrat-regular">Vista que permite visualizar la desercion que ocurre de primer semestre a segundo</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Actualidad</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary" style="padding: 2% 1%">
                    <div class="row">
                        <div class="col-xl-2 pt-2">

                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input type="radio" name="options" id="option1" onclick="nuevos()"> Nuevos
                                </label>
                                <label class="btn btn-primary">
                                    <input type="radio" name="options" id="option2" onclick="activos()"> Activos
                                </label>
                            </div>


                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-4 col-12 form">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="programa" id="programa"></select>
                                    <label>Programa académico</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-4 col-12 form">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="jornada" id="jornada"></select>
                                    <label>Jornada</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-4 col-12 form">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo" id="periodo"></select>
                                    <label>Periodo</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-4 col-12 form">
                            <input type="button" id="consulta" value="Consultar" class="btn btn-success py-3" />
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row table-responsive">
                                <div class="col-12 resultado"></div>
                            </div>
                        </div>
                    </div><!-- div panel footer -->
                    <!--Fin centro -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section>
</div><!-- /.content-wrapper -->
<?php
	}else{
	  require 'noacceso.php';
	}
    require 'footer.php';
}
	ob_end_flush();
?>
<script type="text/javascript" src="scripts/actualidad.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
