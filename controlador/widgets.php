<?php
require_once "../modelos/Widgets.php";

$widgets = new Widgets();

$id_permiso = isset($_POST["id_permiso"]) ? limpiarCadena($_POST["id_permiso"]) : "";
$widgets_nombre = isset($_POST["permiso_nombre"]) ? limpiarCadena($_POST["permiso_nombre"]) : "";
$orden = isset($_POST["orden"]) ? limpiarCadena($_POST["orden"]) : "";
$icono = isset($_POST["icono"]) ? limpiarCadena($_POST["icono"]) : "";
$menu = isset($_POST["menu"]) ? limpiarCadena($_POST["menu"]) : "";
$widgets_nombre_original = isset($_POST["permiso_nombre_original"]) ? limpiarCadena($_POST["permiso_nombre_original"]) : "";
$ultima_orden = isset($_POST["orden"]) ? limpiarCadena($_POST["orden"]) : "";

$widgets_nombre_editar = isset($_POST["permiso_nombre_editar"]) ? limpiarCadena($_POST["permiso_nombre_editar"]) : "";
$orden_editar = isset($_POST["orden_editar"]) ? limpiarCadena($_POST["orden_editar"]) : "";
$icono_editar = isset($_POST["icono_editar"]) ? limpiarCadena($_POST["icono_editar"]) : "";
$widgets_nombre_original_editar = isset($_POST["permiso_nombre_original_editar"]) ? limpiarCadena($_POST["permiso_nombre_original_editar"]) : "";


