<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class WhatsappMisActivos
{
    function listarChats($valor_buscar, $estado_chat)
    {
        $id_usuario = $_SESSION['id_usuario'];
        global $mbd;
        $sql = "SELECT `ce`.id_credencial, `ce`.`credencial_identificacion`, `ce`.`credencial_nombre`, `ce`.`credencial_nombre_2`, `ce`.`credencial_apellido`, `ce`.`credencial_apellido_2`, `wr`.`numero_whatsapp`, `wr`.`ultima_modificacion`, `wr`.`ultimo_mensaje`, `wr`.`mensajes_no_vistos`, `wr`.`mostrado`, `wr`.`tipo_mensaje_masivo`  FROM `credencial_estudiante` `ce` RIGHT JOIN `whatsapp_registros` `wr` ON `ce`.`id_credencial` = `wr`.`id_credencial` INNER JOIN `whatsapp_estado_seguimientos` `wes` ON `wr`.`numero_whatsapp` = `wes`.`numero_celular` WHERE ";
        // Agregar el filtro de búsqueda si se proporciona un valor
        if (!empty($valor_buscar)) {
            $sql .= " (`wr`.`numero_whatsapp` LIKE :valor_buscar 
            OR `ce`.`credencial_apellido_2` LIKE :valor_buscar
            OR `ce`.`credencial_apellido` LIKE :valor_buscar
            OR `ce`.`credencial_nombre_2` LIKE :valor_buscar
            OR `ce`.`credencial_nombre` LIKE :valor_buscar) AND `wes`.`estado` = 'activo' AND `wes`.`id_usuario` = :id_usuario";
        } else {
            $sql .= " `wes`.`estado` = 'activo' AND `wes`.`id_usuario` = :id_usuario";
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
        $sql .= " ORDER BY `wr`.`ultima_modificacion` DESC LIMIT 20;";
        // Preparar y ejecutar la consulta
        $sentencia = $mbd->prepare($sql);
        if (!empty($valor_buscar)) {
            $sentencia->bindValue(':valor_buscar', '%' . $valor_buscar . '%', PDO::PARAM_STR);
        }
        $sentencia->bindParam(':id_usuario', $id_usuario);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    function CantidadNoMostrados()
    {
        $id_usuario = $_SESSION['id_usuario'];
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COUNT(*) AS `total_sin_mostrar` FROM `whatsapp_registros` `wr` INNER JOIN 
                    `whatsapp_estado_seguimientos` `wes` 
                    ON `wr`.`numero_whatsapp` = `wes`.`numero_celular` WHERE `wr`.`mostrado` = 0 AND `wes`.`estado` = 'activo' AND `wes`.`id_usuario` = :id_usuario;");
        $sentencia->bindParam(':id_usuario', $id_usuario);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros["total_sin_mostrar"];
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
    function actualizarMostrados()
    {
        $id_usuario = $_SESSION['id_usuario'];
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `whatsapp_registros` `wr` INNER JOIN `whatsapp_estado_seguimientos` `wes` ON `wr`.`numero_whatsapp` = `wes`.`numero_celular` SET `wr`.`mostrado` = 1 WHERE `wes`.`estado` = 'activo' AND `wes`.`id_usuario` = :id_usuario;");
        $sentencia->bindParam(':id_usuario', $id_usuario);
        $sentencia->execute();
    }
    public function consultaEstudiante($dato_busqueda)
    {
        global $mbd;
        $dato_busqueda = substr($dato_busqueda, 2);
        //echo $dato_busqueda;
        $sentencia = $mbd->prepare("SELECT * FROM `credencial_estudiante` `ce` INNER JOIN `estudiantes_datos_personales` `edp` ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `edp`.`celular` = :dato_busqueda");
        $sentencia->bindParam(":dato_busqueda", $dato_busqueda);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;
    }
    public function consultaUsuario($id_usuario)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT CONCAT(`usuario_nombre`, ' ', `usuario_apellido`) AS `usuario_nombre_completo` FROM `usuario` WHERE `id_usuario` = :id_usuario");
        $sentencia->bindParam(":id_usuario", $id_usuario);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;
    }
    public function Dependencia($id_dependencia)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `dependencia` FROM `dependencias` WHERE `id_dependencias` = :id_dependencia;");
        $sentencia->bindParam(":id_dependencia", $id_dependencia);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros["dependencia"];
    }
}
