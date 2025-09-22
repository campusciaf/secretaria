<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: ../");
}else{
	$menu = 14;
    $submenu = 1428;
	require 'header.php';
	if($_SESSION['oncentercontinuadagestion']==1){
?>

<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Consulta continuada</span><br>
                      <span class="fs-14 f-montserrat-regular">Módulo que permite realizar consultas sobre estudiantes interesados</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Continuada</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="col-12 card p-4">
                    <div class="table-responsive p-4" id="listadoregistrostres">
                        <div id="titulo"></div>
                        <table id="tbllistado" class="table table-hover" style="width:100%">
                            <thead>
                                <th>Opciones</th>
                                <th>Identificación</th>
                                <th>Nombre completo</th>
                                <th>Curso/diplomado</th>
                                <th>Correo</th>
                                <th>Celular</th>
                                <th>Matricula</th>
                                <th>Estado</th>
                                <th>Ingreso</th>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                    </div>
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
<script type="text/javascript" src="scripts/oncentercontinuadagestion.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>