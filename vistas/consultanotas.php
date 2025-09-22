<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: ../");
}else{
	$menu = 10;
	$submenu = 1006;
    require 'header.php';
	if ($_SESSION['usuario_nombre']){
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Consultas notas</span><br>
                      <span class="fs-14 f-montserrat-regular">Visualice las notas del periodo</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Consulta Notas</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary" style="padding: 2% 1%">
                    <div class="box-header with-border">							
						<div id="mostrardatos" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <form id="formulario" method="POST">
                                <div class="row">

                                <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select  class="form-control border-start-0 programa" data-live-search="true" name="programa" id="programa" onChange="progra(this.value);" required></select>
                                            <label>Programa</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>

                                <div class="col-xl-3 col-lg-4 col-md-4 col-12 dos">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select  class="form-control border-start-0 jornada" data-live-search="true" name="jornada" id="jornada" required></select>
                                            <label>Jornada</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>

                                <div class="col-xl-3 col-lg-4 col-md-4 col-12 dos">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select  class="form-control border-start-0" data-live-search="true" name="estado" id="estado" required>
                                                <option value="" selected disabled> - Asignaturas -</option>
                                                <option value="2">Ambas</option>
                                                <option value="1">Aprobadas</option>
                                                <option value="0">No Aprobadas</option>
                                            </select>
                                            <label>Estado</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>

                                <div class="col-xl-3 col-lg-4 col-md-4 col-12 dos">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select  class="form-control border-start-0 semestre" data-live-search="true" name="semestre" id="semestre" required></select>
                                            <label>Semestre</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>

                                <div class="col-xl-3 col-lg-4 col-md-4 col-12 dos">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select  class="form-control border-start-0 periodo" data-live-search="true" name="periodo" id="periodo" required></select>
                                            <label>Periodo Académico</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>


                                <div class="col-xl-3 col-lg-4 col-md-4 col-12 d-none"> 
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <input type="hidden" name="c" class="c">
                                            <input type="hidden" name="cortes" class="canCor">
                                            <select  class="form-control border-start-0 corte" data-live-search="true" name="corte" id="corte" ></select>
                                            <label>Cortes</label>
                                        </div>
                                    </div>   
                                </div>

                                <div class="col-2 dos m-0 px-0">
                                    <button type="submit" class="btn btn-success py-3"><i class="fas fa-search"></i> Buscar </button>
                                </div>

                                </div>
                            </form>
                        </div>
                        <div class="col-md-12 conte"></div>
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
	}else{
	  require 'noacceso.php';
	}
    require 'footer.php';
}
	ob_end_flush();
?>
<script type="text/javascript" src="scripts/consultanotas.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>