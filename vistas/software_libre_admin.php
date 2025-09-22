<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: ../");
}else{
    $menu = 4;
    $submenu = 403;
    require 'header.php';
    if($_SESSION['cajadeherramientas']==1){
?>

<link rel="stylesheet" type="text/css" href="../public/css/biblioteca.css">

<!--Contenido-->
<div class="content-wrapper">
	<section class="content">
	<div class="row">
        
		<div class="contenido">

            <div>
				<h2 class="titulo-5">Herramientas Creativas</h2>
            </div>
            
				<!-- Botones -->

			<style>
				a:hover{
					text-decoration: none;
				}
				a:link{
					text-decoration: none;
				}
				a:visited{
					text-decoration: none;
				}
				a:active{
					text-decoration: none;
				}
			</style>
			<div class="card col-xl-12 m-2 p-2">
				<div class="btn-group btn-group-toggle  m-2 p-2" data-toggle="buttons" >
				<div class="btn-group btn-group-toggle" data-toggle="buttons"   id="mostrar_categorias"></div>
				<!-- <label class="btn bg-olive active">
					<input type="radio" name="options" id="option_b1" autocomplete="off" checked=""> <span id="filtro_0">Todos</span>
				</label>
				<label class="btn bg-olive">
					<input type="radio" name="options" id="option_b2" autocomplete="off"> <span id="filtro_1">Almacenamiento en la nube</span>
				</label>
				<label class="btn bg-olive">
					<input type="radio" name="options" id="option_b3" autocomplete="off"> <span id="filtro_2">Bancos de imágenes</span>
				</label>
				<label class="btn bg-olive">
					<input type="radio" name="options" id="option_b3" autocomplete="off"> <span id="filtro_3">Edición de imagenes</span>
				</label>
				<label class="btn bg-olive">
					<input type="radio" name="options" id="option_b3" autocomplete="off"> <span id="filtro_4">Edición de audio y video</span>
				</label>
				<label class="btn bg-olive">
					<input type="radio" name="options" id="option_b3" autocomplete="off"> <span id="filtro_5">Programación</span>
				</label>
				<label class="btn bg-olive">
					<input type="radio" name="options" id="option_b3" autocomplete="off"> <span id="filtro_6">Envio de archivos</span>
				</label> -->
				</div>

				<div class="row"></div>
				<div class="row contenido_libre">
			</div>
		</div>
		</section>				  
    </div><!-- /.content-wrapper -->
</div>
<!--Fin-Contenido-->		
<?php
	}else{
        require 'noacceso.php';
	}
    require 'footer.php';
}
ob_end_flush();
?>
<script src="scripts/softwarelibreadmin.js"></script>










































































