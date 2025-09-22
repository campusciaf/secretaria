<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');
class SofiCuotasAVencer{



    //lista todos los financiados
    public function listarCuotasAVencer(){
        global $mbd;
        $hoy = date("Y-m-d");
        $desde =date("Y-m-d",strtotime($hoy."+ 3 days")); 
        $sentencia = $mbd->prepare("SELECT `sp`.`nombres`, `sp`.`numero_documento`, `sp`.`id_persona`, `sp`.`apellidos`, `sp`.`celular`, `sp`.`email`, `sm`.`id` AS `consecutivo`, `sf`.`valor_cuota`, `sf`.`fecha_pago`, `sf`.`plazo_pago`, `ce`.`id_credencial` FROM (`sofi_persona` `sp` INNER JOIN `sofi_matricula` `sm` ON `sp`.`id_persona` = `sm`.`id_persona` INNER JOIN `sofi_financiamiento` `sf` ON `sf`.`id_matricula` = `sm`.`id`) LEFT JOIN `credencial_estudiante` `ce` ON `sp`.`numero_documento` = `ce`.`credencial_identificacion` WHERE `sf`.`plazo_pago` BETWEEN :hoy AND :desde AND (`sf`.`estado` = 'A Pagar' OR `sf`.`estado` = 'Abonado') AND `sf`.`estado_mail` = 0 AND `sp`.`estado` <> 'Anulado' AND `sm`.`estado_financiacion` = 1;");
        $sentencia->bindParam(":hoy", $hoy);
        $sentencia->bindParam(":desde", $desde);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //trae la informacion de la persona a la cual se le enviara el mail
    public function enviarMailIndividual($id_persona){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `nombres`, `apellidos`, `email` FROM `sofi_persona` WHERE `id_persona` = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //actualiza el estado de la cuota para indicar que se envio el mail
    public function actualizarEstadoMail($id_persona){
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("UPDATE `sofi_financiamiento` SET `estado_mail`= 1 WHERE `numero_documento` = :id_persona and `plazo_pago` BETWEEN :fecha AND DATE_ADD(:fecha, INTERVAL 3 DAY)");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->bindParam(':fecha', $hoy);
        return $sentencia->execute();
    }
    //Vuelve cualquier int en formato de dinero
    public function formatoDinero($valor) {
        $moneda = array(2, ',', '.');// Peso colombiano 
        return number_format($valor, $moneda[0], $moneda[1], $moneda[2]);
    }

    //traer el numero de whatsapp estudiantes
    public function traerCelularEstudiante($numero_documento){
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT `edp`.`celular` FROM `credencial_estudiante` `ce` INNER JOIN `estudiantes_datos_personales` `edp` ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `ce`.`credencial_identificacion` = :numero_documento LIMIT 1;");
        $sentencia->bindParam(":numero_documento", $numero_documento);
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

        //devuelve la diferencia entre 2 fechas el formato %A es para devolver en dias
    public function diferenciaFechas($inicial, $final, $formatoDiferencia='%a'){
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
    public function etiquetas()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `etiquetas` WHERE `etiqueta_dependencia` = 'Financiera'");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cambiarEtiqueta($id_persona,$valor)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `sofi_matricula` SET id_etiqueta= :valor WHERE id_persona= :id_persona");
        $sentencia->bindParam(":id_persona",$id_persona);
        $sentencia->bindParam(":valor",$valor);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
    // consulta que permite cargar la etiqueta
    public function sofimatricula($id_persona)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_matricula` WHERE id_persona= :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
}
?>