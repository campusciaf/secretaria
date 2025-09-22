<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class whatsappDependencia{
    public function consultaEstudiante($dato_busqueda){
        global $mbd;
        $dato_busqueda = substr($dato_busqueda, 2);
        //echo $dato_busqueda;
        $sentencia = $mbd->prepare("SELECT * FROM `credencial_estudiante` `ce` INNER JOIN `estudiantes_datos_personales` `edp` ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `edp`.`celular` = :dato_busqueda");
        $sentencia->bindParam(":dato_busqueda", $dato_busqueda);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;
    }
    public function consultaUsuario($id_usuario){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT CONCAT(`usuario_nombre`, ' ', `usuario_apellido`) AS `usuario_nombre_completo` FROM `usuario` WHERE `id_usuario` = :id_usuario");
        $sentencia->bindParam(":id_usuario", $id_usuario);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;
        
    }
    public function ListarEscuela($id_credencial)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `esc`.`nombre_corto`, `esc`.`bg_color` FROM `estudiantes` AS `e` INNER JOIN `escuelas` AS `esc` ON `esc`.`id_escuelas` = `e`.`escuela_ciaf` WHERE `e`.`id_credencial` = :id_credencial AND `e`.`ciclo` != 6 ORDER BY `e`.`id_estudiante` DESC LIMIT 1");
        $sentencia->bindParam(":id_credencial", $id_credencial);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;
    }
    function listarChats($valor_buscar, $estado_chat){ 
        global $mbd;
        $dependencia = $_SESSION["dependencia"];
        $sql = "SELECT `ce`.id_credencial, `ce`.`credencial_identificacion`, `ce`.`credencial_nombre`, `ce`.`credencial_nombre_2`, `ce`.`credencial_apellido`, `ce`.`credencial_apellido_2`, `wr`.`numero_whatsapp`, `wr`.`ultima_modificacion`, `wr`.`ultimo_mensaje`, `wr`.`mensajes_no_vistos`, `wr`.`mostrado`, `wr`.`tipo_mensaje_masivo` FROM `credencial_estudiante` `ce` RIGHT JOIN `whatsapp_registros` `wr` ON `ce`.`id_credencial` = `wr`.`id_credencial` WHERE ";
        // Agregar el filtro de búsqueda si se proporciona un valor
        if (!empty($valor_buscar)) {
            $sql .= " (`wr`.`numero_whatsapp` LIKE :valor_buscar 
            OR `ce`.`credencial_apellido_2` LIKE :valor_buscar
            OR `ce`.`credencial_apellido` LIKE :valor_buscar
            OR `ce`.`credencial_nombre_2` LIKE :valor_buscar
            OR `ce`.`credencial_nombre` LIKE :valor_buscar) AND `wr`.`dependencia` = :dependencia ";
        }else{
            $sql .= " `wr`.`dependencia` = :dependencia ";
        }
        if (!empty($estado_chat)) {
            // Agregar el filtro de estado del chat
            if ($estado_chat == "Pendientes") {
                $sql .= " AND `wr`.`mensajes_no_vistos` > 0 ";
            } elseif ($estado_chat == "Leidos") {
                $sql .= " AND `wr`.`mensajes_no_vistos` = 0 ";
            }
        }
        // Agregar el orden
        $sql .= " ORDER BY `wr`.`ultima_modificacion` DESC LIMIT 200;";
        // Preparar y ejecutar la consulta
        $sentencia = $mbd->prepare($sql);
        if (!empty($valor_buscar)) {
            $sentencia->bindValue(':valor_buscar', '%' . $valor_buscar . '%', PDO::PARAM_STR);
        }
        $sentencia->bindParam(":dependencia", $dependencia);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    function CantidadNoMostrados() {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COUNT(*) AS `total_sin_mostrar` FROM `whatsapp_registros` WHERE `mostrado` = 0;");
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros["total_sin_mostrar"];
    }
    function actualizarMostrados() {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `whatsapp_registros` SET `mostrado` = 1;");
        $sentencia->execute();
    }
    function registroWhatsapp($id_credencial, $numero_whatsapp, $ultima_modificacion){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `whatsapp_registros`(`id_credencial`, `numero_whatsapp`, `ultima_modificacion`) VALUES (:id_credencial, :numero_whatsapp, :ultima_modificacion)");
        $sentencia->bindParam(":id_credencial", $id_credencial);
        $sentencia->bindParam(":numero_whatsapp", $numero_whatsapp);
        $sentencia->bindParam(":ultima_modificacion", $ultima_modificacion);
        $sentencia->execute();
    }
    public function verificarRegistroWhatsapp($numero_whatsapp){
        global $mbd;
        $numero_whatsapp = substr($numero_whatsapp, 2);
        $sentencia = $mbd->prepare("SELECT `id_credencial` FROM `whatsapp_registros` WHERE  `numero_whatsapp` = :numero_whatsapp");
        $sentencia->bindParam(":numero_whatsapp", $numero_whatsapp);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;
    }
    public function actualizarUltimoMensaje($numero_whatsapp, $ultimo_mensaje)
    {
        global $mbd;
        $numero_whatsapp = substr($numero_whatsapp, 2);
        // Codifica la cadena como JSON para escapar correctamente los caracteres especiales
        $ultimo_mensaje = json_encode($ultimo_mensaje);

        // Quita las comillas dobles adicionales que json_encode agrega
        $ultimo_mensaje = substr($ultimo_mensaje, 1, -1);
        $sentencia = $mbd->prepare("UPDATE `whatsapp_registros` SET `ultimo_mensaje` = :ultimo_mensaje WHERE  `numero_whatsapp` = :numero_whatsapp");
        $sentencia->bindParam(":ultimo_mensaje", $ultimo_mensaje);
        $sentencia->bindParam(":numero_whatsapp", $numero_whatsapp);
        $sentencia->execute();
    }
    public function actualizarMensajeEnviado($numero_celular, $ultimo_mensaje){
        global $mbd;
        $numero_whatsapp = substr($numero_celular, 2);
        // Codifica la cadena como JSON para escapar correctamente los caracteres especiales
        $ultimo_mensaje = json_encode($ultimo_mensaje);
        // Quita las comillas dobles adicionales que json_encode agrega
        $ultimo_mensaje = substr($ultimo_mensaje, 1, -1);
        $sentencia = $mbd->prepare("UPDATE `whatsapp_registros` SET `ultimo_mensaje` = :ultimo_mensaje, `mensajes_no_vistos` = 0 WHERE  `numero_whatsapp` = :numero_whatsapp");
        $sentencia->bindParam(":numero_whatsapp", $numero_whatsapp);
        $sentencia->bindParam(":ultimo_mensaje", $ultimo_mensaje);
        $sentencia->execute();
    }
    public function actualizarMensajesVistos($numero_celular){
        global $mbd;
        $numero_whatsapp = substr($numero_celular, 2);
        $sentencia = $mbd->prepare("UPDATE `whatsapp_registros` SET `mensajes_no_vistos` = 0 WHERE `numero_whatsapp` = :numero_whatsapp");
        $sentencia->bindParam(":numero_whatsapp", $numero_whatsapp);
        $sentencia->execute();
    }
    public function verificarSeguimientoActivo($numero_celular) {
        global $mbd;
        $numero_whatsapp = substr($numero_celular, 2);
        $sentencia = $mbd->prepare("SELECT * FROM `whatsapp_estado_seguimientos` WHERE `numero_celular` LIKE :numero_whatsapp AND `estado` = 'activo'");
        $sentencia->bindParam(":numero_whatsapp", $numero_whatsapp);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;
    }
    public function CantidadSeguimientosActivos($id_usuario) {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COUNT(*) AS total_registros FROM whatsapp_estado_seguimientos WHERE estado = 'activo' AND id_usuario = :id_usuario;");
        $sentencia->bindParam(":id_usuario", $id_usuario);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;
    }
    //hace la insercion del seguimiento para los fiananciados
    public function insertarSeguimiento($seg_descripcion, $seg_tipo, $id_usuario, $id_credencial){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `sofi_seguimientos`(`seg_descripcion`, `seg_tipo`, `id_asesor`, `id_credencial`) VALUES(:seg_descripcion, :seg_tipo, :id_usuario, :id_credencial)");
        $sentencia->bindParam(':seg_descripcion', $seg_descripcion);
        $sentencia->bindParam(':seg_tipo', $seg_tipo);
        $sentencia->bindParam(':id_usuario', $id_usuario);
        $sentencia->bindParam(':id_credencial', $id_credencial);
        return $sentencia->execute();
    }
    // Envió de archivo al server de met para obtener su id
    public function SubirArchivoMeta($token, $telefonoID, $tmpFile, $fileType, $fileName){
        //URL PARA SUBIR EL MENSAJE AL SERVIDOR DE META
        $url_meta_media = 'https://graph.facebook.com/v17.0/' . $telefonoID . '/media';
        //inicializamos la petición
        $curl = curl_init();
        $datos_post =  array('file' => new CURLFile($tmpFile, $fileType, $fileName), 'messaging_product' => 'whatsapp');
        curl_setopt_array($curl, [
            CURLOPT_URL => $url_meta_media,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $datos_post,
            CURLOPT_HTTPHEADER => array("Authorization: Bearer " . $token, "Content-Type: multipart/form-data")
        ]);
        $response = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $responseData = json_decode($response, true);
        //echo $responseData;
        if ($status_code == 200 && isset($responseData['id'])) {
            return $responseData['id'];
        }else{
            return false;
        }
    }  
    public function enviarMensajeMeta($token, $url, $mensaje, $numero_celular, $datos_mensaje) {
        //DECLARAMOS LAS CABECERAS
        $header = array("Authorization: Bearer " . $token, "Content-Type: application/json",);
        //INICIAMOS EL CURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //OBTENEMOS LA RESPUESTA DEL ENVIO DE INFORMACION
        $response = json_decode(curl_exec($curl), true);
        //OBTENEMOS EL CODIGO DE LA RESPUESTA
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //CERRAMOS EL CURL
        curl_close($curl);
        if ($status_code == 200) {
            //crear el nombre del archivo para almacenar la informacion del propietario
            $nombre_archivo = $numero_celular . '.txt';
            $contacto = "../WhatsappApi/chats/$nombre_archivo";
            //almacenar los datos en un archivo de texto para verficar
            file_put_contents($contacto, json_encode($datos_mensaje) . "\n", FILE_APPEND | LOCK_EX);
            return array("exito" => 1, "numero_celular" => $numero_celular);
        } else {
            return array("exito" => 0, "err_info" => "Error al enviar el mensaje");
        }
    }
    public function CantidadNoMostradosPorNumero($numero_whatsapp){
        global $mbd;
        $numero_whatsapp = substr($numero_whatsapp, 2);
        $sentencia = $mbd->prepare("SELECT COUNT(*) AS `total_sin_mostrar` FROM `whatsapp_registros` WHERE `mostrado` = 0 AND `numero_whatsapp` = :numero_whatsapp;");
        $sentencia->bindParam(":numero_whatsapp", $numero_whatsapp);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros["total_sin_mostrar"];
    }
    function ActualizarMostradosPorNumero($numero_whatsapp){
        global $mbd;
        $numero_whatsapp = substr($numero_whatsapp, 2);
        $sentencia = $mbd->prepare("UPDATE `whatsapp_registros` SET `mostrado` = 1 WHERE `numero_whatsapp` = :numero_whatsapp;");
        $sentencia->bindParam(":numero_whatsapp", $numero_whatsapp);
        $sentencia->execute();
    }
    public function Dependencia($id_dependencia){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `dependencia` FROM `dependencias` WHERE `id_dependencias` = :id_dependencia;");
        $sentencia->bindParam(":id_dependencia", $id_dependencia);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros["dependencia"];
    }
    public function ListarDependencias($dependencia){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT DISTINCT(`dependencia`) FROM `dependencias` WHERE `dependencia` != :dependencia ORDER BY `dependencias`.`dependencia` ASC");
        $sentencia->bindParam(":dependencia", $dependencia);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    public function redigirChat($numero_whatsapp, $dependencia) {
        global $mbd;
        $numero_whatsapp = substr($numero_whatsapp, 2);
        $sentencia = $mbd->prepare("UPDATE `whatsapp_registros` SET `dependencia` = :dependencia WHERE `numero_whatsapp`= :numero_whatsapp;");
        $sentencia->bindParam(":numero_whatsapp", $numero_whatsapp);
        $sentencia->bindParam(":dependencia", $dependencia);
        return $sentencia->execute();
    }
}
?>