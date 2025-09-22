<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
  header("Location: ../");
}else{
	$menu=11;
	require 'header_estudiante.php';
?>

<div id="precarga" class="precarga"></div>

<div class="content-wrapper ">
   <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16" >
					<span class="titulo-2 fs-18 text-semibold">Pago general</span><br>
                    <span class="fs-14 f-montserrat-regular">Realice pagos seguros en tu plataforma CIAF</span>
                </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas mb-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel_estudiante.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Pagos general</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
	
    <section class="container-fluid px-4">
    </section>	

</div>



		


<?php
	
require 'footer_estudiante.php';
?>
<script src="scripts/plantilla.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
	ob_end_flush();
?>