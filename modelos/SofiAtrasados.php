<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');
class SofiAtrasados{
    function traerPeriodos(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT DISTINCT(`periodo`) from `sofi_persona` ORDER BY `sofi_persona`.`periodo` DESC");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;;
    }
    //lista todos los financiados
    public function listarAtrasados($periodo){
        global $mbd;
        $hoy = date("Y-m-d");
        if ($periodo == "todos") {
            $periodo = "";
        }else{
            $periodo = "`sp`.`periodo` = '$periodo' AND";
        }
        $sentencia = $mbd->prepare("SELECT `sp`.`nombres`, `sf`.`plazo_pago`, `sp`.`numero_documento`, `sp`.`labora`, `sp`.`id_persona`, `sp`.`apellidos`, `sp`.`celular`, `sm`.`programa`, `sm`.`estado_ciafi`, `sm`.`jornada`, `sm`.`semestre`, `sm`.`id` AS `consecutivo`, 
       `sf`.`valor_cuota`, `sf`.`fecha_pago`, `sm`.`en_cobro`, `sp`.`periodo`, `sp`.`email`, `ce`.`id_credencial` FROM `sofi_persona` `sp` INNER JOIN `sofi_matricula` `sm` ON `sp`.`id_persona` = `sm`.`id_persona` INNER JOIN `sofi_financiamiento` `sf` ON `sf`.`id_matricula` = `sm`.`id` LEFT JOIN `credencial_estudiante` `ce` ON `sp`.`numero_documento` = `ce`.`credencial_identificacion` WHERE $periodo `sf`.`plazo_pago` < DATE(:fecha) AND (`sf`.`estado` = 'A Pagar' OR `sf`.`estado` = 'Abonado') AND sm.`estado_financiacion` = 1 AND `sp`.`estado` <> 'Anulado';");
        $sentencia->bindParam(":fecha", $hoy);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los financiados
    public function traerCelularEstudiante($numero_documento){
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT `edp`.`celular` FROM `credencial_estudiante` `ce` INNER JOIN `estudiantes_datos_personales` `edp` ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `ce`.`credencial_identificacion` = :numero_documento LIMIT 1;");
        $sentencia->bindParam(":numero_documento", $numero_documento);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los financiados
    public function listarAtrasadosNoEnCobro(){
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT `sp`.`id_persona`, `sm`.`id` AS `consecutivo`, `ce`.`id_credencial` FROM `sofi_persona` `sp` INNER JOIN `sofi_matricula` `sm` ON `sp`.`id_persona` = `sm`.`id_persona` INNER JOIN `sofi_financiamiento` `sf` ON `sf`.`id_matricula` = `sm`.`id` LEFT JOIN `credencial_estudiante` `ce` ON `sp`.`numero_documento` = `ce`.`credencial_identificacion` WHERE `sf`.`plazo_pago` < DATE(:fecha)   AND (`sf`.`estado` = 'A Pagar' OR `sf`.`estado` = 'Abonado')   AND `sm`.`estado_financiacion` = 1   AND `sp`.`estado` <> 'Anulado'   AND `sm`.`en_cobro` = 0; ");
        $sentencia->bindParam(":fecha", $hoy);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los financiados
    public function cantCuotasAtrasado($consecutivo){
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT COUNT(`sofi_financiamiento`.`id_financiamiento`) AS `num_cuotas`, SUM(`sofi_financiamiento`.`valor_cuota`) AS `total`, SUM(`sofi_financiamiento`.`valor_pagado`) AS `pagado` FROM `sofi_financiamiento` WHERE `sofi_financiamiento`.`id_matricula` = :consecutivo AND `sofi_financiamiento`.`plazo_pago` < DATE(:fecha);");
        $sentencia->bindParam(":fecha", $hoy);
        $sentencia->bindParam(":consecutivo", $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra a un solicitante especifico
    public function verInfoSolicitante($id_persona){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_persona` WHERE id_persona = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra a un solicitante especifico
    public function verRefeSolicitante($id_persona){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_referencias` WHERE idpersona = :id_persona ORDER BY `sofi_referencias`.`idrefencia` ASC");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //hace la insercion del seguimiento para los fiananciados
    public function insertarSeguimiento($descripcion, $tipo, $id_usuario, $id_persona, $id_credencial){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `sofi_seguimientos`(`seg_descripcion`, `seg_tipo`, `id_asesor`, `id_persona`, `id_credencial`) VALUES(:descripcion, :tipo, :id_usuario, :id_persona, :id_credencial)");
        $sentencia->bindParam(':descripcion', $descripcion);
        $sentencia->bindParam(':tipo', $tipo);
        $sentencia->bindParam(':id_usuario', $id_usuario);
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->bindParam(':id_credencial', $id_credencial);
        return $sentencia->execute();
    }
    //Muestra las cuotas que el estudiante tiene registradas 
    public function verCuotas($consecutivo){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sofi_persona`.`nombres`, `sofi_persona`.`apellidos`, `sofi_financiamiento`.*, `sofi_matricula`.`estado_financiacion` 
                                    FROM ((`sofi_financiamiento` 
                                    INNER JOIN `sofi_persona` ON `sofi_persona`.`id_persona` = `sofi_financiamiento`.`numero_documento`)
                                    INNER JOIN `sofi_matricula` ON `sofi_matricula`.id_persona = `sofi_persona`.`id_persona`)
                                    WHERE `sofi_financiamiento`.`id_matricula` = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //actualiza el estado de la cuota para indicar que se envio el mail
    public function actualizarEstadoMail($id_persona){
        global $mbd;
        $hoy = /*"2020-10-12"*/ date("Y-m-d");
        $sentencia = $mbd->prepare("UPDATE `sofi_financiamiento` SET `estado_mail`= 1 WHERE `numero_documento` = :id_persona and `fecha_pago` BETWEEN :fecha AND DATE_ADD(:fecha, INTERVAL 3 DAY)");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->bindParam(':fecha', $hoy);
        return $sentencia->execute();
    }
    //Vuelve cualquier int en formato de dinero
    public function formatoDinero($valor){
        $moneda = array(2, ',', '.'); // Peso colombiano 
        return number_format($valor, $moneda[0], $moneda[1], $moneda[2]);
    }
    //devuelve la diferencia entre 2 fechas el formato %A es para devolver en dias
    public function diferenciaFechas($inicial, $final, $formatoDiferencia = '%a'){
        $datetime1 = date_create($inicial);
        $datetime2 = date_create($final);
        $intervalo = date_diff($datetime1, $datetime2);
        return $intervalo->format($formatoDiferencia);
    }
    public function obtenerRegistroWhastapp($numero_celular){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `whatsapp_registros` WHERE `numero_whatsapp` LIKE :numero_celular ORDER BY `numero_whatsapp` ASC");
        $sentencia->bindParam(':numero_celular', $numero_celular);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
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
    public function etiquetas(){
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `etiquetas` WHERE `etiqueta_dependencia` = 'Financiera'");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function cambiarEtiqueta($id_persona,$valor){
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `sofi_matricula` SET id_etiqueta= :valor WHERE id_persona= :id_persona");
        $sentencia->bindParam(":id_persona",$id_persona);
        $sentencia->bindParam(":valor",$valor);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
    // consulta que permite cargar la etiqueta
    public function sofimatricula($id_persona){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_matricula` WHERE id_persona= :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    // consulta que permite cargar la etiqueta
    public function ultimoseguimiento($id_persona){
        global $mbd;
        // Corrección: Usa `:id_persona` en lugar de `:$id_persona`
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_seguimientos` WHERE `id_persona`= :id_persona ORDER BY `id_segumiento` DESC LIMIT 1;");
        // Corrección: El nombre del parámetro debe coincidir con el marcador de la consulta
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        // Puedes usar fetch() en lugar de fetchAll() si solo esperas un único registro
        $registro = $sentencia->fetch();
        return $registro;
    }
    public function buscarAsesores(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `usuario` WHERE `asesor_cartera` = '0' AND `usuario_condicion` = 1;");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function cambiarAsesor($id_sofi_matricula, $valor){
        global $mbd;
        // Asigna NULL si el valor está vacío
        $valor = empty($valor) ? null : $valor;
        $sentencia = $mbd->prepare("UPDATE `sofi_matricula` SET sofi_matricula_id_asesor = :valor WHERE id = :id_sofi_matricula");
        $sentencia->bindParam(":id_sofi_matricula", $id_sofi_matricula);
        // Usa PDO::PARAM_NULL si el valor es NULL, de lo contrario usa PDO::PARAM_STR
        $sentencia->bindValue(":valor", $valor, $valor === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
}
