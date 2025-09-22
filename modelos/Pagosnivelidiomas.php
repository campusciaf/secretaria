<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
if (session_id() == '') {
    session_start();
}
class Pagos
{
    public function traeridestudiante($id_credencial, $id_programa_ac)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `estudiantes` WHERE `id_credencial` = :id_credencial AND `id_programa_ac` = :id_programa_ac");
        $sentencia->bindParam(":id_credencial", $id_credencial);
        $sentencia->bindParam(":id_programa_ac", $id_programa_ac);
        $sentencia->execute();
        $datos = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $datos;
    }

    public function insertarPagoIngles($x_id_factura, $id_persona, $consecutivo, $x_description, $x_amount_base, $x_currency_code, $x_bank_name, $x_respuesta, $x_fecha_transaccion, $x_franchise, $x_customer_doctype, $x_customer_document, $x_customer_name, $x_customer_lastname, $x_customer_email, $x_customer_phone, $x_customer_movil, $x_customer_ind_pais, $x_customer_country, $x_customer_city, $x_customer_address, $x_customer_ip)
    {
        global $mbd;
        $sql = "INSERT INTO ingles_pagos_epayco(`id_pagos`, `x_id_factura`, `id_persona`, `consecutivo`, `x_description`, `x_amount_base`, `x_currency_code`, `x_bank_name`, `x_respuesta`, `x_fecha_transaccion`, `x_franchise`, `x_customer_doctype`, `x_customer_document`, `x_customer_name`, `x_customer_lastname`, `x_customer_email`, `x_customer_phone`, `x_customer_movil`, `x_customer_ind_pais`, `x_customer_country`, `x_customer_city`, `x_customer_address`, `x_customer_ip`) VALUES (NULL, '$x_id_factura', '$id_persona', '$consecutivo', '$x_description', '$x_amount_base', '$x_currency_code', '$x_bank_name', '$x_respuesta', '$x_fecha_transaccion', '$x_franchise', '$x_customer_doctype', '$x_customer_document', '$x_customer_name', '$x_customer_lastname', '$x_customer_email', '$x_customer_phone', '$x_customer_movil', '$x_customer_ind_pais', '$x_customer_country',  '$x_customer_city', '$x_customer_address', '$x_customer_ip')";
        $sentencia = $mbd->prepare($sql);
        return $sentencia->execute();
    }
    public function consulta_pago($id_estudiante, $programa){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `materias6` WHERE `id_estudiante` = :id_estudiante AND `programa` = :programa");
        $sentencia->bindParam(":id_estudiante", $id_estudiante);
        $sentencia->bindParam(":programa", $programa);
        $sentencia->execute();
        $datos = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $datos;
    }

    public function insertar_estudiante($id_estudiante, $nombre_materia, $jornada_e, $jornada, $programa,  $periodo_activo)
    {
        $fecha_registro = date("Y-m-d H:i:s");
        $semestre = '1';
        //$sql = "INSERT INTO `materias6`(`id_estudiante`, `nombre_materia`, `jornada_e`, jornada, `periodo`,`programa`,`semestre`, `fecha`) VALUES ('$id_estudiante','$nombre_materia', '$jornada_e', '$jornada', '$periodo_activo','$programa', '$semestre', '$fecha_registro')";
        //echo $sql;
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `materias6`(`id_estudiante`, `nombre_materia`, `jornada_e`, jornada, `periodo`,`programa`,`semestre`, `fecha`) VALUES (:id_estudiante,:nombre_materia, :jornada_e, :jornada, :periodo_activo,:programa, :semestre, :fecha_registro)");
        $sentencia->bindParam(":id_estudiante", $id_estudiante);
        $sentencia->bindParam(":nombre_materia", $nombre_materia);
        $sentencia->bindParam(":jornada_e", $jornada_e);
        $sentencia->bindParam(":periodo_activo", $periodo_activo);
        $sentencia->bindParam(":programa", $programa);
        $sentencia->bindParam(":semestre", $semestre);
        $sentencia->bindParam(":jornada", $jornada);
        $sentencia->bindParam(":fecha_registro", $fecha_registro);
        return $sentencia->execute();
    }
    public function periodoactual()
    {
        $sql = "SELECT * FROM periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function insertarnuevoprograma($id_credencial,$jornada_e, $id_programa_ac, $fo_programa)
    {
        $escuela_ciaf = '4';
        $periodo = '2023-2';
        $periodo = $_SESSION['periodo_actual'];
        $ciclo = '6';
        $periodo_activo = '2023-2';
        $grupo = '1';
        $id_usuario_matriculo = '1';
        $fecha_matricula = date('Y-m-d'); 
        $hora_matricula = date('H:i:s'); 
        $admisiones = 'no';
        $pago = '1';
        global $mbd;
        $sql = "INSERT INTO estudiantes (id_credencial,id_programa_ac,fo_programa,jornada_e,escuela_ciaf,periodo,ciclo,periodo_activo, grupo,id_usuario_matriculo,fecha_matricula,hora_matricula,admisiones,pago_renovar) VALUES (:id_credencial,:id_programa_ac,:fo_programa,:jornada_e,:escuela_ciaf,:periodo,:ciclo,:periodo_activo,:grupo,:id_usuario_matriculo,:fecha_matricula,:hora_matricula,:admisiones,:pago)";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(':id_credencial', $id_credencial);
        $consulta->bindParam(':id_programa_ac', $id_programa_ac);
        $consulta->bindParam(':fo_programa', $fo_programa);
        $consulta->bindParam(':jornada_e', $jornada_e);
        $consulta->bindParam(':escuela_ciaf', $escuela_ciaf);
        $consulta->bindParam(':periodo', $periodo);
        $consulta->bindParam(':ciclo', $ciclo);
        $consulta->bindParam(':periodo_activo', $periodo_activo);
        $consulta->bindParam(':grupo', $grupo);
        $consulta->bindParam(':id_usuario_matriculo', $id_usuario_matriculo);
        $consulta->bindParam(':fecha_matricula', $fecha_matricula);
        $consulta->bindParam(':hora_matricula', $hora_matricula);
        $consulta->bindParam(':admisiones', $admisiones);
        $consulta->bindParam(':pago', $pago);
        return $consulta->execute();
    }
    public function traer_ultimo_registro_estudiantes($id_credencial, $id_programa){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `estudiantes` WHERE `id_credencial` = :id_credencial AND `id_programa_ac` = :id_programa ORDER BY `id_estudiante` DESC");
        $sentencia->bindParam(':id_credencial', $id_credencial);
        $sentencia->bindParam(':id_programa', $id_programa);        
        $sentencia->execute();
        $datos = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $datos;
    }

}
