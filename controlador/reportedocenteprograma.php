<?php
date_default_timezone_set("America/Bogota");
require_once "../modelos/ReporteDocentePrograma.php";
$reporteprogama = new ReporteDocentePrograma();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$id_programa_ac = isset($_POST["programa_ac"]) ? limpiarCadena($_POST["programa_ac"]) : "";


switch ($_GET["op"]) {

	case 'mostrar_reporte':
        $id_programa = $_POST["id_programa"];
        $jornada_programa = $_POST["jornada_programa"];
        $periodo = $_POST["periodo"];
        $data[0] = "";
        $dataTabs = '';
        // consulta que trae los datos del programa 
        $traer_id_programa = $reporteprogama->ConsultarProgramaxDocente($id_programa, $jornada_programa, $periodo);
        $data = array(); //almacenar las tablas de cada semestre
        $semestre_actual = null;
        // crea un data con el numero de semestre 
        for ($semestre = 1; $semestre <= 10; $semestre++) {
            $data["tabla_$semestre"] = '';
        }
        for ($i = 0; $i < count($traer_id_programa); $i++) {
            $id_materia = $traer_id_programa[$i]["id_materia"];
            $consulta_nombre_materia = $reporteprogama->Consultar_Materias_Ciafi($id_materia);
            // creamos un condicional para mostrar el nombre de la materia 
            if (!empty($consulta_nombre_materia) && isset($consulta_nombre_materia[0]["nombre"])) {
                $nombre_materia = $consulta_nombre_materia[0]["nombre"];
            } else {
                $nombre_materia = "Materia no encontrada";
            }
            $id_docente = $traer_id_programa[$i]["id_docente"];
            $diferencia = $traer_id_programa[$i]["diferencia"];
            $semestre = $traer_id_programa[$i]["semestre"];
            $usuario_identificacion = $traer_id_programa[$i]["usuario_identificacion"];
            $usuario_nombre = $traer_id_programa[$i]["usuario_nombre"] . " " . $traer_id_programa[$i]["usuario_nombre_2"] . " " . $traer_id_programa[$i]["usuario_apellido"] . " " . $traer_id_programa[$i]["usuario_apellido_2"];
        
            if ($semestre_actual !== $semestre) {
                if ($semestre_actual !== null) {
                    $data["tabla_$semestre_actual"] .= '</tbody></table>'; 
                }
                
                // Obtener semestres únicos
                $semestresUnicos = array();
                foreach ($traer_id_programa as $fila) {
                    $semestresUnicos[$fila["semestre"]] = true;
                }
                $semestresUnicos = array_keys($semestresUnicos);
            // se inicia el card de la tabla
            $dataTabs = '<div class="card card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">';
                foreach ($semestresUnicos as $sem) {
                    $isActive = $sem == reset($semestresUnicos) ? ' active' : '';
                    $dataTabs .= '<li class="nav-item">
                        <a class="nav-link' . $isActive . '" id="custom-tab-semestre-' . $sem . '-tab" data-toggle="pill" href="#custom-tab-semestre-' . $sem . '" role="tab" aria-controls="custom-tab-semestre-' . $sem . '" aria-selected="' . ($isActive ? 'true' : 'false') . '">Semestre ' . $sem . '</a>
                    </li>';
                }
                $dataTabs .= '</ul></div><div class="card-body"><div class="tab-content" id="custom-tabs-one-tabContent">';
                // se crea el contenido para cada tabla que se encuentre dentro del nav
                foreach ($semestresUnicos as $sem) {
                    $isActive = $sem == reset($semestresUnicos) ? ' show active' : '';
                    $dataTabs .= '<div class="tab-pane fade' . $isActive . '" id="custom-tab-semestre-' . $sem . '" role="tabpanel" aria-labelledby="custom-tab-semestre-' . $sem . '-tab">
                    
                        <table id="reporte_semestre_' . $sem . '" class="tabla-semestre table table-striped">
                            <thead>
                                <tr>
                                    <th>Asignatura</th>
                                    <th>Docente</th>
                                    <th>Cédula</th>
                                    <th>Horas</th>
                                </tr>
                            </thead>
                            <tbody>';
                
                    foreach ($traer_id_programa as $fila) {
                        if ($fila["semestre"] == $sem) {
                            $id_materia = $fila["id_materia"];
                            $consulta_nombre_materia = $reporteprogama->Consultar_Materias_Ciafi($id_materia);
                            $nombre_materia = !empty($consulta_nombre_materia) && isset($consulta_nombre_materia[0]["nombre"]) ? $consulta_nombre_materia[0]["nombre"] : "Materia no encontrada";

                            $dataTabs .= '
                                <tr>
                                    <td>' . $nombre_materia . '</td>
                                    <td>' . $fila["usuario_nombre"] . ' ' . $fila["usuario_nombre_2"] . ' ' . $fila["usuario_apellido"] . ' ' . $fila["usuario_apellido_2"] . '</td>
                                    <td>' . $fila["usuario_identificacion"] . '</td>
                                    <td>' . $fila["diferencia"] . '</td>
                                </tr>';
                        }
                    }
                
                    $dataTabs .= '</tbody></table></div>';
                }
                    
                $dataTabs .= '</div></div></div></div>';
        }
            
        }
        echo json_encode(array("dataTabs" => $dataTabs));

	break;

	case "selectPeriodo":
		$rspta = $reporteprogama->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
		}
	break;

	case "selectPrograma":	
		$rspta = $reporteprogama->selectPrograma();
		echo "<option value=''>-- Seleccionar --</option>";	
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;

    case "selectJornada":
		$rspta = $reporteprogama->selectJornada();
		echo "<option value=''>Seleccionar</option>";
		for ($i = 0; $i < count($rspta); $i++) {
			echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
		}
	break;
}
