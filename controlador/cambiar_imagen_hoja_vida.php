<?php
// session_start();
require_once "../modelos/CambiarImagenHojaVida.php";
$config = new CambiarImagenHojaVida();

date_default_timezone_set("America/Bogota");



switch ($_GET['op']) {

    case 'cambiarImagenHojaVida':
        // los usamos para esconder los botones de guardar y cancelar 
        $campo = isset($_POST["campo"]) ? $_POST["campo"] : "";
        $valor = isset($_POST["valor"]) ? $_POST["valor"] : "";
        $id_cvadministrativos = isset($_POST["id_cvadministrativos"]) ? $_POST["id_cvadministrativos"] : "";
        $nombre_archivo = isset($_POST["cvadministrativos_identificacion"]) ? $_POST["cvadministrativos_identificacion"] . ".jpg" : "";


        if (empty($valor) || is_null($valor)) {
            $msg_errors = "Debes subir una imagen.";
            die(json_encode(array("exito" => 0, "info" => $msg_errors)));
        } else {
            $rspta =  $config->base64_to_jpeg($valor, "../cv_funcionarios/usuarios/" . $nombre_archivo);
            if ($rspta) {
                $config->actualizarCampoBDHojaVida($nombre_archivo, $id_cvadministrativos);
                $data = array("exito" => 1, "info" => "Imagen Actualizada");
            } else {
                $data = array("exito" => 0, "info" => "Error en el guardado");
            }
            echo json_encode($data);
        }
        break;
}
