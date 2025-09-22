<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: ../");
}else{
	$menu = 10;
    $submenu = 1001;
	require 'header.php';
	if($_SESSION['consultafiltrada']==1){
?>

<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Consulta específica</span><br>
                      <span class="fs-14 f-montserrat-regular">Módulo que permite realizar consultas sobre estudiantes</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Filtrada</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
     
                <form action="#" method="post" class="row" id="form_consulta_filtrada">

                    <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="programa" id="programa"></select>
                            <label>Seleccionar Programa</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                    </div>

                    <div class="col-xl-2 col-lg-4 col-md-4 col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="jornada" id="jornada"></select>
                                <label>Seleccionar jornada</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>

                    <div class="col-xl-2 col-lg-4 col-md-4 col-12  ">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="semestre" id="semestre">
                                    <option value="" disabled selected>Semestre</option>
                                    <option value="todos3">Todos</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                </select>
                                <label>Seleccionar semestre</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>

                    <div class="col-3">
                        <input type="submit" value="Consultar" class="btn btn-success py-3" />
                    </div>
                </form>

                <div class="col-12 card p-4">
                    <table class="table table-hover" id="dtl_estudiantes" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Identificación</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Programa</th>
                                <th scope="col">Jornada</th>
                                <th scope="col">Semestre</th>
                                <th scope="col">Grupo</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                 
            </div><!-- /.col -->
        </div><!-- /.row -->					
						
    </section>
</div>

<?php
	}else{
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/consultafiltrada.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>