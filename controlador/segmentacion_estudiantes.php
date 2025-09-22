<?php
require_once "../modelos/SegmentacionEstudiantes.php";
$segmentacion_estudiantes = new SegmentacionEstudiantes();

date_default_timezone_set("America/Bogota");
switch ($_GET["op"]) {
	case "selectPeriodo":
		$rspta = $segmentacion_estudiantes->selectPeriodo();
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
		}
		break;
	case "selectPrograma":
		$rspta = $segmentacion_estudiantes->selectPrograma();
		echo "<option value=''>-- Seleccionar --</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
		break;

	case 'general':
		$data = ["dtotal" => ""];
		$periodo = $_POST["periodo"];
		$programa = isset($_POST["programa"]) ? $_POST["programa"] : [];
		// recibimos desde post el periodo anterior ya restado con el periodo seleccionado
		$periodoAnterior = $_POST["periodoAnterior"];
		if (empty($programa[0])) {
			// tomamos los datos con el periodo anterior
			$periodo_datos_actual = $segmentacion_estudiantes->TraerDatosGraficaSinPrograma($periodo);
			$periodo_dato_anterior = $segmentacion_estudiantes->TraerDatosGraficaSinPrograma($periodoAnterior);
		} else {
			// tomamos los datos para el periodo actual
			$periodo_datos_actual = $segmentacion_estudiantes->TraerDatosGraficaPorPrograma($periodo, $programa[0]);
			$periodo_dato_anterior = $segmentacion_estudiantes->TraerDatosGraficaPorPrograma($periodoAnterior, $programa[0]);
		}

		$edades_periodo = array_fill(0, 100, 0);
		$edades_periodo_anterior = array_fill(0, 100, 0);
		// calculamos los datos de los estudiantes con el periodo actual
		$contador = 0;
		for ($i = 0; $i < count($periodo_datos_actual); $i++) {
			if ($periodo_datos_actual[$i]['fecha_nacimiento'] != "0000-00-00") {
				$fecha_nacimiento = DateTime::createFromFormat('Y-m-d', $periodo_datos_actual[$i]['fecha_nacimiento']);
				if ($fecha_nacimiento) {
					$hoy = new DateTime();
					$edad = $hoy->diff($fecha_nacimiento)->y;
					if ($edad >= 0 && $edad < 100) {
						$edades_periodo[$edad]++;
					}
				}
				$contador++;
			}
		}
		// calculamos los datos de los estudiantes con el periodo anterior
		$contador = 0;
		for ($i = 0; $i < count($periodo_dato_anterior); $i++) {
			if ($periodo_dato_anterior[$i]['fecha_nacimiento'] != "0000-00-00") {
				$fecha_nacimiento = DateTime::createFromFormat('Y-m-d', $periodo_dato_anterior[$i]['fecha_nacimiento']);
				if ($fecha_nacimiento) {
					$hoy = new DateTime();
					$edad = $hoy->diff($fecha_nacimiento)->y;
					if ($edad >= 0 && $edad < 100) {
						$edades_periodo_anterior[$edad]++;
					}
				}
				$contador++;
			}
		}
		// en array colocamos los rangos para comenzar a hacer la toma de datos
		$rangos = [
			"Entre 11-15" => [11, 15],
			"Entre 16-20" => [16, 20],
			"Entre 21-25" => [21, 25],
			"Entre 26-30" => [26, 30],
			"Entre 31-35" => [31, 35],
			"Entre 36-40" => [36, 40],
			"Entre 41-45" => [41, 45]
		];

		//contadores para cada rango tanto para el periodo actual como el periodo anterior
		$resultado_periodo = array_fill_keys(array_keys($rangos), 0);
		$resultado_periodo_anterior = array_fill_keys(array_keys($rangos), 0);

		$keys = array_keys($rangos);  // Obtiene los nombres de los rangos
		for ($edad = 0; $edad < 100; $edad++) {
			for ($j = 0; $j < count($keys); $j++) {
				$rango = $keys[$j];
				$min = $rangos[$rango][0];
				$max = $rangos[$rango][1];
				if ($edad >= $min && $edad <= $max) {
					// tomamos el rango del periodo actual
					if (isset($edades_periodo[$edad])) {
						$resultado_periodo[$rango] += $edades_periodo[$edad];
					}
					// tomamos el rango del periodo anterior
					if (isset($edades_periodo_anterior[$edad])) {
						$resultado_periodo_anterior[$rango] += $edades_periodo_anterior[$edad];
					}
				}
			}
		}
		// se imprime los puntos de datos para la gráfica para el periodo actual y anterior.
		$data['dataPointsPeriodoActual'] = [];
		$data['dataPointsPeriodoAnterior'] = [];
		foreach ($resultado_periodo as $rango => $count) {
			$data['dataPointsPeriodoActual'][] = ["label" => $rango, "y" => $count];
		}
		foreach ($resultado_periodo_anterior as $rango => $count) {
			$data['dataPointsPeriodoAnterior'][] = ["label" => $rango, "y" => $count];
		}

		echo json_encode($data);
		break;

	case 'mostrar_grafica':
		$data[0] = "";
		$data[0] .= '
			<div class="col-xl-8 p-4">
				<div class="row tono-2">
					<div class="col-12 tono-3 py-3">
						<div class="row align-items-center pt-2">
							<div class="col-xl-auto col-lg-auto col-md-auto col-2">
								<span class="rounded bg-light-green p-3 text-success ">
									<i class="fa-solid fa-headset" aria-hidden="true"></i>
								</span> 
							</div>
							<div class="col-xl-10 col-lg-10 col-md-10 col-10">
								<span class="fs-14 line-height-18">Rango Por Edades</span> <br>
							</div>
						</div>
					</div>
					<div class="col-12 p-2 m-2">
						<div id="chartContainer2" style="height: 300px; max-width: 920px; margin: 0px auto;"></div>
					</div>
				</div>
			</div>';

		echo json_encode($data);
		break;
	case 'edadpromedioprograma':
		$data[0] = "";

		$periodo = $_POST["periodo"];
		$programa = isset($_POST["programa"]) ? $_POST["programa"] : [];
		$edad_promedio = 0;
		// recibimos desde post el periodo anterior ya restado con el periodo seleccionado
		if (empty($programa[0])) {
			$edadpromediosinprograma = $segmentacion_estudiantes->TraerEdadPromedioSinPorPrograma($periodo);
			$edad_promedio = $edadpromediosinprograma[0]["edad_promedio"]; // Asume que se devuelve al menos un resultado
			$resultado_edad_promedio = substr($edad_promedio, 0, 2);
		} else {
			$edadpromedioporprograma = $segmentacion_estudiantes->TraerEdadPromedioPorPrograma($periodo, $programa[0]);
			// print_r($edadpromedioporprograma); 
			$edad_promedio = $edadpromedioporprograma[0]["edad_promedio"]; // Asume que se devuelve al menos un resultado
			$resultado_edad_promedio = substr($edad_promedio, 0, 2);
		}
		$data[0] .= '
			<div class="col-xl-3 col-lg-4 col-md-6 col-12">
				<div class="row justify-content-center">
					<div class="col-11">
						<div class="row align-items-center">
							<div class="col-auto">
								<div class="avatar rounded bg-light-green">
									<i class="fa-solid fa-users text-success fa-2x"></i>
								</div>
							</div>
							<div class="col ps-0">
								<div class="row">
									<div class="col-12"><span class="small mb-0">Edad Promedio <br></span></div>
									<div class="col-auto"><h4 class="mb-0 titulo-2 fs-36 font-weight-bolder">' . $resultado_edad_promedio . (empty($resultado_edad_promedio) ? 'sin rango de edad' : ' años.') . '</h4></div>		
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		';
		echo json_encode($data);
		break;
}
