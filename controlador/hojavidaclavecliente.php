<?php

require_once "../modelos/HojaVidaClaveCliente.php";
$HojaVidaClaveCliente = new HojaVidaClaveCliente();

switch ($_GET['op']) {
	//restablece la clave del correo que estan en el modulo de hoja de vidas
	case 'restablecer_clave_hoja_de_vida':

		$usuario_email = $_POST["usuario_email"];
		$usuario_identificacion = $_POST["usuario_identificacion"];
		$clavehash = hash('sha256', $usuario_identificacion);

		$rspta = $HojaVidaClaveCliente->restablecerContrasena($clavehash, $usuario_email);
		if ($rspta) {
			$data = array("exito" => "1", "info" => "La contraseña se restablecio correctamente");
		} else {
			$data = array("exito" => "0", "info" => "Error al restablecer la contraseña");
		}

		echo json_encode($data);
		break;
	//lista los usuarios por medio de la cedula
	case "Listar_Usarios":
		$cedula = $_GET["cedula"];
		$rspta = $HojaVidaClaveCliente->Listar_Usarios($cedula);

		$data["info"] = "";
		$data["info"] .=
			'		
				<table id="tabla_listar_usuarios" class="table" style="width:100%">
					<thead>
						<tr>
							<th scope="col" class="text-center">#</th>
							<th scope="col" class="text-center">Cédula</th>		
							<th scope="col" class="text-center">Nombre</th>		
							<th scope="col" class="text-center">Email</th>		
							<th scope="col" class="text-center">Opciones</th>		
						</tr>
					</thead>
				<tbody>';

		for ($i = 0; $i < count($rspta); $i++) {

			$usuario_identificacion =  $rspta[$i]["usuario_identificacion"];
			$usuario_email =  $rspta[$i]["usuario_email"];

			$usuario_nombre =  $rspta[$i]["usuario_nombre"] . " " . $rspta[$i]["usuario_apellido"];

			$data["info"] .= '
					
					<tr>
						<th scope="row" class="text-center">' . ($i + 1) . '</th>	
						<td class="text-center">' . $usuario_identificacion . '</td>
						<td class="text-center">' . $usuario_nombre . '</td>
						<td class="text-center">' . $usuario_email . '</td>
						<td class="text-center"><button class="tooltip-agregar btn btn-info btn-xs" onclick="restablecer(`' . $usuario_email . '`,' . $usuario_identificacion . ')" title="Restaurar Contraseña" data-toggle="tooltip" data-placement="top"><i class="fas fa-redo"></i></button></td>
					</tr>
					';
		}

		$data["info"] .= '</tbody></table>';

		echo json_encode($data);

		break;
}
