<?php
session_start();
date_default_timezone_set("America/Bogota");

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION["usuario_nombre"])) {
    http_response_code(401);
    echo json_encode(["ok" => false, "msg" => "No autorizado"]);
    exit;
}

// Si manejas permisos por módulo, puedes validar aquí:
// if (!isset($_SESSION['pb-rematricula']) || $_SESSION['pb-rematricula'] != 1) { ... }

require_once "../modelos/PB-Rematricula.php";

$modelo = new Modelo();

$op = $_GET["op"] ?? "";
try {
    switch ($op) {
        case 'cargar':
            // Puedes usar $fecha y $hora si necesitas logs o auditoría
            // $fecha = date('Y-m-d'); $hora = date('H:i:s');

            $cfg = $modelo->obtenerEmbedConfig();
            echo json_encode(["ok" => true, "data" => $cfg]);
            break;

        default:
            http_response_code(400);
            echo json_encode(["ok" => false, "msg" => "Operación no válida"]);
            break;
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "ok"  => false,
        "msg" => "Error interno",
        "err" => $e->getMessage()
    ]);
}
