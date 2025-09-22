<?php
require_once "../modelos/WebFuncionarios.php";
$web_funcionarios = new WebFuncionarios();
$selec_funcionarios = isset($_POST["selec_funcionarios"]) ? limpiarCadena($_POST["selec_funcionarios"]) : "";
$id_web_cargos = isset($_POST["id_web_cargos"]) ? limpiarCadena($_POST["id_web_cargos"]) : "";
$id_usuario_funcionario = isset($_POST["id_usuario_funcionario"]) ? limpiarCadena($_POST["id_usuario_funcionario"]) : "";

switch ($_GET["op"]) {
	case 'mostrar_funcionarios':
		$data[0] = "";
		$rspta = $web_funcionarios->listar_cargos_select();

		$data[0] .= '
						<div class="card-body"><form>
							<div class="row">
								<div class="col">';

		for ($i = 0; $i < count($rspta); $i++) {
			$nombre_cargo = $rspta[$i]["nombre"];
			$id_web_cargos = $rspta[$i]["id_web_cargos"];

			if ($i == 16) {
				$data[0] .= '</div> <div class="col">';
			}

			$data[0] .= '<div _ngcontent-dfc-c50="" class="col-12">
							<img _ngcontent-dfc-c50="" alt="icono" class="pe-3" src="../public/img/img-li-ok.webp">
							<span  id="tour_cargo_funcionario" class="text-semibold fs-18">' . $nombre_cargo .'</span> 
							<span id="tour_editar_funcionario" <button type="button" class="tooltip-agregar btn btn-primary btn-xs" onclick="editar_funcionario(`' . $id_web_cargos . '` )" title="Editar Funcionario" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button> </span>
						</div>';
			$usuarios_cargo = $web_funcionarios->listarUsuariosCargo($id_web_cargos);
			for ($x = 0; $x < count($usuarios_cargo); $x++) {
				$nombre_funcionario = ucwords(strtolower($usuarios_cargo[$x]["usuario_nombre"])) . " " .ucwords(strtolower($usuarios_cargo[$x]["usuario_nombre_2"])) . " " .ucwords(strtolower($usuarios_cargo[$x]["usuario_apellido"])) . " " .ucwords(strtolower($usuarios_cargo[$x]["usuario_apellido_2"])); 
				$data[0] .='<div _ngcontent-dfc-c50="" class="col-12 text-1">
								<div _ngcontent-dfc-c50="" class="titulo-1 fs-14 text-semibold  tipo-letra1 tipo-letra2  mt-2">

								 '.$nombre_funcionario.' <span id="tour_eliminar_funcionario" <button type="button" class="btn btn-danger btn-xs" onclick="removerCargo('.$usuarios_cargo[$x]["id_cargo_web_usuario"].')"> <i class="fas fa-trash" title="Remover usuario del cargo"></i></button></span><br>
								'.$usuarios_cargo[$x]["usuario_login"].'
								
								</div>
							</div>';
			}

			
		}

		$data[0] .= '</div></form></div></div>';

		echo json_encode($data);
		break;
	case "removerCargo":
		$id_cargo_web_usuario = isset($_POST["id_cargo_web_usuario"])?$_POST["id_cargo_web_usuario"]:"";
		$rpsta = $web_funcionarios->removerCargo($id_cargo_web_usuario);
		echo json_encode($rpsta);

	break;


	
	case "selectFuncionarios":
		$rspta = $web_funcionarios->listarFuncionariosActivos();
		echo "<option value=''>Seleccionar</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			$nombre_funcionario = $rspta[$i]["usuario_nombre"] . " " . $rspta[$i]["usuario_nombre_2"] . " " . $rspta[$i]["usuario_apellido"] . " " . $rspta[$i]["usuario_apellido_2"];
			echo "<option value='" . $rspta[$i]["id_usuario"] . "'>" . $nombre_funcionario . "</option>";
		}
	break;

	case 'editar_funcionario':
		$rspta = $web_funcionarios->mostrar_funcionarios($id_usuario_funcionario);
		echo json_encode($rspta);
	break;
	case "selectCargos":
		$rspta = $web_funcionarios->listar_cargos_select();
		echo "<option value=''>Seleccionar</option>";
		for ($i = 0; $i < count($rspta); $i++) {

			$nombre = $rspta[$i]["nombre"];

			echo "<option value='" . $rspta[$i]["id_web_cargos"] . "'>" . $nombre . "</option>";
		}
	break;

	case 'guardaryeditarfuncionario':
		$rspta = $web_funcionarios->editar_cargo_funcionario($selec_funcionarios, $id_web_cargos);
		echo $rspta ? "Funcionario actualizada" : "Funcionario no se pudo actualizar";

	break;




}
