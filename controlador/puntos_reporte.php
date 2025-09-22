<?php
require_once "../modelos/PuntosReporte.php";

$consulta = new Consulta();

switch ($_GET["op"] ?? "") {
    case 'listado_general_puntos':
        $categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';
        $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
        $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';
        $listado = [];

        // Estudiantes
        $rsEst = $consulta->listarPuntosEstudiantes($categoria, $fecha_inicio, $fecha_fin);
        while ($row = $rsEst->fetch(PDO::FETCH_ASSOC)) {
            $listado[] = [
                'identificacion' => $row['credencial_identificacion'],
                'nombre' => $row['credencial_nombre'],
                'apellido' => $row['credencial_apellido'],
                'cantidad_puntos' => $row['puntos_cantidad'],
                'fecha' => $consulta->fechaesp($row['punto_fecha']),
                'tipo' => 'Estudiante',
                'categoria' => $row['punto_nombre'] ?? ''
            ];
        }

        // Docentes
        $rsDoc = $consulta->listarPuntosDocentes($categoria, $fecha_inicio, $fecha_fin);
        while ($row = $rsDoc->fetch(PDO::FETCH_ASSOC)) {
            $listado[] = [
                'identificacion' => $row['usuario_identificacion'],
                'nombre' => $row['usuario_nombre'],
                'apellido' => $row['usuario_apellido'] ?? '',
                'cantidad_puntos' => $row['puntos_cantidad'],
                'fecha' => $consulta->fechaesp($row['punto_fecha']),
                'tipo' => 'Docente',
                'categoria' => $row['punto_nombre'] ?? ''
            ];
        }

        // Colaboradores
        $rsCol = $consulta->listarPuntosColaboradores($categoria, $fecha_inicio, $fecha_fin);
        while ($row = $rsCol->fetch(PDO::FETCH_ASSOC)) {
            $listado[] = [
                'identificacion' => $row['usuario_identificacion'],
                'nombre' => $row['usuario_nombre'],
                'apellido' => $row['usuario_apellido'] ?? '',
                'cantidad_puntos' => $row['puntos_cantidad'],
                'fecha' => $consulta->fechaesp($row['punto_fecha']),
                'tipo' => 'Colaborador',
                'categoria' => $row['punto_nombre'] ?? ''
            ];
        }

        // 👇 fuerza salida JSON limpia
        ob_clean();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($listado, JSON_UNESCAPED_UNICODE);
        exit;

        case 'puntos_totales':
            $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
            $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';
            $total = $consulta->puntos_totales($fecha_inicio, $fecha_fin); // <-- ahora recibe fechas
            $formateado = number_format($total, 0, ',', '.');
            echo json_encode(['total_puntos' => $formateado]);
        break;

        case 'puntos_totales_docente':
            $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
            $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';
            $total = $consulta->puntos_totales_docente($fecha_inicio, $fecha_fin); // <-- ahora recibe fechas
            $formateado = number_format($total, 0, ',', '.');
            echo json_encode(['total_puntos' => $formateado]);
        break;

        case 'puntos_totales_colaborador':
            $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
            $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';
            $total = $consulta->puntos_totales_colaborador($fecha_inicio, $fecha_fin); // <-- ahora recibe fechas
            $formateado = number_format($total, 0, ',', '.');
            echo json_encode(['total_puntos' => $formateado]);
        break;
}
