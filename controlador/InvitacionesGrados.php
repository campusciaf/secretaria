<?php
date_default_timezone_set("America/Bogota");

require_once "../public/phpqrcode/qrlib.php";
require_once "../modelos/InvitacionesGrados.php";
$invitacionesGrados = new InvitacionesGrados();

ini_set('display_errors', 1); // Muestra los errores
ini_set('display_startup_errors', 1); // Muestra errores de inicio
error_reporting(E_ALL); // Muestra todos los tipos de errores

$fecha = date('Y-m-d');
$hora = date('H:i:s');


class InvitacionesGradosControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new InvitacionesGrados();
    }

    public function validar($hash) {
        $invitacion = $this->modelo->buscarPorHash($hash);

        if ($invitacion) {
            if ($invitacion['ingresos'] >= 2 ) {
                require __DIR__ . '/../invitaciones_grados/validacion_max_ingresos.php';
            }else{
                $invitacion = $this->modelo->aumentarIngreso($invitacion['id'], $invitacion['ingresos']+1);
                require __DIR__ . '/../invitaciones_grados/validar_ok.php';
            }
        } else {
            require __DIR__ . '/../invitaciones_grados/validar_error.php';
        }
    }
}

switch ($_GET["op"]) {
	case 'listarEstudiantes':
		$rspta = $invitacionesGrados->listarEstudiantes();

		$data = array();
		$reg = $rspta;
		for ($i = 0; $i < count($reg); $i++) {
			$data[] = array(
				"0" => "Nombre Estudiantes",
				"1" => $rspta[$i]["ingresos"],
				"2" => '<div class="btn-group">
							<button onclick="generarQR('.$rspta[$i]["cedula"].')" class="btn btn-success btn-xs text-sm pointer text-white" title="Ver listado de grupo" id="b-paso8" style="font-size: .75rem !important;">Generar QR</button>
						</div>'
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;

    case 'generarQR':
        $data = array();
		$data["0"] = "";

        ini_set('display_errors', 1); // Muestra los errores
        ini_set('display_startup_errors', 1); // Muestra errores de inicio
        error_reporting(E_ALL); // Muestra todos los tipos de errores

        $doc_visitante = $_POST["doc_visitante"];

        $dir = "../files/qrs/";
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $estudiante = $invitacionesGrados->infoEstudiante($doc_visitante);

        if ( $estudiante['cedula_encrypt'] !== '' ) {    
            $salt = bin2hex(random_bytes(16));
            $hash = hash('sha256', $salt . $doc_visitante);

            $rspta = $invitacionesGrados->uploadQREstudiante($hash, $doc_visitante);
        }else {
            $hash = $estudiante['cedula_encrypt'];
        }

        $texto = "https://ciaf.digital/invitaciones_grados/validar.php?code=" . $hash;

        $filename = $dir . $hash . ".png";
        $publicPath = "files/qrs/" . $hash . ".png";

        try {
            if (!file_exists($filename)) {
                QRcode::png($texto, $filename, QR_ECLEVEL_H, 10, 2);
            }
        } catch (\Throwable $th) {
            print_r( $th );
        }

        echo json_encode([
            "status" => "ok",
            "file" => $publicPath
        ]);
        break;

}
