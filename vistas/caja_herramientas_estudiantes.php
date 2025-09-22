<?php
ob_start();
 session_start();
if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: ../");
}
else
{
	$menu=2;
	
require 'header_estudiante.php';
if (!empty($_SESSION['id_usuario']))
	{
?>



<link rel="stylesheet" type="text/css" href="../public/css/biblioteca.css">

<div id="precarga" class="precarga"></div>
	<div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-xl-6 col-9">
                        <p class="m-0 line-height-16 pl-2">
                            <span class="titulo-2 fs-24 text-semibold">Herramientas Digitales</span><br>
                            <span class="fs-14 font-weight-bold">Las mejores aplicaciones con IA (Probadas)</span>
                        </p>
                    </div>
                    <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                        <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                    </div>
                </div>
            </div>
        </div>

		<section class="container-fluid px-4">
            <div class="contenido px-4">

				<div class="row pb-2">
					<div class="col-12 fs-16 pt-2 font-weight-bolder">Explorar por categoría</div>
					<div class="btn-group col-12 p-0 m-0">
						<div class="d-flex flex-wrap align-items-start" id="mostrar_categorias"></div>
					</div>
					
				</div>

				<div class="row contenido_libre"></div>

			</div>
		</section>
	</div>

<!--Fin-Contenido-->		
<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer_estudiante.php';
?>

<script type="text/javascript" src="scripts/caja_herramientas_estudiantes.js"></script>
<?php
}
	ob_end_flush();
?>









































































