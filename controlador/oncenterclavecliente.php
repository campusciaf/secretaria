<?php

require_once "../modelos/OncenterClaveCliente.php";
$oncenterclavecliente = new OncenterClaveCliente();

switch ($_GET['op']) {

	case 'consultaEstudiante':

		$caso = isset($_POST['caso']) ? $_POST['caso'] : "";
		$registro = $oncenterclavecliente->consultaEstudiante($caso);

		if ($registro) {
			$nombre_completo = $registro['nombre'] . ' ' . $registro['nombre_2'] . ' ' . $registro['apellidos'] . ' ' . $registro['apellidos_2'];
			$email = $registro['email'];
			$id_estudiante = $registro['id_estudiante'];
			$identificacion = $registro['identificacion'];

			$data["exito"] = 1;
			$data["info"] = '

			<div class="col-12 px-2  pb-2 ">
				<div class="row align-items-center" id="t-id">
					<div class="pl-4">
						<span class="rounded bg-light-blue p-2 text-primary ">
							<i class="fa-solid fa-id-card"></i>
						</span> 
					
					</div>
					<div class="col-10">
					<div class="col-10 fs-14 line-height-18"> 
						<span class="">Identificación </span> <br>
						<span class="text-semibold fs-14">'. $identificacion . ' </span> 
					</div> 
					</div>
				</div>
			</div>

			<div class="col-12 px-2 pt-4 pb-2 ">
				<div class="row align-items-center" id="t-nm">
					<div class="pl-4">
						<span class="rounded bg-light-blue p-2 text-primary ">
							<i class="fa-regular fa-user"></i>
						</span> 
					
					</div>
					<div class="col-10">
					<div class="col-10 fs-14 line-height-18"> 
						<span class="">Nombre completo </span> <br>
						<span class="text-semibold fs-14">'. $nombre_completo . ' </span> 
					</div> 
					</div>
				</div>
			</div>

			<div class="col-12 px-2 pt-4 pb-4 ">
				<div class="row align-items-center" id="t-cl">
					<div class="pl-4">
						<span class="rounded bg-light-red p-2 text-danger">
							<i class="fa-regular fa-envelope"></i>
						</span> 
					
					</div>
					<div class="col-10">
					<div class="col-10 fs-14 line-height-18"> 
						<span class="">Correo electrónico </span> <br>
						<span class="text-semibold fs-14">'. $email . ' </span> 
					</div> 
					</div>
				</div>
			</div>


			<button type="submit" name="desactivar" class="btn btn-success btn-block" onclick=restablecer("' . $id_estudiante . '")> Restablecer contraseña </button>';
			echo json_encode($data);
		} else {
			$data["exito"] = 0;
			$data["info"] = "<div class='alert alert-danger mt-4' role='alert'>El caso ingresado no existe</div>";
			echo json_encode($data);
		}

		break;

	case 'restablecer_admision':
		$id_estudiante = isset($_POST['id_estudiante']) ? $_POST['id_estudiante'] : "";

		$pass = md5($id_estudiante);
		$rspta = $oncenterclavecliente->restablecerContrasena($pass, $id_estudiante);
		if ($rspta) {
			$data = array("exito" => "1", "info" => "La contraseña se restablecio correctamente");
		} else {
			$data = array("exito" => "0", "info" => "Error al restablecer la contraseña");
		}

		echo json_encode($data);
		break;



		// case 'mostrar':
		// 	$data= Array();
		// 	$data["0"] ="";//iniciamos el arreglo

		// 	$caso=$_POST["caso"];

		// 	$clave=md5($caso);

		// 		$rspta=$oncenterclavecliente->reestablecer($caso,$clave);
		// 		echo json_encode($rspta);

		// break;
}
