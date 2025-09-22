<?php
require_once "../modelos/SacCalendarioGeneral.php";
$SacCalendarioGeneral = new SacCalendarioGeneral();

$meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

/* campos para agregar una ación */
$nombre_accion = isset($_POST["nombre_accion"]) ? limpiarCadena($_POST["nombre_accion"]) : "";
$id_meta  = isset($_POST["id_meta"]) ? limpiarCadena($_POST["id_meta"]) : "";
$fecha_accion = isset($_POST["fecha_accion"]) ? limpiarCadena($_POST["fecha_accion"]) : "";
$fecha_fin  = isset($_POST["fecha_fin"]) ? limpiarCadena($_POST["fecha_fin"]) : "";
$accion_estado  = isset($_POST["accion_estado"]) ? limpiarCadena($_POST["accion_estado"]) : "";
$meta_nombre  = isset($_POST["meta_nombre"]) ? limpiarCadena($_POST["meta_nombre"]) : "";
$id_accion  = isset($_POST["id_accion"]) ? limpiarCadena($_POST["id_accion"]) : "";
$usuario_imagen  = isset($_POST["usuario_imagen"]) ? limpiarCadena($_POST["usuario_imagen"]) : "";
$anio_actual = date("Y");
switch ($_GET["op"]) {
	case 'checkbox':
		$data[0] = "";
		if (!empty($_POST['check_list'])) {
			$data[0] .= '  	
				<div class="row ">
					<div class="card col-12 table-responsive" id="listadoregistros">
						<table id="ver_sac_calendario" class="table" style="width: 100%;">
							<thead>
								<th id="tour_proyecto" scope="col">Proyecto</th>
								<th id="tour_meta" scope="col">Meta</th>
								<th id="tour_accion" scope="col">Acción</th>
								<th id="tour_cargo" scope="col">Cargo</th>
								<th id="tour_foto" scope="col">Foto</th>
								<th id="tour_estado" scope="col">Estado</th>
								<th  id="tour_mes" scope="col">Mes</th>
							</thead>
							<tbody>';
			foreach ($_POST['check_list'] as $check) {
				$listar_metas = $SacCalendarioGeneral->mostraraccionespormetafin($check, $anio_actual);
				for ($a = 0; $a < count($listar_metas); $a++) {
					// print_r($listar_metas);
					$meta_fecha = $listar_metas[$a]["meta_fecha"];
					$nombre_accion = $listar_metas[$a]["nombre_accion"];
					$nombre_proyecto = $listar_metas[$a]["nombre_proyecto"];
					$meta_responsable = $listar_metas[$a]["usuario_cargo"];
					$meta_nombre = $listar_metas[$a]["meta_nombre"];
					$accion_estado = $listar_metas[$a]["accion_estado"];
					$fecha_fin = $listar_metas[$a]["fecha_fin"];
					$total_proyectos = $SacCalendarioGeneral->listarproyecto($listar_metas[$a]["id_accion"]); // consulta para los proyectos
					$data[0] .= '					
						<tr>
							<td class="fs-14">' . $nombre_proyecto . '</td>
							<td class="fs-14">' . $meta_nombre . '</td>
							<td class="fs-14">' . $nombre_accion . '</td>	
							<td class="fs-14">' . $meta_responsable . '</td>
							<td ><img class="rounded-circle" src="../files/usuarios/' . $listar_metas[$a]["usuario_imagen"] . '" width="40px"></td>
							<td align="right">';
					if ($listar_metas[$a]["accion_estado"] == 0) {
						$data[0] .= '<span class="badge badge-danger p-1">Pendiente</span>';
					} else {
						$data[0] .= '<span class="badge badge-success p-1">Finalizada</span>';
					}
					$data[0] .= '</td>
									<td class="fs-14">' . $meses[$fecha_fin] . '</td>
								</tr>';
				}
			}

			$data[0] .= '</tbody>';
			$data[0] .= '</table>';
			$data[0] .= '
								</div>
							</div>';
		}
		echo json_encode($data);
		break;
}
