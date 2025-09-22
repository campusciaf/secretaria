<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');

class SofiReporteBloqueos{
	//Función para listar los pagos
    public function listarBloqueosPorDia($inicio, $fin){
        $sql = "SELECT `shb`.`consecutivo`, `sp`.`numero_documento`, `sp`.`nombres`, `sp`.`apellidos`, `sp`.`celular`, `sp`.`email`, `shb`.`estado`, DATE(`shb`.`sofi_historial_fecha`) AS `sofi_historial_fecha`, TIME(`shb`.`sofi_historial_fecha`) AS `sofi_historial_hora`, `u`.`usuario_nombre`, `u`.`usuario_nombre_2`, `u`.`usuario_apellido`, `u`.`usuario_apellido_2` FROM `sofi_historial_bloqueos` `shb` INNER JOIN `usuario` `u` ON `u`.`id_usuario` = `shb`.`id_usuario` INNER JOIN `sofi_matricula` AS `sm` ON `sm`.`id` = `shb`.`consecutivo` INNER JOIN `sofi_persona` `sp` ON `sp`.`id_persona` = `sm`.`id_persona` WHERE DATE(`shb`.`sofi_historial_fecha`) BETWEEN :inicio AND :fin";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":inicio", $inicio);
        $consulta->bindParam(":fin", $fin);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function fechaesp($date) {
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];
		$dias 		= array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
		$tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
	}
}
?>