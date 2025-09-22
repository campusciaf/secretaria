<?php
require_once "../modelos/Puntos.php";
$consulta = new Consulta();

date_default_timezone_set("America/Bogota");
$fecha_inicio = $_POST['fecha_inicio'] ?? date("Y-m-d", strtotime("-15 days"));
    $fecha_fin = $_POST['fecha_fin'] ?? date("Y-m-d");
    $fecha_hoy = date("Y-m-d");

switch ($_GET['op']) {

   case 'listar_categorias':
   $fecha_inicio = $_POST['fecha_inicio'] ?? date("Y-m-d", strtotime("-15 days"));
$fecha_fin = $_POST['fecha_fin'] ?? date("Y-m-d");


    $rspta = $consulta->listarTodasLasCategorias();

    $categorias = [];
    $total_general = 0;

    while ($reg = $rspta->fetch(PDO::FETCH_ASSOC)) {
        $nombre = $reg['punto_nombre'];
        $total = $consulta->obtenerTotalPuntosPorCategoria($nombre, $fecha_inicio, $fecha_hoy);
        $categorias[] = ["nombre" => $nombre, "total" => $total];
        $total_general += $total;
    }

    echo json_encode(["categorias" => $categorias, "total_general" => $total_general]);
    break;





   case 'grafico_puntos':
    $categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';

    if ($categoria === '') {
   
        $rspta = $consulta->graficoPuntos($fecha_inicio, $fecha_hoy);
    } else {
      
        $rspta = $consulta->graficoPuntosPorCategoria($categoria, $fecha_inicio, $fecha_hoy);
    }

    $fechas = [];
    $puntos = [];

    while ($reg = $rspta->fetch(PDO::FETCH_OBJ)) {
        $fechas[] = $reg->punto_fecha;
        $puntos[] = $reg->total_puntos;
    }

    echo json_encode(["fechas" => $fechas, "puntos" => $puntos]);
    break;

    
case 'listado_personas_categoria':
    $categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';
    $rspta = $consulta->listarPersonasPorCategoria($categoria, $fecha_inicio, $fecha_hoy);

    $listado = [];
    while ($row = $rspta->fetch(PDO::FETCH_ASSOC)) {
        
        if (!empty($row['punto_fecha'])) {
            $row['punto_fecha'] = $consulta->fechaesp($row['punto_fecha']);
        }
        $listado[] = $row;
    }

    echo json_encode($listado);
    break;



case 'puntos_totales':
		$total = $consulta->puntos_totales(); // <-- esto ya es un número, no un array
		$formateado = number_format($total, 0, ',', '.');
		echo json_encode(['total_puntos' => $formateado]);
    break;

   case 'totales_generales':
    $consulta->obtenerTotalesGeneralesPorCategoria();
    break;
 

}


