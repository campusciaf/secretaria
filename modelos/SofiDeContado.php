<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');

class DeContado{
    //periodos en los que esta el sofi actualemnte
    public function periodoActualyAnterior()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_periodo`");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    
    public function listarContados(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_de_contado`");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    
    public function verInfoContado($id_contado){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_de_contado` WHERE `id_contado` = :id_contado");
        $sentencia->bindParam(":id_contado", $id_contado);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    
    //lista todos los programas
    public function listarProgramas()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `programa_ac`");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    
    public function mostrarInfoEstudiante($documento){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `on_interesados` WHERE `identificacion` = :documento");
        $sentencia->bindParam(':documento', $documento);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    
    public function insertarContado($documento, $nombre, $apellido, $direccion, $telefono, $email, $programa, $semestre, $jornada, $valor_total, $valor_padago, $motivo_pago, $primer_curso, $descuento, $descuento_por, $periodo){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `sofi_de_contado`(`documento`, `nombre`, `apellido`, `telefono`, `email`, `direccion`, `jornada`, `semestre`, `programa`, `valor_total`, `valor_pagado`, `motivo_pago`, `primer_curso`, `descuento`, `motivo_descuento`, `periodo`) VALUES(:documento, :nombre, :apellido, :telefono, :email, :direccion, :jornada, :semestre, :programa, :valor_total, :valor_padago, :motivo_pago, :primer_curso, :descuento, :descuento_por, :periodo)");
        $sentencia->bindParam(":documento",$documento); 
        $sentencia->bindParam(":nombre",$nombre); 
        $sentencia->bindParam(":apellido",$apellido); 
        $sentencia->bindParam(":telefono",$telefono); 
        $sentencia->bindParam(":email",$email); 
        $sentencia->bindParam(":direccion",$direccion); 
        $sentencia->bindParam(":jornada",$jornada); 
        $sentencia->bindParam(":semestre", $semestre);
        $sentencia->bindParam(":programa",$programa); 
        $sentencia->bindParam(":valor_total",$valor_total); 
        $sentencia->bindParam(":valor_padago",$valor_padago); 
        $sentencia->bindParam(":motivo_pago",$motivo_pago); 
        $sentencia->bindParam(":primer_curso",$primer_curso); 
        $sentencia->bindParam(":descuento",$descuento); 
        $sentencia->bindParam(":descuento_por",$descuento_por); 
        $sentencia->bindParam(":periodo", $periodo);
        return $sentencia->execute();
    }

    public function editarContado($id_contado, $documento, $nombre, $apellido, $direccion, $telefono, $email, $programa, $semestre, $jornada, $valor_total, $valor_pagado, $motivo_pago, $primer_curso, $descuento, $descuento_por, $periodo){
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_de_contado` SET `documento` = :documento, `nombre` = :nombre, `apellido` = :apellido, `telefono` = :telefono, `email` = :email,`direccion` = :direccion, `jornada` = :jornada, `semestre` = :semestre, `programa` = :programa, `valor_total` = :valor_total, `valor_pagado` = :valor_pagado,`motivo_pago` = :motivo_pago, `primer_curso` = :primer_curso, `descuento` = :descuento, `motivo_descuento` = :descuento_por, `periodo` = :periodo WHERE `id_contado` = :id_contado;");
        $sentencia->bindParam(":id_contado", $id_contado); 
        $sentencia->bindParam(":documento",$documento); 
        $sentencia->bindParam(":nombre",$nombre); 
        $sentencia->bindParam(":apellido",$apellido); 
        $sentencia->bindParam(":telefono",$telefono); 
        $sentencia->bindParam(":email",$email); 
        $sentencia->bindParam(":direccion",$direccion); 
        $sentencia->bindParam(":jornada",$jornada); 
        $sentencia->bindParam(":semestre", $semestre);
        $sentencia->bindParam(":programa",$programa); 
        $sentencia->bindParam(":valor_total",$valor_total); 
        $sentencia->bindParam(":valor_pagado", $valor_pagado); 
        $sentencia->bindParam(":motivo_pago",$motivo_pago); 
        $sentencia->bindParam(":primer_curso",$primer_curso); 
        $sentencia->bindParam(":descuento",$descuento); 
        $sentencia->bindParam(":descuento_por",$descuento_por); 
        $sentencia->bindParam(":periodo", $periodo);
        return $sentencia->execute();
    }
    
    public function editarInteres($id_interes, $nombre_mes, $fecha_mes, $porcentaje){
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_interes_mora` SET `nombre_mes` = :nombre_mes, `fecha_mes` = :fecha_mes, `porcentaje`= :porcentaje WHERE `id_interes_mora`=:id_interes");
        $sentencia->bindParam(':id_interes', $id_interes);
        $sentencia->bindParam(':nombre_mes', $nombre_mes);
        $sentencia->bindParam(':fecha_mes', $fecha_mes);
        $sentencia->bindParam(':porcentaje', $porcentaje);
        return $sentencia->execute();
    }

    public function actualizar_matriculado($id_estudiante){
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `on_interesados` SET `matricula`= 0 WHERE `id_estudiante` = :id_estudiante;");
        $sentencia->bindParam(":id_estudiante", $id_estudiante);
        return $sentencia->execute();
    }

    public function actualizarEnvioCampus($id){
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_de_contado` SET `matricula_campus` = 0 WHERE `id_contado` = :id");
        $sentencia->bindParam(":id", $id);
        return $sentencia->execute();
    }
    public function obtenerPeriodoCampana(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `on_periodo_actual`");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function buscarInteresado($numero_documento, $periodo) {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `on_interesados` WHERE `identificacion` = :numero_documento AND `periodo_campana` = :periodo;");
        $sentencia->bindParam(":numero_documento", $numero_documento);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function actualizar_seleccionado($id_estudiante){
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `on_interesados` SET `estado`='Admitido', `matricula`= 0 WHERE `id_estudiante` = :id_estudiante;");
        $sentencia->bindParam(":id_estudiante", $id_estudiante);
        return $sentencia->execute();
    }

    public function insertarSeguimientoOncenter($id_usuario, $id_estudiante_agregar, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora, $asesor){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `on_seguimiento`(`id_usuario`, `id_estudiante`, `motivo_seguimiento`, `mensaje_seguimiento`, `fecha_seguimiento`, `hora_seguimiento`, `asesor`) VALUES( :id_usuario, :id_estudiante_agregar, :motivo_seguimiento, :mensaje_seguimiento, :fecha, :hora, :asesor)");
        $sentencia->bindParam(":id_usuario", $id_usuario);
        $sentencia->bindParam(":id_estudiante_agregar", $id_estudiante_agregar);
        $sentencia->bindParam(":motivo_seguimiento", $motivo_seguimiento);
        $sentencia->bindParam(":mensaje_seguimiento", $mensaje_seguimiento);
        $sentencia->bindParam(":fecha", $fecha);
        $sentencia->bindParam(":hora", $hora);
        $sentencia->bindParam(":asesor", $asesor);
        return $sentencia->execute();
    }
}
?>