switch ($_GET["op"]) {

	case 'guardaryeditar':


		if (empty($id_programa)) {


			$rspta = $widgets->insertar($widgets_nombre, $ultima_orden, $menu, $widgets_nombre_original, $icono);

			echo $rspta ? "Permiso registrado " : "No se pudo registrar el permiso";
		} 
		
		
		break;

	case 'mostrar':

		$rspta = $programa->mostrar($id_programa);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);

		break;

	case 'listar':
		$menu_p = 0;
		//lista los permisos(el menu de los permisos comienzan por 0)
		$rspta = $widgets->listarPermisos($menu_p);
		$reg = $rspta;
		$data = array();
		$data["0"] = "";

		$data["0"] .= '<ul class="timeline">';

		for ($i = 0; $i < count($reg); $i++) {

			$orden = $reg[$i]["orden"];

			$data["0"] .= '
	
		<div class="row">
			<div class="col-md-12">
				<!-- The time line -->
				<div class="timeline">
					<!-- timeline time label -->
					<div class="time-label">
						<span class="bg-red">' . $reg[$i]["permiso_nombre_original"] . '</span>  <button class="btn btn-success" onclick="agregar_permiso(' . $orden . ')"><i class="fa fa-plus-circle"></i> Agregar
						</button>
					</div>
					<!-- /.timeline-label -->

					<!-- timeline item -->
				<div>
                <i class="fas fa-user bg-green"></i>
                <div class="timeline-item">
            
                <h3 class="timeline-header no-border">
				<div class="row">';

			$rspta2 = $widgets->listarSubmenu($reg[$i]["orden"]);
			$reg2 = $rspta2;
			for ($k = 0; $k < count($reg2); $k++) {
				$id_permiso = $reg2[$k]["id_permiso"];
				
				$data["0"] .= '
				<div class="col-xl-3 col-lg-6 col-md-6 col-12 ">
    <div class="info-box">
        <span class="info-box-icon bg-info elevation-1">' . $reg2[$k]["icono"] . '</span>

		<a> <button class="btn btn-warning btn-sm position-absolute" style="top: 5px; right: 5px;" onclick="editar_formulario_permiso('.$id_permiso.')" title="Editar"><i class="fas fa-pencil-alt"></i></button> </a>

		

		<div class="info-box-content mt-3">
            <span class="info-box-text">' . $reg2[$k]["permiso_nombre_original"] . '</span>


            <span class="info-box-number">' . $reg2[$k]["orden"] . '</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>

			
				';
			}

			$data["0"] .= '
					</div>
				</h3>
			</div>
			</div>
		</div>
		</div>
		<!-- /.col -->
        </div>';
		}
		$data["0"] .= '</ul>';

		$results = array($data);
		echo json_encode($results);

		break;

	//Formulario para agregar los permisos, en el ultimo orden y con su respectivo menu
	case 'agregar_permiso':
		$orden = $_POST['orden'];
		$data[0] = "";
		$rspta2 = $widgets->listarSubmenuUltimoRegistro($orden);
		$ultima_orden = 0; // Inicializamos el valor de $ultima_orden en cero

		for ($k = 0; $k < count($rspta2); $k++) {
			$orden = $rspta2[$k]["orden"];
			$menu = $rspta2[$k]["menu"];
			$ultima_orden = $orden;
		}

		if (strpos($ultima_orden, '.') !== false && substr_count($ultima_orden, '.') == 1) {
			$partes = explode('.', $ultima_orden);
			$entero = $partes[0];
			$decimal = $partes[1];
			$ultimo_digito = substr($decimal, -1); // Obtener el último dígito decimal
			$nuevo_decimal = $decimal + 1; // Sumar 1 al último dígito decimal
			$resultado = $entero . '.' . $nuevo_decimal; // Combinar la parte entera y el nuevo decimal
		} else {
			// Si el número es de la forma "xx.x", simplemente sumar 0.1 al número
			$ultima_orden = $ultima_orden + 0.1;
		}
		
		$data[0] .= '
			<section class="content" style="padding-top: 0px;">
				<div class="card col-12" id="formularioregistros" style="padding: 2%">
					<form name="formulario" id="formulario" method="POST">
						<div class="row">
		
						<input type="number" class="d-none" id="menu" value = "' . $menu . '" name="menu">';
						
		if (strpos($ultima_orden, '.') !== false && substr_count($ultima_orden, '.') == 1) {
			$data[0] .= '<input type="number" class="d-none" id="orden" value = "' . $resultado . '" name="orden">';
		} else {
			$nuevo_numero = $ultima_orden + 0.1;
			$data[0] .= '<input type="number" class="d-none" id="orden" value = "' . $nuevo_numero . '" name="orden">';
		}
		
		// <input type="number" class="d-none" id="orden" value = "' . $ultima_orden . '" name="orden">

		$data[0] .= '

						
						<div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
							<label>Nombre del Permiso(*):</label>
							<input type="text" class="form-control" name="permiso_nombre" id="permiso_nombre" maxlength="100" required>
						</div>
						
						<div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<label>Nombre para botón</label>
							<input type="text" class="form-control" name="permiso_nombre_original" id="permiso_nombre_original">
						</div>

						<div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<label>Url Icono</label>
							<input type="text" class="form-control" name="icono" id="icono">
						</div>

						<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button class="btn btn-primary" onclick = "guardaryeditar()"id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
							<button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
						</div>
						</div>
					</form>
				</div>
			</section>';
		echo json_encode($data);
		break;



		//Formulario para agregar los permisos, en el ultimo orden y con su respectivo menu
	case 'editar_formulario_permiso':
		$orden = $_POST['id_permiso'];
			$data[0] = "";

			$listar_editar = $widgets->mostrar($orden);

				$widgets_nombre_editar = $listar_editar["permiso_nombre"];
				$widgets_nombre_original_editar = $listar_editar["permiso_nombre_original"];
				$icono_editar = htmlspecialchars($listar_editar["icono"]);

			$data[0] .= '
			<section class="content" style="padding-top: 0px;">
				<div class="card col-12" id="formulario_editado" style="padding: 2%">
					<form name="formulario_editar_consecutivo" id="formulario_editar_consecutivo" method="POST">

					
						<div class="row">
						<div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
							<label>Nombre del Permiso(*):</label>
							<input type="text" class="form-control" name="permiso_nombre_editar" value="'.$widgets_nombre_editar.'" id="permiso_nombre_editar" maxlength="100" required>
						</div>
						
						<div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<label>Nombre para botón</label>
							<input type="text" class="form-control" name="permiso_nombre_original_editar"  value="'.$widgets_nombre_original_editar.'" id="permiso_nombre_original_editar">
						</div>

						<div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<label>Url Icono</label>
							<input type="text" class="form-control" name="icono_editar" id="icono_editar" value="'.$icono_editar.'">
						</div>

						<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">

						<input type="number" class="d-none" id="orden_editar" value = "' . $orden . '" name="orden">
							<button class="btn btn-primary" onclick = "editar_formulario()"><i class="fa fa-save"></i> Guardar</button>
							<button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
						</div>
						</div>
					</form>
				</div>
			</section>';
		echo json_encode($data);
		break;

		case 'editar_formulario':

			$rspta = $widgets->listarSubmenuUltimoRegistroEditar($orden, $widgets_nombre_editar, $widgets_nombre_original_editar, $icono_editar);

			echo $rspta ? "Permiso actualizado" : "Permiso no se pudo actualizar";

		break;

}
