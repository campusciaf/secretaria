<?php
session_start();
require_once "../modelos/CajaHerramientasEstudiantes.php";

$cajaherramientasestudiantes = new CajaHerramientasEstudiantes();

$op = (isset($_GET['op']))?$_GET['op']:'mostrar';
$opcion = isset($_POST["opcion"])? limpiarCadena($_POST["opcion"]):"";
// $opcion = (isset($_GET['opcion']))?$_GET['opcion']:'filtrar';
switch ($op) {
	
	case 'mostrar':
		$data[0] = "";
		$respuesta = $cajaherramientasestudiantes->mostrarElementos();
		for($i = 0;$i < count($respuesta);$i++ ) {
			$data[0] .='
			<div class="col-6 col-md-3 col-lg-3 col-xl-2 ">
				<div class="card card-primary card-outline direct-chat direct-chat-primary p-2">
					<div class="contenedor-img ejemplo-1">
						<center>
							<img src="../public/img/software_libre/'.$respuesta[$i]["ruta_img"].'">
						</center>
						<span class="fs-20"><b>'.$respuesta[$i]["nombre"].'</b></span>  
						<hr width="90%" size="1px" style="border: dashed 1px gray">
						<span class="titulo8">'.$respuesta[$i]["sitio"].'</span><br>
						<br><span class="titulo1">'.$respuesta[$i]["valor"].'</span><br><br>
						<div class="mascara">
						<h2>'.$respuesta[$i]["nombre"].'</h2><p>
							'.$respuesta[$i]["descripcion"].'</p>
							<a href="'.$respuesta[$i]["url"].'" class="link" target="_blank">Leer más</a>
						</div>
					</div>
				</div>
			</div>';
		}
		echo json_encode($data);
	break;

	case 'filtrar':
	// $opcion = $_POST['opcion'];
	$data[0] = "";
	$respuesta = $cajaherramientasestudiantes->filtrarSoftwareLibre($opcion);
	for($i = 0;$i < count($respuesta);$i++ ) {
			$data[0] .='
			<div class="col-6 col-md-3 col-lg-3 col-xl-2 ">
				<div class="card card-primary card-outline direct-chat direct-chat-primary p-2">
					<div class="contenedor-img ejemplo-1">
						<center>
							<img src="../public/img/software_libre/'.$respuesta[$i]["ruta_img"].'">
						</center>
						<span class="fs-20"><b>'.$respuesta[$i]["nombre"].'</b></span>  
						<hr width="90%" size="1px" style="border: dashed 1px gray">
						<span class="titulo8">'.$respuesta[$i]["sitio"].'</span><br>
						<br><span class="titulo1">'.$respuesta[$i]["valor"].'</span><br><br>
						<div class="mascara">
							<h2>'.$respuesta[$i]["nombre"].'</h2><p>
							'.$respuesta[$i]["descripcion"].'</p>
							<a href="'.$respuesta[$i]["url"].'" class="link" target="_blank">Leer mas</a>
							<button class="btn btn-info infoLibro" onclick="abrirModalSW('.($respuesta[$i]["id_software"]).')">Editar</button>
						</div>
					</div>
				</div>
			</div>';
		}
	echo json_encode($data);
	break;

	case 'mostrarcategorias':
		$data[0] = "";
		$data[0] .=" 
		<div class='btn-group btn-group-toggle p-1' data-toggle='buttons role='group' aria-label='Basic example''>
			<label class='btn btn-primary' onclick= 'mostrarElementos()'>
				<input type='radio' name='options' autocomplete='off'>Todos</span>
			</label>
		</div>
	
	";
		

		$respuesta = $cajaherramientasestudiantes->SoftwareLibrecategorias();
		for($i = 0;$i < count($respuesta);$i++ ) {





				$data[0] .= "
				<div class='btn-group btn-group-toggle p-1' data-toggle='buttons' role='group' aria-label='Basic example'>
					<label class='btn btn-primary' onclick='filtrarSoftware(".($i+1).")'>
						<input type='radio' name='options' autocomplete='off' >
						<span>".$respuesta[$i]["nombre_categoria"]."</span>
					</label>
				</div>";

				


			}
		echo json_encode($data);
	break;	

	
	default:
		# code...
		break;
}
 ?>